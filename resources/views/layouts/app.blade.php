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

        /* User Controls - Theme Toggle & User Menu */
        .user-controls {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1100;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .theme-toggle {
            background: var(--card-bg);
            border: 2px solid var(--border-color);
            border-radius: 50px;
            padding: 10px 12px;
            box-shadow: 0 4px 15px var(--shadow);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .theme-toggle:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px var(--shadow);
            border-color: #667eea;
        }

        .theme-toggle-btn {
            background: none;
            border: none;
            color: var(--text-primary);
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            padding: 4px;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .theme-toggle-btn:hover {
            background: var(--primary-gradient);
            color: white;
            transform: rotate(180deg);
        }

        .user-menu {
            background: var(--card-bg);
            border: 2px solid var(--border-color);
            border-radius: 50px;
            box-shadow: 0 4px 15px var(--shadow);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .user-menu:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px var(--shadow);
            border-color: #667eea;
        }

        .user-menu-btn {
            background: none;
            border: none;
            color: var(--text-primary);
            padding: 10px 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            font-size: 14px;
        }

        .user-menu-btn:hover {
            background: var(--primary-gradient);
            color: white;
        }

        .user-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: var(--primary-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 12px;
            font-weight: 600;
        }

        .role-badge {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        [data-theme="dark"] .role-badge {
            background: rgba(102, 126, 234, 0.2);
            color: #a5b4fc;
        }

        .dropdown-menu {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            box-shadow: 0 10px 30px var(--shadow);
            border-radius: 15px;
            padding: 8px;
            margin-top: 8px;
            min-width: 200px;
        }

        .dropdown-item {
            color: var(--text-primary);
            padding: 10px 16px;
            border-radius: 10px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
        }

        .dropdown-item:hover {
            background: var(--border-color);
            color: var(--text-primary);
            transform: translateX(4px);
        }

        .dropdown-item.text-danger:hover {
            background: linear-gradient(135deg, #ef4444, #f87171);
            color: white;
        }

        .dropdown-header {
            color: var(--text-secondary);
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 8px 16px 4px;
        }

        .dropdown-item-text {
            color: var(--text-secondary);
            font-size: 12px;
            padding: 4px 16px;
        }

        .dropdown-divider {
            border-color: var(--border-color);
            margin: 8px 0;
        }

        /* Sidebar User Section */
        .sidebar-user {
            margin-top: auto;
            padding: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.05);
        }

        .sidebar-user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            color: white;
            margin-bottom: 12px;
        }

        .sidebar-user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 16px;
            font-weight: 600;
        }

        .sidebar-user-details h6 {
            margin: 0;
            font-size: 14px;
            font-weight: 600;
        }

        .sidebar-user-details small {
            color: rgba(255, 255, 255, 0.7);
            font-size: 12px;
        }

        .sidebar-logout-btn {
            width: 100%;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            padding: 8px 16px;
            border-radius: 10px;
            transition: all 0.3s ease;
            font-size: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .sidebar-logout-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            transform: translateY(-2px);
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
            .user-controls {
                top: 10px;
                right: 10px;
                gap: 8px;
            }
            .theme-toggle {
                padding: 8px 10px;
            }
            .user-menu-btn {
                padding: 8px 12px;
                font-size: 12px;
            }
            .user-menu-btn .user-name {
                display: none;
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
    <!-- User Controls - Theme Toggle & User Menu -->
    <div class="user-controls">
        <!-- Theme Toggle -->
        <div class="theme-toggle">
            <button class="theme-toggle-btn" onclick="toggleTheme()" title="Toggle Dark Mode">
                <i class="fas fa-moon" id="theme-icon"></i>
            </button>
        </div>

        <!-- User Menu -->
        @auth
        <div class="user-menu dropdown">
            <button class="user-menu-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <span class="user-name">{{ Auth::user()->name }}</span>
                <span class="role-badge">{{ ucfirst(Auth::user()->role) }}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><h6 class="dropdown-header">{{ Auth::user()->name }}</h6></li>
                <li><span class="dropdown-item-text">{{ Auth::user()->email }}</span></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-user"></i>
                        Profile Settings
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-cog"></i>
                        Preferences
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline w-100">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger w-100 text-start">
                            <i class="fas fa-sign-out-alt"></i>
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
        @endauth
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
                <i class="fas fa-network-wired" style="font-size: 28px; color: white;"></i>
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

            @auth
                @if(Auth::user()->isAdmin())
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
                @endif
            @endauth

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
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('tools.random-port-generator') ? 'active' : '' }}"
                    href="{{ route('tools.random-port-generator') }}">
                    <i class="fas fa-random"></i>
                    Random Port
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('tools.bcrypt-generator') ? 'active' : '' }}"
                    href="{{ route('tools.bcrypt-generator') }}">
                    <i class="fas fa-shield-alt"></i>
                    Bcrypt Generator
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('tools.integer-base-converter') ? 'active' : '' }}"
                    href="{{ route('tools.integer-base-converter') }}">
                    <i class="fas fa-calculator"></i>
                    Base Converter
                </a>
            </li>
        </ul>

        <!-- Sidebar User Section -->
        @auth
        <div class="sidebar-user">
            <div class="sidebar-user-info">
                <div class="sidebar-user-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="sidebar-user-details">
                    <h6>{{ Auth::user()->name }}</h6>
                    <small>{{ ucfirst(Auth::user()->role) }}</small>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </button>
            </form>
        </div>
        @endauth
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

        // Auto-close dropdown on mobile after selection
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownItems = document.querySelectorAll('.dropdown-item');
            dropdownItems.forEach(item => {
                item.addEventListener('click', function() {
                    if (window.innerWidth <= 768) {
                        const dropdown = bootstrap.Dropdown.getInstance(document.querySelector('.dropdown-toggle'));
                        if (dropdown) {
                            dropdown.hide();
                        }
                    }
                });
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
