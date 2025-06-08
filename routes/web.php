<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\IpAddressController;
use App\Http\Controllers\NetworkToolsController;
use Illuminate\Support\Facades\Route;

// Dashboard Route
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Inventory Management Routes
// Mengganti Route::resource('inventory', InventoryController::class)
Route::prefix('inventory')->name('inventory.')->controller(InventoryController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/', 'store')->name('store');
    Route::get('/{inventory}', 'show')->name('show');
    Route::get('/{inventory}/edit', 'edit')->name('edit');
    Route::put('/{inventory}', 'update')->name('update');
    Route::patch('/{inventory}', 'update');
    Route::delete('/{inventory}', 'destroy')->name('destroy');
});

// IP Address Management Routes
// Mengganti Route::resource('ip-addresses', IpAddressController::class)
Route::prefix('ip-addresses')->name('ip-addresses.')->controller(IpAddressController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/', 'store')->name('store');
    Route::get('/{ip_address}', 'show')->name('show');
    Route::get('/{ip_address}/edit', 'edit')->name('edit');
    Route::put('/{ip_address}', 'update')->name('update');
    Route::patch('/{ip_address}', 'update');
    Route::delete('/{ip_address}', 'destroy')->name('destroy');
});

// Network Tools Routes (Sudah dalam bentuk group, jadi hanya perlu memastikan konsistensi)
Route::prefix('tools')->name('tools.')->controller(NetworkToolsController::class)->group(function () {
    Route::get('/ping', 'ping')->name('ping');
    Route::post('/ping', 'executePing')->name('ping.execute');

    Route::get('/traceroute', 'traceroute')->name('traceroute');
    Route::post('/traceroute', 'executeTraceroute')->name('traceroute.execute');

    Route::get('/port-scanner', 'portScanner')->name('port-scanner');
    Route::post('/port-scanner', 'executePortScan')->name('port-scanner.execute');

    Route::get('/whois', 'whois')->name('whois');
    Route::post('/whois', 'executeWhois')->name('whois.execute');
});
