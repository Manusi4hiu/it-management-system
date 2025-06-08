<?php

namespace App\Http\Controllers;

use App\Models\IpAddress;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class IpAddressController extends Controller
{
    public function index(Request $request): View
    {
        $query = IpAddress::query();

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('ip_address', 'like', "%{$search}%")
                  ->orWhere('device_name', 'like', "%{$search}%")
                  ->orWhere('assigned_to', 'like', "%{$search}%")
                  ->orWhere('mac_address', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        if ($request->filled('type')) {
            $query->where('type', $request->get('type'));
        }

        $ipAddresses = $query->paginate(15);

        return view('ip-addresses.index', compact('ipAddresses'));
    }

    public function create(): View
    {
        return view('ip-addresses.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ip_address' => 'required|ip|unique:ip_addresses',
            'subnet_mask' => 'required|ip',
            'gateway' => 'nullable|ip',
            'dns_primary' => 'nullable|ip',
            'dns_secondary' => 'nullable|ip',
            'type' => 'required|in:static,dhcp,reserved',
            'status' => 'required|in:available,assigned,reserved',
            'assigned_to' => 'nullable|string|max:255',
            'device_name' => 'nullable|string|max:255',
            'mac_address' => 'nullable|string|max:17',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        IpAddress::create($validated);

        return redirect()->route('ip-addresses.index')
            ->with('success', 'IP Address berhasil ditambahkan.');
    }

    public function show(IpAddress $ipAddress): View
    {
        return view('ip-addresses.show', compact('ipAddress'));
    }

    public function edit(IpAddress $ipAddress): View
    {
        return view('ip-addresses.edit', compact('ipAddress'));
    }

    public function update(Request $request, IpAddress $ipAddress): RedirectResponse
    {
        $validated = $request->validate([
            'ip_address' => 'required|ip|unique:ip_addresses,ip_address,' . $ipAddress->id,
            'subnet_mask' => 'required|ip',
            'gateway' => 'nullable|ip',
            'dns_primary' => 'nullable|ip',
            'dns_secondary' => 'nullable|ip',
            'type' => 'required|in:static,dhcp,reserved',
            'status' => 'required|in:available,assigned,reserved',
            'assigned_to' => 'nullable|string|max:255',
            'device_name' => 'nullable|string|max:255',
            'mac_address' => 'nullable|string|max:17',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $ipAddress->update($validated);

        return redirect()->route('ip-addresses.index')
            ->with('success', 'IP Address berhasil diupdate.');
    }

    public function destroy(IpAddress $ipAddress): RedirectResponse
    {
        $ipAddress->delete();

        return redirect()->route('ip-addresses.index')
            ->with('success', 'IP Address berhasil dihapus.');
    }
}
