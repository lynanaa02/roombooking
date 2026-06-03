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

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            overflow-x: hidden;
            transition: background 0.3s ease;
        }

        body.dark-mode {
            background: #1a1a2e !important;
        }

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: 260px;
            background: linear-gradient(180deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            transition: all 0.3s;
            z-index: 1000;
            overflow-y: auto;
        }

        body.dark-mode .sidebar {
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%) !important;
        }

        @media (max-width: 768px) {
            .sidebar {
                left: -260px;
            }
            .sidebar.active {
                left: 0;
            }
            .main-content {
                margin-left: 0 !important;
            }
        }

        .sidebar-header {
            padding: 24px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-header h3 {
            font-size: 18px;
            margin: 0;
            font-weight: 700;
        }

        .sidebar-header p {
            font-size: 11px;
            margin: 4px 0 0;
            opacity: 0.7;
        }

        .sidebar-menu {
            padding: 16px 0;
        }

        .sidebar-menu .nav-link {
            padding: 10px 20px;
            color: rgba(255,255,255,0.85);
            font-size: 13px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .sidebar-menu .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            padding-left: 26px;
        }

        .sidebar-menu .nav-link.active {
            background: rgba(255,255,255,0.15);
            border-left: 3px solid #ffd700;
        }

        .sidebar-menu .nav-link i {
            width: 22px;
            font-size: 16px;
        }

        /* MAIN CONTENT */
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: all 0.3s;
        }

        /* TOP HEADER */
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

        body.dark-mode .top-header {
            background: #1e293b;
            border-bottom-color: #334155;
        }

        /* MENU TOGGLE (hanya di HP) */
        .menu-toggle {
            display: none;
            background: #667eea;
            border: none;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 18px;
        }

        /* LOGO AREA */
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
            font-weight: 800;
            color: #1a1a2e;
            letter-spacing: -0.02em;
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

        /* USER INFO AREA */
        .user-info-area {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-shrink: 0;
        }

        .dark-mode-toggle {
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

        body.dark-mode .dark-mode-toggle {
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

        /* DROPDOWN MENU */
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

        /* CONTENT */
        .content-wrapper {
            padding: 24px;
            flex: 1;
        }

        @media (max-width: 768px) {
            .content-wrapper {
                padding: 16px;
            }
        }

        /* FOOTER */
        footer {
            background: white;
            padding: 20px 24px;
            text-align: center;
            margin-top: auto;
        }

        body.dark-mode footer {
            background: #1e293b;
        }

        footer p {
            font-size: 12px;
            color: #6b7280;
            margin: 0;
        }

        body.dark-mode footer p {
            color: #94a3b8;
        }

        /* RESPONSIVE HP */
        @media (max-width: 768px) {
            .menu-toggle {
                display: block;
            }

            .logo-text p {
                display: none;
            }

            .desktop-logo {
                display: none;
            }

            .mobile-logo {
                display: block !important;
                font-size: 16px !important;
                line-height: 1.2 !important;
                font-weight: 700 !important;
                white-space: normal !important;
            }

            .logo-img {
                width: 28px !important;
                height: 28px !important;
            }

            .logo-area {
                gap: 6px !important;
                flex: 0 1 auto !important;
            }

            .user-name-text {
                display: none;
            }

            .user-card {
                padding: 5px 10px;
            }

            .user-avatar {
                width: 32px;
                height: 32px;
                font-size: 12px;
            }

            .top-header {
                padding: 8px 12px;
                gap: 8px;
            }
        }

        /* MODAL LOGOUT */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            z-index: 999999;
            display: none;
            align-items: center;
            justify-content: center;
        }
        .modal-container {
            background: white;
            border-radius: 24px;
            width: 90%;
            max-width: 400px;
            text-align: center;
            padding: 24px;
        }
        body.dark-mode .modal-container {
            background: #1e293b;
        }
        .modal-icon {
            width: 70px;
            height: 70px;
            background: #fee2e2;
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
        .modal-container h3 {
            font-size: 20px;
            margin-bottom: 8px;
            color: #1f2937;
        }
        body.dark-mode .modal-container h3 {
            color: #e0e0e0;
        }
        .modal-container p {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 24px;
        }
        body.dark-mode .modal-container p {
            color: #94a3b8;
        }
        .modal-buttons {
            display: flex;
            gap: 12px;
        }
        .modal-btn {
            flex: 1;
            padding: 10px;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            border: none;
        }
        .modal-btn-cancel {
            background: #f3f4f6;
            color: #4b5563;
        }
        body.dark-mode .modal-btn-cancel {
            background: #334155;
            color: #cbd5e1;
        }
        .modal-btn-confirm {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }
    </style>
</head>
<body>
    <button class="menu-toggle" id="menuToggle">
        <i class="fas fa-bars"></i>
    </button>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h3><i class="fas fa-building me-2"></i>Booking System</h3>
            <p>Universitas Jember</p>
        </div>
        <div class="sidebar-menu">
            <a href="{{ route('organisasi.dashboard') }}" class="nav-link {{ request()->routeIs('organisasi.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('organisasi.ruangan.index') }}" class="nav-link {{ request()->routeIs('organisasi.ruangan*') ? 'active' : '' }}">
                <i class="fas fa-door-open"></i>
                <span>Daftar Ruangan</span>
            </a>
            <a href="{{ route('organisasi.booking.create') }}" class="nav-link">
                <i class="fas fa-calendar-plus"></i>
                <span>Booking Ruangan</span>
            </a>
            <a href="{{ route('organisasi.prosedur') }}" class="nav-link {{ request()->routeIs('organisasi.prosedur') ? 'active' : '' }}">
                <i class="fas fa-book-open"></i>
                <span>Prosedur</span>
            </a>
            <a href="{{ route('organisasi.riwayat.index') }}" class="nav-link {{ request()->routeIs('organisasi.riwayat') ? 'active' : '' }}">
                <i class="fas fa-history"></i>
                <span>Riwayat Booking</span>
            </a>
            <a href="{{ route('organisasi.profile') }}" class="nav-link">
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
                    <h2 class="mobile-logo">SISTEM BOOKING</h2>
                    <p>Universitas Jember</p>
                </div>
            </div>

            <div class="user-info-area">
                <button class="dark-mode-toggle" id="darkModeToggle">
                    <i class="fas fa-moon"></i>
                </button>

                <div class="user-dropdown" id="userDropdown">
                    <div class="user-card" id="userCard">
                        <div class="user-avatar">
                            @if(Auth::user()->foto && file_exists(public_path(Auth::user()->foto)))
                                <img src="{{ asset(Auth::user()->foto) }}" alt="Foto">
                            @else
                                {{ substr(Auth::user()->nama_organisasi ?? Auth::user()->name, 0, 2) }}
                            @endif
                        </div>
                        <div class="user-name-text">
                            <small>Organisasi</small>
                            <span>{{ Auth::user()->nama_organisasi ?? Auth::user()->name }}</span>
                        </div>
                        <i class="fas fa-chevron-down dropdown-icon"></i>
                    </div>
                    <div class="dropdown-menu-custom">
                        <a href="{{ route('organisasi.profile') }}">
                            <i class="fas fa-user-circle"></i> Profil
                        </a>
                        <a href="{{ route('organisasi.riwayat.index') }}">
                            <i class="fas fa-history"></i> Riwayat
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
                    <div class="col-md-4">
                        <p><strong>Sistem Booking Ruangan & Gedung</strong><br>Universitas Jember</p>
                    </div>
                    <div class="col-md-4">
                        <p><i class="fas fa-map-marker-alt me-2"></i>Jl. Kalimantan No.37, Jember<br>
                        <i class="fas fa-phone me-2"></i>(0331) 330224</p>
                    </div>
                    <div class="col-md-4">
                        <p>&copy; {{ date('Y') }} Sistem Booking<br>All rights reserved</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Modal Logout -->
    <div id="logoutModal" class="modal-overlay" style="display: none;">
        <div class="modal-container">
            <div class="modal-icon">
                <i class="fas fa-sign-out-alt"></i>
            </div>
            <h3>Konfirmasi Logout</h3>
            <p>Apakah Anda yakin ingin keluar dari sistem?</p>
            <div class="modal-buttons">
                <button class="modal-btn modal-btn-cancel" id="logoutCancelBtn">Batal</button>
                <button class="modal-btn modal-btn-confirm" id="logoutConfirmBtn">Ya, Logout</button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Dark Mode
        function setCookie(name, value, days = 365) {
            let expires = "";
            if (days) {
                const date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "") + expires + "; path=/";
        }

        function getCookie(name) {
            const nameEQ = name + "=";
            const ca = document.cookie.split(';');
            for (let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) === ' ') c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
            }
            return null;
        }

        function initDarkMode() {
            if (getCookie('theme') === 'dark') {
                document.body.classList.add('dark-mode');
                const btn = document.getElementById('darkModeToggle');
                if (btn) btn.innerHTML = '<i class="fas fa-sun"></i>';
            }
        }

        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
            const isDark = document.body.classList.contains('dark-mode');
            setCookie('theme', isDark ? 'dark' : 'light');
            const btn = document.getElementById('darkModeToggle');
            if (btn) btn.innerHTML = isDark ? '<i class="fas fa-sun"></i>' : '<i class="fas fa-moon"></i>';
        }

        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        if (menuToggle) {
            menuToggle.addEventListener('click', () => sidebar.classList.toggle('active'));
        }

        const userDropdown = document.getElementById('userDropdown');
        const userCard = document.getElementById('userCard');
        if (userCard) {
            userCard.addEventListener('click', (e) => {
                e.stopPropagation();
                userDropdown.classList.toggle('open');
            });
        }
        document.addEventListener('click', () => {
            if (userDropdown) userDropdown.classList.remove('open');
        });

        document.addEventListener('DOMContentLoaded', () => {
            initDarkMode();
            const darkBtn = document.getElementById('darkModeToggle');
            if (darkBtn) darkBtn.addEventListener('click', toggleDarkMode);
        });

        const logoutModal = document.getElementById('logoutModal');
        const logoutBtns = ['logoutBtn', 'logoutBtnDropdown'];
        const logoutCancel = document.getElementById('logoutCancelBtn');
        const logoutConfirm = document.getElementById('logoutConfirmBtn');

        function showLogoutModal() { if (logoutModal) logoutModal.style.display = 'flex'; }
        function closeLogoutModal() { if (logoutModal) logoutModal.style.display = 'none'; }

        logoutBtns.forEach(id => {
            const btn = document.getElementById(id);
            if (btn) btn.addEventListener('click', (e) => { e.preventDefault(); showLogoutModal(); });
        });
        if (logoutCancel) logoutCancel.addEventListener('click', closeLogoutModal);
        if (logoutConfirm) logoutConfirm.addEventListener('click', () => document.getElementById('logout-form').submit());
        if (logoutModal) logoutModal.addEventListener('click', (e) => { if (e.target === logoutModal) closeLogoutModal(); });
    </script>

    @stack('scripts')
</body>
</html>
