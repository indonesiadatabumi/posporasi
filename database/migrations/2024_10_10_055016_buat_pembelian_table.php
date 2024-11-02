<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BuatPembelianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembelian', function (Blueprint $table) {
            $table->id();
            $table->string('no_order'); 
            $table->foreignId('id_meja')->nullable()->constrained('meja')->onDelete('set null');
            $table->foreignId('id_resto')->constrained('restoran')->onDelete('cascade'); 
            $table->string('pembeli');  
            $table->string('jenis_pesanan');  
            $table->integer('total_harga');  
            $table->decimal('pajak', 10, 2)->default(0);  
            $table->string('status', 50)->default('pending');  
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
        Schema::dropIfExists('pembelian');
    }
}
