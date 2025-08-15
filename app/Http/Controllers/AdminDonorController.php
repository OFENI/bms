<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Donor;
use App\Models\Donation;
use App\Models\BloodGroup;
use App\Models\Institution;
use App\Models\Inventory;
use Carbon\Carbon;

class AdminDonorController extends Controller
{
    public function index()
    {
        $institutions = Institution::all();
        $totalDonors = User::where('role', 'donor')->count();
        $activeDonors = Donation::where('donation_date', '>=', Carbon::now()->subMonths(6))
                                ->distinct('user_id')
                                ->count('user_id');
        $totalDonations = Donation::count();
        $totalVolume = Donation::sum('volume_ml');
        $bloodCollectedL = round($totalVolume / 1000, 2);

        $donors = User::with('detail')
                    ->where('role', 'donor')
                    ->paginate(10);

        return view('admin.donors', compact(
            'institutions', 'totalDonors', 'activeDonors',
            'totalDonations', 'totalVolume', 'bloodCollectedL', 'donors'
        ));
    }

    public function createUserForm()
    {
        $institutions = Institution::all();
        $bloodGroups = BloodGroup::all();
        $users = User::with('detail')->paginate(10);

        return view('admin.users', compact('institutions', 'bloodGroups', 'users'));
    }

    public function storeUser(Request $request)
    {
        $minDob = Carbon::now()->subYears(17)->format('Y-m-d');

        $data = $request->validate([
            'first_name'       => 'required|string|max:255',
            'last_name'        => 'required|string|max:255',
            'email'            => 'required|email|unique:users,email',
            'phone_number'     => 'required|string|max:20',
            'address'          => 'nullable|string|max:255',
            'role'             => 'required|in:donor,doctor,nurse,staff',
            'blood_group_id'   => 'exclude_unless:role,donor|exists:blood_groups,id',
            'weight_lbs'       => 'exclude_unless:role,donor|numeric|min:30',
            'date_of_birth'    => "exclude_unless:role,donor|nullable|date|before_or_equal:{$minDob}",
            'last_donation_date' => 'nullable|date',
            'password'         => 'required|string|min:8|confirmed',
        ]);

        $generatedPassword = Str::random(10);
        $data['password'] = $generatedPassword;

        $user = User::create([
            'email'          => $data['email'],
            'password'       => Hash::make($data['password']),
            'role'           => $data['role'],
            'institution_id' => in_array($data['role'], ['doctor','nurse','staff'])
                                    ? $request->input('institution_id') : null,
            'created_by'     => Auth::id(),
            'created_on'     => now(),
            'updated_by'     => Auth::id(),
            'updated_on'     => now(),
        ]);

        $bloodType = null;
        if ($data['role'] === 'donor') {
            $name      = BloodGroup::find($data['blood_group_id'])->name;
            $bloodType = str_replace('−', '-', $name);
        }

        $user->detail()->create([
            'first_name'    => $data['first_name'],
            'last_name'     => $data['last_name'],
            'phone_number'  => $data['phone_number'],
            'address'       => $data['address'],
            'date_of_birth' => $data['role'] === 'donor' ? $data['date_of_birth'] : null,
            'blood_type'    => $bloodType,
            'weight_lbs'    => $data['role'] === 'donor' ? $data['weight_lbs'] : null,
            'created_by'    => Auth::id(),
            'created_on'    => now(),
            'updated_by'    => Auth::id(),
            'updated_on'    => now(),
        ]);

        if ($data['role'] === 'donor') {
            Donor::create([
                'user_id'            => $user->id,
                'institution_id'     => null,
                'blood_group_id'     => $data['blood_group_id'],
                'weight'             => $data['weight_lbs'],
                'last_donation_date' => $data['last_donation_date'] ?? null,
                'created_by'         => Auth::id(),
                'created_on'         => now(),
                'updated_by'         => Auth::id(),
                'updated_on'         => now(),
            ]);
        }

        return redirect()
            ->route('admin.users.index')
            ->with('success', ucfirst($data['role']) . ' created! Temporary password: ' . $generatedPassword);
    }

