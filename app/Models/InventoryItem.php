<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'brand',
        'model',
        'serial_number',
        'category_id',
        'status',
        'location',
        'description',
        'purchase_price',
        'purchase_date',
        'warranty_expiry',
        'assigned_to',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'warranty_expiry' => 'date',
        'purchase_price' => 'decimal:2',
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'available' => '<span class="badge bg-success">Available</span>',
            'in_use' => '<span class="badge bg-primary">In Use</span>',
            'maintenance' => '<span class="badge bg-warning">Maintenance</span>',
            'retired' => '<span class="badge bg-danger">Retired</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }
}
