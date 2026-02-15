<?php

namespace App\Http\Controllers;

use App\Models\ConferenceRegistration;
use App\Mail\RegistrationApprovedMail;
use App\Mail\RegistrationRejectedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class AdminRegistrationController extends Controller
{

    public function index(Request $request)
    {
        $query = ConferenceRegistration::query();

        /*
        |--------------------------------------------------------------------------
        | FILTERS
        |--------------------------------------------------------------------------
        */

        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Filter by platform
        if ($request->filled('platform')) {
            $query->where('platform', $request->platform);
        }

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"])
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */

        $registrations = $query
            ->latest()
            ->paginate(10);

        /*
        |--------------------------------------------------------------------------
        | STATISTICS (IMPORTANT: NOT FILTERED)
        |--------------------------------------------------------------------------
        */

        $stats = [
            'total'     => ConferenceRegistration::count(),
            'approved'  => ConferenceRegistration::where('payment_status', 'approved')->count(),
            'pending'   => ConferenceRegistration::where('payment_status', 'pending')->count(),
            'rejected'  => ConferenceRegistration::where('payment_status', 'rejected')->count(),
        ];

        return view('admin.registrations.index', compact('registrations', 'stats'));
    }

    public function show($id)
    {
        $registration = ConferenceRegistration::with('verifier')->findOrFail($id);
        return view('admin.registrations.show', compact('registration'));
    }

    public function approve($id)
    {
        return DB::transaction(function () use ($id) {
            $registration = ConferenceRegistration::findOrFail($id);

            // Check if already approved
            if ($registration->payment_status === ConferenceRegistration::STATUS_APPROVED) {
                return back()->with('error', 'Registration already approved.');
            }

            // Generate Ticket Number
            $lastTicket = ConferenceRegistration::whereNotNull('ticket_number')
                ->where('payment_status', ConferenceRegistration::STATUS_APPROVED)
                ->orderByDesc('id')
                ->first();

            $nextNumber = $lastTicket ? intval(substr($lastTicket->ticket_number, -4)) + 1 : 1;
            $ticketNumber = 'KALRO_' . date('Y') . '_' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

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

            return back()->with('success', 'Registration approved successfully. Ticket: ' . $ticketNumber);
        });
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|min:10|max:500'
        ]);

        return DB::transaction(function () use ($request, $id) {
            $registration = ConferenceRegistration::findOrFail($id);

            // Check if already processed
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

        return Storage::disk('public')->download($path);
    }
}