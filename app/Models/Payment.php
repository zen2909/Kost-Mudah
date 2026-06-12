<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'rental_id', 'method', 'amount', 'proof_path', 'notes', 'status', 'verified_at',
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
}
