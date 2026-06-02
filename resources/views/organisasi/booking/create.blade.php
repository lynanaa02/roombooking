{{-- @extends('layouts.organisasi')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <!-- Header -->
            <div class="header-booking mb-4">
                <h2 class="booking-title">
                    <i class="fas fa-calendar-plus me-2"></i>
                    Formulir Peminjaman Ruangan
                </h2>
                <p class="booking-subtitle">Silakan isi data peminjaman ruangan dengan lengkap dan benar</p>
            </div>

            <!-- Notifikasi -->
            <div id="notificationArea" style="display: none;"></div>

            <!-- Form Card -->
            <div class="booking-card">
                <form action="{{ route('organisasi.booking.store') }}" method="POST" enctype="multipart/form-data" id="bookingForm">
                    @csrf

                    <!-- Bagian 1: Pilih Ruangan -->
                    <div class="form-section">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-door-open"></i>
                            </div>
                            <div class="section-title">
                                <h5>Informasi Ruangan</h5>
                                <p>Pilih ruangan yang akan digunakan</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Pilih Ruangan <span class="text-danger">*</span></label>
                            <select name="ruangan_id" class="form-select" id="ruanganSelect" required>
                                <option value="">-- Pilih Ruangan --</option>
                                @foreach($ruangans as $ruangan)
                                    <option value="{{ $ruangan->id }}"
                                            data-kapasitas="{{ $ruangan->kapasitas }}"
                                            data-lokasi="{{ $ruangan->lokasi }}"
                                        {{ $selectedRuangan && $selectedRuangan->id == $ruangan->id ? 'selected' : '' }}>
                                        {{ $ruangan->nama_ruangan }} - {{ $ruangan->lokasi }} ({{ $ruangan->kapasitas }} orang)
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Pilih ruangan yang sesuai dengan kebutuhan kegiatan Anda</small>
                        </div>

                        <div id="ruanganInfo" class="ruangan-info-box" style="display: none;">
                            <div class="info-row">
                                <span class="info-label"><i class="fas fa-map-marker-alt"></i> Lokasi:</span>
                                <span class="info-value" id="ruanganLokasi">-</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label"><i class="fas fa-users"></i> Kapasitas:</span>
                                <span class="info-value" id="ruanganKapasitas">-</span>
                            </div>
                        </div>

                        <!-- Availability Message -->
                        <div id="availabilityMessage" style="display: none;"></div>
                    </div>

                    <!-- Bagian 2: Detail Kegiatan -->
                    <div class="form-section">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <div class="section-title">
                                <h5>Detail Kegiatan</h5>
                                <p>Informasi tentang kegiatan yang akan dilaksanakan</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Kategori Kegiatan <span class="text-danger">*</span></label>
                            <select name="kategori_kegiatan" class="form-select" id="kategoriKegiatan" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="Rapat Organisasi">📋 Rapat Organisasi</option>
                                <option value="Pelatihan">🎓 Pelatihan / Diklat</option>
                                <option value="Seminar">🎤 Seminar / Konferensi</option>
                                <option value="Workshop">🛠 Workshop / Lokakarya</option>
                                <option value="Kegiatan Seni">🎨 Kegiatan Seni & Budaya</option>
                                <option value="Olahraga">⚽ Olahraga & Pertandingan</option>
                                <option value="Pengabdian Masyarakat">🤝 Pengabdian Masyarakat</option>
                                <option value="Lainnya">📌 Lainnya</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Keterangan Tambahan</label>
                            <textarea name="keterangan_tambahan" class="form-control" rows="3" id="keteranganTambahan"
                                      placeholder="Contoh: Rapat membahas program kerja, dihadiri 50 peserta, dll"></textarea>
                            <small class="form-text text-muted">Berikan informasi tambahan tentang kegiatan (opsional)</small>
                        </div>
                    </div>

                    <!-- Bagian 3: Waktu Peminjaman -->
                    <div class="form-section">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="section-title">
                                <h5>Waktu Peminjaman</h5>
                                <p>Tentukan jadwal penggunaan ruangan</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Tanggal Pengajuan <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_pengajuan" class="form-control" value="{{ date('Y-m-d') }}" id="tanggalPengajuan" required readonly style="background:#f3f4f6;">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Tanggal Peminjaman <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_pinjam" class="form-control" id="tanggalPinjam" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Waktu Mulai <span class="text-danger">*</span></label>
                                    <input type="time" name="waktu_mulai" class="form-control" id="waktuMulai" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Waktu Selesai <span class="text-danger">*</span></label>
                                    <input type="time" name="waktu_selesai" class="form-control" id="waktuSelesai" required>
                                </div>
                            </div>
                        </div>

                        <div id="durasiInfo" class="durasi-box" style="display: none;">
                            <i class="fas fa-hourglass-half"></i>
                            Durasi peminjaman: <strong id="durasiText">-</strong>
                        </div>
                    </div>

                    <!-- Bagian 4: Dokumen Pendukung -->
                    <div class="form-section">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-paperclip"></i>
                            </div>
                            <div class="section-title">
                                <h5>Dokumen Pendukung</h5>
                                <p>Upload dokumen yang diperlukan (opsional)</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Bukti Surat Izin</label>
                                    <div class="upload-wrapper">
                                        <input type="file" name="bukti_surat_izin" id="suratIzin" class="file-input" accept=".pdf,.jpg,.jpeg,.png">
                                        <label for="suratIzin" class="upload-label">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                            <span>Klik untuk upload</span>
                                            <small>PDF, JPG, PNG (Max 2MB)</small>
                                        </label>
                                    </div>
                                    <small class="form-text text-muted">Surat izin dari pembina organisasi</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Proposal Kegiatan</label>
                                    <div class="upload-wrapper">
                                        <input type="file" name="proposal_kegiatan" id="proposal" class="file-input" accept=".pdf,.jpg,.jpeg,.png">
                                        <label for="proposal" class="upload-label">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                            <span>Klik untuk upload</span>
                                            <small>PDF, JPG, PNG (Max 2MB)</small>
                                        </label>
                                    </div>
                                    <small class="form-text text-muted">Proposal kegiatan (jika ada)</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bagian 5: Informasi Pemohon -->
                    <div class="form-section">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-user-circle"></i>
                            </div>
                            <div class="section-title">
                                <h5>Informasi Pemohon</h5>
                                <p>Data organisasi peminjam</p>
                            </div>
                        </div>

                        <div class="pemohon-info">
                            <div class="info-grid">
                                <div class="info-item">
                                    <span class="info-icon"><i class="fas fa-building"></i></span>
                                    <div class="info-detail">
                                        <small>Nama Organisasi</small>
                                        <p>{{ Auth::user()->nama_organisasi ?? Auth::user()->name }}</p>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <span class="info-icon"><i class="fas fa-user-tie"></i></span>
                                    <div class="info-detail">
                                        <small>Ketua Organisasi</small>
                                        <p>{{ Auth::user()->ketua_organisasi ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <span class="info-icon"><i class="fas fa-phone"></i></span>
                                    <div class="info-detail">
                                        <small>No. Telepon</small>
                                        <p>{{ Auth::user()->no_telp ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <span class="info-icon"><i class="fas fa-envelope"></i></span>
                                    <div class="info-detail">
                                        <small>Email</small>
                                        <p>{{ Auth::user()->email }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="form-actions">
                        <button type="button" class="btn btn-cancel" id="btnKembali">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </button>
                        <button type="button" class="btn btn-reset-form" id="btnReset">
                            <i class="fas fa-eraser me-2"></i>Reset
                        </button>
                        <button type="submit" class="btn btn-submit" id="submitBtn" disabled>
                            <i class="fas fa-paper-plane me-2"></i>Ajukan Peminjaman
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .header-booking {
        text-align: center;
        margin-bottom: 30px;
    }

    .booking-title {
        font-size: 28px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 8px;
    }

    .booking-subtitle {
        font-size: 14px;
        color: #6b7280;
        margin: 0;
    }

    .booking-card {
        background: white;
        border-radius: 24px;
        box-shadow: 0 10px 35px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .booking-card form {
        padding: 32px;
    }

    .form-section {
        margin-bottom: 32px;
        padding-bottom: 24px;
        border-bottom: 1px solid #f0f0f0;
    }

    .form-section:last-of-type {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 24px;
    }

    .section-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .section-icon i {
        font-size: 24px;
        color: white;
    }

    .section-title h5 {
        font-size: 16px;
        font-weight: 700;
        color: #1f2937;
        margin: 0 0 4px;
    }

    .section-title p {
        font-size: 12px;
        color: #9ca3af;
        margin: 0;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    .form-label {
        font-size: 13px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
        display: block;
    }

    .form-control, .form-select {
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        padding: 12px 16px;
        font-size: 14px;
        transition: all 0.2s;
    }

    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102,126,234,0.1);
    }

    .form-text {
        font-size: 11px;
        color: #9ca3af;
        margin-top: 6px;
    }

    .ruangan-info-box {
        background: #f8fafc;
        border-radius: 16px;
        padding: 16px;
        margin-top: 16px;
        animation: fadeIn 0.3s ease;
    }

    .info-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 6px 0;
    }

    .info-label {
        width: 100px;
        font-size: 13px;
        color: #6b7280;
    }

    .info-label i {
        width: 20px;
        color: #667eea;
    }

    .info-value {
        font-size: 13px;
        font-weight: 600;
        color: #1f2937;
    }

    .durasi-box {
        background: linear-gradient(135deg, #dbeafe, #e0e7ff);
        border-radius: 12px;
        padding: 12px 16px;
        margin-top: 16px;
        font-size: 13px;
        color: #4338ca;
        animation: fadeIn 0.3s ease;
    }

    .durasi-box i {
        margin-right: 8px;
    }

    .upload-wrapper {
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
        padding: 24px;
        border: 2px dashed #e5e7eb;
        border-radius: 16px;
        cursor: pointer;
        transition: all 0.2s;
        text-align: center;
    }

    .upload-label:hover {
        border-color: #667eea;
        background: #f8fafc;
    }

    .upload-label i {
        font-size: 32px;
        color: #667eea;
        margin-bottom: 10px;
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

    .pemohon-info {
        background: #f8fafc;
        border-radius: 16px;
        padding: 16px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .info-icon {
        width: 40px;
        height: 40px;
        background: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .info-icon i {
        font-size: 20px;
        color: #667eea;
    }

    .info-detail small {
        font-size: 11px;
        color: #9ca3af;
        display: block;
    }

    .info-detail p {
        font-size: 14px;
        font-weight: 600;
        color: #1f2937;
        margin: 4px 0 0;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1px solid #f0f0f0;
    }

    .btn-cancel {
        background: #f3f4f6;
        border: none;
        padding: 12px 24px;
        border-radius: 12px;
        color: #4b5563;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
        cursor: pointer;
    }

    .btn-cancel:hover {
        background: #e5e7eb;
        color: #374151;
    }

    .btn-reset-form {
        background: #fef3c7;
        border: none;
        padding: 12px 24px;
        border-radius: 12px;
        color: #d97706;
        font-weight: 600;
        transition: all 0.2s;
        cursor: pointer;
    }

    .btn-reset-form:hover {
        background: #fde68a;
    }

    .btn-submit {
        background: linear-gradient(135deg, #10b981, #059669);
        border: none;
        padding: 12px 28px;
        border-radius: 12px;
        color: white;
        font-weight: 600;
        transition: all 0.2s;
        cursor: pointer;
    }

    .btn-submit:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(16,185,129,0.4);
    }

    .btn-submit:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .availability-available {
        background: #d1fae5;
        color: #059669;
        padding: 12px 16px;
        border-radius: 12px;
        margin-top: 16px;
        font-size: 14px;
    }

    .availability-unavailable {
        background: #fee2e2;
        color: #dc2626;
        padding: 12px 16px;
        border-radius: 12px;
        margin-top: 16px;
        font-size: 14px;
    }

    .availability-checking {
        background: #fef3c7;
        color: #d97706;
        padding: 12px 16px;
        border-radius: 12px;
        margin-top: 16px;
        font-size: 14px;
    }

    .custom-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 350px;
        padding: 16px 20px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
        animation: slideInRight 0.3s ease-out;
    }

    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .booking-card form {
            padding: 20px;
        }

        .info-grid {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .form-actions {
            flex-wrap: wrap;
        }

        .form-actions .btn {
            flex: 1;
            text-align: center;
        }

        .booking-title {
            font-size: 22px;
        }

        .custom-notification {
            min-width: 280px;
            top: 10px;
            right: 10px;
        }
    }
</style>

<script>
    // ========================================
    // NOTIFICATION FUNCTIONS
    // ========================================
    function showNotification(message, type) {
        const colors = {
            success: '#10b981',
            error: '#ef4444',
            warning: '#f59e0b',
            info: '#3b82f6'
        };

        const icons = {
            success: 'fa-check-circle',
            error: 'fa-times-circle',
            warning: 'fa-exclamation-triangle',
            info: 'fa-info-circle'
        };

        const notification = document.createElement('div');
        notification.className = 'custom-notification';
        notification.style.background = colors[type];
        notification.style.color = 'white';

        notification.innerHTML = `
            <div style="background: rgba(255,255,255,0.2); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fas ${icons[type]}" style="font-size: 20px;"></i>
            </div>
            <div style="flex: 1; font-size: 14px; font-weight: 500;">${message}</div>
            <button onclick="this.closest('.custom-notification').remove()" style="background: rgba(255,255,255,0.15); border: none; border-radius: 10px; padding: 5px 10px; color: white; cursor: pointer;">
                <i class="fas fa-times me-1"></i> Tutup
            </button>
        `;

        document.body.appendChild(notification);

        setTimeout(() => {
            if (notification.parentNode) notification.remove();
        }, 3000);
    }

    // ========================================
    // ELEMENTS
    // ========================================
    const ruanganSelect = document.getElementById('ruanganSelect');
    const tanggalPinjam = document.getElementById('tanggalPinjam');
    const waktuMulaiInput = document.getElementById('waktuMulai');
    const waktuSelesaiInput = document.getElementById('waktuSelesai');
    const availabilityMessage = document.getElementById('availabilityMessage');
    const submitBtn = document.getElementById('submitBtn');
    const btnReset = document.getElementById('btnReset');
    const btnKembali = document.getElementById('btnKembali');
    const form = document.getElementById('bookingForm');

    // Set min date untuk tanggal pinjam (hari ini)
    const today = new Date().toISOString().split('T')[0];
    if (tanggalPinjam) tanggalPinjam.min = today;

    // ========================================
    // RUANGAN INFO
    // ========================================
    const ruanganInfo = document.getElementById('ruanganInfo');
    const ruanganLokasi = document.getElementById('ruanganLokasi');
    const ruanganKapasitas = document.getElementById('ruanganKapasitas');

    if (ruanganSelect) {
        ruanganSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const kapasitas = selectedOption.getAttribute('data-kapasitas');
            const lokasi = selectedOption.getAttribute('data-lokasi');

            if (this.value) {
                ruanganLokasi.textContent = lokasi || '-';
                ruanganKapasitas.textContent = kapasitas ? kapasitas + ' orang' : '-';
                ruanganInfo.style.display = 'block';
            } else {
                ruanganInfo.style.display = 'none';
            }
            cekKetersediaan();
        });

        if (ruanganSelect.value) {
            ruanganSelect.dispatchEvent(new Event('change'));
        }
    }

    // ========================================
    // DURASI
    // ========================================
    const durasiInfo = document.getElementById('durasiInfo');
    const durasiText = document.getElementById('durasiText');

    function calculateDuration() {
        if (waktuMulaiInput && waktuSelesaiInput && waktuMulaiInput.value && waktuSelesaiInput.value) {
            const start = waktuMulaiInput.value;
            const end = waktuSelesaiInput.value;

            if (end > start) {
                const startHour = parseInt(start.split(':')[0]);
                const startMin = parseInt(start.split(':')[1]);
                const endHour = parseInt(end.split(':')[0]);
                const endMin = parseInt(end.split(':')[1]);

                let hours = endHour - startHour;
                let minutes = endMin - startMin;

                if (minutes < 0) {
                    hours--;
                    minutes += 60;
                }

                durasiText.textContent = hours + ' jam ' + minutes + ' menit';
                durasiInfo.style.display = 'block';
            } else {
                durasiInfo.style.display = 'none';
            }
        } else {
            durasiInfo.style.display = 'none';
        }
    }

    if (waktuMulaiInput && waktuSelesaiInput) {
        waktuMulaiInput.addEventListener('change', calculateDuration);
        waktuSelesaiInput.addEventListener('change', calculateDuration);
    }

    // ========================================
    // CEK KETERSEDIAAN (AJAX)
    // ========================================
    function cekKetersediaan() {
        const ruanganId = ruanganSelect ? ruanganSelect.value : null;
        const tanggal = tanggalPinjam ? tanggalPinjam.value : null;
        const mulai = waktuMulaiInput ? waktuMulaiInput.value : null;
        const selesai = waktuSelesaiInput ? waktuSelesaiInput.value : null;

        if (!ruanganId || !tanggal || !mulai || !selesai) {
            if (availabilityMessage) {
                availabilityMessage.style.display = 'none';
            }
            if (submitBtn) submitBtn.disabled = false;
            return;
        }

        // Tampilkan loading
        if (availabilityMessage) {
            availabilityMessage.style.display = 'block';
            availabilityMessage.innerHTML = '<div class="loading-spinner"><i class="fas fa-spinner fa-spin"></i> Mengecek ketersediaan...</div>';
            availabilityMessage.className = 'availability-checking';
        }

        fetch('{{ route("organisasi.booking.check") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                ruangan_id: ruanganId,
                tanggal_pinjam: tanggal,
                waktu_mulai: mulai,
                waktu_selesai: selesai
            })
        })
        .then(response => response.json())
        .then(data => {
            if (availabilityMessage) {
                if (data.tersedia) {
                    availabilityMessage.innerHTML = '<i class="fas fa-check-circle"></i> Ruangan tersedia untuk jadwal ini!';
                    availabilityMessage.className = 'availability-available';
                    if (submitBtn) submitBtn.disabled = false;
                } else {
                    let message = '<i class="fas fa-times-circle"></i> Ruangan tidak tersedia untuk jadwal ini.';
                    if (data.bentrok) {
                        message += `<br><small>Sudah dipesan oleh: ${data.bentrok.organisasi}<br>
                                    Jadwal: ${data.bentrok.waktu_mulai} - ${data.bentrok.waktu_selesai}<br>
                                    Kegiatan: ${data.bentrok.kegiatan}</small>`;
                    }
                    availabilityMessage.innerHTML = message;
                    availabilityMessage.className = 'availability-unavailable';
                    if (submitBtn) submitBtn.disabled = true;
                }
                availabilityMessage.style.display = 'block';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (availabilityMessage) {
                availabilityMessage.style.display = 'none';
            }
            if (submitBtn) submitBtn.disabled = false;
        });
    }

    // Event listeners untuk cek ketersediaan
    if (ruanganSelect) ruanganSelect.addEventListener('change', cekKetersediaan);
    if (tanggalPinjam) tanggalPinjam.addEventListener('change', cekKetersediaan);
    if (waktuMulaiInput) waktuMulaiInput.addEventListener('change', cekKetersediaan);
    if (waktuSelesaiInput) waktuSelesaiInput.addEventListener('change', cekKetersediaan);

    // ========================================
    // TOMBOL RESET
    // ========================================
    if (btnReset) {
        btnReset.addEventListener('click', function() {
            if (form) {
                form.reset();
                // Reset juga select
                if (ruanganSelect) ruanganSelect.value = '';
                if (tanggalPinjam) tanggalPinjam.value = '';
                if (waktuMulaiInput) waktuMulaiInput.value = '';
                if (waktuSelesaiInput) waktuSelesaiInput.value = '';
                if (ruanganInfo) ruanganInfo.style.display = 'none';
                if (durasiInfo) durasiInfo.style.display = 'none';
                if (availabilityMessage) availabilityMessage.style.display = 'none';
                if (submitBtn) submitBtn.disabled = true;

                showNotification('Formulir telah direset', 'info');
            }
        });
    }

    // ========================================
    // TOMBOL KEMBALI
    // ========================================
    if (btnKembali) {
        btnKembali.addEventListener('click', function() {
            showNotification('Kembali ke dashboard', 'info');
            setTimeout(() => {
                window.location.href = '{{ route("organisasi.dashboard") }}';
            }, 500);
        });
    }

    // ========================================
    // SUBMIT FORM DENGAN NOTIFIKASI
    // ========================================
    if (form) {
        form.addEventListener('submit', function(e) {
            if (submitBtn.disabled) {
                e.preventDefault();
                showNotification('Silakan lengkapi data dan pastikan ruangan tersedia', 'warning');
                return false;
            }

            showNotification('Mengirim pengajuan peminjaman...', 'info');
        });
    }

    // ========================================
    // VALIDASI FORM SEBELUM SUBMIT
    // ========================================
    function validateForm() {
        if (!ruanganSelect.value) {
            showNotification('Silakan pilih ruangan terlebih dahulu', 'warning');
            ruanganSelect.focus();
            return false;
        }

        if (!tanggalPinjam.value) {
            showNotification('Silakan pilih tanggal peminjaman', 'warning');
            tanggalPinjam.focus();
            return false;
        }

        if (!waktuMulaiInput.value) {
            showNotification('Silakan pilih waktu mulai', 'warning');
            waktuMulaiInput.focus();
            return false;
        }

        if (!waktuSelesaiInput.value) {
            showNotification('Silakan pilih waktu selesai', 'warning');
            waktuSelesaiInput.focus();
            return false;
        }

        if (waktuMulaiInput.value >= waktuSelesaiInput.value) {
            showNotification('Waktu selesai harus setelah waktu mulai', 'error');
            waktuSelesaiInput.focus();
            return false;
        }

        return true;
    }

    // Tambahkan validasi sebelum submit
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
            }
        });
    }

    // ========================================
    // FILE UPLOAD SHOW FILENAME
    // ========================================
    document.querySelectorAll('.file-input').forEach(input => {
        input.addEventListener('change', function() {
            const label = this.nextElementSibling;
            if (this.files && this.files[0]) {
                label.innerHTML = `
                    <i class="fas fa-check-circle"></i>
                    <span>${this.files[0].name}</span>
                    <small>File siap diupload</small>
                `;
                label.style.borderColor = '#10b981';
                label.style.background = '#ecfdf5';
                showNotification(`File "${this.files[0].name}" siap diupload`, 'success');
            } else {
                label.innerHTML = `
                    <i class="fas fa-cloud-upload-alt"></i>
                    <span>Klik untuk upload</span>
                    <small>PDF, JPG, PNG (Max 2MB)</small>
                `;
                label.style.borderColor = '#e5e7eb';
                label.style.background = 'transparent';
            }
        });
    });
</script>

<!-- Modal Konfirmasi -->
<div id="confirmModal" class="modal-overlay" style="display: none;">
    <div class="modal-container">
        <div class="modal-header" id="modalHeader">
            <div class="modal-icon" id="modalIcon">
                <i class="fas fa-question-circle"></i>
            </div>
            <h3 id="modalTitle">Konfirmasi</h3>
        </div>
        <div class="modal-body">
            <p id="modalMessage">Apakah Anda yakin?</p>
        </div>
        <div class="modal-footer">
            <button class="modal-btn modal-btn-cancel" id="modalCancelBtn">
                <i class="fas fa-times me-2"></i>Batal
            </button>
            <button class="modal-btn modal-btn-confirm" id="modalConfirmBtn">
                <i class="fas fa-check me-2"></i>Ya, Lanjutkan
            </button>
        </div>
    </div>
</div>

<style>
    /* Modal Styles */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(4px);
        z-index: 10000;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: fadeIn 0.2s ease;
    }

    .modal-container {
        background: white;
        border-radius: 24px;
        width: 90%;
        max-width: 420px;
        overflow: hidden;
        animation: slideInUp 0.3s ease;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
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
        cursor: pointer;
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

    /* Untuk modal success (ajukan peminjaman) */
    .modal-icon-success {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    }

    .modal-icon-success i {
        color: #10b981;
    }

    .modal-btn-success {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }

    /* Untuk modal warning (reset) */
    .modal-icon-warning {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    }

    .modal-icon-warning i {
        color: #d97706;
    }

    .modal-btn-warning {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
</style>

<script>
   // ========================================
// MODAL POP-UP FUNCTIONS (DIPERBAIKI)
// ========================================
const modal = document.getElementById('confirmModal');
let currentCallback = null;
let isModalOpen = false;

function showModal(options) {
    // Cegah multiple modal
    if (isModalOpen) return;

    // Set title dan message
    document.getElementById('modalTitle').textContent = options.title || 'Konfirmasi';
    document.getElementById('modalMessage').textContent = options.message || 'Apakah Anda yakin?';

    const modalIconDiv = document.getElementById('modalIcon');
    const modalConfirmBtnElem = document.getElementById('modalConfirmBtn');

    // Set style berdasarkan tipe
    if (options.type === 'success') {
        modalIconDiv.className = 'modal-icon modal-icon-success';
        modalIconDiv.innerHTML = '<i class="fas fa-paper-plane"></i>';
        modalConfirmBtnElem.className = 'modal-btn modal-btn-confirm modal-btn-success';
        modalConfirmBtnElem.innerHTML = '<i class="fas fa-paper-plane me-2"></i>' + (options.confirmText || 'Ya, Ajukan');
    } else if (options.type === 'warning') {
        modalIconDiv.className = 'modal-icon modal-icon-warning';
        modalIconDiv.innerHTML = '<i class="fas fa-eraser"></i>';
        modalConfirmBtnElem.className = 'modal-btn modal-btn-confirm modal-btn-warning';
        modalConfirmBtnElem.innerHTML = '<i class="fas fa-eraser me-2"></i>' + (options.confirmText || 'Ya, Reset');
    } else if (options.type === 'danger') {
        modalIconDiv.className = 'modal-icon';
        modalIconDiv.innerHTML = '<i class="fas fa-sign-out-alt"></i>';
        modalConfirmBtnElem.className = 'modal-btn modal-btn-confirm';
        modalConfirmBtnElem.innerHTML = '<i class="fas fa-sign-out-alt me-2"></i>' + (options.confirmText || 'Ya, Kembali');
    } else {
        modalIconDiv.className = 'modal-icon';
        modalIconDiv.innerHTML = '<i class="fas fa-question-circle"></i>';
        modalConfirmBtnElem.className = 'modal-btn modal-btn-confirm';
        modalConfirmBtnElem.innerHTML = '<i class="fas fa-check me-2"></i>' + (options.confirmText || 'Ya, Lanjutkan');
    }

    // Set callback
    currentCallback = options.onConfirm;

    // Simpan onCancel
    const onCancel = options.onCancel || function() {
        closeModal();
    };

    // Hapus event listener lama dengan clone node
    const oldConfirmBtn = modalConfirmBtnElem;
    const oldCancelBtn = document.getElementById('modalCancelBtn');

    const newConfirmBtn = oldConfirmBtn.cloneNode(true);
    const newCancelBtn = oldCancelBtn.cloneNode(true);

    oldConfirmBtn.parentNode.replaceChild(newConfirmBtn, oldConfirmBtn);
    oldCancelBtn.parentNode.replaceChild(newCancelBtn, oldCancelBtn);

    // Event untuk tombol konfirmasi
    newConfirmBtn.onclick = function(e) {
        e.preventDefault();
        e.stopPropagation();
        if (currentCallback) {
            currentCallback();
        }
        closeModal();
        currentCallback = null;
    };

    // Event untuk tombol batal
    newCancelBtn.onclick = function(e) {
        e.preventDefault();
        e.stopPropagation();
        if (onCancel) onCancel();
        closeModal();
        currentCallback = null;
    };

    // Tampilkan modal
    modal.style.display = 'flex';
    isModalOpen = true;

    // Klik di luar modal
    modal.onclick = function(e) {
        if (e.target === modal) {
            if (onCancel) onCancel();
            closeModal();
            currentCallback = null;
        }
    };
}

function closeModal() {
    modal.style.display = 'none';
    isModalOpen = false;
}

// ========================================
// TOMBOL AJUKAN PEMINJAMAN
// ========================================
const submitFormBtn = document.getElementById('submitBtn');
const bookingForm = document.getElementById('bookingForm');

if (submitFormBtn && bookingForm) {
    // Hapus event listener lama dengan clone
    const newSubmitBtn = submitFormBtn.cloneNode(true);
    submitFormBtn.parentNode.replaceChild(newSubmitBtn, submitFormBtn);

    newSubmitBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        // Validasi form
        if (!validateForm()) {
            return;
        }

        if (newSubmitBtn.disabled) {
            showNotification('Silakan lengkapi data dan pastikan ruangan tersedia', 'warning');
            return;
        }

        showModal({
            title: 'Ajukan Peminjaman',
            message: 'Apakah Anda yakin ingin mengajukan peminjaman ruangan ini? Data yang diajukan akan diproses oleh admin.',
            type: 'success',
            confirmText: 'Ya, Ajukan',
            onConfirm: function() {
                showNotification('Mengirim pengajuan peminjaman...', 'info');
                bookingForm.submit();
            }
        });
    });
}

