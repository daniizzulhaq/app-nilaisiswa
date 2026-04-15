@extends('layouts.app')

@section('title', 'Input Nilai')
@section('page-title', 'Input Nilai')
@section('breadcrumb') <span>Guru</span> / <span>Nilai</span> / Input Baru @endsection

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
        display: flex; align-items: center; gap: 12px;
    }
    .form-header i { font-size: 18px; color: var(--accent); }
    .form-header .fh-title { font-size: 15px; font-weight: 700; }
    .form-body { padding: 24px; }

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
    .form-control option { background: var(--surface-2); }
    .form-control::placeholder { color: var(--muted); }

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
    }
    .btn { display:inline-flex; align-items:center; gap:8px; padding:10px 20px; border-radius:8px; font-size:13px; font-weight:600; text-decoration:none; cursor:pointer; border:none; transition:all .18s; }
    .btn-primary { background:var(--accent); color:#fff; }
    .btn-primary:hover { background:#3b7de8; }
    .btn-secondary { background:var(--surface-2); color:var(--text); border:1px solid var(--border); }
    .btn-secondary:hover { border-color:var(--accent); color:var(--accent); }

    /* Preview nilai akhir */
    .nilai-preview {
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 16px 20px;
        margin-top: 20px;
        display: flex; align-items: center; gap: 20px;
        flex-wrap: wrap;
    }
    .np-item { text-align: center; }
    .np-label { font-size: 10px; color: var(--muted); text-transform: uppercase; letter-spacing: .6px; margin-bottom: 4px; }
    .np-value { font-size: 22px; font-weight: 800; font-family: 'JetBrains Mono', monospace; }

    .error-text { font-size: 11.5px; color: var(--danger); margin-top: 3px; }
</style>
@endpush

@section('content')

<div class="form-card">
    <div class="form-header">
        <i class="fas fa-pen-to-square"></i>
        <div>
            <div class="fh-title">Input Nilai Siswa</div>
        </div>
    </div>

    <form method="POST" action="{{ route('guru.nilai.store') }}" id="nilaiForm">
        @csrf
        <div class="form-body">

            {{-- Pilihan kelas & siswa --}}
            <div class="section-divider"><span>Data Siswa</span></div>
            <div class="form-grid" style="margin-bottom:18px">
                <div class="form-group">
                    <label>Kelas <span class="required">*</span></label>
                    <select name="kelas_id" id="kelasSelect" class="form-control" required>
                        <option value="">— Pilih Kelas —</option>
                        @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ old('kelas_id')==$k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                        @endforeach
                    </select>
                    @error('kelas_id')<div class="error-text">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Siswa <span class="required">*</span></label>
                    <select name="siswa_id" id="siswaSelect" class="form-control" required>
                        <option value="">— Pilih Siswa —</option>
                        @foreach($siswa as $s)
                        <option value="{{ $s->id }}" {{ old('siswa_id')==$s->id ? 'selected' : '' }}>
                            {{ $s->nama }} ({{ $s->nis }})
                        </option>
                        @endforeach
                    </select>
                    @error('siswa_id')<div class="error-text">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Mapel & periode --}}
            <div class="section-divider"><span>Mata Pelajaran & Periode</span></div>
            <div class="form-grid" style="margin-bottom:18px">
                <div class="form-group">
                    <label>Mata Pelajaran <span class="required">*</span></label>
                    <select name="mata_pelajaran_id" class="form-control" required>
                        <option value="">— Pilih Mapel —</option>
                        @foreach($mapel as $mp)
                        <option value="{{ $mp->id }}" {{ old('mata_pelajaran_id')==$mp->id ? 'selected' : '' }}>
                            {{ $mp->nama_mapel }}
                        </option>
                        @endforeach
                    </select>
                    @error('mata_pelajaran_id')<div class="error-text">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Semester <span class="required">*</span></label>
                    <select name="semester" class="form-control" required>
                        <option value="">— Pilih —</option>
                        <option value="1" {{ old('semester')=='1'?'selected':'' }}>Semester 1 (Ganjil)</option>
                        <option value="2" {{ old('semester')=='2'?'selected':'' }}>Semester 2 (Genap)</option>
                    </select>
                    @error('semester')<div class="error-text">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Tahun Ajaran <span class="required">*</span></label>
                    <input type="text" name="tahun_ajaran" class="form-control"
                           value="{{ old('tahun_ajaran', date('Y') . '/' . (date('Y')+1)) }}"
                           placeholder="cth: 2024/2025" required>
                    @error('tahun_ajaran')<div class="error-text">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Input nilai --}}
            <div class="section-divider"><span>Komponen Nilai</span></div>
            <div class="form-grid-4">
                <div class="form-group">
                    <label>Nilai Tugas</label>
                    <input type="number" name="nilai_tugas" id="nTugas" class="form-control"
                           value="{{ old('nilai_tugas') }}" min="0" max="100" step="0.1" placeholder="0–100">
                    @error('nilai_tugas')<div class="error-text">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Nilai UTS</label>
                    <input type="number" name="nilai_uts" id="nUts" class="form-control"
                           value="{{ old('nilai_uts') }}" min="0" max="100" step="0.1" placeholder="0–100">
                    @error('nilai_uts')<div class="error-text">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Nilai UAS</label>
                    <input type="number" name="nilai_uas" id="nUas" class="form-control"
                           value="{{ old('nilai_uas') }}" min="0" max="100" step="0.1" placeholder="0–100">
                    @error('nilai_uas')<div class="error-text">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Nilai Sikap</label>
                    <input type="number" name="nilai_sikap" id="nSikap" class="form-control"
                           value="{{ old('nilai_sikap') }}" min="0" max="100" step="0.1" placeholder="0–100">
                    @error('nilai_sikap')<div class="error-text">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Preview kalkulasi --}}
            <div class="nilai-preview">
                <div class="np-item">
                    <div class="np-label">Nilai Akhir (Est.)</div>
                    <div class="np-value" id="previewAkhir" style="color:var(--accent)">—</div>
                </div>
                <div class="np-item">
                    <div class="np-label">Predikat</div>
                    <div class="np-value" id="previewPredikat" style="color:var(--warning)">—</div>
                </div>
                <div style="margin-left:auto;font-size:12px;color:var(--muted)">
                    <i class="fas fa-circle-info"></i>
                    Formula: 20% Tugas + 30% UTS + 40% UAS + 10% Sikap
                </div>
            </div>

        </div>

        <div class="form-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-floppy-disk"></i> Simpan Nilai
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
// AJAX load siswa by kelas
document.getElementById('kelasSelect').addEventListener('change', function () {
    const kelasId = this.value;
    const siswaSelect = document.getElementById('siswaSelect');
    siswaSelect.innerHTML = '<option value="">— Memuat... —</option>';

    if (!kelasId) {
        siswaSelect.innerHTML = '<option value="">— Pilih Siswa —</option>';
        return;
    }

    fetch(`{{ route('guru.siswa.by.kelas') }}?kelas_id=${kelasId}`)
        .then(r => r.json())
        .then(data => {
            siswaSelect.innerHTML = '<option value="">— Pilih Siswa —</option>';
            data.forEach(s => {
                const opt = document.createElement('option');
                opt.value = s.id;
                opt.textContent = `${s.nama} (${s.nis})`;
                siswaSelect.appendChild(opt);
            });
        })
        .catch(() => {
            siswaSelect.innerHTML = '<option value="">— Gagal memuat —</option>';
        });
});

