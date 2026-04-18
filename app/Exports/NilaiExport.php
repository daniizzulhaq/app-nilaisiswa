<?php
namespace App\Exports;

use App\Models\Nilai;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class NilaiExport implements FromCollection, WithHeadings, WithMapping
{
    protected $kelasId;

    public function __construct($kelasId)
    {
        $this->kelasId = $kelasId;
    }

    public function collection()
    {
        return Nilai::with(['siswa', 'mataPelajaran'])
                    ->where('kelas_id', $this->kelasId)
                    ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'NIS',
            'Nama Siswa',
            'Mata Pelajaran',
            'Nilai',
            'Grade',
            'Status'
        ];
    }

    public function map($nilai): array
    {
        static $no = 1;

        // ✅ Samakan dengan logika rekap: nilai_akhir ?? nilai
        $nilaiValue = $nilai->nilai_akhir ?? $nilai->nilai ?? 0;

        // ✅ Samakan logika grade dengan rekap
        if ($nilaiValue >= 85)      $grade = 'A';
        elseif ($nilaiValue >= 75)  $grade = 'B';
        elseif ($nilaiValue >= 60)  $grade = 'C';
        else                        $grade = 'D';

        $status = $nilaiValue >= 75 ? 'Lulus' : 'Tidak Lulus';

        return [
            $no++,
            $nilai->siswa->nis ?? '-',
            $nilai->siswa->nama ?? '-',   // ✅ Samakan: nama bukan nama_siswa
            $nilai->mataPelajaran->nama_mapel ?? '-',
            $nilaiValue,                  // ✅ Pakai nilaiValue bukan $nilai->nilai
            $grade,
            $status,
        ];
    }
}