// ========================================
// TOMBOL RESET
// ========================================
const resetBtn = document.getElementById('btnReset');

if (resetBtn) {
    // Hapus event listener lama dengan clone
    const newResetBtn = resetBtn.cloneNode(true);
    resetBtn.parentNode.replaceChild(newResetBtn, resetBtn);

    newResetBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        showModal({
            title: 'Reset Formulir',
            message: 'Apakah Anda yakin ingin mereset semua data yang sudah diisi? Semua perubahan akan hilang.',
            type: 'warning',
            confirmText: 'Ya, Reset',
            onConfirm: function() {
                if (bookingForm) {
                    bookingForm.reset();
                    if (ruanganSelect) ruanganSelect.value = '';
                    if (tanggalPinjam) tanggalPinjam.value = '';
                    if (waktuMulaiInput) waktuMulaiInput.value = '';
                    if (waktuSelesaiInput) waktuSelesaiInput.value = '';
                    if (ruanganInfo) ruanganInfo.style.display = 'none';
                    if (durasiInfo) durasiInfo.style.display = 'none';
                    if (availabilityMessage) availabilityMessage.style.display = 'none';
                    if (submitBtn) submitBtn.disabled = true;
                    showNotification('Formulir telah direset', 'success');
                }
            }
        });
    });
}

