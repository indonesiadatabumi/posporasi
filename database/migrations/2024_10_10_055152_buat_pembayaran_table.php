<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BuatPembayaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_resto')->constrained('restoran')->onDelete('cascade'); 
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade'); 
            $table->foreignId('pembelian_id')->constrained('pembelian')->onDelete('cascade'); 
            $table->decimal('subtotal', 10, 2); 
            $table->decimal('pajak', 10, 2)->default(0); 
            $table->decimal('total_pembayaran', 10, 2); 
            $table->string('metode_pembayaran', 50); 
            $table->string('nomor_struk')->unique(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembayaran'); // Menghapus tabel pembayaran
    }
}
