<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class InventoryController extends Controller
{
    public function index(Request $request): View
    {
        $query = InventoryItem::with('category');

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('serial_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->get('category'));
        }

        $items = $query->paginate(15);
        $categories = Category::all();

        return view('inventory.index', compact('items', 'categories'));
    }

    public function create(): View
    {
        $this->authorize('create-inventory');

        $categories = Category::all();
        return view('inventory.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create-inventory');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255|unique:inventory_items',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:available,in_use,maintenance,retired',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'purchase_price' => 'nullable|numeric|min:0',
            'purchase_date' => 'nullable|date',
            'warranty_expiry' => 'nullable|date',
            'assigned_to' => 'nullable|string|max:255',
        ]);

        InventoryItem::create($validated);

        return redirect()->route('inventory.index')
            ->with('success', 'Item berhasil ditambahkan.');
    }

    public function show(InventoryItem $inventory): View
    {
        $inventory->load('category');
        return view('inventory.show', compact('inventory'));
    }

    public function edit(InventoryItem $inventory): View
    {
        $categories = Category::all();
        return view('inventory.edit', compact('inventory', 'categories'));
    }

    public function update(Request $request, InventoryItem $inventory): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255|unique:inventory_items,serial_number,' . $inventory->id,
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:available,in_use,maintenance,retired',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'purchase_price' => 'nullable|numeric|min:0',
            'purchase_date' => 'nullable|date',
            'warranty_expiry' => 'nullable|date',
            'assigned_to' => 'nullable|string|max:255',
        ]);

        $inventory->update($validated);

        return redirect()->route('inventory.index')
            ->with('success', 'Item berhasil diupdate.');
    }

    public function destroy(InventoryItem $inventory): RedirectResponse
    {
        $inventory->delete();

        return redirect()->route('inventory.index')
            ->with('success', 'Item berhasil dihapus.');
    }
}
