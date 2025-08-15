<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Disbursement;
use App\Models\BloodRequest;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DisbursementController extends Controller
{
    /**
     * Show all incoming disbursements for this hospital.
     */
    public function index()
    {
        $user = Auth::user();

        // FIXED: Show disbursements where THIS hospital sent blood to others
        $disbursements = Disbursement::with(['bloodGroup', 'receiverInstitution'])
    ->where('created_by', $user->id) // or sender institution logic
    ->latest()
    ->paginate(10);


        $totalDisbursements = $disbursements->count();
        $totalUnits        = $disbursements->sum('quantity');
        $totalGroups       = $disbursements->pluck('blood_group_id')->unique()->count();

        // FIXED: Only show pending requests for this hospital
        $pendingRequests = BloodRequest::where('status', 'pending')
            ->where('requested_from_id', $user->institution_id)
            ->with(['bloodGroup', 'requesterInstitution'])
            ->get();

        return view('hospital.disbursement', compact(
            'disbursements',
            'totalDisbursements',
            'totalUnits',
            'totalGroups',
            'pendingRequests'
        ));
    }

    /**
     * Store a new disbursement, update inventory & original request.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'blood_request_id' => 'required|exists:blood_requests,id',
            'quantity'         => 'required|integer|min:1',
        ]);

        $user            = Auth::user();
        $senderInstId    = $user->institution_id;
        $bloodRequest    = BloodRequest::findOrFail($data['blood_request_id']);
        $receiverInstId  = $bloodRequest->requester_id; // FIXED: Use requester_id (hospital that needs blood)
        $requestedQty    = $bloodRequest->quantity;
        $qty             = $data['quantity'];

        // 1) Must send at least as many as they asked for
        if ($qty < $requestedQty) {
            return back()->with('error', "You must send at least {$requestedQty} units as requested.");
        }

        // 2) Block if requester already has enough active/unexpired stock
        // 2) Block only if the new total will exceed 150 units
        $bloodGroupId   = $bloodRequest->blood_group_id;
        
        // Check receiver's current inventory
        $existingAtReceiver = Inventory::where('institution_id', $receiverInstId)
            ->where('blood_group_id', $bloodGroupId)
            ->whereIn('status', ['available', 'active'])
            ->where('expiry_date', '>=', now())
            ->sum('quantity');
        
        // ❗ Only block if receiver already has 150 or more
        if ($existingAtReceiver >= 150) {
            return back()->with('error',
                "Cannot disburse: receiving hospital already has {$existingAtReceiver} active units. Limit is 150."
            );
        }
        



        // 3) Ensure sender has enough stock - More flexible check
        $senderStock = Inventory::where('institution_id', $senderInstId)
            ->where('blood_group_id', $bloodRequest->blood_group_id)
            ->whereIn('status', ['available', 'active'])
            ->where('expiry_date', '>=', now())
            ->sum('quantity');

        // DEBUG: Check all inventory records for this blood group
        $allInventory = Inventory::where('institution_id', $senderInstId)
            ->where('blood_group_id', $bloodRequest->blood_group_id)
            ->get(['id', 'quantity', 'status', 'expiry_date']);
        
        \Log::info('All inventory records for sender', [
            'sender_inst_id' => $senderInstId,
            'blood_group_id' => $bloodRequest->blood_group_id,
            'available_stock' => $senderStock,
            'all_records' => $allInventory->map(function($item) {
                return [
                    'id' => $item->id,
                    'quantity' => $item->quantity,
                    'status' => $item->status,
                    'expiry_date' => $item->expiry_date,
                    'is_expired' => $item->expiry_date < now()
                ];
            })
        ]);

        // If no active stock, check if there's any stock at all (for debugging)
        if ($senderStock == 0) {
            $totalStock = Inventory::where('institution_id', $senderInstId)
                ->where('blood_group_id', $bloodRequest->blood_group_id)
                ->sum('quantity');
            
            $expiredStock = Inventory::where('institution_id', $senderInstId)
                ->where('blood_group_id', $bloodRequest->blood_group_id)
                ->where('expiry_date', '<', now())
                ->sum('quantity');
            
            $inactiveStock = Inventory::where('institution_id', $senderInstId)
                ->where('blood_group_id', $bloodRequest->blood_group_id)
                ->whereNotIn('status', ['available', 'active'])
                ->sum('quantity');

            // DEBUG: Log inventory check details
            \Log::info('Inventory Check Debug', [
                'sender_inst_id' => $senderInstId,
                'blood_group_id' => $bloodRequest->blood_group_id,
                'requested_quantity' => $qty,
                'active_stock' => $senderStock,
                'total_stock' => $totalStock,
                'expired_stock' => $expiredStock,
                'inactive_stock' => $inactiveStock,
                'all_inventory_for_this_group' => Inventory::where('institution_id', $senderInstId)
                    ->where('blood_group_id', $bloodRequest->blood_group_id)
                    ->get(['id', 'quantity', 'status', 'expiry_date'])
            ]);

            if ($totalStock == 0) {
                return back()->with('error',
                    "No inventory found for this blood type. Please add inventory first."
                );
            } elseif ($expiredStock > 0) {
                return back()->with('error',
                    "You have {$totalStock} units total, but {$expiredStock} units are expired. Only {$senderStock} units are available for disbursement."
                );
            } elseif ($inactiveStock > 0) {
                // TEMPORARY FIX: Allow disbursement of inactive inventory if no active inventory exists
                $inactiveStockAvailable = Inventory::where('institution_id', $senderInstId)
                    ->where('blood_group_id', $bloodRequest->blood_group_id)
                    ->whereNotIn('status', ['available', 'active'])
                    ->where('expiry_date', '>=', now())
                    ->sum('quantity');
                
                if ($inactiveStockAvailable >= $qty) {
                    // Use inactive stock for disbursement
                    $senderStock = $inactiveStockAvailable;
                    \Log::info('Using inactive inventory for disbursement', [
                        'inactive_stock_used' => $senderStock,
                        'requested_quantity' => $qty
                    ]);
                } else {
                    return back()->with('error',
                        "You have {$totalStock} units total, but {$inactiveStock} units are inactive. Only {$inactiveStockAvailable} inactive units are available for disbursement (need {$qty})."
                    );
                }
            }
        }

        if ($senderStock < $qty) {
            return back()->with('error',
                "Insufficient inventory to disburse. You only have {$senderStock} units available (need {$qty})."
            );
        }

        // 4) Create the disbursement record
        Disbursement::create([
            'blood_request_id' => $bloodRequest->id,
            'institution_id'   => $receiverInstId,
            'blood_group_id'   => $bloodRequest->blood_group_id,
            'quantity'         => $qty,
            'disbursed_date'   => now(),
            'status'           => 'disbursed',
            'created_by'       => $user->id,
            'created_on'       => now(),
        ]);

        // 5) Mark original request fulfilled
        $bloodRequest->update([
            'status'         => 'fulfilled',
            'fulfilled_date' => now(),
        ]);

        // 6) Deduct from sender's inventory (FIFO by expiry)
        $needed = $qty;
        
        // Get all available inventory lots (including different statuses if needed)
        $lots = Inventory::where('institution_id', $senderInstId)
            ->where('blood_group_id', $bloodRequest->blood_group_id)
            ->where('expiry_date', '>=', now())
            ->orderBy('expiry_date')
            ->get();

        \Log::info('Starting inventory deduction', [
            'sender_inst_id' => $senderInstId,
            'blood_group_id' => $bloodRequest->blood_group_id,
            'quantity_to_deduct' => $qty,
            'available_lots' => $lots->count(),
            'lots_details' => $lots->map(function($lot) {
                return [
                    'id' => $lot->id,
                    'quantity' => $lot->quantity,
                    'status' => $lot->status,
                    'expiry_date' => $lot->expiry_date
                ];
            })
        ]);

        foreach ($lots as $lot) {
            if ($needed <= 0) break;
            $take = min($lot->quantity, $needed);
            $oldQuantity = $lot->quantity;
            $lot->quantity -= $take;
            $lot->updated_by = $user->id;
            $lot->updated_on = now();
            $lot->save();
            $needed -= $take;
            
            \Log::info('Deducted from lot', [
                'lot_id' => $lot->id,
                'old_quantity' => $oldQuantity,
                'new_quantity' => $lot->quantity,
                'deducted' => $take,
                'remaining_needed' => $needed
            ]);
        }

        if ($needed > 0) {
            \Log::warning('Could not deduct all needed quantity', [
                'requested' => $qty,
                'deducted' => $qty - $needed,
                'remaining' => $needed
            ]);
        }

        // 7) Add to receiver's inventory (or create it)
        $expiryDate    = Carbon::now()->addDays(42);
        $collectedDate = Carbon::now();

        // FIXED: Better logic to find or create inventory record
        $receiverLot = Inventory::where('institution_id', $receiverInstId)
            ->where('blood_group_id', $bloodRequest->blood_group_id)
            ->whereIn('status', ['available', 'active'])
            ->first();

        if ($receiverLot) {
            // Update existing record
            $receiverLot->quantity += $qty;
            $receiverLot->updated_by = $user->id;
            $receiverLot->updated_on = now();
            $receiverLot->save();
            
            \Log::info('Updated existing inventory record', [
                'institution_id' => $receiverInstId,
                'blood_group_id' => $bloodRequest->blood_group_id,
                'new_quantity' => $receiverLot->quantity,
                'added_quantity' => $qty
            ]);
        } else {
            // Create new record
            $newInventory = Inventory::create([
                'institution_id' => $receiverInstId,
                'blood_group_id' => $bloodRequest->blood_group_id,
                'quantity'       => $qty,
                'collected_date' => $collectedDate,
                'expiry_date'    => $expiryDate,
                'status'         => 'available',
                'created_by'     => $user->id,
                'created_on'     => now(),
                'updated_by'     => $user->id,
                'updated_on'     => now(),
            ]);
            
            \Log::info('Created new inventory record', [
                'inventory_id' => $newInventory->id,
                'institution_id' => $receiverInstId,
                'blood_group_id' => $bloodRequest->blood_group_id,
                'quantity' => $qty,
                'status' => 'active'
            ]);
        }

        // Redirect to dashboard to refresh the inventory display
        return redirect()->route('hospital.dashboard')
            ->with('success', "Disbursement successful! {$qty} units sent to " . 
                \App\Models\Institution::find($receiverInstId)->name . 
                ". Inventory updated.")
            ->with('refresh_inventory', true); // Flag to trigger inventory refresh
    }
}
