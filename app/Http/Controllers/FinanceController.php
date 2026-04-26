<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use App\Models\ConferenceRegistration;
use App\Models\ExhibitionRegistration;
use App\Models\GroupRegistration;

class FinanceController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CONFERENCE REGISTRATIONS
    |--------------------------------------------------------------------------
    */

public function registrations(Request $request)
{
    $query = ConferenceRegistration::query();

    if ($request->filled('payment_status')) {
        $query->where('payment_status', $request->payment_status);
    }

    if ($request->filled('platform')) {
            $query->where('platform', $request->platform);
        }

    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('first_name', 'like', "%{$search}%")
              ->orWhere('last_name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('ticket_number', 'like', "%{$search}%");
        });
    }

    $registrations = $query->latest()->paginate(15);

    // ✅ ADD THIS (fix crash)


    $groupQuery = GroupRegistration::with('members');

if ($request->filled('payment_status')) {
    $groupQuery->where('payment_status', $request->payment_status);
}


if ($request->filled('search')) {
    $search = $request->search;

    $groupQuery->where(function ($q) use ($search) {
        $q->where('first_name', 'like', "%{$search}%")
          ->orWhere('last_name', 'like', "%{$search}%")
          ->orWhere('email', 'like', "%{$search}%")
          ->orWhere('institution', 'like', "%{$search}%");
    });
}

$groupRegistrations = $groupQuery->latest()->paginate(10);

    $stats = [
        'total' =>
            ConferenceRegistration::count()
            + GroupRegistration::count(),

        'approved' =>
            ConferenceRegistration::where('payment_status','approved')->count()
            + GroupRegistration::where('payment_status','approved')->count(),

        'pending' =>
            ConferenceRegistration::where('payment_status','pending')->count()
            + GroupRegistration::where('payment_status','pending')->count(),

        'rejected' =>
            ConferenceRegistration::where('payment_status','rejected')->count()
            + GroupRegistration::where('payment_status','rejected')->count(),
    ];

    return view('finance.registrations.index', compact(
        'registrations',
        'groupRegistrations',
        'stats'
    ));
}

    public function showRegistration($id)
    {
        $registration = ConferenceRegistration::findOrFail($id);

        return view('finance.registrations.show', compact('registration'));
    }

    public function approveRegistration($id)
    {
        return DB::transaction(function () use ($id) {

            $registration = ConferenceRegistration::lockForUpdate()->findOrFail($id);

            if ($registration->payment_status === 'approved') {
                return back()->with('error', 'Already approved.');
            }

            // Generate ticket number
            do {
                $lastTicket = ConferenceRegistration::whereNotNull('ticket_number')
                    ->where('payment_status', 'approved')
                    ->lockForUpdate()
                    ->max('ticket_number');

                $next = $lastTicket ? ((int) substr($lastTicket, -4)) + 1 : 1;

                $ticketNumber = 'KALRO_' . date('Y') . '_' . str_pad($next, 4, '0', STR_PAD_LEFT);

            } while (
                ConferenceRegistration::where('ticket_number', $ticketNumber)->exists()
            );

            $registration->update([
                'payment_status' => 'approved',
                'ticket_number' => $ticketNumber,
                'verified_by' => auth()->id(),
                'verified_at' => now(),
            ]);

            // Optional email (safe try-catch)
            try {
                Mail::to($registration->email)->send(
                    new \App\Mail\RegistrationApprovedMail($registration)
                );
            } catch (\Exception $e) {
                \Log::error('Finance approval email failed: ' . $e->getMessage());
            }

            return back()->with('success', 'Registration approved successfully.');
        });
    }

    public function rejectRegistration(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|min:10'
        ]);

        $registration = ConferenceRegistration::findOrFail($id);

        if ($registration->payment_status !== 'pending') {
            return back()->with('error', 'Only pending registrations can be rejected.');
        }

        $registration->update([
            'payment_status' => 'rejected',
            'rejection_reason' => $request->reason,
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);

        try {
            Mail::to($registration->email)->send(
                new \App\Mail\RegistrationRejectedMail($registration)
            );
        } catch (\Exception $e) {
            \Log::error('Finance rejection email failed: ' . $e->getMessage());
        }

        return back()->with('success', 'Registration rejected successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | EXHIBITION REGISTRATIONS
    |--------------------------------------------------------------------------
    */

    public function exhibitions(Request $request)
    {
        $query = ExhibitionRegistration::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('registration_type')) {
        $query->where('registration_type', $request->registration_type);
    }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('organization_name', 'like', "%{$search}%")
                  ->orWhere('contact_name', 'like', "%{$search}%")
                  ->orWhere('contact_email', 'like', "%{$search}%")
                  ->orWhere('reference_number', 'like', "%{$search}%");
            });
        }

        $exhibitions = $query->latest()->paginate(15);
        
        $stats = [
            'total' => ExhibitionRegistration::count(),
            'approved' => ExhibitionRegistration::where('status', 'approved')->count(),
            'pending' => ExhibitionRegistration::where('status', 'pending')->count(),
            'rejected' => ExhibitionRegistration::where('status', 'rejected')->count(),
        ];

        return view('finance.exhibitions.index', compact('exhibitions', 'stats'));
    }

    public function showExhibition($id)
    {
        $exhibition = ExhibitionRegistration::findOrFail($id);

        return view('finance.exhibitions.show', compact('exhibition'));
    }

    public function approveExhibition($id)
    {
        $exhibition = ExhibitionRegistration::findOrFail($id);

        if ($exhibition->status === 'approved') {
            return back()->with('error', 'Already approved.');
        }

        // ✅ STEP 1: VERIFY PAYMENT AUTOMATICALLY
        // (since you're manually approving, this acts as "finance verification")
        $exhibition->payment_status = 'verified';

        // ✅ STEP 2: APPROVE REGISTRATION
        $exhibition->status = 'approved';
        $exhibition->approved_by = auth()->id();
        $exhibition->approved_at = now();

        $exhibition->save();

        // Email
        try {
            Mail::to($exhibition->contact_email)->send(
                new \App\Mail\ExhibitionApprovalNotification($exhibition)
            );
        } catch (\Exception $e) {
            \Log::error('Exhibition approval email failed: ' . $e->getMessage());
        }

        return back()->with('success', 'Payment verified and exhibition approved successfully.');
    }

    public function rejectExhibition(Request $request, $id)
    {
        $request->validate([
            'admin_notes' => 'required|string|min:10'
        ]);

        $exhibition = ExhibitionRegistration::findOrFail($id);

        if ($exhibition->status !== 'pending') {
            return back()->with('error', 'Only pending exhibitions can be rejected.');
        }

        $exhibition->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes,
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        try {
            Mail::to($exhibition->contact_email)->send(
                new \App\Mail\ExhibitionRejectionNotification($exhibition)
            );
        } catch (\Exception $e) {
            \Log::error('Exhibition rejection email failed: ' . $e->getMessage());
        }

        return back()->with('success', 'Exhibition rejected successfully.');
    }

    public function showGroup($id)
    {
        // Load the group along with its members
        $group = GroupRegistration::with('members')->findOrFail($id);

        return view('finance.registrations.groupshow', compact('group'));
    }
}