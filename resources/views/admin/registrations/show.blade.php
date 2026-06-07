@extends('admin.layout')

@section('title', 'Registration Details')
@section('page-title', 'Registration Details')

@section('content')

@php
    $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $isPartial = ($registration->attendance_type ?? 'full_week') === 'partial';
    $days      = $registration->days_count ?? null;
    $ratePerDay = $days ? ($days <= 2 ? 4500 : 4000) : null;
@endphp

<div class="page-header mb-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <h1 class="mb-0">Registration #{{ $registration->id }}</h1>
                @if($isPartial)
                    <span class="badge fs-6 fw-bold px-3 py-2 text-dark"
                          style="background:#fef3c7; border:2px solid #f59e0b; border-radius:10px;">
                        <i class="fas fa-calendar-day me-1"></i>
                        PARTIAL &ndash; {{ $days }} DAY{{ $days != 1 ? 'S' : '' }}
                    </span>
                @else
                    <span class="badge bg-success fs-6 fw-bold px-3 py-2" style="border-radius:10px;">
                        <i class="fas fa-calendar-check me-1"></i> FULL WEEK
                    </span>
                @endif
            </div>
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

{{-- PARTIAL DAYS ALERT BANNER --}}
@if($isPartial)
<div class="alert d-flex align-items-start gap-3 mb-4"
     style="background:#fffbeb; border:2px solid #f59e0b; border-radius:14px; padding:20px 24px;">
    <i class="fas fa-calendar-day fa-2x mt-1 flex-shrink-0" style="color:#d97706;"></i>
    <div>
        <h5 class="mb-1 fw-bold" style="color:#92400e;">Partial Attendance Registration</h5>
        <p class="mb-2" style="color:#78350f;">
            This participant is attending for <strong>{{ $days }} day{{ $days != 1 ? 's' : '' }}</strong>
            only, not the full conference week.
        </p>
        <div class="d-flex flex-wrap gap-3">
            <div class="px-3 py-2 rounded fw-bold" style="background:#fef3c7; color:#92400e; font-size:.9rem;">
                <i class="fas fa-tag me-1"></i>
                Rate: KES {{ number_format($ratePerDay) }} / day
            </div>
            <div class="px-3 py-2 rounded fw-bold" style="background:#fef3c7; color:#92400e; font-size:.9rem;">
                <i class="fas fa-calculator me-1"></i>
                {{ $days }} day{{ $days != 1 ? 's' : '' }} &times; KES {{ number_format($ratePerDay) }}
                = KES {{ number_format($ratePerDay * $days) }}
            </div>
        </div>
    </div>
</div>
@endif

