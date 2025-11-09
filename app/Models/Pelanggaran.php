<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pelanggaran extends Model
{
    use HasFactory;

    protected $fillable = [
            'karyawan_id',
            'jenis',
            'tanggal_mulai',
            'tanggal_selesai',
            'keterangan',
            'file_surat',
            'status_pelanggaran',
            'created_by',
            'modify_by',
    ];


    protected $casts = [
        'tanggal_mulai'   => 'date',
        'tanggal_selesai' => 'date',
    ];

    

    public function getStatusPelanggaranAttribute()
    {
        if ($this->tanggal_selesai && Carbon::now()->gt(Carbon::parse($this->tanggal_selesai))) {
            return 'Tidak Aktif';
        }
        return 'Aktif';
    }

    // Relasi ke jadwal shift
    public function shifts()
    {
        return $this->hasMany(Shift::class);
    }

    public function karyawan()
    {
        return $this->belongsTo(MasterKaryawan::class, 'karyawan_id');
    }

}
