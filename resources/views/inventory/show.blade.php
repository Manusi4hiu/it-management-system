@extends('layouts.app')

@section('title', $inventory->name . ' - Inventory')
@section('page-title', $inventory->name)
@section('page-subtitle', ($inventory->brand || $inventory->model) ? $inventory->brand . ' ' . $inventory->model : 'Item Details')

@section('page-actions')
<div class="d-flex gap-2">
    <button onclick="printItem()" class="btn btn-success" style="border-radius: 50px;">
        <i class="fas fa-print me-2"></i>Print
    </button>
    <a href="{{ route('inventory.edit', $inventory) }}" class="btn btn-gradient" style="border-radius: 50px;">
        <i class="fas fa-edit me-2"></i>Edit Item
    </a>
    {{-- <div class="dropdown">
        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" style="border-radius: 50px;">
            <i class="fas fa-cog me-2"></i>Actions
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="border-radius: 15px;">
            <li><a class="dropdown-item" href="#" onclick="generateQR()">
                <i class="fas fa-qrcode me-2 text-primary"></i>Show QR Code
            </a></li>
            <li><a class="dropdown-item" href="#" onclick="exportPDF()">
                <i class="fas fa-file-pdf me-2 text-danger"></i>Export PDF
            </a></li>
            <li><a class="dropdown-item" href="#" onclick="duplicateItem()">
                <i class="fas fa-copy me-2 text-info"></i>Duplicate Item
            </a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="#" onclick="deleteItem()">
                <i class="fas fa-trash me-2"></i>Delete Item
            </a></li>
        </ul>
    </div> --}}
    <a href="{{ route('inventory.index') }}" class="btn btn-outline-secondary" style="border-radius: 50px;">
        <i class="fas fa-arrow-left me-2"></i>Back
    </a>
</div>
@endsection

