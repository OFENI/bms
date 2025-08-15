<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Settings | Blood Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        
        /* Settings Specific Styles */
        .settings-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .settings-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
            overflow: hidden;
        }
        
        .settings-header {
            background: linear-gradient(135deg, var(--primary), #1a2530);
            color: white;
            padding: 20px 25px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .settings-header i {
            font-size: 1.5rem;
        }
        
        .settings-header h3 {
            margin: 0;
            font-weight: 600;
        }
        
        .settings-body {
            padding: 25px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .form-control, .form-select {
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            transition: all 0.2s;
            font-size: 0.95rem;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--secondary);
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }
        
        .form-text {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 5px;
        }
        
        /* Toggle Switch */
        .form-check-input {
            width: 3rem;
            height: 1.5rem;
            margin-top: 0;
        }
        
        .form-check-input:checked {
            background-color: var(--success);
            border-color: var(--success);
        }
        
        /* Blood Threshold Cards */
        .threshold-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }
        
        .threshold-card {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
        }
        
        .threshold-card .blood-type {
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 10px;
            color: var(--primary);
        }
        
        .threshold-card .threshold-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--accent);
        }
        
        /* Security Section */
        .security-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }
        
        .security-item:last-child {
            border-bottom: none;
        }
        
        .security-info {
            flex: 1;
        }
        
        .security-title {
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .security-desc {
            font-size: 0.9rem;
            color: #6c757d;
        }
        
        /* Session History */
        .session-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #eee;
        }
        
        .session-info {
            flex: 1;
        }
        
        .session-device {
            font-weight: 600;
            margin-bottom: 3px;
        }
        
        .session-details {
            font-size: 0.85rem;
            color: #6c757d;
        }
        
        .session-status {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .status-active {
            background-color: rgba(39, 174, 96, 0.15);
            color: var(--success);
        }
        
        .status-inactive {
            background-color: rgba(108, 117, 125, 0.15);
            color: #6c757d;
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
        
        .btn-outline-secondary {
            border-color: #6c757d;
            color: #6c757d;
        }
        
        .btn-outline-secondary:hover {
            background-color: #6c757d;
            border-color: #6c757d;
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
            .settings-container {
                padding: 0 15px;
            }
            
            .threshold-grid {
                grid-template-columns: 1fr 1fr;
            }
            
            .security-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }
        
        @media (max-width: 576px) {
            .threshold-grid {
                grid-template-columns: 1fr;
            }
        }
        
        /* Menu Link Styles */
        .menu-item .menu-link {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: inherit;
            padding: 0.5rem 1rem;
        }
        
        .menu-item .menu-link:hover {
            background-color: rgba(255,255,255,0.1);
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
                    <a href="{{ route('hospital.dashboard') }}" class="menu-link" style="display: flex; align-items: center; text-decoration: none; color: inherit;">
                        <i class="fas fa-tachometer-alt" style="margin-right: 20px;"></i>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('hospital.blood_inventory') }}" class="menu-link" style="display: flex; align-items: center; text-decoration: none; color: inherit;">
                        <i class="fas fa-tint" style="margin-right: 20px;"></i>
                        <span class="menu-text">Blood Inventory</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('hospital.requests.index') }}" class="menu-link" style="display: flex; align-items: center; text-decoration: none; color: inherit;">
                        <i class="fas fa-hand-holding-medical" style="margin-right: 20px;"></i>
                        <span class="menu-text">Blood Requests</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('hospital.disbursement_history') }}" class="menu-link" style="display: flex; align-items: center; text-decoration: none; color: inherit;">
                        <i class="fas fa-history" style="margin-right: 20px;"></i>
                        <span class="menu-text">Disbursement History</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('hospital.reports') }}" class="menu-link" style="display: flex; align-items: center; text-decoration: none; color: inherit;">
                        <i class="fas fa-chart-line" style="margin-right: 20px;"></i>
                        <span class="menu-text">Reports</span>
                    </a>
                </li>
                <li class="menu-item active">
                    <a href="{{ route('hospital.settings') }}" class="menu-link" style="display: flex; align-items: center; text-decoration: none; color: inherit;">
                        <i class="fas fa-cog" style="margin-right: 20px;"></i>
                        <span class="menu-text">Settings</span>
                    </a>
                </li>
            </ul>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>Please fix the following errors:
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            <div class="dashboard-title">
                <h1><i class="fas fa-cog me-3"></i>Hospital Settings</h1>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary" onclick="exportSettings()">
                        <i class="fas fa-download me-2"></i>Export Settings
                    </button>
                </div>
            </div>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <div class="settings-container">
                <!-- Institution Information -->
                <div class="settings-section">
                    <div class="settings-header">
                        <i class="fas fa-hospital"></i>
                        <h3>🏥 Institution/Hospital Information</h3>
                    </div>
                    <div class="settings-body">
                        <form id="institutionForm" method="POST" action="{{ route('hospital.settings.institution') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-hospital-alt"></i>
                                            Hospital/Institution Name
                                        </label>
                                        <input type="text" class="form-control" name="name" value="{{ Auth::user()->institution->name ?? 'General Hospital' }}" placeholder="Enter hospital name" required>
                                        <div class="form-text">Official name of your healthcare institution</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-envelope"></i>
                                            Email Address
                                        </label>
                                        <input type="email" class="form-control" name="email" value="{{ Auth::user()->institution->email ?? 'hospital@example.com' }}" placeholder="Enter email address" required>
                                        <div class="form-text">Primary contact email for blood bank operations</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-phone"></i>
                                            Contact Number
                                        </label>
                                        <input type="tel" class="form-control" name="contact_number" value="{{ $institution->contact_number ?? '+255 123 456 789' }}" placeholder="Enter contact number" required>
                                        <div class="form-text">Primary phone number for emergency contacts</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-globe"></i>
                                            Country
                                        </label>
                                        <input type="text" class="form-control" name="country" value="{{ $institution->country ?? 'Tanzania' }}" readonly>
                                        <div class="form-text">Country is set to Tanzania by default</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-map-marker-alt"></i>
                                            Region/State
                                        </label>
                                        <select class="form-select" name="region" required>
                                            <option value="">Select Region</option>
                                            <option {{ $institution->region == 'Dar es Salaam' ? 'selected' : '' }}>Dar es Salaam</option>
                                            <option {{ $institution->region == 'Arusha' ? 'selected' : '' }}>Arusha</option>
                                            <option {{ $institution->region == 'Mwanza' ? 'selected' : '' }}>Mwanza</option>
                                            <option {{ $institution->region == 'Dodoma' ? 'selected' : '' }}>Dodoma</option>
                                            <option {{ $institution->region == 'Mbeya' ? 'selected' : '' }}>Mbeya</option>
                                            <option {{ $institution->region == 'Tanga' ? 'selected' : '' }}>Tanga</option>
                                            <option {{ $institution->region == 'Morogoro' ? 'selected' : '' }}>Morogoro</option>
                                            <option {{ $institution->region == 'Kigoma' ? 'selected' : '' }}>Kigoma</option>
                                            <option {{ $institution->region == 'Mara' ? 'selected' : '' }}>Mara</option>
                                            <option {{ $institution->region == 'Kagera' ? 'selected' : '' }}>Kagera</option>
                                            <option {{ $institution->region == 'Kilimanjaro' ? 'selected' : '' }}>Kilimanjaro</option>
                                            <option {{ $institution->region == 'Tabora' ? 'selected' : '' }}>Tabora</option>
                                            <option {{ $institution->region == 'Ruvuma' ? 'selected' : '' }}>Ruvuma</option>
                                            <option {{ $institution->region == 'Iringa' ? 'selected' : '' }}>Iringa</option>
                                            <option {{ $institution->region == 'Singida' ? 'selected' : '' }}>Singida</option>
                                            <option {{ $institution->region == 'Manyara' ? 'selected' : '' }}>Manyara</option>
                                            <option {{ $institution->region == 'Rukwa' ? 'selected' : '' }}>Rukwa</option>
                                            <option {{ $institution->region == 'Shinyanga' ? 'selected' : '' }}>Shinyanga</option>
                                            <option {{ $institution->region == 'Lindi' ? 'selected' : '' }}>Lindi</option>
                                            <option {{ $institution->region == 'Mtwara' ? 'selected' : '' }}>Mtwara</option>
                                            <option {{ $institution->region == 'Pwani' ? 'selected' : '' }}>Pwani</option>
                                            <option {{ $institution->region == 'Kaskazini Pemba' ? 'selected' : '' }}>Kaskazini Pemba</option>
                                            <option {{ $institution->region == 'Kusini Pemba' ? 'selected' : '' }}>Kusini Pemba</option>
                                            <option {{ $institution->region == 'Kaskazini Unguja' ? 'selected' : '' }}>Kaskazini Unguja</option>
                                            <option {{ $institution->region == 'Kusini Unguja' ? 'selected' : '' }}>Kusini Unguja</option>
                                            <option {{ $institution->region == 'Mjini Magharibi' ? 'selected' : '' }}>Mjini Magharibi</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-map"></i>
                                    Complete Address
                                </label>
                                <textarea class="form-control" name="address" rows="3" placeholder="Enter complete hospital address" required>{{ $institution->address ?? '123 Medical Center Drive, Dar es Salaam, Tanzania' }}</textarea>
                                <div class="form-text">Full address for blood bank location and deliveries</div>
                            </div>
                            
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Update Institution Information
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Blood Bank Operations -->
                <div class="settings-section">
                    <div class="settings-header">
                        <i class="fas fa-tint"></i>
                        <h3>🩸 Blood Bank Operations</h3>
                    </div>
                    <div class="settings-body">
                        <form id="bloodBankForm" method="POST" action="{{ route('hospital.settings.blood-bank') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-clock"></i>
                                            Operating Hours
                                        </label>
                                        <div class="row">
                                            <div class="col-6">
                                                <input type="time" class="form-control" name="opening_time" value="{{ $institution->opening_time ?? '08:00' }}" required>
                                                <div class="form-text text-center">Open</div>
                                            </div>
                                            <div class="col-6">
                                                <input type="time" class="form-control" name="closing_time" value="{{ $institution->closing_time ?? '18:00' }}" required>
                                                <div class="form-text text-center">Close</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-calendar"></i>
                                            Operating Days
                                        </label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="operating_days[]" value="Monday - Friday" {{ in_array('Monday - Friday', $institution->operating_days ?? []) ? 'checked' : '' }}>
                                            <label class="form-check-label">Monday - Friday</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="operating_days[]" value="Saturday" {{ in_array('Saturday', $institution->operating_days ?? []) ? 'checked' : '' }}>
                                            <label class="form-check-label">Saturday</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="operating_days[]" value="Sunday (Emergency Only)" {{ in_array('Sunday (Emergency Only)', $institution->operating_days ?? []) ? 'checked' : '' }}>
                                            <label class="form-check-label">Sunday (Emergency Only)</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-exchange-alt"></i>
                                    Auto Accept Transfers
                                </label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="auto_accept_transfers" id="autoAcceptTransfers" value="1" {{ $institution->auto_accept_transfers ? 'checked' : '' }}>
                                    <label class="form-check-label" for="autoAcceptTransfers">
                                        Automatically accept blood transfer requests from other hospitals
                                    </label>
                                </div>
                                <div class="form-text">When enabled, incoming blood requests will be automatically approved if inventory is sufficient</div>
                            </div>
                            
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Update Blood Bank Settings
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Blood Unit Thresholds -->
                <div class="settings-section">
                    <div class="settings-header">
                        <i class="fas fa-exclamation-triangle"></i>
                        <h3>⚠️ Blood Unit Thresholds</h3>
                    </div>
                    <div class="settings-body">
                        <form id="thresholdsForm" method="POST" action="{{ route('hospital.settings.thresholds') }}">
                            @csrf
                            <p class="text-muted mb-3">Set minimum unit thresholds for each blood type. Alerts will be triggered when inventory falls below these levels.</p>
                            
                            <div class="threshold-grid">
                            <div class="threshold-card">
                                <div class="blood-type">A+</div>
                                <input type="number" class="form-control text-center" name="thresholds[A+]" value="{{ $currentThresholds['A+'] ?? 10 }}" min="0" max="100" required>
                                <div class="form-text">units</div>
                            </div>
                            <div class="threshold-card">
                                <div class="blood-type">A-</div>
                                <input type="number" class="form-control text-center" name="thresholds[A-]" value="{{ $currentThresholds['A-'] ?? 5 }}" min="0" max="100" required>
                                <div class="form-text">units</div>
                            </div>
                            <div class="threshold-card">
                                <div class="blood-type">B+</div>
                                <input type="number" class="form-control text-center" name="thresholds[B+]" value="{{ $currentThresholds['B+'] ?? 8 }}" min="0" max="100" required>
                                <div class="form-text">units</div>
                            </div>
                            <div class="threshold-card">
                                <div class="blood-type">B-</div>
                                <input type="number" class="form-control text-center" name="thresholds[B-]" value="{{ $currentThresholds['B-'] ?? 3 }}" min="0" max="100" required>
                                <div class="form-text">units</div>
                            </div>
                            <div class="threshold-card">
                                <div class="blood-type">O+</div>
                                <input type="number" class="form-control text-center" name="thresholds[O+]" value="{{ $currentThresholds['O+'] ?? 15 }}" min="0" max="100" required>
                                <div class="form-text">units</div>
                            </div>
                            <div class="threshold-card">
                                <div class="blood-type">O-</div>
                                <input type="number" class="form-control text-center" name="thresholds[O-]" value="{{ $currentThresholds['O-'] ?? 5 }}" min="0" max="100" required>
                                <div class="form-text">units</div>
                            </div>
                            <div class="threshold-card">
                                <div class="blood-type">AB+</div>
                                <input type="number" class="form-control text-center" name="thresholds[AB+]" value="{{ $currentThresholds['AB+'] ?? 3 }}" min="0" max="100" required>
                                <div class="form-text">units</div>
                            </div>
                            <div class="threshold-card">
                                <div class="blood-type">AB-</div>
                                <input type="number" class="form-control text-center" name="thresholds[AB-]" value="{{ $currentThresholds['AB-'] ?? 2 }}" min="0" max="100" required>
                                <div class="form-text">units</div>
                            </div>
                        </div>
                        
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Blood Thresholds
                            </button>
                        </div>
                        </form>
                    </div>
                </div>

                <!-- Security & Access -->
                <div class="settings-section">
                    <div class="settings-header">
                        <i class="fas fa-shield-alt"></i>
                        <h3>🔒 Security & Access</h3>
                    </div>
                    <div class="settings-body">
                        <!-- Change Password -->
                        <div class="security-item">
                            <div class="security-info">
                                <div class="security-title">Change Password</div>
                                <div class="security-desc">Update your account password for enhanced security</div>
                            </div>
                            <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#passwordModal">
                                <i class="fas fa-key me-2"></i>Change
                            </button>
                        </div>
                        
                        <!-- Two-Factor Authentication -->
                        <div class="security-item">
                            <div class="security-info">
                                <div class="security-title">Two-Factor Authentication (2FA)</div>
                                <div class="security-desc">Add an extra layer of security to your account</div>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="twoFactorAuth">
                                <label class="form-check-label" for="twoFactorAuth"></label>
                            </div>
                        </div>
                        
                        <!-- Active Sessions -->
                        <div class="security-item">
                            <div class="security-info">
                                <div class="security-title">Active Sessions</div>
                                <div class="security-desc">View and manage your current login sessions</div>
                            </div>
                            <button class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-desktop me-2"></i>View Sessions
                            </button>
                        </div>
                        
                        <!-- Login History -->
                        <div class="security-item">
                            <div class="security-info">
                                <div class="security-title">Login History</div>
                                <div class="security-desc">Review your recent login activities and locations</div>
                            </div>
                            <button class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-history me-2"></i>View History
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Role & Permissions -->
                <div class="settings-section">
                    <div class="settings-header">
                        <i class="fas fa-user-shield"></i>
                        <h3>👤 Role & Permissions</h3>
                    </div>
                    <div class="settings-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-user-tag"></i>
                                        Current Role
                                    </label>
                                    <input type="text" class="form-control" value="{{ ucfirst(Auth::user()->role) }}" readonly>
                                    <div class="form-text">Your current role in the system</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-calendar-alt"></i>
                                        Account Created
                                    </label>
                                    <input type="text" class="form-control" value="{{ Auth::user()->created_on ? Auth::user()->created_on->format('F j, Y') : 'N/A' }}" readonly>
                                    <div class="form-text">Date when your account was created</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-list-check"></i>
                                Permissions
                            </label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" {{ in_array(Auth::user()->role, ['admin', 'doctor', 'nurse', 'staff']) ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">View Blood Inventory</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" {{ in_array(Auth::user()->role, ['admin', 'doctor', 'nurse', 'staff']) ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Create Blood Requests</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" {{ in_array(Auth::user()->role, ['admin', 'doctor', 'nurse', 'staff']) ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">View Disbursement History</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" {{ Auth::user()->role === 'admin' ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Manage Users</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" {{ in_array(Auth::user()->role, ['admin', 'doctor']) ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">System Settings</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" {{ Auth::user()->role === 'admin' ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Admin Access</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-text">Contact your system administrator to modify permissions</div>
                        </div>
                    </div>
                </div>

                <!-- Session History -->
                <div class="settings-section">
                    <div class="settings-header">
                        <i class="fas fa-desktop"></i>
                        <h3>💻 Recent Login Sessions</h3>
                    </div>
                    <div class="settings-body">
                        @foreach($activeSessions as $session)
                        <div class="session-item">
                            <div class="session-info">
                                <div class="session-device">{{ $session['device'] }}</div>
                                <div class="session-details">{{ $session['ip'] }} • Last active: {{ $session['last_active']->diffForHumans() }}</div>
                            </div>
                            <span class="session-status status-{{ $session['status'] }}">{{ ucfirst($session['status']) }}</span>
                        </div>
                        @endforeach
                        
                        <div class="text-center mt-3">
                            <button class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-sign-out-alt me-2"></i>Terminate All Other Sessions
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Password Change Modal -->
    <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="passwordModalLabel">
                        <i class="fas fa-key me-2"></i>Change Password
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('hospital.settings.password') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                            @error('current_password')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required minlength="8">
                            <div class="form-text">Password must be at least 8 characters long</div>
                            @error('new_password')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                            @error('new_password_confirmation')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Change Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Export settings functionality
            const exportBtn = document.querySelector('.btn-outline-secondary');
            exportBtn.addEventListener('click', function() {
                exportSettings();
            });
            
            // Toggle switches
            const toggles = document.querySelectorAll('.form-check-input');
            toggles.forEach(toggle => {
                toggle.addEventListener('change', function() {
                    const label = this.nextElementSibling;
                    if (this.checked) {
                        label.style.color = 'var(--success)';
                    } else {
                        label.style.color = 'inherit';
                    }
                });
            });
            
            // Threshold input validation
            const thresholdInputs = document.querySelectorAll('.threshold-card input');
            thresholdInputs.forEach(input => {
                input.addEventListener('change', function() {
                    const value = parseInt(this.value);
                    if (value < 0) this.value = 0;
                    if (value > 100) this.value = 100;
                });
            });
            

            
            // Terminate sessions functionality
            const terminateSessionsBtn = document.querySelector('.btn-outline-danger');
            if (terminateSessionsBtn) {
                terminateSessionsBtn.addEventListener('click', function() {
                    terminateAllSessions();
                });
            }
            
            // Handle password modal after successful submission
            @if(session('success') && session('password_changed'))
                const passwordModal = document.getElementById('passwordModal');
                if (passwordModal) {
                    const modal = bootstrap.Modal.getInstance(passwordModal);
                    if (modal) {
                        modal.hide();
                    }
                }
            @endif
        });
        

        
        function getOperatingDays() {
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            const days = [];
            checkboxes.forEach((checkbox, index) => {
                if (checkbox.checked) {
                    days.push(['Monday - Friday', 'Saturday', 'Sunday (Emergency Only)'][index]);
                }
            });
            return days;
        }
        
        function getThresholds() {
            const thresholds = {};
            const inputs = document.querySelectorAll('.threshold-card input');
            const bloodTypes = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];
            
            inputs.forEach((input, index) => {
                thresholds[bloodTypes[index]] = parseInt(input.value) || 0;
            });
            
            return thresholds;
        }
        
        function exportSettings() {
            const exportBtn = document.querySelector('.btn-outline-secondary');
            const originalText = exportBtn.innerHTML;
            exportBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Exporting...';
            exportBtn.disabled = true;
            
            setTimeout(() => {
                // Create and download JSON file
                const settings = {
                    institution: {
                        name: document.querySelector('input[name="name"]').value,
                        email: document.querySelector('input[name="email"]').value,
                        contact_number: document.querySelector('input[name="contact_number"]').value,
                        country: document.querySelector('input[name="country"]').value,
                        region: document.querySelector('select[name="region"]').value,
                        address: document.querySelector('textarea[name="address"]').value
                    },
                    blood_bank: {
                        opening_time: document.querySelector('input[name="opening_time"]').value,
                        closing_time: document.querySelector('input[name="closing_time"]').value,
                        operating_days: getOperatingDays(),
                        auto_accept_transfers: document.getElementById('autoAcceptTransfers').checked
                    },
                    thresholds: getThresholds(),
                    exported_at: new Date().toISOString()
                };
                
                const dataStr = JSON.stringify(settings, null, 2);
                const dataBlob = new Blob([dataStr], {type: 'application/json'});
                const url = URL.createObjectURL(dataBlob);
                const link = document.createElement('a');
                link.href = url;
                link.download = 'hospital-settings.json';
                link.click();
                URL.revokeObjectURL(url);
                
                exportBtn.innerHTML = originalText;
                exportBtn.disabled = false;
                showNotification('Settings exported successfully!', 'success');
            }, 1000);
        }
        

        
        function terminateAllSessions() {
            if (confirm('Are you sure you want to terminate all other sessions? This will log you out from all other devices.')) {
                const btn = document.querySelector('.btn-outline-danger');
                const originalText = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Terminating...';
                btn.disabled = true;
                
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                    showNotification('All other sessions terminated successfully!', 'success');
                }, 1500);
            }
        }
        
        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} position-fixed`;
            notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            notification.innerHTML = message;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }
    </script>
</body>
</html> 