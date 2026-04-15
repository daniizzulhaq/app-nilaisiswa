<?php
// app/Exports/NilaiExport.php
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
        
        $grade = '';
        if($nilai->nilai >= 85) $grade = 'A';
        elseif($nilai->nilai >= 75) $grade = 'B';
        elseif($nilai->nilai >= 60) $grade = 'C';
        else $grade = 'D';
        
        $status = $nilai->nilai >= 75 ? 'Lulus' : 'Tidak Lulus';
        
        return [
            $no++,
            $nilai->siswa->nis ?? '-',
            $nilai->siswa->nama_siswa ?? '-',
            $nilai->mataPelajaran->nama_mapel ?? '-',
            $nilai->nilai,
            $grade,
            $status
        ];
    }
}