@extends('layouts.app')

@section('title', 'Data Kelas')
@section('page-title', 'Data Kelas')
@section('breadcrumb')
    <span>Admin</span> / Data Kelas
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

    .kelas-cell { display: flex; align-items: center; gap: 10px; }
    .kelas-avatar {
        width: 34px; height: 34px; border-radius: 8px;
        display: grid; place-items: center;
        font-size: 11px; font-weight: 700; color: #fff; flex-shrink: 0;
    }
    .kelas-avatar.X   { background: linear-gradient(135deg, #4f8ef7, #7c6af7); }
    .kelas-avatar.XI  { background: linear-gradient(135deg, #f59e0b, #f97316); }
    .kelas-avatar.XII { background: linear-gradient(135deg, #10b981, #0ea5e9); }
    .kelas-name  { font-weight: 600; color: var(--text); }
    .kelas-tahun { font-size: 11.5px; color: var(--muted); font-family: 'JetBrains Mono', monospace; }

    .badge-tingkat {
        display: inline-block; padding: 3px 10px;
        border-radius: 6px; font-size: 12px; font-weight: 600;
    }
    .badge-tingkat.X   { background: rgba(79,142,247,.12);  color: var(--accent); }
    .badge-tingkat.XI  { background: rgba(245,158,11,.12);  color: #f59e0b; }
    .badge-tingkat.XII { background: rgba(16,185,129,.12);  color: #10b981; }

    .badge-siswa {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 10px; border-radius: 6px;
        font-size: 12px; font-weight: 600;
        background: rgba(79,142,247,.08); color: var(--accent);
        text-decoration: none; transition: background .15s;
    }
    .badge-siswa:hover { background: rgba(79,142,247,.2); }

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
        <h2>Data Kelas</h2>
        <p>Total {{ $kelas->total() }} kelas terdaftar</p>
    </div>
    <a href="{{ route('admin.kelas.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Kelas
    </a>
</div>

{{-- TOOLBAR --}}
<form method="GET" action="{{ route('admin.kelas.index') }}" class="toolbar">
    <div class="search-box">
        <i class="fas fa-magnifying-glass"></i>
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama kelas atau tahun ajaran...">
    </div>
    <select name="tingkat" class="filter-select" onchange="this.form.submit()">
        <option value="">Semua Tingkat</option>
        @foreach(['X', 'XI', 'XII'] as $t)
            <option value="{{ $t }}" {{ request('tingkat') == $t ? 'selected' : '' }}>
                Kelas {{ $t }}
            </option>
        @endforeach
    </select>
    @if(request()->hasAny(['q','tingkat']))
        <a href="{{ route('admin.kelas.index') }}" class="btn btn-cancel btn-sm">
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
                <th>Kelas</th>
                <th>Tingkat</th>
                <th>Tahun Ajaran</th>
                <th>Jumlah Siswa</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kelas as $i => $k)
            <tr>
                <td style="color:var(--muted); font-size:12px">{{ $kelas->firstItem() + $i }}</td>
                <td>
                    <div class="kelas-cell">
                        <div class="kelas-avatar {{ $k->tingkat }}">{{ $k->tingkat }}</div>
                        <div>
                            <div class="kelas-name">{{ $k->nama_kelas }}</div>
                            <div class="kelas-tahun">{{ $k->tahun_ajaran }}</div>
                        </div>
                    </div>
                </td>
                <td>
                    <span class="badge-tingkat {{ $k->tingkat }}">Kelas {{ $k->tingkat }}</span>
                </td>
                <td style="color:var(--muted); font-size:12.5px; font-family:'JetBrains Mono',monospace">
                    {{ $k->tahun_ajaran }}
                </td>
                <td>
                    <a href="{{ route('admin.kelas.show', $k) }}" class="badge-siswa">
                        <i class="fas fa-user-graduate"></i> {{ $k->siswa_count }} siswa
                    </a>
                </td>
                <td>
                    <div class="actions">
                        <a href="{{ route('admin.kelas.edit', $k) }}" class="btn btn-edit btn-sm">
                            <i class="fas fa-pen"></i> Edit
                        </a>
                        <button type="button" class="btn btn-delete btn-sm"
                            onclick="confirmDelete({{ $k->id }}, '{{ addslashes($k->nama_kelas) }}')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6">
                    <div class="empty-state">
                        <i class="fas fa-school"></i>
                        <p>Belum ada data kelas.</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination-wrap">
        <span>
            Menampilkan {{ $kelas->firstItem() }}–{{ $kelas->lastItem() }}
            dari {{ $kelas->total() }} kelas
        </span>
        {{ $kelas->appends(request()->query())->links() }}
    </div>
</div>

{{-- DELETE MODAL --}}
<div class="modal-overlay" id="deleteModal">
    <div class="modal-box">
        <h3>🗑️ Hapus Kelas</h3>
        <p>Apakah kamu yakin ingin menghapus kelas <strong id="deleteKelasName"></strong>?
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
    document.getElementById('deleteKelasName').textContent = name;
    document.getElementById('deleteForm').action = `/admin/kelas/${id}`;
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