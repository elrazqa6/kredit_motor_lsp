<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pengajuan_kredit', function (Blueprint $table) {
            // Status DP: Belum Bayar, Menunggu, Lunas, Ditolak
            $table->enum('status_dp', ['Belum Bayar', 'Menunggu', 'Lunas', 'Ditolak'])
                  ->default('Belum Bayar')
                  ->after('uang_muka');
            
            // Bukti transfer DP (file path)
            $table->string('bukti_dp')->nullable()->after('status_dp');
            
            // Tanggal bayar DP
            $table->datetime('tgl_bayar_dp')->nullable()->after('bukti_dp');
            
            // Keterangan/alasan jika ditolak
            $table->text('keterangan_dp')->nullable()->after('tgl_bayar_dp');
        });
    }

    public function down()
    {
        Schema::table('pengajuan_kredit', function (Blueprint $table) {
            $table->dropColumn(['status_dp', 'bukti_dp', 'tgl_bayar_dp', 'keterangan_dp']);
        });
    }
};