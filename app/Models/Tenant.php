<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'occupation', 'gender',
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
}
