<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Blood Management Dashboard</title>
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
            .menu-item .menu-link {
                 display: flex;              /* so the icon + text align nicely */
                 align-items: center;
                 text-decoration: none;      /* removes the underline */
                 color: inherit;             /* inherit from .menu-item (or body) */
                  padding: 0.5rem 1rem;       /* adjust spacing as needed */
}

            .menu-item .menu-link:hover {
                  background-color: rgba(255,255,255,0.1); /* subtle hover effect */
}

        }
        
        .blood-card:hover {
            transform: translateY(-4px) scale(1.03);
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }

        blood-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
    }
    .blood-card {
        background: white;
        padding: 15px;
        border-radius: 12px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        width: 100px;
        text-align: center;
    }
    .blood-type {
        font-weight: bold;
        font-size: 18px;
    }
    .blood-status {
        margin-top: 5px;
        font-size: 14px;
    }
    .blood-group-tile {
        transition: transform 0.2s, box-shadow 0.2s;
        cursor: pointer;
    }
    .blood-group-tile:hover {
        transform: translateY(-3px) scale(1.04);
        box-shadow: 0 6px 18px rgba(231,76,60,0.08);
    }
    .card-header-custom {
        background: linear-gradient(90deg, #e74c3c 60%, #fff0 100%);
        color: #fff;
        border-top-left-radius: 18px !important;
        border-top-right-radius: 18px !important;
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
                  <a href="{{  route('hospital.blood_inventory')  }}" class="menu-link @if(request()->routeIs('hospital.inventory')) active @endif" style="display: flex; align-items: center; text-decoration: none; color: inherit;">
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
<li class="menu-item">
  <a href="{{ route('hospital.disbursement_history') }}" class="menu-link @if(request()->routeIs('hospital.disbursement_history')) active @endif" style="display: flex; align-items: center; text-decoration: none; color: inherit;">
    <i class="fas fa-history" style="margin-right: 20px;"></i>
    <span class="menu-text">Disbursement History</span>
  </a>
</li>

                <!-- <li class="menu-item">
                    <i class="fas fa-user-friends"></i>
                    <span class="menu-text">Donors</span>
                </li>-->
                <li class="menu-item">
                  <a href="{{ route('hospital.reports') }}" class="menu-link @if(request()->routeIs('hospital.reports')) active @endif" style="display: flex; align-items: center; text-decoration: none; color: inherit;">
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
        
        <!-- Main Content -->
        <div class="main-content">
            <div class="dashboard-title">
                <h1>Blood Management Dashboard</h1>
                <button class="btn btn-primary" id="newRequestBtn">
                    <i class="fas fa-plus-circle me-2"></i>New Blood Request
                </button>
            </div>
            
            <!-- Stats Overview -->
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-icon" style="background-color: rgba(52, 152, 219, 0.1); color: var(--secondary);">
                        <i class="fas fa-tint"></i>
                    </div>
                    <div class="stat-value">{{ $totalBloodUnits }}</div>
                    <div class="stat-title">Total Blood Units Available</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon" style="background-color: rgba(243, 156, 18, 0.1); color: var(--warning);">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-value">{{ $pendingRequests }}</div>
                    <div class="stat-title">Pending Requests</div>
                </div>
                
                <div class="stat-card">
                   <div class="stat-icon" style="background-color: rgba(39, 174, 96, 0.1); color: var(--success);">
                        <i class="fas fa-check-circle"></i>
                   </div>
                  <div class="stat-value">{{ $fulfilledRequests }}</div>
                  <div class="stat-title">Fulfilled Requests</div>
                </div>

                

            </div>
            
            <!-- Blood Request Form -->
            <div class="card mb-4" id="requestForm" style="display: none;">
                <div class="card-header">
                    <i class="fas fa-file-medical me-2"></i>New Blood Request Form
                </div>
                <div class="card-body">
                    <form>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Blood Type</label>
                                <select class="form-select">
                                    <option>Select Blood Type</option>
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
                            <div class="col-md-6">
                                <label class="form-label">Quantity (Units)</label>
                                <input type="number" class="form-control" min="1" value="5">
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Urgency Level</label>
                                <select class="form-select">
                                    <option>Normal</option>
                                    <option>High</option>
                                    <option selected>Critical (Urgent)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Required By</label>
                                <input type="date" class="form-control">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Purpose/Notes</label>
                            <textarea class="form-control" rows="3" placeholder="Enter reason for request"></textarea>
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-outline-secondary" id="cancelRequestBtn">Cancel</button>
                            <button type="button" class="btn btn-primary">Submit Request</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="row">
                <!-- Pending Requests -->
                





<!-- The panel itself: -->
<div class="notification-panel" id="notificationPanel">
    <div class="notification-header">
        <h5>Notifications ({{ $incomingCount }})</h5>
        <button class="btn btn-sm btn-outline-secondary" id="closeNotificationPanel">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="notification-list">
        @forelse($incomingRequests as $req)
            <div class="notification-item unread">
                <div class="notification-title">
                    New Blood Request from {{ $req->requesterInstitution->name }}
                </div>
                <div class="notification-desc">
                    {{ $req->quantity }} units of {{ $req->bloodGroup->name }}
                </div>
                <div class="notification-time">
                    {{ $req->created_at->diffForHumans() }}
                </div>
            </div>
        @empty
            <div class="notification-item">
                <div class="notification-desc">No new incoming requests.</div>
            </div>
        @endforelse
    </div>
</div>

                    <!-- Disbursement History -->

                    @php
function getStatus($units) {
    if ($units >= 100) {
        return ['Safe', 'safe', 100];
    } elseif ($units >= 50) {
        return ['Warning', 'warning', 60];
    } elseif ($units > 0) {
        return ['Low', 'low', 30];
    } else {
        return ['Empty', 'empty', 0];
    }
}
@endphp

<div class="container my-4">
    <h4 class="mb-4 text-danger fw-bold d-flex align-items-center">
        <i class="fas fa-hospital me-2"></i>
        Available Blood Stock in Other Hospitals
        <button class="btn btn-sm btn-outline-primary ms-3" onclick="fetchOtherHospitalsInventory()" id="refreshBtn" title="Refresh Inventory">
            <i class="fas fa-sync-alt" id="refreshIcon"></i> Refresh
        </button>
        <small class="text-muted ms-2" id="lastUpdated"></small>
    </h4>

    <div id="other-hospitals-inventory">
        <div class="row g-4">
            @foreach ($inventoryData as $data)
                <div class="col-12">
                    <div class="card inventory-card shadow-sm border-0 w-100" style="border-radius: 18px;">
                        <div class="card-header-custom d-flex justify-content-between align-items-center text-white px-4 py-3"
                             style="background: linear-gradient(90deg, #e74c3c 60%, #fff0 100%); border-radius: 18px 18px 0 0;">
                            <h6 class="mb-0 fw-bold" style="font-size: 1.1rem;">
                                <i class="fas fa-hospital-alt me-2"></i>{{ $data['institution']->name }}
                            </h6>
                        </div>
                        <div class="card-body px-4 py-3">
                            <div class="d-flex flex-wrap justify-content-start gap-3">
                                @foreach ($bloodTypes as $type)
                                    @php
                                        // how many units this hospital has of $type
                                        $units = $data['inventory'][$type] ?? 0;

                                        // bucket thresholds
                                        if      ($units <= 20) { 
                                            $label   = 'Low';
                                            $class   = 'danger'; 
                                            // % of the 0–20 range
                                            $percent = $units > 0
                                                       ? intval(min(100, ($units / 20) * 100))
                                                       : 0;
                                        }
                                        elseif  ($units <= 50) {
                                            $label   = 'Warning';
                                            $class   = 'warning';
                                            // scale 21–50 into 0–100
                                            $percent = intval(min(100, (($units - 20) / 30) * 100));
                                        }
                                        else {
                                            $label   = 'Safe';
                                            $class   = 'success';
                                            $percent = 100;
                                        }

                                        // tile background by class
                                        $bg = match($class) {
                                            'success' => 'rgba(39, 174, 96, 0.12)',
                                            'warning' => 'rgba(243, 156, 18, 0.12)',
                                            'danger'  => 'rgba(231, 76, 60, 0.12)',
                                            default   => '#f8f9fa',
                                        };
                                    @endphp

                                    <div class="blood-group-tile p-3 text-center"
                                         style="width:100px; background:{{ $bg }}; border-radius:12px; box-shadow:0 1px 6px rgba(0,0,0,0.05);">

                                        <span class="blood-group-label mb-1 d-block" style="font-size:1rem; font-weight:600;">
                                            <i class="fas fa-tint me-1 text-{{ $class }}"></i>{{ $type }}
                                        </span>

                                        <span class="blood-units fw-semibold d-block" style="font-size:0.95rem;">
                                            {{ $units }} units
                                        </span>

                                        <div class="progress mt-2" style="height:5px; background-color:#eee; border-radius:4px;">
                                            <div class="progress-bar bg-{{ $class }}" style="width:{{ $percent }}%; border-radius:4px;"></div>
                                        </div>

                                        <span class="badge bg-{{ $class }} mt-2" style="font-size:0.8rem;">
                                            {{ $label }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>






                </div>
                
              
                    
                    <!-- Critical Levels -->
                    <div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-exclamation-triangle me-2"></i>Critical Levels
    </div>
    <div class="card-body">

        {{-- Show critical alerts --}}
        @foreach ($criticalLevels['critical'] as $group)
            <div class="alert alert-danger d-flex align-items-center">
                <i class="fas fa-exclamation-circle fa-2x me-3"></i>
                <div>
                    <strong>{{ $group->blood_type }} blood is critically low</strong>
                    <div>Only {{ $group->total }} units available</div>
                </div>
            </div>
        @endforeach

        {{-- Show warning alerts --}}
        @foreach ($criticalLevels['warning'] as $group)
            <div class="alert alert-warning d-flex align-items-center">
                <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                <div>
                    <strong>{{ $group->blood_type }} blood is below optimal</strong>
                    <div>Only {{ $group->total }} units available</div>
                </div>
            </div>
        @endforeach

        {{-- Optional: no issues --}}
        @if (empty($criticalLevels['critical']) && empty($criticalLevels['warning']))
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i> All blood groups are at safe levels.
            </div>
        @endif

    </div>
</div>

                </div>
            </div>
        </div>
    </div>
    
    <!-- Notification Panel -->
    <div class="notification-panel" id="notificationPanel">
        <div class="notification-header">
            <h5>Notifications (3)</h5>
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
        // Expose bloodTypes to JS
        const bloodTypes = @json($bloodTypes);
        // Initialize Chart
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('inventoryChart').getContext('2d');
            const inventoryChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['A+ (25%)', 'O+ (22%)', 'B+ (14%)', 'AB+ (7%)', 'A- (10%)', 'O- (4%)', 'B- (9%)', 'AB- (9%)'],
                    datasets: [{
                        data: [25, 22, 14, 7, 10, 4, 9, 9],
                        backgroundColor: [
                            '#e74c3c', '#3498db', '#2ecc71', '#9b59b6',
                            '#e67e22', '#1abc9c', '#f1c40f', '#95a5a6'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                        }
                    }
                }
            });
            
            // Toggle Notification Panel
            const notificationToggle = document.getElementById('notificationToggle');
            const notificationPanel = document.getElementById('notificationPanel');
            const closeNotificationPanel = document.getElementById('closeNotificationPanel');
            
            notificationToggle.addEventListener('click', function() {
                notificationPanel.classList.toggle('open');
            });
            
            closeNotificationPanel.addEventListener('click', function() {
                notificationPanel.classList.remove('open');
            });
            
            // Toggle Request Form
            const newRequestBtn = document.getElementById('newRequestBtn');
            const requestForm = document.getElementById('requestForm');
            const cancelRequestBtn = document.getElementById('cancelRequestBtn');
            
            newRequestBtn.addEventListener('click', function() {
                requestForm.style.display = 'block';
                newRequestBtn.style.display = 'none';
            });
            
            cancelRequestBtn.addEventListener('click', function() {
                requestForm.style.display = 'none';
                newRequestBtn.style.display = 'block';
            });
            
            // Mobile Menu Toggle
            const menuToggle = document.getElementById('menuToggle');
            const sidebar = document.getElementById('sidebar');
            
            menuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('open');
            });
            
            // Mark notifications as read
            const notificationItems = document.querySelectorAll('.notification-item');
            notificationItems.forEach(item => {
                item.addEventListener('click', function() {
                    this.classList.remove('unread');
                });
            });
        });

        // Expose bloodTypes to JS
        const bloodTypes = @json($bloodTypes);

        // Request notification permission
        if ('Notification' in window) {
            Notification.requestPermission();
        }

        // Function to render the inventory section
        function renderOtherHospitalsInventory(data) {
            let html = '<div class="row g-4">';
            data.forEach(hospital => {
                html += `<div class="col-12">
                    <div class="card inventory-card shadow-sm border-0 w-100" style="border-radius: 18px;">
                        <div class="card-header-custom d-flex justify-content-between align-items-center text-white px-4 py-3"
                             style="background: linear-gradient(90deg, #e74c3c 60%, #fff0 100%); border-radius: 18px 18px 0 0;">
                            <h6 class="mb-0 fw-bold" style="font-size: 1.1rem;">
                                <i class=\"fas fa-hospital-alt me-2\"></i>${hospital.institution.name}
                            </h6>
                        </div>
                        <div class="card-body px-4 py-3">
                            <div class="d-flex flex-wrap justify-content-start gap-3">`;
                bloodTypes.forEach(type => {
                    const units = hospital.inventory[type] ? parseInt(hospital.inventory[type]) : 0;
                    let label, className, percent;
                    if (units <= 20) {
                        label = 'Low';
                        className = 'danger';
                        percent = units > 0 ? Math.min(100, (units / 20) * 100) : 0;
                    } else if (units <= 50) {
                        label = 'Warning';
                        className = 'warning';
                        percent = Math.min(100, ((units - 20) / 30) * 100);
                    } else {
                        label = 'Safe';
                        className = 'success';
                        percent = 100;
                    }
                    const bg = {
                        'success': 'rgba(39, 174, 96, 0.12)',
                        'warning': 'rgba(243, 156, 18, 0.12)',
                        'danger':  'rgba(231, 76, 60, 0.12)'
                    }[className] || '#f8f9fa';
                    html += `<div class=\"blood-group-tile p-3 text-center\" style=\"width:100px; background:${bg}; border-radius:12px; box-shadow:0 1px 6px rgba(0,0,0,0.05);\">
                        <span class=\"blood-group-label mb-1 d-block\" style=\"font-size:1rem; font-weight:600;\">
                            <i class=\"fas fa-tint me-1 text-${className}\"></i>${type}
                        </span>
                        <span class=\"blood-units fw-semibold d-block\" style=\"font-size:0.95rem;\">
                            ${units} units
                        </span>
                        <div class=\"progress mt-2\" style=\"height:5px; background-color:#eee; border-radius:4px;\">
                            <div class=\"progress-bar bg-${className}\" style=\"width:${percent}%; border-radius:4px;\"></div>
                        </div>
                        <span class=\"badge bg-${className} mt-2\" style=\"font-size:0.8rem;\">
                            ${label}
                        </span>
                    </div>`;
                });
                html += `</div></div></div></div>`;
            });
            html += '</div>';
            document.getElementById('other-hospitals-inventory').innerHTML = html;
        }

        // Function to fetch and update inventory
        function fetchOtherHospitalsInventory() {
            // Show loading state
            const container = document.getElementById('other-hospitals-inventory');
            const refreshBtn = document.getElementById('refreshBtn');
            const refreshIcon = document.getElementById('refreshIcon');
            const lastUpdated = document.getElementById('lastUpdated');

            refreshBtn.disabled = true;
            refreshIcon.classList.add('fa-spin');
            lastUpdated.textContent = 'Updating...';

            console.log('Fetching inventory data...');
            fetch("{{ route('hospital.other_inventory_data') }}")
                .then(response => {
                    console.log('Response status:', response.status);
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Received data:', data);
                    renderOtherHospitalsInventory(data);
                    lastUpdated.textContent = `Last updated: ${new Date().toLocaleTimeString()}`;
                })
                .catch(error => {
                    console.error('Error fetching inventory:', error);
                    container.innerHTML = '<div class="alert alert-danger">Error loading inventory. <button class="btn btn-sm btn-outline-primary ms-2" onclick="fetchOtherHospitalsInventory()">Retry</button></div>';
                    lastUpdated.textContent = 'Failed to update';
                })
                .finally(() => {
                    refreshBtn.disabled = false;
                    refreshIcon.classList.remove('fa-spin');
                });
        }

        // Auto-refresh inventory if coming from disbursement
        @if(session('refresh_inventory'))
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(() => {
                    fetchOtherHospitalsInventory();
                }, 1000); // Small delay to ensure page is loaded
            });
        @endif

        // Periodic refresh every 30 seconds
        setInterval(function() {
            fetchOtherHospitalsInventory();
        }, 30000); // 30 seconds

        // Smart polling - check for changes first, then refresh if needed
        function smartPolling() {
            fetch("{{ route('hospital.check_inventory_changes') }}")
                .then(response => response.json())
                .then(data => {
                    if (data.has_changes) {
                        console.log('Inventory changes detected, refreshing...');
                        
                        // Show notification
                        if (Notification.permission === 'granted') {
                            new Notification('Blood Inventory Updated', {
                                body: 'Other hospitals\' inventory has been updated.',
                                icon: '/favicon.ico'
                            });
                        }
                        
                        // Visual indicator
                        const refreshBtn = document.getElementById('refreshBtn');
                        refreshBtn.classList.add('btn-warning');
                        setTimeout(() => {
                            refreshBtn.classList.remove('btn-warning');
                        }, 3000);
                        
                        fetchOtherHospitalsInventory();
                    }
                })
                .catch(error => {
                    console.error('Error checking for changes:', error);
                });
        }

        // Smart polling every 10 seconds
        setInterval(smartPolling, 10000); // 10 seconds

        // Refresh on page focus (when user returns to tab)
        document.addEventListener('visibilitychange', function() {
            if (!document.hidden) {
                fetchOtherHospitalsInventory();
            }
        });
    </script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    fetch("{{ route('hospital.notifications') }}")
        .then(res => res.json())
        .then(data => {
            const badge = document.getElementById("notification-badge");
            const count = data.count;

            if (count > 0) {
                badge.textContent = count;
                badge.style.display = "inline-block";
            } else {
                badge.style.display = "none"; // hide when 0
            }
        })
        .catch(error => {
            console.error("Notification fetch failed:", error);
            document.getElementById("notification-badge").textContent = "!";
        });
});
</script>

</body>
</html>