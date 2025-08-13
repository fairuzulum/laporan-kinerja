<?php

namespace Database\Seeders;

use App\Models\Instrumen;
use App\Models\PohonKinerja;
use App\Models\UnitKerja;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PohonKinerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Ambil data master yang dibutuhkan
        $unitBisnis = UnitKerja::where('nama_unit', 'Jurusan Bisnis Digital')->first();
        $unitPertanian = UnitKerja::where('nama_unit', 'Jurusan Pertanian')->first();

        // 2. Buat Instrumen
        $instrumen = Instrumen::create([
            'nama_instrumen' => 'Perjanjian Kinerja 2025',
            'tahun' => '2025'
        ]);

        // 3. Buat Pohon Kinerja (Level 1 - Sasaran Utama)
        $sasaran1 = PohonKinerja::create([
            'id_instrumen_fk' => $instrumen->id_instrumen,
            'id_pk_induk' => null, // Level teratas tidak punya induk
            'kode_kinerja' => '1',
            'deskripsi_sasaran' => 'Meningkatnya Kualitas Lulusan',
            'indikator' => 'Persentase Lulusan yang Mendapat Pekerjaan Layak',
            'satuan' => 'Persen',
            'target' => 85.00
        ]);

        // 4. Buat Anak dari Sasaran 1 (Level 2 - Program)
        $program1_1 = PohonKinerja::create([
            'id_instrumen_fk' => $instrumen->id_instrumen,
            'id_pk_induk' => $sasaran1->id_pk, // Induknya adalah Sasaran 1
            'kode_kinerja' => '1.1',
            'deskripsi_sasaran' => 'Penguatan Kompetensi Lulusan',
            'indikator' => 'Rata-rata Skor Uji Kompetensi',
            'satuan' => 'Skor',
            'target' => 80.00
        ]);

        // 5. Buat Anak dari Program 1.1 (Level 3 - Kegiatan)
        $kegiatan1_1_1 = PohonKinerja::create([
            'id_instrumen_fk' => $instrumen->id_instrumen,
            'id_pk_induk' => $program1_1->id_pk, // Induknya adalah Program 1.1
            'kode_kinerja' => '1.1.1',
            'deskripsi_sasaran' => 'Pelaksanaan Sertifikasi Internasional',
            'indikator' => 'Jumlah Lulusan Bersertifikasi Internasional',
            'satuan' => 'Orang',
            'target' => 50.00
        ]);

        // Contoh Sasaran lain
        $sasaran2 = PohonKinerja::create([
            'id_instrumen_fk' => $instrumen->id_instrumen,
            'id_pk_induk' => null,
            'kode_kinerja' => '2',
            'deskripsi_sasaran' => 'Meningkatnya Kualitas Penelitian Dosen',
            'indikator' => 'Jumlah Publikasi di Jurnal Internasional Bereputasi',
            'satuan' => 'Publikasi',
            'target' => 20.00
        ]);

        // 6. Tugaskan Penanggung Jawab menggunakan relasi
        //    Sangat mudah! Kita tidak perlu menyentuh tabel pivot secara manual.
        $program1_1->unitKerjas()->attach($unitBisnis->id_unit);
        $kegiatan1_1_1->unitKerjas()->attach($unitBisnis->id_unit);
        $sasaran2->unitKerjas()->attach([$unitBisnis->id_unit, $unitPertanian->id_unit]); // Contoh 1 IKU ditugaskan ke 2 unit
    }
}