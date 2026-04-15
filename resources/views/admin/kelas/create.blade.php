@extends('layouts.app')

@section('title', 'Tambah Kelas')
@section('page-title', 'Tambah Kelas')
@section('breadcrumb')
    <span>Admin</span> / <a href="{{ route('admin.kelas.index') }}">Data Kelas</a> / Tambah
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

    /* Select arrow */
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
        <h2>Tambah Kelas</h2>
        <p>Isi form berikut untuk menambahkan kelas baru</p>
    </div>
    <a href="{{ route('admin.kelas.index') }}" class="btn btn-ghost">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="form-card">
    <form method="POST" action="{{ route('admin.kelas.store') }}">
        @csrf

        {{-- Nama Kelas --}}
        <div class="form-group">
            <label for="nama_kelas">Nama Kelas <span>*</span></label>
            <input type="text" id="nama_kelas" name="nama_kelas"
                   class="form-control @error('nama_kelas') is-invalid @enderror"
                   value="{{ old('nama_kelas') }}"
                   placeholder="Contoh: X-A, XI IPA 1, XII IPS 2"
                   autofocus>
            @error('nama_kelas')
                <div class="invalid-feedback">{{ $message }}</div>
            @else
                <div class="form-hint">Gunakan nama yang jelas dan mudah dikenali</div>
            @enderror
        </div>

        {{-- Tingkat --}}
        <div class="form-group">
            <label for="tingkat">Tingkat <span>*</span></label>
            <div class="select-wrap">
                <select id="tingkat" name="tingkat"
                        class="form-select @error('tingkat') is-invalid @enderror">
                    <option value="" disabled {{ old('tingkat') ? '' : 'selected' }}>-- Pilih Tingkat --</option>
                    @foreach(['X', 'XI', 'XII'] as $t)
                        <option value="{{ $t }}" {{ old('tingkat') === $t ? 'selected' : '' }}>
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
                   value="{{ old('tahun_ajaran') }}"
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
                <i class="fas fa-save"></i> Simpan Kelas
            </button>
            <a href="{{ route('admin.kelas.index') }}" class="btn btn-ghost">
                Batal
            </a>
        </div>
    </form>
</div>

@endsection