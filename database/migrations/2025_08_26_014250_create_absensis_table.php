<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();

            $table->foreignId('karyawan_id')->constrained('master_karyawans')->cascadeOnDelete();
            $table->foreignId('shift_id')->constrained('shifts')->cascadeOnDelete();

            // Masuk
            $table->dateTime('waktu_masuk')->nullable();
            $table->unsignedInteger('menit_telat_masuk')->default(0);
            $table->string('foto_selfi_masuk')->nullable();
            $table->text('share_live_location_masuk')->nullable();
            $table->enum('status_absen_masuk', ['Masuk','Telat','Alfa','Izin','Backup','Libur'])->nullable();
            $table->string('file_form_masuk')->nullable();
            $table->foreignId('masuk_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('modifyMasuk_by')->nullable()->constrained('users')->nullOnDelete();

            // Pulang
            $table->dateTime('waktu_pulang')->nullable();
            $table->unsignedInteger('menit_telat_pulang')->default(0);
            $table->string('foto_selfi_pulang')->nullable();
            $table->text('share_live_location_pulang')->nullable();
            $table->enum('status_absen_pulang', ['Tepat Waktu','Telat','Tidak Absen Pulang','Izin','Backup'])->nullable();
            $table->string('file_form_pulang')->nullable();
            $table->foreignId('pulang_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('modifyPulang_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            // 1 karyawan 1 shift 1 record (harian)
            $table->unique(['karyawan_id','shift_id']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('absensis');
    }
};
