<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class MasterPayroll extends Model
{
use HasFactory;


protected $table = 'master_payrolls';


protected $fillable = [
'karyawan_id',
'basic_salary',
'leader_fee',
'insentive_fee',
'nama_bank',
'nama_rekening',
'nomor_rekening',
'no_wa',
];


public function karyawan()
{
return $this->belongsTo(MasterKaryawan::class, 'karyawan_id');
}


public function pembayaran()
{
return $this->hasMany(PembayaranPayroll::class, 'payroll_id');
}
}