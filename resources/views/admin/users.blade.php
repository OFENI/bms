<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management | LifeStream Blood Bank</title>
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
        
        /* Responsive */
        @media (max-width: 992px) {
            .side-navbar {
                position: fixed;
                left: -250px;
                top: 56px;
                width: 250px;
                height: calc(100vh - 56px);
                z-index: 1050;
                background: white;
                box-shadow: 2px 0 10px rgba(0,0,0,0.1);
                transition: left 0.3s;
            }
            .side-navbar.active {
                left: 0;
            }
            .main-content {
                margin-left: 0;
                max-width: 100%;
            }
            .page-container {
                padding-top: 56px;
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
            .modal-dialog {
                max-width: 98vw;
                margin: 1rem auto;
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
            .modal-content {
                padding: 0.5rem;
            }
            .modal-body, .modal-header, .modal-footer {
                padding: 1rem !important;
            }
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
                    <a href="#" class="nav-link active">
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
                    <li class="breadcrumb-item active" aria-current="page">User Management</li>
                </ol>
            </nav>

            <!-- Page Title -->
            <div class="page-title">
                <h2>User Management</h2>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        <i class="fas fa-user-plus"></i> Add New User
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

            <!-- User Filter Section -->
<form method="GET" action="{{ route('admin.users') }}">
    <div class="filter-card">
        <div class="row g-3">
            <div class="col-md-3">
                <label for="searchInput" class="form-label">Search</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="searchInput" name="search" value="{{ request('search') }}" placeholder="Name, email, etc.">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-3">
                <label for="roleFilter" class="form-label">Role</label>
                <select class="form-select" id="roleFilter" name="role">
                    <option value="">All Roles</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                    <option value="doctor" {{ request('role') == 'doctor' ? 'selected' : '' }}>Doctor</option>
                    <option value="nurse" {{ request('role') == 'nurse' ? 'selected' : '' }}>Nurse</option>
                    <option value="staff" {{ request('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                    <option value="donor" {{ request('role') == 'donor' ? 'selected' : '' }}>Donor</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="statusFilter" class="form-label">Status</label>
                <select class="form-select" id="statusFilter" name="status">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
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


            <!-- Users Table -->
             @if ($errors->any())
                  <div class="alert alert-danger">
                     <ul class="mb-0">
                          @foreach ($errors->all() as $error)
                         <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                   </div>
                @endif

            <div class="table-card">
                 <div class="card-header">
                    <h3 class="mb-0">Registered Users</h3>
                
                 </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" class="form-check-input">
                                    </th>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Last Active</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                    <tbody>
                    @foreach($users as $user)
                         <tr>
                             <td><input type="checkbox" class="form-check-input"></td>
                             <td>
                                <div class="d-flex align-items-center">
                                   <img src="https://ui-avatars.com/api/?name={{ urlencode($user->username ?? 'User') }}&background=e53935&color=fff" 
                                   alt="{{ $user->username }}" class="rounded-circle me-2" width="40" height="40">
                                <div>
                    <h6 class="mb-0">
                     {{ $user->details->first_name ?? 'No Name' }} {{ $user->details->last_name ?? '' }}
                    </h6>

                   <small class="text-muted">
                      ID: {{ $user->details->custom_id ?? 'N/A' }}
                   </small>
                </div>
            </div>
        </td>
        <td>{{ $user->email }}</td>
        <td>
            @php
                $roleClasses = [
                    'administrator' => 'bg-primary',
                    'doctor' => 'bg-info',
                    'staff' => 'bg-secondary',
                    'donor' => 'bg-warning text-dark',
                ];
                $roleClass = $roleClasses[strtolower($user->role)] ?? 'bg-light';
            @endphp
            <span class="badge {{ $roleClass }}">{{ ucfirst($user->role) }}</span>
        </td>
        <td>{{ $user->updated_at->diffForHumans() }}</td>
        <td>
            <span class="badge bg-success">Active</span>
        </td>
        <td>
  <div class="d-flex action-btns">
    <button
      class="btn btn-outline-primary edit-user-btn"
      data-bs-toggle="modal"
      data-bs-target="#editUserModal"
      data-id="{{ $user->id }}"
      data-first_name="{{ $user->details->first_name ?? '' }}"
      data-last_name="{{ $user->details->last_name ?? '' }}"
      data-email="{{ $user->email }}"
      data-phone_number="{{ $user->details->phone_number ?? '' }}"
      data-role="{{ $user->role }}"
      data-status="{{ $user->status ?? 'active' }}"
    >
      <i class="fas fa-edit"></i>
    </button>

    <button class="btn btn-outline-secondary">
      <i class="fas fa-eye"></i>
    </button>

<form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" class="d-inline delete-user-form">
    @csrf
    @method('DELETE')
    <button type="button" class="btn btn-sm btn-outline-danger delete-user-btn">
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
     
                <div class="card-footer d-flex justify-content-between align-items-center">
                 <div>
                  Showing 
                  <strong>{{ $users->firstItem() }}</strong> to 
                  <strong>{{ $users->lastItem() }}</strong> of 
                  <strong>{{ $users->total() }}</strong> entries
                </div>
  <nav>
    {{ 
      $users
        ->appends(request()->only(['search','role','status']))
        ->links('pagination::bootstrap-5') 
    }}
  </nav>
</div>


            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Create New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.users.store') }}" method="POST" id="createUserForm">
                        @csrf
                        <div class="row g-3">
                            <!-- Role Selector -->
                            <div class="col-md-6">
                                <label for="role" class="form-label">Role</label>
                                <select name="role" id="role" class="form-select" required>
                                    <option value="">-- Select Role --</option>
                                    <option value="donor" {{ old('role') == 'donor' ? 'selected' : '' }}>Donor</option>
                                    <option value="doctor" {{ old('role') == 'doctor' ? 'selected' : '' }}>Doctor</option>
                                    <option value="nurse" {{ old('role') == 'nurse' ? 'selected' : '' }}>Nurse</option>
                                    <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                                </select>
                                @error('role')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>

                            <!-- Institution for staff/doctor -->
                            <div class="col-md-6 staff-field" style="display:none">
  <label for="institution_id" class="form-label">Hospital / Institution</label>
  <select name="institution_id" id="institution_id" class="form-select">
    <option value="">-- Select Institution --</option>
    @foreach($institutions as $inst)
      <option value="{{ $inst->id }}" {{ old('institution_id')==$inst->id?'selected':'' }}>
        {{ $inst->name }}
      </option>
    @endforeach
  </select>
</div>

                            <!-- First Name -->
                            <div class="col-md-6">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" class="form-control" required>
                                @error('first_name')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>

                            <!-- Last Name -->
                            <div class="col-md-6">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" class="form-control" required>
                                @error('last_name')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control" required>
                                @error('email')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>

                            <!-- Phone Number -->
                            <div class="col-md-6">
                                <label for="phone_number" class="form-label">Phone Number</label>
                                <input type="tel" name="phone_number" id="phone_number" value="{{ old('phone_number') }}" class="form-control" required>
                                @error('phone_number')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>

                            <!-- Donor only fields -->
                            <div class="col-md-6 donor-field" style="display:none">
                                <label for="date_of_birth" class="form-label">Date of Birth</label>
                                <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth') }}" class="form-control">
                                @error('date_of_birth')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 donor-field" style="display:none">
                                <label for="blood_group_id" class="form-label">Blood Type</label>
                                <select name="blood_group_id" class="form-select" required>
                              <option value="">-- Choose Blood Type --</option>
                                @foreach($bloodGroups as $group)
                                 <option value="{{ $group->id }}">{{ $group->name }}</option>
                                @endforeach
                                  </select>

                                @error('blood_group_id')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 donor-field" style="display:none">
                                <label for="weight_lbs" class="form-label">Weight (lbs)</label>
                                <input type="number" name="weight_lbs" id="weight_lbs" value="{{ old('weight_lbs') }}" class="form-control">
                                @error('weight_lbs')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 donor-field" style="display:none">
                                <label for="address" class="form-label">Residential Address</label>
                                <input type="text" name="address" id="address" value="{{ old('address') }}" class="form-control">
                                @error('address')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>

                            <!-- Hidden password fields -->
                            <input type="hidden" name="password" id="generatedPassword" value="">
                            <input type="hidden" name="password_confirmation" id="generatedPasswordConfirm" value="">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="createUserForm" class="btn btn-primary">Create User</button>
                </div>
            </div>
        </div>
    </div>


    <script>
document.addEventListener('DOMContentLoaded', function () {
    const roleSelect = document.getElementById('role');
    const staffField = document.querySelector('.staff-field');
    const institutionSelect = document.getElementById('institution_id');

    function toggleFields() {
        const role = roleSelect.value;
        if (['doctor', 'nurse', 'staff'].includes(role)) {
            staffField.style.display = 'block';
            institutionSelect.disabled = false;
            institutionSelect.required = true;
        } else {
            staffField.style.display = 'none';
            institutionSelect.disabled = true; // Disable to prevent sending empty data
            institutionSelect.required = false;
        }
    }

    toggleFields();
    roleSelect.addEventListener('change', toggleFields);
});
</script>




<script>
document.addEventListener('DOMContentLoaded', function () {
    const roleSelect = document.getElementById('role');
    const donorFields = document.querySelectorAll('.donor-field');
    const staffField = document.querySelector('.staff-field');
    const institutionSelect = staffField ? staffField.querySelector('select') : null;

    function toggleFields() {
        const role = roleSelect.value;

        // Toggle staff/institution field
        if (['doctor', 'nurse', 'staff'].includes(role)) {
            staffField.style.display = 'block';
            if (institutionSelect) {
                institutionSelect.required = true;
                institutionSelect.disabled = false;
            }
        } else {
            staffField.style.display = 'none';
            if (institutionSelect) {
                institutionSelect.required = false;
                institutionSelect.disabled = true;
            }
        }

        // Toggle donor-specific fields
        donorFields.forEach(field => {
            const inputs = field.querySelectorAll('input, select');
            if (role === 'donor') {
                field.style.display = 'block';
                inputs.forEach(i => i.required = true);
            } else {
                field.style.display = 'none';
                inputs.forEach(i => i.required = false);
            }
        });
    }

    // Attach listener to role dropdown
    if (roleSelect) {
        roleSelect.addEventListener('change', toggleFields);
        toggleFields(); // Run on load
    }

    // Auto-generate password when modal shows
    const addUserModal = document.getElementById('addUserModal');
    if (addUserModal) {
        addUserModal.addEventListener('show.bs.modal', function () {
            const password = Math.random().toString(36).slice(-10);
            const passwordInput = document.getElementById('generatedPassword');
            const passwordConfirm = document.getElementById('generatedPasswordConfirm');

            if (passwordInput) passwordInput.value = password;
            if (passwordConfirm) passwordConfirm.value = password;
        });
    }

    // SweetAlert success popup — stay until OK
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            html: `{!! nl2br(e(session('success'))) !!}`, // allow line breaks
            confirmButtonText: 'OK',
            allowOutsideClick: false,
            allowEscapeKey: false,
        });
    @endif
});
</script>




    <!-- Edit User Modal -->
  <!-- Edit User Modal -->
<!-- Edit User Modal -->
<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="POST" id="editUserForm">
      @csrf
      @method('PATCH')

      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="user_id" id="editUserId">

          <div class="row g-3">
            <div class="col-md-6">
              <label for="editFirstName" class="form-label">First Name</label>
              <input type="text" name="first_name" id="editFirstName" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label for="editLastName" class="form-label">Last Name</label>
              <input type="text" name="last_name" id="editLastName" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label for="editEmail" class="form-label">Email</label>
              <input type="email" name="email" id="editEmail" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label for="editPhone" class="form-label">Phone Number</label>
              <input type="text" name="phone_number" id="editPhone" class="form-control">
            </div>
            <div class="col-md-6">
              <label for="editRole" class="form-label">Role</label>
              <select name="role" id="editRole" class="form-select" required>
                <option value="administrator">Administrator</option>
                <option value="doctor">Doctor</option>
                <option value="staff">Staff</option>
                <option value="donor">Donor</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="editStatus" class="form-label">Status</label>
              <select name="status" id="editStatus" class="form-select" required>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="pending">Pending</option>
              </select>
            </div>
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
  function openEditModal(user) {
    document.getElementById('editUserId').value = user.id;
    document.getElementById('editFirstName').value = user.detail?.first_name || '';
    document.getElementById('editLastName').value = user.detail?.last_name || '';
    document.getElementById('editEmail').value = user.email;
    document.getElementById('editPhone').value = user.detail?.phone_number || '';
    document.getElementById('editRole').value = user.role;
    document.getElementById('editStatus').value = user.status;

    // Set the form action
    document.getElementById('editUserForm').action = `/admin/users/${user.id}`;

    // Show the modal
    const modal = new bootstrap.Modal(document.getElementById('editUserModal'));
    modal.show();
  }
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
  let formToDelete = null;

  // When any delete-user-btn is clicked...
  document.querySelectorAll('.delete-user-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      formToDelete = btn.closest('form');
      new bootstrap.Modal(document.getElementById('confirmDeleteModal')).show();
    });
  });

  // When Confirm Delete in modal is clicked...
  document.getElementById('confirmDeleteBtn').addEventListener('click', () => {
    if (formToDelete) {
      formToDelete.submit();
    }
  });
});
</script>



