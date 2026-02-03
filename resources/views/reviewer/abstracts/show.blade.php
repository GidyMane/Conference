@extends('admin.layout')

@section('title', 'View Abstract')
@section('page-title', 'Abstract Details')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1>Abstract Details</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.abstracts.index') }}">Abstracts</a></li>
                    <li class="breadcrumb-item active">{{ $abstract->submission_id ?? 'View' }}</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('admin.abstracts.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to List
            </a>
        </div>
    </div>
</div>

<div class="row">
    <!-- Main Content -->
    <div class="col-lg-8">
        <!-- Submission Info Card -->
        <div class="card mb-4">
            <div class="card-header bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-file-alt me-2 text-kalro-primary"></i>
                        {{ $abstract->submission_id ?? 'SUB-001' }}
                    </h5>
                    <span class="badge badge-{{ strtolower(str_replace('_', '-', $abstract->status ?? 'pending')) }} fs-6">
                        {{ ucfirst(str_replace('_', ' ', $abstract->status ?? 'Pending')) }}
                    </span>
                </div>
            </div>
            <div class="card-body">
                <h4 class="mb-4">{{ $abstract->title ?? 'Abstract Title' }}</h4>
                
                <div class="mb-4">
                    <h6 class="text-muted mb-2">Abstract Content</h6>
                    <div class="border rounded p-3 bg-light">
                        <p class="mb-0" style="white-space: pre-wrap;">{{ $abstract->abstract_text ?? 'Abstract content will appear here...' }}</p>
                    </div>
                    <small class="text-muted">{{ $abstract->word_count ?? 0 }} words</small>
                </div>
                
                <div class="mb-4">
                    <h6 class="text-muted mb-2">Keywords</h6>
                    <div>
                        @foreach(explode(',', $abstract->keywords ?? 'climate-smart, agriculture, sustainability') as $keyword)
                        <span class="badge bg-info me-1 mb-1">{{ trim($keyword) }}</span>
                        @endforeach
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Sub-theme</h6>
                        <p><span class="badge bg-secondary fs-6">{{ $abstract->subtheme->name ?? 'Theme Name' }}</span></p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Submission Type</h6>
                        <p>{{ ucfirst($abstract->submission_type ?? 'Abstract') }}</p>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Presentation Preference</h6>
                        <p>{{ $abstract->presentation_preference ?? 'No Preference' }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Attendance Mode</h6>
                        <p>{{ $abstract->attendance_mode ?? 'Not Specified' }}</p>
                    </div>
                </div>
                
                @if($abstract->special_requirements)
                <div class="mb-4">
                    <h6 class="text-muted mb-2">Special Requirements</h6>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        {{ $abstract->special_requirements }}
                    </div>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Authors Card -->
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-users me-2"></i>Authors</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Institution</th>
                                <th>Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($abstract->authors ?? [] as $author)
                            <tr>
                                <td>
                                    <strong>{{ $author->name }}</strong>
                                    @if($author->is_corresponding)
                                    <span class="badge bg-success ms-2">Corresponding</span>
                                    @endif
                                </td>
                                <td>{{ $author->institution }}</td>
                                <td>{{ $author->position ?? 'Author' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-muted">No authors listed</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Review History Card -->
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-history me-2"></i>Review History</h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    @forelse($abstract->reviews ?? [] as $review)
                    <div class="timeline-item mb-3 pb-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1">{{ $review->reviewer->name ?? 'Reviewer' }}</h6>
                                <p class="mb-2">{{ $review->comments }}</p>
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ $review->created_at->format('M d, Y h:i A') }}
                                </small>
                            </div>
                            <span class="badge badge-{{ strtolower($review->status) }}">
                                {{ ucfirst($review->status) }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted mb-0">No review history yet</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Quick Actions Card -->
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    @if($abstract->status == 'pending')
                    <button class="btn btn-info" onclick="assignToReviewer()">
                        <i class="fas fa-user-plus me-2"></i>Assign to Reviewer
                    </button>
                    @endif
                    
                    @if(in_array($abstract->status, ['pending', 'under_review']))
                    <button class="btn btn-success" onclick="approveAbstract()">
                        <i class="fas fa-check me-2"></i>Approve Abstract
                    </button>
                    <button class="btn btn-danger" onclick="rejectAbstract()">
                        <i class="fas fa-times me-2"></i>Reject Abstract
                    </button>
                    @endif
                    
                    <button class="btn btn-outline-primary" onclick="sendEmail()">
                        <i class="fas fa-envelope me-2"></i>Send Email
                    </button>
                    
                    <button class="btn btn-outline-secondary" onclick="printAbstract()">
                        <i class="fas fa-print me-2"></i>Print
                    </button>
                    
                    <a href="{{ route('admin.abstracts.edit', $abstract->id) }}" class="btn btn-outline-warning">
                        <i class="fas fa-edit me-2"></i>Edit Details
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Corresponding Author Card -->
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-user me-2"></i>Corresponding Author</h5>
            </div>
            <div class="card-body">
                <p class="mb-2"><strong>{{ $abstract->author_name ?? 'John Doe' }}</strong></p>
                <p class="mb-2">
                    <i class="fas fa-envelope text-muted me-2"></i>
                    <a href="mailto:{{ $abstract->author_email ?? 'email@example.com' }}">{{ $abstract->author_email ?? 'email@example.com' }}</a>
                </p>
                <p class="mb-2">
                    <i class="fas fa-phone text-muted me-2"></i>
                    {{ $abstract->author_phone ?? '+254 700 000 000' }}
                </p>
                <p class="mb-2">
                    <i class="fas fa-building text-muted me-2"></i>
                    {{ $abstract->organization ?? 'Organization' }}
                </p>
                <p class="mb-2">
                    <i class="fas fa-briefcase text-muted me-2"></i>
                    {{ $abstract->position ?? 'Position' }}
                </p>
                <p class="mb-0">
                    <i class="fas fa-university text-muted me-2"></i>
                    {{ $abstract->department ?? 'Department' }}
                </p>
            </div>
        </div>
        
        <!-- Reviewer Assignment Card -->
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-user-tie me-2"></i>Assigned Reviewer</h5>
            </div>
            <div class="card-body">
                @if($abstract->reviewer)
                <div class="d-flex align-items-center mb-3">
                    <div class="user-avatar me-3">{{ strtoupper(substr($abstract->reviewer->name, 0, 1)) }}</div>
                    <div>
                        <p class="mb-0"><strong>{{ $abstract->reviewer->name }}</strong></p>
                        <small class="text-muted">{{ $abstract->reviewer->email }}</small>
                    </div>
                </div>
                <button class="btn btn-sm btn-outline-primary w-100" onclick="changeReviewer()">
                    Change Reviewer
                </button>
                @else
                <p class="text-muted mb-3">No reviewer assigned yet</p>
                <button class="btn btn-kalro-primary w-100" onclick="assignToReviewer()">
                    Assign Reviewer
                </button>
                @endif
            </div>
        </div>
        
        <!-- Metadata Card -->
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Metadata</h5>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <small class="text-muted">Submitted</small>
                    <p class="mb-0">{{ $abstract->created_at->format('M d, Y h:i A') ?? 'N/A' }}</p>
                </div>
                <div class="mb-2">
                    <small class="text-muted">Last Updated</small>
                    <p class="mb-0">{{ $abstract->updated_at->format('M d, Y h:i A') ?? 'N/A' }}</p>
                </div>
                @if($abstract->reviewed_at)
                <div class="mb-2">
                    <small class="text-muted">Reviewed On</small>
                    <p class="mb-0">{{ $abstract->reviewed_at->format('M d, Y h:i A') }}</p>
                </div>
                @endif
                <div>
                    <small class="text-muted">Submission ID</small>
                    <p class="mb-0"><code>{{ $abstract->submission_id ?? 'SUB-001' }}</code></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Assign/Change Reviewer Modal -->
<div class="modal fade" id="reviewerModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Reviewer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="reviewerForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Select Reviewer</label>
                        <select class="form-select" name="reviewer_id" required>
                            <option value="">Choose a reviewer...</option>
                            @foreach($reviewers ?? [] as $reviewer)
                            <option value="{{ $reviewer->id }}" {{ ($abstract->reviewer_id ?? null) == $reviewer->id ? 'selected' : '' }}>
                                {{ $reviewer->name }} - {{ $reviewer->subtheme->name ?? 'No theme' }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Add Note (Optional)</label>
                        <textarea class="form-control" name="note" rows="3" placeholder="Add any specific instructions for the reviewer..."></textarea>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="send_email" id="sendEmail" checked>
                        <label class="form-check-label" for="sendEmail">
                            Send notification email to reviewer
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-kalro-primary">Assign</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reject Abstract</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="rejectForm">
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Are you sure you want to reject this abstract?
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Reason for Rejection *</label>
                        <textarea class="form-control" name="rejection_reason" rows="4" required placeholder="Provide a clear reason for rejection..."></textarea>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="send_email" id="sendRejectEmail" checked>
                        <label class="form-check-label" for="sendRejectEmail">
                            Send notification email to author
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject Abstract</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function assignToReviewer() {
        new bootstrap.Modal(document.getElementById('reviewerModal')).show();
    }
    
    function changeReviewer() {
        new bootstrap.Modal(document.getElementById('reviewerModal')).show();
    }
    
    function approveAbstract() {
        if (confirm('Are you sure you want to approve this abstract? The author will be notified to submit the full paper.')) {
            fetch(`/admin/abstracts/{{ $abstract->id ?? 1 }}/approve`, {
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
    
    function rejectAbstract() {
        new bootstrap.Modal(document.getElementById('rejectModal')).show();
    }
    
    function sendEmail() {
        window.location.href = `/admin/abstracts/{{ $abstract->id ?? 1 }}/send-email`;
    }
    
    function printAbstract() {
        window.print();
    }
    
    // Handle reviewer form submission
    document.getElementById('reviewerForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        fetch(`/admin/abstracts/{{ $abstract->id ?? 1 }}/assign-reviewer`, {
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
                location.reload();
            }
        });
    });
    
    // Handle reject form submission
    document.getElementById('rejectForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        fetch(`/admin/abstracts/{{ $abstract->id ?? 1 }}/reject`, {
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
                location.reload();
            }
        });
    });
</script>
@endsection
