@extends('layouts.app')

@section('title', 'Dashboard Siswa')
@section('page-title', 'Dashboard Siswa')
@section('breadcrumb')
    <span>Siswa</span> / Dashboard
@endsection

@push('styles')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    .stat-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 20px;
        transition: all .2s;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        border-color: var(--accent);
    }
    .stat-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 15px;
    }
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: grid;
        place-items: center;
        font-size: 22px;
    }
    .stat-icon.blue { background: rgba(79,142,247,.1); color: #4f8ef7; }
    .stat-icon.green { background: rgba(16,185,129,.1); color: #10b981; }
    .stat-icon.orange { background: rgba(245,158,11,.1); color: #f59e0b; }
    .stat-icon.purple { background: rgba(124,106,247,.1); color: #7c6af7; }
    .stat-icon.red { background: rgba(248,113,113,.1); color: #ef4444; }
    
    .stat-value {
        font-size: 28px;
        font-weight: 800;
        color: var(--text);
        margin-bottom: 5px;
    }
    .stat-label {
        font-size: 13px;
        color: var(--muted);
    }
    
    .welcome-section {
        background: linear-gradient(135deg, rgba(79,142,247,.1), rgba(124,106,247,.1));
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 30px;
    }
    .welcome-section h2 {
        font-size: 22px;
        font-weight: 800;
        margin-bottom: 5px;
    }
    .welcome-section p {
        color: var(--muted);
        font-size: 13px;
    }
    
    .chart-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .chart-title {
        font-size: 14px;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .nilai-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .nilai-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 15px;
        background: var(--surface-2);
        border-radius: 10px;
        border: 1px solid var(--border);
    }
    .nilai-mapel {
        font-weight: 600;
        color: var(--text);
    }
    .nilai-value {
        font-size: 16px;
        font-weight: 700;
    }
    .nilai-value.high { color: #10b981; }
    .nilai-value.medium { color: #f59e0b; }
    .nilai-value.low { color: #ef4444; }
    
    .predikat {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
    }
    .predikat-a { background: rgba(16,185,129,.15); color: #10b981; }
    .predikat-b { background: rgba(79,142,247,.15); color: #4f8ef7; }
    .predikat-c { background: rgba(245,158,11,.15); color: #f59e0b; }
    .predikat-d { background: rgba(248,113,113,.15); color: #ef4444; }
    
    .two-columns {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }
    
    @media (max-width: 768px) {
        .two-columns {
            grid-template-columns: 1fr;
        }
    }
    
    .info-siswa {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        margin-top: 15px;
    }
    .info-siswa-item {
        flex: 1;
        min-width: 150px;
    }
    .info-siswa-label {
        font-size: 11px;
        color: var(--muted);
        text-transform: uppercase;
        letter-spacing: .5px;
    }
    .info-siswa-value {
        font-size: 14px;
        font-weight: 600;
        margin-top: 4px;
    }
</style>
@endpush

@section('content')

<div class="welcome-section">
    <h2>Selamat Datang, {{ $siswa->nama ?? Auth::user()->name }}!</h2>
    <p>Berikut adalah ringkasan hasil belajar Anda.</p>
    
    <div class="info-siswa">
        <div class="info-siswa-item">
            <div class="info-siswa-label">NIS</div>
            <div class="info-siswa-value">{{ $siswa->nis ?? '-' }}</div>
        </div>
        <div class="info-siswa-item">
            <div class="info-siswa-label">Kelas</div>
            <div class="info-siswa-value">{{ $siswa->kelas->nama_kelas ?? '-' }}</div>
        </div>
        <div class="info-siswa-item">
            <div class="info-siswa-label">Tahun Ajaran</div>
            <div class="info-siswa-value">{{ date('Y') }}/{{ date('Y')+1 }}</div>
        </div>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon blue">
                <i class="fas fa-book"></i>
            </div>
        </div>
        <div class="stat-value">{{ $totalMapel ?? 0 }}</div>
        <div class="stat-label">Total Mata Pelajaran</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon green">
                <i class="fas fa-chart-line"></i>
            </div>
        </div>
        <div class="stat-value">{{ number_format($rataRata ?? 0, 2) }}</div>
        <div class="stat-label">Rata-rata Nilai</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon purple">
                <i class="fas fa-star"></i>
            </div>
        </div>
        <div class="stat-value">{{ $nilaiTertinggi ?? 0 }}</div>
        <div class="stat-label">Nilai Tertinggi</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon orange">
                <i class="fas fa-flag-checkered"></i>
            </div>
        </div>
        <div class="stat-value">{{ $predikatUtama ?? '-' }}</div>
        <div class="stat-label">Predikat Utama</div>
    </div>
</div>

<div class="two-columns">
    {{-- Daftar Nilai --}}
    <div class="chart-card">
        <div class="chart-title">
            <i class="fas fa-list-check"></i> Daftar Nilai Mata Pelajaran
        </div>
        <div class="nilai-list">
            @forelse($nilai as $n)
            <div class="nilai-item">
                <div>
                    <div class="nilai-mapel">{{ $n->mataPelajaran->nama_mapel ?? '-' }}</div>
                    <div style="font-size: 11px; color: var(--muted);">{{ $n->mataPelajaran->kode_mapel ?? '-' }}</div>
                </div>
                <div style="text-align: right;">
                    <div class="nilai-value 
                        @if(($n->nilai_akhir ?? 0) >= 85) high
                        @elseif(($n->nilai_akhir ?? 0) >= 70) medium
                        @else low @endif">
                        {{ $n->nilai_akhir ?? '-' }}
                    </div>
                    <div>
                        <span class="predikat predikat-{{ strtolower($n->predikat ?? 'd') }}">
                            {{ $n->predikat ?? '-' }}
                        </span>
                    </div>
                </div>
            </div>
            @empty
            <div style="text-align: center; padding: 40px; color: var(--muted);">
                <i class="fas fa-chart-simple" style="font-size: 40px; margin-bottom: 10px; opacity: 0.3;"></i>
                <p>Belum ada data nilai</p>
            </div>
            @endforelse
        </div>
    </div>
    
    {{-- Grafik dan Statistik --}}
    <div class="chart-card">
        <div class="chart-title">
            <i class="fas fa-chart-pie"></i> Statistik Nilai
        </div>
        <canvas id="nilaiChart" width="400" height="300" style="max-height: 300px;"></canvas>
        
        <div style="margin-top: 20px;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                <span style="font-size: 13px;">Status Kelulusan</span>
                <span style="font-size: 13px; font-weight: 600; color: {{ ($statusLulus ?? false) ? '#10b981' : '#ef4444' }}">
                    {{ ($statusLulus ?? false) ? '✓ LULUS' : '✗ REMEDIAL' }}
                </span>
            </div>
            <div class="progress-bar" style="width: 100%; height: 8px; background: rgba(79,142,247,.2); border-radius: 4px;">
                <div class="progress-fill" style="width: {{ $persentaseKelulusan ?? 0 }}%; background: {{ ($statusLulus ?? false) ? '#10b981' : '#ef4444' }};"></div>
            </div>
            <div style="margin-top: 15px; text-align: center;">
               <a href="{{ route('siswa.raport', $siswa->id) }}">Lihat Raport</a>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart Nilai
    const ctx = document.getElementById('nilaiChart').getContext('2d');
    
    // Data dari PHP
    const mapelNames = @json($nilai->pluck('mataPelajaran.nama_mapel')->toArray() ?? []);
    const nilaiAkhirs = @json($nilai->pluck('nilai_akhir')->toArray() ?? []);
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: mapelNames,
            datasets: [{
                label: 'Nilai Akhir',
                data: nilaiAkhirs,
                backgroundColor: 'rgba(79, 142, 247, 0.6)',
                borderColor: '#4f8ef7',
                borderWidth: 1,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    title: {
                        display: true,
                        text: 'Nilai'
                    }
                },
                x: {
                    ticks: {
                        maxRotation: 45,
                        minRotation: 45
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `Nilai: ${context.raw}`;
                        }
                    }
                }
            }
        }
    });
</script>
@endpush