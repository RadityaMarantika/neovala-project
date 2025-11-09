<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('master_gudangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_gudang');
            $table->enum('region', ['Transpark Juanda', 'Ayam Keshwari', 'Lainnya'])->default('Lainnya');
            $table->string('kepala_gudang')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('master_gudangs');
    }
};
