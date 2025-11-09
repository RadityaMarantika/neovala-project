<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterUnit extends Model
{
    protected $fillable = [
        'jenis_koneksi', 'nama_lengkap', 'no_ktp', 'no_telp', 'alamat',
        'nama_bank', 'no_rekening', 'nama_rekening',
        'region_id', 'no_unit', 'surat_kontrak',
        'status_sewa', 'status_kelola', 'detail_hutang',
    ];

    public function sewas()
    {
        return $this->hasMany(MasterUnitSewa::class, 'unit_id');
    }
}
