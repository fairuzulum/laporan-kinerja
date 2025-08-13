<?php

namespace Database\Seeders;

use App\Models\UnitKerja;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UnitKerja::create([
            'nama_unit' => 'Jurusan Bisnis Digital',
            'tipe_unit' => 'Jurusan'
        ]);

        UnitKerja::create([
            'nama_unit' => 'Jurusan Pertanian',
            'tipe_unit' => 'Jurusan'
        ]);

        UnitKerja::create([
            'nama_unit' => 'UPT Bahasa',
            'tipe_unit' => 'UPT'
        ]);
    }
}