<?php

use App\Http\Controllers\AdminRequestController;
use App\Http\Controllers\BarterController;
use App\Http\Controllers\BonusController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ConsumableController;
use App\Http\Controllers\ConsumableRequestController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JustificationEventController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\OutcomeController;
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
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::redirect('/', 'login');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});


// payrolls -----------------------------------------------------------------------------
// --------------------------------------------------------------------------------------
Route::resource('payrolls', PayrollController::class)->middleware('auth');
Route::get('/admin/payrolls', [PayrollController::class, 'adminIndex'])->middleware(['auth', 'admin'])->name('payroll-admin.index');
Route::get('/admin/payrolls/show-receipt/{ids}/{payroll_id}', [PayrollController::class, 'showUsersPayrolls'])->middleware(['auth', 'admin'])->name('payroll-admin.show-receipt');
// Route::get('/admin/payrolls/show/{payrollUser}', [PayrollController::class, 'showUserPayroll'])->middleware(['auth', 'admin'])->name('payroll-admin.show');
Route::get('/admin/payrolls/close', [PayrollController::class, 'closePayroll'])->middleware(['auth', 'admin'])->name('payroll-admin.close');
Route::put('/admin/payrolls/update', [PayrollController::class, 'updatePayroll'])->middleware(['auth', 'admin'])->name('payroll-admin.update');
Route::put('/admin/payrolls/set-incident', [PayrollController::class, 'setIncident'])->middleware(['auth', 'admin'])->name('payroll-admin.set-incident');
Route::put('/admin/payrolls/remove-absent', [PayrollController::class, 'removeAbsent'])->middleware(['auth', 'admin'])->name('payroll-admin.remove-absent');
Route::post('payroll/store-attendance', [PayrollController::class, 'storeAttendance'])->middleware('auth')->name('payroll.store-attendance');
Route::post('payroll/store-extras', [PayrollController::class, 'storeExtras'])->middleware('auth')->name('payroll.store-extras');
Route::get('payroll/get-by-date/{date}', [PayrollController::class, 'getByDate'])->middleware('auth')->name('payroll.get-by-date');


// workpermits --------------------------------------------------------------------------
// --------------------------------------------------------------------------------------
Route::resource('work-permits', WorkPermitController::class)->middleware('auth');


// barters ------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------
Route::resource('barters', BarterController::class)->middleware('auth');


// loans --------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------
Route::resource('loans', LoanController::class)->middleware('auth');
Route::get('/admin-requests/loans', [AdminRequestController::class, 'loans'])->middleware(['auth', 'admin'])->name('admin-requests.loans');
Route::put('/accept/loans/{loan}', [AdminRequestController::class, 'acceptLoan'])->middleware(['auth', 'admin'])->name('loan.accept');
Route::put('/reject/loans/{loan}', [AdminRequestController::class, 'rejectLoan'])->middleware(['auth', 'admin'])->name('loan.reject');


// warehouses ---------------------------------------------------------------------------
// --------------------------------------------------------------------------------------
Route::resource('warehouses', WarehouseController::class)->middleware('auth');



// warehouses movements ---------------------------------------------------------------------------
// --------------------------------------------------------------------------------------
Route::get('warehouses-movements/show-product-record/{product}', [WarehouseMovementController::class, 'showProductRecord'])->middleware('auth')->name('warehouse-movements.show-product-record');
Route::resource('warehouse-movements', WarehouseMovementController::class)->middleware('auth')->except(['show, index, destroy, edit, update']);


// product-request -----------------------------------------------------------------------
// --------------------------------------------------------------------------------------
Route::resource('product-request', ProductRequestController::class)->middleware('auth');
Route::get('product-request-history', [ProductRequestController::class, 'history'])->middleware(['auth', 'admin'])->name('product-request.history');
Route::get('product-request-get-by-page/{currentPage}', [ProductRequestController::class, 'getItemsByPage'])->name('product-request.get-by-page')->middleware('auth');


// consumable-request -----------------------------------------------------------------------
// --------------------------------------------------------------------------------------
Route::resource('consumable-request', ConsumableRequestController::class)->middleware('auth');
Route::get('/consumable-request-history', [ConsumableRequestController::class, 'history'])->middleware(['auth', 'admin'])->name('consumable-request.history');
Route::get('consumable-request-get-by-page/{currentPage}', [ConsumableRequestController::class, 'getItemsByPage'])->name('consumable-request.get-by-page')->middleware('auth');


// sales-to-employees ---------------------------------------------------------------------
// ----------------------------------------------------------------------------------------
Route::resource('sales-to-employees', SaleToEmployeeController::class)->middleware('auth');
Route::post('sales-to-employees/store-special-courtesies', [SaleToEmployeeController::class, 'storeSpecialCourtesies'])->middleware('auth')->name('sales-to-employees.store-special-courtesies');


// carts -----------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------------
Route::get('carts', [CartController::class, 'index'])->middleware('auth')->name('carts.index');
Route::get('cart/remove-products', [CartController::class, 'createRemovedProducts'])->middleware('auth')->name('cart.remove-products');
Route::post('cart/remove-products', [CartController::class, 'removeProducts'])->middleware('auth')->name('cart.store-removed-products');
Route::get('carts-requests-index', [CartController::class, 'requestsIndex'])->middleware('auth')->name('carts.requests-index');


