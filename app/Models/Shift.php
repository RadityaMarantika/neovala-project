<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shift extends Model
{
    protected $fillable = [
        'lokasi','kode_shift','jam_kerja',
        'jam_masuk_kerja','jam_pulang_kerja','jadwal_tanggal'
    ];

    protected $casts = [
        'jadwal_tanggal' => 'date',
    ];

    public function karyawans(): BelongsToMany {
        return $this->belongsToMany(MasterKaryawan::class, 'shift_karyawan', 'shift_id', 'karyawan_id')->withPivot('id','status')->withTimestamps();
    }

    public function absensis(): HasMany {
        return $this->hasMany(Absensi::class);
    }

}
