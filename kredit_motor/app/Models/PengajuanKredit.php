<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanKredit extends Model
{
    use HasFactory;
    
    protected $table = 'pengajuan_kredit';
    
    protected $fillable = [
    'id_pelanggan',
    'id_motor',
    'id_jenis_cicilan',
    'id_asuransi',
    'id_metode_bayar',
    'uang_muka',
    'status_dp',        
    'bukti_dp',         
    'tgl_bayar_dp',     
    'keterangan_dp',    
    'status_pengajuan',
    'tgl_pengajuan_kredit',
    'harga_cash',
    'dp',
    'harga_kredit',
    'biaya_asuransi_perbulan',
    'cicilan_perbulan',
    'tenor',
    'url_kk',
    'url_ktp',
    'url_npwp',
    'url_slip_gaji',
    'url_foto',
    'keterangan_status_pengajuan',
];
    
    protected $casts = [
        'uang_muka' => 'decimal:0',
        'harga_cash' => 'decimal:0',
        'dp' => 'decimal:2',
        'harga_kredit' => 'decimal:0',
        'biaya_asuransi_perbulan' => 'decimal:0',
        'cicilan_perbulan' => 'decimal:0',
        'tenor' => 'integer',
        'tgl_pengajuan_kredit' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    // Relasi
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }
    
    public function motor()
    {
        return $this->belongsTo(Motor::class, 'id_motor');
    }
    
    public function jenisCicilan()
    {
        return $this->belongsTo(JenisCicilan::class, 'id_jenis_cicilan');
    }
    
    public function asuransi()
    {
        return $this->belongsTo(Asuransi::class, 'id_asuransi');
    }
    
    public function metodeBayar()
    {
        return $this->belongsTo(MetodeBayar::class, 'id_metode_bayar');
    }
    
    public function kredit()
    {
        return $this->hasOne(Kredit::class, 'id_pengajuan_kredit');
    }
}