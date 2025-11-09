<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KoperasiAccount extends Model
{
    
    protected $fillable = ['kode_koperasi', 'jenis', 'karyawan_id', 'tanggal_buat', 'dibuat_oleh'];

    public function karyawan() {
        return $this->belongsTo(MasterKaryawan::class, 'karyawan_id');
    }

    public function tabunganTransactions() {
        return $this->hasMany(KoperasiTabunganTransaction::class);
    }

    public function pinjaman() {
        return $this->hasOne(KoperasiPinjaman::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }
}
