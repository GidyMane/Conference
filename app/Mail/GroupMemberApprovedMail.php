<?php

namespace App\Mail;

use App\Models\GroupMember;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GroupMemberApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $member;

    public function __construct(GroupMember $member)
    {
        $this->member = $member;
    }

    public function build()
    {
        return $this->subject('KALRO Group Registration Approved')
                    ->view('emails.group-member-approved');
    }
}