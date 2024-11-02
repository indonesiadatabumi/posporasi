<?php

// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// return new class extends Migration
// {
//     /**
//      * Run the migrations.
//      *
//      * @return void
//      */
//     public function up()
//     {
//         Schema::create('toko', function (Blueprint $table) {
//             $table->id();
//             $table->string('nama_toko');
//             $table->string('alamat'); 
//             $table->foreignId('id_user')->constrained('users')->onDelete('cascade'); // Relasi ke pengguna (owner)
//             $table->timestamps();
//         });
        
//     }

//     /**
//      * Reverse the migrations.
//      *
//      * @return void
//      */
//     public function down()
//     {
//         Schema::dropIfExists('toko');
//     }
// };
