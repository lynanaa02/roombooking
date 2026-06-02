@extends('layouts.organisasi')

@section('content')
<div class="container-fluidd px-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-0 fw-bold" id="pageTitle">
                <i class="fas fa-user-circle me-2 text-primary"></i>Profil Organisasi
            </h3>
            <p class="text-muted mb-0" id="pageSubtitle">Kelola informasi dan pengaturan akun organisasi Anda</p>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <ul class="mb-0 mt-1 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        {{-- LEFT COLUMN: Profile Card --}}
        <div class="col-lg-4">
            <div class="profile-card">
                <div class="profile-card-header">
                    <div class="profile-avatar">
                        @if($organisasi->foto && file_exists(public_path($organisasi->foto)))
                            <img src="{{ asset($organisasi->foto) }}" alt="Foto Organisasi">
                        @else
                            <div class="avatar-placeholder">
                                <i class="fas fa-building"></i>
                            </div>
                        @endif
                    </div>
                    <div class="profile-info mt-3">
                        <h4 class="fw-bold mb-1">{{ $organisasi->nama_organisasi }}</h4>
                        <p class="mb-2">{{ $organisasi->name }}</p>
                        <div class="profile-badge">
                            <span class="badge-custom {{ strtolower($organisasi->jenis_organisasi) }}">
                                <i class="fas fa-tag me-1"></i>{{ $organisasi->jenis_organisasi }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="profile-card-body">
                    <div class="info-row">
                        <div class="info-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="info-text">
                            <small class="text-muted d-block">Email</small>
                            <strong>{{ $organisasi->email }}</strong>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="info-text">
                            <small class="text-muted d-block">Ketua Organisasi</small>
                            <strong>{{ $organisasi->ketua_organisasi ?? '-' }}</strong>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="info-text">
                            <small class="text-muted d-block">Jumlah Anggota</small>
                            <strong>{{ $organisasi->jumlah_anggota ?? 0 }} orang</strong>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="info-text">
                            <small class="text-muted d-block">Nomor Telepon</small>
                            <strong>{{ $organisasi->no_telp ?? '-' }}</strong>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="info-text">
                            <small class="text-muted d-block">Terdaftar Sejak</small>
                            <strong>{{ $organisasi->created_at ? $organisasi->created_at->format('d M Y') : '-' }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN: Edit Forms --}}
        <div class="col-lg-8">
            {{-- Tab Navigation --}}
            <ul class="nav-modern" id="profileTab" role="tablist">
                <li class="nav-item-modern" role="presentation">
                    <button class="nav-link-modern" id="info-tab" data-tab="info">
                        <i class="fas fa-address-card me-2"></i>Informasi Dasar
                    </button>
                </li>
                <li class="nav-item-modern" role="presentation">
                    <button class="nav-link-modern" id="password-tab" data-tab="password">
                        <i class="fas fa-lock me-2"></i>Ganti Password
                    </button>
                </li>
            </ul>

            <div class="tab-content-modern">
                {{-- TAB 1: Informasi Dasar --}}
                <div class="tab-pane-modern" id="info-pane">
                    <div class="form-card">
                        <h5 class="form-card-title">
                            <i class="fas fa-edit me-2 text-primary"></i>Edit Informasi Profil
                        </h5>
                        <form action="{{ route('organisasi.profile.update') }}" method="POST" enctype="multipart/form-data" id="infoForm">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label-custom">
                                        <i class="fas fa-tag me-1"></i>Nama Singkatan
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="name" class="form-control-custom"
                                           value="{{ old('name', $organisasi->name) }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label-custom">
                                        <i class="fas fa-building me-1"></i>Nama Lengkap Organisasi
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="nama_organisasi" class="form-control-custom"
                                           value="{{ old('nama_organisasi', $organisasi->nama_organisasi) }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label-custom">
                                        <i class="fas fa-envelope me-1"></i>Email
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" name="email" class="form-control-custom"
                                           value="{{ old('email', $organisasi->email) }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label-custom">
                                        <i class="fas fa-user-tie me-1"></i>Ketua Organisasi
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="ketua_organisasi" class="form-control-custom"
                                           value="{{ old('ketua_organisasi', $organisasi->ketua_organisasi) }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label-custom">
                                        <i class="fas fa-users me-1"></i>Jumlah Anggota
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" name="jumlah_anggota" class="form-control-custom"
                                           value="{{ old('jumlah_anggota', $organisasi->jumlah_anggota) }}" required min="1">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label-custom">
                                        <i class="fas fa-phone me-1"></i>Nomor Telepon
                                    </label>
                                    <input type="text" name="no_telp" class="form-control-custom"
                                           value="{{ old('no_telp', $organisasi->no_telp) }}" placeholder="085xxxxxxxxx">
                                </div>

                                <div class="col-12">
                                    <label class="form-label-custom">
                                        <i class="fas fa-image me-1"></i>Foto / Logo Organisasi
                                    </label>
                                    <div class="file-upload-wrapper">
                                        <input type="file" name="foto" id="foto" class="file-upload-input" accept="image/*">
                                        <label for="foto" class="file-upload-label">
                                            <i class="fas fa-cloud-upload-alt me-2"></i>
                                            <span>Pilih Foto</span>
                                        </label>
                                        <span class="file-upload-filename" id="filename">Tidak ada file dipilih</span>
                                    </div>
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>Format: JPG, PNG, JPEG. Maksimal 2MB
                                    </small>
                                </div>

                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn-save">
                                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- TAB 2: Ganti Password --}}
                <div class="tab-pane-modern" id="password-pane">
                    <div class="form-card">
                        <h5 class="form-card-title">
                            <i class="fas fa-key me-2 text-primary"></i>Ganti Password
                        </h5>
                        <form action="{{ route('organisasi.profile.password') }}" method="POST" id="passwordForm">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label class="form-label-custom">
                                    <i class="fas fa-lock me-1"></i>Password Lama
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="password" name="current_password" class="form-control-custom" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label-custom">
                                    <i class="fas fa-key me-1"></i>Password Baru
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="password" name="password" class="form-control-custom" required>
                                <small class="text-muted">Minimal 6 karakter</small>
                            </div>

                            <div class="mb-4">
                                <label class="form-label-custom">
                                    <i class="fas fa-check-circle me-1"></i>Konfirmasi Password Baru
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="password" name="password_confirmation" class="form-control-custom" required>
                            </div>

                            <button type="submit" class="btn-save">
                                <i class="fas fa-sync-alt me-2"></i>Ganti Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* CSS Variables untuk Light Mode (default) */
