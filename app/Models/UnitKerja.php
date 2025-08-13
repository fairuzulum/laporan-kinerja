<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UnitKerja extends Model
{
    use HasFactory;

    protected $table = 'unit_kerjas';
    protected $primaryKey = 'id_unit';
    protected $guarded = [];

    /**
     * Relasi many-to-many ke PohonKinerja melalui tabel pivot 'penanggung_jawabs'.
     * Satu Unit Kerja bisa bertanggung jawab atas banyak Pohon Kinerja.
     */
    public function pohonKinerjas(): BelongsToMany
    {
        return $this->belongsToMany(
            PohonKinerja::class,
            'penanggung_jawabs', // Nama tabel pivot
            'id_unit_fk',        // Foreign key di tabel pivot untuk UnitKerja
            'id_pk_fk'           // Foreign key di tabel pivot untuk PohonKinerja
        );
    }

    /**
     * Relasi ke Realisasi.
     * Satu Unit Kerja bisa membuat banyak laporan realisasi.
     */
    public function realisasis(): HasMany
    {
        return $this->hasMany(Realisasi::class, 'id_unit_fk', 'id_unit');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'id_unit_fk', 'id_unit');
    }
}
