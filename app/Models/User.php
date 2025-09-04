<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable, HasRoles;

    

    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
        'role', ];

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

   
}