@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card-stats">
                <h4 class="mb-4">
                    <i class="fas fa-user-circle me-2"></i>
                    Profile Admin
                </h4>

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

                <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" id="profileForm">
                    @csrf
                    @method('PUT')

                    <div class="text-center mb-4">
                        @if(Auth::user()->foto && file_exists(public_path(Auth::user()->foto)))
                            <img src="{{ asset(Auth::user()->foto) }}"
                                 class="rounded-circle" width="120" height="120" style="object-fit: cover; border: 3px solid #667eea;">
                        @else
                            <div style="width: 120px; height: 120px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="fas fa-user-circle fa-5x" style="color: white;"></i>
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Foto Profile</label>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                        <small class="text-muted">Format: JPG, PNG. Maksimal 2MB</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $admin->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $admin->email) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password Baru (Kosongkan jika tidak diubah)</label>
                        <input type="password" name="password" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>

                    <div class="text-end">
                        <button type="button" class="btn btn-secondary me-2" id="btnBatalProfile">
                            <i class="fas fa-times me-2"></i>Batal
                        </button>
                        <button type="button" class="btn btn-custom" id="btnSimpanProfile">
                            <i class="fas fa-save me-2"></i>Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Tombol Batal dengan Pop-up Konfirmasi
    document.getElementById('btnBatalProfile')?.addEventListener('click', function(e) {
        e.preventDefault();

        showModalModern({
            title: 'Konfirmasi Batal',
            message: 'Apakah Anda yakin ingin membatalkan perubahan? Data yang belum disimpan akan hilang.',
            type: 'warning',
            confirmText: 'Ya, Batal',
            onConfirm: function() {
                sessionStorage.setItem('flashMessage', 'Perubahan profile dibatalkan');
                sessionStorage.setItem('flashType', 'info');
                window.location.href = '{{ route("admin.dashboard") }}';
            }
        });
    });

    // Tombol Simpan dengan Pop-up Konfirmasi
    document.getElementById('btnSimpanProfile')?.addEventListener('click', function(e) {
        e.preventDefault();

        // Validasi form
        const form = document.getElementById('profileForm');
        const name = form.querySelector('[name="name"]').value;
        const email = form.querySelector('[name="email"]').value;
        const password = form.querySelector('[name="password"]').value;
        const passwordConf = form.querySelector('[name="password_confirmation"]').value;

        if (!name) {
            showToast('Nama lengkap harus diisi', 'warning');
            return;
        }
        if (!email) {
            showToast('Email harus diisi', 'warning');
            return;
        }
        if (password !== passwordConf) {
            showToast('Password dan konfirmasi password tidak sama', 'error');
            return;
        }

        showModalModern({
            title: 'Konfirmasi Update',
            message: 'Apakah Anda yakin ingin mengupdate profile?',
            type: 'success',
            confirmText: 'Ya, Update',
            onConfirm: function() {
                form.submit();
            }
        });
    });
</script>

<style>
    .btn-secondary {
        background: #f3f4f6;
        border: none;
        padding: 10px 24px;
        border-radius: 12px;
        color: #6b7280;
        font-weight: 600;
        transition: all 0.2s;
        cursor: pointer;
    }
    .btn-secondary:hover {
        background: #e5e7eb;
        color: #4b5563;
    }
    .btn-custom {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border: none;
        padding: 10px 24px;
        border-radius: 12px;
        color: white;
        font-weight: 600;
        transition: all 0.3s;
        cursor: pointer;
    }
    .btn-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102,126,234,0.4);
    }
</style>
@endsection
