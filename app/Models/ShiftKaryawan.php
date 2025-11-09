<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftKaryawan extends Model
{
    use HasFactory;

    protected $table = 'shift_karyawan';

    protected $fillable = [
        'shift_id',
        'karyawan_id',
        'status',       // Bekerja / Libur / Backup
        'catatan',      // untuk menyimpan info tukar shift / catatan lainnya
    ];

    /**
     * Relasi ke tabel Shift
     */
    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }

    /**
     * Relasi ke tabel MasterKaryawan
     */
    public function karyawan()
    {
        return $this->belongsTo(MasterKaryawan::class, 'karyawan_id');
    }

    /**
     * Scope filter berdasarkan status
     * Contoh: ShiftKaryawan::bekerja()->get();
     */
    public function scopeBekerja($query)
    {
        return $query->where('status', 'Bekerja');
    }

    public function scopeLibur($query)
    {
        return $query->where('status', 'Libur');
    }

    public function scopeBackup($query)
    {
        return $query->where('status', 'Backup');
    }

    /**
     * Helper untuk format tanggal shift (dari relasi Shift)
     */
    public function getTanggalShiftAttribute()
    {
        return optional($this->shift)->jadwal_tanggal
            ? \Carbon\Carbon::parse($this->shift->jadwal_tanggal)->translatedFormat('d F Y')
            : '-';
    }

    /**
     * Helper untuk catatan tukar shift (contoh: “Deni tukar shift dengan Oky”)
     */
    public static function catatTukarShift(ShiftKaryawan $penukar, ShiftKaryawan $tujuan)
    {
        $penukarNama = optional($penukar->karyawan)->nama_lengkap ?? 'Karyawan A';
        $tujuanNama  = optional($tujuan->karyawan)->nama_lengkap ?? 'Karyawan B';

        $penukar->catatan = "{$penukarNama} tukar shift dengan {$tujuanNama}";
        $tujuan->catatan  = "{$tujuanNama} tukar shift dengan {$penukarNama}";

        $penukar->touch(); // update updated_at otomatis
        $tujuan->touch();

        $penukar->save();
        $tujuan->save();
    }

    /**
     * Helper untuk menampilkan label status dengan warna (misalnya di tabel)
     */
    public function getStatusLabelAttribute()
    {
        return match (strtolower($this->status)) {
            'bekerja' => '<span class="badge bg-success">Bekerja</span>',
            'libur' => '<span class="badge bg-secondary">Libur</span>',
            'backup' => '<span class="badge bg-warning text-dark">Backup</span>',
            default => '<span class="badge bg-light text-muted">-</span>',
        };
    }
}
