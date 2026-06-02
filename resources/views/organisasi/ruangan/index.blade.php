@extends('layouts.organisasi')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="header-section mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h2 class="page-title">
                    <i class="fas fa-door-open me-2"></i>Daftar Ruangan
                </h2>
                <p class="page-subtitle">Tersedia {{ $totalRuangan }} ruangan yang dapat dipinjam</p>
            </div>
            <div class="search-box">
                <form action="{{ route('organisasi.ruangan.index') }}" method="GET" class="d-flex gap-2">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-start-0"
                               placeholder="Cari ruangan atau lokasi..." value="{{ request('search') }}">
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-2"></i>Cari
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section mb-4">
        <div class="filter-card">
            <form method="GET" action="{{ route('organisasi.ruangan.index') }}" id="filterForm">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="filter-label">Kapasitas Minimal</label>
                        <select name="kapasitas" class="form-select filter-select" id="filterKapasitas">
                            <option value="">Semua Kapasitas</option>
                            <option value="50" {{ request('kapasitas') == '50' ? 'selected' : '' }}>≥ 50 orang</option>
                            <option value="100" {{ request('kapasitas') == '100' ? 'selected' : '' }}>≥ 100 orang</option>
                            <option value="200" {{ request('kapasitas') == '200' ? 'selected' : '' }}>≥ 200 orang</option>
                            <option value="300" {{ request('kapasitas') == '300' ? 'selected' : '' }}>≥ 300 orang</option>
                            <option value="500" {{ request('kapasitas') == '500' ? 'selected' : '' }}>≥ 500 orang</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="filter-label">Fasilitas</label>
                        <select name="fasilitas" class="form-select filter-select" id="filterFasilitas">
                            <option value="">Semua Fasilitas</option>
                            <option value="ac" {{ request('fasilitas') == 'ac' ? 'selected' : '' }}>❄️ AC</option>
                            <option value="proyektor" {{ request('fasilitas') == 'proyektor' ? 'selected' : '' }}>📽️ Proyektor</option>
                            <option value="whiteboard" {{ request('fasilitas') == 'whiteboard' ? 'selected' : '' }}>✍️ Whiteboard</option>
                            <option value="sound" {{ request('fasilitas') == 'sound' ? 'selected' : '' }}>🔊 Sound System</option>
                            <option value="wifi" {{ request('fasilitas') == 'wifi' ? 'selected' : '' }}>📡 WiFi</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="filter-label">Status</label>
                        <select name="status" class="form-select filter-select" id="filterStatus">
                            <option value="">Semua Status</option>
                            <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>🟢 Tersedia</option>
                            <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>🟡 Dipinjam</option>
                            <option value="perbaikan" {{ request('status') == 'perbaikan' ? 'selected' : '' }}>🔴 Perbaikan</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <div class="d-flex gap-2 w-100">
                            <button type="submit" class="btn btn-filter w-100" id="btnFilter">
                                <i class="fas fa-sliders-h me-2"></i>Terapkan Filter
                            </button>
                            <button type="button" class="btn btn-reset" id="btnReset">
                                <i class="fas fa-undo-alt me-2"></i>Reset
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Total Result -->
    <div class="total-result mb-3">
        <p>Menampilkan <strong>{{ $ruangans->total() }}</strong> dari <strong>{{ $totalRuangan }}</strong> ruangan</p>
    </div>

    <!-- Ruangan Cards Grid -->
    <div class="row">
        @forelse($ruangans as $ruangan)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="ruangan-card">
                <!-- Card Image -->
                <div class="ruangan-card-image">
                    @if($ruangan->foto && file_exists(public_path($ruangan->foto)))
                        <img src="{{ asset($ruangan->foto) }}" alt="{{ $ruangan->nama_ruangan }}">
                    @elseif($ruangan->foto && file_exists(storage_path('app/public/ruangan/' . $ruangan->foto)))
                        <img src="{{ asset('storage/ruangan/' . $ruangan->foto) }}" alt="{{ $ruangan->nama_ruangan }}">
                    @else
                        <div class="image-placeholder">
                            <i class="fas fa-door-open fa-4x"></i>
                        </div>
                    @endif

                    <!-- Status Badge -->
                    @if($ruangan->status == 'tersedia')
                        <span class="status-badge status-tersedia">
                            <i class="fas fa-check-circle me-1"></i>Tersedia
                        </span>
                    @elseif($ruangan->status == 'dipinjam')
                        <span class="status-badge status-dipinjam">
                            <i class="fas fa-clock me-1"></i>Dipinjam
                        </span>
                    @else
                        <span class="status-badge status-perbaikan">
                            <i class="fas fa-tools me-1"></i>Perbaikan
                        </span>
                    @endif
                </div>

                <!-- Card Body -->
                <div class="ruangan-card-body">
                    <h4 class="ruangan-title">{{ $ruangan->nama_ruangan }}</h4>
                    <p class="ruangan-code">Kode: {{ $ruangan->kode_ruangan }}</p>

                    <div class="ruangan-details">
                        <div class="detail-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $ruangan->lokasi }}</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-users"></i>
                            <span>Kapasitas: <strong>{{ $ruangan->kapasitas }}</strong> orang</span>
                        </div>
                    </div>

                    <!-- Fasilitas -->
                    <div class="fasilitas-section">
                        <p class="fasilitas-label">Fasilitas:</p>
                        <div class="fasilitas-list">
                            @php
                                $fasilitasArray = $ruangan->fasilitas ? explode(',', $ruangan->fasilitas) : [];
                            @endphp
                            @if(count($fasilitasArray) > 0)
                                @foreach($fasilitasArray as $fasilitas)
                                    <span class="fasilitas-item">
                                        @if(str_contains(strtolower($fasilitas), 'ac'))
                                            ❄️
                                        @elseif(str_contains(strtolower($fasilitas), 'proyektor'))
                                            📽️
                                        @elseif(str_contains(strtolower($fasilitas), 'whiteboard'))
                                            ✍️
                                        @elseif(str_contains(strtolower($fasilitas), 'sound'))
                                            🔊
                                        @elseif(str_contains(strtolower($fasilitas), 'wifi'))
                                            📡
                                        @else
                                            📌
                                        @endif
                                        {{ trim($fasilitas) }}
                                    </span>
                                @endforeach
                            @else
                                <span class="text-muted small">Tidak ada fasilitas tercantum</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Card Footer -->
                <div class="ruangan-card-footer">
                    @if($ruangan->status == 'tersedia')
                        <button class="btn-booking" onclick="bookingRuangan({{ $ruangan->id }}, '{{ $ruangan->nama_ruangan }}')">
                            <i class="fas fa-calendar-plus me-2"></i>Booking Sekarang
                        </button>
                    @else
                        <button class="btn-disabled" disabled>
                            <i class="fas fa-ban me-2"></i>Tidak Tersedia
                        </button>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="empty-state">
                <i class="fas fa-door-closed fa-5x text-muted mb-3"></i>
                <h4>Tidak ada ruangan ditemukan</h4>
                <p class="text-muted">Coba ubah kata kunci pencarian atau filter yang Anda gunakan</p>
                <button class="btn btn-primary mt-3" onclick="location.href='{{ route('organisasi.ruangan.index') }}'">
                    <i class="fas fa-sync-alt me-2"></i>Refresh Halaman
                </button>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination Modern -->
    <div class="pagination-wrapper mt-4">
        @if ($ruangans->hasPages())
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($ruangans->onFirstPage())
                    <li class="disabled"><span><i class="fas fa-chevron-left"></i> Prev</span></li>
                @else
                    <li><a href="{{ $ruangans->previousPageUrl() }}" rel="prev"><i class="fas fa-chevron-left"></i> Prev</a></li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($ruangans->getUrlRange(1, $ruangans->lastPage()) as $page => $url)
                    @if ($page == $ruangans->currentPage())
                        <li class="active"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($ruangans->hasMorePages())
                    <li><a href="{{ $ruangans->nextPageUrl() }}" rel="next">Next <i class="fas fa-chevron-right"></i></a></li>
                @else
                    <li class="disabled"><span>Next <i class="fas fa-chevron-right"></i></span></li>
                @endif
            </ul>
        @endif
    </div>
