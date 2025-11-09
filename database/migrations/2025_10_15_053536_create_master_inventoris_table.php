<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('master_inventoris', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang')->unique();
            $table->string('nama_barang');
            $table->string('kode_rak')->nullable();
            $table->enum('satuan', ['pcs', 'kg', 'liter', 'pack', 'unit'])->default('pcs');
            $table->string('merk')->nullable();
            $table->enum('kategori', [
                'Amenitis',
                'Perkakas Rumah Tangga',
                'Elektronik',
                'Perlengkapan Dapur',
                'Perlengkapan Makan'
            ])->default('Amenitis');
            $table->enum('jenis', ['Barang Habis Pakai', 'Barang Tidak Habis Pakai'])->default('Barang Habis Pakai');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('master_inventoris');
    }
};
