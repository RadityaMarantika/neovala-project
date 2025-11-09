<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterInventori extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kode_rak',
        'satuan',
        'merk',
        'kategori',
        'jenis',
        
        'catatan',
        'nama_toko',
        'link_toko',
        'maps',
    ];

    public function inventoriGudang()
    {
        return $this->hasMany(MasterInventoriGudang::class, 'barang_id');
    }
}
