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

<!-- Filters -->
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
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
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
                        <option value="today" {{ request('date_range') == 'today' ? 'selected' : '' }}>Today</option>
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
                    <button type="submit" class="btn btn-reviewer-primary"><i class="fas fa-search me-2"></i>Apply Filters</button>
                    <a href="{{ route('reviewer.abstracts.index') }}" class="btn btn-outline-secondary"><i class="fas fa-redo me-2"></i>Reset</a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Stats -->
<div class="row mb-4">
    @foreach(['pending' => 'warning', 'under_review' => 'info', 'reviewed' => 'success', 'total' => 'primary'] as $status => $color)
    <div class="col-md-3 mb-3">
        <div class="card border-start border-4 border-{{ $color }}">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted text-capitalize">{{ $status == 'total' ? 'Total Assigned' : str_replace('_', ' ', $status) }}</h6>
                    <h3>{{ $statusCounts[$status] ?? 0 }}</h3>
                </div>
                <i class="fas fa-{{ match($status) {
                    'pending' => 'clock',
                    'under_review' => 'search',
                    'reviewed' => 'check-circle',
                    'total' => 'file-alt',
                } }} fa-2x text-{{ $color }}"></i>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Upcoming Deadlines -->
@if($upcomingDeadlines > 0)
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
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Submission ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Status</th>
                        <th>Assigned Date</th>
                        <th>Deadline</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($abstracts as $abstract)
                    <tr class="{{ $abstract->isUrgent ? 'table-warning' : '' }}">
                        <td><strong>{{ $abstract->submission_id }}</strong></td>
                        <td>{{ $abstract->title }}</td>
                        <td>{{ $abstract->author_name }}</td>
                        <td>{{ ucwords(str_replace('_', ' ', $abstract->review_status)) }}</td>
                        <td>
                            @php
                                $assignment = $abstract->assignments->first(); // Should be the one for this reviewer
                            @endphp
                            {{ $assignment ? $assignment->created_at->format('M d, Y') : 'N/A' }}
                        </td>

                        <td>
                            @if($abstract->review_deadline)
                                @php
                                    $daysLeft = Carbon::parse($abstract->review_deadline)->diffInDays(now(), false);
                                @endphp
                                <span class="{{ $daysLeft <= 3 && $daysLeft >= 0 ? 'text-danger fw-bold' : '' }}">
                                    {{ Carbon::parse($abstract->review_deadline)->format('M d, Y') }}
                                    @if($daysLeft >= 0)
                                        <small class="text-muted">({{ $daysLeft }} days left)</small>
                                    @else
                                        <small class="text-danger">(Overdue)</small>
                                    @endif
                                </span>
                            @else
                                <span class="text-muted">No deadline</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('reviewer.abstracts.show', $abstract->id) }}" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                <button class="btn btn-success" onclick="downloadAbstract({{ $abstract->id }})"><i class="fas fa-download"></i></button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">No abstracts assigned yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function downloadAbstract(id) {
        window.open('/reviewer/abstracts/' + id + '/download', '_blank');
    }

    function exportData() {
        const params = new URLSearchParams(window.location.search);
        window.location.href = '/reviewer/abstracts/export?' + params.toString();
    }
</script>
@endsection
