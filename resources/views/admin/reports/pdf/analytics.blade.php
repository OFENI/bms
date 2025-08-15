<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Analytics Report</title>
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

        .meta-info {
            text-align: right;
            font-size: 11px;
            color: #666;
            margin-bottom: 20px;
        }

        .section {
            margin-bottom: 25px;
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
            font-size: 20px;
            font-weight: bold;
            color: #dc2626;
            display: block;
        }

        .stat-label {
            font-size: 10px;
            color: #666;
            margin-top: 5px;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #777;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LifeStream Blood Management System</h1>
        <div style="color: #666; font-size: 14px; margin-top: 5px;">Analytics Report</div>
    </div>

    <div class="meta-info">
        Generated on: {{ $now->format('F j, Y - H:i:s') }}<br>
        Report Type: Analytics Overview
    </div>

    <!-- Key Metrics -->
    <div class="section">
        <div class="section-title">Key Performance Indicators</div>
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

    <!-- Center Performance -->
    <div class="section">
        <div class="section-title">Center Performance Analysis</div>
        <table>
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Center Name</th>
                    <th>Total Donations</th>
                    <th>Performance %</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $maxDonations = max(array_column($centerData, 'donations'));
                @endphp
                @foreach($centerData as $index => $center)
                    @php
                        $performance = $maxDonations > 0 ? round(($center['donations'] / $maxDonations) * 100, 1) : 0;
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $center['name'] }}</td>
                        <td>{{ $center['donations'] }}</td>
                        <td>{{ $performance }}%</td>
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
                    <th>Growth Rate</th>
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
                                    <span style="color: #059669;">↗ +{{ $changePercent }}%</span>
                                @elseif($change < 0)
                                    <span style="color: #dc2626;">↘ {{ $changePercent }}%</span>
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

    <!-- System Efficiency -->
    <div class="section">
        <div class="section-title">System Efficiency Metrics</div>
        <table>
            <thead>
                <tr>
                    <th>Metric</th>
                    <th>Value</th>
                    <th>Analysis</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Donation-to-Request Ratio</td>
                    <td>{{ $totalRequests > 0 ? round(($totalDonations / $totalRequests) * 100, 1) : 0 }}%</td>
                    <td>
                        @if($totalRequests > 0 && ($totalDonations / $totalRequests) >= 1)
                            <span style="color: #059669;">Excellent supply coverage</span>
                        @elseif($totalRequests > 0 && ($totalDonations / $totalRequests) >= 0.8)
                            <span style="color: #f59e0b;">Good supply coverage</span>
                        @else
                            <span style="color: #dc2626;">Supply shortage detected</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Average Daily Donations</td>
                    <td>{{ $totalDonations > 0 ? round($totalDonations / max(1, \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($recentDonations->first()->donation_date ?? now()))), 1) : 0 }}</td>
                    <td>Daily donation rate</td>
                </tr>
                <tr>
                    <td>Inventory Utilization</td>
                    <td>{{ $totalInventory > 0 ? round(($totalInventory / max(1, $totalDonations)) * 100, 1) : 0 }}%</td>
                    <td>Current inventory vs total donations</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="footer">
        LifeStream Blood Management System &copy; {{ date('Y') }} — All rights reserved.<br>
        This report was automatically generated on {{ $now->format('F j, Y \a\t H:i:s') }}
    </div>
</body>
</html> 