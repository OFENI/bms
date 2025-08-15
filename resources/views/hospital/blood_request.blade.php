<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Requests | Hospital Dashboard</title>
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
        
        .badge-pending {
            background-color: rgba(243, 156, 18, 0.15);
            color: var(--warning);
        }
        
        .badge-partial {
            background-color: rgba(52, 152, 219, 0.15);
            color: var(--secondary);
        }
        
        .badge-fulfilled {
            background-color: rgba(39, 174, 96, 0.15);
            color: var(--success);
        }
        
        .badge-urgent {
            background-color: rgba(231, 76, 60, 0.15);
            color: var(--danger);
        }
        
        .badge-normal {
            background-color: rgba(149, 165, 166, 0.15);
            color: #7f8c8d;
        }
        
        .badge-high {
            background-color: rgba(241, 196, 15, 0.15);
            color: #f39c12;
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
        
        /* Request Form */
        .request-form-container {
            display: none;
            margin-bottom: 30px;
        }
        
        .request-form-card {
            border-left: 4px solid var(--secondary);
        }
        
        /* Status Indicators */
        .status-indicator {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 8px;
        }
        
        .status-pending {
            background-color: var(--warning);
        }
        
        .status-partial {
            background-color: var(--secondary);
        }
        
        .status-fulfilled {
            background-color: var(--success);
        }
        
        .status-cancelled {
            background-color: var(--danger);
        }
        
        /* Timeline */
        .timeline-item {
            display: flex;
            margin-bottom: 20px;
            position: relative;
        }
        
        .timeline-item:last-child {
            margin-bottom: 0;
        }
        
        .timeline-marker {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background-color: #f8f9fa;
            border: 2px solid var(--secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
            z-index: 2;
        }
        
        .timeline-marker i {
            font-size: 12px;
            color: var(--secondary);
        }
        
        .timeline-content {
            flex: 1;
            padding-bottom: 20px;
            border-left: 2px solid #e0e0e0;
            padding-left: 20px;
            padding-bottom: 10px;
        }
        
        .timeline-title {
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .timeline-date {
            font-size: 0.85rem;
            color: #777;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                width: 80px;
            }
            
            .menu-text {
                display: none;
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
            
            .sidebar {
                position: fixed;
                left: -80px;
                z-index: 1000;
                height: calc(100vh - 80px);
            }
            
            .sidebar.open {
                left: 0;
            }
            
            .mobile-menu-btn {
                display: block;
            }
        }
        
        /* Notification Panel */
        .notification-panel {
            position: fixed;
            top: 80px;
            right: -400px;
            width: 380px;
            height: calc(100vh - 80px);
            background-color: white;
            box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
            z-index: 999;
            transition: right 0.3s ease;
            overflow-y: auto;
            padding: 20px;
        }
        
        .notification-panel.open {
            right: 0;
        }
        
        .notification-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        
        .notification-item {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 15px;
            background-color: #f9f9f9;
            border-left: 4px solid var(--secondary);
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .notification-item.unread {
            background-color: rgba(52, 152, 219, 0.08);
            border-left: 4px solid var(--accent);
        }
        
        .notification-item:hover {
            transform: translateX(-5px);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }
        
        .notification-title {
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .notification-time {
            font-size: 0.85rem;
            color: #777;
        }
    </style>
</head>
<body>
@include('layouts.partials.header', ['user' => Auth::user(), 'hospital' => Auth::user()->institution])
    <!-- Header -->
    
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

               <li class="menu-item">
  <a 
    href="{{ route('hospital.inventory') }}" 
    class="menu-link"
    style="display: flex; align-items: center; text-decoration: none; color: inherit;"
  >    
    <i class="fas fa-tint" style="margin-right: 20px;"></i>
    <span class="menu-text">Blood Inventory</span>
  </a>
</li>


                <li class="menu-item active">
                    <i class="fas fa-hand-holding-medical"></i>
                    <span class="menu-text">Blood Requests</span>
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
        
        <!-- Main Content - Blood Requests -->
        <div class="main-content">
            <div class="dashboard-title">
                <h1><i class="fas fa-syringe me-3"></i>Blood Requests Management</h1>
                <button class="btn btn-primary" id="newRequestBtn" type="button">
    <i class="fas fa-plus-circle me-2"></i>New Blood Request
</button>
            </div>
            
            <!-- Stats Overview -->
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-icon" style="background-color: rgba(243, 156, 18, 0.1); color: var(--warning);">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-value">{{ $pendingCount }}</div>
                    <div class="stat-title">Pending Requests</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon" style="background-color: rgba(52, 152, 219, 0.1); color: var(--secondary);">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <div class="stat-value">{{ $partialRequests->count() }}</div>
                    <div class="stat-title">Partially Fulfilled</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon" style="background-color: rgba(39, 174, 96, 0.1); color: var(--success);">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-value">{{ $fulfilledCount }}</div>
                    <div class="stat-title">Fulfilled Requests</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon" style="background-color: rgba(231, 76, 60, 0.1); color: var(--danger);">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="stat-value">{{ $urgentCount }}</div>
                    <div class="stat-title">Urgent Requests</div>
                </div>
            </div>
            
            <!-- New Request Form -->
            <div class="request-form-container" id="requestFormContainer" style="display:none;">
                <div class="card request-form-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-file-medical me-2"></i>New Blood Request
                        </div>
                        <button class="btn btn-sm btn-outline-secondary" id="closeRequestForm" type="button">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="card-body">
                    <form method="POST" action="{{ route('hospital.requests.store') }}">
    @csrf
    <div class="row g-3">
        <!-- Request To -->
        <div class="col-12 col-md-6">
            <label for="requested_from_id" class="form-label">Request To</label>
            <select name="requested_from_id" id="requested_from_id" class="form-select" required>
                <option value="">Select Institution</option>
                @foreach($institutions as $institution)
                    <option value="{{ $institution->id }}">{{ $institution->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Blood Group -->
        <div class="col-12 col-md-6">
            <label for="blood_group_id" class="form-label">Blood Group</label>
            <select name="blood_group_id" id="blood_group_id" class="form-select" required>
                <option value="">Select Blood Group</option>
                @foreach($bloodGroups as $group)
                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Quantity -->
        <div class="col-12 col-md-6">
            <label for="quantity" class="form-label">Quantity (Units)</label>
            <input type="number" name="quantity" id="quantity" class="form-control" min="1" required>
        </div>

        <!-- Urgency Level -->
        <div class="col-12 col-md-6">
            <label for="urgency_level" class="form-label">Urgency Level</label>
            <select name="urgency_level" id="urgency_level" class="form-select" required>
                <option value="normal">Normal</option>
                <option value="urgent">Urgent</option>
                
            </select>
        </div>

        <!-- Notes -->
        <div class="col-12">
            <label for="notes" class="form-label">Notes (Optional)</label>
            <textarea name="notes" id="notes" class="form-control"></textarea>
        </div>

        <!-- Requested Date (auto-filled) -->
        <input type="hidden" name="requested_date" value="{{ now() }}">

        <!-- Status (default to pending) -->
        <input type="hidden" name="status" value="pending">

        <!-- Fulfilled Date (leave optional for the other hospital) -->
        {{-- You can remove this field entirely, or leave it hidden --}}
        <input type="hidden" name="fulfilled_date" value="">

        <!-- Submit Button -->
        <div class="col-12 d-flex justify-content-end mt-3">
            <button type="submit" class="btn btn-primary">Submit Request</button>
        </div>
    </div>
</form>

                    </div>
                </div>
            </div>


            @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
    <i class="fas fa-check-circle me-2"></i>
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif

            <!-- End Responsive New Request Form -->

<script>
  document.getElementById('newRequestBtn').addEventListener('click', () => {
    document.getElementById('requestFormContainer').style.display = 'block';
  });
  document.getElementById('closeRequestForm').addEventListener('click', () => {
    document.getElementById('requestFormContainer').style.display = 'none';
  });
  document.getElementById('cancelRequestBtn').addEventListener('click', () => {
    document.getElementById('requestFormContainer').style.display = 'none';
  });
</script>


            
            <div class="row">
                <!-- Pending Requests -->
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-list me-2"></i>Pending Blood Requests
                            </div>
                            <div>
                                <button class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                        
                                            <th>Blood Type</th>
                                            <th>Quantity</th>
                                            <th>Request Date</th>
                                            <th>Urgency</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                            </thead>
                                            <!-- Pending Requests -->
                                               <tbody>
                                              @forelse ($pendingRequests as $request)
                                         <tr>
   
        <td>{{ $request->bloodGroup->name ?? 'N/A' }}</td>
        <td>{{ $request->quantity }} units</td>
        <td>{{ \Carbon\Carbon::parse($request->requested_date)->format('M d, Y') }}</td>
        <td>
            <span class="badge 
                @if($request->urgency_level === 'critical') badge-urgent
                @elseif($request->urgency_level === 'high') badge-high
                @else badge-normal
                @endif">
                {{ ucfirst($request->urgency_level) }}
            </span>
        </td>
        <td>
            <span class="status-indicator status-pending"></span>
            <span class="badge badge-pending">Pending</span>
        </td>
        <td>
        <button 
  class="btn btn-sm btn-outline-primary me-1 viewRequestBtn" 
  data-bs-toggle="modal"
  data-bs-target="#requestDetailsModal"
  data-hospital="{{ $request->requestedFromInstitution->name ?? 'N/A' }}"
  data-blood-group="{{ $request->bloodGroup->name ?? 'N/A' }}"
  data-quantity="{{ $request->quantity }}"
  data-urgency="{{ $request->urgency_level }}"
  data-date="{{ \Carbon\Carbon::parse($request->requested_date)->format('M d, Y h:i A') }}"
  data-status="{{ $request->status }}"
  data-notes="{{ $request->notes ?? 'N/A' }}"
>
  <i class="fas fa-eye"></i>
</button>


            <button class="btn btn-sm btn-outline-danger cancelRequestBtn"
    data-request-id="{{ $request->id }}"
    title="Cancel">
    <i class="fas fa-times"></i>
</button>
        </td>
    </tr>
 
@empty
    <tr>
        <td colspan="7" class="text-center">No pending requests.</td>
    </tr>
@endforelse
</tbody>


  </table>
</div>
</div>
</div>
<!-- Request Details Modal -->
<div class="modal fade" id="requestDetailsModal" tabindex="-1" aria-labelledby="requestDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Blood Request Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>Hospital:</strong> <span id="modalHospital"></span></p>
                <p><strong>Blood Group:</strong> <span id="modalBloodGroup"></span></p>
                <p><strong>Quantity:</strong> <span id="modalQuantity"></span> units</p>
                <p><strong>Urgency:</strong> <span id="modalUrgency"></span></p>
                <p><strong>Requested Date:</strong> <span id="modalRequestedDate"></span></p>
                <p><strong>Status:</strong> <span id="modalStatus"></span></p>
                <p><strong>Notes:</strong> <span id="modalNotes"></span></p>
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const viewButtons = document.querySelectorAll('.viewRequestBtn');

    viewButtons.forEach(button => {
        button.addEventListener('click', function () {
            console.log('Clicked, hospital:', this.dataset.hospital);

            document.getElementById('modalHospital').textContent = this.dataset.hospital;
            document.getElementById('modalBloodGroup').textContent = this.dataset.bloodGroup;
            document.getElementById('modalQuantity').textContent = this.dataset.quantity;
            document.getElementById('modalUrgency').textContent = this.dataset.urgency;
            document.getElementById('modalRequestedDate').textContent = this.dataset.date;
            document.getElementById('modalStatus').textContent = this.dataset.status;
            document.getElementById('modalNotes').textContent = this.dataset.notes;
        });
    });
});
</script>


                    
                    <!-- Request History -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-history me-2"></i>Request History
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Request ID</th>
                                            <th>Blood Type</th>
                                            <th>Quantity</th>
                                            <th>Request Date</th>
                                            <th>Fulfillment Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
@foreach($fulfilledRequests as $request)
<tr>
    <td>{{ $request->id }}</td>
    <td>{{ $request->bloodGroup->name ?? 'N/A' }}</td>
    <td>{{ $request->quantity }} units</td>
    <td>{{ \Carbon\Carbon::parse($request->requested_date)->format('M d, Y') }}</td>
    <td>{{ $request->fulfilled_date ? \Carbon\Carbon::parse($request->fulfilled_date)->format('M d, Y') : '-' }}</td>
    <td>
        <span class="status-indicator status-fulfilled"></span>
        <span class="badge badge-fulfilled">{{ ucfirst($request->status) }}</span>
    </td>
</tr>
@endforeach
</tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Request Timeline & Notifications -->
                <div class="col-lg-4">
                    <!-- Request Status Timeline -->
                    @foreach($requests as $request)
    <div class="timeline-item">
        <div class="timeline-marker"><i class="fas fa-file-medical"></i></div>
        <div class="timeline-content">
            <div class="timeline-title">Request Submitted</div>
            <div class="timeline-date">
                {{ \Carbon\Carbon::parse($request->submitted_at)->format('M d, Y \a\t h:i A') }}
            </div>
            <div class="text-muted">
                Blood type: {{ $request->bloodGroup->name ?? 'N/A' }} | Quantity: {{ $request->quantity }} units
            </div>
        </div>
    </div>
@endforeach

                    
                    <!-- Notifications -->
                    <div class="card mb-4">
  <div class="card-header">
    <i class="fas fa-bell me-2"></i>New Incoming Requests
  </div>
  <div class="card-body">
    {{-- HEADER YOU WANTED: --}}
    

    @forelse($pendingIncoming as $req)
      <div class="alert alert-primary">
        <strong>{{ $req->requesterInstitution->name }}</strong>
        requested {{ $req->quantity }} units of
        {{ $req->bloodGroup->name }}
        on {{ \Carbon\Carbon::parse($req->created_at)->format('M d, Y H:i') }}.
      </div>
    @empty
      <div class="alert alert-secondary">No new incoming requests.</div>
    @endforelse
  </div>
</div>



    
    <!-- Notification Panel -->
    <div class="notification-panel" id="notificationPanel">
        <div class="notification-header">
            <h5>Notifications ({{ $incomingCount }})</h5>
            <button class="btn btn-sm btn-outline-secondary" id="closeNotificationPanel">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="notification-list">
            <div class="notification-item unread">
                <div class="notification-title">New Blood Request Approved</div>
                <div class="notification-desc">Your request for 5 units of O+ blood has been approved.</div>
                <div class="notification-time">2 hours ago</div>
            </div>
            
            <div class="notification-item unread">
                <div class="notification-title">Partial Fulfillment</div>
                <div class="notification-desc">Your request for 8 units of A- has been partially fulfilled (5 units).</div>
                <div class="notification-time">5 hours ago</div>
            </div>
            
            <div class="notification-item unread">
                <div class="notification-title">Urgent: Critical Levels</div>
                <div class="notification-desc">O- blood type is critically low. Only 5 units available.</div>
                <div class="notification-time">Yesterday</div>
            </div>
            
            <div class="notification-item">
                <div class="notification-title">New Donation Received</div>
                <div class="notification-desc">3 units of AB+ blood added to inventory.</div>
                <div class="notification-time">Oct 12, 2023</div>
            </div>
            
            <div class="notification-item">
                <div class="notification-title">Disbursement Completed</div>
                <div class="notification-desc">Your request for 10 units of B+ has been fulfilled.</div>
                <div class="notification-time">Oct 10, 2023</div>
            </div>
        </div>
    </div>
    
    <script>
document.addEventListener('DOMContentLoaded', function() {
  // 🔔 Notification panel
  const notificationToggle     = document.getElementById('notificationToggle');
  const notificationPanel      = document.getElementById('notificationPanel');
  const closeNotificationPanel = document.getElementById('closeNotificationPanel');
  if (notificationToggle && notificationPanel && closeNotificationPanel) {
    notificationToggle.addEventListener('click', () => notificationPanel.classList.toggle('open'));
    closeNotificationPanel.addEventListener('click', () => notificationPanel.classList.remove('open'));
  }

  // ✏️ New Request form
  const newRequestBtn       = document.getElementById('newRequestBtn');
  const requestFormContainer= document.getElementById('requestFormContainer');
  const closeRequestForm    = document.getElementById('closeRequestForm');
  const cancelRequestBtn    = document.getElementById('cancelRequestBtn');
  const submitRequestBtn    = document.getElementById('submitRequestBtn');

  if (newRequestBtn && requestFormContainer) {
    newRequestBtn.addEventListener('click', () => {
      requestFormContainer.style.display = 'block';
      window.scrollTo({ top: requestFormContainer.offsetTop - 20, behavior: 'smooth' });
    });
  }
  [closeRequestForm, cancelRequestBtn].forEach(btn => {
    if (btn) btn.addEventListener('click', () => requestFormContainer.style.display = 'none');
  });
  if (submitRequestBtn) {
    submitRequestBtn.addEventListener('click', function(e) {
      e.preventDefault();  // important!
      const bloodType = document.getElementById('bloodType')?.value;
      const quantity  = document.getElementById('quantity')?.value;
      if (!bloodType || !quantity) {
        return alert('Please select a blood type and enter quantity');
      }
      alert(`Request submitted for ${quantity} units of ${bloodType} blood`);
      requestFormContainer.style.display = 'none';
      // optionally reset form fields here
    });
  }

  // ☰ Mobile sidebar
  const menuToggle = document.getElementById('menuToggle');
  const sidebar    = document.getElementById('sidebar');
  if (menuToggle && sidebar) {
    menuToggle.addEventListener('click', () => sidebar.classList.toggle('open'));
  }

  // Mark individual notifications as “read”
  document.querySelectorAll('.notification-item').forEach(item => {
    item.addEventListener('click', () => item.classList.remove('unread'));
  });

  // Set “required by” to tomorrow (if present)
  const requiredByInput = document.getElementById('requiredBy');
  if (requiredByInput) {
    const tomorrow = new Date(Date.now() + 86400000).toISOString().slice(0, 16);
    requiredByInput.value = tomorrow;
  }
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>