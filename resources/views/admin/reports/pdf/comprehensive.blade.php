<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Comprehensive Blood Management Report</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            margin: 20px;
            color: #333;
            line-height: 1.4;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #dc2626;
            padding-bottom: 20px;
        }

        .header h1 {
            color: #dc2626;
            font-size: 24px;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .header .subtitle {
            color: #666;
            font-size: 14px;
            margin-top: 5px;
        }

        .meta-info {
            text-align: right;
            font-size: 11px;
            color: #666;
            margin-bottom: 20px;
        }

        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }

        .section-title {
            background-color: #dc2626;
            color: white;
            padding: 8px 12px;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 15px;
            border-radius: 4px;
        }

        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }

        .stat-item {
            display: table-cell;
            width: 25%;
            text-align: center;
            padding: 15px 10px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
        }

        .stat-value {
            font-size: 24px;
            font-weight: bold;
            color: #dc2626;
            display: block;
        }

        .stat-label {
            font-size: 11px;
            color: #666;
            margin-top: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 11px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px 10px;
            text-align: left;
        }

        th {
            background-color: #dc2626;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .chart-placeholder {
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            padding: 20px;
            text-align: center;
            margin: 15px 0;
            border-radius: 4px;
        }

        .chart-placeholder .chart-title {
            font-weight: bold;
            color: #dc2626;
            margin-bottom: 10px;
        }

        .chart-placeholder .chart-data {
            font-size: 10px;
            color: #666;
        }

        .summary-box {
            background-color: #fef2f2;
            border-left: 4px solid #dc2626;
            padding: 15px;
            margin: 20px 0;
            border-radius: 0 4px 4px 0;
        }

        .summary-title {
            font-weight: bold;
            color: #dc2626;
            margin-bottom: 10px;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #777;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }

        .page-break {
            page-break-before: always;
        }

        .critical {
            color: #dc2626;
            font-weight: bold;
        }

        .low {
            color: #f59e0b;
            font-weight: bold;
        }

        .adequate {
            color: #059669;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LifeStream Blood Management System</h1>
        <div class="subtitle">Comprehensive Analytics Report</div>
    </div>

    <div class="meta-info">
        Generated on: {{ $now->format('F j, Y - H:i:s') }}<br>
        Report Type: Comprehensive Analysis
    </div>

    <!-- Executive Summary -->
    <div class="section">
        <div class="section-title">Executive Summary</div>
        <div class="stats-grid">
            <div class="stat-item">
                <span class="stat-value">{{ number_format($totalDonations) }}</span>
                <span class="stat-label">Total Donations</span>
            </div>
            <div class="stat-item">
                <span class="stat-value">{{ number_format($last30DaysTotal) }}</span>
                <span class="stat-label">Last 30 Days</span>
            </div>
            <div class="stat-item">
                <span class="stat-value">{{ number_format($totalInventory) }}</span>
                <span class="stat-label">Inventory Units</span>
            </div>
            <div class="stat-item">
                <span class="stat-value">{{ number_format($totalRequests) }}</span>
                <span class="stat-label">Blood Requests</span>
            </div>
        </div>
    </div>

    <!-- Blood Type Distribution -->
    <div class="section">
        <div class="section-title">Blood Type Distribution</div>
        <table>
            <thead>
                <tr>
                    <th>Blood Type</th>
                    <th>Donations</th>
                    <th>Current Inventory</th>
                    <th>Demand</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalDonations = array_sum($donationsByBloodType);
                @endphp
                @foreach($bloodLabels as $index => $label)
                    @php
                        // Find the blood group ID by name
                        $bloodGroup = \App\Models\BloodGroup::where('name', $label)->first();
                        $bloodGroupId = $bloodGroup ? $bloodGroup->id : null;
                        
                        $donations = $bloodGroupId ? ($donationsByBloodType[$bloodGroupId] ?? 0) : 0;
                        $inventory = $bloodGroupId ? ($inventoryByBloodType[$bloodGroupId] ?? 0) : 0;
                        $demand = $bloodGroupId ? ($demandByBloodType[$bloodGroupId] ?? 0) : 0;
                        $percentage = $totalDonations > 0 ? round(($donations / $totalDonations) * 100, 1) : 0;
                        
                        if ($inventory < 5) {
                            $status = 'Critical';
                            $statusClass = 'critical';
                        } elseif ($inventory < 20) {
                            $status = 'Low';
                            $statusClass = 'low';
                        } else {
                            $status = 'Adequate';
                            $statusClass = 'adequate';
                        }
                    @endphp
                    <tr>
                        <td><strong>{{ $label }}</strong></td>
                        <td>{{ $donations }} ({{ $percentage }}%)</td>
                        <td>{{ $inventory }} units</td>
                        <td>{{ $demand }} units</td>
                        <td class="{{ $statusClass }}">{{ $status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Monthly Trends -->
    <div class="section">
        <div class="section-title">Monthly Donation Trends</div>
        <table>
            <thead>
                <tr>
                    <th>Month</th>
                    <th>Donations</th>
                    <th>Trend</th>
                </tr>
            </thead>
            <tbody>
                @foreach($monthlyDonations as $monthly)
                    <tr>
                        <td>{{ \Carbon\Carbon::createFromFormat('Y-m', $monthly->month)->format('F Y') }}</td>
                        <td>{{ $monthly->total }}</td>
                        <td>
                            @if($loop->index > 0)
                                @php
                                    $previous = $monthlyDonations[$loop->index - 1]->total;
                                    $change = $monthly->total - $previous;
                                    $changePercent = $previous > 0 ? round(($change / $previous) * 100, 1) : 0;
                                @endphp
                                @if($change > 0)
                                    <span class="adequate">↗ +{{ $changePercent }}%</span>
                                @elseif($change < 0)
                                    <span class="critical">↘ {{ $changePercent }}%</span>
                                @else
                                    <span>→ 0%</span>
                                @endif
                            @else
                                <span>-</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Center Performance -->
    <div class="section">
        <div class="section-title">Center Performance</div>
        <table>
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Center Name</th>
                    <th>Total Donations</th>
                    <th>Performance</th>
                </tr>
            </thead>
            <tbody>
                @foreach($centerData as $index => $center)
                    @php
                        $maxDonations = max(array_column($centerData, 'donations'));
                        $performance = $maxDonations > 0 ? round(($center['donations'] / $maxDonations) * 100, 1) : 0;
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $center['name'] }}</td>
                        <td>{{ $center['donations'] }}</td>
                        <td>{{ $performance }}% of top performer</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Recent Donations -->
    <div class="section">
        <div class="section-title">Recent Donations (Last 50)</div>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Donor</th>
                    <th>Blood Type</th>
                    <th>Donation Date</th>
                    <th>Volume (ml)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentDonations as $index => $donation)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $donation->user->full_name ?? 'Unknown' }}</td>
                        <td>
                            @if($donation->bloodGroup && $donation->bloodGroup->name)
                                {{ $donation->bloodGroup->name }}
                            @else
                                <span style="color: red;">[Missing]</span>
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($donation->donation_date)->format('M j, Y') }}</td>
                        <td>{{ $donation->volume_ml ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Key Insights -->
    <div class="section">
        <div class="section-title">Key Insights & Recommendations</div>
        <div class="summary-box">
            <div class="summary-title">📊 Current Status</div>
            <ul>
                <li><strong>Total System Donations:</strong> {{ number_format($totalDonations) }} units collected</li>
                <li><strong>Recent Activity:</strong> {{ $last30DaysTotal }} donations in the last 30 days</li>
                <li><strong>Inventory Status:</strong> {{ number_format($totalInventory) }} units currently available</li>
                <li><strong>Demand Tracking:</strong> {{ number_format($totalRequests) }} blood requests processed</li>
            </ul>
        </div>

        <div class="summary-box">
            <div class="summary-title">⚠️ Critical Alerts</div>
            @php
                $criticalTypes = [];
                foreach($bloodLabels as $index => $label) {
                    $bloodGroup = \App\Models\BloodGroup::where('name', $label)->first();
                    $bloodGroupId = $bloodGroup ? $bloodGroup->id : null;
                    $inventory = $bloodGroupId ? ($inventoryByBloodType[$bloodGroupId] ?? 0) : 0;
                    if ($inventory < 5) {
                        $criticalTypes[] = $label;
                    }
                }
            @endphp
            @if(count($criticalTypes) > 0)
                <p><strong>Critical Inventory Levels:</strong> {{ implode(', ', $criticalTypes) }} - Immediate action required</p>
            @else
                <p><strong>All blood types are at adequate levels</strong></p>
            @endif
        </div>

        <div class="summary-box">
            <div class="summary-title">📈 Performance Highlights</div>
            @php
                $topCenter = $centerData[0] ?? null;
                $topBloodType = '';
                $maxDonations = 0;
                foreach($bloodLabels as $index => $label) {
                    $bloodGroup = \App\Models\BloodGroup::where('name', $label)->first();
                    $bloodGroupId = $bloodGroup ? $bloodGroup->id : null;
                    $donations = $bloodGroupId ? ($donationsByBloodType[$bloodGroupId] ?? 0) : 0;
                    if ($donations > $maxDonations) {
                        $maxDonations = $donations;
                        $topBloodType = $label;
                    }
                }
            @endphp
            <ul>
                @if($topCenter)
                    <li><strong>Top Performing Center:</strong> {{ $topCenter['name'] }} with {{ $topCenter['donations'] }} donations</li>
                @endif
                <li><strong>Most Donated Blood Type:</strong> {{ $topBloodType }} ({{ $maxDonations }} donations)</li>
                <li><strong>System Efficiency:</strong> {{ $totalRequests > 0 ? round(($totalDonations / $totalRequests) * 100, 1) : 0 }}% donation-to-request ratio</li>
            </ul>
        </div>
    </div>

    <div class="footer">
        LifeStream Blood Management System &copy; {{ date('Y') }} — All rights reserved.<br>
        This report was automatically generated on {{ $now->format('F j, Y \a\t H:i:s') }}
    </div>
</body>
</html> 