<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Institutions Management | LifeStream Blood Bank</title>
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
        
        /* Institution Card */
        .institution-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            border-top: 3px solid var(--primary-red);
        }
        
        .institution-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .institution-header {
            padding: 15px;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            align-items: center;
        }
        
        .institution-icon {
            width: 40px;
            height: 40px;
            background: var(--light-red);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: var(--primary-red);
            font-size: 18px;
        }
        
        .institution-body {
            padding: 15px;
        }
        
        .institution-detail {
            display: flex;
            margin-bottom: 8px;
        }
        
        .institution-label {
            font-weight: 500;
            min-width: 100px;
            color: var(--text-light);
        }
        
        .institution-value {
            flex: 1;
        }
        
        .inventory-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            margin-right: 5px;
            margin-bottom: 5px;
            background-color: #eef2ff;
            color: #4f46e5;
        }
        
        .inventory-badge.low {
            background-color: #fef3c7;
            color: #d97706;
        }
        
        .inventory-badge.critical {
            background-color: #fee2e2;
            color: #dc2626;
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
            
            .institution-grid {
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
        .institution-grid {
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
                    <a href="#" class="nav-link active">
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
                    <li class="breadcrumb-item active" aria-current="page">Institutions</li>
                </ol>
            </nav>

            <!-- Page Title -->
            <div class="page-title">
                <h2>Institutions Management</h2>
                <div class="d-flex gap-2 align-items-center">
                    <div class="view-toggle me-3">
                        <button class="view-toggle-btn active" id="listViewBtn">
                            <i class="fas fa-list"></i>
                        </button>
                        <button class="view-toggle-btn" id="gridViewBtn">
                            <i class="fas fa-th-large"></i>
                        </button>
                    </div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addInstitutionModal">
                        <i class="fas fa-hospital"></i> Add New Institution
                    </button>
                    

                    <!-- Add Institution Modal -->
<div class="modal fade" id="addInstitutionModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{ route('institutions.store') }}" method="POST">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title">Add New Institution</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <!-- Institution Name -->
            <div class="col-md-6">
              <label for="name" class="form-label">Institution Name</label>
              <input type="text" class="form-control" name="name" id="name" required>
            </div>

            <!-- Institution Type -->
            <div class="col-md-6">
              <label for="type" class="form-label">Institution Type</label>
              <select class="form-select" name="type" id="type" required>
                <option value="" disabled selected>Select Type</option>
                <option value="Hospital">Hospital</option>
                <option value="Clinic">Clinic</option>
                <option value="Blood Bank">Blood Bank</option>
                <option value="Research Center">Research Center</option>
              </select>
            </div>

            <!-- Contact Number -->
            <div class="col-md-6">
              <label for="contact_number" class="form-label">Contact Number</label>
              <input type="text" class="form-control" name="contact_number" id="contact_number">
            </div>

            <!-- Email -->
            <div class="col-md-6">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" name="email" id="email">
            </div>

            <!-- Location / Address -->
            <div class="col-12">
              <label for="location" class="form-label">Address / Location</label>
              <textarea class="form-control" name="location" id="location" rows="2" required></textarea>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Add Institution</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  @if(session()->has('institutionName') && session()->has('tempPassword'))
    Swal.fire({
      icon: 'success',
      title: 'Institution Registered!',
      html: `
        <p><strong>{{ session('institutionName') }}</strong> has been added.</p>
        <p><strong>Email:</strong> {{ session('institutionEmail') }}</p>
        <p><strong>Temporary Password:</strong> {{ session('tempPassword') }}</p>
      `,
      confirmButtonText: 'OK'
    });
  @elseif(session()->has('success'))
    Swal.fire({
      icon: 'success',
      title: '{{ session('success') }}',
      confirmButtonText: 'OK'
    });
  @endif
</script>


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

            <!-- Institution Filter Section -->
       
      <form method="GET" action="{{ route('admin.institutions') }}">
  <div class="filter-card mb-4">
    <div class="row g-3">
      <!-- Search -->
      <div class="col-md-3">
        <label for="search" class="form-label">Search</label>
        <div class="input-group">
          <input
            type="text"
            class="form-control"
            id="search"
            name="search"
            value="{{ request('search') }}"
            placeholder="Name, location, etc.">
          <button class="btn btn-outline-secondary" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>

      <!-- Type -->
      <div class="col-md-3">
        <label for="type" class="form-label">Institution Type</label>
        <select class="form-select" id="type" name="type">
          <option value="">All Types</option>
          <option value="Hospital" {{ request('type')=='Hospital' ? 'selected' : '' }}>Hospital</option>
          <option value="Clinic"   {{ request('type')=='Clinic'   ? 'selected' : '' }}>Clinic</option>
          <option value="Blood Bank" {{ request('type')=='Blood Bank' ? 'selected' : '' }}>Blood Bank</option>
          <option value="Research Center" {{ request('type')=='Research Center' ? 'selected' : '' }}>Research Center</option>
        </select>
      </div>

      <!-- Status -->
      <div class="col-md-3">
        <label for="status" class="form-label">Status</label>
        <select class="form-select" id="status" name="status">
          <option value="">All Statuses</option>
          <option value="active"   {{ request('status')=='active'   ? 'selected' : '' }}>Active</option>
          <option value="inactive" {{ request('status')=='inactive' ? 'selected' : '' }}>Inactive</option>
     
        </select>
      </div>

      <!-- Apply -->
      <div class="col-md-3 d-flex align-items-end">
        <button class="btn btn-outline-secondary w-100" type="submit">
          <i class="fas fa-filter"></i> Apply Filters
        </button>
      </div>
    </div>
  </div>
</form>


            <!-- Institutions Table (List View) -->
            <div class="table-card" id="listView">
                <div class="card-header">
                    <h3 class="mb-0">Registered Institutions</h3>
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
                                    <th>Institution</th>
                                    <th>Type</th>
                                    <th>Location</th>
                                    <th>Contact</th>
                                    <th>Blood Inventory</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
  @foreach($institutions as $institution)
                        <tr>
      <td><input type="checkbox" class="form-check-input"></td>

      {{-- Institution name + ID --}}
      <td>
        <div class="d-flex align-items-center">
          <div class="institution-icon">
            {{-- Pick an icon by type (you can expand this mapping) --}}
            @switch($institution->type)
              @case('Hospital')     <i class="fas fa-hospital"></i>@break
              @case('Clinic')       <i class="fas fa-clinic-medical"></i>@break
              @case('Blood Bank')   <i class="fas fa-tint"></i>@break
              @case('Research Center') <i class="fas fa-flask"></i>@break
              @default              <i class="fas fa-building"></i>
            @endswitch
          </div>
          <div class="ms-2">
            <h6 class="mb-0">{{ $institution->name }}</h6>
            <small class="text-muted">ID: INST-{{ $institution->id }}</small>
          </div>
        </div>
      </td>

      {{-- Type badge --}}
      <td>
        @php
          // simple color map; adjust to your palette
          $color = match($institution->type) {
            'Hospital' => 'primary',
            'Clinic'   => 'info',
            'Blood Bank' => 'secondary',
            'Research Center' => 'warning text-dark',
            default    => 'dark',
          };
        @endphp
        <span class="badge bg-{{ $color }}">{{ $institution->type }}</span>
      </td>

      {{-- Location --}}
      <td>{{ $institution->location }}</td>

      {{-- Contact info --}}
      <td>
        @if($institution->email)
          {{ $institution->email }}<br>
        @endif
        @if($institution->contact_number)
          {{ $institution->contact_number }}
        @endif
      </td>

      {{-- Blood inventory badges --}}
      <td>
  @php
    $inventory = $institution->inventory ?? [];
  @endphp
  @if(count($inventory))
    @foreach($inventory as $item)
      <span class="inventory-badge
        @if($item->quantity == 0) critical
        @elseif($item->quantity <= 2) low
        @endif
      ">
      {{ $item->bloodGroup->name ?? 'Unknown' }}: {{ $item->quantity }} units

      </span>
    @endforeach
  @else
    <small class="text-muted">No inventory records</small>
  @endif
</td>

      {{-- Status (assuming you have a status field) --}}
      <td>
  @if(($institution->inventory ?? collect())->isNotEmpty())
    <span class="badge bg-success">Active</span>
  @else
    <span class="badge bg-secondary">Inactive</span>
  @endif
</td>


      {{-- Actions --}}
      <td>
        <div class="d-flex action-btns">
          <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editInstitutionModal{{ $institution->id }}">
            <i class="fas fa-edit"></i>
          </button>
          <a href="#" 
   class="btn btn-outline-secondary" 
   data-bs-toggle="modal" 
   data-bs-target="#viewInstitutionModal{{ $institution->id }}">
  <i class="fas fa-eye"></i>
</a>

 <form action="{{ route('institutions.destroy', $institution) }}" method="POST" class="d-inline">
  @csrf @method('DELETE')
  <button type="button" class="btn btn-outline-danger btn-sm delete-btn">
    <i class="fas fa-trash"></i>
  </button>
</form>

        </div>
      </td>
    </tr>
   

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.preventDefault();
      const form = this.closest('form');

      Swal.fire({
        title: 'Are you sure?',
        text: 'This will permanently delete the institution.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it',
        cancelButtonText: 'Cancel',
      }).then((result) => {
        if (result.isConfirmed) {
          form.submit();
        }
      });
    });
  });
