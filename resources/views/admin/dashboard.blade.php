@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-card">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="welcome-title">Selamat Datang, {{ $admin->name }}! 👋</h2>
                        <p class="welcome-subtitle">Sistem Booking Ruangan dan Gedung Universitas Jember</p>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="welcome-date">
                            <i class="fas fa-calendar-alt me-2"></i>
                            {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Weather & Visitor Stats Row -->
    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="info-card weather-card">
                <div class="info-card-header">
                    <i class="fas fa-cloud-sun"></i>
                    <h5>Cuaca {{ $weather['city'] }}</h5>
                </div>
                <div class="info-card-body">
                    <div class="weather-main">
                        <span class="weather-temp">{{ $weather['temperature'] }}</span>
                        <span class="weather-desc">{{ $weather['description'] }}</span>
                    </div>
                    <div class="weather-details">
                        <span><i class="fas fa-tint"></i> {{ $weather['humidity'] }}</span>
                        <span><i class="fas fa-wind"></i> {{ $weather['wind_speed'] }}</span>
                        <span><i class="fas fa-thermometer-half"></i> feels {{ $weather['feels_like'] }}</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Visitor Stats -->
        <div class="col-md-6 mb-3">
            <div class="info-card visitor-card">
                <div class="info-card-header">
                    <i class="fas fa-chart-line"></i>
                    <h5>Statistik Kunjungan</h5>
                </div>
                <div class="info-card-body">
                    <div class="visitor-stats">
                        <div class="visitor-stat">
                            <div class="visitor-number">{{ $visitData->visit_count ?? 0 }}</div>
                            <div class="visitor-label">Total Kunjungan</div>
                        </div>
                        <div class="visitor-stat">
                            <div class="visitor-date">
                                {{ $visitData->first_visit ? $visitData->first_visit->setTimezone('Asia/Jakarta')->format('d/m/Y H:i') : '-' }}
                            </div>
                            <div class="visitor-label">Pertama Kali</div>
                        </div>
                        <div class="visitor-stat">
                            <div class="visitor-date">
                                {{ $visitData->last_visit ? $visitData->last_visit->setTimezone('Asia/Jakarta')->format('d/m/Y H:i') : '-' }}
                            </div>
                            <div class="visitor-label">Terakhir</div>
                        </div>
                    </div>
                    <form action="{{ route('admin.visit.reset') }}" method="POST" class="reset-form">
                        @csrf
                        <button type="submit" class="btn-reset" onclick="return confirm('Reset hitungan kunjungan?')">
                            <i class="fas fa-sync-alt me-2"></i>Reset Hitungan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards Row 1 -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="stat-card">
                    <div class="stat-icon bg-primary">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="stat-info">
                        <h3>{{ number_format($totalPengajuan) }}</h3>
                        <p>Total Pengajuan</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-card">
                    <div class="stat-icon bg-success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-info">
                        <h3>{{ number_format($totalDisetujui) }}</h3>
                        <p>Disetujui</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-card">
                    <div class="stat-icon bg-warning">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-info">
                        <h3>{{ number_format($totalBelumDisetujui) }}</h3>
                        <p>Pending</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-card">
                    <div class="stat-icon bg-danger">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div class="stat-info">
                        <h3>{{ number_format($totalDitolak) }}</h3>
                        <p>Ditolak</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards Row 2 -->
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <div class="stat-card">
                    <div class="stat-icon bg-info">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <h3>{{ number_format($totalOrganisasi) }}</h3>
                        <p>Total Organisasi</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="stat-card">
                    <div class="stat-icon bg-dark">
                        <i class="fas fa-door-open"></i>
                    </div>
                    <div class="stat-info">
                        <h3>{{ number_format($totalRuangan) }}</h3>
                        <p>Total Ruangan</p>
                    </div>
                </div>
            </div>
        </div>

    <!-- Latest Bookings Table -->
    <div class="row">
        <div class="col-12">
            <div class="section-header">
                <div class="section-title">
                    <i class="fas fa-history me-2"></i>
                    <h4>10 Peminjaman Terbaru</h4>
                </div>
                <a href="{{ route('admin.peminjaman.index') }}" class="btn-view-all">
                    Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>

            <div class="table-card">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Organisasi</th>
                                <th>Ruangan</th>
                                <th>Kegiatan</th>
                                <th>Tgl Pengajuan</th>
                                <th>Waktu</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestBookings as $index => $booking)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <strong>{{ $booking->user->nama_organisasi ?? $booking->user->name }}</strong><br>
                                    <small>{{ $booking->user->jenis_organisasi ?? '-' }}</small>
                                </td>
                                <td>
                                    {{ $booking->ruangan->nama_ruangan }}<br>
                                    <small>Kode: {{ $booking->ruangan->kode_ruangan }}</small>
                                </td>
                                <td>{{ Str::limit($booking->kategori_kegiatan, 30) }}</td>
                                <td>{{ \Carbon\Carbon::parse($booking->tanggal_pengajuan)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($booking->waktu_mulai)->format('d/m/Y H:i') }}</td>
                                <td>
                                    @if($booking->status == 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif($booking->status == 'disetujui')
                                        <span class="badge bg-success">Disetujui</span>
                                    @else
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.peminjaman.show', $booking->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">Belum ada peminjaman</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>

/* Dark mode untuk dashboard table */
.dark-mode .table-light {
    background-color: #0f172a !important;
}
.dark-mode .table-light th {
    background-color: #0f172a !important;
    color: #94a3b8 !important;
}

/* Welcome Card */
.welcome-card {
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 16px;
    padding: 24px;
    color: white;
}
.welcome-title {
    font-size: 22px;
    font-weight: 700;
    margin-bottom: 6px;
}
.welcome-subtitle {
    font-size: 13px;
    opacity: 0.9;
    margin: 0;
}
.welcome-date {
    background: rgba(255,255,255,0.15);
    padding: 8px 16px;
    border-radius: 30px;
    font-size: 13px;
    display: inline-block;
}

/* Info Card */
.info-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    overflow: hidden;
    height: 100%;
}
.info-card-header {
    background: #f8fafc;
    padding: 14px 20px;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    align-items: center;
    gap: 10px;
}
.info-card-header i {
    font-size: 18px;
    color: #667eea;
}
.info-card-header h5 {
    font-size: 15px;
    font-weight: 600;
    margin: 0;
    color: #1f2937;
}
.info-card-body {
    padding: 16px 20px;
}

