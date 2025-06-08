@extends('layouts.app')

@section('title', 'Dashboard - IT Management System')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Overview of your IT infrastructure')

@section('content')
<div class="row">
    <!-- Inventory Stats -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card animate-fade-in shadow-lg" style="animation-delay: 0.1s;">
            <div class="card-body p-4 position-relative">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="text-white text-uppercase small mb-2 fw-semibold" style="opacity: 0.9; letter-spacing: 0.5px;">Total Inventory</h6>
                        <h2 class="text-white fw-bold mb-0" style="font-size: 2.5rem;">{{ $inventoryStats['total'] ?? 0 }}</h2>
                    </div>
                    <div class="icon-box" style="background: rgba(255,255,255,0.25); width: 60px; height: 60px; border-radius: 15px;">
                        <i class="fas fa-boxes text-white" style="font-size: 24px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card-success animate-fade-in shadow-lg" style="animation-delay: 0.2s;">
            <div class="card-body p-4 position-relative">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="text-white text-uppercase small mb-2 fw-semibold" style="opacity: 0.9; letter-spacing: 0.5px;">Available Items</h6>
                        <h2 class="text-white fw-bold mb-0" style="font-size: 2.5rem;">{{ $inventoryStats['available'] ?? 0 }}</h2>
                    </div>
                    <div class="icon-box" style="background: rgba(255,255,255,0.25); width: 60px; height: 60px; border-radius: 15px;">
                        <i class="fas fa-check-circle text-white" style="font-size: 24px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card-info animate-fade-in shadow-lg" style="animation-delay: 0.3s;">
            <div class="card-body p-4 position-relative">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="text-white text-uppercase small mb-2 fw-semibold" style="opacity: 0.9; letter-spacing: 0.5px;">In Use</h6>
                        <h2 class="text-white fw-bold mb-0" style="font-size: 2.5rem;">{{ $inventoryStats['in_use'] ?? 0 }}</h2>
                    </div>
                    <div class="icon-box" style="background: rgba(255,255,255,0.25); width: 60px; height: 60px; border-radius: 15px;">
                        <i class="fas fa-user-check text-white" style="font-size: 24px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card-warning animate-fade-in shadow-lg" style="animation-delay: 0.4s;">
            <div class="card-body p-4 position-relative">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="text-white text-uppercase small mb-2 fw-semibold" style="opacity: 0.9; letter-spacing: 0.5px;">Maintenance</h6>
                        <h2 class="text-white fw-bold mb-0" style="font-size: 2.5rem;">{{ $inventoryStats['maintenance'] ?? 0 }}</h2>
                    </div>
                    <div class="icon-box" style="background: rgba(255,255,255,0.25); width: 60px; height: 60px; border-radius: 15px;">
                        <i class="fas fa-tools text-white" style="font-size: 24px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- IP Address Stats -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card animate-fade-in shadow-lg" style="animation-delay: 0.5s;">
            <div class="card-body p-4 position-relative">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="text-white text-uppercase small mb-2 fw-semibold" style="opacity: 0.9; letter-spacing: 0.5px;">Total IP Addresses</h6>
                        <h2 class="text-white fw-bold mb-0" style="font-size: 2.5rem;">{{ $ipStats['total'] ?? 0 }}</h2>
                    </div>
                    <div class="icon-box" style="background: rgba(255,255,255,0.25); width: 60px; height: 60px; border-radius: 15px;">
                        <i class="fas fa-network-wired text-white" style="font-size: 24px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card-success animate-fade-in shadow-lg" style="animation-delay: 0.6s;">
            <div class="card-body p-4 position-relative">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="text-white text-uppercase small mb-2 fw-semibold" style="opacity: 0.9; letter-spacing: 0.5px;">Available IPs</h6>
                        <h2 class="text-white fw-bold mb-0" style="font-size: 2.5rem;">{{ $ipStats['available'] ?? 0 }}</h2>
                    </div>
                    <div class="icon-box" style="background: rgba(255,255,255,0.25); width: 60px; height: 60px; border-radius: 15px;">
                        <i class="fas fa-circle text-white" style="font-size: 24px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card-info animate-fade-in shadow-lg" style="animation-delay: 0.7s;">
            <div class="card-body p-4 position-relative">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="text-white text-uppercase small mb-2 fw-semibold" style="opacity: 0.9; letter-spacing: 0.5px;">Assigned IPs</h6>
                        <h2 class="text-white fw-bold mb-0" style="font-size: 2.5rem;">{{ $ipStats['assigned'] ?? 0 }}</h2>
                    </div>
                    <div class="icon-box" style="background: rgba(255,255,255,0.25); width: 60px; height: 60px; border-radius: 15px;">
                        <i class="fas fa-dot-circle text-white" style="font-size: 24px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card-warning animate-fade-in shadow-lg" style="animation-delay: 0.8s;">
            <div class="card-body p-4 position-relative">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="text-white text-uppercase small mb-2 fw-semibold" style="opacity: 0.9; letter-spacing: 0.5px;">Reserved IPs</h6>
                        <h2 class="text-white fw-bold mb-0" style="font-size: 2.5rem;">{{ $ipStats['reserved'] ?? 0 }}</h2>
                    </div>
                    <div class="icon-box" style="background: rgba(255,255,255,0.25); width: 60px; height: 60px; border-radius: 15px;">
                        <i class="fas fa-lock text-white" style="font-size: 24px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card animate-fade-in shadow-lg border-0" style="animation-delay: 0.9s;">
            <div class="card-header text-white border-0" style="background: var(--primary-gradient); border-radius: 20px 20px 0 0;">
                <h5 class="card-title mb-0 fw-bold d-flex align-items-center">
                    <div class="icon-box me-3" style="background: rgba(255,255,255,0.2); width: 40px; height: 40px; font-size: 16px;">
                        <i class="fas fa-clock text-white"></i>
                    </div>
                    Recent Inventory Items
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background: var(--bg-secondary);">
                            <tr>
                                <th class="fw-semibold border-0 py-3" style="color: var(--text-primary);">Name</th>
                                <th class="fw-semibold border-0 py-3" style="color: var(--text-primary);">Category</th>
                                <th class="fw-semibold border-0 py-3" style="color: var(--text-primary);">Status</th>
                                <th class="fw-semibold border-0 py-3" style="color: var(--text-primary);">Added</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentItems ?? [] as $item)
                                <tr style="border-bottom: 1px solid var(--border-color);">
                                    <td style="padding: 15px 12px; border: none;">
                                        <div>
                                            <strong style="color: var(--text-primary);">{{ $item->name }}</strong>
                                            @if($item->brand)
                                                <br><small style="color: var(--text-secondary);">{{ $item->brand }} {{ $item->model }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td style="padding: 15px 12px; border: none;">
                                        <span class="badge bg-primary px-3 py-2" style="border-radius: 50px; font-size: 0.75rem;">
                                            {{ $item->category->name }}
                                        </span>
                                    </td>
                                    <td style="padding: 15px 12px; border: none;">
                                        @php
                                            $statusConfig = [
                                                'available' => ['bg-success', 'Available'],
                                                'in_use' => ['bg-primary', 'In Use'],
                                                'maintenance' => ['bg-warning', 'Maintenance'],
                                                'retired' => ['bg-danger', 'Retired']
                                            ];
                                            $config = $statusConfig[$item->status] ?? ['bg-secondary', 'Unknown'];
                                        @endphp
                                        <span class="badge {{ $config[0] }} px-3 py-2" style="border-radius: 50px; font-size: 0.75rem;">
                                            {{ $config[1] }}
                                        </span>
                                    </td>
                                    <td style="padding: 15px 12px; border: none; color: var(--text-secondary);">
                                        {{ $item->created_at->diffForHumans() }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5" style="border: none; color: var(--text-secondary);">
                                        <div class="mb-3">
                                            <i class="fas fa-inbox" style="font-size: 3rem; opacity: 0.3;"></i>
                                        </div>
                                        <p class="mb-0">No recent items found</p>
                                        <small>Start by adding your first inventory item</small>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card animate-fade-in shadow-lg border-0" style="animation-delay: 1s;">
            <div class="card-header text-white border-0" style="background: var(--success-gradient); border-radius: 20px 20px 0 0;">
                <h5 class="card-title mb-0 fw-bold d-flex align-items-center">
                    <div class="icon-box me-3" style="background: rgba(255,255,255,0.2); width: 40px; height: 40px; font-size: 16px;">
                        <i class="fas fa-tools text-white"></i>
                    </div>
                    Quick Tools
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="d-flex flex-column gap-3">
                    <a href="{{ route('tools.ping') }}" class="btn btn-outline-primary shadow-sm" style="border-radius: 15px; padding: 12px 20px; border-width: 2px; transition: all 0.3s ease;">
                        <div class="d-flex align-items-center">
                            <div class="icon-box me-3" style="background: #3b82f6; width: 35px; height: 35px; font-size: 14px;">
                                <i class="fas fa-satellite-dish text-white"></i>
                            </div>
                            <div class="text-start">
                                <div class="fw-semibold" style="color: var(--text-primary);">Ping Tool</div>
                                <small style="color: var(--text-secondary);">Test network connectivity</small>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('tools.traceroute') }}" class="btn btn-outline-info shadow-sm" style="border-radius: 15px; padding: 12px 20px; border-width: 2px; transition: all 0.3s ease;">
                        <div class="d-flex align-items-center">
                            <div class="icon-box me-3" style="background: #06b6d4; width: 35px; height: 35px; font-size: 14px;">
                                <i class="fas fa-route text-white"></i>
                            </div>
                            <div class="text-start">
                                <div class="fw-semibold" style="color: var(--text-primary);">Traceroute</div>
                                <small style="color: var(--text-secondary);">Trace network path</small>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('tools.port-scanner') }}" class="btn btn-outline-warning shadow-sm" style="border-radius: 15px; padding: 12px 20px; border-width: 2px; transition: all 0.3s ease;">
                        <div class="d-flex align-items-center">
                            <div class="icon-box me-3" style="background: #f59e0b; width: 35px; height: 35px; font-size: 14px;">
                                <i class="fas fa-search text-white"></i>
                            </div>
                            <div class="text-start">
                                <div class="fw-semibold" style="color: var(--text-primary);">Port Scanner</div>
                                <small style="color: var(--text-secondary);">Scan open ports</small>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('tools.whois') }}" class="btn btn-outline-success shadow-sm" style="border-radius: 15px; padding: 12px 20px; border-width: 2px; transition: all 0.3s ease;">
                        <div class="d-flex align-items-center">
                            <div class="icon-box me-3" style="background: #10b981; width: 35px; height: 35px; font-size: 14px;">
                                <i class="fas fa-info-circle text-white"></i>
                            </div>
                            <div class="text-start">
                                <div class="fw-semibold" style="color: var(--text-primary);">Whois Lookup</div>
                                <small style="color: var(--text-secondary);">Domain information</small>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Quick Stats Summary -->
        <div class="card animate-fade-in shadow-lg border-0 mt-4" style="animation-delay: 1.2s;">
            <div class="card-header text-white border-0" style="background: var(--info-gradient); border-radius: 20px 20px 0 0;">
                <h6 class="card-title mb-0 fw-bold d-flex align-items-center">
                    <div class="icon-box me-3" style="background: rgba(255,255,255,0.2); width: 35px; height: 35px; font-size: 14px;">
                        <i class="fas fa-chart-pie text-white"></i>
                    </div>
                    Quick Summary
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex justify-content-between align-items-center p-3" style="background: var(--bg-secondary); border-radius: 12px; border: 1px solid var(--border-color);">
                        <span class="fw-medium" style="color: var(--text-primary);">Total Assets</span>
                        <span class="fw-bold" style="color: var(--text-primary); font-size: 1.25rem;">{{ ($inventoryStats['total'] ?? 0) + ($ipStats['total'] ?? 0) }}</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center p-3" style="background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); border-radius: 12px;">
                        <span class="fw-medium" style="color: #065f46;">Available Resources</span>
                        <span class="fw-bold" style="color: #047857; font-size: 1.25rem;">{{ ($inventoryStats['available'] ?? 0) + ($ipStats['available'] ?? 0) }}</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center p-3" style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); border-radius: 12px;">
                        <span class="fw-medium" style="color: #1e3a8a;">In Use / Assigned</span>
                        <span class="fw-bold" style="color: #1d4ed8; font-size: 1.25rem;">{{ ($inventoryStats['in_use'] ?? 0) + ($ipStats['assigned'] ?? 0) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Add hover effects to tool buttons
document.querySelectorAll('.btn-outline-primary, .btn-outline-info, .btn-outline-warning, .btn-outline-success').forEach(btn => {
    btn.addEventListener('mouse enter', function() {
        this.style.transform = 'translateY(-3px)';
        this.style.boxShadow = '0 10px 25px rgba(0,0,0,0.15)';
    });

    btn.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0)';
        this.style.boxShadow = '0 2px 4px rgba(0,0,0,0.1)';
    });
});

