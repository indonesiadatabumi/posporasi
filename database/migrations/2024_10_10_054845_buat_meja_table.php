<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BuatMejaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meja', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_resto')->constrained('restoran')->onDelete('cascade'); 
            // $table->foreignId('id_user')->constrained('users')->onDelete('cascade'); 
            $table->string('nomor_meja');  
            $table->integer('kapasitas');  
            $table->string('status', 50)->default('tersedia');  
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
        Schema::dropIfExists('meja');
    }
}
