<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motor extends Model
{
    use HasFactory;
    
    protected $table = 'motor';
    
    protected $fillable = [
        'nama_motor',
        'merk',
        'jenis_motor_id',
        'harga_cash',
        'harga_jual',
        'warna',
        'stok',
        'foto1',
        'foto2',
        'foto3',
        'deskripsi',
        'cc',
        'tahun',
        'status'
    ];
    
    public function jenisMotor()
    {
        return $this->belongsTo(JenisMotor::class, 'jenis_motor_id');
    }
    

    public function pengajuanKredit()
    {
        return $this->hasMany(PengajuanKredit::class, 'id_motor');
    }
    
    public function scopeTersedia($query)
    {
        return $query->where('stok', '>', 0);
    }
}