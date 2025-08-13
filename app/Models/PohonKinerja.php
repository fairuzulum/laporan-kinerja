<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PohonKinerja extends Model
{
    use HasFactory;

    protected $table = 'pohon_kinerja';
    protected $primaryKey = 'id_pk';
    protected $guarded = [];

    /**
     * Relasi ke parent-nya sendiri (self-referencing).
     * Satu anak IKU/Sasaran pasti dimiliki oleh satu Induk.
     */
    public function induk(): BelongsTo
    {
        return $this->belongsTo(PohonKinerja::class, 'id_pk_induk', 'id_pk');
    }

    /**
     * Relasi ke anak-anaknya sendiri.
     * Satu Induk bisa memiliki banyak anak.
     */
    public function anak(): HasMany
    {
        return $this->hasMany(PohonKinerja::class, 'id_pk_induk', 'id_pk');
    }

    /**
     * Relasi ke Instrumen.
     * Satu Pohon Kinerja pasti dimiliki oleh satu Instrumen.
     */
    public function instrumen(): BelongsTo
    {
        return $this->belongsTo(Instrumen::class, 'id_instrumen_fk', 'id_instrumen');
    }

    /**
     * Relasi ke Realisasi.
     * Satu Pohon Kinerja bisa memiliki banyak laporan realisasi.
     */
    public function realisasis(): HasMany
    {
        return $this->hasMany(Realisasi::class, 'id_pk_fk', 'id_pk');
    }

    /**
     * Relasi many-to-many ke UnitKerja melalui tabel pivot 'penanggung_jawabs'.
     * Satu Pohon Kinerja bisa menjadi tanggung jawab banyak Unit Kerja.
     */
    public function unitKerjas(): BelongsToMany
    {
        return $this->belongsToMany(
            UnitKerja::class,
            'penanggung_jawabs', // Nama tabel pivot
            'id_pk_fk',          // Foreign key di tabel pivot untuk PohonKinerja
            'id_unit_fk'         // Foreign key di tabel pivot untuk UnitKerja
        );
    }
}