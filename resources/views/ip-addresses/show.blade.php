@extends('layouts.app')

@section('title', $ipAddress->ip_address . ' - IP Address')
@section('page-title', $ipAddress->ip_address)
@section('page-subtitle', $ipAddress->device_name ?: 'Network IP Address Details')

@section('page-actions')
<div class="d-flex gap-2">
    <button onclick="pingIP('{{ $ipAddress->ip_address }}')" class="btn btn-success" style="border-radius: 50px;">
        <i class="fas fa-satellite-dish me-2"></i>Ping
    </button>
    <a href="{{ route('ip-addresses.edit', $ipAddress) }}" class="btn btn-gradient" style="border-radius: 50px;">
        <i class="fas fa-edit me-2"></i>Edit IP
    </a>
    <div class="dropdown">
        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" style="border-radius: 50px;">
            <i class="fas fa-cog me-2"></i>Actions
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="border-radius: 15px;">
            <li><a class="dropdown-item" href="#" onclick="tracerouteIP('{{ $ipAddress->ip_address }}')">
                <i class="fas fa-route me-2 text-info"></i>Traceroute
            </a></li>
            <li><a class="dropdown-item" href="{{ route('tools.port-scanner') }}?host={{ $ipAddress->ip_address }}">
                <i class="fas fa-search me-2 text-warning"></i>Port Scan
            </a></li>
            <li><a class="dropdown-item" href="#" onclick="copyToClipboard('{{ $ipAddress->ip_address }}')">
                <i class="fas fa-copy me-2 text-primary"></i>Copy IP
            </a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="#" onclick="deleteIP()">
                <i class="fas fa-trash me-2"></i>Delete IP
            </a></li>
        </ul>
    </div>
    <a href="{{ route('ip-addresses.index') }}" class="btn btn-outline-secondary" style="border-radius: 50px;">
        <i class="fas fa-arrow-left me-2"></i>Back
    </a>
</div>
@endsection

