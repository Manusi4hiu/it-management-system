<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\IpAddressController;
use App\Http\Controllers\NetworkToolsController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes - Require Authentication
Route::middleware(['auth'])->group(function () {

    // Dashboard Route
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Inventory Management Routes - Admin Only
    Route::middleware(['role:admin'])->prefix('inventory')->name('inventory.')->controller(InventoryController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{inventory}', 'show')->name('show');
        Route::get('/{inventory}/edit', 'edit')->name('edit');
        Route::put('/{inventory}', 'update')->name('update');
        Route::patch('/{inventory}', 'update');
        Route::delete('/{inventory}', 'destroy')->name('destroy');
    });

    // IP Address Management Routes - Admin Only
    Route::middleware(['role:admin'])->prefix('ip-addresses')->name('ip-addresses.')->controller(IpAddressController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{ip_address}', 'show')->name('show');
        Route::get('/{ip_address}/edit', 'edit')->name('edit');
        Route::put('/{ip_address}', 'update')->name('update');
        Route::patch('/{ip_address}', 'update');
        Route::delete('/{ip_address}', 'destroy')->name('destroy');
    });

    // Network Tools Routes - Available for all authenticated users
    Route::prefix('tools')->name('tools.')->controller(NetworkToolsController::class)->group(function () {
        Route::get('/ping', 'ping')->name('ping');
        Route::post('/ping', 'executePing')->name('ping.execute');
        Route::get('/traceroute', 'traceroute')->name('traceroute');
        Route::post('/traceroute', 'executeTraceroute')->name('traceroute.execute');
        Route::get('/port-scanner', 'portScanner')->name('port-scanner');
        Route::post('/port-scanner', 'executePortScan')->name('port-scanner.execute');
        Route::get('/whois', 'whois')->name('whois');
        Route::post('/whois', 'executeWhois')->name('whois.execute');
        Route::get('/random-port-generator', 'randomPortGenerator')->name('random-port-generator');
        Route::get('/bcrypt-generator', 'bcryptGenerator')->name('bcrypt-generator');
        Route::post('/bcrypt/hash', 'handleBcryptHash')->name('bcrypt.hash');
        Route::post('/bcrypt/compare', 'handleBcryptCompare')->name('bcrypt.compare');
        Route::get('/integer-base-converter', 'integerBaseConverter')->name('integer-base-converter');
    });
});
