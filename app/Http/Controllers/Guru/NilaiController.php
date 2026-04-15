<?php
namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\{Nilai, Siswa, MataPelajaran, Kelas, Kkm};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
    public function index(Request $request)
    {
        $guru = Auth::user()->guru;
        $mapel = MataPelajaran::where('guru_id', $guru->id)->get();
        
        $query = Nilai::with(['siswa', 'mataPelajaran', 'kelas']);
        
        $query->whereHas('mataPelajaran', function($q) use ($guru) {
            $q->where('guru_id', $guru->id);
        });
        
        if ($request->filled('mapel_id')) {
            $query->where('mata_pelajaran_id', $request->mapel_id);
        }
        
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }
        
        if ($request->filled('tahun_ajaran')) {
            $query->where('tahun_ajaran', 'like', "%{$request->tahun_ajaran}%");
        }
        
        if ($request->filled('q')) {
            $search = $request->q;
            $query->whereHas('siswa', function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }
        
        $nilais = $query->orderBy('created_at', 'desc')->paginate(15);
        
        return view('guru.nilai.index', compact('nilais', 'mapel'));
    }

    public function create(Request $request)
    {
        $kelas = Kelas::all();
        $mapel = MataPelajaran::where('guru_id', Auth::user()->guru->id)->get();
        $siswa = $request->kelas_id ? Siswa::where('kelas_id', $request->kelas_id)->get() : collect();
        
        return view('guru.nilai.create', compact('kelas', 'mapel', 'siswa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id'          => 'required|exists:siswa,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'kelas_id'          => 'required|exists:kelas,id',
            'semester'          => 'required|in:1,2',
            'tahun_ajaran'      => 'required|string',
            'nilai_tugas'       => 'nullable|numeric|min:0|max:100',
            'nilai_uts'         => 'nullable|numeric|min:0|max:100',
            'nilai_uas'         => 'nullable|numeric|min:0|max:100',
            'nilai_sikap'       => 'nullable|numeric|min:0|max:100',
        ]);

        $nilai = Nilai::updateOrCreate(
            [
                'siswa_id'          => $request->siswa_id,
                'mata_pelajaran_id' => $request->mata_pelajaran_id,
                'semester'          => $request->semester,
                'tahun_ajaran'      => $request->tahun_ajaran,
            ],
            $request->only(['kelas_id', 'nilai_tugas', 'nilai_uts', 'nilai_uas', 'nilai_sikap'])
        );

        // Hitung otomatis
        $nilaiAkhir = $nilai->hitungNilaiAkhir();
        $predikat = Nilai::tentukanPredikat($nilaiAkhir);
        
        $kkm = Kkm::where('mata_pelajaran_id', $request->mata_pelajaran_id)
                  ->where('kelas_id', $request->kelas_id)
                  ->first();
        $kkmValue = $kkm ? $kkm->nilai_kkm : 75;
        $lulus = $nilaiAkhir >= $kkmValue;

        $nilai->update([
            'nilai_akhir' => $nilaiAkhir,
            'predikat'    => $predikat,
            'lulus'       => $lulus,  // ✅ SUDAH ADA
        ]);

        return redirect()->route('guru.nilai.index')->with('success', 'Nilai berhasil disimpan.');
    }

    public function edit(Nilai $nilai)
    {
        return view('guru.nilai.edit', compact('nilai'));
    }

    public function update(Request $request, Nilai $nilai)
    {
        $request->validate([
            'nilai_tugas'  => 'nullable|numeric|min:0|max:100',
            'nilai_uts'    => 'nullable|numeric|min:0|max:100',
            'nilai_uas'    => 'nullable|numeric|min:0|max:100',
            'nilai_sikap'  => 'nullable|numeric|min:0|max:100',
        ]);

        $nilai->update($request->only(['nilai_tugas', 'nilai_uts', 'nilai_uas', 'nilai_sikap']));
        
        $nilaiAkhir = $nilai->hitungNilaiAkhir();
        
        // ✅ HITUNG ULANG KKM DAN STATUS LULUS
        $kkm = Kkm::where('mata_pelajaran_id', $nilai->mata_pelajaran_id)
                  ->where('kelas_id', $nilai->kelas_id)
                  ->first();
        $kkmValue = $kkm ? $kkm->nilai_kkm : 75;
        $lulus = $nilaiAkhir >= $kkmValue;
        
        $nilai->update([
            'nilai_akhir' => $nilaiAkhir,
            'predikat'    => Nilai::tentukanPredikat($nilaiAkhir),
            'lulus'       => $lulus,  // ✅ SEKARANG ADA!
        ]);

        return redirect()->route('guru.nilai.index')->with('success', 'Nilai diperbarui.');
    }
    
    public function destroy(Nilai $nilai)
    {
        $nilai->delete();
        return redirect()->route('guru.nilai.index')->with('success', 'Nilai berhasil dihapus.');
    }
}