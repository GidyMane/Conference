<?php
// app/Http/Controllers/ExhibitionRegistrationController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\ExhibitionRegistration;
use App\Mail\ExhibitionRegistrationConfirmation;
use App\Mail\ExhibitionApprovalNotification;
use App\Mail\ExhibitionRejectionNotification; 

class ExhibitionRegistrationController extends Controller
{
    /**
     * Display the exhibition registration form
     */
    public function showRegistrationForm()
    {
        return view('main.exhibition_registration');
    }

    /**
     * Process the exhibition registration
     */
    public function processRegistration(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'organizationName' => 'required|string|max:255',
            'aboutExhibition' => 'required|string|min:50',
            'benefits' => 'required|string|min:50',
            'boothCount' => 'required|integer|min:1|max:10',
            'registrationType' => 'required|in:with_meals,without_meals',
            'calculatedTotal' => 'required|numeric|min:18000',
            'paymentMethod' => 'required|in:bank,mpesa',
            'receiptNumber' => 'required|string|max:255',
            'paymentProof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'contactName' => 'required|string|max:255',
            'contactRole' => 'required|string|max:255',
            'contactPhone' => 'required|string|max:20',
            'contactEmail' => 'required|email|max:255',
            'isTeamLeader' => 'required|in:yes,no',
            'teamSize' => 'required|integer|min:1|max:20',
            'terms' => 'required|accepted',
        ]);

        DB::beginTransaction();

        try {
            // Generate a unique reference number
            $referenceNumber = ExhibitionRegistration::generateReferenceNumber();

            // Handle payment proof upload
            $paymentProofPath = null;
            if ($request->hasFile('paymentProof')) {
                $paymentProofPath = $request->file('paymentProof')->store('exhibition-payments', 'public');
            }

            // Calculate expected amount based on booth count and type
            $pricePerBooth = $validated['registrationType'] === 'with_meals' ? 25000 : 18000;
            $expectedTotal = $validated['boothCount'] * $pricePerBooth;

            // Verify the calculated total matches
            if ($validated['calculatedTotal'] != $expectedTotal) {
                return back()
                    ->withInput()
                    ->withErrors(['calculatedTotal' => 'The calculated total does not match the expected amount.']);
            }

            // Save to database
            $registration = ExhibitionRegistration::create([
                'reference_number' => $referenceNumber,
                'organization_name' => $validated['organizationName'],
                'about_exhibition' => $validated['aboutExhibition'],
                'benefits' => $validated['benefits'],
                'booth_count' => $validated['boothCount'],
                'registration_type' => $validated['registrationType'],
                'total_amount' => $expectedTotal,
                'payment_method' => $validated['paymentMethod'],
                'receipt_number' => $validated['receiptNumber'],
                'payment_proof_path' => $paymentProofPath,
                'contact_name' => $validated['contactName'],
                'contact_role' => $validated['contactRole'],
                'contact_phone' => $validated['contactPhone'],
                'contact_email' => $validated['contactEmail'],
                'is_team_leader' => $validated['isTeamLeader'] === 'yes',
                'team_size' => $validated['teamSize'],
                'status' => 'pending',
                'payment_status' => 'pending',
            ]);

            DB::commit();

            // Send confirmation email
            try {
                Mail::to($validated['contactEmail'])->send(new ExhibitionRegistrationConfirmation($registration));
                $registration->update(['confirmation_email_sent_at' => now()]);
            } catch (\Exception $e) {
                \Log::error('Failed to send exhibition confirmation email: ' . $e->getMessage());
            }

            // Redirect to success page with reference number
            return redirect()
                ->route('exhibition.success')
                ->with([
                    'success' => 'Your exhibition registration has been submitted successfully!',
                    'reference_number' => $referenceNumber
                ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Registration failed: ' . $e->getMessage());
            
            return back()
                ->withInput()
                ->with('error', 'Registration failed. Please try again.');
        }
    }

    /**
     * Display the success page
     */
    public function showSuccessPage()
    {
        return view('main.exhibition_success');
    }

    /**
     * Admin: View all registrations with filters
     */
    /**
 * Admin: View all registrations with filters
 */
public function index(Request $request)
{
    $query = ExhibitionRegistration::with('approver')->orderBy('created_at', 'desc');
    
    // Apply filters
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }
    
    if ($request->filled('registration_type')) {
        $query->where('registration_type', $request->registration_type);
    }
    
    if ($request->filled('payment_method')) {
        $query->where('payment_method', $request->payment_method);
    }
    
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('organization_name', 'like', "%{$search}%")
              ->orWhere('contact_name', 'like', "%{$search}%")
              ->orWhere('contact_email', 'like', "%{$search}%")
              ->orWhere('reference_number', 'like', "%{$search}%");
        });
    }
    
    if ($request->filled('date_from')) {
        $query->whereDate('created_at', '>=', $request->date_from);
    }
    
    if ($request->filled('date_to')) {
        $query->whereDate('created_at', '<=', $request->date_to);
    }
    
    $registrations = $query->paginate(15);
    
    // Calculate statistics
    $stats = [
        'total' => ExhibitionRegistration::count(),
        'pending' => ExhibitionRegistration::where('status', 'pending')->count(),
        'approved' => ExhibitionRegistration::where('status', 'approved')->count(),
        'rejected' => ExhibitionRegistration::where('status', 'rejected')->count(),
    ];
    
    return view('admin.exhibitions.index', compact('registrations', 'stats'));
}

    /**
     * Admin: View single registration
     */
    public function show($id)
    {
        $registration = ExhibitionRegistration::with('approver')->findOrFail($id);
        return view('admin.exhibitions.show', compact('registration'));
    }

    /**
     * Admin: Approve registration
     */
    public function approve(Request $request, $id)
    {
        $validated = $request->validate([
            'booth_number' => 'nullable|string|max:50',
            'admin_notes' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $registration = ExhibitionRegistration::findOrFail($id);
            
            // Mark as approved
            $registration->markAsApproved(
                auth()->id(), 
                $validated['booth_number'] ?? null
            );
            
            // Mark payment as verified
            $registration->markPaymentAsVerified();
            
            // Update notes if provided
            if (!empty($validated['admin_notes'])) {
                $registration->update(['admin_notes' => $validated['admin_notes']]);
            }

            DB::commit();

            // Send approval email
            try {
                Mail::to($registration->contact_email)->send(new ExhibitionApprovalNotification($registration));
                $registration->update(['approval_email_sent_at' => now()]);
                
                return redirect()
                    ->route('admin.exhibitions.show', $registration->id)
                    ->with('success', 'Registration approved successfully and notification email sent.');
                    
            } catch (\Exception $e) {
                \Log::error('Failed to send approval email: ' . $e->getMessage());
                
                return redirect()
                    ->route('admin.exhibitions.show', $registration->id)
                    ->with('warning', 'Registration approved but failed to send email notification.');
            }
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Failed to approve exhibition registration: ' . $e->getMessage());
            
            return redirect()
                ->route('admin.exhibitions.show', $id)
                ->with('error', 'Failed to approve registration. Please try again.');
        }
    }


    /**
     * Admin: Reject registration
     */
    public function reject(Request $request, $id)
    {
        $validated = $request->validate([
            'admin_notes' => 'required|string|min:10',
        ]);

        try {
            $registration = ExhibitionRegistration::findOrFail($id);
            $registration->markAsRejected($validated['admin_notes']);

            // Send rejection email
            try {
                Mail::to($registration->contact_email)->send(new ExhibitionRejectionNotification($registration));
                \Log::info('Rejection email sent to: ' . $registration->contact_email);
            } catch (\Exception $e) {
                \Log::error('Failed to send rejection email: ' . $e->getMessage());
                // Continue with rejection even if email fails
            }

            return redirect()
                ->route('admin.exhibitions.show', $registration->id)
                ->with('success', 'Registration rejected successfully. Notification email has been sent.');

        } catch (\Exception $e) {
            \Log::error('Failed to reject exhibition registration: ' . $e->getMessage());
            
            return redirect()
                ->route('admin.exhibitions.show', $id)
                ->with('error', 'Failed to reject registration. Please try again.');
        }
    }

    /**
     * Admin: Download payment proof
     */
    public function downloadProof($id)
    {
        $registration = ExhibitionRegistration::findOrFail($id);
        
        if (!$registration->payment_proof_path || !Storage::disk('public')->exists($registration->payment_proof_path)) {
            return back()->with('error', 'Payment proof file not found.');
        }

        return Storage::disk('public')->download($registration->payment_proof_path);
    }

    /**
     * Admin: Resend approval email
     */
    public function resendApprovalEmail($id)
    {
        $registration = ExhibitionRegistration::findOrFail($id);

        if ($registration->status !== 'approved') {
            return redirect()
                ->route('admin.exhibitions.show', $registration->id)
                ->with('error', 'Cannot send approval email for non-approved registration.');
        }

        try {
            Mail::to($registration->contact_email)->send(new ExhibitionApprovalNotification($registration));
            $registration->update(['approval_email_sent_at' => now()]);
            
            return redirect()
                ->route('admin.exhibitions.show', $registration->id)
                ->with('success', 'Approval email resent successfully.');
            
        } catch (\Exception $e) {
            \Log::error('Failed to resend approval email: ' . $e->getMessage());
            
            return redirect()
                ->route('admin.exhibitions.show', $registration->id)
                ->with('error', 'Failed to resend approval email.');
        }
    }

    /**
     * Admin: Update registration status
     */
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $registration = ExhibitionRegistration::findOrFail($id);
        $oldStatus = $registration->status;
        
        $registration->update(['status' => $validated['status']]);

        // If status changed to approved, send approval email
        if ($oldStatus !== 'approved' && $validated['status'] === 'approved') {
            try {
                Mail::to($registration->contact_email)->send(new ExhibitionApprovalNotification($registration));
                $registration->update(['approval_email_sent_at' => now()]);
                
                return back()->with('success', 'Registration status updated and approval email sent.');
            } catch (\Exception $e) {
                \Log::error('Failed to send approval email: ' . $e->getMessage());
                return back()->with('warning', 'Status updated but failed to send approval email.');
            }
        }

        return back()->with('success', 'Registration status updated successfully.');
    }

    /**
     * Admin: Export registrations to CSV
     */
    public function export(Request $request)
    {
        $query = ExhibitionRegistration::orderBy('created_at', 'desc');
        
        // Apply same filters as index
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('registration_type')) {
            $query->where('registration_type', $request->registration_type);
        }
        
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }
        
        $registrations = $query->get();
        
        $filename = 'exhibition-registrations-' . now()->format('Y-m-d-His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];
        
        $columns = [
            'Reference Number',
            'Organization Name',
            'Contact Name',
            'Contact Email',
            'Contact Phone',
            'Booth Count',
            'Package Type',
            'Total Amount',
            'Payment Method',
            'Payment Status',
            'Registration Status',
            'Registered Date'
        ];
        
        $callback = function() use ($registrations, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            
            foreach ($registrations as $registration) {
                fputcsv($file, [
                    $registration->reference_number,
                    $registration->organization_name,
                    $registration->contact_name,
                    $registration->contact_email,
                    $registration->contact_phone,
                    $registration->booth_count,
                    $registration->registration_type === 'with_meals' ? 'Premium' : 'Standard',
                    $registration->total_amount,
                    $registration->payment_method === 'bank' ? 'Bank Transfer' : 'M-Pesa',
                    ucfirst($registration->payment_status),
                    ucfirst($registration->status),
                    $registration->created_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}