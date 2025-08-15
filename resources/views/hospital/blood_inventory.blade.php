<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Inventory | Hospital Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #3498db;
            --accent: #e74c3c;
            --light: #ecf0f1;
            --dark: #2c3e50;
            --success: #27ae60;
            --warning: #f39c12;
            --danger: #e74c3c;
            --info: #2980b9;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7fa;
            color: #333;
            overflow-x: hidden;
        }
        
        /* Header Styles */
        .header {
            background: linear-gradient(135deg, var(--primary), #1a2530);
            color: white;
            padding: 15px 25px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .hospital-info {
            display: flex;
            align-items: center;
        }
        
        .hospital-logo {
            width: 50px;
            height: 50px;
            background-color: var(--accent);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 24px;
        }
        
        .hospital-name {
            font-weight: 700;
            font-size: 1.5rem;
        }
        
        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .notification-bell {
            position: relative;
            cursor: pointer;
            font-size: 1.2rem;
        }
        
        .notification-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: var(--accent);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: bold;
        }
        
        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }
        
        /* Dashboard Layout */
        .dashboard-container {
            display: flex;
            min-height: calc(100vh - 80px);
        }
        
        .sidebar {
            width: 250px;
            background-color: white;
            box-shadow: 3px 0 10px rgba(0, 0, 0, 0.05);
            padding: 20px 0;
            transition: all 0.3s ease;
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 0;
        }
        
        .menu-item {
            padding: 12px 25px;
            display: flex;
            align-items: center;
            gap: 15px;
            cursor: pointer;
            transition: all 0.2s;
            border-left: 4px solid transparent;
        }
        
        .menu-item:hover, .menu-item.active {
            background-color: rgba(52, 152, 219, 0.1);
            border-left: 4px solid var(--secondary);
            color: var(--secondary);
        }
        
        .menu-item.active {
            font-weight: 600;
        }
        
        .main-content {
            flex: 1;
            padding: 25px;
        }
        
        .dashboard-title {
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .dashboard-title h1 {
            font-weight: 700;
            color: var(--primary);
            font-size: 1.8rem;
        }
        
        /* Cards */
        .card {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border: none;
            margin-bottom: 25px;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }
        
        .card-header {
            background-color: transparent;
            border-bottom: 1px solid #eee;
            padding: 18px 25px;
            font-weight: 700;
            font-size: 1.2rem;
            color: var(--primary);
        }
        
        .card-body {
            padding: 25px;
        }
        
        /* Stats Cards */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            font-size: 1.5rem;
        }
        
        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            margin: 5px 0;
        }
        
        .stat-title {
            color: #777;
            font-size: 0.9rem;
        }
        
        /* Tables */
        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        
        .table th {
            background-color: #f8f9fa;
            color: var(--dark);
            font-weight: 600;
            padding: 15px;
            border-top: 1px solid #eee;
        }
        
        .table td {
            padding: 15px;
            border-top: 1px solid #eee;
            vertical-align: middle;
        }
        
        .table tr:hover td {
            background-color: rgba(52, 152, 219, 0.05);
        }
        
        /* Badges */
        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
        }
        
        .badge-safe {
            background-color: rgba(39, 174, 96, 0.15);
            color: var(--success);
        }
        
        .badge-warning {
            background-color: rgba(243, 156, 18, 0.15);
            color: var(--warning);
        }
        
        .badge-danger {
            background-color: rgba(231, 76, 60, 0.15);
            color: var(--danger);
        }
        
        .badge-info {
            background-color: rgba(52, 152, 219, 0.15);
            color: var(--secondary);
        }
        
        /* Buttons */
        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.2s;
        }
        
        .btn-primary {
            background-color: var(--secondary);
            border-color: var(--secondary);
        }
        
        .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }
        
        .btn-danger {
            background-color: var(--danger);
            border-color: var(--danger);
        }
        
        /* Form Styles */
        .form-label {
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--dark);
        }
        
        .form-control, .form-select {
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            transition: all 0.2s;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--secondary);
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }
        
        /* Inventory Chart */
        .chart-container {
            height: 300px;
            position: relative;
        }
        
        /* Blood Type Grid */
        .blood-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .blood-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            text-align: center;
            transition: all 0.3s;
            border-top: 4px solid;
        }
        
        .blood-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }
        
        .blood-type {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .blood-count {
            font-size: 1.8rem;
            font-weight: 700;
            margin: 10px 0;
        }
        
        .blood-status {
            font-weight: 600;
            padding: 6px 15px;
            border-radius: 20px;
            display: inline-block;
            margin-top: 10px;
        }
        
        /* Expiration Section */
        .expiration-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
        }
        
        .expiration-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        
        .expiration-title {
            font-weight: 700;
            font-size: 1.2rem;
            color: var(--primary);
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                width: 0;
                left: -250px;
                position: fixed;
                z-index: 1050;
                height: 100vh;
                transition: left 0.3s, width 0.3s;
                overflow-y: auto;
            }
            .sidebar.open {
                left: 0;
                width: 250px;
            }
            .menu-text {
                display: inline;
            }
            .main-content {
                padding-left: 0;
            }
        }
        
        @media (max-width: 768px) {
            .stats-container {
                grid-template-columns: 1fr;
            }
            .dashboard-title {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            .mobile-menu-btn {
                display: block;
            }
            .blood-grid {
                grid-template-columns: 1fr 1fr;
            }
            .sidebar {
                left: -250px;
                width: 0;
                height: 100vh;
            }
            .sidebar.open {
                left: 0;
                width: 250px;
            }
        }
        
        @media (max-width: 576px) {
            .blood-grid {
                grid-template-columns: 1fr;
            }
            .table {
                font-size: 0.85rem;
            }
        }
        
        /* Blood Type Colors */
        .blood-a-plus { border-color: #e74c3c; }
        .blood-a-minus { border-color: #e67e22; }
        .blood-b-plus { border-color: #2ecc71; }
        .blood-b-minus { border-color: #1abc9c; }
        .blood-o-plus { border-color: #3498db; }
        .blood-o-minus { border-color: #9b59b6; }
        .blood-ab-plus { border-color: #f1c40f; }
        .blood-ab-minus { border-color: #34495e; }
    </style>
</head>
<body>
    <!-- Header -->
    @include('layouts.partials.header', ['user' => Auth::user(), 'hospital' => Auth::user()->institution])
    
    <!-- Dashboard Layout -->
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <ul class="sidebar-menu">
            <li class="menu-item">
                  <a href="{{ route('hospital.dashboard') }}" class="menu-link @if(request()->routeIs('hospital.dashboard')) active @endif" style="display: flex; align-items: center; text-decoration: none; color: inherit;">
                    <i class="fas fa-tachometer-alt" style="margin-right: 20px;"></i>
                    <span class="menu-text">Dashboard</span>
                  </a>
                </li>

                <li class="menu-item active">
                    <i class="fas fa-tint"></i>
                    <span class="menu-text">Blood Inventory</span>
                </li>

<li class="menu-item">
  <a 
                    href="{{ route('hospital.requests.index') }}" 
    class="menu-link"
    style="display: flex; align-items: center; text-decoration: none; color: inherit;"
  >
    <i class="fas fa-hand-holding-medical" style="margin-right: 20px;"></i>
    <span class="menu-text">Blood Requests</span>
  </a>
</li>

<li class="menu-item">
  <a 
    href="{{ route('hospital.disbursement_history') }}" 
    class="menu-link"
    style="display: flex; align-items: center; text-decoration: none; color: inherit;"
  >
    <i class="fas fa-history" style="margin-right: 20px;"></i>
    <span class="menu-text">Disbursement History</span>
  </a>
</li>

                <!-- <li class="menu-item">
                    <i class="fas fa-user-friends"></i>
                    <span class="menu-text">Donors</span>
                </li>-->
                <li class="menu-item">
                  <a href="{{ route('hospital.reports') }}" class="menu-link" style="display: flex; align-items: center; text-decoration: none; color: inherit;">
                    <i class="fas fa-chart-line" style="margin-right: 20px;"></i>
                    <span class="menu-text">Reports</span>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="{{ route('hospital.settings') }}" class="menu-link" style="display: flex; align-items: center; text-decoration: none; color: inherit;">
                    <i class="fas fa-cog" style="margin-right: 20px;"></i>
                    <span class="menu-text">Settings</span>
                  </a>
                </li>
            </ul>
        </div>
        
        <!-- Main Content - Blood Inventory -->
        <div class="main-content">
            <div class="dashboard-title">
                <h1><i class="fas fa-tint me-3"></i>Blood Inventory Management</h1>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary">
                        <i class="fas fa-print me-2"></i>Print Report
                    </button>
                    <button class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Add Blood Units
                    </button>
                </div>
            </div>
            
            <!-- Stats Overview -->
            @php
    $bloodTypes = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];

    function getStatus($units) {
        if ($units >= 71) return ['Safe', 'badge-safe', 100];
        if ($units >= 41) return ['Warning', 'badge-warning', 70];
        if ($units >= 11) return ['Low', 'badge-low', 40];
        return ['Critical', 'badge-danger', 10];
    }
@endphp

<div class="blood-grid">
    @foreach ($bloodTypes as $type)
        @php
            $units = $inventory[$type]->total_volume ?? 0;
            [$label, $class, $percent] = getStatus($units);
        @endphp

        <div class="blood-card">
            <div class="blood-type">{{ $type }}</div>
            <div class="blood-count">{{ $units }} units</div>
            <div class="blood-status {{ $class }}">{{ $label }}</div>
            <div class="progress mt-3" style="height: 8px;">
                <div class="progress-bar" role="progressbar" style="width: {{ $percent }}%; background-color:
                    @switch($label)
                        @case('Safe') #28a745 @break
                        @case('Warning') #ffc107 @break
                        @case('Low') #e67e22 @break
                        @case('Critical') #dc3545 @break
                    @endswitch
                "></div>
            </div>
        </div>
    @endforeach
</div>


<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div><i class="fas fa-chart-bar me-2"></i>Inventory Overview</div>
                <select class="form-select form-select-sm w-auto">
                    <option>Last 7 Days</option>
                    <option>Last 30 Days</option>
                    <option>Last 90 Days</option>
                </select>
            </div>
            <div class="card-body">
                <canvas id="inventoryChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('inventoryChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: @json($chartLabels),
        datasets: [{
            label: 'Total Volume (units)',
            data: @json($chartData),
            backgroundColor: 'rgba(255,99,132,0.6)',
            borderColor: 'rgba(255,99,132,1)',
            borderWidth: 1
        }]
    },
    options: { scales: { y: { beginAtZero:true } } }
});
</script>

                    <div class="row">
                    <!-- Expiring Soon -->
                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-hourglass-half me-2"></i>Blood Units Expiring Soon
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Unit ID</th>
                                            <th>Blood Type</th>
                                            <th>Expiration Date</th>
                                            <th>Days Left</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
@forelse ($expiringUnits as $unit)
    @php
        $expiry = \Carbon\Carbon::parse($unit->expiry_date);
        $today = \Carbon\Carbon::today();
        $daysLeft = $today->diffInDays($expiry, false);
        $dateFormatted = $expiry->format('F d, Y');
    @endphp
    <tr>
        <td>{{ 'ID-' . $unit->id }}</td>
        <td>{{ $unit->bloodGroup->name ?? 'N/A' }}</td>
        <td>{{ $dateFormatted }}</td>
        <td>
            @if ($daysLeft < 0)
                <span class="badge bg-danger">Expired</span>
            @elseif ($daysLeft === 0)
                <span class="badge bg-warning">Today</span>
            @elseif ($daysLeft <= 5)
                <span class="badge bg-warning">{{ $daysLeft }} days</span>
            @elseif ($daysLeft <= 10)
                <span class="badge bg-info">{{ $daysLeft }} days</span>
            @else
                <span class="badge bg-success">{{ $daysLeft }} days</span>
            @endif
        </td>
        <td>
            <a href="#" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-eye"></i>
            </a>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="5" class="text-center">No expiring units found.</td>
    </tr>
@endforelse
</tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Critical Levels & Recent Activity -->
               
                    
                    <!-- Recent Activity -->
                    
                    

    
    <script>
        // Initialize Chart
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('inventoryChart').getContext('2d');
            const inventoryChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'],
                    datasets: [{
                        label: 'Current Inventory',
                        data: [320, 95, 180, 28, 280, 12, 90, 45],
                        backgroundColor: [
                            '#e74c3c', '#e67e22', '#2ecc71', '#1abc9c',
                            '#3498db', '#9b59b6', '#f1c40f', '#34495e'
                        ],
                        borderWidth: 0
                    }, {
                        label: 'Optimal Level',
                        data: [390, 200, 240, 150, 360, 150, 200, 150],
                        backgroundColor: 'rgba(200, 200, 200, 0.2)',
                        borderColor: '#ccc',
                        borderWidth: 1,
                        type: 'line',
                        fill: false,
                        pointRadius: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Units'
                            }
                        }
                    }
                }
            });
            
            // Mobile Menu Toggle
            const menuToggle = document.getElementById('menuToggle');
            const sidebar = document.getElementById('sidebar');
            if (menuToggle && sidebar) {
                menuToggle.addEventListener('click', function() {
                    const isOpen = sidebar.classList.toggle('open');
                    menuToggle.setAttribute('aria-expanded', isOpen);
                });
                // Close sidebar when clicking outside on mobile
                document.addEventListener('click', function(e) {
                    if (window.innerWidth < 992 && sidebar.classList.contains('open')) {
                        if (!sidebar.contains(e.target) && !menuToggle.contains(e.target)) {
                            sidebar.classList.remove('open');
                            menuToggle.setAttribute('aria-expanded', 'false');
                        }
                    }
                });
            }
            
            // Highlight critical blood cards
            document.querySelectorAll('.blood-card').forEach(card => {
                card.addEventListener('click', function() {
                    // Reset all cards
                    document.querySelectorAll('.blood-card').forEach(c => {
                        c.style.transform = 'scale(1)';
                        c.style.boxShadow = '0 5px 15px rgba(0, 0, 0, 0.05)';
                    });
                    
                    // Highlight clicked card
                    this.style.transform = 'scale(1.02)';
                    this.style.boxShadow = '0 10px 25px rgba(0, 0, 0, 0.15)';
                    
                    // Show alert for critical levels
                    if(this.querySelector('.blood-status').classList.contains('badge-danger')) {
                        const bloodType = this.querySelector('.blood-type').textContent;
                        alert(`Critical level for ${bloodType} blood! Only ${this.querySelector('.blood-count').textContent} available.`);
                    }
                });
            });
        });
    </script>

<script>
document.getElementById('notificationDropdown')?.addEventListener('click', function () {
    fetch("{{ route('hospital.notifications') }}", {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        const list = document.getElementById('notificationList');
        const count = document.getElementById('notificationCount');

        list.innerHTML = '';

        if (data.length === 0) {
            list.innerHTML = '<li class="dropdown-item text-muted">No new requests</li>';
            count.style.display = 'none';
        } else {
            count.textContent = data.length;
            count.style.display = 'inline-block';

            data.forEach(item => {
                const li = document.createElement('li');
                li.classList.add('dropdown-item');
                li.innerHTML = `
                    <strong>${item.quantity} unit(s)</strong> of ${item.blood_group_id} requested
                    <br><small class="text-muted">${new Date(item.created_at).toLocaleString()}</small>
                    <a href="{{ url('hospital/requests') }}" class="d-block mt-1">View Request</a>
                `;
                list.appendChild(li);
            });
        }
    })
    .catch(error => {
        console.error('Notification fetch failed:', error);
    });
});
</script>
</body>
</html>