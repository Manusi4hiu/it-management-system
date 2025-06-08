<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\IpAddress;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $inventoryStats = [
            'total' => InventoryItem::count(),
            'available' => InventoryItem::where('status', 'available')->count(),
            'in_use' => InventoryItem::where('status', 'in_use')->count(),
            'maintenance' => InventoryItem::where('status', 'maintenance')->count(),
        ];

        $ipStats = [
            'total' => IpAddress::count(),
            'available' => IpAddress::where('status', 'available')->count(),
            'assigned' => IpAddress::where('status', 'assigned')->count(),
            'reserved' => IpAddress::where('status', 'reserved')->count(),
        ];

        $recentItems = InventoryItem::with('category')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('inventoryStats', 'ipStats', 'recentItems'));
    }
}
