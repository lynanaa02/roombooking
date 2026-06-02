@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3><i class="fas fa-door-open me-2"></i>Kelola Ruangan</h3>
        <a href="{{ route('admin.ruangan.create') }}" class="btn-custom">
            <i class="fas fa-plus me-2"></i>Tambah Ruangan
        </a>
    </div>

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

    <!-- Search Form -->
    <div class="search-card">
        <form method="GET" action="{{ route('admin.ruangan.index') }}" class="search-form">
            <div class="search-wrapper">
                <i class="fas fa-search search-icon"></i>
                <input type="text" name="search" class="search-input" placeholder="Cari ruangan berdasarkan nama, kode, atau lokasi..." value="{{ request('search') }}">
                <button type="submit" class="search-btn">
                    <i class="fas fa-search"></i> Cari
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.ruangan.index') }}" class="search-reset">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </div>
        </form>
        @if(request('search'))
            <div class="search-info">
                <i class="fas fa-search me-1"></i> Menampilkan hasil pencarian: "<strong>{{ request('search') }}</strong>"
                <a href="{{ route('admin.ruangan.index') }}" class="ms-2 text-danger">Reset</a>
            </div>
        @endif
    </div>

    <!-- Table Container -->
    <div id="tableContainer">
        @include('admin.ruangan._table_rows', ['ruangans' => $ruangans])
    </div>
</div>

<style>
    .btn-custom {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border: none;
        padding: 10px 24px;
        border-radius: 12px;
        color: white;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
    }
    .btn-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102,126,234,0.4);
        color: white;
    }
    .search-card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        margin-bottom: 20px;
    }
    .search-form {
        width: 100%;
    }
    .search-wrapper {
        position: relative;
        display: flex;
        gap: 10px;
        align-items: center;
    }
    .search-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        font-size: 16px;
        pointer-events: none;
    }
    .search-input {
        flex: 1;
        padding: 12px 50px 12px 45px;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        font-size: 14px;
        transition: all 0.2s;
    }
    .search-input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102,126,234,0.1);
    }
    .search-btn {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border: none;
        padding: 0 24px;
        border-radius: 12px;
        color: white;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        height: 46px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .search-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102,126,234,0.4);
    }
    .search-reset {
        position: absolute;
        right: 150px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #9ca3af;
        cursor: pointer;
        font-size: 16px;
        padding: 5px;
        text-decoration: none;
    }
    .search-reset:hover {
        color: #ef4444;
    }
    .search-info {
        font-size: 13px;
        color: #6b7280;
        margin-top: 12px;
        padding-top: 10px;
        border-top: 1px solid #f0f0f0;
        text-align: left;
    }
    .search-info a {
        text-decoration: none;
    }
</style>

<!-- Modal Detail Ruangan -->
<div id="detailModal" class="modal-modern" style="display: none;">
    <div class="modal-modern-content">
        <div class="modal-modern-header">
            <h4><i class="fas fa-door-open me-2"></i>Detail Ruangan</h4>
            <button onclick="closeDetailModal()" class="modal-modern-close">&times;</button>
        </div>
        <div class="modal-modern-body" id="modalDetailContent">
            <div class="text-center py-5">
                <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
                <p class="mt-2">Memuat data...</p>
            </div>
        </div>
        <div class="modal-modern-footer">
            <button onclick="closeDetailModal()" class="btn-modal-close">Tutup</button>
        </div>
    </div>
</div>

