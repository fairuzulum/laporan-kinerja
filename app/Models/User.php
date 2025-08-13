<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_photo',
        'id_unit_fk',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class, 'id_unit_fk', 'id_unit');
    }

    // Di dalam class User
    public function evaluasiLaporans()
    {
        return $this->hasMany(EvaluasiLaporan::class, 'id_user_fk');
    }
}
