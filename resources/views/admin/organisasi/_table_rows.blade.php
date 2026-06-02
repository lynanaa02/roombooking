<div class="card-modern">
    <div class="table-responsive">
        <table class="table-modern">
            <thead>
                <tr>
                    <th class="text-center" width="4%">No</th>
                    <th class="text-center" width="8%">Logo</th>
                    <th width="18%">Nama Organisasi</th>
                    <th width="12%">Ketua</th>
                    <th class="text-center" width="8%">Jenis</th>
                    <th class="text-center" width="8%">Anggota</th>
                    <th width="15%">Email</th>
                    <th width="12%">Telepon</th>
                    <th class="text-center" width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($organisasis as $index => $organisasi)
                <tr>
                    <td class="text-center">{{ $organisasis->firstItem() + $index }}</td>
                    <td class="text-center">
                        @if($organisasi->foto && file_exists(public_path($organisasi->foto)))
                            <img src="{{ asset($organisasi->foto) }}" width="40" height="40" style="border-radius: 50%; object-fit: cover;">
                        @else
                            <div class="avatar-placeholder"><i class="fas fa-building"></i></div>
                        @endif
                    </td>
                    <td>
                        <strong>{{ $organisasi->nama_organisasi }}</strong><br>
                        <small class="text-muted">{{ $organisasi->name }}</small>
                    </td>
                    <td>{{ $organisasi->ketua_organisasi ?? '-' }}</td>
                    <td class="text-center">
                        @if($organisasi->jenis_organisasi == 'UKM')
                            <span class="badge-ukm">UKM</span>
                        @elseif($organisasi->jenis_organisasi == 'BEM')
                            <span class="badge-bem">BEM</span>
                        @elseif($organisasi->jenis_organisasi == 'Himpunan')
                            <span class="badge-himpunan">Himpunan</span>
                        @else
                            <span class="badge-default">-</span>
                        @endif
                    </td>
                    <td class="text-center">{{ $organisasi->jumlah_anggota ?? 0 }} org</td>
                    <td class="text-break">{{ $organisasi->email }}</td>
                    <td>{{ $organisasi->no_telp ?? '-' }}</td>
                    <td class="text-center">
                        <button onclick="showDetail({{ $organisasi->id }})" class="btn-action btn-detail" title="Detail"><i class="fas fa-eye"></i></button>
                        <a href="{{ route('admin.organisasi.edit', $organisasi) }}" class="btn-action btn-edit" title="Edit"><i class="fas fa-edit"></i></a>
                        <button onclick="confirmAction(event, 'deleteForm{{ $organisasi->id }}', '{{ $organisasi->nama_organisasi }}', 'delete')" class="btn-action btn-delete" title="Hapus"><i class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>
                <form id="deleteForm{{ $organisasi->id }}" action="{{ route('admin.organisasi.destroy', $organisasi) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-5">
                        <i class="fas fa-users-slash fa-3x text-muted mb-2"></i>
                        <p class="text-muted">Belum ada data organisasi</p>
                        <a href="{{ route('admin.organisasi.create') }}" class="btn-custom mt-2">Tambah Organisasi</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination-wrapper">
        @if ($organisasis->hasPages())
            <ul class="pagination">
                @if ($organisasis->onFirstPage())
                    <li class="disabled"><span class="page-link"><i class="fas fa-chevron-left"></i> Prev</span></li>
                @else
                    <li>
                        <a href="javascript:void(0)" class="page-link prev-link" data-page="{{ $organisasis->currentPage() - 1 }}">
                            <i class="fas fa-chevron-left"></i> Prev
                        </a>
                    </li>
                @endif

                @php
                    $currentPage = $organisasis->currentPage();
                    $lastPage = $organisasis->lastPage();
                    $start = max(1, $currentPage - 2);
                    $end = min($lastPage, $currentPage + 2);
                @endphp

                @if ($start > 1)
                    <li><a href="javascript:void(0)" class="page-link page-num" data-page="1">1</a></li>
                    @if ($start > 2)
                        <li class="disabled"><span class="page-link">...</span></li>
                    @endif
                @endif

                @for ($i = $start; $i <= $end; $i++)
                    @if ($i == $currentPage)
                        <li class="active"><span class="page-link">{{ $i }}</span></li>
                    @else
                        <li><a href="javascript:void(0)" class="page-link page-num" data-page="{{ $i }}">{{ $i }}</a></li>
                    @endif
                @endfor

                @if ($end < $lastPage)
                    @if ($end < $lastPage - 1)
                        <li class="disabled"><span class="page-link">...</span></li>
                    @endif
                    <li><a href="javascript:void(0)" class="page-link page-num" data-page="{{ $lastPage }}">{{ $lastPage }}</a></li>
                @endif

                @if ($organisasis->hasMorePages())
                    <li>
                        <a href="javascript:void(0)" class="page-link next-link" data-page="{{ $organisasis->currentPage() + 1 }}">
                            Next <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                @else
                    <li class="disabled"><span class="page-link">Next <i class="fas fa-chevron-right"></i></span></li>
                @endif
            </ul>
        @endif
    </div>
</div>

<style>
    .card-modern { background: white; border-radius: 16px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
    .table-modern { width: 100%; border-collapse: collapse; }
    .table-modern th { padding: 12px 10px; background: #f8fafc; font-weight: 600; font-size: 13px; color: #1f2937; border-bottom: 1px solid #e5e7eb; }
    .table-modern td { padding: 12px 10px; font-size: 13px; border-bottom: 1px solid #f0f0f0; vertical-align: middle; }
    .table-modern tr:hover { background: #f9fafb; }
    .avatar-placeholder { width: 40px; height: 40px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; }
    .avatar-placeholder i { color: white; font-size: 18px; }
    .badge-ukm, .badge-bem, .badge-himpunan, .badge-default { padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; display: inline-block; }
    .badge-ukm { background: #dbeafe; color: #1e40af; }
    .badge-bem { background: #d1fae5; color: #065f46; }
    .badge-himpunan { background: #fed7aa; color: #9a3412; }
    .badge-default { background: #f3f4f6; color: #4b5563; }
    .btn-action { width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; border: none; cursor: pointer; transition: all 0.2s; margin: 0 2px; }
    .btn-detail { background: #e0f2fe; color: #0284c7; }
    .btn-detail:hover { background: #bae6fd; }
    .btn-edit { background: #fef3c7; color: #d97706; }
    .btn-edit:hover { background: #fde68a; }
    .btn-delete { background: #fee2e2; color: #dc2626; }
    .btn-delete:hover { background: #fecaca; }
    .pagination-wrapper { margin-top: 20px; display: flex; justify-content: center; }
    .text-break { word-break: break-word; }

    .pagination {
        display: flex;
        gap: 6px;
        list-style: none;
        margin: 0;
        padding: 0;
        flex-wrap: wrap;
        justify-content: center;
    }
    .pagination li { display: inline-block; }
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
    @media (max-width: 768px) {
        .pagination .page-link {
            min-width: 32px;
            height: 32px;
            padding: 0 8px;
            font-size: 12px;
        }
    }
</style>
