@extends('reviewer.layout')

@section('title', 'My Abstracts')
@section('page-title', 'My Assigned Abstracts')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1>My Assigned Abstracts</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('reviewer.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">My Abstracts</li>
                </ol>
            </nav>
            <!-- Display Reviewer's Sub-theme -->
            @if(Auth::user()->subtheme)
            <div class="reviewer-badge">
                <i class="fas fa-tag"></i> Your Sub-theme: <strong>{{ Auth::user()->subtheme->name }}</strong>
            </div>
            @endif
        </div>
        <div>
            <button class="btn btn-outline-success" onclick="exportData()">
                <i class="fas fa-file-excel me-2"></i>Export My Reviews
            </button>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filters</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('reviewer.abstracts.index') }}">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending My Review</option>
                        <option value="under_review" {{ request('status') == 'under_review' ? 'selected' : '' }}>Under Review</option>
                        <option value="reviewed" {{ request('status') == 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                
                <div class="col-md-4">
                    <label class="form-label">Date Range</label>
                    <select name="date_range" class="form-select">
                        <option value="">All Time</option>
                        <option value="today" {{ request('date_range') == 'today' ? 'selected' : '' }}>Assigned Today</option>
                        <option value="week" {{ request('date_range') == 'week' ? 'selected' : '' }}>This Week</option>
                        <option value="month" {{ request('date_range') == 'month' ? 'selected' : '' }}>This Month</option>
                    </select>
                </div>
                
                <div class="col-md-4">
                    <label class="form-label">Sort By</label>
                    <select name="sort" class="form-select">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                        <option value="deadline" {{ request('sort') == 'deadline' ? 'selected' : '' }}>Deadline Soon</option>
                    </select>
                </div>
                
                <div class="col-12">
                    <button type="submit" class="btn btn-reviewer-primary">
                        <i class="fas fa-search me-2"></i>Apply Filters
                    </button>
                    <a href="{{ route('reviewer.abstracts.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-redo me-2"></i>Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Statistics Summary -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card border-start border-warning border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Pending Review</h6>
                        <h3 class="mb-0">{{ $statusCounts['pending'] ?? 0 }}</h3>
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
                        <h6 class="text-muted mb-1">Under Review</h6>
                        <h3 class="mb-0">{{ $statusCounts['under_review'] ?? 0 }}</h3>
                    </div>
                    <i class="fas fa-search fa-2x text-info"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card border-start border-success border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Completed</h6>
                        <h3 class="mb-0">{{ $statusCounts['reviewed'] ?? 0 }}</h3>
                    </div>
                    <i class="fas fa-check-circle fa-2x text-success"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card border-start border-primary border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Assigned</h6>
                        <h3 class="mb-0">{{ $statusCounts['total'] ?? 0 }}</h3>
                    </div>
                    <i class="fas fa-file-alt fa-2x text-primary"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Urgent Deadlines Alert -->
@if(isset($upcomingDeadlines) && $upcomingDeadlines > 0)
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-triangle me-2"></i>
    <strong>Attention!</strong> You have {{ $upcomingDeadlines }} abstract(s) with review deadlines in the next 3 days.
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- Abstracts Table -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>My Assigned Abstracts</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover data-table">
                <thead>
                    <tr>
                        <th>Submission ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Status</th>
                        <th>Assigned Date</th>
                        <th>Review Deadline</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($abstracts ?? [] as $abstract)
                    <tr class="{{ $abstract->isUrgent ?? false ? 'table-warning' : '' }}">
                        <td><strong class="text-primary">{{ $abstract->submission_id }}</strong></td>
                        <td>
                            <a href="{{ route('reviewer.abstracts.show', $abstract->id) }}" class="text-decoration-none">
                                {{ Str::limit($abstract->title, 60) }}
                            </a>
                            @if($abstract->isUrgent ?? false)
                            <span class="badge bg-danger ms-1">Urgent</span>
                            @endif
                        </td>
                        <td>{{ $abstract->author_name }}</td>
                        <td>
                            @if($abstract->review_status == 'pending')
                                <span class="badge badge-pending">
                                    <i class="fas fa-clock me-1"></i>Pending Review
                                </span>
                            @elseif($abstract->review_status == 'under_review')
                                <span class="badge badge-under-review">
                                    <i class="fas fa-search me-1"></i>Under Review
                                </span>
                            @elseif($abstract->review_status == 'reviewed')
                                <span class="badge badge-reviewed">
                                    <i class="fas fa-check me-1"></i>Reviewed
                                </span>
                            @elseif($abstract->review_status == 'approved')
                                <span class="badge badge-approved">
                                    <i class="fas fa-check-circle me-1"></i>Approved
                                </span>
                            @else
                                <span class="badge badge-rejected">
                                    <i class="fas fa-times-circle me-1"></i>Rejected
                                </span>
                            @endif
                        </td>
                        <td>{{ $abstract->assigned_at ? $abstract->assigned_at->format('M d, Y') : 'N/A' }}</td>
                        <td>
                            @if($abstract->review_deadline)
                                @php
                                    $deadline = \Carbon\Carbon::parse($abstract->review_deadline);
                                    $daysLeft = now()->diffInDays($deadline, false);
                                @endphp
                                <span class="{{ $daysLeft <= 3 && $daysLeft >= 0 ? 'text-danger fw-bold' : '' }}">
                                    {{ $deadline->format('M d, Y') }}
                                    @if($daysLeft >= 0)
                                        <small class="text-muted">({{ $daysLeft }} days left)</small>
                                    @else
                                        <small class="text-danger">(Overdue)</small>
                                    @endif
                                </span>
                            @else
                                <span class="text-muted">No deadline set</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('reviewer.abstracts.show', $abstract->id) }}" class="btn btn-info" title="View & Review">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                @if($abstract->review_status != 'reviewed')
                                <a href="{{ route('reviewer.abstracts.review', $abstract->id) }}" class="btn btn-primary" title="Start Review">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @else
                                <a href="{{ route('reviewer.abstracts.review', $abstract->id) }}" class="btn btn-secondary" title="Edit Review">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                @endif
                                
                                <button class="btn btn-success" onclick="downloadAbstract({{ $abstract->id }})" title="Download PDF">
                                    <i class="fas fa-download"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                            <p class="mb-0">No abstracts have been assigned to you yet.</p>
                            <small>Please check back later or contact the administrator.</small>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Review Guidelines Modal -->
