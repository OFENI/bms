<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Inventory Report</title>
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
        <div style="color: #666; font-size: 14px; margin-top: 5px;">Inventory Report</div>
    </div>

    <div class="meta-info">
        Generated on: {{ $now->format('F j, Y - H:i:s') }}<br>
        Report Type: Inventory Analysis
    </div>

    <!-- Inventory Summary -->
    <div class="section">
        <div class="section-title">Inventory Summary</div>
        <table>
            <thead>
                <tr>
                    <th>Metric</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Total Inventory Units</td>
                    <td>{{ number_format($totalInventory) }}</td>
                </tr>
                <tr>
                    <td>Blood Types Available</td>
                    <td>{{ count(array_filter($inventoryByBloodType, function($value) { return $value > 0; })) }}</td>
                </tr>
                <tr>
                    <td>Critical Levels</td>
                    <td>{{ count(array_filter($inventoryByBloodType, function($value) { return $value < 5; })) }} types</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Blood Type Inventory -->
    <div class="section">
        <div class="section-title">Current Inventory by Blood Type</div>
        <table>
            <thead>
                <tr>
                    <th>Blood Type</th>
                    <th>Current Inventory</th>
                    <th>Status</th>
                    <th>Demand</th>
                    <th>Supply vs Demand</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bloodLabels as $index => $label)
                    @php
                        $bloodGroup = \App\Models\BloodGroup::where('name', $label)->first();
                        $bloodGroupId = $bloodGroup ? $bloodGroup->id : null;
                        $inventory = $bloodGroupId ? ($inventoryByBloodType[$bloodGroupId] ?? 0) : 0;
                        $demand = $bloodGroupId ? ($demandByBloodType[$bloodGroupId] ?? 0) : 0;
                        
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
                        
                        $ratio = $demand > 0 ? round(($inventory / $demand) * 100, 1) : 0;
                    @endphp
                    <tr>
                        <td><strong>{{ $label }}</strong></td>
                        <td>{{ $inventory }} units</td>
                        <td class="{{ $statusClass }}">{{ $status }}</td>
                        <td>{{ $demand }} units</td>
                        <td>{{ $ratio }}% of demand</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Critical Alerts -->
    <div class="section">
        <div class="section-title">Critical Inventory Alerts</div>
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
            <table>
                <thead>
                    <tr>
                        <th>Blood Type</th>
                        <th>Current Level</th>
                        <th>Recommended Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($criticalTypes as $type)
                        @php
                            $bloodGroup = \App\Models\BloodGroup::where('name', $type)->first();
                            $bloodGroupId = $bloodGroup ? $bloodGroup->id : null;
                            $inventory = $bloodGroupId ? ($inventoryByBloodType[$bloodGroupId] ?? 0) : 0;
                        @endphp
                        <tr>
                            <td class="critical">{{ $type }}</td>
                            <td class="critical">{{ $inventory }} units</td>
                            <td>Immediate donation drive required</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="color: #059669; font-weight: bold;">✅ All blood types are at adequate levels</p>
        @endif
    </div>

    <div class="footer">
        LifeStream Blood Management System &copy; {{ date('Y') }} — All rights reserved.<br>
        This report was automatically generated on {{ $now->format('F j, Y \a\t H:i:s') }}
    </div>
</body>
</html> 