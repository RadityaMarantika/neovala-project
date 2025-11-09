<?php

// database/migrations/xxxx_xx_xx_create_master_unit_sewas_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('master_unit_sewas', function (Blueprint $table) {
            $table->id();

            // Data Sewa
            $table->enum('periode_sewa', ['3 bulan', '6 bulan', '12 bulan']);
            $table->enum('jenis_tempo', ['monthly', 'quarterly', 'semi-annually', 'annually']);
            $table->foreignId('unit_id')->constrained('master_units')->cascadeOnDelete();

            $table->enum('jenis_ipl', ['Include', 'Exclude']);
            $table->enum('jenis_utl', ['Include', 'Exclude']);
            $table->enum('jenis_wifi', ['Include', 'Exclude']);
            $table->date('pengambilan_kunci')->nullable();

            // Detail Biaya Unit
            $table->enum('bayar_unit', ['Owner', 'Marketing'])->nullable();
            $table->bigInteger('biaya_unit')->nullable();
            $table->integer('tanggal_unit')->nullable();

            // Detail Biaya UTL
            $table->enum('bayar_utl', ['Owner', 'Marketing'])->nullable();
            $table->bigInteger('biaya_utl')->nullable();
            $table->integer('tanggal_utl')->nullable();

            // Detail Biaya IPL
            $table->enum('bayar_ipl', ['Owner', 'Marketing'])->nullable();
            $table->bigInteger('biaya_ipl')->nullable();
            $table->integer('tanggal_ipl')->nullable();

            // Detail Biaya Wifi
            $table->enum('bayar_wifi', ['Owner', 'Marketing'])->nullable();
            $table->string('provider_wifi')->nullable();
            $table->bigInteger('biaya_wifi')->nullable();
            $table->integer('tanggal_wifi')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('master_unit_sewas');
    }
};
