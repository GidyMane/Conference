<?php

namespace App\Mail;

use App\Models\ConferenceRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $registration;

    public function __construct(ConferenceRegistration $registration)
    {
        $this->registration = $registration;
    }

    public function build()
    {
        return $this->subject('Conference Registration Update')
            ->view('emails.registration-rejected')
            ->with([
                'registration' => $this->registration,
            ]);
    }
}
