<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Angsuran extends Model
{
    use HasFactory;
    
    protected $table = 'angsuran';
    
    protected $fillable = [
        'id_kredit',
        'angsuran_ke',
        'tgl_jatuh_tempo',      // ← TAMBAHKAN INI
        'total_bayar',
        'tgl_bayar',
        'keterangan',
    ];
    
    protected $casts = [
        'tgl_jatuh_tempo' => 'date',
        'tgl_bayar' => 'date',
        'total_bayar' => 'decimal:0',
    ];
    
    // Relasi ke Kredit
    public function kredit()
    {
        return $this->belongsTo(Kredit::class, 'id_kredit');
    }
    
    // Accessor untuk status
    public function getStatusAttribute()
    {
        if ($this->tgl_bayar) {
            return 'Lunas';
        }
        
        if ($this->jatuh_tempo < now()) {
            return 'Telat';
        }
        
        return 'Belum Bayar';
    }
    
    // Accessor untuk status badge class
    public function getStatusBadgeClassAttribute()
    {
        $status = $this->status;
        $classes = [
            'Lunas' => 'badge-lunas',
            'Belum Bayar' => 'badge-belum',
            'Telat' => 'badge-telat'
        ];
        
        return $classes[$status] ?? 'badge-secondary';
    }
    
    // Accessor untuk format jatuh tempo
    public function getJatuhTempoFormattedAttribute()
    {
        return $this->jatuh_tempo ? $this->jatuh_tempo->translatedFormat('d F Y') : '-';
    }
    
    // Accessor untuk cek apakah terlambat
    public function getIsTerlambatAttribute()
    {
        return !$this->tgl_bayar && $this->jatuh_tempo < now();
    }
    
    // Accessor untuk cek apakah sudah lunas
    public function getIsLunasAttribute()
    {
        return !is_null($this->tgl_bayar);
    }
    
    // Accessor untuk hitung hari terlambat
    public function getHariTerlambatAttribute()
    {
        if ($this->is_terlambat) {
            return now()->diffInDays($this->jatuh_tempo);
        }
        return 0;
    }
}