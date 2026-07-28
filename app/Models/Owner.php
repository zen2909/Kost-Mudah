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
        'ewallet_ovo',
        'ewallet_dana',
        'ewallet_shopeepay',
        'qris_ewallet',
        'qris_image',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function boardingHouses()
    {
        return $this->hasMany(BoardingHouse::class, 'user_id', 'user_id');
    }

    public function isVerified()
    {
        return $this->verification_status === 'approved';
    }

    public function scopeVerified($query)
    {
        return $query->where('verification_status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('verification_status', 'pending');
    }

    public function getEwalletNumber($provider)
    {
        $field = 'ewallet_' . $provider;
        return $this->$field ?? null;
    }

    public function hasEwallet($provider)
    {
        $field = 'ewallet_' . $provider;
        return !empty($this->$field);
    }

    public function getEwalletsAttribute()
    {
        $ewallets = [];
        
        if ($this->ewallet_ovo) {
            $ewallets['ovo'] = [
                'label' => 'OVO',
                'number' => $this->ewallet_ovo,
                'color' => 'purple',
                'icon' => 'O'
            ];
        }
        
        if ($this->ewallet_dana) {
            $ewallets['dana'] = [
                'label' => 'DANA',
                'number' => $this->ewallet_dana,
                'color' => 'blue',
                'icon' => 'D'
            ];
        }
        
        if ($this->ewallet_shopeepay) {
            $ewallets['shopeepay'] = [
                'label' => 'ShopeePay',
                'number' => $this->ewallet_shopeepay,
                'color' => 'orange',
                'icon' => 'SP'
            ];
        }
        
        return $ewallets;
    }

    public function getQrisEwalletDataAttribute()
    {
        if (!$this->qris_ewallet) {
            return null;
        }

        $ewallets = $this->ewallets;
        return $ewallets[$this->qris_ewallet] ?? null;
    }

    public function getActiveEwalletProvidersAttribute()
    {
        $providers = [];
        
        if ($this->ewallet_ovo) $providers[] = 'ovo';
        if ($this->ewallet_dana) $providers[] = 'dana';
        if ($this->ewallet_shopeepay) $providers[] = 'shopeepay';
        
        return $providers;
    }

    public function getBankIconAttribute()
    {
        $bankIcons = [
            'BCA' => 'bg-blue-100 text-blue-600',
            'BRI' => 'bg-red-100 text-red-600',
            'Mandiri' => 'bg-yellow-100 text-yellow-700',
            'BNI' => 'bg-blue-100 text-blue-800',
            'BTN' => 'bg-green-100 text-green-700',
        ];
        return $bankIcons[$this->bank_name] ?? 'bg-gray-100 text-gray-600';
    }
}