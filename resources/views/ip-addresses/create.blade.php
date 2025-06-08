@extends('layouts.app')

@section('title', 'Add New IP Address')
@section('page-title', 'Add New IP Address')
@section('page-subtitle', 'Register a new IP address to your network management')

@section('page-actions')
<a href="{{ route('ip-addresses.index') }}" class="btn btn-outline-secondary" style="border-radius: 50px;">
    <i class="fas fa-arrow-left me-2"></i>Back to IP Addresses
</a>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card animate-fade-in shadow-lg border-0">
            <div class="card-header text-white border-0" style="background: var(--info-gradient); border-radius: 20px 20px 0 0;">
                <h5 class="card-title mb-0 fw-bold d-flex align-items-center">
                    <div class="icon-box me-3" style="background: rgba(255,255,255,0.2); width: 40px; height: 40px; font-size: 16px;">
                        <i class="fas fa-network-wired text-white"></i>
                    </div>
                    IP Address Information
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('ip-addresses.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf

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
                                           id="ip_address" name="ip_address" value="{{ old('ip_address') }}"
                                           placeholder="192.168.1.100" required style="border-radius: 0 15px 15px 0;">
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
                                    <option value="255.255.255.0" {{ old('subnet_mask') === '255.255.255.0' ? 'selected' : 'selected' }}>/24 - 255.255.255.0</option>
                                    <option value="255.255.0.0" {{ old('subnet_mask') === '255.255.0.0' ? 'selected' : '' }}>/16 - 255.255.0.0</option>
                                    <option value="255.0.0.0" {{ old('subnet_mask') === '255.0.0.0' ? 'selected' : '' }}>/8 - 255.0.0.0</option>
                                    <option value="255.255.255.128" {{ old('subnet_mask') === '255.255.255.128' ? 'selected' : '' }}>/25 - 255.255.255.128</option>
                                    <option value="255.255.255.192" {{ old('subnet_mask') === '255.255.255.192' ? 'selected' : '' }}>/26 - 255.255.255.192</option>
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
                                       id="gateway" name="gateway" value="{{ old('gateway') }}"
                                       placeholder="192.168.1.1" style="border-radius: 15px;">
                                @error('gateway')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="dns_primary" class="form-label fw-semibold text-dark">Primary DNS</label>
                                <input type="text" class="form-control search-box @error('dns_primary') is-invalid @enderror"
                                       id="dns_primary" name="dns_primary" value="{{ old('dns_primary', '8.8.8.8') }}"
                                       placeholder="8.8.8.8" style="border-radius: 15px;">
                                @error('dns_primary')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="dns_secondary" class="form-label fw-semibold text-dark">Secondary DNS</label>
                                <input type="text" class="form-control search-box @error('dns_secondary') is-invalid @enderror"
                                       id="dns_secondary" name="dns_secondary" value="{{ old('dns_secondary', '8.8.4.4') }}"
                                       placeholder="8.8.4.4" style="border-radius: 15px;">
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
                                    <option value="static" {{ old('type') === 'static' ? 'selected' : '' }}>
                                        📌 Static IP
                                    </option>
                                    <option value="dhcp" {{ old('type') === 'dhcp' ? 'selected' : '' }}>
                                        🔄 DHCP
                                    </option>
                                    <option value="reserved" {{ old('type') === 'reserved' ? 'selected' : '' }}>
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
                                    <option value="available" {{ old('status') === 'available' ? 'selected' : '' }}>
                                        🟢 Available
                                    </option>
                                    <option value="assigned" {{ old('status') === 'assigned' ? 'selected' : '' }}>
                                        🔵 Assigned
                                    </option>
                                    <option value="reserved" {{ old('status') === 'reserved' ? 'selected' : '' }}>
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
                                       id="device_name" name="device_name" value="{{ old('device_name') }}"
                                       placeholder="PC-OFFICE-01" style="border-radius: 15px;">
                                @error('device_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="mac_address" class="form-label fw-semibold text-dark">MAC Address</label>
                                <input type="text" class="form-control search-box @error('mac_address') is-invalid @enderror"
                                       id="mac_address" name="mac_address" value="{{ old('mac_address') }}"
                                       placeholder="00:11:22:33:44:55" style="border-radius: 15px;">
                                @error('mac_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-4 mt-2">
                            <div class="col-md-6">
                                <label for="assigned_to" class="form-label fw-semibold text-dark">Assigned To</label>
                                <input type="text" class="form-control search-box @error('assigned_to') is-invalid @enderror"
                                       id="assigned_to" name="assigned_to" value="{{ old('assigned_to') }}"
                                       placeholder="John Doe" style="border-radius: 15px;">
                                @error('assigned_to')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="location" class="form-label fw-semibold text-dark">Location</label>
                                <input type="text" class="form-control search-box @error('location') is-invalid @enderror"
                                       id="location" name="location" value="{{ old('location') }}"
                                       placeholder="Office Floor 2" style="border-radius: 15px;">
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
                                  placeholder="Add any additional notes about this IP address..."
                                  style="border-radius: 15px;">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-3 pt-4">
                        <button type="submit" class="btn btn-gradient px-5 py-3 fw-bold shadow-lg">
                            <i class="fas fa-save me-2"></i>Save IP Address
                        </button>
                        <a href="{{ route('ip-addresses.index') }}" class="btn btn-outline-secondary px-5 py-3 fw-semibold" style="border-radius: 50px;">
                            <i class="fas fa-times me-2"></i>Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Quick Tips Sidebar -->
    <div class="col-lg-4">
        <div class="card animate-slide-in shadow-lg border-0 mb-4" style="animation-delay: 0.2s;">
            <div class="card-header text-white border-0" style="background: var(--success-gradient); border-radius: 20px 20px 0 0;">
                <h6 class="card-title mb-0 fw-bold d-flex align-items-center">
                    <i class="fas fa-lightbulb me-2"></i>
                    Network Tips
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="d-flex flex-column gap-3">
                    <div class="p-3" style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); border-radius: 12px;">
                        <h6 class="fw-semibold text-blue-800 mb-2">🌐 IP Address Format</h6>
                        <p class="small text-blue-700 mb-0">Use standard IPv4 format: 192.168.1.100. Avoid using network or broadcast addresses.</p>
                    </div>

                    <div class="p-3" style="background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%); border-radius: 12px;">
                        <h6 class="fw-semibold text-green-800 mb-2">📌 Static vs DHCP</h6>
                        <p class="small text-green-700 mb-0">Use Static for servers and critical devices. DHCP for regular workstations.</p>
                    </div>

                    <div class="p-3" style="background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%); border-radius: 12px;">
                        <h6 class="fw-semibold text-purple-800 mb-2">🔍 MAC Address</h6>
                        <p class="small text-purple-700 mb-0">Format: XX:XX:XX:XX:XX:XX. Use for device identification and Wake-on-LAN.</p>
                    </div>

                    <div class="p-3" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border-radius: 12px;">
                        <h6 class="fw-semibold text-yellow-800 mb-2">📝 Documentation</h6>
                        <p class="small text-yellow-700 mb-0">Always document device purpose and location for easier network management.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Fill -->
        <div class="card animate-slide-in shadow-lg border-0" style="animation-delay: 0.4s;">
            <div class="card-header text-white border-0" style="background: var(--warning-gradient); border-radius: 20px 20px 0 0;">
                <h6 class="card-title mb-0 fw-bold d-flex align-items-center">
                    <i class="fas fa-magic me-2"></i>
                    Quick Fill
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="mb-3">
                    <label class="form-label fw-semibold small">Common Subnets:</label>
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="fillSubnet('192.168.1', '192.168.1.1')" style="border-radius: 15px;">
                            192.168.1.x/24
                        </button>
                        <button type="button" class="btn btn-outline-info btn-sm" onclick="fillSubnet('192.168.10', '192.168.10.1')" style="border-radius: 15px;">
                            192.168.10.x/24
                        </button>
                        <button type="button" class="btn btn-outline-success btn-sm" onclick="fillSubnet('10.0.1', '10.0.1.1')" style="border-radius: 15px;">
                            10.0.1.x/24
                        </button>
                        <button type="button" class="btn btn-outline-warning btn-sm" onclick="fillSubnet('172.16.1', '172.16.1.1')" style="border-radius: 15px;">
                            172.16.1.x/24
                        </button>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small">Common DNS:</label>
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="fillDNS('8.8.8.8', '8.8.4.4')" style="border-radius: 15px;">
                            Google DNS
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="fillDNS('1.1.1.1', '1.0.0.1')" style="border-radius: 15px;">
                            Cloudflare DNS
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function fillSubnet(subnet, gateway) {
    const ipField = document.getElementById('ip_address');
    const gatewayField = document.getElementById('gateway');

    if (!ipField.value) {
        ipField.value = subnet + '.';
        ipField.focus();
    }
    gatewayField.value = gateway;

    // Visual feedback
    [ipField, gatewayField].forEach(field => {
        field.style.background = 'linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%)';
        setTimeout(() => {
            field.style.background = '';
        }, 1000);
    });
}

function fillDNS(primary, secondary) {
    document.getElementById('dns_primary').value = primary;
    document.getElementById('dns_secondary').value = secondary;

    // Visual feedback
    const fields = [document.getElementById('dns_primary'), document.getElementById('dns_secondary')];
    fields.forEach(field => {
        field.style.background = 'linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%)';
        setTimeout(() => {
            field.style.background = '';
        }, 1000);
    });
}

// Auto-fill gateway based on IP address
document.getElementById('ip_address').addEventListener('blur', function() {
    const ip = this.value;
    const gatewayField = document.getElementById('gateway');

    if (ip && !gatewayField.value) {
        const parts = ip.split('.');
        if (parts.length === 4) {
            gatewayField.value = parts[0] + '.' + parts[1] + '.' + parts[2] + '.1';
        }
    }
});

// MAC Address formatting
document.getElementById('mac_address').addEventListener('input', function() {
    let value = this.value.replace(/[^a-fA-F0-9]/g, '');
    let formattedValue = value.match(/.{1,2}/g)?.join(':') || value;
    if (formattedValue.length <= 17) {
        this.value = formattedValue.toUpperCase();
    }
});

// IP Address validation
document.getElementById('ip_address').addEventListener('blur', function() {
    const ip = this.value;
    const ipRegex = /^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/;

    if (ip && !ipRegex.test(ip)) {
        this.style.borderColor = '#ef4444';
        this.style.background = 'linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%)';
    } else if (ip) {
        this.style.borderColor = '#10b981';
        this.style.background = 'linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%)';
        setTimeout(() => {
            this.style.borderColor = '';
            this.style.background = '';
        }, 2000);
    }
});

// Form validation with visual feedback
document.querySelector('form').addEventListener('submit', function(e) {
    const requiredFields = this.querySelectorAll('[required]');
    let isValid = true;

    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            field.style.borderColor = '#ef4444';
            field.style.background = 'linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%)';
            isValid = false;
        } else {
            field.style.borderColor = '';
            field.style.background = '';
        }
    });

    if (!isValid) {
        e.preventDefault();
        // Show error message
        const alert = document.createElement('div');
        alert.className = 'alert alert-danger alert-dismissible fade show';
        alert.style.borderRadius = '15px';
        alert.innerHTML = `
            <i class="fas fa-exclamation-circle me-2"></i>
            Please fill in all required fields with valid information.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        this.insertBefore(alert, this.firstChild);

        // Scroll to top
        this.scrollIntoView({ behavior: 'smooth' });
    }
});

// Auto-hide/show device fields based on status
document.getElementById('status').addEventListener('change', function() {
    const deviceFields = document.querySelectorAll('#device_name, #assigned_to, #mac_address');
    if (this.value === 'available') {
        deviceFields.forEach(field => {
            field.closest('.col-md-6').style.opacity = '0.5';
            field.value = '';
        });
    } else {
        deviceFields.forEach(field => {
            field.closest('.col-md-6').style.opacity = '1';
        });
    }
});
</script>
@endpush
