<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Disbursement;
use App\Models\BloodRequest;
use Illuminate\Support\Facades\Auth;

class DisbursementHistoryController extends Controller
{
    /**
     * Show disbursement history for this hospital (outgoing disbursements).
     */
    public function index()
    {
        $user = Auth::user();
        $institutionId = $user->institution_id;

        // Outgoing disbursements that this hospital sent
        $disbursements = Disbursement::with(['bloodGroup', 'receiverInstitution'])
    ->where('created_by', $user->id) // or sender institution logic
    ->latest()
    ->paginate(10);

        // Stats
        $totalDisbursements = $disbursements->total();
        $totalUnits        = $disbursements->sum('quantity');
        $totalGroups       = $disbursements->pluck('blood_group_id')->unique()->count();

        // Only pending requests *to* this hospital (for incoming badge)
        $pendingRequests = BloodRequest::where('status', 'pending')
            ->where('requested_from_id', $institutionId)
            ->with(['bloodGroup', 'requestedFromInstitution'])
            ->get();
        $incomingCount = $pendingRequests->count();

        return view('hospital.disbursement', compact(
            'disbursements',
            'totalDisbursements',
            'totalUnits',
            'totalGroups',
            'pendingRequests',
            'incomingCount'
        ));
    }

    /**
     * Store a new disbursement record.
     */
    
public function store(Request $request)
{
    $user = Auth::user();
    $institutionId = $user->institution_id;

    $data = $request->validate([
        'blood_request_id' => 'required|exists:blood_requests,id',
        'quantity'         => 'required|integer|min:1',
    ]);

    $bloodRequest = BloodRequest::findOrFail($data['blood_request_id']);
    $requestedQty = $bloodRequest->quantity;
    $qty = $data['quantity'];

    // Must send at least requested amount
    if ($qty < $requestedQty) {
        return back()->with('error', "You must send at least {$requestedQty} units.");
    }

    // Check receiver's existing stock and new total
    $receiverId = $bloodRequest->requested_from_id;
    $receiverStock = Inventory::where('institution_id', $receiverId)
        ->where('blood_group_id', $bloodRequest->blood_group_id)
        ->sum('quantity');
    $newStock = $receiverStock + $qty;
    if ($newStock >= 150) {
        return back()->with('error', 'Disbursement blocked: after adding this, the requesting hospital would exceed 150 units.');
    }

    // Check sender's own stock
    $senderStock = Inventory::where('institution_id', $institutionId)
        ->where('blood_group_id', $bloodRequest->blood_group_id)
        ->sum('quantity');
    if ($senderStock < $qty) {
        return back()->with('error', 'Insufficient inventory to disburse.');
    }

    // Proceed with disbursement
    Disbursement::create([
        'blood_request_id' => $bloodRequest->id,
        'institution_id'   => $institutionId,
        'blood_group_id'   => $bloodRequest->blood_group_id,
        'quantity'         => $qty,
        'disbursed_date'   => now(),
        'status'           => 'disbursed',
        'created_by'       => $user->id,
        'created_on'       => now(),
    ]);

    // Decrement sender inventory FIFO
    $needed = $qty;
    Inventory::where('institution_id', $institutionId)
        ->where('blood_group_id', $bloodRequest->blood_group_id)
        ->where('expiry_date', '>=', now())
        ->orderBy('expiry_date')
        ->get()
        ->each(function($inv) use (&$needed) {
            if ($needed <= 0) return;
            $take = min($inv->quantity, $needed);
            $inv->decrement('quantity', $take);
            $needed -= $take;
        });

    // Update request status
    $bloodRequest->update(['status' => 'fulfilled', 'fulfilled_date' => now()]);

    // Add to receiver inventory
    $receiverInv = Inventory::firstOrNew([
        'institution_id' => $receiverId,
        'blood_group_id' => $bloodRequest->blood_group_id,
        'status'         => 'active',
    ]);
    
    $receiverInv->quantity += $qty;
    $receiverInv->collected_date = now();
    $receiverInv->expiry_date    = now()->addDays(42);
    $receiverInv->created_by     = $user->id;
    $receiverInv->updated_by     = $user->id;
    $receiverInv->save();
    

    return back()->with('success', 'Disbursement recorded successfully.');
}


}

