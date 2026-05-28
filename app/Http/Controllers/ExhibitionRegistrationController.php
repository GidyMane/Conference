<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\ExhibitionRegistration;
use App\Mail\ExhibitionRegistrationConfirmation;
use App\Mail\ExhibitionApprovalNotification;
use App\Mail\ExhibitionRejectionNotification;
use Carbon\Carbon;

class ExhibitionRegistrationController extends Controller
{
    /**
     * Early bird cutoff date (single source of truth)
     */
    private const EARLY_BIRD_END = '2026-05-31 23:59:59';

    /**
     * Display registration form
     */
    public function showRegistrationForm()
    {
        return view('main.exhibition_registration');
    }

    /**
     * Process registration
     */
    public function processRegistration(Request $request)
    {
        $validated = $request->validate([
            'organizationName' => 'required|string|max:255',
            'aboutExhibition'  => 'required|string|min:50',
            'benefits'         => 'required|string|min:50',
            'boothCount'       => 'required|integer|min:1|max:10',
            'registrationType' => 'required|in:standard,own_tent',
            'targetAudience'   => 'required|string|min:5',

            // IMPORTANT FIX: ensure user input is trusted OR removed later
            'calculatedTotal'  => 'required|numeric',

            'paymentMethod'    => 'required|in:bank,mpesa',
            'receiptNumber'    => 'required|string|max:255',
            'paymentProof'     => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',

            'contactName'      => 'required|string|max:255',
            'contactRole'      => 'required|string|max:255',
            'contactPhone'     => 'required|string|max:20',
            'contactEmail'     => 'required|email|max:255',

            'isTeamLeader'     => 'required|in:yes,no',
            'teamSize'         => 'required|integer|min:1|max:20',
            'terms'            => 'required|accepted',
        ]);

        DB::beginTransaction();

        try {
            $referenceNumber = ExhibitionRegistration::generateReferenceNumber();

            // Upload payment proof
            $paymentProofPath = $request->file('paymentProof')
                ? $request->file('paymentProof')->store('exhibition-payments', 'public')
                : null;

            // Early bird logic (single source)
            $isEarlyBird = now()->lte(Carbon::parse(self::EARLY_BIRD_END));

            $pricePerBooth = match ($validated['registrationType']) {
                'standard'  => $isEarlyBird ? 15000 : 20000,
                'own_tent'  => $isEarlyBird ? 8000  : 10000,
            };

            $expectedTotal = $validated['boothCount'] * $pricePerBooth;

            /**
             * FIX: prevent fake pricing submissions
             */
            if ((float) $validated['calculatedTotal'] !== (float) $expectedTotal) {
                return back()
                    ->withInput()
                    ->with('error', 'Invalid total amount detected. Please refresh and try again.');
            }

            $registration = ExhibitionRegistration::create([
                'reference_number'   => $referenceNumber,
                'organization_name'   => $validated['organizationName'],
                'about_exhibition'    => $validated['aboutExhibition'],
                'benefits'           => $validated['benefits'],
                'booth_count'        => $validated['boothCount'],
                'target_audience'    => $validated['targetAudience'],
                'registration_type'  => $validated['registrationType'],
                'total_amount'       => $expectedTotal,
                'payment_method'     => $validated['paymentMethod'],
                'receipt_number'     => $validated['receiptNumber'],
                'payment_proof_path' => $paymentProofPath,

                'contact_name'       => $validated['contactName'],
                'contact_role'       => $validated['contactRole'],
                'contact_phone'      => $validated['contactPhone'],
                'contact_email'      => $validated['contactEmail'],

                'is_team_leader'     => $validated['isTeamLeader'] === 'yes',
                'team_size'          => $validated['teamSize'],

                'status'             => 'pending',
                'payment_status'     => 'pending',
            ]);

            DB::commit();

            /**
             * Email should NOT break registration success
             */
            try {
                Mail::to($registration->contact_email)
                    ->send(new ExhibitionRegistrationConfirmation($registration));

                $registration->update([
                    'confirmation_email_sent_at' => now()
                ]);

            } catch (\Exception $e) {
                Log::error('Registration email failed: ' . $e->getMessage());
            }

            return redirect()
                ->route('exhibition.success')
                ->with([
                    'success' => 'Your exhibition registration has been submitted successfully!',
                    'reference_number' => $referenceNumber
                ]);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Registration failed: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Registration failed. Please try again.');
        }
    }

