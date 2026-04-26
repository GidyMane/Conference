<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class FinanceWelcomeMail extends Mailable
{
    public $user;
    public $password;

    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Finance Account Created')
                    ->view('emails.finance-welcome');
    }
}