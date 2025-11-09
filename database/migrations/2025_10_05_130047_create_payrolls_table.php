<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')->constrained('master_karyawans')->onDelete('cascade');
            $table->string('working_area')->nullable();
            $table->string('job_position')->nullable();

            // Earnings
            $table->decimal('basic_salary', 15, 2)->default(0);
            $table->decimal('overtime_pay', 15, 2)->default(0);
            $table->decimal('ph_allowances', 15, 2)->default(0);
            $table->decimal('leader_fee', 15, 2)->default(0);
            $table->decimal('incentive_fee', 15, 2)->default(0);
            $table->decimal('other_allowances', 15, 2)->default(0);
            $table->decimal('total_earnings', 15, 2)->default(0);

            // Deductions
            $table->decimal('total_loan', 15, 2)->default(0);
            $table->decimal('loan_repayment', 15, 2)->default(0);
            $table->decimal('remaining_loan', 15, 2)->default(0);
            $table->decimal('penalties', 15, 2)->default(0);
            $table->decimal('outstanding_cash', 15, 2)->default(0);
            $table->decimal('total_deductions', 15, 2)->default(0);

            $table->text('descriptions')->nullable();
            $table->decimal('take_home_pay', 15, 2)->default(0);

            // Bank info
            $table->date('payment_date')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_bank_name')->nullable();
            $table->string('account_number')->nullable();

            // Info
            $table->string('prepared_by')->nullable();
            $table->string('approved_by')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
