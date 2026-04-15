<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistem Informasi Nilai Siswa</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #4e73df, #1cc88a);
            height: 100vh;
        }

        .login-card {
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        .school-title {
            font-weight: 600;
            color: #4e73df;
        }

        .btn-login {
            background-color: #4e73df;
            border: none;
        }

        .btn-login:hover {
            background-color: #2e59d9;
        }
    </style>
</head>
<body>

<div class="container h-100 d-flex justify-content-center align-items-center">
    <div class="col-md-5">

        <div class="card login-card p-4">

            <div class="text-center mb-4">
                <h4 class="school-title">Sistem Informasi</h4>
                <h5>Pengolahan Nilai Siswa</h5>
                <small class="text-muted">Silakan login untuk melanjutkan</small>
            </div>

            {{-- Error --}}
            @if($errors->any())
                <div class="alert alert-danger">
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
                           value="{{ old('email') }}" 
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" 
                           name="password" 
                           class="form-control" 
                           required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-login text-white">
                        Login
                    </button>
                </div>
            </form>

            <div class="text-center mt-3">
                <small class="text-muted">
                    © {{ date('Y') }} Sistem Akademik Sekolah
                </small>
            </div>

        </div>

    </div>
</div>

</body>
</html>