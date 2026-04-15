<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table = 'guru';
    protected $fillable = ['user_id','nip','nama','no_telp'];

    public function user()          { return $this->belongsTo(User::class); }
    public function mataPelajaran() { return $this->hasMany(MataPelajaran::class); }
}