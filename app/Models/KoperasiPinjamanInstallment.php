<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KoperasiPinjamanInstallment extends Model
{
     protected $fillable = ['koperasi_pinjaman_id','periode','jatuh_tempo','jumlah_cicilan','status','paid_at'];

    public function pinjaman() {
        return $this->belongsTo(KoperasiPinjaman::class, 'koperasi_pinjaman_id');
    }
}
