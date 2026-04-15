@extends('layouts.app')

@section('title', 'Edit Nilai')
@section('page-title', 'Edit Nilai')
@section('breadcrumb') 
    <span>Guru</span> / <span>Nilai</span> / Edit Nilai 
@endsection

@push('styles')
<style>
    .form-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
        max-width: 820px;
    }
    .form-header {
        padding: 20px 24px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 12px;
        background: linear-gradient(135deg, rgba(79,142,247,.05), rgba(124,106,247,.05));
    }
    .form-header i { font-size: 18px; color: var(--accent); }
    .form-header .fh-title { font-size: 15px; font-weight: 700; }
    .form-header .fh-sub { font-size: 12px; color: var(--muted); margin-top: 2px; }
    
    .form-body { padding: 24px; }

    .info-card {
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 16px 20px;
        margin-bottom: 24px;
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
    }
    .info-item {
        flex: 1;
        min-width: 150px;
    }
    .info-label {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .6px;
        color: var(--muted);
        margin-bottom: 6px;
    }
    .info-value {
        font-size: 14px;
        font-weight: 600;
        color: var(--text);
    }
    .info-value small {
        font-weight: normal;
        font-size: 11px;
        color: var(--muted);
    }

    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
    .form-grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 18px; }
    @media(max-width:640px) {
        .form-grid, .form-grid-4 { grid-template-columns: 1fr; }
    }

    .form-group { display: flex; flex-direction: column; gap: 6px; }
    .form-group label {
        font-size: 12px; font-weight: 600; color: var(--muted);
        text-transform: uppercase; letter-spacing: .6px;
    }
    .form-group .required { color: var(--danger); }
    .form-control {
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: 8px;
        color: var(--text);
        padding: 10px 14px;
        font-size: 13.5px;
        outline: none;
        width: 100%;
        font-family: inherit;
        transition: border-color .18s, box-shadow .18s;
    }
    .form-control:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(79,142,247,.12);
    }
    .form-control[readonly] {
        background: rgba(37,43,59,.3);
        cursor: default;
        opacity: 0.8;
    }

    .section-divider {
        height: 1px; background: var(--border);
        margin: 22px 0; position: relative;
    }
    .section-divider span {
        position: absolute; top: -9px; left: 0;
        background: var(--surface);
        padding-right: 12px;
        font-size: 11px; font-weight: 700; color: var(--muted);
        text-transform: uppercase; letter-spacing: .8px;
    }

    .form-footer {
        padding: 16px 24px;
        border-top: 1px solid var(--border);
        display: flex; gap: 10px; align-items: center;
        background: var(--surface-2);
    }
    .btn { 
        display: inline-flex; align-items: center; gap: 8px; 
        padding: 10px 20px; border-radius: 8px; font-size: 13px; 
        font-weight: 600; text-decoration: none; cursor: pointer; 
        border: none; transition: all .18s; 
    }
    .btn-primary { background: var(--accent); color: #fff; }
    .btn-primary:hover { background: #3b7de8; transform: translateY(-1px); }
    .btn-secondary { background: var(--surface-2); color: var(--text); border: 1px solid var(--border); }
    .btn-secondary:hover { border-color: var(--accent); color: var(--accent); }

    .nilai-preview {
        background: linear-gradient(135deg, rgba(79,142,247,.08), rgba(124,106,247,.08));
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 16px 20px;
        margin-top: 20px;
        display: flex;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
    }
    .np-item { text-align: center; }
    .np-label { font-size: 10px; color: var(--muted); text-transform: uppercase; letter-spacing: .6px; margin-bottom: 4px; }
    .np-value { font-size: 22px; font-weight: 800; font-family: 'JetBrains Mono', monospace; }

    .error-text { font-size: 11.5px; color: var(--danger); margin-top: 3px; }
    
    .warning-box {
        background: rgba(245,158,11,.1);
        border-left: 3px solid #f59e0b;
        border-radius: 8px;
        padding: 12px 16px;
        margin-bottom: 20px;
        font-size: 12px;
        color: var(--muted);
    }
    .warning-box i {
        color: #f59e0b;
        margin-right: 8px;
    }
    
    .current-value {
        font-size: 13px;
        color: var(--muted);
        margin-top: 4px;
    }
    .current-value span {
        color: var(--text);
        font-weight: 600;
    }
</style>
@endpush

@section('content')

<div class="form-card">
    <div class="form-header">
        <i class="fas fa-pen-to-square"></i>
        <div>
            <div class="fh-title">Edit Nilai Siswa</div>
            <div class="fh-sub">Ubah komponen nilai yang akan diperbarui</div>
        </div>
    </div>

    <form method="POST" action="{{ route('guru.nilai.update', $nilai->id) }}" id="nilaiForm">
        @csrf
        @method('PUT')
        <div class="form-body">

            {{-- Info Data Siswa (Readonly) --}}
            <div class="info-card">
                <div class="info-item">
                    <div class="info-label"><i class="fas fa-user"></i> Nama Siswa</div>
                    <div class="info-value">{{ $nilai->siswa->nama ?? '-' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label"><i class="fas fa-id-card"></i> NIS</div>
                    <div class="info-value">{{ $nilai->siswa->nis ?? '-' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label"><i class="fas fa-building"></i> Kelas</div>
                    <div class="info-value">{{ $nilai->kelas->nama_kelas ?? '-' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label"><i class="fas fa-book"></i> Mata Pelajaran</div>
                    <div class="info-value">{{ $nilai->mataPelajaran->nama_mapel ?? '-' }}</div>
                </div>
            </div>

            {{-- Periode (Readonly) --}}
            <div class="section-divider"><span>Periode (Tidak Dapat Diubah)</span></div>
            <div class="form-grid" style="margin-bottom:18px">
                <div class="form-group">
                    <label>Semester</label>
                    <input type="text" class="form-control" readonly 
                           value="Semester {{ $nilai->semester }} ({{ $nilai->semester == 1 ? 'Ganjil' : 'Genap' }})">
                </div>
                <div class="form-group">
                    <label>Tahun Ajaran</label>
                    <input type="text" class="form-control" readonly value="{{ $nilai->tahun_ajaran }}">
                </div>
            </div>

            {{-- Input nilai --}}
            <div class="section-divider"><span>Komponen Nilai</span></div>
            
            <div class="warning-box">
                <i class="fas fa-info-circle"></i>
                Kosongkan nilai jika tidak ingin mengubahnya. Nilai yang tidak diisi akan tetap menggunakan nilai sebelumnya.
            </div>
            
            <div class="form-grid-4">
                <div class="form-group">
                    <label>Nilai Tugas</label>
                    <input type="number" name="nilai_tugas" id="nTugas" class="form-control"
                           value="{{ old('nilai_tugas', $nilai->nilai_tugas) }}" 
                           min="0" max="100" step="0.1" placeholder="0–100">
                    <div class="current-value">
                        Nilai saat ini: <span>{{ $nilai->nilai_tugas ?? '-' }}</span>
                    </div>
                    @error('nilai_tugas')<div class="error-text">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Nilai UTS</label>
                    <input type="number" name="nilai_uts" id="nUts" class="form-control"
                           value="{{ old('nilai_uts', $nilai->nilai_uts) }}" 
                           min="0" max="100" step="0.1" placeholder="0–100">
                    <div class="current-value">
                        Nilai saat ini: <span>{{ $nilai->nilai_uts ?? '-' }}</span>
                    </div>
                    @error('nilai_uts')<div class="error-text">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Nilai UAS</label>
                    <input type="number" name="nilai_uas" id="nUas" class="form-control"
                           value="{{ old('nilai_uas', $nilai->nilai_uas) }}" 
                           min="0" max="100" step="0.1" placeholder="0–100">
                    <div class="current-value">
                        Nilai saat ini: <span>{{ $nilai->nilai_uas ?? '-' }}</span>
                    </div>
                    @error('nilai_uas')<div class="error-text">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Nilai Sikap</label>
                    <input type="number" name="nilai_sikap" id="nSikap" class="form-control"
                           value="{{ old('nilai_sikap', $nilai->nilai_sikap) }}" 
                           min="0" max="100" step="0.1" placeholder="0–100">
                    <div class="current-value">
                        Nilai saat ini: <span>{{ $nilai->nilai_sikap ?? '-' }}</span>
                    </div>
                    @error('nilai_sikap')<div class="error-text">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Preview kalkulasi --}}
            <div class="nilai-preview">
                <div class="np-item">
                    <div class="np-label">Nilai Akhir (Baru)</div>
                    <div class="np-value" id="previewAkhir" style="color:var(--accent)">—</div>
                </div>
                <div class="np-item">
                    <div class="np-label">Predikat (Baru)</div>
                    <div class="np-value" id="previewPredikat" style="color:var(--warning)">—</div>
                </div>
                <div class="np-item">
                    <div class="np-label">Nilai Akhir (Saat Ini)</div>
                    <div class="np-value" style="font-size: 18px; color: var(--muted);">
                        {{ $nilai->nilai_akhir ?? '-' }}
                    </div>
                </div>
                <div style="margin-left:auto;font-size:12px;color:var(--muted)">
                    <i class="fas fa-circle-info"></i>
                    Formula: 20% Tugas + 30% UTS + 40% UAS + 10% Sikap
                </div>
            </div>

        </div>

        <div class="form-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Nilai
            </button>
            <a href="{{ route('guru.nilai.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Batal
            </a>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
// Preview nilai akhir
function hitungPreview() {
    const tugas = parseFloat(document.getElementById('nTugas').value) || 0;
    const uts   = parseFloat(document.getElementById('nUts').value)   || 0;
    const uas   = parseFloat(document.getElementById('nUas').value)   || 0;
    const sikap = parseFloat(document.getElementById('nSikap').value) || 0;

    const akhir = (tugas * 0.2) + (uts * 0.3) + (uas * 0.4) + (sikap * 0.1);
    const rounded = Math.round(akhir * 10) / 10;

    const previewAkhir = document.getElementById('previewAkhir');
    previewAkhir.textContent = rounded || '—';
    
    // Warna berdasarkan nilai
    if (rounded >= 85) {
        previewAkhir.style.color = '#10b981';
    } else if (rounded >= 75) {
        previewAkhir.style.color = '#4f8ef7';
    } else if (rounded >= 60) {
        previewAkhir.style.color = '#f59e0b';
    } else if (rounded > 0) {
        previewAkhir.style.color = '#ef4444';
    } else {
        previewAkhir.style.color = 'var(--accent)';
    }

    let predikat = '—', color = 'var(--muted)';
    if (akhir >= 85)     { predikat = 'A'; color = '#10b981'; }
    else if (akhir >= 75){ predikat = 'B'; color = '#4f8ef7'; }
    else if (akhir >= 60){ predikat = 'C'; color = '#f59e0b'; }
    else if (akhir > 0)  { predikat = 'D'; color = '#ef4444'; }

    const el = document.getElementById('previewPredikat');
    el.textContent = predikat;
    el.style.color = color;
}

// Event listeners untuk semua input nilai
['nTugas','nUts','nUas','nSikap'].forEach(id => {
    const element = document.getElementById(id);
    if (element) {
        element.addEventListener('input', hitungPreview);
    }
});

// Hitung preview awal
hitungPreview();
</script>
@endpush