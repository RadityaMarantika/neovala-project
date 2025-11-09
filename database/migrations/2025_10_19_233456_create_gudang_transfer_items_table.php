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
       Schema::create('gudang_transfer_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gudang_transfer_id')->constrained('gudang_transfers')->onDelete('cascade');
            $table->foreignId('barang_id')->constrained('master_inventoris')->onDelete('cascade');
            $table->integer('jumlah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gudang_transfer_items');
    }
};
