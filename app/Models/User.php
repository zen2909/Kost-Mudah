<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
    ];

    /**
     * Relasi ke data tenant (jika role = 'tenant')
     */
    public function tenant()
    {
        return $this->hasOne(Tenant::class);
    }

    /**
     * Relasi ke data owner (jika role = 'owner')
     */
    public function owner()
    {
        return $this->hasOne(Owner::class);
    }

    /**
     * Cek apakah user adalah admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Cek apakah user adalah owner (pemilik kost)
     */
    public function isOwner(): bool
    {
        return $this->role === 'owner';
    }

    /**
     * Cek apakah user adalah tenant (penyewa)
     */
    public function isTenant(): bool
    {
        return $this->role === 'tenant';
    }

    /**
     * Scope untuk filter berdasarkan role
     */
    public function scopeRole($query, $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Accessor untuk foto profil (dengan fallback avatar)
     */
    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo && file_exists(storage_path('app/public/'.$this->photo))) {
            return asset('storage/'.$this->photo);
        }

        // Fallback: avatar dari ui-avatars.com
        return 'https://ui-avatars.com/api/?background=0D8ABC&color=fff&name='.urlencode($this->name);
    }
}
