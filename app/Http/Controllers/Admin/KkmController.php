<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Kkm, MataPelajaran, Kelas};
use Illuminate\Http\Request;

class KkmController extends Controller
{
    public function index()
    {
        $kkm = Kkm::with(['mataPelajaran', 'kelas'])->paginate(15);
        return view('admin.kkm.index', compact('kkm'));
    }

    public function create()
    {
        $mapel = MataPelajaran::all();
        $kelas = Kelas::all();
        return view('admin.kkm.create', compact('mapel', 'kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'kelas_id'          => 'required|exists:kelas,id',
            'nilai_kkm'         => 'required|integer|min:0|max:100',
        ]);

        Kkm::updateOrCreate(
            [
                'mata_pelajaran_id' => $request->mata_pelajaran_id,
                'kelas_id'          => $request->kelas_id,
            ],
            ['nilai_kkm' => $request->nilai_kkm]
        );

        return redirect()->route('admin.kkm.index')->with('success', 'KKM berhasil disimpan.');
    }

    public function edit(Kkm $kkm)
    {
        $mapel = MataPelajaran::all();
        $kelas = Kelas::all();
        return view('admin.kkm.edit', compact('kkm', 'mapel', 'kelas'));
    }

    public function update(Request $request, Kkm $kkm)
    {
        $request->validate([
            'nilai_kkm' => 'required|integer|min:0|max:100',
        ]);

        $kkm->update(['nilai_kkm' => $request->nilai_kkm]);

        return redirect()->route('admin.kkm.index')->with('success', 'KKM diperbarui.');
    }

    public function destroy(Kkm $kkm)
    {
        $kkm->delete();
        return back()->with('success', 'KKM dihapus.');
    }
}