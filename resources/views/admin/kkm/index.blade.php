@extends('layouts.app')

@section('title', 'Data KKM')
@section('page-title', 'Data KKM')
@section('breadcrumb')
    <span>Admin</span> / Data KKM
@endsection

@push('styles')
<style>
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        gap: 12px;
        flex-wrap: wrap;
    }
    .page-header-left h2 { font-size: 20px; font-weight: 800; color: var(--text); }
    .page-header-left p  { font-size: 13px; color: var(--muted); margin-top: 2px; }

    .btn {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 9px 16px; border-radius: 8px; font-size: 13px;
        font-weight: 600; cursor: pointer; border: none;
        text-decoration: none; transition: all .18s;
        font-family: inherit;
    }
    .btn-primary { background: var(--accent); color: #fff; box-shadow: 0 2px 10px rgba(79,142,247,.3); }
    .btn-primary:hover { background: #3a7bf5; transform: translateY(-1px); }
    .btn-sm { padding: 6px 11px; font-size: 12px; }
    .btn-edit   { background: rgba(124,106,247,.15); color: #7c6af7; }
    .btn-edit:hover   { background: rgba(124,106,247,.3); }
    .btn-delete { background: rgba(248,113,113,.12); color: var(--danger); }
    .btn-delete:hover { background: rgba(248,113,113,.25); }
    .btn-cancel { background: var(--surface-2); color: var(--muted); border: 1px solid var(--border); }
    .btn-cancel:hover { color: var(--text); }
    .btn-danger { background: var(--danger); color: #fff; }
    .btn-danger:hover { background: #ef4444; }

    .toolbar {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 14px 18px;
        margin-bottom: 16px;
        display: flex; gap: 12px; flex-wrap: wrap; align-items: center;
    }
    .search-box {
        flex: 1; min-width: 200px;
        display: flex; align-items: center; gap: 8px;
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 8px 12px;
    }
    .search-box i { color: var(--muted); font-size: 13px; }
    .search-box input {
        background: none; border: none; outline: none;
        color: var(--text); font-size: 13px; width: 100%;
        font-family: inherit;
    }
    .search-box input::placeholder { color: var(--muted); }
    .filter-select {
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 8px 12px;
        color: var(--text); font-size: 13px;
        font-family: inherit; outline: none; cursor: pointer;
    }

    .table-wrap {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
    }
    table { width: 100%; border-collapse: collapse; }
    thead tr { background: var(--surface-2); border-bottom: 1px solid var(--border); }
    th {
        padding: 12px 16px; text-align: left;
        font-size: 11px; font-weight: 700;
        text-transform: uppercase; letter-spacing: .8px;
        color: var(--muted); white-space: nowrap;
    }
    tbody tr { border-bottom: 1px solid var(--border); transition: background .15s; }
    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: var(--surface-2); }
    td { padding: 13px 16px; font-size: 13.5px; vertical-align: middle; }

    .mapel-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .mapel-avatar {
        width: 34px; height: 34px; border-radius: 8px;
        display: grid; place-items: center;
        font-size: 10px; font-weight: 700; color: #fff; flex-shrink: 0;
        background: linear-gradient(135deg, #4f8ef7, #7c6af7);
    }
    .kelas-avatar {
        width: 34px; height: 34px; border-radius: 8px;
        display: grid; place-items: center;
        font-size: 10px; font-weight: 700; color: #fff; flex-shrink: 0;
        background: linear-gradient(135deg, #f59e0b, #f97316);
    }
    .mapel-name { font-weight: 600; color: var(--text); }
    .mapel-kode { font-size: 11.5px; color: var(--muted); font-family: 'JetBrains Mono', monospace; }
    .kelas-name { font-weight: 600; color: var(--text); }
    .kelas-level { font-size: 11.5px; color: var(--muted); }

    .badge-kkm {
        display: inline-block; padding: 4px 12px;
        border-radius: 20px; font-size: 13px; font-weight: 700;
        background: rgba(79,142,247,.12); color: #4f8ef7;
    }
    .badge-kkm-high {
        background: rgba(16,185,129,.12); color: #10b981;
    }
    .badge-kkm-low {
        background: rgba(248,113,113,.12); color: #ef4444;
    }

    .actions { display: flex; gap: 6px; }

    .pagination-wrap {
        padding: 14px 18px;
        border-top: 1px solid var(--border);
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 10px;
        font-size: 12.5px; color: var(--muted);
    }
    .pagination-wrap .pagination { display: flex; gap: 4px; list-style: none; }
    .pagination-wrap .page-item .page-link {
        display: inline-flex; align-items: center; justify-content: center;
        min-width: 32px; height: 32px; padding: 0 8px;
        border-radius: 7px; background: var(--surface-2);
        border: 1px solid var(--border); color: var(--muted);
        font-size: 12.5px; text-decoration: none; transition: all .15s;
    }
    .pagination-wrap .page-item.active .page-link { background: var(--accent); border-color: var(--accent); color: #fff; }
    .pagination-wrap .page-item .page-link:hover { border-color: var(--accent); color: var(--accent); }
    .pagination-wrap .page-item.disabled .page-link { opacity: .4; pointer-events: none; }

    .empty-state { text-align: center; padding: 60px 20px; color: var(--muted); }
    .empty-state i { font-size: 40px; margin-bottom: 12px; display: block; opacity: .3; }
    .empty-state p { font-size: 14px; }

    .modal-overlay {
        display: none; position: fixed; inset: 0;
        background: rgba(0,0,0,.6); backdrop-filter: blur(4px);
        z-index: 200; align-items: center; justify-content: center;
    }
    .modal-overlay.show { display: flex; }
    .modal-box {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: 16px; padding: 28px;
        max-width: 380px; width: 90%;
        animation: fadeUp .25s ease;
    }
    .modal-box h3 { font-size: 17px; font-weight: 700; margin-bottom: 8px; }
    .modal-box p  { font-size: 13.5px; color: var(--muted); margin-bottom: 22px; }
    .modal-actions { display: flex; gap: 10px; justify-content: flex-end; }
</style>
@endpush

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h2>Data KKM</h2>
        <p>Total {{ $kkm->total() }} data KKM terdaftar</p>
    </div>
    <a href="{{ route('admin.kkm.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah KKM
    </a>
</div>

{{-- TOOLBAR --}}
<form method="GET" action="{{ route('admin.kkm.index') }}" class="toolbar">
    <div class="search-box">
        <i class="fas fa-magnifying-glass"></i>
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari mata pelajaran atau kelas...">
    </div>
    <select name="kelas_id" class="filter-select" onchange="this.form.submit()">
        <option value="">Semua Kelas</option>
        @foreach($kelasList ?? [] as $kelas)
            <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>
                {{ $kelas->nama_kelas }}
            </option>
        @endforeach
    </select>
    @if(request()->hasAny(['q', 'kelas_id']))
        <a href="{{ route('admin.kkm.index') }}" class="btn btn-cancel btn-sm">
            <i class="fas fa-xmark"></i> Reset
        </a>
    @endif
</form>

{{-- TABLE --}}
<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Mata Pelajaran</th>
                <th>Kelas</th>
                <th>Nilai KKM</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kkm as $i => $item)
            <tr>
                <td style="color:var(--muted); font-size:12px">{{ $kkm->firstItem() + $i }}</td>
                <td>
                    <div class="mapel-cell">
                        <div class="mapel-avatar">
                            {{ strtoupper(substr($item->mataPelajaran->kode_mapel ?? 'MAPEL', 0, 3)) }}
                        </div>
                        <div>
                            <div class="mapel-name">{{ $item->mataPelajaran->nama_mapel ?? '-' }}</div>
                            <div class="mapel-kode">{{ $item->mataPelajaran->kode_mapel ?? '-' }}</div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="mapel-cell">
                        <div class="kelas-avatar">
                            {{ strtoupper(substr($item->kelas->nama_kelas ?? 'KLS', 0, 2)) }}
                        </div>
                        <div>
                            <div class="kelas-name">{{ $item->kelas->nama_kelas ?? '-' }}</div>
                            <div class="kelas-level">{{ $item->kelas->tingkat ?? '-' }}</div>
                        </div>
                    </div>
                </td>
                <td>
                    <span class="badge-kkm {{ $item->nilai_kkm >= 75 ? 'badge-kkm-high' : ($item->nilai_kkm < 60 ? 'badge-kkm-low' : '') }}">
                        {{ $item->nilai_kkm }}
                    </span>
                </td>
                <td>
                    @php
                        $status = $item->nilai_kkm >= 75 ? 'Tinggi' : ($item->nilai_kkm >= 60 ? 'Sedang' : 'Rendah');
                        $statusColor = $item->nilai_kkm >= 75 ? '#10b981' : ($item->nilai_kkm >= 60 ? '#f59e0b' : '#ef4444');
                    @endphp
                    <span style="color: {{ $statusColor }}; font-size: 12px; font-weight: 600;">
                        ● {{ $status }}
                    </span>
                </td>
                <td>
                    <div class="actions">
                        <a href="{{ route('admin.kkm.edit', $item) }}" class="btn btn-edit btn-sm">
                            <i class="fas fa-pen"></i> Edit
                        </a>
                        <button type="button" class="btn btn-delete btn-sm"
                            onclick="confirmDelete({{ $item->id }}, '{{ addslashes($item->mataPelajaran->nama_mapel ?? '') }} - {{ addslashes($item->kelas->nama_kelas ?? '') }}')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6">
                    <div class="empty-state">
                        <i class="fas fa-chart-line"></i>
                        <p>Belum ada data KKM.</p>
                        <p style="font-size: 12px; margin-top: 8px;">Silakan tambah KKM baru dengan klik tombol "Tambah KKM"</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination-wrap">
        <span>
            Menampilkan {{ $kkm->firstItem() }}–{{ $kkm->lastItem() }}
            dari {{ $kkm->total() }} data KKM
        </span>
        {{ $kkm->appends(request()->query())->links() }}
    </div>
</div>

{{-- DELETE MODAL --}}
<div class="modal-overlay" id="deleteModal">
    <div class="modal-box">
        <h3>🗑️ Hapus KKM</h3>
        <p>Apakah kamu yakin ingin menghapus KKM untuk <strong id="deleteKkmName"></strong>?
           Data nilai yang terkait dengan KKM ini akan terpengaruh.</p>
        <div class="modal-actions">
            <button class="btn btn-cancel" onclick="closeModal()">Batal</button>
            <form id="deleteForm" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function confirmDelete(id, name) {
    document.getElementById('deleteKkmName').textContent = name;
    document.getElementById('deleteForm').action = `/admin/kkm/${id}`;
    document.getElementById('deleteModal').classList.add('show');
}
function closeModal() {
    document.getElementById('deleteModal').classList.remove('show');
}
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});

const searchInput = document.querySelector('.search-box input');
let searchTimer;
if (searchInput) {
    searchInput.addEventListener('input', () => {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => searchInput.closest('form').submit(), 500);
    });
}
</script>
@endpush