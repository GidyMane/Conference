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

public function dashboard()
    {
        // ── Single / Individual Registrations (approved only) ──
        $singleKES = ConferenceRegistration::where('payment_status', 'approved')
            ->where('fee_currency', 'KES')
            ->sum('fee');

        $singleUSD = ConferenceRegistration::where('payment_status', 'approved')
            ->where('fee_currency', 'USD')
            ->sum('fee');

        $singleCount = ConferenceRegistration::where('payment_status', 'approved')->count();

        // Break down single by attendance type
        $singleFullWeekKES = ConferenceRegistration::where('payment_status', 'approved')
            ->where('fee_currency', 'KES')
            ->where(function($q){ $q->where('attendance_type','full_week')->orWhereNull('attendance_type'); })
            ->sum('fee');

        $singlePartialKES = ConferenceRegistration::where('payment_status', 'approved')
            ->where('fee_currency', 'KES')
            ->where('attendance_type', 'partial')
            ->sum('fee');

        $singleFullWeekCount = ConferenceRegistration::where('payment_status', 'approved')
            ->where(function($q){ $q->where('attendance_type','full_week')->orWhereNull('attendance_type'); })
            ->count();

        $singlePartialCount = ConferenceRegistration::where('payment_status', 'approved')
            ->where('attendance_type', 'partial')
            ->count();

        // Partial days breakdown by day count
        $partialByDays = ConferenceRegistration::where('payment_status', 'approved')
            ->where('attendance_type', 'partial')
            ->selectRaw('days_count, COUNT(*) as registrants, SUM(fee) as collected')
            ->groupBy('days_count')
            ->orderBy('days_count')
            ->get();

        // Break down single by platform
        $singleVirtualKES = ConferenceRegistration::where('payment_status', 'approved')
            ->where('fee_currency', 'KES')
            ->where('platform', 'virtual')
            ->sum('fee');

        $singleVirtualUSD = ConferenceRegistration::where('payment_status', 'approved')
            ->where('fee_currency', 'USD')
            ->where('platform', 'virtual')
            ->sum('fee');

        $singlePhysicalKES = ConferenceRegistration::where('payment_status', 'approved')
            ->where('fee_currency', 'KES')
            ->where('platform', 'physical')
            ->sum('fee');

        $singlePhysicalUSD = ConferenceRegistration::where('payment_status', 'approved')
            ->where('fee_currency', 'USD')
            ->where('platform', 'physical')
            ->sum('fee');

        // ── Group Registrations (approved only) ──
        $groupKES = GroupRegistration::where('payment_status', 'approved')
            ->where('currency', 'KES')
            ->sum('total_fee');

        $groupUSD = GroupRegistration::where('payment_status', 'approved')
            ->where('currency', 'USD')
            ->sum('total_fee');

        $groupCount      = GroupRegistration::where('payment_status', 'approved')->count();
        $groupMemberCount = \App\Models\GroupMember::whereHas('group', fn($q) =>
            $q->where('payment_status', 'approved')
        )->count();

        // ── Exhibition Registrations (approved only) ──
        // Exhibition is always KES
        $exhibitionKES   = ExhibitionRegistration::where('status', 'approved')->sum('total_amount');
        $exhibitionCount = ExhibitionRegistration::where('status', 'approved')->count();

        // Exhibition breakdown by type
        $exhibitionByType = ExhibitionRegistration::where('status', 'approved')
            ->selectRaw('registration_type, COUNT(*) as count, SUM(total_amount) as total')
            ->groupBy('registration_type')
            ->get();

        // ── Grand Totals (KES only — USD kept separate) ──
        $grandTotalKES = $singleKES + $groupKES + $exhibitionKES;
        $grandTotalUSD = $singleUSD + $groupUSD;

        // ── Pending amounts (what could still come in) ──
        $pendingSingleKES = ConferenceRegistration::where('payment_status', 'pending')
            ->where('fee_currency', 'KES')->sum('fee');
        $pendingSingleUSD = ConferenceRegistration::where('payment_status', 'pending')
            ->where('fee_currency', 'USD')->sum('fee');
        $pendingGroupKES  = GroupRegistration::where('payment_status', 'pending')
            ->where('currency', 'KES')->sum('total_fee');
        $pendingExhibitionKES = ExhibitionRegistration::where('status', 'pending')->sum('total_amount');

        // ── Recent approvals (last 10 across all types) ──
        $recentSingle = ConferenceRegistration::where('payment_status', 'approved')
            ->latest('updated_at')->take(5)
            ->get(['first_name','last_name','fee','fee_currency','attendance_type','days_count','updated_at']);

        $recentGroup = GroupRegistration::where('payment_status', 'approved')
            ->latest('updated_at')->take(5)
            ->get(['first_name','last_name','total_fee','currency','updated_at']);

        $recentExhibition = ExhibitionRegistration::where('status', 'approved')
            ->latest('approved_at')->take(5)
            ->get(['organization_name','total_amount','approved_at']);

        return view('finance.dashboard', compact(
            // Single
            'singleKES','singleUSD','singleCount',
            'singleFullWeekKES','singlePartialKES',
            'singleFullWeekCount','singlePartialCount',
            'singleVirtualKES','singleVirtualUSD',
            'singlePhysicalKES','singlePhysicalUSD',
            'partialByDays',
            // Group
            'groupKES','groupUSD','groupCount','groupMemberCount',
            // Exhibition
            'exhibitionKES','exhibitionCount','exhibitionByType',
            // Totals
            'grandTotalKES','grandTotalUSD',
            // Pending
            'pendingSingleKES','pendingSingleUSD','pendingGroupKES','pendingExhibitionKES',
            // Recent
            'recentSingle','recentGroup','recentExhibition'
        ));
    }

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