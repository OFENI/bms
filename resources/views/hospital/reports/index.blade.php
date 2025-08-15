<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Institution Reports | Blood Management System</title>
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
        
        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
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
            text-decoration: none;
            color: #333;
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
        
        /* Report Specific Styles */
        .report-container {
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .filters-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            padding: 25px;
            margin-bottom: 25px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            text-align: center;
            transition: transform 0.2s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 24px;
            color: white;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .stat-label {
            color: #666;
            font-size: 0.9rem;
        }
        
        .chart-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            padding: 25px;
            margin-bottom: 25px;
        }
        
        .chart-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--primary);
        }
        
        .performance-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .performance-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .performance-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: var(--primary);
        }
        
        .performance-value {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .performance-unit {
            color: #666;
            font-size: 0.9rem;
        }
        
        .export-buttons {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .btn-export {
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .btn-export:hover {
            transform: translateY(-2px);
        }
        
        .btn-pdf {
            background-color: var(--danger);
            color: white;
        }
        
        .btn-csv {
            background-color: var(--success);
            color: white;
        }
        
        .institution-info {
            background: linear-gradient(135deg, var(--primary), #1a2530);
            color: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
        }
        
        .institution-name {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .institution-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }
        
        .detail-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .detail-icon {
            width: 30px;
            height: 30px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="d-flex justify-content-between align-items-center">
            <div class="hospital-info">
                <div class="hospital-logo">
                    <i class="fas fa-hospital"></i>
                </div>
                <div>
                    <h4 class="mb-0">{{ $institution->name }}</h4>
                    <small>Blood Management System</small>
                </div>
            </div>
            <div class="header-right">
                <div class="user-profile">
                    <div class="user-avatar">
                        {{ strtoupper(substr(Auth::user()->email, 0, 1)) }}
                    </div>
                    <div>
                        <div>{{ Auth::user()->email }}</div>
                        <small>{{ ucfirst(Auth::user()->role) }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Layout -->
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('hospital.dashboard') }}" class="menu-item">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('hospital.inventory') }}" class="menu-item">
                        <i class="fas fa-tint"></i>
                        <span>Blood Inventory</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('hospital.requests.index') }}" class="menu-item">
                        <i class="fas fa-hand-holding-medical"></i>
                        <span>Blood Requests</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('hospital.disbursement_history') }}" class="menu-item">
                        <i class="fas fa-history"></i>
                        <span>Disbursement History</span>
                    </a>
                </li>
                
                <li>
                    <a href="{{ route('hospital.reports') }}" class="menu-item active">
                        <i class="fas fa-chart-bar"></i>
                        <span>Reports</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('hospital.settings') }}" class="menu-item">
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="dashboard-title">
                <h1><i class="fas fa-chart-bar me-3"></i>Institution Reports</h1>
                <div class="export-buttons">
                    <a href="{{ route('hospital.reports.pdf', request()->query()) }}" class="btn-export btn-pdf">
                        <i class="fas fa-file-pdf"></i>Export PDF
                    </a>
                    <a href="{{ route('hospital.reports.csv', request()->query()) }}" class="btn-export btn-csv">
                        <i class="fas fa-file-csv"></i>Export CSV
                    </a>
                </div>
            </div>

            <!-- Institution Information -->
            <div class="institution-info">
                <div class="institution-name">{{ $institution->name }}</div>
                <div class="institution-details">
                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>{{ $institution->email }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div>{{ $institution->contact_number }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>{{ $institution->region }}, {{ $institution->country }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>{{ $institution->opening_time }} - {{ $institution->closing_time }}</div>
                    </div>
                </div>
            </div>

            <!-- Filters Section -->
            <div class="filters-section">
                <form method="GET" action="{{ route('hospital.reports') }}" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Date Range</label>
                        <select name="date_range" class="form-select">
                            <option value="last_7_days" {{ $dateRange == 'last_7_days' ? 'selected' : '' }}>Last 7 Days</option>
                            <option value="last_30_days" {{ $dateRange == 'last_30_days' ? 'selected' : '' }}>Last 30 Days</option>
                            <option value="last_90_days" {{ $dateRange == 'last_90_days' ? 'selected' : '' }}>Last 90 Days</option>
                            <option value="last_6_months" {{ $dateRange == 'last_6_months' ? 'selected' : '' }}>Last 6 Months</option>
                            <option value="last_year" {{ $dateRange == 'last_year' ? 'selected' : '' }}>Last Year</option>
                            <option value="this_month" {{ $dateRange == 'this_month' ? 'selected' : '' }}>This Month</option>
                            <option value="this_year" {{ $dateRange == 'this_year' ? 'selected' : '' }}>This Year</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Blood Type</label>
                        <select name="blood_type" class="form-select">
                            <option value="all" {{ $bloodType == 'all' ? 'selected' : '' }}>All Blood Types</option>
                            @foreach($data['blood_groups'] as $bloodGroup)
                                <option value="{{ $bloodGroup->name }}" {{ $bloodType == $bloodGroup->name ? 'selected' : '' }}>
                                    {{ $bloodGroup->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Report Type</label>
                        <select name="report_type" class="form-select">
                            <option value="summary" {{ $reportType == 'summary' ? 'selected' : '' }}>Summary</option>
                            <option value="detailed" {{ $reportType == 'detailed' ? 'selected' : '' }}>Detailed</option>
                            <option value="analytics" {{ $reportType == 'analytics' ? 'selected' : '' }}>Analytics</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter me-2"></i>Apply Filters
                        </button>
                    </div>
                </form>
            </div>

            <!-- Statistics Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon" style="background-color: var(--success);">
                        <i class="fas fa-tint"></i>
                    </div>
                    <div class="stat-number">{{ $data['donations']['total'] }}</div>
                    <div class="stat-label">Total Donations</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon" style="background-color: var(--info);">
                        <i class="fas fa-hand-holding-medical"></i>
                    </div>
                    <div class="stat-number">{{ $data['blood_requests']['total'] }}</div>
                    <div class="stat-label">Blood Requests</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon" style="background-color: var(--warning);">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                    <div class="stat-number">{{ $data['disbursements']['total'] }}</div>
                    <div class="stat-label">Disbursements</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon" style="background-color: var(--secondary);">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-number">{{ $data['donors']['total'] }}</div>
                    <div class="stat-label">Total Donors</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon" style="background-color: var(--primary);">
                        <i class="fas fa-user-md"></i>
                    </div>
                    <div class="stat-number">{{ $data['staff']['total'] }}</div>
                    <div class="stat-label">Staff Members</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon" style="background-color: var(--danger);">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stat-number">{{ $data['performance']['fulfillment_rate'] }}%</div>
                    <div class="stat-label">Fulfillment Rate</div>
                </div>
            </div>

            <!-- Performance Metrics -->
            <div class="performance-grid">
                <div class="performance-card">
                    <div class="performance-title">
                        <i class="fas fa-chart-line me-2"></i>Donation Rate
                    </div>
                    <div class="performance-value">{{ $data['performance']['donation_rate'] }}</div>
                    <div class="performance-unit">donations per day</div>
                </div>
                
                <div class="performance-card">
                    <div class="performance-title">
                        <i class="fas fa-clock me-2"></i>Response Time
                    </div>
                    <div class="performance-value">{{ $data['performance']['response_time'] }}</div>
                    <div class="performance-unit">hours average</div>
                </div>
                
            </div>

            <!-- Charts Section -->
            <div class="row">
                <div class="col-md-6">
                    <div class="chart-section">
                        <div class="chart-title">
                            <i class="fas fa-chart-pie me-2"></i>Donations by Blood Type
                        </div>
                        <canvas id="donationsChart" width="400" height="200"></canvas>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="chart-section">
                        <div class="chart-title">
                            <i class="fas fa-chart-bar me-2"></i>Monthly Donation Trends
                        </div>
                        <canvas id="trendsChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="chart-section">
                        <div class="chart-title">
                            <i class="fas fa-chart-doughnut me-2"></i>Request Status Distribution
                        </div>
                        <canvas id="requestsChart" width="400" height="200"></canvas>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="chart-section">
                        <div class="chart-title">
                            <i class="fas fa-chart-pie me-2"></i>Staff by Role
                        </div>
                        <canvas id="staffChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Donations by Blood Type Chart
        const donationsCtx = document.getElementById('donationsChart').getContext('2d');
        const donationsChart = new Chart(donationsCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($data['blood_groups']->pluck('name')) !!},
                datasets: [{
                    data: {!! json_encode($data['blood_groups']->map(function($bg) use ($data) { 
                        return $data['donations']['by_blood_type'][$bg->id]->total ?? 0; 
                    })) !!},
                    backgroundColor: [
                        '#e74c3c', '#3498db', '#2ecc71', '#f39c12',
                        '#9b59b6', '#1abc9c', '#34495e', '#e67e22'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Monthly Trends Chart
        const trendsCtx = document.getElementById('trendsChart').getContext('2d');
        const trendsChart = new Chart(trendsCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($data['donations']['monthly_trend']->pluck('month')) !!},
                datasets: [{
                    label: 'Donations',
                    data: {!! json_encode($data['donations']['monthly_trend']->pluck('total')) !!},
                    borderColor: '#3498db',
                    backgroundColor: 'rgba(52, 152, 219, 0.1)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Request Status Chart
        const requestsCtx = document.getElementById('requestsChart').getContext('2d');
        const requestsChart = new Chart(requestsCtx, {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Approved', 'Rejected'],
                datasets: [{
                    data: [
                        {{ $data['blood_requests']['pending'] }},
                        {{ $data['blood_requests']['approved'] }},
                        {{ $data['blood_requests']['rejected'] }}
                    ],
                    backgroundColor: ['#f39c12', '#27ae60', '#e74c3c']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Staff by Role Chart
        const staffCtx = document.getElementById('staffChart').getContext('2d');
        const staffChart = new Chart(staffCtx, {
            type: 'pie',
            data: {
                labels: {!! json_encode(collect($data['staff']['by_role'])->keys()->map(function($role) { 
                    return ucfirst($role); 
                })) !!},
                datasets: [{
                    data: {!! json_encode(collect($data['staff']['by_role'])->values()->pluck('total')) !!},
                    backgroundColor: [
                        '#e74c3c', '#3498db', '#2ecc71', '#f39c12',
                        '#9b59b6', '#1abc9c'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
</body>
</html> 