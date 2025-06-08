@extends('layouts.app')

@section('title', 'IP Address Management')
@section('page-title', 'IP Address Management')
@section('page-subtitle', 'Manage and monitor your network IP addresses')

@section('page-actions')
<a href="{{ route('ip-addresses.create') }}" class="btn btn-gradient shadow-lg">
    <i class="fas fa-plus me-2"></i>Add New IP
</a>
@endsection

@section('content')
<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stats-card animate-fade-in shadow-lg" style="animation-delay: 0.1s;">
            <div class="card-body p-4 position-relative">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="text-white text-uppercase small mb-2 fw-semibold" style="opacity: 0.9; letter-spacing: 0.5px;">Total IPs</h6>
                        <h2 class="text-white fw-bold mb-0" style="font-size: 2.5rem;">{{ $ipAddresses->total() }}</h2>
                    </div>
                    <div class="icon-box" style="background: rgba(255,255,255,0.25); width: 60px; height: 60px; border-radius: 15px;">
                        <i class="fas fa-network-wired text-white" style="font-size: 24px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stats-card-success animate-fade-in shadow-lg" style="animation-delay: 0.2s;">
            <div class="card-body p-4 position-relative">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="text-white text-uppercase small mb-2 fw-semibold" style="opacity: 0.9; letter-spacing: 0.5px;">Available</h6>
                        <h2 class="text-white fw-bold mb-0" style="font-size: 2.5rem;">{{ $ipAddresses->where('status', 'available')->count() }}</h2>
                    </div>
                    <div class="icon-box" style="background: rgba(255,255,255,0.25); width: 60px; height: 60px; border-radius: 15px;">
                        <i class="fas fa-circle text-white" style="font-size: 24px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stats-card-info animate-fade-in shadow-lg" style="animation-delay: 0.3s;">
            <div class="card-body p-4 position-relative">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="text-white text-uppercase small mb-2 fw-semibold" style="opacity: 0.9; letter-spacing: 0.5px;">Assigned</h6>
                        <h2 class="text-white fw-bold mb-0" style="font-size: 2.5rem;">{{ $ipAddresses->where('status', 'assigned')->count() }}</h2>
                    </div>
                    <div class="icon-box" style="background: rgba(255,255,255,0.25); width: 60px; height: 60px; border-radius: 15px;">
                        <i class="fas fa-dot-circle text-white" style="font-size: 24px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stats-card-warning animate-fade-in shadow-lg" style="animation-delay: 0.4s;">
            <div class="card-body p-4 position-relative">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="text-white text-uppercase small mb-2 fw-semibold" style="opacity: 0.9; letter-spacing: 0.5px;">Reserved</h6>
                        <h2 class="text-white fw-bold mb-0" style="font-size: 2.5rem;">{{ $ipAddresses->where('status', 'reserved')->count() }}</h2>
                    </div>
                    <div class="icon-box" style="background: rgba(255,255,255,0.25); width: 60px; height: 60px; border-radius: 15px;">
                        <i class="fas fa-lock text-white" style="font-size: 24px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Card -->
