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
        Schema::create('master_karyawans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('nomor_ktp')->unique();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->text('alamat_ktp');
            $table->text('alamat_domisili')->nullable();
            $table->string('nomor_telp')->nullable();
            $table->enum('status_karyawan', ['Aktif', 'Tidak Aktif'])->default('Aktif');
            $table->date('tanggal_mulai_bekerja');
            $table->enum('penempatan', ['Ayam Bakar', 'Transpark Juanda']);
            $table->enum('jabatan', [
                'Staff Housekeeping',
                'Staff Finance',
                'Staff Kitchen',
                'Staff Admin',
                'Staff IT'
            ]);
            $table->enum('posisi', [
                'PIC Staff Housekeeping',
                'Junior Staff Housekeeping',
                'Senior Staff Housekeeping',
                'Akuntan',
                'Analis Keuangan',
                'PIC Staff Kitchen',
                'Cook Helper',
                'Chef',
                'Steward'
            ]);
            $table->unsignedBigInteger('create_by');
            $table->unsignedBigInteger('modify_by')->nullable();
            $table->timestamps();

            $table->foreign('create_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('modify_by')->references('id')->on('users')->onDelete('set null');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_karyawans');
    }
};
