<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterGudang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_gudang',
        'region',
        'kepala_gudang',
    ];

    public function inventoriGudang()
    {
        return $this->hasMany(MasterInventoriGudang::class, 'gudang_id');
    }
}
