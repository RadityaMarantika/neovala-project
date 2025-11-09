<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterInventoriGudang extends Model
{
    use HasFactory;

    protected $fillable = [
        'gudang_id',
        'barang_id',
        'stok_aktual',
        'minimum_stok',
        'status_stok',
        'kode_rak',
        'penanggung_jawab'
    ];

    public function gudang()
    {
        return $this->belongsTo(MasterGudang::class, 'gudang_id');
    }

    public function barang()
    {
        return $this->belongsTo(MasterInventori::class, 'barang_id');
    }
        public function histories()
    {
        return $this->hasMany(InventoriGudangHistory::class, 'inventori_gudang_id');
    }

}
