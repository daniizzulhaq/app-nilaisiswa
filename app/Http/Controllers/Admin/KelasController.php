<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::withCount('siswa')->paginate(15);
        return view('admin.kelas.index', compact('kelas'));
    }

    public function create()
    {
        return view('admin.kelas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas'   => 'required|string|max:50',
            'tingkat'      => 'required|in:X,XI,XII',
            'tahun_ajaran' => 'required|string|max:10',
        ]);

        Kelas::create($request->only(['nama_kelas', 'tingkat', 'tahun_ajaran']));

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function show(Kelas $kelas)
    {
        $kelas->load('siswa');
        return view('admin.kelas.show', compact('kelas'));
    }

    public function edit(Kelas $kelas)
    {
        return view('admin.kelas.edit', compact('kelas'));
    }

    public function update(Request $request, Kelas $kelas)
    {
        $request->validate([
            'nama_kelas'   => 'required|string|max:50',
            'tingkat'      => 'required|in:X,XI,XII',
            'tahun_ajaran' => 'required|string|max:10',
        ]);

        $kelas->update($request->only(['nama_kelas', 'tingkat', 'tahun_ajaran']));

        return redirect()->route('admin.kelas.index')->with('success', 'Data kelas diperbarui.');
    }

    public function destroy(Kelas $kelas)
    {
        $kelas->delete();
        return back()->with('success', 'Kelas dihapus.');
    }
}