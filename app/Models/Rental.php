<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id', 
        'boarding_house_id', 
        'room_number',
        'start_date', 
        'end_date',
        'duration_months',
        'total_price',
        'unique_code',
        'status', // pending, paid, cancelled, completed
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

    // Relasi ke payment (satu rental punya satu payment terbaru)
    public function payment()
    {
        return $this->hasOne(Payment::class)->latest();
    }

    // Relasi ke semua payments
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Helper status rental
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

    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    // Alias untuk isPaid (untuk kompatibilitas)
    public function isActive()
    {
        return $this->status === 'paid';
    }

    // Helper payment status dari payment terbaru
    public function getPaymentStatusAttribute()
    {
        $payment = $this->payment;
        if (!$payment) {
            return 'pending';
        }
        return $payment->status;
    }

    public function isPaymentPaid()
    {
        return $this->getPaymentStatusAttribute() === 'verified';
    }

    public function isPaymentPending()
    {
        return $this->getPaymentStatusAttribute() === 'pending';
    }

    public function isLate()
    {
        $payment = $this->payment;
        if (!$payment || $payment->status === 'verified') {
            return false;
        }
        return $this->end_date && now()->gt($this->end_date);
    }

    // Scope untuk rental dengan status tertentu
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // Generate unique code untuk rental
    public static function generateUniqueCode()
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (self::where('unique_code', $code)->exists());
        
        return $code;
    }
}