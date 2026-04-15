@extends('layouts.app')

@section('title', 'Tambah User')
@section('page-title', 'Tambah User')
@section('breadcrumb')
    <span>Admin</span> / <a href="{{ route('admin.user.index') }}">Data User</a> / Tambah
@endsection

@push('styles')
<style>
    .form-container {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 28px;
        max-width: 500px;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-size: 13px;
        font-weight: 600;
        color: var(--text);
    }
    .form-group label .required {
        color: var(--danger);
        margin-left: 4px;
    }
    .form-control {
        width: 100%;
        padding: 10px 12px;
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: 8px;
        color: var(--text);
        font-size: 13.5px;
        font-family: inherit;
    }
    .form-control:focus {
        outline: none;
        border-color: var(--accent);
    }
    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 28px;
        padding-top: 20px;
        border-top: 1px solid var(--border);
    }
    .btn-primary { background: var(--accent); color: #fff; }
    .btn-secondary { background: var(--surface-2); color: var(--muted); border: 1px solid var(--border); }
    .alert-danger {
        background: rgba(248,113,113,.1);
        border: 1px solid rgba(248,113,113,.3);
        border-radius: 10px;
        padding: 12px 16px;
        margin-bottom: 24px;
    }
    .info-text {
        font-size: 12px;
        color: var(--muted);
        margin-top: 5px;
    }
</style>
@endpush

@section('content')
<div class="form-container">
    @if($errors->any())
    <div class="alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.user.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Nama Lengkap <span class="required">*</span></label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label>Email <span class="required">*</span></label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <label>Password <span class="required">*</span></label>
            <input type="password" name="password" class="form-control" required>
            <div class="info-text">Minimal 6 karakter</div>
        </div>

        <div class="form-group">
            <label>Konfirmasi Password <span class="required">*</span></label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Role <span class="required">*</span></label>
            <select name="role" class="form-control" required>
                <option value="">Pilih Role</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="guru" {{ old('role') == 'guru' ? 'selected' : '' }}>Guru</option>
                <option value="siswa" {{ old('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection