<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'rental_id',
        'method', // bank_transfer, qris, ewallet
        'amount',
        'proof_path',
        'notes',
        'status', // pending, verified, rejected
        'verified_at',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    // Relasi ke rental
    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }

    // Helper status
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isVerified()
    {
        return $this->status === 'verified';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    // Helper method
    public function getMethodLabelAttribute()
    {
        $labels = [
            'bank_transfer' => 'Transfer Bank',
            'qris' => 'QRIS',
            'ewallet' => 'E-Wallet',
        ];
        return $labels[$this->method] ?? $this->method;
    }

    // Scope
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeVerified($query)
    {
        return $query->where('status', 'verified');
    }
}