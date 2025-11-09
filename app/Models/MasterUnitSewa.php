<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterUnitSewa extends Model
{
    protected $fillable = [
        'periode_sewa', 'jenis_tempo', 'unit_id', 'jenis_ipl', 'jenis_utl', 'jenis_wifi',
        'pengambilan_kunci', 'bayar_unit', 'biaya_unit', 'tanggal_unit',
        'bayar_utl', 'biaya_utl', 'tanggal_utl',
        'bayar_ipl', 'biaya_ipl', 'tanggal_ipl',
        'bayar_wifi', 'provider_wifi', 'biaya_wifi', 'tanggal_wifi',
    ];

    public function unit()
    {
        return $this->belongsTo(MasterUnit::class, 'unit_id');
    }

    public function hutang()
    {
        return $this->hasOne(MasterUnitHutang::class, 'sewa_id');
    }
}
