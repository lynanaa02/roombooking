@extends('layouts.organisasi')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header -->
            <div class="detail-header mb-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <h2 class="detail-title">
                            <i class="fas fa-file-alt me-2"></i>Detail Peminjaman Ruangan
                        </h2>
                        <p class="detail-subtitle">Informasi lengkap peminjaman ruangan Anda</p>
                    </div>
                    <a href="{{ route('organisasi.riwayat.index') }}" class="btn-back">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Riwayat
                    </a>
                </div>
            </div>

            <!-- Status Banner -->
            <div class="status-banner mb-4">
                @if($booking->status == 'pending')
                    <div class="status-banner-pending">
                        <i class="fas fa-clock fa-2x me-3"></i>
                        <div>
                            <h5>Status: Menunggu Persetujuan</h5>
                            <p>Peminjaman ini masih menunggu persetujuan admin</p>
                        </div>
                    </div>
                @elseif($booking->status == 'disetujui')
                    <div class="status-banner-approved">
                        <i class="fas fa-check-circle fa-2x me-3"></i>
                        <div>
                            <h5>Status: Disetujui</h5>
                            <p>Peminjaman ini telah disetujui oleh admin</p>
                        </div>
                    </div>
                @else
                    <div class="status-banner-rejected">
                        <i class="fas fa-times-circle fa-2x me-3"></i>
                        <div>
                            <h5>Status: Ditolak</h5>
                            <p>Peminjaman ini telah ditolak oleh admin</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Tabs Navigation -->
            <div class="modal-tabs">
                <button class="tab-btn active" onclick="showTab('ruangan')">
                    <i class="fas fa-door-open me-2"></i>Ruangan
                </button>
                <button class="tab-btn" onclick="showTab('peminjaman')">
                    <i class="fas fa-calendar-alt me-2"></i>Peminjaman
                </button>
                <button class="tab-btn" onclick="showTab('dokumen')">
                    <i class="fas fa-paperclip me-2"></i>Dokumen
                </button>
            </div>

            <!-- Tab Content -->
            <div class="tab-content-wrapper">
                <!-- TAB 1: Ruangan -->
                <div id="tab-ruangan" class="tab-pane active">
                    <div class="info-card">
                        <div class="info-card-header">
                            <i class="fas fa-door-open"></i>
                            <h5>Informasi Ruangan</h5>
                        </div>
                        <div class="info-card-body">
                            <div class="info-grid-2">
                                <div class="info-item">
                                    <div class="info-label">Nama Ruangan</div>
                                    <div class="info-value">{{ $booking->ruangan->nama_ruangan }}</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Kode Ruangan</div>
                                    <div class="info-value">{{ $booking->ruangan->kode_ruangan }}</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Lokasi</div>
                                    <div class="info-value">{{ $booking->ruangan->lokasi }}</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Kapasitas</div>
                                    <div class="info-value">{{ $booking->ruangan->kapasitas }} orang</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Fasilitas</div>
                                    <div class="info-value">{{ $booking->ruangan->fasilitas ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 2: Peminjaman -->
                <div id="tab-peminjaman" class="tab-pane" style="display: none;">
                    <div class="info-card">
                        <div class="info-card-header">
                            <i class="fas fa-calendar-alt"></i>
                            <h5>Detail Peminjaman</h5>
                        </div>
                        <div class="info-card-body">
                            @php
                                $start = \Carbon\Carbon::parse($booking->waktu_mulai);
                                $end = \Carbon\Carbon::parse($booking->waktu_selesai);
                                $hours = $start->diffInHours($end);
                                $minutes = $start->diffInMinutes($end) % 60;
                            @endphp
                            <div class="info-grid-2">
                                <div class="info-item">
                                    <div class="info-label">Kategori Kegiatan</div>
                                    <div class="info-value">{{ $booking->kategori_kegiatan }}</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Tanggal Pengajuan</div>
                                    <div class="info-value">{{ \Carbon\Carbon::parse($booking->tanggal_pengajuan)->format('d/m/Y H:i') }}</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Tanggal Peminjaman</div>
                                    <div class="info-value">{{ \Carbon\Carbon::parse($booking->tanggal_pinjam)->format('d/m/Y') }}</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Waktu Mulai</div>
                                    <div class="info-value">{{ \Carbon\Carbon::parse($booking->waktu_mulai)->format('H:i') }} WIB</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Waktu Selesai</div>
                                    <div class="info-value">{{ \Carbon\Carbon::parse($booking->waktu_selesai)->format('H:i') }} WIB</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Durasi</div>
                                    <div class="info-value">{{ $hours }} jam {{ $minutes > 0 ? $minutes . ' menit' : '' }}</div>
                                </div>
                                <div class="info-item full-width">
                                    <div class="info-label">Keterangan Tambahan</div>
                                    <div class="info-value">{{ $booking->keterangan_tambahan ?? '-' }}</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Status</div>
                                    <div class="info-value">
                                        @if($booking->status == 'pending')
                                            <span class="badge-pending"><i class="fas fa-clock me-1"></i>Pending</span>
                                        @elseif($booking->status == 'disetujui')
                                            <span class="badge-approved"><i class="fas fa-check-circle me-1"></i>Disetujui</span>
                                        @else
                                            <span class="badge-rejected"><i class="fas fa-times-circle me-1"></i>Ditolak</span>
                                        @endif
                                    </div>
                                </div>
                                @if($booking->status == 'ditolak' && $booking->alasan_ditolak)
                                <div class="info-item full-width">
                                    <div class="info-label">Alasan Ditolak</div>
                                    <div class="info-value" style="color: #dc2626;">
                                        <i class="fas fa-info-circle me-1"></i> {{ $booking->alasan_ditolak }}
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 3: Dokumen -->
                <div id="tab-dokumen" class="tab-pane" style="display: none;">
                    <div class="docs-grid">
                        <!-- Surat Izin -->
                        <div class="doc-card">
                            <div class="doc-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="doc-info">
                                <div class="doc-title">Surat Izin</div>
                                <div class="doc-desc">Surat izin dari pembina organisasi</div>
                                @if($booking->bukti_surat_izin)
                                    @php
                                        $suratPath = $booking->bukti_surat_izin;
                                        $suratPath = str_replace('storage/', '', $suratPath);
                                        $suratPath = str_replace('public/', '', $suratPath);
                                        $extension = strtolower(pathinfo($suratPath, PATHINFO_EXTENSION));
                                    @endphp

                                    @if($extension == 'pdf')
                                        <button onclick="openPdfViewer('{{ asset($suratPath) }}')" class="doc-btn">
                                            <i class="fas fa-file-pdf me-1"></i> Lihat PDF
                                        </button>
                                    @elseif(in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                                        <button onclick="openImageModal('{{ asset($suratPath) }}')" class="doc-btn">
                                            <i class="fas fa-image me-1"></i> Lihat Gambar
                                        </button>
                                    @else
                                        <a href="{{ asset($suratPath) }}" target="_blank" class="doc-btn">
                                            <i class="fas fa-download me-1"></i> Download File
                                        </a>
                                    @endif
                                @else
                                    <span class="doc-empty">Tidak ada dokumen</span>
                                @endif
                            </div>
                        </div>

                        <!-- Proposal Kegiatan -->
                        <div class="doc-card">
                            <div class="doc-icon">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div class="doc-info">
                                <div class="doc-title">Proposal Kegiatan</div>
                                <div class="doc-desc">Proposal kegiatan yang diajukan</div>
                                @if($booking->proposal_kegiatan)
                                    @php
                                        $proposalPath = $booking->proposal_kegiatan;
                                        $proposalPath = str_replace('storage/', '', $proposalPath);
                                        $proposalPath = str_replace('public/', '', $proposalPath);
                                        $extension = strtolower(pathinfo($proposalPath, PATHINFO_EXTENSION));
                                    @endphp

                                    @if($extension == 'pdf')
                                        <button onclick="openPdfViewer('{{ asset($proposalPath) }}')" class="doc-btn">
                                            <i class="fas fa-file-pdf me-1"></i> Lihat PDF
                                        </button>
                                    @elseif(in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                                        <button onclick="openImageModal('{{ asset($proposalPath) }}')" class="doc-btn">
                                            <i class="fas fa-image me-1"></i> Lihat Gambar
                                        </button>
                                    @else
                                        <a href="{{ asset($proposalPath) }}" target="_blank" class="doc-btn">
                                            <i class="fas fa-download me-1"></i> Download File
                                        </a>
                                    @endif
                                @else
                                    <span class="doc-empty">Tidak ada dokumen</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- TOMBOL BATAL PEMINJAMAN (DI PALING BAWAH)   -->
            <!-- ========================================== -->
            @if($booking->status == 'pending')
            <div class="cancel-action-wrapper">
                <button class="btn-cancel" onclick="showCancelModal()">
                    <i class="fas fa-times-circle me-2"></i>Batalkan Peminjaman
                </button>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Batal -->
<div id="cancelModal" class="modal-confirm" style="display: none;">
    <div class="modal-confirm-content" style="max-width: 400px;">
        <div class="modal-confirm-icon warning">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h3>Batalkan Peminjaman</h3>
        <p>Apakah Anda yakin ingin membatalkan peminjaman ini?</p>
        <p class="text-muted small">Peminjaman yang sudah dibatalkan tidak dapat dikembalikan.</p>
        <div class="modal-confirm-buttons">
            <button class="btn-no" onclick="closeCancelModal()">Tidak, Kembali</button>
            <form id="cancelForm" action="{{ route('organisasi.booking.cancel', $booking) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-yes-cancel">Ya, Batalkan</button>
            </form>
        </div>
    </div>
</div>

<!-- Modal PDF Viewer -->
<div id="pdfModal" class="modal-pdf" style="display: none;">
    <div class="modal-pdf-content">
        <div class="modal-pdf-header">
            <h5><i class="fas fa-file-pdf me-2"></i>Lihat Dokumen PDF</h5>
            <button class="modal-pdf-close" onclick="closePdfViewer()">&times;</button>
        </div>
        <div class="modal-pdf-body">
            <iframe id="pdfFrame" src="" width="100%" height="500px" style="border: none; border-radius: 8px;"></iframe>
        </div>
        <div class="modal-pdf-footer">
            <button class="btn-download-pdf" onclick="downloadPdf()">
                <i class="fas fa-download me-2"></i>Download PDF
            </button>
            <button class="btn-close-pdf" onclick="closePdfViewer()">Tutup</button>
        </div>
    </div>
</div>

<!-- Modal Image Viewer -->
<div id="imageModal" class="modal-image" style="display: none;">
    <div class="modal-image-content">
        <button class="modal-image-close" onclick="closeImageModal()">&times;</button>
        <img id="imageViewer" src="" alt="Preview">
    </div>
</div>

<style>
    /* ========== HEADER ========== */
    .detail-header {
        margin-bottom: 24px;
    }
    .detail-title {
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
        margin: 0 0 4px;
    }
    .detail-subtitle {
        font-size: 14px;
        color: #6b7280;
        margin: 0;
    }
    .btn-back {
        background: #f3f4f6;
        padding: 10px 20px;
        border-radius: 30px;
        color: #4b5563;
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-back:hover {
        background: #e5e7eb;
        color: #1f2937;
    }

    /* ========== STATUS BANNER ========== */
    .status-banner-pending,
    .status-banner-approved,
    .status-banner-rejected {
        display: flex;
        align-items: center;
        padding: 20px 24px;
        border-radius: 16px;
    }
    .status-banner-pending { background: #fef3c7; }
    .status-banner-approved { background: #d1fae5; }
    .status-banner-rejected { background: #fee2e2; }
    .status-banner-pending i { color: #d97706; }
    .status-banner-approved i { color: #059669; }
    .status-banner-rejected i { color: #dc2626; }
    .status-banner-pending h5, .status-banner-approved h5, .status-banner-rejected h5 {
        font-size: 16px;
        font-weight: 700;
        margin: 0;
    }
    .status-banner-pending p, .status-banner-approved p, .status-banner-rejected p {
        font-size: 13px;
        margin: 4px 0 0;
        opacity: 0.8;
    }

    /* ========== TABS ========== */
    .modal-tabs {
        display: flex;
        gap: 12px;
        margin-bottom: 24px;
        background: #f1f5f9;
        padding: 8px;
        border-radius: 60px;
        border: 1px solid #e2e8f0;
    }
    .tab-btn {
        background: transparent;
        border: none;
        padding: 10px 28px;
        font-size: 14px;
        font-weight: 600;
        color: #475569;
        cursor: pointer;
        border-radius: 40px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .tab-btn:hover {
        background: rgba(102, 126, 234, 0.1);
        color: #4f46e5;
    }
    .tab-btn.active {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    /* ========== INFO CARD ========== */
    .info-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        margin-bottom: 20px;
        border: 1px solid #e5e7eb;
    }
    .info-card-header {
        background: #f8fafc;
        padding: 16px 24px;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .info-card-header i {
        font-size: 20px;
        color: #667eea;
    }
    .info-card-header h5 {
        font-size: 16px;
        font-weight: 600;
        margin: 0;
        color: #1f2937;
    }
    .info-card-body {
        padding: 24px;
    }
    .info-grid-2 {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }
    .info-item {
        background: #f8fafc;
        border-radius: 12px;
        padding: 12px 16px;
    }
    .info-item.full-width {
        grid-column: span 2;
    }
    .info-label {
        font-size: 11px;
        color: #9ca3af;
        margin-bottom: 4px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .info-value {
        font-size: 14px;
        font-weight: 600;
        color: #1f2937;
    }

    /* ========== BADGES ========== */
    .badge-pending {
        background: #fef3c7;
        color: #d97706;
        display: inline-flex;
        align-items: center;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }
    .badge-approved {
        background: #d1fae5;
        color: #059669;
        display: inline-flex;
        align-items: center;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }
    .badge-rejected {
        background: #fee2e2;
        color: #dc2626;
        display: inline-flex;
        align-items: center;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    /* ========== DOKUMEN CARDS ========== */
    .docs-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    .doc-card {
        background: #f8fafc;
        border-radius: 16px;
        padding: 24px 20px;
        text-align: center;
        transition: all 0.2s;
        border: 1px solid #e5e7eb;
    }
    .doc-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    .doc-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
    }
    .doc-icon i {
        font-size: 28px;
        color: white;
    }
    .doc-title {
        font-size: 16px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 4px;
    }
    .doc-desc {
        font-size: 12px;
        color: #6b7280;
        margin-bottom: 16px;
    }
    .doc-btn {
        background: white;
        border: 1px solid #e5e7eb;
        padding: 8px 20px;
        border-radius: 30px;
        color: #667eea;
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .doc-btn:hover {
        background: #667eea;
        border-color: #667eea;
        color: white;
    }
    .doc-empty {
        font-size: 13px;
        color: #9ca3af;
    }

    /* ========== CANCEL BUTTON (DI PALING BAWAH) ========== */
    .cancel-action-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1px solid #e5e7eb;
    }
    .btn-cancel {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        border: none;
        padding: 12px 40px;
        border-radius: 40px;
        color: white;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-cancel:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(220, 38, 38, 0.4);
    }

    /* ========== MODAL CONFIRM ========== */
    .modal-confirm {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(4px);
        z-index: 200000;
        display: none;
        align-items: center;
        justify-content: center;
    }
    .modal-confirm-content {
        background: white;
        border-radius: 24px;
        padding: 32px;
        width: 90%;
        max-width: 400px;
        text-align: center;
    }
    .modal-confirm-icon {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
    }
    .modal-confirm-icon i { font-size: 36px; }
    .modal-confirm-icon.success { background: #d1fae5; color: #10b981; }
    .modal-confirm-icon.warning { background: #fef3c7; color: #d97706; }
    .modal-confirm-icon.danger { background: #fee2e2; color: #dc2626; }
    .modal-confirm-content h3 { font-size: 20px; margin-bottom: 8px; color: #1f2937; }
    .modal-confirm-content p { font-size: 14px; color: #6b7280; margin-bottom: 8px; }
    .modal-confirm-buttons { display: flex; gap: 12px; justify-content: center; margin-top: 20px; }
    .btn-yes, .btn-no, .btn-yes-cancel {
        padding: 10px 24px;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        border: none;
        transition: all 0.2s;
    }
    .btn-yes { background: linear-gradient(135deg, #10b981, #059669); color: white; }
    .btn-yes-cancel { background: linear-gradient(135deg, #ef4444, #dc2626); color: white; }
    .btn-no { background: #f3f4f6; color: #4b5563; }
    .btn-yes:hover, .btn-yes-cancel:hover, .btn-no:hover { transform: translateY(-2px); }

    /* ========== MODAL PDF ========== */
    .modal-pdf {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.85);
        backdrop-filter: blur(5px);
        z-index: 200000;
        display: none;
        align-items: center;
        justify-content: center;
    }
    .modal-pdf-content {
        background: white;
        border-radius: 20px;
        width: 90%;
        max-width: 1000px;
        max-height: 90vh;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }
    .modal-pdf-header {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .modal-pdf-header h5 { margin: 0; }
    .modal-pdf-close {
        background: rgba(255,255,255,0.2);
        border: none;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        font-size: 24px;
        color: white;
        cursor: pointer;
    }
    .modal-pdf-body { flex: 1; padding: 20px; background: #1a1a2e; }
    .modal-pdf-footer {
        padding: 15px 20px;
        border-top: 1px solid #e5e7eb;
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        background: white;
    }
    .btn-download-pdf {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        border: none;
        padding: 8px 24px;
        border-radius: 40px;
        color: white;
        font-weight: 600;
        cursor: pointer;
    }
    .btn-close-pdf {
        background: #f3f4f6;
        border: none;
        padding: 8px 24px;
        border-radius: 40px;
        font-weight: 600;
        cursor: pointer;
    }

    /* ========== MODAL IMAGE ========== */
    .modal-image {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.9);
        z-index: 200001;
        display: none;
        align-items: center;
        justify-content: center;
    }
    .modal-image-content {
        position: relative;
        max-width: 90%;
        max-height: 90%;
    }
    .modal-image-content img {
        width: 100%;
        height: auto;
        max-height: 90vh;
        object-fit: contain;
        border-radius: 8px;
    }
    .modal-image-close {
        position: absolute;
        top: -40px;
        right: 0;
        background: rgba(255,255,255,0.2);
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        font-size: 28px;
        color: white;
        cursor: pointer;
    }

    /* ========== DARK MODE ========== */
    body.dark-mode .detail-title { color: #f1f5f9; }
    body.dark-mode .detail-subtitle { color: #94a3b8; }
    body.dark-mode .btn-back { background: #334155; color: #cbd5e1; }
    body.dark-mode .modal-tabs { background: #1e293b; border-color: #334155; }
    body.dark-mode .tab-btn { color: #94a3b8; }
    body.dark-mode .tab-btn:hover { background: rgba(129, 140, 248, 0.15); color: #a5b4fc; }
    body.dark-mode .info-card { background: #1e293b; border-color: #334155; }
    body.dark-mode .info-card-header { background: #0f172a; border-bottom-color: #334155; }
    body.dark-mode .info-card-header h5 { color: #f1f5f9; }
    body.dark-mode .info-item { background: #0f172a; }
    body.dark-mode .info-label { color: #64748b; }
    body.dark-mode .info-value { color: #f1f5f9; }
    body.dark-mode .doc-card { background: #0f172a; border-color: #334155; }
    body.dark-mode .doc-title { color: #f1f5f9; }
    body.dark-mode .doc-desc { color: #94a3b8; }
    body.dark-mode .doc-btn { background: #1e293b; border-color: #475569; color: #818cf8; }
    body.dark-mode .badge-pending { background: #78350f; color: #fde68a; }
    body.dark-mode .badge-approved { background: #065f46; color: #86efac; }
    body.dark-mode .badge-rejected { background: #7f1d1d; color: #fca5a5; }
    body.dark-mode .status-banner-pending { background: #78350f; color: #fde68a; }
    body.dark-mode .status-banner-approved { background: #065f46; color: #86efac; }
    body.dark-mode .status-banner-rejected { background: #7f1d1d; color: #fca5a5; }
    body.dark-mode .status-banner-pending h5, body.dark-mode .status-banner-approved h5, body.dark-mode .status-banner-rejected h5,
    body.dark-mode .status-banner-pending p, body.dark-mode .status-banner-approved p, body.dark-mode .status-banner-rejected p {
        color: white;
    }
    body.dark-mode .modal-confirm-content { background: #1e293b; }
    body.dark-mode .modal-confirm-content h3 { color: #f1f5f9; }
    body.dark-mode .modal-confirm-content p { color: #94a3b8; }
    body.dark-mode .btn-no { background: #334155; color: #cbd5e1; }
    body.dark-mode .modal-pdf-content { background: #1e293b; }
    body.dark-mode .modal-pdf-footer { background: #1e293b; border-top-color: #334155; }
    body.dark-mode .btn-close-pdf { background: #334155; color: white; }
    body.dark-mode .cancel-action-wrapper { border-top-color: #334155; }
    body.dark-mode .btn-cancel { background: linear-gradient(135deg, #b91c1c, #7f1d1d); }

    /* ========== RESPONSIVE ========== */
    @media (max-width: 768px) {
        .info-grid-2 { grid-template-columns: 1fr; }
        .info-item.full-width { grid-column: span 1; }
        .docs-grid { grid-template-columns: 1fr; }
        .modal-tabs { flex-wrap: wrap; justify-content: center; }
        .tab-btn { padding: 8px 20px; font-size: 12px; }
        .cancel-action-wrapper { margin-top: 24px; padding-top: 20px; }
        .btn-cancel { padding: 12px 30px; width: 100%; justify-content: center; }
    }
</style>

<script>
    // Tab Functions
    function showTab(tabName) {
        document.getElementById('tab-ruangan').style.display = 'none';
        document.getElementById('tab-peminjaman').style.display = 'none';
        document.getElementById('tab-dokumen').style.display = 'none';

        document.getElementById('tab-' + tabName).style.display = 'block';

        const btns = document.querySelectorAll('.tab-btn');
        btns.forEach(btn => btn.classList.remove('active'));
        event.target.classList.add('active');
    }

    // Cancel Modal Functions
    function showCancelModal() {
        document.getElementById('cancelModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeCancelModal() {
        document.getElementById('cancelModal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    // PDF Viewer
    let currentPdfUrl = '';

    function openPdfViewer(url) {
        currentPdfUrl = url;
        document.getElementById('pdfFrame').src = url;
        document.getElementById('pdfModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closePdfViewer() {
        document.getElementById('pdfFrame').src = '';
        document.getElementById('pdfModal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    function downloadPdf() {
        if (currentPdfUrl) window.open(currentPdfUrl, '_blank');
    }

    // Image Viewer
    function openImageModal(url) {
        document.getElementById('imageViewer').src = url;
        document.getElementById('imageModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeImageModal() {
        document.getElementById('imageViewer').src = '';
        document.getElementById('imageModal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    // Close modal on outside click
    window.onclick = function(event) {
        if (event.target === document.getElementById('pdfModal')) closePdfViewer();
        if (event.target === document.getElementById('imageModal')) closeImageModal();
        if (event.target === document.getElementById('cancelModal')) closeCancelModal();
    }
</script>
@endsection