<div class="row">

    {{-- PARTICIPANT INFO --}}
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-user me-2"></i>Participant Information</h5>
            </div>
            <div class="card-body">

                <table class="table table-borderless table-sm mb-0">
                    <tbody>
                        <tr>
                            <td class="text-muted fw-semibold" style="width:40%">Full Name</td>
                            <td><strong>{{ $registration->full_name }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">Email</td>
                            <td>{{ $registration->email }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">Phone</td>
                            <td>{{ $registration->phone_prefix }} {{ $registration->phone_number }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">Institution</td>
                            <td>{{ $registration->institution }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">Country</td>
                            <td>{{ $registration->country }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">Nationality</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $registration->nationality)) }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">Platform</td>
                            <td>
                                <span class="badge bg-secondary">{{ ucfirst($registration->platform) }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">Category</td>
                            <td>
                                <span class="badge bg-info">
                                    {{ ucfirst(str_replace('_', ' ', $registration->category)) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">Attendance</td>
                            <td>
                                @if($isPartial)
                                    <span class="badge fw-bold text-dark"
                                          style="background:#fef3c7; border:1px solid #f59e0b;">
                                        <i class="fas fa-calendar-day me-1"></i>
                                        Partial – {{ $days }} day{{ $days != 1 ? 's' : '' }}
                                    </span>
                                @else
                                    <span class="badge bg-success">
                                        <i class="fas fa-calendar-check me-1"></i> Full Week
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @if($isPartial)
                        <tr>
                            <td class="text-muted fw-semibold">Days Selected</td>
                            <td>
                                <div class="d-flex gap-1 flex-wrap">
                                    @for($i = 1; $i <= $days; $i++)
                                        <span class="badge" style="background:#1a5f3a; font-size:.8rem;">Day {{ $i }}</span>
                                    @endfor
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">Rate per Day</td>
                            <td><strong>KES {{ number_format($ratePerDay) }}</strong></td>
                        </tr>
                        @endif
                        @if($registration->paper_ref_code)
                        <tr>
                            <td class="text-muted fw-semibold">Paper Ref</td>
                            <td><code>{{ $registration->paper_ref_code }}</code></td>
                        </tr>
                        @endif
                        <tr>
                            <td class="text-muted fw-semibold">Registered On</td>
                            <td>{{ $registration->created_at->format('M d, Y H:i') }}</td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    {{-- PAYMENT INFO --}}
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-credit-card me-2"></i>Payment Information</h5>
            </div>
            <div class="card-body">

                <table class="table table-borderless table-sm mb-0">
                    <tbody>
                        <tr>
                            <td class="text-muted fw-semibold" style="width:40%">Status</td>
                            <td>
                                @if($registration->payment_status === 'approved')
                                    <span class="badge bg-success fs-6">Approved</span>
                                @elseif($registration->payment_status === 'rejected')
                                    <span class="badge bg-danger fs-6">Rejected</span>
                                @else
                                    <span class="badge bg-warning text-dark fs-6">Pending</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">Payment Method</td>
                            <td>{{ ucfirst($registration->payment_method) }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">Transaction ID</td>
                            <td><code>{{ $registration->transaction_id ?? '—' }}</code></td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">Fee</td>
                            <td>
                                <strong class="fs-5" style="color:#1a5f3a;">
                                    {{ $registration->fee_currency }}
                                    {{ number_format($registration->fee, 2) }}
                                </strong>
                                @if($isPartial)
                                    <br>
                                    <small class="text-muted">
                                        {{ $days }} day{{ $days != 1 ? 's' : '' }}
                                        &times; KES {{ number_format($ratePerDay) }}/day
                                    </small>
                                @endif
                            </td>
                        </tr>
                        @if($registration->ticket_number)
                        <tr>
                            <td class="text-muted fw-semibold">Ticket No.</td>
                            <td>
                                <span class="text-success fw-bold fs-5">
                                    {{ $registration->ticket_number }}
                                </span>
                            </td>
                        </tr>
                        @endif
                        @if($registration->verified_at)
                        <tr>
                            <td class="text-muted fw-semibold">Verified At</td>
                            <td>{{ \Carbon\Carbon::parse($registration->verified_at)->format('M d, Y H:i') }}</td>
                        </tr>
                        @endif
                    </tbody>
                </table>

                @if($registration->payment_status === 'rejected')
                    <div class="alert alert-danger mt-3">
                        <strong><i class="fas fa-times-circle me-1"></i>Rejection Reason:</strong><br>
                        {{ $registration->rejection_reason }}
                    </div>
                @endif

            </div>
        </div>
    </div>

</div>

{{-- PARTIAL DAYS FEE BREAKDOWN CARD --}}
@if($isPartial)
<div class="card shadow-sm mb-4" style="border:2px solid #f59e0b; border-radius:14px; overflow:hidden;">
    <div class="card-header fw-bold" style="background:#fef3c7; color:#92400e; border-bottom:1px solid #fde68a;">
        <i class="fas fa-calculator me-2"></i>Partial Day Fee Breakdown
    </div>
    <div class="card-body p-0">
        <table class="table table-sm mb-0">
            <thead style="background:#fffbeb;">
                <tr>
                    <th class="px-4">Day</th>
                    <th>Rate</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @for($i = 1; $i <= $days; $i++)
                <tr>
                    <td class="px-4">
                        <span class="badge" style="background:#1a5f3a;">Day {{ $i }}</span>
                    </td>
                    <td>KES {{ number_format($ratePerDay) }} / day</td>
                    <td><strong>KES {{ number_format($ratePerDay) }}</strong></td>
                </tr>
                @endfor
            </tbody>
            <tfoot style="background:#fffbeb; border-top:2px solid #fde68a;">
                <tr>
                    <td colspan="2" class="px-4 fw-bold text-end" style="color:#92400e;">Total</td>
                    <td class="fw-bold fs-5" style="color:#92400e;">
                        KES {{ number_format($ratePerDay * $days) }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endif

{{-- DOCUMENTS SECTION --}}
<div class="card mt-3 shadow-sm">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0"><i class="fas fa-file me-2"></i>Uploaded Documents</h5>
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
