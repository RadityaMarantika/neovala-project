<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KoperasiTabunganTransaction extends Model
{
   protected $fillable = ['karyawan_id','koperasi_account_id','tanggal_input','jumlah','upload_bukti','status','approved_by','saldo_after'];

    public function account() {
        return $this->belongsTo(KoperasiAccount::class, 'koperasi_account_id');
    }

    

    public function approvedBy() {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
