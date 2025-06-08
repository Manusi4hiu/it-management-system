@extends('layouts.app')

@section('title', 'Whois Lookup Tool')
@section('page-title', 'Whois Lookup Tool')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Whois Lookup Tool
                </h5>
            </div>
            <div class="card-body">
                <form id="whoisForm">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="mb-3">
                                <label for="domain" class="form-label">Domain Name or IP Address</label>
                                <input type="text" class="form-control" id="domain" name="domain"
                                       placeholder="example.com or 8.8.8.8" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label class="form-label">&nbsp;</label>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search me-2"></i>Lookup
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="mb-3">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="clearResult()">
                        <i class="fas fa-eraser me-2"></i>Clear Result
                    </button>
                </div>

                <div id="result" class="mt-4" style="display: none;">
                    <h6>Whois Information:</h6>
                    <div id="output"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-globe me-2"></i>
                    Quick Lookups
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-primary btn-sm" onclick="setDomain('google.com')">
                        Google.com
                    </button>
                    <button class="btn btn-outline-primary btn-sm" onclick="setDomain('github.com')">
                        GitHub.com
                    </button>
                    <button class="btn btn-outline-primary btn-sm" onclick="setDomain('stackoverflow.com')">
                        StackOverflow.com
                    </button>
                    <button class="btn btn-outline-primary btn-sm" onclick="setDomain('8.8.8.8')">
                        8.8.8.8 (Google DNS)
                    </button>
                    <button class="btn btn-outline-primary btn-sm" onclick="setDomain('1.1.1.1')">
                        1.1.1.1 (Cloudflare)
                    </button>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-question-circle me-2"></i>
                    About Whois
                </h6>
            </div>
            <div class="card-body">
                <small class="text-muted">
                    Whois is a query and response protocol that provides information about domain names,
                    IP addresses, and autonomous systems. It shows registration details, nameservers,
                    contact information, and more.
                </small>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-lightbulb me-2"></i>
                    Tips
                </h6>
            </div>
            <div class="card-body">
                <small class="text-muted">
                    • Enter domain without protocol (e.g., google.com not https://google.com)<br>
                    • Works with both domain names and IP addresses<br>
                    • Some domains may have privacy protection enabled<br>
                    • Results may vary depending on the registrar
                </small>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('whoisForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const domain = document.getElementById('domain').value.trim();

    if (!domain) {
        alert('Please enter a domain name or IP address');
        return;
    }

    // Clean domain (remove protocol if present)
    const cleanDomain = domain.replace(/^https?:\/\//, '').replace(/\/.*$/, '');

    // Show loading
    document.getElementById('result').style.display = 'block';
    document.getElementById('output').innerHTML = `
        <div class="text-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Looking up ${cleanDomain}...</p>
            <small class="text-muted">This may take a few seconds...</small>
        </div>
    `;

    // Make request
    fetch('/tools/whois', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            domain: cleanDomain
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const output = data.output || 'No whois information available';
            const formattedOutput = formatWhoisOutput(output);

            document.getElementById('output').innerHTML = `
                <div class="card">
                    <div class="card-body">
                        <pre class="bg-light p-3 rounded" style="max-height: 500px; overflow-y: auto; font-size: 0.85em; white-space: pre-wrap;">${formattedOutput}</pre>
                    </div>
                </div>
                ${data.error ? `<div class="alert alert-warning mt-2"><small>${data.error}</small></div>` : ''}
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
                <strong>Error:</strong> Failed to lookup ${cleanDomain}. Please check if whois is installed on the server.
            </div>
        `;
    });
});

function formatWhoisOutput(output) {
    // Basic formatting for better readability
    return output
        .replace(/^(Domain Name|Registrar|Creation Date|Registry Expiry Date|Updated Date|Name Server):/gm, '<strong>$1:</strong>')
        .replace(/^(Registrant|Admin|Tech)( Contact)?:/gm, '<strong class="text-primary">$1$2:</strong>')
        .replace(/^(Status):/gm, '<strong class="text-warning">$1:</strong>')
        .replace(/^(DNSSEC):/gm, '<strong class="text-info">$1:</strong>');
}

function setDomain(domain) {
    document.getElementById('domain').value = domain;
}

function clearResult() {
    document.getElementById('result').style.display = 'none';
    document.getElementById('domain').value = '';
}
</script>
@endpush
