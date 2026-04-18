<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SiAkad') — Sistem Informasi Akademik</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --bg:        #0d0f14;
            --surface:   #13161e;
            --surface-2: #1a1e2a;
            --border:    #252b3b;
            --accent:    #4f8ef7;
            --accent-2:  #7c6af7;
            --success:   #34d399;
            --warning:   #fbbf24;
            --danger:    #f87171;
            --text:      #e2e8f0;
            --muted:     #64748b;
            --sidebar-w: 260px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            display: flex;
            min-height: 100vh;
            font-size: 14px;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--surface);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 100;
            transition: transform .3s ease;
        }

        .sidebar-brand {
            padding: 24px 20px 20px;
            border-bottom: 1px solid var(--border);
        }
        .sidebar-brand .logo-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .sidebar-brand .logo-icon {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            border-radius: 10px;
            display: grid; place-items: center;
            font-size: 17px; color: #fff;
            box-shadow: 0 4px 12px rgba(79,142,247,.35);
        }
        .sidebar-brand .logo-text {
            font-size: 17px;
            font-weight: 800;
            letter-spacing: -.3px;
            background: linear-gradient(135deg, #e2e8f0, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .sidebar-brand .logo-sub {
            font-size: 10px;
            color: var(--muted);
            letter-spacing: .5px;
            text-transform: uppercase;
        }

        /* Nav */
        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 16px 12px;
            scrollbar-width: thin;
            scrollbar-color: var(--border) transparent;
        }

        .nav-section-label {
            font-size: 9.5px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--muted);
            padding: 16px 8px 6px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            color: var(--muted);
            text-decoration: none;
            font-weight: 500;
            font-size: 13.5px;
            transition: all .18s;
            position: relative;
            margin-bottom: 2px;
        }
        .nav-item:hover {
            background: var(--surface-2);
            color: var(--text);
        }
        .nav-item.active {
            background: rgba(79,142,247,.12);
            color: var(--accent);
        }
        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0; top: 20%; bottom: 20%;
            width: 3px;
            background: var(--accent);
            border-radius: 0 2px 2px 0;
        }
        .nav-item i {
            width: 18px;
            text-align: center;
            font-size: 14px;
        }
        .nav-item .badge {
            margin-left: auto;
            background: var(--accent);
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 1px 7px;
            border-radius: 20px;
        }

        /* Sidebar footer */
        .sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid var(--border);
        }
        .user-card {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 10px;
            background: var(--surface-2);
        }
        .user-avatar {
            width: 34px; height: 34px;
            border-radius: 8px;
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            display: grid; place-items: center;
            font-size: 13px; color: #fff; font-weight: 700;
        }
        .user-name { font-size: 13px; font-weight: 600; color: var(--text); }
        .user-role { font-size: 11px; color: var(--muted); text-transform: capitalize; }
        .logout-btn {
            margin-left: auto;
            background: none; border: none; cursor: pointer;
            color: var(--muted); font-size: 14px;
            padding: 4px;
            transition: color .18s;
        }
        .logout-btn:hover { color: var(--danger); }

        /* ── MAIN ── */
        .main-wrap {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Topbar */
        .topbar {
            height: 60px;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            padding: 0 28px;
            gap: 16px;
            position: sticky;
            top: 0;
            z-index: 50;
        }
        .topbar-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text);
        }
        .topbar-breadcrumb {
            font-size: 12px;
            color: var(--muted);
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .topbar-breadcrumb span { color: var(--accent); }
        .topbar-right { margin-left: auto; display: flex; align-items: center; gap: 12px; }
        .topbar-time {
            font-family: 'JetBrains Mono', monospace;
            font-size: 12px;
            color: var(--muted);
            background: var(--surface-2);
            padding: 6px 12px;
            border-radius: 6px;
            border: 1px solid var(--border);
        }

        /* Page content */
        .page-content {
            padding: 28px;
            flex: 1;
        }

        /* ── ALERTS ── */
        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 13.5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .alert-success { background: rgba(52,211,153,.1); border: 1px solid rgba(52,211,153,.25); color: var(--success); }
        .alert-danger  { background: rgba(248,113,113,.1); border: 1px solid rgba(248,113,113,.25); color: var(--danger); }

        /* ── MOBILE TOGGLE ── */
        .hamburger {
            display: none;
            background: none; border: none; cursor: pointer;
            color: var(--text); font-size: 18px;
        }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-wrap { margin-left: 0; }
            .hamburger { display: block; }
            .page-content { padding: 16px; }
        }
    </style>

    @stack('styles')
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="logo-wrap">
            <div class="logo-icon"><i class="fas fa-graduation-cap"></i></div>
            <div>
                <div class="logo-text">SiAkad</div>
                <div class="logo-sub">Sistem Akademik</div>
            </div>
        </div>
    </div>

    <nav class="sidebar-nav">
        @auth
            @if(auth()->user()->role === 'admin')
                <div class="nav-section-label">Utama</div>
                <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-pie"></i> Dashboard
                </a>

                <div class="nav-section-label">Data Master</div>
                <a href="{{ route('admin.siswa.index') }}" class="nav-item {{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}">
                    <i class="fas fa-user-graduate"></i> Data Siswa
                </a>
                <a href="{{ route('admin.guru.index') }}" class="nav-item {{ request()->routeIs('admin.guru.*') ? 'active' : '' }}">
                    <i class="fas fa-chalkboard-teacher"></i> Data Guru
                </a>
                <a href="{{ route('admin.kelas.index') }}" class="nav-item {{ request()->routeIs('admin.kelas.*') ? 'active' : '' }}">
                    <i class="fas fa-door-open"></i> Data Kelas
                </a>
                <a href="{{ route('admin.mapel.index') }}" class="nav-item {{ request()->routeIs('admin.mapel.*') ? 'active' : '' }}">
                    <i class="fas fa-book-open"></i> Mata Pelajaran
                </a>
                <a href="{{ route('admin.kkm.index') }}" class="nav-item {{ request()->routeIs('admin.kkm.*') ? 'active' : '' }}">
                    <i class="fas fa-bullseye"></i> KKM
                </a>

                <div class="nav-section-label">Laporan</div>
                <a href="{{ route('laporan.rekap') }}" class="nav-item {{ request()->routeIs('laporan.rekap') ? 'active' : '' }}">
                    <i class="fas fa-table-list"></i> Rekap Kelas
                </a>
             

                <div class="nav-section-label">Pengaturan</div>
                <a href="{{ route('admin.user.index') }}" class="nav-item {{ request()->routeIs('admin.user.*') ? 'active' : '' }}">
                    <i class="fas fa-users-gear"></i> Manajemen User
                </a>

            @elseif(auth()->user()->role === 'guru')
                <div class="nav-section-label">Utama</div>
                <a href="{{ route('guru.dashboard') }}" class="nav-item {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-pie"></i> Dashboard
                </a>
                <a href="{{ route('guru.nilai.index') }}" class="nav-item {{ request()->routeIs('guru.nilai.*') ? 'active' : '' }}">
                    <i class="fas fa-pen-to-square"></i> Input Nilai
                </a>

                <div class="nav-section-label">Laporan</div>
                <a href="{{ route('laporan.rekap') }}" class="nav-item {{ request()->routeIs('laporan.rekap') ? 'active' : '' }}">
                    <i class="fas fa-table-list"></i> Rekap Kelas
                </a>

            @elseif(auth()->user()->role === 'siswa')
                <div class="nav-section-label">Utama</div>
                <a href="{{ route('siswa.dashboard') }}" class="nav-item {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-pie"></i> Dashboard
                </a>
            @endif

            <!-- Profile — semua role -->
            <div class="nav-section-label">Akun</div>
            <a href="{{ route('profile.edit') }}" class="nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <i class="fas fa-circle-user"></i> Profil Saya
            </a>
        @endauth
    </nav>

    <div class="sidebar-footer">
        @auth
        <div class="user-card">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div>
                <div class="user-name">{{ Str::limit(auth()->user()->name, 16) }}</div>
                <div class="user-role">{{ auth()->user()->role }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}" style="margin:0">
                @csrf
                <button type="submit" class="logout-btn" title="Logout">
                    <i class="fas fa-arrow-right-from-bracket"></i>
                </button>
            </form>
        </div>
        @endauth
    </div>
</aside>

<!-- MAIN -->
<div class="main-wrap">
    <!-- Topbar -->
    <header class="topbar">
        <button class="hamburger" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
        <div>
            <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
            <div class="topbar-breadcrumb">
                <i class="fas fa-house" style="font-size:10px"></i>
                @yield('breadcrumb')
            </div>
        </div>
        <div class="topbar-right">
            <div class="topbar-time" id="clock">--:--:--</div>
        </div>
    </header>

    <!-- Content -->
    <main class="page-content">
        @if(session('success'))
            <div class="alert alert-success"><i class="fas fa-circle-check"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger"><i class="fas fa-circle-exclamation"></i> {{ session('error') }}</div>
        @endif

        @yield('content')
    </main>
</div>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
    }

    // Live clock
    function tick() {
        const now = new Date();
        document.getElementById('clock').textContent =
            now.toLocaleTimeString('id-ID', { hour12: false });
    }
    tick();
    setInterval(tick, 1000);
</script>

@stack('scripts')
</body>
</html>