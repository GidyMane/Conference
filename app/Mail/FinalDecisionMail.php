<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FinalDecisionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $paper;
    public $pdfContent;

    public function __construct($paper, $pdfContent)
    {
        $this->paper = $paper;
        $this->pdfContent = $pdfContent;
    }

    public function build()
    {
        return $this->subject('Final Decision on Your Submitted Paper')
                    ->view('emails.final_decision') // Simple email body
                    ->attachData($this->pdfContent, 'review_summary.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}