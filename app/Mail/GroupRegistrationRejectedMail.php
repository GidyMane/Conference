<?php

namespace App\Mail;

use App\Models\GroupRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GroupRegistrationRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $group;

    public function __construct(GroupRegistration $group)
    {
        $this->group = $group;
    }

    public function build()
    {
        return $this->subject('Group Registration Update')
                    ->view('emails.group-registration-rejected')
                    ->with([
                        'group' => $this->group,
                    ]);
    }
}