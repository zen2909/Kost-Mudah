<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'role',
        'photo',
        'password',
        'email_verified_at',
        'phone_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi ke owner
    public function owner()
    {
        return $this->hasOne(Owner::class);
    }

    // Relasi ke tenant
    public function tenant()
    {
        return $this->hasOne(Tenant::class);
    }

    // Relasi ke boarding houses (untuk owner)
    public function boardingHouses()
    {
        return $this->hasMany(BoardingHouse::class, 'user_id');
    }

    // Helper methods
    public function isAdmin(): bool
    {
        return $this->role === 'admin' || $this->hasRole('admin');
    }

    public function isOwner(): bool
    {
        return $this->role === 'owner' || $this->hasRole('owner');
    }

    public function isTenant(): bool
    {
        return $this->role === 'tenant' || $this->hasRole('tenant');
    }
}