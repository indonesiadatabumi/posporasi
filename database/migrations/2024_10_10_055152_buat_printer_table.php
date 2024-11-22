<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BuatPrinterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('printer', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('id_resto'); 
            $table->string('nama_printer');  
            $table->string('ip_printer')->nullable();  
            $table->integer('port_printer')->nullable();  
            $table->string('share_name')->nullable();  
            $table->enum('koneksi', ['network', 'usb', 'smb'])->default('network');  
            $table->string('lokasi_printer')->nullable();  
            $table->timestamps();   

            $table->foreign('id_resto')->references('id')->on('restoran')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('printer'); 
    }
}
