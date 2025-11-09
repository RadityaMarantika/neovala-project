<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('master_chanel_units', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('no_nik');
            $table->string('no_telp');
            $table->text('alamat')->nullable();
            $table->string('foto_ktp')->nullable();
            $table->enum('jenis_koneksi', ['Marketing', 'Owner Unit', 'Tenant Relation']);
            $table->string('nama_bank')->nullable();
            $table->string('bank_rek')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_chanel_units');
    }
};
