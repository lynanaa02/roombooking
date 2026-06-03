<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistem Booking Ruangan dan Gedung - Universitas Jember</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- PDF.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js';
    </script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            overflow-x: hidden;
            font-weight: 400;
            letter-spacing: -0.01em;
        }

        /* ========== SIDEBAR ========== */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: 280px;
            background: linear-gradient(180deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
            box-shadow: 2px 0 20px rgba(0,0,0,0.1);
            overflow-y: auto;
        }

        @media (max-width: 768px) {
            .sidebar {
                left: -280px;
            }
            .sidebar.active {
                left: 0;
            }
            .main-content {
                margin-left: 0 !important;
            }
        }
        .sidebar-header {
            padding: 28px 24px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar-header h3 {
            font-size: 20px;
            margin: 0;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        .sidebar-header p {
            font-size: 13px;
            margin: 6px 0 0;
            opacity: 0.8;
            font-weight: 400;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .sidebar-menu .nav-link {
            padding: 12px 24px;
            color: rgba(255,255,255,0.85);
            transition: all 0.25s ease;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .sidebar-menu .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            padding-left: 30px;
        }

        .sidebar-menu .nav-link.active {
            background: rgba(255,255,255,0.15);
            color: white;
            border-left: 4px solid #ffd700;
            font-weight: 600;
        }

        .sidebar-menu .nav-link i {
            width: 22px;
            font-size: 18px;
        }

        /* ========== MAIN CONTENT ========== */
        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ========== TOP HEADER ========== */
        .top-header {
            background: white;
            padding: 10px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 99;
            border-bottom: 2px solid #667eea;
            gap: 15px;
        }

        .menu-toggle {
            display: none;
        }

        .menu-toggle:hover {
            background: #5a67d8;
            transform: scale(1.02);
        }

        /* HP Styles */
        @media (max-width: 768px) {
            .menu-toggle {
                display: flex !important;
                position: fixed;
                top: 16px;
                left: 12px;
                z-index: 1001;
                background: #667eea;
                border: none;
                color: white;
                width: 24px;
                height: 24px;
                border-radius: 8px;
                cursor: pointer;
                font-size: 16px;
                align-items: center;
                justify-content: center;
                transition: all 0.3s ease;
            }

            .menu-toggle:hover {
                transform: scale(1.05);
            }

            .logo-area {
                margin-left: 28px !important;
                gap: 8px !important;
            }

            .desktop-logo {
                display: none !important;
            }

            .mobile-logo {
                display: block !important;
                font-size: 16px !important;
                line-height: 1.2 !important;
                font-weight: 700 !important;
            }

            .logo-img {
                width: 34px !important;
                height: 34px !important;
            }

            .logo-text p {
                display: none !important;
            }

            .user-name-text {
                display: none !important;
            }

            .user-card {
                padding: 5px 10px !important;
                gap: 6px !important;
            }

            .user-avatar {
                width: 32px !important;
                height: 32px !important;
                font-size: 12px !important;
            }

            .top-header {
                padding: 8px 12px !important;
                gap: 8px !important;
            }

            .content-wrapper {
                padding: 16px !important;
            }

            .sidebar {
                width: 260px;
            }

            .sidebar.active {
                left: 0;
            }
        }

        /* LOGO AREA - Desktop */
        .logo-area {
            display: flex;
            align-items: center;
            gap: 12px;
            flex: 1;
        }

        .logo-img {
            width: 45px;
            height: 45px;
            object-fit: cover;
            border-radius: 10px;
        }

        .logo-text h2 {
            font-size: 20px;
            margin: 0;
            font-weight: 700;
            color: #1a1a2e;
            line-height: 1.3;
            white-space: nowrap;
        }

        body.dark-mode .logo-text h2 {
            color: #e0e0e0;
        }

        .logo-text p {
            font-size: 10px;
            margin: 2px 0 0;
            color: #6b7280;
        }

        .desktop-logo {
            display: block;
        }

        .mobile-logo {
            display: none;
        }

        @media (max-width: 768px) {
            .logo-area i {
                font-size: 24px;
            }
        }

        .user-info-area {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-shrink: 0;
        }

        .dark-mode-toggle-header {
            background: #f3f4f6;
            border: none;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        body.dark-mode .dark-mode-toggle-header {
            background: #334155;
            color: white;
        }

        .user-card {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #f8fafc;
            padding: 6px 14px;
            border-radius: 40px;
            cursor: pointer;
            border: 1px solid #e2e8f0;
        }

        body.dark-mode .user-card {
            background: #334155;
            border-color: #475569;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 14px;
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }

        .user-name-text {
            text-align: left;
        }

        .user-name-text small {
            font-size: 10px;
            color: #6b7280;
            display: block;
            line-height: 1.2;
        }

        body.dark-mode .user-name-text small {
            color: #94a3b8;
        }

        .user-name-text span {
            font-size: 13px;
            font-weight: 700;
            color: #1a1a2e;
        }

        body.dark-mode .user-name-text span {
            color: white;
        }

        .dropdown-icon {
            font-size: 12px;
            color: #94a3b8;
            transition: transform 0.2s;
        }

        .user-dropdown.open .dropdown-icon {
            transform: rotate(180deg);
        }

        .dropdown-menu-custom {
            position: absolute;
            top: 55px;
            right: 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            min-width: 180px;
            display: none;
            z-index: 200;
            overflow: hidden;
        }

        body.dark-mode .dropdown-menu-custom {
            background: #1e293b;
            border: 1px solid #334155;
        }

        .user-dropdown {
            position: relative;
        }

        .user-dropdown.open .dropdown-menu-custom {
            display: block;
        }

        .dropdown-menu-custom a,
        .dropdown-menu-custom button {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            color: #1f2937;
            text-decoration: none;
            font-size: 13px;
            width: 100%;
            border: none;
            background: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        body.dark-mode .dropdown-menu-custom a,
        body.dark-mode .dropdown-menu-custom button {
            color: #cbd5e1;
        }

        .dropdown-menu-custom a:hover,
        .dropdown-menu-custom button:hover {
            background: #f3f4f6;
        }

        body.dark-mode .dropdown-menu-custom a:hover,
        body.dark-mode .dropdown-menu-custom button:hover {
            background: #334155;
        }

        .dropdown-menu-custom a i,
        .dropdown-menu-custom button i {
            width: 20px;
            color: #667eea;
        }

        /* ========== CONTENT WRAPPER ========== */
        .content-wrapper {
            padding: 28px;
            flex: 1;
        }

        @media (max-width: 768px) {
            .content-wrapper {
                padding: 16px;
            }
        }

        /* ========== CARD STATS ========== */
        .card-stats {
            background: white;
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.06);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            border: none;
            height: 100%;
        }

        .card-stats:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 28px rgba(0,0,0,0.12);
        }

        /* ========== TABLE ========== */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table {
            min-width: 600px;
            font-size: 14px;
        }

        .table th {
            font-weight: 600;
            font-size: 14px;
            letter-spacing: -0.01em;
        }

        @media (max-width: 768px) {
            .table th, .table td {
                padding: 10px 8px !important;
                font-size: 11px !important;
            }
            .btn-sm {
                padding: 4px 8px !important;
                font-size: 10px !important;
            }
        }

        /* ========== MODAL ========== */
        @media (max-width: 768px) {
            .modal-dialog {
                margin: 10px;
                width: calc(100% - 20px);
            }
            .modal-body {
                padding: 20px !important;
            }
        }

        /* ========== FORM ========== */
        @media (max-width: 768px) {
            .form-control, .btn {
                font-size: 15px !important;
            }
            .col-md-6, .col-md-8, .col-md-4 {
                margin-bottom: 15px;
            }
        }

        .row {
            margin-right: -12px;
            margin-left: -12px;
        }

        .row > [class*="col-"] {
            padding-right: 12px;
            padding-left: 12px;
        }

        .btn-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 10px 24px;
            border-radius: 12px;
            transition: all 0.25s;
            font-weight: 600;
            font-size: 16px;
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102,126,234,0.4);
        }

        /* ========== FOOTER ========== */
        footer {
            background: white;
            padding: 20px 28px;
            text-align: center;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.04);
        }

        footer h5 {
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 12px;
            color: #1a1a2e;
            letter-spacing: -0.01em;
        }

        footer p {
            font-size: 12px;
            margin-bottom: 4px;
            color: #888;
            font-weight: 400;
        }

        footer .text-muted {
            font-size: 11px;
            color: #aaa !important;
        }

        footer hr {
            margin: 16px 0;
            opacity: 0.3;
        }

        @media (max-width: 768px) {
            footer {
                padding: 16px;
            }
            footer h5 {
                font-size: 12px;
            }
            footer p {
                font-size: 10px;
            }
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translate(-50%, -48%) scale(0.96);
            }
            to {
                opacity: 1;
                transform: translate(-50%, -50%) scale(1);
            }
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        .modal-btn-cancel {
            padding: 12px 24px;
            background: #f3f4f6;
            border: none;
            border-radius: 12px;
            color: #6b7280;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            flex: 1;
        }

        .modal-btn-cancel:hover {
            background: #e5e7eb;
            transform: translateY(-2px);
        }

        .modal-btn-confirm {
            padding: 12px 24px;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            border: none;
            border-radius: 12px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            flex: 1;
        }

        .modal-btn-confirm:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(220, 38, 38, 0.3);
        }
        /* Modal Pop-up Modern */
