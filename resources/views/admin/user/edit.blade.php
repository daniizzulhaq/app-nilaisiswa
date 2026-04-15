@extends('layouts.app')

@section('title', 'Edit User')
@section('page-title', 'Edit User')
@section('breadcrumb')
    <span>Admin</span> / <a href="{{ route('admin.user.index') }}">Data User</a> / Edit
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
    .form-control {
        width: 100%;
        padding: 10px 12px;
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: 8px;
        color: var(--text);
        font-size: 13.5px;
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
    .warning-box {
        background: rgba(245,158,11,.08);
        border-left: 3px solid #f59e0b;
        border-radius: 8px;
        padding: 12px 16px;
        margin-bottom: 20px;
        font-size: 12.5px;
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

    <div class="warning-box">
        <i class="fas fa-info-circle"></i> Kosongkan password jika tidak ingin mengubahnya
    </div>

    <form action="{{ route('admin.user.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="form-group">
            <label>Password (Opsional)</label>
            <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diubah">
        </div>

        <div class="form-group">
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <div class="form-group">
            <label>Role</label>
            <select name="role" class="form-control" required>
                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="guru" {{ old('role', $user->role) == 'guru' ? 'selected' : '' }}>Guru</option>
                <option value="siswa" {{ old('role', $user->role) == 'siswa' ? 'selected' : '' }}>Siswa</option>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection