@extends('layouts.app')

@section('title', 'Data Mata Pelajaran')
@section('page-title', 'Data Mata Pelajaran')
@section('breadcrumb')
    <span>Admin</span> / Data Mata Pelajaran
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

    .mapel-cell { display: flex; align-items: center; gap: 10px; }
    .mapel-avatar {
        width: 34px; height: 34px; border-radius: 8px;
        display: grid; place-items: center;
        font-size: 10px; font-weight: 700; color: #fff; flex-shrink: 0;
        background: linear-gradient(135deg, #4f8ef7, #7c6af7);
    }
    .mapel-name  { font-weight: 600; color: var(--text); }
    .mapel-kode  { font-size: 11.5px; color: var(--muted); font-family: 'JetBrains Mono', monospace; }

    .badge-sks {
        display: inline-block; padding: 3px 10px;
        border-radius: 6px; font-size: 12px; font-weight: 600;
        background: rgba(16,185,129,.12); color: #10b981;
    }

    .badge-guru {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 10px; border-radius: 6px;
        font-size: 12px; font-weight: 600;
        background: rgba(245,158,11,.10); color: #f59e0b;
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
        <h2>Data Mata Pelajaran</h2>
        <p>Total {{ $mapel->total() }} mata pelajaran terdaftar</p>
    </div>
    <a href="{{ route('admin.mapel.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Mapel
    </a>
</div>

{{-- TOOLBAR --}}
<form method="GET" action="{{ route('admin.mapel.index') }}" class="toolbar">
    <div class="search-box">
        <i class="fas fa-magnifying-glass"></i>
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama atau kode mata pelajaran...">
    </div>
    <select name="sks" class="filter-select" onchange="this.form.submit()">
        <option value="">Semua SKS</option>
        @foreach([1, 2, 3, 4, 5, 6] as $s)
            <option value="{{ $s }}" {{ request('sks') == $s ? 'selected' : '' }}>
                {{ $s }} SKS
            </option>
        @endforeach
    </select>
    @if(request()->hasAny(['q', 'sks']))
        <a href="{{ route('admin.mapel.index') }}" class="btn btn-cancel btn-sm">
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
                <th>Kode</th>
                <th>SKS</th>
                <th>Guru Pengampu</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($mapel as $i => $m)
            <tr>
                <td style="color:var(--muted); font-size:12px">{{ $mapel->firstItem() + $i }}</td>
                <td>
                    <div class="mapel-cell">
                        <div class="mapel-avatar">
                            {{ strtoupper(substr($m->kode_mapel, 0, 3)) }}
                        </div>
                        <div>
                            <div class="mapel-name">{{ $m->nama_mapel }}</div>
                            <div class="mapel-kode">{{ $m->kode_mapel }}</div>
                        </div>
                    </div>
                </td>
                <td style="font-family:'JetBrains Mono',monospace; font-size:12.5px; color:var(--muted)">
                    {{ $m->kode_mapel }}
                </td>
                <td>
                    <span class="badge-sks">{{ $m->sks }} SKS</span>
                </td>
                <td>
                    <span class="badge-guru">
                        <i class="fas fa-chalkboard-teacher"></i>
                        {{ $m->guru?->nama?? '-' }}
                    </span>
                </td>
                <td>
                    <div class="actions">
                        <a href="{{ route('admin.mapel.edit', $m) }}" class="btn btn-edit btn-sm">
                            <i class="fas fa-pen"></i> Edit
                        </a>
                        <button type="button" class="btn btn-delete btn-sm"
                            onclick="confirmDelete({{ $m->id }}, '{{ addslashes($m->nama_mapel) }}')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6">
                    <div class="empty-state">
                        <i class="fas fa-book-open"></i>
                        <p>Belum ada data mata pelajaran.</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination-wrap">
        <span>
            Menampilkan {{ $mapel->firstItem() }}–{{ $mapel->lastItem() }}
            dari {{ $mapel->total() }} mata pelajaran
        </span>
        {{ $mapel->appends(request()->query())->links() }}
    </div>
</div>

{{-- DELETE MODAL --}}
<div class="modal-overlay" id="deleteModal">
    <div class="modal-box">
        <h3>🗑️ Hapus Mata Pelajaran</h3>
        <p>Apakah kamu yakin ingin menghapus mata pelajaran <strong id="deleteMapelName"></strong>?
           Seluruh data terkait akan terpengaruh.</p>
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
    document.getElementById('deleteMapelName').textContent = name;
    document.getElementById('deleteForm').action = `/admin/mapel/${id}`;
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
searchInput.addEventListener('input', () => {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(() => searchInput.closest('form').submit(), 500);
});
</script>
@endpush