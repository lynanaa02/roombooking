<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Sistem Booking Ruangan dan Gedung Universitas Jember</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            overflow-x: hidden;
            transition: background 0.3s ease;
        }

        /* Dark Mode Styles */
        body.dark-mode {
            background: #1a1a2e !important;
        }

        body.dark-mode .login-card {
            background: #1e293b !important;
        }

        body.dark-mode .login-header {
            background: linear-gradient(135deg, #1e3c72, #2a5298) !important;
        }

        body.dark-mode .login-header::before {
            background: #1e293b !important;
        }

        body.dark-mode .login-body {
            background: #1e293b !important;
        }

        body.dark-mode .form-group label {
            color: #e0e0e0 !important;
        }

        body.dark-mode .form-control,
        body.dark-mode .input-group-text {
            background-color: #334155 !important;
            border-color: #475569 !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode .form-control:focus {
            background-color: #334155 !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode .input-group-text {
            color: #818cf8 !important;
        }

        body.dark-mode .demo-info {
            background: #334155 !important;
        }

        body.dark-mode .demo-info h6,
        body.dark-mode .demo-info p {
            color: #cbd5e1 !important;
        }

        body.dark-mode .demo-info i {
            color: #818cf8 !important;
        }

        body.dark-mode .login-footer {
            background: #0f172a !important;
            border-top-color: #334155 !important;
        }

        body.dark-mode .login-footer p {
            color: #94a3b8 !important;
        }

        body.dark-mode .alert-danger {
            background: linear-gradient(135deg, #7f1d1d 0%, #991b1b 100%) !important;
            color: #fca5a5 !important;
            border-left-color: #ef4444 !important;
        }

        /* Dark Mode Toggle Button */
        .dark-mode-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            color: white;
            cursor: pointer;
            z-index: 1000;
            backdrop-filter: blur(4px);
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .dark-mode-toggle:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.05);
        }

        /* Background Animation */
        .bg-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
        }

        .bg-animation .circle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 20s infinite ease-in-out;
        }

        .circle-1 {
            width: 300px;
            height: 300px;
            top: -100px;
            left: -100px;
            animation-delay: 0s;
        }

        .circle-2 {
            width: 500px;
            height: 500px;
            bottom: -200px;
            right: -200px;
            animation-delay: 5s;
        }

        .circle-3 {
            width: 200px;
            height: 200px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation-delay: 10s;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            50% {
                transform: translateY(-20px) rotate(10deg);
            }
        }

        /* Login Container */
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 1;
            padding: 20px;
        }

        .login-card {
            background: white;
            border-radius: 30px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            max-width: 450px;
            width: 100%;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }

        .login-header::before {
            content: '';
            position: absolute;
            bottom: -20px;
            left: 0;
            right: 0;
            height: 40px;
            background: white;
            border-radius: 50% 50% 0 0;
        }

        .login-header i {
            font-size: 60px;
            margin-bottom: 20px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        .login-header h3 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .login-header p {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 0;
        }

        .login-body {
            padding: 40px 30px;
            background: white;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            display: block;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .input-group {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
        }

        .input-group:focus-within {
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.25);
        }

        .input-group-text {
            background: #f8f9fa;
            border: 1px solid #e0e0e0;
            border-right: none;
            color: #667eea;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }

        .form-control {
            border: 1px solid #e0e0e0;
            border-left: none;
            padding: 12px 15px;
            font-size: 14px;
            transition: all 0.3s;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #e0e0e0;
        }

        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 600;
            font-size: 16px;
            color: white;
            width: 100%;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login i {
            margin-right: 8px;
        }

        /* Alert Custom */
        .alert-custom {
            border-radius: 12px;
            border: none;
            padding: 12px 20px;
            margin-bottom: 25px;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% {
                transform: translateX(0);
            }
            25% {
                transform: translateX(-10px);
            }
            75% {
                transform: translateX(10px);
            }
        }

        .alert-danger {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #991b1b;
            border-left: 4px solid #dc2626;
        }

        /* Demo Info */
        .demo-info {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            border-radius: 12px;
            padding: 15px;
            margin-top: 25px;
            transition: all 0.3s ease;
        }

        .demo-info h6 {
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
        }

        .demo-info p {
            margin-bottom: 5px;
            font-size: 13px;
            color: #666;
        }

        .demo-info i {
            color: #667eea;
            width: 20px;
        }

        /* Footer */
        .login-footer {
            text-align: center;
            padding: 20px 30px;
            background: #f8f9fa;
            border-top: 1px solid #e0e0e0;
            transition: all 0.3s ease;
        }

        .login-footer p {
            margin: 0;
            font-size: 12px;
            color: #666;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .login-card {
                margin: 20px;
            }

            .login-header {
                padding: 30px 20px;
            }

            .login-body {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Dark Mode Toggle Button -->
    <button class="dark-mode-toggle" id="darkModeToggle">
        <i class="fas fa-moon"></i>
    </button>

    <div class="bg-animation">
        <div class="circle circle-1"></div>
        <div class="circle circle-2"></div>
        <div class="circle circle-3"></div>
    </div>

    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <img src="{{ asset('images/logo-unej.png') }}" alt="Logo" style="height: 60px; margin-bottom: 15px;">
                <h3>Sistem Booking Ruangan & Gedung</h3>
                <p>Universitas Jember</p>
            </div>

            <div class="login-body">
                @if($errors->any())
                    <div class="alert alert-custom alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <label>
                            <i class="fas fa-envelope me-2"></i>
                            Email Address
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" name="email" class="form-control"
                                   value="{{ old('email') }}" required autofocus
                                   placeholder="admin@unej.ac.id">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>
                            <i class="fas fa-lock me-2"></i>
                            Password
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" name="password" class="form-control"
                                   required placeholder="••••••••">
                        </div>
                    </div>

                    <button type="submit" class="btn-login">
                        <i class="fas fa-sign-in-alt"></i>
                        Login ke Sistem
                    </button>
                </form>

                <div class="text-center mt-3">
                    <a href="{{ route('password.request') }}" class="text-decoration-none">
                        <i class="fas fa-question-circle me-1"></i>Lupa password?
                    </a>
                </div>

                <div class="demo-info">
                    <h6>
                        <i class="fas fa-info-circle me-2"></i>
                        Demo Account
                    </h6>
                    <p>
                        <i class="fas fa-user-shield"></i>
                        <strong>Admin:</strong> admin@unej.ac.id / password123
                    </p>
                    <p class="mb-0">
                        <i class="fas fa-users"></i>
                        <strong>Organisasi:</strong> Daftarkan melalui admin terlebih dahulu
                    </p>
                </div>
            </div>

            <div class="login-footer">
                <p>&copy; {{ date('Y') }} Sistem Booking Ruangan dan Gedung</p>
                <p class="mb-0">Universitas Jember</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // ========================================
        // DARK MODE FUNCTIONS
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
            for(let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) === ' ') c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
            }
            return null;
        }

        function initDarkMode() {
            const savedTheme = getCookie('theme');
            const darkModeBtn = document.getElementById('darkModeToggle');

            if (savedTheme === 'dark') {
                document.body.classList.add('dark-mode');
                if (darkModeBtn) darkModeBtn.innerHTML = '<i class="fas fa-sun"></i>';
            } else {
                document.body.classList.remove('dark-mode');
                if (darkModeBtn) darkModeBtn.innerHTML = '<i class="fas fa-moon"></i>';
            }
        }

        function toggleDarkMode() {
            const darkModeBtn = document.getElementById('darkModeToggle');

            if (document.body.classList.contains('dark-mode')) {
                document.body.classList.remove('dark-mode');
                setCookie('theme', 'light');
                if (darkModeBtn) darkModeBtn.innerHTML = '<i class="fas fa-moon"></i>';
            } else {
                document.body.classList.add('dark-mode');
                setCookie('theme', 'dark');
                if (darkModeBtn) darkModeBtn.innerHTML = '<i class="fas fa-sun"></i>';
            }
        }

        // ========================================
        // INITIALIZE
        // ========================================
        document.addEventListener('DOMContentLoaded', function() {
            initDarkMode();

            const darkModeBtn = document.getElementById('darkModeToggle');
            if (darkModeBtn) {
                darkModeBtn.addEventListener('click', toggleDarkMode);
            }
        });

        // Auto hide alert after 3 seconds
        setTimeout(function() {
            $('.alert-custom').fadeOut('slow');
        }, 3000);

        // Add loading effect on submit
        $('form').on('submit', function() {
            $('.btn-login').html('<i class="fas fa-spinner fa-spin me-2"></i>Loading...').attr('disabled', true);
        });

        // Floating animation effect
        $(document).ready(function() {
            $('.circle').each(function(index) {
                var delay = index * 2;
                $(this).css('animation-delay', delay + 's');
            });
        });
    </script>
</body>
</html>
