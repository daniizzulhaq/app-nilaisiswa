@extends('layouts.app')

@section('title', 'Tambah KKM')
@section('page-title', 'Tambah KKM')
@section('breadcrumb')
    <span>Admin</span> / <a href="{{ route('admin.kkm.index') }}">Data KKM</a> / Tambah KKM
@endsection

@push('styles')
<style>
    .form-container {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 28px;
        max-width: 600px;
    }
    .form-group {
        margin-bottom: 24px;
    }
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-size: 13px;
        font-weight: 700;
        color: var(--text);
        text-transform: uppercase;
        letter-spacing: .5px;
    }
    .form-group label .required {
        color: var(--danger);
        margin-left: 4px;
    }
    .form-control {
        width: 100%;
        padding: 10px 12px;
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: 8px;
        color: var(--text);
        font-size: 13.5px;
        font-family: inherit;
        transition: all .15s;
    }
    .form-control:focus {
        outline: none;
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(79,142,247,.1);
    }
    select.form-control {
        cursor: pointer;
    }
    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 28px;
        padding-top: 20px;
        border-top: 1px solid var(--border);
    }
    .btn {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 9px 16px; border-radius: 8px; font-size: 13px;
        font-weight: 600; cursor: pointer; border: none;
        text-decoration: none; transition: all .18s;
        font-family: inherit;
    }
    .btn-primary { background: var(--accent); color: #fff; box-shadow: 0 2px 10px rgba(79,142,247,.3); }
    .btn-primary:hover { background: #3a7bf5; transform: translateY(-1px); }
    .btn-secondary {
        background: var(--surface-2);
        color: var(--muted);
        border: 1px solid var(--border);
    }
    .btn-secondary:hover {
        color: var(--text);
        background: var(--surface);
    }
    .alert-danger {
        background: rgba(248,113,113,.1);
        border: 1px solid rgba(248,113,113,.3);
        border-radius: 10px;
        padding: 12px 16px;
        margin-bottom: 24px;
    }
    .alert-danger ul {
        margin: 0;
        padding-left: 20px;
        color: var(--danger);
        font-size: 13px;
    }
    .alert-success {
        background: rgba(16,185,129,.1);
        border: 1px solid rgba(16,185,129,.3);
        border-radius: 10px;
        padding: 12px 16px;
        margin-bottom: 24px;
        color: #10b981;
        font-size: 13px;
    }
    .info-text {
        font-size: 12px;
        color: var(--muted);
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .info-text i {
        font-size: 11px;
    }
    .preview-card {
        background: var(--surface-2);
        border-radius: 12px;
        padding: 16px;
        margin-top: 20px;
        border: 1px solid var(--border);
    }
    .preview-card h4 {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .8px;
        color: var(--muted);
        margin-bottom: 12px;
    }
    .preview-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 8px 0;
    }
    .preview-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: grid;
        place-items: center;
        font-size: 12px;
        font-weight: 700;
        color: #fff;
        background: linear-gradient(135deg, #4f8ef7, #7c6af7);
    }
    .preview-info {
        flex: 1;
    }
    .preview-title {
        font-weight: 600;
        color: var(--text);
        font-size: 14px;
    }
    .preview-sub {
        font-size: 11.5px;
        color: var(--muted);
        margin-top: 2px;
    }
</style>
@endpush

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h2>Tambah KKM Baru</h2>
        <p>Atur nilai Kriteria Ketuntasan Minimal untuk kombinasi mata pelajaran dan kelas</p>
    </div>
</div>

<div class="form-container">
    @if(session('success'))
    <div class="alert-success">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.kkm.store') }}" method="POST" id="kkmForm">
        @csrf

        <div class="form-group">
            <label>Mata Pelajaran <span class="required">*</span></label>
            <select name="mata_pelajaran_id" id="mata_pelajaran_id" class="form-control" required>
                <option value="">Pilih Mata Pelajaran</option>
                @foreach($mapel as $m)
                    <option value="{{ $m->id }}" 
                        data-kode="{{ $m->kode_mapel }}"
                        data-nama="{{ $m->nama_mapel }}"
                        {{ old('mata_pelajaran_id') == $m->id ? 'selected' : '' }}>
                        {{ $m->nama_mapel }} ({{ $m->kode_mapel }}) - {{ $m->sks }} SKS
                    </option>
                @endforeach
            </select>
            <div class="info-text">
                <i class="fas fa-info-circle"></i> Pilih mata pelajaran yang akan ditentukan KKM-nya
            </div>
        </div>

        <div class="form-group">
            <label>Kelas <span class="required">*</span></label>
            <select name="kelas_id" id="kelas_id" class="form-control" required>
                <option value="">Pilih Kelas</option>
                @foreach($kelas as $k)
                    <option value="{{ $k->id }}"
                        data-nama="{{ $k->nama_kelas }}"
                        data-tingkat="{{ $k->tingkat ?? '' }}"
                        {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kelas }}
                    </option>
                @endforeach
            </select>
            <div class="info-text">
                <i class="fas fa-info-circle"></i> Pilih kelas yang akan diterapkan KKM
            </div>
        </div>

        <div class="form-group">
            <label>Nilai KKM <span class="required">*</span></label>
            <input type="number" name="nilai_kkm" id="nilai_kkm" class="form-control" 
                   value="{{ old('nilai_kkm', 75) }}" 
                   min="0" max="100" step="1" required>
            <div class="info-text">
                <i class="fas fa-chart-line"></i> Range nilai: 0 - 100 | Rekomendasi: 75
            </div>
        </div>

        <!-- Preview Card -->
        <div class="preview-card" id="previewCard" style="display: none;">
            <h4>
                <i class="fas fa-eye"></i> Preview
            </h4>
            <div class="preview-item">
                <div class="preview-icon" id="previewIcon">
                    MP
                </div>
                <div class="preview-info">
                    <div class="preview-title" id="previewTitle">-</div>
                    <div class="preview-sub" id="previewSub">-</div>
                </div>
                <div style="text-align: right;">
                    <div class="preview-title" id="previewKkm">-</div>
                    <div class="preview-sub" id="previewStatus">-</div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan KKM
            </button>
            <a href="{{ route('admin.kkm.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Batal
            </a>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
    const mapelSelect = document.getElementById('mata_pelajaran_id');
    const kelasSelect = document.getElementById('kelas_id');
    const nilaiKkm = document.getElementById('nilai_kkm');
    const previewCard = document.getElementById('previewCard');
    const previewIcon = document.getElementById('previewIcon');
    const previewTitle = document.getElementById('previewTitle');
    const previewSub = document.getElementById('previewSub');
    const previewKkm = document.getElementById('previewKkm');
    const previewStatus = document.getElementById('previewStatus');

    function updatePreview() {
        const mapelOption = mapelSelect.options[mapelSelect.selectedIndex];
        const kelasOption = kelasSelect.options[kelasSelect.selectedIndex];
        const nilai = nilaiKkm.value;

        if (mapelSelect.value && kelasSelect.value) {
            previewCard.style.display = 'block';
            
            // Mapel info
            const mapelName = mapelOption.dataset.nama || mapelOption.text;
            const mapelKode = mapelOption.dataset.kode || '';
            previewIcon.textContent = (mapelKode || mapelName).substring(0, 3).toUpperCase();
            previewTitle.textContent = mapelName;
            previewSub.textContent = kelasOption.dataset.nama || kelasOption.text;
            
            // KKM info
            previewKkm.textContent = nilai;
            let statusText = '';
            let statusColor = '';
            if (nilai >= 75) {
                statusText = '● Tinggi';
                statusColor = '#10b981';
            } else if (nilai >= 60) {
                statusText = '● Sedang';
                statusColor = '#f59e0b';
            } else {
                statusText = '● Rendah';
                statusColor = '#ef4444';
            }
            previewStatus.textContent = statusText;
            previewStatus.style.color = statusColor;
        } else {
            previewCard.style.display = 'none';
        }
    }

    mapelSelect.addEventListener('change', updatePreview);
    kelasSelect.addEventListener('change', updatePreview);
    nilaiKkm.addEventListener('input', updatePreview);
    
    // Initial preview if both selected
    if (mapelSelect.value && kelasSelect.value) {
        updatePreview();
    }
</script>
@endpush