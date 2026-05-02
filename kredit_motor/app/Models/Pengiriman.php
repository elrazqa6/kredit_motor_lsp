<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    use HasFactory;
    
    protected $table = 'pengiriman';
    
    protected $fillable = [
        'id_kredit',
        'no_resi',
        'kurir',
        'alamat_pengiriman',
        'tgl_pengiriman',
        'tgl_estimasi_sampai',
        'tgl_sampai',
        'status',
        'keterangan',
    ];
    
    protected $casts = [
        'tgl_pengiriman' => 'date',
        'tgl_estimasi_sampai' => 'date',
        'tgl_sampai' => 'date',
    ];
    
    public function kredit()
    {
        return $this->belongsTo(Kredit::class, 'id_kredit');
    }
}