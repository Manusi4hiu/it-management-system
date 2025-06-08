@extends('layouts.app')

@section('title', 'Traceroute Tool')
@section('page-title', 'Traceroute Tool')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-route me-2"></i>
                    Traceroute Tool
                </h5>
            </div>
            <div class="card-body">
                <form id="tracerouteForm">
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
                                <label for="max_hops" class="form-label">Max Hops</label>
                                <select class="form-select" id="max_hops" name="max_hops">
                                    <option value="15">15 hops</option>
                                    <option value="20">20 hops</option>
                                    <option value="25">25 hops</option>
                                    <option value="30">30 hops</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-play me-2"></i>Start Traceroute
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
                        Google.com
                    </button>
                    <button class="btn btn-outline-primary btn-sm" onclick="setHost('facebook.com')">
                        Facebook.com
                    </button>
                    <button class="btn btn-outline-primary btn-sm" onclick="setHost('github.com')">
                        GitHub.com
                    </button>
                    <button class="btn btn-outline-primary btn-sm" onclick="setHost('stackoverflow.com')">
                        StackOverflow.com
                    </button>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-question-circle me-2"></i>
                    About Traceroute
                </h6>
            </div>
            <div class="card-body">
                <small class="text-muted">
                    Traceroute is a network diagnostic tool that displays the route (path) and measures
                    transit delays of packets across an Internet Protocol (IP) network. It shows each
                    hop along the path to the destination.
                </small>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('tracerouteForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const host = document.getElementById('host').value;
    const maxHops = document.getElementById('max_hops').value;

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
            <p class="mt-2">Tracing route to ${host}...</p>
            <small class="text-muted">This may take a while...</small>
        </div>
    `;

    // Make request
    fetch('/tools/traceroute', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            host: host,
            max_hops: parseInt(maxHops)
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('output').innerHTML = `
                <pre class="bg-dark text-light p-3 rounded" style="max-height: 400px; overflow-y: auto;">${data.output}</pre>
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
                <strong>Error:</strong> Failed to traceroute ${host}
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
