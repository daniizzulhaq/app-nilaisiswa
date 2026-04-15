<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\{Nilai, MataPelajaran, Kelas, Siswa};
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $guru  = Auth::user()->guru;

        // Mata pelajaran yang diampu guru ini
        $mapel = MataPelajaran::where('guru_id', $guru->id)->get();

        // Jumlah kelas unik yang diampu
        $totalKelas = $mapel->pluck('kelas_id')->unique()->count();

        // Total siswa dari semua kelas yang diampu
        $kelasIds    = $mapel->pluck('kelas_id')->unique();
        $totalSiswa  = Siswa::whereIn('kelas_id', $kelasIds)->count();

        // Total nilai yang sudah diinput oleh guru ini
        $mapelIds    = $mapel->pluck('id');
        $totalNilai  = Nilai::whereIn('mata_pelajaran_id', $mapelIds)->count();

        // Nilai terbaru yang diinput
        $nilaiTerbaru = Nilai::whereIn('mata_pelajaran_id', $mapelIds)
            ->with(['siswa', 'mataPelajaran'])
            ->latest()
            ->take(8)
            ->get();

        // Statistik per mata pelajaran (rata-rata nilai akhir)
        $statsMapel = [];
        foreach ($mapel as $mp) {
            $avg = Nilai::where('mata_pelajaran_id', $mp->id)
                ->whereNotNull('nilai_akhir')
                ->avg('nilai_akhir');
            $statsMapel[] = [
                'nama'      => $mp->nama_mapel,
                'kode'      => $mp->kode_mapel ?? strtoupper(substr($mp->nama_mapel, 0, 3)),
                'rata_rata' => round($avg ?? 0, 1),
                'total'     => Nilai::where('mata_pelajaran_id', $mp->id)->count(),
            ];
        }

        // Distribusi predikat
        $distribusi = Nilai::whereIn('mata_pelajaran_id', $mapelIds)
            ->selectRaw('predikat, count(*) as total')
            ->groupBy('predikat')
            ->pluck('total', 'predikat')
            ->toArray();

        return view('guru.dashboard', compact(
            'guru', 'mapel', 'totalKelas', 'totalSiswa',
            'totalNilai', 'nilaiTerbaru', 'statsMapel', 'distribusi'
        ));
    }
}