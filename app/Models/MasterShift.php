<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterShift extends Model
{
    use HasFactory;

    protected $fillable = [
        'buat_kode_shift',
        'jam_masuk',
        'jam_pulang',
    ];

    // Relasi ke jadwal shift
    public function shifts()
    {
        return $this->hasMany(Shift::class);
    }
}
