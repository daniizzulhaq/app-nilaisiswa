<?php
namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\{Nilai, Siswa};
use Illuminate\Support\Facades\Auth;

class NilaiSiswaController extends Controller
{
    public function index()
    {
        $siswa = Auth::user()->siswa;

        $nilai = Nilai::with('mataPelajaran')
                      ->where('siswa_id', $siswa->id)
                      ->orderBy('tahun_ajaran')
                      ->orderBy('semester')
                      ->get();

        $rataRata    = $nilai->avg('nilai_akhir');
        $totalLulus  = $nilai->where('lulus', true)->count();
        $totalTidak  = $nilai->where('lulus', false)->count();

        return view('siswa.dashboard', compact('siswa', 'nilai', 'rataRata', 'totalLulus', 'totalTidak'));
    }

    public function show($semester, $tahunAjaran)
    {
        $siswa = Auth::user()->siswa;

        $nilai = Nilai::with('mataPelajaran')
                      ->where('siswa_id', $siswa->id)
                      ->where('semester', $semester)
                      ->where('tahun_ajaran', $tahunAjaran)
                      ->get();

        return view('siswa.nilai_detail', compact('siswa', 'nilai', 'semester', 'tahunAjaran'));
    }
    public function exportPdf()
{
    $siswa = Auth::user()->siswa;
    $siswa->load(['nilai.mataPelajaran', 'kelas']);

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('laporan.raport_pdf', compact('siswa'));

    return $pdf->download("raport_{$siswa->nis}.pdf");
}

    // ✅ Tambahkan method ini
    public function raport()
    {
        $siswa = Auth::user()->siswa;

        $nilai = Nilai::with('mataPelajaran')
                      ->where('siswa_id', $siswa->id)
                      ->get();

        return view('laporan.raport', compact('siswa', 'nilai'));
    }
}