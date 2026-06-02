@extends('layouts.organisasi')

@section('content')
<div class="container-fluid">
    <!-- Hero Section -->
    <div class="hero-section mb-5">
        <div class="hero-content">
            <h1 class="hero-title">
                <i class="fas fa-book-open me-3"></i>Prosedur Peminjaman Ruangan
            </h1>
            <p class="hero-subtitle">Ikuti langkah-langkah berikut untuk melakukan peminjaman ruangan dengan mudah</p>
        </div>
    </div>

    <!-- Timeline Steps -->
    <div class="timeline-container mb-5">
        <div class="timeline-steps">
            <!-- Step 1 -->
            <div class="timeline-step">
                <div class="step-number">1</div>
                <div class="step-content">
                    <div class="step-icon">
                        <i class="fas fa-sign-in-alt"></i>
                    </div>
                    <h3 class="step-title">Login ke Sistem</h3>
                    <p class="step-description">Akses website sistem booking ruangan menggunakan akun organisasi yang telah didaftarkan oleh admin</p>
                    <div class="step-tip">
                        <i class="fas fa-info-circle"></i>
                        <span>Pastikan email dan password yang dimasukkan benar</span>
                    </div>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="timeline-step">
                <div class="step-number">2</div>
                <div class="step-content">
                    <div class="step-icon">
                        <i class="fas fa-door-open"></i>
                    </div>
                    <h3 class="step-title">Pilih Ruangan</h3>
                    <p class="step-description">Cari ruangan yang sesuai dengan kebutuhan melalui menu "Daftar Ruangan" atau filter yang tersedia</p>
                    <div class="step-tip">
                        <i class="fas fa-lightbulb"></i>
                        <span>Gunakan filter kapasitas dan fasilitas untuk mempermudah pencarian</span>
                    </div>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="timeline-step">
                <div class="step-number">3</div>
                <div class="step-content">
                    <div class="step-icon">
                        <i class="fas fa-calendar-plus"></i>
                    </div>
                    <h3 class="step-title">Klik Booking Sekarang</h3>
                    <p class="step-description">Pada card ruangan yang dipilih, klik tombol "Booking Sekarang" untuk masuk ke formulir peminjaman</p>
                    <div class="step-tip">
                        <i class="fas fa-hand-pointer"></i>
                        <span>Pastikan ruangan yang dipilih berstatus "Tersedia"</span>
                    </div>
                </div>
            </div>

            <!-- Step 4 -->
            <div class="timeline-step">
                <div class="step-number">4</div>
                <div class="step-content">
                    <div class="step-icon">
                        <i class="fas fa-edit"></i>
                    </div>
                    <h3 class="step-title">Isi Formulir Peminjaman</h3>
                    <p class="step-description">Lengkapi semua data yang diperlukan dalam formulir peminjaman dengan benar</p>
                    <div class="step-form-info">
                        <div class="info-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Pilih ruangan yang sudah ditentukan</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Tentukan kategori kegiatan</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Atur tanggal dan waktu peminjaman</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Upload dokumen pendukung (opsional)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 5 -->
            <div class="timeline-step">
                <div class="step-number">5</div>
                <div class="step-content">
                    <div class="step-icon">
                        <i class="fas fa-paper-plane"></i>
                    </div>
                    <h3 class="step-title">Ajukan Peminjaman</h3>
                    <p class="step-description">Setelah semua data terisi, klik tombol "Ajukan Peminjaman" untuk mengirimkan permohonan</p>
                    <div class="step-tip">
                        <i class="fas fa-clock"></i>
                        <span>Sistem akan memberi notifikasi bahwa pengajuan berhasil dikirim</span>
                    </div>
                </div>
            </div>

            <!-- Step 6 -->
            <div class="timeline-step">
                <div class="step-number">6</div>
                <div class="step-content">
                    <div class="step-icon">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                    <h3 class="step-title">Menunggu Konfirmasi Admin</h3>
                    <p class="step-description">Pengajuan akan diproses oleh admin. Status dapat dilihat di menu "Riwayat Booking"</p>
                    <div class="step-status">
                        <span class="status-badge status-pending">⏳ Menunggu</span>
                        <span class="status-badge status-approved">✓ Disetujui</span>
                        <span class="status-badge status-rejected">✗ Ditolak</span>
                    </div>
                </div>
            </div>

            <!-- Step 7 -->
            <div class="timeline-step">
                <div class="step-number">7</div>
                <div class="step-content">
                    <div class="step-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h3 class="step-title">Peminjaman Disetujui</h3>
                    <p class="step-description">Jika disetujui, organisasi dapat menggunakan ruangan sesuai jadwal yang telah ditentukan</p>
                    <div class="step-tip">
                        <i class="fas fa-calendar-check"></i>
                        <span>Gunakan ruangan sesuai dengan waktu yang telah disetujui</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Summary Card -->
    <div class="summary-card">
        <div class="summary-header">
            <i class="fas fa-clipboard-list"></i>
            <h4>Ringkasan Persyaratan</h4>
        </div>
        <div class="summary-body">
            <div class="summary-grid">
                <div class="summary-item">
                    <i class="fas fa-clock"></i>
                    <div>
                        <strong>Waktu Pengajuan</strong>
                        <p>Minimal H-3 sebelum kegiatan</p>
                    </div>
                </div>
                <div class="summary-item">
                    <i class="fas fa-file-alt"></i>
                    <div>
                        <strong>Dokumen Wajib</strong>
                        <p>Surat izin dari pembina organisasi</p>
                    </div>
                </div>
                <div class="summary-item">
                    <i class="fas fa-building"></i>
                    <div>
                        <strong>Maksimal Peminjaman</strong>
                        <p>8 jam per hari (08.00 - 16.00)</p>
                    </div>
                </div>
                <div class="summary-item">
                    <i class="fas fa-users"></i>
                    <div>
                        <strong>Ketentuan Peserta</strong>
                        <p>Sesuai kapasitas ruangan</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="summary-footer">
            <a href="{{ route('organisasi.ruangan.index') }}" class="btn-booking-now">
                <i class="fas fa-calendar-plus me-2"></i>Booking Sekarang
            </a>
            <a href="{{ route('organisasi.dashboard') }}" class="btn-back">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
            </a>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="faq-section">
        <div class="faq-header">
            <i class="fas fa-question-circle"></i>
            <h4>Pertanyaan Umum (FAQ)</h4>
        </div>
        <div class="faq-list">
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFaq(this)">
                    <i class="fas fa-chevron-right faq-icon"></i>
                    <span>Berapa lama waktu proses persetujuan peminjaman?</span>
                </div>
                <div class="faq-answer">
                    <p>Proses persetujuan biasanya memakan waktu 1x24 jam setelah pengajuan. Admin akan memproses sesuai urutan pengajuan.</p>
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFaq(this)">
                    <i class="fas fa-chevron-right faq-icon"></i>
                    <span>Apakah bisa membatalkan peminjaman yang sudah diajukan?</span>
                </div>
                <div class="faq-answer">
                    <p>Ya, bisa. Selama status peminjaman masih "Menunggu", organisasi dapat membatalkan melalui menu Riwayat Booking.</p>
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFaq(this)">
                    <i class="fas fa-chevron-right faq-icon"></i>
                    <span>Dokumen apa saja yang harus dilampirkan?</span>
                </div>
                <div class="faq-answer">
                    <p>Dokumen wajib adalah surat izin dari pembina organisasi. Proposal kegiatan bersifat opsional tetapi disarankan untuk dilampirkan.</p>
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFaq(this)">
                    <i class="fas fa-chevron-right faq-icon"></i>
                    <span>Apakah ada batasan waktu peminjaman ruangan?</span>
                </div>
                <div class="faq-answer">
                    <p>Maksimal peminjaman adalah 8 jam per hari, dengan jam operasional 08.00 - 16.00 WIB (Senin-Jumat) dan 08.00-12.00 WIB (Sabtu).</p>
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFaq(this)">
                    <i class="fas fa-chevron-right faq-icon"></i>
                    <span>Bagaimana jika ruangan yang dipilih sedang tidak tersedia?</span>
                </div>
                <div class="faq-answer">
                    <p>Anda dapat memilih ruangan lain yang tersedia atau memilih jadwal yang berbeda. Gunakan fitur filter untuk mencari ruangan yang tersedia.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* ==================== BASE STYLES ==================== */
    .hero-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 24px;
        padding: 40px;
        text-align: center;
        color: white;
    }
    .hero-title {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 12px;
    }
    .hero-subtitle {
        font-size: 16px;
        opacity: 0.9;
        margin: 0;
    }

    /* Timeline Container */
    .timeline-container {
        position: relative;
        padding: 20px 0;
    }
    .timeline-steps {
        position: relative;
    }
    .timeline-steps::before {
        content: '';
        position: absolute;
        left: 50px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
        opacity: 0.3;
    }
    .timeline-step {
        display: flex;
        gap: 30px;
        margin-bottom: 40px;
        position: relative;
    }
    .step-number {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        font-weight: 700;
        color: white;
        flex-shrink: 0;
        position: relative;
        z-index: 2;
        box-shadow: 0 5px 15px rgba(102,126,234,0.3);
    }
    .step-content {
        flex: 1;
        background: white;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.06);
        transition: all 0.3s;
    }
    .step-content:hover {
        transform: translateX(5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .step-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #e0e7ff, #ede9fe);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
    }
    .step-icon i {
        font-size: 28px;
        color: #667eea;
    }
    .step-title {
        font-size: 18px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 10px;
    }
    .step-description {
        font-size: 14px;
        color: #6b7280;
        line-height: 1.5;
        margin-bottom: 12px;
    }
    .step-tip {
        background: #fef3c7;
        border-radius: 12px;
        padding: 10px 14px;
        font-size: 12px;
        color: #d97706;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .step-tip i {
        font-size: 14px;
    }
    .step-form-info {
        margin-top: 12px;
        padding-top: 12px;
        border-top: 1px solid #f0f0f0;
    }
    .info-item {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 8px;
    }
    .info-item i {
        color: #10b981;
        font-size: 14px;
    }
    .step-status {
        display: flex;
        gap: 12px;
        margin-top: 12px;
        flex-wrap: wrap;
    }
    .status-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    .status-pending {
        background: #fef3c7;
        color: #d97706;
    }
    .status-approved {
        background: #d1fae5;
        color: #059669;
    }
    .status-rejected {
        background: #fee2e2;
        color: #dc2626;
    }

    /* Summary Card */
    .summary-card {
        background: white;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.06);
        margin-bottom: 40px;
    }
    .summary-header {
        background: linear-gradient(135deg, #667eea, #764ba2);
        padding: 18px 24px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .summary-header i {
        font-size: 24px;
        color: white;
    }
    .summary-header h4 {
        font-size: 18px;
        font-weight: 600;
        color: white;
        margin: 0;
    }
    .summary-body {
        padding: 24px;
    }
    .summary-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    .summary-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 12px;
        background: #f8fafc;
        border-radius: 16px;
    }
    .summary-item i {
        width: 40px;
        height: 40px;
        background: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: #667eea;
    }
    .summary-item strong {
        font-size: 14px;
        color: #1f2937;
    }
    .summary-item p {
        font-size: 12px;
        color: #6b7280;
        margin: 4px 0 0;
    }
    .summary-footer {
        padding: 16px 24px 24px;
        display: flex;
        gap: 16px;
        justify-content: center;
        border-top: 1px solid #f0f0f0;
    }
    .btn-booking-now {
        background: linear-gradient(135deg, #10b981, #059669);
        border: none;
        padding: 12px 28px;
        border-radius: 12px;
        color: white;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s;
    }
    .btn-booking-now:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(16,185,129,0.4);
        color: white;
    }
    .btn-back {
        background: #f3f4f6;
        border: none;
        padding: 12px 28px;
        border-radius: 12px;
        color: #4b5563;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s;
    }
    .btn-back:hover {
        background: #e5e7eb;
        color: #374151;
    }

    /* FAQ Section */
    .faq-section {
        background: white;
        border-radius: 24px;
        padding: 24px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.06);
    }
    .faq-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 1px solid #f0f0f0;
    }
    .faq-header i {
        font-size: 28px;
        color: #667eea;
    }
    .faq-header h4 {
        font-size: 18px;
        font-weight: 600;
        color: #1f2937;
        margin: 0;
    }
    .faq-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .faq-item {
        border: 1px solid #f0f0f0;
        border-radius: 16px;
        overflow: hidden;
    }
    .faq-question {
        padding: 16px 20px;
        background: #f8fafc;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 600;
        color: #1f2937;
        transition: all 0.2s;
    }
    .faq-question:hover {
        background: #f1f5f9;
    }
    .faq-icon {
        transition: transform 0.2s;
        color: #667eea;
    }
    .faq-item.active .faq-icon {
        transform: rotate(90deg);
    }
    .faq-answer {
        display: none;
        padding: 16px 20px;
        background: white;
        font-size: 14px;
        color: #6b7280;
        line-height: 1.5;
        border-top: 1px solid #f0f0f0;
    }
    .faq-item.active .faq-answer {
        display: block;
    }

    /* ==================== DARK MODE STYLES ==================== */
    body.dark-mode .hero-section {
        background: linear-gradient(135deg, #1e3c72, #2a5298) !important;
    }
    body.dark-mode .hero-title,
    body.dark-mode .hero-subtitle {
        color: white !important;
    }
    body.dark-mode .step-content {
        background-color: #1e293b !important;
        box-shadow: 0 5px 20px rgba(0,0,0,0.2) !important;
    }
    body.dark-mode .step-title {
        color: #e0e0e0 !important;
    }
    body.dark-mode .step-description {
        color: #94a3b8 !important;
    }
    body.dark-mode .step-icon {
        background: linear-gradient(135deg, #1e3c72, #2a5298) !important;
    }
    body.dark-mode .step-icon i {
        color: #a5f3fc !important;
    }
    body.dark-mode .step-tip {
        background-color: #78350f !important;
        color: #fde68a !important;
    }
    body.dark-mode .step-form-info {
        border-top-color: #334155 !important;
    }
    body.dark-mode .info-item {
        color: #94a3b8 !important;
    }
    body.dark-mode .status-pending {
        background-color: #78350f !important;
        color: #fde68a !important;
    }
    body.dark-mode .status-approved {
        background-color: #065f46 !important;
        color: #86efac !important;
    }
    body.dark-mode .status-rejected {
        background-color: #7f1d1d !important;
        color: #fca5a5 !important;
    }
    body.dark-mode .summary-card {
        background-color: #1e293b !important;
    }
    body.dark-mode .summary-header {
        background: linear-gradient(135deg, #1e3c72, #2a5298) !important;
    }
    body.dark-mode .summary-item {
        background-color: #0f172a !important;
    }
    body.dark-mode .summary-item strong {
        color: #e0e0e0 !important;
    }
    body.dark-mode .summary-item p {
        color: #94a3b8 !important;
    }
    body.dark-mode .summary-item i {
        background-color: #1e293b !important;
        color: #818cf8 !important;
    }
    body.dark-mode .summary-footer {
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
    body.dark-mode .faq-section {
        background-color: #1e293b !important;
    }
    body.dark-mode .faq-header {
        border-bottom-color: #334155 !important;
    }
    body.dark-mode .faq-header h4 {
        color: #e0e0e0 !important;
    }
    body.dark-mode .faq-header i {
        color: #818cf8 !important;
    }
    body.dark-mode .faq-item {
        border-color: #334155 !important;
    }
    body.dark-mode .faq-question {
        background-color: #0f172a !important;
        color: #e0e0e0 !important;
    }
    body.dark-mode .faq-question:hover {
        background-color: #1e293b !important;
    }
    body.dark-mode .faq-answer {
        background-color: #1e293b !important;
        color: #94a3b8 !important;
        border-top-color: #334155 !important;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .hero-section { padding: 30px 20px; }
        .hero-title { font-size: 22px; }
        .hero-subtitle { font-size: 13px; }
        .timeline-steps::before { left: 25px; }
        .step-number { width: 40px; height: 40px; font-size: 16px; }
        .step-content { padding: 16px; }
        .step-icon { width: 45px; height: 45px; }
        .step-icon i { font-size: 20px; }
        .step-title { font-size: 16px; }
        .step-description { font-size: 12px; }
        .summary-grid { grid-template-columns: 1fr; gap: 12px; }
        .summary-footer { flex-direction: column; }
        .btn-booking-now, .btn-back { text-align: center; }
        .faq-question { font-size: 13px; padding: 12px 16px; }
    }
</style>

<script>
    function toggleFaq(element) {
        const faqItem = element.closest('.faq-item');
        faqItem.classList.toggle('active');
    }
</script>
@endsection
