<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisCicilan extends Model
{
    use HasFactory;
    
    protected $table = 'jenis_cicilan';
    
    protected $fillable = [
        'lama_cicilan',
        'margin_kredit'
    ];
    
    protected $casts = [
        'lama_cicilan' => 'integer',
        'margin_kredit' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    /**
     * Get formatted lama cicilan
     */
    public function getLamaCicilanFormattedAttribute()
    {
        return $this->lama_cicilan . ' bulan (' . number_format($this->lama_cicilan / 12, 1) . ' tahun)';
    }
    
    /**
     * Get margin rate as percentage
     */
    public function getMarginRateAttribute()
    {
        return $this->margin_kredit . '%';
    }
    
    /**
     * Relasi ke pengajuan kredit
     */
    public function pengajuanKredit()
    {
        return $this->hasMany(PengajuanKredit::class, 'id_jenis_cicilan');
    }
    
    public function hitungCicilan($hargaMotor, $dpNominal = 0)
    {
        $pokok = $hargaMotor - $dpNominal;
        $bunga = ($pokok * $this->margin_kredit / 100);
        $total = $pokok + $bunga;
        return $total / $this->lama_cicilan;
    }
}