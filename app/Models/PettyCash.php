<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PettyCash extends Model
{
    protected $fillable = [
        'tanggal', 'jenis', 'kategori', 'subkategori',
        'create_by', 'diambil_oleh', 'jumlah', 'keterangan', 'saldo', 'upload_bukti'
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'create_by');
    }

    public function karyawan()
    {
        return $this->belongsTo(MasterKaryawan::class, 'diambil_oleh');
    }
}
