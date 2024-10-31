<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class MahasiswaSeeder extends Seeder
{
    public function run()
    {
        $mahasiswa = [
            [
                'nim' => '2107112735',
                'nama' => 'Tri Murniati',
                'angkatan' => 2021,
                'email' => 'tri.murniati2735@students.unri.ac.id',
                'password' => Hash::make('bismillah123'),
                'prodi_id' => 2,
                'konsentrasi_id' => 1, 
                'role_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        DB::table('mahasiswas')->insert($mahasiswa);
    }
}