<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\Inventory;
use App\Models\BloodGroup;
use App\Models\BloodRequest;
use App\Models\Institution;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        try {
            $now = Carbon::now();

            // Get filter parameters
            $dateRange = $request->get('date_range', 'last_30_days');
            $bloodType = $request->get('blood_type', 'all');
            $location = $request->get('location', 'all');
            $reportType = $request->get('report_type', 'summary');

            // Calculate date range based on filter
            $startDate = $this->getStartDate($dateRange);
            $endDate = $now;

            // Base query for donations with filters
            $donationsQuery = Donation::query();
            if ($startDate) {
                $donationsQuery->whereBetween('donation_date', [$startDate, $endDate]);
            }
            if ($bloodType !== 'all') {
                $bloodGroup = BloodGroup::where('name', $bloodType)->first();
                if ($bloodGroup) {
                    $donationsQuery->where('blood_group_id', $bloodGroup->id);
                }
            }
            if ($location !== 'all') {
                $institution = Institution::where('name', $location)->first();
                if ($institution) {
                    $donationsQuery->where('institution_id', $institution->id);
                }
            }

            // 1. Blood Types and Labels
            $bloodTypes = BloodGroup::orderBy('id')->pluck('name', 'id')->toArray();
            $bloodLabels = BloodGroup::orderBy('id')->pluck('name')->toArray();

            // 2. Donations by blood type (with filters)
            $donationsByBloodType = (clone $donationsQuery)
                ->select('blood_group_id', DB::raw('COUNT(*) as total'))
                ->groupBy('blood_group_id')
                ->pluck('total', 'blood_group_id')
                ->toArray();

            // 3. Inventory by blood type (with blood type filter)
            $inventoryQuery = Inventory::query();
            if ($bloodType !== 'all') {
                $bloodGroup = BloodGroup::where('name', $bloodType)->first();
                if ($bloodGroup) {
                    $inventoryQuery->where('blood_group_id', $bloodGroup->id);
                }
            }
            $inventoryByBloodType = $inventoryQuery
                ->select('blood_group_id', DB::raw('SUM(quantity) as total'))
                ->groupBy('blood_group_id')
                ->pluck('total', 'blood_group_id')
                ->toArray();

            // 4. Demand by blood type (with blood type filter)
            $demandQuery = BloodRequest::query();
            if ($bloodType !== 'all') {
                $bloodGroup = BloodGroup::where('name', $bloodType)->first();
                if ($bloodGroup) {
                    $demandQuery->where('blood_group_id', $bloodGroup->id);
                }
            }
            $demandByBloodType = $demandQuery
                ->select('blood_group_id', DB::raw('SUM(quantity) as total'))
                ->groupBy('blood_group_id')
                ->pluck('total', 'blood_group_id')
                ->toArray();

            // 5. Monthly donation trends (with filters)
            $monthlyDonationsQuery = (clone $donationsQuery);
            $monthlyDonations = $monthlyDonationsQuery
                ->selectRaw('DATE_FORMAT(donation_date, "%Y-%m") as month, COUNT(*) as total')
                ->groupBy('month')
                ->orderBy('month', 'asc')
                ->get();

            $months = $monthlyDonations->pluck('month');
            $donationCounts = $monthlyDonations->pluck('total');

            // 6. Donor Demographics (Age only) - with date filter
            $userDOBsQuery = DB::table('user_details')
                ->join('donations', 'user_details.user_id', '=', 'donations.user_id')
                ->whereNotNull('user_details.date_of_birth');
            
            if ($startDate) {
                $userDOBsQuery->whereBetween('donations.donation_date', [$startDate, $endDate]);
            }
            if ($bloodType !== 'all') {
                $bloodGroup = BloodGroup::where('name', $bloodType)->first();
                if ($bloodGroup) {
                    $userDOBsQuery->where('donations.blood_group_id', $bloodGroup->id);
                }
            }
            if ($location !== 'all') {
                $institution = Institution::where('name', $location)->first();
                if ($institution) {
                    $userDOBsQuery->where('donations.institution_id', $institution->id);
                }
            }

            $userDOBs = $userDOBsQuery->pluck('user_details.date_of_birth');

            $ageGroups = [
                'Under 18' => 0,
                '18-25' => 0,
                '26-35' => 0,
                '36-45' => 0,
                '46-60' => 0,
                'Above 60' => 0,
            ];

            foreach ($userDOBs as $dob) {
                $age = Carbon::parse($dob)->age;

                if ($age < 18) $ageGroups['Under 18']++;
                elseif ($age <= 25) $ageGroups['18-25']++;
                elseif ($age <= 35) $ageGroups['26-35']++;
                elseif ($age <= 45) $ageGroups['36-45']++;
                elseif ($age <= 60) $ageGroups['46-60']++;
                else $ageGroups['Above 60']++;
            }

            // 7. Inventory levels (with date and blood type filters)
            $inventoryLevelsQuery = Inventory::query();
            if ($startDate) {
                $inventoryLevelsQuery->where('created_at', '>=', $startDate);
            }
            if ($bloodType !== 'all') {
                $bloodGroup = BloodGroup::where('name', $bloodType)->first();
                if ($bloodGroup) {
                    $inventoryLevelsQuery->where('blood_group_id', $bloodGroup->id);
                }
            }
            $inventoryLevels = $inventoryLevelsQuery
                ->selectRaw('DATE(created_at) as date, SUM(quantity) as total')
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            $inventoryDates = $inventoryLevels->pluck('date');
            $inventoryTotals = $inventoryLevels->pluck('total');

            // 8. Center performance (with filters)
            $centerPerformanceQuery = (clone $donationsQuery);
            $centerPerformance = $centerPerformanceQuery
                ->select('institution_id', DB::raw('COUNT(*) as total'))
                ->groupBy('institution_id')
                ->orderByDesc('total')
                ->get();

            $centerNames = [];
            $centerTotals = [];

            foreach ($centerPerformance as $row) {
                $institution = Institution::find($row->institution_id);
                $centerNames[] = $institution?->name ?? 'Unknown';
                $centerTotals[] = $row->total;
            }

            // 9. Demand Forecast (Static or later dynamic)
            $forecastLabels = ['Next 30 Days', 'Next 90 Days', 'Seasonal Trends'];
            $forecastData = [120, 350, 250];

            // 10. Summary Insights (with filters)

            // Last 30 days donations (with filters)
            $last30DaysQuery = (clone $donationsQuery);
            $last30DaysTotal = $last30DaysQuery
                ->where('donation_date', '>=', $now->copy()->subDays(30))
                ->count();

            // Previous month donations (with filters)
            $previousMonthQuery = (clone $donationsQuery);
            $previousMonthTotal = $previousMonthQuery
                ->whereBetween('donation_date', [
                    $now->copy()->subDays(60),
                    $now->copy()->subDays(31)
                ])
                ->count();

            $donationGrowth = $previousMonthTotal > 0
                ? round((($last30DaysTotal - $previousMonthTotal) / $previousMonthTotal) * 100, 1)
                : 0;

            // Most donated blood group (with filters)
            $donationCountsGroupedQuery = (clone $donationsQuery);
            $donationCountsGrouped = $donationCountsGroupedQuery
                ->select('blood_group_id', DB::raw('COUNT(*) as total'))
                ->groupBy('blood_group_id')
                ->orderByDesc('total')
                ->pluck('total', 'blood_group_id');

            $mostDonatedBloodGroupId = $donationCountsGrouped->keys()->first();
            $mostDonatedBloodGroup = BloodGroup::find($mostDonatedBloodGroupId)?->name ?? 'N/A';
            $mostDonatedPercentage = $donationCountsGrouped->sum() > 0
                ? round(($donationCountsGrouped[$mostDonatedBloodGroupId] / $donationCountsGrouped->sum()) * 100, 1)
                : 0;

            // Critical blood levels (<5 units) - with blood type filter
            $criticalBloodQuery = Inventory::query();
            if ($bloodType !== 'all') {
                $bloodGroup = BloodGroup::where('name', $bloodType)->first();
                if ($bloodGroup) {
                    $criticalBloodQuery->where('blood_group_id', $bloodGroup->id);
                }
            }
            $criticalBlood = $criticalBloodQuery
                ->select('blood_group_id')
                ->groupBy('blood_group_id')
                ->havingRaw('SUM(quantity) < 5')
                ->pluck('blood_group_id');

            $criticalBloodNames = BloodGroup::whereIn('id', $criticalBlood)->pluck('name')->toArray();

            // Top center (with filters)
            $topCenterQuery = (clone $donationsQuery);
            $topCenter = $topCenterQuery
                ->select('institution_id', DB::raw('COUNT(*) as total'))
                ->groupBy('institution_id')
                ->orderByDesc('total')
                ->first();

            $topCenterName = $topCenter
                ? Institution::find($topCenter->institution_id)?->name ?? 'Unknown'
                : 'None';

            $topCenterDonations = $topCenter->total ?? 0;

            // Create properly mapped arrays for charts
            $mappedDonationsByBloodType = [];
            $mappedInventoryByBloodType = [];
            $mappedDemandByBloodType = [];
            
            foreach ($bloodLabels as $label) {
                $bloodGroup = BloodGroup::where('name', $label)->first();
                $bloodGroupId = $bloodGroup ? $bloodGroup->id : null;
                
                $mappedDonationsByBloodType[] = $bloodGroupId ? ($donationsByBloodType[$bloodGroupId] ?? 0) : 0;
                $mappedInventoryByBloodType[] = $bloodGroupId ? ($inventoryByBloodType[$bloodGroupId] ?? 0) : 0;
                $mappedDemandByBloodType[] = $bloodGroupId ? ($demandByBloodType[$bloodGroupId] ?? 0) : 0;
            }

            // Get available institutions for filter dropdown
            $institutions = Institution::orderBy('name')->pluck('name')->toArray();

            // Send data to view
            return view('admin.reports', compact(
                'bloodTypes',
                'donationsByBloodType',
                'inventoryByBloodType',
                'demandByBloodType',
                'mappedDonationsByBloodType',
                'mappedInventoryByBloodType',
                'mappedDemandByBloodType',
                'months',
                'donationCounts',
                'ageGroups',
                'inventoryDates',
                'inventoryTotals',
                'centerNames',
                'centerTotals',
                'forecastLabels',
                'forecastData',
                'last30DaysTotal',
                'donationGrowth',
                'mostDonatedBloodGroup',
                'mostDonatedPercentage',
                'criticalBloodNames',
                'topCenterName',
                'topCenterDonations',
                'bloodLabels',
                'institutions',
                'dateRange',
                'bloodType',
                'location',
                'reportType'
            ));
        } catch (\Exception $e) {
            // Log the error and return a simple error view
            \Log::error('Error in ReportController: ' . $e->getMessage());
            return view('admin.reports', [
                'error' => 'An error occurred while loading the reports. Please try again.',
                'bloodTypes' => [],
                'donationsByBloodType' => [],
                'inventoryByBloodType' => [],
                'demandByBloodType' => [],
                'months' => [],
                'donationCounts' => [],
                'ageGroups' => [],
                'inventoryDates' => [],
                'inventoryTotals' => [],
                'centerNames' => [],
                'centerTotals' => [],
                'forecastLabels' => [],
                'forecastData' => [],
                'last30DaysTotal' => 0,
                'donationGrowth' => 0,
                'mostDonatedBloodGroup' => 'N/A',
                'mostDonatedPercentage' => 0,
                'criticalBloodNames' => [],
                'topCenterName' => 'None',
                'topCenterDonations' => 0,
                'bloodLabels' => [],
                'institutions' => [],
                'dateRange' => 'last_30_days',
                'bloodType' => 'all',
                'location' => 'all',
                'reportType' => 'summary'
            ]);
        }
    }

    /**
     * Calculate start date based on date range filter
     */
    private function getStartDate($dateRange)
    {
        $now = Carbon::now();
        
        switch ($dateRange) {
            case 'last_7_days':
                return $now->copy()->subDays(7);
            case 'last_30_days':
                return $now->copy()->subDays(30);
            case 'last_90_days':
                return $now->copy()->subDays(90);
            case 'year_to_date':
                return $now->copy()->startOfYear();
            case 'custom_range':
                // For custom range, we'll need to implement date picker functionality
                // For now, return null to show all data
                return null;
            default:
                return $now->copy()->subDays(30); // Default to last 30 days
        }
    }

    public function exportPDF(Request $request)
    {
        try {
            $now = Carbon::now();
            $reportType = $request->get('type', 'comprehensive');

            // Get filter parameters
            $dateRange = $request->get('date_range', 'last_30_days');
            $bloodType = $request->get('blood_type', 'all');
            $location = $request->get('location', 'all');
            $reportTypeFilter = $request->get('report_type', 'summary');

            // Get all the data needed for the report with filters
            $data = $this->getReportData($dateRange, $bloodType, $location, $reportTypeFilter);

            // Generate PDF based on report type
            switch ($reportType) {
                case 'donations':
                    $pdf = PDF::loadView('admin.reports.pdf.donations', $data);
                    $filename = 'donations_report_' . $now->format('Y-m-d') . '.pdf';
                    break;
                case 'inventory':
                    $pdf = PDF::loadView('admin.reports.pdf.inventory', $data);
                    $filename = 'inventory_report_' . $now->format('Y-m-d') . '.pdf';
                    break;
                case 'analytics':
                    $pdf = PDF::loadView('admin.reports.pdf.analytics', $data);
                    $filename = 'analytics_report_' . $now->format('Y-m-d') . '.pdf';
                    break;
                default:
                    $pdf = PDF::loadView('admin.reports.pdf.comprehensive', $data);
                    $filename = 'comprehensive_report_' . $now->format('Y-m-d') . '.pdf';
                    break;
            }

            return $pdf->download($filename);

        } catch (\Exception $e) {
            \Log::error('Error generating PDF report: ' . $e->getMessage());
            return back()->with('error', 'Failed to generate PDF report. Please try again.');
        }
    }

    public function exportCSV(Request $request)
    {
        try {
            $now = Carbon::now();
            $reportType = $request->get('type', 'comprehensive');

            // Get filter parameters
            $dateRange = $request->get('date_range', 'last_30_days');
            $bloodType = $request->get('blood_type', 'all');
            $location = $request->get('location', 'all');
            $reportTypeFilter = $request->get('report_type', 'summary');

            $data = $this->getReportData($dateRange, $bloodType, $location, $reportTypeFilter);
            $filename = $reportType . '_report_' . $now->format('Y-m-d') . '.csv';

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            $callback = function() use ($data, $reportType) {
                $file = fopen('php://output', 'w');

                switch ($reportType) {
                    case 'donations':
                        $this->generateDonationsCSV($file, $data);
                        break;
                    case 'inventory':
                        $this->generateInventoryCSV($file, $data);
                        break;
                    case 'analytics':
                        $this->generateAnalyticsCSV($file, $data);
                        break;
                    default:
                        $this->generateComprehensiveCSV($file, $data);
                        break;
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);

        } catch (\Exception $e) {
            \Log::error('Error generating CSV report: ' . $e->getMessage());
            return back()->with('error', 'Failed to generate CSV report. Please try again.');
        }
    }

    private function getReportData($dateRange = 'last_30_days', $bloodType = 'all', $location = 'all', $reportType = 'summary')
    {
        $now = Carbon::now();

        // Calculate date range based on filter
        $startDate = $this->getStartDate($dateRange);
        $endDate = $now;

        // Base query for donations with filters
        $donationsQuery = Donation::query();
        if ($startDate) {
            $donationsQuery->whereBetween('donation_date', [$startDate, $endDate]);
        }
        if ($bloodType !== 'all') {
            $bloodGroup = BloodGroup::where('name', $bloodType)->first();
            if ($bloodGroup) {
                $donationsQuery->where('blood_group_id', $bloodGroup->id);
            }
        }
        if ($location !== 'all') {
            $institution = Institution::where('name', $location)->first();
            if ($institution) {
                $donationsQuery->where('institution_id', $institution->id);
            }
        }

        // Get all the data needed for reports with filters
        $bloodLabels = BloodGroup::orderBy('id')->pluck('name')->toArray();
        
        // Donations by blood type (with filters)
        $donationsByBloodType = (clone $donationsQuery)
            ->select('blood_group_id', DB::raw('COUNT(*) as total'))
            ->groupBy('blood_group_id')
            ->pluck('total', 'blood_group_id')
            ->toArray();

        // Inventory by blood type (with blood type filter)
        $inventoryQuery = Inventory::query();
        if ($bloodType !== 'all') {
            $bloodGroup = BloodGroup::where('name', $bloodType)->first();
            if ($bloodGroup) {
                $inventoryQuery->where('blood_group_id', $bloodGroup->id);
            }
        }
        $inventoryByBloodType = $inventoryQuery
            ->select('blood_group_id', DB::raw('SUM(quantity) as total'))
            ->groupBy('blood_group_id')
            ->pluck('total', 'blood_group_id')
            ->toArray();

        // Demand by blood type (with blood type filter)
        $demandQuery = BloodRequest::query();
        if ($bloodType !== 'all') {
            $bloodGroup = BloodGroup::where('name', $bloodType)->first();
            if ($bloodGroup) {
                $demandQuery->where('blood_group_id', $bloodGroup->id);
            }
        }
        $demandByBloodType = $demandQuery
            ->select('blood_group_id', DB::raw('SUM(quantity) as total'))
            ->groupBy('blood_group_id')
            ->pluck('total', 'blood_group_id')
            ->toArray();

        // Monthly trends (with filters)
        $monthlyDonationsQuery = (clone $donationsQuery);
        $monthlyDonations = $monthlyDonationsQuery
            ->selectRaw('DATE_FORMAT(donation_date, "%Y-%m") as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        // Center performance (with filters)
        $centerPerformanceQuery = (clone $donationsQuery);
        $centerPerformance = $centerPerformanceQuery
            ->select('institution_id', DB::raw('COUNT(*) as total'))
            ->groupBy('institution_id')
            ->orderByDesc('total')
            ->get();

        $centerData = [];
        foreach ($centerPerformance as $row) {
            $institution = Institution::find($row->institution_id);
            $centerData[] = [
                'name' => $institution?->name ?? 'Unknown',
                'donations' => $row->total
            ];
        }

        // Recent donations (with filters)
        $recentDonationsQuery = (clone $donationsQuery);
        $recentDonations = $recentDonationsQuery
            ->with(['user.detail', 'bloodGroup'])
            ->orderBy('donation_date', 'desc')
            ->limit(50)
            ->get();

        // Calculate totals with filters
        $last30DaysQuery = (clone $donationsQuery);
        $last30DaysTotal = $last30DaysQuery
            ->where('donation_date', '>=', $now->copy()->subDays(30))
            ->count();

        $totalDonationsQuery = (clone $donationsQuery);
        $totalDonations = $totalDonationsQuery->count();

        $totalInventoryQuery = (clone $inventoryQuery);
        $totalInventory = $totalInventoryQuery->sum('quantity');

        $totalRequestsQuery = (clone $demandQuery);
        $totalRequests = $totalRequestsQuery->count();

        return [
            'now' => $now,
            'bloodLabels' => $bloodLabels,
            'donationsByBloodType' => $donationsByBloodType,
            'inventoryByBloodType' => $inventoryByBloodType,
            'demandByBloodType' => $demandByBloodType,
            'monthlyDonations' => $monthlyDonations,
            'centerData' => $centerData,
            'recentDonations' => $recentDonations,
            'last30DaysTotal' => $last30DaysTotal,
            'totalDonations' => $totalDonations,
            'totalInventory' => $totalInventory,
            'totalRequests' => $totalRequests,
            'filters' => [
                'dateRange' => $dateRange,
                'bloodType' => $bloodType,
                'location' => $location,
                'reportType' => $reportType
            ]
        ];
    }

    private function generateDonationsCSV($file, $data)
    {
        // Header
        fputcsv($file, ['Blood Type', 'Donations', 'Percentage']);

        $totalDonations = array_sum($data['donationsByBloodType']);

        foreach ($data['bloodLabels'] as $index => $label) {
            $bloodGroup = \App\Models\BloodGroup::where('name', $label)->first();
            $bloodGroupId = $bloodGroup ? $bloodGroup->id : null;
            $donations = $bloodGroupId ? ($data['donationsByBloodType'][$bloodGroupId] ?? 0) : 0;
            $percentage = $totalDonations > 0 ? round(($donations / $totalDonations) * 100, 2) : 0;
            fputcsv($file, [$label, $donations, $percentage . '%']);
        }
    }

    private function generateInventoryCSV($file, $data)
    {
        // Header
        fputcsv($file, ['Blood Type', 'Current Inventory', 'Status']);

        foreach ($data['bloodLabels'] as $index => $label) {
            $bloodGroup = \App\Models\BloodGroup::where('name', $label)->first();
            $bloodGroupId = $bloodGroup ? $bloodGroup->id : null;
            $inventory = $bloodGroupId ? ($data['inventoryByBloodType'][$bloodGroupId] ?? 0) : 0;
            $status = $inventory < 5 ? 'Critical' : ($inventory < 20 ? 'Low' : 'Adequate');
            fputcsv($file, [$label, $inventory, $status]);
        }
    }

    private function generateAnalyticsCSV($file, $data)
    {
        // Header
        fputcsv($file, ['Metric', 'Value']);

        fputcsv($file, ['Total Donations', $data['totalDonations']]);
        fputcsv($file, ['Last 30 Days Donations', $data['last30DaysTotal']]);
        fputcsv($file, ['Total Inventory Units', $data['totalInventory']]);
        fputcsv($file, ['Total Blood Requests', $data['totalRequests']]);
        fputcsv($file, ['Report Generated', $data['now']->format('Y-m-d H:i:s')]);
    }

    private function generateComprehensiveCSV($file, $data)
    {
        // Multiple sheets in one CSV
        fputcsv($file, ['LIFESTREAM BLOOD MANAGEMENT SYSTEM - COMPREHENSIVE REPORT']);
        fputcsv($file, ['Generated on: ' . $data['now']->format('F j, Y - H:i:s')]);
        fputcsv($file, []);

        // Summary
        fputcsv($file, ['SUMMARY STATISTICS']);
        fputcsv($file, ['Metric', 'Value']);
        fputcsv($file, ['Total Donations', $data['totalDonations']]);
        fputcsv($file, ['Last 30 Days Donations', $data['last30DaysTotal']]);
        fputcsv($file, ['Total Inventory Units', $data['totalInventory']]);
        fputcsv($file, ['Total Blood Requests', $data['totalRequests']]);
        fputcsv($file, []);

        // Donations by Blood Type
        fputcsv($file, ['DONATIONS BY BLOOD TYPE']);
        fputcsv($file, ['Blood Type', 'Donations', 'Percentage']);
        $totalDonations = array_sum($data['donationsByBloodType']);
        foreach ($data['bloodLabels'] as $index => $label) {
            $bloodGroup = \App\Models\BloodGroup::where('name', $label)->first();
            $bloodGroupId = $bloodGroup ? $bloodGroup->id : null;
            $donations = $bloodGroupId ? ($data['donationsByBloodType'][$bloodGroupId] ?? 0) : 0;
            $percentage = $totalDonations > 0 ? round(($donations / $totalDonations) * 100, 2) : 0;
            fputcsv($file, [$label, $donations, $percentage . '%']);
        }
        fputcsv($file, []);

        // Center Performance
        fputcsv($file, ['CENTER PERFORMANCE']);
        fputcsv($file, ['Center Name', 'Total Donations']);
        foreach ($data['centerData'] as $center) {
            fputcsv($file, [$center['name'], $center['donations']]);
        }
    }
}
