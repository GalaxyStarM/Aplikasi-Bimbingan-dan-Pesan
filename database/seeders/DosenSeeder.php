<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DosenSeeder extends Seeder
{
    public function run()
    {
        $dosen = [
            [
                'nip' => '198501012015041001',
                'nama' => 'Dr. Contoh Dosen',
                'nama_singkat' => 'CD',
                'email' => 'tri.murniati2735@student.unri.ac.id',
                'password' => Hash::make('password123'),
                'prodi_id' => 1, // Sesuaikan dengan ID prodi yang sesuai
                'role_id' => 2,  // Role dosen
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nip' => '198501012015041002',
                'nama' => 'Dr. Contoh Dosen',
                'nama_singkat' => 'CD',
                'email' => 'desi.maya0665@student.unri.ac.id',
                'password' => Hash::make('password123'),
                'prodi_id' => 1, // Sesuaikan dengan ID prodi yang sesuai
                'role_id' => 2,  // Role dosen
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nip' => '198501012015041025',
                'nama' => 'Dr. Contoh Dosen',
                'nama_singkat' => 'CD',
                'email' => 'syahirah.tri0255@students.unri.ac.id',
                'password' => Hash::make('password123'),
                'prodi_id' => 1, // Sesuaikan dengan ID prodi yang sesuai
                'role_id' => 2,  // Role dosen
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        DB::table('dosens')->insert($dosen);
    }
}