<?php

// database/migrations/xxxx_xx_xx_create_master_unit_hutangs_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('master_unit_hutangs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('sewa_id')->constrained('master_unit_sewas')->cascadeOnDelete();

            // Tagihan Unit
            $table->date('tempo_unit')->nullable();
            $table->enum('pay_unit', ['Paid', 'Unpaid'])->default('Unpaid');
            $table->bigInteger('pembayaran_unit')->nullable();

            // Tagihan UTL
            $table->date('tempo_utl')->nullable();
            $table->enum('pay_utl', ['Paid', 'Unpaid'])->default('Unpaid');
            $table->bigInteger('pembayaran_utl')->nullable();

            // Tagihan IPL
            $table->date('tempo_ipl')->nullable();
            $table->enum('pay_ipl', ['Paid', 'Unpaid'])->default('Unpaid');
            $table->bigInteger('pembayaran_ipl')->nullable();

            // Tagihan Wifi
            $table->date('tempo_wifi')->nullable();
            $table->enum('pay_wifi', ['Paid', 'Unpaid'])->default('Unpaid');
            $table->bigInteger('pembayaran_wifi')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('master_unit_hutangs');
    }
};
