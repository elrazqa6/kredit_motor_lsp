<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisMotor extends Model
{
    use HasFactory;
    
    protected $table = 'jenis_motor';
    
    protected $fillable = [
        'nama_jenis',
        'keterangan',
        'is_active',
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
    ];
    
    public function motor()
    {
        return $this->hasMany(Motor::class, 'jenis_motor_id');
    }
}