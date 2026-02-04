@extends('reviewer.layout')

@section('title', 'Completed Reviews')

@section('content')
<style>
    :root {
        --primary-blue: #1e5a8e;
        --success-green: #28a745;
        --danger-red: #dc3545;
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

    /* Stats Card */
    .stat-card {
        background: white;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
        border-left: 4px solid var(--success-green);
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
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
        color: var(--success-green);
    }

    /* Table Card */
    .table-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
        overflow: hidden;
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

    .status-badge.approved {
        background: #d4edda;
        color: #155724;
    }

    .status-badge.rejected {
        background: #f8d7da;
        color: #721c24;
    }

    .status-badge.needs-revision {
        background: #fff3cd;
        color: #856404;
    }

    /* Score Badge */
    .score-badge {
        background: var(--primary-blue);
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
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
        color: var(--success-green);
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

    .review-details {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .review-section {
        margin-bottom: 20px;
    }

    .review-section h6 {
        color: var(--primary-blue);
        font-weight: 600;
        margin-bottom: 15px;
    }

    .score-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 15px;
        margin-bottom: 20px;
    }

    .score-item {
        background: white;
        padding: 15px;
        border-radius: 8px;
        border: 2px solid #e9ecef;
        text-align: center;
    }

    .score-item label {
        display: block;
        font-size: 12px;
        color: #6c757d;
        margin-bottom: 5px;
        text-transform: uppercase;
    }

    .score-item .score {
        font-size: 24px;
        font-weight: 700;
        color: var(--primary-blue);
    }

    .comments-box {
        background: white;
        padding: 20px;
        border-radius: 8px;
        border-left: 4px solid var(--primary-blue);
        line-height: 1.8;
        white-space: pre-wrap;
    }

    .decision-box {
        background: white;
        padding: 15px;
        border-radius: 8px;
        border: 2px solid;
        text-align: center;
        font-weight: 600;
        text-transform: uppercase;
    }

    .decision-box.approved {
        border-color: var(--success-green);
        color: var(--success-green);
        background: #d4edda;
    }

    .decision-box.rejected {
        border-color: var(--danger-red);
        color: var(--danger-red);
        background: #f8d7da;
    }

    .decision-box.needs-revision {
        border-color: #ffc107;
        color: #856404;
        background: #fff3cd;
    }
</style>

<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-check-circle me-2"></i>Completed Reviews
    </h1>
    <p class="text-muted">All abstracts you have reviewed</p>
</div>

<!-- Statistics Card -->
<div class="stat-card">
    <div class="stat-card-content">
        <h6>Total Completed Reviews</h6>
        <h3>{{ $completedReviews->total() }}</h3>
        <small class="text-muted">
            <i class="fas fa-check text-success me-1"></i>
            {{ $stats['approved'] ?? 0 }} Approved | 
            <i class="fas fa-times text-danger me-1"></i>
            {{ $stats['rejected'] ?? 0 }} Rejected | 
            <i class="fas fa-edit text-warning me-1"></i>
            {{ $stats['needs_revision'] ?? 0 }} Needs Revision
        </small>
    </div>
    <div class="stat-card-icon">
        <i class="fas fa-clipboard-check"></i>
    </div>
</div>

<!-- Completed Reviews Table -->
<div class="table-card">
    @if($completedReviews->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Submission ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Decision</th>
                        <th>Reviewed Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($completedReviews as $review)
                    <tr>
                        <td><strong class="text-primary">{{ $review->abstract->submission_code }}</strong></td>
                        <td>{{ Str::limit($review->abstract->paper_title, 50) }}</td>
                        <td>{{ $review->abstract->author_name }}</td>
                        <td>
                            <span class="status-badge {{ strtolower(str_replace('_', '-', $review->decision)) }}">
                                {{ ucfirst(str_replace('_', ' ', $review->decision)) }}
                            </span>
                        </td>
                        <td>{{ $review->created_at->format('M d, Y') }}</td>
                        <td>
                            <button class="btn btn-view btn-sm view-review"
                                    data-bs-toggle="modal"
                                    data-bs-target="#reviewDetailsModal"
                                    data-code="{{ $review->abstract->submission_code }}"
                                    data-title="{{ $review->abstract->paper_title }}"
                                    data-author="{{ $review->abstract->author_name }}"
                                    data-theme="{{ $review->abstract->subTheme->form_field_value ?? 'N/A' }}"
                                    data-decision="{{ $review->decision }}"
                                    data-comments="{{ $review->comment }}"
                                    data-relevance="{{ $review->relevance_score }}"
                                    data-methodology="{{ $review->methodology_score }}"
                                    data-originality="{{ $review->originality_score }}"
                                    data-clarity="{{ $review->clarity_score }}"
                                    data-overall="{{ $review->overall_score }}"
                                    data-date="{{ $review->created_at->format('M d, Y H:i') }}">
                                <i class="fas fa-eye me-1"></i> View
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-3">
            {{ $completedReviews->links() }}
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-clipboard-check"></i>
            <h3>No Completed Reviews Yet</h3>
            <p>You haven't completed any reviews yet.</p>
        </div>
    @endif
</div>

<!-- Review Details Modal -->
<div class="modal fade" id="reviewDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-clipboard-check me-2"></i>Review Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Abstract Info -->
                <div class="review-details">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-hashtag me-2"></i>Submission Code:</strong> 
                               <span id="modalCode" class="text-primary fw-bold"></span></p>
                            <p><strong><i class="fas fa-user me-2"></i>Author:</strong> 
                               <span id="modalAuthor"></span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-tag me-2"></i>Sub-Theme:</strong> 
                               <span id="modalTheme" class="badge bg-secondary"></span></p>
                            <p><strong><i class="fas fa-calendar me-2"></i>Reviewed:</strong> 
                               <span id="modalDate"></span></p>
                        </div>
                    </div>
                    <p><strong><i class="fas fa-heading me-2"></i>Title:</strong></p>
                    <h5 id="modalTitle" class="text-primary"></h5>
                </div>

                <!-- Scores -->

                <!-- Comments -->
                <div class="review-section">
                    <h6><i class="fas fa-comment me-2"></i>Review Comments</h6>
                    <div class="comments-box" id="modalComments"></div>
                </div>

                <!-- Decision -->
                <div class="review-section">
                    <h6><i class="fas fa-gavel me-2"></i>Final Decision</h6>
                    <div class="decision-box" id="modalDecision"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.view-review').forEach(btn => {
        btn.addEventListener('click', () => {
            const data = btn.dataset;
            
            // Set basic info
            document.getElementById('modalCode').textContent = data.code;
            document.getElementById('modalTitle').textContent = data.title;
            document.getElementById('modalAuthor').textContent = data.author;
            document.getElementById('modalTheme').textContent = data.theme;
            document.getElementById('modalDate').textContent = data.date;
            
            // Set comments
            document.getElementById('modalComments').textContent = data.comments;
            
            // Set decision
            const decisionEl = document.getElementById('modalDecision');
            const decisionClass = data.decision.toLowerCase().replace('_', '-');
            decisionEl.className = `decision-box ${decisionClass}`;
            decisionEl.innerHTML = `<i class="fas ${data.decision === 'APPROVED' ? 'fa-check' : (data.decision === 'REJECTED' ? 'fa-times' : 'fa-edit')} me-2"></i>${data.decision.replace('_', ' ')}`;
        });
    });
});
</script>
@endsection