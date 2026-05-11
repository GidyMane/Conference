<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\User;

class ExhibitionRegistration extends Model
{
    use HasFactory;

    /**
     * Single source of truth for early bird deadline
     */
    public const EARLY_BIRD_END = '2026-05-22 23:59:59';

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

    /* =========================
       PRICING LOGIC
    ========================= */

    public function isEarlyBird(): bool
    {
        $deadline = Carbon::parse(self::EARLY_BIRD_END, 'Africa/Nairobi');
        return now('Africa/Nairobi')->lte($deadline);
    }

    public function getPricePerBoothAttribute(): int
    {
        $earlyBird = $this->isEarlyBird();

        if ($this->registration_type === 'standard') {
            return $earlyBird ? 15000 : 20000;
        }

        return $earlyBird ? 8000 : 10000;
    }

    public function getFormattedPricePerBoothAttribute(): string
    {
        return 'KES ' . number_format($this->getPricePerBoothAttribute(), 0);
    }

    public function getFormattedTotalAttribute(): string
    {
        return 'KES ' . number_format($this->total_amount, 0);
    }

    public function getRegistrationTypeLabelAttribute(): string
    {
        $price = $this->getPricePerBoothAttribute();

        return match ($this->registration_type) {
            'standard' => "Standard (KES {$price})",
            'own_tent' => "Own Tent (KES {$price})",
            default => ucfirst($this->registration_type),
        };
    }

    /* =========================
       PAYMENT LABELS
    ========================= */

    public function getPaymentMethodLabelAttribute(): string
    {
        return match ($this->payment_method) {
            'bank' => 'Bank Transfer',
            'mpesa' => 'M-Pesa',
            default => 'Unknown',
        };
    }

    public function getPaymentStatusBadgeAttribute(): string
    {
        return match ($this->payment_status) {
            'verified' => '<span class="badge bg-success">Verified</span>',
            'failed' => '<span class="badge bg-danger">Failed</span>',
            default => '<span class="badge bg-warning text-dark">Pending</span>',
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'approved' => '<span class="badge bg-success">Approved</span>',
            'rejected' => '<span class="badge bg-danger">Rejected</span>',
            default => '<span class="badge bg-warning text-dark">Pending</span>',
        };
    }

    /* =========================
       FILES
    ========================= */

    public function getPaymentProofUrlAttribute(): ?string
    {
        return $this->payment_proof_path
            ? Storage::url($this->payment_proof_path)
            : null;
    }

    /* =========================
       SCOPES
    ========================= */

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeNeedsPaymentVerification($query)
    {
        return $query->where('payment_status', 'pending');
    }

    /* =========================
       RELATIONSHIPS
    ========================= */

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /* =========================
       BUSINESS LOGIC
    ========================= */

    public static function generateReferenceNumber(): string
    {
        do {
            $reference = 'EXH-' . strtoupper(substr(md5(uniqid()), 0, 8));
        } while (self::where('reference_number', $reference)->exists());

        return $reference;
    }

    public function markAsApproved(int $approvedBy, ?string $boothNumber = null): bool
    {
        return $this->update([
            'status' => 'approved',
            'approved_at' => now('Africa/Nairobi'),
            'approved_by' => $approvedBy,
            'booth_number' => $boothNumber ?? $this->booth_number,
        ]);
    }

    public function markAsRejected(?string $notes = null): bool
    {
        return $this->update([
            'status' => 'rejected',
            'admin_notes' => $notes,
        ]);
    }

    public function markPaymentAsVerified(): bool
    {
        return $this->update([
            'payment_status' => 'verified'
        ]);
    }

    public function hasApprovalEmailBeenSent(): bool
    {
        return !is_null($this->approval_email_sent_at);
    }
}