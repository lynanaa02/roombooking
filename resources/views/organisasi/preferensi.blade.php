{{-- @extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card-modern">
                <div class="card-header-modern">
                    <i class="fas fa-sliders-h me-2"></i> Pengaturan Preferensi
                </div>
                <div class="card-body p-4">
                    <!-- Tema Section -->
                    <div class="preference-section mb-4">
                        <h5 class="section-title">
                            <i class="fas fa-palette me-2"></i> Tema
                        </h5>
                        <p class="text-muted small mb-3">Pilih tampilan tema yang Anda sukai</p>
                        <div class="theme-buttons d-flex gap-3 flex-wrap">
                            <button class="theme-btn" id="themeLight" onclick="setTheme('light')">
                                <div class="theme-preview light-preview"></div>
                                <span>☀️ Light</span>
                            </button>
                            <button class="theme-btn" id="themeDark" onclick="setTheme('dark')">
                                <div class="theme-preview dark-preview"></div>
                                <span>🌙 Dark</span>
                            </button>
                            <button class="theme-btn" id="themeSystem" onclick="setTheme('system')">
                                <div class="theme-preview system-preview"></div>
                                <span>💻 System</span>
                            </button>
                        </div>
                    </div>

                    <!-- Font Size Section -->
                    <div class="preference-section mb-4">
                        <h5 class="section-title">
                            <i class="fas fa-text-height me-2"></i> Ukuran Font
                        </h5>
                        <p class="text-muted small mb-3">Pilih ukuran font yang nyaman untuk mata Anda</p>
                        <div class="font-buttons d-flex gap-3 flex-wrap">
                            <button class="font-size-btn" data-size="small" onclick="setFontSizePreference('small')">
                                <span>Aa</span>
                                <small>Kecil</small>
                            </button>
                            <button class="font-size-btn" data-size="medium" onclick="setFontSizePreference('medium')">
                                <span>Aa</span>
                                <small>Sedang</small>
                            </button>
                            <button class="font-size-btn" data-size="large" onclick="setFontSizePreference('large')">
                                <span>Aa</span>
                                <small>Besar</small>
                            </button>
                        </div>
                    </div>

                    <!-- Preview Section -->
                    <div class="preference-section">
                        <h5 class="section-title">
                            <i class="fas fa-eye me-2"></i> Preview
                        </h5>
                        <p class="text-muted small mb-3">Contoh tampilan teks dengan pengaturan Anda</p>
                        <div class="preview-box p-3 rounded">
                            <h6>Judul Section</h6>
                            <p>Ini adalah contoh teks biasa. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            <button class="btn btn-sm btn-primary">Contoh Tombol</button>
                        </div>
                    </div>

                    <div class="alert alert-info mt-4">
                        <i class="fas fa-info-circle me-2"></i>
                        Pengaturan Anda akan disimpan dan berlaku di semua halaman.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card-header-modern {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 18px 24px;
        font-size: 18px;
        font-weight: 600;
        border-radius: 16px 16px 0 0;
    }
    .card-body {
        padding: 24px;
    }
    .preference-section {
        border-bottom: 1px solid #e5e7eb;
        padding-bottom: 24px;
        margin-bottom: 24px;
    }
    .preference-section:last-child {
        border-bottom: none;
        padding-bottom: 0;
        margin-bottom: 0;
    }
    .section-title {
        font-size: 16px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 8px;
    }
    .theme-buttons, .font-buttons {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
    }
    .theme-btn {
        background: #f8fafc;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 12px 20px;
        cursor: pointer;
        transition: all 0.2s;
        text-align: center;
        min-width: 100px;
    }
    .theme-btn:hover {
        border-color: #667eea;
        transform: translateY(-2px);
    }
    .theme-btn.active {
        border-color: #667eea;
        background: linear-gradient(135deg, #667eea15, #764ba215);
    }
    .theme-preview {
        width: 60px;
        height: 40px;
        border-radius: 8px;
        margin-bottom: 8px;
        margin-left: auto;
        margin-right: auto;
    }
    .light-preview {
        background: white;
        border: 1px solid #e5e7eb;
    }
    .dark-preview {
        background: #1e293b;
        border: 1px solid #334155;
    }
    .system-preview {
        background: linear-gradient(135deg, white 50%, #1e293b 50%);
        border: 1px solid #e5e7eb;
    }
    .font-size-btn {
        background: #f8fafc;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 12px 20px;
        cursor: pointer;
        transition: all 0.2s;
        text-align: center;
        min-width: 80px;
    }
    .font-size-btn:hover {
        border-color: #667eea;
        transform: translateY(-2px);
    }
    .font-size-btn.active {
        border-color: #667eea;
        background: linear-gradient(135deg, #667eea15, #764ba215);
    }
    .font-size-btn span {
        font-weight: 700;
        display: block;
        margin-bottom: 4px;
    }
    .font-size-btn[data-size="small"] span { font-size: 13px; }
    .font-size-btn[data-size="medium"] span { font-size: 15px; }
    .font-size-btn[data-size="large"] span { font-size: 17px; }
    .preview-box {
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
    }
    .dark .preview-box {
        background: #1e293b;
        border-color: #334155;
    }
    .dark .section-title {
        color: #e0e0e0;
    }
    .dark .theme-btn,
    .dark .font-size-btn {
        background: #1e293b;
        border-color: #334155;
        color: #e0e0e0;
    }
    .dark .theme-btn:hover,
    .dark .font-size-btn:hover {
        border-color: #818cf8;
    }
</style>

<script>
    function setTheme(theme) {
        if (theme === 'system') {
            const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (systemPrefersDark) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
            deleteCookie('theme');
        } else if (theme === 'dark') {
            document.documentElement.classList.add('dark');
            setCookie('theme', 'dark');
        } else {
            document.documentElement.classList.remove('dark');
            setCookie('theme', 'light');
        }

        // Update active state
        document.querySelectorAll('.theme-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        if (theme === 'dark') {
            document.getElementById('themeDark')?.classList.add('active');
        } else if (theme === 'light') {
            document.getElementById('themeLight')?.classList.add('active');
        } else {
            document.getElementById('themeSystem')?.classList.add('active');
        }

        // Update dark mode toggle button di sidebar
        const toggleBtn = document.getElementById('darkModeToggle');
        if (toggleBtn) {
            const isDark = document.documentElement.classList.contains('dark');
            toggleBtn.innerHTML = isDark ? '<i class="fas fa-sun me-2"></i> Light Mode' : '<i class="fas fa-moon me-2"></i> Dark Mode';
        }

        // Simpan ke server
        fetch('{{ route("admin.preferensi.save") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ theme: theme })
        });
    }

    function setFontSizePreference(size) {
        setFontSize(size);

        // Update active state
        document.querySelectorAll('.font-size-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        document.querySelector(`.font-size-btn[data-size="${size}"]`)?.classList.add('active');

        fetch('{{ route("admin.preferensi.save") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ font_size: size })
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const savedTheme = getCookie('theme');
        if (savedTheme === 'dark') {
            document.getElementById('themeDark')?.classList.add('active');
            document.documentElement.classList.add('dark');
        } else if (savedTheme === 'light') {
            document.getElementById('themeLight')?.classList.add('active');
        } else {
            document.getElementById('themeSystem')?.classList.add('active');
            const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (systemPrefersDark) {
                document.documentElement.classList.add('dark');
            }
        }

        const savedFontSize = getCookie('fontSize');
        if (savedFontSize) {
            document.querySelector(`.font-size-btn[data-size="${savedFontSize}"]`)?.classList.add('active');
            setFontSize(savedFontSize);
        }
    });
</script>
@endsection --}}
