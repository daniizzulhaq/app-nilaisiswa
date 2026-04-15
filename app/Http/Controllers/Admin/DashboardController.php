<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Siswa, Guru, MataPelajaran, Nilai, Kelas};

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'total_siswa'     => Siswa::count(),
            'total_guru'      => Guru::count(),
            'total_mapel'     => MataPelajaran::count(),
            'total_kelas'     => Kelas::count(),
            'rata_nilai'      => Nilai::avg('nilai_akhir'),
            'siswa_lulus'     => Nilai::where('lulus', true)->distinct('siswa_id')->count(),
            'siswa_tidak_lulus' => Nilai::where('lulus', false)->distinct('siswa_id')->count(),
        ];
        return view('admin.dashboard', $data);
    }
}