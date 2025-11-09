<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('master_units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('channel_id')->constrained('master_chanel_units')->onDelete('cascade');
            $table->foreignId('region_id')->constrained('master_regions')->onDelete('cascade');
            $table->string('nama_tower');
            $table->string('no_unit');
            $table->enum('status_sewa', ['Available', 'Unavailable', 'During Rental Period'])->default('Available');
            $table->enum('status_kelola', ['Active', 'Not Active'])->default('Active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_units');
    }
};
