<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Realisasi extends Model
{
    use HasFactory;

    // Laravel akan otomatis mengasumsikan nama tabel 'realisasis'
    // jadi kita tidak perlu definisikan secara eksplisit.

    protected $primaryKey = 'id_realisasi';
    protected $guarded = [];

    /**
     * Relasi ke PohonKinerja.
     * Satu laporan Realisasi pasti mengacu pada satu Indikator Kinerja.
     */
    public function pohonKinerja(): BelongsTo
    {
        return $this->belongsTo(PohonKinerja::class, 'id_pk_fk', 'id_pk');
    }

    /**
     * Relasi ke UnitKerja.
     * Satu laporan Realisasi pasti dibuat oleh satu Unit Kerja.
     */
    public function unitKerja(): BelongsTo
    {
        return $this->belongsTo(UnitKerja::class, 'id_unit_fk', 'id_unit');
    }

    // Di dalam class Realisasi
    public function evaluasiLaporans()
    {
        return $this->hasMany(EvaluasiLaporan::class, 'id_realisasi_fk');
    }
}
