@extends('layouts.app')

@section('title', 'Edit KKM')
@section('page-title', 'Edit KKM')
@section('breadcrumb')
    <span>Admin</span> / <a href="{{ route('admin.kkm.index') }}">Data KKM</a> / Edit KKM
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
    .form-control[disabled] {
        opacity: 0.6;
        cursor: not-allowed;
        background: var(--surface);
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
    .readonly-card {
        background: var(--surface-2);
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 20px;
        border: 1px solid var(--border);
    }
    .readonly-card h4 {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .8px;
        color: var(--muted);
        margin-bottom: 12px;
    }
    .readonly-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 8px 0;
    }
    .readonly-icon {
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
    .readonly-info {
        flex: 1;
    }
    .readonly-title {
        font-weight: 600;
        color: var(--text);
        font-size: 14px;
    }
    .readonly-sub {
        font-size: 11.5px;
        color: var(--muted);
        margin-top: 2px;
    }
    .badge-kkm-current {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 700;
        background: rgba(79,142,247,.12);
        color: #4f8ef7;
    }
    .warning-box {
        background: rgba(245,158,11,.08);
        border-left: 3px solid #f59e0b;
        border-radius: 8px;
        padding: 12px 16px;
        margin-bottom: 20px;
        font-size: 12.5px;
        color: var(--muted);
    }
    .warning-box i {
        color: #f59e0b;
        margin-right: 8px;
    }
</style>
@endpush

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h2>Edit KKM</h2>
        <p>Ubah nilai Kriteria Ketuntasan Minimal</p>
    </div>
</div>

<div class="form-container">
    @if($errors->any())
    <div class="alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="warning-box">
        <i class="fas fa-info-circle"></i>
        Mata Pelajaran dan Kelas tidak dapat diubah. Jika perlu mengganti kombinasi, silakan hapus data ini dan buat baru.
    </div>

    <!-- Readonly Info Card -->
    <div class="readonly-card">
        <h4>
            <i class="fas fa-lock"></i> Data Tetap
        </h4>
        <div class="readonly-item">
            <div class="readonly-icon">
                {{ strtoupper(substr($kkm->mataPelajaran->kode_mapel ?? 'MP', 0, 3)) }}
            </div>
            <div class="readonly-info">
                <div class="readonly-title">Mata Pelajaran</div>
                <div class="readonly-sub">
                    {{ $kkm->mataPelajaran->nama_mapel ?? '-' }} 
                    ({{ $kkm->mataPelajaran->kode_mapel ?? '-' }})
                </div>
            </div>
        </div>
        <div class="readonly-item">
            <div class="readonly-icon" style="background: linear-gradient(135deg, #f59e0b, #f97316);">
                {{ strtoupper(substr($kkm->kelas->nama_kelas ?? 'KL', 0, 2)) }}
            </div>
            <div class="readonly-info">
                <div class="readonly-title">Kelas</div>
                <div class="readonly-sub">
                    {{ $kkm->kelas->nama_kelas ?? '-' }}
                    @if($kkm->kelas->tingkat ?? false)
                        ({{ $kkm->kelas->tingkat }})
                    @endif
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.kkm.update', $kkm) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Hidden fields for readonly data -->
        <input type="hidden" name="mata_pelajaran_id" value="{{ $kkm->mata_pelajaran_id }}">
        <input type="hidden" name="kelas_id" value="{{ $kkm->kelas_id }}">

        <div class="form-group">
            <label>Nilai KKM Saat Ini</label>
            <div>
                <span class="badge-kkm-current">
                    {{ $kkm->nilai_kkm }}
                </span>
            </div>
        </div>

        <div class="form-group">
            <label>Nilai KKM Baru <span class="required">*</span></label>
            <input type="number" name="nilai_kkm" class="form-control" 
                   value="{{ old('nilai_kkm', $kkm->nilai_kkm) }}" 
                   min="0" max="100" step="1" required>
            <div class="info-text">
                <i class="fas fa-chart-line"></i> Range nilai: 0 - 100 | Rekomendasi: 75
            </div>
        </div>

        <!-- Live Preview -->
        <div class="readonly-card" id="previewCard">
            <h4>
                <i class="fas fa-eye"></i> Preview Perubahan
            </h4>
            <div class="readonly-item">
                <div class="readonly-icon" id="previewIcon">
                    {{ strtoupper(substr($kkm->mataPelajaran->kode_mapel ?? 'MP', 0, 3)) }}
                </div>
                <div class="readonly-info">
                    <div class="readonly-title" id="previewTitle">
                        {{ $kkm->mataPelajaran->nama_mapel ?? '-' }}
                    </div>
                    <div class="readonly-sub" id="previewSub">
                        {{ $kkm->kelas->nama_kelas ?? '-' }}
                    </div>
                </div>
                <div style="text-align: right;">
                    <div class="readonly-title" id="previewKkm">{{ $kkm->nilai_kkm }}</div>
                    <div class="readonly-sub" id="previewStatus">-</div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update KKM
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
    const nilaiInput = document.querySelector('input[name="nilai_kkm"]');
    const previewKkm = document.getElementById('previewKkm');
    const previewStatus = document.getElementById('previewStatus');
    const oldValue = {{ $kkm->nilai_kkm }};

    function updatePreview() {
        const newValue = nilaiInput.value;
        previewKkm.textContent = newValue;
        
        // Add indicator if value changed
        if (parseInt(newValue) !== oldValue) {
            previewKkm.style.color = '#f59e0b';
            previewKkm.style.fontWeight = 'bold';
        } else {
            previewKkm.style.color = '';
            previewKkm.style.fontWeight = '';
        }
        
        // Status
        let statusText = '';
        let statusColor = '';
        if (newValue >= 75) {
            statusText = '● Tinggi (Meningkat)';
            statusColor = '#10b981';
        } else if (newValue >= 60) {
            statusText = '● Sedang';
            statusColor = '#f59e0b';
        } else {
            statusText = '● Rendah (Perlu Perhatian)';
            statusColor = '#ef4444';
        }
        
        // Compare with old value
        if (parseInt(newValue) > oldValue) {
            statusText = '▲ ' + statusText;
        } else if (parseInt(newValue) < oldValue) {
            statusText = '▼ ' + statusText;
        }
        
        previewStatus.textContent = statusText;
        previewStatus.style.color = statusColor;
    }
    
    nilaiInput.addEventListener('input', updatePreview);
    updatePreview();
</script>
@endpush