@section('content')
<div class="row">
    <!-- Main Content -->
    <div class="col-lg-8">
        <!-- IP Overview Card -->
        <div class="card animate-fade-in shadow-lg border-0 mb-4">
            <div class="card-header text-white border-0" style="background: var(--info-gradient); border-radius: 20px 20px 0 0;">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="icon-box me-4" style="background: rgba(255,255,255,0.2); width: 60px; height: 60px; font-size: 24px;">
                            <i class="fas fa-network-wired text-white"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-1 text-white" style="font-family: 'Courier New', monospace;">{{ $ipAddress->ip_address }}</h4>
                            <p class="text-white mb-0" style="opacity: 0.9;">
                                {{ $ipAddress->subnet_mask }}
                                @if($ipAddress->device_name)
                                    • {{ $ipAddress->device_name }}
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="text-end">
                        @php
                            $statusConfig = [
                                'available' => ['bg-success', 'fas fa-circle'],
                                'assigned' => ['bg-primary', 'fas fa-dot-circle'],
                                'reserved' => ['bg-warning', 'fas fa-lock']
                            ];
                            $config = $statusConfig[$ipAddress->status] ?? ['bg-secondary', 'fas fa-question-circle'];
                        @endphp
                        <div class="badge {{ $config[0] }} px-3 py-2 fs-6">
                            <i class="{{ $config[1] }} me-2"></i>
                            {{ ucfirst($ipAddress->status) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <!-- Network Configuration -->
                    <div class="col-md-6">
                        <div class="h-100 p-4" style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); border-radius: 15px; border: 1px solid #93c5fd;">
                            <h6 class="fw-bold mb-3 d-flex align-items-center" style="color: #1e3a8a;">
                                <i class="fas fa-globe me-2" style="color: #3b82f6;"></i>
                                Network Configuration
                            </h6>
                            <div class="space-y-3">
                                <div class="d-flex justify-content-between py-2">
                                    <span class="fw-medium" style="color: #1e40af;">IP Address:</span>
                                    <code class="px-2 py-1" style="background: #e0f2fe; color: #0c4a6e; border-radius: 6px; font-size: 0.875rem; cursor: pointer;" onclick="copyToClipboard('{{ $ipAddress->ip_address }}')">{{ $ipAddress->ip_address }}</code>
                                </div>
                                <div class="d-flex justify-content-between py-2">
                                    <span class="fw-medium" style="color: #1e40af;">Subnet Mask:</span>
                                    <code class="px-2 py-1" style="background: #e0f2fe; color: #0c4a6e; border-radius: 6px; font-size: 0.875rem;">{{ $ipAddress->subnet_mask }}</code>
                                </div>
                                @if($ipAddress->gateway)
                                <div class="d-flex justify-content-between py-2">
                                    <span class="fw-medium" style="color: #1e40af;">Gateway:</span>
                                    <code class="px-2 py-1" style="background: #e0f2fe; color: #0c4a6e; border-radius: 6px; font-size: 0.875rem;">{{ $ipAddress->gateway }}</code>
                                </div>
                                @endif
                                <div class="d-flex justify-content-between py-2">
                                    <span class="fw-medium" style="color: #1e40af;">Type:</span>
                                    @php
                                        $typeConfig = [
                                            'static' => ['bg-info', 'fas fa-thumbtack', 'Static'],
                                            'dhcp' => ['bg-secondary', 'fas fa-sync-alt', 'DHCP'],
                                            'reserved' => ['bg-warning', 'fas fa-lock', 'Reserved']
                                        ];
                                        $typeClass = $typeConfig[$ipAddress->type] ?? ['bg-secondary', 'fas fa-question-circle', 'Unknown'];
                                    @endphp
                                    <span class="badge {{ $typeClass[0] }} px-3 py-1" style="border-radius: 50px;">
                                        <i class="{{ $typeClass[1] }} me-1"></i>
                                        {{ $typeClass[2] }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Device Information -->
                    <div class="col-md-6">
                        <div class="h-100 p-4" style="background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%); border-radius: 15px; border: 1px solid #c4b5fd;">
                            <h6 class="fw-bold mb-3 d-flex align-items-center" style="color: #581c87;">
                                <i class="fas fa-desktop me-2" style="color: #8b5cf6;"></i>
                                Device Information
                            </h6>
                            <div class="space-y-3">
                                <div class="d-flex justify-content-between py-2">
                                    <span class="fw-medium" style="color: #6b21a8;">Status:</span>
                                    <span class="badge {{ $config[0] }} px-3 py-1" style="border-radius: 50px;">
                                        <i class="{{ $config[1] }} me-1"></i>
                                        {{ ucfirst($ipAddress->status) }}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between py-2">
                                    <span class="fw-medium" style="color: #6b21a8;">Device Name:</span>
                                    <span class="fw-semibold" style="color: #581c87;">
                                        @if($ipAddress->device_name)
                                            <i class="fas fa-desktop me-1"></i>
                                            {{ $ipAddress->device_name }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between py-2">
                                    <span class="fw-medium" style="color: #6b21a8;">Assigned To:</span>
                                    <span class="fw-semibold" style="color: #581c87;">
                                        @if($ipAddress->assigned_to)
                                            <i class="fas fa-user me-1"></i>
                                            {{ $ipAddress->assigned_to }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between py-2">
                                    <span class="fw-medium" style="color: #6b21a8;">Location:</span>
                                    <span class="fw-semibold" style="color: #581c87;">
                                        @if($ipAddress->location)
                                            <i class="fas fa-map-marker-alt me-1"></i>
                                            {{ $ipAddress->location }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- DNS & Network Details -->
        <div class="card animate-fade-in shadow-lg border-0 mb-4" style="animation-delay: 0.2s;">
            <div class="card-header text-white border-0" style="background: var(--success-gradient); border-radius: 20px 20px 0 0;">
                <h5 class="card-title mb-0 fw-bold d-flex align-items-center">
                    <i class="fas fa-server me-2"></i>
                    DNS & Network Details
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="text-center p-4 h-100" style="background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%); border-radius: 15px; border: 1px solid #86efac;">
                            <div class="icon-box mx-auto mb-3" style="background: #10b981; width: 50px; height: 50px; font-size: 20px;">
                                <i class="fas fa-dns text-white"></i>
                            </div>
                            <h6 class="fw-semibold mb-1" style="color: #065f46;">Primary DNS</h6>
                            <h5 class="fw-bold" style="color: #047857; font-family: 'Courier New', monospace;">
                                {{ $ipAddress->dns_primary ?: 'Not configured' }}
                            </h5>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-center p-4 h-100" style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); border-radius: 15px; border: 1px solid #93c5fd;">
                            <div class="icon-box mx-auto mb-3" style="background: #3b82f6; width: 50px; height: 50px; font-size: 20px;">
                                <i class="fas fa-dns text-white"></i>
                            </div>
                            <h6 class="fw-semibold mb-1" style="color: #1e3a8a;">Secondary DNS</h6>
                            <h5 class="fw-bold" style="color: #1d4ed8; font-family: 'Courier New', monospace;">
                                {{ $ipAddress->dns_secondary ?: 'Not configured' }}
                            </h5>
                        </div>
                    </div>
                </div>

                @if($ipAddress->mac_address)
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="p-4" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border-radius: 15px; border: 1px solid #fcd34d;">
                            <div class="d-flex align-items-center">
                                <div class="icon-box me-3" style="background: #f59e0b; width: 50px; height: 50px; font-size: 20px;">
                                    <i class="fas fa-ethernet text-white"></i>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-1" style="color: #92400e;">MAC Address</h6>
                                    <h5 class="fw-bold mb-0" style="color: #d97706; font-family: 'Courier New', monospace; cursor: pointer;" onclick="copyToClipboard('{{ $ipAddress->mac_address }}')">
                                        {{ $ipAddress->mac_address }}
                                        <i class="fas fa-copy ms-2 small"></i>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Notes -->
        @if($ipAddress->notes)
        <div class="card animate-fade-in shadow-lg border-0" style="animation-delay: 0.4s;">
            <div class="card-header text-white border-0" style="background: linear-gradient(135deg, #64748b 0%, #475569 100%); border-radius: 20px 20px 0 0;">
                <h5 class="card-title mb-0 fw-bold d-flex align-items-center">
                    <i class="fas fa-sticky-note me-2"></i>
                    Notes & Documentation
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="p-4" style="background: var(--bg-secondary); border-radius: 15px; border: 1px solid var(--border-color);">
                    <p class="mb-0" style="color: var(--text-primary); line-height: 1.6;">{{ $ipAddress->notes }}</p>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Network Tools -->
        <div class="card animate-slide-in shadow-lg border-0 mb-4" style="animation-delay: 0.1s;">
            <div class="card-header text-white border-0" style="background: var(--warning-gradient); border-radius: 20px 20px 0 0;">
                <h6 class="card-title mb-0 fw-bold d-flex align-items-center">
                    <i class="fas fa-tools me-2"></i>
                    Network Tools
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="d-grid gap-3">
                    <button class="btn btn-success shadow" onclick="pingIP('{{ $ipAddress->ip_address }}')" style="border-radius: 15px;">
                        <i class="fas fa-satellite-dish me-2"></i>Ping IP
                    </button>
                    <button class="btn btn-info shadow" onclick="tracerouteIP('{{ $ipAddress->ip_address }}')" style="border-radius: 15px;">
                        <i class="fas fa-route me-2"></i>Traceroute
                    </button>
                    <a href="{{ route('tools.port-scanner') }}?host={{ $ipAddress->ip_address }}" class="btn btn-warning shadow" style="border-radius: 15px;">
                        <i class="fas fa-search me-2"></i>Port Scan
                    </a>
                    <button class="btn btn-secondary shadow" onclick="copyToClipboard('{{ $ipAddress->ip_address }}')" style="border-radius: 15px;">
                        <i class="fas fa-copy me-2"></i>Copy IP Address
                    </button>
                </div>
            </div>
        </div>

        <!-- Quick Status Actions -->
        <div class="card animate-slide-in shadow-lg border-0 mb-4" style="animation-delay: 0.3s;">
            <div class="card-header text-white border-0" style="background: var(--primary-gradient); border-radius: 20px 20px 0 0;">
                <h6 class="card-title mb-0 fw-bold d-flex align-items-center">
                    <i class="fas fa-bolt me-2"></i>
                    Quick Status Actions
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="d-grid gap-3">
                    @if($ipAddress->status === 'available')
                        <button class="btn btn-primary shadow" onclick="changeStatus('assigned')" style="border-radius: 15px;">
                            <i class="fas fa-user-check me-2"></i>Mark as Assigned
                        </button>
                        <button class="btn btn-warning shadow" onclick="changeStatus('reserved')" style="border-radius: 15px;">
                            <i class="fas fa-lock me-2"></i>Mark as Reserved
                        </button>
                    @elseif($ipAddress->status === 'assigned')
                        <button class="btn btn-success shadow" onclick="changeStatus('available')" style="border-radius: 15px;">
                            <i class="fas fa-circle me-2"></i>Mark as Available
                        </button>
                        <button class="btn btn-warning shadow" onclick="changeStatus('reserved')" style="border-radius: 15px;">
                            <i class="fas fa-lock me-2"></i>Mark as Reserved
                        </button>
                    @elseif($ipAddress->status === 'reserved')
                        <button class="btn btn-success shadow" onclick="changeStatus('available')" style="border-radius: 15px;">
                            <i class="fas fa-circle me-2"></i>Mark as Available
                        </button>
                        <button class="btn btn-primary shadow" onclick="changeStatus('assigned')" style="border-radius: 15px;">
                            <i class="fas fa-user-check me-2"></i>Mark as Assigned
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- IP Statistics -->
        <div class="card animate-slide-in shadow-lg border-0 mb-4" style="animation-delay: 0.5s;">
            <div class="card-header text-white border-0" style="background: var(--info-gradient); border-radius: 20px 20px 0 0;">
                <h6 class="card-title mb-0 fw-bold d-flex align-items-center">
                    <i class="fas fa-chart-line me-2"></i>
                    IP Statistics
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="d-flex flex-column gap-3">
                    <div class="p-3" style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); border-radius: 12px;">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-medium" style="color: #1e3a8a;">Added</span>
                            <span class="fw-bold" style="color: #2563eb;">{{ $ipAddress->created_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    <div class="p-3" style="background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%); border-radius: 12px;">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-medium" style="color: #14532d;">Last Updated</span>
                            <span class="fw-bold" style="color: #059669;">{{ $ipAddress->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    <div class="p-3" style="background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%); border-radius: 12px;">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-medium" style="color: #581c87;">Subnet</span>
                            <span class="fw-bold" style="color: #7c3aed; font-family: 'Courier New', monospace;">
                                {{ implode('.', array_slice(explode('.', $ipAddress->ip_address), 0, 3)) }}.0/24
                            </span>
                        </div>
                    </div>

                    @if($ipAddress->gateway)
                    <div class="p-3" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border-radius: 12px;">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-medium" style="color: #92400e;">Network Gateway</span>
                            <span class="fw-bold" style="color: #d97706; font-family: 'Courier New', monospace;">{{ $ipAddress->gateway }}</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Network Connectivity Test -->
        <div class="card animate-slide-in shadow-lg border-0" style="animation-delay: 0.7s;">
            <div class="card-header text-white border-0" style="background: linear-gradient(135deg, #64748b 0%, #475569 100%); border-radius: 20px 20px 0 0;">
                <h6 class="card-title mb-0 fw-bold d-flex align-items-center">
                    <i class="fas fa-wifi me-2"></i>
                    Connectivity Status
                </h6>
            </div>
            <div class="card-body p-4 text-center">
                <div class="mb-3">
                    <div id="connectivity-status" class="badge bg-secondary px-3 py-2" style="border-radius: 50px;">
                        <i class="fas fa-question-circle me-1"></i>
                        Unknown
                    </div>
                </div>
                <button class="btn btn-outline-primary btn-sm" onclick="testConnectivity()" style="border-radius: 50px;">
                    <i class="fas fa-sync me-2"></i>Test Connectivity
                </button>
                <div id="last-ping-time" class="small text-muted mt-2"></div>
            </div>
        </div>
    </div>
</div>

<!-- Network Tool Modal -->
<div class="modal fade" id="networkToolModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="networkToolTitle" style="color: var(--text-primary);">Network Tool</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="networkToolResult">
                    <div class="text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2" style="color: var(--text-primary);">Processing...</p>
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
function pingIP(ipAddress) {
    showNetworkTool('Ping Result', `Pinging ${ipAddress}...`);

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
            document.getElementById('networkToolResult').innerHTML = `
                <div class="p-3" style="background: var(--bg-secondary); border-radius: 15px; border: 1px solid var(--border-color);">
                    <pre class="mb-0" style="color: var(--text-primary); font-size: 0.875rem; white-space: pre-wrap;">${data.output}</pre>
                </div>
            `;

            // Update connectivity status
            updateConnectivityStatus(true);
        } else {
            document.getElementById('networkToolResult').innerHTML = `
                <div class="alert alert-danger border-0" style="border-radius: 15px;">
                    <strong>Error:</strong> ${data.error}
                </div>
            `;
            updateConnectivityStatus(false);
        }
    })
    .catch(error => {
        document.getElementById('networkToolResult').innerHTML = `
            <div class="alert alert-danger border-0" style="border-radius: 15px;">
                <strong>Error:</strong> Failed to ping ${ipAddress}
            </div>
        `;
        updateConnectivityStatus(false);
    });
}

function tracerouteIP(ipAddress) {
    showNetworkTool('Traceroute Result', `Tracing route to ${ipAddress}...`);

    fetch('/tools/traceroute', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            host: ipAddress
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('networkToolResult').innerHTML = `
                <div class="p-3" style="background: var(--bg-secondary); border-radius: 15px; border: 1px solid var(--border-color);">
                    <pre class="mb-0" style="color: var(--text-primary); font-size: 0.875rem; white-space: pre-wrap; max-height: 400px; overflow-y: auto;">${data.output}</pre>
                </div>
            `;
        } else {
            document.getElementById('networkToolResult').innerHTML = `
                <div class="alert alert-danger border-0" style="border-radius: 15px;">
                    <strong>Error:</strong> ${data.error}
                </div>
            `;
        }
    })
    .catch(error => {
        document.getElementById('networkToolResult').innerHTML = `
            <div class="alert alert-danger border-0" style="border-radius: 15px;">
                <strong>Error:</strong> Failed to traceroute ${ipAddress}
            </div>
        `;
    });
}

function showNetworkTool(title, message) {
    document.getElementById('networkToolTitle').textContent = title;
    document.getElementById('networkToolResult').innerHTML = `
        <div class="text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2" style="color: var(--text-primary);">${message}</p>
        </div>
    `;
    new bootstrap.Modal(document.getElementById('networkToolModal')).show();
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        // Show toast notification
        const toast = document.createElement('div');
        toast.className = 'position-fixed top-0 end-0 p-3';
        toast.style.zIndex = '1100';
        toast.innerHTML = `
            <div class="toast show" role="alert" style="border-radius: 15px;">
                <div class="toast-header">
                    <i class="fas fa-copy text-success me-2"></i>
                    <strong class="me-auto">Copied!</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body">
                    ${text} copied to clipboard
                </div>
            </div>
        `;
        document.body.appendChild(toast);

        setTimeout(() => {
            if (document.body.contains(toast)) {
                document.body.removeChild(toast);
            }
        }, 3000);
    }).catch(err => {
        console.error('Failed to copy: ', err);
    });
}

function changeStatus(newStatus) {
    if (confirm(`Are you sure you want to change the status to "${newStatus}"?`)) {
        // Create form and submit
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("ip-addresses.update", $ipAddress) }}';

        // Add CSRF token and method
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';

        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'PUT';

        const statusField = document.createElement('input');
        statusField.name = 'status';
        statusField.type = 'hidden';
        statusField.value = newStatus;

        // Copy all current values
        const fields = {
            'ip_address': '{{ $ipAddress->ip_address }}',
            'subnet_mask': '{{ $ipAddress->subnet_mask }}',
            'gateway': '{{ $ipAddress->gateway }}',
            'dns_primary': '{{ $ipAddress->dns_primary }}',
            'dns_secondary': '{{ $ipAddress->dns_secondary }}',
            'type': '{{ $ipAddress->type }}',
            'device_name': '{{ $ipAddress->device_name }}',
            'mac_address': '{{ $ipAddress->mac_address }}',
            'assigned_to': '{{ $ipAddress->assigned_to }}',
            'location': '{{ $ipAddress->location }}',
            'notes': '{{ $ipAddress->notes }}'
        };

        Object.keys(fields).forEach(key => {
            if (fields[key] && fields[key] !== 'null') {
                const field = document.createElement('input');
                field.type = 'hidden';
                field.name = key;
                field.value = fields[key];
                form.appendChild(field);
            }
        });

        form.appendChild(csrfToken);
        form.appendChild(methodField);
        form.appendChild(statusField);

        document.body.appendChild(form);
        form.submit();
    }
}

