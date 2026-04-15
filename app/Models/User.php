<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = ['name', 'email', 'password', 'role'];

    public function siswa()    { return $this->hasOne(Siswa::class); }
    public function guru()     { return $this->hasOne(Guru::class); }
    public function isAdmin()  { return $this->role === 'admin'; }
    public function isGuru()   { return $this->role === 'guru'; }
    public function isSiswa()  { return $this->role === 'siswa'; }
}