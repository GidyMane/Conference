<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\SubmittedAbstract;

class AbstractAssignedMail extends Mailable
{
    public function __construct(
        public User $reviewer,
        public SubmittedAbstract $abstract
    ) {}

    public function build()
    {
        return $this->subject('New Abstract Assigned for Review')
            ->view('emails.abstract-assigned');
    }
}
