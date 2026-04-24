<?php

namespace App\Http\Controllers;

use App\Models\ConferenceRegistration;
use App\Mail\RegistrationApprovedMail;
use App\Mail\RegistrationRejectedMail;
use App\Mail\GroupMemberApprovedMail;
use App\Mail\GroupRegistrationRejectedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\GroupRegistration;
use App\Models\GroupMember;


class AdminRegistrationController extends Controller
{

    public function index(Request $request)
    {
        // Individual registrations
        $registrations = ConferenceRegistration::query();

        if ($request->filled('payment_status')) {
            $registrations->where('payment_status', $request->payment_status);
        }

        if ($request->filled('platform')) {
            $registrations->where('platform', $request->platform);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $registrations->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"])
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $registrations = $registrations->latest()->paginate(10);

        // Group registrations
        $groupRegistrations = GroupRegistration::with('members')->latest()->paginate(10);

        $stats = [
            'total' => ConferenceRegistration::count() + GroupRegistration::count(),
            'approved' => ConferenceRegistration::where('payment_status', 'approved')->count() +
                        GroupRegistration::where('payment_status', 'approved')->count(),
            'pending' => ConferenceRegistration::where('payment_status', 'pending')->count() +
                        GroupRegistration::where('payment_status', 'pending')->count(),
            'rejected' => ConferenceRegistration::where('payment_status', 'rejected')->count() +
                        GroupRegistration::where('payment_status', 'rejected')->count(),
        ];

        return view('admin.registrations.index', compact('registrations', 'groupRegistrations', 'stats'));
    }

    public function show($id)
    {
        $registration = ConferenceRegistration::with('verifier')->findOrFail($id);
        return view('admin.registrations.show', compact('registration'));
    }

    public function approve($id)
    {
        return DB::transaction(function () use ($id) {

            $registration = ConferenceRegistration::lockForUpdate()->findOrFail($id);

            if ($registration->payment_status === ConferenceRegistration::STATUS_APPROVED) {
                return back()->with('error', 'Registration already approved.');
            }

            do {
                // Get highest ticket number (NOT last row)
                $lastTicketNumber = ConferenceRegistration::whereNotNull('ticket_number')
                    ->where('payment_status', ConferenceRegistration::STATUS_APPROVED)
                    ->lockForUpdate()
                    ->max('ticket_number');

                $nextNumber = $lastTicketNumber
                    ? ((int) substr($lastTicketNumber, -4)) + 1
                    : 1;

                $ticketNumber = 'KALRO_' . date('Y') . '_' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            } while (
                ConferenceRegistration::where('ticket_number', $ticketNumber)->exists()
            );

            $registration->update([
                'payment_status' => ConferenceRegistration::STATUS_APPROVED,
                'ticket_number' => $ticketNumber,
                'verified_by' => auth()->id(),
                'verified_at' => now(),
            ]);

            try {
                Mail::to($registration->email)->send(new RegistrationApprovedMail($registration));
            } catch (\Exception $e) {
                \Log::error('Failed to send approval email: ' . $e->getMessage());
            }

            return back()->with('success', 'Registration approved. Ticket: ' . $ticketNumber);
        });
    }

public function reject(Request $request, $id)
{
    $request->validate([
        'reason' => 'required|string|min:10|max:500'
    ]);

    return DB::transaction(function () use ($request, $id) {
        $registration = ConferenceRegistration::findOrFail($id);

        if ($registration->payment_status !== ConferenceRegistration::STATUS_PENDING) {
            return back()->with('error', 'Only pending registrations can be rejected.');
        }

        $registration->update([
            'payment_status' => ConferenceRegistration::STATUS_REJECTED,
            'rejection_reason' => $request->reason,
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);

        try {
            Mail::to($registration->email)->send(new RegistrationRejectedMail($registration));
        } catch (\Exception $e) {
            \Log::error('Failed to send rejection email: ' . $e->getMessage());
        }

        return back()->with('success', 'Registration rejected and notification sent.');
    });
}

    public function downloadProof($id, $type)
    {
        $registration = ConferenceRegistration::findOrFail($id);
        
        $path = $type === 'payment' 
            ? $registration->payment_proof_path 
            : $registration->student_id_path;

        if (!$path || !Storage::disk('public')->exists($path)) {
            return back()->with('error', 'File not found.');
        }

        // File extension
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        // Clean name (remove spaces/special chars)
        $fullName = $registration->first_name . '_' . $registration->last_name;
        $fullName = preg_replace('/[^A-Za-z0-9_]/', '', str_replace(' ', '_', $fullName));

        // Prefix
        $prefix = $type === 'payment' ? 'PAYMENT_PROOF' : 'STUDENT_PROOF';

        // Use registration ID
        $fileName = "{$prefix}-{$fullName}-REG_{$registration->id}.{$extension}";

        return Storage::disk('public')->download($path, $fileName);
    }

    public function showGroup($id)
    {
        // Load the group along with its members
        $group = GroupRegistration::with('members')->findOrFail($id);

        return view('admin.registrations.groupshow', compact('group'));
    }

public function approveGroup($id)
{
    // Find the group
    $group = GroupRegistration::findOrFail($id);

    if ($group->payment_status === 'approved') {
        return back()->with('error', 'Group already approved.');
    }

    // Start transaction to update group and members
    DB::transaction(function () use ($group) {

        // Approve the group
        $group->update([
            'payment_status' => 'approved',
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);

        // Fetch members fresh from DB
        $members = $group->members()->get();

        $lastTicket = GroupMember::where('group_registration_id', $group->id)
            ->whereNotNull('ticket_number')
            ->orderByDesc('id')
            ->first();

        $nextNumber = $lastTicket 
            ? intval(substr($lastTicket->ticket_number, -4)) + 1 
            : 1;

        foreach ($members as $member) {
            $ticketNumber = 'KALRO_CONF' . date('Y') . '_G' . $group->id . '_' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            $member->update([
                'payment_status' => 'approved',
                'ticket_number' => $ticketNumber,
                'verified_by' => auth()->id(),
                'verified_at' => now(),
            ]);

            $nextNumber++;
        }
    });

    // Send emails AFTER transaction commits
    $members = GroupMember::where('group_registration_id', $group->id)->get();

    foreach ($members as $member) {
        if ($member->email) {
            \Log::info('Sending approval email to member ID: ' . $member->id . ', email: ' . $member->email);
            try {
                Mail::to($member->email)->send(new GroupMemberApprovedMail($member));
            } catch (\Exception $e) {
                \Log::error('Failed to send email to member ID: ' . $member->id . ': ' . $e->getMessage());
            }
        } else {
            \Log::warning('Member ID ' . $member->id . ' has no email, skipping mail.');
        }
    }

    return back()->with('success', 'Group approved, tickets generated, and emails sent.');
}
    // Reject a group registration
public function rejectGroup(Request $request, $id)
{
    $request->validate([
        'reason' => 'required|string|min:10|max:500'
    ]);

    return DB::transaction(function () use ($request, $id) {
        $group = GroupRegistration::with('members')->findOrFail($id);

        if ($group->payment_status !== 'pending') {
            return back()->with('error', 'Only pending group registrations can be rejected.');
        }

        // Update each member
        foreach ($group->members as $member) {
            $member->update([
                'payment_status' => 'rejected',
                'rejection_reason' => $request->reason,
                'verified_by' => auth()->id(),
                'verified_at' => now(),
            ]);
        }

        // Update group
        $group->update([
            'payment_status' => 'rejected',
            'rejection_reason' => $request->reason,
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);

        // Send email only to the coordinator
        try {
            Mail::to($group->email)->send(new GroupRegistrationRejectedMail($group));
        } catch (\Exception $e) {
            \Log::error('Failed to send group rejection email: ' . $e->getMessage());
        }

        return back()->with('success', 'Group registration rejected and coordinator notified.');
    });
}

    // Download group payment proof
public function downloadGroupProof($id)
{
    $group = GroupRegistration::findOrFail($id);

    if (!$group->payment_proof_path || !Storage::disk('public')->exists($group->payment_proof_path)) {
        return back()->with('error', 'Payment proof not found.');
    }

    // File extension
    $extension = pathinfo($group->payment_proof_path, PATHINFO_EXTENSION);

    // Coordinator name
    $fullName = $group->first_name . '_' . $group->last_name;

    // Clean name
    $fullName = preg_replace('/[^A-Za-z0-9_]/', '', str_replace(' ', '_', $fullName));

    // Optional: limit length
    $fullName = substr($fullName, 0, 25);

    // Create reference
    $ref = 'KALRO_' . date('Y') . '_' . str_pad($group->id, 4, '0', STR_PAD_LEFT);

    // Final filename
    $fileName = "PAYMENT-{$fullName}-{$ref}.{$extension}";

    return Storage::disk('public')->download($group->payment_proof_path, $fileName);
}
}