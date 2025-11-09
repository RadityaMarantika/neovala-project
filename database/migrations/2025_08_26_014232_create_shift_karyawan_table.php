<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('shift_karyawan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shift_id')->constrained('shifts')->cascadeOnDelete();
            $table->foreignId('karyawan_id')->constrained('master_karyawans')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['shift_id','karyawan_id']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('shift_karyawan');
    }
};