<style>
    .modal-modern {
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
    .modal-modern-content {
        background: white;
        border-radius: 24px;
        width: 90%;
        max-width: 750px;
        max-height: 85vh;
        overflow: auto;
        animation: modalFadeIn 0.3s ease;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
    .modal-modern-header {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 20px 24px;
        border-radius: 24px 24px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: sticky;
        top: 0;
    }
    .modal-modern-header h4 { margin: 0; font-size: 18px; font-weight: 600; }
    .modal-modern-close {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        font-size: 24px;
        color: white;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .modal-modern-close:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: scale(1.05);
    }
    .modal-modern-body { padding: 28px; }
    .modal-modern-footer {
        padding: 16px 24px;
        border-top: 1px solid #e5e7eb;
        text-align: right;
        background: white;
        border-radius: 0 0 24px 24px;
    }
    .btn-modal-close {
        background: #f3f4f6;
        border: none;
        padding: 10px 24px;
        border-radius: 12px;
        color: #4b5563;
        font-weight: 600;
        cursor: pointer;
    }
    .modal-info-card {
        background: #f8fafc;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .modal-info-title {
        font-size: 16px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 16px;
        padding-bottom: 8px;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .modal-info-title i { color: #667eea; }
    .modal-info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }
    .modal-info-item {
        display: flex;
        flex-direction: column;
    }
    .modal-info-label {
        font-size: 11px;
        color: #9ca3af;
        margin-bottom: 4px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .modal-info-value {
        font-size: 14px;
        font-weight: 600;
        color: #1f2937;
        word-break: break-word;
    }
    .modal-foto {
        text-align: center;
        margin-bottom: 24px;
    }
    .modal-foto-img {
        width: 120px;
        height: 120px;
        border-radius: 12px;
        object-fit: cover;
        border: 3px solid #667eea;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .modal-foto-placeholder {
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .modal-foto-placeholder i { font-size: 48px; color: white; }
    .badge-status-tersedia { background: #d1fae5; color: #059669; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; display: inline-block; }
    .badge-status-dipinjam { background: #fef3c7; color: #d97706; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; display: inline-block; }
    .badge-status-perbaikan { background: #fee2e2; color: #dc2626; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; display: inline-block; }
    @keyframes modalFadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }
    @media (max-width: 768px) {
        .modal-info-grid { grid-template-columns: 1fr; gap: 12px; }
        .modal-modern-body { padding: 20px; }
        .search-wrapper { flex-direction: column; }
        .search-btn { width: 100%; justify-content: center; padding: 10px; }
        .search-reset { right: 15px; top: 45px; }
    }


    /* ========== DARK MODE - STATUS BADGE ========== */
    .dark-mode .badge,
    .dark-mode span[class*="badge"],
    .dark-mode .status-badge,
    .dark-mode .badge-pending,
    .dark-mode .badge-approved,
    .dark-mode .badge-rejected {
        background-color: #334155 !important;
        color: #e0e0e0 !important;
    }

    /* Pending */
    .dark-mode .badge-pending,
    .dark-mode .bg-warning,
    .dark-mode .status-pending {
        background-color: #78350f !important;
        color: #fde68a !important;
    }

    /* Disetujui */
    .dark-mode .badge-approved,
    .dark-mode .bg-success,
    .dark-mode .status-approved {
        background-color: #065f46 !important;
        color: #86efac !important;
    }

    /* Ditolak */
    .dark-mode .badge-rejected,
    .dark-mode .bg-danger,
    .dark-mode .status-rejected {
        background-color: #7f1d1d !important;
        color: #fca5a5 !important;
    }

    /* Tersedia */
    .dark-mode .badge.bg-success,
    .dark-mode .bg-success {
        background-color: #065f46 !important;
        color: #86efac !important;
    }

    /* Dipinjam */
    .dark-mode .badge.bg-warning,
    .dark-mode .bg-warning {
        background-color: #78350f !important;
        color: #fde68a !important;
    }

    /* Perbaikan */
    .dark-mode .badge.bg-danger,
    .dark-mode .bg-danger {
        background-color: #7f1d1d !important;
        color: #fca5a5 !important;
    }

        /* ========== DARK MODE - MODAL / POP-UP ========== */
    .dark-mode .modal-content,
    .dark-mode .modal-dialog,
    .dark-mode .modal-header,
    .dark-mode .modal-body,
    .dark-mode .modal-footer,
    .dark-mode .custom-modal-content,
    .dark-mode .modal-container,
    .dark-mode .modal-modern-content {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }

    .dark-mode .modal-title,
    .dark-mode .modal-body p,
    .dark-mode .modal-body .label,
    .dark-mode .modal-body .value,
    .dark-mode .modal-body .info-label,
    .dark-mode .modal-body .info-value {
        color: #e0e0e0 !important;
    }

    .dark-mode .modal-header {
        border-bottom-color: #334155 !important;
    }

    .dark-mode .modal-footer {
        border-top-color: #334155 !important;
    }

    .dark-mode .modal .btn-close {
        filter: invert(1);
    }

    /* Modal Confirm */
    .dark-mode .modal-confirm-content {
        background-color: #1e293b !important;
    }

    .dark-mode .modal-confirm-content h3 {
        color: #e0e0e0 !important;
    }

    .dark-mode .modal-confirm-content p {
        color: #94a3b8 !important;
    }

    .dark-mode .btn-no {
        background-color: #334155 !important;
        color: #cbd5e1 !important;
    }


    /* ========== DARK MODE - DETAIL RUANGAN ========== */
    .dark-mode .modal-info-card {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }

    .dark-mode .modal-info-title {
        color: #e0e0e0 !important;
        border-bottom-color: #334155 !important;
    }

    .dark-mode .modal-info-label {
        color: #94a3b8 !important;
    }

    .dark-mode .modal-info-value {
        color: #e0e0e0 !important;
    }

    .dark-mode .modal-foto-placeholder {
        background: linear-gradient(135deg, #1e3c72, #2a5298) !important;
    }

    /* Info Card di detail */
    .dark-mode .info-card {
        background-color: #1e293b !important;
    }

    .dark-mode .info-card-header {
        background-color: #0f172a !important;
        border-bottom-color: #334155 !important;
    }

    .dark-mode .info-card-header i,
    .dark-mode .info-card-header h5 {
        color: #e0e0e0 !important;
    }

    .dark-mode .info-row .info-label {
        color: #94a3b8 !important;
    }

    .dark-mode .info-row .info-value {
        color: #e0e0e0 !important;
    }

</style>

<script>
    function showDetailRuangan(id) {
        const modal = document.getElementById('detailModal');
        const content = document.getElementById('modalDetailContent');
        modal.style.display = 'flex';
        content.innerHTML = '<div class="text-center py-5"><i class="fas fa-spinner fa-spin fa-2x text-primary"></i><p>Memuat data...</p></div>';

        fetch(`/admin/ruangan/${id}/detail`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const r = data.data;
                    let fotoUrl = null;
                    if (r.foto) {
                        if (r.foto.startsWith('http')) fotoUrl = r.foto;
                        else if (r.foto.startsWith('uploads/')) fotoUrl = '/' + r.foto;
                        else fotoUrl = '/storage/ruangan/' + r.foto;
                    }
                    let statusClass = r.status == 'tersedia' ? 'badge-status-tersedia' : (r.status == 'dipinjam' ? 'badge-status-dipinjam' : 'badge-status-perbaikan');
                    let statusText = r.status == 'tersedia' ? 'Tersedia' : (r.status == 'dipinjam' ? 'Dipinjam' : 'Perbaikan');

                    content.innerHTML = `
                        <div class="modal-foto">
                            ${fotoUrl ? `<img src="${fotoUrl}" class="modal-foto-img" onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'modal-foto-placeholder\'><i class=\'fas fa-door-open\'></i></div>'">` : '<div class="modal-foto-placeholder"><i class="fas fa-door-open"></i></div>'}
                            <div class="modal-foto-name" style="margin-top:12px; font-size:18px; font-weight:700;">${escapeHtml(r.nama_ruangan)}</div>
                            <div class="modal-foto-shortname" style="font-size:13px; color:#6b7280;">${escapeHtml(r.kode_ruangan)}</div>
                        </div>
                        <div class="modal-info-card">
                            <div class="modal-info-title"><i class="fas fa-info-circle"></i> Informasi Ruangan</div>
                            <div class="modal-info-grid">
                                <div class="modal-info-item"><span class="modal-info-label">Kode Ruangan</span><span class="modal-info-value">${escapeHtml(r.kode_ruangan)}</span></div>
                                <div class="modal-info-item"><span class="modal-info-label">Lokasi</span><span class="modal-info-value">${escapeHtml(r.lokasi)}</span></div>
                                <div class="modal-info-item"><span class="modal-info-label">Kapasitas</span><span class="modal-info-value">${r.kapasitas} orang</span></div>
                                <div class="modal-info-item"><span class="modal-info-label">Status</span><span class="modal-info-value"><span class="${statusClass}">${statusText}</span></span></div>
                                <div class="modal-info-item full-width"><span class="modal-info-label">Fasilitas</span><span class="modal-info-value">${escapeHtml(r.fasilitas || '-')}</span></div>
                                <div class="modal-info-item"><span class="modal-info-label">Dibuat</span><span class="modal-info-value">${new Date(r.created_at).toLocaleString('id-ID')}</span></div>
                                <div class="modal-info-item"><span class="modal-info-label">Diupdate</span><span class="modal-info-value">${new Date(r.updated_at).toLocaleString('id-ID')}</span></div>
                            </div>
                        </div>
                    `;
                } else {
                    content.innerHTML = '<div class="text-center text-danger py-5">Gagal memuat data</div>';
                }
            })
            .catch(error => content.innerHTML = '<div class="text-center text-danger py-5">Terjadi kesalahan</div>');
    }

    function closeDetailModal() {
        document.getElementById('detailModal').style.display = 'none';
    }

    function escapeHtml(str) {
        if (!str) return '';
        return str.replace(/[&<>]/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            return m;
        });
    }


    window.onclick = function(event) {
        const modal = document.getElementById('detailModal');
        if (event.target === modal) closeDetailModal();
    }

</script>
@endsection
