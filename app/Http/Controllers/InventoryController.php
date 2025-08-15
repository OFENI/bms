<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Institution;
use App\Models\BloodGroup;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    /**
     * Display paginated inventory records with filtering.
     */
    public function index(Request $request)
    {

        // Automatically mark expired blood as 'expired'
        Inventory::where('status', 'available')
            ->whereDate('expiry_date', '<', now())
            ->update(['status' => 'expired']);

        // Update institution status based on blood inventory
        // Get institutions with available blood
        $institutionsWithBlood = Inventory::where('status', 'available')
            ->where('quantity', '>', 0)
            ->pluck('institution_id')
            ->unique();

        // Set institutions with blood to active
        Institution::whereIn('id', $institutionsWithBlood)
            ->update(['status' => 'active']);

        // Set institutions without blood to inactive
        Institution::whereNotIn('id', $institutionsWithBlood)
            ->update(['status' => 'inactive']);

        $query = Inventory::with(['institution', 'bloodGroup']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('unit_id', 'like', "%{$search}%")
                  ->orWhere('donor_id', 'like', "%{$search}%");
            });
        }

        if ($request->filled('blood_type')) {
            $bloodType = $request->input('blood_type');
            $query->whereHas('bloodGroup', function($q) use ($bloodType) {
                $q->where('name', $bloodType);
            });
        }

        if ($request->filled('status')) {
            $status = $request->input('status');
            $query->where('status', $status);
        }

        $inventories = $query->orderBy('expiry_date', 'asc')->paginate(10);

        // Summary stats
        $totalUnits = Inventory::where('status', 'active')->sum('quantity');

        $availableUnits = Inventory::where('status', 'active')->sum('quantity');


        $reservedCount = Inventory::where('status', 'reserved')->count();
        $today = Carbon::today();
        $nextWeek = Carbon::today()->addDays(7);
        $expiringSoonCount = Inventory::whereBetween('expiry_date', [$today, $nextWeek])->count();
        $criticalThreshold = 5;
        $criticalCount = Inventory::select('blood_group_id', DB::raw('SUM(quantity) as total'))
            ->groupBy('blood_group_id')
            ->having('total', '<', $criticalThreshold)
            ->count();

        // New: Prepare inventory distribution for all hospitals
        // Inside your InventoryController@index or similar method

// Get all hospitals
$institutions = Institution::where('type', 'hospital')->get();

// Get all blood groups (names)
$bloodGroups = BloodGroup::pluck('name'); // e.g. ['A+', 'B-', 'O+', ...]

// Prepare inventory data for each institution
$inventoryData = [];

foreach ($institutions as $institution) {
    // Get all inventories for this institution with status 'active' or 'available'
    $groupedInventory = Inventory::where('institution_id', $institution->id)
        ->whereIn('status', ['active', 'available'])
        ->get()
        ->groupBy(fn($inv) => $inv->bloodGroup->name)
        ->map(fn($group) => $group->sum('quantity'));

    // Build distribution as flat blood_type => units array
    $distribution = [];

    foreach ($bloodGroups as $type) {
        $units = $groupedInventory[$type] ?? 0;
        $distribution[$type] = $units;
    }

    $inventoryData[] = [
        'institution' => $institution,
        'distribution' => $distribution,
    ];
}

// Pass $inventoryData and $bloodGroups to the view as usual

        

        return view('admin.inventory', [
            'inventories' => $inventories,
            'filters' => $request->only(['search', 'blood_type', 'status']),
            'totalUnits' => $totalUnits,
            'availableUnits' => $availableUnits,
            'reservedCount' => $reservedCount,
            'expiringSoonCount' => $expiringSoonCount,
            'criticalCount' => $criticalCount,
            'inventoryData' => $inventoryData,
            'bloodGroups' => $bloodGroups,
        ]);
    }

    /**
     * Store a new inventory record.
     */
    public function store(Request $request)
    {
        $request->validate([
            'institution_id'   => 'required|exists:institutions,id',
            'blood_group_id'   => 'required|exists:blood_groups,id',
            'quantity'         => 'required|numeric|min:1',
            'collected_date'   => 'required|date',
            'expiry_date'      => 'required|date|after:collected_date',
        ]);

        Inventory::create([
            'institution_id' => $request->institution_id,
            'blood_group_id' => $request->blood_group_id,
            'quantity'       => $request->quantity,
            'collected_date' => Carbon::parse($request->collected_date),
            'expiry_date'    => Carbon::parse($request->expiry_date),
            'created_by'     => Auth::id(),
            'created_on'     => now(),
            'updated_by'     => Auth::id(),
            'updated_on'     => now(),
        ]);

        // Update institution status to active when blood is added
        Institution::where('id', $request->institution_id)
            ->update(['status' => 'active']);

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Inventory item added successfully.');
    }

    /**
     * Show the form to edit an existing inventory record.
     */
    public function edit(Inventory $inventory)
    {
        $institutions = Institution::all();
        $bloodGroups = BloodGroup::all();

        return view('admin.inventory', compact('inventory', 'institutions', 'bloodGroups'));
    }

    /**
     * Update an existing inventory item.
     */
    public function update(Request $request, Inventory $inventory)
    {
        $request->validate([
            'institution_id'   => 'required|exists:institutions,id',
            'blood_group_id'   => 'required|exists:blood_groups,id',
            'quantity'         => 'required|numeric|min:1',
            'expiry_date'      => 'required|date|after:today',
        ]);

        // Prevent updating expired inventory or increasing quantity (new blood must be a new record)
        if (now()->gt($inventory->expiry_date)) {
            return redirect()->back()->withErrors('Cannot update expired inventory.');
        }
        if ($request->quantity > $inventory->quantity) {
            return redirect()->back()->withErrors('Cannot increase quantity of an existing inventory record. Add new blood as a new record.');
        }

        $inventory->update([
            'institution_id' => $request->institution_id,
            'blood_group_id' => $request->blood_group_id,
            'quantity'       => $request->quantity,
            'expiry_date'    => Carbon::parse($request->expiry_date),
            'updated_by'     => Auth::id(),
            'updated_on'     => now(),
        ]);

        // Check if institution still has available blood after update
        $hasAvailableBlood = Inventory::where('institution_id', $request->institution_id)
            ->where('status', 'available')
            ->where('quantity', '>', 0)
            ->exists();

        // Update institution status based on remaining blood
        Institution::where('id', $request->institution_id)
            ->update(['status' => $hasAvailableBlood ? 'active' : 'inactive']);

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Inventory item updated successfully.');
    }

    /**
     * Delete an inventory item.
     */
    public function destroy(Inventory $inventory)
    {
        $institutionId = $inventory->institution_id;
        $inventory->delete();

        // Check if institution still has available blood after deletion
        $hasAvailableBlood = Inventory::where('institution_id', $institutionId)
            ->where('status', 'available')
            ->where('quantity', '>', 0)
            ->exists();

        // Update institution status based on remaining blood
        Institution::where('id', $institutionId)
            ->update(['status' => $hasAvailableBlood ? 'active' : 'inactive']);

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Inventory item deleted.');
    }
}
