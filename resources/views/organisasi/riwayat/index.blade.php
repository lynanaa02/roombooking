@extends('layouts.organisasi')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="header-section mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h2 class="page-title">
                    <i class="fas fa-history me-2"></i>Riwayat Peminjaman
                </h2>
                <p class="page-subtitle">Daftar peminjaman ruangan yang telah Anda ajukan</p>
            </div>
            <div class="search-box">
                <form action="{{ route('organisasi.riwayat.index') }}" method="GET" class="d-flex gap-2">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-start-0"
                               placeholder="Cari berdasarkan ruangan atau kegiatan..." value="{{ request('search') }}">
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-2"></i>Cari
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Filter Status -->
    <div class="filter-section mb-4">
        <div class="filter-card">
            <div class="d-flex gap-2 flex-wrap align-items-center">
                <label class="filter-label me-2">Status:</label>
                <a href="{{ route('organisasi.riwayat.index') }}" class="filter-badge {{ !request('status') ? 'active' : '' }}">Semua</a>
                <a href="{{ route('organisasi.riwayat.index', ['status' => 'pending']) }}" class="filter-badge {{ request('status') == 'pending' ? 'active' : '' }}">
                    <i class="fas fa-clock me-1"></i>Pending
                </a>
                <a href="{{ route('organisasi.riwayat.index', ['status' => 'disetujui']) }}" class="filter-badge {{ request('status') == 'disetujui' ? 'active' : '' }}">
                    <i class="fas fa-check-circle me-1"></i>Disetujui
                </a>
                <a href="{{ route('organisasi.riwayat.index', ['status' => 'ditolak']) }}" class="filter-badge {{ request('status') == 'ditolak' ? 'active' : '' }}">
                    <i class="fas fa-times-circle me-1"></i>Ditolak
                </a>
            </div>
        </div>
    </div>

    <!-- Statistik -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="stats-card">
                <div class="stats-icon bg-primary">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="stats-info">
                    <h3>{{ $totalPengajuan ?? 0 }}</h3>
                    <p>Total Pengajuan</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card">
                <div class="stats-icon bg-warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stats-info">
                    <h3>{{ $totalPending ?? 0 }}</h3>
                    <p>Menunggu</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card">
                <div class="stats-icon bg-success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stats-info">
                    <h3>{{ $totalDisetujui ?? 0 }}</h3>
                    <p>Disetujui</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card">
                <div class="stats-icon bg-danger">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stats-info">
                    <h3>{{ $totalDitolak ?? 0 }}</h3>
                    <p>Ditolak</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Riwayat -->
    <div class="table-card">
        <div class="table-responsive">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th class="text-center" width="5%">No</th>
                        <th width="15%">Ruangan</th>
                        <th width="15%">Kegiatan</th>
                        <th width="10%" class="text-center">Tanggal Pinjam</th>
                        <th width="15%" class="text-center">Waktu</th>
                        <th width="8%" class="text-center">Durasi</th>
                        <th width="10%" class="text-center">Tgl Pengajuan</th>
                        <th width="10%" class="text-center">Status</th>
                        <th width="12%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayat as $index => $booking)
                    <tr>
                        <td class="text-center">{{ $riwayat->firstItem() + $index }}</td>
                        <td>
                            <strong>{{ $booking->ruangan->nama_ruangan ?? '-' }}</strong><br>
                            <small class="text-muted">Kode: {{ $booking->ruangan->kode_ruangan ?? '-' }}</small>
                        </td>
                        <td>
                            <strong>{{ $booking->kategori_kegiatan ?? '-' }}</strong><br>
                            <small class="text-muted">{{ \Str::limit($booking->keterangan_tambahan ?? '-', 30) }}</small>
                        </td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($booking->tanggal_pinjam)->format('d/m/Y') }}</td>
                        <td class="text-center">
                            {{ \Carbon\Carbon::parse($booking->waktu_mulai)->format('H:i') }}<br>
                            <small>s/d {{ \Carbon\Carbon::parse($booking->waktu_selesai)->format('H:i') }}</small>
                        </td>
                        <td class="text-center">
                            @php
                                $start = \Carbon\Carbon::parse($booking->waktu_mulai);
                                $end = \Carbon\Carbon::parse($booking->waktu_selesai);
                                $hours = $start->diffInHours($end);
                                $minutes = $start->diffInMinutes($end) % 60;
                            @endphp
                            {{ $hours }} jam {{ $minutes > 0 ? $minutes . ' menit' : '' }}
                        </td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($booking->tanggal_pengajuan)->format('d/m/Y') }}</td>
                        <td class="text-center">
                            @if($booking->status == 'pending')
                                <span class="status-badge pending">
                                    <i class="fas fa-clock me-1"></i>Pending
                                </span>
                            @elseif($booking->status == 'disetujui')
                                <span class="status-badge approved">
                                    <i class="fas fa-check-circle me-1"></i>Disetujui
                                </span>
                            @else
                                <span class="status-badge rejected">
                                    <i class="fas fa-times-circle me-1"></i>Ditolak
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="action-buttons">
                                {{-- TOMBOL DETAIL DIARAHKAN KE HALAMAN SHOW --}}
                                <a href="{{ route('organisasi.booking.show', $booking->id) }}" class="btn-action btn-detail" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($booking->status == 'pending')
                                    <button class="btn-action btn-cancel" onclick="cancelBooking({{ $booking->id }}, '{{ $booking->ruangan->nama_ruangan ?? '-' }}')" title="Batalkan">
                                        <i class="fas fa-ban"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                                    <h5>Belum Ada Riwayat Peminjaman</h5>
                                    <p>Anda belum pernah mengajukan peminjaman ruangan</p>
                                    <a href="{{ route('organisasi.ruangan.index') }}" class="btn-primary-custom">
                                        <i class="fas fa-calendar-plus me-2"></i>Booking Sekarang
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination-wrapper">
            {{ $riwayat->appends(request()->query())->links() }}
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Batal (Tetap ada untuk cancel) -->
<div id="cancelModal" class="modal-custom" style="display: none;">
    <div class="modal-custom-content" style="max-width: 400px;">
        <div class="modal-cancel-icon warning">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h3>Batalkan Peminjaman</h3>
        <p id="cancelMessage">Apakah Anda yakin ingin membatalkan peminjaman ini?</p>
        <div class="modal-cancel-buttons">
            <button class="btn-cancel-modal" onclick="closeCancelModal()">Batal</button>
            <form id="cancelForm" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-confirm-cancel">Ya, Batalkan</button>
            </form>
        </div>
    </div>
