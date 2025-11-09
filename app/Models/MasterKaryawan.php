<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKaryawan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_lengkap',
        'nomor_ktp',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat_ktp',
        'alamat_domisili',
        'nomor_telp',
        'status_karyawan',
        'tanggal_mulai_bekerja',
        'penempatan',
        'jabatan',
        'create_by',
        'modify_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'create_by');
    }

    public function modifier()
    {
        return $this->belongsTo(User::class, 'modify_by');
    }

    public function shifts() {
        return $this->belongsToMany(Shift::class, 'shift_karyawan', 'karyawan_id', 'shift_id')->withPivot('status')->withTimestamps();
    }

    public function absensis() {
        return $this->hasMany(Absensi::class, 'karyawan_id');
    }
    
        public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

     public function pelanggarans()
    {
        return $this->hasMany(Pelanggaran::class);
    }

    public function getStatusPelanggaranAttribute()
    {
        $aktif = $this->pelanggarans()
            ->whereDate('tanggal_selesai', '>=', now())
            ->orderByDesc('tanggal_mulai')
            ->first();

        return $aktif ? $aktif->jenis : 'Tidak Ada Pelanggaran';
    }

}
