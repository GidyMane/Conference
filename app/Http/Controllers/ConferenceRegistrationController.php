<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

class ConferenceRegistrationController extends Controller
{
    public function showRegistrationForm()
    {
        return view('main.registrations');
        
    }

    public function processRegistration(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'country' => 'required|string',
            'nationality' => 'required|in:east_african,non_east_african',
            'email' => 'required|email|unique:conference_registrations,email',
            'phonePrefix' => 'required|string',
            'phoneNumber' => 'required|string',
            'platform' => 'required|in:physical,virtual',
            'category' => 'required|in:student,professional,kalro_staff',
            'fee' => 'required|numeric',
            'feeCurrency' => 'required|in:KES,USD',
            'paymentMethod' => 'required|in:bank,mpesa',
            'transactionId' => 'required|string',
            'paymentProof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'studentId' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'terms' => 'required|accepted',
        ]);

        // Handle file uploads
        $paymentProofPath = null;
        if ($request->hasFile('paymentProof')) {
            $paymentProofPath = $request->file('paymentProof')->store('payment-proofs', 'public');
        }

        $studentIdPath = null;
        if ($request->hasFile('studentId')) {
            $studentIdPath = $request->file('studentId')->store('student-ids', 'public');
        }

        // Save to database (you'll need to create the migration)
        $registration = ConferenceRegistration::create([
            'first_name' => $validated['firstName'],
            'last_name' => $validated['lastName'],
            'institution' => $validated['institution'],
            'country' => $validated['country'],
            'nationality' => $validated['nationality'],
            'email' => $validated['email'],
            'phone_prefix' => $validated['phonePrefix'],
            'phone_number' => $validated['phoneNumber'],
            'platform' => $validated['platform'],
            'category' => $validated['category'],
            'fee' => $validated['fee'],
            'fee_currency' => $validated['feeCurrency'],
            'payment_method' => $validated['paymentMethod'],
            'transaction_id' => $validated['transactionId'],
            'payment_proof_path' => $paymentProofPath,
            'student_id_path' => $studentIdPath,
            'status' => 'pending', // pending, approved, rejected
        ]);

        // Send confirmation email (optional)
        // Mail::to($validated['email'])->send(new RegistrationConfirmation($registration));

        return redirect()->route('conference.register.form')
            ->with('success', 'Registration successful! Check your email for confirmation.');
    }
}