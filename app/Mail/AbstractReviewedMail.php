<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use App\Models\SubmittedAbstract;

class AbstractReviewedMail extends Mailable
{
    public function __construct(
        public SubmittedAbstract $abstract,
        public string $comment
    ) {}

    public function build()
    {
        return $this->subject('Abstract Review Result – ' . $this->abstract->status)
            ->view('emails.abstract-reviewed');
    }
}
