<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Ubah kolom 'role' di tabel 'users' untuk menambah 'evaluator'
        Schema::table('users', function (Blueprint $table) {
            // Sintaks ini untuk MySQL
            $table->enum('role', ['tim_sakip', 'unit_kerja', 'evaluator'])->default('unit_kerja')->change();
        });

        // 2. Buat tabel baru untuk menyimpan catatan/evaluasi
        Schema::create('evaluasi_laporans', function (Blueprint $table) {
            $table->id('id_evaluasi');
            $table->foreignId('id_realisasi_fk')->constrained('realisasis', 'id_realisasi')->onDelete('cascade');
            $table->foreignId('id_user_fk')->constrained('users')->onDelete('cascade'); // Siapa yang memberi catatan
            $table->text('catatan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluasi_laporans');

        Schema::table('users', function (Blueprint $table) {
             $table->enum('role', ['tim_sakip', 'unit_kerja'])->default('unit_kerja')->change();
        });
    }
};