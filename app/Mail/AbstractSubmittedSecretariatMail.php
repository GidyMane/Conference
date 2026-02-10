<?php

namespace App\Mail;

use App\Models\SubmittedAbstract;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AbstractSubmittedSecretariatMail extends Mailable
{
    use Queueable, SerializesModels;

    public $abstract;

    /**
     * Create a new message instance.
     *
     * @param SubmittedAbstract $abstract
     */
    public function __construct(SubmittedAbstract $abstract)
    {
        $this->abstract = $abstract;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('New Abstract Submission – KALRO Conference 2026')
            ->markdown('emails.abstract_submitted_secretariat');
    }
}