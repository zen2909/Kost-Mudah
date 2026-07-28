<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class BoardingHousePhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'boarding_house_id', 
        'path', 
        'is_primary',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    // Accessor untuk mendapatkan URL foto
    public function getPhotoUrlAttribute()
    {
        if ($this->path) {
            return Storage::url($this->path);
        }
        return null;
    }

    // Relasi ke boarding house
    public function boardingHouse()
    {
        return $this->belongsTo(BoardingHouse::class);
    }
}