</script>

<!-- Edit Institution Modal -->
<div class="modal fade" id="editInstitutionModal{{ $institution->id }}" tabindex="-1" aria-labelledby="editInstitutionLabel{{ $institution->id }}" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{ route('institutions.update', $institution->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title" id="editInstitutionLabel{{ $institution->id }}">Edit Institution</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label>Name</label>
              <input type="text" name="name" class="form-control" value="{{ $institution->name }}" required>
            </div>

            <div class="col-md-6">
              <label>Type</label>
              <select name="type" class="form-select" required>
                <option value="Hospital" {{ $institution->type == 'Hospital' ? 'selected' : '' }}>Hospital</option>
                <option value="Clinic" {{ $institution->type == 'Clinic' ? 'selected' : '' }}>Clinic</option>
                <option value="Blood Bank" {{ $institution->type == 'Blood Bank' ? 'selected' : '' }}>Blood Bank</option>
                <option value="Research Center" {{ $institution->type == 'Research Center' ? 'selected' : '' }}>Research Center</option>
              </select>
            </div>

            <div class="col-md-6">
              <label>Location</label>
              <input type="text" name="location" class="form-control" value="{{ $institution->location }}" required>
            </div>

            <div class="col-md-6">
              <label>Email</label>
              <input type="email" name="email" class="form-control" value="{{ $institution->email }}">
            </div>

            <div class="col-md-6">
              <label>Contact Number</label>
              <input type="text" name="contact_number" class="form-control" value="{{ $institution->contact_number }}">
            </div>

            <div class="col-md-6">
              <label>Status</label>
              <select name="status" class="form-select">
                <option value="active" {{ $institution->status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $institution->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
              </select>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save Changes</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>

      </form>
    </div>
  </div>
</div>
  @endforeach

  <!-- View Institution Modal -->

  @foreach($institutions as $institution)
 <div class="modal fade" id="viewInstitutionModal{{ $institution->id }}" tabindex="-1" aria-labelledby="viewInstitutionLabel{{ $institution->id }}" aria-hidden="true">
  <div class="modal-dialog modal-md"> <!-- smaller modal -->
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="viewInstitutionLabel{{ $institution->id }}">Institution Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="row g-3">
          <div class="col-6">
            <label class="form-label">Name</label>
            <input type="text" class="form-control" value="{{ $institution->name }}" readonly>
          </div>

          <div class="col-6">
            <label class="form-label">Type</label>
            <input type="text" class="form-control" value="{{ $institution->type }}" readonly>
          </div>

          <div class="col-6">
            <label class="form-label">Location</label>
            <input type="text" class="form-control" value="{{ $institution->location }}" readonly>
          </div>

          <div class="col-6">
            <label class="form-label">Status</label>
            <input type="text" class="form-control" value="{{ ucfirst($institution->status) }}" readonly>
          </div>

          <div class="col-6">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" value="{{ $institution->email ?? 'N/A' }}" readonly>
          </div>

          <div class="col-6">
            <label class="form-label">Contact Number</label>
            <input type="text" class="form-control" value="{{ $institution->contact_number ?? 'N/A' }}" readonly>
          </div>

          <div class="col-12">
            <label class="form-label">Blood Inventory</label>
            @if($institution->inventory && $institution->inventory->count())
              <ul class="list-group">
                @foreach($institution->inventory as $item)
                  <li class="list-group-item p-1">
                    <small>{{ $item->bloodGroup->type }}: {{ $item->quantity }} units</small>
                  </li>
                @endforeach
              </ul>
            @else
              <p class="text-muted small mb-0">No blood inventory records.</p>
            @endif
          </div>
        </div>
      </div>

      <div class="modal-footer py-2">
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

@endforeach
</tbody>

</table>
</div>
 </div>

              @if ($institutions->count())
    <div class="card-footer d-flex justify-content-between align-items-center">
        <div>
    Showing <strong>{{ $institutions->firstItem() }}</strong> 
    to <strong>{{ $institutions->lastItem() }}</strong> 
    of <strong>{{ $institutions->total() }}</strong> entries
</div>
        <nav>
            {!! $institutions->links('pagination::bootstrap-5') !!}
        </nav>
    </div>
@else
    <div class="card-footer text-center text-muted">
        No institutions found.
    </div>
@endif

            </div>

            <!-- Institutions Grid (Card View) -->
            <div class="institution-grid" id="gridView" style="display: none;">
                <!-- Institution Card 1 -->
                <!-- Grid View -->
    @foreach($institutions as $institution)
        <div class="institution-card">
            <div class="institution-header">
                <div class="institution-icon">
                    @switch($institution->type)
                        @case('Hospital') <i class="fas fa-hospital"></i>@break
                        @case('Clinic') <i class="fas fa-clinic-medical"></i>@break
                        @case('Blood Bank') <i class="fas fa-tint"></i>@break
                        @case('Research Center') <i class="fas fa-flask"></i>@break
                        @default <i class="fas fa-building"></i>
                    @endswitch
                </div>
                <div>
                    <h6 class="mb-0">{{ $institution->name }}</h6>
                    <small class="text-muted">ID: INST-{{ $institution->id }}</small>
                </div>
            </div>

            <div class="institution-body">
                <div class="institution-detail">
                    <div class="institution-label">Type:</div>
                    <div class="institution-value">
                        @php
                            $color = match($institution->type) {
                                'Hospital' => 'primary',
                                'Clinic'   => 'info',
                                'Blood Bank' => 'secondary',
                                'Research Center' => 'warning text-dark',
                                default => 'dark',
                            };
                        @endphp
                        <span class="badge bg-{{ $color }}">{{ $institution->type }}</span>
                    </div>
                </div>

                <div class="institution-detail">
                    <div class="institution-label">Location:</div>
                    <div class="institution-value">{{ $institution->location }}</div>
                </div>

                <div class="institution-detail">
                    <div class="institution-label">Contact:</div>
                    <div class="institution-value">
                        @if($institution->email)
                            {{ $institution->email }}<br>
                        @endif
                        @if($institution->contact_number)
                            {{ $institution->contact_number }}
                        @endif
                    </div>
                </div>

                <div class="institution-detail">
    <div class="institution-label">Inventory:</div>
    <div class="institution-value">
        @forelse($institution->inventory ?? [] as $item)
            <span class="inventory-badge 
                @if($item->quantity == 0) critical 
                @elseif($item->quantity <= 2) low 
                @endif">
                {{ $item->bloodGroup->name }}: {{ $item->quantity }} units
            </span>
        @empty
            <small class="text-muted">No inventory records</small>
        @endforelse
    </div>
</div>


                <div class="institution-detail">
    <div class="institution-label">Status:</div>
    <div class="institution-value">
        @php
            $hasInventory = isset($institution->inventory) && $institution->inventory->count() > 0;
        @endphp

        @if($hasInventory)
            <span class="badge bg-success">Active</span>
        @else
            <span class="badge bg-secondary">Inactive</span>
        @endif
    </div>
</div>


                <div class="d-flex action-btns justify-content-end mt-3">
                    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editInstitutionModal{{ $institution->id }}">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#viewInstitutionModal{{ $institution->id }}">
                        <i class="fas fa-eye"></i>
                    </button>
                    <form action="{{ route('institutions.destroy', $institution) }}" method="POST" class="d-inline delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-outline-danger delete-btn">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>

            </div>
        </div>
    </div>

    <!-- Add Institution Modal -->
    <div class="modal fade" id="addInstitutionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Institution</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="institutionName" class="form-label">Institution Name</label>
                                <input type="text" class="form-control" id="institutionName" required>
                            </div>
                            <div class="col-md-6">
                                <label for="institutionType" class="form-label">Institution Type</label>
                                <select class="form-select" id="institutionType" required>
                                    <option value="">Select Type</option>
                                    <option value="hospital">Hospital</option>
                                    <option value="clinic">Clinic</option>
                                    <option value="bloodbank">Blood Bank</option>
                                    <option value="research">Research Center</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="contactPerson" class="form-label">Contact Person</label>
                                <input type="text" class="form-control" id="contactPerson" required>
                            </div>
                            <div class="col-md-6">
                                <label for="contactEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="contactEmail" required>
                            </div>
                            <div class="col-md-6">
                                <label for="contactPhone" class="form-label">Phone</label>
                                <input type="tel" class="form-control" id="contactPhone">
                            </div>
                            <div class="col-md-6">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="pending">Pending Approval</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control" id="address" rows="2"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="city" class="form-label">City</label>
                                <input type="text" class="form-control" id="city">
                            </div>
                            <div class="col-md-6">
                                <label for="postalCode" class="form-label">Postal Code</label>
                                <input type="text" class="form-control" id="postalCode">
                            </div>
                            <div class="col-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" rows="3"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Add Institution</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Institution Modal -->
    <div class="modal fade" id="editInstitutionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Institution</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="editInstitutionName" class="form-label">Institution Name</label>
                                <input type="text" class="form-control" id="editInstitutionName" value="City General Hospital" required>
                            </div>
                            <div class="col-md-6">
                                <label for="editInstitutionType" class="form-label">Institution Type</label>
                                <select class="form-select" id="editInstitutionType" required>
                                    <option value="hospital" selected>Hospital</option>
                                    <option value="clinic">Clinic</option>
                                    <option value="bloodbank">Blood Bank</option>
                                    <option value="research">Research Center</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="editContactPerson" class="form-label">Contact Person</label>
                                <input type="text" class="form-control" id="editContactPerson" value="Dr. John Smith" required>
                            </div>
                            <div class="col-md-6">
                                <label for="editContactEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="editContactEmail" value="contact@cityhospital.org" required>
                            </div>
                            <div class="col-md-6">
                                <label for="editContactPhone" class="form-label">Phone</label>
                                <input type="tel" class="form-control" id="editContactPhone" value="(555) 123-4567">
                            </div>
                            <div class="col-md-6">
                                <label for="editStatus" class="form-label">Status</label>
                                <select class="form-select" id="editStatus" required>
                                    <option value="active" selected>Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="pending">Pending Approval</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="editAddress" class="form-label">Address</label>
                                <textarea class="form-control" id="editAddress" rows="2">123 Medical Blvd, City Center</textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="editCity" class="form-label">City</label>
                                <input type="text" class="form-control" id="editCity" value="Metropolis">
                            </div>
                            <div class="col-md-6">
                                <label for="editPostalCode" class="form-label">Postal Code</label>
                                <input type="text" class="form-control" id="editPostalCode" value="12345">
                            </div>
                            <div class="col-12">
                                <label for="editDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="editDescription" rows="3">A full-service hospital providing comprehensive medical care to the community since 1985.</textarea>
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
            toggleBtn.addEventListener('click', function() {
                document.body.classList.toggle('collapsed');
            });

            // View toggle
            const listViewBtn = document.getElementById('listViewBtn');
            const gridViewBtn = document.getElementById('gridViewBtn');
            const listView = document.getElementById('listView');
            const gridView = document.getElementById('gridView');
            
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

            // Delete confirmation
            document.querySelectorAll('.btn-outline-danger').forEach(button => {
                button.addEventListener('click', function() {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire(
                                'Deleted!',
                                'Institution has been deleted.',
                                'success'
                            );
                        }
                    });
                });
            });
        });
    </script>
    <script>
  document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.delete-btn');

    deleteButtons.forEach(button => {
      button.addEventListener('click', function (e) {
        e.preventDefault();
        const form = this.closest('form');

        Swal.fire({
          title: 'Are you sure?',
          text: "This institution will be deleted!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#e3342f',
          cancelButtonColor: '#6c757d',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            form.submit();
          }
        });
      });
    });
  });
</script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>s