@extends('layouts.app')

@section('title', 'Edit Kelas')
@section('page-title', 'Edit Kelas')
@section('breadcrumb')
    <span>Admin</span> / <a href="{{ route('admin.kelas.index') }}">Data Kelas</a> / Edit
@endsection

@push('styles')
<style>
    .page-header {
        display: flex; align-items: center;
        justify-content: space-between;
        margin-bottom: 20px; gap: 12px; flex-wrap: wrap;
    }
    .page-header-left h2 { font-size: 20px; font-weight: 800; color: var(--text); }
    .page-header-left p  { font-size: 13px; color: var(--muted); margin-top: 2px; }

    .btn {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 9px 16px; border-radius: 8px; font-size: 13px;
        font-weight: 600; cursor: pointer; border: none;
        text-decoration: none; transition: all .18s; font-family: inherit;
    }
    .btn-primary { background: var(--accent); color: #fff; box-shadow: 0 2px 10px rgba(79,142,247,.3); }
    .btn-primary:hover { background: #3a7bf5; transform: translateY(-1px); }
    .btn-ghost {
        background: var(--surface-2); color: var(--muted);
        border: 1px solid var(--border);
    }
    .btn-ghost:hover { color: var(--text); }

    .form-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 28px;
        max-width: 540px;
    }

    /* Info badge at top */
    .kelas-info-badge {
        display: inline-flex; align-items: center; gap: 10px;
        background: var(--surface-2); border: 1px solid var(--border);
        border-radius: 10px; padding: 10px 14px;
        margin-bottom: 24px;
    }
    .kelas-info-badge .avatar {
        width: 32px; height: 32px; border-radius: 7px;
        display: grid; place-items: center;
        font-size: 11px; font-weight: 700; color: #fff;
    }
    .kelas-info-badge .avatar.X   { background: linear-gradient(135deg, #4f8ef7, #7c6af7); }
    .kelas-info-badge .avatar.XI  { background: linear-gradient(135deg, #f59e0b, #f97316); }
    .kelas-info-badge .avatar.XII { background: linear-gradient(135deg, #10b981, #0ea5e9); }
    .kelas-info-badge .info-name  { font-size: 13px; font-weight: 600; color: var(--text); }
    .kelas-info-badge .info-sub   { font-size: 11.5px; color: var(--muted); }

    .form-group { margin-bottom: 20px; }
    .form-group label {
        display: block;
        font-size: 13px; font-weight: 600; color: var(--text);
        margin-bottom: 7px;
    }
    .form-group label span { color: var(--danger); margin-left: 2px; }

    .form-control, .form-select {
        width: 100%; box-sizing: border-box;
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 10px 13px;
        color: var(--text); font-size: 13px;
        font-family: inherit; outline: none;
        transition: border-color .18s, box-shadow .18s;
        appearance: none;
    }
    .form-control:focus, .form-select:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(79,142,247,.15);
    }
    .form-control::placeholder { color: var(--muted); }
    .form-control.is-invalid, .form-select.is-invalid { border-color: var(--danger); }
    .invalid-feedback { font-size: 12px; color: var(--danger); margin-top: 5px; }

    .select-wrap { position: relative; }
    .select-wrap::after {
        content: '\f078';
        font-family: 'Font Awesome 6 Free'; font-weight: 900;
        position: absolute; right: 13px; top: 50%; transform: translateY(-50%);
        color: var(--muted); font-size: 11px; pointer-events: none;
    }

    .form-hint { font-size: 12px; color: var(--muted); margin-top: 5px; }

    .form-actions { display: flex; gap: 10px; margin-top: 28px; padding-top: 20px; border-top: 1px solid var(--border); }
</style>
@endpush

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h2>Edit Kelas</h2>
        <p>Perbarui data kelas yang sudah ada</p>
    </div>
    <a href="{{ route('admin.kelas.index') }}" class="btn btn-ghost">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="form-card">

    {{-- Current kelas info --}}
    <div class="kelas-info-badge">
        <div class="avatar {{ $kelas->tingkat }}">{{ $kelas->tingkat }}</div>
        <div>
            <div class="info-name">{{ $kelas->nama_kelas }}</div>
            <div class="info-sub">{{ $kelas->tahun_ajaran }} &middot; {{ $kelas->siswa_count ?? 0 }} siswa</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.kelas.update', $kelas) }}">
        @csrf
        @method('PUT')

        {{-- Nama Kelas --}}
        <div class="form-group">
            <label for="nama_kelas">Nama Kelas <span>*</span></label>
            <input type="text" id="nama_kelas" name="nama_kelas"
                   class="form-control @error('nama_kelas') is-invalid @enderror"
                   value="{{ old('nama_kelas', $kelas->nama_kelas) }}"
                   placeholder="Contoh: X-A, XI IPA 1, XII IPS 2"
                   autofocus>
            @error('nama_kelas')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Tingkat --}}
        <div class="form-group">
            <label for="tingkat">Tingkat <span>*</span></label>
            <div class="select-wrap">
                <select id="tingkat" name="tingkat"
                        class="form-select @error('tingkat') is-invalid @enderror">
                    <option value="" disabled>-- Pilih Tingkat --</option>
                    @foreach(['X', 'XI', 'XII'] as $t)
                        <option value="{{ $t }}" {{ old('tingkat', $kelas->tingkat) === $t ? 'selected' : '' }}>
                            Kelas {{ $t }}
                        </option>
                    @endforeach
                </select>
            </div>
            @error('tingkat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Tahun Ajaran --}}
        <div class="form-group">
            <label for="tahun_ajaran">Tahun Ajaran <span>*</span></label>
            <input type="text" id="tahun_ajaran" name="tahun_ajaran"
                   class="form-control @error('tahun_ajaran') is-invalid @enderror"
                   value="{{ old('tahun_ajaran', $kelas->tahun_ajaran) }}"
                   placeholder="Contoh: 2024/2025"
                   maxlength="10">
            @error('tahun_ajaran')
                <div class="invalid-feedback">{{ $message }}</div>
            @else
                <div class="form-hint">Format: YYYY/YYYY (contoh: 2024/2025)</div>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Perbarui Kelas
            </button>
            <a href="{{ route('admin.kelas.index') }}" class="btn btn-ghost">
                Batal
            </a>
        </div>
    </form>
</div>

@endsection