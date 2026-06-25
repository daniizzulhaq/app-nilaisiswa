@extends('layouts.app')

@section('title', 'Detail Guru')
@section('page-title', 'Detail Guru')
@section('breadcrumb')
    <span>Admin</span> / <a href="{{ route('admin.guru.index') }}">Data Guru</a> / Detail
@endsection

@push('styles')
<style>
    .back-btn {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 9px 16px; border-radius: 8px; font-size: 13px;
        font-weight: 600; cursor: pointer; border: none;
        text-decoration: none; transition: all .18s;
        background: var(--surface-2); color: var(--muted);
        border: 1px solid var(--border); margin-bottom: 20px;
    }
    .back-btn:hover { color: var(--text); }

    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    @media (max-width: 640px) {
        .detail-grid { grid-template-columns: 1fr; }
    }

    .card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
    }
    .card-header {
        padding: 16px 20px;
        border-bottom: 1px solid var(--border);
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .7px;
        color: var(--muted);
        display: flex; align-items: center; gap: 8px;
    }
    .card-body { padding: 20px; }

    /* Profile card */
    .profile-top {
        display: flex; align-items: center; gap: 16px;
        margin-bottom: 24px;
    }
    .avatar-lg {
        width: 64px; height: 64px; border-radius: 14px;
        display: grid; place-items: center;
        font-size: 24px; font-weight: 700; color: #fff;
        background: linear-gradient(135deg, #10b981, #059669);
        flex-shrink: 0;
    }
    .profile-name { font-size: 18px; font-weight: 800; color: var(--text); }
    .profile-nip  { font-size: 12px; color: var(--muted); font-family: 'JetBrains Mono', monospace; margin-top: 2px; }

    .info-list { display: flex; flex-direction: column; gap: 14px; }
    .info-row {
        display: flex; justify-content: space-between; align-items: center;
        font-size: 13.5px;
    }
    .info-label { color: var(--muted); font-size: 12.5px; }
    .info-value { font-weight: 600; color: var(--text); text-align: right; }

    .badge-email {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 10px; border-radius: 6px;
        font-size: 12px; font-weight: 500;
        background: rgba(79,142,247,.08); color: var(--accent);
    }
    .badge-telp {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 9px; border-radius: 6px;
        font-size: 12px;
        background: rgba(16,185,129,.1); color: #10b981;
    }
    .badge-role {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 9px; border-radius: 6px;
        font-size: 12px; font-weight: 600;
        background: rgba(124,106,247,.12); color: #7c6af7;
        text-transform: capitalize;
    }

    /* Mapel list */
    .mapel-list { display: flex; flex-direction: column; gap: 10px; }
    .mapel-item {
        display: flex; align-items: center; gap: 10px;
        padding: 10px 14px;
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: 9px;
        font-size: 13.5px; font-weight: 500; color: var(--text);
    }
    .mapel-item i { color: var(--accent); font-size: 13px; }

    .empty-mapel {
        text-align: center; padding: 30px 20px;
        color: var(--muted); font-size: 13px; font-style: italic;
    }
    .empty-mapel i { font-size: 28px; opacity: .25; display: block; margin-bottom: 8px; }

    /* Actions */
    .action-bar {
        display: flex; gap: 10px; margin-top: 20px; flex-wrap: wrap;
    }
    .btn {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 9px 16px; border-radius: 8px; font-size: 13px;
        font-weight: 600; cursor: pointer; border: none;
        text-decoration: none; transition: all .18s; font-family: inherit;
    }
    .btn-primary { background: var(--accent); color: #fff; box-shadow: 0 2px 10px rgba(79,142,247,.3); }
    .btn-primary:hover { background: #3a7bf5; transform: translateY(-1px); }
    .btn-delete { background: rgba(248,113,113,.12); color: var(--danger); }
    .btn-delete:hover { background: rgba(248,113,113,.25); }

    /* Modal */
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
    .btn-cancel { background: var(--surface-2); color: var(--muted); border: 1px solid var(--border); }
    .btn-cancel:hover { color: var(--text); }
    .btn-danger { background: var(--danger); color: #fff; }
    .btn-danger:hover { background: #ef4444; }
</style>
@endpush

@section('content')

<a href="{{ route('admin.guru.index') }}" class="back-btn">
    <i class="fas fa-arrow-left"></i> Kembali
</a>

<div class="detail-grid">

    {{-- Kartu Profil --}}
    <div class="card">
        <div class="card-header">
            <i class="fas fa-user"></i> Informasi Guru
        </div>
        <div class="card-body">
            <div class="profile-top">
                <div class="avatar-lg">{{ strtoupper(substr($guru->nama, 0, 1)) }}</div>
                <div>
                    <div class="profile-name">{{ $guru->nama }}</div>
                    <div class="profile-nip">NIP: {{ $guru->nip }}</div>
                </div>
            </div>

            <div class="info-list">
                <div class="info-row">
                    <span class="info-label"><i class="fas fa-envelope" style="width:14px"></i> Email</span>
                    <span class="badge-email">{{ $guru->user->email ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label"><i class="fas fa-phone" style="width:14px"></i> No. Telepon</span>
                    @if($guru->no_telp)
                        <span class="badge-telp"><i class="fas fa-phone" style="font-size:11px"></i> {{ $guru->no_telp }}</span>
                    @else
                        <span class="info-value" style="color:var(--muted); font-style:italic">—</span>
                    @endif
                </div>
                <div class="info-row">
                    <span class="info-label"><i class="fas fa-shield-halved" style="width:14px"></i> Role</span>
                    <span class="badge-role"><i class="fas fa-user-tie" style="font-size:11px"></i> {{ $guru->user->role ?? 'guru' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label"><i class="fas fa-calendar" style="width:14px"></i> Terdaftar</span>
                    <span class="info-value">{{ $guru->created_at->format('d M Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Mata Pelajaran --}}
    <div class="card">
        <div class="card-header">
            <i class="fas fa-book"></i> Mata Pelajaran Diampu
        </div>
        <div class="card-body">
            @if($guru->mataPelajaran && $guru->mataPelajaran->count())
                <div class="mapel-list">
                    @foreach($guru->mataPelajaran as $mp)
                    <div class="mapel-item">
                        <i class="fas fa-book-open"></i>
                        {{ $mp->nama_mapel }}
                    </div>
                    @endforeach
                </div>
            @else
                <div class="empty-mapel">
                    <i class="fas fa-book"></i>
                    Belum ada mata pelajaran yang diampu.
                </div>
            @endif
        </div>
    </div>

</div>

{{-- Action Bar --}}
<div class="action-bar">
    <a href="{{ route('admin.guru.edit', $guru) }}" class="btn btn-primary">
        <i class="fas fa-pen"></i> Edit Data
    </a>
    <button type="button" class="btn btn-delete"
        onclick="document.getElementById('deleteModal').classList.add('show')">
        <i class="fas fa-trash"></i> Hapus Guru
    </button>
</div>

{{-- DELETE MODAL --}}
<div class="modal-overlay" id="deleteModal">
    <div class="modal-box">
        <h3>🗑️ Hapus Guru</h3>
        <p>Apakah kamu yakin ingin menghapus <strong>{{ $guru->nama }}</strong>?
           Akun login guru ini juga akan terhapus.</p>
        <div class="modal-actions">
            <button class="btn btn-cancel" onclick="document.getElementById('deleteModal').classList.remove('show')">Batal</button>
            <form action="{{ route('admin.guru.destroy', $guru) }}" method="POST">
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
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) this.classList.remove('show');
});
</script>
@endpush