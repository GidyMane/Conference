<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Models\ConferenceRegistration;
use App\Models\GroupRegistration;
use App\Models\GroupMember;


class ConferenceRegistrationController extends Controller
{
    public function showRegistrationForm()
    {
        return view('main.registrations');
        
    }

    public function store(Request $request)
    {
        $request->validate([
            // ======================
            // PERSONAL DETAILS
            // ======================
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|email',
            'phonePrefix' => 'required',
            'phoneNumber' => 'required',
            'institution' => 'required',
            //'country' => 'required',
            'nationality' => 'required|in:east_african,non_east_african',

            // ======================
            // REGISTRATION DETAILS
            // ======================
            'platform' => 'required|in:physical,virtual',
            'category' => 'required|in:student,professional,kalro_staff',

            // ======================
            // FILES
            // ======================
            'studentId' => 'nullable|file|max:5120',

            // ======================
            // FEE
            // ======================
            'fee' => 'required|numeric',
            'feeCurrency' => 'required',

            // ======================
            // PAYMENT
            // ======================
            'paymentMethod' => 'required|in:bank,mpesa',
            'transactionId' => 'required',
            'paymentProof' => 'required|file|max:5120',
        ]);

        // ✅ Enforce student ID if category is student
        if ($request->category === 'student' && !$request->hasFile('studentId')) {
            return back()->withErrors([
                'studentId' => 'Student ID is required for students'
            ])->withInput();
        }

        // ======================
        // FILE UPLOADS
        // ======================
        $studentIdPath = null;
        if ($request->hasFile('studentId')) {
            $studentIdPath = $request->file('studentId')
                ->store('student_ids', 'public');
        }

        $paymentProofPath = $request->file('paymentProof')
            ->store('payment_proofs', 'public');

        // ======================
        // SAVE DATA
        // ======================
        ConferenceRegistration::create([
            'first_name' => $request->firstName,
            'last_name' => $request->lastName,
            'email' => $request->email,
            'phone_prefix' => $request->phonePrefix,
            'phone_number' => $request->phoneNumber,
            'institution' => $request->institution,
            //'country' => $request->country,
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

    public function storeGroup(Request $request)
{
    // Basic validation
    $request->validate([
        'coordinatorFirstName' => 'required',
        'coordinatorLastName' => 'required',
        'coordinatorEmail' => 'required|email',
        'coordinatorPhonePrefix' => 'required',
        'coordinatorPhoneNumber' => 'required',
        'coordinatorInstitution' => 'required',
        'groupCount' => 'required|integer|min:2|max:50',
        'groupPaymentMethod' => 'required|in:bank,mpesa',
        'groupTransactionId' => 'required',
        'groupPaymentProof' => 'required|file|max:5120',
        'members' => 'required|array|min:2', // validate members exist
    ]);

    // Upload payment proof
    $paymentProofPath = $request->file('groupPaymentProof')
        ->store('group_payment_proofs', 'public');

    // Create group
    $group = GroupRegistration::create([
        'first_name' => $request->coordinatorFirstName,
        'last_name' => $request->coordinatorLastName,
        'email' => $request->coordinatorEmail,
        'phone_prefix' => $request->coordinatorPhonePrefix,
        'phone_number' => $request->coordinatorPhoneNumber,
        'institution' => $request->coordinatorInstitution,
        'group_count' => $request->groupCount,
        'total_fee' => 0, // calculate later if needed
        'currency' => 'KES',
        'payment_method' => $request->groupPaymentMethod,
        'transaction_id' => $request->groupTransactionId,
        'payment_proof_path' => $paymentProofPath,
    ]);

    // Create group members
    foreach ($request->members as $member) {
        $group->members()->create([
            'first_name' => $member['firstName'],
            'last_name' => $member['lastName'],
            'email' => $member['email'],
            'institution' => $member['institution'] ?? null,
            'nationality' => $member['nationality'] ?? null,
            'platform' => $member['platform'] ?? null,
            'category' => $member['category'] ?? null,
            'presenter' => $member['presenter'] ?? 'no',
            'paper_ref_code' => $member['paperRefCode'] ?? null,
            'student_id' => $member['studentId'] ?? null,
            'fee' => $member['fee'] ?? 0,         // add this
            'currency' => $member['currency'] ?? 'KES',  // add this
        ]);
    }

    return back()->with('success', 'Group registration submitted successfully!');
}
}