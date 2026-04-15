@extends('layouts.app')

@section('title', 'Edit Profil')
@section('page-title', 'Edit Profil')
@section('breadcrumb')
    <span>Profil</span> / Edit Profil
@endsection

@push('styles')
<style>
    .profile-container {
        max-width: 800px;
        margin: 0 auto;
    }
    .profile-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 24px;
    }
    .profile-header {
        background: linear-gradient(135deg, #4f8ef7, #7c6af7);
        padding: 30px;
        text-align: center;
        color: #fff;
        position: relative;
    }
    .profile-avatar {
        width: 80px;
        height: 80px;
        background: rgba(255,255,255,.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        font-size: 32px;
        font-weight: bold;
        border: 3px solid #fff;
    }
    .profile-header h3 {
        font-size: 20px;
        margin-bottom: 5px;
    }
    .profile-header p {
        font-size: 13px;
        opacity: 0.9;
    }
    .profile-body {
        padding: 28px;
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
        text-transform: uppercase;
        letter-spacing: .5px;
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
        transition: all .15s;
    }
    .form-control:focus {
        outline: none;
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(79,142,247,.1);
    }
    .form-control[readonly] {
        background: var(--surface);
        cursor: default;
        opacity: 0.7;
    }
    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 28px;
        padding-top: 20px;
        border-top: 1px solid var(--border);
    }
    .btn {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 9px 16px; border-radius: 8px; font-size: 13px;
        font-weight: 600; cursor: pointer; border: none;
        text-decoration: none; transition: all .18s;
        font-family: inherit;
    }
    .btn-primary { background: var(--accent); color: #fff; box-shadow: 0 2px 10px rgba(79,142,247,.3); }
    .btn-primary:hover { background: #3a7bf5; transform: translateY(-1px); }
    .btn-secondary { background: var(--surface-2); color: var(--muted); border: 1px solid var(--border); }
    .btn-secondary:hover { color: var(--text); }
    .btn-danger { background: var(--danger); color: #fff; }
    .btn-danger:hover { background: #ef4444; }
    
    .alert-success {
        background: rgba(16,185,129,.1);
        border: 1px solid rgba(16,185,129,.3);
        border-radius: 10px;
        padding: 12px 16px;
        margin-bottom: 24px;
        color: #10b981;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .alert-danger {
        background: rgba(248,113,113,.1);
        border: 1px solid rgba(248,113,113,.3);
        border-radius: 10px;
        padding: 12px 16px;
        margin-bottom: 24px;
    }
    .alert-danger ul {
        margin: 0;
        padding-left: 20px;
        color: var(--danger);
        font-size: 13px;
    }
    .info-text {
        font-size: 12px;
        color: var(--muted);
        margin-top: 5px;
    }
    .password-section {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid var(--border);
    }
    .password-section h4 {
        font-size: 14px;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    @media (max-width: 640px) {
        .row {
            grid-template-columns: 1fr;
            gap: 0;
        }
    }
</style>
@endpush

@section('content')

<div class="profile-container">
    @if(session('success'))
    <div class="alert-success">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif

    {{-- FORM UPDATE PROFIL --}}
    <div class="profile-card">
        <div class="profile-header">
            <div class="profile-avatar">
                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
            </div>
            <h3>{{ Auth::user()->name }}</h3>
            <p>{{ ucfirst(Auth::user()->role) }}</p>
        </div>

        <div class="profile-body">
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Nama Lengkap <span class="required">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name', Auth::user()->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback" style="color: var(--danger); font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Email <span class="required">*</span></label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                           value="{{ old('email', Auth::user()->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback" style="color: var(--danger); font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Role</label>
                    <input type="text" class="form-control" value="{{ ucfirst(Auth::user()->role) }}" readonly disabled>
                    <div class="info-text">Role tidak dapat diubah</div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Profil
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- FORM UPDATE PASSWORD --}}
    <div class="profile-card">
        <div class="profile-body">
            <div class="password-section">
                <h4>
                    <i class="fas fa-lock"></i> Ubah Password
                </h4>
                
                <form action="{{ route('profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Password Saat Ini <span class="required">*</span></label>
                        <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                        @error('current_password')
                            <div class="invalid-feedback" style="color: var(--danger); font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <label>Password Baru <span class="required">*</span></label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div class="invalid-feedback" style="color: var(--danger); font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Konfirmasi Password Baru <span class="required">*</span></label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>

                    <div class="info-text">
                        <i class="fas fa-info-circle"></i> Password minimal 6 karakter
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-key"></i> Ubah Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Auto-hide alert after 3 seconds
    setTimeout(function() {
        let alerts = document.querySelectorAll('.alert-success');
        alerts.forEach(function(alert) {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(function() {
                alert.remove();
            }, 500);
        });
    }, 3000);
</script>
@endpush