@extends('layouts.app')

@section('title', 'Inventory Management')
@section('page-title', 'Inventory Management')
@section('page-subtitle', 'Manage and track all your IT assets in one place')

@section('page-actions')
<a href="{{ route('inventory.create') }}" class="btn btn-gradient px-4 py-2 rounded-full shadow-lg hover:shadow-xl transition-all duration-300">
    <i class="fas fa-plus me-2"></i>Add New Item
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
                        <h6 class="text-white text-uppercase small mb-2 fw-semibold" style="opacity: 0.9; letter-spacing: 0.5px;">Total Items</h6>
                        <h2 class="text-white fw-bold mb-0" style="font-size: 2.5rem;">{{ $items->total() }}</h2>
                    </div>
                    <div class="icon-box" style="background: rgba(255,255,255,0.25); width: 60px; height: 60px; border-radius: 15px;">
                        <i class="fas fa-boxes text-white" style="font-size: 24px;"></i>
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
                        <h2 class="text-white fw-bold mb-0" style="font-size: 2.5rem;">{{ $items->where('status', 'available')->count() }}</h2>
                    </div>
                    <div class="icon-box" style="background: rgba(255,255,255,0.25); width: 60px; height: 60px; border-radius: 15px;">
                        <i class="fas fa-check-circle text-white" style="font-size: 24px;"></i>
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
                        <h6 class="text-white text-uppercase small mb-2 fw-semibold" style="opacity: 0.9; letter-spacing: 0.5px;">In Use</h6>
                        <h2 class="text-white fw-bold mb-0" style="font-size: 2.5rem;">{{ $items->where('status', 'in_use')->count() }}</h2>
                    </div>
                    <div class="icon-box" style="background: rgba(255,255,255,0.25); width: 60px; height: 60px; border-radius: 15px;">
                        <i class="fas fa-user-check text-white" style="font-size: 24px;"></i>
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
                        <h6 class="text-white text-uppercase small mb-2 fw-semibold" style="opacity: 0.9; letter-spacing: 0.5px;">Maintenance</h6>
                        <h2 class="text-white fw-bold mb-0" style="font-size: 2.5rem;">{{ $items->where('status', 'maintenance')->count() }}</h2>
                    </div>
                    <div class="icon-box" style="background: rgba(255,255,255,0.25); width: 60px; height: 60px; border-radius: 15px;">
                        <i class="fas fa-tools text-white" style="font-size: 24px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Card -->
