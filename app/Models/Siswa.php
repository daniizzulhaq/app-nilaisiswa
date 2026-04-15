<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';
    protected $fillable = ['user_id','kelas_id','nis','nama','jenis_kelamin','tanggal_lahir','alamat'];

    public function user()          { return $this->belongsTo(User::class); }
    public function kelas()         { return $this->belongsTo(Kelas::class); }
    public function nilai()         { return $this->hasMany(Nilai::class); }
}