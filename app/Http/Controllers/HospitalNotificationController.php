<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BloodRequest;

class HospitalNotificationController extends Controller
{
    /**
     * Return pending blood requests for this hospital (JSON).
     */
    public function fetchNotifications()
    {
        $user = Auth::user();

        $notifications = BloodRequest::where('requested_from_id', $user->institution_id)
            ->where('status', 'pending')
            ->with('bloodGroup')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($request) {
                return [
                    'id' => $request->id,
                    'quantity' => $request->quantity,
                    'blood_group_id' => $request->bloodGroup->name ?? 'Unknown',
                    'created_at' => $request->created_at->toDateTimeString(),
                ];
            });

        return response()->json($notifications);
    }
}
