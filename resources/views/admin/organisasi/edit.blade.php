@php
    use Illuminate\Support\Facades\Storage;
@endphp
@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-modern">
                <div class="card-header-modern">
                    <i class="fas fa-edit me-2"></i> Edit Organisasi: {{ $organisasi->nama_organisasi }}
                </div>

                <form method="POST" action="{{ route('admin.organisasi.update', $organisasi) }}" enctype="multipart/form-data" id="updateForm">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Organisasi <span class="text-danger">*</span></label>
                            <input type="text" name="nama_organisasi" class="form-control @error('nama_organisasi') is-invalid @enderror" value="{{ old('nama_organisasi', $organisasi->nama_organisasi) }}" required>
                            @error('nama_organisasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Pendek <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $organisasi->name) }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $organisasi->email) }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" name="no_telp" class="form-control @error('no_telp') is-invalid @enderror" value="{{ old('no_telp', $organisasi->no_telp) }}">
                            @error('no_telp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ketua Organisasi <span class="text-danger">*</span></label>
                            <input type="text" name="ketua_organisasi" class="form-control @error('ketua_organisasi') is-invalid @enderror" value="{{ old('ketua_organisasi', $organisasi->ketua_organisasi) }}" required>
                            @error('ketua_organisasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenis Organisasi <span class="text-danger">*</span></label>
                            <select name="jenis_organisasi" class="form-control @error('jenis_organisasi') is-invalid @enderror" required>
                                <option value="">Pilih Jenis Organisasi</option>
                                <option value="UKM" {{ old('jenis_organisasi', $organisasi->jenis_organisasi) == 'UKM' ? 'selected' : '' }}>UKM (Unit Kegiatan Mahasiswa)</option>
                                <option value="BEM" {{ old('jenis_organisasi', $organisasi->jenis_organisasi) == 'BEM' ? 'selected' : '' }}>BEM (Badan Eksekutif Mahasiswa)</option>
                                <option value="Himpunan" {{ old('jenis_organisasi', $organisasi->jenis_organisasi) == 'Himpunan' ? 'selected' : '' }}>Himpunan Mahasiswa</option>
                            </select>
                            @error('jenis_organisasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jumlah Anggota <span class="text-danger">*</span></label>
                            <input type="number" name="jumlah_anggota" class="form-control @error('jumlah_anggota') is-invalid @enderror" value="{{ old('jumlah_anggota', $organisasi->jumlah_anggota) }}" required min="1">
                            @error('jumlah_anggota')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Logo/Foto Organisasi</label>
                            @if($organisasi->foto && Storage::disk('public')->exists($organisasi->foto))
                                <div class="mb-2">
                                    <img src="{{ Storage::url($organisasi->foto) }}" width="80" height="80" style="object-fit: cover; border-radius: 12px;">
                                    <br>
                                    <small class="text-muted">Foto saat ini</small>
                                </div>
                            @endif
                            <div class="upload-area">
                                <input type="file" name="foto" id="foto" class="file-input" accept="image/*">
                                <label for="foto" class="upload-label">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span>Klik untuk ganti foto</span>
                                    <small>JPG, PNG (Max 2MB)</small>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password" name="password" class="form-control" minlength="6">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                    </div>

                    <div class="alert-warning-box mt-3">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Perhatian:</strong> Jika password diubah, organisasi harus menggunakan password baru untuk login.
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn-batal" id="btnBatalEdit">
                            <i class="fas fa-times me-2"></i>Batal
                        </button>
                        <button type="button" onclick="confirmAction(event, 'updateForm', 'Organisasi {{ $organisasi->nama_organisasi }}', 'update')" class="btn-update">
                            <i class="fas fa-save me-2"></i>Update Organisasi
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
    .alert-warning-box {
        background: #fefce8;
        border-radius: 12px;
        padding: 14px 16px;
        color: #854d0e;
        font-size: 13px;
    }
    
    body.dark-mode .alert-warning-box {
    background: linear-gradient(135deg, #78350f, #92400e) !important;
    color: #fde68a !important;
    border-left: 4px solid #f59e0b !important;
    border-radius: 12px !important;
}

body.dark-mode .alert-warning-box i {
    color: #fbbf24 !important;
}

body.dark-mode .alert-warning-box strong {
    color: #fde68a !important;
}
    .current-photo {
        margin-bottom: 12px;
        text-align: center;
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
        padding: 16px;
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
        font-size: 24px;
        color: #667eea;
        margin-bottom: 6px;
    }
    .upload-label span {
        font-size: 12px;
        font-weight: 500;
        color: #374151;
    }
    .upload-label small {
        font-size: 10px;
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
    .btn-update {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border: none;
        padding: 10px 28px;
        border-radius: 12px;
        color: white;
        font-weight: 600;
        transition: all 0.3s;
        cursor: pointer;
    }
    .btn-update:hover {
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


    // Tombol Batal dengan pop-up
    document.getElementById('btnBatalEdit')?.addEventListener('click', function(e) {
        e.preventDefault();
        showConfirmModal({
            title: 'Batal Edit',
            message: 'Apakah Anda yakin ingin membatalkan perubahan? Data yang belum disimpan akan hilang.',
            type: 'warning',
            confirmText: 'Ya, Batal',
            onConfirm: function() {
                sessionStorage.setItem('flashMessage', 'Perubahan organisasi dibatalkan');
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

    // Cek flash message dari sessionStorage saat halaman dimuat
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


@endsection
