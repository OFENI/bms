<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reports & Analytics | LifeStream Blood Bank</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>

  <style>
    :root {
      --primary-red: #dc2626;
      --dark-red: #b91c1c;
      --light-red: #fee2e2;
      --text-dark: #1f2937;
      --text-light: #6b7280;
    }

    body {
      font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
      background-color: #f9fafb;
      color: var(--text-dark);
      transition: margin-left 0.3s;
      max-width: 100%;
      overflow-x: hidden;
    }

    .page-container {
      max-width: 1600px;
      margin: 0 auto;
      position: relative;
    }

    .top-navbar {
      background-color: white;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      padding: 0.5rem 1rem;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1030;
      display: flex;
      justify-content: space-between;
      align-items: center;
      max-width: 1600px;
      margin: 0 auto;
    }

    .navbar-brand {
      font-weight: 700;
      color: var(--primary-red);
      display: flex;
      align-items: center;
      gap: 10px;
      margin-right: 20px;
    }

    .side-navbar {
      background-color: white;
      height: 100vh;
      width: 250px;
      position: fixed;
      top: 56px;
      left: 0;
      box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
      transition: all 0.3s ease-in-out;
      z-index: 1020;
      overflow-y: auto;
    }

    .main-content {
      margin-left: 250px;
      margin-top: 56px;
      padding: 20px;
      transition: margin-left 0.3s;
      max-width: calc(1600px - 250px);
    }

    .dashboard-card {
      background-color: white;
      border-radius: 10px;
      padding: 20px;
      margin-bottom: 20px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
      border-top: 3px solid var(--primary-red);
      max-width: 100%;
    }

    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 15px;
      margin-bottom: 20px;
      max-width: 100%;
    }

    .chart-container {
      background: white;
      border-radius: 10px;
      padding: 20px;
      margin-bottom: 20px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
      max-width: 100%;
    }

    .grid-container {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
      margin-bottom: 20px;
      max-width: 100%;
    }

    /* Responsive adjustments */
    @media (max-width: 1200px) {
      .page-container {
        max-width: 1200px;
      }
      .main-content {
        max-width: calc(1200px - 250px);
      }
    }

    @media (max-width: 992px) {
      .side-navbar {
        transform: translateX(-100%);
        width: 250px;
      }
      
      body.collapsed .side-navbar {
        transform: translateX(0);
      }
      
      .main-content {
        margin-left: 0;
        max-width: 100%;
      }
      
      body.collapsed .main-content {
        margin-left: 0;
      }
      
      .grid-container {
        grid-template-columns: 1fr;
      }
    }

    @media (max-width: 768px) {
      .stats-grid {
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
      }
    }

    @media (max-width: 576px) {
      .stats-grid {
        grid-template-columns: 1fr 1fr;
      }
    }

    /* Navigation Styles */
    .nav-menu {
      padding: 15px;
    }

    .nav-item {
      margin-bottom: 5px;
    }

    .nav-link {
      color: var(--text-dark);
      padding: 10px 15px;
      border-radius: 6px;
      display: flex;
      align-items: center;
      gap: 10px;
      text-decoration: none;
      transition: all 0.2s;
    }

    .nav-link:hover, .nav-link.active {
      background-color: var(--light-red);
      color: var(--primary-red);
    }

    .nav-link.active {
      font-weight: 600;
    }

    .nav-link i {
      width: 20px;
      text-align: center;
    }

    body.collapsed .side-navbar {
      width: 70px;
    }

    body.collapsed .nav-link span {
      display: none;
    }

    body.collapsed .nav-link {
      justify-content: center;
    }

    body.collapsed .main-content {
      margin-left: 70px;
    }

    .toggle-btn {
      background: none;
      border: none;
      font-size: 1.25rem;
      color: var(--text-dark);
      cursor: pointer;
      padding: 5px 10px;
      border-radius: 4px;
      transition: all 0.2s;
    }

    .toggle-btn:hover {
      color: var(--primary-red);
      background-color: var(--light-red);
    }

    .user-menu {
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .user-avatar {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background-color: var(--light-red);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--primary-red);
      font-weight: bold;
    }

    .notification-bell {
      position: relative;
      color: var(--text-light);
      font-size: 1.1rem;
      cursor: pointer;
    }

    .notification-badge {
      position: absolute;
      top: -5px;
      right: -5px;
      background-color: var(--primary-red);
      color: white;
      border-radius: 50%;
      width: 18px;
      height: 18px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 10px;
      font-weight: bold;
    }

    .dropdown-menu {
      border: none;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      border-radius: 8px;
      padding: 5px 0;
    }

    .dropdown-item {
      padding: 8px 15px;
      font-size: 0.9rem;
    }

    .dropdown-item:hover {
      background-color: #f8f9fa;
    }

    .dropdown-divider {
      margin: 5px 0;
    }

    .card-title {
      font-size: 1.1rem;
      font-weight: 600;
      margin-bottom: 15px;
      color: var(--text-dark);
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .card-title i {
      color: var(--primary-red);
    }

    .stat-card {
      background-color: white;
      border-radius: 8px;
      padding: 15px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
      border-top: 3px solid var(--primary-red);
      transition: all 0.3s ease;  
      display: block;
      text-decoration: none;
      color: inherit;
    }

    .stat-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 4px 12px rgba(220, 38, 38, 0.15);
    }

    .stat-title {
      font-size: 0.9rem;
      color: var(--text-light);
      margin-bottom: 5px;
    }

    .stat-value {
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--primary-red);
      margin-bottom: 5px;
    }

    .stat-value i {
      font-size: 1.8rem;
    }

    .stat-desc {
      font-size: 0.8rem;
      color: var(--text-light);
    }

    .action-card {
      cursor: pointer;
    }

    .action-card:hover {
      border-top-color: var(--dark-red);
    }

    .action-card .stat-value i {
      transition: color 0.3s;
    }

    .action-card:hover .stat-value i {
      color: var(--dark-red);
    }

    .recent-donations {
      background-color: white;
      border-radius: 10px;
      padding: 20px;
      margin-bottom: 25px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    .donations-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 15px;
    }

    .donations-title {
      font-size: 1.1rem;
      font-weight: 600;
    }

    .donations-table {
      width: 100%;
      border-collapse: collapse;
    }

    .donations-table th {
      text-align: left;
      padding: 10px;
      background-color: #f9fafb;
      color: var(--text-light);
      font-weight: 500;
      font-size: 0.8rem;
    }

    .donations-table td {
      padding: 12px 10px;
      border-bottom: 1px solid #f3f4f6;
      font-size: 0.9rem;
    }

    .donation-status {
      padding: 4px 8px;
      border-radius: 12px;
      font-size: 0.8rem;
      font-weight: 500;
    }

    .status-completed {
      background-color: #dcfce7;
      color: #16a34a;
    }
    
    .status-pending {
      background-color: #fffbeb;
      color: #d97706;
    }
    
    .status-critical {
      background-color: #fee2e2;
      color: #dc2626;
    }

    .action-btn {
      background: none;
      border: none;
      color: var(--primary-red);
      cursor: pointer;
      font-size: 0.9rem;
      padding: 0;
      margin-left: 8px;
    }

    .current-date {
      font-size: 0.9rem;
      color: var(--text-light);
    }

    .chart-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 15px;
    }
    
    .chart-title {
      font-size: 1.1rem;
      font-weight: 600;
      color: var(--text-dark);
    }
    
    .chart-actions {
      display: flex;
      gap: 10px;
    }
    
    .chart-select {
      border: 1px solid #e5e7eb;
      border-radius: 6px;
      padding: 5px 10px;
      font-size: 0.85rem;
    }
    
    /* Reports Page Specific Styles */
    .report-filters {
      background-color: white;
      border-radius: 10px;
      padding: 20px;
      margin-bottom: 25px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
      border-top: 3px solid var(--primary-red);
    }
    
    .filter-row {
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
      margin-bottom: 15px;
    }
    
    .filter-group {
      flex: 1;
      min-width: 200px;
    }
    
    .filter-label {
      display: block;
      margin-bottom: 5px;
      font-size: 0.9rem;
      color: var(--text-light);
    }
    
    .filter-select {
      width: 100%;
      padding: 8px 12px;
      border: 1px solid #e5e7eb;
      border-radius: 6px;
      background-color: #fff;
      font-size: 0.9rem;
    }
    
    .chart-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
      gap: 20px;
      margin-bottom: 20px;
    }
    
    .chart-card {
      background-color: white;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
      border-top: 3px solid var(--primary-red);
    }
    
    .chart-placeholder {
      height: 300px;
      display: flex;
      align-items: center;
      justify-content: center;
      background-color: #f0f0f0;
      border-radius: 6px;
      margin-top: 15px;
      position: relative;
      border: 2px solid #e5e7eb;
      min-height: 300px;
      overflow: visible;
    }
    
    /* Debug styles - remove after fixing */
    .chart-placeholder::before {
      content: 'Chart Container';
      position: absolute;
      top: 5px;
      right: 5px;
      background: rgba(0,0,0,0.7);
      color: white;
      padding: 2px 6px;
      border-radius: 3px;
      font-size: 10px;
      z-index: 10;
    }
    
    .chart-placeholder canvas {
      max-width: 100%;
      max-height: 100%;
      display: block;
    }
    
    .export-actions {
      display: flex;
      justify-content: flex-end;
      gap: 10px;
      margin-top: 20px;
    }
    
    .export-btn {
      padding: 8px 15px;
      border-radius: 6px;
      font-size: 0.9rem;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 8px;
      text-decoration: none;
      border: none;
    }
    
    .export-pdf {
      background-color: var(--primary-red);
      color: white;
    }
    
    .export-csv {
      background-color: white;
      color: var(--primary-red);
      border: 1px solid var(--primary-red);
    }
    
    .export-btn:hover {
      opacity: 0.9;
      transform: translateY(-1px);
      transition: all 0.2s ease;
    }
    
    .export-actions .dropdown-menu {
      border: 1px solid #e5e7eb;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      border-radius: 8px;
      padding: 5px 0;
    }
    
    .export-actions .dropdown-item {
      padding: 8px 15px;
      font-size: 0.9rem;
      color: var(--text-dark);
      text-decoration: none;
    }
    
    .export-actions .dropdown-item:hover {
      background-color: var(--light-red);
      color: var(--primary-red);
    }
    
    .report-summary {
      background-color: #fef2f2;
      border-left: 4px solid var(--primary-red);
      padding: 15px;
      border-radius: 0 6px 6px 0;
      margin: 20px 0;
    }
    
    .summary-title {
      font-weight: 600;
      margin-bottom: 10px;
      color: var(--dark-red);
    }
    
    .summary-content {
      font-size: 0.9rem;
      line-height: 1.6;
    }
    
    .summary-highlight {
      color: var(--dark-red);
      font-weight: 600;
    }
    
    /* Filter specific styles */
    .filter-select:focus {
      border-color: var(--primary-red);
      box-shadow: 0 0 0 0.2rem rgba(220, 38, 38, 0.25);
    }
    
    .filter-loading {
      opacity: 0.6;
      pointer-events: none;
    }
    
    .filter-loading .chart-placeholder {
      position: relative;
    }
    
    .filter-loading .chart-placeholder::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(255, 255, 255, 0.8);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 10;
    }
    
    .filter-loading .chart-placeholder::before {
      content: 'Updating charts...';
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: var(--primary-red);
      color: white;
      padding: 8px 16px;
      border-radius: 20px;
      font-size: 12px;
      z-index: 11;
    }
    
    .active-filters {
      background-color: #e3f2fd;
      border-left: 4px solid #2196f3;
      padding: 12px 16px;
      border-radius: 0 6px 6px 0;
      margin: 15px 0;
      font-size: 0.9rem;
    }
    
    .active-filters strong {
      color: #1976d2;
    }
    
    .filter-badge {
      display: inline-block;
      background-color: var(--primary-red);
      color: white;
      padding: 2px 8px;
      border-radius: 12px;
      font-size: 0.8rem;
      margin: 2px;
    }
  </style>
