@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-modern">
                <div class="card-header-modern">
                    <i class="fas fa-plus-circle me-2"></i> Tambah Organisasi Baru
                </div>

                <form method="POST" action="{{ route('admin.organisasi.store') }}" enctype="multipart/form-data" id="createForm">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Organisasi <span class="text-danger">*</span></label>
                            <input type="text" name="nama_organisasi" class="form-control @error('nama_organisasi') is-invalid @enderror" value="{{ old('nama_organisasi') }}" required>
                            @error('nama_organisasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Pendek <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <small class="text-muted">Nama singkatan untuk tampilan di sistem</small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" name="no_telp" class="form-control @error('no_telp') is-invalid @enderror" value="{{ old('no_telp') }}">
                            @error('no_telp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ketua Organisasi <span class="text-danger">*</span></label>
                            <input type="text" name="ketua_organisasi" class="form-control @error('ketua_organisasi') is-invalid @enderror" value="{{ old('ketua_organisasi') }}" required>
                            @error('ketua_organisasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenis Organisasi <span class="text-danger">*</span></label>
                            <select name="jenis_organisasi" class="form-control @error('jenis_organisasi') is-invalid @enderror" required>
                                <option value="">Pilih Jenis Organisasi</option>
                                <option value="UKM" {{ old('jenis_organisasi') == 'UKM' ? 'selected' : '' }}>UKM (Unit Kegiatan Mahasiswa)</option>
                                <option value="BEM" {{ old('jenis_organisasi') == 'BEM' ? 'selected' : '' }}>BEM (Badan Eksekutif Mahasiswa)</option>
                                <option value="Himpunan" {{ old('jenis_organisasi') == 'Himpunan' ? 'selected' : '' }}>Himpunan Mahasiswa</option>
                            </select>
                            @error('jenis_organisasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jumlah Anggota <span class="text-danger">*</span></label>
                            <input type="number" name="jumlah_anggota" class="form-control @error('jumlah_anggota') is-invalid @enderror" value="{{ old('jumlah_anggota') }}" required min="1">
                            @error('jumlah_anggota')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Logo/Foto Organisasi</label>
                            <div class="upload-area">
                                <input type="file" name="foto" id="foto" class="file-input" accept="image/*">
                                <label for="foto" class="upload-label">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span>Klik untuk upload foto</span>
                                    <small>JPG, PNG (Max 2MB)</small>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <div class="password-wrapper">
                                <input type="password" name="password" id="password" class="form-control" required minlength="6">
                                <button type="button" class="password-toggle">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <small class="text-muted">Minimal 6 karakter</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                            <div class="password-wrapper">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                                <button type="button" class="password-toggle">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="alert-info-box mt-3">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Informasi:</strong> Organisasi akan dapat login menggunakan email dan password yang didaftarkan.
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn-batal" id="btnBatalCreate">
                            <i class="fas fa-times me-2"></i>Batal
                        </button>
                        <button type="button" class="btn-simpan" id="btnSimpanCreate">
                            <i class="fas fa-save me-2"></i>Simpan Organisasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .card-modern {
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .card-header-modern {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 18px 24px;
        font-size: 18px;
        font-weight: 600;
    }
    .card-modern form {
        padding: 28px;
    }
    .form-label {
        font-weight: 600;
        font-size: 13px;
        color: #374151;
        margin-bottom: 8px;
        display: block;
    }
    .form-control {
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        padding: 10px 14px;
        font-size: 14px;
        width: 100%;
        transition: all 0.2s;
    }
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102,126,234,0.1);
        outline: none;
    }
    .password-wrapper {
        position: relative;
    }
    .password-toggle {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        color: #9ca3af;
    }
    .password-toggle:hover {
        color: #667eea;
    }
    .alert-info-box {
        background: #f0f9ff;
        border-radius: 12px;
        padding: 14px 16px;
        color: #0369a1;
        font-size: 13px;
    }
    .upload-area {
        position: relative;
    }
    .file-input {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }
    .upload-label {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 20px;
        border: 2px dashed #e5e7eb;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.2s;
        text-align: center;
        background: #fafbfc;
    }
    .upload-label:hover {
        border-color: #667eea;
        background: #f8fafc;
    }
    .upload-label i {
        font-size: 28px;
        color: #667eea;
        margin-bottom: 8px;
    }
    .upload-label span {
        font-size: 13px;
        font-weight: 500;
        color: #374151;
    }
    .upload-label small {
        font-size: 11px;
        color: #9ca3af;
        margin-top: 4px;
    }
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 28px;
        padding-top: 20px;
        border-top: 1px solid #f0f0f0;
    }
    .btn-simpan {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border: none;
        padding: 10px 28px;
        border-radius: 12px;
        color: white;
        font-weight: 600;
        transition: all 0.3s;
        cursor: pointer;
    }
    .btn-simpan:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102,126,234,0.4);
    }
    .btn-batal {
        background: #f3f4f6;
        border: none;
        padding: 10px 24px;
        border-radius: 12px;
        color: #6b7280;
        font-weight: 600;
        transition: all 0.2s;
        cursor: pointer;
    }
    .btn-batal:hover {
        background: #e5e7eb;
        color: #4b5563;
    }
</style>

<script>
    // Tombol Simpan dengan Pop-up Konfirmasi
    document.getElementById('btnSimpanCreate')?.addEventListener('click', function(e) {
        e.preventDefault();

        // Validasi form
        const form = document.getElementById('createForm');
        const namaOrganisasi = form.querySelector('[name="nama_organisasi"]').value;
        const email = form.querySelector('[name="email"]').value;
        const password = form.querySelector('[name="password"]').value;
        const passwordConf = form.querySelector('[name="password_confirmation"]').value;

        if (!namaOrganisasi) {
            showToast('Nama organisasi harus diisi', 'warning');
            return;
        }
        if (!email) {
            showToast('Email harus diisi', 'warning');
            return;
        }
        if (!password) {
            showToast('Password harus diisi', 'warning');
            return;
        }
        if (password !== passwordConf) {
            showToast('Password dan konfirmasi password tidak sama', 'error');
            return;
        }

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show mb-3" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>{{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        showConfirmModal({
            title: 'Konfirmasi Simpan',
            message: 'Apakah Anda yakin ingin menyimpan data organisasi ini?',
            type: 'success',
            confirmText: 'Ya, Simpan',
            onConfirm: function() {
                form.submit();
            }
        });
    });

    // Tombol Batal dengan Pop-up Konfirmasi
    document.getElementById('btnBatalCreate')?.addEventListener('click', function(e) {
        e.preventDefault();

        showConfirmModal({
            title: 'Konfirmasi Batal',
            message: 'Apakah Anda yakin ingin membatalkan? Data yang sudah diisi akan hilang.',
            type: 'warning',
            confirmText: 'Ya, Batal',
            onConfirm: function() {
                sessionStorage.setItem('flashMessage', 'Penambahan organisasi dibatalkan');
                sessionStorage.setItem('flashType', 'info');
                window.location.href = '{{ route("admin.organisasi.index") }}';
            }
        });
    });

    // File upload preview
    document.getElementById('foto')?.addEventListener('change', function() {
        const label = this.nextElementSibling;
        if (this.files && this.files[0]) {
            label.innerHTML = `
                <i class="fas fa-check-circle"></i>
                <span>${this.files[0].name}</span>
                <small>File siap diupload</small>
            `;
            label.style.borderColor = '#10b981';
            label.style.background = '#ecfdf5';
        }
    });
</script>


@endsection