function deleteIP() {
    if (confirm('Are you sure you want to delete this IP address? This action cannot be undone.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("ip-addresses.destroy", $ipAddress) }}';

        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';

        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';

        form.appendChild(csrfToken);
        form.appendChild(methodField);

        document.body.appendChild(form);
        form.submit();
    }
}

function testConnectivity() {
    const statusElement = document.getElementById('connectivity-status');
    const timeElement = document.getElementById('last-ping-time');

    statusElement.className = 'badge bg-warning px-3 py-2';
    statusElement.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Testing...';

    pingIP('{{ $ipAddress->ip_address }}');
}

function updateConnectivityStatus(isOnline) {
    const statusElement = document.getElementById('connectivity-status');
    const timeElement = document.getElementById('last-ping-time');
    const now = new Date().toLocaleString();

    if (isOnline) {
        statusElement.className = 'badge bg-success px-3 py-2';
        statusElement.innerHTML = '<i class="fas fa-check-circle me-1"></i>Online';
    } else {
        statusElement.className = 'badge bg-danger px-3 py-2';
        statusElement.innerHTML = '<i class="fas fa-times-circle me-1"></i>Offline';
    }

    timeElement.textContent = `Last tested: ${now}`;
}

// Add smooth transitions
document.querySelectorAll('.btn').forEach(btn => {
    btn.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-2px)';
    });

    btn.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0)';
    });
});

// Auto-test connectivity on page load
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(() => {
        testConnectivity();
    }, 1000);
});
</script>
@endpush
