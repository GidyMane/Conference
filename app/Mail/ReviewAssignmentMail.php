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

        // ✅ Use storage path
        $this->downloadLink = asset('storage/' . $this->paper->file_path);
    }

    public function build()
    {
        return $this->view('emails.review-assignment')
            ->with([
                'assignment' => $this->assignment,
                'paper' => $this->paper,
                'reviewLink' => $this->reviewLink,
                'downloadLink' => $this->downloadLink,
            ]);
    }
}