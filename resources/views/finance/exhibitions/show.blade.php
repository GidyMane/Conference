@extends('reviewer.layout')

@section('title', 'Exhibition Registration Details')
@section('page-title', 'Exhibition Registration Details')

@section('content')

@php
    $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
@endphp

<div class="page-header mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1>Registration #{{ $exhibition->reference_number }}</h1>
            <a href="{{ route('finance.exhibitions.index') }}" class="btn btn-sm btn-secondary mt-2">
                <i class="fas fa-arrow-left me-1"></i> Back to List
            </a>
        </div>

        {{-- APPROVE / REJECT BUTTONS --}}
        <div>
            @if($exhibition->status === 'pending')

                <button class="btn btn-success"
                        data-bs-toggle="modal"
                        data-bs-target="#approveModal">
                    <i class="fas fa-check me-1"></i> Approve
                </button>

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

    {{-- ORGANIZATION INFO --}}
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Organization Information</h5>
            </div>
            <div class="card-body">

                <p><strong>Organization Name:</strong> {{ $exhibition->organization_name }}</p>
                <p><strong>Reference Number:</strong> {{ $exhibition->reference_number }}</p>

                <hr>

                <h6>About Exhibition:</h6>
                <p class="text-muted">{{ $exhibition->about_exhibition }}</p>

                <h6>Target Audience:</h6>
                <p class="text-muted">{{ $exhibition->target_audience }}</p>

                <h6>Benefits to Attendees:</h6>
                <p class="text-muted">{{ $exhibition->benefits }}</p>

            </div>
        </div>
    </div>

    {{-- CONTACT INFO --}}
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Contact Information</h5>
            </div>
            <div class="card-body">

                <p><strong>Name:</strong> {{ $exhibition->contact_name }}</p>
                <p><strong>Role:</strong> {{ $exhibition->contact_role }}</p>
                <p><strong>Email:</strong> {{ $exhibition->contact_email }}</p>
                <p><strong>Phone:</strong> {{ $exhibition->contact_phone }}</p>
                <p><strong>Team Leader:</strong> {{ $exhibition->is_team_leader ? 'Yes' : 'No' }}</p>
                <p><strong>Team Size:</strong> {{ $exhibition->team_size }} persons</p>

            </div>
        </div>
    </div>

</div>

<div class="row">

    {{-- BOOTH DETAILS --}}
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Booth Details</h5>
            </div>
            <div class="card-body">

                <p><strong>Number of Booths:</strong> {{ $exhibition->booth_count }}</p>
                <p><strong>Package Type:</strong>
                    @if($exhibition->registration_type == 'with_meals')
                        <span class="badge bg-success">Premium (With Meals)</span>
                    @else
                        <span class="badge bg-secondary">Standard (Without Meals)</span>
                    @endif
                </p>
                <p><strong>Price per Booth:</strong> KES {{ number_format($exhibition->price_per_booth) }}</p>
                <p><strong>Total Amount:</strong> <strong>KES {{ number_format($exhibition->total_amount) }}</strong></p>

                @if($exhibition->booth_number)
                    <hr>
                    <p><strong>Allocated Booth Number:</strong>
                        <span class="badge bg-success fs-6">{{ $exhibition->booth_number }}</span>
                    </p>
                @endif

            </div>
        </div>
    </div>

    {{-- PAYMENT INFO --}}
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">Payment Information</h5>
            </div>
            <div class="card-body">

                <p>
                    <strong>Payment Status:</strong>
                    {!! $exhibition->payment_status_badge !!}
                </p>

                <p>
                    <strong>Registration Status:</strong>
                    {!! $exhibition->status_badge !!}
                </p>

                <p><strong>Payment Method:</strong> {{ $exhibition->payment_method_label }}</p>
                <p><strong>Receipt Number:</strong> {{ $exhibition->receipt_number ?? '—' }}</p>

                @if($exhibition->payment_proof_path)
                    <hr>
                    <p><strong>Payment Proof:</strong></p>
                    <a href="{{ route('finance.exhibitions.downloadProof', $exhibition->id) }}"
                       class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-download me-1"></i> Download Proof
                    </a>
                @endif

                @if($exhibition->admin_notes)
                    <hr>
                    <div class="alert alert-info">
                        <strong>Admin Notes:</strong><br>
                        {{ $exhibition->admin_notes }}
                    </div>
                @endif

            </div>
        </div>
    </div>

</div>

{{-- TIMELINE --}}
<div class="card mt-3 shadow-sm">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0">Timeline</h5>
    </div>

    <div class="card-body">
        <div class="row">

            <div class="col-md-3">
                <p><strong>Registered:</strong><br>
                    {{ $exhibition->created_at->format('d M Y H:i') }}
                </p>
            </div>

            @if($exhibition->approved_at)
            <div class="col-md-3">
                <p><strong>Approved:</strong><br>
                    {{ $exhibition->approved_at->format('d M Y H:i') }}
                    @if($exhibition->approver)
                        <br><small>by {{ $exhibition->approver->name }}</small>
                    @endif
                </p>
            </div>
            @endif

            @if($exhibition->confirmation_email_sent_at)
            <div class="col-md-3">
                <p><strong>Confirmation Email:</strong><br>
                    {{ $exhibition->confirmation_email_sent_at->format('d M Y H:i') }}
                </p>
            </div>
            @endif

            @if($exhibition->approval_email_sent_at)
            <div class="col-md-3">
                <p><strong>Approval Email:</strong><br>
                    {{ $exhibition->approval_email_sent_at->format('d M Y H:i') }}
                </p>
            </div>
            @endif

        </div>
    </div>
</div>

{{-- APPROVE MODAL --}}
@if($exhibition->status === 'pending')
<div class="modal fade" id="approveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('finance.exhibitions.approve', $exhibition->id) }}"
                  method="POST">
                @csrf
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Approve Registration</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Booth Number</label>
                        <input type="text" class="form-control" name="booth_number" placeholder="e.g., B12, A5" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Admin Notes</label>
                        <textarea class="form-control" name="admin_notes" rows="3"></textarea>
                    </div>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        An approval email will be sent to the exhibitor.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Approve</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- REJECT MODAL --}}
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('finance.exhibitions.reject', $exhibition->id) }}"
                  method="POST">
                @csrf
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Reject Registration</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Rejection Reason <span class="text-danger">*</span></label>
                        <textarea name="admin_notes"
                                  class="form-control"
                                  required
                                  minlength="10"
                                  rows="4"
                                  placeholder="Please provide a clear reason for rejection..."></textarea>
                        <small class="text-muted">This reason will be included in the email sent to the exhibitor.</small>
                    </div>
                    
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Warning:</strong> This action cannot be undone. A rejection email will be sent to the exhibitor with the reason provided above.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times me-1"></i> Reject & Send Email
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection

@section('scripts')
<script>
    function resendEmail(id) {
        if (confirm('Resend approval email to this exhibitor?')) {
            fetch(`{{ url('finance/exhibitions') }}/${id}/resend-email`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Email resent successfully!');
                    location.reload();
                } else {
                    alert(data.message || 'Failed to resend email');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        }
    }
</script>
@endsection