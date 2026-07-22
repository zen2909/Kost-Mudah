<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'role',
        'photo',
        'password',
        'email_verified_at',
        'phone_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi ke owner
    public function owner()
    {
        return $this->hasOne(Owner::class);
    }

    // Relasi ke tenant
    public function tenant()
    {
        return $this->hasOne(Tenant::class);
    }

    // Relasi ke boarding houses (untuk owner)
    public function boardingHouses()
    {
        return $this->hasMany(BoardingHouse::class, 'user_id');
    }

    // Relasi ke documents (untuk owner)
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

  public function rentals()
    {
        return $this->hasManyThrough(
            Rental::class,
            Tenant::class,
            'user_id', 
            'tenant_id', 
            'id',
            'id'
        );
    }

    // Helper methods
    public function isAdmin(): bool
    {
        return $this->role === 'admin' || $this->hasRole('admin');
    }

    public function isOwner(): bool
    {
        return $this->role === 'owner' || $this->hasRole('owner');
    }

    public function isTenant(): bool
    {
        return $this->role === 'tenant' || $this->hasRole('tenant');
    }

    /**
     * Get verification status based on documents
     * Returns: 'verified', 'pending', 'rejected', or 'unverified'
     */
    public function getVerificationStatusAttribute()
    {
        // Jika tidak ada owner record, return unverified
        if (!$this->owner) {
            return 'unverified';
        }

        // Jika sudah ada status di owner dan tidak pending, gunakan status tersebut
        // Ini untuk backward compatibility
        if ($this->owner->verification_status && $this->owner->verification_status !== 'pending') {
            return $this->owner->verification_status;
        }

        // Cek dokumen yang terkait dengan user ini
        $documents = $this->documents;

        // Jika tidak ada dokumen sama sekali
        if ($documents->isEmpty()) {
            return 'unverified';
        }

        // Cek apakah ada dokumen yang ditolak
        $hasRejected = $documents->contains('status', 'rejected');
        if ($hasRejected) {
            return 'rejected';
        }

        // Cek apakah ada dokumen yang pending
        $hasPending = $documents->contains('status', 'pending');
        if ($hasPending) {
            return 'pending';
        }

        // Cek apakah semua dokumen terverifikasi
        $allVerified = $documents->every(function ($doc) {
            return $doc->status === 'verified';
        });

        if ($allVerified && $documents->isNotEmpty()) {
            return 'approved';
        }

        // Default
        return 'unverified';
    }


    /**
     * Get verification status label
     */
    public function getVerificationStatusLabelAttribute()
    {
        $status = $this->getVerificationStatusAttribute();
        $labels = [
            'approved' => 'VERIFIED',
            'pending' => 'PENDING',
            'rejected' => 'REJECTED',
            'unverified' => 'UNVERIFIED',
        ];
        return $labels[$status] ?? 'UNVERIFIED';
    }

    /**
     * Get verification status color class
     */
    public function getVerificationStatusClassAttribute()
    {
        $status = $this->getVerificationStatusAttribute();
        $classes = [
            'approved' => 'bg-[#DCFCE7] text-[#15803D]',
            'pending' => 'bg-[#FEF3C7] text-[#92400E]',
            'rejected' => 'bg-[#FEE2E2] text-[#991B1B]',
            'unverified' => 'bg-[#F2F4F5] text-[#42474C]',
        ];
        return $classes[$status] ?? 'bg-[#F2F4F5] text-[#42474C]';
    }
}