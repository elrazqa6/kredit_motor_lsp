<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;
    
    protected $table = 'pelanggans';
    
    protected $fillable = [
        'user_id',
        'nama_pelanggan',
        'email',
        'no_telp',
        'alamat1',
        'kota1',
        'provinsi1',
        'kodepos1',
        'alamat2',
        'kota2',
        'provinsi2',
        'kodepos2',
        'alamat3',
        'kota3',
        'provinsi3',
        'kodepos3',
        'foto',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');  // ← user_id
    }
    
    public function pengajuanKredit()
    {
        return $this->hasMany(PengajuanKredit::class, 'id_pelanggan');
    }
}