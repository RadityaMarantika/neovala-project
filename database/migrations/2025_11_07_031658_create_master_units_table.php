<?php

// database/migrations/xxxx_xx_xx_create_master_units_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('master_units', function (Blueprint $table) {
            $table->id();

            // Identitas Chanel Unit
            $table->string('jenis_koneksi'); // Owner / Marketing
            $table->string('nama_lengkap');
            $table->string('no_ktp')->unique();
            $table->string('no_telp')->unique();
            $table->text('alamat')->nullable();
            $table->string('nama_bank')->nullable();
            $table->string('no_rekening')->unique()->nullable();
            $table->string('nama_rekening')->nullable();

            // Identitas Unit
            $table->foreignId('region_id')->constrained('master_regions')->cascadeOnDelete();
            $table->string('no_unit');
            $table->string('surat_kontrak')->nullable(); // path file pdf
            $table->enum('status_sewa', ['Aktif', 'Non-Aktif'])->default('Aktif');
            $table->enum('status_kelola', ['Aktif', 'Non-Aktif'])->default('Aktif');
            $table->enum('detail_hutang', ['Aktif', 'Non-Aktif'])->default('Non-Aktif');

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('master_units');
    }
};

