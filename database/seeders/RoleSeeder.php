<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'id' => '1',
                'role_akses' => 'dosen'
            ],
            [
                'id' => '2',
                'role_akses' => 'mahasiswa'
            ],
            // Tambahkan role lain jika diperlukan
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
