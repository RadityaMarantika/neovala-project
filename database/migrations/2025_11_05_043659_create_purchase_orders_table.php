<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('kode_po')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('gudang_id')->default(1); // hanya gudang pusat
            $table->date('tanggal_po')->nullable();
            $table->enum('status', ['Pending', 'Approved', 'Ongoing', 'Receive'])->default('Pending');
            
            // data pembelian
            $table->date('tanggal_pembelian')->nullable();
            $table->string('bukti_pembelian')->nullable();

            // data penerimaan
            $table->date('tanggal_diterima')->nullable();
            $table->string('bukti_sampai')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};

