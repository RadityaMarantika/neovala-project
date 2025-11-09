<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterPettycash extends Model
{
    use HasFactory;
    protected $table = 'master_pettycashes'; 

    protected $fillable = [
        'nama_pettycash',
        'dikelola_oleh_id',
        'saldo_awal',
        'saldo_berjalan',
    ];

    public function transaksi()
    {
        return $this->hasMany(TransaksiPettycash::class, 'pettycash_id');
    }
    public function karyawan()
{
    return $this->belongsTo(MasterKaryawan::class, 'dikelola_oleh_id');
}

}