:root {
    --bg-gradient: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
    --card-bg: #ffffff;
    --text-primary: #1e293b;
    --text-secondary: #64748b;
    --text-muted: #6c757d;
    --border-color: #e2e8f0;
    --input-bg: #ffffff;
    --input-border: #e2e8f0;
    --shadow-sm: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    --shadow-md: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
    --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.08);
    --alert-success-bg: #d1fae5;
    --alert-success-text: #065f46;
    --alert-danger-bg: #fee2e2;
    --alert-danger-text: #991b1b;
}

/* Dark Mode */
body.dark-mode {
    --bg-gradient: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    --card-bg: #1e293b;
    --text-primary: #f1f5f9;
    --text-secondary: #94a3b8;
    --text-muted: #94a3b8;
    --border-color: #334155;
    --input-bg: #0f172a;
    --input-border: #334155;
    --shadow-sm: 0 4px 6px -1px rgba(0, 0, 0, 0.2);
    --shadow-md: 0 10px 15px -3px rgba(0, 0, 0, 0.2);
    --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.2);
    --alert-success-bg: #064e3b;
    --alert-success-text: #6ee7b7;
    --alert-danger-bg: #7f1d1d;
    --alert-danger-text: #fca5a5;
}

.container-fluidd {
    background: var(--bg-gradient);
    min-height: 100vh;
    padding: 2rem 1.5rem;
    transition: background 0.3s ease;
}

