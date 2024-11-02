<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BuatPengeluaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengeluaran', function (Blueprint $table) {
            $table->id();
             // $table->foreignId('id_toko')->constrained('toko')->onDelete('cascade'); 
             $table->foreignId('id_resto')->constrained('restoran')->onDelete('cascade'); 
             // $table->foreignId('id_user')->constrained('users')->onDelete('cascade'); 
            $table->text('deskripsi');
            $table->integer('nominal');
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
        Schema::dropIfExists('pengeluaran');
    }
}
