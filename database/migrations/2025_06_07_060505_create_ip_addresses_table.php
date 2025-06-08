<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ip_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address')->unique();
            $table->string('subnet_mask')->default('255.255.255.0');
            $table->string('gateway')->nullable();
            $table->string('dns_primary')->nullable();
            $table->string('dns_secondary')->nullable();
            $table->enum('type', ['static', 'dhcp', 'reserved'])->default('static');
            $table->enum('status', ['available', 'assigned', 'reserved'])->default('available');
            $table->string('assigned_to')->nullable();
            $table->string('device_name')->nullable();
            $table->string('mac_address')->nullable();
            $table->string('location')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ip_addresses');
    }
};