#pageTitle {
    color: var(--text-primary) !important;
}

#pageSubtitle {
    color: var(--text-muted) !important;
}

/* Profile Card */
.profile-card {
    background: var(--card-bg);
    border-radius: 28px;
    box-shadow: var(--shadow-lg);
    overflow: hidden;
    transition: all 0.3s ease;
    border: 1px solid var(--border-color);
}

.profile-card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 2rem 1.5rem;
    text-align: center;
    position: relative;
}

.profile-avatar {
    width: 120px;
    height: 120px;
    margin: 0 auto;
    border-radius: 50%;
    overflow: hidden;
    border: 4px solid rgba(255, 255, 255, 0.3);
    background: rgba(255, 255, 255, 0.2);
}

.profile-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.avatar-placeholder {
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
}

.avatar-placeholder i {
    font-size: 50px;
    color: white;
}

.profile-info h4 {
    color: white;
}

.profile-info p {
    color: rgba(255, 255, 255, 0.8);
}

.badge-custom {
    display: inline-flex;
    align-items: center;
    padding: 6px 16px;
    border-radius: 30px;
    font-size: 12px;
    font-weight: 600;
}

.badge-custom.ukm {
    background: rgba(59, 130, 246, 0.2);
    color: #60a5fa;
}

.badge-custom.bem {
    background: rgba(16, 185, 129, 0.2);
    color: #34d399;
}

.badge-custom.himpunan {
    background: rgba(245, 158, 11, 0.2);
    color: #fbbf24;
}

.profile-card-body {
    padding: 1.5rem;
}

.info-row {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--border-color);
}

.info-row:last-child {
    border-bottom: none;
}

.info-icon {
    width: 40px;
    height: 40px;
    background: rgba(102, 126, 234, 0.1);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #667eea;
    font-size: 18px;
}

.info-text {
    flex: 1;
}

.info-text small {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--text-muted);
}

.info-text strong {
    font-size: 14px;
    color: var(--text-primary);
}

/* Modern Navigation */
.nav-modern {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 1.5rem;
    background: var(--card-bg);
    padding: 0.5rem;
    border-radius: 60px;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
}

.nav-item-modern {
    list-style: none;
}

.nav-link-modern {
    padding: 0.75rem 1.8rem;
    border-radius: 40px;
    font-weight: 600;
    font-size: 14px;
    color: var(--text-secondary);
    background: transparent;
    border: none;
    transition: all 0.3s ease;
    cursor: pointer;
}

.nav-link-modern i {
    margin-right: 8px;
}

.nav-link-modern:hover {
    color: #667eea;
    background: rgba(102, 126, 234, 0.1);
}

.nav-link-modern.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

/* Form Card */
.form-card {
    background: var(--card-bg);
    border-radius: 24px;
    padding: 1.8rem;
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border-color);
}

.form-card-title {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid var(--border-color);
    color: var(--text-primary);
}

.form-label-custom {
    font-size: 0.85rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    display: block;
    color: var(--text-primary);
}

.form-label-custom i {
    color: #667eea;
}

.form-control-custom {
    width: 100%;
    padding: 0.75rem 1rem;
    background: var(--input-bg);
    border: 1px solid var(--input-border);
    border-radius: 14px;
    font-size: 0.9rem;
    color: var(--text-primary);
    transition: all 0.2s ease;
}

.form-control-custom:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

