<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Management | LifeStream Blood Bank</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
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
        
        /* Donor Card */
        .donor-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            border-top: 3px solid var(--primary-red);
        }
        
        .donor-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .donor-header {
            padding: 15px;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            align-items: center;
        }
        
        .donor-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--light-red);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: var(--primary-red);
            font-size: 24px;
            font-weight: bold;
        }
        
        .donor-body {
            padding: 15px;
        }
        
        .donor-detail {
            display: flex;
            margin-bottom: 8px;
        }
        
        .donor-label {
            font-weight: 500;
            min-width: 100px;
            color: var(--text-light);
        }
        
        .donor-value {
            flex: 1;
        }
        
        .blood-type-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            margin-right: 5px;
            margin-bottom: 5px;
            background-color: #fee2e2;
            color: #dc2626;
        }
        
        .last-donation {
            display: flex;
            align-items: center;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px dashed #e5e7eb;
        }
        
        .last-donation i {
            color: var(--primary-red);
            margin-right: 8px;
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
            
            .donor-grid {
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
        .donor-grid {
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
        
        /* Eligibility Indicator */
        .eligibility-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }
        
        .eligible { background-color: #43a047; }
        .not-eligible { background-color: #e53935; }
        .pending { background-color: #ffb300; }
        
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
        .dataTables_info {
  display: none;
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
                    <a href="#" class="nav-link active">
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
                    <li class="breadcrumb-item active" aria-current="page">Donors</li>
                </ol>
            </nav>

            <!-- Page Title -->
            <div class="page-title">
                <h2>Donor Management</h2>
                <div class="d-flex gap-2 align-items-center">
                    <div class="view-toggle me-3">
                      
                       
                    </div>
                 <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDonationModal">
  Add Donation
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

            <!-- Donor Statistics -->
            <div class="stats-grid">
              <div class="stat-card">
  <div class="stat-icon">
    <i class="fas fa-users"></i>
  </div>
  <div class="stat-value">
    {{ number_format($totalDonors) }}
  </div>
  <div class="stat-label">Total Donors</div>
</div>

                <div class="stat-card">
  <div class="stat-icon">
    <i class="fas fa-check-circle"></i>
  </div>
  <div class="stat-value">
    {{ number_format($activeDonors) }}
  </div>
  <div class="stat-label">Active Donors</div>
</div>

               <div class="stat-card">
  <div class="stat-icon">
    <i class="fas fa-syringe"></i>
  </div>
  <div class="stat-value">
    {{ number_format($totalDonations) }}
  </div>
  <div class="stat-label">Total Donations</div>
</div>

                <div class="stat-card">
  <div class="stat-icon">
    <i class="fas fa-tint"></i>
  </div>
  <div class="stat-value">
    {{ number_format($bloodCollectedL, 2) }} L
  </div>
  <div class="stat-label">Blood Collected</div>
</div>
</div>

            <!-- Donor Filter Section -->
            <div class="filter-card">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="searchInput" class="form-label">Search</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="searchInput" placeholder="Name, ID, contact...">
                            <button class="btn btn-outline-secondary" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="bloodTypeFilter" class="form-label">Blood Type</label>
                        <select class="form-select" id="bloodTypeFilter">
                            <option value="">All Blood Types</option>
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
                    <div class="col-md-3">
                        <label for="statusFilter" class="form-label">Status</label>
                        <select class="form-select" id="statusFilter">
                            <option value="">All Statuses</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="pending">Pending Review</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button class="btn btn-outline-secondary w-100">
                            <i class="fas fa-filter"></i> Apply Filters
                        </button>
                    </div>
                </div>
            </div>

            <!-- Donors Table (List View) -->
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
                    <h3 class="mb-0">Registered Donors</h3>
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
                                    <th>Donor</th>
                                    <th>Blood Type</th>
                                    <th>Contact</th>
                                    <th>Last Donation</th>
                                    <th>Total Donations</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
  @foreach($donors as $donor)
    @php
    $lastDonation = $donor->donations->sortByDesc('donation_date')->first();

      $lastDate     = $lastDonation
                      ? \Carbon\Carbon::parse($lastDonation->donation_date)->startOfDay()
                      : null;
      $daysSince    = $lastDate
                      ? $lastDate->diffInDays(now()->startOfDay())
                      : null;
      if (is_null($lastDate)) {
        $statusText  = 'Pending Review';
        $statusClass = 'bg-warning';
        $eligClass   = 'pending';
      }
      elseif ($daysSince >= 56) {
        $statusText  = 'Eligible';
        $statusClass = 'bg-success';
        $eligClass   = 'eligible';
      } else {
        $statusText  = 'Not Eligible';
        $statusClass = 'bg-danger';
        $eligClass   = 'not-eligible';
      }
    @endphp

    <tr>
      <td><input type="checkbox" class="form-check-input"></td>
      <td>
        <div class="d-flex align-items-center">
          <div class="donor-avatar">
            {{ strtoupper(substr($donor->detail->first_name ?? '', 0, 1) . substr($donor->detail->last_name ?? '', 0, 1)) }}
          </div>
          <div class="ms-2">
            <h6 class="mb-0">
              {{ $donor->detail->first_name ?? 'Unknown' }} {{ $donor->detail->last_name ?? '' }}
            </h6>
            <small class="text-muted">ID: {{ $donor->detail->custom_id ?? 'N/A' }}</small>
          </div>
        </div>
      </td>
      <td>
        @php
          $type = $donor->detail->blood_type ?? 'Unknown';
          $cls  = $bloodTypeClasses[$type] ?? 'bg-secondary text-white';
        @endphp
        <span class="badge {{ $cls }}">{{ $type }}</span>
      </td>
      <td>
        {{ $donor->email ?? 'N/A' }}<br>
        {{ $donor->detail->phone_number ?? 'N/A' }}
      </td>
      <td>
        {{ $lastDate ? $lastDate->format('d M Y') : '—' }}
      </td>
      <td>
        {{ $donor->donations->count() }} donation{{ $donor->donations->count() > 1 ? 's' : '' }}
      </td>
      <td>
        <span class="eligibility-indicator {{ $eligClass }}"></span>
        <span class="badge {{ $statusClass }}">{{ $statusText }}</span>
      </td>
      <td>
        <div class="d-flex action-btns">
          <button class="btn btn-outline-primary edit-donor-btn"
                  data-bs-toggle="modal"
                  data-bs-target="#editDonorModal"
                  data-donor="{{ htmlspecialchars(json_encode([
                      'id' => $donor->id,
                      'first_name' => $donor->detail->first_name ?? '',
                      'last_name' => $donor->detail->last_name ?? '',
                      'custom_id' => $donor->detail->custom_id ?? '',
                      'blood_type' => $donor->detail->blood_type ?? '',
                      'email' => $donor->email ?? '',
                      'phone_number' => $donor->detail->phone_number ?? '',
                      'address' => $donor->detail->address ?? '',
                  ]), ENT_QUOTES, 'UTF-8') }}">
            <i class="fas fa-edit"></i>
          </button>
          <button class="btn btn-outline-info view-idcard-btn"
                  data-bs-toggle="modal"
                  data-bs-target="#donorIdCardModal"
                  data-donor="{{ htmlspecialchars(json_encode([
                      'id' => $donor->id,
                      'first_name' => $donor->detail->first_name ?? '',
                      'last_name' => $donor->detail->last_name ?? '',
                      'custom_id' => $donor->detail->custom_id ?? '',
                      'blood_type' => $donor->detail->blood_type ?? '',
                      'email' => $donor->email ?? '',
                      'phone_number' => $donor->detail->phone_number ?? '',
                      'address' => $donor->detail->address ?? '',
                      'donations' => $donor->donations->map(function($d) {
                          return [
                              'date' => $d->donation_date,
                              'volume' => $d->volume_ml,
                          ];
                      }),
                  ]), ENT_QUOTES, 'UTF-8') }}">
            <i class="fas fa-id-card"></i>
          </button>
          <form method="POST" action="{{ route('admin.donors.destroy', $donor->id) }}" class="d-inline delete-donor-form">
            @csrf @method('DELETE')
            <button type="button" class="btn btn-outline-danger delete-donor-btn">
              <i class="fas fa-trash"></i>
            </button>
          </form>
        </div>
      </td>
    </tr>
  @endforeach
