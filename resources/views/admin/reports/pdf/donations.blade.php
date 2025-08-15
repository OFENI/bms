<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Donations Report</title>
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
        <div style="color: #666; font-size: 14px; margin-top: 5px;">Donations Report</div>
    </div>

    <div class="meta-info">
        Generated on: {{ $now->format('F j, Y - H:i:s') }}<br>
        Report Type: Donations Analysis
    </div>

    <!-- Donations Summary -->
    <div class="section">
        <div class="section-title">Donations Summary</div>
        <table>
            <thead>
                <tr>
                    <th>Metric</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Total Donations</td>
                    <td>{{ number_format($totalDonations) }}</td>
                </tr>
                <tr>
                    <td>Last 30 Days</td>
                    <td>{{ number_format($last30DaysTotal) }}</td>
                </tr>
                <tr>
                    <td>Average Daily Donations</td>
                    <td>{{ $totalDonations > 0 ? round($totalDonations / max(1, \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($recentDonations->first()->donation_date ?? now()))), 1) : 0 }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Blood Type Distribution -->
    <div class="section">
        <div class="section-title">Donations by Blood Type</div>
        <table>
            <thead>
                <tr>
                    <th>Blood Type</th>
                    <th>Donations</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalDonations = array_sum($donationsByBloodType);
                @endphp
                @foreach($bloodLabels as $index => $label)
                    @php
                        $bloodGroup = \App\Models\BloodGroup::where('name', $label)->first();
                        $bloodGroupId = $bloodGroup ? $bloodGroup->id : null;
                        $donations = $bloodGroupId ? ($donationsByBloodType[$bloodGroupId] ?? 0) : 0;
                        $percentage = $totalDonations > 0 ? round(($donations / $totalDonations) * 100, 1) : 0;
                    @endphp
                    <tr>
                        <td><strong>{{ $label }}</strong></td>
                        <td>{{ $donations }}</td>
                        <td>{{ $percentage }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Recent Donations -->
    <div class="section">
        <div class="section-title">Recent Donations</div>
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
                        <td>{{ $donation->bloodGroup->name ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($donation->donation_date)->format('M j, Y') }}</td>
                        <td>{{ $donation->volume_ml ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        LifeStream Blood Management System &copy; {{ date('Y') }} — All rights reserved.<br>
        This report was automatically generated on {{ $now->format('F j, Y \a\t H:i:s') }}
    </div>
</body>
</html> 