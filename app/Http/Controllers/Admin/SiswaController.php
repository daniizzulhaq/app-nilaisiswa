<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Siswa, Kelas, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $siswa = Siswa::with('kelas')
            ->when($request->q, fn($q, $v) =>
                $q->where('nama', 'like', "%$v%")
                  ->orWhere('nis', 'like', "%$v%")
            )
            ->when($request->kelas_id, fn($q, $v) => $q->where('kelas_id', $v))
            ->when($request->jenis_kelamin, fn($q, $v) => $q->where('jenis_kelamin', $v))
            ->latest()
            ->paginate(15);

        return view('admin.siswa.index', compact('siswa'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        return view('admin.siswa.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis'           => 'required|unique:siswa',
            'nama'          => 'required|string|max:100',
            'email'         => 'required|email|unique:users',
            'kelas_id'      => 'required|exists:kelas,id',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'alamat'        => 'nullable|string',
        ]);

        $user = User::create([
            'name'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make('password123'),
            'role'     => 'siswa',
        ]);

        Siswa::create([
            'user_id'       => $user->id,
            'kelas_id'      => $request->kelas_id,
            'nis'           => $request->nis,
            'nama'          => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat'        => $request->alamat,
        ]);

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function edit(Siswa $siswa)
    {
        $kelas = Kelas::all();
        return view('admin.siswa.edit', compact('siswa', 'kelas'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nama'          => 'required|string|max:100',
            'kelas_id'      => 'required|exists:kelas,id',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'alamat'        => 'nullable|string',
        ]);

        $siswa->update(
            $request->only(['nama', 'kelas_id', 'jenis_kelamin', 'tanggal_lahir', 'alamat'])
        );

        // Sync nama di tabel users
        $siswa->user?->update(['name' => $request->nama]);

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa)
    {
        $siswa->user?->delete(); // cascade hapus akun login
        $siswa->delete();

        return back()->with('success', 'Siswa berhasil dihapus.');
    }
}