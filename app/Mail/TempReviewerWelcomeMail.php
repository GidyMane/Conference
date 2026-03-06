<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class TempReviewerWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $password;

    public function __construct(User $user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    public function build()
    {
        // Hardcode the view data for testing
        return $this->from(config('mail.from.address'), config('mail.from.name'))
                    ->subject('Welcome as Temporary Reviewer - ' . config('app.name'))
                    ->view('emails.temp_reviewer_welcome')
                    ->with([
                        'name' => $this->user->full_name,
                        'email' => $this->user->email,
                        'password' => $this->password,
                        'loginUrl' => route('reviewer.login'), // Make sure this route exists
                    ]);
    }
}