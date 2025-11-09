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
        Schema::create('koperasi_pinjaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('koperasi_account_id')->constrained('koperasi_accounts')->cascadeOnDelete();
            $table->date('tanggal_pengajuan');
            $table->decimal('jumlah_pinjam', 15, 2);
            $table->text('alasan');
            $table->string('upload_bukti')->nullable();
            $table->enum('status', ['request', 'approved', 'rejected', 'on_progress', 'lunas'])->default('request');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->integer('jumlah_cicilan');
            $table->decimal('nominal_per_cicilan', 15, 2)->nullable();
            $table->date('jatuh_tempo')->nullable(); // bisa dipakai untuk jatuh tempo terakhir
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('koperasi_pinjaman');
    }
};
