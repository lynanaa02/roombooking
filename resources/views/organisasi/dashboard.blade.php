@extends('layouts.organisasi')

@section('content')
<div class="container-fluid">
    <!-- Welcome Section -->
    <div class="welcome-section mb-4">
        <div class="welcome-card">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="welcome-title">Selamat Datang, {{ Auth::user()->nama_organisasi ?? Auth::user()->name }}! 👋</h2>
                    <p class="welcome-subtitle">Sistem Peminjaman Ruangan dan Gedung Universitas Jember</p>
                    <p class="welcome-location mt-2">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        Universitas Jember - Jl. Kalimantan No.37, Jember
                    </p>
                </div>
                <div class="col-md-4 text-end">
                    <div class="org-badge">
                        <i class="fas fa-building"></i>
                        <span>{{ Auth::user()->jenis_organisasi ?? 'Organisasi' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Weather & Visitor Stats -->
    <div class="row mb-4">
        <!-- Weather Card (SAMA PERSIS SEPERTI ADMIN) -->
        <div class="col-md-6 mb-3">
            <div class="info-card weather-card">
                <div class="info-card-header">
                    <i class="fas fa-cloud-sun"></i>
                    <h5>Cuaca {{ $weather['city'] ?? 'Jember' }}</h5>
                </div>
                <div class="info-card-body">
                    <div class="weather-main">
                        <span class="weather-temp">{{ $weather['temperature'] ?? '28°C' }}</span>
                        <span class="weather-desc">{{ $weather['description'] ?? 'Cerah' }}</span>
                    </div>
                    <div class="weather-details">
                        <span><i class="fas fa-tint"></i> {{ $weather['humidity'] ?? '75%' }}</span>
                        <span><i class="fas fa-wind"></i> {{ $weather['wind_speed'] ?? '8 km/h' }}</span>
                        <span><i class="fas fa-thermometer-half"></i> feels {{ $weather['feels_like'] ?? '32°C' }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="info-card visitor-card">
                <div class="info-card-header">
                    <i class="fas fa-chart-line"></i>
                    <h5>Statistik Kunjungan Anda</h5>
                </div>
                <div class="info-card-body">
                    <div class="visitor-stats">
                        <div class="visitor-stat">
                            <div class="visitor-number">{{ $visitData->visit_count ?? 0 }}x</div>
                            <div class="visitor-label">Total Kunjungan</div>
                        </div>
                        <div class="visitor-stat">
                            <div class="visitor-date">
                                {{ $visitData->first_visit ? \Carbon\Carbon::parse($visitData->first_visit)->setTimezone('Asia/Jakarta')->format('d/m/Y H:i') : '-' }}
                            </div>
                            <div class="visitor-label">Kunjungan Pertama</div>
                        </div>
                        <div class="visitor-stat">
                            <div class="visitor-date">
                                {{ $visitData->last_visit ? \Carbon\Carbon::parse($visitData->last_visit)->setTimezone('Asia/Jakarta')->format('d/m/Y H:i') : '-' }}
                            </div>
                            <div class="visitor-label">Kunjungan Terakhir</div>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <small class="text-muted">* Setiap kali Anda membuka halaman ini, kunjungan akan bertambah</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="stat-card">
                <div class="stat-icon bg-primary">
                    <i class="fas fa-door-open"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $totalRuanganTersedia ?? 0 }}</h3>
                    <p>Ruangan Tersedia</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card">
                <div class="stat-icon bg-success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $totalDisetujui ?? 0 }}</h3>
                    <p>Peminjaman Disetujui</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card">
                <div class="stat-icon bg-warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $totalPending ?? 0 }}</h3>
                    <p>Menunggu Persetujuan</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card">
                <div class="stat-icon bg-danger">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $totalDitolak ?? 0 }}</h3>
                    <p>Peminjaman Ditolak</p>
                </div>
            </div>
        </div>
    </div>

   <!-- Filter/Search Section -->
    <div class="card-filter mb-4">
        <div class="card-body">
            <h5 class="filter-title mb-3">
                <i class="fas fa-search me-2"></i>Cari Ruangan
            </h5>
            <form action="{{ route('organisasi.ruangan.index') }}" method="GET" class="row g-3" id="dashboardSearchForm">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama ruangan atau lokasi..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <input type="number" name="kapasitas" class="form-control" placeholder="Minimal kapasitas" value="{{ request('kapasitas') }}">
                </div>
                <div class="col-md-3">
                    <select name="fasilitas" class="form-select">
                        <option value="">Semua Fasilitas</option>
                        <option value="ac" {{ request('fasilitas') == 'ac' ? 'selected' : '' }}>AC</option>
                        <option value="proyektor" {{ request('fasilitas') == 'proyektor' ? 'selected' : '' }}>Proyektor</option>
                        <option value="whiteboard" {{ request('fasilitas') == 'whiteboard' ? 'selected' : '' }}>Whiteboard</option>
                        <option value="sound" {{ request('fasilitas') == 'sound' ? 'selected' : '' }}>Sound System</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-filter w-100">
                        <i class="fas fa-search me-2"></i>Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Rekomendasi Ruangan -->
    <div class="section-title mb-3">
        <h4><i class="fas fa-star me-2"></i>Rekomendasi Ruangan</h4>
        <p>Ruangan yang tersedia dan sering digunakan</p>
    </div>

    <div class="row mb-5">
        @forelse($recommendedRuangan as $ruangan)
        <div class="col-md-3 mb-3">
            <div class="ruangan-card">
                <div class="ruangan-image">
                    @if($ruangan->foto && file_exists(public_path($ruangan->foto)))
                        <img src="{{ asset($ruangan->foto) }}" alt="{{ $ruangan->nama_ruangan }}">
                    @elseif($ruangan->foto && file_exists(storage_path('app/public/ruangan/' . $ruangan->foto)))
                        <img src="{{ asset('storage/ruangan/' . $ruangan->foto) }}" alt="{{ $ruangan->nama_ruangan }}">
                    @else
                        <div class="ruangan-placeholder">
                            <i class="fas fa-door-open fa-3x"></i>
                        </div>
                    @endif
                    @if($loop->iteration == 1)
                        <span class="ruangan-badge">Populer</span>
                    @endif
                </div>
                <div class="ruangan-info">
                    <h5>{{ $ruangan->nama_ruangan }}</h5>
                    <p class="kapasitas"><i class="fas fa-users me-1"></i> Kapasitas: {{ $ruangan->kapasitas }} orang</p>
                    <p class="lokasi"><i class="fas fa-map-marker-alt me-1"></i> {{ $ruangan->lokasi }}</p>
                    <div class="fasilitas">
                        @php
                            $fasilitasList = explode(',', $ruangan->fasilitas ?? '');
                        @endphp
                        @foreach(array_slice($fasilitasList, 0, 3) as $fas)
                            <span class="fasilitas-badge">{{ trim($fas) }}</span>
                        @endforeach
                    </div>
                    <button class="btn-booking mt-2" onclick="location.href='{{ route('organisasi.booking.create', $ruangan->id) }}'">
                        <i class="fas fa-calendar-plus me-2"></i>Booking Sekarang
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle me-2"></i>
                Belum ada data ruangan. Silahkan hubungi admin.
            </div>
        </div>
        @endforelse
    </div>

    <!-- Formulir Pengajuan Peminjaman -->
    <div id="form-booking" class="section-title mb-3">
        <h4><i class="fas fa-file-alt me-2"></i>Formulir Pengajuan Peminjaman</h4>
        <p>Isi formulir berikut untuk mengajukan peminjaman ruangan</p>
    </div>

    <div class="card-form mb-5">
        <div class="card-body">
            <form action="{{ route('organisasi.booking.store') }}" method="POST" enctype="multipart/form-data" id="dashboardBookingForm">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Pilih Ruangan <span class="text-danger">*</span></label>
                        <select name="ruangan_id" id="dashboardRuanganId" class="form-select" required>
                            <option value="">-- Pilih Ruangan --</option>
                            @foreach($ruangans as $ruangan)
                                <option value="{{ $ruangan->id }}">
                                    {{ $ruangan->nama_ruangan }} - {{ $ruangan->lokasi }} ({{ $ruangan->kapasitas }} orang)
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kategori Kegiatan <span class="text-danger">*</span></label>
                        <select name="kategori_kegiatan" id="dashboardKategori" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Rapat Organisasi">📋 Rapat Organisasi</option>
                            <option value="Pelatihan">🎓 Pelatihan</option>
                            <option value="Seminar">🎤 Seminar</option>
                            <option value="Workshop">🛠 Workshop</option>
                            <option value="Kegiatan Seni">🎨 Kegiatan Seni</option>
                            <option value="Olahraga">⚽ Olahraga</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tanggal Pengajuan <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_pengajuan" id="dashboardTanggalPengajuan" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tanggal Peminjaman <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_pinjam" id="dashboardTanggalPinjam" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Waktu Mulai <span class="text-danger">*</span></label>
                        <input type="time" name="waktu_mulai" id="dashboardWaktuMulai" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Waktu Selesai <span class="text-danger">*</span></label>
                        <input type="time" name="waktu_selesai" id="dashboardWaktuSelesai" class="form-control" required>
                    </div>
                </div>

                <!-- Availability Message -->
                <div id="dashboardAvailabilityMessage" class="availability-message" style="display: none;"></div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="upload-modern-area">
                            <div class="upload-modern-icon">
                                <i class="fas fa-file-pdf"></i>
                            </div>
                            <div class="upload-modern-content">
                                <h6>Bukti Surat Izin</h6>
                                <p>Upload surat izin dari pembina organisasi (Opsional)</p>
                                <div class="upload-modern-wrapper">
                                    <input type="file" name="bukti_surat_izin" id="uploadSurat" class="upload-modern-input" accept=".pdf,.jpg,.jpeg,.png">
                                    <label for="uploadSurat" class="upload-modern-label">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        <span>Pilih File</span>
                                    </label>
                                    <span class="upload-modern-filename" id="suratFileName">Tidak ada file dipilih</span>
                                </div>
                                <small class="upload-modern-hint">Format: PDF, JPG, PNG (Max 2MB)</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="upload-modern-area">
                            <div class="upload-modern-icon">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div class="upload-modern-content">
                                <h6>Proposal Kegiatan</h6>
                                <p>Upload proposal kegiatan (Opsional)</p>
                                <div class="upload-modern-wrapper">
                                    <input type="file" name="proposal_kegiatan" id="uploadProposal" class="upload-modern-input" accept=".pdf,.jpg,.jpeg,.png">
                                    <label for="uploadProposal" class="upload-modern-label">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        <span>Pilih File</span>
                                    </label>
                                    <span class="upload-modern-filename" id="proposalFileName">Tidak ada file dipilih</span>
                                </div>
                                <small class="upload-modern-hint">Format: PDF, JPG, PNG (Max 2MB)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan Tambahan</label>
                    <textarea name="keterangan_tambahan" class="form-control" rows="2" placeholder="Informasi tambahan tentang kegiatan..."></textarea>
                </div>

                <div class="text-end">
                    <button type="button" class="btn btn-secondary me-2" id="dashboardBtnReset">
                        <i class="fas fa-eraser me-2"></i>Reset
                    </button>
                    <button type="submit" class="btn btn-submit" id="dashboardSubmitBtn">
                        <i class="fas fa-paper-plane me-2"></i>Ajukan Peminjaman
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Riwayat Peminjaman Terakhir -->
    <div class="section-title mb-3">
        <h4><i class="fas fa-history me-2"></i>Riwayat Peminjaman Terakhir</h4>
        <p>10 peminjaman terakhir yang Anda ajukan</p>
    </div>

    <div class="card-table">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-modern">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Ruangan</th>
                            <th>Kegiatan</th>
                            <th>Tanggal Pinjam</th>
                            <th>Waktu</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayatBookings as $index => $booking)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $booking->ruangan->nama_ruangan ?? '-' }}</td>
                            <td>{{ $booking->kategori_kegiatan ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($booking->tanggal_pinjam)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($booking->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->waktu_selesai)->format('H:i') }}</td>
                            <td>
                                @if($booking->status == 'pending')
                                    <span class="status-badge status-pending">⏳ Menunggu</span>
                                @elseif($booking->status == 'disetujui')
                                    <span class="status-badge status-approved">✓ Disetujui</span>
                                @else
                                    <span class="status-badge status-rejected">✗ Ditolak</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('organisasi.booking.show', $booking->id) }}" class="btn-detail">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-2 d-block"></i>
                                <p>Belum ada riwayat peminjaman</p>
                                <button class="btn-submit mt-2" onclick="document.getElementById('form-booking').scrollIntoView({behavior: 'smooth'})">Ajukan Peminjaman Sekarang</button>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi -->
