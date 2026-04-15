@extends('layouts.app')

@section('title', 'Edit Guru')
@section('page-title', 'Edit Guru')
@section('breadcrumb')
    <span>Admin</span> / <a href="{{ route('admin.guru.index') }}">Data Guru</a> / Edit Guru
@endsection

@push('styles')
<style>
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
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
    .btn-primary {
        background: var(--accent); color: #fff;
        box-shadow: 0 2px 10px rgba(79,142,247,.3);
    }
    .btn-primary:hover { background: #3a7bf5; transform: translateY(-1px); }
    .btn-back { background: var(--surface-2); color: var(--muted); border: 1px solid var(--border); }
    .btn-back:hover { color: var(--text); }
    .btn-danger-soft { background: rgba(248,113,113,.12); color: var(--danger); border: none; }
    .btn-danger-soft:hover { background: rgba(248,113,113,.25); }

    /* Card */
    .form-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
        max-width: 680px;
    }
    .form-card-header {
        padding: 20px 24px;
        border-bottom: 1px solid var(--border);
        background: var(--surface-2);
        display: flex; align-items: center; gap: 12px;
    }
    .form-card-icon {
        width: 40px; height: 40px; border-radius: 10px;
        background: linear-gradient(135deg, #10b981, #059669);
        display: grid; place-items: center;
        color: #fff; font-size: 16px; flex-shrink: 0;
    }
    .form-card-header h3 { font-size: 15px; font-weight: 700; color: var(--text); }
    .form-card-header p  { font-size: 12px; color: var(--muted); margin-top: 2px; }

    /* Avatar preview in header */
    .guru-avatar {
        width: 40px; height: 40px; border-radius: 10px;
        background: linear-gradient(135deg, #10b981, #059669);
        display: grid; place-items: center;
        color: #fff; font-size: 16px; font-weight: 700; flex-shrink: 0;
    }

    .form-body { padding: 24px; }

    .form-section-title {
        font-size: 11px; font-weight: 700; text-transform: uppercase;
        letter-spacing: .8px; color: var(--muted);
        margin-bottom: 14px; margin-top: 24px;
        padding-bottom: 8px; border-bottom: 1px solid var(--border);
    }
    .form-section-title:first-child { margin-top: 0; }

    .form-row {
        display: grid; grid-template-columns: 1fr 1fr;
        gap: 14px; margin-bottom: 14px;
    }
    .form-row.full { grid-template-columns: 1fr; }

    .form-group { display: flex; flex-direction: column; gap: 6px; }
    .form-group label {
        font-size: 12.5px; font-weight: 600; color: var(--text);
    }
    .form-group label span.req { color: var(--danger); margin-left: 2px; }
    .form-group label span.opt {
        font-size: 11px; color: var(--muted); font-weight: 400; margin-left: 4px;
    }

    .form-control {
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 9px 12px;
        color: var(--text);
        font-size: 13px;
        font-family: inherit;
        outline: none;
        transition: border-color .18s, box-shadow .18s;
        width: 100%;
        box-sizing: border-box;
    }
    .form-control:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(79,142,247,.12);
    }
    .form-control.is-invalid { border-color: var(--danger); }
    .form-control::placeholder { color: var(--muted); }
    .form-control[readonly] {
        opacity: .6; cursor: not-allowed;
    }

    .invalid-feedback {
        font-size: 11.5px; color: var(--danger);
        display: flex; align-items: center; gap: 4px;
        margin-top: 2px;
    }
    .hint {
        font-size: 11.5px; color: var(--muted);
        display: flex; align-items: center; gap: 4px;
        margin-top: 2px;
    }

    /* Password reset toggle */
    .password-toggle-wrap {
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 14px 16px;
        margin-top: 14px;
    }
    .password-toggle-header {
        display: flex; align-items: center; justify-content: space-between;
        cursor: pointer;
    }
    .password-toggle-header span {
        font-size: 13px; font-weight: 600; color: var(--text);
        display: flex; align-items: center; gap: 8px;
    }
    .toggle-icon { color: var(--muted); font-size: 12px; transition: transform .2s; }
    .toggle-icon.open { transform: rotate(180deg); }
    .password-fields {
        display: none; margin-top: 14px;
        display: flex; flex-direction: column; gap: 12px;
    }
    .password-fields.hidden { display: none; }

    .form-footer {
        padding: 18px 24px;
        border-top: 1px solid var(--border);
        background: var(--surface-2);
        display: flex; align-items: center; justify-content: space-between; gap: 10px;
        flex-wrap: wrap;
    }
    .form-footer-right { display: flex; gap: 10px; }

    /* Danger zone */
    .danger-zone {
        margin-top: 20px;
        max-width: 680px;
        background: var(--surface);
        border: 1px solid rgba(248,113,113,.3);
        border-radius: 16px;
        overflow: hidden;
    }
    .danger-zone-header {
        padding: 16px 24px;
        border-bottom: 1px solid rgba(248,113,113,.2);
        background: rgba(248,113,113,.05);
        display: flex; align-items: center; gap: 10px;
    }
    .danger-zone-header i { color: var(--danger); }
    .danger-zone-header h4 { font-size: 14px; font-weight: 700; color: var(--danger); }
    .danger-zone-body {
        padding: 16px 24px;
        display: flex; align-items: center; justify-content: space-between; gap: 12px;
        flex-wrap: wrap;
    }
    .danger-zone-body p { font-size: 13px; color: var(--muted); }

    /* Modal */
    .modal-overlay {
        display: none; position: fixed; inset: 0;
        background: rgba(0,0,0,.6); backdrop-filter: blur(4px);
        z-index: 200; align-items: center; justify-content: center;
    }
    .modal-overlay.show { display: flex; }
    .modal-box {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 28px;
        max-width: 380px; width: 90%;
        animation: fadeUp .25s ease;
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

<div class="page-header">
    <div class="page-header-left">
        <h2>Edit Guru</h2>
        <p>Perbarui informasi data guru</p>
    </div>
    <a href="{{ route('admin.guru.index') }}" class="btn btn-back">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="form-card">
    <div class="form-card-header">
        <div class="guru-avatar">
            {{ strtoupper(substr($guru->nama, 0, 1)) }}
        </div>
        <div>
            <h3>{{ $guru->nama }}</h3>
            <p>NIP: {{ $guru->nip }}</p>
        </div>
    </div>

    <form action="{{ route('admin.guru.update', $guru) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-body">

            {{-- INFO PRIBADI --}}
            <div class="form-section-title">Informasi Pribadi</div>

            <div class="form-row">
                <div class="form-group">
                    <label>NIP <span class="req">*</span></label>
                    <input type="text" name="nip"
                        value="{{ old('nip', $guru->nip) }}"
                        class="form-control {{ $errors->has('nip') ? 'is-invalid' : '' }}"
                        placeholder="197504102005011001">
                    @error('nip')
                        <div class="invalid-feedback"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Nama Lengkap <span class="req">*</span></label>
                    <input type="text" name="nama"
                        value="{{ old('nama', $guru->nama) }}"
                        class="form-control {{ $errors->has('nama') ? 'is-invalid' : '' }}"
                        placeholder="Nama sesuai KTP">
                    @error('nama')
                        <div class="invalid-feedback"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>No. Telepon <span class="opt">(opsional)</span></label>
                    <input type="text" name="no_telp"
                        value="{{ old('no_telp', $guru->no_telp) }}"
                        class="form-control {{ $errors->has('no_telp') ? 'is-invalid' : '' }}"
                        placeholder="08xxxxxxxxxx">
                    @error('no_telp')
                        <div class="invalid-feedback"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- AKUN LOGIN --}}
            <div class="form-section-title">Akun Login</div>

            <div class="form-row full">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control"
                        value="{{ $guru->user->email ?? '-' }}" readonly>
                    <div class="hint"><i class="fas fa-lock"></i> Email tidak dapat diubah dari halaman ini</div>
                </div>
            </div>

            {{-- RESET PASSWORD --}}
            <div class="password-toggle-wrap">
                <div class="password-toggle-header" onclick="togglePassword()">
                    <span><i class="fas fa-key"></i> Reset Password</span>
                    <i class="fas fa-chevron-down toggle-icon" id="toggleIcon"></i>
                </div>
                <div class="password-fields hidden" id="passwordFields">
                    <div class="form-group">
                        <label>Password Baru <span class="req">*</span></label>
                        <input type="password" name="password"
                            class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                            placeholder="Minimal 8 karakter">
                        @error('password')
                            <div class="invalid-feedback"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Konfirmasi Password <span class="req">*</span></label>
                        <input type="password" name="password_confirmation"
                            class="form-control"
                            placeholder="Ulangi password baru">
                    </div>
                </div>
            </div>

        </div>

        <div class="form-footer">
            <span style="font-size:12px; color:var(--muted);">
                <i class="fas fa-clock"></i>
                Terakhir diperbarui: {{ $guru->updated_at ? $guru->updated_at->diffForHumans() : '-' }}
            </span>
            <div class="form-footer-right">
                <a href="{{ route('admin.guru.index') }}" class="btn btn-back">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-floppy-disk"></i> Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>

