<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    protected $table = 'mata_pelajaran';
    protected $fillable = ['guru_id','kode_mapel','nama_mapel','sks'];

    public function guru()          { return $this->belongsTo(Guru::class); }
    public function nilai()         { return $this->hasMany(Nilai::class); }
    public function kkm()           { return $this->hasMany(Kkm::class); }
}