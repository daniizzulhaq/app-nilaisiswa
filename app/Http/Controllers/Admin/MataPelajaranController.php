<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{MataPelajaran, Guru};
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    public function index()
    {
        $mapel = MataPelajaran::with('guru')->paginate(15);
        return view('admin.mapel.index', compact('mapel'));
    }

    public function create()
    {
        $guru = Guru::all();
        return view('admin.mapel.create', compact('guru'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'guru_id'    => 'required|exists:guru,id',
            'kode_mapel' => 'required|unique:mata_pelajaran|max:20',
            'nama_mapel' => 'required|string|max:100',
            'sks'        => 'required|integer|min:1|max:6',
        ]);

        MataPelajaran::create($request->only(['guru_id', 'kode_mapel', 'nama_mapel', 'sks']));

        return redirect()->route('admin.mapel.index')->with('success', 'Mata pelajaran ditambahkan.');
    }

    public function show(MataPelajaran $mataPelajaran)
    {
        $mataPelajaran->load('guru');
        return view('admin.mapel.show', compact('mataPelajaran'));
    }

    public function edit(MataPelajaran $mataPelajaran)
    {
        $guru = Guru::all();
        return view('admin.mapel.edit', compact('mataPelajaran', 'guru'));
    }

    public function update(Request $request, MataPelajaran $mataPelajaran)
    {
        $request->validate([
            'guru_id'    => 'required|exists:guru,id',
            'kode_mapel' => 'required|unique:mata_pelajaran,kode_mapel,' . $mataPelajaran->id . '|max:20',
            'nama_mapel' => 'required|string|max:100',
            'sks'        => 'required|integer|min:1|max:6',
        ]);

        $mataPelajaran->update($request->only(['guru_id', 'kode_mapel', 'nama_mapel', 'sks']));

        return redirect()->route('admin.mapel.index')->with('success', 'Mata pelajaran diperbarui.');
    }

    public function destroy(MataPelajaran $mataPelajaran)
    {
        $mataPelajaran->delete();
        return back()->with('success', 'Mata pelajaran dihapus.');
    }
}