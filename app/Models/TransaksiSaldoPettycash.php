<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiSaldoPettycash extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'jenis_transaksi',
        'pettycash_asal_id',
        'pettycash_tujuan_id',
        'nominal',
        'keterangan',
        'dibuat_oleh',
        'bukti_transfer'
    ];

    public function asal()
    {
        return $this->belongsTo(MasterPettycash::class, 'pettycash_asal_id');
    }

    public function tujuan()
    {
        return $this->belongsTo(MasterPettycash::class, 'pettycash_tujuan_id');
    }

}
