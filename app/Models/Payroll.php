<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'karyawan_id', 'working_area', 'job_position', 'department',
        'basic_salary', 'overtime_pay', 'ph_allowances', 'leader_fee',
        'incentive_fee', 'other_allowances', 'total_earnings',
        'total_loan', 'loan_repayment', 'remaining_loan', 'penalties',
        'outstanding_cash', 'total_deductions', 'descriptions',
        'take_home_pay', 'payment_date', 'bank_name', 'account_bank_name',
        'account_number', 'prepared_by', 'approved_by',
    ];

    public function karyawan()
    {
        return $this->belongsTo(MasterKaryawan::class);
    }
}
