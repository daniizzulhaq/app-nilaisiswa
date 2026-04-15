@extends('layouts.app')

@section('title', 'Edit Siswa')
@section('page-title', 'Edit Siswa')
@section('breadcrumb')
    <span>Admin</span> / <a href="{{ route('admin.siswa.index') }}" style="color:var(--muted);text-decoration:none">Data Siswa</a> / Edit
@endsection

@push('styles')
<style>
    .form-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        max-width: 720px;
    }
    .form-card-header {
        padding: 20px 28px;
        border-bottom: 1px solid var(--border);
        display: flex; align-items: center; gap: 12px;
    }
    .student-avatar-lg {
        width: 46px; height: 46px; border-radius: 11px;
        display: grid; place-items: center;
        font-size: 18px; font-weight: 800; color: #fff; flex-shrink: 0;
    }
    .student-avatar-lg.L { background: linear-gradient(135deg, #4f8ef7, #7c6af7); }
    .student-avatar-lg.P { background: linear-gradient(135deg, #f472b6, #fb7185); }
    .form-card-header h3 { font-size: 15px; font-weight: 700; }
    .form-card-header p  { font-size: 12px; color: var(--muted); }
    .form-body { padding: 28px; }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }
    .form-group { display: flex; flex-direction: column; gap: 6px; }
    .form-group.full { grid-column: 1 / -1; }

    label {
        font-size: 12px; font-weight: 700;
        color: var(--muted); text-transform: uppercase; letter-spacing: .5px;
    }
    label .required { color: var(--danger); margin-left: 2px; }

    .form-control {
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: 9px;
        padding: 10px 14px;
        color: var(--text);
        font-size: 13.5px;
        font-family: inherit;
        outline: none;
        transition: border-color .18s, box-shadow .18s;
        width: 100%;
    }
    .form-control:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(79,142,247,.12);
    }
    .form-control.is-invalid {
        border-color: var(--danger);
        box-shadow: 0 0 0 3px rgba(248,113,113,.1);
    }
    .form-control:disabled {
        opacity: .5; cursor: not-allowed;
    }
    textarea.form-control { resize: vertical; min-height: 90px; }

    .error-msg { font-size: 11.5px; color: var(--danger); }

    .radio-group { display: flex; gap: 10px; }
    .radio-option { flex: 1; cursor: pointer; }
    .radio-option input { display: none; }
    .radio-label {
        display: flex; align-items: center; gap: 8px;
        padding: 10px 14px;
        border: 1px solid var(--border);
        border-radius: 9px;
        background: var(--surface-2);
        font-size: 13px; font-weight: 500; color: var(--muted);
        transition: all .18s; cursor: pointer;
    }
    .radio-option input:checked + .radio-label {
        border-color: var(--accent);
        background: rgba(79,142,247,.08);
        color: var(--accent);
    }

    .readonly-field {
        display: flex; flex-direction: column; gap: 6px;
    }
    .readonly-value {
        padding: 10px 14px;
        background: var(--surface-2);
        border: 1px dashed var(--border);
        border-radius: 9px;
        font-size: 13.5px;
        color: var(--muted);
        font-family: 'JetBrains Mono', monospace;
    }
    .readonly-hint {
        font-size: 11px; color: var(--muted);
        display: flex; align-items: center; gap: 4px;
    }

    .form-actions {
        display: flex; gap: 10px; justify-content: flex-end;
        padding: 20px 28px;
        border-top: 1px solid var(--border);
    }
    .btn {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 9px 18px; border-radius: 8px; font-size: 13px;
        font-weight: 600; cursor: pointer; border: none;
        text-decoration: none; transition: all .18s; font-family: inherit;
    }
    .btn-primary { background: var(--accent); color: #fff; box-shadow: 0 2px 10px rgba(79,142,247,.3); }
    .btn-primary:hover { background: #3a7bf5; }
    .btn-ghost { background: var(--surface-2); color: var(--muted); border: 1px solid var(--border); }
    .btn-ghost:hover { color: var(--text); }

    @media (max-width: 600px) {
        .form-grid { grid-template-columns: 1fr; }
        .form-group.full { grid-column: 1; }
    }
</style>
@endpush

@section('content')

<form method="POST" action="{{ route('admin.siswa.update', $siswa) }}">
@csrf
@method('PUT')

<div class="form-card">
    <div class="form-card-header">
        <div class="student-avatar-lg {{ $siswa->jenis_kelamin }}">
            {{ strtoupper(substr($siswa->nama, 0, 1)) }}
        </div>
        <div>
            <h3>{{ $siswa->nama }}</h3>
            <p>NIS: {{ $siswa->nis }} &nbsp;·&nbsp; Edit data siswa</p>
        </div>
    </div>

    <div class="form-body">
        <div class="form-grid">

            {{-- NIS (readonly) --}}
            <div class="form-group readonly-field">
                <label>NIS</label>
                <div class="readonly-value">{{ $siswa->nis }}</div>
                <div class="readonly-hint"><i class="fas fa-lock" style="font-size:10px"></i> NIS tidak dapat diubah</div>
            </div>

            {{-- Nama --}}
            <div class="form-group">
                <label>Nama Lengkap <span class="required">*</span></label>
                <input type="text" name="nama" class="form-control {{ $errors->has('nama') ? 'is-invalid' : '' }}"
                    value="{{ old('nama', $siswa->nama) }}" required>
                @error('nama') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            {{-- Email (readonly — ubah via User) --}}
            <div class="form-group readonly-field">
                <label>Email Login</label>
                <div class="readonly-value">{{ $siswa->user->email ?? '-' }}</div>
                <div class="readonly-hint"><i class="fas fa-lock" style="font-size:10px"></i> Ubah email via Manajemen User</div>
            </div>

            {{-- Kelas --}}
            <div class="form-group">
                <label>Kelas <span class="required">*</span></label>
                <select name="kelas_id" class="form-control {{ $errors->has('kelas_id') ? 'is-invalid' : '' }}" required>
                    <option value="">— Pilih Kelas —</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}"
                            {{ old('kelas_id', $siswa->kelas_id) == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
                @error('kelas_id') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            {{-- Jenis Kelamin --}}
            <div class="form-group">
                <label>Jenis Kelamin <span class="required">*</span></label>
                <div class="radio-group">
                    <label class="radio-option">
                        <input type="radio" name="jenis_kelamin" value="L"
                            {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'L' ? 'checked' : '' }}>
                        <span class="radio-label"><i class="fas fa-mars"></i> Laki-laki</span>
                    </label>
                    <label class="radio-option">
                        <input type="radio" name="jenis_kelamin" value="P"
                            {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'P' ? 'checked' : '' }}>
                        <span class="radio-label"><i class="fas fa-venus"></i> Perempuan</span>
                    </label>
                </div>
                @error('jenis_kelamin') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            {{-- Tanggal Lahir --}}
            <div class="form-group">
                <label>Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" class="form-control"
                    value="{{ old('tanggal_lahir', $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('Y-m-d') : '') }}">
            </div>

            {{-- Alamat --}}
            <div class="form-group full">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control">{{ old('alamat', $siswa->alamat) }}</textarea>
            </div>

        </div>
    </div>

    <div class="form-actions">
        <a href="{{ route('admin.siswa.index') }}" class="btn btn-ghost">
            <i class="fas fa-arrow-left"></i> Batal
        </a>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-floppy-disk"></i> Simpan Perubahan
        </button>
    </div>
</div>

</form>
@endsection