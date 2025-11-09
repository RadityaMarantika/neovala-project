<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('master_pettycashs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pettycash');
            $table->string('dikelola_oleh');
            $table->decimal('saldo_awal', 15, 2)->default(0);
            $table->decimal('saldo_berjalan', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_pettycashs');
    }
};
