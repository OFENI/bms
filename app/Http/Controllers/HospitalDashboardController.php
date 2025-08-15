<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Institution;
use App\Models\BloodGroup;
use App\Models\Inventory;
use App\Models\BloodRequest;
use Carbon\Carbon;

class HospitalDashboardController extends Controller
{
    

    public function index()
    {
        $user = Auth::user();
        $currentId = $user->institution_id;
    
        // FIXED: Use the same blood types array as the inventory page
        $bloodTypes = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];
    
        // Get all institutions except current
        $hospitals = Institution::where('id', '!=', $currentId)->get();
    
        $inventoryData = $hospitals->map(function ($inst) use ($bloodTypes) {
            // FIXED: Use the same logic as HospitalInventoryController
            $inventoryRaw = Inventory::where('institution_id', $inst->id)
                ->whereIn('status', ['available', 'active'])
                ->select('blood_group_id', DB::raw('SUM(quantity) as total_volume'))
                ->groupBy('blood_group_id')
                ->get();
            
            // Get blood groups mapping
            $bloodGroups = BloodGroup::pluck('name', 'id')->toArray();
            
            // Build inventory array
            $grouped = [];
            foreach ($inventoryRaw as $item) {
                $type = $bloodGroups[$item->blood_group_id] ?? 'Unknown';
                $grouped[$type] = $item->total_volume;
            }
            
            // FIXED: Ensure all blood types are present with default 0
            $normalized = [];
            foreach ($bloodTypes as $type) {
                $normalized[$type] = $grouped[$type] ?? 0;
            }
    
            return [
                'institution' => $inst,
                'inventory' => $normalized,
            ];
        });

        

        $totalBloodUnits = Inventory::where('institution_id', $user->institution_id)
        ->whereIn('status', ['available', 'active'])
        ->sum('quantity');  // or your column name for units

    
        $requests = BloodRequest::where('requested_by', $user->institution_id)
    ->with('bloodGroup')
    ->latest()
    ->take(10)
    ->get();

$pendingRequests = BloodRequest::where('requested_by', $user->institution_id)
    ->where('status', 'pending')
    ->count();

$fulfilledRequests = BloodRequest::where('requested_by', $user->institution_id)
    ->where('status', 'fulfilled')
    ->count();

       // $urgentRequirements = BloodRequest::where('institution_id', $user->institution_id)
       // ->where('status', 'pending')
      //  ->where('required_date', '<=', Carbon::now()->addDay()) // assuming `required_date` exists
       // ->count();

       // --- CRITICAL LEVELS ---
    $criticalThreshold = 5;
    $warningThreshold = 15;

    $groupLevels = Inventory::selectRaw('blood_groups.name as blood_type, SUM(quantity) as total')
        ->join('blood_groups', 'inventory.blood_group_id', '=', 'blood_groups.id')
        ->where('inventory.institution_id', $user->institution_id)
        ->whereIn('inventory.status', ['available', 'active'])
        ->groupBy('blood_groups.name')
        ->get();

    $criticalLevels = [
        'critical' => [],
        'warning' => [],
    ];

    foreach ($groupLevels as $group) {
        if ($group->total <= $criticalThreshold) {
            $criticalLevels['critical'][] = $group;
        } elseif ($group->total <= $warningThreshold) {
            $criticalLevels['warning'][] = $group;
        }
    }

    $incomingRequests = BloodRequest::where('requested_from_id', Auth::user()->institution_id)
    ->where('status', 'pending')
    ->orderBy('created_at', 'desc')
    ->get();

// Count them for the badge:
$incomingCount = $incomingRequests->count();

$fulfilledRequests = BloodRequest::where('requested_by', $user->id)
    ->where('status', 'fulfilled')
    ->count();

