<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nama_lengkap' => 'Admin Utama',
            'email' => 'admin@example.com',
            'jenis_kelamin' => 'Laki-laki',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => now()->subYears(30),
            'alamat' => 'Jl. Contoh No. 123, Jakarta',
            'no_hp' => '081234567890',
            'jabatan' => 'Administrator',
            'password' => Hash::make('password123'),
        ]);
    }
}