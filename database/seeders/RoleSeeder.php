<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'admin',
            'kepala',
            'pegawai',
        ];

        foreach ($data as $value) {
            Role::create([
                'role'      => $value,
                'status'    => 1
            ]);
        }
    }
}
