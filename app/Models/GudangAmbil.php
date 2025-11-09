<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GudangAmbil extends Model
{
    protected $fillable = [
        'gudang_asal',
        'gudang_tujuan',
        'user_id'
    ];

    public function items()
{
    return $this->hasMany(GudangAmbilItem::class, 'transfer_id');
}

public function gudangTujuan()
{
    return $this->belongsTo(MasterGudang::class, 'gudang_tujuan');
}

}


