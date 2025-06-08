@extends('layouts.app')

@section('title', 'Edit IP Address')
@section('page-title', 'Edit IP Address')
@section('page-subtitle', 'Update information for ' . $ipAddress->ip_address)

@section('page-actions')
<div class="d-flex gap-2">
    <a href="{{ route('ip-addresses.show', $ipAddress) }}" class="btn btn-info" style="border-radius: 50px;">
        <i class="fas fa-eye me-2"></i>View IP
    </a>
    <a href="{{ route('ip-addresses.index') }}" class="btn btn-outline-secondary" style="border-radius: 50px;">
        <i class="fas fa-arrow-left me-2"></i>Back to IP Addresses
    </a>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card animate-fade-in shadow-lg border-0">
            <div class="card-header text-white border-0" style="background: var(--warning-gradient); border-radius: 20px 20px 0 0;">
                <div class="d-flex align-items-center">
                    <div class="icon-box me-3" style="background: rgba(255,255,255,0.2); width: 40px; height: 40px; font-size: 16px;">
                        <i class="fas fa-edit text-white"></i>
                    </div>
                    <div>
                        <h5 class="card-title mb-0 fw-bold">Edit IP Address</h5>
                        <small class="text-white" style="opacity: 0.8; font-family: 'Courier New', monospace;">{{ $ipAddress->ip_address }}</small>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <!-- Current Status Alert -->
                <div class="alert border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #e0f2fe 0%, #b3e5fc 100%); border-radius: 15px;">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-info-circle text-blue-600 fs-4 me-3"></i>
                        <div>
                            <h6 class="fw-semibold text-blue-800 mb-1">Current Status</h6>
                            <p class="text-blue-700 mb-0">
                                This IP is currently <strong>{{ ucfirst($ipAddress->status) }}</strong>
                                @if($ipAddress->assigned_to)
                                    and assigned to <strong>{{ $ipAddress->assigned_to }}</strong>
                                @endif
                                @if($ipAddress->device_name)
                                    on device <strong>{{ $ipAddress->device_name }}</strong>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('ip-addresses.update', $ipAddress) }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')

                    <!-- Network Configuration -->
                    <div class="mb-4 p-4" style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); border-radius: 15px; border: 1px solid #93c5fd;">
                        <h6 class="fw-bold text-dark mb-3 d-flex align-items-center">
                            <div class="icon-box me-2" style="background: #3b82f6; width: 30px; height: 30px; font-size: 12px;">
                                <i class="fas fa-globe text-white"></i>
                            </div>
                            Network Configuration
                        </h6>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="ip_address" class="form-label fw-semibold text-dark">
                                    IP Address <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-0 fw-bold text-primary" style="border-radius: 15px 0 0 15px;">
                                        <i class="fas fa-network-wired"></i>
                                    </span>
                                    <input type="text" class="form-control search-box @error('ip_address') is-invalid @enderror"
                                           id="ip_address" name="ip_address" value="{{ old('ip_address', $ipAddress->ip_address) }}"
                                           required style="border-radius: 0 15px 15px 0;">
                                </div>
                                @error('ip_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="subnet_mask" class="form-label fw-semibold text-dark">
                                    Subnet Mask <span class="text-danger">*</span>
                                </label>
                                <select class="form-select search-box @error('subnet_mask') is-invalid @enderror"
                                        id="subnet_mask" name="subnet_mask" required style="border-radius: 15px;">
                                    <option value="">Select Subnet Mask</option>
                                    <option value="255.255.255.0" {{ old('subnet_mask', $ipAddress->subnet_mask) === '255.255.255.0' ? 'selected' : '' }}>/24 - 255.255.255.0</option>
                                    <option value="255.255.0.0" {{ old('subnet_mask', $ipAddress->subnet_mask) === '255.255.0.0' ? 'selected' : '' }}>/16 - 255.255.0.0</option>
                                    <option value="255.0.0.0" {{ old('subnet_mask', $ipAddress->subnet_mask) === '255.0.0.0' ? 'selected' : '' }}>/8 - 255.0.0.0</option>
                                    <option value="255.255.255.128" {{ old('subnet_mask', $ipAddress->subnet_mask) === '255.255.255.128' ? 'selected' : '' }}>/25 - 255.255.255.128</option>
                                    <option value="255.255.255.192" {{ old('subnet_mask', $ipAddress->subnet_mask) === '255.255.255.192' ? 'selected' : '' }}>/26 - 255.255.255.192</option>
                                </select>
                                @error('subnet_mask')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-4 mt-2">
                            <div class="col-md-4">
                                <label for="gateway" class="form-label fw-semibold text-dark">Gateway</label>
                                <input type="text" class="form-control search-box @error('gateway') is-invalid @enderror"
                                       id="gateway" name="gateway" value="{{ old('gateway', $ipAddress->gateway) }}"
                                       style="border-radius: 15px;">
                                @error('gateway')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="dns_primary" class="form-label fw-semibold text-dark">Primary DNS</label>
                                <input type="text" class="form-control search-box @error('dns_primary') is-invalid @enderror"
                                       id="dns_primary" name="dns_primary" value="{{ old('dns_primary', $ipAddress->dns_primary) }}"
                                       style="border-radius: 15px;">
                                @error('dns_primary')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="dns_secondary" class="form-label fw-semibold text-dark">Secondary DNS</label>
                                <input type="text" class="form-control search-box @error('dns_secondary') is-invalid @enderror"
                                       id="dns_secondary" name="dns_secondary" value="{{ old('dns_secondary', $ipAddress->dns_secondary) }}"
                                       style="border-radius: 15px;">
                                @error('dns_secondary')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- IP Configuration -->
                    <div class="mb-4 p-4" style="background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%); border-radius: 15px; border: 1px solid #86efac;">
                        <h6 class="fw-bold text-dark mb-3 d-flex align-items-center">
                            <div class="icon-box me-2" style="background: #10b981; width: 30px; height: 30px; font-size: 12px;">
                                <i class="fas fa-cog text-white"></i>
                            </div>
                            IP Configuration
                        </h6>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="type" class="form-label fw-semibold text-dark">
                                    Type <span class="text-danger">*</span>
                                </label>
                                <select class="form-select search-box @error('type') is-invalid @enderror"
                                        id="type" name="type" required style="border-radius: 15px;">
                                    <option value="">Select Type</option>
                                    <option value="static" {{ old('type', $ipAddress->type) === 'static' ? 'selected' : '' }}>
                                        📌 Static IP
                                    </option>
                                    <option value="dhcp" {{ old('type', $ipAddress->type) === 'dhcp' ? 'selected' : '' }}>
                                        🔄 DHCP
                                    </option>
                                    <option value="reserved" {{ old('type', $ipAddress->type) === 'reserved' ? 'selected' : '' }}>
                                        🔒 Reserved
                                    </option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="status" class="form-label fw-semibold text-dark">
                                    Status <span class="text-danger">*</span>
                                </label>
                                <select class="form-select search-box @error('status') is-invalid @enderror"
                                        id="status" name="status" required style="border-radius: 15px;">
                                    <option value="">Select Status</option>
                                    <option value="available" {{ old('status', $ipAddress->status) === 'available' ? 'selected' : '' }}>
                                        🟢 Available
                                    </option>
                                    <option value="assigned" {{ old('status', $ipAddress->status) === 'assigned' ? 'selected' : '' }}>
                                        🔵 Assigned
                                    </option>
                                    <option value="reserved" {{ old('status', $ipAddress->status) === 'reserved' ? 'selected' : '' }}>
                                        🟡 Reserved
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Device Information -->
                    <div class="mb-4 p-4" style="background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%); border-radius: 15px; border: 1px solid #c4b5fd;">
                        <h6 class="fw-bold text-dark mb-3 d-flex align-items-center">
                            <div class="icon-box me-2" style="background: #8b5cf6; width: 30px; height: 30px; font-size: 12px;">
                                <i class="fas fa-desktop text-white"></i>
                            </div>
                            Device Information
                        </h6>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="device_name" class="form-label fw-semibold text-dark">Device Name</label>
                                <input type="text" class="form-control search-box @error('device_name') is-invalid @enderror"
                                       id="device_name" name="device_name" value="{{ old('device_name', $ipAddress->device_name) }}"
                                       style="border-radius: 15px;">
                                @error('device_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="mac_address" class="form-label fw-semibold text-dark">MAC Address</label>
                                <input type="text" class="form-control search-box @error('mac_address') is-invalid @enderror"
                                       id="mac_address" name="mac_address" value="{{ old('mac_address', $ipAddress->mac_address) }}"
                                       style="border-radius: 15px;">
                                @error('mac_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-4 mt-2">
                            <div class="col-md-6">
                                <label for="assigned_to" class="form-label fw-semibold text-dark">Assigned To</label>
                                <input type="text" class="form-control search-box @error('assigned_to') is-invalid @enderror"
                                       id="assigned_to" name="assigned_to" value="{{ old('assigned_to', $ipAddress->assigned_to) }}"
                                       style="border-radius: 15px;">
                                @error('assigned_to')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="location" class="form-label fw-semibold text-dark">Location</label>
                                <input type="text" class="form-control search-box @error('location') is-invalid @enderror"
                                       id="location" name="location" value="{{ old('location', $ipAddress->location) }}"
                                       style="border-radius: 15px;">
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Additional Notes -->
                    <div class="mb-4 p-4" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border-radius: 15px; border: 1px solid #fcd34d;">
                        <h6 class="fw-bold text-dark mb-3 d-flex align-items-center">
                            <div class="icon-box me-2" style="background: #f59e0b; width: 30px; height: 30px; font-size: 12px;">
                                <i class="fas fa-sticky-note text-white"></i>
                            </div>
                            Additional Notes
                        </h6>
                        <label for="notes" class="form-label fw-semibold text-dark">Notes</label>
                        <textarea class="form-control search-box @error('notes') is-invalid @enderror"
                                  id="notes" name="notes" rows="4"
                                  style="border-radius: 15px;">{{ old('notes', $ipAddress->notes) }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-3 pt-4">
                        <button type="submit" class="btn btn-gradient px-5 py-3 fw-bold shadow-lg">
                            <i class="fas fa-save me-2"></i>Update IP Address
                        </button>
                        <a href="{{ route('ip-addresses.show', $ipAddress) }}" class="btn btn-outline-secondary px-5 py-3 fw-semibold" style="border-radius: 50px;">
                            <i class="fas fa-times me-2"></i>Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Change History & Quick Actions Sidebar -->
    <div class="col-lg-4">
        <!-- Quick Actions -->
        <div class="card animate-slide-in shadow-lg border-0 mb-4" style="animation-delay: 0.2s;">
            <div class="card-header text-white border-0" style="background: var(--info-gradient); border-radius: 20px 20px 0 0;">
                <h6 class="card-title mb-0 fw-bold d-flex align-items-center">
                    <i class="fas fa-bolt me-2"></i>
                    Quick Actions
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="d-grid gap-3">
                    <button type="button" class="btn btn-outline-success" onclick="pingIP('{{ $ipAddress->ip_address }}')" style="border-radius: 15px;">
                        <i class="fas fa-satellite-dish me-2"></i>Ping IP
                    </button>
                    <button type="button" class="btn btn-outline-info" onclick="tracerouteIP('{{ $ipAddress->ip_address }}')" style="border-radius: 15px;">
                        <i class="fas fa-route me-2"></i>Traceroute
                    </button>
                    <a href="{{ route('ip-addresses.show', $ipAddress) }}" class="btn btn-outline-primary" style="border-radius: 15px;">
                        <i class="fas fa-eye me-2"></i>View Details
                    </a>
                    <button type="button" class="btn btn-outline-danger" onclick="deleteIP()" style="border-radius: 15px;">
                        <i class="fas fa-trash me-2"></i>Delete IP
                    </button>
                </div>
            </div>
        </div>

        <!-- IP History -->
        <div class="card animate-slide-in shadow-lg border-0" style="animation-delay: 0.4s;">
            <div class="card-header text-white border-0" style="background: var(--success-gradient); border-radius: 20px 20px 0 0;">
                <h6 class="card-title mb-0 fw-bold d-flex align-items-center">
                    <i class="fas fa-history me-2"></i>
                    IP History
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="timeline">
                    <div class="d-flex align-items-start mb-4">
                        <div class="icon-box me-3" style="background: #3b82f6; width: 35px; height: 35px; font-size: 14px;">
                            <i class="fas fa-plus text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-semibold text-dark mb-1">IP Created</h6>
                            <p class="small text-muted mb-1">IP address was added to network</p>
                            <small class="text-muted">{{ $ipAddress->created_at->format('M d, Y H:i') }}</small>
                        </div>
                    </div>

                    @if($ipAddress->updated_at != $ipAddress->created_at)
                    <div class="d-flex align-items-start mb-4">
                        <div class="icon-box me-3" style="background: #f59e0b; width: 35px; height: 35px; font-size: 14px;">
                            <i class="fas fa-edit text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-semibold text-dark mb-1">Last Updated</h6>
                            <p class="small text-muted mb-1">IP information was modified</p>
                            <small class="text-muted">{{ $ipAddress->updated_at->format('M d, Y H:i') }}</small>
                        </div>
                    </div>
                    @endif

                    @if($ipAddress->assigned_to)
                    <div class="d-flex align-items-start">
                        <div class="icon-box me-3" style="background: #10b981; width: 35px; height: 35px; font-size: 14px;">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-semibold text-dark mb-1">Currently Assigned</h6>
                            <p class="small text-muted mb-1">
                                Assigned to {{ $ipAddress->assigned_to }}
                                @if($ipAddress->device_name)
                                    on {{ $ipAddress->device_name }}
                                @endif
                            </p>
                            <small class="text-muted">Status: {{ ucfirst($ipAddress->status) }}</small>
                        </div>
                    </div>
                    @endif
                </div>
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
                <strong>Error:</strong> Failed to ping ${ipAddress}
            </div>
        `;
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

// MAC Address formatting
document.getElementById('mac_address').addEventListener('input', function() {
    let value = this.value.replace(/[^a-fA-F0-9]/g, '');
    let formattedValue = value.match(/.{1,2}/g)?.join(':') || value;
    if (formattedValue.length <= 17) {
        this.value = formattedValue.toUpperCase();
    }
});

// Form validation with enhanced visual feedback
document.querySelector('form').addEventListener('submit', function(e) {
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalContent = submitBtn.innerHTML;

    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Updating...';
    submitBtn.disabled = true;

    // Re-enable after 3 seconds if form doesn't submit
    setTimeout(() => {
        submitBtn.innerHTML = originalContent;
        submitBtn.disabled = false;
    }, 3000);
});

// Auto-hide/show device fields based on status
document.getElementById('status').addEventListener('change', function() {
    const deviceFields = document.querySelectorAll('#device_name, #assigned_to, #mac_address');
    if (this.value === 'available') {
        deviceFields.forEach(field => {
            field.closest('.col-md-6').style.opacity = '0.5';
        });
    } else {
        deviceFields.forEach(field => {
            field.closest('.col-md-6').style.opacity = '1';
        });
    }
});
</script>
@endpush
