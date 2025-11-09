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
        Schema::create('koperasi_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('kode_koperasi')->unique();
            $table->enum('jenis', ['tabungan', 'pinjaman']);
            $table->foreignId('karyawan_id')->constrained('master_karyawans');
            $table->date('tanggal_buat');
            $table->foreignId('dibuat_oleh')->constrained('users');
            $table->timestamps();

            $table->unique(['karyawan_id', 'jenis']); // satu karyawan hanya boleh punya 1 tabungan + 1 pinjaman
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('koperasi_accounts');
    }
};
