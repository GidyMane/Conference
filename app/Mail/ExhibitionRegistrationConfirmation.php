<?php
// app/Mail/ExhibitionRegistrationConfirmation.php

namespace App\Mail;

use App\Models\ExhibitionRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ExhibitionRegistrationConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public ExhibitionRegistration $registration;

    public function __construct(ExhibitionRegistration $registration)
    {
        $this->registration = $registration;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Exhibition Registration Confirmation - KALRO Conference',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.exhibition-confirmation',
        );
    }
}