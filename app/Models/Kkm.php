<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Kkm extends Model
{
    protected $table = 'kkm';
    protected $fillable = ['mata_pelajaran_id','kelas_id','nilai_kkm'];

    public function mataPelajaran() { return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id'); }
    public function kelas()         { return $this->belongsTo(Kelas::class); }
}