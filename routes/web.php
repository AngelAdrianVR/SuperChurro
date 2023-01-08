<?php

use App\Http\Controllers\BarterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\WorkPermitController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

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
Route::resource('payrolls', PayrollController::class);
Route::resource('work-permits', WorkPermitController::class);
Route::resource('barters', BarterController::class);
Route::resource('loans', LoanController::class);
Route::resource('users', UserController::class);
Route::resource('sales', SaleController::class);
Route::resource('carts', CartController::class);
Route::resource('warehouses', WarehouseController::class);

