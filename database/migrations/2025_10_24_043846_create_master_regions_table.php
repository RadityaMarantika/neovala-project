<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('master_regions', function (Blueprint $table) {
            $table->id();
            $table->string('kode_region')->unique();
            $table->string('nama_apart');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_regions');
    }
};
