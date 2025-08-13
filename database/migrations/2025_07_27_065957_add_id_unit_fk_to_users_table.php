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
        // Perintah untuk MENGUBAH tabel 'users'
        Schema::table('users', function (Blueprint $table) {
            // 1. Tambah kolom baru untuk foreign key
            $table->unsignedBigInteger('id_unit_fk')->nullable()->after('role');

            // 2. Definisikan foreign key constraint
            $table->foreign('id_unit_fk')
                  ->references('id_unit')      // Mengacu ke kolom 'id_unit'
                  ->on('unit_kerjas')        // di tabel 'unit_kerjas'
                  ->onDelete('set null');     // Jika unit kerja dihapus, kolom ini jadi NULL
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Perintah untuk membatalkan perubahan jika di-rollback
        Schema::table('users', function (Blueprint $table) {
            // Hapus constraint dulu sebelum hapus kolom
            $table->dropForeign(['id_unit_fk']);
            $table->dropColumn('id_unit_fk');
        });
    }
};