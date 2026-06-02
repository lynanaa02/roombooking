<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reset Password - Sistem Booking Ruangan dan Gedung Universitas Jember</title>
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
            transition: background 0.3s ease;
        }

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

        body.dark-mode .input-group-text {
            color: #818cf8 !important;
        }

        body.dark-mode .login-footer {
            background: #0f172a !important;
            border-top-color: #334155 !important;
        }

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

        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
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
        }

        .login-body {
            padding: 40px 30px;
            background: white;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            display: block;
            font-size: 14px;
        }

        .input-group {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .input-group-text {
            background: #f8f9fa;
            border: 1px solid #e0e0e0;
            border-right: none;
            color: #667eea;
            padding: 12px 15px;
        }

        .form-control {
            border: 1px solid #e0e0e0;
            border-left: none;
            padding: 12px 15px;
            font-size: 14px;
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
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .alert-custom {
            border-radius: 12px;
            border: none;
            padding: 12px 20px;
            margin-bottom: 25px;
        }

        .alert-danger {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #991b1b;
            border-left: 4px solid #dc2626;
        }

        .login-footer {
            text-align: center;
            padding: 20px 30px;
            background: #f8f9fa;
            border-top: 1px solid #e0e0e0;
        }

        .login-footer p {
            margin: 0;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <button class="dark-mode-toggle" id="darkModeToggle">
        <i class="fas fa-moon"></i>
    </button>

    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <i class="fas fa-key"></i>
                <h3>Reset Password</h3>
                <p>Sistem Booking Ruangan & Gedung Universitas Jember</p>
            </div>

            <div class="login-body">
                @if ($errors->any())
                    <div class="alert-custom alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        {{ $errors->first() }}
                    </div>
                @endif

                <p class="text-muted mb-4 text-center">
                    Silakan masukkan password baru Anda.
                </p>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group">
                        <label>
                            <i class="fas fa-envelope me-2"></i>
                            Alamat Email
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" name="email" class="form-control"
                                   value="{{ $email ?? old('email') }}" required readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>
                            <i class="fas fa-lock me-2"></i>
                            Password Baru
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" name="password" class="form-control"
                                   required placeholder="Minimal 6 karakter">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>
                            <i class="fas fa-lock me-2"></i>
                            Konfirmasi Password Baru
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-check"></i>
                            </span>
                            <input type="password" name="password_confirmation" class="form-control"
                                   required placeholder="Ketik ulang password baru">
                        </div>
                    </div>

                    <button type="submit" class="btn-login">
                        <i class="fas fa-save me-2"></i>
                        Reset Password
                    </button>
                </form>
            </div>

            <div class="login-footer">
                <p>&copy; {{ date('Y') }} Sistem Booking Ruangan dan Gedung</p>
                <p class="mb-0">Universitas Jember</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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

        document.addEventListener('DOMContentLoaded', function() {
            initDarkMode();

            const darkModeBtn = document.getElementById('darkModeToggle');
            if (darkModeBtn) {
                darkModeBtn.addEventListener('click', toggleDarkMode);
            }
        });
    </script>
</body>
</html>
