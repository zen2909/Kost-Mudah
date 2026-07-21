<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'boarding_house_id',
        'document_type',
        'custom_type',
        'document_number',
        'file_path',
        'expired_date',
        'status',
        'notes',
        'verified_at',
        'verified_by',
        'rejection_reason',
    ];

    protected $casts = [
        'expired_date' => 'date',
        'verified_at' => 'datetime',
    ];

    // Relasi ke user (pemilik)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke boarding house
    public function boardingHouse()
    {
        return $this->belongsTo(BoardingHouse::class);
    }

    // Relasi ke admin yang memverifikasi
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // Helper methods
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

    // Scope
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeVerified($query)
    {
        return $query->where('status', 'verified');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // Get document type label
    public function getDocumentTypeLabelAttribute()
    {
        $types = [
            'ktp' => 'Kartu Tanda Penduduk',
            'imb' => 'IMB (Izin Mendirikan Bangunan)',
            'pbb' => 'PBB (Pajak Bumi Bangunan)',
            'sertifikat' => 'Sertifikat Properti',
            'akta' => 'Akta Tanah',
            'other' => 'Lainnya',
        ];
        return $types[$this->document_type] ?? $this->custom_type ?? $this->document_type;
    }

    // Get status label with color
    public function getStatusLabelAttribute()
    {
        $statuses = [
            'pending' => ['label' => 'Pending', 'class' => 'bg-[#FEF3C7] text-[#92400E]'],
            'verified' => ['label' => 'Terverifikasi', 'class' => 'bg-[#DCFCE7] text-[#15803D]'],
            'rejected' => ['label' => 'Ditolak', 'class' => 'bg-[#FEE2E2] text-[#991B1B]'],
        ];
        return $statuses[$this->status] ?? $statuses['pending'];
    }
}