    public function showUsers()
    {
        $institutions = Institution::all();
        $bloodGroups = BloodGroup::all();
        $users = User::with('detail')->paginate(10);
        return view('admin.users', compact('institutions', 'bloodGroups', 'users'));
    }

    public function searchAjax(Request $request)
    {
        $q = trim($request->query('query'));
        if (!$q) {
            return response()->json(['success' => false, 'message' => 'Empty search.']);
        }
    
        $user = User::with('detail')
            ->where('role', 'donor')
            ->where(function ($query) use ($q) {
                $query->whereHas('detail', fn($q2) =>
                    $q2->where('first_name','like',"%{$q}%")
                       ->orWhere('last_name','like',"%{$q}%")
                )->orWhere('id',$q);
            })
            ->first();
    
        if (!$user || !$user->detail) {
            return response()->json(['success' => false, 'message' => 'No matching donor.']);
        }
    
        $lastDonation = $user->donations()->latest('donation_date')->first();
    
        // Fix: parse donation_date string to Carbon before format
        $lastDate = $lastDonation ? Carbon::parse($lastDonation->donation_date)->format('Y-m-d') : null;
    
        return response()->json([
            'success' => true,
            'donor'   => [
                'user_id'            => $user->id,
                'first_name'         => $user->detail->first_name,
                'last_name'          => $user->detail->last_name,
                'blood_type'         => $user->detail->blood_type,
                'weight_lbs'         => $user->detail->weight_lbs,
                'last_donation_date' => $lastDate,
            ],
        ]);
    }
    
    public function storeDonation(Request $request)
{
    $validated = $request->validate([
        'user_id'        => 'required|exists:users,id',
        'volume_ml'      => 'required|numeric|min:1',
        'donation_date'  => 'required|date',
        'institution_id' => 'required|exists:institutions,id',
        // Add this line to require blood_group_id
        'blood_group_id' => 'required|exists:blood_groups,id',
    ]);

    $donor = \App\Models\Donor::where('user_id', $validated['user_id'])->first();
    if (! $donor || ! $donor->blood_group_id) {
        return back()->withErrors('Cannot determine donor’s blood group.');
    }

    $bgId = $donor->blood_group_id;
    $expiryDate = Carbon::parse($validated['donation_date'])->addDays(35)->toDateString();

    $donation = Donation::create([
        'user_id'        => $validated['user_id'],
        'volume_ml'      => $validated['volume_ml'],
        'donation_date'  => $validated['donation_date'],
        'institution_id' => $validated['institution_id'],
        'blood_group_id' => $bgId, // Set blood_group_id from donor
        'created_by'     => Auth::id(),
        'created_on'     => now(),
        'updated_by'     => Auth::id(),
        'updated_on'     => now(),
    ]);

    // Update inventory
    $inventory = Inventory::firstOrNew([
        'institution_id' => $validated['institution_id'],
        'blood_group_id' => $bgId,
    ]);

    $inventory->quantity    = ($inventory->quantity ?? 0) + $validated['volume_ml'];
    $inventory->expiry_date = $expiryDate;
    $inventory->status      = $inventory->status ?? 'active';
    $inventory->updated_by  = Auth::id();
    $inventory->updated_on  = now();

    if (! $inventory->exists) {
        $inventory->created_by = Auth::id();
        $inventory->created_on = now();
    }

    $inventory->save();

    // ✅ Update donor eligibility (wait 56 days)
   // Update last_donation_date in donor table
$donor->last_donation_date = $validated['donation_date'];
$donor->updated_by = Auth::id();
$donor->updated_on = now();
$donor->save();

// Set eligibility to false after donation
$userDetail = UserDetail::where('user_id', $validated['user_id'])->first();
if ($userDetail) {
    $userDetail->is_eligible = false;
    $userDetail->updated_by = Auth::id();
    $userDetail->updated_on = now();
    $userDetail->save();
}


    return redirect()
        ->route('admin.donors.index')
        ->with('success', 'Donation recorded, inventory updated, and eligibility refreshed!');
}

}
