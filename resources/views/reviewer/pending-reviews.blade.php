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
                    <label for="status" class="form-label"><i class="fas fa-circle me-1"></i> Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="assigned" {{ request('status') == 'assigned' ? 'selected' : '' }}>Assigned</option>
                        <option value="under_review" {{ request('status') == 'under_review' ? 'selected' : '' }}>Under Review</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="date_from" class="form-label"><i class="fas fa-calendar me-1"></i> Date Assigned</label>
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
                        <th>Status</th>
                        <th>Assigned Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                   @foreach($pendingReviews as $assignment)
                    <tr>
                        <td><strong class="text-primary">{{ $assignment->submission_code }}</strong></td>
                        <td>{{ Str::limit($assignment->paper_title, 50) }}</td>
                        <td>{{ $assignment->author_name }}</td>
                        <td>
                            <span class="status-badge {{ strtolower(str_replace('_', '-', $assignment->abstract_status)) }}">
                                {{ ucfirst(str_replace('_', ' ', $assignment->abstract_status)) }}
                            </span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($assignment->assigned_at)->format('M d, Y') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-view view-abstract"
                                    data-bs-toggle="modal"
                                    data-bs-target="#abstractModal"
                                    data-assignment-id="{{ $assignment->assignment_id }}"
                                    data-id="{{ $assignment->abstract_id }}"
                                    data-code="{{ $assignment->submission_code }}"
                                    data-title="{{ $assignment->paper_title }}"
                                    data-author="{{ $assignment->author_name }}"
                                    data-email="{{ $assignment->author_email }}"
                                    data-phone="{{ $assignment->author_phone ?? '' }}"
                                    data-org="{{ $assignment->organisation }}"
                                    data-theme="{{ $assignment->subtheme_name ?? 'N/A' }}"
                                    data-abstract="{{ $assignment->abstract_text }}"
                                    data-keywords="{{ $assignment->keywords ?? '' }}"
                                    data-status="{{ $assignment->abstract_status }}"
                                    data-created="{{ \Carbon\Carbon::parse($assignment->assigned_at)->format('M d, Y') }}"
                                    data-reviewed-by="{{ $assignment->review_reviewer_id ? \App\Models\User::find($assignment->review_reviewer_id)->full_name : '' }}"
                                    data-reviewed-at="{{ $assignment->review_created_at ? \Carbon\Carbon::parse($assignment->review_created_at)->format('M d, Y') : '' }}"
                                    data-review-comment="{{ $assignment->review_comment ?? '' }}"
                                    data-review-decision="{{ $assignment->review_decision ?? '' }}"
                                    data-presentation="{{ $assignment->presentation_preference ?? '' }}"
                                    data-attendance="{{ $assignment->attendance_mode ?? '' }}">
                                    <i class="fas fa-eye me-1"></i> Review
                                </button>

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

<!-- Include the Modal Partial -->
@include('reviewer.partials.abstractModal')

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.view-abstract').forEach(btn => {
        btn.addEventListener('click', () => {
            const d = btn.dataset;

            const setText = (id, value) => {
                const el = document.getElementById(id);
                if (el) el.textContent = value || '—';
            };

            setText('modalCode', d.code);
            setText('modalTitle', d.title);
            setText('modalAuthor', d.author);
            setText('modalEmail', d.email);
            setText('modalOrg', d.org);
            setText('modalTheme', d.theme);
            setText('modalStatus', d.status);
            setText('modalAbstract', d.abstract);

            const keywordsContainer = document.getElementById('modalKeywords');
            keywordsContainer.innerHTML = '';
            if (d.keywords) {
                d.keywords.split(',').forEach(k => {
                    const badge = document.createElement('span');
                    badge.className = 'keywords-badge';
                    badge.textContent = k.trim();
                    keywordsContainer.appendChild(badge);
                });
            } else {
                keywordsContainer.innerHTML = '<span class="text-muted">No keywords</span>';
            }

            // Fill hidden fields in the review form
            document.getElementById('assignmentId').value = d.assignmentId;
            document.getElementById('abstractId').value = d.abstractId;
        });
    });
});
</script>
@endsection