@extends('layouts.app')

@section('title', 'Rekap Nilai per Kelas')
@section('page-title', 'Rekap Nilai per Kelas')
@section('breadcrumb')
    <span>Laporan</span> / Rekap Nilai
@endsection

@push('styles')
<style>
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        gap: 12px;
        flex-wrap: wrap;
    }
    .page-header-left h2 { font-size: 20px; font-weight: 800; color: var(--text); }
    .page-header-left p  { font-size: 13px; color: var(--muted); margin-top: 2px; }

    .btn {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 9px 16px; border-radius: 8px; font-size: 13px;
        font-weight: 600; cursor: pointer; border: none;
        text-decoration: none; transition: all .18s;
        font-family: inherit;
    }
    .btn-primary { background: var(--accent); color: #fff; box-shadow: 0 2px 10px rgba(79,142,247,.3); }
    .btn-primary:hover { background: #3a7bf5; transform: translateY(-1px); }
    .btn-success { background: #10b981; color: #fff; }
    .btn-success:hover { background: #059669; }
    .btn-secondary { background: var(--surface-2); color: var(--muted); border: 1px solid var(--border); }
    .btn-secondary:hover { color: var(--text); }

    .filter-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 18px 22px;
        margin-bottom: 20px;
    }
    .filter-form {
        display: flex;
        gap: 12px;
        align-items: flex-end;
        flex-wrap: wrap;
    }
    .filter-group {
        flex: 1;
        min-width: 200px;
    }
    .filter-group label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: var(--muted);
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: .5px;
    }
    .filter-group select, .filter-group input {
        width: 100%;
        padding: 9px 12px;
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: 8px;
        color: var(--text);
        font-size: 13px;
        font-family: inherit;
    }
    .filter-group select:focus, .filter-group input:focus {
        outline: none;
        border-color: var(--accent);
    }

    .table-wrap {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
        overflow-x: auto;
    }
    table { width: 100%; border-collapse: collapse; min-width: 600px; }
    thead tr { background: var(--surface-2); border-bottom: 1px solid var(--border); }
    th {
        padding: 12px 16px; text-align: left;
        font-size: 11px; font-weight: 700;
        text-transform: uppercase; letter-spacing: .8px;
        color: var(--muted);
    }
    tbody tr { border-bottom: 1px solid var(--border); transition: background .15s; }
    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: var(--surface-2); }
    td { padding: 12px 16px; font-size: 13px; vertical-align: middle; }

    .badge-nilai {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    .badge-nilai-a { background: rgba(16,185,129,.12); color: #10b981; }
    .badge-nilai-b { background: rgba(79,142,247,.12); color: #4f8ef7; }
    .badge-nilai-c { background: rgba(245,158,11,.12); color: #f59e0b; }
    .badge-nilai-d { background: rgba(248,113,113,.12); color: #ef4444; }

    .empty-state { text-align: center; padding: 60px 20px; color: var(--muted); }
    .empty-state i { font-size: 40px; margin-bottom: 12px; display: block; opacity: .3; }
</style>
@endpush

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h2>Rekap Nilai per Kelas</h2>
        <p>Lihat ringkasan nilai siswa berdasarkan kelas</p>
    </div>
    @if(request('kelas_id'))
    <div>
        <a href="{{ route('laporan.rekap.export', ['kelas_id' => request('kelas_id')]) }}" class="btn btn-success">
            <i class="fas fa-file-excel"></i> Export Excel
        </a>
    </div>
    @endif
</div>

<div class="filter-card">
    <form method="GET" action="{{ route('laporan.rekap') }}" class="filter-form">
        <div class="filter-group">
            <label><i class="fas fa-building"></i> Pilih Kelas</label>
            <select name="kelas_id" onchange="this.form.submit()">
                <option value="">-- Semua Kelas --</option>
                @foreach($kelas as $k)
                    <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kelas }}
                    </option>
                @endforeach
            </select>
        </div>
        @if(request('kelas_id'))
            <a href="{{ route('laporan.rekap') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Reset
            </a>
        @endif
    </form>
</div>

<div class="table-wrap">
    @if($nilai->count() > 0)
         <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>Nama Siswa</th>
                    <th>Mata Pelajaran</th>
                    <th>Nilai</th>
                    <th>Grade</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($nilai as $index => $n)
<tr>
    <td>{{ $index + 1 }}</td>
    <td>{{ $n->siswa->nis ?? '-' }}</td>
    <td><strong>{{ $n->siswa->nama ?? '-' }}</strong></td>  {{-- Ubah dari nama_siswa ke nama --}}
    <td>{{ $n->mataPelajaran->nama_mapel ?? '-' }}</td>
    <td>{{ $n->nilai_akhir ?? $n->nilai ?? '-' }}</td>  {{-- Sesuaikan dengan field nilai --}}
    <td>
        @php
            $nilaiValue = $n->nilai_akhir ?? $n->nilai ?? 0;
            $grade = '';
            if($nilaiValue >= 85) $grade = 'A';
            elseif($nilaiValue >= 75) $grade = 'B';
            elseif($nilaiValue >= 60) $grade = 'C';
            else $grade = 'D';
        @endphp
        <span class="badge-nilai badge-nilai-{{ strtolower($grade) }}">
            {{ $grade }}
        </span>
    </td>
    <td>
        @if($nilaiValue >= 75)
            <span style="color: #10b981;">✓ Lulus</span>
        @else
            <span style="color: #ef4444;">✗ Tidak Lulus</span>
        @endif
    </td>
</tr>
@endforeach
            </tbody>
        </table>
    @else
        <div class="empty-state">
            <i class="fas fa-chart-bar"></i>
            <p>Belum ada data nilai.</p>
            @if(!request('kelas_id'))
                <p style="font-size: 12px; margin-top: 8px;">Silakan pilih kelas terlebih dahulu</p>
            @else
                <p style="font-size: 12px; margin-top: 8px;">Tidak ada data nilai untuk kelas ini</p>
            @endif
        </div>
    @endif
</div>

@endsection