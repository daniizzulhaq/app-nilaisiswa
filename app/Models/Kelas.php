<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';
    protected $fillable = ['nama_kelas', 'tingkat', 'tahun_ajaran'];

    public function siswa()         { return $this->hasMany(Siswa::class); }
    public function nilai()         { return $this->hasMany(Nilai::class); }
    public function kkm()           { return $this->hasMany(Kkm::class); }
}