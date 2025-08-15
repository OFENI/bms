<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminDonorController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\DisbursementController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\HospitalDashboardController;
use App\Http\Controllers\HospitalInventoryController;
use App\Http\Controllers\DisbursementHistoryController;
use App\Http\Controllers\HospitalBloodRequestController;
use App\Http\Controllers\HospitalSettingsController;
use App\Http\Controllers\HospitalReportController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\HospitalNotificationController;
// Public welcome page
Route::get('/', function () {
    return view('welcome');
});

// Authentication
Route::get('/login',  [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout',[LoginController::class, 'logout'])->name('logout');

// Admin Dashboard — with inline admin role check
Route::middleware(['auth'])->prefix('admin')->group(function () {
    
     Route::group(['middleware' => function ($request, $next) {
         if (Auth::user()->role !== 'admin') {
             return redirect('/')->with('error', 'Access denied. Admins only.');
         }
         return $next($request);
     }], function () {
 
         Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
         Route::get('/users', [AdminController::class, 'usersManagement'])->name('admin.users');
         Route::get('/institutions', [AdminController::class, 'institutions'])->name('admin.institutions');
         Route::post('/institutions', [InstitutionController::class, 'store'])
         ->name('institutions.store');
         Route::get('/donors', [AdminController::class, 'donors'])->name('admin.donors');
         Route::get('/blood-inventory', [InstitutionController::class, 'inventory'])->name('admin.blood.inventory');
         Route::get('/disbursements', [DisbursementController::class, 'index'])
         ->name('admin.disbursements');
         Route::delete('/institutions/{institution}', [InstitutionController::class, 'destroy'])
         ->name('institutions.destroy');
         Route::match(['put','patch'], '/institutions/{institution}', [InstitutionController::class, 'update'])
         ->name('institutions.update');

         Route::post('users', [AdminDonorController::class, 'storeUser'])
     ->name('admin.users.store');
         Route::get('/inventory/report', [InventoryController::class, 'generateReport'])->name('admin.inventory.report');
         
         Route::resource('inventory', InventoryController::class);
         Route::resource('disbursements', DisbursementController::class);
 
    
         Route::patch('users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
         Route::delete('users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
 
         Route::get('donors/search', [AdminDonorController::class, 'search'])->name('admin.donors.search');
         Route::get('donors/search-ajax', [AdminDonorController::class, 'searchAjax'])->name('admin.donors.searchAjax');
         Route::post('donors/storeDonation', [AdminDonorController::class, 'storeDonation'])->name('admin.donors.storeDonation');
         Route::delete('donors/{user}', [AdminDonorController::class, 'destroy'])->name('admin.donors.destroy');
 
         Route::get('institutions/report', [AdminController::class, 'downloadInstitutionReport'])->name('admin.institutions.report');
 
         Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

         Route::get('/admin/blood-inventory', [InventoryController::class, 'index'])
         ->name('admin.inventory.index')
         ->middleware(['auth']);

    // For listing all institutions (index page)
          Route::get('/admin/institutions', [InstitutionController::class, 'index'])->name('institutions.index');

          Route::post('/admin/disbursements', [DisbursementController::class, 'store'])->name('disbursements.store');


     });
 });

// Admin Donors Routes
Route::prefix('admin/donors')->name('admin.donors.')->group(function () {
    Route::get('/', [AdminDonorController::class, 'index'])->name('index');          // List donors
    Route::get('/{donor}/edit', [AdminDonorController::class, 'edit'])->name('edit'); // Edit donor form
    Route::put('/{donor}', [AdminDonorController::class, 'update'])->name('update');  // Update donor
    Route::delete('/{donor}', [AdminDonorController::class, 'destroy'])->name('destroy'); // Delete donor
    Route::get('/admin/users', [AdminDonorController::class, 'showUsers'])->name('admin.users.index');
    Route::post('/admin/users/store', [AdminDonorController::class, 'storeUser'])
    ->name('admin.users.store');
    Route::get('/admin/users/create', [AdminDonorController::class, 'createUserForm'])->name('admin.users.create');
     Route::get('/admin/users', [AdminDonorController::class, 'listUsers'])->name('admin.users');

     Route::get('/admin/donors/search', [AdminDonorController::class, 'search'])->name('admin.donors.search');

     Route::get('/admin/donors/search', [AdminDonorController::class, 'searchAjax'])->name('admin.donors.searchAjax');
     Route::get('/admin/donors', [AdminDonorController::class, 'index'])->name('admin.donors.index');

     Route::get('users/create', [AdminDonorController::class, 'createUserForm'])
     ->name('admin.users.create');

    });

    // ────────── USERS ──────────
Route::get('users', [AdminDonorController::class, 'showUsers'])
->name('admin.users.index');

Route::get('users/create', [AdminDonorController::class, 'createUserForm'])
->name('admin.users.create');

Route::post('users', [AdminDonorController::class, 'storeUser'])
->name('admin.users.store');

// Hospital Routes - Consolidated
Route::middleware(['auth'])->prefix('hospital')->name('hospital.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [HospitalDashboardController::class, 'index'])->name('dashboard');
    
    // Inventory
    Route::get('/inventory', [HospitalInventoryController::class, 'index'])->name('inventory');
    Route::get('/blood-inventory', [HospitalInventoryController::class, 'index'])->name('blood_inventory');
    Route::get('/other-inventory', [HospitalInventoryController::class, 'showOtherInventories'])->name('other_inventory');
    Route::get('/other-inventory-data', [HospitalDashboardController::class, 'otherInventory'])->name('other_inventory_data');
    Route::get('/check-inventory-changes', [HospitalDashboardController::class, 'checkInventoryChanges'])->name('check_inventory_changes');
    Route::get('/debug-inventory/{hospitalId?}', [HospitalDashboardController::class, 'debugInventory'])->name('debug_inventory');
    Route::get('/test-inventory', [HospitalDashboardController::class, 'testInventory'])->name('test_inventory');
    Route::get('/debug-current-inventory', [HospitalDashboardController::class, 'debugCurrentInventory'])->name('debug_current_inventory');
    
    // Blood Requests
    Route::get('/requests', [HospitalBloodRequestController::class, 'index'])->name('requests.index');
    Route::get('/requests/create', [HospitalBloodRequestController::class, 'create'])->name('requests.create');
    Route::post('/requests', [HospitalBloodRequestController::class, 'store'])->name('requests.store');
    
    // Disbursements
    Route::get('/disbursement-history', [DisbursementHistoryController::class, 'index'])->name('disbursement_history');
    Route::get('/disbursement/{id}', [DisbursementController::class, 'getDisbursementDetail'])->name('disbursement.detail');
    Route::post('/disbursement/store', [DisbursementController::class, 'store'])->name('disbursement.store');
    
    // Settings
    Route::get('/settings', [HospitalSettingsController::class, 'index'])->name('settings');
    Route::post('/settings/institution', [HospitalSettingsController::class, 'updateInstitution'])->name('settings.institution');
    Route::post('/settings/blood-bank', [HospitalSettingsController::class, 'updateBloodBankSettings'])->name('settings.blood-bank');
    Route::post('/settings/thresholds', [HospitalSettingsController::class, 'updateThresholds'])->name('settings.thresholds');
    Route::post('/settings/password', [HospitalSettingsController::class, 'changePassword'])->name('settings.password');
    Route::post('/settings/2fa', [HospitalSettingsController::class, 'toggleTwoFactor'])->name('settings.2fa');
    Route::post('/settings/sessions/terminate', [HospitalSettingsController::class, 'terminateSessions'])->name('settings.sessions.terminate');
    Route::get('/settings/export', [HospitalSettingsController::class, 'exportSettings'])->name('settings.export');
    
    // Reports
    Route::get('/reports', [HospitalReportController::class, 'index'])->name('reports');
    Route::get('/reports/export/pdf', [HospitalReportController::class, 'exportPDF'])->name('reports.pdf');
    Route::get('/reports/export/csv', [HospitalReportController::class, 'exportCSV'])->name('reports.csv');
});

// General Disbursements Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/disbursements', [DisbursementController::class, 'index'])->name('disbursements.index');
    Route::post('/disbursements', [DisbursementController::class, 'store'])->name('disbursements.store');
});

    
    Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports');
        Route::get('/reports/export/pdf', [ReportController::class, 'exportPDF'])->name('reports.pdf');
        Route::get('/reports/export/csv', [ReportController::class, 'exportCSV'])->name('reports.csv');
    });
    
 

    Route::middleware(['auth'])->group(function () {
        Route::get('/hospital/notifications', [HospitalNotificationController::class, 'fetchNotifications'])->name('hospital.notifications');
    });
    
    