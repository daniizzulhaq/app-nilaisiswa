<?php
namespace App\Http\Controllers;

use App\Models\{Siswa, Nilai, Kelas};
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;      // untuk export PDF
use Maatwebsite\Excel\Facades\Excel; // untuk export Excel

class LaporanController extends Controller
{
    // Raport per siswa
    public function raport($siswaId)
    {
        $siswa = Siswa::with(['nilai.mataPelajaran', 'kelas'])->findOrFail($siswaId);
        return view('laporan.raport', compact('siswa'));
    }

    // Rekap nilai per kelas
    public function rekapKelas(Request $request)
    {
        $kelas  = Kelas::all();
        $nilai  = collect();
        if ($request->kelas_id) {
            $nilai = Nilai::with(['siswa','mataPelajaran'])
                          ->where('kelas_id', $request->kelas_id)
                          ->get();
        }
        return view('laporan.rekap', compact('kelas', 'nilai'));
    }

    // Export PDF raport
    public function exportPdf($siswaId)
    {
        $siswa = Siswa::with(['nilai.mataPelajaran', 'kelas'])->findOrFail($siswaId);
        $pdf   = Pdf::loadView('laporan.raport_pdf', compact('siswa'));
        return $pdf->download("raport_{$siswa->nis}.pdf");
    }

    // Export Excel rekap kelas
    public function exportExcel(Request $request)
    {
        // Buat class NilaiExport di app/Exports/NilaiExport.php
        return Excel::download(new \App\Exports\NilaiExport($request->kelas_id), 'rekap_nilai.xlsx');
    }
}