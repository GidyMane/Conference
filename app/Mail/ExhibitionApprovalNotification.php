<?php
// app/Mail/ExhibitionApprovalNotification.php

namespace App\Mail;

use App\Models\ExhibitionRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ExhibitionApprovalNotification extends Mailable
{
    use Queueable, SerializesModels;

    public ExhibitionRegistration $registration;

    /**
     * Create a new message instance.
     */
    public function __construct(ExhibitionRegistration $registration)
    {
        $this->registration = $registration;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '✓ Exhibition Registration Approved - KALRO Conference',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.exhibition-approval',
        );
    }
}