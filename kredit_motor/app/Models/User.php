<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    
    public function pelanggan()
    {
        return $this->hasOne(Pelanggan::class, 'user_id');  // ← user_id
    }
    
    public function isAdmin()
    {
        return in_array($this->role, ['admin', 'marketing', 'ceo']);
    }
    

    public function isClient()
    {
        return $this->role == 'client';
    }
}