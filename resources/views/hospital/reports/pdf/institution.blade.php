<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Institution Report - {{ $institution->name }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
            line-height: 1.6;
        }
        
        .header {
            text-align: center;
            border-bottom: 3px solid #2c3e50;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .institution-name {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
        }
        
        .report-title {
            font-size: 18px;
            color: #666;
            margin-bottom: 5px;
        }
        
        .report-date {
            font-size: 14px;
            color: #999;
        }
        
        .section {
            margin-bottom: 30px;
        }
        
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .info-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        
        .info-label {
            font-weight: bold;
            color: #555;
        }
        
        .info-value {
            color: #333;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .stat-box {
            border: 2px solid #3498db;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
        }
        
        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        
        .stat-label {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
        }
        
        .performance-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .performance-box {
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 15px;
        }
        
        .performance-title {
            font-size: 14px;
            font-weight: bold;
            color: #555;
            margin-bottom: 8px;
        }
        
        .performance-value {
            font-size: 20px;
            font-weight: bold;
            color: #2c3e50;
        }
        
        .performance-unit {
            font-size: 12px;
            color: #666;
        }
        
        .blood-type-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .blood-type-table th,
        .blood-type-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        
        .blood-type-table th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #2c3e50;
        }
        
        .blood-type-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 15px;
            }
            
            .page-break {
                page-break-before: always;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="institution-name">{{ $institution->name }}</div>
        <div class="report-title">Institution Report</div>
        <div class="report-date">Generated on: {{ date('F j, Y \a\t g:i A') }}</div>
    </div>

    <!-- Institution Information -->
    <div class="section">
        <div class="section-title">Institution Information</div>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Name:</span>
                <span class="info-value">{{ $data['institution']['name'] }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Email:</span>
                <span class="info-value">{{ $data['institution']['email'] }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Contact Number:</span>
                <span class="info-value">{{ $data['institution']['contact_number'] }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Region:</span>
                <span class="info-value">{{ $data['institution']['region'] }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Country:</span>
                <span class="info-value">{{ $data['institution']['country'] }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Operating Hours:</span>
                <span class="info-value">{{ $data['institution']['opening_time'] }} - {{ $data['institution']['closing_time'] }}</span>
            </div>
        </div>
        <div class="info-item">
            <span class="info-label">Address:</span>
            <span class="info-value">{{ $data['institution']['address'] }}</span>
        </div>
    </div>

    <!-- Key Statistics -->
    <div class="section">
        <div class="section-title">Key Statistics</div>
        <div class="stats-grid">
            <div class="stat-box">
                <div class="stat-number">{{ $data['donations']['total'] }}</div>
                <div class="stat-label">Total Donations</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">{{ $data['blood_requests']['total'] }}</div>
                <div class="stat-label">Blood Requests</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">{{ $data['disbursements']['total'] }}</div>
                <div class="stat-label">Disbursements</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">{{ $data['donors']['total'] }}</div>
                <div class="stat-label">Total Donors</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">{{ $data['staff']['total'] }}</div>
                <div class="stat-label">Staff Members</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">{{ $data['performance']['fulfillment_rate'] }}%</div>
                <div class="stat-label">Fulfillment Rate</div>
            </div>
        </div>
    </div>

    <!-- Performance Metrics -->
    <div class="section">
        <div class="section-title">Performance Metrics</div>
        <div class="performance-grid">
            <div class="performance-box">
                <div class="performance-title">Donation Rate</div>
                <div class="performance-value">{{ $data['performance']['donation_rate'] }}</div>
                <div class="performance-unit">donations per day</div>
            </div>
            <div class="performance-box">
                <div class="performance-title">Response Time</div>
                <div class="performance-value">{{ $data['performance']['response_time'] }}</div>
                <div class="performance-unit">hours average</div>
            </div>
            <div class="performance-box">
                <div class="performance-title">Inventory Turnover</div>
                <div class="performance-value">{{ $data['performance']['inventory_turnover'] }}</div>
                <div class="performance-unit">times per period</div>
            </div>
            <div class="performance-box">
                <div class="performance-title">Total Value</div>
                <div class="performance-value">${{ number_format($data['financial']['total_donations_value']) }}</div>
                <div class="performance-unit">donations value</div>
            </div>
        </div>
    </div>

    <!-- Blood Type Breakdown -->
    <div class="section">
        <div class="section-title">Blood Type Breakdown</div>
        <table class="blood-type-table">
            <thead>
                <tr>
                    <th>Blood Type</th>
                    <th>Donations</th>
                    <th>Requests</th>
                    <th>Disbursements</th>
                    <th>Current Inventory</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['blood_groups'] as $bloodGroup)
                <tr>
                    <td><strong>{{ $bloodGroup->name }}</strong></td>
                    <td>{{ $data['donations']['by_blood_type'][$bloodGroup->id]->total ?? 0 }}</td>
                    <td>{{ $data['blood_requests']['by_blood_type'][$bloodGroup->id]->total ?? 0 }}</td>
                    <td>{{ $data['disbursements']['by_blood_type'][$bloodGroup->id]->total ?? 0 }}</td>
                    <td>{{ $data['current_inventory'][$bloodGroup->id]->total ?? 0 }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Request Status Summary -->
    <div class="section">
        <div class="section-title">Blood Request Status Summary</div>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Total Requests:</span>
                <span class="info-value">{{ $data['blood_requests']['total'] }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Pending:</span>
                <span class="info-value">{{ $data['blood_requests']['pending'] }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Approved:</span>
                <span class="info-value">{{ $data['blood_requests']['approved'] }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Rejected:</span>
                <span class="info-value">{{ $data['blood_requests']['rejected'] }}</span>
            </div>
        </div>
    </div>

    <!-- Staff Breakdown -->
    <div class="section">
        <div class="section-title">Staff by Role</div>
        <table class="blood-type-table">
            <thead>
                <tr>
                    <th>Role</th>
                    <th>Count</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['staff']['by_role'] as $role => $count)
                <tr>
                    <td><strong>{{ ucfirst($role) }}</strong></td>
                    <td>{{ $count->total }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Monthly Trends -->
    @if($data['donations']['monthly_trend']->count() > 0)
    <div class="section">
        <div class="section-title">Monthly Donation Trends</div>
        <table class="blood-type-table">
            <thead>
                <tr>
                    <th>Month</th>
                    <th>Donations</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['donations']['monthly_trend'] as $trend)
                <tr>
                    <td><strong>{{ $trend->month }}</strong></td>
                    <td>{{ $trend->total }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>This report was generated automatically by the Blood Management System</p>
        <p>For questions or support, please contact your system administrator</p>
    </div>
</body>
</html> 