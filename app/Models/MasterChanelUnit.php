<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterChanelUnit extends Model
{
    protected $fillable = [
        'nama_lengkap',
        'no_nik',
        'no_telp',
        'alamat',
        'foto_ktp',
        'jenis_koneksi',
        'nama_bank',
        'bank_rek',
    ];

    public function units()
    {
        return $this->hasMany(MasterUnit::class, 'channel_id');
    }
}
