@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-modern">
                <div class="card-header-modern">
                    <i class="fas fa-edit me-2"></i> Edit Ruangan: {{ $ruangan->nama_ruangan }}
                </div>

                <form method="POST" action="{{ route('admin.ruangan.update', $ruangan) }}" enctype="multipart/form-data" id="updateForm">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Ruangan <span class="text-danger">*</span></label>
                            <input type="text" name="nama_ruangan" class="form-control @error('nama_ruangan') is-invalid @enderror" value="{{ old('nama_ruangan', $ruangan->nama_ruangan) }}" required>
                            @error('nama_ruangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kode Ruangan <span class="text-danger">*</span></label>
                            <input type="text" name="kode_ruangan" class="form-control @error('kode_ruangan') is-invalid @enderror" value="{{ old('kode_ruangan', $ruangan->kode_ruangan) }}" required>
                            @error('kode_ruangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Lokasi <span class="text-danger">*</span></label>
                            <input type="text" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror" value="{{ old('lokasi', $ruangan->lokasi) }}" required>
                            @error('lokasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kapasitas (orang) <span class="text-danger">*</span></label>
                            <input type="number" name="kapasitas" class="form-control @error('kapasitas') is-invalid @enderror" value="{{ old('kapasitas', $ruangan->kapasitas) }}" required min="1">
                            @error('kapasitas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Fasilitas</label>
                        <textarea name="fasilitas" class="form-control @error('fasilitas') is-invalid @enderror" rows="3" placeholder="AC, Proyektor, Whiteboard, Sound System">{{ old('fasilitas', $ruangan->fasilitas) }}</textarea>
                        @error('fasilitas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="text-muted">Pisahkan dengan koma (,) jika lebih dari satu</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                            <option value="tersedia" {{ $ruangan->status == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="dipinjam" {{ $ruangan->status == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                            <option value="perbaikan" {{ $ruangan->status == 'perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <!-- Foto Saat Ini -->
                    @if($ruangan->foto && file_exists(public_path($ruangan->foto)))
                    <div class="mb-3 text-center">
                        <label class="form-label">Foto Saat Ini</label>
                        <div>
                            <img src="{{ asset($ruangan->foto) }}" class="current-photo" width="120" height="120" style="object-fit: cover; border-radius: 12px; border: 2px solid #e5e7eb;">
                        </div>
                    </div>
                    @endif

                    <!-- Upload Foto Modern -->
                    <div class="mb-4">
                        <label class="form-label">Ganti Foto Ruangan</label>
                        <div class="upload-area">
                            <input type="file" name="foto" id="fotoRuangan" class="file-input" accept="image/*">
                            <label for="fotoRuangan" class="upload-label">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span>Klik untuk ganti foto ruangan</span>
                                <small>JPG, PNG (Max 8MB) - Kosongkan jika tidak ingin mengganti</small>
                            </label>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn-batal" id="btnBatalEdit">
                            <i class="fas fa-times me-2"></i>Batal
                        </button>
                        <button type="button" class="btn-simpan" id="btnSimpanEdit">
                            <i class="fas fa-save me-2"></i>Update Ruangan
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
    textarea.form-control {
        resize: vertical;
        min-height: 80px;
    }

    /* Current Photo */
    .current-photo {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    /* Upload Area Modern */
    .upload-area {
        position: relative;
        margin-top: 5px;
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
        padding: 30px;
        border: 2px dashed #e5e7eb;
        border-radius: 16px;
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
        font-size: 40px;
        color: #667eea;
        margin-bottom: 12px;
    }
    .upload-label span {
        font-size: 14px;
        font-weight: 500;
        color: #374151;
    }
    .upload-label small {
        font-size: 12px;
        color: #9ca3af;
        margin-top: 6px;
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
    document.getElementById('btnSimpanEdit')?.addEventListener('click', function(e) {
        e.preventDefault();

        const form = document.getElementById('updateForm');
        const namaRuangan = form.querySelector('[name="nama_ruangan"]').value;

        if (!namaRuangan) {
            showToast('Nama ruangan harus diisi', 'warning');
            return;
        }

        showConfirmModal({
            title: 'Konfirmasi Update',
            message: 'Apakah Anda yakin ingin mengupdate data ruangan ini?',
            type: 'success',
            confirmText: 'Ya, Update',
            onConfirm: function() {
                form.submit();
            }
        });
    });

    // Tombol Batal
    document.getElementById('btnBatalEdit')?.addEventListener('click', function(e) {
        e.preventDefault();

        showConfirmModal({
            title: 'Konfirmasi Batal',
            message: 'Apakah Anda yakin ingin membatalkan perubahan? Data yang belum disimpan akan hilang.',
            type: 'warning',
            confirmText: 'Ya, Batal',
            onConfirm: function() {
                sessionStorage.setItem('flashMessage', 'Perubahan ruangan dibatalkan');
                sessionStorage.setItem('flashType', 'info');
                window.location.href = '{{ route("admin.ruangan.index") }}';
            }
        });
    });

    // File upload preview
    document.getElementById('fotoRuangan')?.addEventListener('change', function() {
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
