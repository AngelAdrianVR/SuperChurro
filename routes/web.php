<?php

use App\Http\Controllers\AdminRequestController;
use App\Http\Controllers\BarterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\NoticeController;
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
use App\Models\CashRegister;
use App\Models\Notice;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
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
        $checked_in = auth()->user()->hasCheckedInToday();
        $checked_out = auth()->user()->hasCheckedOutToday();
        $loan = auth()->user()->loans()->where('remaining', '>', 0)->whereNotNull('authorized_at')->first();
        $leaves = auth()->user()->workPermits()->whereDate('date', '>=', today())->with('permissionType')->get();
        $notices = Notice::all();

        return auth()->user()->is_admin
            ? Inertia::render('AdminDashboard')
            : Inertia::render('Dashboard', compact('checked_in', 'checked_out', 'loan', 'leaves', 'notices'));
    })->name('dashboard');
});

Route::resource('payrolls', PayrollController::class)->middleware('auth');
Route::resource('work-permits', WorkPermitController::class)->middleware('auth');
Route::resource('barters', BarterController::class)->middleware('auth');
Route::resource('loans', LoanController::class)->middleware('auth');
Route::resource('warehouses', WarehouseController::class)->middleware('auth');
Route::resource('product-request', ProductRequestController::class)->middleware('auth');
Route::resource('sales-to-employees', SaleToEmployeeController::class)->middleware('auth');

Route::get('carts', [CartController::class, 'index'])->middleware('auth')->name('carts.index');
Route::post('cart/remove-products', [CartController::class, 'removeProducts'])->middleware('auth')->name('cart.remove-products');

// admin routes
Route::resource('products', ProductController::class)->middleware(['auth', 'admin']);
Route::resource('users', UserController::class)->middleware(['auth', 'admin']);
Route::resource('sales', SaleController::class)->middleware(['auth']);
Route::resource('settings', SettingController::class)->middleware(['auth', 'admin']);
Route::get('/admin/payrolls', [PayrollController::class, 'adminIndex'])->middleware(['auth', 'admin'])->name('payroll-admin.index');
Route::get('/admin/payrolls/show/{payroll}', [PayrollController::class, 'showUsersPayrolls'])->middleware(['auth', 'admin'])->name('payroll-admin.show');
Route::get('/admin/payrolls/close', [PayrollController::class, 'closePayroll'])->middleware(['auth', 'admin'])->name('payroll-admin.close');
Route::get('/admin-requests/permits', [AdminRequestController::class, 'permits'])->middleware(['auth', 'admin'])->name('admin-requests.permits');
Route::get('/admin-requests/loans', [AdminRequestController::class, 'loans'])->middleware(['auth', 'admin'])->name('admin-requests.loans');
Route::put('/accept/work-permit/{work_permit}', [AdminRequestController::class, 'acceptWorkPermit'])->middleware(['auth', 'admin'])->name('work-permit.accept');
Route::put('/reject/work-permit/{work_permit}', [AdminRequestController::class, 'rejectWorkPermit'])->middleware(['auth', 'admin'])->name('work-permit.reject');
Route::put('/accept/loans/{loan}', [AdminRequestController::class, 'acceptLoan'])->middleware(['auth', 'admin'])->name('loan.accept');
Route::put('/reject/loans/{loan}', [AdminRequestController::class, 'rejectLoan'])->middleware(['auth', 'admin'])->name('loan.reject');
Route::resource('notices', NoticeController::class)->middleware(['auth', 'admin']);
Route::get('/admin/christmas-bonus/show/{user}', [UserController::class, 'showUsersCrhismasBonus'])->middleware(['auth', 'admin'])->name('chrismas-bonus.show');
Route::get('/admin/settlement/show/{user}', [UserController::class, 'showUserSettlement'])->middleware(['auth', 'admin'])->name('settlement.show');
Route::get('/admin/vacation_bonus/show/{user}', [UserController::class, 'showUserVacationBonus'])->middleware(['auth', 'admin'])->name('vacation-bonus.show');


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

Route::post('payroll/store-attendance', [PayrollController::class, 'storeAttendance'])
    ->middleware('auth')
    ->name('payroll.store-attendance');

Route::post('/users/update-with-resources/{user}', [UserController::class, 'updateWithResources'])
    ->middleware('auth')
    ->name('users.update-with-resources');

Route::post('/users/delete-file', [UserController::class, 'deleteFile'])
    ->middleware('auth')
    ->name('users.delete-file');

Route::post('/cash-register', function (Request $request) {
    CashRegister::create([
        'cash' => $request->cash,
        'date' => $request->date
    ]);

    return response()->json(['status' => 'ok']);
})
    ->middleware('auth')
    ->name('cash-register.store');
