<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Guru, User, MataPelajaran};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    public function index()
    {
        $guru = Guru::with('user')->paginate(15);
        return view('admin.guru.index', compact('guru'));
    }

    public function create()
    {
        return view('admin.guru.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip'      => 'required|unique:guru',
            'nama'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users',
            'no_telp'  => 'nullable|string|max:15',
        ]);

        $user = User::create([
            'name'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make('password123'),
            'role'     => 'guru',
        ]);

        Guru::create([
            'user_id' => $user->id,
            'nip'     => $request->nip,
            'nama'    => $request->nama,
            'no_telp' => $request->no_telp,
        ]);

        return redirect()->route('admin.guru.index')->with('success', 'Guru berhasil ditambahkan.');
    }

    public function show(Guru $guru)
    {
        $guru->load(['user', 'mataPelajaran']);
        return view('admin.guru.show', compact('guru'));
    }

    public function edit(Guru $guru)
    {
        return view('admin.guru.edit', compact('guru'));
    }

    public function update(Request $request, Guru $guru)
    {
        $request->validate([
            'nip'     => 'required|unique:guru,nip,' . $guru->id,
            'nama'    => 'required|string|max:100',
            'no_telp' => 'nullable|string|max:15',
        ]);

        $guru->update($request->only(['nip', 'nama', 'no_telp']));
        $guru->user->update(['name' => $request->nama]);

        return redirect()->route('admin.guru.index')->with('success', 'Data guru diperbarui.');
    }

    public function destroy(Guru $guru)
    {
        $guru->user()->delete(); // cascade hapus guru juga
        return back()->with('success', 'Data guru dihapus.');
    }
}