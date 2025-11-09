<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanShift extends Model
{
    protected $fillable = [
        'karyawan_id', 'shift_id', 'pengajuan_by','approve_by','reject_by',
        'jenis_pengajuan', 'tanggal', 'keterangan', 'foto','foto_bukti', 'status'
    ];

    public function karyawan()
    {
        return $this->belongsTo(MasterKaryawan::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

   
    // Ganti pengajuan() jadi user() biar lebih natural
    public function user()
    {
        return $this->belongsTo(User::class, 'pengajuan_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approve_by');
    }

    public function rejectedBy()
    {
        return $this->belongsTo(User::class, 'reject_by');
    }
}
