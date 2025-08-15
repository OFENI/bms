<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Institution;
use App\Models\Inventory;
use App\Models\BloodGroup;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HospitalInventoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $institution = $user->institution;
    
        if (!$institution) {
            return back()->withErrors('No hospital assigned.');
        }
    
        // Fetch all blood groups directly
        $bloodGroups = BloodGroup::pluck('name', 'id')->toArray(); // e.g., [1 => "A+", 2 => "A−", ...]
    
        // Normalize the blood group names exactly as in bloodTypes
        $normalizedGroups = [];
        foreach ($bloodGroups as $id => $name) {
            $normalized = strtoupper(str_replace(['−'], '-', $name)); // A− => A-, AB− => AB-
            $normalizedGroups[$id] = $normalized;
        }
    
        // Fetch inventory data from the DB
        $inventoryRaw = Inventory::select('blood_group_id', DB::raw('SUM(quantity) as total_volume'))
            ->where('institution_id', $institution->id)
            ->groupBy('blood_group_id')
            ->get();
    
        // Build the $inventory array
        $inventory = [];
        foreach ($inventoryRaw as $item) {
            $type = $normalizedGroups[$item->blood_group_id] ?? 'Unknown';
            $inventory[$type] = (object)[
                'total_volume' => $item->total_volume
            ];
        }
    
        // Make sure all 8 types exist
        $bloodTypes = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];
        foreach ($bloodTypes as $type) {
            if (!isset($inventory[$type])) {
                $inventory[$type] = (object)[
                    'total_volume' => 0
                ];
            }
        }

        $expiringUnits = Inventory::where('institution_id', $institution->id)
        ->whereDate('expiry_date', '<=', now()->addDays(30))
        ->get()
        ->map(function ($unit) {
            $unit->days_left = now()->diffInDays(\Carbon\Carbon::parse($unit->expiry_date), false);
            return $unit;
        });
    
        // Get incoming blood requests for notification badge
        $incomingRequests = \App\Models\BloodRequest::where('requested_from_id', $institution->id)
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $incomingCount = $incomingRequests->count();
    
        // For the chart
        $chartLabels = array_keys($inventory);
        $chartData = array_map(fn($item) => $item->total_volume, $inventory);
    
        return view('hospital.blood_inventory', compact(
            'user',
            'institution',
            'inventory',
            'chartLabels',
            'chartData',
            'expiringUnits',
            'incomingCount'
        ));
    }

    public function showOtherInventories()
    {
        $currentInstitutionId = Auth::user()->institution_id;
        $bloodGroups = BloodGroup::all();
        $bloodTypes = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];
    
        $institutions = Institution::where('id', '!=', $currentInstitutionId)->get();
        $inventoryData = [];
    
        foreach ($institutions as $institution) {
            $inventoryRaw = Inventory::where('institution_id', $institution->id)
            ->select('blood_group_id', DB::raw('SUM(quantity) as total'))
            ->groupBy('blood_group_id')
            ->get();
        
        $mappedInventory = [];
        
        foreach ($bloodGroups as $group) {
            $normalized = strtoupper(str_replace('−', '-', $group->name));
            $total = $inventoryRaw->firstWhere('blood_group_id', $group->id)?->total ?? 0;
            $mappedInventory[$normalized] = $total;
        }
        

    
            $inventoryData[] = [
                'institution' => $institution,
                'inventory'   => $mappedInventory,
            ];
        }
    
        // Get incoming blood requests for notification badge
        $incomingRequests = \App\Models\BloodRequest::where('requested_from_id', $currentInstitutionId)
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $incomingCount = $incomingRequests->count();

        return view('hospital.other_inventory', compact('inventoryData', 'bloodTypes', 'incomingCount'));
    }
    

    
}
