<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\ReviewAssignment;

class ReviewAssignmentMail extends Mailable
{
    use SerializesModels;

    public $assignment;
    public $paper;
    public $reviewLink;
    public $downloadLink;
    public $isResubmission;

    public function __construct(ReviewAssignment $assignment, $isResubmission = false)
    {
        $this->assignment = $assignment;

        // keep your existing relationship
        $this->paper = $assignment->fullPaper;

        // new flag
        $this->isResubmission = $isResubmission;

        $this->reviewLink = url('/review/' . $assignment->review_token);

        // keep your existing file download path
        $this->downloadLink = asset('storage/' . $this->paper->file_path);
    }

    public function build()
    {
        $subject = $this->isResubmission
            ? 'Updated Paper Submission for Review'
            : 'Paper Review Assignment';

        return $this->subject($subject)
            ->view('emails.review-assignment')
            ->with([
                'assignment' => $this->assignment,
                'paper' => $this->paper,
                'reviewLink' => $this->reviewLink,
                'downloadLink' => $this->downloadLink,
                'isResubmission' => $this->isResubmission,
            ]);
    }
}