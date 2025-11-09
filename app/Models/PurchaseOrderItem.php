<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_order_id', 'inventory_id', 'qty_request', 'qty_received'
    ];

    public function po()
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id');
    }

    public function inventory()
    {
        return $this->belongsTo(MasterInventori::class, 'inventory_id');
    }

public function inventoriItem()
{
    return $this->hasOne(MasterInventoriGudang::class, 'barang_id', 'inventory_id')
        ->where('gudang_id', 1); // gudang pusat
}

}
