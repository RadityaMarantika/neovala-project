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
        Schema::create('transaksi_saldo_pettycashes', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->default(now());
            $table->enum('jenis_transaksi', ['topup', 'transfer']);
            $table->foreignId('pettycash_asal_id')->nullable()->constrained('master_pettycashes')->nullOnDelete();
            $table->foreignId('pettycash_tujuan_id')->constrained('master_pettycashes')->cascadeOnDelete();
            $table->decimal('nominal', 15, 2);
            $table->text('keterangan')->nullable();
            $table->foreignId('dibuat_oleh')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_saldo_pettycashes');
    }
};
