<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TambahDeviceToPrinterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('printer', function (Blueprint $table) {
            $table->string('device')->nullable()->after('lokasi_printer');  // Menambahkan kolom device setelah lokasi_printer
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('printer', function (Blueprint $table) {
            $table->dropColumn('device');  
       
        });
    }
}