<div class="modal fade" id="guidelinesModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-book me-2"></i>Review Guidelines</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h6>General Guidelines:</h6>
                <ul>
                    <li>Review abstracts thoroughly for scientific merit, clarity, and relevance to the conference theme</li>
                    <li>Provide constructive feedback to help authors improve their work</li>
                    <li>Maintain confidentiality of all submitted abstracts</li>
                    <li>Complete reviews before the deadline</li>
                    <li>Declare any conflicts of interest</li>
                </ul>
                
                <h6 class="mt-4">Evaluation Criteria:</h6>
                <ul>
                    <li><strong>Originality:</strong> Is the research novel and innovative?</li>
                    <li><strong>Scientific Merit:</strong> Is the methodology sound and appropriate?</li>
                    <li><strong>Clarity:</strong> Is the abstract well-written and easy to understand?</li>
                    <li><strong>Relevance:</strong> Does it align with the conference sub-theme?</li>
                    <li><strong>Impact:</strong> What is the potential contribution to the field?</li>
                </ul>
                
                <div class="alert alert-info mt-4">
                    <i class="fas fa-info-circle me-2"></i>
                    For detailed review criteria, please refer to the Review Handbook in the Help section.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="#" class="btn btn-reviewer-primary">View Full Guidelines</a>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats Info -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card bg-light">
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3">
                        <i class="fas fa-star text-warning fa-2x mb-2"></i>
                        <h6 class="text-muted">Average Rating Given</h6>
                        <h4>{{ $reviewerStats['avgRating'] ?? 'N/A' }}</h4>
                    </div>
                    <div class="col-md-3">
                        <i class="fas fa-chart-line text-success fa-2x mb-2"></i>
                        <h6 class="text-muted">Reviews This Month</h6>
                        <h4>{{ $reviewerStats['monthlyReviews'] ?? 0 }}</h4>
                    </div>
                    <div class="col-md-3">
                        <i class="fas fa-clock text-info fa-2x mb-2"></i>
                        <h6 class="text-muted">Avg. Review Time</h6>
                        <h4>{{ $reviewerStats['avgReviewTime'] ?? 'N/A' }}</h4>
                    </div>
                    <div class="col-md-3">
                        <i class="fas fa-trophy text-primary fa-2x mb-2"></i>
                        <h6 class="text-muted">Total Reviews</h6>
                        <h4>{{ $reviewerStats['totalReviews'] ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Download Abstract
    function downloadAbstract(abstractId) {
        window.open(`/reviewer/abstracts/${abstractId}/download`, '_blank');
    }

    // Export Data
    function exportData() {
        const params = new URLSearchParams(window.location.search);
        window.location.href = '/' + params.toString();
    }

    // Show guidelines on first visit
    $(document).ready(function() {
        @if(session('first_visit'))
            new bootstrap.Modal(document.getElementById('guidelinesModal')).show();
        @endif
    });
</script>
@endsection