</tbody>


  
</table>

<div class="card-footer d-flex align-items-center w-100">
  {{-- LEFT: summary --}}
  <div class="me-auto">
    @if($donors->total())
      Showing
      <strong>{{ $donors->firstItem() }}</strong>
      to
      <strong>{{ $donors->lastItem() }}</strong>
      of
      <strong>{{ $donors->total() }}</strong>
      entries
    @else
      <span class="text-muted">No donors found.</span>
    @endif
  </div>

  {{-- RIGHT: pagination --}}
  <nav>
    {!! $donors->links('pagination::bootstrap-5') !!}
  </nav>
</div>




            </div>

            <!-- Donors Grid (Card View) -->
            <div class="donor-grid" id="gridView" style="display: none;">
                <!-- Donor Card 1 -->
                <div class="donor-card">
                    <div class="donor-header">
                        <div class="donor-avatar">JS</div>
                        <div>
                            <h6 class="mb-0">John Smith</h6>
                            <small class="text-muted">ID: DON-2024-001</small>
                        </div>
                    </div>
                    <div class="donor-body">
                        <div class="donor-detail">
                            <div class="donor-label">Blood Type:</div>
                            <div class="donor-value">
                                <span class="badge blood-type-Op">O+</span>
                            </div>
                        </div>
                        <div class="donor-detail">
                            <div class="donor-label">Contact:</div>
                            <div class="donor-value">
                                john.smith@email.com<br>
                                (555) 123-4567
                            </div>
                        </div>
                        <div class="donor-detail">
                            <div class="donor-label">Status:</div>
                            <div class="donor-value">
                                <span class="eligibility-indicator eligible"></span>
                                <span class="badge bg-success">Eligible</span>
                            </div>
                        </div>
                        <div class="last-donation">
                            <i class="fas fa-history"></i>
                            <div>
                                <small class="text-muted">Last Donation</small>
                                <div>15 Mar 2024</div>
                            </div>
                            <div class="ms-auto">
                                <small class="text-muted">Total</small>
                                <div>12 donations</div>
                            </div>
                        </div>
                        <div class="d-flex action-btns justify-content-end mt-3">
                            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editDonorModal">
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

                <!-- Donor Card 2 -->
                <div class="donor-card">
                    <div class="donor-header">
                        <div class="donor-avatar">MJ</div>
                        <div>
                            <h6 class="mb-0">Maria Johnson</h6>
                            <small class="text-muted">ID: DON-2023-045</small>
                        </div>
                    </div>
                    <div class="donor-body">
                        <div class="donor-detail">
                            <div class="donor-label">Blood Type:</div>
                            <div class="donor-value">
                                <span class="badge blood-type-ABp">AB+</span>
                            </div>
                        </div>
                        <div class="donor-detail">
                            <div class="donor-label">Contact:</div>
                            <div class="donor-value">
                                maria.j@email.com<br>
                                (555) 987-6543
                            </div>
                        </div>
                        <div class="donor-detail">
                            <div class="donor-label">Status:</div>
                            <div class="donor-value">
                                <span class="eligibility-indicator eligible"></span>
                                <span class="badge bg-success">Eligible</span>
                            </div>
                        </div>
                        <div class="last-donation">
                            <i class="fas fa-history"></i>
                            <div>
                                <small class="text-muted">Last Donation</small>
                                <div>28 Feb 2024</div>
                            </div>
                            <div class="ms-auto">
                                <small class="text-muted">Total</small>
                                <div>8 donations</div>
                            </div>
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

                <!-- Donor Card 3 -->
                <div class="donor-card">
                    <div class="donor-header">
                        <div class="donor-avatar">RD</div>
                        <div>
                            <h6 class="mb-0">Robert Davis</h6>
                            <small class="text-muted">ID: DON-2024-012</small>
                        </div>
                    </div>
                    <div class="donor-body">
                        <div class="donor-detail">
                            <div class="donor-label">Blood Type:</div>
                            <div class="donor-value">
                                <span class="badge blood-type-Bn">B-</span>
                            </div>
                        </div>
                        <div class="donor-detail">
                            <div class="donor-label">Contact:</div>
                            <div class="donor-value">
                                rob.davis@email.com<br>
                                (555) 456-7890
                            </div>
                        </div>
                        <div class="donor-detail">
                            <div class="donor-label">Status:</div>
                            <div class="donor-value">
                                <span class="eligibility-indicator not-eligible"></span>
                                <span class="badge bg-danger">Not Eligible</span>
                            </div>
                        </div>
                        <div class="last-donation">
                            <i class="fas fa-history"></i>
                            <div>
                                <small class="text-muted">Last Donation</small>
                                <div>10 Jan 2024</div>
                            </div>
                            <div class="ms-auto">
                                <small class="text-muted">Total</small>
                                <div>3 donations</div>
                            </div>
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

                <!-- Donor Card 4 -->
                <div class="donor-card">
                    <div class="donor-header">
                        <div class="donor-avatar">SW</div>
                        <div>
                            <h6 class="mb-0">Sarah Williams</h6>
                            <small class="text-muted">ID: DON-2022-078</small>
                        </div>
                    </div>
                    <div class="donor-body">
                        <div class="donor-detail">
                            <div class="donor-label">Blood Type:</div>
                            <div class="donor-value">
                                <span class="badge blood-type-On">O-</span>
                            </div>
                        </div>
                        <div class="donor-detail">
                            <div class="donor-label">Contact:</div>
                            <div class="donor-value">
                                sarah.w@email.com<br>
                                (555) 321-6547
                            </div>
                        </div>
                        <div class="donor-detail">
                            <div class="donor-label">Status:</div>
                            <div class="donor-value">
                                <span class="eligibility-indicator eligible"></span>
                                <span class="badge bg-success">Eligible</span>
                            </div>
                        </div>
                        <div class="last-donation">
                            <i class="fas fa-history"></i>
                            <div>
                                <small class="text-muted">Last Donation</small>
                                <div>05 Dec 2023</div>
                            </div>
                            <div class="ms-auto">
                                <small class="text-muted">Total</small>
                                <div>15 donations</div>
                            </div>
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

                <!-- Donor Card 5 -->
                <div class="donor-card">
                    <div class="donor-header">
                        <div class="donor-avatar">MB</div>
                        <div>
                            <h6 class="mb-0">Michael Brown</h6>
                            <small class="text-muted">ID: DON-2023-102</small>
                        </div>
                    </div>
                    <div class="donor-body">
                        <div class="donor-detail">
                            <div class="donor-label">Blood Type:</div>
                            <div class="donor-value">
                                <span class="badge blood-type-Ap">A+</span>
                            </div>
                        </div>
                        <div class="donor-detail">
                            <div class="donor-label">Contact:</div>
                            <div class="donor-value">
                                m.brown@email.com<br>
                                (555) 234-5678
                            </div>
                        </div>
                        <div class="donor-detail">
                            <div class="donor-label">Status:</div>
                            <div class="donor-value">
                                <span class="eligibility-indicator pending"></span>
                                <span class="badge bg-warning">Pending Review</span>
                            </div>
                        </div>
                        <div class="last-donation">
                            <i class="fas fa-history"></i>
                            <div>
                                <small class="text-muted">Last Donation</small>
                                <div>20 Feb 2024</div>
                            </div>
                            <div class="ms-auto">
                                <small class="text-muted">Total</small>
                                <div>6 donations</div>
                            </div>
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



    <!-- Add Donor Modal -->

