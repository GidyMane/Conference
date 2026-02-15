@extends('admin.layout')

@section('title', 'Registration Details')
@section('page-title', 'Registration Details')

@section('content')

@php
    $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
@endphp

<div class="page-header mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1>Registration #{{ $registration->id }}</h1>
            <a href="{{ route('admin.registrations.index') }}" class="btn btn-sm btn-secondary mt-2">
                <i class="fas fa-arrow-left me-1"></i> Back to List
            </a>
        </div>

        {{-- APPROVE / REJECT BUTTONS --}}
        <div>
            @if($registration->payment_status === 'pending')

                <form action="{{ route('admin.registrations.approve', $registration->id) }}"
                      method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check me-1"></i> Approve
                    </button>
                </form>

                <button class="btn btn-danger"
                        data-bs-toggle="modal"
                        data-bs-target="#rejectModal">
                    <i class="fas fa-times me-1"></i> Reject
                </button>

            @endif
        </div>
    </div>
</div>

<div class="row">

    {{-- PARTICIPANT INFO --}}
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Participant Information</h5>
            </div>
            <div class="card-body">

                <p><strong>Full Name:</strong> {{ $registration->full_name }}</p>
                <p><strong>Email:</strong> {{ $registration->email }}</p>
                <p><strong>Phone:</strong> {{ $registration->phone_prefix }} {{ $registration->phone_number }}</p>
                <p><strong>Institution:</strong> {{ $registration->institution }}</p>
                <p><strong>Country:</strong> {{ $registration->country }}</p>

                <p><strong>Platform:</strong>
                    <span class="badge bg-secondary">
                        {{ ucfirst($registration->platform) }}
                    </span>
                </p>

                <p><strong>Category:</strong>
                    <span class="badge bg-info">
                        {{ ucfirst(str_replace('_', ' ', $registration->category)) }}
                    </span>
                </p>

            </div>
        </div>
    </div>

    {{-- PAYMENT INFO --}}
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Payment Information</h5>
            </div>
            <div class="card-body">

                <p>
                    <strong>Status:</strong>
                    @if($registration->payment_status === 'approved')
                        <span class="badge bg-success">Approved</span>
                    @elseif($registration->payment_status === 'rejected')
                        <span class="badge bg-danger">Rejected</span>
                    @else
                        <span class="badge bg-warning text-dark">Pending</span>
                    @endif
                </p>

                <p><strong>Fee:</strong>
                    {{ $registration->fee_currency }}
                    {{ number_format($registration->fee, 2) }}
                </p>

                <p><strong>Transaction ID:</strong>
                    {{ $registration->transaction_id ?? '—' }}
                </p>

                @if($registration->ticket_number)
                    <hr>
                    <p>
                        <strong>Ticket Number:</strong>
                        <span class="text-success fw-bold fs-5">
                            {{ $registration->ticket_number }}
                        </span>
                    </p>
                @endif

                @if($registration->payment_status === 'rejected')
                    <div class="alert alert-danger mt-3">
                        <strong>Rejection Reason:</strong><br>
                        {{ $registration->rejection_reason }}
                    </div>
                @endif

            </div>
        </div>
    </div>

</div>

{{-- DOCUMENTS SECTION --}}
<div class="card mt-3 shadow-sm">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0">Uploaded Documents</h5>
    </div>

    <div class="card-body">
        <div class="row">

            {{-- PAYMENT PROOF --}}
            @if($registration->payment_proof_path)
                @php
                    $paymentExtension = strtolower(pathinfo($registration->payment_proof_path, PATHINFO_EXTENSION));
                @endphp

                <div class="col-md-6 mb-4">
                    <h6>Payment Proof</h6>

                    <div class="border rounded p-3 text-center bg-light">

                        @if(in_array($paymentExtension, $imageExtensions))
                            <img src="{{ asset('storage/' . $registration->payment_proof_path) }}"
                                 class="img-fluid rounded shadow-sm"
                                 style="max-height: 350px; object-fit: contain;">
                        @else
                            <div class="py-4">
                                <i class="fas fa-file-pdf fa-3x text-danger mb-3"></i>
                                <p class="fw-semibold mb-1">This file cannot be previewed.</p>
                                <p class="text-muted">Download the PDF below.</p>
                            </div>
                        @endif

                    </div>

                    <div class="mt-2">
                        <a href="{{ route('admin.registrations.downloadProof', ['id' => $registration->id, 'type' => 'payment']) }}"
                           class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-download me-1"></i> Download
                        </a>
                    </div>
                </div>
            @endif


            {{-- STUDENT ID --}}
            @if($registration->student_id_path)
                @php
                    $studentExtension = strtolower(pathinfo($registration->student_id_path, PATHINFO_EXTENSION));
                @endphp

                <div class="col-md-6 mb-4">
                    <h6>Student ID</h6>

                    <div class="border rounded p-3 text-center bg-light">

                        @if(in_array($studentExtension, $imageExtensions))
                            <img src="{{ asset('storage/' . $registration->student_id_path) }}"
                                 class="img-fluid rounded shadow-sm"
                                 style="max-height: 350px; object-fit: contain;">
                        @else
                            <div class="py-4">
                                <i class="fas fa-file-pdf fa-3x text-danger mb-3"></i>
                                <p class="fw-semibold mb-1">This file cannot be previewed.</p>
                                <p class="text-muted">Download the PDF below.</p>
                            </div>
                        @endif

                    </div>

                    <div class="mt-2">
                        <a href="{{ route('admin.registrations.downloadProof', ['id' => $registration->id, 'type' => 'student']) }}"
                           class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-download me-1"></i> Download
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>


{{-- REJECT MODAL --}}
@if($registration->payment_status === 'pending')
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.registrations.reject', $registration->id) }}"
                  method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Reject Registration</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Rejection Reason</label>
                    <textarea name="reason"
                              class="form-control"
                              required
                              minlength="10"></textarea>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection
