<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'verification_document', 
        'verification_status', 
        'verified_at',
        'bank_name',
        'bank_account_number',
        'bank_account_holder',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke boarding houses (kost milik)
    public function boardingHouses()
    {
        return $this->hasMany(BoardingHouse::class, 'user_id', 'user_id');
    }

    // Cek apakah pemilik sudah terverifikasi
    public function isVerified()
    {
        return $this->verification_status === 'approved';
    }

    // Scope untuk owner yang sudah terverifikasi
    public function scopeVerified($query)
    {
        return $query->where('verification_status', 'approved');
    }

    // Scope untuk owner yang pending
    public function scopePending($query)
    {
        return $query->where('verification_status', 'pending');
    }
}