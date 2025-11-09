<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GudangTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_transfer',
        'gudang_asal_id',
        'gudang_tujuan_id',
        'tanggal_transfer',
        'keterangan',
        'created_by',
    ];

    public function items()
    {
        return $this->hasMany(GudangTransferItem::class);
    }

    public function gudangAsal()
    {
        return $this->belongsTo(MasterGudang::class, 'gudang_asal_id');
    }

    public function gudangTujuan()
    {
        return $this->belongsTo(MasterGudang::class, 'gudang_tujuan_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