.modal-modern-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(4px);
    z-index: 999999 !important;
    display: none;
    align-items: center;
    justify-content: center;
}
.modal-modern-container {
    background: white;
    border-radius: 24px;
    width: 90%;
    max-width: 420px;
    animation: modalSlideIn 0.3s ease;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    overflow: hidden;
}
.modal-modern-header {
    padding: 24px 24px 0 24px;
    text-align: center;
}
.modal-modern-icon {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 16px;
}
.modal-modern-icon i {
    font-size: 32px;
}
.modal-modern-title {
    font-size: 20px;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 8px;
}
.modal-modern-message {
    font-size: 14px;
    color: #6b7280;
    line-height: 1.5;
}
.modal-modern-body {
    padding: 16px 24px 0 24px;
    text-align: center;
}
.modal-modern-footer {
    padding: 20px 24px 24px 24px;
    display: flex;
    gap: 12px;
    justify-content: center;
}
.modal-modern-btn {
    padding: 10px 24px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.2s;
    border: none;
    flex: 1;
}
.modal-modern-btn-cancel {
    background: #f3f4f6;
    color: #6b7280;
}
.modal-modern-btn-cancel:hover {
    background: #e5e7eb;
}
.modal-modern-btn-confirm {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
}
.modal-modern-btn-confirm:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
}
.modal-modern-btn-warning {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
}
.modal-modern-btn-success {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}
.icon-danger { background: linear-gradient(135deg, #fee2e2, #fecaca); color: #dc2626; }
.icon-warning { background: linear-gradient(135deg, #fef3c7, #fde68a); color: #d97706; }
.icon-success { background: linear-gradient(135deg, #d1fae5, #a7f3d0); color: #10b981; }
.icon-info { background: linear-gradient(135deg, #dbeafe, #bfdbfe); color: #3b82f6; }

/* Password Toggle */
.password-wrapper {
    position: relative;
}
.password-toggle {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #9ca3af;
    background: none;
    border: none;
}
.password-toggle:hover {
    color: #667eea;
}


/* Membuat tabel lebih rapi */
.table, .table-modern {
    width: 100%;
    border-collapse: collapse;
}

.table th, .table-modern th,
.table td, .table-modern td {
    padding: 12px;
    vertical-align: middle;
}

/* Membuat card rekomendasi ruangan rapi */
.ruangan-card {
    height: 100%;
    display: flex;
    flex-direction: column;
}

.ruangan-card .ruangan-info {
    flex: 1;
}

/* ========== DARK MODE - CARD ========== */
.dark-mode .welcome-card,
.dark-mode .stat-card,
.dark-mode .weather-card,
.dark-mode .visitor-card,
.dark-mode .info-card,
.dark-mode .card-stats,
.dark-mode .card-modern,
.dark-mode .search-card,
.dark-mode .card-table,
.dark-mode .ruangan-card {
    background-color: #1e293b !important;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2) !important;
}


.dark-mode .welcome-card {
    background: linear-gradient(135deg, #1e3c72, #2a5298) !important;
}

/* Stat Card */
.dark-mode .stat-card {
    background-color: #1e293b !important;
}

/* Weather Card */
.dark-mode .weather-card {
    background-color: #1e293b !important;
}

/* Visitor Card */
.dark-mode .visitor-card {
    background-color: #1e293b !important;
}

/* Ruangan Card di Dashboard */
.dark-mode .ruangan-card {
    background-color: #1e293b !important;
}

.dark-mode .ruangan-card .ruangan-info {
    background-color: #1e293b !important;
}

/* Info Card */
.dark-mode .info-card {
    background-color: #1e293b !important;
}

.dark-mode .info-card-header {
    background-color: #0f172a !important;
    border-bottom-color: #334155 !important;
}

/* Section Header */
.dark-mode .section-header {
    border-bottom-color: #334155 !important;
}

/* Teks di dalam card */
.dark-mode .stat-info h3,
.dark-mode .stat-info p,
.dark-mode .weather-temp,
.dark-mode .weather-desc,
.dark-mode .weather-details span,
.dark-mode .visitor-number,
.dark-mode .visitor-date,
.dark-mode .visitor-label,
.dark-mode .ruangan-card h5,
.dark-mode .ruangan-card p,
.dark-mode .info-card .label,
.dark-mode .info-card .value {
    color: #e0e0e0 !important;
}

/* Tombol Reset di Visitor Card */
.dark-mode .btn-reset,
.dark-mode .btn-reset-visit {
    background-color: #334155 !important;
    color: #cbd5e1 !important;
    border: none !important;
}

.dark-mode .btn-reset:hover,
.dark-mode .btn-reset-visit:hover {
    background-color: #475569 !important;
    color: white !important;
}

/* Badge jenis organisasi di card */
.dark-mode .badge-ukm,
.dark-mode .badge-bem,
.dark-mode .badge-himpunan {
    background-color: #334155 !important;
    color: #e0e0e0 !important;
}


    </style>
</head>
<body>
    <!-- Toggle Button untuk Mobile -->
    <button class="menu-toggle" id="menuToggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h3><i class="fas fa-building me-2"></i>Booking System</h3>
            <p>Universitas Jember</p>
        </div>
        <div class="sidebar-menu">
            <a href="#" id="darkModeToggle" class="nav-link" onclick="toggleDarkMode(); return false;">
                <i class="fas fa-moon"></i>
                <span>Dark Mode</span>
            </a>
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.ruangan.index') }}" class="nav-link {{ request()->routeIs('admin.ruangan*') ? 'active' : '' }}">
                <i class="fas fa-door-open"></i>
                <span>Kelola Ruangan</span>
            </a>
            <a href="{{ route('admin.organisasi.index') }}" class="nav-link {{ request()->routeIs('admin.organisasi*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <span>Kelola Organisasi</span>
            </a>
            <a href="{{ route('admin.peminjaman.index') }}" class="nav-link {{ request()->routeIs('admin.peminjaman*') ? 'active' : '' }}">
                <i class="fas fa-calendar-check"></i>
                <span>Peminjaman</span>
            </a>
            <a href="{{ route('admin.profile') }}" class="nav-link {{ request()->routeIs('admin.profile') ? 'active' : '' }}">
                <i class="fas fa-user-circle"></i>
                <span>Profile</span>
            </a>
            <a href="#" id="logoutBtn" class="nav-link">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>

    <div class="main-content">
        <div class="top-header">

            <div class="logo-area">
                <img src="{{ asset('images/logo-unej.png') }}" alt="Logo" class="logo-img">
                <div class="logo-text">
                    <h2 class="desktop-logo">SISTEM BOOKING RUANGAN & GEDUNG</h2>
                    <h2 class="mobile-logo">SISTEM<br>BOOKING</h2>
                    <p>Universitas Jember</p>
                </div>
            </div>


            <div class="user-info-area">
                <button class="dark-mode-toggle-header" id="darkModeToggleHeader">
                    <i class="fas fa-moon"></i>
                </button>

                <div class="user-dropdown" id="userDropdown">
                    <div class="user-card" id="userCard">
                        <div class="user-avatar">
                            @if(Auth::user()->foto && file_exists(public_path(Auth::user()->foto)))
                                <img src="{{ asset(Auth::user()->foto) }}" alt="Foto">
                            @else
                                {{ substr(Auth::user()->name, 0, 2) }}
                            @endif
                        </div>
                        <div class="user-name-text">
                            <small>Administrator</small>
                            <span>{{ Auth::user()->name }}</span>
                        </div>
                        <i class="fas fa-chevron-down dropdown-icon"></i>
                    </div>
                    <div class="dropdown-menu-custom">
                        <a href="{{ route('admin.profile') }}">
                            <i class="fas fa-user-circle"></i> Profil
                        </a>
                        <button id="logoutBtnDropdown">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-wrapper">
            @yield('content')
        </div>

        <footer>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <h5>Sistem Booking Ruangan & Gedung</h5>
                        <p>Sistem peminjaman ruangan terintegrasi untuk sivitas akademika Universitas Jember</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <h5>Kontak & Alamat</h5>
                        <p><i class="fas fa-map-marker-alt me-2"></i>Jl. Kalimantan No.37, Jember</p>
                        <p><i class="fas fa-phone me-2"></i>(0331) 330224</p>
                        <p><i class="fas fa-envelope me-2"></i>info@unej.ac.id</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <h5>Jam Operasional</h5>
                        <p>Senin - Jumat: 08.00 - 16.00</p>
                        <p>Sabtu: 08.00 - 12.00</p>
                        <p>Minggu & Hari Libur: Tutup</p>
                    </div>
                </div>
                <hr>
                <div class="text-center">
                    <p class="text-muted mb-0">&copy; {{ date('Y') }} Sistem Booking Ruangan dan Gedung | Universitas Jember</p>
                    <p class="text-muted mt-1" style="font-size: 9px;">All rights reserved</p>
                </div>
            </div>
        </footer>
    </div>

    <!-- Modal Konfirmasi Global -->
    <div id="confirmationModal" class="custom-modal" style="display: none; position: fixed; z-index: 10000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); backdrop-filter: blur(4px);">
        <div class="custom-modal-content" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; border-radius: 24px; width: 90%; max-width: 450px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); animation: modalFadeIn 0.3s ease-out;">
            <div style="padding: 28px 28px 0 28px; text-align: center;">
                <div id="modalIcon" style="width: 72px; height: 72px; background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                    <i id="modalIconSymbol" class="fas fa-exclamation-triangle" style="font-size: 34px; color: #dc2626;"></i>
                </div>
                <h3 id="modalTitle" style="font-size: 20px; font-weight: 700; color: #1f2937; margin-bottom: 10px;">Konfirmasi Hapus</h3>
                <p id="modalMessage" style="font-size: 14px; color: #6b7280; line-height: 1.5;">Apakah Anda yakin ingin menghapus data ini?</p>
            </div>
            <div id="modalBody" style="padding: 0 28px; display: none;"></div>
            <div style="padding: 20px 28px; display: flex; gap: 12px; justify-content: center; border-top: 1px solid #e5e7eb; margin-top: 20px;">
                <button id="modalCancelBtn" class="modal-btn-cancel">
                    <i class="fas fa-times me-2"></i>Batal
                </button>
                <button id="modalConfirmBtn" class="modal-btn-confirm">
                    <i class="fas fa-trash-alt me-2"></i>Ya, Hapus
                </button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');

        function checkScreenSize() {
            if (window.innerWidth <= 768) {
                if (menuToggle) {
                    menuToggle.style.display = 'flex';
                    menuToggle.innerHTML = '<i class="fas fa-bars"></i>';
                    menuToggle.style.background = '#667eea';
                }
                if (sidebar) sidebar.classList.remove('active');
            } else {
                if (menuToggle) {
                    menuToggle.style.display = 'none';
                    menuToggle.innerHTML = '<i class="fas fa-bars"></i>';
                    menuToggle.style.background = '#667eea';
                }
                if (sidebar) sidebar.classList.remove('active');
            }
        }
        function toggleSidebar() {
            if (!sidebar || !menuToggle) return;

            sidebar.classList.toggle('active');
            if (sidebar.classList.contains('active')) {
                menuToggle.innerHTML = '<i class="fas fa-times"></i>';
                menuToggle.style.background = 'white';
                menuToggle.style.color = '#667eea';
                menuToggle.style.border = '1px solid #667eea';
            } else {
                menuToggle.innerHTML = '<i class="fas fa-bars"></i>';
                menuToggle.style.background = '#667eea';
            }
        }

        if (menuToggle) {
            menuToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                toggleSidebar();
            });
        }

        document.addEventListener('click', function(event) {
            if (window.innerWidth <= 768 && sidebar && menuToggle) {
                const isClickInsideSidebar = sidebar.contains(event.target);
                const isClickToggle = menuToggle.contains(event.target);

                if (!isClickInsideSidebar && !isClickToggle && sidebar.classList.contains('active')) {
                    sidebar.classList.remove('active');
                    menuToggle.innerHTML = '<i class="fas fa-bars"></i>';
                    menuToggle.style.background = '#667eea';
                }
            }
        });
        window.addEventListener('resize', function() {
            checkScreenSize();
        });
        checkScreenSize();



        let currentConfirmCallback = null;
        function showConfirmModal(options) {
            const modal = document.getElementById('confirmationModal');
            if (!modal) return;

            const title = document.getElementById('modalTitle');
            const message = document.getElementById('modalMessage');
            const icon = document.getElementById('modalIcon');
            const iconSymbol = document.getElementById('modalIconSymbol');
            let confirmBtn = document.getElementById('modalConfirmBtn');
            let cancelBtn = document.getElementById('modalCancelBtn');
            const modalBody = document.getElementById('modalBody');

            title.textContent = options.title || 'Konfirmasi';
            message.textContent = options.message || 'Apakah Anda yakin?';

            if (options.type === 'danger') {
                icon.style.background = 'linear-gradient(135deg, #fee2e2 0%, #fecaca 100%)';
                iconSymbol.className = 'fas fa-exclamation-triangle';
                iconSymbol.style.color = '#dc2626';
                confirmBtn.style.background = 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)';
                confirmBtn.innerHTML = '<i class="fas fa-trash-alt me-2"></i>' + (options.confirmText || 'Ya, Hapus');
            } else if (options.type === 'warning') {
                icon.style.background = 'linear-gradient(135deg, #fef3c7 0%, #fde68a 100%)';
                iconSymbol.className = 'fas fa-exclamation-triangle';
                iconSymbol.style.color = '#d97706';
                confirmBtn.style.background = 'linear-gradient(135deg, #f59e0b 0%, #d97706 100%)';
                confirmBtn.innerHTML = '<i class="fas fa-check me-2"></i>' + (options.confirmText || 'Ya, Lanjutkan');
            } else if (options.type === 'success') {
                icon.style.background = 'linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%)';
                iconSymbol.className = 'fas fa-check-circle';
                iconSymbol.style.color = '#10b981';
                confirmBtn.style.background = 'linear-gradient(135deg, #10b981 0%, #059669 100%)';
                confirmBtn.innerHTML = '<i class="fas fa-check me-2"></i>' + (options.confirmText || 'Ya, Simpan');
            } else {
                icon.style.background = 'linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%)';
                iconSymbol.className = 'fas fa-question-circle';
                iconSymbol.style.color = '#3b82f6';
                confirmBtn.style.background = 'linear-gradient(135deg, #3b82f6 0%, #2563eb 100%)';
                confirmBtn.innerHTML = '<i class="fas fa-check me-2"></i>' + (options.confirmText || 'Ya');
            }

            if (options.body) {
                modalBody.style.display = 'block';
                modalBody.innerHTML = options.body;
            } else {
                modalBody.style.display = 'none';
                modalBody.innerHTML = '';
            }

            currentConfirmCallback = options.onConfirm;
            const onCancel = options.onCancel || function() {
                showCancelNotification('Operasi dibatalkan');
                modal.style.display = 'none';
            };

            const newConfirmBtn = confirmBtn.cloneNode(true);
            const newCancelBtn = cancelBtn.cloneNode(true);
            confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);
            cancelBtn.parentNode.replaceChild(newCancelBtn, cancelBtn);

            newConfirmBtn.onclick = function() {
                if (currentConfirmCallback) currentConfirmCallback();
                modal.style.display = 'none';
                currentConfirmCallback = null;
            };
            newCancelBtn.onclick = function() {
                onCancel();
                modal.style.display = 'none';
                currentConfirmCallback = null;
            };

            modal.style.display = 'block';
            modal.onclick = function(e) {
                if (e.target === modal) {
                    onCancel();
                    modal.style.display = 'none';
                    currentConfirmCallback = null;
                }
            };
        }

        function showSuccessNotification(msg) { showNotification(msg, '#10b981', 'fa-check-circle'); }
        function showErrorNotification(msg) { showNotification(msg, '#ef4444', 'fa-times-circle'); }
        function showWarningNotification(msg) { showNotification(msg, '#f59e0b', 'fa-exclamation-triangle'); }
        function showInfoNotification(msg) { showNotification(msg, '#3b82f6', 'fa-info-circle'); }
        function showCancelNotification(msg) { showNotification(msg, '#ef4444', 'fa-ban'); }

        function showNotification(message, color, icon) {
            const oldNotif = document.querySelector('.custom-notification');
            if (oldNotif) oldNotif.remove();

            const notification = document.createElement('div');
            notification.className = 'custom-notification';
            notification.style.cssText = `
                position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 340px;
                background: ${color}; color: white; padding: 14px 18px; border-radius: 16px;
                display: flex; align-items: center; gap: 12px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.15);
                animation: slideInRight 0.3s ease-out; font-family: 'Inter', sans-serif; font-weight: 500;
            `;
            notification.innerHTML = `
                <div style="background: rgba(255,255,255,0.2); width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="fas ${icon}" style="font-size: 18px;"></i>
                </div>
                <div style="flex: 1; font-size: 14px;">${message}</div>
                <button onclick="this.closest('.custom-notification').remove()" style="background: rgba(255,255,255,0.15); border: none; border-radius: 10px; padding: 5px 10px; color: white; cursor: pointer; font-size: 11px;">
                    <i class="fas fa-times me-1"></i> Tutup
                </button>
            `;
            document.body.appendChild(notification);
            setTimeout(() => { if (notification.parentNode) notification.remove(); }, 3000);
        }

        function cancelCreate(returnUrl, itemName) {
            showCancelNotification(itemName + ' dibatalkan');
            setTimeout(() => window.location.href = returnUrl, 800);
        }

        function cancelEdit(returnUrl, itemName) {
            showCancelNotification(itemName + ' dibatalkan');
            setTimeout(() => window.location.href = returnUrl, 800);
        }

        function confirmDelete(event, formId, itemName) {
            event.preventDefault();
            showConfirmModal({
                title: 'Hapus ' + itemName,
                message: 'Apakah Anda yakin ingin menghapus ' + itemName + '? Data yang dihapus tidak dapat dikembalikan.',
                type: 'danger',
                confirmText: 'Ya, Hapus',
                onConfirm: () => document.getElementById(formId).submit(),
                onCancel: () => showCancelNotification('Penghapusan ' + itemName + ' dibatalkan')
            });
        }

        function confirmApprove(formId, itemName) {
            showConfirmModal({
                title: 'Setujui Peminjaman',
                message: 'Apakah Anda yakin ingin menyetujui peminjaman ' + itemName + '?',
                type: 'success',
                confirmText: 'Ya, Setujui',
                onConfirm: () => document.getElementById(formId).submit(),
                onCancel: () => showCancelNotification('Persetujuan peminjaman dibatalkan')
            });
        }

        function confirmReject(formId, itemName) {
            showConfirmModal({
                title: 'Tolak Peminjaman',
                message: 'Apakah Anda yakin ingin menolak peminjaman ' + itemName + '?',
                type: 'warning',
                confirmText: 'Ya, Tolak',
                onConfirm: () => document.getElementById(formId).submit(),
                onCancel: () => showCancelNotification('Penolakan peminjaman dibatalkan')
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success')) showSuccessNotification('{{ session('success') }}'); @endif
            @if(session('error')) showErrorNotification('{{ session('error') }}'); @endif
            @if(session('warning')) showWarningNotification('{{ session('warning') }}'); @endif
            @if(session('info')) showInfoNotification('{{ session('info') }}'); @endif
            @if(session('cancel')) showCancelNotification('{{ session('cancel') }}'); @endif
        });
    </script>

    <!-- Modal Logout -->
        <div id="logoutModal" class="modal-overlay" style="display: none;">
            <div class="modal-container">
                <div class="modal-header">
                    <div class="modal-icon">
                        <i class="fas fa-sign-out-alt"></i>
                    </div>
                    <h3>Konfirmasi Logout</h3>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin keluar dari sistem?</p>
                    <p style="font-size: 12px; margin-top: 8px; color: #9ca3af;">Anda akan diarahkan ke halaman login</p>
                </div>
                <div class="modal-footer">
                    <button class="modal-btn modal-btn-cancel" id="logoutCancelBtn">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button class="modal-btn modal-btn-confirm" id="logoutConfirmBtn">
                        <i class="fas fa-sign-out-alt me-2"></i>Ya, Logout
                    </button>
                </div>
            </div>
        </div>

        <style>
            .modal-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.6);
                backdrop-filter: blur(4px);
                z-index: 999999 !important;
                display: none;
                align-items: center;
                justify-content: center;
            }
            .modal-container {
                background: white;
                border-radius: 24px;
                width: 90%;
                max-width: 420px;
                z-index: 1000000 !important;
                position: relative;
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
                animation: modalSlideIn 0.3s ease;
            }
            .modal-header {
                padding: 24px 24px 0 24px;
                text-align: center;
            }
            .modal-icon {
                width: 70px;
                height: 70px;
                background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
                border-radius: 50%;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 16px;
            }
            .modal-icon i {
                font-size: 32px;
                color: #dc2626;
            }
            .modal-header h3 {
                font-size: 20px;
                font-weight: 700;
                color: #1f2937;
                margin: 0;
            }
            .modal-body {
                padding: 16px 24px 0 24px;
                text-align: center;
            }
            .modal-body p {
                font-size: 14px;
                color: #6b7280;
                line-height: 1.5;
                margin: 0;
            }
            .modal-footer {
                padding: 20px 24px 24px 24px;
                display: flex;
                gap: 12px;
                justify-content: center;
            }
            .modal-btn {
                padding: 10px 24px;
                border-radius: 12px;
                font-weight: 600;
                font-size: 14px;
                cursor: pointer !important;
                transition: all 0.2s;
                border: none;
                flex: 1;
            }
            .modal-btn-cancel {
                background: #f3f4f6;
                color: #6b7280;
            }
            .modal-btn-cancel:hover {
                background: #e5e7eb;
                transform: translateY(-1px);
            }
            .modal-btn-confirm {
                background: linear-gradient(135deg, #ef4444, #dc2626);
                color: white;
            }
            .modal-btn-confirm:hover {
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
            }
            @keyframes modalSlideIn {
                from {
                    opacity: 0;
                    transform: translateY(30px) scale(0.95);
                }
                to {
                    opacity: 1;
                    transform: translateY(0) scale(1);
                }
            }



                        /* Dark Mode */
                /* ========== DARK MODE LENGKAP - SEMUA ELEMEN ========== */
                .dark-mode {
                    background: #1a1a2e !important;
                    color: #e0e0e0 !important;
                }

                /* SEMUA TEKS DI DALAM BODY */
                .dark-mode body,
                .dark-mode p,
                .dark-mode h1, .dark-mode h2, .dark-mode h3, .dark-mode h4, .dark-mode h5, .dark-mode h6,
                .dark-mode span,
                .dark-mode div:not(.sidebar):not(.avatar):not(.logo-area),
                .dark-mode label,
                .dark-mode .text-muted,
                .dark-mode .text-secondary,
                .dark-mode .small,
                .dark-mode small,
                .dark-mode strong,
                .dark-mode b,
                .dark-mode td,
                .dark-mode th,
                .dark-mode li,
                .dark-mode .form-label,
                .dark-mode .form-text {
                    color: #e0e0e0 !important;
                }

                /* Kecuali sidebar (tetap putih) */
                .dark-mode .sidebar,
                .dark-mode .sidebar *,
                .dark-mode .sidebar .nav-link,
                .dark-mode .sidebar .sidebar-header h3,
                .dark-mode .sidebar .sidebar-header p {
                    color: rgba(255,255,255,0.85) !important;
                }

                .dark-mode .sidebar .nav-link:hover {
                    color: white !important;
                }

                .dark-mode .sidebar .nav-link.active {
                    color: white !important;
                }

                /* Header logo area */
                .dark-mode .logo-area h2,
                .dark-mode .logo-area p {
                    color: #e0e0e0 !important;
                }

                .dark-mode .logo-area i {
                    color: #818cf8 !important;
                }



                /* Card dan Container */
                .dark-mode .card-stats,
                .dark-mode .card-modern,
                .dark-mode .search-card,
                .dark-mode .card-table,
                .dark-mode .booking-card,
                .dark-mode .card-form,
                .dark-mode .top-header,
                .dark-mode footer,
                .dark-mode .stat-card,
                .dark-mode .info-card,
                .dark-mode .ruangan-card,
                .dark-mode .modal-content,
                .dark-mode .modal-container,
                .dark-mode .modal-modern-content,
                .dark-mode .custom-modal-content,
                .dark-mode .pagination-wrapper {
                    background-color: #1e293b !important;
                }

                /* Tabel */
                .dark-mode .table,
                .dark-mode .table-modern,
                .dark-mode .table-custom {
                    background-color: #1e293b !important;
                }

                .dark-mode .table th,
                .dark-mode .table-modern th {
                    background-color: #0f172a !important;
                    color: #94a3b8 !important;
                }

                .dark-mode .table td,
                .dark-mode .table-modern td {
                    color: #cbd5e1 !important;
                    border-bottom-color: #334155 !important;
                }

                .dark-mode .table tr:hover {
                    background-color: #334155 !important;
                }

                /* Form Elements */
                .dark-mode .form-control,
                .dark-mode .form-select,
                .dark-mode .search-input,
                .dark-mode .input-group-text {
                    background-color: #334155 !important;
                    border-color: #475569 !important;
                    color: #e0e0e0 !important;
                }

                .dark-mode .form-control:focus,
                .dark-mode .form-select:focus {
                    background-color: #334155 !important;
                    color: #e0e0e0 !important;
                    border-color: #818cf8 !important;
                    box-shadow: 0 0 0 0.2rem rgba(129, 140, 248, 0.25) !important;
                }

                .dark-mode .form-control::placeholder {
                    color: #94a3b8 !important;
                }

                /* Buttons */
                .dark-mode .btn-custom,
                .dark-mode .btn-simpan,
                .dark-mode .btn-submit,
                .dark-mode .btn-primary {
                    background: linear-gradient(135deg, #818cf8, #a78bfa) !important;
                    border: none !important;
                    color: white !important;
                }

                .dark-mode .btn-batal,
                .dark-mode .btn-secondary,
                .dark-mode .btn-cancel {
                    background-color: #334155 !important;
                    border-color: #475569 !important;
                    color: #cbd5e1 !important;
                }

                .dark-mode .btn-batal:hover,
                .dark-mode .btn-secondary:hover {
                    background-color: #475569 !important;
                    color: white !important;
                }

                .dark-mode .btn-danger {
                    background-color: #7f1d1d !important;
                    border-color: #991b1b !important;
                    color: #fca5a5 !important;
                }

                .dark-mode .btn-warning {
                    background-color: #92400e !important;
                    border-color: #b45309 !important;
                    color: #fde68a !important;
                }

                .dark-mode .btn-info {
                    background-color: #0e7490 !important;
                    border-color: #0891b2 !important;
                    color: #7dd3fc !important;
                }

                /* Badges */
                .dark-mode .badge.bg-success {
                    background-color: #065f46 !important;
                    color: #86efac !important;
                }

                .dark-mode .badge.bg-warning {
                    background-color: #92400e !important;
                    color: #fde68a !important;
                }

                .dark-mode .badge.bg-danger {
                    background-color: #7f1d1d !important;
                    color: #fca5a5 !important;
                }

                .dark-mode .badge.bg-primary {
                    background-color: #1e40af !important;
                    color: #93c5fd !important;
                }

                .dark-mode .badge.bg-info {
                    background-color: #0e7490 !important;
                    color: #7dd3fc !important;
                }

                .dark-mode .badge.bg-secondary {
                    background-color: #334155 !important;
                    color: #cbd5e1 !important;
                }

                /* Status Badge Kustom */
                .dark-mode .badge-pending,
                .dark-mode .status-pending {
                    background: #78350f !important;
                    color: #fde68a !important;
                }

                .dark-mode .badge-approved,
                .dark-mode .status-approved {
                    background: #065f46 !important;
                    color: #86efac !important;
                }

                .dark-mode .badge-rejected,
                .dark-mode .status-rejected {
                    background: #7f1d1d !important;
                    color: #fca5a5 !important;
                }

                /* Alert */
                .dark-mode .alert-success {
                    background-color: #064e3b !important;
                    color: #86efac !important;
                    border-color: #059669 !important;
                }

                .dark-mode .alert-danger {
                    background-color: #7f1d1d !important;
                    color: #fca5a5 !important;
                    border-color: #dc2626 !important;
                }

                .dark-mode .alert-warning {
                    background-color: #78350f !important;
                    color: #fde68a !important;
                    border-color: #d97706 !important;
                }

                .dark-mode .alert-info {
                    background-color: #0c4a6e !important;
                    color: #7dd3fc !important;
                    border-color: #0284c7 !important;
                }

                /* Modal */
                .dark-mode .modal-header,
                .dark-mode .modal-footer {
                    background-color: #1e293b !important;
                    border-color: #334155 !important;
                }

                .dark-mode .modal-title {
                    color: #e0e0e0 !important;
                }

                .dark-mode .modal-body {
                    background-color: #1e293b !important;
                    color: #cbd5e1 !important;
                }

                .dark-mode .modal .btn-close {
                    filter: invert(1);
                }

                /* Dropdown */
                .dark-mode .dropdown-menu {
                    background-color: #1e293b !important;
                    border-color: #334155 !important;
                }

                .dark-mode .dropdown-item {
                    color: #cbd5e1 !important;
                }

                .dark-mode .dropdown-item:hover {
                    background-color: #334155 !important;
                    color: #e0e0e0 !important;
                }

                /* Pagination */
                .dark-mode .pagination .page-link {
                    background-color: #334155 !important;
                    border-color: #475569 !important;
                    color: #cbd5e1 !important;
                }

                .dark-mode .pagination .page-link:hover {
                    background-color: #475569 !important;
                    color: white !important;
                }

                .dark-mode .pagination .active .page-link {
                    background: linear-gradient(135deg, #818cf8, #a78bfa) !important;
                    color: white !important;
                }

                .dark-mode .pagination .disabled .page-link {
                    background-color: #1e293b !important;
                    color: #64748b !important;
                }

                /* Sidebar (tetap gelap tapi teks putih) */
                .dark-mode .sidebar {
                    background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%) !important;
                }

                /* Card rekomendasi ruangan */
                .dark-mode .ruangan-card .ruangan-info h5,
                .dark-mode .ruangan-card .ruangan-info p,
                .dark-mode .ruangan-card .ruangan-info .kapasitas,
                .dark-mode .ruangan-card .ruangan-info .lokasi {
                    color: #e0e0e0 !important;
                }

                .dark-mode .fasilitas-badge {
                    background-color: #334155 !important;
                    color: #cbd5e1 !important;
                }

                /* Statistik Cards */
                .dark-mode .stat-info h3,
                .dark-mode .stat-info p {
                    color: #e0e0e0 !important;
                }

                /* Welcome Card */
                .dark-mode .welcome-card {
                    background: linear-gradient(135deg, #1e3c72, #2a5298) !important;
                }

                /* Ruangan Card */
                .dark-mode .ruangan-card {
                    background-color: #1e293b !important;
                }

                /* Section Title */
                .dark-mode .section-title h4,
                .dark-mode .section-title p {
                    color: #e0e0e0 !important;
                }

                /* Footer */
                .dark-mode footer h5,
                .dark-mode footer p,
                .dark-mode footer .text-muted {
                    color: #cbd5e1 !important;
                }

                .dark-mode .page-title {
                    color: #e0e0e0 !important;
                }

                .dark-mode .visitor-card,
                .dark-mode .info-card,
                .dark-mode .weather-card {
                    background-color: #1e293b !important;
                }

                .dark-mode .visitor-number,
                .dark-mode .visitor-date,
                .dark-mode .stat-number,
                .dark-mode .weather-temp,
                .dark-mode .weather-desc,
                .dark-mode .visitor-stats .stat-number {
                    color: #e0e0e0 !important;
                }

                .dark-mode .visitor-label,
                .dark-mode .stat-label,
                .dark-mode .weather-details span {
                    color: #94a3b8 !important;
                }

                .dark-mode .btn-reset,
                .dark-mode .btn-reset-visit {
                    background-color: #334155 !important;
                    color: #cbd5e1 !important;
                }

                .dark-mode .btn-reset:hover,
                .dark-mode .btn-reset-visit:hover {
                    background-color: #475569 !important;
                    color: white !important;
                }

                .dark-mode .welcome-card {
                    background: linear-gradient(135deg, #1e3c72, #2a5298) !important;
                }

                .dark-mode .welcome-title,
                .dark-mode .welcome-subtitle,
                .dark-mode .welcome-date {
                    color: white !important;
                }

                .dark-mode .btn-detail:hover,
                .dark-mode .btn-action:hover {
                    opacity: 0.8 !important;
                    transform: translateY(-1px) !important;
                }

                .dark-mode .btn-detail {
                    background-color: #0e7490 !important;
                    color: #7dd3fc !important;
                }

                .dark-mode .btn-edit {
                    background-color: #92400e !important;
                    color: #fde68a !important;
                }

                .dark-mode .btn-delete {
                    background-color: #7f1d1d !important;
                    color: #fca5a5 !important;
                }

                /* Tabel hover effect */
                .dark-mode .table-modern tr:hover {
                    background-color: #334155 !important;
                }

                /* Tombol Detail di tabel peminjaman */
                .dark-mode .btn-detail-sm {
                    background-color: #0e7490 !important;
                    color: #7dd3fc !important;
                }

                .dark-mode .btn-detail-sm:hover {
                    background-color: #0891b2 !important;
                    color: white !important;
                }

                /* ========== DARK MODE - UPLOAD FOTO ========== */
                .dark-mode .upload-wrapper {
                    background-color: transparent !important;
                }

                .dark-mode .upload-label {
                    background-color: #334155 !important;
                    border: 2px dashed #475569 !important;
                    border-radius: 16px !important;
                }

                .dark-mode .upload-label:hover {
                    background-color: #475569 !important;
                    border-color: #818cf8 !important;
                }

                .dark-mode .upload-label span {
                    color: #e0e0e0 !important;
                }

                .dark-mode .upload-label small {
                    color: #94a3b8 !important;
                }

                .dark-mode .upload-label i {
                    color: #818cf8 !important;
                }

                .dark-mode .file-input {
                    background-color: transparent !important;
                }

                /* Preview foto yang sudah diupload */
                .dark-mode .current-photo {
                    background-color: #1e293b !important;
                    padding: 10px;
                    border-radius: 12px;
                }

                .dark-mode .current-photo small {
                    color: #94a3b8 !important;
                }

                /* Form control untuk file */
                .dark-mode input[type="file"] {
                    background-color: #334155 !important;
                    color: #e0e0e0 !important;
                    border-color: #475569 !important;
                }

                .dark-mode input[type="file"]::file-selector-button {
                    background-color: #475569 !important;
                    color: #e0e0e0 !important;
                    border: none !important;
                    padding: 8px 16px !important;
                    border-radius: 8px !important;
                    cursor: pointer !important;
                }

                .dark-mode input[type="file"]::file-selector-button:hover {
                    background-color: #64748b !important;
                }

                /* ========== DARK MODE - SEMUA POP-UP / MODAL ========== */

                /* Modal Konfirmasi Global */
                .dark-mode #confirmationModal .custom-modal-content,
                .dark-mode #globalConfirmModal .modal-container,
                .dark-mode #detailModal .modal-detail-content,
                .dark-mode .modal-modern-content,
                .dark-mode .modal-content,
                .dark-mode .modal-dialog {
                    background-color: #1e293b !important;
                    border: 1px solid #334155 !important;
                }

                /* Header Modal */
                .dark-mode .modal-header,
                .dark-mode .modal-detail-header,
                .dark-mode .modal-modern-header {
                    background: linear-gradient(135deg, #1e3c72, #2a5298) !important;
                    border-bottom-color: #334155 !important;
                }

                .dark-mode .modal-header h4,
                .dark-mode .modal-detail-header h4,
                .dark-mode .modal-modern-header h4,
                .dark-mode .modal-title {
                    color: white !important;
                }

                /* Body Modal */
                .dark-mode .modal-body,
                .dark-mode .modal-detail-body,
                .dark-mode .modal-modern-body {
                    background-color: #1e293b !important;
                    color: #e0e0e0 !important;
                }

                /* Footer Modal */
                .dark-mode .modal-footer,
                .dark-mode .modal-detail-footer,
                .dark-mode .modal-modern-footer {
                    background-color: #1e293b !important;
                    border-top-color: #334155 !important;
                }

                /* Teks dalam modal */
                .dark-mode .modal-body p,
                .dark-mode .modal-body .label,
                .dark-mode .modal-body .value,
                .dark-mode .modal-body .info-label,
                .dark-mode .modal-body .info-value,
                .dark-mode .modal-body .info-item,
                .dark-mode .modal-body .info-row .info-label,
                .dark-mode .modal-body .info-row .info-value {
                    color: #e0e0e0 !important;
                }

                /* Info Card dalam modal */
                .dark-mode .modal-body .info-card,
                .dark-mode .modal-body .info-section {
                    background-color: #0f172a !important;
                    border-color: #334155 !important;
                }

                .dark-mode .modal-body .info-card h6,
                .dark-mode .modal-body .info-section h6 {
                    color: #e0e0e0 !important;
                    border-bottom-color: #334155 !important;
                }

                /* Tombol close modal */
                .dark-mode .modal-header .btn-close,
                .dark-mode .modal-detail-close,
                .dark-mode .modal-modern-close {
                    background-color: rgba(255,255,255,0.2) !important;
                    color: white !important;
                }

                .dark-mode .modal-header .btn-close:hover,
                .dark-mode .modal-detail-close:hover,
                .dark-mode .modal-modern-close:hover {
                    background-color: rgba(255,255,255,0.3) !important;
                }

                /* Modal Confirm (Approve/Reject) */
                .dark-mode .modal-confirm-content {
                    background-color: #1e293b !important;
                    border: 1px solid #334155 !important;
                }

                .dark-mode .modal-confirm-content h3 {
                    color: #e0e0e0 !important;
                }

                .dark-mode .modal-confirm-content p {
                    color: #94a3b8 !important;
                }

                .dark-mode .modal-confirm-icon.success {
                    background: linear-gradient(135deg, #064e3b, #065f46) !important;
                    color: #86efac !important;
                }

                .dark-mode .modal-confirm-icon.danger {
                    background: linear-gradient(135deg, #7f1d1d, #991b1b) !important;
                    color: #fca5a5 !important;
                }

                .dark-mode .btn-no {
                    background-color: #334155 !important;
                    color: #cbd5e1 !important;
                }

                .dark-mode .btn-no:hover {
                    background-color: #475569 !important;
                    color: white !important;
                }

                /* Modal Detail Peminjaman */
                .dark-mode .detail-modal .modal-content,
                .dark-mode #detailModal .modal-detail-content {
                    background-color: #1e293b !important;
                }

                .dark-mode .status-banner-pending {
                    background-color: #78350f !important;
                    color: #fde68a !important;
                }

                .dark-mode .status-banner-approved {
                    background-color: #065f46 !important;
                    color: #86efac !important;
                }

                .dark-mode .status-banner-rejected {
                    background-color: #7f1d1d !important;
                    color: #fca5a5 !important;
                }

                /* Tombol dalam modal */
                .dark-mode .btn-secondary,
                .dark-mode .btn-cancel {
                    background-color: #334155 !important;
                    color: #cbd5e1 !important;
                    border-color: #475569 !important;
                }

                .dark-mode .btn-secondary:hover,
                .dark-mode .btn-cancel:hover {
                    background-color: #475569 !important;
                    color: white !important;
                }

                .dark-mode .btn-approve {
                    background: linear-gradient(135deg, #065f46, #059669) !important;
                }

                .dark-mode .btn-reject {
                    background: linear-gradient(135deg, #7f1d1d, #dc2626) !important;
                }

                /* Modal dari dashboard */
                .dark-mode .modal.show .modal-content,
                .dark-mode .modal.show .modal-header,
                .dark-mode .modal.show .modal-body,
                .dark-mode .modal.show .modal-footer {
                    background-color: #1e293b !important;
                }

                .dark-mode .modal.show .modal-title {
                    color: #e0e0e0 !important;
                }

                .dark-mode .modal.show .btn-close {
                    filter: invert(1);
                }


        </style>

        <script>
            // Logout Modal Handler
            const logoutModal = document.getElementById('logoutModal');

            function showLogoutModal() {
                if (logoutModal) logoutModal.style.display = 'flex';
            }

            function closeLogoutModal() {
                if (logoutModal) logoutModal.style.display = 'none';
            }

            // Setup logout button
            document.addEventListener('DOMContentLoaded', function() {
                const logoutBtn = document.getElementById('logoutBtn');
                const logoutCancel = document.getElementById('logoutCancelBtn');
                const logoutConfirm = document.getElementById('logoutConfirmBtn');

                if (logoutBtn) {
                    logoutBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        showLogoutModal();
                    });
                }

                if (logoutCancel) {
                    logoutCancel.addEventListener('click', function() {
                        closeLogoutModal();
                    });
                }

                if (logoutConfirm) {
                    logoutConfirm.addEventListener('click', function() {
                        document.getElementById('logout-form').submit();
                    });
                }

                // Klik di luar modal
                if (logoutModal) {
                    logoutModal.addEventListener('click', function(e) {
                        if (e.target === logoutModal) {
                            closeLogoutModal();
                        }
                    });
                }
            });

            function updateDarkModeButtons(isDark) {
                const headerBtn = document.getElementById('darkModeToggleHeader');
                const sidebarBtn = document.getElementById('darkModeToggle');

                if (headerBtn) {
                    headerBtn.innerHTML = isDark ? '<i class="fas fa-sun"></i>' : '<i class="fas fa-moon"></i>';
                }
                if (sidebarBtn) {
                    sidebarBtn.innerHTML = isDark ? '<i class="fas fa-sun me-2"></i> Light Mode' : '<i class="fas fa-moon me-2"></i> Dark Mode';
                }
            }


            const darkModeHeaderBtn = document.getElementById('darkModeToggleHeader');
            if (darkModeHeaderBtn) {
                darkModeHeaderBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    toggleDarkMode();
                });
            }

            const userDropdown = document.getElementById('userDropdown');
            const userCard = document.getElementById('userCard');

            if (userCard) {
                userCard.addEventListener('click', function(e) {
                    e.stopPropagation();
                    userDropdown.classList.toggle('open');
                });
            }

            document.addEventListener('click', function() {
                if (userDropdown) {
                    userDropdown.classList.remove('open');
                }
            });

            const logoutBtnDropdown = document.getElementById('logoutBtnDropdown');
            if (logoutBtnDropdown) {
                const newLogoutBtnDropdown = logoutBtnDropdown.cloneNode(true);
                logoutBtnDropdown.parentNode.replaceChild(newLogoutBtnDropdown, logoutBtnDropdown);
                newLogoutBtnDropdown.addEventListener('click', function(e) {
                    e.preventDefault();
                    showLogoutModal();
                });
            }


        </script>

    <!-- Modal Konfirmasi Global -->
<div id="globalConfirmModal" class="modal-overlay" style="display: none;">
    <div class="modal-container">
        <div class="modal-header">
            <div class="modal-icon" id="globalModalIcon">
                <i class="fas fa-question-circle"></i>
            </div>
            <h3 id="globalModalTitle">Konfirmasi</h3>
        </div>
        <div class="modal-body">
            <p id="globalModalMessage">Apakah Anda yakin?</p>
        </div>
        <div class="modal-footer">
            <button class="modal-btn modal-btn-cancel" id="globalModalCancelBtn">
                <i class="fas fa-times me-2"></i>Batal
            </button>
            <button class="modal-btn modal-btn-confirm" id="globalModalConfirmBtn">
                <i class="fas fa-check me-2"></i>Ya, Lanjutkan
            </button>
        </div>
    </div>
</div>

<!-- Notifikasi Toast -->
<div id="toastNotification" class="toast-notification" style="display: none;">
    <div class="toast-content">
        <i class="fas fa-check-circle toast-icon"></i>
        <span class="toast-message"></span>
    </div>
</div>

<style>
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(4px);
        z-index: 999999 !important;
        display: none;
        align-items: center;
        justify-content: center;
    }
    .modal-container {
        background: white;
        border-radius: 24px;
        width: 90%;
        max-width: 420px;
        z-index: 1000000 !important;
        position: relative;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        animation: modalSlideIn 0.3s ease;
    }
    .modal-header {
        padding: 24px 24px 0 24px;
        text-align: center;
    }
    .modal-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
    }
    .modal-icon i { font-size: 32px; color: #dc2626; }
    .modal-header h3 { font-size: 20px; font-weight: 700; color: #1f2937; margin: 0; }
    .modal-body { padding: 16px 24px 0 24px; text-align: center; }
    .modal-body p { font-size: 14px; color: #6b7280; line-height: 1.5; margin: 0; }
    .modal-footer { padding: 20px 24px 24px 24px; display: flex; gap: 12px; justify-content: center; }
    .modal-btn { padding: 10px 24px; border-radius: 12px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.2s; border: none; flex: 1; }
    .modal-btn-cancel { background: #f3f4f6; color: #6b7280; }
    .modal-btn-cancel:hover { background: #e5e7eb; transform: translateY(-1px); }
    .modal-btn-confirm { background: linear-gradient(135deg, #ef4444, #dc2626); color: white; }
    .modal-btn-confirm:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3); }
    .modal-icon-success { background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); }
    .modal-icon-success i { color: #10b981; }
    .modal-btn-success { background: linear-gradient(135deg, #10b981, #059669); color: white; }
    .modal-icon-warning { background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); }
    .modal-icon-warning i { color: #d97706; }
    .modal-btn-warning { background: linear-gradient(135deg, #f59e0b, #d97706); color: white; }

    .toast-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 320px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        animation: slideInRight 0.3s ease;
    }
    .toast-content { display: flex; align-items: center; gap: 12px; padding: 14px 18px; }
    .toast-icon { font-size: 20px; }
    .toast-message { font-size: 14px; color: #1f2937; flex: 1; }
    .toast-success { border-left: 4px solid #10b981; }
    .toast-success .toast-icon { color: #10b981; }
    .toast-error { border-left: 4px solid #ef4444; }
    .toast-error .toast-icon { color: #ef4444; }
    .toast-warning { border-left: 4px solid #f59e0b; }
    .toast-warning .toast-icon { color: #f59e0b; }
    .toast-info { border-left: 4px solid #3b82f6; }
    .toast-info .toast-icon { color: #3b82f6; }

    @keyframes modalSlideIn { from { opacity: 0; transform: translateY(30px) scale(0.95); } to { opacity: 1; transform: translateY(0) scale(1); } }
    @keyframes slideInRight { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
</style>

<script>
    // ========================================
    // TOAST NOTIFICATION
    // ========================================
    function showToast(message, type = 'success') {
        const toast = document.getElementById('toastNotification');
        const toastIcon = toast.querySelector('.toast-icon');
        const toastMessage = toast.querySelector('.toast-message');

        toast.className = 'toast-notification toast-' + type;

        if (type === 'success') {
            toastIcon.className = 'toast-icon fas fa-check-circle';
        } else if (type === 'error') {
            toastIcon.className = 'toast-icon fas fa-times-circle';
        } else if (type === 'warning') {
            toastIcon.className = 'toast-icon fas fa-exclamation-triangle';
        } else {
            toastIcon.className = 'toast-icon fas fa-info-circle';
        }

        toastMessage.textContent = message;
        toast.style.display = 'block';

        setTimeout(() => {
            toast.style.display = 'none';
        }, 3000);
    }

    // ========================================
    // GLOBAL MODAL - VERSI SEDERHANA
    // ========================================
    let currentFormId = null;
    let currentActionType = null;

    function confirmAction(event, formId, itemName, actionType = 'delete') {
        event.preventDefault();

        currentFormId = formId;
        currentActionType = actionType;

        const modal = document.getElementById('globalConfirmModal');
        const modalIcon = document.getElementById('globalModalIcon');
        const modalTitle = document.getElementById('globalModalTitle');
        const modalMessage = document.getElementById('globalModalMessage');
        const confirmBtn = document.getElementById('globalModalConfirmBtn');

        if (actionType === 'delete') {
            modalIcon.className = 'modal-icon';
            modalIcon.innerHTML = '<i class="fas fa-trash-alt"></i>';
            modalTitle.textContent = 'Hapus ' + itemName;
            modalMessage.textContent = 'Apakah Anda yakin ingin menghapus ' + itemName + '? Data yang dihapus tidak dapat dikembalikan.';
            confirmBtn.className = 'modal-btn modal-btn-confirm';
            confirmBtn.innerHTML = '<i class="fas fa-trash-alt me-2"></i>Ya, Hapus';
        } else if (actionType === 'update') {
            modalIcon.className = 'modal-icon modal-icon-warning';
            modalIcon.innerHTML = '<i class="fas fa-edit"></i>';
            modalTitle.textContent = 'Update ' + itemName;
            modalMessage.textContent = 'Apakah Anda yakin ingin mengupdate ' + itemName + '?';
            confirmBtn.className = 'modal-btn modal-btn-confirm modal-btn-warning';
            confirmBtn.innerHTML = '<i class="fas fa-edit me-2"></i>Ya, Update';
        } else {
            modalIcon.className = 'modal-icon modal-icon-success';
            modalIcon.innerHTML = '<i class="fas fa-save"></i>';
            modalTitle.textContent = 'Simpan ' + itemName;
            modalMessage.textContent = 'Apakah Anda yakin ingin menyimpan ' + itemName + '?';
            confirmBtn.className = 'modal-btn modal-btn-confirm modal-btn-success';
            confirmBtn.innerHTML = '<i class="fas fa-save me-2"></i>Ya, Simpan';
        }

        modal.style.display = 'flex';
    }

    function closeGlobalModal() {
        document.getElementById('globalConfirmModal').style.display = 'none';
        currentFormId = null;
        currentActionType = null;
    }

    // Setup modal buttons
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('globalConfirmModal');
        const confirmBtn = document.getElementById('globalModalConfirmBtn');
        const cancelBtn = document.getElementById('globalModalCancelBtn');

        // Tombol konfirmasi
        confirmBtn.onclick = function() {
            if (currentFormId) {
                document.getElementById(currentFormId).submit();
                showToast('Memproses data...', 'info');
            }
            closeGlobalModal();
        };

        // Tombol batal
        cancelBtn.onclick = function() {
            closeGlobalModal();
            showToast('Operasi dibatalkan', 'info');
        };

        // Klik di luar modal
        modal.onclick = function(e) {
            if (e.target === modal) {
                closeGlobalModal();
                showToast('Operasi dibatalkan', 'info');
            }
        };
    });
</script>

<script>
    function showConfirmModal(options) {
    const modal = document.getElementById('confirmationModal');
    if (!modal) return;

    document.getElementById('modalTitle').textContent = options.title || 'Konfirmasi';
    document.getElementById('modalMessage').textContent = options.message || 'Apakah Anda yakin?';

    const iconSymbol = document.getElementById('modalIconSymbol');
    const confirmBtn = document.getElementById('modalConfirmBtn');

    if (options.type === 'danger') {
        document.getElementById('modalIcon').style.background = 'linear-gradient(135deg, #fee2e2 0%, #fecaca 100%)';
        iconSymbol.className = 'fas fa-exclamation-triangle';
        iconSymbol.style.color = '#dc2626';
        confirmBtn.style.background = 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)';
        confirmBtn.innerHTML = '<i class="fas fa-trash-alt me-2"></i>' + (options.confirmText || 'Ya, Hapus');
    } else if (options.type === 'warning') {
        document.getElementById('modalIcon').style.background = 'linear-gradient(135deg, #fef3c7 0%, #fde68a 100%)';
        iconSymbol.className = 'fas fa-exclamation-triangle';
        iconSymbol.style.color = '#d97706';
        confirmBtn.style.background = 'linear-gradient(135deg, #f59e0b 0%, #d97706 100%)';
        confirmBtn.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>' + (options.confirmText || 'Ya, Lanjutkan');
    } else {
        document.getElementById('modalIcon').style.background = 'linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%)';
        iconSymbol.className = 'fas fa-check-circle';
        iconSymbol.style.color = '#10b981';
        confirmBtn.style.background = 'linear-gradient(135deg, #10b981 0%, #059669 100%)';
        confirmBtn.innerHTML = '<i class="fas fa-check me-2"></i>' + (options.confirmText || 'Ya, Simpan');
    }

    const onConfirm = options.onConfirm || function() {};
    const onCancel = options.onCancel || function() { modal.style.display = 'none'; };

    const newConfirmBtn = confirmBtn.cloneNode(true);
    const newCancelBtn = document.getElementById('modalCancelBtn').cloneNode(true);
    confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);
    document.getElementById('modalCancelBtn').parentNode.replaceChild(newCancelBtn, document.getElementById('modalCancelBtn'));

    newConfirmBtn.onclick = function() { onConfirm(); modal.style.display = 'none'; };
    newCancelBtn.onclick = function() { onCancel(); modal.style.display = 'none'; };

    modal.style.display = 'block';
    modal.onclick = function(e) { if (e.target === modal) { onCancel(); modal.style.display = 'none'; } };
}

// Handler untuk flash message dari sessionStorage
document.addEventListener('DOMContentLoaded', function() {
    const flashMessage = sessionStorage.getItem('flashMessage');
    const flashType = sessionStorage.getItem('flashType');

    if (flashMessage) {
        if (flashType === 'success') showSuccessNotification(flashMessage);
        else if (flashType === 'error') showErrorNotification(flashMessage);
        else if (flashType === 'warning') showWarningNotification(flashMessage);
        else showInfoNotification(flashMessage);

        sessionStorage.removeItem('flashMessage');
        sessionStorage.removeItem('flashType');
    }
});

</script>

<!-- Modal Pop-up Modern -->
<div id="modalModern" class="modal-modern-overlay">
    <div class="modal-modern-container">
        <div class="modal-modern-header">
            <div id="modalModernIcon" class="modal-modern-icon icon-danger">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h3 id="modalModernTitle" class="modal-modern-title">Konfirmasi</h3>
            <p id="modalModernMessage" class="modal-modern-message">Apakah Anda yakin?</p>
        </div>
        <div id="modalModernBody" class="modal-modern-body" style="display: none;"></div>
        <div class="modal-modern-footer">
            <button id="modalModernCancelBtn" class="modal-modern-btn modal-modern-btn-cancel">
                <i class="fas fa-times me-2"></i>Batal
            </button>
            <button id="modalModernConfirmBtn" class="modal-modern-btn modal-modern-btn-confirm">
                <i class="fas fa-trash-alt me-2"></i>Ya
            </button>
        </div>
    </div>
</div>

<script>
    // Modal Modern Functions
    let modalModernCallback = null;

    function showModalModern(options) {
        const modal = document.getElementById('modalModern');
        const icon = document.getElementById('modalModernIcon');
        const title = document.getElementById('modalModernTitle');
        const message = document.getElementById('modalModernMessage');
        const confirmBtn = document.getElementById('modalModernConfirmBtn');
        const cancelBtn = document.getElementById('modalModernCancelBtn');
        const bodyDiv = document.getElementById('modalModernBody');

        title.textContent = options.title || 'Konfirmasi';
        message.textContent = options.message || 'Apakah Anda yakin?';

        if (options.type === 'danger') {
            icon.className = 'modal-modern-icon icon-danger';
            icon.innerHTML = '<i class="fas fa-exclamation-triangle"></i>';
            confirmBtn.className = 'modal-modern-btn modal-modern-btn-confirm';
            confirmBtn.innerHTML = '<i class="fas fa-trash-alt me-2"></i>' + (options.confirmText || 'Ya, Hapus');
        } else if (options.type === 'warning') {
            icon.className = 'modal-modern-icon icon-warning';
            icon.innerHTML = '<i class="fas fa-exclamation-triangle"></i>';
            confirmBtn.className = 'modal-modern-btn modal-modern-btn-warning';
            confirmBtn.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>' + (options.confirmText || 'Ya, Lanjutkan');
        } else if (options.type === 'success') {
            icon.className = 'modal-modern-icon icon-success';
            icon.innerHTML = '<i class="fas fa-check-circle"></i>';
            confirmBtn.className = 'modal-modern-btn modal-modern-btn-success';
            confirmBtn.innerHTML = '<i class="fas fa-check me-2"></i>' + (options.confirmText || 'Ya, Simpan');
        } else {
            icon.className = 'modal-modern-icon icon-info';
            icon.innerHTML = '<i class="fas fa-info-circle"></i>';
            confirmBtn.className = 'modal-modern-btn modal-modern-btn-confirm';
            confirmBtn.innerHTML = '<i class="fas fa-check me-2"></i>' + (options.confirmText || 'Ya');
        }

        if (options.body) {
            bodyDiv.style.display = 'block';
            bodyDiv.innerHTML = options.body;
        } else {
            bodyDiv.style.display = 'none';
        }

        modalModernCallback = options.onConfirm;
        const onCancel = options.onCancel || function() { closeModalModern(); };

        // Hapus event listener lama
        const newConfirmBtn = confirmBtn.cloneNode(true);
        const newCancelBtn = cancelBtn.cloneNode(true);
        confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);
        cancelBtn.parentNode.replaceChild(newCancelBtn, cancelBtn);

        newConfirmBtn.onclick = function() {
            if (modalModernCallback) modalModernCallback();
            closeModalModern();
        };
        newCancelBtn.onclick = function() {
            onCancel();
            closeModalModern();
        };

        modal.style.display = 'flex';
        modal.onclick = function(e) {
            if (e.target === modal) {
                onCancel();
                closeModalModern();
            }
        };
    }

    function closeModalModern() {
        document.getElementById('modalModern').style.display = 'none';
        modalModernCallback = null;
    }

    // Password Toggle
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.password-toggle').forEach(toggle => {
            toggle.addEventListener('click', function() {
                const input = this.previousElementSibling;
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
        });
    });
</script>



<script>

    (function() {
        const isDark = localStorage.getItem('darkMode') === 'true';
        if (isDark) {
            document.body.classList.add('dark-mode');
        }

        window.toggleDarkMode = function() {
            document.body.classList.toggle('dark-mode');
            const isDarkNow = document.body.classList.contains('dark-mode');
            localStorage.setItem('darkMode', isDarkNow);

            const btn = document.getElementById('darkModeToggle');
            if (btn) {
                btn.innerHTML = isDarkNow ? '<i class="fas fa-sun me-2"></i> Light Mode' : '<i class="fas fa-moon me-2"></i> Dark Mode';
            }
        };

        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('darkModeToggle');
            if (btn) {
                const isDarkNow = document.body.classList.contains('dark-mode');
                btn.innerHTML = isDarkNow ? '<i class="fas fa-sun me-2"></i> Light Mode' : '<i class="fas fa-moon me-2"></i> Dark Mode';
            }
        });
    })();
</script>


    @stack('scripts')
</body>
</html>

