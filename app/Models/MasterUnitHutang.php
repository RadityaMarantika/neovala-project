<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterUnitHutang extends Model
{
    protected $fillable = [
        'sewa_id',
        'tempo_unit', 'pay_unit', 'pembayaran_unit',
        'tempo_utl', 'pay_utl', 'pembayaran_utl',
        'tempo_ipl', 'pay_ipl', 'pembayaran_ipl',
        'tempo_wifi', 'pay_wifi', 'pembayaran_wifi',
    ];

    public function sewa()
    {
        return $this->belongsTo(MasterUnitSewa::class, 'sewa_id');
    }
}
