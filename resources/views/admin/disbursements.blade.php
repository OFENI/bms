<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disbursements | LifeStream Blood Bank</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* EXISTING STYLES REMAIN THE SAME */
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
        
        /* Disbursement Card */
        .disbursement-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            border-top: 3px solid var(--primary-red);
        }
        
        .disbursement-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .disbursement-header {
            padding: 15px;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            align-items: center;
        }
        
        .disbursement-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--light-red);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: var(--primary-red);
            font-size: 18px;
        }
        
        .disbursement-body {
            padding: 15px;
        }
        
        .disbursement-detail {
            display: flex;
            margin-bottom: 8px;
        }
        
        .disbursement-label {
            font-weight: 500;
            min-width: 120px;
            color: var(--text-light);
        }
        
        .disbursement-value {
            flex: 1;
        }
        
        .blood-unit-badge {
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
        
        /* Enhanced Responsive Design */
        @media (max-width: 1200px) {
            .disbursement-grid {
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            }
            
            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            }
        }
        
        @media (max-width: 992px) {
            .side-navbar {
                transform: translateX(-100%);
                width: 250px;
                transition: transform 0.3s ease-in-out;
            }
            
            body.collapsed .side-navbar {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
                max-width: 100%;
                padding: 15px;
            }
            
            body.collapsed .main-content {
                margin-left: 0;
            }
            
            .page-container {
                max-width: 100%;
            }
            
            .top-navbar {
                max-width: 100%;
            }
            
            .disbursement-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 15px;
            }
            
            .timeline-container {
                padding: 20px;
            }
            
            .activity-details {
                grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
                gap: 10px;
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
                flex-wrap: wrap;
                gap: 10px;
            }
            
            .disbursement-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }
            
            .timeline-item {
                flex-direction: column;
                padding-left: 20px;
            }
            
            .timeline-date {
                min-width: auto;
                margin-bottom: 10px;
            }
            
            .activity-details {
                grid-template-columns: repeat(2, 1fr);
                gap: 8px;
            }
            
            .action-buttons {
                flex-direction: column;
                gap: 8px;
            }
            
            .action-btn {
                width: 100%;
                justify-content: center;
            }
            
            .filter-card .row {
                margin: 0;
            }
            
            .filter-card .col-md-3 {
                margin-bottom: 15px;
            }
            
            .filter-card .col-md-3:last-child {
                margin-bottom: 0;
            }
            
            .table-responsive {
                font-size: 0.9rem;
            }
            
            .table th, .table td {
                padding: 10px 8px;
            }
            
            .blood-unit-badge {
                font-size: 0.75rem;
                padding: 3px 6px;
                margin-bottom: 3px;
            }
        }
        
        @media (max-width: 576px) {
            .main-content {
                padding: 10px;
            }
            
            .page-title h2 {
                font-size: 1.5rem;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }
            
            .stat-card {
                padding: 15px;
            }
            
            .stat-card .stat-value {
                font-size: 1.5rem;
            }
            
            .timeline-container {
                padding: 15px;
            }
            
            .timeline-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            
            .timeline-header h5 {
                font-size: 1.2rem;
            }
            
            .activity-details {
                grid-template-columns: 1fr;
                gap: 8px;
            }
            
            .action-btns {
                flex-wrap: wrap;
                gap: 5px;
            }
            
            .action-btns .btn {
                padding: 5px 8px;
                font-size: 0.8rem;
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
            
            .view-toggle {
                width: 100%;
                justify-content: center;
            }
            
            .view-toggle-btn {
                flex: 1;
                text-align: center;
            }
            
            .table {
                font-size: 0.8rem;
            }
            
            .table th, .table td {
                padding: 8px 5px;
            }
            
            .disbursement-card {
                margin-bottom: 15px;
            }
            
            .disbursement-header {
                padding: 12px;
            }
            
            .disbursement-body {
                padding: 12px;
            }
            
            .disbursement-detail {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }
            
            .disbursement-label {
                min-width: auto;
                font-size: 0.9rem;
            }
            
            .top-navbar {
                padding: 0.5rem;
            }
            
            .navbar-brand span {
                display: none;
            }
            
            .navbar-brand span:first-child {
                display: inline;
            }
            
            .user-menu .d-flex span {
                display: none;
            }
        }
        
        @media (max-width: 480px) {
            .page-title .d-flex {
                flex-direction: column;
                align-items: stretch;
            }
            
            .page-title .d-flex > * {
                width: 100%;
            }
            
            .view-toggle {
                order: -1;
            }
            
            .table-responsive {
                font-size: 0.75rem;
            }
            
            .table th, .table td {
                padding: 6px 4px;
            }
            
            .action-btns .btn {
                padding: 4px 6px;
                font-size: 0.75rem;
            }
            
            .timeline-content {
                padding: 12px;
            }
            
            .timeline-title {
                font-size: 0.95rem;
            }
            
            .timeline-description {
                font-size: 0.85rem;
            }
        }
        
        /* Grid Layout */
        .disbursement-grid {
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
        
        /* Status Colors */
        .status-pending { background-color: #fff8e1; color: #ff8f00; }
        .status-completed { background-color: #e8f5e9; color: #388e3c; }
        .status-cancelled { background-color: #ffebee; color: #c62828; }
        .status-processing { background-color: #e3f2fd; color: #1565c0; }
        
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
        
        /* Timeline */
        .timeline-container {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border-top: 3px solid var(--primary-red);
        }
        
        .timeline-item {
            display: flex;
            position: relative;
            padding: 0 0 20px 30px;
            border-left: 2px solid #e5e7eb;
        }
        
        .timeline-item:last-child {
            padding-bottom: 0;
        }
        
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -7px;
            top: 0;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: var(--primary-red);
        }
        
        .timeline-date {
            font-weight: 500;
            min-width: 100px;
            color: var(--text-light);
        }
        
        .timeline-content {
            flex: 1;
        }
        
        .timeline-title {
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .timeline-description {
            color: var(--text-light);
            font-size: 0.9rem;
        }
        /* ENHANCED RECENT DISBURSEMENT ACTIVITY SECTION */
        .timeline-container {
            background: white;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            border-top: 4px solid var(--primary-red);
            position: relative;
            overflow: hidden;
        }
        
        .timeline-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #f3f4f6;
        }
        
        .timeline-header h5 {
            font-size: 1.4rem;
            color: var(--text-dark);
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .timeline-header h5 i {
            color: var(--primary-red);
        }
        
        .view-all-btn {
            background: var(--light-red);
            color: var(--primary-red);
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .view-all-btn:hover {
            background: var(--primary-red);
            color: white;
        }
        
        .timeline-item {
            display: flex;
            position: relative;
            padding: 0 0 25px 35px;
            border-left: 2px solid #e5e7eb;
            transition: all 0.3s;
        }
        
        .timeline-item:hover {
            background: #f9fafb;
            border-radius: 8px;
        }
        
        .timeline-item:last-child {
            padding-bottom: 0;
        }
        
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -8px;
            top: 0;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: var(--primary-red);
            z-index: 2;
        }
        
        .timeline-icon {
            position: absolute;
            left: -28px;
            top: -4px;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 12px;
            z-index: 1;
        }
        
        .timeline-date {
            font-weight: 600;
            min-width: 120px;
            color: var(--text-light);
            font-size: 0.95rem;
        }
        
        .timeline-content {
            flex: 1;
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
            position: relative;
        }
        
        .timeline-content::after {
            content: '';
            position: absolute;
            left: -8px;
            top: 18px;
            width: 16px;
            height: 16px;
            transform: rotate(45deg);
            background: white;
            box-shadow: -2px 2px 4px rgba(0,0,0,0.05);
        }
        
        .timeline-title {
            font-weight: 700;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .status-badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .timeline-description {
            color: var(--text-light);
            font-size: 0.95rem;
            margin-bottom: 15px;
        }
        
        .activity-details {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 12px;
            margin-bottom: 15px;
            background: #f8f9fa;
            padding: 12px;
            border-radius: 6px;
        }
        
        .detail-item {
            display: flex;
            flex-direction: column;
        }
        
        .detail-label {
            font-size: 0.8rem;
            color: var(--text-light);
            margin-bottom: 3px;
        }
        
        .detail-value {
            font-weight: 600;
            color: var(--text-dark);
            font-size: 0.95rem;
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }
        
        .action-btn {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.9rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
        }
        
        .btn-view {
            background: #e3f2fd;
            color: #1565c0;
        }
        
        .btn-view:hover {
            background: #bbdefb;
        }
        
        .btn-approve {
            background: #e8f5e9;
            color: #388e3c;
        }
        
        .btn-approve:hover {
            background: #c8e6c9;
        }
        
        .btn-decline {
            background: #ffebee;
            color: #c62828;
        }
        
        .btn-decline:hover {
            background: #ffcdd2;
        }
        
        /* Color coding for activity types */
        .status-completed {
            background-color: #e8f5e9;
            color: #388e3c;
        }
        
        .status-request {
            background-color: #e3f2fd;
            color: #1565c0;
        }
        
        .status-processing {
            background-color: #f3e5f5;
            color: #7b1fa2;
        }
        
        .status-approved {
            background-color: #fff8e1;
            color: #ff8f00;
        }
    </style>
</head>
<body>
    <!-- EXISTING PAGE CONTENT REMAINS THE SAME UNTIL THE ACTIVITY SECTION -->
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
  <a href="{{ route('admin.blood.inventory') }}" class="nav-link">
    <i class="fas fa-tint"></i>
    <span>Blood Inventory</span>
  </a>
</div>
                <div class="nav-item">
                    <a href="#" class="nav-link active">
                        <i class="fas fa-syringe"></i>
                        <span>Disbursements</span>
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
                    <li class="breadcrumb-item active" aria-current="page">Disbursements</li>
                </ol>
            </nav>

            <!-- Page Title -->
            <div class="page-title">
                <h2>Blood Disbursement Management</h2>
                <div class="d-flex gap-2 align-items-center">
                    <div class="view-toggle me-3">
                        <button class="view-toggle-btn active" id="listViewBtn">
                            <i class="fas fa-list"></i>
                        </button>
                        <button class="view-toggle-btn" id="gridViewBtn">
                            <i class="fas fa-th-large"></i>
                        </button>
                    </div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDisbursementModal">
    <i class="fas fa-plus"></i> Add Disbursement
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

            <!-- Disbursement Statistics -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-truck-loading"></i>
                    </div>
                    <div class="stat-value">247</div>
                    <div class="stat-label">Total Disbursements</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-value">189</div>
                    <div class="stat-label">Completed</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                    <div class="stat-value">35</div>
                    <div class="stat-label">Pending</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-tint"></i>
                    </div>
                    <div class="stat-value">1,423 L</div>
                    <div class="stat-label">Blood Disbursed</div>
                </div>
            </div>

    <!-- Recent Activity Timeline - ENHANCED SECTION -->
    <div class="timeline-container">
        <div class="timeline-header">
            <h5><i class="fas fa-history"></i> Recent Disbursement Activity</h5>
            <button class="view-all-btn">
                <i class="fas fa-list"></i> View All Activity
            </button>
        </div>
        
        <div class="timeline-item">
            <div class="timeline-icon status-completed">
                <i class="fas fa-check"></i>
            </div>
            <div class="timeline-date">
                <i class="far fa-calendar"></i> Today, 10:30 AM
            </div>
            <div class="timeline-content">
                <div class="timeline-title">
                    <span>Disbursement Completed</span>
                    <span class="status-badge status-completed">Completed</span>
                </div>
                <div class="timeline-description">
                    15 units of blood have been successfully disbursed to City General Hospital. 
                    The shipment was received by Dr. Jennifer Parker at the main reception.
                </div>
                <div class="activity-details">
                    <div class="detail-item">
                        <span class="detail-label">Institution</span>
                        <span class="detail-value">City General Hospital</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Blood Units</span>
                        <span class="detail-value">15 units</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Disbursement ID</span>
                        <span class="detail-value">DIS-2024-00123</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Handled By</span>
                        <span class="detail-value">Dr. Michael Chen</span>
                    </div>
                </div>
                <div class="action-buttons">
                    <button class="action-btn btn-view">
                        <i class="fas fa-eye"></i> View Details
                    </button>
                    <button class="action-btn btn-approve">
                        <i class="fas fa-file-pdf"></i> Report
                    </button>
                </div>
            </div>
        </div>
        
        <div class="timeline-item">
            <div class="timeline-icon status-request">
                <i class="fas fa-plus-circle"></i>
            </div>
            <div class="timeline-date">
                <i class="far fa-calendar"></i> Yesterday, 2:15 PM
            </div>
            <div class="timeline-content">
                <div class="timeline-title">
                    <span>New Disbursement Request</span>
                    <span class="status-badge status-request">New Request</span>
                </div>
                <div class="timeline-description">
                    Regional Blood Center has requested 8 units of O+ blood. 
                    The request is pending approval from the inventory manager.
                </div>
                <div class="activity-details">
                    <div class="detail-item">
                        <span class="detail-label">Institution</span>
                        <span class="detail-value">Regional Blood Center</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Blood Type</span>
                        <span class="detail-value">O+</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Units Requested</span>
                        <span class="detail-value">8 units</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Requested By</span>
                        <span class="detail-value">Sarah Johnson</span>
                    </div>
                </div>
                <div class="action-buttons">
                    <button class="action-btn btn-approve">
                        <i class="fas fa-check-circle"></i> Approve
                    </button>
                    <button class="action-btn btn-decline">
                        <i class="fas fa-times-circle"></i> Decline
                    </button>
                </div>
            </div>
        </div>
        
        <div class="timeline-item">
            <div class="timeline-icon status-processing">
                <i class="fas fa-sync-alt"></i>
            </div>
            <div class="timeline-date">
                <i class="far fa-calendar"></i> Apr 12, 9:45 AM
            </div>
            <div class="timeline-content">
                <div class="timeline-title">
                    <span>Disbursement Processed</span>
                    <span class="status-badge status-processing">Processing</span>
                </div>
                <div class="timeline-description">
                    12 units of blood have been processed and shipped to Northside Community Clinic. 
                    The shipment is en route and expected to arrive within 2 hours.
                </div>
                <div class="activity-details">
                    <div class="detail-item">
                        <span class="detail-label">Institution</span>
                        <span class="detail-value">Northside Community Clinic</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Blood Units</span>
                        <span class="detail-value">12 units</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Tracking ID</span>
                        <span class="detail-value">TRK-7842-2024</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Estimated Arrival</span>
                        <span class="detail-value">11:45 AM</span>
                    </div>
                </div>
                <div class="action-buttons">
                    <button class="action-btn btn-view">
                        <i class="fas fa-map-marker-alt"></i> Track
                    </button>
                    <button class="action-btn btn-view">
                        <i class="fas fa-phone-alt"></i> Contact
                    </button>
                </div>
            </div>
        </div>
        
        <div class="timeline-item">
            <div class="timeline-icon status-approved">
                <i class="fas fa-clipboard-check"></i>
            </div>
            <div class="timeline-date">
                <i class="far fa-calendar"></i> Apr 10, 4:20 PM
            </div>
            <div class="timeline-content">
                <div class="timeline-title">
                    <span>Disbursement Approved</span>
                    <span class="status-badge status-approved">Approved</span>
                </div>
                <div class="timeline-description">
                    The request from Children's Hospital for 5 units of AB- blood has been approved. 
                    The blood units are being prepared for shipment.
                </div>
                <div class="activity-details">
                    <div class="detail-item">
                        <span class="detail-label">Institution</span>
                        <span class="detail-value">Children's Hospital</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Blood Type</span>
                        <span class="detail-value">AB-</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Units Approved</span>
                        <span class="detail-value">5 units</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Approved By</span>
                        <span class="detail-value">Dr. Robert Davis</span>
                    </div>
                </div>
                <div class="action-buttons">
                    <button class="action-btn btn-view">
                        <i class="fas fa-file-invoice"></i> Details
                    </button>
                    <button class="action-btn btn-approve">
                        <i class="fas fa-truck"></i> Schedule
                    </button>
                </div>
            </div>
        </div>
    </div>



     <div class="filter-card">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="searchInput" class="form-label">Search</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="searchInput" placeholder="ID, Institution...">
                            <button class="btn btn-outline-secondary" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="institutionFilter" class="form-label">Institution</label>
                        <select class="form-select" id="institutionFilter">
                            <option value="">All Institutions</option>
                            <option value="city_hospital">City General Hospital</option>
                            <option value="northside">Northside Community Clinic</option>
                            <option value="regional">Regional Blood Center</option>
                            <option value="children">Children's Hospital</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="statusFilter" class="form-label">Status</label>
                        <select class="form-select" id="statusFilter">
                            <option value="">All Statuses</option>
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button class="btn btn-outline-secondary w-100">
                            <i class="fas fa-filter"></i> Apply Filters
                        </button>
                    </div>
                </div>
            </div>

            <!-- Disbursements Table (List View) -->
            <div class="table-card" id="listView">
                <div class="card-header">
                    <h3 class="mb-0">Blood Disbursements</h3>
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
                                    <th>Disbursement ID</th>
                                    <th>Institution</th>
                                    <th>Blood Units</th>
                                    <th>Request Date</th>
                                    <th>Disbursement Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td>DIS-2024-00123</td>
                                    <td>City General Hospital</td>
                                    <td>
                                        <span class="blood-unit-badge">O+: 5 units</span>
                                        <span class="blood-unit-badge">A+: 3 units</span>
                                        <span class="blood-unit-badge">B+: 2 units</span>
                                    </td>
                                    <td>15 Apr 2024</td>
                                    <td>17 Apr 2024</td>
                                    <td>
                                        <span class="badge status-completed">Completed</span>
                                    </td>
                                    <td>
                                        <div class="d-flex action-btns">
                                            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editDisbursementModal">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-secondary">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td>DIS-2024-00145</td>
                                    <td>Children's Hospital</td>
                                    <td>
                                        <span class="blood-unit-badge">O-: 3 units</span>
                                        <span class="blood-unit-badge">A-: 2 units</span>
                                    </td>
                                    <td>18 Apr 2024</td>
                                    <td>-</td>
                                    <td>
                                        <span class="badge status-processing">Processing</span>
                                    </td>
                                    <td>
                                        <div class="d-flex action-btns">
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
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td>DIS-2024-00087</td>
                                    <td>Regional Blood Center</td>
                                    <td>
                                        <span class="blood-unit-badge">AB+: 4 units</span>
                                        <span class="blood-unit-badge">B+: 4 units</span>
                                    </td>
                                    <td>10 Apr 2024</td>
                                    <td>12 Apr 2024</td>
                                    <td>
                                        <span class="badge status-completed">Completed</span>
                                    </td>
                                    <td>
                                        <div class="d-flex action-btns">
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
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td>DIS-2024-00234</td>
                                    <td>Northside Community Clinic</td>
                                    <td>
                                        <span class="blood-unit-badge">A+: 2 units</span>
                                        <span class="blood-unit-badge">O+: 1 unit</span>
                                    </td>
                                    <td>20 Apr 2024</td>
                                    <td>-</td>
                                    <td>
                                        <span class="badge status-pending">Pending</span>
                                    </td>
                                    <td>
                                        <div class="d-flex action-btns">
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
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td>DIS-2024-00189</td>
                                    <td>City General Hospital</td>
                                    <td>
                                        <span class="blood-unit-badge">O+: 8 units</span>
                                    </td>
                                    <td>15 Apr 2024</td>
                                    <td>-</td>
                                    <td>
                                        <span class="badge status-cancelled">Cancelled</span>
                                    </td>
                                    <td>
                                        <div class="d-flex action-btns">
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
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <div>
                        Showing 1 to 5 of 47 entries
                    </div>
                    <nav>
                        <ul class="pagination mb-0">
                            <li class="page-item disabled">
                                <a class="page-link" href="#">Previous</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

            <!-- Disbursements Grid (Card View) -->
            <div class="disbursement-grid" id="gridView" style="display: none;">
                <!-- Disbursement Card 1 -->
                <div class="disbursement-card">
                    <div class="disbursement-header">
                        <div class="disbursement-icon">
                            <i class="fas fa-truck"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">DIS-2024-00123</h6>
                            <small class="text-muted">City General Hospital</small>
                        </div>
                    </div>
                    <div class="disbursement-body">
                        <div class="disbursement-detail">
                            <div class="disbursement-label">Status:</div>
                            <div class="disbursement-value">
                                <span class="badge status-completed">Completed</span>
                            </div>
                        </div>
                        <div class="disbursement-detail">
                            <div class="disbursement-label">Blood Units:</div>
                            <div class="disbursement-value">
                                <span class="blood-unit-badge">O+: 5 units</span>
                                <span class="blood-unit-badge">A+: 3 units</span>
                                <span class="blood-unit-badge">B+: 2 units</span>
                            </div>
                        </div>
                        <div class="disbursement-detail">
                            <div class="disbursement-label">Request Date:</div>
                            <div class="disbursement-value">15 Apr 2024</div>
                        </div>
                        <div class="disbursement-detail">
                            <div class="disbursement-label">Disbursed On:</div>
                            <div class="disbursement-value">17 Apr 2024</div>
                        </div>
                        <div class="d-flex action-btns justify-content-end mt-3">
                            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editDisbursementModal">
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

                <!-- Disbursement Card 2 -->
                <div class="disbursement-card">
                    <div class="disbursement-header">
                        <div class="disbursement-icon">
                            <i class="fas fa-truck-loading"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">DIS-2024-00145</h6>
                            <small class="text-muted">Children's Hospital</small>
                        </div>
                    </div>
                    <div class="disbursement-body">
                        <div class="disbursement-detail">
                            <div class="disbursement-label">Status:</div>
                            <div class="disbursement-value">
                                <span class="badge status-processing">Processing</span>
                            </div>
                        </div>
                        <div class="disbursement-detail">
                            <div class="disbursement-label">Blood Units:</div>
                            <div class="disbursement-value">
                                <span class="blood-unit-badge">O-: 3 units</span>
                                <span class="blood-unit-badge">A-: 2 units</span>
                            </div>
                        </div>
                        <div class="disbursement-detail">
                            <div class="disbursement-label">Request Date:</div>
                            <div class="disbursement-value">18 Apr 2024</div>
                        </div>
                        <div class="disbursement-detail">
                            <div class="disbursement-label">Disbursed On:</div>
                            <div class="disbursement-value">-</div>
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

                <!-- Disbursement Card 3 -->
                <div class="disbursement-card">
                    <div class="disbursement-header">
                        <div class="disbursement-icon">
                            <i class="fas fa-truck"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">DIS-2024-00087</h6>
                            <small class="text-muted">Regional Blood Center</small>
                        </div>
                    </div>
                    <div class="disbursement-body">
                        <div class="disbursement-detail">
                            <div class="disbursement-label">Status:</div>
                            <div class="disbursement-value">
                                <span class="badge status-completed">Completed</span>
                            </div>
                        </div>
                        <div class="disbursement-detail">
                            <div class="disbursement-label">Blood Units:</div>
                            <div class="disbursement-value">
                                <span class="blood-unit-badge">AB+: 4 units</span>
                                <span class="blood-unit-badge">B+: 4 units</span>
                            </div>
                        </div>
                        <div class="disbursement-detail">
                            <div class="disbursement-label">Request Date:</div>
                            <div class="disbursement-value">10 Apr 2024</div>
                        </div>
                        <div class="disbursement-detail">
                            <div class="disbursement-label">Disbursed On:</div>
                            <div class="disbursement-value">12 Apr 2024</div>
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

                <!-- Disbursement Card 4 -->
                <div class="disbursement-card">
                    <div class="disbursement-header">
                        <div class="disbursement-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">DIS-2024-00234</h6>
                            <small class="text-muted">Northside Community Clinic</small>
                        </div>
                    </div>
                    <div class="disbursement-body">
                        <div class="disbursement-detail">
                            <div class="disbursement-label">Status:</div>
                            <div class="disbursement-value">
                                <span class="badge status-pending">Pending</span>
                            </div>
                        </div>
                        <div class="disbursement-detail">
                            <div class="disbursement-label">Blood Units:</div>
                            <div class="disbursement-value">
                                <span class="blood-unit-badge">A+: 2 units</span>
                                <span class="blood-unit-badge">O+: 1 unit</span>
                            </div>
                        </div>
                        <div class="disbursement-detail">
                            <div class="disbursement-label">Request Date:</div>
                            <div class="disbursement-value">20 Apr 2024</div>
                        </div>
                        <div class="disbursement-detail">
                            <div class="disbursement-label">Disbursed On:</div>
                            <div class="disbursement-value">-</div>
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

                <!-- Disbursement Card 5 -->
                <div class="disbursement-card">
                    <div class="disbursement-header">
                        <div class="disbursement-icon">
                            <i class="fas fa-ban"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">DIS-2024-00189</h6>
                            <small class="text-muted">City General Hospital</small>
                        </div>
                    </div>
                    <div class="disbursement-body">
                        <div class="disbursement-detail">
                            <div class="disbursement-label">Status:</div>
                            <div class="disbursement-value">
                                <span class="badge status-cancelled">Cancelled</span>
                            </div>
                        </div>
                        <div class="disbursement-detail">
                            <div class="disbursement-label">Blood Units:</div>
                            <div class="disbursement-value">
                                <span class="blood-unit-badge">O+: 8 units</span>
                            </div>
                        </div>
                        <div class="disbursement-detail">
                            <div class="disbursement-label">Request Date:</div>
                            <div class="disbursement-value">15 Apr 2024</div>
                        </div>
                        <div class="disbursement-detail">
                            <div class="disbursement-label">Disbursed On:</div>
                            <div class="disbursement-value">-</div>
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

    <!-- Add Disbursement Modal -->
    <div class="modal fade" id="addDisbursementModal" tabindex="-1" aria-labelledby="addDisbursementModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDisbursementModalLabel">Add New Disbursement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="disbursementForm" action="{{ route('disbursements.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="institution" class="form-label">Institution</label>
                                <select name="institution_id" id="institution" class="form-select" required>
                                    <option value="">Select Institution</option>
                                    @foreach($institutions ?? [] as $institution)
                                        <option value="{{ $institution->id }}">{{ $institution->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="disbursed_date" class="form-label">Disbursement Date</label>
                                <input type="date" name="disbursed_date" id="disbursed_date" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select" required>
                                    <option value="pending">Pending</option>
                                    <option value="disbursed">Disbursed</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Blood Units</label>
                                <div class="card p-3">
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-5">
                                            <select class="form-select" id="bloodType">
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
                                        <div class="col-md-4">
                                            <input type="number" class="form-control" id="units" placeholder="Units" min="1">
                                        </div>
                                        <div class="col-md-3">
                                            <button type="button" class="btn btn-primary w-100" id="addUnitBtn">
                                                <i class="fas fa-plus"></i> Add
                                            </button>
                                        </div>
                                    </div>
                                    <div id="unitsContainer">
                                        <div class="alert alert-light mb-0">No units added yet</div>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="blood_units" id="blood_units">

                            <div class="col-12">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea name="notes" id="notes" class="form-control" rows="3" placeholder="Enter any additional notes..."></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="createDisbursementBtn">Create Disbursement</button>
                </div>
            </div>
        </div>
    </div>




    <!-- Edit Disbursement Modal -->
    <div class="modal fade" id="editDisbursementModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Disbursement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="editInstitution" class="form-label">Institution</label>
                                <select class="form-select" id="editInstitution" required>
                                    <option value="city_hospital" selected>City General Hospital</option>
                                    <option value="northside">Northside Community Clinic</option>
                                    <option value="regional">Regional Blood Center</option>
                                    <option value="children">Children's Hospital</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="editRequestDate" class="form-label">Request Date</label>
                                <input type="date" class="form-control" id="editRequestDate" value="2024-04-15" required>
                            </div>
                            <div class="col-md-6">
                                <label for="editDisbursementDate" class="form-label">Disbursement Date</label>
                                <input type="date" class="form-control" id="editDisbursementDate" value="2024-04-17">
                            </div>
                            <div class="col-md-6">
                                <label for="editStatus" class="form-label">Status</label>
                                <select class="form-select" id="editStatus" required>
                                    <option value="completed" selected>Completed</option>
                                    <option value="pending">Pending</option>
                                    <option value="processing">Processing</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Blood Units</label>
                                <div class="card p-3">
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-5">
                                            <select class="form-select" id="editBloodType">
                                                <option value="">Select Blood Type</option>
                                                <option value="A+">A+</option>
                                                <option value="A-">A-</option>
                                                <option value="B+">B+</option>
                                                <option value="B-">B-</option>
                                                <option value="O+" selected>O+</option>
                                                <option value="O-">O-</option>
                                                <option value="AB+">AB+</option>
                                                <option value="AB-">AB-</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="number" class="form-control" id="editUnits" value="5" min="1">
                                        </div>
                                        <div class="col-md-3">
                                            <button type="button" class="btn btn-primary w-100" id="editAddUnitBtn">
                                                <i class="fas fa-plus"></i> Add
                                            </button>
                                        </div>
                                    </div>
                                    <div id="editUnitsContainer">
                                        <div class="d-flex justify-content-between align-items-center bg-light p-2 mb-2 rounded">
                                            <div>
                                                <span class="badge bg-primary">O+</span>
                                                <span>5 units</span>
                                            </div>
                                            <button type="button" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center bg-light p-2 mb-2 rounded">
                                            <div>
                                                <span class="badge bg-danger">A+</span>
                                                <span>3 units</span>
                                            </div>
                                            <button type="button" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center bg-light p-2 rounded">
                                            <div>
                                                <span class="badge bg-success">B+</span>
                                                <span>2 units</span>
                                            </div>
                                            <button type="button" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="editNotes" class="form-label">Notes</label>
                                <textarea class="form-control" id="editNotes" rows="3">Emergency request for surgery department</textarea>
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
                        title: 'Delete Disbursement?',
                        text: "This will permanently remove the disbursement record.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire(
                                'Deleted!',
                                'The disbursement record has been deleted.',
                                'success'
                            );
                        }
                    });
                });
            });

            // Add unit functionality for modal
            const addUnitBtn = document.getElementById('addUnitBtn');
            let bloodUnitsList = [];

            function updateBloodUnitsInput() {
                const bloodUnitsInput = document.getElementById('blood_units');
                if (bloodUnitsInput) {
                    bloodUnitsInput.value = JSON.stringify(bloodUnitsList);
                }
            }

            function renderUnits() {
                const container = document.getElementById('unitsContainer');
                if (!container) return;
                if (bloodUnitsList.length === 0) {
                    container.innerHTML = '<div class="alert alert-light mb-0">No units added yet</div>';
                } else {
                    container.innerHTML = bloodUnitsList.map((unit, index) => `
                        <div class="d-flex justify-content-between align-items-center bg-light p-2 mb-2 rounded">
                            <div>
                                <span class="badge ${getBloodTypeClass(unit.type)}">${unit.type}</span>
                                <span>${unit.quantity} units</span>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-danger remove-unit" data-index="${index}">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `).join('');
                }
                updateBloodUnitsInput();
            }

            if (addUnitBtn) {
                addUnitBtn.addEventListener('click', function() {
                    const bloodType = document.getElementById('bloodType').value;
                    const units = document.getElementById('units').value;
                    if (!bloodType || !units) {
                        Swal.fire('Error', 'Please select a blood type and enter number of units', 'error');
                        return;
                    }
                    bloodUnitsList.push({ type: bloodType, quantity: parseInt(units, 10) });
                    renderUnits();
                    document.getElementById('bloodType').value = '';
                    document.getElementById('units').value = '';
                });
            }

            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-unit')) {
                    const index = e.target.getAttribute('data-index');
                    bloodUnitsList.splice(index, 1);
                    renderUnits();
                }
            });

            // Create Disbursement button functionality
            const createDisbursementBtn = document.getElementById('createDisbursementBtn');
            if (createDisbursementBtn) {
                createDisbursementBtn.addEventListener('click', function() {
                    const form = document.getElementById('disbursementForm');
                    
                    // Validate form
                    if (!form.checkValidity()) {
                        form.reportValidity();
                        return;
                    }
                    
                    // Check if blood units are added
                    const unitsContainer = document.getElementById('unitsContainer');
                    if (unitsContainer.querySelector('.alert')) {
                        Swal.fire('Error', 'Please add at least one blood unit', 'error');
                        return;
                    }
                    
                    // Show loading state
                    this.disabled = true;
                    this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating...';
                    
                    // Submit form
                    form.submit();
                });
            }
            
            // Blood type badge classes
            function getBloodTypeClass(type) {
                const classes = {
                    'A+': 'bg-danger',
                    'A-': 'bg-danger',
                    'B+': 'bg-success',
                    'B-': 'bg-success',
                    'O+': 'bg-primary',
                    'O-': 'bg-primary',
                    'AB+': 'bg-info',
                    'AB-': 'bg-info'
                };
                return classes[type] || 'bg-secondary';
            }

            // Mobile-specific enhancements
            function handleMobileLayout() {
                const isMobile = window.innerWidth <= 768;
                
                if (isMobile) {
                    // Auto-hide sidebar on mobile
                    document.body.classList.remove('collapsed');
                    
                    // Close sidebar when clicking outside
                    document.addEventListener('click', function(e) {
                        if (window.innerWidth <= 768) {
                            const sidebar = document.querySelector('.side-navbar');
                            const toggleBtn = document.getElementById('toggleSidebar');
                            
                            if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
                                document.body.classList.remove('collapsed');
                            }
                        }
                    });
                }
            }

            // Initialize mobile layout
            handleMobileLayout();
            
            // Handle window resize
            window.addEventListener('resize', handleMobileLayout);

            // Modal enhancements
            const addDisbursementModal = document.getElementById('addDisbursementModal');
            if (addDisbursementModal) {
                // Reset form when modal is closed
                addDisbursementModal.addEventListener('hidden.bs.modal', function() {
                    const form = this.querySelector('form');
                    if (form) {
                        form.reset();
                        const unitsContainer = document.getElementById('unitsContainer');
                        if (unitsContainer) {
                            unitsContainer.innerHTML = '<div class="alert alert-light mb-0">No units added yet</div>';
                        }
                        // Reset the create button
                        const createBtn = document.getElementById('createDisbursementBtn');
                        if (createBtn) {
                            createBtn.disabled = false;
                            createBtn.innerHTML = 'Create Disbursement';
                        }
                    }
                });

                // Set default date to today
                const disbursedDateInput = document.getElementById('disbursed_date');
                if (disbursedDateInput) {
                    const today = new Date().toISOString().split('T')[0];
                    disbursedDateInput.value = today;
                }

                // Handle form submission
                const form = document.getElementById('disbursementForm');
                if (form) {
                    form.addEventListener('submit', function(e) {
                        // Prevent default submission if validation fails
                        const unitsContainer = document.getElementById('unitsContainer');
                        if (unitsContainer.querySelector('.alert')) {
                            e.preventDefault();
                            Swal.fire('Error', 'Please add at least one blood unit', 'error');
                            return false;
                        }
                    });
                }
            }

            // Search functionality
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    const tableRows = document.querySelectorAll('tbody tr');
                    
                    tableRows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(searchTerm) ? '' : 'none';
                    });
                });
            }

            // Filter functionality
            const institutionFilter = document.getElementById('institutionFilter');
            const statusFilter = document.getElementById('statusFilter');
            
            function applyFilters() {
                const institution = institutionFilter ? institutionFilter.value : '';
                const status = statusFilter ? statusFilter.value : '';
                const tableRows = document.querySelectorAll('tbody tr');
                
                tableRows.forEach(row => {
                    const institutionText = row.cells[2] ? row.cells[2].textContent.toLowerCase() : '';
                    const statusText = row.cells[6] ? row.cells[6].textContent.toLowerCase() : '';
                    
                    const institutionMatch = !institution || institutionText.includes(institution.toLowerCase());
                    const statusMatch = !status || statusText.includes(status.toLowerCase());
                    
                    row.style.display = institutionMatch && statusMatch ? '' : 'none';
                });
            }
            
            if (institutionFilter) institutionFilter.addEventListener('change', applyFilters);
            if (statusFilter) statusFilter.addEventListener('change', applyFilters);
        });
    </script>
    
    <!-- EXISTING PAGE CONTENT CONTINUES AFTER THIS POINT -->



    <script>
        // Add hover effect to timeline items
        document.querySelectorAll('.timeline-item').forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(5px)';
            });
            
            item.addEventListener('mouseleave', function() {
                this.style.transform = 'translateX(0)';
            });
        });
        
        // View all button functionality
        document.querySelector('.view-all-btn').addEventListener('click', function() {
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
            
            setTimeout(() => {
                this.innerHTML = '<i class="fas fa-list"></i> View All Activity';
                alert('All activity data loaded successfully!');
            }, 1500);
        });
    </script>
</body>
</html>