<!DOCTYPE html>
<html>
<head>
    <title>Blood Inventory Report</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f5f5f5; }
    </style>
</head>
<body>
    <h2>Blood Inventory Report</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Blood Group</th>
                <th>Institution</th>
                <th>Volume (ml)</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inventories as $index => $inventory)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $inventory->bloodGroup->name ?? 'N/A' }}</td>
                    <td>{{ $inventory->institution->name ?? 'N/A' }}</td>
                    <td>{{ $inventory->volume_ml }}</td>
                    <td>{{ $inventory->updated_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
