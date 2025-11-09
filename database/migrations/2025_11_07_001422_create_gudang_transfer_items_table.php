<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('gudang_ambil_items', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('transfer_id');
        $table->unsignedBigInteger('barang_id');
        $table->integer('qty_transfer');
        $table->timestamps();

        $table->foreign('transfer_id')->references('id')->on('gudang_transfers')->onDelete('cascade');
        $table->foreign('barang_id')->references('id')->on('master_inventoris')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gudang_ambil_items');
    }
};
