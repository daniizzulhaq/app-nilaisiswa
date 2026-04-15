@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')
@section('breadcrumb')
    <span>Admin</span> / Dashboard
@endsection

@push('styles')
<style>
    /* ── STATS GRID ── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 28px;
    }

    .stat-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        position: relative;
        overflow: hidden;
        transition: transform .2s, border-color .2s;
        animation: fadeUp .4s ease both;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        border-color: var(--accent);
    }
    .stat-card::after {
        content: '';
        position: absolute;
        inset: 0;
        background: var(--card-glow, transparent);
        pointer-events: none;
        border-radius: inherit;
    }

    .stat-icon {
        width: 48px; height: 48px;
        border-radius: 12px;
        display: grid; place-items: center;
        font-size: 20px;
        flex-shrink: 0;
    }
    .stat-icon.blue   { background: rgba(79,142,247,.15);  color: #4f8ef7; }
    .stat-icon.purple { background: rgba(124,106,247,.15); color: #7c6af7; }
    .stat-icon.green  { background: rgba(52,211,153,.15);  color: #34d399; }
    .stat-icon.orange { background: rgba(251,191,36,.15);  color: #fbbf24; }
    .stat-icon.red    { background: rgba(248,113,113,.15); color: #f87171; }
    .stat-icon.teal   { background: rgba(45,212,191,.15);  color: #2dd4bf; }

    .stat-body {}
    .stat-label {
        font-size: 11.5px;
        font-weight: 600;
        color: var(--muted);
        text-transform: uppercase;
        letter-spacing: .5px;
        margin-bottom: 4px;
    }
    .stat-value {
        font-size: 26px;
        font-weight: 800;
        color: var(--text);
        letter-spacing: -1px;
        line-height: 1;
    }
    .stat-sub {
        font-size: 11px;
        color: var(--muted);
        margin-top: 4px;
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .stat-card:nth-child(1) { animation-delay: .05s }
    .stat-card:nth-child(2) { animation-delay: .10s }
    .stat-card:nth-child(3) { animation-delay: .15s }
    .stat-card:nth-child(4) { animation-delay: .20s }
    .stat-card:nth-child(5) { animation-delay: .25s }
    .stat-card:nth-child(6) { animation-delay: .30s }

    /* ── BOTTOM ROW ── */
    .bottom-grid {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 20px;
    }
    @media (max-width: 900px) {
        .bottom-grid { grid-template-columns: 1fr; }
    }

    .panel {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
    }
    .panel-header {
        padding: 18px 22px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .panel-title {
        font-size: 14px;
        font-weight: 700;
        color: var(--text);
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .panel-title i { color: var(--accent); font-size: 13px; }
    .panel-body { padding: 20px 22px; }

    /* Lulus chart */
    .lulus-wrap {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
    .lulus-bar-row {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .lulus-bar-meta {
        display: flex;
        justify-content: space-between;
        font-size: 12.5px;
    }
    .lulus-bar-label { font-weight: 600; color: var(--text); }
    .lulus-bar-count { color: var(--muted); }
    .lulus-bar-track {
        height: 8px;
        background: var(--surface-2);
        border-radius: 99px;
        overflow: hidden;
    }
    .lulus-bar-fill {
        height: 100%;
        border-radius: 99px;
        transition: width 1s cubic-bezier(.4,0,.2,1);
    }
    .lulus-bar-fill.success { background: linear-gradient(90deg, #34d399, #2dd4bf); }
    .lulus-bar-fill.danger  { background: linear-gradient(90deg, #f87171, #fb923c); }

    .rata-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        background: rgba(79,142,247,.08);
        border: 1px solid rgba(79,142,247,.2);
        border-radius: 10px;
        font-size: 13px;
        color: var(--accent);
        font-weight: 600;
    }
    .rata-badge .big { font-size: 22px; font-weight: 800; }

    /* Quick actions */
    .qa-list { display: flex; flex-direction: column; gap: 10px; }
    .qa-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 14px;
        border-radius: 10px;
        background: var(--surface-2);
        text-decoration: none;
        color: var(--text);
        font-size: 13.5px;
        font-weight: 500;
        border: 1px solid transparent;
        transition: all .18s;
    }
    .qa-item:hover {
        border-color: var(--accent);
        color: var(--accent);
        transform: translateX(3px);
    }
    .qa-item i { width: 16px; text-align: center; color: var(--accent); }
    .qa-item .arrow { margin-left: auto; color: var(--muted); font-size: 11px; }

    /* Welcome banner */
    .welcome-banner {
        background: linear-gradient(135deg, #1a2035, #1e1a35);
        border: 1px solid rgba(79,142,247,.2);
        border-radius: 14px;
        padding: 24px 28px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        animation: fadeUp .3s ease;
        position: relative;
        overflow: hidden;
    }
    .welcome-banner::before {
        content: '';
        position: absolute;
        right: -40px; top: -40px;
        width: 200px; height: 200px;
        background: radial-gradient(circle, rgba(79,142,247,.12), transparent 70%);
    }
    .welcome-banner::after {
        content: '';
        position: absolute;
        right: 100px; bottom: -60px;
        width: 150px; height: 150px;
        background: radial-gradient(circle, rgba(124,106,247,.1), transparent 70%);
    }
    .banner-text { position: relative; z-index: 1; }
    .banner-greeting {
        font-size: 20px;
        font-weight: 800;
        color: var(--text);
        margin-bottom: 4px;
    }
    .banner-sub { font-size: 13px; color: var(--muted); }
    .banner-icon {
        font-size: 52px;
        position: relative;
        z-index: 1;
        filter: drop-shadow(0 4px 20px rgba(79,142,247,.4));
    }
</style>
@endpush

@section('content')

{{-- WELCOME BANNER --}}
<div class="welcome-banner">
    <div class="banner-text">
        <div class="banner-greeting">Selamat datang, {{ auth()->user()->name }}! 👋</div>
        <div class="banner-sub">
            {{ now()->translatedFormat('l, d F Y') }} — Berikut ringkasan data akademik hari ini.
        </div>
    </div>
    <div class="banner-icon">🎓</div>
</div>

{{-- STAT CARDS --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fas fa-user-graduate"></i></div>
        <div class="stat-body">
            <div class="stat-label">Total Siswa</div>
            <div class="stat-value">{{ number_format($total_siswa) }}</div>
            <div class="stat-sub">Siswa terdaftar</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon purple"><i class="fas fa-chalkboard-teacher"></i></div>
        <div class="stat-body">
            <div class="stat-label">Total Guru</div>
            <div class="stat-value">{{ number_format($total_guru) }}</div>
            <div class="stat-sub">Guru aktif</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon orange"><i class="fas fa-door-open"></i></div>
        <div class="stat-body">
            <div class="stat-label">Total Kelas</div>
            <div class="stat-value">{{ number_format($total_kelas) }}</div>
            <div class="stat-sub">Kelas aktif</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon teal"><i class="fas fa-book-open"></i></div>
        <div class="stat-body">
            <div class="stat-label">Mata Pelajaran</div>
            <div class="stat-value">{{ number_format($total_mapel) }}</div>
            <div class="stat-sub">Mata pelajaran</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-circle-check"></i></div>
        <div class="stat-body">
            <div class="stat-label">Siswa Lulus</div>
            <div class="stat-value">{{ number_format($siswa_lulus) }}</div>
            <div class="stat-sub">Melampaui KKM</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon red"><i class="fas fa-circle-xmark"></i></div>
        <div class="stat-body">
            <div class="stat-label">Tidak Lulus</div>
            <div class="stat-value">{{ number_format($siswa_tidak_lulus) }}</div>
            <div class="stat-sub">Di bawah KKM</div>
        </div>
    </div>
</div>

{{-- BOTTOM ROW --}}
<div class="bottom-grid">
    {{-- Lulus panel --}}
    <div class="panel">
        <div class="panel-header">
            <div class="panel-title">
                <i class="fas fa-chart-bar"></i> Statistik Kelulusan
            </div>
            <div class="rata-badge">
                <span>Rata Nilai</span>
                <span class="big">{{ $rata_nilai ? number_format($rata_nilai, 1) : '—' }}</span>
            </div>
        </div>
        <div class="panel-body">
            @php
                $total_nilai = $siswa_lulus + $siswa_tidak_lulus;
                $pct_lulus   = $total_nilai > 0 ? round($siswa_lulus / $total_nilai * 100) : 0;
                $pct_gagal   = $total_nilai > 0 ? round($siswa_tidak_lulus / $total_nilai * 100) : 0;
            @endphp

            <div class="lulus-wrap">
                <div class="lulus-bar-row">
                    <div class="lulus-bar-meta">
                        <span class="lulus-bar-label">✅ Lulus / Tuntas</span>
                        <span class="lulus-bar-count">{{ $siswa_lulus }} siswa ({{ $pct_lulus }}%)</span>
                    </div>
                    <div class="lulus-bar-track">
                        <div class="lulus-bar-fill success" style="width: {{ $pct_lulus }}%"></div>
                    </div>
                </div>

                <div class="lulus-bar-row">
                    <div class="lulus-bar-meta">
                        <span class="lulus-bar-label">❌ Tidak Lulus / Remedi</span>
                        <span class="lulus-bar-count">{{ $siswa_tidak_lulus }} siswa ({{ $pct_gagal }}%)</span>
                    </div>
                    <div class="lulus-bar-track">
                        <div class="lulus-bar-fill danger" style="width: {{ $pct_gagal }}%"></div>
                    </div>
                </div>

                <div style="padding-top:8px; border-top: 1px solid var(--border); font-size:12px; color:var(--muted)">
                    <i class="fas fa-info-circle"></i>
                    Total data nilai: <strong style="color:var(--text)">{{ number_format($total_nilai) }}</strong> entri.
                    Persentase kelulusan global: <strong style="color:var(--success)">{{ $pct_lulus }}%</strong>.
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="panel">
        <div class="panel-header">
            <div class="panel-title"><i class="fas fa-bolt"></i> Aksi Cepat</div>
        </div>
        <div class="panel-body">
            <div class="qa-list">
                <a href="{{ route('admin.siswa.create') }}" class="qa-item">
                    <i class="fas fa-user-plus"></i> Tambah Siswa Baru
                    <i class="fas fa-chevron-right arrow"></i>
                </a>
                <a href="{{ route('admin.guru.create') }}" class="qa-item">
                    <i class="fas fa-person-chalkboard"></i> Tambah Guru Baru
                    <i class="fas fa-chevron-right arrow"></i>
                </a>
                <a href="{{ route('admin.kelas.create') }}" class="qa-item">
                    <i class="fas fa-plus-circle"></i> Buat Kelas Baru
                    <i class="fas fa-chevron-right arrow"></i>
                </a>
                <a href="{{ route('admin.mapel.create') }}" class="qa-item">
                    <i class="fas fa-book-medical"></i> Tambah Mata Pelajaran
                    <i class="fas fa-chevron-right arrow"></i>
                </a>
                <a href="{{ route('laporan.rekap') }}" class="qa-item">
                    <i class="fas fa-table-list"></i> Lihat Rekap Kelas
                    <i class="fas fa-chevron-right arrow"></i>
                </a>
                <a href="{{ route('laporan.export.excel') }}" class="qa-item">
                    <i class="fas fa-file-excel"></i> Export Excel
                    <i class="fas fa-chevron-right arrow"></i>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection