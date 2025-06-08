@extends('layouts.app')

@section('title', 'Add New Item - Inventory')
@section('page-title', 'Add New Inventory Item')
@section('page-subtitle', 'Register a new IT asset to your inventory system')

@section('page-actions')
<a href="{{ route('inventory.index') }}" class="btn btn-outline-secondary" style="border-radius: 50px;">
    <i class="fas fa-arrow-left me-2"></i>Back to Inventory
</a>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card animate-fade-in shadow-lg border-0">
            <div class="card-header text-white border-0" style="background: var(--primary-gradient); border-radius: 20px 20px 0 0;">
                <h5 class="card-title mb-0 fw-bold d-flex align-items-center">
                    <div class="icon-box me-3" style="background: rgba(255,255,255,0.2); width: 40px; height: 40px; font-size: 16px;">
                        <i class="fas fa-plus-circle text-white"></i>
                    </div>
                    Item Information
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('inventory.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf

                    <!-- Basic Information -->
                    <div class="mb-4 p-4" style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); border-radius: 15px; border: 1px solid #93c5fd;">
                        <h6 class="fw-bold text-dark mb-3 d-flex align-items-center">
                            <i class="fas fa-info-circle text-primary me-2"></i>
                            Basic Information
                        </h6>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold text-dark">
                                    Item Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control search-box @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name') }}" required
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
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                            <i class="fas fa-tag text-success me-2"></i>
                            Product Details
                        </h6>
                        <div class="row g-4">
                            <div class="col-md-4">
                                <label for="brand" class="form-label fw-semibold text-dark">Brand</label>
                                <input type="text" class="form-control search-box @error('brand') is-invalid @enderror"
                                       id="brand" name="brand" value="{{ old('brand') }}"
                                       placeholder="e.g., Dell, HP, Lenovo">
                                @error('brand')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="model" class="form-label fw-semibold text-dark">Model</label>
                                <input type="text" class="form-control search-box @error('model') is-invalid @enderror"
                                       id="model" name="model" value="{{ old('model') }}"
                                       placeholder="e.g., Latitude 7420">
                                @error('model')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="serial_number" class="form-label fw-semibold text-dark">Serial Number</label>
                                <div class="input-group">
                                    <input type="text" class="form-control search-box @error('serial_number') is-invalid @enderror"
                                           id="serial_number" name="serial_number" value="{{ old('serial_number') }}"
                                           placeholder="Unique serial number">
                                    <button class="btn btn-outline-secondary" type="button" onclick="generateSerial()" style="border-radius: 0 15px 15px 0;">
                                        <i class="fas fa-magic"></i>
                                    </button>
                                </div>
                                @error('serial_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Status & Location -->
                    <div class="mb-4 p-4" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border-radius: 15px; border: 1px solid #fcd34d;">
                        <h6 class="fw-bold text-dark mb-3 d-flex align-items-center">
                            <i class="fas fa-map-marker-alt text-warning me-2"></i>
                            Status & Location
                        </h6>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="status" class="form-label fw-semibold text-dark">
                                    Status <span class="text-danger">*</span>
                                </label>
                                <select class="form-select search-box @error('status') is-invalid @enderror"
                                        id="status" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="available" {{ old('status') === 'available' ? 'selected' : '' }}>
                                        🟢 Available
                                    </option>
                                    <option value="in_use" {{ old('status') === 'in_use' ? 'selected' : '' }}>
                                        🔵 In Use
                                    </option>
                                    <option value="maintenance" {{ old('status') === 'maintenance' ? 'selected' : '' }}>
                                        🟡 Maintenance
                                    </option>
                                    <option value="retired" {{ old('status') === 'retired' ? 'selected' : '' }}>
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
                                       id="location" name="location" value="{{ old('location') }}"
                                       placeholder="e.g., Office Floor 2">
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="assigned_to" class="form-label fw-semibold text-dark">Assigned To</label>
                            <input type="text" class="form-control search-box @error('assigned_to') is-invalid @enderror"
                                   id="assigned_to" name="assigned_to" value="{{ old('assigned_to') }}"
                                   placeholder="Person or department name">
                            @error('assigned_to')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Purchase Information -->
                    <div class="mb-4 p-4" style="background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%); border-radius: 15px; border: 1px solid #c4b5fd;">
                        <h6 class="fw-bold text-dark mb-3 d-flex align-items-center">
                            <i class="fas fa-receipt text-purple-600 me-2"></i>
                            Purchase Information
                        </h6>
                        <div class="row g-4">
                            <div class="col-md-4">
                                <label for="purchase_price" class="form-label fw-semibold text-dark">Purchase Price</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-0 fw-bold text-success" style="border-radius: 15px 0 0 15px;">Rp.</span>
                                    <input type="number" step="0.01" class="form-control search-box @error('purchase_price') is-invalid @enderror"
                                           id="purchase_price" name="purchase_price" value="{{ old('purchase_price') }}"
                                           placeholder="0.00" style="border-radius: 0 15px 15px 0;">
                                    @error('purchase_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="purchase_date" class="form-label fw-semibold text-dark">Purchase Date</label>
                                <input type="date" class="form-control search-box @error('purchase_date') is-invalid @enderror"
                                       id="purchase_date" name="purchase_date" value="{{ old('purchase_date') }}">
                                @error('purchase_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="warranty_expiry" class="form-label fw-semibold text-dark">Warranty Expiry</label>
                                <input type="date" class="form-control search-box @error('warranty_expiry') is-invalid @enderror"
                                       id="warranty_expiry" name="warranty_expiry" value="{{ old('warranty_expiry') }}">
                                @error('warranty_expiry')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-4 p-4" style="background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%); border-radius: 15px; border: 1px solid #cbd5e1;">
                        <h6 class="fw-bold text-dark mb-3 d-flex align-items-center">
                            <i class="fas fa-file-alt text-secondary me-2"></i>
                            Additional Notes
                        </h6>
                        <label for="description" class="form-label fw-semibold text-dark">Description</label>
                        <textarea class="form-control search-box @error('description') is-invalid @enderror"
                                  id="description" name="description" rows="4"
                                  placeholder="Add any additional notes or specifications...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-3 pt-4">
                        <button type="submit" class="btn btn-gradient px-5 py-3 fw-bold shadow-lg">
                            <i class="fas fa-save me-2"></i>Save Item
                        </button>
                        <a href="{{ route('inventory.index') }}" class="btn btn-outline-secondary px-5 py-3 fw-semibold" style="border-radius: 50px;">
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
                    Quick Tips
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="d-flex flex-column gap-3">
                    <div class="p-3" style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); border-radius: 12px;">
                        <h6 class="fw-semibold text-blue-800 mb-2">📝 Naming Convention</h6>
                        <p class="small text-blue-700 mb-0">Use descriptive names like "Dell Laptop - Marketing Dept" for easier identification.</p>
                    </div>

                    <div class="p-3" style="background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%); border-radius: 12px;">
                        <h6 class="fw-semibold text-green-800 mb-2">🏷️ Serial Numbers</h6>
                        <p class="small text-green-700 mb-0">Always record serial numbers for warranty claims and asset tracking.</p>
                    </div>

                    <div class="p-3" style="background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%); border-radius: 12px;">
                        <h6 class="fw-semibold text-purple-800 mb-2">📍 Location Tracking</h6>
                        <p class="small text-purple-700 mb-0">Be specific with locations: "Floor 2, Room 201" instead of just "Office".</p>
                    </div>

                    <div class="p-3" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border-radius: 12px;">
                        <h6 class="fw-semibold text-yellow-800 mb-2">💰 Purchase Info</h6>
                        <p class="small text-yellow-700 mb-0">Recording purchase details helps with budgeting and depreciation tracking.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card animate-slide-in shadow-lg border-0" style="animation-delay: 0.4s;">
            <div class="card-header text-white border-0" style="background: var(--warning-gradient); border-radius: 20px 20px 0 0;">
                <h6 class="card-title mb-0 fw-bold d-flex align-items-center">
                    <i class="fas fa-bolt me-2"></i>
                    Quick Actions
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="d-grid gap-3">
                    <button type="button" class="btn btn-outline-primary" onclick="fillSampleData()" style="border-radius: 15px;">
                        <i class="fas fa-magic me-2"></i>Fill Sample Data
                    </button>
                    <button type="button" class="btn btn-outline-success" onclick="generateSerial()" style="border-radius: 15px;">
                        <i class="fas fa-barcode me-2"></i>Generate Serial
                    </button>
                    <a href="{{ route('inventory.index') }}" class="btn btn-outline-secondary" style="border-radius: 15px;">
                        <i class="fas fa-list me-2"></i>View All Items
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function fillSampleData() {
    document.getElementById('name').value = 'Dell Latitude 7420';
    document.getElementById('brand').value = 'Dell';
    document.getElementById('model').value = 'Latitude 7420';
    document.getElementById('location').value = 'Office Floor 2';
    document.getElementById('purchase_price').value = '1299.99';
    document.getElementById('description').value = 'Business laptop with Intel i7 processor, 16GB RAM, 512GB SSD';

    // Add visual feedback
    const fields = ['name', 'brand', 'model', 'location', 'purchase_price', 'description'];
    fields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        field.style.background = 'linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%)';
        setTimeout(() => {
            field.style.background = '';
        }, 1000);
    });
}

function generateSerial() {
    const prefix = 'IT';
    const timestamp = Date.now().toString().slice(-6);
    const random = Math.random().toString(36).substring(2, 6).toUpperCase();
    const serial = `${prefix}${timestamp}${random}`;
    document.getElementById('serial_number').value = serial;

    // Add visual feedback
    const field = document.getElementById('serial_number');
    field.style.background = 'linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%)';
    setTimeout(() => {
        field.style.background = '';
    }, 1000);
}

// Auto-calculate warranty expiry (1 year from purchase date)
document.getElementById('purchase_date').addEventListener('change', function() {
    if (this.value && !document.getElementById('warranty_expiry').value) {
        const purchaseDate = new Date(this.value);
        purchaseDate.setFullYear(purchaseDate.getFullYear() + 1);
        document.getElementById('warranty_expiry').value = purchaseDate.toISOString().split('T')[0];
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
            Please fill in all required fields.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        this.insertBefore(alert, this.firstChild);

        // Scroll to top
        this.scrollIntoView({ behavior: 'smooth' });
    }
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
</script>
@endpush