// ========================================
// TOMBOL KEMBALI (DIPERBAIKI)
// ========================================
const kembaliBtn = document.getElementById('btnKembali');

if (kembaliBtn) {
    // Hapus event listener lama dengan clone
    const newKembaliBtn = kembaliBtn.cloneNode(true);
    kembaliBtn.parentNode.replaceChild(newKembaliBtn, kembaliBtn);

    newKembaliBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        console.log('Tombol kembali diklik - menampilkan modal');

        showModal({
            title: 'Kembali ke Dashboard',
            message: 'Apakah Anda yakin ingin kembali ke dashboard? Data yang belum disimpan akan hilang.',
            type: 'danger',
            confirmText: 'Ya, Kembali',
            onConfirm: function() {
                console.log('Konfirmasi kembali - redirect ke dashboard');
                showNotification('Kembali ke dashboard', 'info');
                window.location.href = '{{ route("organisasi.dashboard") }}';
            },
            onCancel: function() {
                console.log('Batal kembali - modal ditutup');
            }
        });
    });
}

// ========================================
// VALIDASI FORM
// ========================================
function validateForm() {
    if (!ruanganSelect || !ruanganSelect.value) {
        showNotification('Silakan pilih ruangan terlebih dahulu', 'warning');
        if (ruanganSelect) ruanganSelect.focus();
        return false;
    }

    if (!tanggalPinjam || !tanggalPinjam.value) {
        showNotification('Silakan pilih tanggal peminjaman', 'warning');
        if (tanggalPinjam) tanggalPinjam.focus();
        return false;
    }

    if (!waktuMulaiInput || !waktuMulaiInput.value) {
        showNotification('Silakan pilih waktu mulai', 'warning');
        if (waktuMulaiInput) waktuMulaiInput.focus();
        return false;
    }

    if (!waktuSelesaiInput || !waktuSelesaiInput.value) {
        showNotification('Silakan pilih waktu selesai', 'warning');
        if (waktuSelesaiInput) waktuSelesaiInput.focus();
        return false;
    }

    if (waktuMulaiInput.value >= waktuSelesaiInput.value) {
        showNotification('Waktu selesai harus setelah waktu mulai', 'error');
        if (waktuSelesaiInput) waktuSelesaiInput.focus();
        return false;
    }

    return true;
}
</script>