</div>

<style>
    /* Header */
    .header-section {
        margin-bottom: 24px;
    }
    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 4px;
    }
    body.dark-mode .page-title {
        color: #e0e0e0 !important;
    }
    .page-subtitle {
        font-size: 14px;
        color: #6b7280;
        margin: 0;
    }
    body.dark-mode .page-subtitle {
        color: #94a3b8 !important;
    }

    /* Search Box */
    .search-box {
        min-width: 320px;
    }
    .search-box .input-group-text {
        border-radius: 12px 0 0 12px;
        border-right: none;
    }
    body.dark-mode .search-box .input-group-text,
    body.dark-mode .search-box .form-control {
        background-color: #334155 !important;
        border-color: #475569 !important;
        color: #e0e0e0 !important;
    }
    .search-box .form-control {
        border-radius: 0 12px 12px 0;
        border-left: none;
    }
    .search-box .btn-primary {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border: none;
        border-radius: 12px;
        padding: 10px 20px;
        font-weight: 600;
    }
    body.dark-mode .search-box .btn-primary {
        background: linear-gradient(135deg, #1e3c72, #2a5298) !important;
    }

    /* Filter Section */
    .filter-section {
        margin-bottom: 20px;
    }
    .filter-card {
        background: white;
        border-radius: 16px;
        padding: 16px 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    body.dark-mode .filter-card {
        background-color: #1e293b !important;
    }
    .filter-label {
        font-size: 13px;
        font-weight: 600;
        color: #4b5563;
    }
    body.dark-mode .filter-label {
        color: #94a3b8 !important;
    }
    .filter-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 16px;
        border-radius: 30px;
        background: #f3f4f6;
        color: #4b5563;
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.2s;
    }
    body.dark-mode .filter-badge {
        background-color: #334155 !important;
        color: #cbd5e1 !important;
    }
    .filter-badge:hover {
        background: #e5e7eb;
        color: #1f2937;
    }
    body.dark-mode .filter-badge:hover {
        background-color: #475569 !important;
        color: white !important;
    }
    .filter-badge.active {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
    }
    body.dark-mode .filter-badge.active {
        background: linear-gradient(135deg, #1e3c72, #2a5298) !important;
    }

    /* Stats Cards */
    .stats-card {
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
    body.dark-mode .stats-card {
        background-color: #1e293b !important;
    }
    .stats-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }
    .stats-icon {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 22px;
    }
    .stats-icon.bg-primary { background: linear-gradient(135deg, #667eea, #764ba2); }
    .stats-icon.bg-warning { background: linear-gradient(135deg, #f59e0b, #d97706); }
    .stats-icon.bg-success { background: linear-gradient(135deg, #10b981, #059669); }
    .stats-icon.bg-danger { background: linear-gradient(135deg, #ef4444, #dc2626); }
    body.dark-mode .stats-icon.bg-primary { background: linear-gradient(135deg, #1e3c72, #2a5298) !important; }
    .stats-info h3 {
        font-size: 24px;
        font-weight: 700;
        margin: 0;
        color: #1f2937;
    }
    body.dark-mode .stats-info h3 {
        color: #e0e0e0 !important;
    }
    .stats-info p {
        margin: 0;
        font-size: 12px;
        color: #6b7280;
    }
    body.dark-mode .stats-info p {
        color: #94a3b8 !important;
    }

    /* Table */
    .table-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    body.dark-mode .table-card {
        background-color: #1e293b !important;
    }
    .table-modern {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }
    .table-modern th {
        padding: 14px 12px;
        background: #f8fafc;
        font-weight: 600;
        color: #1f2937;
        border-bottom: 1px solid #e5e7eb;
    }
    body.dark-mode .table-modern th {
        background-color: #0f172a !important;
        color: #94a3b8 !important;
    }
    .table-modern td {
        padding: 12px;
        border-bottom: 1px solid #f0f0f0;
        vertical-align: middle;
    }
    body.dark-mode .table-modern td {
        color: #cbd5e1 !important;
        border-bottom-color: #334155 !important;
    }
    .table-modern tr:hover {
        background: #f9fafb;
    }
    body.dark-mode .table-modern tr:hover {
        background-color: #334155 !important;
    }

    /* Status Badge */
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }
    .status-badge.pending {
        background: #fef3c7;
        color: #d97706;
    }
    .status-badge.approved {
        background: #d1fae5;
        color: #059669;
    }
    .status-badge.rejected {
        background: #fee2e2;
        color: #dc2626;
    }
    body.dark-mode .status-badge.pending {
        background: #78350f !important;
        color: #fde68a !important;
    }
    body.dark-mode .status-badge.approved {
        background: #065f46 !important;
        color: #86efac !important;
    }
    body.dark-mode .status-badge.rejected {
        background: #7f1d1d !important;
        color: #fca5a5 !important;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 6px;
        justify-content: center;
    }
    .btn-action {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
        font-size: 14px;
        text-decoration: none;
    }
    .btn-detail {
        background: #e0f2fe;
        color: #0284c7;
    }
    .btn-detail:hover {
        background: #bae6fd;
        transform: translateY(-2px);
        color: #0284c7;
    }
    .btn-cancel {
        background: #fee2e2;
        color: #dc2626;
    }
    .btn-cancel:hover {
        background: #fecaca;
        transform: translateY(-2px);
    }
    body.dark-mode .btn-detail {
        background-color: #0e7490 !important;
        color: #7dd3fc !important;
    }
    body.dark-mode .btn-cancel {
        background-color: #7f1d1d !important;
        color: #fca5a5 !important;
    }

    /* Pagination */
    .pagination-wrapper {
        padding: 20px;
        border-top: 1px solid #e5e7eb;
        display: flex;
        justify-content: center;
    }
    body.dark-mode .pagination-wrapper {
        border-top-color: #334155 !important;
    }
    .pagination {
        display: flex;
        gap: 6px;
        list-style: none;
        margin: 0;
        padding: 0;
        flex-wrap: wrap;
        justify-content: center;
    }
    .pagination li a, .pagination li span {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        height: 36px;
        padding: 0 12px;
        background: #f3f4f6;
        border-radius: 10px;
        color: #4b5563;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s;
        cursor: pointer;
    }
    body.dark-mode .pagination li a,
    body.dark-mode .pagination li span {
        background-color: #334155 !important;
        color: #cbd5e1 !important;
    }
    .pagination li a:hover {
        background: #e5e7eb;
        color: #1f2937;
    }
    body.dark-mode .pagination li a:hover {
        background-color: #475569 !important;
        color: white !important;
    }
    .pagination li.active span {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
    }
    body.dark-mode .pagination li.active span {
        background: linear-gradient(135deg, #1e3c72, #2a5298) !important;
    }

    /* Modal Cancel */
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
        border-radius: 20px;
        width: 90%;
        max-width: 400px;
        text-align: center;
        animation: modalFadeIn 0.2s ease;
    }
    body.dark-mode .modal-custom-content {
        background-color: #1e293b !important;
    }
    .modal-cancel-icon {
        width: 65px;
        height: 65px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin: 20px auto 12px;
    }
    .modal-cancel-icon i {
        font-size: 32px;
    }
    .modal-cancel-icon.warning {
        background: #fef3c7;
        color: #d97706;
    }
    body.dark-mode .modal-cancel-icon.warning {
        background: #78350f !important;
        color: #fde68a !important;
    }
    .modal-custom-content h3 {
        font-size: 20px;
        margin-bottom: 8px;
        color: #1f2937;
    }
    body.dark-mode .modal-custom-content h3 {
        color: #e0e0e0 !important;
    }
    .modal-custom-content p {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 20px;
    }
    body.dark-mode .modal-custom-content p {
        color: #94a3b8 !important;
    }
    .modal-cancel-buttons {
        display: flex;
        gap: 12px;
        justify-content: center;
        padding: 16px 20px 20px;
        border-top: 1px solid #e5e7eb;
    }
    body.dark-mode .modal-cancel-buttons {
        border-top-color: #334155 !important;
    }
    .btn-cancel-modal, .btn-confirm-cancel {
        padding: 8px 20px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
        flex: 1;
    }
    .btn-cancel-modal {
        background: #f3f4f6;
        color: #4b5563;
    }
    body.dark-mode .btn-cancel-modal {
        background-color: #334155 !important;
        color: #cbd5e1 !important;
    }
    .btn-cancel-modal:hover {
        background: #e5e7eb;
    }
    .btn-confirm-cancel {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
    }
    body.dark-mode .btn-confirm-cancel {
        background: linear-gradient(135deg, #7f1d1d, #991b1b) !important;
    }
    .btn-confirm-cancel:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220,38,38,0.3);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 20px;
    }
    body.dark-mode .empty-state {
        background-color: #1e293b !important;
    }
    .empty-state i {
        font-size: 64px;
        margin-bottom: 20px;
        color: #9ca3af;
    }
    body.dark-mode .empty-state i {
        color: #64748b;
    }
    .empty-state h5 {
        font-size: 20px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 8px;
    }
    body.dark-mode .empty-state h5 {
        color: #e0e0e0 !important;
    }
    .empty-state p {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 24px;
    }
    body.dark-mode .empty-state p {
        color: #94a3b8 !important;
    }
    .btn-primary-custom {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border: none;
        padding: 12px 32px;
        border-radius: 12px;
        color: white;
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
    }
    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102,126,234,0.4);
        color: white;
    }
    body.dark-mode .btn-primary-custom {
        background: linear-gradient(135deg, #1e3c72, #2a5298) !important;
    }

    @keyframes modalFadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    @media (max-width: 768px) {
        .page-title { font-size: 22px; }
        .search-box { min-width: 100%; width: 100%; }
        .stats-card { padding: 15px; }
        .stats-icon { width: 45px; height: 45px; font-size: 20px; }
        .stats-info h3 { font-size: 22px; }
        .table-modern th, .table-modern td { padding: 8px; font-size: 11px; }
        .filter-badge { padding: 4px 12px; font-size: 12px; }
        .action-buttons { gap: 4px; }
        .btn-action { width: 28px; height: 28px; font-size: 12px; }
    }
</style>

<script>
    // ========================================
    // CANCEL BOOKING
    // ========================================
    function cancelBooking(id, roomName) {
        document.getElementById('cancelMessage').innerHTML = `Apakah Anda yakin ingin membatalkan peminjaman ruangan <strong>"${escapeHtml(roomName)}"</strong>?`;
        document.getElementById('cancelModal').style.display = 'flex';
        document.getElementById('cancelForm').action = `/organisasi/booking/${id}/cancel`;
    }

    function closeCancelModal() {
        document.getElementById('cancelModal').style.display = 'none';
    }

    // ========================================
    // ESCAPE HTML
    // ========================================
    function escapeHtml(str) {
        if (!str) return '';
        return str.replace(/[&<>]/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            return m;
        });
    }

    // ========================================
    // CLICK OUTSIDE MODAL
    // ========================================
    window.onclick = function(event) {
        const cancelModal = document.getElementById('cancelModal');
        if (event.target === cancelModal) closeCancelModal();
    }
</script>
@endsection
