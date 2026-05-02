<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pengiriman', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_kredit');
            $table->string('no_resi')->unique();
            $table->string('kurir')->nullable(); // JNE, J&T, SiCepat, dll
            $table->text('alamat_pengiriman');
            $table->date('tgl_pengiriman')->nullable();
            $table->date('tgl_estimasi_sampai')->nullable();
            $table->date('tgl_sampai')->nullable();
            $table->enum('status', ['Diproses', 'Dikirim', 'Selesai', 'Batal'])->default('Diproses');
            $table->text('keterangan')->nullable();
            $table->timestamps();
            
            $table->foreign('id_kredit')->references('id')->on('kredit')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengiriman');
    }
};