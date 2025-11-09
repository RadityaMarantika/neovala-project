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
        Schema::create('pelanggaran', function (Blueprint $table) {
           $table->id();

            // relasi ke master_karyawan
            $table->foreignId('karyawan_id')
                ->constrained('master_karyawans')
                ->onDelete('cascade');

            // jenis surat peringatan
            $table->enum('jenis', ['Surat Teguran', 'SP1', 'SP2', 'SP3']);

            // periode pelanggaran
            $table->date('tanggal_mulai');   // tanggal kena pelanggaran
            $table->date('tanggal_selesai'); // otomatis +30 hari

            // keterangan tambahan
            $table->text('keterangan')->nullable();

            // upload surat
            $table->string('file_surat')->nullable();

            // track siapa yang create / update
            $table->foreignId('created_by')
                ->constrained('users')
                ->onDelete('cascade');
            $table->foreignId('modified_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggaran');
    }
};
