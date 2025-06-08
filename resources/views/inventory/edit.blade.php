@extends('layouts.app')

@section('title', 'Edit Item - Inventory')
@section('page-title', 'Edit Inventory Item')
@section('page-subtitle', 'Update information for ' . $inventory->name)

@section('page-actions')
<div class="d-flex gap-2">
    <a href="{{ route('inventory.show', $inventory) }}" class="btn btn-info" style="border-radius: 50px;">
        <i class="fas fa-eye me-2"></i>View Item
    </a>
    <a href="{{ route('inventory.index') }}" class="btn btn-outline-secondary" style="border-radius: 50px;">
        <i class="fas fa-arrow-left me-2"></i>Back to Inventory
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
                        <h5 class="card-title mb-0 fw-bold">Edit Item</h5>
                        <small class="text-white" style="opacity: 0.8;">{{ $inventory->name }}</small>
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
                                This item is currently <strong>{{ ucfirst(str_replace('_', ' ', $inventory->status)) }}</strong>
                                @if($inventory->assigned_to)
                                    and assigned to <strong>{{ $inventory->assigned_to }}</strong>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('inventory.update', $inventory) }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')

                    <!-- Basic Information -->
                    <div class="mb-4 p-4" style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); border-radius: 15px; border: 1px solid #93c5fd;">
                        <h6 class="fw-bold text-dark mb-3 d-flex align-items-center">
                            <div class="icon-box me-2" style="background: #3b82f6; width: 30px; height: 30px; font-size: 12px;">
                                <i class="fas fa-info-circle text-white"></i>
                            </div>
                            Basic Information
                        </h6>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold text-dark">
                                    Item Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control search-box @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name', $inventory->name) }}" required
                                       placeholder="Enter item name">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="category_id" class="form-label fw-semibold text-dark">
                                    Category <span class="text-danger">*</span>
                                </label>
                                <select class="form-select search-box @error('category_id') is-invalid @enderror"
                                        id="category_id" name="category_id" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}"
                                                {{ old('category_id', $inventory->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Product Details -->
                    <div class="mb-4 p-4" style="background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%); border-radius: 15px; border: 1px solid #86efac;">
                        <h6 class="fw-bold text-dark mb-3 d-flex align-items-center">
                            <div class="icon-box me-2" style="background: #10b981; width: 30px; height: 30px; font-size: 12px;">
                                <i class="fas fa-tag text-white"></i>
                            </div>
                            Product Details
                        </h6>
                        <div class="row g-4">
                            <div class="col-md-4">
                                <label for="brand" class="form-label fw-semibold text-dark">Brand</label>
                                <input type="text" class="form-control search-box @error('brand') is-invalid @enderror"
                                       id="brand" name="brand" value="{{ old('brand', $inventory->brand) }}"
                                       placeholder="e.g., Dell, HP, Lenovo">
                                @error('brand')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="model" class="form-label fw-semibold text-dark">Model</label>
                                <input type="text" class="form-control search-box @error('model') is-invalid @enderror"
                                       id="model" name="model" value="{{ old('model', $inventory->model) }}"
                                       placeholder="e.g., Latitude 7420">
                                @error('model')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="serial_number" class="form-label fw-semibold text-dark">Serial Number</label>
                                <input type="text" class="form-control search-box @error('serial_number') is-invalid @enderror"
                                       id="serial_number" name="serial_number" value="{{ old('serial_number', $inventory->serial_number) }}"
                                       placeholder="Unique serial number">
                                @error('serial_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Status & Assignment -->
                    <div class="mb-4 p-4" style="background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%); border-radius: 15px; border: 1px solid #c4b5fd;">
                        <h6 class="fw-bold text-dark mb-3 d-flex align-items-center">
                            <div class="icon-box me-2" style="background: #8b5cf6; width: 30px; height: 30px; font-size: 12px;">
                                <i class="fas fa-user-cog text-white"></i>
                            </div>
                            Status & Assignment
                        </h6>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="status" class="form-label fw-semibold text-dark">
                                    Status <span class="text-danger">*</span>
                                </label>
                                <select class="form-select search-box @error('status') is-invalid @enderror"
                                        id="status" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="available" {{ old('status', $inventory->status) === 'available' ? 'selected' : '' }}>
                                        🟢 Available
                                    </option>
                                    <option value="in_use" {{ old('status', $inventory->status) === 'in_use' ? 'selected' : '' }}>
                                        🔵 In Use
                                    </option>
                                    <option value="maintenance" {{ old('status', $inventory->status) === 'maintenance' ? 'selected' : '' }}>
                                        🟡 Maintenance
                                    </option>
                                    <option value="retired" {{ old('status', $inventory->status) === 'retired' ? 'selected' : '' }}>
                                        🔴 Retired
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="location" class="form-label fw-semibold text-dark">Location</label>
                                <input type="text" class="form-control search-box @error('location') is-invalid @enderror"
                                       id="location" name="location" value="{{ old('location', $inventory->location) }}"
                                       placeholder="e.g., Office Floor 2">
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="assigned_to" class="form-label fw-semibold text-dark">Assigned To</label>
                            <input type="text" class="form-control search-box @error('assigned_to') is-invalid @enderror"
                                   id="assigned_to" name="assigned_to" value="{{ old('assigned_to', $inventory->assigned_to) }}"
                                   placeholder="Person or department name">
                            @error('assigned_to')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Purchase Information -->
                    <div class="mb-4 p-4" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border-radius: 15px; border: 1px solid #fcd34d;">
                        <h6 class="fw-bold text-dark mb-3 d-flex align-items-center">
                            <div class="icon-box me-2" style="background: #f59e0b; width: 30px; height: 30px; font-size: 12px;">
                                <i class="fas fa-receipt text-white"></i>
                            </div>
                            Purchase Information
                        </h6>
                        <div class="row g-4">
                            <div class="col-md-4">
                                <label for="purchase_price" class="form-label fw-semibold text-dark">Purchase Price</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-0 fw-bold text-success" style="border-radius: 15px 0 0 15px;">Rp.</span>
                                    <input type="number" step="0.01" class="form-control search-box @error('purchase_price') is-invalid @enderror"
                                           id="purchase_price" name="purchase_price" value="{{ old('purchase_price', $inventory->purchase_price) }}"
                                           placeholder="0.00" style="border-radius: 0 15px 15px 0;">
                                    @error('purchase_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="purchase_date" class="form-label fw-semibold text-dark">Purchase Date</label>
                                <input type="date" class="form-control search-box @error('purchase_date') is-invalid @enderror"
                                       id="purchase_date" name="purchase_date"
                                       value="{{ old('purchase_date', $inventory->purchase_date?->format('Y-m-d')) }}">
                                @error('purchase_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="warranty_expiry" class="form-label fw-semibold text-dark">Warranty Expiry</label>
                                <input type="date" class="form-control search-box @error('warranty_expiry') is-invalid @enderror"
                                       id="warranty_expiry" name="warranty_expiry"
                                       value="{{ old('warranty_expiry', $inventory->warranty_expiry?->format('Y-m-d')) }}">
                                @error('warranty_expiry')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-4 p-4" style="background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%); border-radius: 15px; border: 1px solid #cbd5e1;">
                        <h6 class="fw-bold text-dark mb-3 d-flex align-items-center">
                            <div class="icon-box me-2" style="background: #64748b; width: 30px; height: 30px; font-size: 12px;">
                                <i class="fas fa-file-alt text-white"></i>
                            </div>
                            Additional Notes
                        </h6>
                        <label for="description" class="form-label fw-semibold text-dark">Description</label>
                        <textarea class="form-control search-box @error('description') is-invalid @enderror"
                                  id="description" name="description" rows="4"
                                  placeholder="Add any additional notes or specifications...">{{ old('description', $inventory->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-3 pt-4">
                        <button type="submit" class="btn btn-gradient px-5 py-3 fw-bold shadow-lg">
                            <i class="fas fa-save me-2"></i>Update Item
                        </button>
                        <a href="{{ route('inventory.show', $inventory) }}" class="btn btn-outline-secondary px-5 py-3 fw-semibold" style="border-radius: 50px;">
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
                    <button type="button" class="btn btn-outline-primary" onclick="duplicateItem()" style="border-radius: 15px;">
                        <i class="fas fa-copy me-2"></i>Duplicate Item
                    </button>
                    <button type="button" class="btn btn-outline-success" onclick="generateQR()" style="border-radius: 15px;">
                        <i class="fas fa-qrcode me-2"></i>Generate QR Code
                    </button>
                    <a href="{{ route('inventory.show', $inventory) }}" class="btn btn-outline-info" style="border-radius: 15px;">
                        <i class="fas fa-eye me-2"></i>View Details
                    </a>
                    <button type="button" class="btn btn-outline-danger" onclick="deleteItem()" style="border-radius: 15px;">
                        <i class="fas fa-trash me-2"></i>Delete Item
                    </button>
                </div>
            </div>
        </div>

        <!-- Item History -->
        <div class="card animate-slide-in shadow-lg border-0" style="animation-delay: 0.4s;">
            <div class="card-header text-white border-0" style="background: var(--success-gradient); border-radius: 20px 20px 0 0;">
                <h6 class="card-title mb-0 fw-bold d-flex align-items-center">
                    <i class="fas fa-history me-2"></i>
                    Item History
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="timeline">
                    <div class="d-flex align-items-start mb-4">
                        <div class="icon-box me-3" style="background: #3b82f6; width: 35px; height: 35px; font-size: 14px;">
                            <i class="fas fa-plus text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-semibold text-dark mb-1">Item Created</h6>
                            <p class="small text-muted mb-1">Item was added to inventory</p>
                            <small class="text-muted">{{ $inventory->created_at->format('M d, Y H:i') }}</small>
                        </div>
                    </div>

                    @if($inventory->updated_at != $inventory->created_at)
                    <div class="d-flex align-items-start mb-4">
                        <div class="icon-box me-3" style="background: #f59e0b; width: 35px; height: 35px; font-size: 14px;">
                            <i class="fas fa-edit text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-semibold text-dark mb-1">Last Updated</h6>
                            <p class="small text-muted mb-1">Item information was modified</p>
                            <small class="text-muted">{{ $inventory->updated_at->format('M d, Y H:i') }}</small>
                        </div>
                    </div>
                    @endif

                    @if($inventory->purchase_date)
                    <div class="d-flex align-items-start">
                        <div class="icon-box me-3" style="background: #10b981; width: 35px; height: 35px; font-size: 14px;">
                            <i class="fas fa-shopping-cart text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-semibold text-dark mb-1">Purchased</h6>
                            <p class="small text-muted mb-1">
                                Item was purchased
                                @if($inventory->purchase_price)
                                    for ${{ number_format($inventory->purchase_price, 2) }}
                                @endif
                            </p>
                            <small class="text-muted">{{ $inventory->purchase_date->format('M d, Y') }}</small>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function duplicateItem() {
    if (confirm('Create a duplicate of this item?')) {
        alert('Duplicate functionality would be implemented here');
    }
}

function generateQR() {
    alert('QR Code generation would be implemented here');
}

function deleteItem() {
    if (confirm('Are you sure you want to delete this item? This action cannot be undone.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("inventory.destroy", $inventory) }}';

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

// Auto-hide/show assigned_to field based on status
document.getElementById('status').addEventListener('change', function() {
    const assignedField = document.getElementById('assigned_to').closest('.mt-4');
    if (this.value === 'available' || this.value === 'retired') {
        assignedField.style.opacity = '0.5';
        document.getElementById('assigned_to').value = '';
    } else {
        assignedField.style.opacity = '1';
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

// Real-time validation feedback
document.querySelectorAll('input, select, textarea').forEach(field => {
    field.addEventListener('blur', function() {
        if (this.hasAttribute('required') && !this.value.trim()) {
            this.style.borderColor = '#ef4444';
            this.style.background = 'linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%)';
        } else {
            this.style.borderColor = '#10b981';
            this.style.background = 'linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%)';
            setTimeout(() => {
                this.style.borderColor = '';
                this.style.background = '';
            }, 2000);
        }
    });
});
</script>
@endpush
