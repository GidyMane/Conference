<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BulkAbstractMail extends Mailable
{
    use SerializesModels;

    public $subjectLine;
    public $messageBody;
    public $abstract;

    public function __construct($subjectLine, $messageBody, $abstract = null)
    {
        $this->subjectLine = $subjectLine;
        $this->messageBody = $messageBody;
        $this->abstract = $abstract;
    }

    public function build()
    {
        return $this->subject($this->subjectLine)
            ->view('emails.bulk_abstract');
    }
}