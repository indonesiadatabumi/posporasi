<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BuatSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('id_toko')->constrained('toko')->onDelete('cascade'); 
            $table->foreignId('id_resto')->constrained('restoran')->onDelete('cascade'); 
            // $table->foreignId('id_user')->constrained('users')->onDelete('cascade'); 
            $table->string('nama_toko');
            $table->text('alamat')->nullable();
            $table->string('telepon');
            $table->tinyInteger('tipe_nota');
            $table->string('path_logo');
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
        Schema::dropIfExists('setting');
    }
}
