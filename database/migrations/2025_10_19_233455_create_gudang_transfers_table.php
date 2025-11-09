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
        Schema::create('gudang_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transfer')->unique();
            $table->foreignId('gudang_asal_id')->constrained('master_gudangs')->onDelete('cascade');
            $table->foreignId('gudang_tujuan_id')->constrained('master_gudangs')->onDelete('cascade');
            $table->date('tanggal_transfer');
            $table->text('keterangan')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gudang_transfers');
    }
};
