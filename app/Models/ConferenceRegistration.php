<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConferenceRegistration extends Model
{
    protected $table = 'conference_registrations';
    
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_prefix',
        'phone_number',
        'institution',
        'country',
        'nationality',
        'platform',
        'category',
        'student_id_path',
        'fee',
        'fee_currency',
        'payment_method',
        'transaction_id',
        'payment_proof_path',
        'payment_status',
        'rejection_reason',
        'ticket_number',
        'verified_by',
        'verified_at'
    ];

    protected $casts = [
        'verified_at' => 'datetime',
        'fee' => 'decimal:2'
    ];

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    // Relationships
    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // Accessors
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getFullPhoneAttribute(): string
    {
        return $this->phone_prefix . $this->phone_number;
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('payment_status', self::STATUS_PENDING);
    }

    public function scopeApproved($query)
    {
        return $query->where('payment_status', self::STATUS_APPROVED);
    }

    public function scopeRejected($query)
    {
        return $query->where('payment_status', self::STATUS_REJECTED);
    }
}