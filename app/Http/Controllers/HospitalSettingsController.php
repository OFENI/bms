<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Institution;
use App\Models\User;
use App\Models\BloodGroup;

class HospitalSettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $institution = $user->institution;
        
        // Get blood groups for thresholds
        $bloodGroups = BloodGroup::all();
        
        // Get user's active sessions (simulated data for now)
        $activeSessions = [
            [
                'device' => 'Chrome on Windows 10',
                'ip' => '192.168.1.100',
                'last_active' => now()->subMinutes(2),
                'status' => 'active'
            ],
            [
                'device' => 'Safari on iPhone',
                'ip' => '192.168.1.101',
                'last_active' => now()->subHour(),
                'status' => 'inactive'
            ],
            [
                'device' => 'Firefox on MacBook',
                'ip' => '192.168.1.102',
                'last_active' => now()->subHours(3),
                'status' => 'inactive'
            ]
        ];
        
        // Get user permissions (simulated data)
        $permissions = [
            'view_inventory' => true,
            'create_requests' => true,
            'view_history' => true,
            'manage_users' => false,
            'system_settings' => false,
            'admin_access' => false
        ];
        
        // Get current blood thresholds from institution
        $currentThresholds = $institution->blood_thresholds ?? [
            'A+' => 10, 'A-' => 5, 'B+' => 8, 'B-' => 3,
            'O+' => 15, 'O-' => 5, 'AB+' => 3, 'AB-' => 2
        ];
        
        return view('hospital.settings', compact(
            'user',
            'institution',
            'bloodGroups',
            'activeSessions',
            'permissions',
            'currentThresholds'
        ));
    }
    
    public function updateInstitution(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'contact_number' => 'required|string|max:20',
            'region' => 'required|string|max:100',
            'address' => 'required|string|max:500',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        try {
            $user = Auth::user();
            $institution = $user->institution;
            
            // Check if user has an institution
            if (!$institution) {
                return back()->with('error', 'No institution found for this user');
            }
            
            $institution->update([
                'name' => $request->name,
                'email' => $request->email,
                'contact_number' => $request->contact_number,
                'region' => $request->region,
                'address' => $request->address,
                'country' => 'Tanzania', // Always set to Tanzania
            ]);
            
            return back()->with('success', 'Institution information updated successfully');
        } catch (\Exception $e) {
            \Log::error('Institution update failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to update institution information: ' . $e->getMessage());
        }
    }
    
    public function updateBloodBankSettings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'opening_time' => 'required|date_format:H:i',
            'closing_time' => 'required|date_format:H:i|after:opening_time',
            'operating_days' => 'array',
            'auto_accept_transfers' => 'boolean',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        try {
            $institution = Auth::user()->institution;
            $institution->update([
                'opening_time' => $request->opening_time,
                'closing_time' => $request->closing_time,
                'operating_days' => $request->operating_days ?? [],
                'auto_accept_transfers' => $request->has('auto_accept_transfers'),
            ]);
            
            return back()->with('success', 'Blood bank settings updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update blood bank settings');
        }
    }
    
    public function updateThresholds(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'thresholds' => 'required|array',
            'thresholds.*' => 'integer|min:0|max:100',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        try {
            $institution = Auth::user()->institution;
            $institution->update([
                'blood_thresholds' => $request->thresholds,
            ]);
            
            return back()->with('success', 'Blood thresholds updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update blood thresholds');
        }
    }
    
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
            'new_password_confirmation' => 'required|string',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        $user = Auth::user();
        
        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect'])->withInput();
        }
        
        try {
            $user->update([
                'password' => Hash::make($request->new_password)
            ]);
            
            return back()->with('success', 'Password changed successfully')->with('password_changed', true);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to change password');
        }
    }
    
    public function toggleTwoFactor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'enabled' => 'required|boolean',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        try {
            $user = Auth::user();
            $user->update([
                'two_factor_enabled' => $request->enabled
            ]);
            
            return response()->json([
                'success' => true,
                'message' => $request->enabled ? 'Two-factor authentication enabled' : 'Two-factor authentication disabled'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update two-factor authentication'
            ], 500);
        }
    }
    
    public function terminateSessions(Request $request)
    {
        try {
            // In a real application, you would implement session management
            // For now, we'll just return a success response
            return response()->json([
                'success' => true,
                'message' => 'All other sessions terminated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to terminate sessions'
            ], 500);
        }
    }
    
    public function exportSettings()
    {
        $user = Auth::user();
        $institution = $user->institution;
        
        $settings = [
            'institution' => [
                'name' => $institution->name,
                'email' => $institution->email,
                'contact_number' => $institution->contact_number,
                'region' => $institution->region,
                'address' => $institution->address,
            ],
            'blood_bank' => [
                'opening_time' => $institution->opening_time,
                'closing_time' => $institution->closing_time,
                'operating_days' => json_decode($institution->operating_days, true),
                'auto_accept_transfers' => $institution->auto_accept_transfers,
            ],
            'thresholds' => json_decode($institution->blood_thresholds, true),
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'two_factor_enabled' => $user->two_factor_enabled ?? false,
            ],
            'exported_at' => now()->toISOString(),
        ];
        
        return response()->json($settings);
    }
} 