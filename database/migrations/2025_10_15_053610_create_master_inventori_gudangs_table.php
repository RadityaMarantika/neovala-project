<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('master_inventori_gudangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gudang_id')->constrained('master_gudangs')->onDelete('cascade');
            $table->foreignId('barang_id')->constrained('master_inventoris')->onDelete('cascade');
            $table->integer('stok_aktual')->default(0);
            $table->integer('minimum_stok')->default(0);
            $table->enum('status_stok', ['Habis', 'Perlu Purchase', 'Tersedia Cukup'])->default('Tersedia Cukup');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('master_inventori_gudangs');
    }
};
