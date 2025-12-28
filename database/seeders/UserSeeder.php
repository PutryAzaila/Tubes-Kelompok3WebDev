<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'nama_lengkap'   => 'Admin Sistem',
                'email'          => 'admin@gmail.com',
                'jenis_kelamin'  => 'Laki-laki',
                'tempat_lahir'   => 'Jakarta',
                'tanggal_lahir'  => now()->subYears(30),
                'alamat'         => 'Jl. Cenderawasih No. 123, Jakarta',
                'no_hp'          => '081234567890',
                'jabatan'        => 'Admin',
                'password'       => Hash::make('password123'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'manajer@gmail.com'],
            [
                'nama_lengkap'   => 'Manajer Operasional',
                'email'          => 'manajer@gmail.com',
                'jenis_kelamin'  => 'Laki-laki',
                'tempat_lahir'   => 'Bandung',
                'tanggal_lahir'  => now()->subYears(35),
                'alamat'         => 'Jl. Merdeka No. 45, Bandung',
                'no_hp'          => '081298765432',
                'jabatan'        => 'Manajer',
                'password'       => Hash::make('password123'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'noc@gmail.com'],
            [
                'nama_lengkap'   => 'Petugas NOC',
                'email'          => 'noc@gmail.com',
                'jenis_kelamin'  => 'Perempuan',
                'tempat_lahir'   => 'Surabaya',
                'tanggal_lahir'  => now()->subYears(25),
                'alamat'         => 'Ruang NOC Lt. 2',
                'no_hp'          => '081277788899',
                'jabatan'        => 'NOC',
                'password'       => Hash::make('password123'),
            ]
        );
    }
}