</div>

<style>
    /* Header Section */
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
    .search-box .form-control:focus {
        box-shadow: none;
        border-color: #667eea;
    }
    .search-box .btn-primary {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border: none;
        border-radius: 12px;
        padding: 10px 20px;
        font-weight: 600;
    }

    /* Filter Section */
    .filter-section {
        margin-bottom: 20px;
    }
    .filter-card {
        background: white;
        border-radius: 20px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
    }
    body.dark-mode .filter-card {
        background-color: #1e293b !important;
    }
    .filter-label {
        font-size: 12px;
        font-weight: 600;
        color: #4b5563;
        margin-bottom: 6px;
        display: block;
    }
    body.dark-mode .filter-label {
        color: #94a3b8 !important;
    }
    .filter-select {
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        padding: 10px 12px;
        font-size: 14px;
    }
    body.dark-mode .filter-select {
        background-color: #334155 !important;
        border-color: #475569 !important;
        color: #e0e0e0 !important;
    }
    .filter-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102,126,234,0.1);
    }
    .btn-filter {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border: none;
        border-radius: 12px;
        padding: 10px;
        color: white;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-filter:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102,126,234,0.4);
    }
    .btn-reset {
        background: #f3f4f6;
        border: none;
        border-radius: 12px;
        padding: 10px;
        color: #4b5563;
        font-weight: 600;
        transition: all 0.3s;
    }
    body.dark-mode .btn-reset {
        background-color: #334155 !important;
        color: #cbd5e1 !important;
    }
    .btn-reset:hover {
        background: #e5e7eb;
    }
    body.dark-mode .btn-reset:hover {
        background-color: #475569 !important;
    }

    /* Total Result */
    .total-result p {
        font-size: 13px;
        color: #6b7280;
        margin: 0;
    }
    body.dark-mode .total-result p {
        color: #94a3b8 !important;
    }

    /* Ruangan Card */
    .ruangan-card {
        background: white;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.06);
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    body.dark-mode .ruangan-card {
        background-color: #1e293b !important;
    }
    .ruangan-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.12);
    }
    .ruangan-card-image {
        position: relative;
        height: 200px;
        overflow: hidden;
        background: linear-gradient(135deg, #667eea, #764ba2);
    }
    .ruangan-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .ruangan-card:hover .ruangan-card-image img {
        transform: scale(1.05);
    }
    .image-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(255,255,255,0.8);
    }
    .status-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        padding: 6px 14px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
        backdrop-filter: blur(4px);
    }
    .status-tersedia {
        background: rgba(16,185,129,0.9);
        color: white;
    }
    .status-dipinjam {
        background: rgba(245,158,11,0.9);
        color: white;
    }
    .status-perbaikan {
        background: rgba(239,68,68,0.9);
        color: white;
    }
    body.dark-mode .status-tersedia {
        background: #065f46 !important;
    }
    body.dark-mode .status-dipinjam {
        background: #78350f !important;
    }
    body.dark-mode .status-perbaikan {
        background: #7f1d1d !important;
    }
    .ruangan-card-body {
        padding: 20px;
        flex: 1;
    }
    .ruangan-title {
        font-size: 18px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 4px;
    }
    body.dark-mode .ruangan-title {
        color: #e0e0e0 !important;
    }
    .ruangan-code {
        font-size: 12px;
        color: #9ca3af;
        margin-bottom: 12px;
        font-family: monospace;
    }
    body.dark-mode .ruangan-code {
        color: #94a3b8 !important;
    }
    .ruangan-details {
        margin-bottom: 16px;
    }
    .detail-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 8px;
    }
    body.dark-mode .detail-item {
        color: #94a3b8 !important;
    }
    .detail-item i {
        width: 18px;
        color: #667eea;
    }
    body.dark-mode .detail-item i {
        color: #818cf8 !important;
    }
    .fasilitas-section {
        margin-top: 12px;
        padding-top: 12px;
        border-top: 1px solid #f0f0f0;
    }
    body.dark-mode .fasilitas-section {
        border-top-color: #334155 !important;
    }
    .fasilitas-label {
        font-size: 11px;
        font-weight: 600;
        color: #9ca3af;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    body.dark-mode .fasilitas-label {
        color: #64748b !important;
    }
    .fasilitas-list {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    .fasilitas-item {
        background: #f3f4f6;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        color: #4b5563;
    }
    body.dark-mode .fasilitas-item {
        background-color: #334155 !important;
        color: #cbd5e1 !important;
    }
    .ruangan-card-footer {
        padding: 16px 20px 20px;
        border-top: 1px solid #f0f0f0;
    }
    body.dark-mode .ruangan-card-footer {
        border-top-color: #334155 !important;
    }
    .btn-booking {
        width: 100%;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border: none;
        padding: 12px;
        border-radius: 14px;
        color: white;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s;
        cursor: pointer;
    }
    .btn-booking:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(102,126,234,0.4);
    }
    .btn-disabled {
        width: 100%;
        background: #e5e7eb;
        border: none;
        padding: 12px;
        border-radius: 14px;
        color: #9ca3af;
        font-weight: 600;
        font-size: 14px;
        cursor: not-allowed;
    }
    body.dark-mode .btn-disabled {
        background-color: #334155 !important;
        color: #64748b !important;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 24px;
    }
    body.dark-mode .empty-state {
        background-color: #1e293b !important;
    }
    body.dark-mode .empty-state h4,
    body.dark-mode .empty-state p {
        color: #e0e0e0 !important;
    }

    /* Pagination Modern */
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }
    .pagination {
        display: flex;
        gap: 8px;
        list-style: none;
        margin: 0;
        padding: 0;
        flex-wrap: wrap;
        justify-content: center;
    }
    .pagination li a,
    .pagination li span {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 38px;
        height: 38px;
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
        background: linear-gradient(135deg, #818cf8, #a78bfa) !important;
    }
    .pagination li.disabled span {
        opacity: 0.5;
        cursor: not-allowed;
        background: #f9fafb;
    }
    body.dark-mode .pagination li.disabled span {
        background-color: #1e293b !important;
        color: #64748b !important;
    }
    .pagination li a i,
    .pagination li span i {
        font-size: 11px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-title { font-size: 22px; }
        .search-box { min-width: 100%; width: 100%; }
        .header-section .d-flex { flex-direction: column; }
        .filter-card { padding: 15px; }
        .ruangan-card-image { height: 170px; }
        .ruangan-title { font-size: 16px; }
        .pagination li a,
        .pagination li span { min-width: 32px; height: 32px; padding: 0 8px; font-size: 12px; }
    }
</style>

<script>
    // Filter functionality
    document.getElementById('btnFilter').addEventListener('click', function() {
        let url = new URL(window.location.href);
        let params = new URLSearchParams();

        let kapasitas = document.getElementById('filterKapasitas').value;
        let fasilitas = document.getElementById('filterFasilitas').value;
        let status = document.getElementById('filterStatus').value;
        let search = document.querySelector('input[name="search"]').value;

        if (search) params.set('search', search);
        if (kapasitas) params.set('kapasitas', kapasitas);
        if (fasilitas) params.set('fasilitas', fasilitas);
        if (status) params.set('status', status);

        window.location.href = '{{ route("organisasi.ruangan.index") }}?' + params.toString();
    });

    // Reset filter
    document.getElementById('btnReset').addEventListener('click', function() {
        window.location.href = '{{ route("organisasi.ruangan.index") }}';
    });
    // Booking function
    function bookingRuangan(ruanganId, ruanganName) {
        window.location.href = '{{ route("organisasi.booking.create", "") }}/' + ruanganId;
        if (typeof showSuccessNotification === 'function') {
            showSuccessNotification('Ruangan "' + ruanganName + '" dipilih, silakan lengkapi formulir.');
        }
    }

    // Enter key search
    document.querySelector('input[name="search"]').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            document.getElementById('filterForm').submit();
        }
    });
</script>
@endsection
