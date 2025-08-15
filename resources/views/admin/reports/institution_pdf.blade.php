<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Institution Donation Report</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 13px;
            margin: 30px;
            color: #333;
        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
            font-size: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #B71C1C;
        }

        .meta-info {
            text-align: right;
            font-size: 12px;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 12px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px 10px;
            text-align: left;
        }

        th {
            background-color: #f44336;
            color: #fff;
            text-transform: uppercase;
            font-size: 12px;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 11px;
            color: #777;
        }
    </style>
</head>
<body>
    <h2>Institution Donation Report</h2>
    <div class="meta-info">Generated on: {{ now()->format('F j, Y - H:i') }}</div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Institution</th>
                <th>Type</th>
                <th>Location</th>
                <th>Donations</th>
                <th>Total Volume (ml)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($institutions as $index => $institution)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $institution->name }}</td>
                    <td>{{ ucfirst($institution->type) }}</td>
                    <td>{{ $institution->location }}</td>
                    <td>{{ $institution->donations_count }}</td>
                    <td>{{ $institution->donations_sum_volume_ml }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        LifeStream Blood Management System &copy; {{ date('Y') }} — All rights reserved.
    </div>
</body>
</html>
