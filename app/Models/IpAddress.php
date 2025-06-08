<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IpAddress extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'ip_address',
        'subnet_mask',
        'gateway',
        'dns_primary',
        'dns_secondary',
        'type',
        'status',
        'assigned_to',
        'device_name',
        'mac_address',
        'location',
        'notes',
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'available' => '<span class="badge bg-success">Available</span>',
            'assigned' => '<span class="badge bg-primary">Assigned</span>',
            'reserved' => '<span class="badge bg-warning">Reserved</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }

    public function getTypeBadgeAttribute(): string
    {
        return match($this->type) {
            'static' => '<span class="badge bg-info">Static</span>',
            'dhcp' => '<span class="badge bg-secondary">DHCP</span>',
            'reserved' => '<span class="badge bg-warning">Reserved</span>',
            default => '<span class="badge bg-light">Unknown</span>',
        };
    }
}
