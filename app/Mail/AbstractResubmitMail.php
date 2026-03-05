<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class AbstractResubmitMail extends Mailable
{
    public $abstract;
    public $comment;

    public function __construct($abstract, $comment)
    {
        $this->abstract = $abstract;
        $this->comment = $comment;
    }

    public function build()
    {
        return $this->subject('Abstract Revision Required')
            ->view('emails.abstract-resubmit');
    }
}