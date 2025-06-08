<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\IpAddressController;
use App\Http\Controllers\NetworkToolsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('inventory', InventoryController::class);
// Inventory Tools
Route::resource('ip-addresses', IpAddressController::class);

// Network Tools Routes
Route::prefix('tools')->name('tools.')->group(function () {
    Route::get('/ping', [NetworkToolsController::class, 'ping'])->name('ping');
    Route::post('/ping', [NetworkToolsController::class, 'executePing'])->name('ping.execute');

    Route::get('/traceroute', [NetworkToolsController::class, 'traceroute'])->name('traceroute');
    Route::post('/traceroute', [NetworkToolsController::class, 'executeTraceroute'])->name('traceroute.execute');

    Route::get('/port-scanner', [NetworkToolsController::class, 'portScanner'])->name('port-scanner');
    Route::post('/port-scanner', [NetworkToolsController::class, 'executePortScan'])->name('port-scanner.execute');

    Route::get('/whois', [NetworkToolsController::class, 'whois'])->name('whois');
    Route::post('/whois', [NetworkToolsController::class, 'executeWhois'])->name('whois.execute');
});
