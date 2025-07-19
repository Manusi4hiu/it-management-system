@extends('layouts.app')

@section('title', 'Bcrypt Generator - IT Management System')
@section('page-title', 'Bcrypt Generator')
@section('page-subtitle', 'Hash and compare text strings using Bcrypt. Bcrypt is a password-hashing function based on the Blowfish cipher.')

@section('content')
<div class="row g-4">
    <!-- Hashing Column -->
    <div class="col-lg-6">
        <div class="card animate-fade-in h-100 shadow-lg border-0" style="animation-delay: 0.1s;">
            <div class="card-header">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="fas fa-lock me-2 text-primary"></i>Hash
                </h5>
            </div>
            <div class="card-body d-flex flex-column">
                <form id="hash-form">
                    <div class="mb-3">
                        <label for="string_to_hash" class="form-label fw-medium">Your string</label>
                        <input type="text" class="form-control form-control-lg" id="string_to_hash" name="string_to_hash" placeholder="Your string to bcrypt..." required>
                    </div>
                    <div class="mb-4">
                        <label for="rounds" class="form-label fw-medium">Salt count (Rounds)</label>
                        <div class="input-group">
                            <button class="btn btn-outline-secondary" type="button" id="rounds-minus">-</button>
                            <input type="number" class="form-control form-control-lg text-center" id="rounds" name="rounds" value="10" min="4" max="31">
                            <button class="btn btn-outline-secondary" type="button" id="rounds-plus">+</button>
                        </div>
                    </div>
                </form>
                <div class="mt-auto">
                    <label class="form-label fw-medium">Generated Hash</label>
                    <div class="p-3 mb-3" style="background: var(--bg-primary); border: 1px solid var(--border-color); border-radius: 15px; min-height: 100px; word-wrap: break-word;">
                        <code id="hash-result" class="fs-6" style="color: var(--text-primary);"></code>
                    </div>
                    <button id="copy-hash-btn" class="btn btn-gradient w-100 py-2">
                        <i class="fas fa-copy me-2"></i>
                        <span id="copy-hash-text">Copy Hash</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Comparison Column -->
    <div class="col-lg-6">
        <div class="card animate-fade-in h-100 shadow-lg border-0" style="animation-delay: 0.2s;">
            <div class="card-header">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="fas fa-check-double me-2 text-success"></i>Compare string with hash
                </h5>
            </div>
            <div class="card-body d-flex flex-column">
                <form id="compare-form">
                    <div class="mb-3">
                        <label for="string_to_compare" class="form-label fw-medium">Your string</label>
                        <input type="text" class="form-control form-control-lg" id="string_to_compare" name="string_to_compare" placeholder="Your string to compare...">
                    </div>
                    <div class="mb-4">
                        <label for="hash_to_compare" class="form-label fw-medium">Your hash</label>
                        <input type="text" class="form-control form-control-lg" id="hash_to_compare" name="hash_to_compare" placeholder="Your hash to compare...">
                    </div>
                </form>
                <div class="mt-auto text-center">
                    <div id="compare-result-area" class="p-4" style="background: var(--bg-primary); border: 1px solid var(--border-color); border-radius: 15px;">
                        <h4 class="mb-0 fw-bold">Do they match? <span id="compare-result">--</span></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // --- Hashing Elements ---
    const hashForm = document.getElementById('hash-form');
    const stringToHashInput = document.getElementById('string_to_hash');
    const roundsInput = document.getElementById('rounds');
    const roundsMinusBtn = document.getElementById('rounds-minus');
    const roundsPlusBtn = document.getElementById('rounds-plus');
    const hashResultEl = document.getElementById('hash-result');
    const copyHashBtn = document.getElementById('copy-hash-btn');
    const copyHashText = document.getElementById('copy-hash-text');

    // --- Comparison Elements ---
    const compareForm = document.getElementById('compare-form');
    const stringToCompareInput = document.getElementById('string_to_compare');
    const hashToCompareInput = document.getElementById('hash_to_compare');
    const compareResultEl = document.getElementById('compare-result');

    // --- Hashing Logic ---
    const handleHash = async () => {
        if (!stringToHashInput.value) {
            hashResultEl.textContent = '';
            return;
        }

        try {
            const response = await fetch("{{ route('tools.bcrypt.hash') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    string_to_hash: stringToHashInput.value,
                    rounds: roundsInput.value
                })
            });

            const data = await response.json();
            if (data.success) {
                hashResultEl.textContent = data.hash;
            } else {
                hashResultEl.textContent = data.message || 'Error hashing.';
            }
        } catch (error) {
            console.error('Hashing error:', error);
            hashResultEl.textContent = 'An unexpected error occurred.';
        }
    };

    // --- Comparison Logic ---
    const handleCompare = async () => {
        if (!stringToCompareInput.value || !hashToCompareInput.value) {
            compareResultEl.textContent = '--';
            compareResultEl.className = '';
            return;
        }

        try {
            const response = await fetch("{{ route('tools.bcrypt.compare') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    string_to_compare: stringToCompareInput.value,
                    hash_to_compare: hashToCompareInput.value
                })
            });

            const data = await response.json();
            if (data.success) {
                if (data.match) {
                    compareResultEl.textContent = 'Yes';
                    compareResultEl.className = 'text-success';
                } else {
                    compareResultEl.textContent = 'No';
                    compareResultEl.className = 'text-danger';
                }
            } else {
                compareResultEl.textContent = 'Error';
                compareResultEl.className = 'text-warning';
            }
        } catch (error) {
            console.error('Comparison error:', error);
            compareResultEl.textContent = 'Error';
            compareResultEl.className = 'text-warning';
        }
    };

    // --- Event Listeners ---
    stringToHashInput.addEventListener('input', handleHash);
    roundsInput.addEventListener('change', handleHash);
    roundsMinusBtn.addEventListener('click', () => { roundsInput.stepDown(); handleHash(); });
    roundsPlusBtn.addEventListener('click', () => { roundsInput.stepUp(); handleHash(); });

    stringToCompareInput.addEventListener('input', handleCompare);
    hashToCompareInput.addEventListener('input', handleCompare);

    copyHashBtn.addEventListener('click', function() {
        if (!hashResultEl.textContent) return;
        navigator.clipboard.writeText(hashResultEl.textContent).then(() => {
            const originalText = copyHashText.textContent;
            copyHashText.textContent = 'Copied!';
            this.classList.add('btn-success');
            this.querySelector('i').className = 'fas fa-check me-2';
            setTimeout(() => {
                copyHashText.textContent = originalText;
                this.classList.remove('btn-success');
                this.querySelector('i').className = 'fas fa-copy me-2';
            }, 2000);
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
