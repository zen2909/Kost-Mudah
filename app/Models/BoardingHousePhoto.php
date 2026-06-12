<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardingHousePhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'boarding_house_id', 'path', 'is_primary',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    // Relasi ke boarding house
    public function boardingHouse()
    {
        return $this->belongsTo(BoardingHouse::class);
    }
}
