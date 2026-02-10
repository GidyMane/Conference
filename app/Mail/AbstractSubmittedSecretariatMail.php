<?php

namespace App\Mail;

use App\Models\SubmittedAbstract;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AbstractSubmittedSecretariatMail extends Mailable
{
    use Queueable, SerializesModels;

    public SubmittedAbstract $abstract;
    public int $authorCount;
    public string $submissionDate;
    public string $host;

    public function __construct(SubmittedAbstract $abstract)
    {
        $this->abstract = $abstract;
        $this->authorCount = $abstract->coAuthors()->count() ?? 1;
        $this->submissionDate = $abstract->created_at->format('F j, Y');
        $this->host = config('app.url') ?? request()->getHost();
    }

    public function build()
    {
        return $this->subject('New Abstract Submission – KALRO Conference 2026')
            ->view('emails.abstract_submitted_secretariat')
            ->with([
                'abstract'       => $this->abstract,
                'authorCount'    => $this->authorCount,
                'submissionDate' => $this->submissionDate,
                'host'           => $this->host,
            ]);
    }
}