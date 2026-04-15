@extends('layouts.app')

@section('title', 'Edit Mata Pelajaran')
@section('page-title', 'Edit Mata Pelajaran')
@section('breadcrumb')
    <span>Admin</span> / <a href="{{ route('admin.mapel.index') }}">Data Mata Pelajaran</a> / Edit
@endsection

@push('styles')
<style>
    .form-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        gap: 12px;
        flex-wrap: wrap;
    }
    .form-header-left h2 { font-size: 20px; font-weight: 800; color: var(--text); }
    .form-header-left p  { font-size: 13px; color: var(--muted); margin-top: 2px; }

    .btn {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 9px 16px; border-radius: 8px; font-size: 13px;
        font-weight: 600; cursor: pointer; border: none;
        text-decoration: none; transition: all .18s;
        font-family: inherit;
    }
    .btn-primary { background: var(--accent); color: #fff; box-shadow: 0 2px 10px rgba(79,142,247,.3); }
    .btn-primary:hover { background: #3a7bf5; transform: translateY(-1px); }
    .btn-cancel { background: var(--surface-2); color: var(--muted); border: 1px solid var(--border); }
    .btn-cancel:hover { color: var(--text); }
    .btn-danger-outline {
        background: rgba(248,113,113,.10);
        color: var(--danger);
        border: 1px solid rgba(248,113,113,.25);
    }
    .btn-danger-outline:hover { background: rgba(248,113,113,.2); }

    .form-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
        max-width: 680px;
    }
    .form-card-header {
        padding: 18px 24px;
        border-bottom: 1px solid var(--border);
        background: var(--surface-2);
        display: flex; align-items: center; gap: 10px;
    }
    .form-card-header .icon {
        width: 36px; height: 36px; border-radius: 9px;
        background: linear-gradient(135deg, #f59e0b, #f97316);
        display: grid; place-items: center;
        color: #fff; font-size: 15px; flex-shrink: 0;
    }
    .form-card-header h3 { font-size: 15px; font-weight: 700; color: var(--text); }
    .form-card-header p  { font-size: 12px; color: var(--muted); margin-top: 1px; }

    .form-body { padding: 24px; }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }
    .form-group { margin-bottom: 20px; }
    .form-group:last-child { margin-bottom: 0; }
    .form-group.full { grid-column: 1 / -1; }

    label {
        display: block;
        font-size: 12.5px; font-weight: 600;
        color: var(--muted); margin-bottom: 7px;
        text-transform: uppercase; letter-spacing: .5px;
    }
    label span.req { color: var(--danger); margin-left: 2px; }

    .form-control {
        width: 100%; padding: 10px 13px;
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: 9px;
        color: var(--text); font-size: 13.5px;
        font-family: inherit; outline: none;
        transition: border-color .18s, box-shadow .18s;
        box-sizing: border-box;
    }
    .form-control:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(79,142,247,.15);
    }
    .form-control::placeholder { color: var(--muted); }
    .form-control.is-invalid { border-color: var(--danger); }
    .form-control.is-invalid:focus { box-shadow: 0 0 0 3px rgba(248,113,113,.15); }

    select.form-control { cursor: pointer; }

    .input-hint {
        font-size: 11.5px; color: var(--muted);
        margin-top: 5px;
    }
    .invalid-feedback {
        font-size: 11.5px; color: var(--danger);
        margin-top: 5px; display: flex; align-items: center; gap: 4px;
    }
    .invalid-feedback i { font-size: 10px; }

    .sks-grid {
        display: grid; grid-template-columns: repeat(6, 1fr); gap: 8px;
    }
    .sks-option input[type="radio"] { display: none; }
    .sks-option label {
        display: grid; place-items: center;
        height: 42px; border-radius: 8px;
        background: var(--surface-2);
        border: 1.5px solid var(--border);
        font-size: 14px; font-weight: 700;
        color: var(--muted); cursor: pointer;
        transition: all .15s;
        text-transform: none; letter-spacing: 0;
    }
    .sks-option input[type="radio"]:checked + label {
        background: rgba(79,142,247,.12);
        border-color: var(--accent);
        color: var(--accent);
    }
    .sks-option label:hover {
        border-color: var(--accent);
        color: var(--accent);
    }

    .preview-box {
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 14px 16px;
        display: flex; align-items: center; gap: 12px;
        margin-bottom: 20px;
    }
    .preview-avatar {
        width: 42px; height: 42px; border-radius: 10px;
        display: grid; place-items: center;
        font-size: 11px; font-weight: 700; color: #fff; flex-shrink: 0;
        background: linear-gradient(135deg, #4f8ef7, #7c6af7);
        transition: all .2s;
    }
    .preview-info .preview-name { font-size: 14px; font-weight: 700; color: var(--text); }
    .preview-info .preview-sub  { font-size: 12px; color: var(--muted); font-family: 'JetBrains Mono', monospace; margin-top: 2px; }

    .meta-info {
        display: flex; gap: 18px; flex-wrap: wrap;
        padding: 12px 16px;
        background: rgba(79,142,247,.05);
        border: 1px solid rgba(79,142,247,.15);
        border-radius: 9px;
        margin-bottom: 20px;
    }
    .meta-item { font-size: 12px; color: var(--muted); }
    .meta-item strong { color: var(--text); font-weight: 600; }

    .form-footer {
        padding: 18px 24px;
        border-top: 1px solid var(--border);
        background: var(--surface-2);
        display: flex; align-items: center; justify-content: space-between;
        gap: 10px; flex-wrap: wrap;
    }
    .form-footer-right { display: flex; gap: 10px; }

    .modal-overlay {
        display: none; position: fixed; inset: 0;
        background: rgba(0,0,0,.6); backdrop-filter: blur(4px);
        z-index: 200; align-items: center; justify-content: center;
    }
    .modal-overlay.show { display: flex; }
    .modal-box {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: 16px; padding: 28px;
        max-width: 380px; width: 90%;
        animation: fadeUp .25s ease;
    }
    .modal-box h3 { font-size: 17px; font-weight: 700; margin-bottom: 8px; }
    .modal-box p  { font-size: 13.5px; color: var(--muted); margin-bottom: 22px; }
    .modal-actions { display: flex; gap: 10px; justify-content: flex-end; }
    .btn-danger { background: var(--danger); color: #fff; }
    .btn-danger:hover { background: #ef4444; }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .form-card { animation: fadeUp .25s ease; }
</style>
@endpush

@section('content')

<div class="form-header">
    <div class="form-header-left">
        <h2>Edit Mata Pelajaran</h2>
        <p>Perbarui informasi mata pelajaran <strong>{{ $mataPelajaran->nama_mapel }}</strong></p>
    </div>
    <a href="{{ route('admin.mapel.index') }}" class="btn btn-cancel">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="form-card">
    <div class="form-card-header">
        <div class="icon"><i class="fas fa-pen-to-square"></i></div>
        <div>
            <h3>Edit Informasi Mata Pelajaran</h3>
            <p>ID: #{{ $mataPelajaran->id }} &mdash; Terakhir diperbarui: {{ $mataPelajaran->updated_at->diffForHumans() }}</p>
        </div>
    </div>

    <form action="{{ route('admin.mapel.update', $mataPelajaran) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-body">

            {{-- Meta Info --}}
            <div class="meta-info">
                <div class="meta-item">ID: <strong>#{{ $mataPelajaran->id }}</strong></div>
                <div class="meta-item">Dibuat: <strong>{{ $mataPelajaran->created_at->format('d M Y') }}</strong></div>
                <div class="meta-item">SKS Saat Ini: <strong>{{ $mataPelajaran->sks }} SKS</strong></div>
            </div>

            {{-- Live Preview --}}
            <div class="preview-box">
                <div class="preview-avatar" id="previewAvatar">
                    {{ strtoupper(substr($mataPelajaran->kode_mapel, 0, 3)) }}
                </div>
                <div class="preview-info">
                    <div class="preview-name" id="previewName">{{ $mataPelajaran->nama_mapel }}</div>
                    <div class="preview-sub"  id="previewKode">{{ $mataPelajaran->kode_mapel }}</div>
                </div>
            </div>

            <div class="form-row">
                {{-- Nama Mapel --}}
                <div class="form-group full">
                    <label>Nama Mata Pelajaran <span class="req">*</span></label>
                    <input type="text" name="nama_mapel" id="nama_mapel"
                           class="form-control @error('nama_mapel') is-invalid @enderror"
                           value="{{ old('nama_mapel', $mataPelajaran->nama_mapel) }}"
                           placeholder="cth. Matematika, Bahasa Indonesia...">
                    @error('nama_mapel')
                        <div class="invalid-feedback"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                    @enderror
                </div>

                {{-- Kode Mapel --}}
                <div class="form-group">
                    <label>Kode Mapel <span class="req">*</span></label>
                    <input type="text" name="kode_mapel" id="kode_mapel"
                           class="form-control @error('kode_mapel') is-invalid @enderror"
                           value="{{ old('kode_mapel', $mataPelajaran->kode_mapel) }}"
                           placeholder="cth. MAT, BIN, FIS"
                           maxlength="20"
                           style="font-family:'JetBrains Mono',monospace; text-transform:uppercase">
                    @error('kode_mapel')
                        <div class="invalid-feedback"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                    @else
                        <div class="input-hint">Kode unik, maks. 20 karakter</div>
                    @enderror
                </div>

                {{-- Guru --}}
                <div class="form-group">
                    <label>Guru Pengampu <span class="req">*</span></label>
                    <select name="guru_id" class="form-control @error('guru_id') is-invalid @enderror">
                        <option value="">— Pilih Guru —</option>
                        @foreach($guru as $g)
                            <option value="{{ $g->id }}"
                                {{ old('guru_id', $mataPelajaran->guru_id) == $g->id ? 'selected' : '' }}>
                                {{ $g->nama_guru }}
                            </option>
                        @endforeach
                    </select>
                    @error('guru_id')
                        <div class="invalid-feedback"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- SKS --}}
            <div class="form-group">
                <label>Jumlah SKS <span class="req">*</span></label>
                <div class="sks-grid">
                    @foreach([1,2,3,4,5,6] as $s)
                        <div class="sks-option">
                            <input type="radio" name="sks" id="sks_{{ $s }}" value="{{ $s }}"
                                   {{ old('sks', $mataPelajaran->sks) == $s ? 'checked' : '' }}>
                            <label for="sks_{{ $s }}">{{ $s }}</label>
                        </div>
                    @endforeach
                </div>
                @error('sks')
                    <div class="invalid-feedback" style="margin-top:8px">
                        <i class="fas fa-circle-exclamation"></i> {{ $message }}
                    </div>
                @enderror
            </div>

        </div>

        <div class="form-footer">
            <button type="button" class="btn btn-danger-outline"
                    onclick="document.getElementById('deleteModal').classList.add('show')">
                <i class="fas fa-trash"></i> Hapus Mapel
            </button>
            <div class="form-footer-right">
                <a href="{{ route('admin.mapel.index') }}" class="btn btn-cancel">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-floppy-disk"></i> Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>

{{-- DELETE MODAL --}}
<div class="modal-overlay" id="deleteModal">
    <div class="modal-box">
        <h3>🗑️ Hapus Mata Pelajaran</h3>
        <p>Apakah kamu yakin ingin menghapus <strong>{{ $mataPelajaran->nama_mapel }}</strong>?
           Seluruh data terkait akan terpengaruh.</p>
        <div class="modal-actions">
            <button class="btn btn-cancel"
                    onclick="document.getElementById('deleteModal').classList.remove('show')">
                Batal
            </button>
            <form action="{{ route('admin.mapel.destroy', $mataPelajaran) }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const namaInput    = document.getElementById('nama_mapel');
    const kodeInput    = document.getElementById('kode_mapel');
    const previewName  = document.getElementById('previewName');
    const previewKode  = document.getElementById('previewKode');
    const previewAvatar = document.getElementById('previewAvatar');

    function updatePreview() {
        const nama = namaInput.value.trim();
        const kode = kodeInput.value.trim().toUpperCase();

        previewName.textContent   = nama || 'Nama Mata Pelajaran';
        previewKode.textContent   = kode || 'Kode Mapel';
        previewAvatar.textContent = kode ? kode.substring(0, 3) : '—';
    }

    namaInput.addEventListener('input', updatePreview);
    kodeInput.addEventListener('input', function() {
        this.value = this.value.toUpperCase();
        updatePreview();
    });

    // Close modal on overlay click
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) this.classList.remove('show');
    });
</script>
@endpush