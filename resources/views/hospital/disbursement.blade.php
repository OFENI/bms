<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disbursement History | Hospital Dashboard</title>
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
        
        .badge-completed {
            background-color: rgba(39, 174, 96, 0.15);
            color: var(--success);
        }
        
        .badge-in-transit {
            background-color: rgba(52, 152, 219, 0.15);
            color: var(--secondary);
        }
        
        .badge-pending {
            background-color: rgba(243, 156, 18, 0.15);
            color: var(--warning);
        }
        
        .badge-cancelled {
            background-color: rgba(231, 76, 60, 0.15);
            color: var(--danger);
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
        
        /* Filter Bar */
        .filter-bar {
            background-color: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
        }
        
        /* Disbursement Details */
        .disbursement-detail-card {
            display: none;
            margin-bottom: 25px;
        }
        
        .detail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .detail-item {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
        }
        
        .detail-label {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 5px;
        }
        
        .detail-value {
            color: #555;
        }
        
        /* Blood Unit Badges */
        .blood-unit-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            margin-right: 8px;
            margin-bottom: 8px;
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        /* Timeline */
        .timeline {
            position: relative;
            padding-left: 30px;
            margin-top: 20px;
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            left: 10px;
            top: 5px;
            height: calc(100% - 10px);
            width: 2px;
            background-color: #e0e0e0;
        }
        
        .timeline-item {
            position: relative;
            margin-bottom: 20px;
            padding-left: 20px;
        }
        
        .timeline-item:last-child {
            margin-bottom: 0;
        }
        
        .timeline-marker {
            position: absolute;
            left: 0;
            top: 5px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: white;
            border: 3px solid var(--secondary);
            z-index: 2;
        }
        
        .timeline-content {
            padding: 10px 15px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
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

            .blood-unit-badge {
    padding: 6px 12px;
    margin: 4px;
    border-radius: 6px;
    display: inline-block;
    background: #f5f5f5;
    color: #333;
    font-weight: 600;
}
        }
        
        /* Print Styles */
        @media print {
            .sidebar, .header, .btn, .filter-bar {
                display: none !important;
            }
            
            .main-content {
                margin-left: 0 !important;
                padding: 10px !important;
            }
            
            .card {
                box-shadow: none !important;
                border: 1px solid #ddd !important;
            }
        }



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
                <li class="menu-item">
                  <a href="{{ route('hospital.inventory') }}" class="menu-link @if(request()->routeIs('hospital.inventory')) active @endif" style="display: flex; align-items: center; text-decoration: none; color: inherit;">
                    <i class="fas fa-tint" style="margin-right: 20px;"></i>
                    <span class="menu-text">Blood Inventory</span>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="{{ route('hospital.requests.index') }}" class="menu-link @if(request()->routeIs('hospital.requests.index')) active @endif" style="display: flex; align-items: center; text-decoration: none; color: inherit;">
    <i class="fas fa-hand-holding-medical" style="margin-right: 20px;"></i>
    <span class="menu-text">Blood Requests</span>
  </a>
</li>
                <li class="menu-item active">
                    <i class="fas fa-history"></i>
                    <span class="menu-text">Disbursement History</span>
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
        
        <!-- Main Content - Disbursement History -->
        <div class="main-content">
            <div class="dashboard-title">
                <h1><i class="fas fa-history me-3"></i>Disbursement History</h1>
                <div class="d-flex gap-2">
                <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#disbursementModal" id="addDisbursementBtn">
    <i class="fas fa-plus-circle me-2"></i>Add Disbursement
</button>
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown">
                            <i class="fas fa-download me-2"></i>Export
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-file-excel me-2"></i>Excel</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-file-pdf me-2"></i>PDF</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-file-csv me-2"></i>CSV</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Stats Overview -->
            <div class="stats-container">
            <div class="stat-card">
    <div class="stat-icon" style="background-color: rgba(52, 152, 219, 0.1); color: var(--secondary);">
        <i class="fas fa-truck"></i>
    </div>
    <div class="stat-value">{{ $totalDisbursements }}</div>
    <div class="stat-title">Total Disbursements</div>
</div>

<div class="stat-card">
    <div class="stat-icon" style="background-color: rgba(46, 204, 113, 0.1); color: var(--secondary);">
        <i class="fas fa-tint"></i>
    </div>
    <div class="stat-value">{{ $totalUnits }}</div>
    <div class="stat-title">Units Disbursed</div>
</div>

<div class="stat-card">
    <div class="stat-icon" style="background-color: rgba(155, 89, 182, 0.1); color: var(--secondary);">
        <i class="fas fa-syringe"></i>
    </div>
    <div class="stat-value">{{ $totalGroups }}</div>
    <div class="stat-title">Blood Groups Disbursed</div>
</div>

            </div>
            
            <!-- Filter Bar -->
            <div class="filter-bar">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Date Range</label>
                        <select class="form-select">
                            <option>Last 7 Days</option>
                            <option selected>Last 30 Days</option>
                            <option>Last 90 Days</option>
                            <option>Last Year</option>
                            <option>Custom Range</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select class="form-select">
                            <option>All Statuses</option>
                            <option selected>Completed</option>
                            <option>In Transit</option>
                            <option>Pending</option>
                            <option>Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Blood Type</label>
                        <select class="form-select">
                            <option>All Types</option>
                            <option>A+</option>
                            <option>A-</option>
                            <option>B+</option>
                            <option>B-</option>
                            <option>O+</option>
                            <option>O-</option>
                            <option>AB+</option>
                            <option>AB-</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button class="btn btn-primary w-100">
                            <i class="fas fa-filter me-2"></i>Apply Filters
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Disbursement Detail View -->
            <div id="disbursementDetail" class="card disbursement-detail-card" style="display: none;">
    <div class="card-header">
        <span><i class="fas fa-file-invoice me-2"></i>Disbursement Details: <span id="detailId"></span></span>
        <button class="btn btn-sm btn-outline-secondary" id="closeDetail"><i class="fas fa-times"></i></button>
    </div>
    <div class="card-body">
        <div class="detail-grid">
            <div class="detail-item">
                <div class="detail-label">Disbursement ID</div>
                <div class="detail-value" id="disb-id"></div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Requested By</div>
                <div class="detail-value" id="requested-by"></div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Request Date</div>
                <div class="detail-value" id="request-date"></div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Disbursement Date</div>
                <div class="detail-value" id="disburse-date"></div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Status</div>
                <div class="detail-value"><span class="badge bg-success" id="status-badge"></span></div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Handled By</div>
                <div class="detail-value" id="handled-by"></div>
            </div>
        </div>

        <div class="mt-4">
            <h5>Blood Units</h5>
            <div id="blood-unit-display"></div>
        </div>

        <div class="mt-4">
            <h5>Notes</h5>
            <p id="notes"></p>
        </div>
    </div>
</div>

            <!-- Add Disbursement Modal -->
<!-- Add Disbursement Modal -->
<div class="modal fade" id="addDisbursementModal" tabindex="-1" aria-labelledby="addDisbursementLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('disbursements.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="addDisbursementLabel">Add Disbursement</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="blood_request_id" class="form-label">Blood Request</label>
            <select class="form-select" name="blood_request_id" required>
              @foreach ($pendingRequests as $request)
                <option value="{{ $request->id }}">
                  {{ $request->requesterInstitution->name ?? 'Unknown' }} - {{ $request->bloodGroup->name ?? '' }} - {{ $request->quantity }} units
                </option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label for="quantity" class="form-label">Disburse Quantity</label>
            <input type="number" class="form-control" name="quantity" min="1" required>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Disbursement</button>
        </div>
      </form>
    </div>
  </div>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        const addBtn = document.getElementById('addDisbursementBtn');
        const modal = new bootstrap.Modal(document.getElementById('addDisbursementModal'));

        addBtn.addEventListener('click', function () {
            modal.show();
        });

        // Handle form submission to refresh dashboard inventory
        const disbursementForm = document.querySelector('#addDisbursementModal form');
        disbursementForm.addEventListener('submit', function(e) {
            // Add a hidden input to indicate this is a disbursement
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'refresh_dashboard';
            hiddenInput.value = 'true';
            this.appendChild(hiddenInput);
        });
    });