</head>
<body>
  <div class="page-container">
    <!-- Top Navigation Bar -->
    <nav class="top-navbar">
      <div class="d-flex align-items-center">
        <button class="toggle-btn me-2" id="toggleSidebar">
          <i class="fas fa-bars"></i>
        </button>
        <a class="navbar-brand" href="#">
          <i class="fas fa-tint"></i>
          <span>Damu Salama</span>
          <span>Admin Panel</span>
        </a>
      </div>
      <div class="current-date">July 6, 2025</div>
      
      <div class="user-menu">
      <div class="dropdown notification-bell position-relative">
    <i class="fas fa-bell fa-lg dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" role="button"></i>

    @if(isset($totalAlerts) && $totalAlerts > 0)
        <span class="notification-badge bg-danger text-white position-absolute top-0 start-100 translate-middle rounded-circle">
            {{ $totalAlerts }}
        </span>
    @endif

    <ul class="dropdown-menu dropdown-menu-end p-3 shadow" style="min-width: 350px;">
        <li class="mb-2"><strong>Notifications ({{ $totalAlerts }})</strong></li>

        @forelse ($notifications as $notification)
            <li>
                <a href="{{ $notification['link'] }}" class="dropdown-item">
                    {{ $notification['message'] }}
                </a>
            </li>
        @empty
            <li class="text-muted">No new notifications</li>
        @endforelse
    </ul>
