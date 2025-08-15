<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard | LifeStream Blood Bank</title>
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

    body {
      font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
      background-color: #f9fafb;
      color: var(--text-dark);
      transition: margin-left 0.3s;
      max-width: 100%;
      overflow-x: hidden;
    }

    /* Container for fixed width */
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

    /* Stats Grid */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 15px;
      margin-bottom: 20px;
      max-width: 100%;
    }

    /* Chart containers */
    .chart-container {
      background: white;
      border-radius: 10px;
      padding: 20px;
      margin-bottom: 20px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
      max-width: 100%;
    }

    /* Grid container for side-by-side elements */
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

    /* Rest of your existing styles... */
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

    .quick-actions {
      background-color: white;
      border-radius: 10px;
      padding: 20px;
      margin-bottom: 25px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    .quick-actions-title {
      font-size: 1.1rem;
      font-weight: 600;
      margin-bottom: 15px;
      color: var(--text-dark);
      border-bottom: 2px solid var(--light-red);
      padding-bottom: 8px;
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

    .btn-danger {
      background-color: var(--primary-red);
      border-color: var(--primary-red);
    }

    .btn-danger:hover {
      background-color: var(--dark-red);
      border-color: var(--dark-red);
    }

    .form-control, .form-select {
      border-radius: 6px;
      padding: 0.5rem 0.75rem;
    }

    .form-control:focus, .form-select:focus {
      border-color: var(--primary-red);
      box-shadow: 0 0 0 0.25rem rgba(220, 38, 38, 0.25);
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

    .modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: none; /* hidden by default */
  align-items: center;
  justify-content: center;
  z-index: 1000;
}
.modal-window {
  background: #fff;
  border-radius: 8px;
  width: 90%;
  max-width: 500px;
  padding: 1.5rem;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}
.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.modal-close {
  background: none;
  border: none;
  font-size: 1.5rem;
  cursor: pointer;
}

.modal-overlay {
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(0,0,0,0.5);
  display: none;           /* hidden by default */
  align-items: center;
  justify-content: center;
  z-index: 1000;
}

.modal-window {
  background: #fff;
  border-radius: 8px;
  width: 90%;
  max-width: 500px;
  padding: 1.5rem;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
}

.modal-close {
  background: none;
  border: none;
  font-size: 1.5rem;
  cursor: pointer;
  line-height: 1;
}

.modal-overlay {
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(0,0,0,0.5);
  display: none;           /* hidden by default */
  align-items: center;
  justify-content: center;
  z-index: 1000;
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
          <span>Damu Salama,</span>
          <span>Admin Panel</span>
        </a>
      </div>
      <div class="current-date">{{ \Carbon\Carbon::now()->format('F j, Y') }}</div>
      
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
          <a href="#" class="nav-link active">
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
        <a href="{{  route('admin.donors.index') }}"
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
          <li class="breadcrumb-item active" aria-current="page">Admin Dashboard</li>
        </ol>
      </nav>

      <!-- Welcome Message -->
      <div class="dashboard-card">
        <div class="d-flex align-items-center">
          <div class="me-3">
            <i class="fas fa-user-shield text-danger" style="font-size: 2rem;"></i>
          </div>
          <div>
            <h3>System Overview</h3>
            <p class="mb-0">Welcome back, Admin. Here's a summary of the blood donation system status.</p>
          </div>
        </div>
      </div>

      <!-- Stats Overview -->

      <div class="stats-grid">

  {{-- Total Donors Card --}}
  <div class="stat-card">
    <div class="stat-title">Registered Users</div>
    <div class="stat-value">
      <span class="number-highlight">{{ $totalRealUsers }}</span>

    </div>
    <div class="stat-desc">
      <span class="number-highlight">+</span> this month
    </div>
  </div>

  {{-- Heath Institutions --}}
  <div class="stat-card">
    <div class="stat-title">Heath Institutions</div>
    <div class="stat-value">
       {{ number_format($totalInstitutions) }}
    </div>
    <div class="stat-desc">
      <span class="number-highlight">+</span> today
    </div>
  </div>

  

 {{-- Blood Inventory Card --}}
<div class="stat-card">
  <div class="stat-title">Blood Inventory</div>
  <div class="stat-value">
    <span class="number-highlight">{{ number_format($totalUnits) }}</span> units
  </div>
  <div class="stat-desc">
    <span class="number-highlight">{{ $criticalTypes }}</span> types critical
  </div>
</div>


 {{-- Today’s Donations Card --}}
<div class="stat-card">
  <div class="stat-title">Today's Donations</div>
  <div class="stat-value">
    <span class="number-highlight">{{ $todaysDonations }}</span>
  </div>
  <div class="stat-desc">
    Target: <span class="number-highlight">{{ $donationTarget }}</span>
  </div>
</div>


</div>


      <!-- Charts Section -->
     
      <!-- Quick Actions -->
      <div class="quick-actions">
        <h3 class="quick-actions-title">Admin Quick Actions</h3>
        <div class="stats-grid">

        <a href="#" class="stat-card action-card" id="openDonorModal">
  <div class="stat-title">Donor Information</div>
  <div class="stat-value"><i class="fas fa-user-plus"></i></div>
  <div class="stat-desc">Update Donor Information</div>
</a>




          
          
          <a href="#" class="stat-card action-card">
            <div class="stat-title">Update Inventory</div>
            <div class="stat-value"><i class="fas fa-vial"></i></div>
            <div class="stat-desc">Add blood units</div>
          </a>
          
          <a href="{{ route('admin.institutions.report') }}" class="stat-card action-card" target="_blank">
    <div class="stat-title">Generate Reports</div>
    <div class="stat-value"><i class="fas fa-file-pdf"></i></div>
    <div class="stat-desc">Create system reports</div>
</a>
          
          <a href="#" class="stat-card action-card">
            <div class="stat-title">Manage Centers</div>
            <div class="stat-value"><i class="fas fa-hospital"></i></div>
            <div class="stat-desc">Add/edit locations</div>
          </a>
          
          <a href="#" class="stat-card action-card">
            <div class="stat-title">Send Notifications</div>
            <div class="stat-value"><i class="fas fa-bell"></i></div>
            <div class="stat-desc">Alert donors/staff</div>
          </a>
        </div>
      </div>




        
        <div class="recent-donations">
          <div class="donations-header">
            <h3 class="donations-title">Critical Inventory Levels</h3>
            <a href="#" class="btn btn-sm btn-outline-danger">Manage</a>
          </div>
          <table class="donations-table">
            <thead>
              <tr>
                <th>Blood Type</th>
                <th>Current Stock</th>
                <th>Target Level</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
  @foreach ($inventoryData as $row)
    <tr>
      <td>{{ $row['type'] }}</td>
      <td>{{ $row['total'] }} units</td>
      <td>{{ $row['target'] }} units</td>
      <td>
        <span class="donation-status 
            {{ $row['status'] == 'Critical' ? 'status-critical' : 
               ($row['status'] == 'Low' ? 'status-pending' : '') }}">
          {{ $row['status'] }}
        </span>
      </td>
    </tr>
  @endforeach
</tbody>

          </table>
        </div>
      </div>
    </div>
  </div>



<!-- Donor Modal -->






  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Toggle sidebar
      const toggleBtn = document.getElementById('toggleSidebar');
      toggleBtn.addEventListener('click', function() {
        document.body.classList.toggle('collapsed');
      });

      // Initialize charts
      const bloodTypeCtx = document.getElementById('bloodTypeChart').getContext('2d');
      const bloodTypeChart = new Chart(bloodTypeCtx, {
        type: 'bar',
        data: {
          labels: ['O+', 'A+', 'B+', 'AB+', 'O-', 'A-', 'B-', 'AB-'],
          datasets: [{
            label: 'Donations (last 30 days)',
            data: [85, 72, 58, 42, 38, 32, 28, 15],
            backgroundColor: [
              'rgba(220, 38, 38, 0.7)',
              'rgba(220, 38, 38, 0.7)',
              'rgba(220, 38, 38, 0.7)',
              'rgba(220, 38, 38, 0.7)',
              'rgba(220, 38, 38, 0.7)',
              'rgba(220, 38, 38, 0.7)',
              'rgba(220, 38, 38, 0.7)',
              'rgba(220, 38, 38, 0.7)'
            ],
            borderColor: [
              'rgb(220, 38, 38)',
              'rgb(220, 38, 38)',
              'rgb(220, 38, 38)',
              'rgb(220, 38, 38)',
              'rgb(220, 38, 38)',
              'rgb(220, 38, 38)',
              'rgb(220, 38, 38)',
              'rgb(220, 38, 38)'
            ],
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              title: {
                display: true,
                text: 'Number of Donations'
              }
            }
          }
        }
      });

      const trendsCtx = document.getElementById('donationTrendsChart').getContext('2d');
      const donationTrendsChart = new Chart(trendsCtx, {
        type: 'line',
        data: {
          labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5'],
          datasets: [{
            label: 'Weekly Donations',
            data: [105, 132, 98, 124, 142],
            fill: false,
            borderColor: 'rgb(220, 38, 38)',
            tension: 0.1
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
                text: 'Donations'
              }
            }
          }
        }
      });
      
      // Simulate notifications
      document.querySelector('.notification-bell').addEventListener('click', function() {
        alert('You have 7 notifications:\n- 3 new donor registrations\n- 2 pending appointments\n- 2 critical inventory alerts');
      });
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>