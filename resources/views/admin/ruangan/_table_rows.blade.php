@if($ruangans->count() > 0)
<div class="card-modern">
    <div class="table-responsive">
        <table class="table-modern">
            <thead>
                <tr>
                    <th class="text-center" width="5%">No</th>
                    <th class="text-center" width="10%">Foto</th>
                    <th width="20%">Nama Ruangan</th>
                    <th width="12%">Kode Ruangan</th>
                    <th width="18%">Lokasi</th>
                    <th class="text-center" width="10%">Kapasitas</th>
                    <th class="text-center" width="10%">Status</th>
                    <th class="text-center" width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ruangans as $index => $ruangan)
                <tr>
                    <td class="text-center">{{ $ruangans->firstItem() + $index }}</td>
                    <td class="text-center">
                        @if($ruangan->foto && file_exists(public_path($ruangan->foto)))
                            <img src="{{ asset($ruangan->foto) }}" width="45" height="45" style="border-radius: 10px; object-fit: cover;">
                        @elseif($ruangan->foto && file_exists(storage_path('app/public/ruangan/' . $ruangan->foto)))
                            <img src="{{ asset('storage/ruangan/' . $ruangan->foto) }}" width="45" height="45" style="border-radius: 10px; object-fit: cover;">
                        @else
                            <div class="avatar-placeholder">
                                <i class="fas fa-door-open"></i>
                            </div>
                        @endif
                    </td>
                    <td>
                        <strong>{{ $ruangan->nama_ruangan }}</strong><br>
                        <small class="text-muted">{{ $ruangan->kode_ruangan }}</small>
                    </td>
                    <td>{{ $ruangan->kode_ruangan }}</td>
                    <td>{{ $ruangan->lokasi }}</td>
                    <td class="text-center">{{ $ruangan->kapasitas }} orang</td>
                    <td class="text-center">
                        @if($ruangan->status == 'tersedia')
                            <span class="badge-tersedia">Tersedia</span>
                        @elseif($ruangan->status == 'dipinjam')
                            <span class="badge-dipinjam">Dipinjam</span>
                        @else
                            <span class="badge-perbaikan">Perbaikan</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <button onclick="showDetailRuangan({{ $ruangan->id }})" class="btn-action btn-detail" title="Detail">
                            <i class="fas fa-eye"></i>
                        </button>
                        <a href="{{ route('admin.ruangan.edit', $ruangan) }}" class="btn-action btn-edit" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button onclick="confirmAction(event, 'deleteForm{{ $ruangan->id }}', 'Ruangan {{ $ruangan->nama_ruangan }}', 'delete')" class="btn-action btn-delete" title="Hapus">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
                <form id="deleteForm{{ $ruangan->id }}" action="{{ route('admin.ruangan.destroy', $ruangan) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
                @endforeach
            </tbody>
        </table>
    </div>


    <div class="d-flex justify-content-center mt-4">
        @if ($ruangans->hasPages())
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    {{-- Previous Page Link --}}
                    @if ($ruangans->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link"><i class="fas fa-chevron-left"></i> Previous</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $ruangans->previousPageUrl() }}">
                                <i class="fas fa-chevron-left"></i> Previous
                            </a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($ruangans->getUrlRange(1, $ruangans->lastPage()) as $page => $url)
                        @if ($page == $ruangans->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($ruangans->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $ruangans->nextPageUrl() }}">
                                Next <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link">Next <i class="fas fa-chevron-right"></i></span>
                        </li>
                    @endif
                </ul>
            </nav>
        @endif
    </div>
</div>
@else
<div class="empty-state">
    <i class="fas fa-door-closed fa-4x text-muted mb-3"></i>
    <h5 class="text-muted">Belum ada data ruangan</h5>
    <p class="text-muted">Silakan tambah ruangan baru dengan klik tombol di atas</p>
    <a href="{{ route('admin.ruangan.create') }}" class="btn-custom mt-3">
        <i class="fas fa-plus me-2"></i>Tambah Ruangan
    </a>
</div>
@endif

<style>
    .card-modern {
        background: white;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .table-modern {
        width: 100%;
        border-collapse: collapse;
    }

    .table-modern th {
        padding: 12px 10px;
        background: #f8fafc;
        font-weight: 600;
        font-size: 13px;
        color: #1f2937;
        border-bottom: 1px solid #e5e7eb;
    }

    .table-modern td {
        padding: 12px 10px;
        font-size: 13px;
        border-bottom: 1px solid #f0f0f0;
        vertical-align: middle;
    }

    .table-modern tr:hover {
        background: #f9fafb;
    }

    .avatar-placeholder {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }

    .avatar-placeholder i {
        color: white;
        font-size: 20px;
    }

    .badge-tersedia {
        background: #d1fae5;
        color: #059669;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
    }

    .badge-dipinjam {
        background: #fef3c7;
        color: #d97706;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
    }

    .badge-perbaikan {
        background: #fee2e2;
        color: #dc2626;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
    }

    .btn-action {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        margin: 0 2px;
        text-decoration: none;
    }

    .btn-detail {
        background: #e0f2fe;
        color: #0284c7;
    }

    .btn-detail:hover {
        background: #bae6fd;
        transform: translateY(-2px);
    }

    .btn-edit {
        background: #fef3c7;
        color: #d97706;
    }

    .btn-edit:hover {
        background: #fde68a;
        transform: translateY(-2px);
    }

    .btn-delete {
        background: #fee2e2;
        color: #dc2626;
    }

    .btn-delete:hover {
        background: #fecaca;
        transform: translateY(-2px);
    }

    .pagination-wrapper {
        margin-top: 20px;
        padding-top: 16px;
        border-top: 1px solid #e5e7eb;
        display: flex;
        justify-content: center;
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

    .pagination li {
        display: inline-block;
    }

    .pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        height: 36px;
        padding: 0 12px;
        background: #f3f4f6;
        border: none;
        border-radius: 10px;
        color: #4b5563;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s;
        cursor: pointer;
    }

    .pagination .page-link:hover {
        background: #e5e7eb;
        color: #1f2937;
        transform: translateY(-1px);
    }

    .pagination .active .page-link {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        box-shadow: 0 2px 6px rgba(102,126,234,0.3);
    }

    .pagination .disabled .page-link {
        opacity: 0.5;
        cursor: not-allowed;
        pointer-events: none;
        background: #f9fafb;
    }

    .pagination .page-link i {
        font-size: 11px;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 16px;
    }

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

    @media (max-width: 768px) {
        .table-modern th,
        .table-modern td {
            padding: 8px 6px;
            font-size: 11px;
        }

        .btn-action {
            width: 28px;
            height: 28px;
        }

        .btn-action i {
            font-size: 12px;
        }

        .pagination .page-link {
            min-width: 30px;
            height: 30px;
            padding: 0 8px;
            font-size: 11px;
        }

        .badge-tersedia,
        .badge-dipinjam,
        .badge-perbaikan {
            padding: 2px 8px;
            font-size: 9px;
        }
    }
</style>
