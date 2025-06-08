@extends('layouts.app')

@section('title', 'Ping Tool')
@section('page-title', 'Ping Tool')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-satellite-dish me-2"></i>
                    Ping Tool
                </h5>
            </div>
            <div class="card-body">
                <form id="pingForm">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="host" class="form-label">Host/IP Address</label>
                                <input type="text" class="form-control" id="host" name="host"
                                       placeholder="google.com or 8.8.8.8" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="count" class="form-label">Count</label>
                                <select class="form-select" id="count" name="count">
                                    <option value="4">4 packets</option>
                                    <option value="6">6 packets</option>
                                    <option value="8">8 packets</option>
                                    <option value="10">10 packets</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-play me-2"></i>Start Ping
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="clearResult()">
                        <i class="fas fa-eraser me-2"></i>Clear
                    </button>
                </form>

                <div id="result" class="mt-4" style="display: none;">
                    <h6>Result:</h6>
                    <div id="output"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Quick Targets
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-primary btn-sm" onclick="setHost('google.com')">
                        Google DNS
                    </button>
                    <button class="btn btn-outline-primary btn-sm" onclick="setHost('8.8.8.8')">
                        8.8.8.8
                    </button>
                    <button class="btn btn-outline-primary btn-sm" onclick="setHost('1.1.1.1')">
                        Cloudflare DNS
                    </button>
                    <button class="btn btn-outline-primary btn-sm" onclick="setHost('192.168.1.1')">
                        Default Gateway
                    </button>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-question-circle me-2"></i>
                    About Ping
                </h6>
            </div>
            <div class="card-body">
                <small class="text-muted">
                    Ping is a network utility that tests the reachability of a host on an IP network.
                    It measures the round-trip time for messages sent from the originating host to a destination computer.
                </small>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('pingForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const host = document.getElementById('host').value;
    const count = document.getElementById('count').value;

    if (!host) {
        alert('Please enter a host or IP address');
        return;
    }

    // Show loading
    document.getElementById('result').style.display = 'block';
    document.getElementById('output').innerHTML = `
        <div class="text-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Pinging ${host}...</p>
        </div>
    `;

    // Make request
    fetch('/tools/ping', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            host: host,
            count: parseInt(count)
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('output').innerHTML = `
                <pre class="bg-dark text-light p-3 rounded">${data.output}</pre>
                ${data.error ? `<div class="alert alert-warning mt-2">${data.error}</div>` : ''}
            `;
        } else {
            document.getElementById('output').innerHTML = `
                <div class="alert alert-danger">
                    <strong>Error:</strong> ${data.error}
                </div>
            `;
        }
    })
    .catch(error => {
        document.getElementById('output').innerHTML = `
            <div class="alert alert-danger">
                <strong>Error:</strong> Failed to ping ${host}
            </div>
        `;
    });
});

function setHost(host) {
    document.getElementById('host').value = host;
}

function clearResult() {
    document.getElementById('result').style.display = 'none';
    document.getElementById('host').value = '';
}
</script>
@endpush