{{-- DANGER ZONE --}}
<div class="danger-zone">
    <div class="danger-zone-header">
        <i class="fas fa-triangle-exclamation"></i>
        <h4>Danger Zone</h4>
    </div>
    <div class="danger-zone-body">
        <p>Menghapus guru akan menghapus akun login dan semua data terkait secara permanen.</p>
        <button type="button" class="btn btn-danger-soft"
            onclick="document.getElementById('deleteModal').classList.add('show')">
            <i class="fas fa-trash"></i> Hapus Guru Ini
        </button>
    </div>
</div>

{{-- DELETE MODAL --}}
<div class="modal-overlay" id="deleteModal">
    <div class="modal-box">
        <h3>🗑️ Hapus Guru</h3>
        <p>Apakah kamu yakin ingin menghapus <strong>{{ $guru->nama }}</strong>?
           Akun login guru ini juga akan terhapus dan tidak dapat dikembalikan.</p>
        <div class="modal-actions">
            <button class="btn btn-cancel"
                onclick="document.getElementById('deleteModal').classList.remove('show')">Batal</button>
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
function togglePassword() {
    const fields = document.getElementById('passwordFields');
    const icon   = document.getElementById('toggleIcon');
    const isHidden = fields.classList.contains('hidden');
    fields.classList.toggle('hidden', !isHidden);
    icon.classList.toggle('open', isHidden);
}

// Open password section if there were validation errors on password fields
@if($errors->has('password'))
    togglePassword();
@endif

// Close modal on overlay click
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) this.classList.remove('show');
});
</script>
@endpush