// Preview nilai akhir
function hitungPreview() {
    const tugas = parseFloat(document.getElementById('nTugas').value) || 0;
    const uts   = parseFloat(document.getElementById('nUts').value)   || 0;
    const uas   = parseFloat(document.getElementById('nUas').value)   || 0;
    const sikap = parseFloat(document.getElementById('nSikap').value) || 0;

    const akhir = (tugas * 0.2) + (uts * 0.3) + (uas * 0.4) + (sikap * 0.1);
    const rounded = Math.round(akhir * 10) / 10;

    document.getElementById('previewAkhir').textContent = rounded || '—';

    let predikat = '—', color = 'var(--muted)';
    if (akhir >= 90)     { predikat = 'A'; color = 'var(--success)'; }
    else if (akhir >= 80){ predikat = 'B'; color = 'var(--accent)'; }
    else if (akhir >= 70){ predikat = 'C'; color = 'var(--warning)'; }
    else if (akhir > 0)  { predikat = 'D'; color = 'var(--danger)'; }

    const el = document.getElementById('previewPredikat');
    el.textContent = predikat;
    el.style.color = color;
}

['nTugas','nUts','nUas','nSikap'].forEach(id => {
    document.getElementById(id).addEventListener('input', hitungPreview);
});
</script>
@endpush