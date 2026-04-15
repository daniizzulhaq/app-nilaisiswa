@extends('layouts.app')

@section('title', 'Detail Nilai')
@section('page-title', 'Detail Nilai')
@section('breadcrumb')
    <span>Siswa</span> / <a href="{{ route('siswa.dashboard') }}">Dashboard</a> / Detail Nilai
@endsection

@push('styles')
<style>
    .detail-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
    }
    .detail-header {
        background: linear-gradient(135deg, #4f8ef7, #7c6af7);
        padding: 25px;
        color: #fff;
    }
    .detail-header h2 {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 5px;
    }
    .detail-header p {
        font-size: 13px;
        opacity: 0.9;
    }
    .detail-body {
        padding: 25px;
    }
    .info-siswa {
        background: var(--surface-2);
        border-radius: 12px;
        padding: 15px 20px;
        margin-bottom: 25px;
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }
    .info-item {
        flex: 1;
        min-width: 150px;
    }
    .info-label {
        font-size: 11px;
        color: var(--muted);
        text-transform: uppercase;
        letter-spacing: .5px;
        margin-bottom: 5px;
    }
    .info-value {
        font-size: 14px;
        font-weight: 600;
        color: var(--text);
    }
    .table-wrap {
        overflow-x: auto;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th {
        background: var(--surface-2);
        padding: 12px;
        text-align: left;
        font-size: 11px;
        font-weight: 700;
        color: var(--muted);
        text-transform: uppercase;
    }
    td {
        padding: 10px 12px;
        border-bottom: 1px solid var(--border);
        font-size: 13px;
    }
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
    .status-lulus { color: #10b981; font-weight: 600; }
    .status-remedial { color: #ef4444; font-weight: 600; }
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: 8px;
        color: var(--text);
        text-decoration: none;
        font-size: 13px;
        margin-top: 20px;
    }
    .btn-back:hover {
        border-color: var(--accent);
        color: var(--accent);
    }
</style>
@endpush

@section('content')

<div class="detail-card">
    <div class="detail-header">
        <h2>Detail Nilai</h2>
        <p>Semester {{ $semester }} - Tahun Ajaran {{ $tahunAjaran }}</p>
    </div>
    
    <div class="detail-body">
        <div class="info-siswa">
            <div class="info-item">
                <div class="info-label">Nama Siswa</div>
                <div class="info-value">{{ $siswa->nama ?? '-' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">NIS</div>
                <div class="info-value">{{ $siswa->nis ?? '-' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Kelas</div>
                <div class="info-value">{{ $siswa->kelas->nama_kelas ?? '-' }}</div>
            </div>
        </div>
        
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Mata Pelajaran</th>
                        <th>Nilai Tugas</th>
                        <th>Nilai UTS</th>
                        <th>Nilai UAS</th>
                        <th>Nilai Akhir</th>
                        <th>Predikat</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($nilai as $index => $n)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <strong>{{ $n->mataPelajaran->nama_mapel ?? '-' }}</strong><br>
                            <small style="color: var(--muted);">{{ $n->mataPelajaran->kode_mapel ?? '-' }}</small>
                        </td>
                        <td>{{ $n->nilai_tugas ?? '-' }}</td>
                        <td>{{ $n->nilai_uts ?? '-' }}</td>
                        <td>{{ $n->nilai_uas ?? '-' }}</td>
                        <td style="font-weight: 700; color: {{ ($n->nilai_akhir ?? 0) >= 75 ? '#10b981' : '#ef4444' }}">
                            {{ $n->nilai_akhir ?? '-' }}
                        </td>
                        <td>
                            <span class="predikat predikat-{{ strtolower($n->predikat ?? 'd') }}">
                                {{ $n->predikat ?? '-' }}
                            </span>
                        </td>
                        <td>
                            @if($n->lulus)
                                <span class="status-lulus">✓ Lulus</span>
                            @else
                                <span class="status-remedial">✗ Remedial</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align: center;">Belum ada data nilai</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <a href="{{ route('siswa.dashboard') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>
</div>

@endsection