<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('gudang_ambil_items', function (Blueprint $table) {
        $table->dropForeign(['transfer_id']);
        $table->foreign('transfer_id')
            ->references('id')
            ->on('gudang_ambils')
            ->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('gudang_ambil_items', function (Blueprint $table) {
        $table->dropForeign(['transfer_id']);
        $table->foreign('transfer_id')
            ->references('id')
            ->on('gudang_transfers')
            ->onDelete('cascade');
    });
}

};
