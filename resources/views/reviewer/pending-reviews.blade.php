@extends('reviewer.layout')

@section('title', 'Pending Reviews')

@section('content')
<style>
    :root {
        --primary-blue: #1e5a8e;
        --light-blue: #e8f4f8;
        --warning-yellow: #ffc107;
        --success-green: #28a745;
    }

    .page-header {
        margin-bottom: 30px;
    }

    .page-title {
        font-size: 28px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 10px;
    }

    /* Stats Cards */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
        border-left: 4px solid;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .stat-card.warning {
        border-left-color: var(--warning-yellow);
    }

    .stat-card.info {
        border-left-color: #17a2b8;
    }

    .stat-card-content h6 {
        font-size: 14px;
        color: #6c757d;
        margin-bottom: 5px;
        text-transform: uppercase;
        font-weight: 500;
    }

    .stat-card-content h3 {
        font-size: 32px;
        font-weight: 700;
        margin: 0;
        color: #2c3e50;
    }

    .stat-card-icon {
        font-size: 40px;
        opacity: 0.3;
    }

    .stat-card.warning .stat-card-icon {
        color: var(--warning-yellow);
    }

    .stat-card.info .stat-card-icon {
        color: #17a2b8;
    }

    /* Filter Section */
    .filter-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
        margin-bottom: 25px;
    }

    .filter-header {
        background: linear-gradient(135deg, var(--primary-blue) 0%, #0d3d5c 100%);
        padding: 15px 20px;
        color: white;
        border-radius: 8px 8px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .filter-title {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
    }

    .filter-body {
        padding: 20px;
    }

    .filter-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 15px;
    }

    .btn-filter {
        background: var(--primary-blue);
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 5px;
        font-weight: 500;
        transition: all 0.3s;
    }

    .btn-filter:hover {
        background: #0d3d5c;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .btn-reset {
        background: #6c757d;
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 5px;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s;
    }

    .btn-reset:hover {
        background: #5a6268;
        color: white;
    }

    /* Table Card */
    .table-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .table {
        margin-bottom: 0;
    }

    .table thead th {
        background: var(--primary-blue);
        color: white;
        border: none;
        padding: 15px 12px;
        font-weight: 600;
        font-size: 14px;
        text-transform: uppercase;
    }

    .table tbody td {
        padding: 12px;
        vertical-align: middle;
        font-size: 14px;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
    }

    /* Status Badges */
    .status-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        display: inline-block;
    }

    .status-badge.pending {
        background: #fff3cd;
        color: #856404;
    }

    .status-badge.under-review {
        background: #d1ecf1;
        color: #0c5460;
    }

    /* Action Buttons */
    .btn-view {
        background: var(--primary-blue);
        color: white;
        border: none;
        padding: 6px 15px;
        border-radius: 5px;
        font-size: 13px;
        transition: all 0.3s;
    }

    .btn-view:hover {
        background: #0d3d5c;
        color: white;
        transform: translateY(-1px);
    }

    .btn-download {
        background: #28a745;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 5px;
        font-size: 13px;
        transition: all 0.3s;
    }

    .btn-download:hover {
        background: #218838;
        color: white;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 64px;
        margin-bottom: 20px;
        opacity: 0.3;
    }

    .empty-state h3 {
        font-size: 24px;
        margin-bottom: 10px;
        color: #495057;
    }

    /* Modal */
    .modal-header {
        background: linear-gradient(135deg, var(--primary-blue) 0%, #0d3d5c 100%);
        color: white;
    }

    .abstract-content {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        border-left: 4px solid var(--primary-blue);
        line-height: 1.8;
        white-space: pre-wrap;
    }

    .keywords-badge {
        display: inline-block;
        background: var(--light-blue);
        color: var(--primary-blue);
        padding: 5px 12px;
        border-radius: 15px;
        margin: 3px;
        font-size: 13px;
        font-weight: 500;
    }

    .submission-meta {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .submission-meta p {
        margin-bottom: 10px;
        line-height: 1.6;
    }
</style>

<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-clock me-2"></i>Pending Reviews
    </h1>
    <p class="text-muted">Abstracts assigned to you that are awaiting review</p>
</div>

<!-- Statistics Cards -->
<div class="stats-row">
    <div class="stat-card warning">
        <div class="stat-card-content">
            <h6>Pending Reviews</h6>
            <h3>{{ $stats['pending'] ?? 0 }}</h3>
        </div>
        <div class="stat-card-icon">
            <i class="fas fa-clock"></i>
        </div>
    </div>

    <div class="stat-card info">
        <div class="stat-card-content">
            <h6>Under Review</h6>
            <h3>{{ $stats['under_review'] ?? 0 }}</h3>
        </div>
        <div class="stat-card-icon">
            <i class="fas fa-search"></i>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="filter-card">
    <div class="filter-header">
        <h2 class="filter-title"><i class="fas fa-filter me-2"></i>Filter Abstracts</h2>
    </div>
    <div class="filter-body">
        <form method="GET" action="{{ route('reviewer.pending-reviews') }}">
            <div class="filter-row">
                <div class="form-group">
                    <label for="status" class="form-label">
                        <i class="fas fa-circle me-1"></i> Status
                    </label>
                    <select name="status" id="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="assigned" {{ request('status') == 'assigned' ? 'selected' : '' }}>Assigned</option>
                        <option value="under_review" {{ request('status') == 'under_review' ? 'selected' : '' }}>Under Review</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="date_from" class="form-label">
                        <i class="fas fa-calendar me-1"></i> Date Assigned
                    </label>
                    <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-filter">
                    <i class="fas fa-search me-1"></i> Apply Filters
                </button>
                <a href="{{ route('reviewer.pending-reviews') }}" class="btn btn-reset">
                    <i class="fas fa-times me-1"></i> Clear
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Pending Reviews Table -->
<div class="table-card">
    @if($pendingReviews->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Submission ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Sub-theme</th>
                        <th>Status</th>
                        <th>Assigned Date</th>
                        <th>Deadline</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingReviews as $assignment)
                    <tr>
                        <td><strong class="text-primary">{{ $assignment->abstract->submission_code }}</strong></td>
                        <td>{{ Str::limit($assignment->abstract->paper_title, 50) }}</td>
                        <td>{{ $assignment->abstract->author_name }}</td>
                        <td><span class="badge bg-secondary">{{ $assignment->abstract->subTheme->name ?? 'N/A' }}</span></td>
                        <td>
                            <span class="status-badge {{ strtolower(str_replace('_', '-', $assignment->status)) }}">
                                {{ ucfirst(str_replace('_', ' ', $assignment->status)) }}
                            </span>
                        </td>
                        <td>{{ $assignment->assigned_at->format('M d, Y') }}</td>
                        <td>
                            @if($assignment->deadline)
                                {{ $assignment->deadline->format('M d, Y') }}
                            @else
                                <span class="text-muted">No deadline</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-view view-abstract"
                                        data-bs-toggle="modal"
                                        data-bs-target="#reviewModal"
                                        data-assignment-id="{{ $assignment->id }}"
                                        data-abstract-id="{{ $assignment->abstract->id }}"
                                        data-code="{{ $assignment->abstract->submission_code }}"
                                        data-title="{{ $assignment->abstract->paper_title }}"
                                        data-author="{{ $assignment->abstract->author_name }}"
                                        data-email="{{ $assignment->abstract->author_email }}"
                                        data-org="{{ $assignment->abstract->organisation }}"
                                        data-theme="{{ $assignment->abstract->subTheme->name ?? 'N/A' }}"
                                        data-abstract="{{ $assignment->abstract->abstract_text }}"
                                        data-keywords="{{ $assignment->abstract->keywords }}"
                                        data-status="{{ $assignment->status }}">
                                    <i class="fas fa-eye me-1"></i> Review
                                </button>
                                @if($assignment->abstract->uploaded_file)
                                <a href="{{ Storage::url($assignment->abstract->uploaded_file) }}" 
                                   class="btn btn-download" 
                                   target="_blank"
                                   title="Download Abstract">
                                    <i class="fas fa-download"></i>
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-3">
            {{ $pendingReviews->links() }}
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <h3>No Pending Reviews</h3>
            <p>You don't have any abstracts pending review at the moment.</p>
        </div>
    @endif
</div>

<!-- Review Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-file-alt me-2"></i>Review Abstract
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Abstract Details -->
                <div class="submission-meta">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-hashtag me-2"></i>Submission Code:</strong> 
                               <span id="modalCode" class="text-primary fw-bold"></span></p>
                            <p><strong><i class="fas fa-user me-2"></i>Author:</strong> 
                               <span id="modalAuthor"></span></p>
                            <p><strong><i class="fas fa-envelope me-2"></i>Email:</strong> 
                               <span id="modalEmail"></span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-building me-2"></i>Organization:</strong> 
                               <span id="modalOrg"></span></p>
                            <p><strong><i class="fas fa-tag me-2"></i>Sub-Theme:</strong> 
                               <span id="modalTheme" class="badge bg-secondary"></span></p>
                            <p><strong><i class="fas fa-circle me-2"></i>Current Status:</strong> 
                               <span id="modalStatus"></span></p>
                        </div>
                    </div>
                </div>

                <!-- Paper Title -->
                <div class="mb-4">
                    <h6 class="text-primary mb-3">
                        <i class="fas fa-heading me-2"></i>Paper Title
                    </h6>
                    <div class="card">
                        <div class="card-body">
                            <h5 id="modalTitle" class="card-title mb-0"></h5>
                        </div>
                    </div>
                </div>

                <!-- Abstract Content -->
                <div class="row mb-4">
                    <div class="col-md-8">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-file-lines me-2"></i>Abstract Content
                        </h6>
                        <div class="abstract-content" id="modalAbstract"></div>
                    </div>
                    <div class="col-md-4">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-tags me-2"></i>Keywords
                        </h6>
                        <div id="modalKeywords" class="mb-3"></div>
                    </div>
                </div>

                <!-- Review Form -->
                <form id="reviewForm" action="{{ route('reviewer.submit-review') }}" method="POST">
                    @csrf
                    <input type="hidden" name="assignment_id" id="assignmentId">
                    <input type="hidden" name="abstract_id" id="abstractId">

                    <!-- Review Comment -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-comment me-1"></i> Review Comments
                        </label>
                        <textarea class="form-control" name="comments" rows="4" 
                                  placeholder="Provide detailed feedback on the abstract..." required></textarea>
                    </div>

                    <!-- Review Scores -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label class="form-label">Relevance (1-5)</label>
                            <select name="relevance_score" class="form-select" required>
                                <option value="">Select</option>
                                <option value="1">1 - Poor</option>
                                <option value="2">2 - Fair</option>
                                <option value="3">3 - Good</option>
                                <option value="4">4 - Very Good</option>
                                <option value="5">5 - Excellent</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Methodology (1-5)</label>
                            <select name="methodology_score" class="form-select" required>
                                <option value="">Select</option>
                                <option value="1">1 - Poor</option>
                                <option value="2">2 - Fair</option>
                                <option value="3">3 - Good</option>
                                <option value="4">4 - Very Good</option>
                                <option value="5">5 - Excellent</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Originality (1-5)</label>
                            <select name="originality_score" class="form-select" required>
                                <option value="">Select</option>
                                <option value="1">1 - Poor</option>
                                <option value="2">2 - Fair</option>
                                <option value="3">3 - Good</option>
                                <option value="4">4 - Very Good</option>
                                <option value="5">5 - Excellent</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Clarity (1-5)</label>
                            <select name="clarity_score" class="form-select" required>
                                <option value="">Select</option>
                                <option value="1">1 - Poor</option>
                                <option value="2">2 - Fair</option>
                                <option value="3">3 - Good</option>
                                <option value="4">4 - Very Good</option>
                                <option value="5">5 - Excellent</option>
                            </select>
                        </div>
                    </div>

                    <!-- Decision -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-gavel me-1"></i> Decision
                        </label>
                        <select name="decision" class="form-select" required>
                            <option value="">Select Decision</option>
                            <option value="APPROVED">Approve</option>
                            <option value="REJECTED">Reject</option>
                            <option value="NEEDS_REVISION">Needs Revision</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-paper-plane me-1"></i> Submit Review
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.view-abstract').forEach(btn => {
        btn.addEventListener('click', () => {
            const data = btn.dataset;
            
            document.getElementById('assignmentId').value = data.assignmentId;
            document.getElementById('abstractId').value = data.abstractId;
            document.getElementById('modalCode').textContent = data.code;
            document.getElementById('modalTitle').textContent = data.title;
            document.getElementById('modalAuthor').textContent = data.author;
            document.getElementById('modalEmail').textContent = data.email;
            document.getElementById('modalOrg').textContent = data.org;
            document.getElementById('modalTheme').textContent = data.theme;
            document.getElementById('modalAbstract').textContent = data.abstract;
            
            // Render status
            const statusEl = document.getElementById('modalStatus');
            const cls = data.status.toLowerCase().replace('_', '-');
            statusEl.className = `status-badge ${cls}`;
            statusEl.textContent = data.status.replace('_', ' ');
            
            // Render keywords
            const keywordsContainer = document.getElementById('modalKeywords');
            keywordsContainer.innerHTML = '';
            if (data.keywords) {
                data.keywords.split(',').forEach(keyword => {
                    const badge = document.createElement('span');
                    badge.className = 'keywords-badge';
                    badge.textContent = keyword.trim();
                    keywordsContainer.appendChild(badge);
                });
            } else {
                keywordsContainer.innerHTML = '<span class="text-muted">No keywords</span>';
            }
        });
    });
});
</script>
@endsection