    /**
     * Success page
     */
    public function showSuccessPage()
    {
        return view('main.exhibition_success');
    }

    /**
     * Admin list
     */
    public function index(Request $request)
    {
        $query = ExhibitionRegistration::with('approver')
            ->orderBy('created_at', 'desc');

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->registration_type) {
            $query->where('registration_type', $request->registration_type);
        }

        if ($request->payment_method) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('organization_name', 'like', "%{$request->search}%")
                  ->orWhere('contact_name', 'like', "%{$request->search}%")
                  ->orWhere('contact_email', 'like', "%{$request->search}%")
                  ->orWhere('reference_number', 'like', "%{$request->search}%");
            });
        }

        $registrations = $query->paginate(15);

        $stats = [
            'total'    => ExhibitionRegistration::count(),
            'pending'  => ExhibitionRegistration::where('status', 'pending')->count(),
            'approved' => ExhibitionRegistration::where('status', 'approved')->count(),
            'rejected' => ExhibitionRegistration::where('status', 'rejected')->count(),
        ];

        return view('admin.exhibitions.index', compact('registrations', 'stats'));
    }

    /**
     * View single
     */
    public function show($id)
    {
        $registration = ExhibitionRegistration::with('approver')->findOrFail($id);
        return view('admin.exhibitions.show', compact('registration'));
    }

    /**
     * Approve
     */
    public function approve(Request $request, $id)
    {
        $validated = $request->validate([
            'booth_number' => 'nullable|string|max:50',
            'admin_notes'  => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $registration = ExhibitionRegistration::findOrFail($id);

            $registration->markAsApproved(
                auth()->id(),
                $validated['booth_number'] ?? null
            );

            $registration->markPaymentAsVerified();

            if (!empty($validated['admin_notes'])) {
                $registration->update(['admin_notes' => $validated['admin_notes']]);
            }

            DB::commit();

            try {
                Mail::to($registration->contact_email)
                    ->send(new ExhibitionApprovalNotification($registration));

                $registration->update([
                    'approval_email_sent_at' => now()
                ]);

            } catch (\Exception $e) {
                Log::error('Approval email failed: ' . $e->getMessage());
            }

            return back()->with('success', 'Registration approved successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Approval failed: ' . $e->getMessage());

            return back()->with('error', 'Approval failed.');
        }
    }

    /**
     * Reject
     */
    public function reject(Request $request, $id)
    {
        $validated = $request->validate([
            'admin_notes' => 'required|string|min:10',
        ]);

        try {
            $registration = ExhibitionRegistration::findOrFail($id);
            $registration->markAsRejected($validated['admin_notes']);

            try {
                Mail::to($registration->contact_email)
                    ->send(new ExhibitionRejectionNotification($registration));
            } catch (\Exception $e) {
                Log::error('Rejection email failed: ' . $e->getMessage());
            }

            return back()->with('success', 'Registration rejected.');

        } catch (\Exception $e) {
            Log::error('Rejection failed: ' . $e->getMessage());

            return back()->with('error', 'Rejection failed.');
        }
    }

    /**
     * Download proof
     */
    public function downloadProof($id)
    {
        $registration = ExhibitionRegistration::findOrFail($id);

        if (!$registration->payment_proof_path ||
            !Storage::disk('public')->exists($registration->payment_proof_path)) {
            return back()->with('error', 'File not found.');
        }

        return Storage::disk('public')->download(
            $registration->payment_proof_path,
            'PAYMENT_PROOF-' . $registration->reference_number
        );
    }
}