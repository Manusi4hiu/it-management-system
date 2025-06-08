@extends('layouts.app')

@section('title', 'Port Scanner Tool')
@section('page-title', 'Port Scanner Tool')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-search me-2"></i>
                    Port Scanner Tool
                </h5>
            </div>
            <div class="card-body">
                <form id="portScanForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="host" class="form-label">Host/IP Address</label>
                                <input type="text" class="form-control" id="host" name="host"
                                       placeholder="192.168.1.1" value="{{ request('host') }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="ports" class="form-label">Ports</label>
                                <input type="text" class="form-control" id="ports" name="ports"
                                       placeholder="80,443,22 or 1-1000" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="timeout" class="form-label">Timeout (s)</label>
                                <select class="form-select" id="timeout" name="timeout">
                                    <option value="1">1s</option>
                                    <option value="3" selected>3s</option>
                                    <option value="5">5s</option>
                                    <option value="10">10s</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-play me-2"></i>Start Scan
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="clearResult()">
                        <i class="fas fa-eraser me-2"></i>Clear
                    </button>
                </form>

                <div id="result" class="mt-4" style="display: none;">
                    <h6>Scan Results:</h6>
                    <div id="output"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-list me-2"></i>
                    Common Port Ranges
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-primary btn-sm" onclick="setPorts('21,22,23,25,53,80,110,143,443,993,995')">
                        Common Services
                    </button>
                    <button class="btn btn-outline-primary btn-sm" onclick="setPorts('80,443,8080,8443')">
                        Web Services
                    </button>
                    <button class="btn btn-outline-primary btn-sm" onclick="setPorts('21,22,23,3389')">
                        Remote Access
                    </button>
                    <button class="btn btn-outline-primary btn-sm" onclick="setPorts('1-1000')">
                        Well-known Ports
                    </button>
                    <button class="btn btn-outline-primary btn-sm" onclick="setPorts('1-65535')">
                        All Ports (Slow!)
                    </button>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Common Ports
                </h6>
            </div>
            <div class="card-body">
                <small class="text-muted">
                    <strong>21:</strong> FTP<br>
                    <strong>22:</strong> SSH<br>
                    <strong>23:</strong> Telnet<br>
                    <strong>25:</strong> SMTP<br>
                    <strong>53:</strong> DNS<br>
                    <strong>80:</strong> HTTP<br>
                    <strong>110:</strong> POP3<br>
                    <strong>143:</strong> IMAP<br>
                    <strong>443:</strong> HTTPS<br>
                    <strong>993:</strong> IMAPS<br>
                    <strong>995:</strong> POP3S<br>
                    <strong>3389:</strong> RDP<br>
                    <strong>3306:</strong> MySQL<br>
                    <strong>5432:</strong> PostgreSQL
                </small>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-question-circle me-2"></i>
                    Port Range Format
                </h6>
            </div>
            <div class="card-body">
                <small class="text-muted">
                    <strong>Single ports:</strong> 80,443,22<br>
                    <strong>Port range:</strong> 1-1000<br>
                    <strong>Mixed:</strong> 80,443,1000-2000
                </small>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('portScanForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const host = document.getElementById('host').value;
    const ports = document.getElementById('ports').value;
    const timeout = document.getElementById('timeout').value;

    if (!host || !ports) {
        alert('Please enter both host and ports');
        return;
    }

    // Show loading
    document.getElementById('result').style.display = 'block';
    document.getElementById('output').innerHTML = `
        <div class="text-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Scanning ${host} ports ${ports}...</p>
            <small class="text-muted">This may take a while depending on the number of ports...</small>
        </div>
    `;

    // Make request
    fetch('/tools/port-scanner', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            host: host,
            ports: ports,
            timeout: parseInt(timeout)
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            let openPorts = data.results.filter(result => result.status === 'open');
            let closedPorts = data.results.filter(result => result.status === 'closed');

            let html = '';

            if (openPorts.length > 0) {
                html += '<div class="alert alert-success"><h6>Open Ports:</h6>';
                html += '<div class="table-responsive"><table class="table table-sm mb-0">';
                html += '<thead><tr><th>Port</th><th>Status</th><th>Service</th></tr></thead><tbody>';
                openPorts.forEach(port => {
                    html += `<tr><td><strong>${port.port}</strong></td><td><span class="badge bg-success">Open</span></td><td>${port.service}</td></tr>`;
                });
                html += '</tbody></table></div></div>';
            }

            if (closedPorts.length > 0) {
                html += '<div class="alert alert-secondary"><h6>Closed/Filtered Ports:</h6>';
                html += '<div class="row">';
                closedPorts.forEach((port, index) => {
                    if (index % 10 === 0) html += '<div class="col-md-6">';
                    html += `<small class="text-muted">${port.port}, </small>`;
                    if ((index + 1) % 10 === 0 || index === closedPorts.length - 1) html += '</div>';
                });
                html += '</div></div>';
            }

            if (openPorts.length === 0 && closedPorts.length === 0) {
                html = '<div class="alert alert-warning">No results found. Please check the host and ports.</div>';
            }

            document.getElementById('output').innerHTML = html;
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
                <strong>Error:</strong> Failed to scan ports on ${host}
            </div>
        `;
    });
});

function setPorts(ports) {
    document.getElementById('ports').value = ports;
}

function clearResult() {
    document.getElementById('result').style.display = 'none';
    document.getElementById('host').value = '';
    document.getElementById('ports').value = '';
}
</script>
@endpush
