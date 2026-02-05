<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;
use App\Models\AbstractAssignment;
use App\Mail\AbstractReviewReminderMail;

class SendReviewReminders extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'app:send-review-reminders';

    /**
     * The console command description.
     */
    protected $description = 'Send reminder emails to reviewers with pending abstract reviews';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $assignments = AbstractAssignment::with(['abstract', 'reviewer'])
            ->whereNull('reminded_at')
            ->where('assigned_at', '<=', Carbon::now()->subDays(3))
            ->whereDoesntHave('abstract.reviews', function ($q) {
                $q->whereColumn(
                    'reviewer_id',
                    'abstract_assignments.reviewer_id'
                );
            })
            ->orderBy('assigned_at')
            ->limit(50) // safety limit
            ->get();

        if ($assignments->isEmpty()) {
            $this->info('No pending review reminders to send.');
            return Command::SUCCESS;
        }

        foreach ($assignments as $assignment) {
            try {
                Mail::to($assignment->reviewer->email)->send(
                    new AbstractReviewReminderMail(
                        $assignment->reviewer,
                        $assignment->abstract
                    )
                );

                $assignment->update([
                    'reminded_at' => now(),
                ]);

                $this->info("Reminder sent: Assignment #{$assignment->id}");

            } catch (\Throwable $e) {
                \Log::error('Review reminder failed', [
                    'assignment_id' => $assignment->id,
                    'error' => $e->getMessage(),
                ]);

                $this->error("Failed for Assignment #{$assignment->id}");
            }
        }

        return Command::SUCCESS;
    }
}