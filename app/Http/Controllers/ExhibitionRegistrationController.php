<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\ExhibitionRegistration;

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

        // Generate a unique reference number
        $referenceNumber = 'EXH-' . strtoupper(Str::random(8));

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
            'status' => 'pending', // pending, approved, rejected
        ]);

        // Send confirmation email (optional)
        // try {
        //     Mail::to($validated['contactEmail'])->send(new ExhibitionConfirmation($registration));
        // } catch (\Exception $e) {
        //     \Log::error('Failed to send exhibition confirmation email: ' . $e->getMessage());
        // }

        // Redirect to success page with reference number
        return redirect()
            ->route('exhibition.success')
            ->with([
                'success' => 'Your exhibition registration has been submitted successfully!',
                'reference_number' => $referenceNumber
            ]);
    }

    /**
     * Display the success page
     */
    public function showSuccessPage()
    {
        return view('main.exhibition_success');
    }

    /**
     * Admin: View all registrations (optional)
     */
    public function index()
    {
        $registrations = ExhibitionRegistration::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.exhibitions.index', compact('registrations'));
    }

    /**
     * Admin: View single registration (optional)
     */
    public function show($id)
    {
        $registration = ExhibitionRegistration::findOrFail($id);
        return view('admin.exhibitions.show', compact('registration'));
    }

    /**
     * Admin: Update registration status (optional)
     */
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $registration = ExhibitionRegistration::findOrFail($id);
        $registration->update(['status' => $validated['status']]);

        return back()->with('success', 'Registration status updated successfully.');
    }
}