/* File Upload */
.file-upload-wrapper {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.file-upload-input {
    display: none;
}

.file-upload-label {
    background: rgba(102, 126, 234, 0.1);
    padding: 0.7rem 1.5rem;
    border-radius: 40px;
    font-size: 0.85rem;
    font-weight: 500;
    color: #667eea;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
}

.file-upload-label:hover {
    background: rgba(102, 126, 234, 0.2);
}

.file-upload-filename {
    font-size: 0.85rem;
    color: var(--text-secondary);
}

/* Save Button */
.btn-save {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    padding: 0.85rem 2rem;
    border-radius: 40px;
    font-weight: 600;
    font-size: 0.9rem;
    color: white;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
}

.btn-save:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
}

/* Alert Styles */
.alert-success {
    background: var(--alert-success-bg) !important;
    color: var(--alert-success-text) !important;
    border: none;
}

.alert-danger {
    background: var(--alert-danger-bg) !important;
    color: var(--alert-danger-text) !important;
    border: none;
}

.text-muted {
    color: var(--text-muted) !important;
}

/* Tab Content */
.tab-pane-modern {
    display: none;
}

.tab-pane-modern.active {
    display: block;
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive */
@media (max-width: 768px) {
    .container-fluidd {
        padding: 1rem;
    }

    .nav-modern {
        flex-direction: column;
        border-radius: 20px;
        background: transparent;
        gap: 0.5rem;
    }

    .nav-link-modern {
        text-align: center;
        background: var(--card-bg);
    }

    .profile-card {
        margin-bottom: 1rem;
    }

    .form-card {
        padding: 1.2rem;
    }
}
</style>

<script>
// ========================================
// TAB FUNCTION (DIPERBAIKI)
// ========================================
document.addEventListener('DOMContentLoaded', function() {
    // Get elements
    const infoTab = document.getElementById('info-tab');
    const passwordTab = document.getElementById('password-tab');
    const infoPane = document.getElementById('info-pane');
    const passwordPane = document.getElementById('password-pane');

    // Function to show Info tab
    function showInfoTab() {
        infoTab.classList.add('active');
        passwordTab.classList.remove('active');
        infoPane.classList.add('active');
        passwordPane.classList.remove('active');
        // Simpan ke sessionStorage
        sessionStorage.setItem('activeProfileTab', 'info');
    }

    // Function to show Password tab
    function showPasswordTab() {
        passwordTab.classList.add('active');
        infoTab.classList.remove('active');
        passwordPane.classList.add('active');
        infoPane.classList.remove('active');
        // Simpan ke sessionStorage
        sessionStorage.setItem('activeProfileTab', 'password');
    }

    // Event listeners
    infoTab.addEventListener('click', function(e) {
        e.preventDefault();
        showInfoTab();
    });

    passwordTab.addEventListener('click', function(e) {
        e.preventDefault();
        showPasswordTab();
    });

    // Cek sessionStorage untuk tab yang aktif
    const savedTab = sessionStorage.getItem('activeProfileTab');

    // Cek dari flash data (jika ada error/success dari ganti password)
    @if(session('tab') == 'password')
        showPasswordTab();
    @elseif(session('tab') == 'info')
        showInfoTab();
    @else
        // Default: info tab atau sesuai sessionStorage
        if (savedTab === 'password') {
            showPasswordTab();
        } else {
            showInfoTab();
        }
    @endif
});

// ========================================
// FILE UPLOAD FILENAME DISPLAY
// ========================================
const fotoInput = document.getElementById('foto');
if (fotoInput) {
    fotoInput.addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name || 'Tidak ada file dipilih';
        document.getElementById('filename').textContent = fileName;
    });
}

// ========================================
// DARK MODE - SINKRON DENGAN SIDEBAR
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
    if (savedTheme === 'dark') {
        document.body.classList.add('dark-mode');
    } else {
        document.body.classList.remove('dark-mode');
    }
}

// Listen for custom dark mode event from sidebar
document.addEventListener('darkModeChanged', function(e) {
    if (e.detail.isDark) {
        document.body.classList.add('dark-mode');
    } else {
        document.body.classList.remove('dark-mode');
    }
});

// Initialize dark mode on page load
initDarkMode();
</script>
@endsection