<style>
    /* Modal Override - pastikan di atas semua */
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
}

/* Pastikan tombol di modal bisa diklik */
.modal-btn {
    cursor: pointer !important;
    z-index: 1000001 !important;
    position: relative;
}
</style>


@endsection --}}

@extends('layouts.organisasi')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <!-- Header -->
            <div class="header-booking">
                <div class="header-icon">
                    <i class="fas fa-calendar-plus"></i>
                </div>
                <h2 class="booking-title">Formulir Peminjaman Ruangan</h2>
                <p class="booking-subtitle">Silakan isi data peminjaman ruangan dengan lengkap dan benar</p>
            </div>

            <!-- Form Card -->
            <div class="booking-card">
                <form action="{{ route('organisasi.booking.store') }}" method="POST" enctype="multipart/form-data" id="bookingForm">
                    @csrf

                    <!-- ==================== BAGIAN 1: INFORMASI RUANGAN ==================== -->
                    <div class="form-section">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-door-open"></i>
                            </div>
                            <div>
                                <h5>Informasi Ruangan</h5>
                                <p>Pilih ruangan yang akan digunakan</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Pilih Ruangan <span class="text-danger">*</span></label>
                            <select name="ruangan_id" class="form-select" id="ruanganSelect" required>
                                <option value="">-- Pilih Ruangan --</option>
                                @foreach($ruangans as $ruangan)
                                    <option value="{{ $ruangan->id }}"
                                            data-kapasitas="{{ $ruangan->kapasitas }}"
                                            data-lokasi="{{ $ruangan->lokasi }}"
                                        {{ $selectedRuangan && $selectedRuangan->id == $ruangan->id ? 'selected' : '' }}>
                                        {{ $ruangan->nama_ruangan }} - {{ $ruangan->lokasi }} ({{ $ruangan->kapasitas }} orang)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div id="ruanganInfo" class="ruangan-info-card" style="display: none;">
                            <div class="info-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Lokasi: </span>
                                <strong id="ruanganLokasi">-</strong>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-users"></i>
                                <span>Kapasitas: </span>
                                <strong id="ruanganKapasitas">-</strong>
                            </div>
                        </div>

                        <div id="availabilityMessage" class="availability-message" style="display: none;"></div>
                    </div>

                    <!-- ==================== BAGIAN 2: DETAIL KEGIATAN ==================== -->
                    <div class="form-section">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <div>
                                <h5>Detail Kegiatan</h5>
                                <p>Informasi tentang kegiatan yang akan dilaksanakan</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Kategori Kegiatan <span class="text-danger">*</span></label>
                            <select name="kategori_kegiatan" class="form-select" id="kategoriKegiatan" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="Rapat Organisasi">📋 Rapat Organisasi</option>
                                <option value="Pelatihan">🎓 Pelatihan</option>
                                <option value="Seminar">🎤 Seminar</option>
                                <option value="Workshop">🛠 Workshop</option>
                                <option value="Kegiatan Seni">🎨 Kegiatan Seni</option>
                                <option value="Olahraga">⚽ Olahraga</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Keterangan Tambahan</label>
                            <textarea name="keterangan_tambahan" class="form-control" rows="3" placeholder="Informasi tambahan tentang kegiatan..."></textarea>
                        </div>
                    </div>

                    <!-- ==================== BAGIAN 3: WAKTU PEMINJAMAN ==================== -->
                    <div class="form-section">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <h5>Waktu Peminjaman</h5>
                                <p>Tentukan jadwal penggunaan ruangan</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Tanggal Pengajuan</label>
                                    <input type="date" name="tanggal_pengajuan" class="form-control" value="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Tanggal Peminjaman <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_pinjam" class="form-control" id="tanggalPinjam" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Waktu Mulai <span class="text-danger">*</span></label>
                                    <input type="time" name="waktu_mulai" class="form-control" id="waktuMulai" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Waktu Selesai <span class="text-danger">*</span></label>
                                    <input type="time" name="waktu_selesai" class="form-control" id="waktuSelesai" required>
                                </div>
                            </div>
                        </div>

                        <div id="durasiInfo" class="durasi-card" style="display: none;">
                            <i class="fas fa-hourglass-half"></i>
                            <span>Durasi peminjaman: </span>
                            <strong id="durasiText">-</strong>
                        </div>
                    </div>

                    <!-- ==================== BAGIAN 4: DOKUMEN PENDUKUNG ==================== -->
                    <div class="form-section">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-paperclip"></i>
                            </div>
                            <div>
                                <h5>Dokumen Pendukung</h5>
                                <p>Upload dokumen yang diperlukan (opsional)</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="upload-card">
                                    <div class="upload-icon">
                                        <i class="fas fa-file-pdf"></i>
                                    </div>
                                    <div class="upload-content">
                                        <h6>Bukti Surat Izin</h6>
                                        <p>Upload surat izin dari pembina organisasi</p>
                                        <div class="upload-area">
                                            <input type="file" name="bukti_surat_izin" id="suratIzin" class="upload-input" accept=".pdf,.jpg,.jpeg,.png">
                                            <label for="suratIzin" class="upload-btn">
                                                <i class="fas fa-cloud-upload-alt"></i>
                                                <span>Pilih File</span>
                                            </label>
                                            <span class="upload-filename" id="suratFileName">Belum ada file</span>
                                        </div>
                                        <small class="upload-hint">PDF, JPG, PNG (Max 2MB)</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="upload-card">
                                    <div class="upload-icon">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                    <div class="upload-content">
                                        <h6>Proposal Kegiatan</h6>
                                        <p>Upload proposal kegiatan</p>
                                        <div class="upload-area">
                                            <input type="file" name="proposal_kegiatan" id="proposal" class="upload-input" accept=".pdf,.jpg,.jpeg,.png">
                                            <label for="proposal" class="upload-btn">
                                                <i class="fas fa-cloud-upload-alt"></i>
                                                <span>Pilih File</span>
                                            </label>
                                            <span class="upload-filename" id="proposalFileName">Belum ada file</span>
                                        </div>
                                        <small class="upload-hint">PDF, JPG, PNG (Max 2MB)</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ==================== BAGIAN 5: INFORMASI PEMOHON ==================== -->
                    <div class="form-section">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-user-circle"></i>
                            </div>
                            <div>
                                <h5>Informasi Pemohon</h5>
                                <p>Data organisasi peminjam</p>
                            </div>
                        </div>

                        <div class="pemohon-grid">
                            <div class="pemohon-item">
                                <i class="fas fa-building"></i>
                                <div>
                                    <small>Nama Organisasi</small>
                                    <p>{{ Auth::user()->nama_organisasi ?? Auth::user()->name }}</p>
                                </div>
                            </div>
                            <div class="pemohon-item">
                                <i class="fas fa-user-tie"></i>
                                <div>
                                    <small>Ketua Organisasi</small>
                                    <p>{{ Auth::user()->ketua_organisasi ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="pemohon-item">
                                <i class="fas fa-phone"></i>
                                <div>
                                    <small>No. Telepon</small>
                                    <p>{{ Auth::user()->no_telp ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="pemohon-item">
                                <i class="fas fa-envelope"></i>
                                <div>
                                    <small>Email</small>
                                    <p>{{ Auth::user()->email }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ==================== TOMBOL AKSI ==================== -->
                    <div class="form-actions">
                        <button type="button" class="btn-back" id="btnKembali">
                            <i class="fas fa-arrow-left"></i>
                            <span>Kembali</span>
                        </button>
                        <button type="button" class="btn-reset" id="btnReset">
                            <i class="fas fa-eraser"></i>
                            <span>Reset</span>
                        </button>
                        <button type="submit" class="btn-submit" id="submitBtn">
                            <i class="fas fa-paper-plane"></i>
                            <span>Ajukan Peminjaman</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Modern -->
<div id="confirmModal" class="modal-custom">
    <div class="modal-custom-content">
        <div class="modal-custom-icon" id="modalIcon">
            <i class="fas fa-question-circle"></i>
        </div>
        <h3 id="modalTitle">Konfirmasi</h3>
        <p id="modalMessage">Apakah Anda yakin?</p>
        <div class="modal-custom-buttons">
            <button class="modal-btn-cancel" id="modalCancelBtn">Batal</button>
            <button class="modal-btn-confirm" id="modalConfirmBtn">Ya, Lanjutkan</button>
        </div>
    </div>
</div>

<style>
    /* ==================== BASE STYLES ==================== */
    .header-booking {
        text-align: center;
        margin-bottom: 32px;
    }
    .header-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
    }
    .header-icon i {
        font-size: 32px;
        color: white;
    }
    .booking-title {
        font-size: 28px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 8px;
    }
    .booking-subtitle {
        font-size: 14px;
        color: #6b7280;
    }

    /* Booking Card */
    .booking-card {
        background: white;
        border-radius: 24px;
        box-shadow: 0 20px 35px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    .booking-card form {
        padding: 32px;
    }

    /* Form Section */
    .form-section {
        margin-bottom: 32px;
        padding-bottom: 24px;
        border-bottom: 1px solid #e5e7eb;
    }
    .form-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    /* Section Header */
    .section-header {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 24px;
    }
    .section-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .section-icon i {
        font-size: 24px;
        color: white;
    }
    .section-header h5 {
        font-size: 16px;
        font-weight: 700;
        margin: 0 0 4px;
    }
    .section-header p {
        font-size: 12px;
        margin: 0;
    }

    /* Form Elements */
    .form-group {
        margin-bottom: 20px;
    }
    .form-label {
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 8px;
        display: block;
    }
    .form-control, .form-select {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        font-size: 14px;
        transition: all 0.2s;
    }
    .form-control:focus, .form-select:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102,126,234,0.1);
    }

    /* Ruangan Info Card */
    .ruangan-info-card {
        background: #f8fafc;
        border-radius: 16px;
        padding: 16px;
        display: flex;
        gap: 24px;
        margin-top: 16px;
    }
    .info-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
    }
    .info-item i {
        width: 18px;
    }

    /* Durasi Card */
    .durasi-card {
        background: linear-gradient(135deg, #dbeafe, #e0e7ff);
        border-radius: 12px;
        padding: 12px 16px;
        margin-top: 16px;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Upload Card */
    .upload-card {
        background: #f8fafc;
        border-radius: 20px;
        padding: 20px;
        display: flex;
        gap: 16px;
        transition: all 0.3s;
        border: 1px solid #e5e7eb;
        height: 100%;
    }
    .upload-card:hover {
        border-color: #667eea;
        box-shadow: 0 4px 12px rgba(102,126,234,0.1);
    }
    .upload-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .upload-icon i {
        font-size: 24px;
        color: white;
    }
    .upload-content {
        flex: 1;
    }
    .upload-content h6 {
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 4px;
    }
    .upload-content p {
        font-size: 12px;
        margin-bottom: 12px;
    }
    .upload-area {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }
    .upload-input {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }
    .upload-btn {
        background: linear-gradient(135deg, #667eea, #764ba2);
        padding: 8px 20px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .upload-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102,126,234,0.4);
    }
    .upload-filename {
        font-size: 12px;
    }
    .upload-hint {
        display: block;
        margin-top: 8px;
        font-size: 10px;
    }

    /* Pemohon Grid */
    .pemohon-grid {
        background: #f8fafc;
        border-radius: 16px;
        padding: 20px;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    .pemohon-item {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .pemohon-item i {
        width: 40px;
        height: 40px;
        background: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }
    .pemohon-item small {
        font-size: 11px;
        display: block;
    }
    .pemohon-item p {
        font-size: 14px;
        font-weight: 600;
        margin: 4px 0 0;
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 16px;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1px solid #e5e7eb;
    }
    .form-actions button {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 28px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s;
        border: none;
    }
    .btn-back {
        background: #f3f4f6;
    }
    .btn-back:hover {
        background: #e5e7eb;
        transform: translateY(-2px);
    }
    .btn-reset {
        background: #fef3c7;
    }
    .btn-reset:hover {
        background: #fde68a;
        transform: translateY(-2px);
    }
    .btn-submit {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(16,185,129,0.4);
    }
    .btn-submit:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Availability Message */
    .availability-message {
        margin-top: 16px;
        padding: 12px 16px;
        border-radius: 12px;
        font-size: 13px;
    }
    .availability-available {
        background: #d1fae5;
        color: #059669;
        border-left: 4px solid #10b981;
    }
    .availability-unavailable {
        background: #fee2e2;
        color: #dc2626;
        border-left: 4px solid #ef4444;
    }
    .availability-checking {
        background: #fef3c7;
        color: #d97706;
        border-left: 4px solid #f59e0b;
    }

    /* Modal Custom */
    .modal-custom {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(4px);
        z-index: 100000;
        display: none;
        align-items: center;
        justify-content: center;
    }
    .modal-custom-content {
        background: white;
        border-radius: 24px;
        width: 90%;
        max-width: 420px;
        text-align: center;
        animation: modalFadeIn 0.2s ease;
        overflow: hidden;
    }
    .modal-custom-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin: 32px auto 16px;
    }
    .modal-custom-icon i {
        font-size: 40px;
    }
    .modal-custom-icon.success {
        background: #d1fae5;
        color: #10b981;
    }
    .modal-custom-icon.warning {
        background: #fef3c7;
        color: #d97706;
    }
    .modal-custom-icon.danger {
        background: #fee2e2;
        color: #dc2626;
    }
    .modal-custom-icon.info {
        background: #dbeafe;
        color: #3b82f6;
    }
    .modal-custom-content h3 {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 8px;
    }
    .modal-custom-content p {
        font-size: 14px;
        margin-bottom: 24px;
        padding: 0 24px;
    }
    .modal-custom-buttons {
        display: flex;
        gap: 12px;
        padding: 20px 24px 24px;
        border-top: 1px solid #e5e7eb;
    }
    .modal-btn-cancel, .modal-btn-confirm {
        flex: 1;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
    }
    .modal-btn-cancel {
        background: #f3f4f6;
    }
    .modal-btn-cancel:hover {
        background: #e5e7eb;
    }
    .modal-btn-confirm {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
    }
    .modal-btn-confirm:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220,38,38,0.3);
    }
    @keyframes modalFadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    /* ==================== DARK MODE STYLES ==================== */
    body.dark-mode .booking-title {
        color: #e0e0e0 !important;
    }
    body.dark-mode .booking-subtitle {
        color: #94a3b8 !important;
    }
    body.dark-mode .booking-card {
        background-color: #1e293b !important;
    }
    body.dark-mode .form-section {
        border-bottom-color: #334155 !important;
    }
    body.dark-mode .section-header h5 {
        color: #e0e0e0 !important;
    }
    body.dark-mode .section-header p {
        color: #94a3b8 !important;
    }
    body.dark-mode .form-label {
        color: #e0e0e0 !important;
    }
    body.dark-mode .form-control,
    body.dark-mode .form-select {
        background-color: #334155 !important;
        border-color: #475569 !important;
        color: #e0e0e0 !important;
    }
    body.dark-mode .form-control::placeholder {
        color: #94a3b8 !important;
    }
    body.dark-mode .ruangan-info-card {
        background-color: #0f172a !important;
    }
    body.dark-mode .info-item {
        color: #94a3b8 !important;
    }
    body.dark-mode .info-item i {
        color: #818cf8 !important;
    }
    body.dark-mode .info-value {
        color: #e0e0e0 !important;
    }
    body.dark-mode .durasi-card {
        background: linear-gradient(135deg, #1e3c72, #2a5298) !important;
        color: #a5f3fc !important;
    }
    body.dark-mode .upload-card {
        background-color: #0f172a !important;
        border-color: #334155 !important;
    }
    body.dark-mode .upload-content h6 {
        color: #e0e0e0 !important;
    }
    body.dark-mode .upload-content p {
        color: #94a3b8 !important;
    }
    body.dark-mode .upload-btn {
        background: linear-gradient(135deg, #1e3c72, #2a5298) !important;
    }
    body.dark-mode .upload-filename {
        color: #94a3b8 !important;
    }
    body.dark-mode .upload-hint {
        color: #64748b !important;
    }
    body.dark-mode .pemohon-grid {
        background-color: #0f172a !important;
    }
    body.dark-mode .pemohon-item i {
        background-color: #1e293b !important;
        color: #818cf8 !important;
    }
    body.dark-mode .pemohon-item small {
        color: #94a3b8 !important;
    }
    body.dark-mode .pemohon-item p {
        color: #e0e0e0 !important;
    }
    body.dark-mode .form-actions {
        border-top-color: #334155 !important;
    }
    body.dark-mode .btn-back {
        background-color: #334155 !important;
        color: #cbd5e1 !important;
    }
    body.dark-mode .btn-back:hover {
        background-color: #475569 !important;
        color: white !important;
    }
    body.dark-mode .btn-reset {
        background-color: #78350f !important;
        color: #fde68a !important;
    }
    body.dark-mode .btn-reset:hover {
        background-color: #92400e !important;
    }
    body.dark-mode .btn-submit {
        background: linear-gradient(135deg, #065f46, #059669) !important;
    }
    body.dark-mode .availability-available {
        background-color: #065f46 !important;
        color: #86efac !important;
    }
    body.dark-mode .availability-unavailable {
        background-color: #7f1d1d !important;
        color: #fca5a5 !important;
    }
    body.dark-mode .availability-checking {
        background-color: #78350f !important;
        color: #fde68a !important;
    }
    body.dark-mode .modal-custom-content {
        background-color: #1e293b !important;
    }
    body.dark-mode .modal-custom-content h3 {
        color: #e0e0e0 !important;
    }
    body.dark-mode .modal-custom-content p {
        color: #94a3b8 !important;
    }
    body.dark-mode .modal-btn-cancel {
        background-color: #334155 !important;
        color: #cbd5e1 !important;
    }
    body.dark-mode .modal-btn-cancel:hover {
        background-color: #475569 !important;
        color: white !important;
    }

    @media (max-width: 768px) {
        .booking-card form { padding: 20px; }
        .pemohon-grid { grid-template-columns: 1fr; gap: 16px; }
        .form-actions { flex-wrap: wrap; }
        .form-actions button { flex: 1; justify-content: center; }
        .upload-card { flex-direction: column; text-align: center; }
        .upload-icon { margin: 0 auto; }
        .upload-area { justify-content: center; }
        .booking-title { font-size: 22px; }
    }
</style>

<script>
    // ========================================
    // DOM ELEMENTS
    // ========================================
    const ruanganSelect = document.getElementById('ruanganSelect');
    const tanggalPinjam = document.getElementById('tanggalPinjam');
    const waktuMulai = document.getElementById('waktuMulai');
    const waktuSelesai = document.getElementById('waktuSelesai');
    const kategoriKegiatan = document.getElementById('kategoriKegiatan');
    const availabilityMessage = document.getElementById('availabilityMessage');
    const submitBtn = document.getElementById('submitBtn');
    const bookingForm = document.getElementById('bookingForm');

    // Set min date
    const today = new Date().toISOString().split('T')[0];
    if (tanggalPinjam) tanggalPinjam.min = today;

    // ========================================
    // MODAL FUNCTIONS
    // ========================================
    const modal = document.getElementById('confirmModal');
    let currentCallback = null;

    function showModal(options) {
        const modalIcon = document.getElementById('modalIcon');
        const modalTitle = document.getElementById('modalTitle');
        const modalMessage = document.getElementById('modalMessage');
        const confirmBtn = document.getElementById('modalConfirmBtn');
        const cancelBtn = document.getElementById('modalCancelBtn');

        modalTitle.textContent = options.title || 'Konfirmasi';
        modalMessage.textContent = options.message || 'Apakah Anda yakin?';

        if (options.type === 'success') {
            modalIcon.className = 'modal-custom-icon success';
            modalIcon.innerHTML = '<i class="fas fa-paper-plane"></i>';
            confirmBtn.style.background = 'linear-gradient(135deg, #10b981, #059669)';
            confirmBtn.innerHTML = options.confirmText || 'Ya, Ajukan';
        } else if (options.type === 'warning') {
            modalIcon.className = 'modal-custom-icon warning';
            modalIcon.innerHTML = '<i class="fas fa-eraser"></i>';
            confirmBtn.style.background = 'linear-gradient(135deg, #f59e0b, #d97706)';
            confirmBtn.innerHTML = options.confirmText || 'Ya, Reset';
        } else if (options.type === 'danger') {
            modalIcon.className = 'modal-custom-icon danger';
            modalIcon.innerHTML = '<i class="fas fa-sign-out-alt"></i>';
            confirmBtn.style.background = 'linear-gradient(135deg, #ef4444, #dc2626)';
            confirmBtn.innerHTML = options.confirmText || 'Ya, Kembali';
        } else {
            modalIcon.className = 'modal-custom-icon info';
            modalIcon.innerHTML = '<i class="fas fa-question-circle"></i>';
            confirmBtn.style.background = 'linear-gradient(135deg, #3b82f6, #2563eb)';
            confirmBtn.innerHTML = options.confirmText || 'Ya, Lanjutkan';
        }

        currentCallback = options.onConfirm;
        const onCancel = options.onCancel || function() { modal.style.display = 'none'; };

        const newConfirmBtn = confirmBtn.cloneNode(true);
        const newCancelBtn = cancelBtn.cloneNode(true);
        confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);
        cancelBtn.parentNode.replaceChild(newCancelBtn, cancelBtn);

        newConfirmBtn.onclick = function() { if (currentCallback) currentCallback(); modal.style.display = 'none'; };
        newCancelBtn.onclick = function() { onCancel(); modal.style.display = 'none'; };

        modal.style.display = 'flex';
        modal.onclick = function(e) { if (e.target === modal) { onCancel(); modal.style.display = 'none'; } };
    }

    // ========================================
    // RUANGAN INFO
    // ========================================
    const ruanganInfo = document.getElementById('ruanganInfo');
    const ruanganLokasi = document.getElementById('ruanganLokasi');
    const ruanganKapasitas = document.getElementById('ruanganKapasitas');

    if (ruanganSelect) {
        ruanganSelect.addEventListener('change', function() {
            const opt = this.options[this.selectedIndex];
            const kapasitas = opt.getAttribute('data-kapasitas');
            const lokasi = opt.getAttribute('data-lokasi');
            if (this.value) {
                ruanganLokasi.textContent = lokasi || '-';
                ruanganKapasitas.textContent = kapasitas ? kapasitas + ' orang' : '-';
                ruanganInfo.style.display = 'flex';
            } else {
                ruanganInfo.style.display = 'none';
            }
            cekKetersediaan();
        });
        if (ruanganSelect.value) ruanganSelect.dispatchEvent(new Event('change'));
    }

    // ========================================
    // DURASI
    // ========================================
    const durasiInfo = document.getElementById('durasiInfo');
    const durasiText = document.getElementById('durasiText');

    function calculateDuration() {
        if (waktuMulai && waktuSelesai && waktuMulai.value && waktuSelesai.value) {
            const start = waktuMulai.value;
            const end = waktuSelesai.value;
            if (end > start) {
                let h = parseInt(end.split(':')[0]) - parseInt(start.split(':')[0]);
                let m = parseInt(end.split(':')[1]) - parseInt(start.split(':')[1]);
                if (m < 0) { h--; m += 60; }
                durasiText.textContent = h + ' jam ' + m + ' menit';
                durasiInfo.style.display = 'flex';
            } else {
                durasiInfo.style.display = 'none';
            }
        } else {
            durasiInfo.style.display = 'none';
        }
    }
    if (waktuMulai && waktuSelesai) {
        waktuMulai.addEventListener('change', calculateDuration);
        waktuSelesai.addEventListener('change', calculateDuration);
    }

    // ========================================
    // CEK KETERSEDIAAN
    // ========================================
    function cekKetersediaan() {
        const ruanganId = ruanganSelect?.value;
        const tanggal = tanggalPinjam?.value;
        const mulai = waktuMulai?.value;
        const selesai = waktuSelesai?.value;

        if (!ruanganId || !tanggal || !mulai || !selesai) {
            if (availabilityMessage) availabilityMessage.style.display = 'none';
            if (submitBtn) submitBtn.disabled = false;
            return;
        }

        if (availabilityMessage) {
            availabilityMessage.style.display = 'block';
            availabilityMessage.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengecek ketersediaan...';
            availabilityMessage.className = 'availability-checking';
        }

        fetch('{{ route("organisasi.booking.check") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
            body: JSON.stringify({ ruangan_id: ruanganId, tanggal_pinjam: tanggal, waktu_mulai: mulai, waktu_selesai: selesai })
        })
        .then(res => res.json())
        .then(data => {
            if (availabilityMessage) {
                if (data.tersedia) {
                    availabilityMessage.innerHTML = '<i class="fas fa-check-circle"></i> ✓ Ruangan tersedia!';
                    availabilityMessage.className = 'availability-available';
                    if (submitBtn) submitBtn.disabled = false;
                } else {
                    let msg = '<i class="fas fa-times-circle"></i> ✗ Ruangan tidak tersedia.';
                    if (data.bentrok) {
                        msg += `<br><small>Dipesan oleh: ${data.bentrok.organisasi}<br>Jadwal: ${data.bentrok.waktu_mulai} - ${data.bentrok.waktu_selesai}</small>`;
                    }
                    availabilityMessage.innerHTML = msg;
                    availabilityMessage.className = 'availability-unavailable';
                    if (submitBtn) submitBtn.disabled = true;
                }
            }
        })
        .catch(err => { console.error(err); if (submitBtn) submitBtn.disabled = false; });
    }

    if (ruanganSelect) ruanganSelect.addEventListener('change', cekKetersediaan);
    if (tanggalPinjam) tanggalPinjam.addEventListener('change', cekKetersediaan);
    if (waktuMulai) waktuMulai.addEventListener('change', cekKetersediaan);
    if (waktuSelesai) waktuSelesai.addEventListener('change', cekKetersediaan);
    if (kategoriKegiatan) kategoriKegiatan.addEventListener('change', cekKetersediaan);

    // ========================================
    // TOMBOL RESET
    // ========================================
    const btnReset = document.getElementById('btnReset');
    if (btnReset) {
        btnReset.addEventListener('click', function(e) {
            e.preventDefault();
            showModal({
                title: 'Reset Formulir',
                message: 'Apakah Anda yakin ingin mereset semua data yang sudah diisi?',
                type: 'warning',
                confirmText: 'Ya, Reset',
                onConfirm: function() {
                    bookingForm.reset();
                    if (ruanganSelect) ruanganSelect.value = '';
                    if (tanggalPinjam) tanggalPinjam.value = '';
                    if (waktuMulai) waktuMulai.value = '';
                    if (waktuSelesai) waktuSelesai.value = '';
                    if (ruanganInfo) ruanganInfo.style.display = 'none';
                    if (durasiInfo) durasiInfo.style.display = 'none';
                    if (availabilityMessage) availabilityMessage.style.display = 'none';
                    if (submitBtn) submitBtn.disabled = true;
                    showToast('Formulir telah direset', 'success');
                }
            });
        });
    }

    // ========================================
    // TOMBOL KEMBALI
    // ========================================
    const btnKembali = document.getElementById('btnKembali');
    if (btnKembali) {
        btnKembali.addEventListener('click', function(e) {
            e.preventDefault();
            showModal({
                title: 'Kembali ke Dashboard',
                message: 'Apakah Anda yakin ingin kembali ke dashboard? Data yang belum disimpan akan hilang.',
                type: 'danger',
                confirmText: 'Ya, Kembali',
                onConfirm: function() {
                    window.location.href = '{{ route("organisasi.dashboard") }}';
                }
            });
        });
    }

    // ========================================
    // TOMBOL SUBMIT
    // ========================================
    if (submitBtn && bookingForm) {
        submitBtn.addEventListener('click', function(e) {
            e.preventDefault();

            if (!ruanganSelect?.value) { showToast('Pilih ruangan', 'warning'); ruanganSelect?.focus(); return; }
            if (!tanggalPinjam?.value) { showToast('Pilih tanggal peminjaman', 'warning'); tanggalPinjam?.focus(); return; }
            if (!waktuMulai?.value) { showToast('Pilih waktu mulai', 'warning'); waktuMulai?.focus(); return; }
            if (!waktuSelesai?.value) { showToast('Pilih waktu selesai', 'warning'); waktuSelesai?.focus(); return; }
            if (waktuMulai.value >= waktuSelesai.value) { showToast('Waktu selesai harus setelah waktu mulai', 'error'); return; }
            if (!kategoriKegiatan?.value) { showToast('Pilih kategori kegiatan', 'warning'); kategoriKegiatan?.focus(); return; }
            if (submitBtn.disabled) { showToast('Ruangan tidak tersedia untuk jadwal ini', 'error'); return; }

            showModal({
                title: 'Ajukan Peminjaman',
                message: 'Apakah Anda yakin ingin mengajukan peminjaman ruangan ini?',
                type: 'success',
                confirmText: 'Ya, Ajukan',
                onConfirm: function() { bookingForm.submit(); }
            });
        });
    }

    // ========================================
    // TOAST NOTIFICATION (ATAS KANAN)
    // ========================================
    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.style.cssText = `
            position: fixed; top: 20px; right: 20px; z-index: 100000;
            background: ${type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : type === 'warning' ? '#f59e0b' : '#3b82f6'};
            color: white; padding: 14px 20px; border-radius: 12px;
            display: flex; align-items: center; gap: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            animation: slideInRight 0.3s ease; font-size: 14px;
            min-width: 320px; font-family: 'Inter', sans-serif;
        `;
        toast.innerHTML = `
            <div style="background:rgba(255,255,255,0.2); width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center;">
                <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-times-circle' : type === 'warning' ? 'fa-exclamation-triangle' : 'fa-info-circle'}"></i>
            </div>
            <div style="flex:1">${message}</div>
            <button onclick="this.parentElement.remove()" style="background:rgba(255,255,255,0.15); border:none; border-radius:8px; padding:5px 10px; color:white; cursor:pointer;">
                <i class="fas fa-times"></i> Tutup
            </button>
        `;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }

    // ========================================
    // FILE UPLOAD
    // ========================================
    document.getElementById('suratIzin')?.addEventListener('change', function(e) {
        const name = e.target.files[0]?.name || 'Belum ada file';
        document.getElementById('suratFileName').textContent = name;
        if (e.target.files[0]) showToast(`File "${name}" siap diupload`, 'success');
    });
    document.getElementById('proposal')?.addEventListener('change', function(e) {
        const name = e.target.files[0]?.name || 'Belum ada file';
        document.getElementById('proposalFileName').textContent = name;
        if (e.target.files[0]) showToast(`File "${name}" siap diupload`, 'success');
    });
</script>

@endsection
