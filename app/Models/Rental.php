<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'boarding_house_id',
        'start_date',
        'end_date',
        'duration_months',
        'total_price',
        'unique_code',
        'status'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public static function generateUniqueCode()
    {
        return 'RENT-' . strtoupper(uniqid());
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function boardingHouse()
    {
        return $this->belongsTo(BoardingHouse::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}