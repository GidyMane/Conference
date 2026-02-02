<?php

namespace App\Mail;

use App\Models\SubmittedAbstract;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AbstractSubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    public SubmittedAbstract $abstract;
    public int $authorCount;

    public function __construct(SubmittedAbstract $abstract)
    {
        $this->abstract = $abstract;
        $this->authorCount = $abstract->coAuthors()->count();
    }

    public function build()
    {
        return $this->subject('Abstract Submission Confirmation – 2nd KALRO Scientific Conference')
            ->view('emails.abstract_submitted')
            ->with([
                'abstract'      => $this->abstract,
                'authorCount'   => $this->authorCount,
                'submissionDate'=> now()->format('F j, Y'),
                'host'          => request()->getHost() ?? 'KALRO Conference',
            ]);
    }
}
