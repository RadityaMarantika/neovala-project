<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiPettycash extends Model
{
    use HasFactory;

    protected $fillable = [
        'pettycash_id',
        'tanggal_transaksi',
        'region',
        'jenis_transaksi',
        'metode_transaksi',
        'kategori',
        'sub_kategori',
        'keperluan',
        'nominal',
        'bukti_foto',
        'saldo_sebelum',
        'saldo_berjalan',
        'created_by'
    ];

    public function pettycash()
    {
        return $this->belongsTo(MasterPettycash::class, 'pettycash_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
