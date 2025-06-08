<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'IT Management System')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-gradient: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%);
            --warning-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --sidebar-width: 280px;

            /* Light Mode Colors */
            --bg-primary: #f5f7fa;
            --bg-secondary: #ffffff;
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            --border-color: #e5e7eb;
            --shadow: rgba(0, 0, 0, 0.1);
            --card-bg: rgba(255, 255, 255, 0.95);
        }

        [data-theme="dark"] {
            /* Dark Mode Colors */
            --bg-primary: #0f172a;
            --bg-secondary: #1e293b;
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --border-color: #334155;
            --shadow: rgba(0, 0, 0, 0.3);
            --card-bg: rgba(30, 41, 59, 0.95);

            /* Dark Mode Gradients */
            --primary-gradient: linear-gradient(135deg, #4c1d95 0%, #581c87 100%);
            --success-gradient: linear-gradient(135deg, #166534 0%, #15803d 100%);
            --warning-gradient: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
            --info-gradient: linear-gradient(135deg, #1e40af 0%, #2563eb 100%);
        }

        * {
            box-sizing: border-box;
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--bg-primary) 0%, var(--bg-secondary) 100%);
            color: var(--text-primary);
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: var(--primary-gradient);
            z-index: 1000;
            overflow-y: auto;
            transition: all 0.3s ease;
            box-shadow: 4px 0 20px var(--shadow);
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            margin: 4px 12px;
            border-radius: 12px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            font-weight: 500;
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }

        .sidebar .nav-link:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.5s;
        }

        .sidebar .nav-link:hover:before {
            left: 100%;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.15);
            transform: translateX(8px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .sidebar .nav-link i {
            width: 20px;
            text-align: center;
            margin-right: 12px;
            font-size: 16px;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            padding: 0;
            transition: all 0.3s ease;
        }

        .content-wrapper {
            padding: 2rem;
        }

        .card {
            border: 1px solid var(--border-color);
            border-radius: 20px;
            box-shadow: 0 10px 30px var(--shadow);
            transition: all 0.3s ease;
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            overflow: hidden;
            color: var(--text-primary);
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px var(--shadow);
        }

        .card-header {
            border: none;
            padding: 1.5rem 2rem;
            background: transparent;
            border-bottom: 1px solid var(--border-color);
        }

        .card-body {
            padding: 2rem;
        }

        .stats-card {
            background: var(--primary-gradient);
            color: white;
            position: relative;
            overflow: hidden;
        }

        .stats-card:before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            transform: rotate(45deg);
        }

        .stats-card-success {
            background: var(--success-gradient);
        }

        .stats-card-warning {
            background: var(--warning-gradient);
        }

        .stats-card-info {
            background: var(--info-gradient);
        }

        .btn-gradient {
            background: var(--primary-gradient);
            border: none;
            color: white;
            transition: all 0.3s ease;
            border-radius: 50px;
            font-weight: 600;
            padding: 12px 30px;
            position: relative;
            overflow: hidden;
        }

        .btn-gradient:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-gradient:hover:before {
            left: 100%;
        }

        .btn-gradient:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .search-box {
            background: var(--card-bg);
            border: 2px solid var(--border-color);
            transition: all 0.3s ease;
            border-radius: 15px;
            padding: 12px 20px;
            font-weight: 500;
            color: var(--text-primary);
        }

        .search-box:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            background: var(--card-bg);
            transform: translateY(-2px);
            color: var(--text-primary);
        }

        .filter-card {
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border-color);
        }

        .inventory-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .inventory-card:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(102, 126, 234, 0.05), transparent);
            transition: left 0.5s;
        }

        .inventory-card:hover:before {
            left: 100%;
        }

        .inventory-card:hover {
            border-color: #3b82f6;
            transform: translateY(-5px);
            box-shadow: 0 20px 40px var(--shadow);
        }

        .status-badge {
            font-size: 0.75rem;
            padding: 8px 16px;
            border-radius: 50px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .status-available {
            background: linear-gradient(135deg, #10b981, #34d399);
            color: white;
        }

        .status-in-use {
            background: linear-gradient(135deg, #3b82f6, #60a5fa);
            color: white;
        }

        .status-maintenance {
            background: linear-gradient(135deg, #f59e0b, #fbbf24);
            color: white;
        }

        .status-retired {
            background: linear-gradient(135deg, #ef4444, #f87171);
            color: white;
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slide-in {
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .sidebar-brand {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 1rem;
            text-align: center;
            position: relative;
        }

        .sidebar-brand:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 2px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 1px;
        }

        .sidebar-heading {
            padding: 1rem 1.5rem 0.5rem;
            margin-top: 1.5rem;
            margin-bottom: 0.5rem;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, 0.6);
            position: relative;
        }

        .sidebar-heading:before {
            content: '';
            position: absolute;
            top: 0;
            left: 1.5rem;
            right: 1.5rem;
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
        }

        .page-header {
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid var(--border-color);
        }

        .icon-box {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 1rem;
        }

        .gradient-text {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
        }

        /* Dark Mode Toggle */
        .theme-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1100;
            background: var(--card-bg);
            border: 2px solid var(--border-color);
            border-radius: 50px;
            padding: 8px 16px;
            box-shadow: 0 4px 15px var(--shadow);
            transition: all 0.3s ease;
        }

        .theme-toggle:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px var(--shadow);
        }

        .theme-toggle-btn {
            background: none;
            border: none;
            color: var(--text-primary);
            font-size: 18px;
            cursor: pointer;
            transition: all 0.3s ease;
            padding: 8px;
            border-radius: 50%;
        }

        .theme-toggle-btn:hover {
            background: var(--border-color);
            transform: rotate(180deg);
        }

        /* Table Dark Mode */
        .table {
            color: var(--text-primary);
        }

        .table th {
            background: var(--bg-secondary);
            color: var(--text-primary);
            border-color: var(--border-color);
        }

        .table td {
            border-color: var(--border-color);
        }

        .table-hover tbody tr:hover {
            background-color: var(--border-color);
        }

        /* Form Controls Dark Mode */
        .form-control,
        .form-select {
            background: var(--card-bg);
            border-color: var(--border-color);
            color: var(--text-primary);
        }

        .form-control:focus,
        .form-select:focus {
            background: var(--card-bg);
            border-color: #667eea;
            color: var(--text-primary);
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        /* Dropdown Dark Mode */
        .dropdown-menu {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            box-shadow: 0 10px 30px var(--shadow);
        }

        .dropdown-item {
            color: var(--text-primary);
        }

        .dropdown-item:hover {
            background: var(--border-color);
            color: var(--text-primary);
        }

        /* Badge Dark Mode */
        .badge {
            color: white !important;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .content-wrapper {
                padding: 1rem;
            }

            .mobile-menu-btn {
                display: block !important;
            }

            .card-body {
                padding: 1.5rem;
            }

            .theme-toggle {
                top: 10px;
                right: 60px;
                padding: 6px 12px;
            }
        }

        @media (min-width: 769px) {
            .mobile-menu-btn {
                display: none !important;
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-secondary);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-gradient);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #764ba2, #667eea);
        }

        /* Loading Animation */
        .loading {
            position: relative;
            overflow: hidden;
        }

        .loading:after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% {
                left: -100%;
            }

            100% {
                left: 100%;
            }
        }
    </style>
</head>

<body>
    <!-- Theme Toggle -->
    <div class="theme-toggle">
        <button class="theme-toggle-btn" onclick="toggleTheme()" title="Toggle Dark Mode">
            <i class="fas fa-moon" id="theme-icon"></i>
        </button>
    </div>

    <!-- Mobile Menu Button -->
    <button class="mobile-menu-btn btn btn-primary position-fixed shadow-lg"
        style="top: 1rem; left: 1rem; z-index: 1100; display: none; border-radius: 15px;" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="logo-container mx-auto mb-3"
                style="width: 60px; height: 60px; background: rgba(255,255,255,0.1); border-radius: 15px; padding: 8px; display: flex; align-items: center; justify-content: center;">
                <img src="{{ asset('images/it-logo.png') }}" alt="IT Management Logo" class="logo-img"
                    style="max-width: 100%; max-height: 100%; object-fit: contain; filter: brightness(0) invert(1);">
            </div>
            <h4 class="text-white fw-bold mb-1">IT Management</h4>
            <p class="text-white-50 small mb-0">System Dashboard</p>
        </div>

        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                    href="{{ route('dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('inventory.*') ? 'active' : '' }}"
                    href="{{ route('inventory.index') }}">
                    <i class="fas fa-boxes"></i>
                    Inventory
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('ip-addresses.*') ? 'active' : '' }}"
                    href="{{ route('ip-addresses.index') }}">
                    <i class="fas fa-network-wired"></i>
                    IP Addresses
                </a>
            </li>

            <div class="sidebar-heading">
                Network Tools
            </div>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('tools.ping') ? 'active' : '' }}"
                    href="{{ route('tools.ping') }}">
                    <i class="fas fa-satellite-dish"></i>
                    Ping
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('tools.traceroute') ? 'active' : '' }}"
                    href="{{ route('tools.traceroute') }}">
                    <i class="fas fa-route"></i>
                    Traceroute
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('tools.port-scanner') ? 'active' : '' }}"
                    href="{{ route('tools.port-scanner') }}">
                    <i class="fas fa-search"></i>
                    Port Scanner
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('tools.whois') ? 'active' : '' }}"
                    href="{{ route('tools.whois') }}">
                    <i class="fas fa-info-circle"></i>
                    Whois
                </a>
            </li>
        </ul>
    </nav>

    <!-- Main content -->
    <main class="main-content">
        <div class="content-wrapper">
            <!-- Page Header -->
            <div class="page-header">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <div>
                        <h1 class="gradient-text mb-2">@yield('page-title', 'Dashboard')</h1>
                        <p class="mb-0 fw-medium" style="color: var(--text-secondary);">@yield('page-subtitle', 'Manage your IT resources efficiently')</p>
                    </div>
                    <div class="btn-toolbar">
                        @yield('page-actions')
                    </div>
                </div>
            </div>

            <!-- Alerts -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show animate-fade-in border-0 shadow-lg mb-4"
                    role="alert" style="background: var(--success-gradient); color: white; border-radius: 15px;">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show animate-fade-in border-0 shadow-lg mb-4"
                    role="alert"
                    style="background: linear-gradient(135deg, #ef4444 0%, #f87171 100%); color: white; border-radius: 15px;">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Page Content -->
            @yield('content')
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <script>
        // Dark Mode Toggle
        function toggleTheme() {
            const html = document.documentElement;
            const themeIcon = document.getElementById('theme-icon');
            const currentTheme = html.getAttribute('data-theme');

            if (currentTheme === 'dark') {
                html.removeAttribute('data-theme');
                themeIcon.className = 'fas fa-moon';
                localStorage.setItem('theme', 'light');
            } else {
                html.setAttribute('data-theme', 'dark');
                themeIcon.className = 'fas fa-sun';
                localStorage.setItem('theme', 'dark');
            }
        }

        // Load saved theme
        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('theme');
            const html = document.documentElement;
            const themeIcon = document.getElementById('theme-icon');

            if (savedTheme === 'dark') {
                html.setAttribute('data-theme', 'dark');
                themeIcon.className = 'fas fa-sun';
            } else {
                themeIcon.className = 'fas fa-moon';
            }
        });

        // Mobile sidebar toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const menuBtn = document.querySelector('.mobile-menu-btn');

            if (window.innerWidth <= 768) {
                if (!sidebar.contains(event.target) && !menuBtn.contains(event.target)) {
                    sidebar.classList.remove('show');
                }
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            if (window.innerWidth > 768) {
                sidebar.classList.remove('show');
            }
        });

        // Add loading effect to buttons
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.btn-gradient');
            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    if (!this.classList.contains('loading')) {
                        this.classList.add('loading');
                        setTimeout(() => {
                            this.classList.remove('loading');
                        }, 1000);
                    }
                });
            });
        });

        // Smooth scroll for internal links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
