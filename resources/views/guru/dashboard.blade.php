@extends('layouts.app')

@section('title', 'Dashboard Guru')
@section('page-title', 'Dashboard')
@section('breadcrumb') <span>Guru</span> / Dashboard @endsection

@push('styles')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 28px;
    }

    .stat-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 20px;
        position: relative;
        overflow: hidden;
        transition: transform .2s, border-color .2s;
    }
    .stat-card:hover { transform: translateY(-2px); border-color: var(--accent); }
    .stat-card .stat-icon {
        width: 44px; height: 44px;
        border-radius: 10px;
        display: grid; place-items: center;
        font-size: 18px;
        margin-bottom: 14px;
    }
    .stat-card .stat-value {
        font-size: 28px; font-weight: 800; line-height: 1;
        margin-bottom: 4px;
    }
    .stat-card .stat-label { font-size: 12px; color: var(--muted); font-weight: 500; }
    .stat-card .stat-glow {
        position: absolute; right: -20px; top: -20px;
        width: 80px; height: 80px;
        border-radius: 50%;
        opacity: .08;
    }

    .icon-blue  { background: rgba(79,142,247,.15); color: var(--accent); }
    .icon-purple{ background: rgba(124,106,247,.15); color: var(--accent-2); }
    .icon-green { background: rgba(52,211,153,.15);  color: var(--success); }
    .icon-amber { background: rgba(251,191,36,.15);  color: var(--warning); }
    .glow-blue  { background: var(--accent); }
    .glow-purple{ background: var(--accent-2); }
    .glow-green { background: var(--success); }
    .glow-amber { background: var(--warning); }

    /* 2-col grid */
    .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
    @media(max-width: 900px){ .two-col { grid-template-columns: 1fr; } }

    .card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 12px;
        overflow: hidden;
    }
    .card-header {
        padding: 16px 20px;
        border-bottom: 1px solid var(--border);
        display: flex; align-items: center; gap: 10px;
    }
    .card-header .card-title { font-size: 14px; font-weight: 700; }
    .card-header .card-sub   { font-size: 12px; color: var(--muted); margin-left: auto; }
    .card-body { padding: 16px 20px; }

    /* Mapel stats bars */
    .mapel-row { margin-bottom: 14px; }
    .mapel-row:last-child { margin-bottom: 0; }
    .mapel-row .mapel-top {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 6px;
    }
    .mapel-row .mapel-name { font-size: 13px; font-weight: 600; }
    .mapel-row .mapel-avg  {
        font-size: 13px; font-weight: 700;
        font-family: 'JetBrains Mono', monospace;
    }
    .mapel-row .progress-bar {
        height: 6px;
        background: var(--surface-2);
        border-radius: 3px;
        overflow: hidden;
    }
    .mapel-row .progress-fill {
        height: 100%; border-radius: 3px;
        background: linear-gradient(90deg, var(--accent), var(--accent-2));
        transition: width .6s ease;
    }

    /* Predikat donut */
    .predikat-grid {
        display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px;
    }
    .predikat-item {
        background: var(--surface-2);
        border-radius: 10px;
        padding: 14px 10px;
        text-align: center;
    }
    .predikat-item .pred-letter {
        font-size: 24px; font-weight: 800;
        line-height: 1; margin-bottom: 4px;
    }
    .predikat-item .pred-count {
        font-size: 11px; color: var(--muted);
    }
    .pred-A { color: var(--success); }
    .pred-B { color: var(--accent); }
    .pred-C { color: var(--warning); }
    .pred-D { color: var(--danger); }

    /* Recent nilai table */
    .recent-table { width: 100%; border-collapse: collapse; }
    .recent-table th {
        font-size: 11px; font-weight: 700; text-transform: uppercase;
        letter-spacing: .8px; color: var(--muted);
        padding: 8px 12px; text-align: left;
        border-bottom: 1px solid var(--border);
    }
    .recent-table td {
        padding: 10px 12px; font-size: 13px;
        border-bottom: 1px solid rgba(37,43,59,.5);
    }
    .recent-table tr:last-child td { border-bottom: none; }
    .recent-table tr:hover td { background: var(--surface-2); }

    .badge-predikat {
        display: inline-block;
        padding: 2px 10px; border-radius: 20px;
        font-size: 11px; font-weight: 700;
    }
    .bp-A { background: rgba(52,211,153,.15); color: var(--success); }
    .bp-B { background: rgba(79,142,247,.15);  color: var(--accent); }
    .bp-C { background: rgba(251,191,36,.15);  color: var(--warning); }
    .bp-D { background: rgba(248,113,113,.15); color: var(--danger); }

    .lulus-chip {
        font-size: 10px; font-weight: 700; padding: 2px 8px; border-radius: 20px;
    }
    .chip-lulus   { background: rgba(52,211,153,.15); color: var(--success); }
    .chip-remedial{ background: rgba(248,113,113,.15); color: var(--danger); }

    /* Mapel cards */
    .mapel-cards { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 12px; }
    .mapel-chip {
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 14px 16px;
        display: flex; align-items: center; gap: 10px;
    }
    .mapel-chip .mc-icon {
        width: 36px; height: 36px; border-radius: 8px;
        background: linear-gradient(135deg, var(--accent), var(--accent-2));
        display: grid; place-items: center;
        font-size: 14px; color: #fff; flex-shrink: 0;
    }
    .mapel-chip .mc-name { font-size: 12.5px; font-weight: 600; line-height: 1.3; }
    .mapel-chip .mc-kelas { font-size: 11px; color: var(--muted); margin-top: 2px; }

    /* Welcome bar */
    .welcome-bar {
        background: linear-gradient(135deg, rgba(79,142,247,.12), rgba(124,106,247,.08));
        border: 1px solid rgba(79,142,247,.2);
        border-radius: 14px;
        padding: 22px 28px;
        display: flex; align-items: center; gap: 20px;
        margin-bottom: 24px;
        position: relative; overflow: hidden;
    }
    .welcome-bar::before {
        content: '';
        position: absolute; right: -40px; top: -40px;
        width: 180px; height: 180px;
        background: radial-gradient(circle, rgba(79,142,247,.15) 0%, transparent 70%);
        pointer-events: none;
    }
    .wb-avatar {
        width: 52px; height: 52px; border-radius: 12px;
        background: linear-gradient(135deg, var(--accent), var(--accent-2));
        display: grid; place-items: center;
        font-size: 22px; font-weight: 800; color: #fff;
        flex-shrink: 0;
    }
    .wb-title { font-size: 18px; font-weight: 800; margin-bottom: 3px; }
    .wb-sub   { font-size: 13px; color: var(--muted); }
    .wb-actions { margin-left: auto; display: flex; gap: 10px; }
    .btn {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 9px 18px; border-radius: 8px;
        font-size: 13px; font-weight: 600;
        text-decoration: none; cursor: pointer;
        border: none; transition: all .18s;
    }
    .btn-primary {
        background: var(--accent); color: #fff;
    }
    .btn-primary:hover { background: #3b7de8; }
    .btn-secondary {
        background: var(--surface-2); color: var(--text);
        border: 1px solid var(--border);
    }
    .btn-secondary:hover { border-color: var(--accent); color: var(--accent); }
</style>
@endpush

@section('content')

{{-- Welcome bar --}}
<div class="welcome-bar">
    <div class="wb-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
    <div>
        <div class="wb-title">Selamat datang, {{ auth()->user()->name }}! 👋</div>
        <div class="wb-sub">
            Anda mengampu {{ $mapel->count() }} mata pelajaran &bull;
            {{ now()->translatedFormat('l, d F Y') }}
        </div>
    </div>
    <div class="wb-actions">
        <a href="{{ route('guru.nilai.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Input Nilai
        </a>
        <a href="{{ route('laporan.rekap') }}" class="btn btn-secondary">
            <i class="fas fa-table-list"></i> Rekap
        </a>
    </div>
</div>

{{-- Stat cards --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-glow glow-blue"></div>
        <div class="stat-icon icon-blue"><i class="fas fa-book-open"></i></div>
        <div class="stat-value" style="color:var(--accent)">{{ $mapel->count() }}</div>
        <div class="stat-label">Mata Pelajaran</div>
    </div>
    <div class="stat-card">
        <div class="stat-glow glow-purple"></div>
        <div class="stat-icon icon-purple"><i class="fas fa-door-open"></i></div>
        <div class="stat-value" style="color:var(--accent-2)">{{ $totalKelas }}</div>
        <div class="stat-label">Kelas Diampu</div>
    </div>
    <div class="stat-card">
        <div class="stat-glow glow-green"></div>
        <div class="stat-icon icon-green"><i class="fas fa-user-graduate"></i></div>
        <div class="stat-value" style="color:var(--success)">{{ $totalSiswa }}</div>
        <div class="stat-label">Total Siswa</div>
    </div>
    <div class="stat-card">
        <div class="stat-glow glow-amber"></div>
        <div class="stat-icon icon-amber"><i class="fas fa-pen-to-square"></i></div>
        <div class="stat-value" style="color:var(--warning)">{{ $totalNilai }}</div>
        <div class="stat-label">Nilai Diinput</div>
    </div>
</div>

{{-- Mapel yang diampu --}}
<div class="card" style="margin-bottom:20px">
    <div class="card-header">
        <i class="fas fa-book-open" style="color:var(--accent)"></i>
        <span class="card-title">Mata Pelajaran yang Diampu</span>
    </div>
    <div class="card-body">
        @if($mapel->isEmpty())
            <p style="color:var(--muted);font-size:13px;">Belum ada mata pelajaran yang ditugaskan.</p>
        @else
        <div class="mapel-cards">
            @foreach($mapel as $mp)
            <div class="mapel-chip">
                <div class="mc-icon"><i class="fas fa-book"></i></div>
                <div>
                    <div class="mc-name">{{ $mp->nama_mapel }}</div>
                    <div class="mc-kelas">{{ $mp->kelas->nama_kelas ?? '-' }}</div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>

{{-- Stats & Predikat --}}
<div class="two-col">
    {{-- Rata-rata per mapel --}}
    <div class="card">
        <div class="card-header">
            <i class="fas fa-chart-bar" style="color:var(--accent-2)"></i>
            <span class="card-title">Rata-rata Nilai per Mapel</span>
        </div>
        <div class="card-body">
            @forelse($statsMapel as $s)
            <div class="mapel-row">
                <div class="mapel-top">
                    <span class="mapel-name">{{ $s['nama'] }}</span>
                    <span class="mapel-avg" style="color:{{ $s['rata_rata'] >= 75 ? 'var(--success)' : 'var(--warning)' }}">
                        {{ $s['rata_rata'] }}
                    </span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width:{{ $s['rata_rata'] }}%"></div>
                </div>
            </div>
            @empty
            <p style="color:var(--muted);font-size:13px;">Belum ada data nilai.</p>
            @endforelse
        </div>
    </div>

    {{-- Distribusi predikat --}}
    <div class="card">
        <div class="card-header">
            <i class="fas fa-award" style="color:var(--warning)"></i>
            <span class="card-title">Distribusi Predikat</span>
        </div>
        <div class="card-body">
            <div class="predikat-grid">
                @foreach(['A','B','C','D'] as $p)
                <div class="predikat-item">
                    <div class="pred-letter pred-{{ $p }}">{{ $p }}</div>
                    <div class="pred-count">{{ $distribusi[$p] ?? 0 }} siswa</div>
                </div>
                @endforeach
            </div>
            @php
                $total = array_sum($distribusi ?: [0]);
            @endphp
            @if($total > 0)
            <div style="margin-top:18px">
                <div style="height:8px;border-radius:4px;overflow:hidden;display:flex;gap:2px">
                    @foreach(['A'=>'var(--success)','B'=>'var(--accent)','C'=>'var(--warning)','D'=>'var(--danger)'] as $p=>$color)
                        @php $pct = $total > 0 ? (($distribusi[$p] ?? 0)/$total)*100 : 0 @endphp
                        @if($pct > 0)
                        <div style="width:{{ $pct }}%;background:{{ $color }};border-radius:2px"></div>
                        @endif
                    @endforeach
                </div>
                <div style="display:flex;justify-content:space-between;margin-top:8px;font-size:11px;color:var(--muted)">
                    <span>Total: {{ $total }} data</span>
                    <span>Lulus: {{ number_format(((($distribusi['A']??0)+($distribusi['B']??0)+($distribusi['C']??0))/$total)*100,1) }}%</span>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Nilai terbaru --}}
<div class="card">
    <div class="card-header">
        <i class="fas fa-clock-rotate-left" style="color:var(--accent)"></i>
        <span class="card-title">Nilai Terbaru Diinput</span>
        <a href="{{ route('guru.nilai.index') }}" class="card-sub" style="text-decoration:none;color:var(--accent)">
            Lihat semua <i class="fas fa-arrow-right" style="font-size:10px"></i>
        </a>
    </div>
    <div class="card-body" style="padding:0">
        @if($nilaiTerbaru->isEmpty())
            <p style="padding:20px;color:var(--muted);font-size:13px;">Belum ada data nilai.</p>
        @else
        <table class="recent-table">
            <thead>
                <tr>
                    <th>Siswa</th>
                    <th>Mata Pelajaran</th>
                    <th>Semester</th>
                    <th>Nilai Akhir</th>
                    <th>Predikat</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($nilaiTerbaru as $n)
                <tr>
                    <td style="font-weight:600">{{ $n->siswa->nama ?? '-' }}</td>
                    <td style="color:var(--muted)">{{ $n->mataPelajaran->nama_mapel ?? '-' }}</td>
                    <td style="font-family:'JetBrains Mono',monospace;font-size:12px">
                        Sem {{ $n->semester }} / {{ $n->tahun_ajaran }}
                    </td>
                    <td>
                        <span style="font-family:'JetBrains Mono',monospace;font-weight:700;color:{{ ($n->nilai_akhir??0)>=75 ? 'var(--success)' : 'var(--warning)' }}">
                            {{ $n->nilai_akhir ?? '-' }}
                        </span>
                    </td>
                    <td>
                        <span class="badge-predikat bp-{{ $n->predikat ?? 'D' }}">
                            {{ $n->predikat ?? '-' }}
                        </span>
                    </td>
                    <td>
                        <span class="lulus-chip {{ $n->lulus ? 'chip-lulus' : 'chip-remedial' }}">
                            {{ $n->lulus ? 'Lulus' : 'Remedial' }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>

@endsection