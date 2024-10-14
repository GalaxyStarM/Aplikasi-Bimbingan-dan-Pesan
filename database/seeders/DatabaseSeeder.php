<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Menghapus semua data sebelumnya (jika diperlukan)
        User::truncate();

        // Menambahkan data pengguna
        User::factory()->create([
            'name' => 'Mahasiswa 1',
            'nim' => '2021012345', // NIM untuk mahasiswa
            'email' => 'mahasiswa1@example.com',
            'password' => Hash::make('password123'), // Password yang di-hash
            'role' => 'mahasiswa', // Role mahasiswa
        ]);

        User::factory()->create([
            'name' => 'Dosen 1',
            'nip' => '123456789012345678', // NIP untuk dosen
            'email' => 'dosen1@example.com',
            'password' => Hash::make('password123'), // Password yang di-hash
            'role' => 'dosen', // Role dosen
        ]);
    }
}