// Add pulse animation to stats cards on load
document.addEventListener('DOMContentLoaded', function() {
    const statsCards = document.querySelectorAll('.stats-card, .stats-card-success, .stats-card-info, .stats-card-warning');

    statsCards.forEach((card, index) => {
        setTimeout(() => {
            card.style.transform = 'scale(1.05)';
            setTimeout(() => {
                card.style.transform = 'scale(1)';
            }, 200);
        }, index * 100);
    });
});

// Auto-refresh stats every 30 seconds (optional)
setInterval(function() {
    // You can implement auto-refresh here if needed
    console.log('Stats could be refreshed here');
}, 30000);
</script>

<style>
/* Additional hover effects for stats cards */
.stats-card:hover,
.stats-card-success:hover,
.stats-card-info:hover,
.stats-card-warning:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 25px 50px rgba(0,0,0,0.2);
}

/* Ensure all text is properly visible */
.stats-card .text-white,
.stats-card-success .text-white,
.stats-card-info .text-white,
.stats-card-warning .text-white {
    text-shadow: 0 1px 3px rgba(0,0,0,0.3);
}

/* Icon visibility enhancement */
.icon-box {
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.icon-box:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
}

/* Table row hover effect */
.table tbody tr:hover {
    background-color: var(--border-color);
    transform: translateX(5px);
    transition: all 0.3s ease;
}

/* Button hover enhancements */
.btn-outline-primary:hover { background: #3b82f6; border-color: #3b82f6; color: white; }
.btn-outline-info:hover { background: #06b6d4; border-color: #06b6d4; color: white; }
.btn-outline-warning:hover { background: #f59e0b; border-color: #f59e0b; color: white; }
.btn-outline-success:hover { background: #10b981; border-color: #10b981; color: white; }

/* Dark mode specific adjustments */
[data-theme="dark"] .quick-summary .p-3:first-child {
    background: var(--bg-secondary) !important;
}

[data-theme="dark"] .quick-summary .p-3:not(:first-child) {
    background: var(--bg-secondary) !important;
}

[data-theme="dark"] .quick-summary .p-3:not(:first-child) span {
    color: var(--text-primary) !important;
}
</style>
@endpush
