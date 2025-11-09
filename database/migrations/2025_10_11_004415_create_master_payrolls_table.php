<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
Schema::create('master_payrolls', function (Blueprint $table) {
$table->id();
$table->unsignedBigInteger('karyawan_id')->index();
$table->bigInteger('basic_salary')->default(0);
$table->bigInteger('leader_fee')->default(0);
$table->bigInteger('insentive_fee')->default(0);
$table->string('nama_bank')->nullable();
$table->string('nama_rekening')->nullable();
$table->string('nomor_rekening')->nullable();
$table->string('no_wa')->nullable();
$table->timestamps();


// assuming karyawans table exists
// $table->foreign('karyawan_id')->references('id')->on('karyawans')->onDelete('cascade');
});
}


public function down()
{
Schema::dropIfExists('master_payrolls');
}
};
