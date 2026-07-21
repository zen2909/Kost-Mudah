<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'occupation', 
        'gender',
        'verification_status',
        'verified_at',
        'identity_number',
        'identity_photo',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke rentals (penyewaan)
    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    // Relasi ke reviews
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Relasi ke favorites
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    // Dapatkan kost favorit melalui favorites
    public function favoriteBoardingHouses()
    {
        return $this->belongsToMany(BoardingHouse::class, 'favorites', 'tenant_id', 'boarding_house_id')
            ->withTimestamps();
    }

    // Cek apakah tenant sudah terverifikasi
    public function isVerified()
    {
        return $this->verification_status === 'verified';
    }

    // Scope untuk tenant yang sudah terverifikasi
    public function scopeVerified($query)
    {
        return $query->where('verification_status', 'verified');
    }

    // Scope untuk tenant yang pending
    public function scopePending($query)
    {
        return $query->where('verification_status', 'pending');
    }
}