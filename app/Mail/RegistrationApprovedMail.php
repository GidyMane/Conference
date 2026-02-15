<?php

namespace App\Mail;

use App\Models\ConferenceRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $registration;

    public function __construct(ConferenceRegistration $registration)
    {
        $this->registration = $registration;
    }

    public function build()
    {
        return $this->subject('KALRO Conference Registration Approved')
                    ->view('emails.registration-approved');
    }
}