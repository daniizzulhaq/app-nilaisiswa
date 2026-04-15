<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // Guru
        User::create([
            'name'     => 'Guru',
            'email'    => 'guru@gmail.com',
            'password' => Hash::make('password'),
            'role'     => 'guru',
        ]);

        // Siswa
        User::create([
            'name'     => 'Siswa',
            'email'    => 'siswa@gmail.com',
            'password' => Hash::make('password'),
            'role'     => 'siswa',
        ]);
    }
}