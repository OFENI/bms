<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BloodRequest;
use App\Models\Institution;
use App\Models\BloodGroup;
use Illuminate\Support\Facades\Auth;




class HospitalBloodRequestController extends Controller
{
    
    
    public function index()
    {
        $institutionId = Auth::user()->institution_id;
    
        $requests = BloodRequest::where('requested_by', $institutionId)
            ->orderBy('created_at', 'desc')
            ->get();
    
        $institutions = Institution::where('id', '!=', $institutionId)->get();
        $bloodGroups = BloodGroup::all();
    
        $pendingRequests = BloodRequest::where('requester_id', $institutionId)
    ->where('status', 'pending')
    ->orderBy('requested_date', 'desc')
    ->get();
    
        $fulfilledRequests = BloodRequest::where('requester_id', $institutionId)
                            ->whereRaw('LOWER(status) = ?', ['fulfilled'])
                            ->orderBy('fulfilled_date', 'desc')
                            ->get();
    
        $partialRequests = BloodRequest::where('requester_id', $institutionId)
                            ->whereRaw('LOWER(status) = ?', ['partial'])
                            ->orderBy('fulfilled_date', 'desc')
                            ->get();
    
                            $pendingCount = BloodRequest::where('requester_id', $institutionId)
                            ->whereRaw('LOWER(status) = ?', ['pending'])
                            ->count();
        $partialCount = BloodRequest::where('requester_id', $institutionId)
                            ->whereRaw('LOWER(status) = ?', ['partial'])
                            ->count();
    
        $fulfilledCount = BloodRequest::where('requester_id', $institutionId)
                            ->whereRaw('LOWER(status) = ?', ['fulfilled'])
                            ->count();
    
        $urgentCount = BloodRequest::where('requester_id', $institutionId)
                            ->whereRaw('LOWER(urgency_level) = ?', ['critical'])
                            ->count();

                            $requests = BloodRequest::where('requester_id', $institutionId)
                            ->with('bloodGroup')
                            ->latest()
                            ->take(3)
                            ->get();
                        
        $latestRequest = BloodRequest::where('requester_id', $institutionId)->latest()->first();
    

        $notifications = \App\Models\BloodRequest::where('requester_id', $institutionId)
        ->whereIn('status', ['approved', 'partial', 'fulfilled'])
        ->orderBy('updated_at', 'desc')
        ->take(3)
        ->with('bloodGroup')
        ->get();

        $pendingRequests = BloodRequest::with(['bloodGroup', 'requestedFromInstitution'])
        ->where('status', 'pending')
        ->where('requester_id', $institutionId)  // your hospital requesting blood
        ->orderByDesc('created_at')
        ->get();

        $pendingIncoming = BloodRequest::with(['bloodGroup', 'requesterInstitution'])
        ->where('requested_from_id', $institutionId)
        ->where('status', 'pending')
        ->latest('created_at')
        ->get();
    
    $incomingCount = $pendingIncoming->count();


    
        return view('hospital.blood_request', [
            'pendingRequests' => $pendingRequests,
            'institutions'    => $institutions,
            'bloodGroups'     => $bloodGroups,
            'fulfilledRequests'=> $fulfilledRequests,
            'pendingCount'    => $pendingCount,
            'partialRequests' => $partialRequests,
            'partialCount'    => $partialCount,
            'fulfilledCount'  => $fulfilledCount,
            'urgentCount'     => $urgentCount,
            'latestRequest'   => $latestRequest,
            'requests'        => $requests,
            'notifications'   => $notifications,
            'pendingIncoming' => $pendingIncoming,
            'incomingCount'   => $incomingCount,
        ]);
    }
    
    
    // Show form
    public function create()
    {
        $bloodGroups = BloodGroup::all();
        $institutions = Institution::where('id', '!=', Auth::user()->institution_id)->get(); // exclude self

        return view('hospital.blood_request', compact('bloodGroups', 'institutions'));
    }

    // Store request
    public function store(Request $request)
    {
        $userId = auth()->id();
        $institutionId = auth()->user()->institution_id;
    
        // Validate the form inputs first
        $validated = $request->validate([
            'blood_group_id'     => 'required|exists:blood_groups,id',
            'quantity'           => 'required|integer|min:1',
            'urgency_level'      => 'required|in:normal,urgent,critical',
            'requested_from_id'  => 'required|exists:institutions,id',
            'notes'              => 'nullable|string',
        ]);
    
        // 🔍 Check the inventory of the requested institution
        $availableStock = \App\Models\Inventory::where('institution_id', $validated['requested_from_id'])
            ->where('blood_group_id', $validated['blood_group_id'])
            ->sum('quantity');
    
        if ($availableStock < 50) {
            return redirect()->back()->with('error', 'The requested institution has less than 50 units of that blood group. Request cannot be processed at this time.');
        }
    
        // ✅ Proceed if stock is sufficient
        \App\Models\BloodRequest::create([
            'requester_id'      => $institutionId,
            'requested_by'      => $userId,
            'requested_from_id' => $validated['requested_from_id'],
            'blood_group_id'    => $validated['blood_group_id'],
            'quantity'          => $validated['quantity'],
            'urgency_level'     => $validated['urgency_level'],
            'notes'             => $validated['notes'] ?? null,
            'status'            => 'pending',
            'requested_date'    => now(),
            'fulfilled_date'    => null,
            'created_by'        => $userId,
            'created_on'        => now(),
        ]);
    
        return redirect()->back()->with('success', 'Blood request submitted successfully!');
    }
    

}