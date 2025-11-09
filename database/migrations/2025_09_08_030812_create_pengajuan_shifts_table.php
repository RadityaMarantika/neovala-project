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
        Schema::create('pengajuan_shifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')->constrained('master_karyawans')->onDelete('cascade');
            $table->foreignId('shift_id')->constrained('shifts')->onDelete('cascade');
            $table->foreignId('pengajuan_by')->constrained('users')->onDelete('cascade');
            $table->enum('jenis_pengajuan', ['izin', 'backup', 'sakit']);
            $table->date('tanggal');
            $table->text('keterangan')->nullable();
            $table->string('foto')->nullable(); // simpan path file
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('approve_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('reject_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_shifts');
    }
};
