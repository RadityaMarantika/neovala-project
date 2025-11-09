<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('inventori_gudang_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inventori_gudang_id');
            $table->integer('stok_lama')->nullable();
            $table->integer('stok_baru')->nullable();
            $table->string('keterangan')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('inventori_gudang_id')->references('id')->on('master_inventori_gudangs')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventori_gudang_histories');
    }
};
