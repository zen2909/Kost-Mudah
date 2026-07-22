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
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke rentals (penyewaan)
    public function rentals()
    {
        return $this->hasMany(Rental::class, 'tenant_id');
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

    // Get verification status from documents
    public function getVerificationStatusAttribute()
    {
        $user = $this->user;
        if (!$user) {
            return 'unverified';
        }

        // Cek apakah user memiliki dokumen yang terverifikasi
        if ($user->documents()->where('status', 'verified')->exists()) {
            return 'verified';
        }
        
        // Cek apakah user memiliki dokumen yang pending
        if ($user->documents()->where('status', 'pending')->exists()) {
            return 'pending';
        }
        
        return 'unverified';
    }

    // Cek apakah tenant sudah terverifikasi
    public function isVerified()
    {
        return $this->verification_status === 'verified';
    }

    // Scope untuk tenant yang sudah terverifikasi
    public function scopeVerified($query)
    {
        return $query->whereHas('user.documents', function ($q) {
            $q->where('status', 'verified');
        });
    }

    // Scope untuk tenant yang pending
    public function scopePending($query)
    {
        return $query->whereHas('user.documents', function ($q) {
            $q->where('status', 'pending');
        });
    }

    // Scope untuk tenant yang belum verifikasi
    public function scopeUnverified($query)
    {
        return $query->whereDoesntHave('user.documents', function ($q) {
            $q->whereIn('status', ['verified', 'pending']);
        });
    }
}