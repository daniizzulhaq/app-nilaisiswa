<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $table = 'nilai';
    protected $fillable = [
        'siswa_id','mata_pelajaran_id','kelas_id',
        'semester','tahun_ajaran',
        'nilai_tugas','nilai_uts','nilai_uas','nilai_sikap',
        'nilai_akhir','predikat','lulus'
    ];

    public function siswa()         { return $this->belongsTo(Siswa::class); }
    public function mataPelajaran() { return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id'); }
    public function kelas()         { return $this->belongsTo(Kelas::class); }

    // Hitung nilai akhir otomatis (bobot configurable)
    public function hitungNilaiAkhir($bobotTugas=20, $bobotUts=30, $bobotUas=40, $bobotSikap=10): float
    {
        return ($this->nilai_tugas  * $bobotTugas  / 100)
             + ($this->nilai_uts   * $bobotUts    / 100)
             + ($this->nilai_uas   * $bobotUas    / 100)
             + ($this->nilai_sikap * $bobotSikap  / 100);
    }

    // Tentukan predikat
    public static function tentukanPredikat(float $nilai): string
    {
        return match(true) {
            $nilai >= 90 => 'A',
            $nilai >= 80 => 'B',
            $nilai >= 70 => 'C',
            $nilai >= 60 => 'D',
            default      => 'E',
        };
    }
}