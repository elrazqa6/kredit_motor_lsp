<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            
            // FOREIGN KEY ke tabel kredit (INI YANG PENTING!)
            $table->unsignedBigInteger('id_kredit');
            $table->foreign('id_kredit')
                  ->references('id')
                  ->on('kredit')
                  ->onDelete('cascade');
            
            // Detail angsuran
            $table->integer('angsuran_ke');
            $table->date('jatuh_tempo');
            $table->double('nominal_bayar');
            $table->date('tgl_bayar')->nullable();
            $table->double('denda')->default(0);
            
            // Status
            $table->enum('status_bayar', ['Belum Bayar', 'Lunas', 'Terlambat'])->default('Belum Bayar');
            
            // Bukti dan keterangan
            $table->string('bukti_bayar')->nullable();
            $table->text('keterangan')->nullable();
            
            $table->timestamps();
            
            // Index untuk optimasi query
            $table->index(['id_kredit', 'status_bayar']);
            $table->index(['id_kredit', 'angsuran_ke']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('pembayaran');
    }
};