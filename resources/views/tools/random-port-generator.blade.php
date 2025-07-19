@extends('layouts.app')

@section('title', 'Random Port Generator - IT Management System')
@section('page-title', 'Random Port Generator')
@section('page-subtitle', 'Generate random port numbers outside of the "well-known" ports range (0-1023).')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
        <div class="card animate-fade-in shadow-lg border-0" style="animation-delay: 0.1s;">
            <div class="card-body text-center p-5">

                <!-- Port Display Area -->
                <div id="port-display-area" class="py-5 px-3 mb-4" style="background: var(--bg-primary); border-radius: 20px; border: 1px solid var(--border-color);">
                    <h1 id="port-number" class="display-1 fw-bold" style="font-size: 6rem; color: var(--text-primary); letter-spacing: 2px; transition: all 0.3s ease;">
                        {{ $initialPort }}
                    </h1>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-center gap-3">
                    <button id="copy-btn" class="btn btn-gradient px-4 py-2" style="min-width: 120px;">
                        <i class="fas fa-copy me-2"></i>
                        <span id="copy-btn-text">Copy</span>
                    </button>
                    <button id="refresh-btn" class="btn btn-outline-secondary px-4 py-2" style="min-width: 120px; border-radius: 50px; font-weight: 600; border-width: 2px;">
                        <i class="fas fa-sync-alt me-2"></i>
                        Refresh
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const portNumberEl = document.getElementById('port-number');
    const copyBtn = document.getElementById('copy-btn');
    const copyBtnText = document.getElementById('copy-btn-text');
    const refreshBtn = document.getElementById('refresh-btn');

    // Function to generate a random port
    const generateRandomPort = () => {
        // Range: 1024 (Registered Ports start) to 65535 (Max Port)
        return Math.floor(Math.random() * (65535 - 1024 + 1)) + 1024;
    };

    // Handle Refresh Button Click
    refreshBtn.addEventListener('click', function() {
        // Add a spinning animation to the icon
        const icon = this.querySelector('i');
        icon.classList.add('fa-spin');

        // Add a fade-out effect to the number
        portNumberEl.style.opacity = '0';
        portNumberEl.style.transform = 'scale(0.9)';

        setTimeout(() => {
            const newPort = generateRandomPort();
            portNumberEl.textContent = newPort;

            // Add a fade-in effect
            portNumberEl.style.opacity = '1';
            portNumberEl.style.transform = 'scale(1)';

            // Stop the spinning animation
            icon.classList.remove('fa-spin');
        }, 300); // Match timeout with CSS transition duration
    });

    // Handle Copy Button Click
    copyBtn.addEventListener('click', function() {
        const portToCopy = portNumberEl.textContent;

        navigator.clipboard.writeText(portToCopy).then(() => {
            // Success feedback
            const originalText = copyBtnText.textContent;
            copyBtnText.textContent = 'Copied!';
            this.classList.add('btn-success'); // Optional: change color to green
            this.querySelector('i').className = 'fas fa-check me-2';

            setTimeout(() => {
                copyBtnText.textContent = originalText;
                this.classList.remove('btn-success');
                this.querySelector('i').className = 'fas fa-copy me-2';
            }, 2000);
        }).catch(err => {
            // Error feedback (for older browsers or if permission is denied)
            console.error('Failed to copy: ', err);
            alert('Could not copy text. Please copy it manually.');
        });
    });
});
</script>
<style>
    .btn-success {
        background: var(--success-gradient) !important;
        color: white !important;
    }
</style>
@endpush