<div id="confirmModal" class="modal-overlay" style="display: none;">
    <div class="modal-container">
        <div class="modal-header">
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
    .welcome-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 24px;
        padding: 30px;
        color: white;
        box-shadow: 0 10px 30px rgba(102,126,234,0.3);
    }
    body.dark-mode .welcome-card {
        background: linear-gradient(135deg, #1e3c72, #2a5298) !important;
    }
    .welcome-title { font-size: 28px; font-weight: 700; margin-bottom: 8px; }
    .welcome-subtitle { font-size: 14px; opacity: 0.9; }
    .welcome-location { font-size: 13px; opacity: 0.85; }
    .org-badge { display: inline-flex; align-items: center; gap: 10px; background: rgba(255,255,255,0.2); padding: 12px 20px; border-radius: 50px; font-weight: 600; }

    .stat-card { background: white; border-radius: 20px; padding: 20px; display: flex; align-items: center; gap: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.06); transition: all 0.3s; }
    body.dark-mode .stat-card { background-color: #1e293b !important; }
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
    .stat-icon { width: 55px; height: 55px; border-radius: 16px; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; }
    .stat-icon.bg-primary { background: linear-gradient(135deg, #667eea, #764ba2); }
    .stat-icon.bg-success { background: linear-gradient(135deg, #10b981, #059669); }
    .stat-icon.bg-warning { background: linear-gradient(135deg, #f59e0b, #d97706); }
    .stat-icon.bg-danger { background: linear-gradient(135deg, #ef4444, #dc2626); }
    .stat-info h3 { font-size: 28px; font-weight: 700; margin: 0; color: #1f2937; }
    body.dark-mode .stat-info h3,
    body.dark-mode .stat-info p { color: #e0e0e0 !important; }
    .stat-info p { margin: 0; font-size: 13px; color: #6b7280; }

    .info-card { background: white; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); overflow: hidden; height: 100%; }
    body.dark-mode .info-card { background-color: #1e293b !important; }
    .info-card-header { background: #f8fafc; padding: 14px 20px; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; gap: 10px; }
    body.dark-mode .info-card-header { background-color: #0f172a !important; border-bottom-color: #334155 !important; }
    .info-card-header i { font-size: 18px; color: #667eea; }
    .info-card-header h5 { font-size: 15px; font-weight: 600; margin: 0; color: #1f2937; }
    body.dark-mode .info-card-header h5 { color: #e0e0e0 !important; }

    .weather-main { display: flex; align-items: baseline; gap: 12px; margin-bottom: 12px; }
    .weather-temp { font-size: 32px; font-weight: 700; color: #1f2937; }
    body.dark-mode .weather-temp { color: #e0e0e0 !important; }
    .weather-desc { font-size: 14px; color: #6b7280; }
    body.dark-mode .weather-desc { color: #94a3b8 !important; }
    .weather-details { display: flex; gap: 20px; font-size: 12px; color: #6b7280; }
    body.dark-mode .weather-details { color: #94a3b8 !important; }

    .visitor-stats { display: flex; justify-content: space-around; margin-bottom: 16px; text-align: center; }
    .visitor-stat { flex: 1; }
    .visitor-number { font-size: 28px; font-weight: 700; color: #1f2937; }
    body.dark-mode .visitor-number { color: #e0e0e0 !important; }
    .visitor-date { font-size: 13px; font-weight: 600; color: #1f2937; }
    body.dark-mode .visitor-date { color: #cbd5e1 !important; }
    .visitor-label { font-size: 11px; color: #9ca3af; margin-top: 4px; }

    .card-filter { background: white; border-radius: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.06); overflow: hidden; }
    body.dark-mode .card-filter { background-color: #1e293b !important; }
    .card-filter .card-body { padding: 20px; }
    .filter-title { font-size: 16px; font-weight: 600; color: #1f2937; margin-bottom: 15px; }
    body.dark-mode .filter-title { color: #e0e0e0 !important; }
    .btn-filter { background: linear-gradient(135deg, #667eea, #764ba2); border: none; padding: 10px 20px; border-radius: 12px; color: white; font-weight: 600; transition: all 0.3s; }

    .section-title h4 { font-size: 20px; font-weight: 700; color: #1f2937; margin-bottom: 5px; }
    body.dark-mode .section-title h4 { color: #e0e0e0 !important; }
    .section-title p { font-size: 13px; color: #6b7280; margin-bottom: 0; }
    body.dark-mode .section-title p { color: #94a3b8 !important; }

    .ruangan-card { background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.06); transition: all 0.3s; height: 100%; }
    body.dark-mode .ruangan-card { background-color: #1e293b !important; }
    .ruangan-card:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.12); }
    .ruangan-image { position: relative; height: 160px; overflow: hidden; background: linear-gradient(135deg, #667eea, #764ba2); }
    .ruangan-image img { width: 100%; height: 100%; object-fit: cover; }
    .ruangan-placeholder { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: white; }
    .ruangan-badge { position: absolute; top: 10px; right: 10px; background: linear-gradient(135deg, #f59e0b, #d97706); color: white; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; }
    .ruangan-info { padding: 16px; }
    .ruangan-info h5 { font-size: 16px; font-weight: 700; margin-bottom: 8px; color: #1f2937; }
    body.dark-mode .ruangan-info h5 { color: #e0e0e0 !important; }
    .ruangan-info .kapasitas, .ruangan-info .lokasi { font-size: 12px; color: #6b7280; margin-bottom: 6px; }
    body.dark-mode .ruangan-info .kapasitas,
    body.dark-mode .ruangan-info .lokasi { color: #94a3b8 !important; }
    .fasilitas { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 8px; }
    .fasilitas-badge { background: #f3f4f6; padding: 4px 10px; border-radius: 12px; font-size: 10px; color: #4b5563; }
    body.dark-mode .fasilitas-badge { background: #334155 !important; color: #cbd5e1 !important; }
    .btn-booking { width: 100%; background: linear-gradient(135deg, #667eea, #764ba2); border: none; padding: 8px; border-radius: 12px; color: white; font-weight: 600; font-size: 13px; transition: all 0.3s; cursor: pointer; }
    .btn-booking:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(102,126,234,0.4); }

    .card-form { background: white; border-radius: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.06); overflow: hidden; }
    body.dark-mode .card-form { background-color: #1e293b !important; }
    .card-form .card-body { padding: 28px; }
    .form-label { font-weight: 600; font-size: 13px; color: #374151; margin-bottom: 8px; display: block; }
    body.dark-mode .form-label { color: #e0e0e0 !important; }
    .form-control, .form-select { border-radius: 12px; border: 1px solid #e5e7eb; padding: 10px 14px; font-size: 14px; width: 100%; }
    body.dark-mode .form-control,
    body.dark-mode .form-select { background-color: #334155 !important; border-color: #475569 !important; color: #e0e0e0 !important; }

    .upload-wrapper { position: relative; margin-top: 5px; }
    .file-input { position: absolute; opacity: 0; width: 0; height: 0; }
    .upload-label { display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px; border: 2px dashed #e5e7eb; border-radius: 16px; cursor: pointer; transition: all 0.2s; text-align: center; background: #fafbfc; }
    body.dark-mode .upload-label { background-color: #334155 !important; border-color: #475569 !important; }
    body.dark-mode .upload-label span { color: #e0e0e0 !important; }
    body.dark-mode .upload-label small { color: #94a3b8 !important; }
    .upload-label:hover { border-color: #667eea; background: #f8fafc; }

    .availability-message { margin-top: 15px; padding: 12px 16px; border-radius: 12px; font-size: 13px; }
    .availability-available { background: #d1fae5; color: #059669; border-left: 4px solid #10b981; }
    body.dark-mode .availability-available { background: #065f46 !important; color: #86efac !important; }
    .availability-unavailable { background: #fee2e2; color: #dc2626; border-left: 4px solid #ef4444; }
    body.dark-mode .availability-unavailable { background: #7f1d1d !important; color: #fca5a5 !important; }
    .availability-checking { background: #fef3c7; color: #d97706; border-left: 4px solid #f59e0b; }

    .btn-submit { background: linear-gradient(135deg, #10b981, #059669); border: none; padding: 10px 28px; border-radius: 12px; color: white; font-weight: 600; transition: all 0.3s; cursor: pointer; }
    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(16,185,129,0.4); }
    body.dark-mode .btn-submit { background: linear-gradient(135deg, #065f46, #059669) !important; }
    .btn-secondary { background: #e5e7eb; border: none; padding: 10px 24px; border-radius: 12px; color: #4b5563; font-weight: 600; cursor: pointer; transition: all 0.2s; }
    body.dark-mode .btn-secondary { background-color: #334155 !important; color: #cbd5e1 !important; }

    .card-table { background: white; border-radius: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.06); overflow: hidden; }
    body.dark-mode .card-table { background-color: #1e293b !important; }
    .card-table .card-body { padding: 0; }
    .table-modern { width: 100%; border-collapse: collapse; }
    .table-modern th { background: #f9fafb; padding: 14px 12px; font-size: 13px; font-weight: 600; color: #4b5563; }
    body.dark-mode .table-modern th { background-color: #0f172a !important; color: #94a3b8 !important; }
    .table-modern td { padding: 12px; font-size: 13px; border-bottom: 1px solid #e5e7eb; }
    body.dark-mode .table-modern td { color: #cbd5e1 !important; border-bottom-color: #334155 !important; }
    .status-badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; }
    .status-pending { background: #fef3c7; color: #d97706; }
    body.dark-mode .status-pending { background: #78350f !important; color: #fde68a !important; }
    .status-approved { background: #d1fae5; color: #059669; }
    body.dark-mode .status-approved { background: #065f46 !important; color: #86efac !important; }
    .status-rejected { background: #fee2e2; color: #dc2626; }
    body.dark-mode .status-rejected { background: #7f1d1d !important; color: #fca5a5 !important; }
    .btn-detail { background: none; border: none; color: #667eea; font-size: 12px; text-decoration: none; cursor: pointer; }
    body.dark-mode .btn-detail { color: #818cf8 !important; }
    .btn-detail:hover { color: #764ba2; text-decoration: underline; }

    /* Modal Styles */
    .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.6); backdrop-filter: blur(4px); z-index: 999999 !important; display: none; align-items: center; justify-content: center; }
    .modal-container { background: white; border-radius: 24px; width: 90%; max-width: 420px; z-index: 1000000 !important; position: relative; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); animation: slideInUp 0.3s ease; }
    body.dark-mode .modal-container { background-color: #1e293b !important; }
    .modal-header { padding: 24px 24px 0 24px; text-align: center; }
    .modal-icon { width: 70px; height: 70px; background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 16px; }
    .modal-icon i { font-size: 32px; color: #dc2626; }
    .modal-header h3 { font-size: 20px; font-weight: 700; color: #1f2937; margin: 0; }
    body.dark-mode .modal-header h3 { color: #e0e0e0 !important; }
    .modal-body { padding: 16px 24px 0 24px; text-align: center; }
    .modal-body p { font-size: 14px; color: #6b7280; line-height: 1.5; margin: 0; }
    body.dark-mode .modal-body p { color: #94a3b8 !important; }
    .modal-footer { padding: 20px 24px 24px 24px; display: flex; gap: 12px; justify-content: center; }
    .modal-btn { padding: 10px 24px; border-radius: 12px; font-weight: 600; font-size: 14px; cursor: pointer !important; transition: all 0.2s; border: none; flex: 1; }
    .modal-btn-cancel { background: #f3f4f6; color: #6b7280; }
    body.dark-mode .modal-btn-cancel { background-color: #334155 !important; color: #cbd5e1 !important; }
    .modal-btn-confirm { background: linear-gradient(135deg, #ef4444, #dc2626); color: white; }
    .modal-icon-success { background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); }
    .modal-icon-success i { color: #10b981; }
    .modal-btn-success { background: linear-gradient(135deg, #10b981, #059669); color: white; }
    .modal-icon-warning { background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); }
    .modal-icon-warning i { color: #d97706; }
    .modal-btn-warning { background: linear-gradient(135deg, #f59e0b, #d97706); color: white; }

    @keyframes slideInUp { from { opacity: 0; transform: translateY(30px) scale(0.95); } to { opacity: 1; transform: translateY(0) scale(1); } }
    @keyframes slideInRight { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }

    .custom-notification { position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 350px; padding: 16px 20px; border-radius: 16px; display: flex; align-items: center; gap: 14px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); animation: slideInRight 0.3s ease-out; }
    .custom-notification-success { background: #10b981; color: white; }
    .custom-notification-error { background: #ef4444; color: white; }
    .custom-notification-warning { background: #f59e0b; color: white; }
    .custom-notification-info { background: #3b82f6; color: white; }

    @media (max-width: 768px) {
        .welcome-title { font-size: 20px; }
        .stat-card { padding: 15px; }
        .stat-icon { width: 45px; height: 45px; font-size: 20px; }
        .stat-info h3 { font-size: 22px; }
        .ruangan-card { margin-bottom: 16px; }
        .card-form .card-body { padding: 20px; }
        .custom-notification { min-width: 280px; top: 10px; right: 10px; }
        .visitor-stats { flex-direction: column; gap: 12px; }
        .visitor-stat { margin-bottom: 10px; }
    }

    /* Weather Card - SAMA PERSIS DENGAN ADMIN */
    .weather-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        overflow: hidden;
        height: 100%;
    }
    body.dark-mode .weather-card {
        background-color: #1e293b !important;
    }
    .weather-main {
        display: flex;
        align-items: baseline;
        gap: 12px;
        margin-bottom: 12px;
    }
    .weather-temp {
        font-size: 28px;
        font-weight: 700;
        color: #1f2937;
    }
    body.dark-mode .weather-temp {
        color: #e0e0e0 !important;
    }
    .weather-desc {
        font-size: 14px;
        color: #6b7280;
    }
    body.dark-mode .weather-desc {
        color: #94a3b8 !important;
    }
    .weather-details {
        display: flex;
        gap: 16px;
        font-size: 12px;
        color: #6b7280;
        flex-wrap: wrap;
    }
    body.dark-mode .weather-details {
        color: #94a3b8 !important;
    }
    .weather-details i {
        width: 20px;
        color: #667eea;
    }
    body.dark-mode .weather-details i {
        color: #818cf8 !important;
    }

    /* Visitor Card */
    .visitor-stats {
        display: flex;
        justify-content: space-around;
        text-align: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    .visitor-stat {
        flex: 1;
        min-width: 100px;
    }
    .visitor-number {
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
    }
    body.dark-mode .visitor-number {
        color: #e0e0e0 !important;
    }
    .visitor-date {
        font-size: 13px;
        font-weight: 600;
        color: #1f2937;
    }
    body.dark-mode .visitor-date {
        color: #cbd5e1 !important;
    }
    .visitor-label {
        font-size: 11px;
        color: #9ca3af;
        margin-top: 4px;
    }


    /* Upload Modern Area */
.upload-modern-area {
    background: #f8fafc;
    border-radius: 20px;
    padding: 24px;
    display: flex;
    gap: 20px;
    transition: all 0.3s;
    border: 1px solid #e5e7eb;
}
body.dark-mode .upload-modern-area {
    background: #1e293b;
    border-color: #334155;
}
.upload-modern-area:hover {
    border-color: #667eea;
    box-shadow: 0 4px 12px rgba(102,126,234,0.1);
}
.upload-modern-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.upload-modern-icon i {
    font-size: 28px;
    color: white;
}
.upload-modern-content {
    flex: 1;
}
.upload-modern-content h6 {
    font-size: 15px;
    font-weight: 700;
    margin-bottom: 4px;
    color: #1f2937;
}
body.dark-mode .upload-modern-content h6 {
    color: #e0e0e0;
}
.upload-modern-content p {
    font-size: 12px;
    color: #6b7280;
    margin-bottom: 12px;
}
body.dark-mode .upload-modern-content p {
    color: #94a3b8;
}
.upload-modern-wrapper {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}
.upload-modern-input {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
}
.upload-modern-label {
    background: linear-gradient(135deg, #667eea, #764ba2);
    border: none;
    padding: 8px 20px;
    border-radius: 30px;
    color: white;
    font-weight: 600;
    font-size: 13px;
    cursor: pointer;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}
.upload-modern-label:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102,126,234,0.4);
}
.upload-modern-filename {
    font-size: 12px;
    color: #6b7280;
    word-break: break-all;
}
body.dark-mode .upload-modern-filename {
    color: #94a3b8;
}
.upload-modern-hint {
    display: block;
    margin-top: 8px;
    font-size: 10px;
    color: #9ca3af;
}

@media (max-width: 768px) {
    .upload-modern-area {
        flex-direction: column;
        text-align: center;
    }
    .upload-modern-icon {
        margin: 0 auto;
    }
    .upload-modern-wrapper {
        justify-content: center;
    }
}


</style>

<script>
    // ========================================
    // NOTIFICATION FUNCTIONS
    // ========================================
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `custom-notification custom-notification-${type}`;

        let icon = '';
        if (type === 'success') icon = '<i class="fas fa-check-circle"></i>';
        else if (type === 'error') icon = '<i class="fas fa-times-circle"></i>';
        else if (type === 'warning') icon = '<i class="fas fa-exclamation-triangle"></i>';
        else icon = '<i class="fas fa-info-circle"></i>';

        notification.innerHTML = `
            <div style="background: rgba(255,255,255,0.2); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">${icon}</div>
            <div style="flex: 1; font-size: 14px; font-weight: 500;">${message}</div>
            <button onclick="this.closest('.custom-notification').remove()" style="background: rgba(255,255,255,0.15); border: none; border-radius: 10px; padding: 5px 10px; color: white; cursor: pointer;"><i class="fas fa-times me-1"></i> Tutup</button>
        `;

        document.body.appendChild(notification);
        setTimeout(() => { if (notification.parentNode) notification.remove(); }, 4000);
    }

    // ========================================
    // MODAL FUNCTIONS
    // ========================================
    const modal = document.getElementById('confirmModal');
    let currentCallback = null;
    let isModalOpen = false;

    function showModal(options) {
        if (isModalOpen) return;

        document.getElementById('modalTitle').textContent = options.title || 'Konfirmasi';
        document.getElementById('modalMessage').textContent = options.message || 'Apakah Anda yakin?';

        const modalIconDiv = document.getElementById('modalIcon');
        const modalConfirmBtnElem = document.getElementById('modalConfirmBtn');

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
        } else {
            modalIconDiv.className = 'modal-icon';
            modalIconDiv.innerHTML = '<i class="fas fa-question-circle"></i>';
            modalConfirmBtnElem.className = 'modal-btn modal-btn-confirm';
            modalConfirmBtnElem.innerHTML = '<i class="fas fa-check me-2"></i>' + (options.confirmText || 'Ya, Lanjutkan');
        }

        currentCallback = options.onConfirm;
        const onCancel = options.onCancel || function() { closeModal(); };

        const oldConfirmBtn = modalConfirmBtnElem;
        const oldCancelBtn = document.getElementById('modalCancelBtn');
        const newConfirmBtn = oldConfirmBtn.cloneNode(true);
        const newCancelBtn = oldCancelBtn.cloneNode(true);

        oldConfirmBtn.parentNode.replaceChild(newConfirmBtn, oldConfirmBtn);
        oldCancelBtn.parentNode.replaceChild(newCancelBtn, oldCancelBtn);

        newConfirmBtn.onclick = function(e) { e.preventDefault(); e.stopPropagation(); if (currentCallback) currentCallback(); closeModal(); currentCallback = null; };
        newCancelBtn.onclick = function(e) { e.preventDefault(); e.stopPropagation(); if (onCancel) onCancel(); closeModal(); currentCallback = null; };

        modal.style.display = 'flex';
        isModalOpen = true;
        modal.onclick = function(e) { if (e.target === modal) { onCancel(); closeModal(); currentCallback = null; } };
    }

    function closeModal() { modal.style.display = 'none'; isModalOpen = false; }

    // ========================================
    // CEK KETERSEDIAAN RUANGAN (AJAX)
    // ========================================
    const dashboardRuanganId = document.getElementById('dashboardRuanganId');
    const dashboardTanggalPinjam = document.getElementById('dashboardTanggalPinjam');
    const dashboardWaktuMulai = document.getElementById('dashboardWaktuMulai');
    const dashboardWaktuSelesai = document.getElementById('dashboardWaktuSelesai');
    const dashboardAvailabilityMessage = document.getElementById('dashboardAvailabilityMessage');
    const dashboardSubmitBtn = document.getElementById('dashboardSubmitBtn');

    const today = new Date().toISOString().split('T')[0];
    if (dashboardTanggalPinjam) dashboardTanggalPinjam.min = today;

    function cekKetersediaanDashboard() {
        const ruanganId = dashboardRuanganId ? dashboardRuanganId.value : null;
        const tanggal = dashboardTanggalPinjam ? dashboardTanggalPinjam.value : null;
        const mulai = dashboardWaktuMulai ? dashboardWaktuMulai.value : null;
        const selesai = dashboardWaktuSelesai ? dashboardWaktuSelesai.value : null;

        if (!ruanganId || !tanggal || !mulai || !selesai) {
            if (dashboardAvailabilityMessage) dashboardAvailabilityMessage.style.display = 'none';
            if (dashboardSubmitBtn) dashboardSubmitBtn.disabled = false;
            return;
        }

        if (dashboardAvailabilityMessage) {
            dashboardAvailabilityMessage.style.display = 'block';
            dashboardAvailabilityMessage.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengecek ketersediaan ruangan...';
            dashboardAvailabilityMessage.className = 'availability-checking';
        }

        fetch('{{ route("organisasi.booking.check") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
            body: JSON.stringify({ ruangan_id: ruanganId, tanggal_pinjam: tanggal, waktu_mulai: mulai, waktu_selesai: selesai })
        })
        .then(response => response.json())
        .then(data => {
            if (dashboardAvailabilityMessage) {
                if (data.tersedia) {
                    dashboardAvailabilityMessage.innerHTML = '<i class="fas fa-check-circle"></i> ✓ Ruangan tersedia untuk jadwal ini!';
                    dashboardAvailabilityMessage.className = 'availability-available';
                    if (dashboardSubmitBtn) dashboardSubmitBtn.disabled = false;
                } else {
                    let message = '<i class="fas fa-times-circle"></i> ✗ Ruangan tidak tersedia untuk jadwal ini.';
                    if (data.bentrok) {
                        message += `<br><small>Sudah dipesan oleh: ${data.bentrok.organisasi}<br>📅 Jadwal: ${data.bentrok.waktu_mulai} - ${data.bentrok.waktu_selesai}</small>`;
                    }
                    dashboardAvailabilityMessage.innerHTML = message;
                    dashboardAvailabilityMessage.className = 'availability-unavailable';
                    if (dashboardSubmitBtn) dashboardSubmitBtn.disabled = true;
                    showNotification('Ruangan sudah dipesan pada jadwal tersebut!', 'error');
                }
                dashboardAvailabilityMessage.style.display = 'block';
            }
        })
        .catch(error => { console.error('Error:', error); if (dashboardSubmitBtn) dashboardSubmitBtn.disabled = false; });
    }

    if (dashboardRuanganId) dashboardRuanganId.addEventListener('change', cekKetersediaanDashboard);
    if (dashboardTanggalPinjam) dashboardTanggalPinjam.addEventListener('change', cekKetersediaanDashboard);
    if (dashboardWaktuMulai) dashboardWaktuMulai.addEventListener('change', cekKetersediaanDashboard);
    if (dashboardWaktuSelesai) dashboardWaktuSelesai.addEventListener('change', cekKetersediaanDashboard);

    // ========================================
    // TOMBOL RESET DASHBOARD
    // ========================================
    const dashboardBtnReset = document.getElementById('dashboardBtnReset');
    const dashboardForm = document.getElementById('dashboardBookingForm');

    if (dashboardBtnReset) {
        dashboardBtnReset.addEventListener('click', function(e) {
            e.preventDefault();
            showModal({
                title: 'Reset Formulir',
                message: 'Apakah Anda yakin ingin mereset semua data yang sudah diisi? Semua perubahan akan hilang.',
                type: 'warning',
                confirmText: 'Ya, Reset',
                onConfirm: function() {
                    if (dashboardForm) {
                        dashboardForm.reset();
                        if (dashboardAvailabilityMessage) dashboardAvailabilityMessage.style.display = 'none';
                        if (dashboardSubmitBtn) dashboardSubmitBtn.disabled = true;
                        showNotification('Formulir telah direset', 'success');
                    }
                }
            });
        });
    }

    // ========================================
    // SUBMIT FORM DASHBOARD
    // ========================================
    if (dashboardForm) {
        dashboardForm.addEventListener('submit', function(e) {
            e.preventDefault();

            if (!dashboardRuanganId.value) { showNotification('Silakan pilih ruangan', 'warning'); return; }
            if (!dashboardTanggalPinjam.value) { showNotification('Silakan pilih tanggal peminjaman', 'warning'); return; }
            if (!dashboardWaktuMulai.value) { showNotification('Silakan pilih waktu mulai', 'warning'); return; }
            if (!dashboardWaktuSelesai.value) { showNotification('Silakan pilih waktu selesai', 'warning'); return; }
            if (dashboardWaktuMulai.value >= dashboardWaktuSelesai.value) { showNotification('Waktu selesai harus setelah waktu mulai', 'error'); return; }

            if (dashboardSubmitBtn.disabled) {
                showNotification('Ruangan tidak tersedia untuk jadwal ini', 'error');
                return;
            }

            showModal({
                title: 'Ajukan Peminjaman',
                message: 'Apakah Anda yakin ingin mengajukan peminjaman ruangan ini? Data yang diajukan akan diproses oleh admin.',
                type: 'success',
                confirmText: 'Ya, Ajukan',
                onConfirm: function() {
                    showNotification('Mengirim pengajuan peminjaman...', 'info');
                    dashboardForm.submit();
                }
            });
        });
    }

    // ========================================
    // FILE UPLOAD SHOW FILENAME
    // ========================================
     // Update filename display for upload
    document.getElementById('uploadSurat').addEventListener('change', function(e) {
        const fileName = e.target.files[0] ? e.target.files[0].name : 'Tidak ada file dipilih';
        document.getElementById('suratFileName').textContent = fileName;
    });
    document.getElementById('uploadProposal').addEventListener('change', function(e) {
        const fileName = e.target.files[0] ? e.target.files[0].name : 'Tidak ada file dipilih';
        document.getElementById('proposalFileName').textContent = fileName;
    });
</script>
@endsection