/* Weather Card */
.weather-main {
    display: flex;
    align-items: baseline;
    gap: 12px;
    margin-bottom: 12px;
}
.weather-temp {
    font-size: 32px;
    font-weight: 700;
    color: #1f2937;
}
.weather-desc {
    font-size: 14px;
    color: #6b7280;
}
.weather-details {
    display: flex;
    gap: 20px;
    font-size: 12px;
    color: #6b7280;
}
.weather-details i {
    width: 20px;
    color: #667eea;
}

/* Visitor Card */
.visitor-stats {
    display: flex;
    justify-content: space-around;
    margin-bottom: 16px;
    text-align: center;
}
.visitor-stat {
    flex: 1;
}
.visitor-number {
    font-size: 28px;
    font-weight: 700;
    color: #1f2937;
}
.visitor-date {
    font-size: 13px;
    font-weight: 600;
    color: #1f2937;
}
.visitor-label {
    font-size: 11px;
    color: #9ca3af;
    margin-top: 4px;
}
.reset-form {
    text-align: center;
}
.btn-reset {
    background: #f3f4f6;
    border: none;
    padding: 8px 20px;
    border-radius: 30px;
    color: #4b5563;
    font-size: 12px;
    cursor: pointer;
    transition: all 0.2s;
}
.btn-reset:hover {
    background: #e5e7eb;
}

/* Stat Cards */
.stat-card {
    background: white;
    border-radius: 16px;
    padding: 18px;
    display: flex;
    align-items: center;
    gap: 15px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    transition: all 0.3s;
    height: 100%;
}
.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}
.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 22px;
}
.stat-icon.bg-primary { background: linear-gradient(135deg, #667eea, #764ba2); }
.stat-icon.bg-success { background: linear-gradient(135deg, #10b981, #059669); }
.stat-icon.bg-warning { background: linear-gradient(135deg, #f59e0b, #d97706); }
.stat-icon.bg-info { background: linear-gradient(135deg, #3b82f6, #2563eb); }
.stat-icon.bg-dark { background: linear-gradient(135deg, #1f2937, #111827); }
.stat-info h3 { font-size: 24px; font-weight: 700; margin: 0; color: #1f2937; }
.stat-info p { margin: 0; font-size: 12px; color: #6b7280; }

/* Section Header */
.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}
.section-title {
    display: flex;
    align-items: center;
    gap: 8px;
}
.section-title i {
    font-size: 20px;
    color: #667eea;
}
.section-title h4 {
    font-size: 16px;
    font-weight: 700;
    margin: 0;
    color: #1f2937;
}
.btn-view-all {
    background: #f3f4f6;
    padding: 6px 16px;
    border-radius: 30px;
    color: #4b5563;
    font-size: 12px;
    text-decoration: none;
    transition: all 0.2s;
}
.btn-view-all:hover {
    background: #e5e7eb;
    color: #1f2937;
}

/* Table */
.table-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    overflow: hidden;
}
.table-modern {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}
.table-modern th {
    padding: 12px 12px;
    background: #f8fafc;
    font-weight: 600;
    color: #1f2937;
    border-bottom: 1px solid #e5e7eb;
}
.table-modern td {
    padding: 12px;
    border-bottom: 1px solid #f0f0f0;
    vertical-align: middle;
}
.table-modern tr:hover {
    background: #f9fafb;
}

/* Badges */
.badge-pending, .badge-approved, .badge-rejected {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
}
.badge-pending { background: #fef3c7; color: #d97706; }
.badge-approved { background: #d1fae5; color: #059669; }
.badge-rejected { background: #fee2e2; color: #dc2626; }

/* Button Detail */
.btn-detail {
    background: #e0f2fe;
    border: none;
    padding: 5px 12px;
    border-radius: 8px;
    color: #0284c7;
    font-size: 11px;
    text-decoration: none;
    transition: all 0.2s;
}
.btn-detail:hover {
    background: #bae6fd;
}

@media (max-width: 768px) {
    .welcome-title { font-size: 18px; }
    .visitor-stats { flex-direction: column; gap: 12px; }
    .weather-main { flex-direction: column; gap: 4px; }
    .section-header { flex-direction: column; align-items: flex-start; gap: 10px; }
    .table-modern { font-size: 11px; }
    .table-modern th, .table-modern td { padding: 8px 6px; }
}
</style>
@endsection
