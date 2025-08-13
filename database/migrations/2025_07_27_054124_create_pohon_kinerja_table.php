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
        Schema::create('pohon_kinerja', function (Blueprint $table) {
            $table->id('id_pk');
            
            // Relasi ke diri sendiri untuk hierarki (induk)
            $table->unsignedBigInteger('id_pk_induk')->nullable();
            $table->foreign('id_pk_induk')->references('id_pk')->on('pohon_kinerja')->onDelete('cascade');

            // Relasi ke tabel instrumen
            $table->foreignId('id_instrumen_fk')->constrained('instrumens', 'id_instrumen')->onDelete('cascade');

            $table->string('kode_kinerja', 50)->nullable();
            $table->text('deskripsi_sasaran');
            $table->text('indikator');
            $table->string('satuan', 100);
            $table->decimal('target', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pohon_kinerja');
    }
};