</script>

            <!-- Disbursement History Table -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-list me-2"></i>Blood Disbursement Records
                    </div>
                    <div class="d-flex gap-2">
                        <div class="input-group" style="width: 250px;">
                            <input type="text" class="form-control" placeholder="Search...">
                            <button class="btn btn-outline-secondary">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table class="table table-hover">
    <thead>
        <tr>
            <th>Date</th>
            <th>Blood Type</th>
            <th>Quantity</th>
            <th>Sent To</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($disbursements as $disbursement)
            <tr>
                <td>{{ $disbursement->created_at->format('M d, Y') }}</td>
                <td>{{ $disbursement->bloodGroup->name ?? 'N/A' }}</td>
                <td>{{ $disbursement->quantity }} units</td>
                <td>{{ $disbursement->receiverInstitution->name ?? 'N/A' }}</td>
                <td>
                    @php
                        switch (strtolower($disbursement->status)) {
                            case 'disbursed':
                            case 'completed':
                                $badgeClass = 'success';
                                break;
                            case 'pending':
                                $badgeClass = 'warning';
                                break;
                            case 'rejected':
                                $badgeClass = 'danger';
                                break;
                            default:
                                $badgeClass = 'secondary';
                                break;
                        }
                    @endphp
                    <span class="badge bg-{{ $badgeClass }}">
                        {{ ucfirst($disbursement->status) }}
                    </span>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">No disbursement records found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
                    </div>
                    
                    <!-- Pagination -->
                    <nav class="mt-4">
                        {{ $disbursements->links('pagination::bootstrap-5') }}
                    </nav>
                </div>
            </div>

            <script>
