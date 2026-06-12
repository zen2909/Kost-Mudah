<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id', 'boarding_house_id', 'start_date', 'end_date',
        'duration_months', 'total_price', 'unique_code', 'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // Relasi ke tenant
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    // Relasi ke boarding house
    public function boardingHouse()
    {
        return $this->belongsTo(BoardingHouse::class);
    }

    // Relasi ke payment (satu rental punya satu payment)
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // Helper status
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isPaid()
    {
        return $this->status === 'paid';
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }
}
