<?php

namespace App\Http\Controllers;

use App\Models\Institution;
use App\Models\Inventory;
use App\Models\BloodGroup;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class InstitutionController extends Controller
{
    /**
     * Show the "Add Institution" form and the institutions list.
     */
   public function index()
{
    $bloodGroups  = BloodGroup::all();
    $institutions = Institution::with('inventory.bloodGroup')
                      ->orderBy('created_at','desc')
                      ->paginate(10);

    // point to the singular blade
    return view('admin.institutions', compact('bloodGroups','institutions'));
}

    /**
     * Persist a new institution + its login user + any inventory.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'type'           => 'required|string|in:Hospital,Clinic,Blood Bank,Research Center',
            'location'       => 'required|string|max:255',
            'email'          => 'nullable|email|unique:institutions,email',
            'contact_number' => 'nullable|string|max:100',
            'inventory'      => 'nullable|array',
            'inventory.*'    => 'nullable|integer|min:0',
        ]);
    
        DB::beginTransaction();
        try {
            // 1) Create the institution only
            $institution = Institution::create([
                'name'           => $request->name,
                'type'           => $request->type,
                'location'       => $request->location,
                'email'          => $request->email,
                'contact_number' => $request->contact_number,
                'created_by'     => Auth::id(),
                'created_on'     => now(),
            ]);
    
            // 2) Do NOT create a User here
    
            // 3) Save inventory quantities if any
            if ($request->filled('inventory')) {
                foreach ($request->inventory as $bgId => $qty) {
                    if ($qty > 0) {
                        Inventory::create([
                            'institution_id' => $institution->id,
                            'blood_group_id' => $bgId,
                            'quantity'       => $qty,
                            'expiry_date'    => now()->addMonths(2),
                            'created_by'     => Auth::id(),
                            'created_on'     => now(),
                        ]);
                    }
                }
            }
    
            DB::commit();
    
            return redirect()
                ->route('institutions.index')
                ->with('success', "Institution created successfully: {$institution->name}");
    
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()
                ->withErrors('Failed to save institution: '.$e->getMessage())
                ->withInput();
        }
    }
    

    /**
     * Show the edit form for an institution.
     */
    public function edit(Institution $institution)
    {
        $bloodGroups  = BloodGroup::all();
        return view('admin.institutions.edit', compact('institution','bloodGroups'));
    }

    /**
     * Update an institution’s details.
     */
    public function update(Request $request, Institution $institution)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'type'           => 'required|string|in:Hospital,Clinic,Blood Bank,Research Center',
            'location'       => 'required|string|max:255',
            'email'          => 'nullable|email|unique:institutions,email,'.$institution->id,
            'contact_number' => 'nullable|string|max:100',
            'status'         => 'required|in:active,inactive',
        ]);

        $institution->update($request->only([
            'name','type','location','email','contact_number','status'
        ]));

        return redirect()
            ->route('institutions.index')
            ->with('success', 'Institution updated successfully.');
    }

    /**
     * Delete an institution.
     */
    public function destroy(Institution $institution)
    {
        $institution->delete();
        return redirect()
            ->route('institutions.index')
            ->with('success', 'Institution deleted successfully.');
    }


    public function inventory(Request $request)
{
    $inventories = Inventory::with(['institution', 'bloodGroup'])
        ->orderBy('expiry_date', 'asc')
        ->paginate(10);

    // Summary
    $totalUnits = Inventory::count();
    $availableUnits = Inventory::where('status', 'available')->count();
    $reservedCount = Inventory::where('status', 'reserved')->count();
    $expiringSoonCount = Inventory::whereBetween('expiry_date', [now(), now()->addDays(7)])->count();

    $criticalCount = Inventory::select('blood_group_id', DB::raw('SUM(quantity) as total'))
        ->groupBy('blood_group_id')
        ->having('total', '<', 5)
        ->count();

    // 🩸 Blood Group Distribution per Hospital
    $institutions = Institution::where('type', 'hospital')->get();
    $bloodGroups = BloodGroup::pluck('name'); // ["A+", "A−", etc.]

    $inventoryData = [];

    foreach ($institutions as $institution) {
        $grouped = Inventory::where('institution_id', $institution->id)
            ->where('status', 'available')
            ->get()
            ->groupBy(fn($inv) => $inv->bloodGroup->name)
            ->map(fn($group) => $group->sum('quantity'));

        $total = $grouped->sum();
        $distribution = [];

        foreach ($bloodGroups as $type) {
            $units = $grouped[$type] ?? 0;
            $distribution[$type] = [
                'units' => $units,
                'percentage' => $total > 0 ? round(($units / $total) * 100, 2) : 0,
            ];
        }

        $inventoryData[] = [
            'institution' => $institution,
            'distribution' => $distribution,
        ];
    }

    return view('admin.inventory', [
        'inventories' => $inventories,
        'totalUnits' => $totalUnits,
        'availableUnits' => $availableUnits,
        'reservedCount' => $reservedCount,
        'expiringSoonCount' => $expiringSoonCount,
        'criticalCount' => $criticalCount,
        'inventoryData' => $inventoryData, // ✅ pass it to the view
        'bloodGroups' => $bloodGroups,
    ]);
}
    
    
}
