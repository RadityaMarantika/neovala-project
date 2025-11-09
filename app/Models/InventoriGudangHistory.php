<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoriGudangHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventori_gudang_id',
        'stok_lama',
        'stok_baru',
        'keterangan',
        'updated_by',
    ];

    public function inventoriGudang()
    {
        return $this->belongsTo(MasterInventoriGudang::class, 'inventori_gudang_id');
    }
}