<div class="card filter-card mb-4 animate-fade-in shadow-lg border-0" style="animation-delay: 0.5s;">
    <div class="card-header bg-white border-0 pb-0">
        <h6 class="card-title mb-0 fw-bold d-flex align-items-center" style="color: var(--text-primary);">
            <div class="icon-box me-3" style="background: var(--primary-gradient); width: 35px; height: 35px; font-size: 14px;">
                <i class="fas fa-filter text-white"></i>
            </div>
            Filter & Search IP Addresses
        </h6>
    </div>
    <div class="card-body p-4">
        <form method="GET" action="{{ route('ip-addresses.index') }}">
            <div class="row g-4 align-items-end">
                <!-- Search Input -->
                <div class="col-lg-4 col-md-12">
                    <label class="form-label fw-semibold mb-2" style="color: var(--text-primary); font-size: 0.875rem;">Search IP Addresses</label>
                    <div class="position-relative">
                        <input type="text" name="search" class="form-control search-box border-0 shadow-sm ps-5"
                               style="border-radius: 15px; padding: 12px 20px 12px 45px;"
                               placeholder="Search by IP, device name, or assigned to..."
                               value="{{ request('search') }}">
                        <div class="position-absolute top-50 start-0 translate-middle-y ps-3">
                            <i class="fas fa-search" style="color: #9ca3af;"></i>
                        </div>
                    </div>
                </div>

                <!-- Status Filter -->
                <div class="col-lg-2 col-md-4">
                    <label class="form-label fw-semibold mb-2" style="color: var(--text-primary); font-size: 0.875rem;">Status</label>
                    <select name="status" class="form-select search-box border-0 shadow-sm" style="border-radius: 15px; padding: 12px 16px;">
                        <option value="">All Status</option>
                        <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>
                            🟢 Available
                        </option>
                        <option value="assigned" {{ request('status') === 'assigned' ? 'selected' : '' }}>
                            🔵 Assigned
                        </option>
                        <option value="reserved" {{ request('status') === 'reserved' ? 'selected' : '' }}>
                            🟡 Reserved
                        </option>
                    </select>
                </div>

                <!-- Type Filter -->
                <div class="col-lg-2 col-md-4">
                    <label class="form-label fw-semibold mb-2" style="color: var(--text-primary); font-size: 0.875rem;">Type</label>
                    <select name="type" class="form-select search-box border-0 shadow-sm" style="border-radius: 15px; padding: 12px 16px;">
                        <option value="">All Types</option>
                        <option value="static" {{ request('type') === 'static' ? 'selected' : '' }}>
                            📌 Static
                        </option>
                        <option value="dhcp" {{ request('type') === 'dhcp' ? 'selected' : '' }}>
                            🔄 DHCP
                        </option>
                        <option value="reserved" {{ request('type') === 'reserved' ? 'selected' : '' }}>
                            🔒 Reserved
                        </option>
                    </select>
                </div>

                <!-- Subnet Filter -->
                <div class="col-lg-2 col-md-4">
                    <label class="form-label fw-semibold mb-2" style="color: var(--text-primary); font-size: 0.875rem;">Subnet</label>
                    <select name="subnet" class="form-select search-box border-0 shadow-sm" style="border-radius: 15px; padding: 12px 16px;">
                        <option value="">All Subnets</option>
                        @php
                            $subnets = $ipAddresses->pluck('ip_address')->map(function($ip) {
                                return implode('.', array_slice(explode('.', $ip), 0, 3)) . '.0';
                            })->unique()->sort();
                        @endphp
                        @foreach($subnets as $subnet)
                            <option value="{{ $subnet }}" {{ request('subnet') === $subnet ? 'selected' : '' }}>
                                {{ $subnet }}/24
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="col-lg-2 col-md-12">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-gradient shadow-sm flex-fill" style="border-radius: 15px; padding: 12px; font-weight: 600;">
                            <i class="fas fa-search me-1"></i>
                            <span class="d-none d-sm-inline">Search</span>
                        </button>
                        <a href="{{ route('ip-addresses.index') }}" class="btn btn-outline-secondary shadow-sm" style="border-radius: 15px; padding: 12px; border-width: 2px;" title="Clear Filters">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Filter Buttons -->
            <div class="row mt-3">
                <div class="col-12">
                    <div class="d-flex flex-wrap gap-2">
                        <small class="text-muted fw-semibold me-2 align-self-center">Quick Filters:</small>
                        <a href="{{ route('ip-addresses.index', ['status' => 'available']) }}"
                           class="btn btn-sm btn-outline-success {{ request('status') === 'available' ? 'active' : '' }}"
                           style="border-radius: 50px; font-size: 0.75rem;">
                            Available IPs
                        </a>
                        <a href="{{ route('ip-addresses.index', ['status' => 'assigned']) }}"
                           class="btn btn-sm btn-outline-primary {{ request('status') === 'assigned' ? 'active' : '' }}"
                           style="border-radius: 50px; font-size: 0.75rem;">
                            Assigned
                        </a>
                        <a href="{{ route('ip-addresses.index', ['type' => 'static']) }}"
                           class="btn btn-sm btn-outline-info {{ request('type') === 'static' ? 'active' : '' }}"
                           style="border-radius: 50px; font-size: 0.75rem;">
                            Static IPs
                        </a>
                        @if(request()->hasAny(['search', 'status', 'type', 'subnet']))
                            <a href="{{ route('ip-addresses.index') }}"
                               class="btn btn-sm btn-outline-danger"
                               style="border-radius: 50px; font-size: 0.75rem;">
                                <i class="fas fa-times me-1"></i>Clear All
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- IP Addresses Grid -->
<div class="row" id="ip-grid">
    @forelse($ipAddresses as $index => $ip)
        <div class="col-xl-4 col-lg-6 mb-4 animate-fade-in" style="animation-delay: {{ 0.1 * ($index % 6) }}s;">
            <div class="card inventory-card h-100 shadow-lg border-0">
                <div class="card-body p-4">
                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="flex-grow-1">
                            <h5 class="card-title fw-bold mb-1" style="color: var(--text-primary); font-family: 'Courier New', monospace;">
                                {{ $ip->ip_address }}
                            </h5>
                            <p class="text-muted small mb-0">
                                {{ $ip->subnet_mask }}
                                @if($ip->gateway)
                                    • GW: {{ $ip->gateway }}
                                @endif
                            </p>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-link text-muted p-1" type="button" data-bs-toggle="dropdown" style="border-radius: 8px;">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="border-radius: 15px;">
                                <li><a class="dropdown-item" href="{{ route('ip-addresses.show', $ip) }}">
                                    <i class="fas fa-eye me-2 text-primary"></i>View Details
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('ip-addresses.edit', $ip) }}">
                                    <i class="fas fa-edit me-2 text-warning"></i>Edit IP
                                </a></li>
                                <li><a class="dropdown-item" href="#" onclick="pingIP('{{ $ip->ip_address }}')">
                                    <i class="fas fa-satellite-dish me-2 text-success"></i>Ping IP
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="#" onclick="deleteIP({{ $ip->id }})">
                                    <i class="fas fa-trash me-2"></i>Delete IP
                                </a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Status & Type Badges -->
                    <div class="mb-3 d-flex gap-2 flex-wrap">
                        @php
                            $statusConfig = [
                                'available' => ['status-available', 'fas fa-circle'],
                                'assigned' => ['status-in-use', 'fas fa-dot-circle'],
                                'reserved' => ['status-maintenance', 'fas fa-lock']
                            ];
                            $typeConfig = [
                                'static' => ['bg-info', 'fas fa-thumbtack'],
                                'dhcp' => ['bg-secondary', 'fas fa-sync-alt'],
                                'reserved' => ['bg-warning', 'fas fa-lock']
                            ];
                            $statusClass = $statusConfig[$ip->status] ?? ['status-available', 'fas fa-question-circle'];
                            $typeClass = $typeConfig[$ip->type] ?? ['bg-secondary', 'fas fa-question-circle'];
                        @endphp
                        <span class="status-badge {{ $statusClass[0] }}">
                            <i class="{{ $statusClass[1] }}"></i>
                            {{ ucfirst($ip->status) }}
                        </span>
                        <span class="badge {{ $typeClass[0] }} px-3 py-2" style="border-radius: 50px; font-size: 0.75rem;">
                            <i class="{{ $typeClass[1] }} me-1"></i>
                            {{ ucfirst($ip->type) }}
                        </span>
                    </div>

                    <!-- Details Grid -->
                    <div class="row g-3 mb-3">
                        @if($ip->device_name)
                        <div class="col-12">
                            <div class="p-3" style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); border-radius: 12px;">
                                <div class="small fw-semibold text-uppercase mb-1" style="color: #1e3a8a; font-size: 0.7rem; letter-spacing: 0.5px;">Device Name</div>
                                <div class="small fw-medium" style="color: #1d4ed8;">
                                    <i class="fas fa-desktop me-1"></i>{{ $ip->device_name }}
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($ip->assigned_to)
                        <div class="col-12">
                            <div class="p-3" style="background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%); border-radius: 12px;">
                                <div class="small fw-semibold text-uppercase mb-1" style="color: #581c87; font-size: 0.7rem; letter-spacing: 0.5px;">Assigned To</div>
                                <div class="small fw-medium" style="color: #7c3aed;">
                                    <i class="fas fa-user me-1"></i>{{ $ip->assigned_to }}
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="col-6">
                            <div class="p-3" style="background: var(--bg-secondary); border-radius: 12px; border: 1px solid var(--border-color);">
                                <div class="small text-muted fw-semibold text-uppercase mb-1" style="font-size: 0.7rem; letter-spacing: 0.5px;">Location</div>
                                <div class="small fw-medium" style="color: var(--text-primary);">{{ $ip->location ?: 'Not specified' }}</div>
                            </div>
                        </div>

                        @if($ip->mac_address)
                        <div class="col-6">
                            <div class="p-3" style="background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); border-radius: 12px;">
                                <div class="small fw-semibold text-uppercase mb-1" style="color: #065f46; font-size: 0.7rem; letter-spacing: 0.5px;">MAC Address</div>
                                <div class="small fw-medium" style="color: #047857; font-family: 'Courier New', monospace; font-size: 0.7rem;">{{ $ip->mac_address }}</div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- DNS Information -->
                    @if($ip->dns_primary || $ip->dns_secondary)
                    <div class="mb-3">
                        <div class="p-3" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border-radius: 12px;">
                            <div class="small fw-semibold text-uppercase mb-2" style="color: #92400e; font-size: 0.7rem; letter-spacing: 0.5px;">DNS Servers</div>
                            <div class="d-flex gap-3">
                                @if($ip->dns_primary)
                                <div class="small" style="color: #d97706;">
                                    <strong>Primary:</strong> {{ $ip->dns_primary }}
                                </div>
                                @endif
                                @if($ip->dns_secondary)
                                <div class="small" style="color: #d97706;">
                                    <strong>Secondary:</strong> {{ $ip->dns_secondary }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Footer -->
                    <div class="d-flex justify-content-between align-items-center pt-3" style="border-top: 1px solid var(--border-color);">
                        <div class="small text-muted">
                            <i class="fas fa-calendar me-1"></i>
                            Added {{ $ip->created_at->diffForHumans() }}
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-outline-success" onclick="pingIP('{{ $ip->ip_address }}')"
                                    style="border-radius: 50px; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;"
                                    title="Ping IP">
                                <i class="fas fa-satellite-dish" style="font-size: 12px;"></i>
                            </button>
                            <a href="{{ route('ip-addresses.show', $ip) }}"
                               class="btn btn-sm btn-outline-primary"
                               style="border-radius: 50px; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;"
                               title="View Details">
                                <i class="fas fa-eye" style="font-size: 12px;"></i>
                            </a>
                            <a href="{{ route('ip-addresses.edit', $ip) }}"
                               class="btn btn-sm btn-outline-warning"
                               style="border-radius: 50px; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;"
                               title="Edit IP">
                                <i class="fas fa-edit" style="font-size: 12px;"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card border-0 shadow">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-network-wired text-muted" style="font-size: 4rem; opacity: 0.5;"></i>
                    </div>
                    <h4 class="text-muted fw-semibold mb-2">No IP Addresses Found</h4>
                    <p class="text-muted mb-4">Start by adding your first IP address to track your network.</p>
                    <a href="{{ route('ip-addresses.create') }}" class="btn btn-gradient">
                        <i class="fas fa-plus me-2"></i>Add First IP
                    </a>
                </div>
            </div>
        </div>
    @endforelse
</div>

<!-- Pagination -->
@if($ipAddresses->hasPages())
    <div class="d-flex justify-content-center mt-5">
        <nav class="shadow" style="background: var(--card-bg); border-radius: 50px; padding: 0.5rem;">
            {{ $ipAddresses->appends(request()->query())->links('pagination::bootstrap-4') }}
        </nav>
    </div>
@endif

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" style="color: var(--text-primary);">
                    <i class="fas fa-exclamation-triangle text-danger me-2"></i>
                    Confirm Delete
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 py-3">
                <p class="mb-0" style="color: var(--text-secondary);">Are you sure you want to delete this IP address? This action cannot be undone and will permanently remove the IP from your network management.</p>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="border-radius: 50px;">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" style="border-radius: 50px;">
                        <i class="fas fa-trash me-2"></i>Delete IP
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Ping Modal -->
<div class="modal fade" id="pingModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" style="color: var(--text-primary);">
                    <i class="fas fa-satellite-dish text-success me-2"></i>
                    Ping Result
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="pingResult">
                    <div class="text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2" style="color: var(--text-primary);">Pinging...</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 50px;">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function deleteIP(id) {
    const form = document.getElementById('deleteForm');
    form.action = `/ip-addresses/${id}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

function pingIP(ipAddress) {
    const modal = new bootstrap.Modal(document.getElementById('pingModal'));
    modal.show();

    // Reset result
    document.getElementById('pingResult').innerHTML = `
        <div class="text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2" style="color: var(--text-primary);">Pinging ${ipAddress}...</p>
        </div>
    `;

    // Make AJAX request to ping
    fetch('/tools/ping', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            host: ipAddress,
            count: 4
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('pingResult').innerHTML = `
                <div class="p-3" style="background: var(--bg-secondary); border-radius: 15px; border: 1px solid var(--border-color);">
                    <pre class="mb-0" style="color: var(--text-primary); font-size: 0.875rem; white-space: pre-wrap;">${data.output}</pre>
                </div>
            `;
        } else {
            document.getElementById('pingResult').innerHTML = `
                <div class="alert alert-danger border-0" style="border-radius: 15px;">
                    <strong>Error:</strong> ${data.error}
                </div>
            `;
        }
    })
    .catch(error => {
        document.getElementById('pingResult').innerHTML = `
            <div class="alert alert-danger border-0" style="border-radius: 15px;">
                <strong>Error:</strong> Failed to ping ${ipAddress}
            </div>
        `;
    });
}

// Add loading animation to search
document.querySelector('form').addEventListener('submit', function() {
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalContent = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    submitBtn.disabled = true;

    setTimeout(() => {
        submitBtn.innerHTML = originalContent;
        submitBtn.disabled = false;
    }, 2000);
});

// Auto-submit form on select change
document.querySelectorAll('select[name="status"], select[name="type"], select[name="subnet"]').forEach(select => {
    select.addEventListener('change', function() {
        this.closest('form').submit();
    });
});

// Add hover effect to cards
document.querySelectorAll('.inventory-card').forEach(card => {
    card.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-8px)';
    });

    card.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0)';
    });
});

// Copy IP address to clipboard on click
document.querySelectorAll('.card-title').forEach(title => {
    title.addEventListener('click', function() {
        const ip = this.textContent.trim();
        navigator.clipboard.writeText(ip).then(() => {
            // Show toast notification
            const toast = document.createElement('div');
            toast.className = 'position-fixed top-0 end-0 p-3';
            toast.style.zIndex = '1100';
            toast.innerHTML = `
                <div class="toast show" role="alert">
                    <div class="toast-header">
                        <i class="fas fa-copy text-success me-2"></i>
                        <strong class="me-auto">Copied!</strong>
                    </div>
                    <div class="toast-body">
                        IP address ${ip} copied to clipboard
                    </div>
                </div>
            `;
            document.body.appendChild(toast);

            setTimeout(() => {
                document.body.removeChild(toast);
            }, 3000);
        });
    });

    title.style.cursor = 'pointer';
    title.title = 'Click to copy IP address';
});
</script>
@endpush
