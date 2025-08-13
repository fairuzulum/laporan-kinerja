<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EvaluasiLaporan extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_evaluasi';
    protected $guarded = [];

    public function realisasi(): BelongsTo {
        return $this->belongsTo(Realisasi::class, 'id_realisasi_fk');
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'id_user_fk');
    }
}