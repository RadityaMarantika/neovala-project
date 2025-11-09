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
        Schema::create('koperasi_tabungan_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('koperasi_account_id')->constrained('koperasi_accounts')->cascadeOnDelete();
            $table->date('tanggal_input');
            $table->decimal('jumlah', 15, 2);
            $table->string('upload_bukti')->nullable();
            $table->enum('status', ['request', 'approved', 'rejected'])->default('request');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->decimal('saldo_after', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('koperasi_tabungan_transactions');
    }
};