</div>
        <div class="dropdown">
          <div class="d-flex align-items-center dropdown-toggle" data-bs-toggle="dropdown">
            <div class="user-avatar">A</div>
            <span class="ms-2 d-none d-md-inline">Administrator</span>
          </div>
          <ul class="dropdown-menu dropdown-menu-end">
            <li>
              <a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profile</a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <a class="dropdown-item text-danger" href="#"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
            </li>

            <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<!-- SweetAlert2 Logout Confirmation -->
<script>
    document.getElementById('logoutBtn').addEventListener('click', function(event) {
        event.preventDefault();

        Swal.fire({
            title: 'Are you sure?',
            text: "You will be logged out!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, log out',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logoutForm').submit();
            }
        });
    });
</script>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Left Side Navigation -->
    <div class="side-navbar">
      <div class="nav-menu">
      <div class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </div>

                <div class="nav-item">
                     <a href="{{ route('admin.users') }}" class="nav-link @if(request()->routeIs('admin.users')) active @endif">
                     <i class="fas fa-users"></i>
                     <span>User Management</span>
                     </a>
                </div>

        <div class="nav-item">
          <a href="{{ route('admin.institutions') }}" class="nav-link">
            <i class="fas fa-hospital"></i>
            <span>Institutions</span>
          </a>
        </div>
        <div class="nav-item">
                    <a href="{{ route('admin.donors.index') }}"
                    class="nav-link @if(request()->routeIs('admin.donors')) active @endif">
                    <i class="fas fa-hand-holding-heart"></i>
                     <span>Donors</span>
                    </a>

                </div>
                <div class="nav-item">
  <a href="{{ route('admin.blood.inventory') }}" class="nav-link">
    <i class="fas fa-tint"></i>
    <span>Blood Inventory</span>
  </a>
