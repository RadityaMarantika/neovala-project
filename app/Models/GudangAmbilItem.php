<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GudangAmbilItem extends Model
{
    protected $fillable = [
        'transfer_id',
        'barang_id',
        'qty_transfer',
    ];

    public function transfer()
{
    return $this->belongsTo(GudangAmbil::class, 'transfer_id');
}


    public function barang()
    {
        return $this->belongsTo(MasterInventori::class, 'barang_id');
    }
}

