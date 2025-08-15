<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Institution;
use App\Models\Donor;
use App\Models\UserDetail;
use App\Models\BloodGroup;
use App\Models\Donation;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;
use App\Models\BloodRequest;

class AdminController extends Controller
{
    /**
     * Admin Dashboard
     */
    public function index()
{
    if (Auth::user()->role !== 'admin') {
        return redirect()->route('user.dashboard');
    }

    $totalRealUsers = User::whereNotIn('role', ['admin', 'institution'])->count();
    $totalInstitutions = Institution::count();

    $totalVolume = Donation::sum('volume_ml');
    $unitSizeMl = 450;
    $totalUnits = round($totalVolume / $unitSizeMl, 1);

    $byType = Donation::join('user_details', 'donations.user_id', '=', 'user_details.user_id')
        ->groupBy('user_details.blood_type')
        ->select([
            'user_details.blood_type',
            DB::raw("SUM(donations.volume_ml)/{$unitSizeMl} as units")
        ])->pluck('units','blood_type');

    $criticalThreshold = 10;
    $criticalTypes = $byType->filter(fn($u) => $u < $criticalThreshold)->count();

    $today = Carbon::today();
    $todaysDonations = Donation::whereDate('donation_date', $today)->count();
    $donationTarget = 25;

    $targetLevels = [
        'O-' => 100,
        'AB-' => 80,
        'B-' => 80,
        'A-' => 100,
        'O+' => 180,
    ];

    $inventoryData = \App\Models\Inventory::with('bloodGroup')
        ->selectRaw('blood_group_id, SUM(quantity) as total')
        ->groupBy('blood_group_id')
        ->get()
        ->map(function ($item) use ($targetLevels) {
            $bloodType = $item->bloodGroup->name;
            $target = $targetLevels[$bloodType] ?? 100;
            $status = $item->total < $target * 0.5 ? 'Critical' :
                     ($item->total < $target ? 'Low' : 'Adequate');

            return [
                'type' => $bloodType,
                'total' => $item->total,
                'target' => $target,
                'status' => $status,
            ];
        });

    // Add donors here, eager loading their details
    $donors = User::with('detail')->where('role', 'donor')->get();

    $pendingCount = BloodRequest::where('status', 'pending')->count();
    $partialCount = BloodRequest::where('status', 'partial')->count();
    $criticalCount = BloodRequest::where('urgency_level', 'critical')->count();

    $totalAlerts = $pendingCount + $partialCount + $criticalCount;

    $pendingRequests = BloodRequest::where('status', 'pending')->get();


    return view('admin.dashboard', compact(
        'totalRealUsers',
        'totalInstitutions',
        'totalUnits',
        'criticalTypes',
        'todaysDonations',
        'donationTarget',
        'inventoryData',
        'donors',
        'totalAlerts',
        'pendingRequests'
    ));
}

    /**
     * User Management with Filters, Search & Pagination
     */
    public function usersManagement()
    {
        $users = User::whereNotIn('role', ['admin', 'institution'])
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        $userDetails = UserDetail::whereIn('user_id', $users->pluck('id'))->get();
        $bloodGroups = BloodGroup::all();
        $institutions = Institution::all();

        return view('admin.users', compact('users', 'userDetails', 'bloodGroups', 'institutions'));
    }

    /**
     * Handle user update (Edit)
     */
    public function updateUser(Request $request, User $user)
    {
        $data = $request->validate([
            'first_name'     => 'required|string|max:50',
            'last_name'      => 'required|string|max:50',
            'email'          => 'required|email|unique:users,email,' . $user->id,
            'phone_number'   => 'nullable|string|max:20',
            'role'           => 'required|in:admin,doctor,nurse,staff,donor',
            'status'         => 'required|in:active,inactive,pending,suspended',
            'reset_password' => 'sometimes|boolean',
        ]);

        $user->update([
            'email'  => $data['email'],
            'role'   => $data['role'],
            'status' => $data['status'],
        ]);

        UserDetail::updateOrCreate(
            ['user_id' => $user->id],
            [
                'first_name'   => $data['first_name'],
                'last_name'    => $data['last_name'],
                'phone_number' => $data['phone_number'],
            ]
        );

        if ($request->boolean('reset_password')) {
            $newPass = Str::random(10);
            $user->update(['password' => Hash::make($newPass)]);
            // TODO: Notify user of password reset
        }

        return redirect()
            ->route('admin.users', $request->only(['search', 'role', 'status', 'page']))
            ->with('success', 'User updated successfully.');
    }

    /**
     * Institution List with Filters
     */
    public function institutions(Request $request)
    {
        $query = Institution::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $institutions = $query->orderBy('created_at', 'desc')
            ->paginate(5)
            ->appends($request->only(['search', 'type', 'status']));

        return view('admin.institutions', compact('institutions'));
    }

    /**
     * Donor List
     */
        /**
     * Donor List
     */
    public function donors()
    {
        // 1) Fetch paginated list
        $donors = Donor::orderBy('created_at', 'desc')
                       ->paginate(5);

        // 2) Calculate your stats
        $totalDonors = Donor::count();

        // Active donors: those who have at least one donation record
        $activeDonors = Donor::join('donations', 'donors.user_id', '=', 'donations.user_id')
                             ->distinct('donors.id')
                             ->count('donors.id');

        // 3) Additional stats: total donations count and blood collected (in liters)
        $totalDonations = Donation::count();
        $bloodCollectedL = Donation::sum('volume_ml') / 1000;

        $donors = Donor::with(['user', 'user.detail', 'donations'])->latest()->paginate(10);

    $institutions = Institution::all(); // 🔥 Add this line

        // 4) Pass ALL variables into the view
        return view('admin.donors', compact(
            'donors',
            'totalDonors',
            'activeDonors',
            'totalDonations',
            'bloodCollectedL',
            'institutions'
        ));
    }

    /**
     * Delete a user (and their details)
     */
    public function destroyUser(User $user)
    {
        $user->details()->delete();
        $user->delete();

        return redirect()
            ->route('admin.users')
            ->with('success', 'User deleted successfully.');
    }

    public function downloadInstitutionReport()
    {
         $institutions = Institution::withCount('donations')            ->withSum('donations', 'volume_ml')
            ->get();
        $pdf = PDF::loadView('admin.reports.institution_pdf', compact('institutions'));

        return $pdf->download('institution_donations_report_' . now()->format('Y-m-d') . '.pdf');
    }

    public function donorList()
{
    // Load all donors with their details eager loaded
    $donors = User::with('detail')->where('role', 'donor')->get();

    return view('admin.donors.list', compact('donors'));
}

}
