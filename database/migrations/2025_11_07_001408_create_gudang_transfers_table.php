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
    Schema::create('gudang_ambils', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('gudang_asal')->default(1); // pusat
        $table->unsignedBigInteger('gudang_tujuan');
        $table->unsignedBigInteger('user_id');
        $table->timestamps();

        $table->foreign('gudang_asal')->references('id')->on('master_gudangs')->onDelete('cascade');
        $table->foreign('gudang_tujuan')->references('id')->on('master_gudangs')->onDelete('cascade');
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gudang_ambils');
    }
};
