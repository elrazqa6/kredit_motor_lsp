<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    use HasFactory;
    
    protected $table = 'hero';
    
    protected $fillable = [
        'judul',
        'sub_judul',
        'gambar',
        'tombol_teks',
        'tombol_link',
        'urutan',
        'is_active',
    ];
}