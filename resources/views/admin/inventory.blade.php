<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Inventory | LifeStream Blood Bank</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary-red: #dc2626;
            --dark-red: #b91c1c;
            --light-red: #fee2e2;
            --text-dark: #1f2937;
            --text-light: #6b7280;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }
        
        body {
            background-color: #f9fafb;
            min-height: 100vh;
            overflow-x: hidden;
            color: var(--text-dark);
            transition: margin-left 0.3s;
        }
        
        /* Page Container */
        .page-container {
            max-width: 1600px;
            margin: 0 auto;
            position: relative;
        }
        
        /* Top Navigation Bar */
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
        
        /* Left Navigation */
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
        
        /* Main Content */
        .main-content {
            margin-left: 250px;
            margin-top: 56px;
            padding: 20px;
            transition: margin-left 0.3s;
            max-width: calc(1600px - 250px);
        }
        
        /* Dashboard Cards */
        .dashboard-card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border-top: 3px solid var(--primary-red);
            max-width: 100%;
        }
        
        /* Navigation Menu */
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
        
        /* Collapsed sidebar */
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
        
        /* Page Title */
        .page-title {
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .page-title h2 {
            font-size: 1.8rem;
            color: var(--text-dark);
            font-weight: 600;
        }
        
        .btn {
            padding: 10px 20px;
            border-radius: 6px;
            border: none;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
        }
        
        .btn i {
            margin-right: 8px;
        }
        
        .btn-primary {
            background: var(--primary-red);
            color: white;
            border: 1px solid var(--primary-red);
        }
        
        .btn-primary:hover {
            background: var(--dark-red);
            border-color: var(--dark-red);
        }
        
        .btn-outline-secondary {
            background: transparent;
            color: var(--text-dark);
            border: 1px solid #d1d5db;
        }
        
        .btn-outline-secondary:hover {
            background: #f3f4f6;
        }
        
        /* Filter Card */
        .filter-card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            max-width: 100%;
        }
        
        .form-label {
            font-weight: 500;
            color: var(--text-dark);
            margin-bottom: 8px;
        }
        
        .form-control, .form-select {
            border-radius: 6px;
            padding: 0.5rem 0.75rem;
            border: 1px solid #d1d5db;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-red);
            box-shadow: 0 0 0 0.25rem rgba(220, 38, 38, 0.25);
        }
        
        /* Table Card */
        .table-card {
            background-color: white;
            border-radius: 10px;
            padding: 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            overflow: hidden;
            max-width: 100%;
        }
        
        .card-header {
            background-color: white;
            padding: 20px;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .card-header h3 {
            font-size: 1.3rem;
            color: var(--text-dark);
            margin: 0;
        }
        
        .card-body {
            padding: 20px;
        }
        
        .card-footer {
            background-color: white;
            padding: 15px 20px;
            border-top: 1px solid #f3f4f6;
        }
        
        /* Table Styling */
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table th, .table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #f3f4f6;
        }
        
        .table th {
            background-color: #f9fafb;
            color: var(--text-light);
            font-weight: 500;
            font-size: 0.85rem;
        }
        
        .table tbody tr:hover {
            background-color: #f9fafb;
        }
        
        /* Badges */
        .badge {
            padding: 6px 10px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .bg-primary {
            background-color: #3f51b5 !important;
        }
        
        .bg-info {
            background-color: #3d5afe !important;
        }
        
        .bg-secondary {
            background-color: #78909c !important;
        }
        
        .bg-warning {
            background-color: #ffb300 !important;
        }
        
        .bg-success {
            background-color: #43a047 !important;
        }
        
        .bg-danger {
            background-color: #e53935 !important;
        }
        
        /* Action Buttons */
        .action-btns .btn {
            padding: 6px 10px;
            border-radius: 6px;
        }
        
        .btn-outline-primary {
            color: var(--primary-red);
            border-color: var(--primary-red);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--light-red);
        }
        
        .btn-outline-secondary {
            color: var(--text-dark);
            border-color: #d1d5db;
        }
        
        .btn-outline-secondary:hover {
            background-color: #f3f4f6;
        }
        
        .btn-outline-danger {
            color: var(--primary-red);
            border-color: var(--primary-red);
        }
        
        .btn-outline-danger:hover {
            background-color: var(--light-red);
        }
        
        /* Modal Styling */
        .modal-content {
            border-radius: 10px;
            border: none;
        }
        
        .modal-header {
            border-bottom: 2px solid var(--light-red);
            padding: 1rem 1.5rem;
        }
        
        .modal-title {
            color: var(--primary-red);
            font-weight: 600;
        }
        
        .modal-body {
            padding: 1.5rem;
        }
        
        .modal-footer {
            border-top: 2px solid var(--light-red);
            padding: 1rem 1.5rem;
        }
        
        .current-date {
            font-size: 0.9rem;
            color: var(--text-light);
        }
        
        /* Breadcrumb */
        .breadcrumb {
            background: transparent;
            padding: 0;
            margin-bottom: 20px;
        }
        
        .breadcrumb-item a {
            text-decoration: none;
            color: var(--primary-red);
        }
        
        .breadcrumb-item.active {
            color: var(--text-light);
        }
        
        /* Blood Unit Card */
        .blood-unit-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            border-top: 3px solid var(--primary-red);
        }
        
        .blood-unit-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .blood-unit-header {
            padding: 15px;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            align-items: center;
        }
        
        .blood-type-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 18px;
            font-weight: bold;
        }
        
        .blood-unit-body {
            padding: 15px;
        }
        
        .blood-unit-detail {
            display: flex;
            margin-bottom: 8px;
        }
        
        .blood-unit-label {
            font-weight: 500;
            min-width: 120px;
            color: var(--text-light);
        }
        
        .blood-unit-value {
            flex: 1;
        }
        
        .expiration-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            margin-right: 5px;
            margin-bottom: 5px;
        }
        
        /* Responsive */
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
        }
        
        @media (max-width: 768px) {
            .page-title {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .page-title .d-flex {
                width: 100%;
                justify-content: space-between;
            }
            
            .blood-unit-grid {
                grid-template-columns: repeat(1, 1fr);
            }
        }
        
        @media (max-width: 576px) {
            .filter-card .row > div {
                margin-bottom: 15px;
            }
            
            .filter-card .col-md-3:last-child {
                margin-bottom: 0;
            }
            
            .action-btns {
                flex-wrap: wrap;
                gap: 5px;
            }
            
            .action-btns .btn {
                padding: 5px 8px;
            }
            
            .card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .card-header .d-flex {
                width: 100%;
                justify-content: space-between;
            }
        }
        
        /* Grid Layout */
        .blood-unit-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .view-toggle {
            display: flex;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            overflow: hidden;
        }
        
        .view-toggle-btn {
            padding: 8px 15px;
            background: white;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .view-toggle-btn.active {
            background: var(--light-red);
            color: var(--primary-red);
        }
        
        .view-toggle-btn:first-child {
            border-right: 1px solid #d1d5db;
        }
        
        /* Blood Type Colors */
        .blood-type-Ap { background-color: #ffcdd2; color: #b71c1c; }
        .blood-type-An { background-color: #ffebee; color: #c62828; }
        .blood-type-Bp { background-color: #c8e6c9; color: #2e7d32; }
        .blood-type-Bn { background-color: #e8f5e9; color: #388e3c; }
        .blood-type-Op { background-color: #bbdefb; color: #0d47a1; }
        .blood-type-On { background-color: #e3f2fd; color: #1565c0; }
        .blood-type-ABp { background-color: #e1bee7; color: #6a1b9a; }
        .blood-type-ABn { background-color: #f3e5f5; color: #7b1fa2; }
        
        /* Status Colors */
        .status-available { background-color: #e8f5e9; color: #388e3c; }
        .status-reserved { background-color: #e3f2fd; color: #1565c0; }
        .status-expired { background-color: #ffebee; color: #c62828; }
        .status-used { background-color: #f5f5f5; color: #757575; }
        
        /* Expiration Colors */
        .expiration-safe { background-color: #e8f5e9; color: #388e3c; }
        .expiration-warning { background-color: #fff8e1; color: #ff8f00; }
        .expiration-danger { background-color: #ffebee; color: #c62828; }
        
        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }
        
        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            text-align: center;
        }
        
        .stat-card .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-red);
            margin: 10px 0;
        }
        
        .stat-card .stat-label {
            color: var(--text-light);
            font-size: 0.9rem;
        }
        
        .stat-card .stat-icon {
            font-size: 1.5rem;
            color: var(--primary-red);
            margin-bottom: 10px;
        }
        
        /* Blood Type Distribution */
        .distribution-chart {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border-top: 3px solid var(--primary-red);
            height: 300px;
        }
        
        .progress-container {
            margin-bottom: 15px;
        }
        
        .progress-label {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-size: 0.9rem;
        }
        
        .progress {
            height: 10px;
            border-radius: 5px;
        }
        
        /* Inventory Summary */
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 15px;
            margin-bottom: 25px;
        }
        
        .summary-card {
            background: white;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            text-align: center;
            border-top: 3px solid var(--primary-red);
        }
        
        .summary-card .summary-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-red);
            margin: 5px 0;
        }
        
        .summary-card .summary-label {
            color: var(--text-light);
            font-size: 0.85rem;
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
            <div class="current-date" id="currentDate"></div>
            
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
                            <a class="dropdown-item text-danger" href="#" id="logoutBtn">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a>
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
                <a href="{{ route('admin.institutions') }}"
                   class="nav-link @if(request()->routeIs('admin.institutions')) active @endif">
                  <i class="fas fa-hospital"></i>
                   <span>Institution</span>
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
                    <a href="#" class="nav-link active">
                        <i class="fas fa-tint"></i>
                        <span>Blood Inventory</span>
                    </a>
                </div>

             <div class="nav-item">
          <a href="{{ route('admin.reports') }}" class="nav-link">
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
                    <li class="breadcrumb-item active" aria-current="page">Blood Inventory</li>
                </ol>
            </nav>

            <!-- Page Title -->
            <div class="page-title">
                <h2>Blood Inventory Management</h2>
                <div class="d-flex gap-2 align-items-center">
                    <div class="view-toggle me-3">
                        <button class="view-toggle-btn active" id="listViewBtn">
                            <i class="fas fa-list"></i>
                        </button>
                        <button class="view-toggle-btn" id="gridViewBtn">
                            <i class="fas fa-th-large"></i>
                        </button>
                    </div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBloodUnitModal">
                        <i class="fas fa-plus-circle"></i> Add Blood Unit
                    </button>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown">
                            <i class="fas fa-download"></i> Export
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-file-excel"></i> Excel</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-file-pdf"></i> PDF</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-file-csv"></i> CSV</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="summary-grid">
    <div class="summary-card">
        <div class="summary-value">{{ number_format($totalUnits) }}</div>
        <div class="summary-label">Total Units</div>
    </div>
<div class="summary-card">
    <div class="summary-value">{{ $availableUnits }}</div>
    <div class="summary-label">Available Units</div>
</div>

                <div class="summary-card">
    <div class="summary-value">{{ $reservedCount }}</div>
    <div class="summary-label">Reserved Units</div>
</div>

<div class="summary-card">
    <div class="summary-value">{{ $expiringSoonCount }}</div>
    <div class="summary-label">Expiring This Week</div>
</div>

<div class="summary-card">
    <div class="summary-value">{{ $criticalCount }}</div>
    <div class="summary-label">Critical Levels</div>
</div>

            </div>

            <!-- Blood Type Distribution -->




            <!-- Blood Inventory Filter Section -->
 <form method="GET" action="{{ route('admin.blood.inventory') }}">
    <div class="filter-card">
        <div class="row g-3">
            <div class="col-md-3">
                <label for="searchInput" class="form-label">Search</label>
                <div class="input-group">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control" id="searchInput" placeholder="Unit ID, Donor ID...">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-3">
                <label for="bloodTypeFilter" class="form-label">Blood Type</label>
                <select name="blood_type" class="form-select" id="bloodTypeFilter">
                    <option value="">All Blood Types</option>
                    <option value="A+" {{ request('blood_type') == 'A+' ? 'selected' : '' }}>A+</option>
                    <option value="A-" {{ request('blood_type') == 'A-' ? 'selected' : '' }}>A-</option>
                    <option value="B+" {{ request('blood_type') == 'B+' ? 'selected' : '' }}>B+</option>
                    <option value="B-" {{ request('blood_type') == 'B-' ? 'selected' : '' }}>B-</option>
                    <option value="O+" {{ request('blood_type') == 'O+' ? 'selected' : '' }}>O+</option>
                    <option value="O-" {{ request('blood_type') == 'O-' ? 'selected' : '' }}>O-</option>
                    <option value="AB+" {{ request('blood_type') == 'AB+' ? 'selected' : '' }}>AB+</option>
                    <option value="AB-" {{ request('blood_type') == 'AB-' ? 'selected' : '' }}>AB-</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="statusFilter" class="form-label">Status</label>
                <select name="status" class="form-select" id="statusFilter">
                    <option value="">All Statuses</option>
                    <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="reserved" {{ request('status') == 'reserved' ? 'selected' : '' }}>Reserved</option>
                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                    <option value="used" {{ request('status') == 'used' ? 'selected' : '' }}>Used</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button class="btn btn-outline-secondary w-100" type="submit">
                    <i class="fas fa-filter"></i> Apply Filters
                </button>
            </div>
        </div>
    </div>
</form>



            <!-- Blood Inventory Table (List View) -->
             @php
  $bloodTypeClasses = [
    'A+'  => 'bg-danger',
    'A−'  => 'bg-danger',
    'B+'  => 'bg-warning text-dark',
    'B−'  => 'bg-warning text-dark',
    'AB+' => 'bg-info text-dark',
    'AB−' => 'bg-info text-dark',
    'O+'  => 'bg-success',
    'O−'  => 'bg-success',
  ];
@endphp

            <div class="table-card" id="listView">
                <div class="card-header">
                    <h3 class="mb-0">Blood Inventory</h3>
                    <div class="d-flex align-items-center">
                        <span class="me-2">Show:</span>
                        <select class="form-select form-select-sm w-auto">
                            <option>10</option>
                            <option>25</option>
                            <option>50</option>
                            <option>100</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" class="form-check-input">
                                    </th>
                                    <th>Unit ID</th>
                                    <th>Blood Type</th>
                                    <th>Volume</th>
                                    <th>Collection Date</th>
                                    <th>Expiration Date</th>
                                    <th>Status</th>
                                    <th>Location</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
<tbody>
@foreach ($inventories as $inventory)
    @php
        $collectionDate = \Carbon\Carbon::parse($inventory->created_on)->format('d M Y');
        $expiry = \Carbon\Carbon::parse($inventory->expiry_date);
        $expiryBadge = now()->gt($expiry) 
            ? 'expiration-danger' 
            : ($expiry->diffInDays(now()) <= 7 ? 'expiration-warning' : 'expiration-safe');

        $status = now()->gt($expiry) ? 'Expired' : 'Available';
        $statusBadge = now()->gt($expiry) ? 'status-expired' : 'status-available';
    @endphp
    <tr>
        <td><input type="checkbox" class="form-check-input"></td>
        <td>BLD-{{ str_pad($inventory->id, 5, '0', STR_PAD_LEFT) }}</td>
       @php
  $bloodType = $inventory->bloodGroup->name ?? 'Unknown';
  $badgeClass = $bloodTypeClasses[$bloodType] ?? 'bg-secondary';
@endphp

<td>
  <span class="badge {{ $badgeClass }}">
    {{ $bloodType }}
  </span>
</td>

        <td>{{ $inventory->quantity }} ml</td>
        <td>{{ $collectionDate }}</td>
        <td>
            <span class="expiration-badge {{ $expiryBadge }}">
                {{ $expiry->format('d M Y') }}
            </span>
        </td>
        <td>
            <span class="badge {{ $statusBadge }}">{{ $status }}</span>
        </td>
        <td>{{ $inventory->institution->name }}</td>
        <td>
            <div class="d-flex action-btns">
                <a href="{{ route('inventory.edit', $inventory->id) }}" class="btn btn-outline-primary">
                    <i class="fas fa-edit"></i>
                </a>
                <a href="#" class="btn btn-outline-secondary">
                    <i class="fas fa-eye"></i>
                </a>
                <form method="POST" action="{{ route('inventory.destroy', $inventory->id) }}">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        </td>
    </tr>
@endforeach
</tbody>

</table>
</div>
</div>
               @if ($inventories->count())
<div class="card-footer d-flex justify-content-between align-items-center flex-wrap">
    <div class="text-muted">
        Showing <strong>{{ $inventories->firstItem() }}</strong>
        to <strong>{{ $inventories->lastItem() }}</strong>
        of <strong>{{ $inventories->total() }}</strong> entries
    </div>
    <nav>
        {!! $inventories->links('pagination::bootstrap-5') !!}
    </nav>
</div>
@else
<div class="card-footer text-center text-muted">
    No inventory records found.
</div>
@endif

            </div>

            <!-- Blood Inventory Grid (Card View) -->
            <div class="blood-unit-grid" id="gridView" style="display: none;">
                <!-- Blood Unit Card 1 -->
                <div class="blood-unit-card">
                    <div class="blood-unit-header">
                        <div class="blood-type-icon blood-type-Op">O+</div>
                        <div>
                            <h6 class="mb-0">BLD-2024-00123</h6>
                            <small class="text-muted">450 ml</small>
                        </div>
                    </div>
                    <div class="blood-unit-body">
                        <div class="blood-unit-detail">
                            <div class="blood-unit-label">Collection Date:</div>
                            <div class="blood-unit-value">15 Mar 2024</div>
                        </div>
                        <div class="blood-unit-detail">
                            <div class="blood-unit-label">Expiration Date:</div>
                            <div class="blood-unit-value">
                                <span class="expiration-badge expiration-warning">26 Apr 2024</span>
                            </div>
                        </div>
                        <div class="blood-unit-detail">
                            <div class="blood-unit-label">Status:</div>
                            <div class="blood-unit-value">
                                <span class="badge status-available">Available</span>
                            </div>
                        </div>
                        <div class="blood-unit-detail">
                            <div class="blood-unit-label">Location:</div>
                            <div class="blood-unit-value">Central Blood Bank</div>
                        </div>
                        <div class="blood-unit-detail">
                            <div class="blood-unit-label">Donor ID:</div>
                            <div class="blood-unit-value">DON-2024-001</div>
                        </div>
                        <div class="d-flex action-btns justify-content-end mt-3">
                            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editBloodUnitModal">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-outline-secondary">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-outline-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Blood Unit Card 2 -->
                <div class="blood-unit-card">
                    <div class="blood-unit-header">
                        <div class="blood-type-icon blood-type-Ap">A+</div>
                        <div>
                            <h6 class="mb-0">BLD-2024-00145</h6>
                            <small class="text-muted">450 ml</small>
                        </div>
                    </div>
                    <div class="blood-unit-body">
                        <div class="blood-unit-detail">
                            <div class="blood-unit-label">Collection Date:</div>
                            <div class="blood-unit-value">20 Mar 2024</div>
                        </div>
                        <div class="blood-unit-detail">
                            <div class="blood-unit-label">Expiration Date:</div>
                            <div class="blood-unit-value">
                                <span class="expiration-badge expiration-safe">30 Apr 2024</span>
                            </div>
                        </div>
                        <div class="blood-unit-detail">
                            <div class="blood-unit-label">Status:</div>
                            <div class="blood-unit-value">
                                <span class="badge status-reserved">Reserved</span>
                            </div>
                        </div>
                        <div class="blood-unit-detail">
                            <div class="blood-unit-label">Location:</div>
                            <div class="blood-unit-value">City General Hospital</div>
                        </div>
                        <div class="blood-unit-detail">
                            <div class="blood-unit-label">Donor ID:</div>
                            <div class="blood-unit-value">DON-2023-045</div>
                        </div>
                        <div class="d-flex action-btns justify-content-end mt-3">
                            <button class="btn btn-outline-primary">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-outline-secondary">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-outline-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Blood Unit Card 3 -->
                <div class="blood-unit-card">
                    <div class="blood-unit-header">
                        <div class="blood-type-icon blood-type-Bn">B-</div>
                        <div>
                            <h6 class="mb-0">BLD-2024-00087</h6>
                            <small class="text-muted">450 ml</small>
                        </div>
                    </div>
                    <div class="blood-unit-body">
                        <div class="blood-unit-detail">
                            <div class="blood-unit-label">Collection Date:</div>
                            <div class="blood-unit-value">05 Mar 2024</div>
                        </div>
                        <div class="blood-unit-detail">
                            <div class="blood-unit-label">Expiration Date:</div>
                            <div class="blood-unit-value">
                                <span class="expiration-badge expiration-danger">15 Apr 2024</span>
                            </div>
                        </div>
                        <div class="blood-unit-detail">
                            <div class="blood-unit-label">Status:</div>
                            <div class="blood-unit-value">
                                <span class="badge status-expired">Expired</span>
                            </div>
                        </div>
                        <div class="blood-unit-detail">
                            <div class="blood-unit-label">Location:</div>
                            <div class="blood-unit-value">Regional Blood Center</div>
                        </div>
                        <div class="blood-unit-detail">
                            <div class="blood-unit-label">Donor ID:</div>
                            <div class="blood-unit-value">DON-2024-012</div>
                        </div>
                        <div class="d-flex action-btns justify-content-end mt-3">
                            <button class="btn btn-outline-primary">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-outline-secondary">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-outline-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Blood Unit Card 4 -->
                <div class="blood-unit-card">
                    <div class="blood-unit-header">
                        <div class="blood-type-icon blood-type-On">O-</div>
                        <div>
                            <h6 class="mb-0">BLD-2024-00234</h6>
                            <small class="text-muted">450 ml</small>
                        </div>
                    </div>
                    <div class="blood-unit-body">
                        <div class="blood-unit-detail">
                            <div class="blood-unit-label">Collection Date:</div>
                            <div class="blood-unit-value">22 Mar 2024</div>
                        </div>
                        <div class="blood-unit-detail">
                            <div class="blood-unit-label">Expiration Date:</div>
                            <div class="blood-unit-value">
                                <span class="expiration-badge expiration-safe">02 May 2024</span>
                            </div>
                        </div>
                        <div class="blood-unit-detail">
                            <div class="blood-unit-label">Status:</div>
                            <div class="blood-unit-value">
                                <span class="badge status-available">Available</span>
                            </div>
                        </div>
                        <div class="blood-unit-detail">
                            <div class="blood-unit-label">Location:</div>
                            <div class="blood-unit-value">Central Blood Bank</div>
                        </div>
                        <div class="blood-unit-detail">
                            <div class="blood-unit-label">Donor ID:</div>
                            <div class="blood-unit-value">DON-2022-078</div>
                        </div>
                        <div class="d-flex action-btns justify-content-end mt-3">
                            <button class="btn btn-outline-primary">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-outline-secondary">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-outline-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Blood Unit Card 5 -->
                <div class="blood-unit-card">
                    <div class="blood-unit-header">
                        <div class="blood-type-icon blood-type-ABp">AB+</div>
                        <div>
                            <h6 class="mb-0">BLD-2024-00189</h6>
                            <small class="text-muted">450 ml</small>
                        </div>
                    </div>
                    <div class="blood-unit-body">
                        <div class="blood-unit-detail">
                            <div class="blood-unit-label">Collection Date:</div>
                            <div class="blood-unit-value">18 Mar 2024</div>
                        </div>
                        <div class="blood-unit-detail">
                            <div class="blood-unit-label">Expiration Date:</div>
                            <div class="blood-unit-value">
                                <span class="expiration-badge expiration-safe">28 Apr 2024</span>
                            </div>
                        </div>
                        <div class="blood-unit-detail">
                            <div class="blood-unit-label">Status:</div>
                            <div class="blood-unit-value">
                                <span class="badge status-used">Used</span>
                            </div>
                        </div>
                        <div class="blood-unit-detail">
                            <div class="blood-unit-label">Location:</div>
                            <div class="blood-unit-value">Children's Hospital</div>
                        </div>
                        <div class="blood-unit-detail">
                            <div class="blood-unit-label">Donor ID:</div>
                            <div class="blood-unit-value">DON-2023-102</div>
                        </div>
                        <div class="d-flex action-btns justify-content-end mt-3">
                            <button class="btn btn-outline-primary">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-outline-secondary">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-outline-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Blood Unit Modal -->
    <div class="modal fade" id="addBloodUnitModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Blood Unit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="donorId" class="form-label">Donor ID</label>
                                <input type="text" class="form-control" id="donorId" required>
                            </div>
                            <div class="col-md-6">
                                <label for="bloodType" class="form-label">Blood Type</label>
                                <select class="form-select" id="bloodType" required>
                                    <option value="">Select Blood Type</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="collectionDate" class="form-label">Collection Date</label>
                                <input type="date" class="form-control" id="collectionDate" required>
                            </div>
                            <div class="col-md-6">
                                <label for="expirationDate" class="form-label">Expiration Date</label>
                                <input type="date" class="form-control" id="expirationDate" required>
                            </div>
                            <div class="col-md-6">
                                <label for="volume" class="form-label">Volume (ml)</label>
                                <input type="number" class="form-control" id="volume" value="450" required>
                            </div>
                            <div class="col-md-6">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" required>
                                    <option value="available">Available</option>
                                    <option value="reserved">Reserved</option>
                                    <option value="expired">Expired</option>
                                    <option value="used">Used</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="location" class="form-label">Storage Location</label>
                                <select class="form-select" id="location" required>
                                    <option value="">Select Location</option>
                                    <option value="central">Central Blood Bank</option>
                                    <option value="city_hospital">City General Hospital</option>
                                    <option value="regional">Regional Blood Center</option>
                                    <option value="children">Children's Hospital</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="componentType" class="form-label">Component Type</label>
                                <select class="form-select" id="componentType" required>
                                    <option value="whole_blood">Whole Blood</option>
                                    <option value="red_cells">Red Blood Cells</option>
                                    <option value="plasma">Plasma</option>
                                    <option value="platelets">Platelets</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea class="form-control" id="notes" rows="2"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Add Blood Unit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Blood Unit Modal -->
    <div class="modal fade" id="editBloodUnitModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Blood Unit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="editUnitId" class="form-label">Unit ID</label>
                                <input type="text" class="form-control" id="editUnitId" value="BLD-2024-00123" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="editDonorId" class="form-label">Donor ID</label>
                                <input type="text" class="form-control" id="editDonorId" value="DON-2024-001" required>
                            </div>
                            <div class="col-md-6">
                                <label for="editBloodType" class="form-label">Blood Type</label>
                                <select class="form-select" id="editBloodType" required>
                                    <option value="O+" selected>O+</option>
                                    <option value="O-">O-</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="editCollectionDate" class="form-label">Collection Date</label>
                                <input type="date" class="form-control" id="editCollectionDate" value="2024-03-15" required>
                            </div>
                            <div class="col-md-6">
                                <label for="editExpirationDate" class="form-label">Expiration Date</label>
                                <input type="date" class="form-control" id="editExpirationDate" value="2024-04-26" required>
                            </div>
                            <div class="col-md-6">
                                <label for="editVolume" class="form-label">Volume (ml)</label>
                                <input type="number" class="form-control" id="editVolume" value="450" required>
                            </div>
                            <div class="col-md-6">
                                <label for="editStatus" class="form-label">Status</label>
                                <select class="form-select" id="editStatus" required>
                                    <option value="available" selected>Available</option>
                                    <option value="reserved">Reserved</option>
                                    <option value="expired">Expired</option>
                                    <option value="used">Used</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="editLocation" class="form-label">Storage Location</label>
                                <select class="form-select" id="editLocation" required>
                                    <option value="central" selected>Central Blood Bank</option>
                                    <option value="city_hospital">City General Hospital</option>
                                    <option value="regional">Regional Blood Center</option>
                                    <option value="children">Children's Hospital</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="editComponentType" class="form-label">Component Type</label>
                                <select class="form-select" id="editComponentType" required>
                                    <option value="whole_blood" selected>Whole Blood</option>
                                    <option value="red_cells">Red Blood Cells</option>
                                    <option value="plasma">Plasma</option>
                                    <option value="platelets">Platelets</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="editNotes" class="form-label">Notes</label>
                                <textarea class="form-control" id="editNotes" rows="2">No special notes</textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Set current date
            const now = new Date();
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            document.getElementById('currentDate').textContent = now.toLocaleDateString('en-US', options);
            
            // Toggle sidebar
            const toggleBtn = document.getElementById('toggleSidebar');
            const sidebar = document.getElementById('sidebar');
            if (toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', function() {
                    const isOpen = sidebar.classList.toggle('active');
                    toggleBtn.setAttribute('aria-expanded', isOpen);
                });
                // Close sidebar when clicking outside on mobile
                document.addEventListener('click', function(e) {
                    if (window.innerWidth < 992 && sidebar.classList.contains('active')) {
                        if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
                            sidebar.classList.remove('active');
                            toggleBtn.setAttribute('aria-expanded', 'false');
                        }
                    }
                });
            }

            // View toggle
            const listViewBtn = document.getElementById('listViewBtn');
            const gridViewBtn = document.getElementById('gridViewBtn');
            const listView = document.getElementById('listView');
            const gridView = document.getElementById('gridView');
            
            if (listViewBtn && gridViewBtn && listView && gridView) {
                listViewBtn.addEventListener('click', function() {
                    listViewBtn.classList.add('active');
                    gridViewBtn.classList.remove('active');
                    listView.style.display = 'block';
                    gridView.style.display = 'none';
                });
                
                gridViewBtn.addEventListener('click', function() {
                    gridViewBtn.classList.add('active');
                    listViewBtn.classList.remove('active');
                    gridView.style.display = 'grid';
                    listView.style.display = 'none';
                });
            }

            // Delete confirmation
            document.querySelectorAll('.btn-outline-danger').forEach(button => {
                button.addEventListener('click', function() {
                    // Check if it's a form submit button
                    if (this.type === 'submit') {
                        return; // Let the form submit normally
                    }
                    
                    Swal.fire({
                        title: 'Delete Blood Unit?',
                        text: "This will permanently remove the blood unit from the system.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire(
                                'Deleted!',
                                'The blood unit has been deleted.',
                                'success'
                            );
                        }
                    });
                });
            });
            
            // Initialize tooltips if Bootstrap is available
            if (typeof bootstrap !== 'undefined') {
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



</body>
</html>