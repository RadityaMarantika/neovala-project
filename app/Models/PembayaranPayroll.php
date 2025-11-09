<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PembayaranPayroll extends Model
{
use HasFactory;


protected $table = 'pembayaran_payrolls';


protected $fillable = [
'payroll_id', 'tanggal_pembayaran',
'basic_salary','leader_fee','insentive_fee',
'nama_bank','nama_rekening','nomor_rekening',
'ph_allowance','other_allowance','total_earning',
'loan_repayment','remaining_loan','penalties','total_deduction','take_home_pay',
'created_by','approved_by','status_payroll','bukti_transfer'
];


public function master()
{
return $this->belongsTo(MasterPayroll::class, 'payroll_id');
}
}