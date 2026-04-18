@extends('layouts.app')

@section('title', 'Raport Siswa')
@section('page-title', 'Raport Siswa')
@section('breadcrumb')
    <span>Laporan</span> / <a href="{{ route('laporan.rekap') }}">Rekap Nilai</a> / Raport
@endsection

@push('styles')
<style>
    .raport-container {
        max-width: 900px;
        margin: 0 auto;
    }
    .raport-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
    }
    .raport-header {
        background: linear-gradient(135deg, #4f8ef7, #7c6af7);
        padding: 30px;
        color: #fff;
        text-align: center;
    }
    .raport-header h1 {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 5px;
    }
    .raport-header p {
        font-size: 14px;
        opacity: 0.9;
    }
    .raport-body {
        padding: 30px;
    }
    .info-siswa {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--border);
    }
    .info-item {
        display: flex;
        gap: 10px;
    }
    .info-label {
        font-size: 12px;
        font-weight: 600;
        color: var(--muted);
        text-transform: uppercase;
        min-width: 100px;
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
        font-size: 12px;
        font-weight: 700;
        color: var(--muted);
        text-transform: uppercase;
    }
    td {
        padding: 10px 12px;
        border-bottom: 1px solid var(--border);
        font-size: 13px;
    }
    .btn-print {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: var(--accent);
        color: #fff;
        border-radius: 8px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        margin-top: 20px;
        border: none;
        cursor: pointer;
    }
    @media print {
        .btn-print, .breadcrumb, .page-header, .btn-secondary {
            display: none;
        }
        .raport-card {
            box-shadow: none;
            border: 1px solid #ddd;
        }
    }
</style>
@endpush

@section('content')

<div class="raport-container">
    <div class="raport-card">
        <div class="raport-header">
            <h1>LAPORAN HASIL BELAJAR</h1>
            <p>Raport Semester Ganjil / Genap</p>
        </div>

        <div class="raport-body">
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
                <div class="info-item">
                    <div class="info-label">Tahun Ajaran</div>
                    <div class="info-value">2024/2025</div>
                </div>
            </div>

            {{-- Debug sementara: hapus setelah field nilai diketahui --}}
            {{-- @if($siswa->nilai->first())
                <pre style="font-size:11px; color:red; margin-bottom:16px;">
                    {{ print_r($siswa->nilai->first()->toArray(), true) }}
                </pre>
            @endif --}}

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Mata Pelajaran</th>
                            <th>Nilai</th>
                            <th>Grade</th>
                            <th>Predikat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswa->nilai as $index => $n)
                            @php
                                $nilaiValue = $n->nilai_akhir ?? $n->nilai ?? 0;

                                if($nilaiValue >= 85)      { $grade = 'A'; $predikat = 'Sangat Baik'; }
                                elseif($nilaiValue >= 75)  { $grade = 'B'; $predikat = 'Baik'; }
                                elseif($nilaiValue >= 60)  { $grade = 'C'; $predikat = 'Cukup'; }
                                else                       { $grade = 'D'; $predikat = 'Kurang'; }
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $n->mataPelajaran->nama_mapel ?? '-' }}</td>
                                <td><strong>{{ $nilaiValue }}</strong></td>
                                <td>{{ $grade }}</td>
                                <td>{{ $predikat }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; color: var(--muted);">
                                    Belum ada nilai
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 30px; text-align: center; display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                <button onclick="window.print()" class="btn-print">
                    <i class="fas fa-print"></i> Cetak Raport
                </button>
                @if(Auth::user()->role === 'siswa')
                    <a href="{{ route('siswa.raport.export.pdf') }}" class="btn-print" style="background: #ef4444;">
                        <i class="fas fa-file-pdf"></i> Download PDF
                    </a>
                @else
                    <a href="{{ route('laporan.export.pdf', $siswa->id) }}" class="btn-print" style="background: #ef4444;">
                        <i class="fas fa-file-pdf"></i> Download PDF
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection