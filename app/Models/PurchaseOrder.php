<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_po', 'user_id', 'gudang_id', 'tanggal_po', 'status',
        'tanggal_pembelian', 'bukti_pembelian',
        'tanggal_diterima', 'bukti_sampai'
    ];

    protected $casts = [
        'tanggal_po' => 'datetime',
        'tanggal_pembelian' => 'datetime',
        'tanggal_diterima' => 'datetime',
    ];

    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

