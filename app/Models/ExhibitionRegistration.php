<?php
// app/Models/ExhibitionRegistration.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ExhibitionRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_number',
        'organization_name',
        'about_exhibition',
        'benefits',
        'booth_count',
        'registration_type',
        'target_audience',
        'total_amount',
        'payment_method',
        'receipt_number',
        'payment_proof_path',
        'payment_status',
        'contact_name',
        'contact_role',
        'contact_phone',
        'contact_email',
        'is_team_leader',
        'team_size',
        'status',
        'admin_notes',
        'approved_at',
        'approved_by',
        'booth_number',
        'special_requests',
        'confirmation_email_sent_at',
        'approval_email_sent_at',
    ];

    protected $casts = [
        'is_team_leader' => 'boolean',
        'booth_count' => 'integer',
        'team_size' => 'integer',
        'total_amount' => 'decimal:2',
        'approved_at' => 'datetime',
        'confirmation_email_sent_at' => 'datetime',
        'approval_email_sent_at' => 'datetime',
    ];



    /**
     * Get the formatted price per booth
     */
    public function getFormattedPricePerBoothAttribute(): string
    {
        return 'KES ' . number_format($this->price_per_booth, 0);
    }

    /**
     * Get the registration type label
     */

    /**
     * Get the payment method label
     */
    public function getPaymentMethodLabelAttribute(): string
    {
        return $this->payment_method === 'bank' ? 'Bank Transfer' : 'M-Pesa';
    }

    /**
     * Get the status label with badge class
     */
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'approved' => '<span class="badge bg-success">Approved</span>',
            'rejected' => '<span class="badge bg-danger">Rejected</span>',
            default => '<span class="badge bg-warning text-dark">Pending</span>',
        };
    }

    /**
     * Get the payment status badge
     */
    public function getPaymentStatusBadgeAttribute(): string
    {
        return match($this->payment_status) {
            'verified' => '<span class="badge bg-success">Verified</span>',
            'failed' => '<span class="badge bg-danger">Failed</span>',
            default => '<span class="badge bg-warning text-dark">Pending</span>',
        };
    }

    /**
     * Get the payment proof URL
     */
    public function getPaymentProofUrlAttribute(): ?string
    {
        return $this->payment_proof_path 
            ? Storage::url($this->payment_proof_path) 
            : null;
    }

    /**
     * Scope for pending registrations
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for approved registrations
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope for registrations needing payment verification
     */
    public function scopeNeedsPaymentVerification($query)
    {
        return $query->where('payment_status', 'pending');
    }

    /**
     * Relationship with the user who approved this registration
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Generate a unique reference number
     */
    public static function generateReferenceNumber(): string
    {
        do {
            $reference = 'EXH-' . strtoupper(substr(md5(uniqid()), 0, 8));
        } while (self::where('reference_number', $reference)->exists());

        return $reference;
    }

    /**
     * Mark as approved
     */
    public function markAsApproved(int $approvedBy, ?string $boothNumber = null): bool
    {
        return $this->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => $approvedBy,
            'booth_number' => $boothNumber ?? $this->booth_number,
        ]);
    }

    /**
     * Mark as rejected
     */
    public function markAsRejected(?string $notes = null): bool
    {
        return $this->update([
            'status' => 'rejected',
            'admin_notes' => $notes,
        ]);
    }

    /**
     * Mark payment as verified
     */
    public function markPaymentAsVerified(): bool
    {
        return $this->update(['payment_status' => 'verified']);
    }

    /**
     * Check if approval email has been sent
     */
    public function hasApprovalEmailBeenSent(): bool
    {
        return !is_null($this->approval_email_sent_at);
    }

    public function getPricePerBoothAttribute()
    {
        return $this->registration_type === 'standard' ? 15000 : 8000;
    }

    public function getRegistrationTypeLabelAttribute()
    {
        return $this->registration_type === 'standard'
            ? 'Standard (KES 15,000)'
            : 'Own Tent (KES 8,000)';
    }

    public function getFormattedTotalAttribute()
    {
        return 'KES ' . number_format($this->total_amount);
    }
}