// products ----------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------------
Route::resource('products', ProductController::class)->middleware(['auth', 'admin']);
Route::get('products-search', [ProductController::class, 'searchProduct'])->name('products.search')->middleware('auth');
Route::post('products/update-with-media/{product}', [ProductController::class, 'updateWithMedia'])->name('products.update-with-media')->middleware('auth');
Route::get('products-get-product-scaned/{product_id}', [ProductController::class, 'getProductScaned'])->name('products.get-product-scaned')->middleware('auth');
Route::get('products-get-all-for-indexedDB', [ProductController::class, 'getAllForIndexedDB'])->name('products.get-all-for-indexedDB')->middleware('auth');

// products ----------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------------
Route::resource('consumables', ConsumableController::class)->middleware(['auth', 'admin']);
Route::post('consumables/update-with-media/{consumable}', [ConsumableController::class, 'updateWithMedia'])->name('consumables.update-with-media')->middleware('auth');


// users admin --------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------
Route::resource('users', UserController::class)->middleware(['auth', 'admin']);
Route::get('/admin/christmas-bonus/show/{user}', [UserController::class, 'showUsersCrhismasBonus'])->middleware(['auth', 'admin'])->name('chrismas-bonus.show');
Route::get('/admin/settlement/show/{user}', [UserController::class, 'showUserSettlement'])->middleware(['auth', 'admin'])->name('settlement.show');
Route::get('/admin/liquidation/show/{user}', [UserController::class, 'showUserLiquidation'])->middleware(['auth', 'admin'])->name('liquidation.show');
Route::put('/disable/{user}', [UserController::class, 'disable'])->middleware('auth')->name('user.disable');
Route::put('/enable/{user}', [UserController::class, 'enable'])->middleware('auth')->name('user.enable');
Route::put('/reset-pass/{user}', [UserController::class, 'resetPass'])->middleware('auth')->name('user.reset-pass');
Route::get('/admin/vacation_bonus/show/{user}', [UserController::class, 'showUserVacationBonus'])->middleware(['auth', 'admin'])->name('vacation-bonus.show');
// users routes employee -------------------------------------
Route::post('/users/update-with-resources/{user}', [UserController::class, 'updateWithResources'])->middleware('auth')->name('users.update-with-resources');
Route::post('/users/delete-file', [UserController::class, 'deleteFile'])->middleware('auth')->name('users.delete-file');
Route::post('/users/pay-vacations', [UserController::class, 'payVacations'])->middleware('auth')->name('users.pay-vacations');
Route::get('/users/generate-payroll/{user_id}', [UserController::class, 'generatePayroll'])->middleware('auth')->name('users.generate-payroll');
Route::get('/users-get-employees-in-station', [UserController::class, 'getInStation'])->middleware('auth')->name('users.get-in-station');


// sales ------------------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------------------------------
Route::resource('sales', SaleController::class)->middleware(['auth']);
Route::post('sales/get-by-date', [SaleController::class, 'getByDate'])->middleware('auth')->name('sales.get-sales-by-date');
Route::get('sales-point', [SaleController::class, 'pointIndex'])->middleware('auth')->name('sales.point');
Route::post('sales/get-month-sale', [SaleController::class, 'getMonthSale'])->middleware('auth')->name('sales.get-month-sale');
Route::post('sales-sync-localstorage', [SaleController::class, 'syncLocalstorage'])->middleware('auth')->name('sales.sync-localstorage');
//Imprimir ventas por fecha
Route::get('sales-print', [SaleController::class, 'printSales'])->middleware('auth')->name('sales.print');


// settings ----------------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------------------------
Route::resource('settings', SettingController::class)->middleware(['auth', 'admin']);


// bonuses ------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------
Route::resource('bonuses', BonusController::class)->middleware(['auth', 'admin']);
Route::put('bonus/toggle-status/{bonus}', [BonusController::class, 'toggleStatus'])->middleware(['auth', 'admin'])->name('bonuses.toggle-status');


// outcomes -----------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------
Route::resource('outcomes', OutcomeController::class)->middleware(['auth', 'victor']);
//Specific-action routes
Route::post('/filter-outcomes', [OutcomeController::class, 'filter'])->middleware('auth')->name('outcomes.filter');
//Imprimir egresos por fecha
Route::get('outcomes-print', [OutcomeController::class, 'printOutcomes'])->middleware('auth')->name('outcomes.print');

Route::get('/admin-requests/permits', [AdminRequestController::class, 'permits'])->middleware(['auth', 'admin'])->name('admin-requests.permits');
Route::put('/accept/work-permit/{work_permit}', [AdminRequestController::class, 'acceptWorkPermit'])->middleware(['auth', 'admin'])->name('work-permit.accept');
Route::put('/reject/work-permit/{work_permit}', [AdminRequestController::class, 'rejectWorkPermit'])->middleware(['auth', 'admin'])->name('work-permit.reject');
Route::resource('notices', NoticeController::class)->middleware(['auth', 'admin']);


Route::post('/cash-register', function (Request $request) {
    CashRegister::create([
        'cash' => $request->cash,
        'date' => $request->date
    ]);

    return response()->json(['status' => 'ok']);
})
    ->middleware('auth')
    ->name('cash-register.store');

Route::post('/cash-register/update', function (Request $request) {
    CashRegister::where('date', $request->date)
        ->update(['cash' => $request->cash]);

    return response()->json(['status' => 'ok']);
})->middleware('auth')->name('cash-register.update');

// Justifications routes -----------------------
Route::resource('justifications', JustificationEventController::class);

// Route::get('/paty-nominas', function (Request $request) {
//     $payrolls = PayrollUserResource::collection(PayrollUser::with('payroll', 'user')->whereIn('id', [289,294,300,307,313])->get());
//     // return $payrolls;
//     return inertia('PayRoll/Admin/Template3', compact('payrolls'));
// })
//     ->middleware('auth')
//     ->name('cash-register.update');