<?php

namespace App\Mail;

use App\Models\User;
use App\Models\SubmittedAbstract;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AbstractReviewReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $reviewer;
    public SubmittedAbstract $abstract;

    public function __construct(User $reviewer, SubmittedAbstract $abstract)
    {
        $this->reviewer = $reviewer;
        $this->abstract = $abstract;
    }

    public function build()
    {
        return $this
            ->subject('Reminder: Abstract Review Pending')
            ->view('emails.abstract-review-reminder');
    }
}