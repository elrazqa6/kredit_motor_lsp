<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodeBayar extends Model
{
    use HasFactory;
    
    protected $table = 'metode_bayar';
    
    protected $fillable = [
        'metode_pembayaran',
        'tempat_bayar',
        'no_rekening',
        'url_logo',
    ];
    
    // Relasi ke PengajuanKredit
    public function pengajuanKredit()
    {
        return $this->hasMany(PengajuanKredit::class, 'id_metode_bayar');
    }
    
    // Relasi ke Kredit
    public function kredit()
    {
        return $this->hasMany(Kredit::class, 'id_metode_bayar');
    }
}