<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asuransi extends Model
{
    use HasFactory;
    
    protected $table = 'asuransi';
    
    protected $fillable = [
        'nama_asuransi',
        'biaya',
        'nama_perusahaan',
        'margin_asuransi',
        'no_rekening',
        'url_logo',
        'status'
    ];
    
    protected $casts = [
        'biaya' => 'decimal:0',
        'margin_asuransi' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    /**
     * Get logo URL attribute
     */
    public function getLogoUrlAttribute()
    {
        if ($this->url_logo) {
            return asset('storage/' . $this->url_logo);
        }
        return null;
    }
}