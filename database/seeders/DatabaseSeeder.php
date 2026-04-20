<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
// Hapus baris use Illuminate\Database\Console\Seeds\WithoutModelEvents; kalau tidak dipakai

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Gunakan updateOrCreate untuk memasukkan akun admin tanpa memanggil Factory
        User::updateOrCreate(
            ['email' => 'admin@absensi.com'], // Laravel akan mencari user dengan email ini
            [
                'name' => 'Admin Absensi',
                'password' => Hash::make('password')
            ]
        );
    }
}