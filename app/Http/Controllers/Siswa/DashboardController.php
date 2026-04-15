<?php
namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\{Nilai, MataPelajaran, Siswa};
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $guru  = Auth::user()->guru;
        $mapel = MataPelajaran::where('guru_id', $guru->id)->get();

        $mapelIds     = $mapel->pluck('id');
        $totalNilai   = Nilai::whereIn('mata_pelajaran_id', $mapelIds)->count();
        $rataRata     = Nilai::whereIn('mata_pelajaran_id', $mapelIds)->avg('nilai_akhir');
        $siswaLulus   = Nilai::whereIn('mata_pelajaran_id', $mapelIds)->where('lulus', true)->count();
        $siswaTidak   = Nilai::whereIn('mata_pelajaran_id', $mapelIds)->where('lulus', false)->count();

        return view('guru.dashboard', compact(
            'guru', 'mapel', 'totalNilai', 'rataRata', 'siswaLulus', 'siswaTidak'
        ));
    }
}