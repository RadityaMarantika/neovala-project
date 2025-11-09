<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KoperasiPinjaman extends Model
{
     protected $table = 'koperasi_pinjaman';
    protected $fillable = ['koperasi_account_id','tanggal_pengajuan','jumlah_pinjam','alasan','upload_bukti','status','approved_by','jumlah_cicilan','nominal_per_cicilan','jatuh_tempo'];

    public function account() {
        return $this->belongsTo(KoperasiAccount::class, 'koperasi_account_id');
    }

    public function installments() {
        return $this->hasMany(KoperasiPinjamanInstallment::class);
    }
}
