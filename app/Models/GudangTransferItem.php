<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GudangTransferItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'gudang_transfer_id',
        'barang_id',
        'jumlah',
    ];

    public function transfer()
    {
        return $this->belongsTo(GudangTransfer::class, 'gudang_transfer_id');
    }

    public function barang()
    {
        return $this->belongsTo(MasterInventori::class, 'barang_id');
    }
}
