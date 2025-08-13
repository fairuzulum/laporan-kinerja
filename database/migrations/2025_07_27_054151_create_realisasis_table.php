<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('realisasis', function (Blueprint $table) {
            $table->id('id_realisasi');
            $table->foreignId('id_pk_fk')->constrained('pohon_kinerja', 'id_pk')->onDelete('cascade');
            $table->foreignId('id_unit_fk')->constrained('unit_kerjas', 'id_unit')->onDelete('cascade');
            $table->year('tahun_laporan');
            $table->decimal('capaian_realisasi', 10, 2);
            $table->text('analisis_progres')->nullable();
            $table->text('analisis_kendala')->nullable();
            $table->text('analisis_strategi')->nullable();
            $table->decimal('anggaran_digunakan', 15, 2)->nullable();
            $table->text('link_bukti')->nullable();
            $table->decimal('anggaran_realisasi', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('realisasis');
    }
};