@extends('layouts.app')

@section('title', 'Daftar Nilai')
@section('page-title', 'Input Nilai')
@section('breadcrumb') <span>Guru</span> / Nilai @endsection

@push('styles')
<style>
    .page-toolbar {
        display: flex; align-items: center; gap: 12px;
        margin-bottom: 20px; flex-wrap: wrap;
    }
    .btn {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 9px 18px; border-radius: 8px;
        font-size: 13px; font-weight: 600;
        text-decoration: none; cursor: pointer;
        border: none; transition: all .18s;
    }
    .btn-primary { background: var(--accent); color: #fff; }
    .btn-primary:hover { background: #3b7de8; }
    .btn-danger  { background: rgba(248,113,113,.15); color: var(--danger); border: 1px solid rgba(248,113,113,.25); }
    .btn-danger:hover { background: rgba(248,113,113,.25); }
    .btn-sm { padding: 6px 12px; font-size: 12px; }

    /* Filter bar */
    .filter-bar {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 16px 20px;
        display: flex; flex-wrap: wrap; gap: 12px;
        align-items: flex-end;
        margin-bottom: 20px;
    }
    .filter-group { display: flex; flex-direction: column; gap: 5px; }
    .filter-group label { font-size: 11px; font-weight: 600; color: var(--muted); text-transform: uppercase; letter-spacing: .6px; }
    .filter-group select, .filter-group input {
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: 8px;
        color: var(--text);
        padding: 8px 12px;
        font-size: 13px;
        outline: none;
        min-width: 160px;
        font-family: inherit;
        transition: border-color .18s;
    }
    .filter-group select:focus, .filter-group input:focus { border-color: var(--accent); }
    .filter-group select option { background: var(--surface-2); }

    /* Table */
    .table-wrap {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 12px;
        overflow: hidden;
    }
    .table-header {
        padding: 14px 20px;
        border-bottom: 1px solid var(--border);
        display: flex; align-items: center; gap: 10px;
    }
    .table-header .th-title { font-size: 14px; font-weight: 700; }
    .table-header .th-count {
        font-size: 11px; color: var(--muted);
        background: var(--surface-2); padding: 2px 10px; border-radius: 20px;
    }

    table.data-table { width: 100%; border-collapse: collapse; }
    table.data-table th {
        font-size: 11px; font-weight: 700; text-transform: uppercase;
        letter-spacing: .8px; color: var(--muted);
        padding: 10px 16px; text-align: left;
        border-bottom: 1px solid var(--border);
        white-space: nowrap;
    }
    table.data-table td {
        padding: 11px 16px; font-size: 13px;
        border-bottom: 1px solid rgba(37,43,59,.5);
        vertical-align: middle;
    }
    table.data-table tr:last-child td { border-bottom: none; }
    table.data-table tr:hover td { background: var(--surface-2); }

    .badge-predikat { display:inline-block; padding:2px 10px; border-radius:20px; font-size:11px; font-weight:700; }
    .bp-A { background:rgba(52,211,153,.15); color:var(--success); }
    .bp-B { background:rgba(79,142,247,.15);  color:var(--accent); }
    .bp-C { background:rgba(251,191,36,.15);  color:var(--warning); }
    .bp-D { background:rgba(248,113,113,.15); color:var(--danger); }

    .chip-lulus    { font-size:10px; font-weight:700; padding:2px 8px; border-radius:20px; background:rgba(52,211,153,.15); color:var(--success); }
    .chip-remedial { font-size:10px; font-weight:700; padding:2px 8px; border-radius:20px; background:rgba(248,113,113,.15); color:var(--danger); }

    .mono { font-family: 'JetBrains Mono', monospace; font-size: 12px; }

    .empty-state {
        padding: 60px 20px; text-align: center; color: var(--muted);
    }
    .empty-state i { font-size: 40px; margin-bottom: 12px; opacity: .4; }
    .empty-state p { font-size: 14px; }
</style>
@endpush

@section('content')

<div class="page-toolbar">
    <a href="{{ route('guru.nilai.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Input Nilai Baru
    </a>
</div>

{{-- Filter --}}
<form method="GET" action="{{ route('guru.nilai.index') }}" class="filter-bar">
    <div class="filter-group">
        <label>Mata Pelajaran</label>
        <select name="mapel_id">
            <option value="">Semua Mapel</option>
            @foreach($mapel as $mp)
            <option value="{{ $mp->id }}" {{ request('mapel_id') == $mp->id ? 'selected' : '' }}>
                {{ $mp->nama_mapel }}
            </option>
            @endforeach
        </select>
    </div>
    <div class="filter-group">
        <label>Semester</label>
        <select name="semester">
            <option value="">Semua</option>
            <option value="1" {{ request('semester')=='1'?'selected':'' }}>Semester 1</option>
            <option value="2" {{ request('semester')=='2'?'selected':'' }}>Semester 2</option>
        </select>
    </div>
    <div class="filter-group">
        <label>Tahun Ajaran</label>
        <input type="text" name="tahun_ajaran" value="{{ request('tahun_ajaran') }}" placeholder="cth: 2024/2025">
    </div>
    <div class="filter-group">
        <label>Cari Siswa</label>
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Nama / NIS...">
    </div>
    <button type="submit" class="btn btn-primary btn-sm">
        <i class="fas fa-filter"></i> Filter
    </button>
    <a href="{{ route('guru.nilai.index') }}" class="btn btn-sm" style="background:var(--surface-2);border:1px solid var(--border);color:var(--text)">
        <i class="fas fa-rotate"></i> Reset
    </a>
</form>

{{-- Table --}}
<div class="table-wrap">
    <div class="table-header">
        <i class="fas fa-list-check" style="color:var(--accent)"></i>
        <span class="th-title">Daftar Nilai</span>
        <span class="th-count">{{ $nilais->total() }} data</span>
    </div>

    @if($nilais->isEmpty())
    <div class="empty-state">
        <i class="fas fa-inbox"></i>
        <p>Belum ada data nilai yang diinput.</p>
    </div>
    @else
    <div style="overflow-x:auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Siswa</th>
                    <th>Mata Pelajaran</th>
                    <th>Kelas</th>
                    <th>Semester</th>
                    <th>Tugas</th>
                    <th>UTS</th>
                    <th>UAS</th>
                    <th>Sikap</th>
                    <th>Akhir</th>
                    <th>Predikat</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($nilais as $i => $n)
                <tr>
                    <td class="mono" style="color:var(--muted)">{{ $nilais->firstItem() + $i }}</td>
                    <td>
                        <div style="font-weight:600">{{ $n->siswa->nama ?? '-' }}</div>
                        <div style="font-size:11px;color:var(--muted)">{{ $n->siswa->nis ?? '' }}</div>
                    </td>
                    <td style="color:var(--muted)">{{ $n->mataPelajaran->nama_mapel ?? '-' }}</td>
                    <td>{{ $n->kelas->nama_kelas ?? '-' }}</td>
                    <td class="mono">{{ $n->semester }} / {{ $n->tahun_ajaran }}</td>
                    <td class="mono">{{ $n->nilai_tugas ?? '-' }}</td>
                    <td class="mono">{{ $n->nilai_uts ?? '-' }}</td>
                    <td class="mono">{{ $n->nilai_uas ?? '-' }}</td>
                    <td class="mono">{{ $n->nilai_sikap ?? '-' }}</td>
                    <td>
                        <span class="mono" style="font-weight:700;color:{{ ($n->nilai_akhir??0)>=75?'var(--success)':'var(--warning)' }}">
                            {{ $n->nilai_akhir ?? '-' }}
                        </span>
                    </td>
                    <td>
                        <span class="badge-predikat bp-{{ $n->predikat ?? 'D' }}">{{ $n->predikat ?? '-' }}</span>
                    </td>
                    <td>
                        <span class="{{ $n->lulus ? 'chip-lulus' : 'chip-remedial' }}">
                            {{ $n->lulus ? 'Lulus' : 'Remedial' }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex;gap:6px">
                            <a href="{{ route('guru.nilai.edit', $n->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-pen"></i>
                            </a>
                            <form method="POST" action="{{ route('guru.nilai.destroy', $n->id) }}"
                                  onsubmit="return confirm('Hapus nilai ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="padding:14px 20px;border-top:1px solid var(--border)">
        {{ $nilais->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection