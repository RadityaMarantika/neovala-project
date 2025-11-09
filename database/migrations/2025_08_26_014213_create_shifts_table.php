<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->enum('lokasi', ['Ayam Bakar', 'Transpark Juanda']);
            $table->string('kode_shift')->unique();
            $table->enum('jenis', ['Pagi', 'Siang', 'Malam']);
            $table->unsignedTinyInteger('jam_kerja'); // total jam (8, 12, etc)
            $table->time('jam_masuk_kerja');
            $table->time('jam_pulang_kerja');
            $table->date('jadwal_tanggal');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('shifts');
    }
};