    $pendingRequests = BloodRequest::where('requested_by', $user->id)
    ->where('status', 'pending')
    ->count();

return view('hospital.dashboard', compact(
    'bloodTypes',
    'inventoryData',
    'requests',
    'totalBloodUnits',
    'pendingRequests',
    'fulfilledRequests',
    'criticalLevels',
    'incomingCount',
    'incomingRequests',
    'fulfilledRequests',
    'pendingRequests'
        // ← add this
));
    }
    

    public function otherInventory()
    {
        $user = Auth::user();
        $currentId = $user->institution_id;
        // FIXED: Use the same blood types array as the inventory page
        $bloodTypes = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];
        $hospitals = Institution::where('id', '!=', $currentId)->get();
        $inventoryData = $hospitals->map(function ($inst) use ($bloodTypes) {
            // FIXED: Use the same logic as HospitalInventoryController
            $inventoryRaw = Inventory::where('institution_id', $inst->id)
                ->whereIn('status', ['available', 'active'])
                ->select('blood_group_id', DB::raw('SUM(quantity) as total_volume'))
                ->groupBy('blood_group_id')
                ->get();
            
            // Get blood groups mapping
            $bloodGroups = BloodGroup::pluck('name', 'id')->toArray();
            
            // Build inventory array
            $grouped = [];
            foreach ($inventoryRaw as $item) {
                $type = $bloodGroups[$item->blood_group_id] ?? 'Unknown';
                $grouped[$type] = $item->total_volume;
            }
            
            // FIXED: Ensure all blood types are present with default 0
            $normalized = [];
            foreach ($bloodTypes as $type) {
                $normalized[$type] = $grouped[$type] ?? 0;
            }
            
            // DEBUG: Log inventory data for this hospital
            \Log::info('Hospital Inventory Data', [
                'hospital_id' => $inst->id,
                'hospital_name' => $inst->name,
                'raw_grouped' => $grouped,
                'normalized' => $normalized
            ]);
            
            return [
                'institution' => [
                    'id' => $inst->id,
                    'name' => $inst->name,
                ],
                'inventory' => $normalized,
            ];
        });
        return response()->json($inventoryData);
    }

    public function checkInventoryChanges()
    {
        $user = Auth::user();
        $currentId = $user->institution_id;
        
        // Get the last update timestamp from session or cache
        $lastCheck = session('last_inventory_check', now()->subMinutes(5));
        
        // Check if any inventory has been updated since last check
        $hasChanges = Inventory::where('institution_id', '!=', $currentId)
            ->where('updated_on', '>', $lastCheck)
            ->exists();
        
        // Update the last check timestamp
        session(['last_inventory_check' => now()]);
        
        return response()->json([
            'has_changes' => $hasChanges,
            'timestamp' => now()->toISOString()
        ]);
    }

    public function debugInventory($hospitalId = null)
    {
        $user = Auth::user();
        $currentId = $user->institution_id;
        
        if (!$hospitalId) {
            $hospitalId = Institution::where('id', '!=', $currentId)->first()->id;
        }
        
        // Get raw inventory data
        $rawInventory = Inventory::where('institution_id', $hospitalId)
            ->whereIn('status', ['available', 'active'])
            ->with('bloodGroup')
            ->get();
        
        // Get blood groups
        $bloodGroups = BloodGroup::pluck('name', 'id')->toArray();
        
        $debugData = [
            'hospital_id' => $hospitalId,
            'hospital_name' => Institution::find($hospitalId)->name,
            'raw_inventory' => $rawInventory->map(function($item) use ($bloodGroups) {
                return [
                    'id' => $item->id,
                    'blood_group_id' => $item->blood_group_id,
                    'blood_group_name' => $bloodGroups[$item->blood_group_id] ?? 'Unknown',
                    'quantity' => $item->quantity,
                    'status' => $item->status,
                    'created_on' => $item->created_on,
                    'updated_on' => $item->updated_on,
                ];
            }),
            'blood_groups_mapping' => $bloodGroups,
        ];
        
        return response()->json($debugData);
    }

    public function testInventory()
    {
        $user = Auth::user();
        $currentId = $user->institution_id;
        
        // Test the exact same logic as otherInventory but with more detailed output
        $bloodTypes = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];
        $hospitals = Institution::where('id', '!=', $currentId)->get();
        
        $testResults = [];
        
        foreach ($hospitals as $hospital) {
            // Get raw inventory data
            $inventoryRaw = Inventory::where('institution_id', $hospital->id)
                ->whereIn('status', ['available', 'active'])
                ->select('blood_group_id', DB::raw('SUM(quantity) as total_volume'))
                ->groupBy('blood_group_id')
                ->get();
            
            // Get blood groups mapping
            $bloodGroups = BloodGroup::pluck('name', 'id')->toArray();
            
            // Build inventory array
            $grouped = [];
            foreach ($inventoryRaw as $item) {
                $type = $bloodGroups[$item->blood_group_id] ?? 'Unknown';
                $grouped[$type] = $item->total_volume;
            }
            
            // Normalize
            $normalized = [];
            foreach ($bloodTypes as $type) {
                $normalized[$type] = $grouped[$type] ?? 0;
            }
            
            $testResults[] = [
                'hospital_id' => $hospital->id,
                'hospital_name' => $hospital->name,
                'raw_inventory_raw' => $inventoryRaw->toArray(),
                'blood_groups_mapping' => $bloodGroups,
                'grouped' => $grouped,
                'normalized' => $normalized,
            ];
        }
        
        return response()->json($testResults);
    }

    public function debugCurrentInventory()
    {
        $user = Auth::user();
        $currentId = $user->institution_id;
        
        // Get your own inventory
        $myInventory = Inventory::where('institution_id', $currentId)
            ->with('bloodGroup')
            ->get();
        
        // Get other hospitals' inventory
        $otherHospitals = Institution::where('id', '!=', $currentId)->get();
        $otherInventory = [];
        
        foreach ($otherHospitals as $hospital) {
            $inventory = Inventory::where('institution_id', $hospital->id)
                ->with('bloodGroup')
                ->get();
            
            $otherInventory[] = [
                'hospital_id' => $hospital->id,
                'hospital_name' => $hospital->name,
                'inventory_count' => $inventory->count(),
                'inventory' => $inventory->map(function($item) {
                    return [
                        'id' => $item->id,
                        'blood_group' => $item->bloodGroup->name ?? 'Unknown',
                        'quantity' => $item->quantity,
                        'status' => $item->status,
                        'created_on' => $item->created_on,
                        'updated_on' => $item->updated_on,
                    ];
                })
            ];
        }
        
        return response()->json([
            'my_hospital_id' => $currentId,
            'my_hospital_name' => $user->institution->name ?? 'Unknown',
            'my_inventory_count' => $myInventory->count(),
            'my_inventory' => $myInventory->map(function($item) {
                return [
                    'id' => $item->id,
                    'blood_group' => $item->bloodGroup->name ?? 'Unknown',
                    'quantity' => $item->quantity,
                    'status' => $item->status,
                    'created_on' => $item->created_on,
                    'updated_on' => $item->updated_on,
                ];
            }),
            'other_hospitals' => $otherInventory
        ]);
    }
}
