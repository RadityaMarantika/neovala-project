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
       Schema::create('pelanggarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')->constrained()->onDelete('cascade');
            $table->enum('jenis', ['Surat Teguran', 'SP1', 'SP2', 'SP3']);
            $table->date('tanggal_mulai'); // tanggal kena pelanggaran
            $table->date('tanggal_selesai'); // otomatis +30 hari
            $table->text('keterangan')->nullable();
            $table->string('file_surat')->nullable(); // upload surat
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggarans');
    }
};
