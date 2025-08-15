<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Donation;
use App\Models\Inventory;
use App\Models\BloodGroup;
use App\Models\BloodRequest;
use App\Models\Institution;
use App\Models\Disbursement;
use App\Models\Donor;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;

class HospitalReportController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $institution = $user->institution;
        
        if (!$institution) {
            return back()->with('error', 'No institution found for this user');
        }

        // Get filter parameters
        $dateRange = $request->get('date_range', 'last_30_days');
        $bloodType = $request->get('blood_type', 'all');
        $reportType = $request->get('report_type', 'summary');

        // Calculate date range
        $startDate = $this->getStartDate($dateRange);
        $endDate = Carbon::now();

        // Get institution-specific data
        $data = $this->getInstitutionReportData($institution, $startDate, $endDate, $bloodType, $reportType);

        return view('hospital.reports.index', compact('data', 'institution', 'dateRange', 'bloodType', 'reportType'));
    }

    public function exportPDF(Request $request)
    {
        $user = Auth::user();
        $institution = $user->institution;
        
        if (!$institution) {
            return back()->with('error', 'No institution found for this user');
        }

        $dateRange = $request->get('date_range', 'last_30_days');
        $bloodType = $request->get('blood_type', 'all');
        $reportType = $request->get('report_type', 'summary');

        $startDate = $this->getStartDate($dateRange);
        $endDate = Carbon::now();

        $data = $this->getInstitutionReportData($institution, $startDate, $endDate, $bloodType, $reportType);

        $pdf = PDF::loadView('hospital.reports.pdf.institution', compact('data', 'institution', 'dateRange', 'bloodType', 'reportType'));
        
        return $pdf->download($institution->name . '_institution_report_' . date('Y-m-d') . '.pdf');
    }

    public function exportCSV(Request $request)
    {
        $user = Auth::user();
        $institution = $user->institution;
        
        if (!$institution) {
            return back()->with('error', 'No institution found for this user');
        }

        $dateRange = $request->get('date_range', 'last_30_days');
        $bloodType = $request->get('blood_type', 'all');
        $reportType = $request->get('report_type', 'summary');

        $startDate = $this->getStartDate($dateRange);
        $endDate = Carbon::now();

        $data = $this->getInstitutionReportData($institution, $startDate, $endDate, $bloodType, $reportType);

        $filename = $institution->name . '_institution_report_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($data, $institution, $reportType) {
            $file = fopen('php://output', 'w');
            
            // Write CSV headers
            fputcsv($file, ['Institution Report - ' . $institution->name]);
            fputcsv($file, ['Generated on: ' . date('Y-m-d H:i:s')]);
            fputcsv($file, []);
            
            if ($reportType === 'summary') {
                $this->generateSummaryCSV($file, $data);
            } elseif ($reportType === 'detailed') {
                $this->generateDetailedCSV($file, $data);
            } elseif ($reportType === 'analytics') {
                $this->generateAnalyticsCSV($file, $data);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function getInstitutionReportData($institution, $startDate, $endDate, $bloodType, $reportType)
    {
        $data = [];

        // 1. Basic Institution Information
        $data['institution'] = [
            'name' => $institution->name,
            'email' => $institution->email,
            'contact_number' => $institution->contact_number,
            'region' => $institution->region,
            'address' => $institution->address,
            'country' => $institution->country,
            'opening_time' => $institution->opening_time,
            'closing_time' => $institution->closing_time,
            'operating_days' => $institution->operating_days,
            'auto_accept_transfers' => $institution->auto_accept_transfers,
        ];

        // 2. Blood Groups
        $bloodGroups = BloodGroup::orderBy('id')->get();
        $data['blood_groups'] = $bloodGroups;

        // 3. Current Inventory Levels
        $inventoryQuery = Inventory::where('institution_id', $institution->id);
        if ($bloodType !== 'all') {
            $bloodGroup = BloodGroup::where('name', $bloodType)->first();
            if ($bloodGroup) {
                $inventoryQuery->where('blood_group_id', $bloodGroup->id);
            }
        }
        
        $data['current_inventory'] = $inventoryQuery
            ->select('blood_group_id', DB::raw('SUM(quantity) as total'))
            ->groupBy('blood_group_id')
            ->get()
            ->keyBy('blood_group_id');

        // 4. Donations (with date filter)
        $donationsQuery = Donation::where('institution_id', $institution->id);
        if ($startDate) {
            $donationsQuery->whereBetween('donation_date', [$startDate, $endDate]);
        }
        if ($bloodType !== 'all') {
            $bloodGroup = BloodGroup::where('name', $bloodType)->first();
            if ($bloodGroup) {
                $donationsQuery->where('blood_group_id', $bloodGroup->id);
            }
        }

        $data['donations'] = [
            'total' => $donationsQuery->count(),
            'by_blood_type' => $donationsQuery
                ->select('blood_group_id', DB::raw('COUNT(*) as total'))
                ->groupBy('blood_group_id')
                ->get()
                ->keyBy('blood_group_id'),
            'monthly_trend' => $donationsQuery
                ->selectRaw('DATE_FORMAT(donation_date, "%Y-%m") as month, COUNT(*) as total')
                ->groupBy('month')
                ->orderBy('month', 'asc')
                ->get(),
        ];

        // 5. Blood Requests
        $requestsQuery = BloodRequest::where('requester_id', $institution->id);
        if ($startDate) {
            $requestsQuery->whereBetween('requested_date', [$startDate, $endDate]);
        }
        if ($bloodType !== 'all') {
            $bloodGroup = BloodGroup::where('name', $bloodType)->first();
            if ($bloodGroup) {
                $requestsQuery->where('blood_group_id', $bloodGroup->id);
            }
        }

        $data['blood_requests'] = [
            'total' => $requestsQuery->count(),
            'pending' => (clone $requestsQuery)->where('status', 'pending')->count(),
            'approved' => (clone $requestsQuery)->where('status', 'approved')->count(),
            'rejected' => (clone $requestsQuery)->where('status', 'denied')->count(),
            'by_blood_type' => (clone $requestsQuery)
                ->select('blood_group_id', DB::raw('COUNT(*) as total'))
                ->groupBy('blood_group_id')
                ->get()
                ->keyBy('blood_group_id'),
        ];

        // 6. Disbursements
        $disbursementsQuery = Disbursement::where('institution_id', $institution->id);
        if ($startDate) {
            $disbursementsQuery->whereBetween('disbursed_date', [$startDate, $endDate]);
        }
        if ($bloodType !== 'all') {
            $bloodGroup = BloodGroup::where('name', $bloodType)->first();
            if ($bloodGroup) {
                $disbursementsQuery->where('blood_group_id', $bloodGroup->id);
            }
        }

        $data['disbursements'] = [
            'total' => $disbursementsQuery->count(),
            'total_units' => $disbursementsQuery->sum('quantity'),
            'by_blood_type' => $disbursementsQuery
                ->select('blood_group_id', DB::raw('SUM(quantity) as total'))
                ->groupBy('blood_group_id')
                ->get()
                ->keyBy('blood_group_id'),
        ];

        // 7. Donor Statistics
        $donorIds = Donation::where('institution_id', $institution->id)
    ->pluck('user_id')
    ->unique();

$data['donors'] = [
    'total' => $donorIds->count(),
    'active' => $donorIds->count(),
   'by_blood_type' => \App\Models\UserDetail::whereIn('user_id', $donorIds)
    ->select('blood_type', DB::raw('COUNT(*) as total'))
    ->groupBy('blood_type')
    ->get()
    ->keyBy('blood_type'),

];

        // 8. Staff Statistics
        $staffQuery = User::where('institution_id', $institution->id);
        $data['staff'] = [
            'total' => $staffQuery->count(),
            'by_role' => $staffQuery
                ->select('role', DB::raw('COUNT(*) as total'))
                ->groupBy('role')
                ->get()
                ->keyBy('role'),
        ];

        // 9. Performance Metrics
        $data['performance'] = [
            'donation_rate' => $this->calculateDonationRate($institution->id, $startDate, $endDate),
            'fulfillment_rate' => $this->calculateFulfillmentRate($institution->id, $startDate, $endDate),
            'inventory_turnover' => $this->calculateInventoryTurnover($institution->id, $startDate, $endDate),
            'response_time' => $this->calculateAverageResponseTime($institution->id, $startDate, $endDate),
        ];

        // 10. Financial Summary (if applicable)
        $data['financial'] = [
            'total_donations_value' => $this->calculateDonationsValue($institution->id, $startDate, $endDate),
            'total_disbursements_value' => $this->calculateDisbursementsValue($institution->id, $startDate, $endDate),
        ];

        return $data;
    }

    private function getStartDate($dateRange)
    {
        switch ($dateRange) {
            case 'last_7_days':
                return Carbon::now()->subDays(7);
            case 'last_30_days':
                return Carbon::now()->subDays(30);
            case 'last_90_days':
                return Carbon::now()->subDays(90);
            case 'last_6_months':
                return Carbon::now()->subMonths(6);
            case 'last_year':
                return Carbon::now()->subYear();
            case 'this_month':
                return Carbon::now()->startOfMonth();
            case 'this_year':
                return Carbon::now()->startOfYear();
            default:
                return Carbon::now()->subDays(30);
        }
    }

    private function calculateDonationRate($institutionId, $startDate, $endDate)
    {
        $totalDonations = Donation::where('institution_id', $institutionId)
            ->whereBetween('donation_date', [$startDate, $endDate])
            ->count();
        
        $days = $endDate->diffInDays($startDate);
        
        return $days > 0 ? round($totalDonations / $days, 2) : 0;
    }

    private function calculateFulfillmentRate($institutionId, $startDate, $endDate)
    {
        $totalRequests = BloodRequest::where('requester_id', $institutionId)
            ->whereBetween('requested_date', [$startDate, $endDate])
            ->count();
        
        $fulfilledRequests = BloodRequest::where('requester_id', $institutionId)
            ->whereBetween('requested_date', [$startDate, $endDate])
            ->where('status', 'approved')
            ->count();
        
        return $totalRequests > 0 ? round(($fulfilledRequests / $totalRequests) * 100, 2) : 0;
    }

    private function calculateInventoryTurnover($institutionId, $startDate, $endDate)
    {
        $averageInventory = Inventory::where('institution_id', $institutionId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->avg('quantity') ?? 0;
        
        $totalDisbursements = Disbursement::where('institution_id', $institutionId)
            ->whereBetween('disbursed_date', [$startDate, $endDate])
            ->sum('quantity');
        
        return $averageInventory > 0 ? round($totalDisbursements / $averageInventory, 2) : 0;
    }

    private function calculateAverageResponseTime($institutionId, $startDate, $endDate)
    {
        $requests = BloodRequest::where('requester_id', $institutionId)
            ->whereBetween('requested_date', [$startDate, $endDate])
            ->whereNotNull('fulfilled_date')
            ->get();
        
        if ($requests->isEmpty()) {
            return 0;
        }
        
        $totalResponseTime = 0;
        foreach ($requests as $request) {
            $totalResponseTime += Carbon::parse($request->requested_date)
                ->diffInHours(Carbon::parse($request->fulfilled_date));
        }
        
        return round($totalResponseTime / $requests->count(), 2);
    }

    private function calculateDonationsValue($institutionId, $startDate, $endDate)
    {
        // Assuming average value per donation unit (using volume_ml instead of quantity)
        $totalVolume = Donation::where('institution_id', $institutionId)
            ->whereBetween('donation_date', [$startDate, $endDate])
            ->sum('volume_ml');
        
        // Convert ml to units (assuming 450ml = 1 unit)
        $totalUnits = $totalVolume / 450;
        return $totalUnits * 50; // $50 per unit (adjust as needed)
    }

    private function calculateDisbursementsValue($institutionId, $startDate, $endDate)
    {
        // Assuming average value per disbursement unit
        $totalUnits = Disbursement::where('institution_id', $institutionId)
            ->whereBetween('disbursed_date', [$startDate, $endDate])
            ->sum('quantity');
        
        return $totalUnits * 60; // $60 per unit (adjust as needed)
    }

    private function generateSummaryCSV($file, $data)
    {
        fputcsv($file, ['Institution Summary Report']);
        fputcsv($file, ['Name', $data['institution']['name']]);
        fputcsv($file, ['Email', $data['institution']['email']]);
        fputcsv($file, ['Contact', $data['institution']['contact_number']]);
        fputcsv($file, ['Region', $data['institution']['region']]);
        fputcsv($file, []);
        
        fputcsv($file, ['Donations', $data['donations']['total']]);
        fputcsv($file, ['Blood Requests', $data['blood_requests']['total']]);
        fputcsv($file, ['Disbursements', $data['disbursements']['total']]);
        fputcsv($file, ['Donors', $data['donors']['total']]);
        fputcsv($file, ['Staff', $data['staff']['total']]);
        fputcsv($file, []);
        
        fputcsv($file, ['Performance Metrics']);
        fputcsv($file, ['Donation Rate (per day)', $data['performance']['donation_rate']]);
        fputcsv($file, ['Fulfillment Rate (%)', $data['performance']['fulfillment_rate']]);
        fputcsv($file, ['Inventory Turnover', $data['performance']['inventory_turnover']]);
        fputcsv($file, ['Average Response Time (hours)', $data['performance']['response_time']]);
    }

    private function generateDetailedCSV($file, $data)
    {
        fputcsv($file, ['Detailed Institution Report']);
        fputcsv($file, []);
        
        // Blood type breakdown
        fputcsv($file, ['Blood Type Breakdown']);
        fputcsv($file, ['Blood Type', 'Donations', 'Requests', 'Disbursements', 'Current Inventory']);
        
        foreach ($data['blood_groups'] as $bloodGroup) {
            $donations = $data['donations']['by_blood_type'][$bloodGroup->id]->total ?? 0;
            $requests = $data['blood_requests']['by_blood_type'][$bloodGroup->id]->total ?? 0;
            $disbursements = $data['disbursements']['by_blood_type'][$bloodGroup->id]->total ?? 0;
            $inventory = $data['current_inventory'][$bloodGroup->id]->total ?? 0;
            
            fputcsv($file, [$bloodGroup->name, $donations, $requests, $disbursements, $inventory]);
        }
    }

    private function generateAnalyticsCSV($file, $data)
    {
        fputcsv($file, ['Analytics Report']);
        fputcsv($file, []);
        
        // Monthly trends
        fputcsv($file, ['Monthly Donation Trends']);
        fputcsv($file, ['Month', 'Donations']);
        
        foreach ($data['donations']['monthly_trend'] as $trend) {
            fputcsv($file, [$trend->month, $trend->total]);
        }
        
        fputcsv($file, []);
        
        // Staff breakdown
        fputcsv($file, ['Staff by Role']);
        fputcsv($file, ['Role', 'Count']);
        
        foreach ($data['staff']['by_role'] as $role => $count) {
            fputcsv($file, [ucfirst($role), $count->total]);
        }
    }
}