<script>
  document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('.edit-user-btn');

    editButtons.forEach(button => {
      button.addEventListener('click', function () {
        document.getElementById('editUserId').value = this.dataset.id;
        document.getElementById('editFirstName').value = this.dataset.first_name;
        document.getElementById('editLastName').value = this.dataset.last_name;
        document.getElementById('editEmail').value = this.dataset.email;
         document.getElementById('editPhone').value = this.dataset.phone_number;
        document.getElementById('editRole').value = this.dataset.role;
        document.getElementById('editStatus').value = this.dataset.status;
      });
    });
    document.querySelectorAll('.edit-user-btn').forEach(button => {
  button.addEventListener('click', () => {
    const userId = button.getAttribute('data-id');
    const form = document.getElementById('editUserForm');
    form.action = `/admin/users/${userId}`;
  });
});

  });
</script>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Set current date
            const now = new Date();
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            document.getElementById('currentDate').textContent = now.toLocaleDateString('en-US', options);
            
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Sidebar toggle for mobile
            const toggleBtn = document.getElementById('toggleSidebar');
            const sidebar = document.querySelector('.side-navbar');
            toggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('active');
                document.body.classList.toggle('sidebar-open');
            });
            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(e) {
                if (window.innerWidth < 992 && sidebar.classList.contains('active')) {
                    if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
                        sidebar.classList.remove('active');
                        document.body.classList.remove('sidebar-open');
                    }
                }
            });

            // Delete confirmation
            document.querySelectorAll('.btn-outline-danger').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const form = this.closest('.delete-user-form');
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This action cannot be undone!",
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
        });
    </script>
    <script>
  document.getElementById('userRole').addEventListener('change', function() {
    const isDonor = this.value === 'donor';
    document.querySelectorAll('.donor-field').forEach(el => {
      el.style.display = isDonor ? '' : 'none';
      el.querySelectorAll('input, select').forEach(inp => {
        inp.required = isDonor;
      });
    });
  });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-user-btn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const form = this.closest('.delete-user-form');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action cannot be undone!",
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
    });
</script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
<!-- In resources/views/layouts/app.blade.php, inside <head> -->
</html>