<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - SMP Negeri 1 Rajeg</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1a4fa0, #0e8a5f);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-wrapper {
            width: 900px;
            max-width: 100%;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            display: flex;
            min-height: 520px;
        }
        /* Panel kiri */
        .left-panel {
            flex: 1;
            background: linear-gradient(160deg, #1a4fa0 0%, #0e8a5f 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 48px 32px;
            text-align: center;
            color: white;
            border-right: 1px solid rgba(255,255,255,0.12);
        }
        .logo-circle {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            border: 2px solid rgba(255,255,255,0.35);
            background: rgba(255,255,255,0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            overflow: hidden;
        }
        .logo-circle img {
            width: 70px;
            height: 70px;
            object-fit: contain;
        }
        .school-name { font-size: 18px; font-weight: 600; }
        .school-divider {
            width: 40px; height: 2px;
            background: rgba(255,255,255,0.35);
            border-radius: 2px;
            margin: 14px auto;
        }
        .school-sub  { font-size: 13px; color: rgba(255,255,255,0.75); }
        .school-loc  { font-size: 12px; color: rgba(255,255,255,0.55); margin-top: 6px; }

        /* Panel kanan */
        .right-panel {
            flex: 1;
            background: #ffffff;
            padding: 48px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .portal-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(26,79,160,0.08);
            border: 1px solid rgba(26,79,160,0.2);
            border-radius: 20px;
            padding: 3px 12px;
            font-size: 12px;
            color: #1a4fa0;
            margin-bottom: 20px;
        }
        .form-heading { font-size: 22px; font-weight: 600; color: #1e2a3b; }
        .form-sub     { font-size: 13px; color: #6b7280; margin-top: 4px; margin-bottom: 28px; }

        .form-label   { font-size: 13px; font-weight: 500; color: #374151; }
        .form-control {
            border: 1px solid #d1d5db;
            border-radius: 8px;
            height: 42px;
            font-size: 14px;
            transition: border-color .2s, box-shadow .2s;
        }
        .form-control:focus {
            border-color: #1a4fa0;
            box-shadow: 0 0 0 3px rgba(26,79,160,0.12);
        }
        .btn-login {
            background: linear-gradient(135deg, #1a4fa0, #0e8a5f);
            border: none;
            border-radius: 8px;
            height: 44px;
            font-size: 15px;
            font-weight: 500;
            color: white;
            transition: opacity .2s;
        }
        .btn-login:hover { opacity: 0.88; color: white; }
        .footer-note { font-size: 12px; color: #9ca3af; text-align: center; margin-top: 24px; }
    </style>
</head>
<body>

<div class="login-wrapper">

    {{-- Panel kiri: identitas sekolah --}}
    <div class="left-panel">
        <div class="logo-circle">
            {{-- Taruh logo di: public/images/logo-sekolah.png --}}
            <img src="{{ asset('images/logo.png') }}" alt="Logo SMP Negeri 1 Rajeg">
        </div>
        <div class="school-name">SMP Negeri 1 Rajeg</div>
        <div class="school-divider"></div>
        <div class="school-sub">Sistem Informasi Pengolahan Nilai</div>
        <div class="school-loc">Kabupaten Tangerang · Banten</div>
    </div>

    {{-- Panel kanan: form login --}}
    <div class="right-panel">

        <div class="portal-badge">&#9679; Portal Akademik</div>
        <h4 class="form-heading">Selamat datang 👋</h4>
        <p class="form-sub">Masuk dengan akun yang telah terdaftar</p>

        @if($errors->any())
            <div class="alert alert-danger py-2" style="font-size:13px">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email"
                       name="email"
                       class="form-control"
                       placeholder="nama@smpn1rajeg.sch.id"
                       value="{{ old('email') }}"
                       required>
            </div>

            <div class="mb-4">
                <label class="form-label">Password</label>
                <input type="password"
                       name="password"
                       class="form-control"
                       placeholder="••••••••"
                       required>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-login">
                    Masuk ke Sistem
                </button>
            </div>
        </form>

        <div class="footer-note">
            &copy; {{ date('Y') }} SMP Negeri 1 Rajeg &middot; Sistem Akademik
        </div>
    </div>

</div>

</body>
</html>