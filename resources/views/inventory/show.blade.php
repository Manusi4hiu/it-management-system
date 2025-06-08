@extends('layouts.app')

@section('title', $inventory->name . ' - Inventory')
@section('page-title', $inventory->name)
@section('page-subtitle', $inventory->brand . ' ' . $inventory->model)

@section('page-actions')
<div class="d-flex gap-2">
    <button onclick="printItem()" class="btn btn-success" style="border-radius: 50px;">
        <i class="fas fa-print me-2"></i>Print
    </button>
    <a href="{{ route('inventory.edit', $inventory) }}" class="btn btn-gradient" style="border-radius: 50px;">
        <i class="fas fa-edit me-2"></i>Edit Item
    </a>
    <div class="dropdown">
        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" style="border-radius: 50px;">
            <i class="fas fa-cog me-2"></i>Actions
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="border-radius: 15px;">
            <li><a class="dropdown-item" href="#" onclick="generateQR()">
                <i class="fas fa-qrcode me-2 text-primary"></i>Generate QR Code
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
    </div>
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
                                    'Laptop' => 'fas fa-laptop',
                                    'Desktop' => 'fas fa-desktop',
                                    'Server' => 'fas fa-server',
                                    'Network Equipment' => 'fas fa-network-wired',
                                    'Printer' => 'fas fa-print',
                                    'Monitor' => 'fas fa-tv',
                                    'Storage' => 'fas fa-hdd',
                                    'Mobile Device' => 'fas fa-mobile-alt',
                                    'Accessories' => 'fas fa-keyboard',
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
                                'available' => ['bg-success', 'fas fa-check-circle'],
                                'in_use' => ['bg-primary', 'fas fa-user-check'],
                                'maintenance' => ['bg-warning', 'fas fa-tools'],
                                'retired' => ['bg-danger', 'fas fa-times-circle']
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
                        <div class="h-100 p-4" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-radius: 15px; border: 1px solid #cbd5e1;">
                            <h6 class="fw-bold mb-3 d-flex align-items-center" style="color: #1e293b;">
                                <i class="fas fa-info-circle me-2" style="color: #3b82f6;"></i>
                                Basic Information
                            </h6>
                            <div class="space-y-3">
                                <div class="d-flex justify-content-between py-2">
                                    <span class="fw-medium" style="color: #64748b;">Name:</span>
                                    <span class="fw-semibold" style="color: #1e293b;">{{ $inventory->name }}</span>
                                </div>
                                <div class="d-flex justify-content-between py-2">
                                    <span class="fw-medium" style="color: #64748b;">Category:</span>
                                    <span class="badge bg-primary px-3 py-1" style="border-radius: 50px;">
                                        {{ $inventory->category->name }}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between py-2">
                                    <span class="fw-medium" style="color: #64748b;">Brand:</span>
                                    <span class="fw-semibold" style="color: #1e293b;">{{ $inventory->brand ?: '-' }}</span>
                                </div>
                                <div class="d-flex justify-content-between py-2">
                                    <span class="fw-medium" style="color: #64748b;">Model:</span>
                                    <span class="fw-semibold" style="color: #1e293b;">{{ $inventory->model ?: '-' }}</span>
                                </div>
                                @if($inventory->serial_number)
                                <div class="d-flex justify-content-between py-2">
                                    <span class="fw-medium" style="color: #64748b;">Serial Number:</span>
                                    <code class="px-2 py-1" style="background: #e2e8f0; color: #1e293b; border-radius: 6px; font-size: 0.875rem;">{{ $inventory->serial_number }}</code>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Status & Assignment -->
                    <div class="col-md-6">
                        <div class="h-100 p-4" style="background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); border-radius: 15px; border: 1px solid #86efac;">
                            <h6 class="fw-bold mb-3 d-flex align-items-center" style="color: #1e293b;">
                                <i class="fas fa-user-cog me-2" style="color: #10b981;"></i>
                                Status & Assignment
                            </h6>
                            <div class="space-y-3">
                                <div class="d-flex justify-content-between align-items-center py-2">
                                    <span class="fw-medium" style="color: #064e3b;">Status:</span>
                                    <span class="badge {{ $config[0] }} px-3 py-1" style="border-radius: 50px;">
                                        <i class="{{ $config[1] }} me-1"></i>
                                        {{ ucfirst(str_replace('_', ' ', $inventory->status)) }}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between py-2">
                                    <span class="fw-medium" style="color: #064e3b;">Location:</span>
                                    <span class="fw-semibold" style="color: #1e293b;">
                                        @if($inventory->location)
                                            <i class="fas fa-map-marker-alt me-1" style="color: #ef4444;"></i>
                                            {{ $inventory->location }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between py-2">
                                    <span class="fw-medium" style="color: #064e3b;">Assigned To:</span>
                                    <span class="fw-semibold" style="color: #1e293b;">
                                        @if($inventory->assigned_to)
                                            <i class="fas fa-user me-1" style="color: #3b82f6;"></i>
                                            {{ $inventory->assigned_to }}
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
                <h5 class="card-title mb-0 fw-bold d-flex align-items-center">
                    <i class="fas fa-receipt me-2"></i>
                    Purchase & Financial Information
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="text-center p-4 h-100" style="background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); border-radius: 15px; border: 1px solid #86efac;">
                            <div class="icon-box mx-auto mb-3" style="background: #10b981; width: 50px; height: 50px; font-size: 20px;">
                                <i class="fas fa-dollar-sign text-white"></i>
                            </div>
                            <h6 class="fw-semibold mb-1" style="color: #064e3b;">Purchase Price</h6>
                            <h4 class="fw-bold" style="color: #059669;">
                                @if($inventory->purchase_price)
                                    Rp.{{ number_format($inventory->purchase_price, 2) }}
                                @else
                                    <span style="color: #6b7280;">Not specified</span>
                                @endif
                            </h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-4 h-100" style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); border-radius: 15px; border: 1px solid #93c5fd;">
                            <div class="icon-box mx-auto mb-3" style="background: #3b82f6; width: 50px; height: 50px; font-size: 20px;">
                                <i class="fas fa-calendar text-white"></i>
                            </div>
                            <h6 class="fw-semibold mb-1" style="color: #1e3a8a;">Purchase Date</h6>
                            <h6 class="fw-bold" style="color: #2563eb;">
                                @if($inventory->purchase_date)
                                    {{ $inventory->purchase_date->format('M d, Y') }}
                                    <br><small style="color: #3b82f6;">{{ $inventory->purchase_date->diffForHumans() }}</small>
                                @else
                                    <span style="color: #6b7280;">Not specified</span>
                                @endif
                            </h6>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-4 h-100" style="background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%); border-radius: 15px; border: 1px solid #c4b5fd;">
                            <div class="icon-box mx-auto mb-3" style="background: #8b5cf6; width: 50px; height: 50px; font-size: 20px;">
                                <i class="fas fa-shield-alt text-white"></i>
                            </div>
                            <h6 class="fw-semibold mb-1" style="color: #581c87;">Warranty</h6>
                            <h6 class="fw-bold">
                                @if($inventory->warranty_expiry)
                                    @if($inventory->warranty_expiry->isPast())
                                        <span style="color: #dc2626;">Expired</span>
                                        <br><small style="color: #ef4444;">{{ $inventory->warranty_expiry->diffForHumans() }}</small>
                                    @elseif($inventory->warranty_expiry->diffInDays() <= 30)
                                        <span style="color: #d97706;">Expiring Soon</span>
                                        <br><small style="color: #f59e0b;">{{ $inventory->warranty_expiry->diffForHumans() }}</small>
                                    @else
                                        <span style="color: #059669;">Active</span>
                                        <br><small style="color: #10b981;">{{ $inventory->warranty_expiry->diffForHumans() }}</small>
                                    @endif
                                @else
                                    <span style="color: #6b7280;">Not specified</span>
                                @endif
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description -->
        @if($inventory->description)
        <div class="card animate-fade-in shadow-lg border-0" style="animation-delay: 0.4s;">
            <div class="card-header text-white border-0" style="background: linear-gradient(135deg, #64748b 0%, #475569 100%); border-radius: 20px 20px 0 0;">
                <h5 class="card-title mb-0 fw-bold d-flex align-items-center">
                    <i class="fas fa-file-alt me-2"></i>
                    Description & Notes
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="p-4" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-radius: 15px; border: 1px solid #cbd5e1;">
                    <p class="mb-0" style="color: #374151; line-height: 1.6;">{{ $inventory->description }}</p>
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
                <h6 class="card-title mb-0 fw-bold d-flex align-items-center">
                    <i class="fas fa-bolt me-2"></i>
                    Quick Status Actions
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="d-grid gap-3">
                    @if($inventory->status === 'available')
                        <button class="btn btn-success shadow" onclick="changeStatus('in_use')" style="border-radius: 15px;">
                            <i class="fas fa-user-check me-2"></i>Mark as In Use
                        </button>
                        <button class="btn btn-warning shadow" onclick="changeStatus('maintenance')" style="border-radius: 15px;">
                            <i class="fas fa-tools me-2"></i>Send to Maintenance
                        </button>
                    @elseif($inventory->status === 'in_use')
                        <button class="btn btn-info shadow" onclick="changeStatus('available')" style="border-radius: 15px;">
                            <i class="fas fa-check-circle me-2"></i>Mark as Available
                        </button>
                        <button class="btn btn-warning shadow" onclick="changeStatus('maintenance')" style="border-radius: 15px;">
                            <i class="fas fa-tools me-2"></i>Send to Maintenance
                        </button>
                    @elseif($inventory->status === 'maintenance')
                        <button class="btn btn-success shadow" onclick="changeStatus('available')" style="border-radius: 15px;">
                            <i class="fas fa-check-circle me-2"></i>Mark as Available
                        </button>
                        <button class="btn btn-primary shadow" onclick="changeStatus('in_use')" style="border-radius: 15px;">
                            <i class="fas fa-user-check me-2"></i>Mark as In Use
                        </button>
                    @elseif($inventory->status === 'maintenance')
                        <button class="btn btn-success shadow" onclick="changeStatus('available')" style="border-radius: 15px;">
                            <i class="fas fa-check-circle me-2"></i>Mark as Available
                        </button>
                        <button class="btn btn-primary shadow" onclick="changeStatus('in_use')" style="border-radius: 15px;">
                            <i class="fas fa-user-check me-2"></i>Mark as In Use
                        </button>
                    @endif

                    @if($inventory->status !== 'retired')
                        <button class="btn btn-danger shadow" onclick="changeStatus('retired')" style="border-radius: 15px;">
                            <i class="fas fa-times-circle me-2"></i>Retire Item
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Item Statistics -->
        <div class="card animate-slide-in shadow-lg border-0 mb-4" style="animation-delay: 0.3s;">
            <div class="card-header text-white border-0" style="background: var(--success-gradient); border-radius: 20px 20px 0 0;">
                <h6 class="card-title mb-0 fw-bold d-flex align-items-center">
                    <i class="fas fa-chart-line me-2"></i>
                    Item Statistics
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="d-flex flex-column gap-3">
                    <div class="p-3" style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); border-radius: 12px;">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-medium" style="color: #1e3a8a;">Age</span>
                            <span class="fw-bold" style="color: #2563eb;">{{ $inventory->created_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    <div class="p-3" style="background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%); border-radius: 12px;">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-medium" style="color: #14532d;">Last Updated</span>
                            <span class="fw-bold" style="color: #059669;">{{ $inventory->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    @if($inventory->purchase_date)
                    <div class="p-3" style="background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%); border-radius: 12px;">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-medium" style="color: #581c87;">Owned for</span>
                            <span class="fw-bold" style="color: #7c3aed;">{{ $inventory->purchase_date->diffForHumans() }}</span>
                        </div>
                    </div>
                    @endif

                    @if($inventory->purchase_price && $inventory->purchase_date)
                    @php
                        $yearsOwned = $inventory->purchase_date->diffInYears(now());
                        $monthsOwned = $inventory->purchase_date->diffInMonths(now());
                        $depreciationRate = 0.2; // 20% per year
                        $currentValue = max(0, $inventory->purchase_price * pow(1 - $depreciationRate, $yearsOwned));
                    @endphp
                    <div class="p-3" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border-radius: 12px;">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-medium" style="color: #92400e;">Est. Value</span>
                            <span class="fw-bold" style="color: #d97706;">Rp.{{ number_format($currentValue, 2) }}</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- QR Code -->
        <div class="card animate-slide-in shadow-lg border-0" style="animation-delay: 0.5s;">
            <div class="card-header text-white border-0" style="background: linear-gradient(135deg, #64748b 0%, #475569 100%); border-radius: 20px 20px 0 0;">
                <h6 class="card-title mb-0 fw-bold d-flex align-items-center">
                    <i class="fas fa-qrcode me-2"></i>
                    QR Code
                </h6>
            </div>
            <div class="card-body p-4 text-center">
                <div class="bg-white p-4 mb-3 d-inline-block" style="border-radius: 15px; border: 2px solid #e5e7eb;">
                    <div id="qrcode" class="mx-auto"></div>
                </div>
                <p class="small mb-3" style="color: #6b7280;">Scan to view item details</p>
                <button class="btn btn-outline-primary btn-sm" onclick="downloadQR()" style="border-radius: 50px;">
                    <i class="fas fa-download me-2"></i>Download QR
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Print Layout (Hidden on Screen)-->
<div class="print-only" style="display: none;">
    <!-- Print Header -->
    <div class="print-header" style="text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 15px;">
        <h1 style="margin: 0; font-size: 24pt; font-weight: bold; color: #333;">IT INVENTORY REPORT</h1>
        <p style="margin: 5px 0 0 0; font-size: 12pt; color: #666;">Generated on {{ now()->format('F d, Y H:i') }}</p>
    </div>

    <!-- Print Content in Compact Layout -->
    <div class="print-content">
        <!-- Item Overview - Compact -->
        <div style="margin-bottom: 15px;">
            <div style="background: #f8f9fa; padding: 15px; border: 1px solid #ddd; border-radius: 8px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                    <h2 style="margin: 0; font-size: 18pt; color: #333;">{{ $inventory->name }}</h2>
                    <div style="background: #333; color: white; padding: 5px 10px; border-radius: 15px; font-size: 10pt;">
                        {{ ucfirst(str_replace('_', ' ', $inventory->status)) }}
                    </div>
                </div>
                <p style="margin: 0; color: #666; font-size: 11pt;">
                    {{ $inventory->category->name }}
                    @if($inventory->brand || $inventory->model)
                        • {{ $inventory->brand }} {{ $inventory->model }}
                    @endif
                </p>
            </div>
        </div>

        <!-- Two Column Layout for Details -->
        <div style="display: flex; gap: 15px; margin-bottom: 15px;">
            <!-- Left Column -->
            <div style="flex: 1;">
                <div style="background: #f8f9fa; padding: 12px; border: 1px solid #ddd; border-radius: 8px; height: 100%;">
                    <h3 style="margin: 0 0 10px 0; font-size: 12pt; color: #333; border-bottom: 1px solid #ddd; padding-bottom: 5px;">Basic Information</h3>
                    <table style="width: 100%; font-size: 10pt;">
                        <tr><td style="padding: 3px 0; color: #666; width: 40%;">Name:</td><td style="padding: 3px 0; font-weight: bold;">{{ $inventory->name }}</td></tr>
                        <tr><td style="padding: 3px 0; color: #666;">Category:</td><td style="padding: 3px 0; font-weight: bold;">{{ $inventory->category->name }}</td></tr>
                        <tr><td style="padding: 3px 0; color: #666;">Brand:</td><td style="padding: 3px 0; font-weight: bold;">{{ $inventory->brand ?: '-' }}</td></tr>
                        <tr><td style="padding: 3px 0; color: #666;">Model:</td><td style="padding: 3px 0; font-weight: bold;">{{ $inventory->model ?: '-' }}</td></tr>
                        @if($inventory->serial_number)
                        <tr><td style="padding: 3px 0; color: #666;">Serial Number:</td><td style="padding: 3px 0; font-family: monospace; background: #e9ecef; padding: 2px 4px; border-radius: 3px;">{{ $inventory->serial_number }}</td></tr>
                        @endif
                    </table>
                </div>
            </div>

            <!-- Right Column -->
            <div style="flex: 1;">
                <div style="background: #f8f9fa; padding: 12px; border: 1px solid #ddd; border-radius: 8px; height: 100%;">
                    <h3 style="margin: 0 0 10px 0; font-size: 12pt; color: #333; border-bottom: 1px solid #ddd; padding-bottom: 5px;">Status & Assignment</h3>
                    <table style="width: 100%; font-size: 10pt;">
                        <tr><td style="padding: 3px 0; color: #666; width: 40%;">Status:</td><td style="padding: 3px 0; font-weight: bold;">{{ ucfirst(str_replace('_', ' ', $inventory->status)) }}</td></tr>
                        <tr><td style="padding: 3px 0; color: #666;">Location:</td><td style="padding: 3px 0; font-weight: bold;">{{ $inventory->location ?: '-' }}</td></tr>
                        <tr><td style="padding: 3px 0; color: #666;">Assigned To:</td><td style="padding: 3px 0; font-weight: bold;">{{ $inventory->assigned_to ?: '-' }}</td></tr>
                        <tr><td style="padding: 3px 0; color: #666;">Added:</td><td style="padding: 3px 0; font-weight: bold;">{{ $inventory->created_at->format('M d, Y') }}</td></tr>
                        <tr><td style="padding: 3px 0; color: #666;">Last Updated:</td><td style="padding: 3px 0; font-weight: bold;">{{ $inventory->updated_at->format('M d, Y') }}</td></tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Financial Information - Horizontal Layout -->
        <div style="margin-bottom: 15px;">
            <div style="background: #f8f9fa; padding: 12px; border: 1px solid #ddd; border-radius: 8px;">
                <h3 style="margin: 0 0 10px 0; font-size: 12pt; color: #333; border-bottom: 1px solid #ddd; padding-bottom: 5px;">Purchase & Financial Information</h3>
                <div style="display: flex; gap: 20px;">
                    <div style="flex: 1; text-align: center;">
                        <div style="font-size: 10pt; color: #666; margin-bottom: 3px;">Purchase Price</div>
                        <div style="font-size: 14pt; font-weight: bold; color: #333;">
                            @if($inventory->purchase_price)
                                ${{ number_format($inventory->purchase_price, 2) }}
                            @else
                                Not specified
                            @endif
                        </div>
                    </div>
                    <div style="flex: 1; text-align: center;">
                        <div style="font-size: 10pt; color: #666; margin-bottom: 3px;">Purchase Date</div>
                        <div style="font-size: 12pt; font-weight: bold; color: #333;">
                            @if($inventory->purchase_date)
                                {{ $inventory->purchase_date->format('M d, Y') }}
                            @else
                                Not specified
                            @endif
                        </div>
                    </div>
                    <div style="flex: 1; text-align: center;">
                        <div style="font-size: 10pt; color: #666; margin-bottom: 3px;">Warranty Status</div>
                        <div style="font-size: 12pt; font-weight: bold; color: #333;">
                            @if($inventory->warranty_expiry)
                                @if($inventory->warranty_expiry->isPast())
                                    Expired
                                @elseif($inventory->warranty_expiry->diffInDays() <= 30)
                                    Expiring Soon
                                @else
                                    Active
                                @endif
                            @else
                                Not specified
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description and QR Code Side by Side -->
        <div style="display: flex; gap: 15px;">
            <!-- Description -->
            @if($inventory->description)
            <div style="flex: 2;">
                <div style="background: #f8f9fa; padding: 12px; border: 1px solid #ddd; border-radius: 8px; height: 120px;">
                    <h3 style="margin: 0 0 8px 0; font-size: 12pt; color: #333; border-bottom: 1px solid #ddd; padding-bottom: 5px;">Description</h3>
                    <p style="margin: 0; font-size: 10pt; color: #555; line-height: 1.4; overflow: hidden; text-overflow: ellipsis;">{{ $inventory->description }}</p>
                </div>
            </div>
            @endif

            <!-- QR Code -->
            <div style="flex: 1;">
                <div style="background: #f8f9fa; padding: 12px; border: 1px solid #ddd; border-radius: 8px; text-align: center; height: 120px;">
                    <h3 style="margin: 0 0 8px 0; font-size: 12pt; color: #333; border-bottom: 1px solid #ddd; padding-bottom: 5px;">QR Code</h3>
                    <div id="qrcode-print" style="display: inline-block;"></div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div style="margin-top: 20px; padding-top: 10px; border-top: 1px solid #ddd; text-align: center; font-size: 9pt; color: #666;">
            <p style="margin: 0;">This report was generated automatically by IT Management System</p>
            <p style="margin: 0;">For more information, visit: {{ route('inventory.show', $inventory) }}</p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- QR Code Library -->
<script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>

<style>
/* Print Styles - Optimized for 1 Page */
@media print {
    @page {
        size: A4;
        margin: 0.5in;
    }

    .no-print {
        display: none !important;
    }

    .print-only {
        display: block !important;
    }

    body {
        background: white !important;
        font-family: Arial, sans-serif !important;
        font-size: 10pt !important;
        line-height: 1.3 !important;
        color: #333 !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    * {
        -webkit-print-color-adjust: exact !important;
        color-adjust: exact !important;
        box-sizing: border-box !important;
    }

    .print-content {
        max-width: 100% !important;
        overflow: hidden !important;
    }

    .print-content h1, .print-content h2, .print-content h3 {
        color: #333 !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .print-content table {
        border-collapse: collapse !important;
        width: 100% !important;
    }

    .print-content td {
        vertical-align: top !important;
    }

    /* Hide all screen elements */
    .card, .btn, .dropdown, .sidebar, .animate-fade-in, .animate-slide-in {
        display: none !important;
    }

    /* Ensure QR code prints properly */
    #qrcode-print canvas {
        max-width: 80px !important;
        max-height: 80px !important;
    }

    /* Prevent page breaks inside important sections */
    .print-content > div {
        page-break-inside: avoid !important;
    }

    /* Ensure content fits on one page */
    .print-only {
        max-height: 10in !important;
        overflow: hidden !important;
    }
}

/* Screen-only styles */
@media screen {
    .print-only {
        display: none !important;
    }
}
</style>

<script>
// Generate QR Code
document.addEventListener('DOMContentLoaded', function() {
    const qrData = {
        id: {{ $inventory->id }},
        name: "{{ $inventory->name }}",
        serial: "{{ $inventory->serial_number }}",
        status: "{{ $inventory->status }}",
        url: "{{ route('inventory.show', $inventory) }}"
    };

    // QR Code for screen
    QRCode.toCanvas(document.getElementById('qrcode'), JSON.stringify(qrData), {
        width: 150,
        margin: 2,
        color: {
            dark: '#000000',
            light: '#FFFFFF'
        }
    });

    // QR Code for print (smaller size)
    QRCode.toCanvas(document.getElementById('qrcode-print'), JSON.stringify(qrData), {
        width: 80,
        margin: 1,
        color: {
            dark: '#000000',
            light: '#FFFFFF'
        }
    });
});

function printItem() {
    window.print();
}

function changeStatus(newStatus) {
    if (confirm(`Are you sure you want to change the status to "${newStatus.replace('_', ' ')}"?`)) {
        // Create form and submit
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("inventory.update", $inventory) }}';

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
            'name': '{{ $inventory->name }}',
            'category_id': '{{ $inventory->category_id }}',
            'brand': '{{ $inventory->brand }}',
            'model': '{{ $inventory->model }}',
            'serial_number': '{{ $inventory->serial_number }}',
            'location': '{{ $inventory->location }}',
            'assigned_to': '{{ $inventory->assigned_to }}',
            'purchase_price': '{{ $inventory->purchase_price }}',
            'description': '{{ $inventory->description }}'
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

        @if($inventory->purchase_date)
        const purchaseDateField = document.createElement('input');
        purchaseDateField.type = 'hidden';
        purchaseDateField.name = 'purchase_date';
        purchaseDateField.value = '{{ $inventory->purchase_date->format('Y-m-d') }}';
        form.appendChild(purchaseDateField);
        @endif

        @if($inventory->warranty_expiry)
        const warrantyField = document.createElement('input');
        warrantyField.type = 'hidden';
        warrantyField.name = 'warranty_expiry';
        warrantyField.value = '{{ $inventory->warranty_expiry->format('Y-m-d') }}';
        form.appendChild(warrantyField);
        @endif

        form.appendChild(csrfToken);
        form.appendChild(methodField);
        form.appendChild(statusField);

        document.body.appendChild(form);
        form.submit();
    }
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

function generateQR() {
    alert('QR Code is already generated below!');
    document.getElementById('qrcode').scrollIntoView({ behavior: 'smooth' });
}

function exportPDF() {
    alert('PDF export functionality would be implemented here');
}

function duplicateItem() {
    if (confirm('Create a duplicate of this item?')) {
        const url = new URL('{{ route("inventory.create") }}');
        url.searchParams.set('duplicate', '{{ $inventory->id }}');
        window.location.href = url.toString();
    }
}

function downloadQR() {
    const canvas = document.querySelector('#qrcode canvas');
    const link = document.createElement('a');
    link.download = `{{ $inventory->name }}-qr-code.png`;
    link.href = canvas.toDataURL();
    link.click();
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
</script>
@endpush
