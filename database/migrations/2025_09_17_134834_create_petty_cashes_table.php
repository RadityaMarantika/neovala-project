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
       Schema::create('petty_cashes', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->enum('jenis', ['masuk', 'keluar']);
            $table->string('kategori');
            $table->string('subkategori');
            $table->unsignedBigInteger('create_by'); // user yang input
            $table->unsignedBigInteger('diambil_oleh')->nullable(); // karyawan yang ambil (optional kalau "masuk")
            $table->decimal('jumlah', 15, 2);
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('create_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('diambil_oleh')->references('id')->on('master_karyawans')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('petty_cashes');
    }
};
