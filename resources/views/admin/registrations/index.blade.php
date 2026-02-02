@extends('admin.layout')

@section('title', 'Manage Registrations')
@section('page-title', 'Manage Registrations')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1>Manage Registrations</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Registrations</li>
                </ol>
            </nav>
        </div>
        <div>
            <div class="btn-group">
                <button class="btn btn-kalro-primary" data-bs-toggle="modal" data-bs-target="#sendInvitationModal">
                    <i class="fas fa-envelope me-2"></i>Send Invitations
                </button>
                <button class="btn btn-outline-success" onclick="exportData()">
                    <i class="fas fa-file-excel me-2"></i>Export
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Statistics -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card border-start border-primary border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Registrations</h6>
                        <h3 class="mb-0">{{ $stats['total'] ?? 0 }}</h3>
                    </div>
                    <i class="fas fa-users fa-2x text-primary"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card border-start border-success border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Paid</h6>
                        <h3 class="mb-0">{{ $stats['paid'] ?? 0 }}</h3>
                    </div>
                    <i class="fas fa-check-circle fa-2x text-success"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card border-start border-warning border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Pending Payment</h6>
                        <h3 class="mb-0">{{ $stats['pending'] ?? 0 }}</h3>
                    </div>
                    <i class="fas fa-clock fa-2x text-warning"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card border-start border-info border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Revenue</h6>
                        <h3 class="mb-0">KES {{ number_format($stats['revenue'] ?? 0) }}</h3>
                    </div>
                    <i class="fas fa-money-bill-wave fa-2x text-info"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filters</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.registrations.index') }}">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Registration Type</label>
                    <select name="type" class="form-select">
                        <option value="">All Types</option>
                        <option value="participant">Participant</option>
                        <option value="presenter">Presenter</option>
                        <option value="exhibitor">Exhibitor</option>
                        <option value="vip">VIP</option>
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label">Payment Status</label>
                    <select name="payment_status" class="form-select">
                        <option value="">All Status</option>
                        <option value="paid">Paid</option>
                        <option value="pending">Pending</option>
                        <option value="failed">Failed</option>
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label">Attendance Mode</label>
                    <select name="attendance_mode" class="form-select">
                        <option value="">All Modes</option>
                        <option value="physical">Physical</option>
                        <option value="virtual">Virtual</option>
                        <option value="hybrid">Hybrid</option>
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-kalro-primary w-100">
                        <i class="fas fa-search me-2"></i>Apply Filters
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Registrations Table -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>All Registrations</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover data-table">
                <thead>
                    <tr>
                        <th>Reg. ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Organization</th>
                        <th>Type</th>
                        <th>Attendance</th>
                        <th>Payment</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($registrations ?? [] as $registration)
                    <tr>
                        <td><strong class="text-primary">{{ $registration->registration_id }}</strong></td>
                        <td>{{ $registration->full_name }}</td>
                        <td>{{ $registration->email }}</td>
                        <td>{{ $registration->organization }}</td>
                        <td><span class="badge bg-info">{{ ucfirst($registration->type) }}</span></td>
                        <td><span class="badge bg-secondary">{{ ucfirst($registration->attendance_mode) }}</span></td>
                        <td>
                            @if($registration->payment_status == 'paid')
                                <span class="badge bg-success">Paid</span>
                            @elseif($registration->payment_status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @else
                                <span class="badge bg-danger">Failed</span>
                            @endif
                        </td>
                        <td>KES {{ number_format($registration->amount) }}</td>
                        <td>{{ $registration->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.registrations.show', $registration->id) }}" class="btn btn-info" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button class="btn btn-primary" onclick="sendConfirmation({{ $registration->id }})" title="Send Confirmation">
                                    <i class="fas fa-envelope"></i>
                                </button>
                                @if($registration->payment_status != 'paid')
                                <button class="btn btn-success" onclick="confirmPayment({{ $registration->id }})" title="Confirm Payment">
                                    <i class="fas fa-check"></i>
                                </button>
                                @endif
                                <button class="btn btn-warning" onclick="generateBadge({{ $registration->id }})" title="Generate Badge">
                                    <i class="fas fa-id-card"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted py-4">No registrations found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Send Invitation Modal -->
<div class="modal fade" id="sendInvitationModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Send Conference Invitations</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="sendInvitationForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Recipients</label>
                        <select class="form-select" name="recipients" required>
                            <option value="">Select recipients...</option>
                            <option value="all_authors">All Abstract Authors</option>
                            <option value="approved_authors">Approved Abstract Authors</option>
                            <option value="registered">Already Registered</option>
                            <option value="custom">Custom Email List</option>
                        </select>
                    </div>
                    
                    <div id="customEmailsField" style="display: none;" class="mb-3">
                        <label class="form-label">Email Addresses (comma separated)</label>
                        <textarea class="form-control" name="custom_emails" rows="4" placeholder="email1@example.com, email2@example.com"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Email Subject</label>
                        <input type="text" class="form-control" name="subject" value="Invitation to KALRO Scientific Conference 2026" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Message</label>
                        <textarea class="form-control" name="message" rows="6" required>Dear Participant,

You are cordially invited to attend the 2nd KALRO Scientific Conference and Exhibition taking place from May 18th to 22nd, 2026 in Nairobi, Kenya.

Please register at your earliest convenience.

Best regards,
KALRO Conference Team</textarea>
                    </div>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="include_registration_link" id="includeRegLink" checked>
                        <label class="form-check-label" for="includeRegLink">
                            Include registration link
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-kalro-primary">Send Invitations</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Show custom email field when selected
    document.querySelector('[name="recipients"]')?.addEventListener('change', function() {
        const customField = document.getElementById('customEmailsField');
        if (this.value === 'custom') {
            customField.style.display = 'block';
        } else {
            customField.style.display = 'none';
        }
    });
    
    function sendConfirmation(registrationId) {
        if (confirm('Send confirmation email to this participant?')) {
            fetch(`/admin/registrations/${registrationId}/send-confirmation`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Confirmation email sent successfully');
                }
            });
        }
    }
    
    function confirmPayment(registrationId) {
        if (confirm('Mark this payment as confirmed?')) {
            fetch(`/admin/registrations/${registrationId}/confirm-payment`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }
    }
    
    function generateBadge(registrationId) {
        window.open(`/admin/registrations/${registrationId}/badge`, '_blank');
    }
    
    function exportData() {
        const params = new URLSearchParams(window.location.search);
        window.location.href = '{{ route("admin.registrations.export") }}?' + params.toString();
    }
    
    // Send invitation form
    document.getElementById('sendInvitationForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        fetch('{{ route("admin.registrations.send-invitations") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(`Invitations sent successfully to ${data.count} recipients`);
                bootstrap.Modal.getInstance(document.getElementById('sendInvitationModal')).hide();
            }
        });
    });
</script>
@endsection
