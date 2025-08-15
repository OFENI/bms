<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BloodRequest;
use Illuminate\Support\Facades\Auth;

class HospitalRequestController extends Controller
{
    
    public function index()
{
    $user = Auth::user();

    // Outgoing requests FROM this hospital
    $outgoingRequests = BloodRequest::where('institution_id', $user->institution_id)
        ->where('requested_by', $user->id)
        ->get();

    // Incoming requests TO this hospital
    $incomingRequests = BloodRequest::where('requested_from_id', $user->institution_id)
        ->where('status', 'pending')
        ->orderBy('created_at', 'desc')
        ->get();

    $incomingCount = $incomingRequests->count();

    $bloodGroups = \App\Models\BloodGroup::all();

    return view('hospital.blood_request', compact(
        'outgoingRequests',
        'incomingRequests',
        'incomingCount',
        'bloodGroups'
    ));
}


    
    public function create()
    {
        $user = Auth::user();
        $bloodGroups = \App\Models\BloodGroup::all();
        $hospitals = \App\Models\Institution::where('id', '!=', $user->institution_id)->get();
        // Get incoming blood requests for notification badge
        $incomingRequests = BloodRequest::where('requested_from_id', $user->institution_id)
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
        $incomingCount = $incomingRequests->count();
        return view('hospital.blood_requests.create', compact('bloodGroups', 'incomingCount', 'hospitals'));
    }

    public function store(Request $request)
    {
        abort_if(Auth::user()->role !== 'hospital', 403);
        $request->validate([
            'blood_group_id' => 'required|exists:blood_groups,id',
            'quantity' => 'required|integer|min:1',
            'requested_from_id' => 'required|exists:institutions,id',
        ]);

        $user = Auth::user();

        BloodRequest::create([
            'institution_id' => $user->institution_id,
            'blood_group_id' => $request->blood_group_id,
            'requested_by' => $user->id,
            'quantity' => $request->quantity,
            'status' => 'pending',
            'requested_date' => now(),
            'created_by' => $user->id,
            'created_on' => now(),
            'requested_from_id' => $request->requested_from_id,
        ]);

        return redirect()->route('hospital.blood_request')->with('success', 'Blood request submitted successfully!');
    }

    public function notifications()
{
    $user = Auth::user();
    $pending = BloodRequest::where('requested_from_id', $user->institution_id)
        ->where('status', 'pending')
        ->count();

    return response()->json(['count' => $pending]);
}

}