</div>
        <div class="nav-item">
          <a href="#" class="nav-link active">
            <i class="fas fa-chart-line"></i>
            <span>Reports & Analytics</span>
          </a>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
      <!-- Breadcrumb -->
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Reports & Analytics</li>
        </ol>
      </nav>

      <!-- Page Header -->
      <div class="dashboard-card">
        <div class="d-flex align-items-center">
          <div class="me-3">
            <i class="fas fa-chart-pie text-danger" style="font-size: 2rem;"></i>
          </div>
          <div>
            <h3>Reports & Analytics</h3>
            <p class="mb-0">Analyze donation trends, inventory status, and system performance.</p>
          </div>
        </div>
      </div>

      @if(isset($error))
        <div class="alert alert-danger" role="alert">
          <i class="fas fa-exclamation-triangle me-2"></i>
          {{ $error }}
        </div>
      @endif

      @if(session('success'))
        <div class="alert alert-success" role="alert">
          <i class="fas fa-check-circle me-2"></i>
          {{ session('success') }}
        </div>
      @endif

      <!-- Report Filters -->
      <form method="GET" action="{{ route('admin.reports') }}" id="reportFiltersForm">
        <div class="report-filters">
          <h4><i class="fas fa-filter me-2"></i>Report Filters</h4>
          <div class="filter-row">
            <div class="filter-group">
              <label class="filter-label">Date Range</label>
              <select class="filter-select" name="date_range" id="dateRange">
                <option value="last_7_days" {{ $dateRange === 'last_7_days' ? 'selected' : '' }}>Last 7 Days</option>
                <option value="last_30_days" {{ $dateRange === 'last_30_days' ? 'selected' : '' }}>Last 30 Days</option>
                <option value="last_90_days" {{ $dateRange === 'last_90_days' ? 'selected' : '' }}>Last 90 Days</option>
                <option value="year_to_date" {{ $dateRange === 'year_to_date' ? 'selected' : '' }}>Year to Date</option>
                <option value="custom_range" {{ $dateRange === 'custom_range' ? 'selected' : '' }}>Custom Range</option>
              </select>
            </div>
            <div class="filter-group">
              <label class="filter-label">Blood Type</label>
              <select class="filter-select" name="blood_type" id="bloodType">
                <option value="all" {{ $bloodType === 'all' ? 'selected' : '' }}>All Types</option>
                @foreach($bloodLabels as $bloodLabel)
                  <option value="{{ $bloodLabel }}" {{ $bloodType === $bloodLabel ? 'selected' : '' }}>{{ $bloodLabel }}</option>
                @endforeach
              </select>
            </div>
            <div class="filter-group">
              <label class="filter-label">Location</label>
              <select class="filter-select" name="location" id="location">
                <option value="all" {{ $location === 'all' ? 'selected' : '' }}>All Locations</option>
                @foreach($institutions as $institution)
                  <option value="{{ $institution }}" {{ $location === $institution ? 'selected' : '' }}>{{ $institution }}</option>
                @endforeach
              </select>
            </div>
            <div class="filter-group">
              <label class="filter-label">Report Type</label>
              <select class="filter-select" name="report_type" id="reportType">
                <option value="summary" {{ $reportType === 'summary' ? 'selected' : '' }}>Summary Report</option>
                <option value="detailed" {{ $reportType === 'detailed' ? 'selected' : '' }}>Detailed Analysis</option>
                <option value="forecast" {{ $reportType === 'forecast' ? 'selected' : '' }}>Inventory Forecast</option>
              </select>
            </div>
          </div>
          <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-danger me-2" id="applyFilters">
              <i class="fas fa-sync me-1"></i> Apply Filters
            </button>
            <button type="button" class="btn btn-outline-danger" id="clearFilters">
              <i class="fas fa-times me-1"></i> Clear
            </button>
          </div>
        </div>
      </form>

<!-- Report Summary -->
<div class="report-summary">
    <div class="summary-title"><i class="fas fa-info-circle me-2"></i>Key Insights</div>
    <div class="summary-content">
        • <span class="summary-highlight">Total donations</span> in the last 30 days: <strong>{{ $last30DaysTotal }}</strong>
        ({{ $donationGrowth }}% {{ $donationGrowth >= 0 ? 'increase' : 'decrease' }} from previous month)<br>

        • <span class="summary-highlight">{{ $mostDonatedBloodGroup }}</span> remains the most donated blood type
        ({{ $mostDonatedPercentage }}% of all donations)<br>

        • <span class="summary-highlight">Critical inventory levels</span> detected for
        {{ implode(', ', $criticalBloodNames) ?: 'none' }}<br>

        • <span class="summary-highlight">Top-performing center</span>: {{ $topCenterName }} with {{ $topCenterDonations }} donations this month
    </div>
