@extends('reviewer.layout')

@section('title', 'Group Registration Details')
@section('page-title', 'Group Registration Details')

@section('content')

@php
    $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
@endphp

<div class="page-header mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1>Group Registration #{{ $group->id }}</h1>
            <a href="{{ route('finance.registrations.index') }}" class="btn btn-sm btn-secondary mt-2">
                <i class="fas fa-arrow-left me-1"></i> Back to List
            </a>
        </div>

        {{-- APPROVE / REJECT BUTTONS --}}
        <div>
            @if($group->payment_status === 'pending')
                <form action="{{ route('finance.groupRegistrations.approve', $group->id) }}"
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

    {{-- COORDINATOR INFO --}}
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Coordinator Information</h5>
            </div>
            <div class="card-body">
                <p><strong>Full Name:</strong> {{ $group->first_name }} {{ $group->last_name }}</p>
                <p><strong>Email:</strong> {{ $group->email }}</p>
                <p><strong>Phone:</strong> {{ $group->phone_prefix }} {{ $group->phone_number }}</p>
                <p><strong>Institution:</strong> {{ $group->institution }}</p>
                <p><strong>Group Count:</strong> {{ $group->group_count }}</p>
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
                    @if($group->payment_status === 'approved')
                        <span class="badge bg-success">Approved</span>
                    @elseif($group->payment_status === 'rejected')
                        <span class="badge bg-danger">Rejected</span>
                    @else
                        <span class="badge bg-warning text-dark">Pending</span>
                    @endif
                </p>

                <p><strong>Total Fee:</strong> {{ $group->currency }} {{ number_format($group->total_fee, 2) }}</p>
                <p><strong>Transaction ID:</strong> {{ $group->transaction_id ?? '—' }}</p>
                <p>
                    @if($group->payment_status === 'rejected')
                        @if($group->rejection_reason)
                            <br>
                            <small class="text-danger"><strong>Reason:</strong> {{ $group->rejection_reason }}</small>
                        @endif
                    @endif
                </p>

            </div>
        </div>
    </div>

</div>

{{-- GROUP MEMBERS --}}
<div class="card mt-3 shadow-sm">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0">Group Members</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Category</th>
                        <th>Platform</th>
                        <th>Presenter</th>
                        <th>Paper Ref</th>
                        <th>Fee</th>
                        <th>Ticket number</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($group->members as $index => $member)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $member->first_name }} {{ $member->last_name }}</td>
                            <td>{{ $member->email }}</td>
                            <td>{{ ucfirst($member->category ?? '-') }}</td>
                            <td>{{ ucfirst($member->platform ?? '-') }}</td>
                            <td>{{ ucfirst($member->presenter ?? 'No') }}</td>
                            <td>{{ $member->paper_ref_code ?? '-' }}</td>
                            <td>{{ $member->currency ?? 'KES' }} {{ number_format($member->fee ?? 0, 2) }}</td>
                            <td>{{ ucfirst($member->ticket_number ?? '-') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">No members found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- PAYMENT PROOF --}}
@if($group->payment_proof_path)
<div class="card mt-3 shadow-sm">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0">Payment Proof</h5>
    </div>
    <div class="card-body text-center">
        @php
            $paymentExtension = strtolower(pathinfo($group->payment_proof_path, PATHINFO_EXTENSION));
        @endphp

        @if(in_array($paymentExtension, $imageExtensions))
            <img src="{{ asset('storage/' . $group->payment_proof_path) }}"
                 class="img-fluid rounded shadow-sm"
                 style="max-height: 400px; object-fit: contain;">
        @else
            <div class="py-4">
                <i class="fas fa-file-pdf fa-3x text-danger mb-3"></i>
                <p class="fw-semibold mb-1">This file cannot be previewed.</p>
                <p class="text-muted">Download the PDF below.</p>
            </div>
        @endif

        <div class="mt-2">
            <a href="{{ route('finance.groupRegistrations.downloadProof', $group->id) }}"
               class="btn btn-outline-primary btn-sm">
                <i class="fas fa-download me-1"></i> Download Proof
            </a>
        </div>
    </div>
</div>
@endif

{{-- REJECT MODAL --}}
@if($group->payment_status === 'pending')
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('finance.groupRegistrations.reject', $group->id) }}"
                  method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Reject Group Registration</h5>
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

{{-- PAYMENT PROOF (only if student) --}}
@foreach($group->members as $member)
    @if(strtolower($member->category ?? '') === 'student' && $group->payment_proof_path)
        <div class="card mt-3 shadow-sm">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Student ID Proof for {{ $member->first_name }} {{ $member->last_name }}</h5>
            </div>
            <div class="card-body text-center">
                @php
                    $paymentExtension = strtolower(pathinfo($group->payment_proof_path, PATHINFO_EXTENSION));
                @endphp

                @if(in_array($paymentExtension, $imageExtensions))
                    <img src="{{ asset('storage/' . $group->payment_proof_path) }}"
                         class="img-fluid rounded shadow-sm"
                         style="max-height: 400px; object-fit: contain;">
                @else
                    <div class="py-4">
                        <i class="fas fa-file-pdf fa-3x text-danger mb-3"></i>
                        <p class="fw-semibold mb-1">This file cannot be previewed.</p>
                        <p class="text-muted">Download the PDF below.</p>
                    </div>
                @endif

                <div class="mt-2">
                    <a href="{{ route('finance.groupRegistrations.downloadProof', $group->id) }}"
                       class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-download me-1"></i> Download Proof
                    </a>
                </div>
            </div>
        </div>
    @endif
@endforeach

@endsection