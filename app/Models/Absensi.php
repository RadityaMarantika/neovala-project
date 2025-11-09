<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absensi extends Model
{
    protected $fillable = [
        'karyawan_id','shift_id',
        'waktu_masuk','menit_telat_masuk','foto_selfi_masuk','share_live_location_masuk','status_absen_masuk','file_form_masuk','masuk_by','modifyMasuk_by',
        'waktu_pulang','menit_telat_pulang','foto_selfi_pulang','share_live_location_pulang','status_absen_pulang','file_form_pulang','pulang_by','modifyPulang_by',
    ];

    protected $casts = [
        'waktu_masuk' => 'datetime',
        'waktu_pulang' => 'datetime',
    ];

    public function karyawan(): BelongsTo {
        return $this->belongsTo(MasterKaryawan::class, 'karyawan_id');
    }

    public function shift(): BelongsTo {
        return $this->belongsTo(Shift::class);
    }
}
