@extends('layouts.app')

@section('title', 'Data User')
@section('page-title', 'Data User')
@section('breadcrumb')
    <span>Admin</span> / Data User
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
        color: var(--muted);
    }
    tbody tr { border-bottom: 1px solid var(--border); transition: background .15s; }
    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: var(--surface-2); }
    td { padding: 13px 16px; font-size: 13.5px; vertical-align: middle; }

    .user-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .user-avatar {
        width: 36px; height: 36px; border-radius: 10px;
        display: grid; place-items: center;
        font-size: 11px; font-weight: 700; color: #fff;
        background: linear-gradient(135deg, #4f8ef7, #7c6af7);
    }
    .user-name { font-weight: 600; color: var(--text); }
    .user-email { font-size: 11.5px; color: var(--muted); }

    .badge-role {
        display: inline-block; padding: 4px 12px;
        border-radius: 20px; font-size: 11px; font-weight: 700;
    }
    .badge-admin { background: rgba(79,142,247,.12); color: #4f8ef7; }
    .badge-guru  { background: rgba(16,185,129,.12); color: #10b981; }
    .badge-siswa { background: rgba(245,158,11,.12); color: #f59e0b; }

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

    .empty-state { text-align: center; padding: 60px 20px; color: var(--muted); }
    .empty-state i { font-size: 40px; margin-bottom: 12px; display: block; opacity: .3; }

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
    }
    .modal-box h3 { font-size: 17px; font-weight: 700; margin-bottom: 8px; }
    .modal-box p  { font-size: 13.5px; color: var(--muted); margin-bottom: 22px; }
    .modal-actions { display: flex; gap: 10px; justify-content: flex-end; }
</style>
@endpush

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h2>Data User</h2>
        <p>Total {{ $users->total() }} user terdaftar</p>
    </div>
    <a href="{{ route('admin.user.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah User
    </a>
</div>

<form method="GET" action="{{ route('admin.user.index') }}" class="toolbar">
    <div class="search-box">
        <i class="fas fa-magnifying-glass"></i>
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama atau email...">
    </div>
    <select name="role" class="filter-select" onchange="this.form.submit()">
        <option value="">Semua Role</option>
        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
        <option value="guru" {{ request('role') == 'guru' ? 'selected' : '' }}>Guru</option>
        <option value="siswa" {{ request('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
    </select>
    @if(request()->hasAny(['q', 'role']))
        <a href="{{ route('admin.user.index') }}" class="btn btn-sm" style="background: var(--surface-2);">
            <i class="fas fa-xmark"></i> Reset
        </a>
    @endif
</form>

<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Email</th>
                <th>Role</th>
                <th>Dibuat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $i => $user)
            <tr>
                <td style="color:var(--muted);">{{ $users->firstItem() + $i }}</td>
                <td>
                    <div class="user-cell">
                        <div class="user-avatar">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                        <div>
                            <div class="user-name">{{ $user->name }}</div>
                        </div>
                    </div>
                </td>
                <td>{{ $user->email }}</td>
                <td>
                    <span class="badge-role badge-{{ $user->role }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </td>
                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                <td>
                    <div class="actions">
                        <a href="{{ route('admin.user.edit', $user) }}" class="btn btn-edit btn-sm">
                            <i class="fas fa-pen"></i> Edit
                        </a>
                        @if($user->id !== auth()->id())
                        <button type="button" class="btn btn-delete btn-sm"
                            onclick="confirmDelete({{ $user->id }}, '{{ addslashes($user->name) }}')">
                            <i class="fas fa-trash"></i>
                        </button>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6">
                    <div class="empty-state">
                        <i class="fas fa-users"></i>
                        <p>Belum ada data user.</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination-wrap">
        <span>Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }} dari {{ $users->total() }} user</span>
        {{ $users->appends(request()->query())->links() }}
    </div>
</div>

<div class="modal-overlay" id="deleteModal">
    <div class="modal-box">
        <h3>🗑️ Hapus User</h3>
        <p>Apakah kamu yakin ingin menghapus user <strong id="deleteUserName"></strong>?</p>
        <div class="modal-actions">
            <button class="btn btn-sm" style="background: var(--surface-2);" onclick="closeModal()">Batal</button>
            <form id="deleteForm" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-delete btn-sm">Hapus</button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function confirmDelete(id, name) {
    document.getElementById('deleteUserName').textContent = name;
    document.getElementById('deleteForm').action = `/admin/user/${id}`;
    document.getElementById('deleteModal').classList.add('show');
}
function closeModal() {
    document.getElementById('deleteModal').classList.remove('show');
}
</script>
@endpush