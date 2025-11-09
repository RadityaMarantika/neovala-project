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
       Schema::create('lemburs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('karyawan_id'); // karyawan yang ajukan
            $table->date('tanggal_lembur');
            $table->time('durasi_jam_lembur');
            $table->time('jam_mulai_lembur');
            $table->time('jam_selesai_lembur');
            $table->text('alasan_lembur')->nullable();

            $table->enum('status_lembur', ['Request', 'Accepted', 'Rejected', 'Ongoing', 'Done'])->default('Request');

            // tracking siapa yang aksi
            $table->unsignedBigInteger('request_by')->nullable();
            $table->unsignedBigInteger('accepted_by')->nullable();
            $table->unsignedBigInteger('rejected_by')->nullable();
            $table->unsignedBigInteger('done_by')->nullable();

            $table->timestamps();

            // relasi
            $table->foreign('karyawan_id')->references('id')->on('master_karyawans')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lemburs');
    }
};
