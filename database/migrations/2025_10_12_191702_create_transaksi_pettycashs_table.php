<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi_pettycashs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pettycash_id')->constrained('master_pettycashs')->onDelete('cascade');
            $table->dateTime('tanggal_transaksi');
            $table->enum('region', ['Transpark Juanda','Ayam Keshwari']);
            $table->enum('jenis_transaksi', ['Cash In', 'Cash Out']);
            $table->enum('metode_transaksi', ['Cash', 'Transfer']);
            $table->enum('kategori', ['Accomdation','Apartment Utilities','Unit Facilities','Amenities','Maintenance Service','Agency Fee','Transfer Other Agency','Cleanliness','Entertaint']);
            $table->enum('sub_kategori', ['Hotel','Fuel','E-toll','Parking Fee','Other Accomdation','Unit Payment','Unit Utilities','Token Electricity','Wifi','SIM Router','Other Apartment Utilities','Remot','Tissue Box','Laundry','Bedcover Set','Other Unit Facilities','Tissue','Toiletries','Gas','Galon','Snack','Coffee','Tea Bag','Sugar','Other Aminities','AC Cleaning','Engineer','Other Maintenance Service','Laundry Parfume','Toilet Bag','Trash Bag','Vixal','Baygon','Dish Soap','Insect Trap','Other Cleaniless','Community Fund','Employees Birthday','Other Entertain']);
            $table->text('keperluan')->nullable();
            $table->decimal('nominal', 15, 2);
            $table->string('bukti_foto')->nullable();
            $table->decimal('saldo_sebelum', 15, 2)->default(0);
            $table->decimal('saldo_berjalan', 15, 2)->default(0);
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_pettycashs');
    }
};