@section('content')
<div class="row" id="printable-content">
    <!-- Main Content -->
    <div class="col-lg-8">
        <!-- Item Overview Card -->
        <div class="card animate-fade-in shadow-lg border-0 mb-4">
            <div class="card-header text-white border-0" style="background: var(--primary-gradient); border-radius: 20px 20px 0 0;">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="icon-box me-4" style="background: rgba(255,255,255,0.2); width: 60px; height: 60px; font-size: 24px;">
                            @php
                                $categoryIcons = [
                                    'Laptop' => 'fas fa-laptop', 'Desktop' => 'fas fa-desktop', 'Server' => 'fas fa-server',
                                    'Network Equipment' => 'fas fa-network-wired', 'Printer' => 'fas fa-print', 'Monitor' => 'fas fa-tv',
                                    'Storage' => 'fas fa-hdd', 'Mobile Device' => 'fas fa-mobile-alt', 'Accessories' => 'fas fa-keyboard',
                                    'Software License' => 'fas fa-key'
                                ];
                                $icon = $categoryIcons[$inventory->category->name] ?? 'fas fa-box';
                            @endphp
                            <i class="{{ $icon }} text-white"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-1 text-white">{{ $inventory->name }}</h4>
                            <p class="text-white mb-0" style="opacity: 0.9;">
                                {{ $inventory->category->name }}
                                @if($inventory->brand || $inventory->model)
                                    • {{ $inventory->brand }} {{ $inventory->model }}
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="text-end">
                        @php
                            $statusConfig = [
                                'available' => ['bg-success', 'fas fa-check-circle'], 'in_use' => ['bg-primary', 'fas fa-user-check'],
                                'maintenance' => ['bg-warning', 'fas fa-tools'], 'retired' => ['bg-danger', 'fas fa-times-circle']
                            ];
                            $config = $statusConfig[$inventory->status] ?? ['bg-secondary', 'fas fa-question-circle'];
                        @endphp
                        <div class="badge {{ $config[0] }} px-3 py-2 fs-6">
                            <i class="{{ $config[1] }} me-2"></i>
                            {{ ucfirst(str_replace('_', ' ', $inventory->status)) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <!-- Basic Information -->
                    <div class="col-md-6">
                        <div class="h-100 p-4" style="background: var(--bg-secondary); border-radius: 15px; border: 1px solid var(--border-color);">
                            <h6 class="fw-bold mb-3 d-flex align-items-center" style="color: var(--text-primary);">
                                <i class="fas fa-info-circle me-2 text-primary"></i>
                                Basic Information
                            </h6>
                            <div class="d-flex flex-column gap-2">
                                <div class="d-flex justify-content-between py-2 border-bottom border-opacity-10">
                                    <span class="fw-medium text-secondary">Name:</span>
                                    <span class="fw-semibold text-primary text-end">{{ $inventory->name }}</span>
                                </div>
                                <div class="d-flex justify-content-between py-2 border-bottom border-opacity-10">
                                    <span class="fw-medium text-secondary">Category:</span>
                                    <span class="badge bg-primary px-3 py-1" style="border-radius: 50px;">{{ $inventory->category->name }}</span>
                                </div>
                                <div class="d-flex justify-content-between py-2 border-bottom border-opacity-10">
                                    <span class="fw-medium text-secondary">Brand:</span>
                                    <span class="fw-semibold text-primary text-end">{{ $inventory->brand ?: '-' }}</span>
                                </div>
                                <div class="d-flex justify-content-between py-2 border-bottom border-opacity-10">
                                    <span class="fw-medium text-secondary">Model:</span>
                                    <span class="fw-semibold text-primary text-end">{{ $inventory->model ?: '-' }}</span>
                                </div>
                                @if($inventory->serial_number)
                                <div class="d-flex justify-content-between py-2">
                                    <span class="fw-medium text-secondary">Serial Number:</span>
                                    <code class="px-2 py-1" style="background: var(--border-color); color: var(--text-primary); border-radius: 6px; font-size: 0.875rem;">{{ $inventory->serial_number }}</code>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- Status & Assignment -->
                    <div class="col-md-6">
                        <div class="h-100 p-4" style="background: var(--bg-secondary); border-radius: 15px; border: 1px solid var(--border-color);">
                            <h6 class="fw-bold mb-3 d-flex align-items-center" style="color: var(--text-primary);">
                                <i class="fas fa-user-cog me-2 text-success"></i>
                                Status & Assignment
                            </h6>
                            <div class="d-flex flex-column gap-2">
                                <div class="d-flex justify-content-between align-items-center py-2 border-bottom border-opacity-10">
                                    <span class="fw-medium text-secondary">Status:</span>
                                    <span class="badge {{ $config[0] }} px-3 py-1" style="border-radius: 50px;"><i class="{{ $config[1] }} me-1"></i>{{ ucfirst(str_replace('_', ' ', $inventory->status)) }}</span>
                                </div>
                                <div class="d-flex justify-content-between py-2 border-bottom border-opacity-10">
                                    <span class="fw-medium text-secondary">Location:</span>
                                    <span class="fw-semibold text-primary text-end">
                                        @if($inventory->location)
                                            <i class="fas fa-map-marker-alt me-1 text-danger"></i>{{ $inventory->location }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between py-2">
                                    <span class="fw-medium text-secondary">Assigned To:</span>
                                    <span class="fw-semibold text-primary text-end">
                                        @if($inventory->assigned_to)
                                            <i class="fas fa-user me-1 text-info"></i>{{ $inventory->assigned_to }}
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
        <!-- Purchase & Financial Information -->
        <div class="card animate-fade-in shadow-lg border-0 mb-4" style="animation-delay: 0.2s;">
            <div class="card-header text-white border-0" style="background: var(--warning-gradient); border-radius: 20px 20px 0 0;">
                <h5 class="card-title mb-0 fw-bold d-flex align-items-center"><i class="fas fa-receipt me-2"></i>Purchase & Financial Information</h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="text-center p-4 h-100" style="background: var(--bg-secondary); border-radius: 15px; border: 1px solid var(--border-color);">
                            <div class="icon-box mx-auto mb-3" style="background: #10b981; width: 50px; height: 50px; font-size: 20px;"><i class="fas fa-dollar-sign text-white"></i></div>
                            <h6 class="fw-semibold mb-1 text-secondary">Purchase Price</h6>
                            <h4 class="fw-bold text-success">@if($inventory->purchase_price) Rp.{{ number_format($inventory->purchase_price, 2) }} @else <span class="text-secondary">Not specified</span> @endif</h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-4 h-100" style="background: var(--bg-secondary); border-radius: 15px; border: 1px solid var(--border-color);">
                            <div class="icon-box mx-auto mb-3" style="background: #3b82f6; width: 50px; height: 50px; font-size: 20px;"><i class="fas fa-calendar text-white"></i></div>
                            <h6 class="fw-semibold mb-1 text-secondary">Purchase Date</h6>
                            <h6 class="fw-bold text-primary">@if($inventory->purchase_date) {{ $inventory->purchase_date->format('M d, Y') }}<br><small class="text-info">{{ $inventory->purchase_date->diffForHumans() }}</small> @else <span class="text-secondary">Not specified</span> @endif</h6>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-4 h-100" style="background: var(--bg-secondary); border-radius: 15px; border: 1px solid var(--border-color);">
                            <div class="icon-box mx-auto mb-3" style="background: #8b5cf6; width: 50px; height: 50px; font-size: 20px;"><i class="fas fa-shield-alt text-white"></i></div>
                            <h6 class="fw-semibold mb-1 text-secondary">Warranty</h6>
                            <h6 class="fw-bold">@if($inventory->warranty_expiry) @if($inventory->warranty_expiry->isPast()) <span class="text-danger">Expired</span><br><small class="text-danger">{{ $inventory->warranty_expiry->diffForHumans() }}</small> @elseif($inventory->warranty_expiry->diffInDays() <= 30) <span class="text-warning">Expiring Soon</span><br><small class="text-warning">{{ $inventory->warranty_expiry->diffForHumans() }}</small> @else <span class="text-success">Active</span><br><small class="text-success">{{ $inventory->warranty_expiry->diffForHumans() }}</small> @endif @else <span class="text-secondary">Not specified</span> @endif</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Description -->
        @if($inventory->description)
        <div class="card animate-fade-in shadow-lg border-0" style="animation-delay: 0.4s;">
            <div class="card-header text-white border-0" style="background: linear-gradient(135deg, #64748b 0%, #475569 100%); border-radius: 20px 20px 0 0;">
                <h5 class="card-title mb-0 fw-bold d-flex align-items-center"><i class="fas fa-file-alt me-2"></i>Description & Notes</h5>
            </div>
            <div class="card-body p-4">
                <div class="p-4" style="background: var(--bg-secondary); border-radius: 15px; border: 1px solid var(--border-color);">
                    <p class="mb-0 text-primary" style="line-height: 1.6;">{{ $inventory->description }}</p>
                </div>
            </div>
        </div>
        @endif
    </div>
    <!-- Sidebar -->
    <div class="col-lg-4 no-print">
        <!-- Quick Status Actions -->
        <div class="card animate-slide-in shadow-lg border-0 mb-4" style="animation-delay: 0.1s;">
            <div class="card-header text-white border-0" style="background: var(--info-gradient); border-radius: 20px 20px 0 0;">
                <h6 class="card-title mb-0 fw-bold d-flex align-items-center"><i class="fas fa-bolt me-2"></i>Quick Status Actions</h6>
            </div>
            <div class="card-body p-4">
                <div class="d-grid gap-3">
                    @if($inventory->status === 'available')
                        <button class="btn btn-success shadow" onclick="changeStatus('in_use')" style="border-radius: 15px;"><i class="fas fa-user-check me-2"></i>Mark as In Use</button>
                        <button class="btn btn-warning shadow" onclick="changeStatus('maintenance')" style="border-radius: 15px;"><i class="fas fa-tools me-2"></i>Send to Maintenance</button>
                    @elseif($inventory->status === 'in_use')
                        <button class="btn btn-info shadow" onclick="changeStatus('available')" style="border-radius: 15px;"><i class="fas fa-check-circle me-2"></i>Mark as Available</button>
                        <button class="btn btn-warning shadow" onclick="changeStatus('maintenance')" style="border-radius: 15px;"><i class="fas fa-tools me-2"></i>Send to Maintenance</button>
                    @elseif($inventory->status === 'maintenance')
                        <button class="btn btn-success shadow" onclick="changeStatus('available')" style="border-radius: 15px;"><i class="fas fa-check-circle me-2"></i>Mark as Available</button>
                        <button class="btn btn-primary shadow" onclick="changeStatus('in_use')" style="border-radius: 15px;"><i class="fas fa-user-check me-2"></i>Mark as In Use</button>
                    @endif
                    @if($inventory->status !== 'retired')
                        <button class="btn btn-danger shadow" onclick="changeStatus('retired')" style="border-radius: 15px;"><i class="fas fa-times-circle me-2"></i>Retire Item</button>
                    @endif
                </div>
            </div>
        </div>
        <!-- Item Statistics -->
        <div class="card animate-slide-in shadow-lg border-0 mb-4" style="animation-delay: 0.3s;">
            <div class="card-header text-white border-0" style="background: var(--success-gradient); border-radius: 20px 20px 0 0;">
                <h6 class="card-title mb-0 fw-bold d-flex align-items-center"><i class="fas fa-chart-line me-2"></i>Item Statistics</h6>
            </div>
            <div class="card-body p-4">
                <div class="d-flex flex-column gap-3">
                    <div class="p-3" style="background: var(--bg-secondary); border-radius: 12px; border: 1px solid var(--border-color);">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-medium text-secondary">Age</span>
                            <span class="fw-bold text-primary">{{ $inventory->created_at->diffForHumans(null, true) }}</span>
                        </div>
                    </div>
                    <div class="p-3" style="background: var(--bg-secondary); border-radius: 12px; border: 1px solid var(--border-color);">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-medium text-secondary">Last Updated</span>
                            <span class="fw-bold text-primary">{{ $inventory->updated_at->diffForHumans(null, true) }}</span>
                        </div>
                    </div>
                    @if($inventory->purchase_date)
                    <div class="p-3" style="background: var(--bg-secondary); border-radius: 12px; border: 1px solid var(--border-color);">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-medium text-secondary">Owned for</span>
                            <span class="fw-bold text-primary">{{ $inventory->purchase_date->diffForHumans(null, true) }}</span>
                        </div>
                    </div>
                    @endif
                    @if($inventory->purchase_price && $inventory->purchase_date)
                    @php
                        $yearsOwned = $inventory->purchase_date->diffInYears(now());
                        $depreciationRate = 0.2; // 20% per year
                        $currentValue = max(0, $inventory->purchase_price * pow(1 - $depreciationRate, $yearsOwned));
                    @endphp
                    <div class="p-3" style="background: var(--bg-secondary); border-radius: 12px; border: 1px solid var(--border-color);">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-medium text-secondary">Est. Value</span>
                            <span class="fw-bold text-warning">Rp.{{ number_format($currentValue, 2) }}</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- QR Code -->
        {{-- <div class="card animate-slide-in shadow-lg border-0" style="animation-delay: 0.5s;">
            <div class="card-header text-white border-0" style="background: linear-gradient(135deg, #64748b 0%, #475569 100%); border-radius: 20px 20px 0 0;">
                <h6 class="card-title mb-0 fw-bold d-flex align-items-center"><i class="fas fa-qrcode me-2"></i>QR Code</h6>
            </div>
            <div class="card-body p-4 text-center">
                <div class="bg-white p-4 mb-3 d-inline-block" style="border-radius: 15px; border: 2px solid #e5e7eb;">
                    <div id="qrcode" class="mx-auto"></div>
                </div>
                <p class="small mb-3 text-secondary">Scan to view item details</p>
                <button class="btn btn-outline-primary btn-sm" onclick="downloadQR()" style="border-radius: 50px;"><i class="fas fa-download me-2"></i>Download QR</button>
            </div>
        </div> --}}
    </div>
</div>

<!-- Print Layout (Hidden on Screen)-->
<div class="print-only" style="display: none;">
    <!-- Konten untuk print di sini -->
    <div id="qrcode-print" style="display: none;"></div>
</div>

<!-- Generic Action Confirmation Modal -->
<div class="modal fade" id="actionConfirmationModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-2xl rounded-3xl">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="modalTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 py-3">
                <p class="text-secondary mb-0" id="modalBodyText"></p>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-outline-secondary rounded-full px-4" data-bs-dismiss="modal">Cancel</button>
                <form id="actionForm" method="POST" style="display: inline;">
                    @csrf
                    <input type="hidden" name="_method" id="formMethodInput">
                    <div id="formAdditionalInputs"></div>
                    <button type="submit" class="btn rounded-full px-4" id="modalConfirmButton"></button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- QR Code Library -->
<script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>
<style>
@media print {
    .no-print { display: none !important; }
    .print-only { display: block !important; }
    /* Tambahkan style print lainnya di sini */
}
@media screen {
    .print-only { display: none !important; }
}
</style>
<script>
let actionModal;

@php
    $qrData = [
        'id' => $inventory->id, 'name' => $inventory->name, 'serial' => $inventory->serial_number,
        'status' => $inventory->status, 'url' => route('inventory.show', $inventory)
    ];
@endphp

document.addEventListener('DOMContentLoaded', function() {
    actionModal = new bootstrap.Modal(document.getElementById('actionConfirmationModal'));

    const qrDataObject = @json($qrData);
    const qrDataString = JSON.stringify(qrDataObject);
    const qrCanvasScreen = document.getElementById('qrcode');
    const qrCanvasPrint = document.getElementById('qrcode-print');

    if (qrCanvasScreen) {
        QRCode.toCanvas(qrCanvasScreen, qrDataString, { width: 150, margin: 2, color: { dark: '#000000', light: '#FFFFFF' } }, function (error) {
            if (error) console.error('Failed to generate screen QR Code:', error);
        });
    }
    if (qrCanvasPrint) {
        QRCode.toCanvas(qrCanvasPrint, qrDataString, { width: 80, margin: 1, color: { dark: '#000000', light: '#FFFFFF' } }, function (error) {
            if (error) console.error('Failed to generate print QR Code:', error);
        });
    }
});

function showActionModal(config) {
    const modalTitle = document.getElementById('modalTitle');
    const modalBody = document.getElementById('modalBodyText');
    const modalConfirmBtn = document.getElementById('modalConfirmButton');
    const actionForm = document.getElementById('actionForm');
    const formMethodInput = document.getElementById('formMethodInput');
    const formAdditionalInputs = document.getElementById('formAdditionalInputs');

    actionForm.action = config.actionUrl;
    formMethodInput.value = config.method;
    formAdditionalInputs.innerHTML = '';

    if (config.additionalInputs) {
        Object.entries(config.additionalInputs).forEach(([name, value]) => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = value;
            formAdditionalInputs.appendChild(input);
        });
    }

    modalTitle.innerHTML = config.title;
    modalBody.textContent = config.body;
    modalConfirmBtn.innerHTML = config.confirmText;
    modalConfirmBtn.className = `btn rounded-full px-4 ${config.btnClass}`;

    actionForm.onsubmit = null;
    if (config.method.toUpperCase() === 'GET') {
        actionForm.onsubmit = (e) => {
            e.preventDefault();
            window.location.href = config.actionUrl;
        };
    }

    actionModal.show();
}

function confirmStatusChange(newStatus) {
    const statusText = newStatus.replace(/_/g, ' ');
    showActionModal({
        title: `<i class="fas fa-sync-alt text-warning me-2"></i>Confirm Status Change`,
        body: `Are you sure you want to change the status to "${statusText}"?`,
        confirmText: `<i class="fas fa-check me-2"></i>Yes, Change Status`,
        btnClass: 'btn-warning',
        actionUrl: '{{ route("inventory.update", $inventory) }}',
        method: 'PUT',
        additionalInputs: {
            name: '{{ addslashes($inventory->name) }}',
            category_id: '{{ $inventory->category_id }}',
            brand: '{{ addslashes($inventory->brand) }}',
            model: '{{ addslashes($inventory->model) }}',
            serial_number: '{{ addslashes($inventory->serial_number) }}',
            location: '{{ addslashes($inventory->location) }}',
            assigned_to: '{{ addslashes($inventory->assigned_to) }}',
            purchase_price: '{{ $inventory->purchase_price }}',
            description: '{{ addslashes($inventory->description) }}',
            purchase_date: '{{ $inventory->purchase_date ? $inventory->purchase_date->format("Y-m-d") : "" }}',
            warranty_expiry: '{{ $inventory->warranty_expiry ? $inventory->warranty_expiry->format("Y-m-d") : "" }}',
            status: newStatus
        }
    });
}

function confirmDelete() {
    showActionModal({
        title: `<i class="fas fa-exclamation-triangle text-danger me-2"></i>Confirm Delete`,
        body: 'Are you sure you want to delete this item? This action cannot be undone.',
        confirmText: `<i class="fas fa-trash me-2"></i>Delete Item`,
        btnClass: 'btn-danger',
        actionUrl: '{{ route("inventory.destroy", $inventory) }}',
        method: 'DELETE',
        additionalInputs: null
    });
}

function confirmDuplicate() {
    showActionModal({
        title: `<i class="fas fa-copy text-info me-2"></i>Confirm Duplicate`,
        body: 'This will open the "Add New Item" page with pre-filled data. Continue?',
        confirmText: `<i class="fas fa-check me-2"></i>Yes, Duplicate`,
        btnClass: 'btn-info',
        actionUrl: '{{ route("inventory.create") }}?duplicate={{ $inventory->id }}',
        method: 'GET',
        additionalInputs: null
    });
}

// Wrapper functions to be called by onclick attributes
function changeStatus(newStatus) { confirmStatusChange(newStatus); }
function deleteItem() { confirmDelete(); }
function duplicateItem() { confirmDuplicate(); }

// Other utility functions
function printItem() { window.print(); }
function generateQR() {
    const qrCard = document.getElementById('qrcode').closest('.card');
    if (qrCard) {
        qrCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
        qrCard.style.transition = 'all 0.2s ease-in-out';
        qrCard.style.transform = 'scale(1.03)';
        setTimeout(() => { qrCard.style.transform = 'scale(1)'; }, 400);
    }
}
function exportPDF() { alert('PDF export functionality is not yet implemented.'); }
function downloadQR() {
    const canvas = document.querySelector('#qrcode canvas');
    if (canvas) {
        const link = document.createElement('a');
        link.download = `{{ Str::slug($inventory->name) }}-qr-code.png`;
        link.href = canvas.toDataURL();
        link.click();
    }
}
</script>
@endpush