</div>


      <!-- Charts Grid -->
      <div class="chart-grid">
     
        <!-- Donation Trends -->
        <div class="chart-card">
          <div class="chart-header">
            <h5 class="chart-title"><i class="fas fa-chart-line me-2"></i>Monthly Donation Trends</h5>
            <div class="chart-actions">
              <select class="chart-select">
                <option>By Volume</option>
                <option>By Donor Type</option>
                <option>By Location</option>
              </select>
            </div>
          </div>
          <div class="chart-placeholder">
            <canvas id="donationTrendsChart"></canvas>
            <div style="position: absolute; top: 10px; left: 10px; color: #666; font-size: 12px;">Donation Trends Chart</div>
            <div id="donationChartFallback" style="display: none; text-align: center; color: #666;">
              <i class="fas fa-chart-line" style="font-size: 3rem; margin-bottom: 1rem;"></i>
              <p>Chart loading...</p>
            </div>
          </div>
        </div>

        <!-- Blood Type Distribution -->
        <div class="chart-card">
          <div class="chart-header">
            <h5 class="chart-title"><i class="fas fa-pie-chart me-2"></i>Blood Type Distribution</h5>
            <div class="chart-actions">
              <select class="chart-select" id="bloodTypeSelect">
                <option>Donations</option>
                <option>Inventory</option>
                <option>Demand</option>
              </select>
            </div>
          </div>
          <div class="chart-placeholder">
            <canvas id="bloodTypeChart"></canvas>
            <div style="position: absolute; top: 10px; left: 10px; color: #666; font-size: 12px;">Blood Type Chart</div>
          </div>
        </div>

        <!-- Donor Demographics -->
        <div class="chart-card">
          <div class="chart-header">
            <h5 class="chart-title"><i class="fas fa-user-friends me-2"></i>Donor Demographics</h5>
            <div class="chart-actions">
              <select class="chart-select">
                <option>Age Groups</option>
                <option>Gender</option>
                <option>Frequency</option>
              </select>
            </div>
          </div>
          <div class="chart-placeholder">
            <canvas id="demographicsChart"></canvas>
          </div>
        </div>

        <!-- Inventory Levels -->
        <div class="chart-card">
          <div class="chart-header">
            <h5 class="chart-title"><i class="fas fa-vial me-2"></i>Inventory Levels</h5>
            <div class="chart-actions">
              <select class="chart-select">
                <option>Last 30 Days</option>
                <option>Last 90 Days</option>
                <option>By Location</option>
              </select>
            </div>
          </div>
          <div class="chart-placeholder">
            <canvas id="inventoryChart"></canvas>
          </div>
        </div>

        <!-- Center Performance -->
        <div class="chart-card">
          <div class="chart-header">
            <h5 class="chart-title"><i class="fas fa-hospital me-2"></i>Center Performance</h5>
            <div class="chart-actions">
              <select class="chart-select">
                <option>By Donations</option>
                <option>By Efficiency</option>
                <option>By Donor Satisfaction</option>
              </select>
            </div>
          </div>
          <div class="chart-placeholder">
            <canvas id="centerChart"></canvas>
          </div>
        </div>



      <!-- Export Actions -->
      <div class="export-actions">
        <div class="dropdown">
          <button class="export-btn export-pdf dropdown-toggle" data-bs-toggle="dropdown">
            <i class="fas fa-file-pdf"></i> Export PDF Report
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('admin.reports.pdf', ['type' => 'comprehensive', 'date_range' => $dateRange, 'blood_type' => $bloodType, 'location' => $location, 'report_type' => $reportType]) }}"><i class="fas fa-chart-pie me-2"></i>Comprehensive Report</a></li>
            <li><a class="dropdown-item" href="{{ route('admin.reports.pdf', ['type' => 'donations', 'date_range' => $dateRange, 'blood_type' => $bloodType, 'location' => $location, 'report_type' => $reportType]) }}"><i class="fas fa-hand-holding-heart me-2"></i>Donations Report</a></li>
            <li><a class="dropdown-item" href="{{ route('admin.reports.pdf', ['type' => 'inventory', 'date_range' => $dateRange, 'blood_type' => $bloodType, 'location' => $location, 'report_type' => $reportType]) }}"><i class="fas fa-vial me-2"></i>Inventory Report</a></li>
            <li><a class="dropdown-item" href="{{ route('admin.reports.pdf', ['type' => 'analytics', 'date_range' => $dateRange, 'blood_type' => $bloodType, 'location' => $location, 'report_type' => $reportType]) }}"><i class="fas fa-chart-line me-2"></i>Analytics Report</a></li>
          </ul>
        </div>
        <div class="dropdown">
          <button class="export-btn export-csv dropdown-toggle" data-bs-toggle="dropdown">
            <i class="fas fa-file-csv"></i> Export CSV Data
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('admin.reports.csv', ['type' => 'comprehensive', 'date_range' => $dateRange, 'blood_type' => $bloodType, 'location' => $location, 'report_type' => $reportType]) }}"><i class="fas fa-chart-pie me-2"></i>Comprehensive Data</a></li>
            <li><a class="dropdown-item" href="{{ route('admin.reports.csv', ['type' => 'donations', 'date_range' => $dateRange, 'blood_type' => $bloodType, 'location' => $location, 'report_type' => $reportType]) }}"><i class="fas fa-hand-holding-heart me-2"></i>Donations Data</a></li>
            <li><a class="dropdown-item" href="{{ route('admin.reports.csv', ['type' => 'inventory', 'date_range' => $dateRange, 'blood_type' => $bloodType, 'location' => $location, 'report_type' => $reportType]) }}"><i class="fas fa-vial me-2"></i>Inventory Data</a></li>
            <li><a class="dropdown-item" href="{{ route('admin.reports.csv', ['type' => 'analytics', 'date_range' => $dateRange, 'blood_type' => $bloodType, 'location' => $location, 'report_type' => $reportType]) }}"><i class="fas fa-chart-line me-2"></i>Analytics Data</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    console.log('Reports page script starting...');
    document.addEventListener('DOMContentLoaded', function() {
      console.log('DOM Content Loaded - starting chart initialization...');
      // Toggle sidebar
      const toggleBtn = document.getElementById('toggleSidebar');
      toggleBtn.addEventListener('click', function() {
        document.body.classList.toggle('collapsed');
      });

      // Chart data from controller
      const donationMonths = @json($months ?? []);
      const donationCounts = @json($donationCounts ?? []);
      const bloodLabels = @json($bloodLabels ?? []);
      const donationsByBloodType = @json($mappedDonationsByBloodType ?? []);
      const inventoryByBloodType = @json($mappedInventoryByBloodType ?? []);
      const demandByBloodType = @json($mappedDemandByBloodType ?? []);
      const ageGroups = @json($ageGroups ?? []);
      const centerNames = @json($centerNames ?? []);
      const centerTotals = @json($centerTotals ?? []);

      // Debug logging
      console.log('Chart Data:', {
        donationMonths,
        donationCounts,
        bloodLabels,
        donationsByBloodType,
        inventoryByBloodType,
        demandByBloodType,
        ageGroups,
        centerNames,
        centerTotals
      });

      // Test if Chart.js is loaded
      if (typeof Chart === 'undefined') {
        console.error('Chart.js is not loaded!');
        return;
      } else {
        console.log('Chart.js is loaded successfully');
      }

      // Add a timeout to check if charts are loading
      setTimeout(() => {
        const charts = document.querySelectorAll('canvas[id$="Chart"]');
        console.log('Found', charts.length, 'chart canvases');
        charts.forEach((canvas, index) => {
          console.log(`Chart ${index + 1}:`, canvas.id, 'Dimensions:', canvas.offsetWidth, 'x', canvas.offsetHeight);
        });
        
        // Check if any charts have zero dimensions
        const zeroDimensionCharts = Array.from(charts).filter(canvas => 
          canvas.offsetWidth === 0 || canvas.offsetHeight === 0
        );
        if (zeroDimensionCharts.length > 0) {
          console.warn('Charts with zero dimensions:', zeroDimensionCharts.map(c => c.id));
        }
      }, 1000);

      // Create a simple test chart to verify Chart.js is working
      const testCanvas = document.createElement('canvas');
      testCanvas.id = 'testChart';
      testCanvas.style.width = '100px';
      testCanvas.style.height = '100px';
      document.body.appendChild(testCanvas);
      
      try {
        const testCtx = testCanvas.getContext('2d');
        new Chart(testCtx, {
          type: 'doughnut',
          data: {
            labels: ['Test'],
            datasets: [{
              data: [1],
              backgroundColor: ['#e74c3c']
            }]
          },
          options: {
            responsive: false,
            maintainAspectRatio: false
          }
        });
        console.log('Test chart created successfully');
        // Remove test chart after 2 seconds
        setTimeout(() => {
          document.body.removeChild(testCanvas);
        }, 2000);
      } catch (error) {
        console.error('Error creating test chart:', error);
      }

      // Helper function for blood type data mapping - this will be handled server-side now
      // The data is already properly mapped in the controller

      // 1. Donation Trends Chart
      console.log('Looking for donationTrendsChart element...');
      const donationChartElement = document.getElementById('donationTrendsChart');
      if (donationChartElement) {
        console.log('Found donationTrendsChart element');
        console.log('Chart element dimensions:', donationChartElement.offsetWidth, 'x', donationChartElement.offsetHeight);
        try {
          const donationCtx = donationChartElement.getContext('2d');
                    const donationChart = new Chart(donationCtx, {
            type: 'line',
            data: {
              labels: donationMonths.length > 0 ? donationMonths : ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
              datasets: [{
                label: 'Total Donations',
                data: donationCounts.length > 0 ? donationCounts : [1120, 1250, 980, 1190, 1320, 1450, 1280],
                borderColor: 'rgba(220, 38, 38, 1)',
                backgroundColor: 'rgba(220, 38, 38, 0.1)',
                tension: 0.3,
                fill: true
              }]
            },
            options: {
              responsive: true,
              maintainAspectRatio: false,
              plugins: {
                legend: {
                  position: 'top',
                }
              },
              scales: {
                y: {
                  beginAtZero: true,
                  title: {
                    display: true,
                    text: 'Donations'
                  }
                }
              }
            }
          });
          console.log('Donation trends chart created successfully');
          
          // Add a visual indicator that the chart was created
          const fallback = document.getElementById('donationChartFallback');
          if (fallback) {
            fallback.style.display = 'block';
            fallback.innerHTML = '<i class="fas fa-check-circle" style="font-size: 3rem; margin-bottom: 1rem; color: #28a745;"></i><p>Chart loaded successfully</p>';
            setTimeout(() => {
              fallback.style.display = 'none';
            }, 2000);
          }
        } catch (error) {
          console.error('Error creating donation trends chart:', error);
          // Show fallback message
          const fallback = document.getElementById('donationChartFallback');
          if (fallback) {
            fallback.style.display = 'block';
            fallback.innerHTML = '<i class="fas fa-exclamation-triangle" style="font-size: 3rem; margin-bottom: 1rem; color: #e74c3c;"></i><p>Chart failed to load</p>';
          }
        }
      }

      // 2. Blood Type Distribution Chart
      if (document.getElementById('bloodTypeChart')) {
        const datasets = {
          donations: donationsByBloodType,
          inventory: inventoryByBloodType,
          demand: demandByBloodType,
        };

        let current = 'donations';
        const bloodTypeCtx = document.getElementById('bloodTypeChart').getContext('2d');
        const bloodTypeChart = new Chart(bloodTypeCtx, {
          type: 'pie',
          data: {
            labels: bloodLabels.length > 0 ? bloodLabels : ['O+', 'A+', 'B+', 'AB+', 'O-', 'A-', 'B-', 'AB-'],
            datasets: [{
              data: datasets[current],
              backgroundColor: [
                '#e74c3c','#3498db','#2ecc71','#9b59b6',
                '#f1c40f','#e67e22','#1abc9c','#34495e'
              ],
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                position: 'bottom',
              }
            }
          }
        });

        // Wire up the dropdown
        const bloodTypeSelect = document.getElementById('bloodTypeSelect');
        if (bloodTypeSelect) {
          bloodTypeSelect.addEventListener('change', function() {
            current = this.value.toLowerCase();
            bloodTypeChart.data.datasets[0].data = datasets[current];
            bloodTypeChart.update();
          });
        }
      }

      // 3. Demographics Chart
      if (document.getElementById('demographicsChart')) {
        const demographicsCtx = document.getElementById('demographicsChart').getContext('2d');
        new Chart(demographicsCtx, {
          type: 'bar',
          data: {
            labels: Object.keys(ageGroups).length > 0 ? Object.keys(ageGroups) : ['18-24', '25-34', '35-44', '45-54', '55-64', '65+'],
            datasets: [{
              label: 'Donors by Age',
              data: Object.values(ageGroups).length > 0 ? Object.values(ageGroups) : [22, 35, 28, 20, 12, 8],
              backgroundColor: 'rgba(220, 38, 38, 0.7)',
              borderColor: 'rgba(220, 38, 38, 1)',
              borderWidth: 1
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
                  text: 'Number of Donors'
                }
              }
            }
          }
        });
      }

      // 4. Inventory Chart
      if (document.getElementById('inventoryChart')) {
        const inventoryCtx = document.getElementById('inventoryChart').getContext('2d');
        new Chart(inventoryCtx, {
          type: 'line',
          data: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            datasets: [
              {
                label: 'O+',
                data: [420, 380, 410, 390],
                borderColor: 'rgba(220, 38, 38, 1)',
                backgroundColor: 'rgba(220, 38, 38, 0.1)',
                tension: 0.3,
                fill: true
              },
              {
                label: 'A+',
                data: [320, 340, 310, 290],
                borderColor: 'rgba(59, 130, 246, 1)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.3,
                fill: true
              },
              {
                label: 'B+',
                data: [180, 170, 160, 155],
                borderColor: 'rgba(16, 185, 129, 1)',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                tension: 0.3,
                fill: true
              }
            ]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                position: 'top',
              }
            },
            scales: {
              y: {
                beginAtZero: false,
                title: {
                  display: true,
                  text: 'Units'
                }
              }
            }
          }
        });
      }

      // 5. Center Performance Chart
      if (document.getElementById('centerChart')) {
        const centerCtx = document.getElementById('centerChart').getContext('2d');
        new Chart(centerCtx, {
          type: 'bar',
          data: {
            labels: centerNames.length > 0 ? centerNames : ['Main Center', 'Westside Clinic', 'North Hospital', 'South Hub'],
            datasets: [
              {
                label: 'Donations',
                data: centerTotals.length > 0 ? centerTotals : [428, 312, 278, 195],
                backgroundColor: 'rgba(220, 38, 38, 0.7)',
                borderColor: 'rgba(220, 38, 38, 1)',
                borderWidth: 1
              },
              {
                label: 'Target',
                data: [400, 300, 280, 200],
                backgroundColor: 'rgba(156, 163, 175, 0.5)',
                borderColor: 'rgba(156, 163, 175, 1)',
                borderWidth: 1,
                type: 'line',
                fill: false
              }
            ]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
              y: {
                beginAtZero: true,
                title: {
                  display: true,
                  text: 'Donations'
                }
              }
            }
          }
        });
      }

      // 6. Forecast Chart
      if (document.getElementById('forecastChart')) {
        const forecastCtx = document.getElementById('forecastChart').getContext('2d');
        new Chart(forecastCtx, {
          type: 'line',
          data: {
            labels: ['Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan'],
            datasets: [
              {
                label: 'Projected Demand',
                data: [1580, 1620, 1700, 1650, 1800, 1750],
                borderColor: 'rgba(220, 38, 38, 1)',
                backgroundColor: 'rgba(220, 38, 38, 0.1)',
                borderDash: [5, 5],
                tension: 0.3,
                fill: true
              },
              {
                label: 'Current Trend',
                data: [1540, null, null, null, null, null],
                borderColor: 'rgba(59, 130, 246, 1)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.3,
                fill: false
              }
            ]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                position: 'top',
              }
            },
            scales: {
              y: {
                beginAtZero: false,
                title: {
                  display: true,
                  text: 'Units'
                }
              }
            }
          }
        });
      }

      // Export functionality
      document.querySelectorAll('.export-actions .dropdown-item').forEach(link => {
        link.addEventListener('click', function(e) {
          const originalText = this.innerHTML;
          this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Generating...';
          this.style.pointerEvents = 'none';
          
          // Reset after 3 seconds if download doesn't start
          setTimeout(() => {
            this.innerHTML = originalText;
            this.style.pointerEvents = 'auto';
          }, 3000);
        });
      });

      // Filter functionality
      const filterForm = document.getElementById('reportFiltersForm');
      const applyFiltersBtn = document.getElementById('applyFilters');
      const clearFiltersBtn = document.getElementById('clearFilters');
      const filterSelects = document.querySelectorAll('.filter-select');

      // Auto-submit form when filters change
      filterSelects.forEach(select => {
        select.addEventListener('change', function() {
          // Show loading state
          applyFiltersBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Applying...';
          applyFiltersBtn.disabled = true;
          
          // Add loading class to main content
          document.querySelector('.main-content').classList.add('filter-loading');
          
          // Submit form after a short delay to allow user to see the loading state
          setTimeout(() => {
            filterForm.submit();
          }, 300);
        });
      });

      // Clear filters functionality
      clearFiltersBtn.addEventListener('click', function() {
        // Show loading state
        clearFiltersBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Clearing...';
        clearFiltersBtn.disabled = true;
        
        // Add loading class to main content
        document.querySelector('.main-content').classList.add('filter-loading');
        
        // Reset all selects to default values
        document.getElementById('dateRange').value = 'last_30_days';
        document.getElementById('bloodType').value = 'all';
        document.getElementById('location').value = 'all';
        document.getElementById('reportType').value = 'summary';
        
        // Submit form to refresh with default filters
        setTimeout(() => {
          filterForm.submit();
        }, 300);
      });

      // Show current filter status
      const currentFilters = [];
      if (document.getElementById('dateRange').value !== 'last_30_days') {
        currentFilters.push('Date: ' + document.getElementById('dateRange').options[document.getElementById('dateRange').selectedIndex].text);
      }
      if (document.getElementById('bloodType').value !== 'all') {
        currentFilters.push('Blood Type: ' + document.getElementById('bloodType').value);
      }
      if (document.getElementById('location').value !== 'all') {
        currentFilters.push('Location: ' + document.getElementById('location').value);
      }
      if (document.getElementById('reportType').value !== 'summary') {
        currentFilters.push('Report Type: ' + document.getElementById('reportType').options[document.getElementById('reportType').selectedIndex].text);
      }

      // Display active filters if any
      if (currentFilters.length > 0) {
        const filterStatus = document.createElement('div');
        filterStatus.className = 'alert alert-info mt-3';
        filterStatus.innerHTML = `
          <i class="fas fa-info-circle me-2"></i>
          <strong>Active Filters:</strong> ${currentFilters.join(', ')}
          <button type="button" class="btn-close float-end" data-bs-dismiss="alert"></button>
        `;
        filterForm.parentNode.insertBefore(filterStatus, filterForm.nextSibling);
      }
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>