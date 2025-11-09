<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('master_pettycashes', function (Blueprint $table) {
            // Tambahkan kolom baru nullable
            $table->unsignedBigInteger('dikelola_oleh_id')->nullable()->after('nama_pettycash');

            // Buat foreign key ke master_karyawans
            $table->foreign('dikelola_oleh_id')
                  ->references('id')
                  ->on('master_karyawans')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('master_pettycashes', function (Blueprint $table) {
            // Drop foreign key dan kolom saat rollback
            $table->dropForeign(['dikelola_oleh_id']);
            $table->dropColumn('dikelola_oleh_id');
        });
    }
};
