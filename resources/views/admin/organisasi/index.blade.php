@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3><i class="fas fa-users me-2"></i>Kelola Organisasi</h3>
        <a href="{{ route('admin.organisasi.create') }}" class="btn-custom">
            <i class="fas fa-plus me-2"></i>Tambah Organisasi
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

    <!-- Search Bar -->
    <div class="search-card">
        <div class="search-wrapper">
            <i class="fas fa-search search-icon"></i>
            <input type="text" id="searchInput" class="search-input" placeholder="Cari organisasi berdasarkan nama, email, atau ketua...">
            <button id="clearSearchBtn" class="search-clear" style="display: none;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="searchInfo" class="search-info"></div>
    </div>

    <!-- Table Container -->
    <div id="tableContainer">
        @include('admin.organisasi._table_rows', ['organisasis' => $organisasis])
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
    .search-wrapper {
        position: relative;
    }
    .search-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        font-size: 16px;
    }
    .search-input {
        width: 100%;
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
    .search-clear {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #9ca3af;
        cursor: pointer;
        font-size: 16px;
        padding: 5px;
    }
    .search-clear:hover {
        color: #ef4444;
    }
    .search-info {
        font-size: 13px;
        color: #6b7280;
        margin-top: 10px;
        text-align: right;
    }
</style>

<!-- Modal Detail Modern -->
<div id="detailModal" class="modal-modern" style="display: none;">
    <div class="modal-modern-content">
        <div class="modal-modern-header">
            <h4><i class="fas fa-building me-2"></i>Detail Organisasi</h4>
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
    .modal-modern-header h4 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
    }
    .modal-modern-close {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        font-size: 24px;
        color: white;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .modal-modern-close:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: scale(1.05);
    }
    .modal-modern-body {
        padding: 28px;
    }
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
        transition: all 0.2s;
    }
    .btn-modal-close:hover {
        background: #e5e7eb;
    }
    .modal-info-card {
        background: #f8fafc;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .modal-info-card:last-child {
        margin-bottom: 0;
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
    .modal-info-title i {
        color: #667eea;
    }
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
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #667eea;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .modal-foto-placeholder {
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .modal-foto-placeholder i {
        font-size: 48px;
        color: white;
    }
    .modal-foto-name {
        font-size: 18px;
        font-weight: 700;
        color: #1f2937;
        margin-top: 12px;
        margin-bottom: 4px;
    }
    .modal-foto-shortname {
        font-size: 13px;
        color: #6b7280;
    }
    @keyframes modalFadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }
    @media (max-width: 768px) {
        .modal-info-grid { grid-template-columns: 1fr; gap: 12px; }
        .modal-modern-body { padding: 20px; }
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
    // ==================== VARIABLES ====================
    let searchTimeout;
    let currentPage = 1;
    let currentSearch = '';

    // ==================== HELPER FUNCTIONS ====================
    function escapeHtml(str) {
        if (!str) return '';
        return str.replace(/[&<>]/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            return m;
        });
    }

    // ==================== DELETE CONFIRMATION ====================
    function confirmAction(event, formId, namaOrganisasi, actionType) {
        event.preventDefault();
        event.stopPropagation();

        if (actionType === 'delete') {
            // Gunakan confirm bawaan browser (simple)
            if (confirm(`Apakah Anda yakin ingin menghapus organisasi "${namaOrganisasi}"?`)) {
                const form = document.getElementById(formId);
                if (form) {
                    form.submit();
                }
            }
        }
    }

    // ==================== PAGINATION EVENTS ====================
    function attachPaginationEvents() {
        // Tombol Previous
        document.querySelectorAll('.prev-link').forEach(link => {
            link.removeEventListener('click', handlePrevClick);
            link.addEventListener('click', handlePrevClick);
        });

        // Tombol Next
        document.querySelectorAll('.next-link').forEach(link => {
            link.removeEventListener('click', handleNextClick);
            link.addEventListener('click', handleNextClick);
        });

        // Tombol angka halaman
        document.querySelectorAll('.page-num').forEach(link => {
            link.removeEventListener('click', handlePageClick);
            link.addEventListener('click', handlePageClick);
        });
    }

    function handlePrevClick(e) {
        e.preventDefault();
        if (currentPage > 1) {
            loadSearch(currentPage - 1);
        }
    }

    function handleNextClick(e) {
        e.preventDefault();
        loadSearch(currentPage + 1);
    }

    function handlePageClick(e) {
        e.preventDefault();
        const page = parseInt(this.dataset.page);
        if (page && !isNaN(page)) {
            loadSearch(page);
        }
    }

    // ==================== LOADING INDICATOR ====================
    function showLoading() {
        const loadingHtml = `
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2 text-muted">Memuat data...</p>
            </div>
        `;
        document.getElementById('tableContainer').innerHTML = loadingHtml;
    }

    // ==================== AJAX SEARCH FUNCTION ====================
    function loadSearch(page = 1) {
        const search = document.getElementById('searchInput').value;
        const tableContainer = document.getElementById('tableContainer');
        const searchInfo = document.getElementById('searchInfo');
        const clearBtn = document.getElementById('clearSearchBtn');

        currentPage = page;
        currentSearch = search;

        showLoading();

        const url = `/admin/organisasi/search?search=${encodeURIComponent(search)}&page=${page}`;

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                tableContainer.innerHTML = data.html;
                if (data.total > 0) {
                    searchInfo.innerHTML = `<i class="fas fa-search me-1"></i> Menampilkan ${data.total} data organisasi`;
                } else {
                    searchInfo.innerHTML = '<i class="fas fa-info-circle me-1"></i> Tidak ada data ditemukan';
                }
                clearBtn.style.display = search.length > 0 ? 'block' : 'none';

                // Re-attach events setelah konten diupdate
                setTimeout(() => {
                    attachPaginationEvents();
                }, 100);
            } else {
                tableContainer.innerHTML = '<div class="alert alert-danger">Gagal memuat data: ' + (data.error || 'Unknown error') + '</div>';
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            tableContainer.innerHTML = `<div class="alert alert-danger">Terjadi kesalahan: ${error.message}</div>`;
        });
    }

    // ==================== SHOW DETAIL MODAL ====================
    function showDetail(id) {
        const modal = document.getElementById('detailModal');
        const content = document.getElementById('modalDetailContent');
        modal.style.display = 'flex';
        content.innerHTML = '<div class="text-center py-5"><i class="fas fa-spinner fa-spin fa-2x text-primary"></i><p class="mt-2">Memuat data...</p></div>';

        fetch(`/admin/organisasi/${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const org = data.data;
                    let fotoUrl = null;
                    if (org.foto) {
                        if (org.foto.startsWith('http')) fotoUrl = org.foto;
                        else if (org.foto.startsWith('uploads/')) fotoUrl = '/' + org.foto;
                        else fotoUrl = '/storage/' + org.foto;
                    }

                    content.innerHTML = `
                        <div class="modal-foto">
                            ${fotoUrl ? `<img src="${fotoUrl}" class="modal-foto-img" onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\\'modal-foto-placeholder\\'><i class=\\'fas fa-building\\'></i></div>'">` : '<div class="modal-foto-placeholder"><i class="fas fa-building"></i></div>'}
                            <div class="modal-foto-name">${escapeHtml(org.nama_organisasi)}</div>
                            <div class="modal-foto-shortname">${escapeHtml(org.name)}</div>
                        </div>
                        <div class="modal-info-card">
                            <div class="modal-info-title"><i class="fas fa-address-card"></i> Informasi Organisasi</div>
                            <div class="modal-info-grid">
                                <div class="modal-info-item"><span class="modal-info-label">Ketua Organisasi</span><span class="modal-info-value">${escapeHtml(org.ketua_organisasi || '-')}</span></div>
                                <div class="modal-info-item"><span class="modal-info-label">Jenis Organisasi</span><span class="modal-info-value">${escapeHtml(org.jenis_organisasi)}</span></div>
                                <div class="modal-info-item"><span class="modal-info-label">Jumlah Anggota</span><span class="modal-info-value">${org.jumlah_anggota || 0} orang</span></div>
                                <div class="modal-info-item"><span class="modal-info-label">Email</span><span class="modal-info-value">${escapeHtml(org.email)}</span></div>
                                <div class="modal-info-item"><span class="modal-info-label">No. Telepon</span><span class="modal-info-value">${escapeHtml(org.no_telp || '-')}</span></div>
                                <div class="modal-info-item"><span class="modal-info-label">Tanggal Registrasi</span><span class="modal-info-value">${new Date(org.created_at).toLocaleString('id-ID')}</span></div>
                                <div class="modal-info-item"><span class="modal-info-label">Terakhir Update</span><span class="modal-info-value">${new Date(org.updated_at).toLocaleString('id-ID')}</span></div>
                            </div>
                        </div>
                    `;
                } else {
                    content.innerHTML = '<div class="text-center text-danger py-5">Gagal memuat data</div>';
                }
            })
            .catch(error => {
                console.error('Detail error:', error);
                content.innerHTML = '<div class="text-center text-danger py-5">Terjadi kesalahan saat memuat detail</div>';
            });
    }

    function closeDetailModal() {
        document.getElementById('detailModal').style.display = 'none';
    }

    // ==================== EVENT LISTENERS ====================
    document.addEventListener('DOMContentLoaded', function() {
        // Search input event
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    loadSearch(1);
                }, 500);
            });
        }

        // Clear button event
        const clearBtn = document.getElementById('clearSearchBtn');
        if (clearBtn) {
            clearBtn.addEventListener('click', function() {
                const searchInput = document.getElementById('searchInput');
                if (searchInput) {
                    searchInput.value = '';
                    loadSearch(1);
                }
            });
        }

        // Attach pagination events for initial load
        attachPaginationEvents();
    });

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('detailModal');
        if (event.target === modal) closeDetailModal();
    }
</script>
@endsection
