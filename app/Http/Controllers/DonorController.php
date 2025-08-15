<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDetail;
use App\Models\Donation;
use App\Models\Institution;
use App\Models\Inventory;
use App\Models\BloodGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DonorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display paginated list of donors who have at least one donation.
     */
    public function index()
    {
        $donors = User::whereHas('donations')
            ->with([
                'details',
                'donations' => fn($q) => $q->orderBy('donation_date', 'desc'),
            ])
            ->paginate(10);

        $institutions   = Institution::all();
        $totalDonors    = User::where('role', 'donor')->count();
        $activeDonors   = User::where('role', 'donor')->whereHas('donations')->count();
        $totalDonations = Donation::count();
        $totalVolumeMl  = Donation::sum('volume_ml');
        $bloodCollectedL = round($totalVolumeMl / 1000, 2);

        return view('admin.donors', compact(
            'donors',
            'institutions',
            'totalDonors',
            'activeDonors',
            'totalDonations',
            'bloodCollectedL'
        ));
    }

    /**
     * Show the “Add Donation” form (if it's a separate page).
     */
    public function addDonationPage()
    {
        $institutions = Institution::all();
        return view('admin.add_donor_info', compact('institutions'));
    }

    /**
     * AJAX search for donor info.
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
    
        $donor = UserDetail::with('user')
            ->where(function($q) use ($query) {
                $q->where('first_name', 'like', "%{$query}%")
                  ->orWhere('last_name', 'like', "%{$query}%")
                  ->orWhere('custom_id', 'like', "%{$query}%");
            })
            ->first();
    
        \Log::info('Donor search:', ['query' => $query, 'donor' => $donor]);
    
        if ($request->ajax()) {
            if ($donor && $donor->user) {
                return response()->json([
                    'success' => true,
                    'donor'   => [
                        'user_id'            => $donor->user->id,
                        'first_name'         => $donor->first_name,
                        'last_name'          => $donor->last_name,
                        'blood_type'         => $donor->blood_type,
                        'weight_lbs'         => $donor->weight_lbs,
                        'last_donation_date' => $donor->last_donation_date,
                    ],
                ]);
            }
            return response()->json(['success' => false]);
        }
    
        // fallback for non-AJAX (optional)
        return view('admin.donor', [
            'userDetails' => $donor ? [$donor] : [],
            'query'       => $query,
        ]);
    }
    



    /**
     * Persist a new Donation and update Inventory accordingly.
     */
    public function saveInfo(Request $request)
    {
        $validated = $request->validate([
            'user_id'        => 'required|exists:users,id',
            'volume_ml'      => 'required|numeric|min:1',
            'donation_date'  => 'required|date',
            'institution_id' => 'required|exists:institutions,id',
        ]);

        // 1) Save the donation record
        $donation = Donation::create([
            'user_id'        => $validated['user_id'],
            'volume_ml'      => $validated['volume_ml'],
            'donation_date'  => $validated['donation_date'],
            'institution_id' => $validated['institution_id'],
            'created_by'     => Auth::id(),
            'created_on'     => now(),
            'updated_by'     => Auth::id(),
            'updated_on'     => now(),
        ]);

        // 2) Find the donor’s blood_group_id via their Donor model
        $donor = $donation->user->donor; 
        if (! $donor || ! $donor->blood_group_id) {
            // Should never happen if your data is consistent
            return back()->withErrors('Cannot determine donor’s blood group.');
        }

        $bgId = $donor->blood_group_id;

        // 3) Calculate expiry date (35 days after donation)
        $expiryDate = Carbon::parse($validated['donation_date'])->addDays(35)->toDateString();

        // 4) Update or create the inventory entry
        $inventory = Inventory::firstOrNew([
            'institution_id' => $validated['institution_id'],
            'blood_group_id' => $bgId,
        ]);

        // increment quantity
        $inventory->quantity     = ($inventory->quantity ?? 0) + $validated['volume_ml'];
        $inventory->expiry_date  = $expiryDate;
        $inventory->updated_by   = Auth::id();
        $inventory->updated_on   = now();

        // if brand-new record, set created_by/on
        if (! $inventory->exists) {
            $inventory->created_by = Auth::id();
            $inventory->created_on = now();
        }

        $inventory->save();

        return redirect()
            ->route('admin.donors')
            ->with('success', 'Donation recorded and inventory updated!');
    }
}