<!-- Add Donation Modal Trigger -->


<!-- Add Donation Modal -->
<!-- Add Donation Modal -->
<div class="modal fade" id="addDonationModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="POST" action="{{ route('admin.donors.storeDonation') }}">
      @csrf

      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Donation</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        @error('donation_date')
          <div class="text-danger px-3 mt-2">{{ $message }}</div>
        @enderror

        <div class="modal-body">
          {{-- 1) Search field --}}
          <div class="mb-3 row">
            <label for="searchDonorInput" class="col-form-label col-sm-3">Search Donor</label>
            <div class="col-sm-7">
              <input
                type="text"
                id="searchDonorInput"
                class="form-control"
                placeholder="Enter name or custom ID"
                aria-label="Search donor by name or custom ID"
                required
              >
            </div>
            <div class="col-sm-2">
              <button type="button" class="btn btn-outline-secondary w-100" onclick="searchDonor()">
                <i class="fas fa-search"></i> Search
              </button>
            </div>
          </div>

          {{-- 2) Donor info --}}
          <div id="donorInfo" style="display:none; border:1px solid #ddd; padding:15px; margin-bottom:15px;">
            <input type="hidden" name="user_id" id="donorUserId" required>
            <input type="hidden" id="nextEligibleDate">

            <p><strong>Name:</strong> <span id="donorName"></span></p>
            <p><strong>Blood Type:</strong> <span id="donorBlood"></span></p>
            <p><strong>Weight:</strong> <span id="donorWeight"></span> lbs</p>
          </div>

          {{-- 3) Institution & Donation details --}}
          <div class="mb-3">
            <label for="institution" class="form-label">Select Institution</label>
            <select name="institution_id" class="form-select" required>
              <option value="">-- Choose Institution --</option>
              @foreach($institutions as $institution)
                <option value="{{ $institution->id }}">{{ $institution->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="row g-3">
            <div class="col-md-6">
              <label for="donationDateInput" class="form-label">Donation Date</label>
              <input
    type="date"
    name="donation_date"
    id="donationDateInput"
    class="form-control"
    required
    max="{{ date('Y-m-d') }}"
    aria-describedby="donationDateHelp"
/>

              <div id="donationDateHelp" class="form-text">
                Must wait 56 days between donations.
              </div>
            </div>
            <div class="col-md-6">
              <label for="volumeMlInput" class="form-label">Volume (ml)</label>
              <input
                type="number"
                name="volume_ml"
                id="volumeMlInput"
                class="form-control"
                min="1"
                required
                aria-describedby="volumeHelp"
              >
              <div id="volumeHelp" class="form-text">
                Minimum volume is 1 ml.
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" id="saveDonationBtn" class="btn btn-success" disabled>Save Donation</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  const saveBtn = document.getElementById('saveDonationBtn');
  const donorUserIdInput = document.getElementById('donorUserId');
  const donorInfoDiv = document.getElementById('donorInfo');
  const donationDateInput = document.getElementById('donationDateInput');
  const searchInput = document.getElementById('searchDonorInput');
  const nextEligibleInput = document.getElementById('nextEligibleDate');

  // Allow Enter key to trigger search
  searchInput.addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
      e.preventDefault();
      searchDonor();
    }
  });

  function searchDonor() {
    const query = searchInput.value.trim();
    if (!query) return alert('Please enter a name or custom ID');

    // Reset previous info
    saveBtn.disabled = true;
    donorInfoDiv.style.display = 'none';
    donorUserIdInput.value = '';
    donationDateInput.value = '';
    nextEligibleInput.value = '';

    fetch(`{{ route('admin.donors.searchAjax') }}?query=${encodeURIComponent(query)}`, {
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => res.json())
    .then(data => {
      console.log('Search result:', data);
      if (!data.success || !data.donor) {
        return alert('Donor not found');
      }

      const d = data.donor;
      donorUserIdInput.value = d.user_id;
      document.getElementById('donorName').innerText = `${d.first_name} ${d.last_name}`;
      document.getElementById('donorBlood').innerText = d.blood_type;
      document.getElementById('donorWeight').innerText = d.weight_lbs;
      donorInfoDiv.style.display = 'block';

      if (d.last_donation_date) {
        const last = new Date(d.last_donation_date + 'T00:00:00');
        const next = new Date(last.getTime() + 56 * 24 * 60 * 60 * 1000);
        const nextStr = next.toISOString().slice(0, 10);
        nextEligibleInput.value = nextStr;
        console.log('Next eligible date:', nextStr);
      }

      saveBtn.disabled = false;
    })
    .catch(err => {
      console.error('Search error:', err);
      alert('Error during search.');
    });
  }

  // Check donation eligibility date AND prevent future dates
  donationDateInput.addEventListener('change', function () {
    const nextStr = nextEligibleInput.value;
    const picked = new Date(this.value + 'T00:00:00');
    const today = new Date();
    today.setHours(0, 0, 0, 0); // normalize to midnight

    // Check if picked date is in the future
    if (picked > today) {
      alert('Donation date cannot be in the future. Please select today or a previous date.');
      this.value = '';
      return;
    }

    // Check if picked date is before next eligible date
    if (nextStr) {
      const next = new Date(nextStr + 'T00:00:00');
      if (picked < next) {
        const diff = Math.ceil((next - picked) / (1000 * 60 * 60 * 24));
        Swal.fire({
          icon: 'info',
          title: 'Wait a Bit!',
          html: `Too soon to donate again.<br><strong>Please wait ${diff} more day(s)</strong>.<br>Next eligible date is <strong>${nextStr}</strong>.`,
          showClass: { popup: 'animate__animated animate__fadeInDown' },
          hideClass: { popup: 'animate__animated animate__fadeOutUp' },
          confirmButtonColor: '#e53935'
        });

        this.value = '';
        return;
      }
    }
  });
</script>







@if(isset($userDetails) && $userDetails->count())
    <h3>Search results for "{{ $query }}"</h3>
    <table>
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Custom ID</th>
                <th>Email</th>
                <!-- Add more columns as needed -->
            </tr>
        </thead>
        <tbody>
            @foreach($userDetails as $detail)
            <tr>
                <td>{{ $detail->first_name }}</td>
                <td>{{ $detail->last_name }}</td>
                <td>{{ $detail->custom_id }}</td>
                <td>{{ optional($detail->user)->email }}</td>
                <!-- More info -->
            </tr>
            @endforeach
        </tbody>
    </table>
@elseif(isset($query))
    <p>No donor found matching "{{ $query }}"</p>
@endif


    <!-- Edit Donor Modal -->
    <div class="modal fade" id="editDonorModal" tabindex="-1" aria-labelledby="editDonorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="editDonorForm">
                @csrf
                @method('PATCH')
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="editDonorModalLabel">Edit Donor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="editDonorId">
                        <div class="mb-3">
                            <label for="editFirstName" class="form-label">First Name</label>
                            <input type="text" name="first_name" id="editFirstName" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="editLastName" class="form-label">Last Name</label>
                            <input type="text" name="last_name" id="editLastName" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="editBloodType" class="form-label">Blood Type</label>
                            <input type="text" name="blood_type" id="editBloodType" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="editEmail" class="form-label">Email</label>
                            <input type="email" name="email" id="editEmail" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="editPhone" class="form-label">Phone Number</label>
                            <input type="text" name="phone_number" id="editPhone" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="editAddress" class="form-label">Address</label>
                            <input type="text" name="address" id="editAddress" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Edit Donor
        document.querySelectorAll('.edit-donor-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const donor = JSON.parse(this.getAttribute('data-donor'));
                document.getElementById('editDonorId').value = donor.id;
                document.getElementById('editFirstName').value = donor.first_name;
                document.getElementById('editLastName').value = donor.last_name;
                document.getElementById('editBloodType').value = donor.blood_type;
                document.getElementById('editEmail').value = donor.email;
                document.getElementById('editPhone').value = donor.phone_number;
                document.getElementById('editAddress').value = donor.address;
                // Set form action
                document.getElementById('editDonorForm').action = '/admin/donors/' + donor.id;
            });
        });

        // Delete Donor
        document.querySelectorAll('.delete-donor-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const form = this.closest('.delete-donor-form');
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This action cannot be undone!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    reverseButtons: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // (View/ID Card JS already implemented previously)
    });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>