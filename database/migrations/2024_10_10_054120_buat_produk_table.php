<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BuatProdukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('id_user')->constrained('users')->onDelete('cascade'); 
            $table->foreignId('id_resto')->constrained('restoran')->onDelete('cascade'); 
            $table->foreignId('id_kategori')->constrained('kategori')->onDelete('cascade'); 
            $table->string('nama_produk');  
            $table->string('deskripsi');  
            $table->integer('harga_beli');  
            $table->integer('harga_jual');  
            $table->integer('stok');  
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
        Schema::dropIfExists('produk');
    }
}