<div class="card filter-card mb-4 animate-fade-in shadow-lg border-0" style="animation-delay: 0.5s;">
    <div class="card-header bg-white border-0 pb-0">
        <h6 class="card-title mb-0 fw-bold d-flex align-items-center" style="color: #374151;">
            <div class="icon-box me-3" style="background: var(--primary-gradient); width: 35px; height: 35px; font-size: 14px;">
                <i class="fas fa-filter text-white"></i>
            </div>
            Filter & Search
        </h6>
    </div>
    <div class="card-body p-4">
        <form method="GET" action="{{ route('inventory.index') }}">
            <div class="row g-4 align-items-end">
                <!-- Search Input -->
                <div class="col-lg-5 col-md-12">
                    <label class="form-label fw-semibold mb-2" style="color: #374151; font-size: 0.875rem;">Search Items</label>
                    <div class="position-relative">
                        <input type="text" name="search" class="form-control search-box border-0 shadow-sm ps-5"
                               style="border-radius: 15px; padding: 12px 20px 12px 45px; background: rgba(255,255,255,0.9);"
                               placeholder="Search by name, brand, model, or serial..."
                               value="{{ request('search') }}">
                        <div class="position-absolute top-50 start-0 translate-middle-y ps-3">
                            <i class="fas fa-search" style="color: #9ca3af;"></i>
                        </div>
                    </div>
                </div>

                <!-- Status Filter -->
                <div class="col-lg-2 col-md-4">
                    <label class="form-label fw-semibold mb-2" style="color: #374151; font-size: 0.875rem;">Status</label>
                    <select name="status" class="form-select search-box border-0 shadow-sm" style="border-radius: 15px; padding: 12px 16px; background: rgba(255,255,255,0.9);">
                        <option value="">All Status</option>
                        <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>
                            🟢 Available
                        </option>
                        <option value="in_use" {{ request('status') === 'in_use' ? 'selected' : '' }}>
                            🔵 In Use
                        </option>
                        <option value="maintenance" {{ request('status') === 'maintenance' ? 'selected' : '' }}>
                            🟡 Maintenance
                        </option>
                        <option value="retired" {{ request('status') === 'retired' ? 'selected' : '' }}>
                            🔴 Retired
                        </option>
                    </select>
                </div>

                <!-- Category Filter -->
                <div class="col-lg-3 col-md-4">
                    <label class="form-label fw-semibold mb-2" style="color: #374151; font-size: 0.875rem;">Category</label>
                    <select name="category" class="form-select search-box border-0 shadow-sm" style="border-radius: 15px; padding: 12px 16px; background: rgba(255,255,255,0.9);">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="col-lg-2 col-md-4">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-gradient shadow-sm flex-fill" style="border-radius: 15px; padding: 12px; font-weight: 600;">
                            <i class="fas fa-search me-1"></i>
                            <span class="d-none d-sm-inline">Search</span>
                        </button>
                        <a href="{{ route('inventory.index') }}" class="btn btn-outline-secondary shadow-sm" style="border-radius: 15px; padding: 12px; border-width: 2px;" title="Clear Filters">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Filter Buttons (Optional) -->
            <div class="row mt-3">
                <div class="col-12">
                    <div class="d-flex flex-wrap gap-2">
                        <small class="text-muted fw-semibold me-2 align-self-center">Quick Filters:</small>
                        <a href="{{ route('inventory.index', ['status' => 'available']) }}"
                           class="btn btn-sm btn-outline-success {{ request('status') === 'available' ? 'active' : '' }}"
                           style="border-radius: 50px; font-size: 0.75rem;">
                            Available Items
                        </a>
                        <a href="{{ route('inventory.index', ['status' => 'in_use']) }}"
                           class="btn btn-sm btn-outline-primary {{ request('status') === 'in_use' ? 'active' : '' }}"
                           style="border-radius: 50px; font-size: 0.75rem;">
                            In Use
                        </a>
                        <a href="{{ route('inventory.index', ['status' => 'maintenance']) }}"
                           class="btn btn-sm btn-outline-warning {{ request('status') === 'maintenance' ? 'active' : '' }}"
                           style="border-radius: 50px; font-size: 0.75rem;">
                            Maintenance
                        </a>
                        @if(request()->hasAny(['search', 'status', 'category']))
                            <a href="{{ route('inventory.index') }}"
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

