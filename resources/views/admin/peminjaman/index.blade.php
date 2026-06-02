@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="page-title">
            <i class="fas fa-calendar-check me-2"></i>Manajemen Peminjaman Ruangan
        </h3>
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

    <!-- Statistik Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="stat-card">
                <div class="stat-icon bg-primary">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $totalPengajuan ?? 0 }}</h3>
                    <p>Total Peminjaman</p>
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
                    <p>Pending</p>
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
                    <p>Disetujui</p>
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
                    <p>Ditolak</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Peminjaman -->
    <div class="card-table">
        <div class="table-responsive">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th class="text-center" width="5%">No</th>
                        <th width="15%">Organisasi</th>
                        <th width="12%">Ruangan</th>
                        <th width="18%">Kegiatan</th>
                        <th width="10%" class="text-center">Tgl Pengajuan</th>
                        <th width="15%" class="text-center">Waktu Peminjaman</th>
                        <th width="8%" class="text-center">Durasi</th>
                        <th width="10%" class="text-center">Status</th>
                        <th width="7%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $index => $booking)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>
                            <strong>{{ $booking->user->nama_organisasi ?? $booking->user->name }}</strong>
                            <br><small class="text-muted">{{ $booking->user->jenis_organisasi ?? '-' }}</small>
                        </td>
                        <td>
                            {{ $booking->ruangan->nama_ruangan }}
                            <br><small class="text-muted">Kode: {{ $booking->ruangan->kode_ruangan }}</small>
                        </td>
                        <td>{{ Str::limit($booking->kategori_kegiatan, 35) }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($booking->tanggal_pengajuan)->format('d/m/Y') }}</td>
                        <td class="text-center">
                            {{ \Carbon\Carbon::parse($booking->waktu_mulai)->format('d/m/Y H:i') }}
                            <br><small>s/d {{ \Carbon\Carbon::parse($booking->waktu_selesai)->format('H:i') }}</small>
                        </td>
                        <td class="text-center">
                            @php
                                $start = \Carbon\Carbon::parse($booking->waktu_mulai);
                                $end = \Carbon\Carbon::parse($booking->waktu_selesai);
                                $hours = $start->diffInHours($end);
                            @endphp
                            {{ $hours }} jam
                        </td>
                        <td class="text-center">
                            @if($booking->status == 'pending')
                                <span class="badge-pending"><i class="fas fa-clock me-1"></i>Pending</span>
                            @elseif($booking->status == 'disetujui')
                                <span class="badge-approved"><i class="fas fa-check-circle me-1"></i>Disetujui</span>
                            @else
                                <span class="badge-rejected"><i class="fas fa-times-circle me-1"></i>Ditolak</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <button class="btn-detail" onclick="openModal({{ $booking->id }})">
                                <i class="fas fa-eye me-1"></i>Detail
                            </button>
                        </td>
                    </tr>

                    <!-- Modal Detail Modern dengan Dark Mode -->
                    <div id="modalDetail{{ $booking->id }}" class="modal-modern">
                        <div class="modal-modern-content">
                            <div class="modal-modern-header">
                                <h4><i class="fas fa-file-alt me-2"></i>Detail Peminjaman Ruangan</h4>
                                <button class="modal-modern-close" onclick="closeModal({{ $booking->id }})">&times;</button>
                            </div>
                            <div class="modal-modern-body">
                                <!-- Tabs -->
                                <div class="modal-tabs">
                                    <button class="tab-btn active" onclick="showTab('organisasi{{ $booking->id }}', this)">Organisasi</button>
                                    <button class="tab-btn" onclick="showTab('ruangan{{ $booking->id }}', this)">Ruangan</button>
                                    <button class="tab-btn" onclick="showTab('peminjaman{{ $booking->id }}', this)">Peminjaman</button>
                                    <button class="tab-btn" onclick="showTab('dokumen{{ $booking->id }}', this)">Dokumen</button>
                                </div>

                                <!-- Tab Organisasi -->
                                <div id="organisasi{{ $booking->id }}" class="tab-content active">
                                    <div class="info-grid-2">
                                        <div class="info-item">
                                            <div class="info-label">Nama Organisasi</div>
                                            <div class="info-value">{{ $booking->user->nama_organisasi ?? $booking->user->name }}</div>
                                        </div>
                                        <div class="info-item">
                                            <div class="info-label">Jenis Organisasi</div>
                                            <div class="info-value">{{ $booking->user->jenis_organisasi ?? '-' }}</div>
                                        </div>
                                        <div class="info-item">
                                            <div class="info-label">Ketua Organisasi</div>
                                            <div class="info-value">{{ $booking->user->ketua_organisasi ?? '-' }}</div>
                                        </div>
                                        <div class="info-item">
                                            <div class="info-label">Email</div>
                                            <div class="info-value">{{ $booking->user->email }}</div>
                                        </div>
                                        <div class="info-item">
                                            <div class="info-label">No. Telepon</div>
                                            <div class="info-value">{{ $booking->user->no_telp ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab Ruangan -->
                                <div id="ruangan{{ $booking->id }}" class="tab-content" style="display: none;">
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

                                <!-- Tab Peminjaman -->
                                <div id="peminjaman{{ $booking->id }}" class="tab-content" style="display: none;">
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
                                            <div class="info-label">Tanggal Pinjam</div>
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
                                                    <span class="badge-pending">Pending</span>
                                                @elseif($booking->status == 'disetujui')
                                                    <span class="badge-approved">Disetujui</span>
                                                @else
                                                    <span class="badge-rejected">Ditolak</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab Dokumen -->
                                <div id="dokumen{{ $booking->id }}" class="tab-content" style="display: none;">
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


                                @if($booking->status == 'pending')
                                <div class="modal-actions">
                                    <button class="btn-approve" onclick="showApproveModal({{ $booking->id }})">
                                        <i class="fas fa-check-circle me-2"></i>Setujui Peminjaman
                                    </button>
                                    {{-- <button class="btn-reject" onclick="showRejectModal({{ $booking->id }})">
                                        <i class="fas fa-times-circle me-2"></i>Tolak Peminjaman
                                    </button> --}}
                                    <button class="btn-reject" onclick="showRejectModal({{ $booking->id }}, '{{ route('admin.peminjaman.reject', $booking) }}')">
                                        <i class="fas fa-times-circle me-2"></i>Tolak Peminjaman
                                    </button>
                                </div>

                                <!-- Modal Approve -->
                                <div id="approveModal{{ $booking->id }}" class="modal-confirm" style="display: none;">
                                    <div class="modal-confirm-content">
                                        <div class="modal-confirm-icon success">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        <h3>Setujui Peminjaman</h3>
                                        <p>Apakah Anda yakin ingin menyetujui peminjaman ini?</p>
                                        <div class="modal-confirm-buttons">
                                            <button class="btn-no" onclick="closeApproveModal({{ $booking->id }})">Batal</button>
                                            <form action="{{ route('admin.peminjaman.approve', $booking) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn-yes">Ya, Setujui</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="modal-modern-footer">
                                <button class="btn-close" onclick="closeModal({{ $booking->id }})">
                                    <i class="fas fa-times me-2"></i>Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-2"></i>
                            <p class="text-muted">Belum ada data peminjaman</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination-modern">
            @if ($bookings->hasPages())
                <ul class="pagination">
                    @if ($bookings->onFirstPage())
                        <li class="disabled"><span><i class="fas fa-chevron-left"></i> Prev</span></li>
                    @else
                        <li><a href="{{ $bookings->previousPageUrl() }}"><i class="fas fa-chevron-left"></i> Prev</a></li>
                    @endif

                    @foreach ($bookings->getUrlRange(1, $bookings->lastPage()) as $page => $url)
                        @if ($page == $bookings->currentPage())
                            <li class="active"><span>{{ $page }}</span></li>
                        @else
                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach

                    @if ($bookings->hasMorePages())
                        <li><a href="{{ $bookings->nextPageUrl() }}">Next <i class="fas fa-chevron-right"></i></a></li>
                    @else
                        <li class="disabled"><span>Next <i class="fas fa-chevron-right"></i></span></li>
                    @endif
                </ul>
            @endif
        </div>
    </div>
</div>

<style>
    .page-title {
        font-size: 22px;
        font-weight: 700;
        color: #1f2937;
        margin: 0;
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
    }
    .stat-card:hover { transform: translateY(-2px); box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
    .stat-icon { width: 50px; height: 50px; border-radius: 14px; display: flex; align-items: center; justify-content: center; color: white; font-size: 22px; }
    .stat-icon.bg-primary { background: linear-gradient(135deg, #667eea, #764ba2); }
    .stat-icon.bg-warning { background: linear-gradient(135deg, #f59e0b, #d97706); }
    .stat-icon.bg-success { background: linear-gradient(135deg, #10b981, #059669); }
    .stat-icon.bg-danger { background: linear-gradient(135deg, #ef4444, #dc2626); }
    .stat-info h3 { font-size: 24px; font-weight: 700; margin: 0; color: #1f2937; }
    .stat-info p { margin: 0; font-size: 12px; color: #6b7280; }

    /* Table */
    .card-table { background: white; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); overflow: hidden; }
    .table-responsive { overflow-x: auto; }
    .table-modern { width: 100%; border-collapse: collapse; font-size: 13px; }
    .table-modern th { padding: 14px 12px; background: #f8fafc; font-weight: 600; color: #1f2937; border-bottom: 1px solid #e5e7eb; }
    .table-modern td { padding: 12px; border-bottom: 1px solid #f0f0f0; vertical-align: middle; }
    .table-modern tr:hover { background: #f9fafb; }

    /* Badges */
    .badge-pending, .badge-approved, .badge-rejected {
        display: inline-flex;
        align-items: center;
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
        padding: 6px 14px;
        border-radius: 8px;
        color: #0284c7;
        font-size: 12px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-detail:hover { background: #bae6fd; transform: translateY(-1px); }

    /* Modal Modern */
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
    }
    .modal-modern-header {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 18px 24px;
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
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .modal-modern-close:hover { background: rgba(140, 93, 152, 0.3); transform: scale(1.05); }
    .modal-modern-body { padding: 24px; }
    .modal-modern-footer {
        padding: 16px 24px;
        border-top: 1px solid #e5e7eb;
        text-align: right;
        background: white;
        position: sticky;
        bottom: 0;
        border-radius: 0 0 24px 24px;
    }
    .btn-close {
        background: #f3f4f6;
        border: none;
        padding: 10px 24px;
        border-radius: 12px;
        color: #4b5563;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-close:hover {
        background: #e5e7eb;
    }
    .btn-close i {
        font-size: 14px;
    }

    /* Tabs */
    .modal-tabs {
        display: flex;
        gap: 8px;
        margin-bottom: 24px;
        border-bottom: 1px solid #e5e7eb;
        padding-bottom: 8px;
    }
    .tab-btn {
        background: none;
        border: none;
        padding: 8px 20px;
        font-size: 14px;
        font-weight: 500;
        color: #6b7280;
        cursor: pointer;
        border-radius: 8px;
        transition: all 0.2s;
    }
    .tab-btn:hover { background: #f3f4f6; color: #1f2937; }
    .tab-btn.active {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
    }
    .tab-content { animation: fadeIn 0.2s ease; }

    /* Info Grid */
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
    .info-item.full-width { grid-column: span 2; }
    .info-label { font-size: 11px; color: #9ca3af; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px; }
    .info-value { font-size: 14px; font-weight: 600; color: #1f2937; }

    /* Dokumen Cards */
    .docs-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    .doc-card {
        background: #f8fafc;
        border-radius: 16px;
        padding: 20px;
        text-align: center;
        transition: all 0.2s;
    }
    .doc-card:hover { transform: translateY(-3px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
    .doc-icon { width: 60px; height: 60px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; }
    .doc-icon i { font-size: 28px; color: white; }
    .doc-title { font-size: 16px; font-weight: 700; color: #1f2937; margin-bottom: 4px; }
    .doc-desc { font-size: 12px; color: #6b7280; margin-bottom: 16px; }
    .doc-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: white;
        border: 1px solid #e5e7eb;
        padding: 8px 20px;
        border-radius: 30px;
        color: #667eea;
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.2s;
    }
    .doc-btn:hover { background: #667eea; border-color: #667eea; color: white; }
    .doc-empty { font-size: 13px; color: #9ca3af; }

    /* Modal Actions */
    .modal-actions {
        display: flex;
        gap: 12px;
        justify-content: center;
        margin-top: 24px;
        padding-top: 20px;
        border-top: 1px solid #e5e7eb;
    }
    .btn-approve {
        background: linear-gradient(135deg, #10b981, #059669);
        border: none;
        padding: 10px 28px;
        border-radius: 12px;
        color: white;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }
    .btn-approve:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(16,185,129,0.4); }
    .btn-reject {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        border: none;
        padding: 10px 28px;
        border-radius: 12px;
        color: white;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }
    .btn-reject:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(220,38,38,0.4); }

    /* Modal Confirm */
    .modal-confirm {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.6);
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
        animation: modalFadeIn 0.2s ease;
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
    .modal-confirm-icon.danger { background: #fee2e2; color: #dc2626; }
    .modal-confirm-content h3 { font-size: 20px; margin-bottom: 8px; color: #1f2937; }
    .modal-confirm-content p { font-size: 14px; color: #6b7280; margin-bottom: 24px; }
    .modal-confirm-buttons { display: flex; gap: 12px; justify-content: center; }
    .btn-yes, .btn-no {
        padding: 10px 24px;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        border: none;
    }
    .btn-yes { background: linear-gradient(135deg, #10b981, #059669); color: white; }
    .btn-no { background: #f3f4f6; color: #4b5563; }
    .btn-yes:hover, .btn-no:hover { transform: translateY(-2px); }

    /* Pagination */
    .pagination-modern {
        padding: 20px;
        border-top: 1px solid #e5e7eb;
        display: flex;
        justify-content: center;
        background: white;
    }
    .pagination {
        display: flex;
        gap: 8px;
        list-style: none;
        margin: 0;
        padding: 0;
        align-items: center;
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
    .pagination li a:hover { background: #e5e7eb; color: #1f2937; }
    .pagination li.active span { background: linear-gradient(135deg, #667eea, #764ba2); color: white; }
    .pagination li.disabled span { opacity: 0.5; cursor: not-allowed; background: #f9fafb; }

    /* ========== DARK MODE STYLES ========== */
    .dark-mode .page-title {
        color: #e0e0e0 !important;
    }
    .dark-mode .stat-card {
        background-color: #1e293b !important;
    }
    .dark-mode .stat-info h3,
    .dark-mode .stat-info p {
        color: #e0e0e0 !important;
    }
    .dark-mode .card-table {
        background-color: #1e293b !important;
    }
    .dark-mode .table-modern th {
        background-color: #0f172a !important;
        color: #94a3b8 !important;
    }
    .dark-mode .table-modern td {
        color: #cbd5e1 !important;
        border-bottom-color: #334155 !important;
    }
    .dark-mode .table-modern tr:hover {
        background-color: #334155 !important;
    }
    .dark-mode .badge-pending {
        background-color: #78350f !important;
        color: #fde68a !important;
    }
    .dark-mode .badge-approved {
        background-color: #065f46 !important;
        color: #86efac !important;
    }
    .dark-mode .badge-rejected {
        background-color: #7f1d1d !important;
        color: #fca5a5 !important;
    }
    .dark-mode .btn-detail {
        background-color: #0e7490 !important;
        color: #7dd3fc !important;
    }
    .dark-mode .btn-detail:hover {
        background-color: #0891b2 !important;
        color: white !important;
    }
    .dark-mode .modal-modern-content {
        background-color: #1e293b !important;
    }
    .dark-mode .modal-modern-header {
        background: linear-gradient(135deg, #1e3c72, #2a5298) !important;
    }
    .dark-mode .modal-modern-body {
        background-color: #1e293b !important;
    }
    .dark-mode .modal-modern-footer {
        background-color: #1e293b !important;
        border-top-color: #334155 !important;
    }
    .dark-mode .tab-btn {
        color: #94a3b8 !important;
    }
    .dark-mode .tab-btn:hover {
        background-color: #334155 !important;
        color: #e0e0e0 !important;
    }
    .dark-mode .info-item {
        background-color: #0f172a !important;
    }
    .dark-mode .info-label {
        color: #64748b !important;
    }
    .dark-mode .info-value {
        color: #e0e0e0 !important;
    }
    .dark-mode .doc-card {
        background-color: #0f172a !important;
    }
    .dark-mode .doc-title {
        color: #e0e0e0 !important;
    }
    .dark-mode .doc-desc {
        color: #94a3b8 !important;
    }
    .dark-mode .doc-btn {
        background-color: #1e293b !important;
        border-color: #475569 !important;
        color: #818cf8 !important;
    }
    .dark-mode .doc-btn:hover {
        background-color: #818cf8 !important;
        color: white !important;
    }
    .dark-mode .pagination-modern {
        background-color: #1e293b !important;
        border-top-color: #334155 !important;
    }
    .dark-mode .pagination li a,
    .dark-mode .pagination li span {
        background-color: #334155 !important;
        color: #cbd5e1 !important;
    }
    .dark-mode .pagination li a:hover {
        background-color: #475569 !important;
        color: white !important;
    }
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
    .dark-mode .btn-no:hover {
        background-color: #475569 !important;
        color: white !important;
    }

    @keyframes modalFadeIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

    @media (max-width: 768px) {
        .info-grid-2 { grid-template-columns: 1fr; }
        .info-item.full-width { grid-column: span 1; }
        .docs-grid { grid-template-columns: 1fr; }
        .modal-tabs { flex-wrap: wrap; }
        .modal-actions { flex-direction: column; align-items: center; }
        .modal-modern-content { width: 95%; margin: 10px; }
    }
</style>

<script>
    function openModal(id) {
        document.getElementById('modalDetail' + id).style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeModal(id) {
        document.getElementById('modalDetail' + id).style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    function showTab(tabId, btn) {
        const modal = btn.closest('.modal-modern');
        const tabs = modal.querySelectorAll('.tab-content');
        const btns = modal.querySelectorAll('.tab-btn');

        tabs.forEach(tab => tab.style.display = 'none');
        btns.forEach(b => b.classList.remove('active'));

        document.getElementById(tabId).style.display = 'block';
        btn.classList.add('active');
    }

    window.onclick = function(event) {
        if (event.target.classList.contains('modal-modern')) {
            event.target.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    }

    function showApproveModal(id) {
        document.getElementById('approveModal' + id).style.display = 'flex';
    }

    function closeApproveModal(id) {
        document.getElementById('approveModal' + id).style.display = 'none';
    }

    // Variabel untuk menyimpan form action sementara
let currentRejectAction = '';

function showRejectModal(id, formAction) {
    const modal = document.getElementById('rejectModal');
    const form = document.getElementById('rejectForm');
    const textarea = document.getElementById('alasanPenolakan');

    // Set form action
    form.action = formAction;
    currentRejectAction = formAction;

    // Clear previous value
    textarea.value = '';

    // Remove any existing error message
    const existingError = document.querySelector('.reject-error');
    if (existingError) existingError.remove();

    // Show modal
    if (modal) modal.style.display = 'flex';
}

function closeRejectModal() {
    const modal = document.getElementById('rejectModal');
    const textarea = document.getElementById('alasanPenolakan');
    if (modal) modal.style.display = 'none';
    if (textarea) textarea.value = '';

    // Remove error message
    const existingError = document.querySelector('.reject-error');
    if (existingError) existingError.remove();
}

// Handle form submission
document.addEventListener('DOMContentLoaded', function() {
    const rejectForm = document.getElementById('rejectForm');
    if (rejectForm) {
        rejectForm.addEventListener('submit', function(e) {
            const alasan = document.getElementById('alasanPenolakan').value.trim();
            if (!alasan) {
                e.preventDefault();
                let errorDiv = document.querySelector('.reject-error');
                if (!errorDiv) {
                    errorDiv = document.createElement('div');
                    errorDiv.className = 'reject-error';
                    errorDiv.style.cssText = 'color: #dc2626; font-size: 12px; margin-top: -15px; margin-bottom: 15px; text-align: left;';
                    const modalContent = document.querySelector('#rejectModal .modal-confirm-content');
                    if (modalContent) {
                        modalContent.insertBefore(errorDiv, document.querySelector('#rejectModal .modal-confirm-buttons'));
                    }
                }
                errorDiv.innerHTML = '<i class="fas fa-exclamation-circle me-1"></i> Alasan penolakan harus diisi!';
                return false;
            }
        });
    }
});

</script>

<!-- ========================================== -->
<!-- MODAL PDF VIEWER (UNTUK MENAMPILKAN PDF)    -->
<!-- ========================================== -->
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

<style>
    /* Modal PDF Viewer Styles */
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
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }
    .modal-pdf-header {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .modal-pdf-header h5 {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
    }
    .modal-pdf-close {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        font-size: 24px;
        color: white;
        cursor: pointer;
        transition: all 0.2s;
    }
    .modal-pdf-close:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: scale(1.05);
    }
    .modal-pdf-body {
        flex: 1;
        padding: 20px;
        background: #1a1a2e;
        min-height: 400px;
    }
    .modal-pdf-body iframe {
        background: white;
    }
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
        transition: all 0.2s;
    }
    .btn-download-pdf:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
    }
    .btn-close-pdf {
        background: #f3f4f6;
        border: none;
        padding: 8px 24px;
        border-radius: 40px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-close-pdf:hover {
        background: #e5e7eb;
    }

    /* Dark Mode Styles */
    .dark-mode .modal-pdf-content {
        background: #1e293b;
    }
    .dark-mode .modal-pdf-body {
        background: #0f172a;
    }
    .dark-mode .modal-pdf-footer {
        background: #1e293b;
        border-top-color: #334155;
    }
    .dark-mode .btn-close-pdf {
        background: #334155;
        color: white;
    }
    .dark-mode .btn-close-pdf:hover {
        background: #475569;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .modal-pdf-content {
            width: 95%;
            max-height: 95vh;
        }
        .modal-pdf-body iframe {
            height: 300px;
        }
    }
</style>

<script>
    // Variabel untuk menyimpan URL PDF saat ini
    let currentPdfUrl = '';

    // Fungsi untuk membuka modal PDF viewer
    function openPdfViewer(url) {
        console.log('Membuka PDF:', url);
        currentPdfUrl = url;

        // Tampilkan loading indicator
        const pdfFrame = document.getElementById('pdfFrame');
        if (pdfFrame) {
            pdfFrame.src = url;
        }

        // Tampilkan modal
        const modal = document.getElementById('pdfModal');
        if (modal) {
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        } else {
            console.error('Modal PDF tidak ditemukan!');
            alert('Modal PDF viewer tidak tersedia. Silakan refresh halaman.');
        }
    }

    // Fungsi untuk menutup modal PDF viewer
    function closePdfViewer() {
        const pdfFrame = document.getElementById('pdfFrame');
        if (pdfFrame) {
            pdfFrame.src = '';
        }

        const modal = document.getElementById('pdfModal');
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    }

    // Fungsi untuk download PDF
    function downloadPdf() {
        if (currentPdfUrl) {
            window.open(currentPdfUrl, '_blank');
        }
    }

    // Tutup modal jika klik di luar area modal
    window.onclick = function(event) {
        const modal = document.getElementById('pdfModal');
        if (event.target === modal) {
            closePdfViewer();
        }
    }

    // Debug: cek apakah fungsi sudah terdaftar
    console.log('PDF Viewer functions ready:', typeof openPdfViewer);
</script>

<!-- Modal Image Viewer -->
<div id="imageModal" class="modal-image" style="display: none;">
    <div class="modal-image-content">
        <button class="modal-image-close" onclick="closeImageModal()">&times;</button>
        <img id="imageViewer" src="" alt="Preview">
    </div>
</div>

<style>
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
</style>

<script>
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
</script>
<!-- ========================================== -->
<!-- MODAL REJECT DENGAN ALASAN (GLOBAL)         -->
<!-- ========================================== -->
<div id="rejectModal" class="modal-confirm" style="display: none;">
    <div class="modal-confirm-content" style="max-width: 500px;">
        <div class="modal-confirm-icon danger">
            <i class="fas fa-times-circle"></i>
        </div>
        <h3>Tolak Peminjaman</h3>
        <p>Silakan isi alasan penolakan peminjaman ini:</p>

        <form id="rejectForm" method="POST">
            @csrf
            <textarea name="alasan" id="alasanPenolakan" class="form-control-reject"
                    rows="4" placeholder="Contoh: Jadwal bentrok dengan kegiatan lain..."
                    required style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #e5e7eb; margin-bottom: 20px; resize: vertical;"></textarea>

            <div class="modal-confirm-buttons">
                <button type="button" class="btn-no" onclick="closeRejectModal()">Batal</button>
                <button type="submit" class="btn-yes" id="submitRejectBtn">Ya, Tolak</button>
            </div>
        </form>
    </div>
</div>

@endsection
