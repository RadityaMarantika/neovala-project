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
       Schema::create('master_shifts', function (Blueprint $table) {
            $table->id();
            $table->string('kode_shift')->unique(); // PG08, SI14, ML22
            $table->time('jam_masuk');
            $table->time('jam_pulang');
            $table->enum('jenis_shift', ['Pagi','Siang','Malam']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_shifts');
    }
};
