<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterAgen extends Model
{
    protected $fillable = [
        'nama_lengkap', 'no_nik', 'no_telp', 'alamat', 'foto_ktp',
        'nama_bank', 'bank_rek'
    ];
}
