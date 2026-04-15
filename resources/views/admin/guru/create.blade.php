@extends('layouts.app')

@section('title', 'Tambah Guru')
@section('page-title', 'Tambah Guru')
@section('breadcrumb')
    <span>Admin</span> / <a href="{{ route('admin.guru.index') }}">Data Guru</a> / Tambah Guru
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

    .password-info {
        background: rgba(79,142,247,.08);
        border: 1px solid rgba(79,142,247,.2);
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 12.5px;
        color: var(--accent);
        display: flex; align-items: center; gap: 8px;
        margin-top: 14px;
    }

    .form-footer {
        padding: 18px 24px;
        border-top: 1px solid var(--border);
        background: var(--surface-2);
        display: flex; align-items: center; justify-content: flex-end; gap: 10px;
    }
</style>
@endpush

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h2>Tambah Guru</h2>
        <p>Isi form berikut untuk mendaftarkan guru baru</p>
    </div>
    <a href="{{ route('admin.guru.index') }}" class="btn btn-back">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="form-card">
    <div class="form-card-header">
        <div class="form-card-icon">
            <i class="fas fa-chalkboard-teacher"></i>
        </div>
        <div>
            <h3>Data Guru Baru</h3>
            <p>Akun login akan dibuat otomatis dengan password default</p>
        </div>
    </div>

    <form action="{{ route('admin.guru.store') }}" method="POST">
        @csrf
        <div class="form-body">

            {{-- INFO PRIBADI --}}
            <div class="form-section-title">Informasi Pribadi</div>

            <div class="form-row">
                <div class="form-group">
                    <label>NIP <span class="req">*</span></label>
                    <input type="text" name="nip" value="{{ old('nip') }}"
                        class="form-control {{ $errors->has('nip') ? 'is-invalid' : '' }}"
                        placeholder="Contoh: 197504102005011001">
                    @error('nip')
                        <div class="invalid-feedback"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Nama Lengkap <span class="req">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama') }}"
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
                    <input type="text" name="no_telp" value="{{ old('no_telp') }}"
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
                    <label>Email <span class="req">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                        placeholder="email@sekolah.sch.id">
                    @error('email')
                        <div class="invalid-feedback"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                    @enderror
                    <div class="hint"><i class="fas fa-circle-info"></i> Digunakan sebagai username untuk login</div>
                </div>
            </div>

            <div class="password-info">
                <i class="fas fa-key"></i>
                Password default: <strong>password123</strong> — guru dapat mengubahnya setelah login pertama
            </div>

        </div>

        <div class="form-footer">
            <a href="{{ route('admin.guru.index') }}" class="btn btn-back">Batal</a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-floppy-disk"></i> Simpan Guru
            </button>
        </div>
    </form>
</div>

@endsection