<!-- Inventory Grid -->
<div class="row" id="inventory-grid">
    @forelse($items as $index => $item)
        <div class="col-xl-4 col-lg-6 mb-4 animate-fade-in" style="animation-delay: {{ 0.1 * ($index % 6) }}s;">
            <div class="card inventory-card h-100 border-0 shadow-lg hover:shadow-2xl transition-all duration-300">
                <div class="card-body p-4">
                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="flex-grow-1">
                            <h5 class="card-title font-bold text-gray-800 mb-1">{{ $item->name }}</h5>
                            <p class="text-gray-600 text-sm mb-0">
                                @if($item->brand || $item->model)
                                    {{ $item->brand }} {{ $item->model }}
                                @else
                                    No brand/model specified
                                @endif
                            </p>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-link text-gray-400 p-1" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-xl">
                                <li><a class="dropdown-item" href="{{ route('inventory.show', $item) }}">
                                    <i class="fas fa-eye me-2 text-blue-500"></i>View Details
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('inventory.edit', $item) }}">
                                    <i class="fas fa-edit me-2 text-yellow-500"></i>Edit Item
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="#" onclick="deleteItem({{ $item->id }})">
                                    <i class="fas fa-trash me-2"></i>Delete Item
                                </a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Status Badge -->
                    <div class="mb-3">
                        @php
                            $statusConfig = [
                                'available' => ['bg-green-100 text-green-800', 'fas fa-check-circle text-green-500'],
                                'in_use' => ['bg-blue-100 text-blue-800', 'fas fa-user-check text-blue-500'],
                                'maintenance' => ['bg-yellow-100 text-yellow-800', 'fas fa-tools text-yellow-500'],
                                'retired' => ['bg-red-100 text-red-800', 'fas fa-times-circle text-red-500']
                            ];
                            $config = $statusConfig[$item->status] ?? ['bg-gray-100 text-gray-800', 'fas fa-question-circle text-gray-500'];
                        @endphp
                        <span class="status-badge {{ $config[0] }}">
                            <i class="{{ $config[1] }} me-1"></i>
                            {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                        </span>
                    </div>

                    <!-- Details Grid -->
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <div class="bg-gray-50 rounded-lg p-3">
                                <div class="text-xs text-gray-500 font-semibold uppercase tracking-wider mb-1">Category</div>
                                <div class="text-sm font-medium text-gray-800">{{ $item->category->name }}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-gray-50 rounded-lg p-3">
                                <div class="text-xs text-gray-500 font-semibold uppercase tracking-wider mb-1">Location</div>
                                <div class="text-sm font-medium text-gray-800">{{ $item->location ?: 'Not specified' }}</div>
                            </div>
                        </div>
                        @if($item->serial_number)
                        <div class="col-12">
                            <div class="bg-blue-50 rounded-lg p-3">
                                <div class="text-xs text-blue-600 font-semibold uppercase tracking-wider mb-1">Serial Number</div>
                                <div class="text-sm font-mono font-medium text-blue-800">{{ $item->serial_number }}</div>
                            </div>
                        </div>
                        @endif
                        @if($item->assigned_to)
                        <div class="col-12">
                            <div class="bg-purple-50 rounded-lg p-3">
                                <div class="text-xs text-purple-600 font-semibold uppercase tracking-wider mb-1">Assigned To</div>
                                <div class="text-sm font-medium text-purple-800">
                                    <i class="fas fa-user me-1"></i>{{ $item->assigned_to }}
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Footer -->
                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                        <div class="text-xs text-gray-500">
                            <i class="fas fa-calendar me-1"></i>
                            Added {{ $item->created_at->diffForHumans() }}
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('inventory.show', $item) }}"
                               class="btn btn-sm btn-outline-primary rounded-full px-3 py-1 hover:bg-blue-500 hover:text-white transition-all duration-200">
                                <i class="fas fa-eye text-xs"></i>
                            </a>
                            <a href="{{ route('inventory.edit', $item) }}"
                               class="btn btn-sm btn-outline-warning rounded-full px-3 py-1 hover:bg-yellow-500 hover:text-white transition-all duration-200">
                                <i class="fas fa-edit text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card border-0 shadow-lg">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-inbox text-6xl text-gray-300"></i>
                    </div>
                    <h4 class="text-gray-600 font-semibold mb-2">No Inventory Items Found</h4>
                    <p class="text-gray-500 mb-4">Start by adding your first inventory item to track your IT assets.</p>
                    <a href="{{ route('inventory.create') }}" class="btn btn-gradient px-6 py-2 rounded-full">
                        <i class="fas fa-plus me-2"></i>Add First Item
                    </a>
                </div>
            </div>
        </div>
    @endforelse
</div>

<!-- Pagination -->
@if($items->hasPages())
    <div class="d-flex justify-content-center mt-5">
        <nav class="bg-white rounded-full shadow-lg px-2 py-2">
            {{ $items->appends(request()->query())->links('pagination::bootstrap-4') }}
        </nav>
    </div>
@endif

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-2xl rounded-3xl">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title font-bold text-gray-800">
                    <i class="fas fa-exclamation-triangle text-red-500 me-2"></i>
                    Confirm Delete
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 py-3">
                <p class="text-gray-600 mb-0">Are you sure you want to delete this item? This action cannot be undone and will permanently remove the item from your inventory.</p>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-outline-secondary rounded-full px-4" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger rounded-full px-4">
                        <i class="fas fa-trash me-2"></i>Delete Item
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function deleteItem(id) {
    const form = document.getElementById('deleteForm');
    form.action = `/inventory/${id}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
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
document.querySelectorAll('select[name="status"], select[name="category"]').forEach(select => {
    select.addEventListener('change', function() {
        this.closest('form').submit();
    });
});
</script>
@endpush
