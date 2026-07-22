<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BoardingHouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'slug', 'name', 'address', 'kelurahan', 'latitude', 'longitude',
        'type', 'price_per_month', 'total_rooms', 'available_rooms', 'description',
        'rules', 'facilities', 'status',
    ];

    protected $casts = [
        'facilities' => 'array',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    // Relasi ke user (owner)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke owner (melalui user_id)
    public function owner()
    {
        return $this->belongsTo(Owner::class, 'user_id', 'user_id');
    }

    // Relasi ke foto
    public function photos()
    {
        return $this->hasMany(BoardingHousePhoto::class);
    }

    // Foto utama (primary)
    public function primaryPhoto()
    {
        return $this->hasOne(BoardingHousePhoto::class)->where('is_primary', true);
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

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
    
    // Rata-rata rating
    public function averageRating()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    // Cek ketersediaan kamar
    public function isAvailable()
    {
        return $this->available_rooms > 0 && $this->status === 'active';
    }

    // Scope untuk owner yang sedang login
    public function scopeForOwner($query)
    {
        return $query->where('user_id', Auth::id());
    }
}