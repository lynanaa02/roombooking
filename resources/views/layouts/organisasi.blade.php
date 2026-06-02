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
            font-weight: 400;
            transition: background 0.3s ease;
        }

        /* Dark Mode */
        body.dark-mode {
            background: #1a1a2e !important;
        }

        /* Sidebar */
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

        body.dark-mode .sidebar {
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%) !important;
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
        }

        .sidebar-header p {
            font-size: 13px;
            margin: 6px 0 0;
            opacity: 0.8;
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

        /* Main Content */
        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: all 0.3s;
        }

        /* Top Header */
        .top-header {
            background: white;
            padding: 16px 28px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            position: sticky;
            top: 0;
            z-index: 99;
            border-bottom: 2px solid #386dd8;
        }

        body.dark-mode .top-header {
            background-color: #1e293b !important;
        }

        body.dark-mode .top-header .logo-area h2,
        body.dark-mode .top-header .logo-area p {
            color: #e0e0e0 !important;
        }

        .menu-toggle {
            display: none;
            background: #667eea;
            border: none;
            color: white;
            width: 42px;
            height: 42px;
            border-radius: 12px;
            cursor: pointer;
            font-size: 20px;
        }

        @media (max-width: 768px) {
            .menu-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .top-header {
                padding: 12px 16px;
            }
        }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .logo-img {
            width: 45px;
            height: 45px;
            object-fit: contain;
            border-radius: 10px;
        }

        .logo-area h2 {
            font-size: 20px;
            margin: 0;
            font-weight: 800;
            color: #1a1a2e;
        }

        .logo-area p {
            font-size: 12px;
            margin: 2px 0 0;
            color: #666;
        }

        @media (max-width: 768px) {
            .logo-area h2 { font-size: 14px !important; }
            .logo-area p { font-size: 9px !important; }
            .logo-area i { font-size: 24px; }
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .user-info .text-end small {
            font-size: 12px;
            font-weight: 500;
            color: #888;
        }

        .user-info .text-end div {
            font-size: 14px;
            font-weight: 700;
            color: #1a1a2e;
        }

        body.dark-mode .user-info .text-end small,
        body.dark-mode .user-info .text-end div {
            color: #e0e0e0 !important;
        }
       
        .user-info .avatar {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 18px;
        }

        .content-wrapper {
            padding: 28px;
            flex: 1;
        }

        @media (max-width: 768px) {
            .content-wrapper {
                padding: 16px;
            }
        }

        footer {
            background: white;
            padding: 20px 28px;
            text-align: center;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.04);
        }

        body.dark-mode footer {
            background-color: #1e293b !important;
        }

        body.dark-mode footer h5,
        body.dark-mode footer p {
            color: #cbd5e1 !important;
        }

        footer h5 {
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 12px;
            color: #1a1a2e;
        }

        footer p {
            font-size: 12px;
            margin-bottom: 4px;
            color: #888;
        }

        .btn-custom {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            padding: 10px 24px;
            border-radius: 12px;
            color: white;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102,126,234,0.4);
        }

        /* Dark Mode Toggle Button */
        .dark-mode-toggle {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 16px;
            padding: 8px;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .dark-mode-toggle:hover {
            background: rgba(255,255,255,0.1);
        }

        /* Modal Logout */
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
        body.dark-mode .modal-container {
            background-color: #1e293b !important;
        }
        body.dark-mode .modal-header h3 {
            color: #e0e0e0 !important;
        }
        body.dark-mode .modal-body p {
            color: #94a3b8 !important;
        }
        body.dark-mode .modal-btn-cancel {
            background-color: #334155 !important;
            color: #cbd5e1 !important;
        }
        @keyframes modalSlideIn {
            from { opacity: 0; transform: translateY(30px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
    </style>
</head>
<body>
    <button class="menu-toggle" id="menuToggle" style="position: fixed; top: 15px; left: 15px; z-index: 1001;">
        <i class="fas fa-bars"></i>
    </button>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h3><i class="fas fa-building me-2"></i>Booking System</h3>
            <p>Universitas Jember</p>
        </div>
        <div class="sidebar-menu">
            <button class="nav-link dark-mode-toggle" id="darkModeToggle">
                <i class="fas fa-moon"></i>
                <span>Dark Mode</span>
            </button>
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
            <a class="nav-link" href="{{ route('organisasi.profile') }}">
                <i class="fas fa-user-circle me-2"></i>
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
                <div>
                    <h2>SISTEM BOOKING RUANGAN & GEDUNG</h2>
                    <p>Universitas Jember</p>
                </div>
            </div>
            <div class="user-info">
                <div class="text-end">
                    <small>Organisasi</small>
                    <div>{{ Auth::user()->nama_organisasi ?? Auth::user()->name }}</div>
                </div>
                <div class="avatar">
                    {{ substr(Auth::user()->nama_organisasi ?? Auth::user()->name, 0, 2) }}
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
                </div>
            </div>
        </footer>
    </div>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // ========================================
        // DARK MODE
        // ========================================
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
            const isDark = getCookie('theme') === 'dark';
            if (isDark) {
                document.body.classList.add('dark-mode');
                updateDarkModeButton(true);
            }
        }

        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
            const isDark = document.body.classList.contains('dark-mode');
            setCookie('theme', isDark ? 'dark' : 'light');
            updateDarkModeButton(isDark);
        }

        function updateDarkModeButton(isDark) {
            const btn = document.getElementById('darkModeToggle');
            if (btn) {
                btn.innerHTML = isDark ? '<i class="fas fa-sun me-2"></i> Light Mode' : '<i class="fas fa-moon me-2"></i> Dark Mode';
            }
        }

        // ========================================
        // SIDEBAR TOGGLE
        // ========================================
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');

        if (menuToggle) {
            menuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('active');
            });
        }

        document.addEventListener('click', function(event) {
            if (window.innerWidth <= 768 && sidebar) {
                const isClickInsideSidebar = sidebar.contains(event.target);
                const isClickToggle = menuToggle ? menuToggle.contains(event.target) : false;
                if (!isClickInsideSidebar && !isClickToggle && sidebar.classList.contains('active')) {
                    sidebar.classList.remove('active');
                }
            }
        });

        // ========================================
        // INITIALIZE
        // ========================================
        document.addEventListener('DOMContentLoaded', function() {
            initDarkMode();

            const darkModeBtn = document.getElementById('darkModeToggle');
            if (darkModeBtn) {
                darkModeBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    toggleDarkMode();
                });
            }
        });

        // ========================================
        // LOGOUT MODAL
        // ========================================
        const logoutModal = document.getElementById('logoutModal');
        const logoutBtn = document.getElementById('logoutBtn');
        const logoutCancel = document.getElementById('logoutCancelBtn');
        const logoutConfirm = document.getElementById('logoutConfirmBtn');

        function showLogoutModal() {
            if (logoutModal) logoutModal.style.display = 'flex';
        }

        function closeLogoutModal() {
            if (logoutModal) logoutModal.style.display = 'none';
        }

        if (logoutBtn) {
            // Hapus event listener lama jika ada
            const newLogoutBtn = logoutBtn.cloneNode(true);
            logoutBtn.parentNode.replaceChild(newLogoutBtn, logoutBtn);

            newLogoutBtn.addEventListener('click', function(e) {
                e.preventDefault();
                showLogoutModal();
            });
        }

        if (logoutCancel) {
            const newCancelBtn = logoutCancel.cloneNode(true);
            logoutCancel.parentNode.replaceChild(newCancelBtn, logoutCancel);

            newCancelBtn.addEventListener('click', function() {
                closeLogoutModal();
            });
        }

        if (logoutConfirm) {
            const newConfirmBtn = logoutConfirm.cloneNode(true);
            logoutConfirm.parentNode.replaceChild(newConfirmBtn, logoutConfirm);

            newConfirmBtn.addEventListener('click', function() {
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
    </script>

    @stack('scripts')
</body>
</html>
