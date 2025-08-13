<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // User dengan role 'tim_sakip'
        User::create([
            'name' => 'Tim Sakip User',
            'email' => 'sakip@gmail.com',
            'password' => Hash::make('password123'), // Ganti password sesuai kebutuhan
            'role' => 'tim_sakip',
        ]);

        // // User dengan role 'unit_kerja'
        // User::create([
        //     'name' => 'Unit Kerja User',
        //     'email' => 'unit@gmail.com',
        //     'password' => Hash::make('password123'), // Ganti password sesuai kebutuhan
        //     'role' => 'unit_kerja',
        //     'id_unit_fk' => 1, // Ganti dengan ID unit yang sesuai
        // ]);

        // Optional: Tambahkan lebih banyak user jika perlu
        // User::create([...]);
    }
}