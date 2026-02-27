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

    public function __construct(ReviewAssignment $assignment)
    {
        $this->assignment = $assignment;
        $this->paper = $assignment->paper;

        $this->reviewLink = url('/review/' . $assignment->review_token);

        $this->downloadLink = asset(
            'full-papers/' .
            $this->paper->abstract->sub_theme_id .
            '/' .
            basename($this->paper->file_path)
        );
    }

    public function build()
    {
        $assignment = $this->assignment;

        $reviewLink = url('/review/' . $assignment->review_token);

        $downloadLink = url('/fullpapers/download/' . $assignment->full_paper_id);

        return $this->view('emails.review-assignment')
            ->with([
                'assignment' => $assignment,
                'paper' => $assignment->fullPaper,
                'reviewLink' => $reviewLink,
                'downloadLink' => $downloadLink,
            ]);
    }
}