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
         Schema::create('koperasi_pinjaman_installments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('koperasi_pinjaman_id')->constrained('koperasi_pinjaman')->cascadeOnDelete();
            $table->string('periode'); // contoh: "Sep 2025"
            $table->date('jatuh_tempo');
            $table->decimal('jumlah_cicilan', 15, 2);
            $table->enum('status', ['pending', 'paid'])->default('pending');
            $table->date('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('koperasi_pinjaman_installments');
    }
};
