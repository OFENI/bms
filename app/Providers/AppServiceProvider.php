<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Inventory;
use App\Models\BloodRequest;
use App\Models\Disbursement;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Global notification data for admin views
        View::composer('admin.*', function ($view) {
            if ($user = Auth::user()) {
                if ($user->role === 'admin') {
                    $criticalThreshold = 5;
                    $today = Carbon::today();
                    $soon = Carbon::today()->addDays(7);

                    // Low stock alerts
                    $lowStocks = Inventory::select('institution_id', 'blood_group_id', \DB::raw('SUM(quantity) as total_quantity'))
                        ->groupBy('institution_id', 'blood_group_id')
                        ->having('total_quantity', '<', $criticalThreshold)
                        ->with(['institution', 'bloodGroup'])
                        ->get();

                    $lowStockNotifications = $lowStocks->map(function($item) {
                        return [
                            'type' => 'low_stock',
                            'message' => "Low stock alert: Blood Group {$item->bloodGroup->name} is low at {$item->institution->name}",
                            'link' => route('admin.inventory.index') // Adjust if you have a low stock filter page
                        ];
                    });

                    // Expiring soon or expired blood units
                    $expiringUnits = Inventory::whereDate('expiry_date', '<=', $soon)
                        ->where('quantity', '>', 0)
                        ->with(['institution', 'bloodGroup'])
                        ->get();

                    $expiryNotifications = $expiringUnits->map(function($item) use ($today) {
                        $expiryDate = Carbon::parse($item->expiry_date);
                        $diffDays = $expiryDate->diffInDays($today, false);

                        if ($diffDays < 0) {
                            $msg = "Expired blood alert: Blood Group {$item->bloodGroup->name} at {$item->institution->name} expired on {$expiryDate->format('d M Y')}";
                        } else {
                            $msg = "Expiring soon: Blood Group {$item->bloodGroup->name} at {$item->institution->name} will expire on {$expiryDate->format('d M Y')}";
                        }

                        return [
                            'type' => 'expiry',
                            'message' => $msg,
                            'link' => route('admin.inventory.index') // Adjust if you have an expiry filter page
                        ];
                    });

                    // Blood requests pending/partial/critical
                    $pendingRequests = BloodRequest::whereIn('status', ['pending', 'partial', 'critical'])
                        ->with(['requestedFrom', 'requestedTo'])
                        ->get();

                    $bloodRequestNotifications = $pendingRequests->map(function($request) {
                        $requesterName = $request->requestedFrom ? $request->requestedFrom->name : 'Unknown Institution';
                        $requestedToName = $request->requestedTo ? $request->requestedTo->name : 'Unknown Institution';
                        
                        return [
                            'type' => 'blood_request',
                            'message' => "Blood request: {$requesterName} requested blood from {$requestedToName}",
                            'link' => route('admin.dashboard')
                        ];
                    });

                    // Recent disbursements in last 7 days
                    $recentDisbursements = Disbursement::where('status', 'completed')
                        ->whereDate('disbursed_date', '>=', now()->subDays(7))
                        ->with(['fromInstitution'])
                        ->get();

                    $disbursementNotifications = $recentDisbursements->map(function($disbursement) {
                        $institutionName = $disbursement->fromInstitution ? $disbursement->fromInstitution->name : 'Unknown Institution';
                        
                        return [
                            'type' => 'disbursement',
                            'message' => "Blood disbursed: {$institutionName} processed a disbursement",
                            'link' => route('admin.disbursements')
                        ];
                    });

                    // Combine all notifications
                    $notifications = $lowStockNotifications
                        ->concat($expiryNotifications)
                        ->concat($bloodRequestNotifications)
                        ->concat($disbursementNotifications)
                        ->values();

                    $totalAlerts = $notifications->count();

                    $view->with(compact('notifications', 'totalAlerts'));
                } else {
                    // For non-admin users no notifications or empty
                    $view->with([
                        'notifications' => collect(),
                        'totalAlerts' => 0,
                    ]);
                }
            } else {
                // For guests no notifications or empty
                $view->with([
                    'notifications' => collect(),
                    'totalAlerts' => 0,
                ]);
            }
        });
    }
}
