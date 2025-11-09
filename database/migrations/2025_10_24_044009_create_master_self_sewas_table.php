<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('master_self_sewas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agen_id')->constrained('master_agens')->onDelete('cascade');
            $table->foreignId('unit_id')->constrained('master_units')->onDelete('cascade');
            $table->enum('periode_sewa', ['1 Bulan', '3 Bulan', '6 Bulan', '12 Bulan']);
            $table->date('pengambilan_kunci')->nullable();
            $table->bigInteger('biaya_sewa_unit')->default(0);
            $table->bigInteger('biaya_utilitas')->default(0);
            $table->bigInteger('biaya_ipl')->default(0);
            $table->enum('pembayaran_listrik', ['Paid by Marketing', 'Paid by Company', 'Paid by Customer'])->nullable();
            $table->bigInteger('biaya_listrik')->default(0);
            $table->enum('pembayaran_air', ['Paid by Marketing', 'Paid by Company', 'Paid by Customer'])->nullable();
            $table->bigInteger('biaya_air')->default(0);
            $table->enum('pembayaran_wifi', ['Paid by Marketing', 'Paid by Company', 'Paid by Customer'])->nullable();
            $table->bigInteger('biaya_wifi')->default(0);
            $table->bigInteger('total_hutang')->default(0);
            $table->foreignId('marketing_id')->constrained('master_chanel_units')->onDelete('cascade');
            $table->bigInteger('fee_agen')->default(0);
            $table->bigInteger('deposit')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_self_sewas');
    }
};
