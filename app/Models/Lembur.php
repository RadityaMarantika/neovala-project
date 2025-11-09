<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lembur extends Model
{
    use HasFactory;

    protected $fillable = [
        'karyawan_id',
        'tanggal_lembur',
        'durasi_jam_lembur',
        'jam_mulai_lembur',
        'jam_selesai_lembur',
        'alasan_lembur',
        'status_lembur',
        'request_by',
        'accepted_by',
        'rejected_by',
        'done_by',
    ];

    public function karyawan()
    {
        return $this->belongsTo(MasterKaryawan::class, 'karyawan_id');
    }
}
