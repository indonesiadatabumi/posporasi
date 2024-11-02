<?php

// use Illuminate\Support\Facades\Schema;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Database\Migrations\Migration;

// class CreatePegawaiTable extends Migration
// {
//     /**
//      * Run the migrations.
//      */
//     public function up(): void
//     {
//         Schema::create('pegawai', function (Blueprint $table) {
//             $table->id();
//             $table->foreignId('id_user')->constrained('users')->onDelete('cascade'); // Relasi ke pengguna (pegawai)
//             $table->foreignId('id_toko')->constrained('toko')->onDelete('cascade'); // Relasi ke toko
//             $table->timestamps();
//         });
//     }

//     /**
//      * Reverse the migrations.
//      */
//     public function down(): void
//     {
//         Schema::dropIfExists('pegawai');
//     }
// }