document.querySelectorAll('.view-detail').forEach(button => {
    button.addEventListener('click', () => {
        const id = button.dataset.id;

        fetch(`/hospital/disbursement/${id}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.json())
        .then(data => {
            // Optional: hide Disbursement ID at the top if not needed
            document.getElementById('detailId').textContent = ""; // ← clear top header if not needed

            // Fill visible info
            document.getElementById('disb-id').textContent = data.disbursement_id;
            document.getElementById('requested-by').textContent = data.requested_by;
            document.getElementById('request-date').textContent = data.request_date;
            document.getElementById('disburse-date').textContent = data.disbursement_date;
            document.getElementById('status-badge').textContent = data.status;
            document.getElementById('handled-by').textContent = data.handled_by;

            document.getElementById('blood-unit-display').innerHTML = `
                <span class="blood-unit-badge">${data.blood_units.type}: ${data.blood_units.quantity} units</span>
            `;

            document.getElementById('notes').textContent = data.notes;

            // Show the detail card
            document.getElementById('disbursementDetail').style.display = 'block';
        })
        .catch(error => {
            alert('Failed to load disbursement details: ' + error.message);
        });
    });
});

document.getElementById('closeDetail').addEventListener('click', () => {
    document.getElementById('disbursementDetail').style.display = 'none';
});

</script>


            
            <!-- Monthly Chart -->
   
    

    {{-- Include SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Flash-to-Toast --}}
<script>
  document.addEventListener('DOMContentLoaded', () => {
    @if(session('success'))
      Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: @json(session('success')),
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
      });
      
      // If this is a disbursement success, redirect to dashboard to refresh inventory
      @if(session('refresh_inventory'))
        setTimeout(() => {
          window.location.href = "{{ route('hospital.dashboard') }}";
        }, 2000);
      @endif
    @endif

    @if(session('error'))
      Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'error',
        title: @json(session('error')),
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
      });
    @endif
  });
</script>




    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Chart
            const ctx = document.getElementById('disbursementChart').getContext('2d');
            const disbursementChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
                    datasets: [{
                        label: 'Blood Units Disbursed',
                        data: [120, 135, 142, 156, 130, 145, 165, 152, 168, 74],
                        backgroundColor: 'rgba(52, 152, 219, 0.7)',
                        borderColor: 'rgba(52, 152, 219, 1)',
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
                                text: 'Units'
                            }
                        }
                    }
                }
            });
            
            // View Detail Functionality
            const viewDetailButtons = document.querySelectorAll('.view-detail');
            const detailCard = document.getElementById('disbursementDetail');
            const detailId = document.getElementById('detailId');
            const closeDetail = document.getElementById('closeDetail');
            
            viewDetailButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    detailId.textContent = id;
                    detailCard.style.display = 'block';
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            });
            
            closeDetail.addEventListener('click', function() {
                detailCard.style.display = 'none';
            });
            
            // Print Functionality
            const printBtn = document.getElementById('printBtn');
            printBtn.addEventListener('click', function() {
                window.print();
            });
            
            // Mobile Menu Toggle
            const menuToggle = document.getElementById('menuToggle');
            const sidebar = document.getElementById('sidebar');
            
            menuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('open');
            });
            
            // Simulate data filtering
            const filterBtn = document.querySelector('.filter-bar .btn');
            filterBtn.addEventListener('click', function() {
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Filtering...';
                
                setTimeout(() => {
                    this.innerHTML = '<i class="fas fa-filter me-2"></i>Apply Filters';
                    alert('Filters applied successfully');
                }, 1500);
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
    <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap JS (required for modal) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 CSS & JS from CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>