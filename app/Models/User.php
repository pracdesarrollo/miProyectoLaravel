<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'last_name',
        'email',
        'phone',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relación con ventas
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    // Accessor para nombre completo
    public function getFullNameAttribute()
    {
        return $this->name . ' ' . $this->last_name;
    }

    // Scope para buscar por email
    public function scopeByEmail($query, $email)
    {
        return $query->where('email', $email);
    }

    public function isAdmin():bool{
        return $this->role === 'admin';
    }

    public function isVendedor(): bool{
        return $this->role === 'vendor';
    }
}