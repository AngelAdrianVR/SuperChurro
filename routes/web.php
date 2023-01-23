<?php

use App\Http\Controllers\AdminRequestController;
use App\Http\Controllers\BarterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductRequestController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SaleToEmployeeController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\WarehouseMovementController;
use App\Http\Controllers\WorkPermitController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/qr-scanner', function () {
        return Inertia::render('ScannerPage');
    })->name('qr-scanner');
});

// how to protect pages from not admin useres? (custom middleware)
Route::resource('payrolls', PayrollController::class)->middleware('auth');
Route::resource('work-permits', WorkPermitController::class)->middleware('auth');
Route::resource('barters', BarterController::class)->middleware('auth');
Route::resource('loans', LoanController::class)->middleware('auth');
Route::resource('carts', CartController::class)->middleware('auth');
Route::resource('warehouses', WarehouseController::class)->middleware('auth');
Route::resource('product-request', ProductRequestController::class)->middleware('auth');
Route::resource('sells-to-employees', SaleToEmployeeController::class)->middleware('auth');

// admin routes
Route::resource('products', ProductController::class)->middleware(['auth','admin']);
Route::resource('users', UserController::class)->middleware(['auth','admin']);
Route::resource('sales', SaleController::class)->middleware(['auth','admin']);
Route::resource('settings', SettingController::class)->middleware(['auth','admin']);
Route::get('/admin/payrolls', [PayrollController::class, 'adminIndex'])->middleware(['auth','admin'])->name('payroll-admin.index');
Route::get('/admin/payrolls/show/{payroll}', [PayrollController::class, 'showUsersPayrolls'])->middleware(['auth','admin'])->name('payroll-admin.show');
Route::get('/admin/payrolls/close', [PayrollController::class, 'closePayroll'])->middleware(['auth','admin'])->name('payroll-admin.close');
Route::get('/admin-requests/permits', [AdminRequestController::class, 'permits'])->middleware(['auth','admin'])->name('admin-requests.permits');
Route::get('/admin-requests/loans', [AdminRequestController::class, 'loans'])->middleware(['auth','admin'])->name('admin-requests.loans');
Route::put('/accept/work-permit/{work_permit}', [AdminRequestController::class, 'acceptWorkPermit'])->middleware(['auth','admin'])->name('work-permit.accept');
Route::put('/reject/work-permit/{work_permit}', [AdminRequestController::class, 'rejectWorkPermit'])->middleware(['auth','admin'])->name('work-permit.reject');
Route::put('/accept/loans/{loan}', [AdminRequestController::class, 'acceptLoan'])->middleware(['auth','admin'])->name('loan.accept');
Route::put('/reject/loans/{loan}', [AdminRequestController::class, 'rejectLoan'])->middleware(['auth','admin'])->name('loan.reject');

//Specific-action routes
Route::put('/disable/{user}', [UserController::class, 'disable'])->middleware('auth')->name('user.disable');
Route::put('/enable/{user}', [UserController::class, 'enable'])->middleware('auth')->name('user.enable');
Route::put('/reset-pass/{user}', [UserController::class, 'resetPass'])->middleware('auth')->name('user.reset-pass');

Route::get('warehouses-movements/show-product-record/{product}', [WarehouseMovementController::class, 'showProductRecord'])
    ->middleware('auth')
    ->name('warehouse-movements.show-product-record');
Route::resource('warehouse-movements', WarehouseMovementController::class)
    ->middleware('auth')
    ->except(['show, index, destroy, edit, update']);

// API
Route::post('sales/get-by-date', [SaleController::class, 'getByDate'])
    ->middleware('auth')
    ->name('sales.get-sales-by-date');
