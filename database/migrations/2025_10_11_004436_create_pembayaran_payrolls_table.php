<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pembayaran_payrolls', function (Blueprint $table) {
$table->id();
$table->unsignedBigInteger('payroll_id')->index(); // master_payrolls.id
$table->date('tanggal_pembayaran');


// snapshot from master
$table->bigInteger('basic_salary')->default(0);
$table->bigInteger('leader_fee')->default(0);
$table->bigInteger('insentive_fee')->default(0);


$table->string('nama_bank')->nullable();
$table->string('nama_rekening')->nullable();
$table->string('nomor_rekening')->nullable();


$table->bigInteger('ph_allowance')->default(0);
$table->bigInteger('other_allowance')->default(0);
$table->bigInteger('total_earning')->default(0);


$table->bigInteger('loan_repayment')->default(0);
$table->bigInteger('remaining_loan')->default(0);
$table->bigInteger('penalties')->default(0);


$table->bigInteger('total_deduction')->default(0);
$table->bigInteger('take_home_pay')->default(0);


$table->unsignedBigInteger('created_by')->nullable();
$table->unsignedBigInteger('approved_by')->nullable();


$table->enum('status_payroll', ['Pending','Approve','Done'])->default('Pending');
$table->string('bukti_transfer')->nullable();


$table->timestamps();


// foreign key relation (optional)
// $table->foreign('payroll_id')->references('id')->on('master_payrolls')->onDelete('cascade');
});
}


public function down()
{
Schema::dropIfExists('pembayaran_payrolls');
}
};
