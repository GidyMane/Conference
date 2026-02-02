@extends('admin.layout')

@section('title', 'Manage Abstracts')
@section('page-title', 'Manage Abstracts')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1>Manage Abstracts</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Abstracts</li>
                </ol>
            </nav>
        </div>
        <div>
            <button class="btn btn-kalro-primary" data-bs-toggle="modal" data-bs-target="#bulkActionModal">
                <i class="fas fa-tasks me-2"></i>Bulk Actions
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
        <form method="GET" action="{{ route('admin.abstracts.index') }}">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="under_review" {{ request('status') == 'under_review' ? 'selected' : '' }}>Under Review</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label">Sub-theme</label>
                    <select name="subtheme" class="form-select">
                        <option value="">All Sub-themes</option>
                        @foreach($subthemes ?? [] as $subtheme)
                        <option value="{{ $subtheme->id }}" {{ request('subtheme') == $subtheme->id ? 'selected' : '' }}>
                            {{ $subtheme->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label">Reviewer</label>
                    <select name="reviewer" class="form-select">
                        <option value="">All Reviewers</option>
                        <option value="unassigned" {{ request('reviewer') == 'unassigned' ? 'selected' : '' }}>Unassigned</option>
                        @foreach($reviewers ?? [] as $reviewer)
                        <option value="{{ $reviewer->id }}" {{ request('reviewer') == $reviewer->id ? 'selected' : '' }}>
                            {{ $reviewer->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label">Date Range</label>
                    <select name="date_range" class="form-select">
                        <option value="">All Time</option>
                        <option value="today" {{ request('date_range') == 'today' ? 'selected' : '' }}>Today</option>
                        <option value="week" {{ request('date_range') == 'week' ? 'selected' : '' }}>This Week</option>
                        <option value="month" {{ request('date_range') == 'month' ? 'selected' : '' }}>This Month</option>
                    </select>
                </div>
                
                <div class="col-12">
                    <button type="submit" class="btn btn-kalro-primary">
                        <i class="fas fa-search me-2"></i>Apply Filters
                    </button>
                    <a href="{{ route('admin.abstracts.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-redo me-2"></i>Reset
                    </a>
                    <button type="button" class="btn btn-outline-success" onclick="exportData()">
                        <i class="fas fa-file-excel me-2"></i>Export
                    </button>
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
                        <h6 class="text-muted mb-1">Pending</h6>
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
                        <h6 class="text-muted mb-1">Approved</h6>
                        <h3 class="mb-0">{{ $statusCounts['approved'] ?? 0 }}</h3>
                    </div>
                    <i class="fas fa-check-circle fa-2x text-success"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card border-start border-danger border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Rejected</h6>
                        <h3 class="mb-0">{{ $statusCounts['rejected'] ?? 0 }}</h3>
                    </div>
                    <i class="fas fa-times-circle fa-2x text-danger"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Abstracts Table -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>All Abstracts</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover data-table">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" id="selectAll">
                        </th>
                        <th>Submission ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Sub-theme</th>
                        <th>Status</th>
                        <th>Reviewer</th>
                        <th>Submitted</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($abstracts ?? [] as $abstract)
                    <tr>
                        <td>
                            <input type="checkbox" class="select-item" value="{{ $abstract->id }}">
                        </td>
                        <td><strong class="text-kalro-primary">{{ $abstract->submission_id }}</strong></td>
                        <td>
                            <a href="{{ route('admin.abstracts.show', $abstract->id) }}" class="text-decoration-none">
                                {{ Str::limit($abstract->title, 50) }}
                            </a>
                        </td>
                        <td>{{ $abstract->author_name }}</td>
                        <td>
                            <span class="badge bg-secondary">{{ $abstract->subtheme->name ?? 'N/A' }}</span>
                        </td>
                        <td>
                            <span class="badge badge-{{ strtolower(str_replace('_', '-', $abstract->status)) }}">
                                {{ ucfirst(str_replace('_', ' ', $abstract->status)) }}
                            </span>
                        </td>
                        <td>
                            @if($abstract->reviewer)
                                {{ $abstract->reviewer->name }}
                            @else
                                <span class="text-muted">Unassigned</span>
                            @endif
                        </td>
                        <td>{{ $abstract->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.abstracts.show', $abstract->id) }}" class="btn btn-info" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button class="btn btn-primary" onclick="assignReviewer({{ $abstract->id }})" title="Assign Reviewer">
                                    <i class="fas fa-user-plus"></i>
                                </button>
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#" onclick="changeStatus({{ $abstract->id }}, 'under_review')">Mark Under Review</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="changeStatus({{ $abstract->id }}, 'approved')">Approve</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="changeStatus({{ $abstract->id }}, 'rejected')">Reject</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#" onclick="deleteAbstract({{ $abstract->id }})">Delete</a></li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">No abstracts found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Assign Reviewer Modal -->
<div class="modal fade" id="assignReviewerModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Reviewer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="assignReviewerForm">
                <div class="modal-body">
                    <input type="hidden" id="abstract_id" name="abstract_id">
                    <div class="mb-3">
                        <label class="form-label">Select Reviewer</label>
                        <select class="form-select" name="reviewer_id" required>
                            <option value="">Choose a reviewer...</option>
                            @foreach($reviewers ?? [] as $reviewer)
                            <option value="{{ $reviewer->id }}">
                                {{ $reviewer->name }} - {{ $reviewer->subtheme->name ?? 'No theme' }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Reviewers can only be assigned abstracts from their sub-theme.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-kalro-primary">Assign Reviewer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bulk Action Modal -->
<div class="modal fade" id="bulkActionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bulk Actions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="bulkActionForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Select Action</label>
                        <select class="form-select" name="action" required>
                            <option value="">Choose an action...</option>
                            <option value="assign_reviewer">Assign Reviewer</option>
                            <option value="change_status">Change Status</option>
                            <option value="export">Export Selected</option>
                            <option value="delete">Delete Selected</option>
                        </select>
                    </div>
                    <div id="actionOptions"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-kalro-primary">Apply</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Select all checkbox
    document.getElementById('selectAll')?.addEventListener('change', function() {
        document.querySelectorAll('.select-item').forEach(cb => cb.checked = this.checked);
    });

    // Assign Reviewer
    function assignReviewer(abstractId) {
        document.getElementById('abstract_id').value = abstractId;
        new bootstrap.Modal(document.getElementById('assignReviewerModal')).show();
    }

    // Handle assign reviewer form
    document.getElementById('assignReviewerForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        // Make AJAX call here
        fetch('{{ route("admin.abstracts.assign-reviewer") }}', {
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

    // Change Status
    function changeStatus(abstractId, status) {
        if (confirm('Are you sure you want to change the status?')) {
            fetch(`/admin/abstracts/${abstractId}/status`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ status: status })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }
    }

    // Delete Abstract
    function deleteAbstract(abstractId) {
        if (confirm('Are you sure you want to delete this abstract? This action cannot be undone.')) {
            fetch(`/admin/abstracts/${abstractId}`, {
                method: 'DELETE',
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

    // Export Data
    function exportData() {
        const params = new URLSearchParams(window.location.search);
        window.location.href = '{{ route("admin.abstracts.export") }}?' + params.toString();
    }
</script>
@endsection