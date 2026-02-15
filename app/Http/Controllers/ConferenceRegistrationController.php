<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Models\ConferenceRegistration;


class ConferenceRegistrationController extends Controller
{
    public function showRegistrationForm()
    {
        return view('main.registrations');
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email',
            'paymentProof' => 'required|file|max:5120',
            'transactionId' => 'required'
        ]);

        // Upload files
        $studentIdPath = null;
        if ($request->hasFile('studentId')) {
            $studentIdPath = $request->file('studentId')->store('student_ids', 'public');
        }

        $paymentProofPath = $request->file('paymentProof')
            ->store('payment_proofs', 'public');

        ConferenceRegistration::create([
            'first_name' => $request->firstName,
            'last_name' => $request->lastName,
            'email' => $request->email,
            'phone_prefix' => $request->phonePrefix,
            'phone_number' => $request->phoneNumber,
            'institution' => $request->institution,
            'country' => $request->country,
            'nationality' => $request->nationality,
            'platform' => $request->platform,
            'category' => $request->category,
            'student_id_path' => $studentIdPath,
            'fee' => $request->fee,
            'fee_currency' => $request->feeCurrency,
            'payment_method' => $request->paymentMethod,
            'transaction_id' => $request->transactionId,
            'payment_proof_path' => $paymentProofPath,
        ]);

        return back()->with('success', 'Registration submitted. Awaiting payment verification.');
    }
}