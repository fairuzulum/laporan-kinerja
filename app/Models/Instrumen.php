<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Instrumen extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara eksplisit
    protected $table = 'instrumens';

    // Menentukan primary key secara eksplisit
    protected $primaryKey = 'id_instrumen';

    // Izinkan semua field untuk diisi secara massal (mass assignable)
    protected $guarded = [];

    /**
     * Mendefinisikan relasi one-to-many ke PohonKinerja.
     * Satu Instrumen memiliki banyak Pohon Kinerja.
     */
    public function pohonKinerjas(): HasMany
    {
        return $this->hasMany(PohonKinerja::class, 'id_instrumen_fk', 'id_instrumen');
    }
}