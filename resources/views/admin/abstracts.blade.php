@extends('admin.layout')
@section('content')

<style>
    /* Filter Card Styles */
    .filter-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
        margin-bottom: 25px;
        overflow: hidden;
    }

    .filter-header {
        background: linear-gradient(135deg, var(--kalro-green) 0%, var(--kalro-dark-green) 100%);
        padding: 15px 20px;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .filter-title {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
    }

    .filter-stats {
        font-size: 14px;
        opacity: 0.9;
    }

    .filter-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        padding: 20px;
    }

    .filter-actions {
        padding: 0 20px 20px 20px;
        display: flex;
        gap: 10px;
    }

    .date-range-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .date-range-separator {
        color: #666;
        font-weight: 500;
    }

    .btn-filter {
        background: var(--kalro-green);
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 5px;
        font-weight: 500;
        transition: all 0.3s;
    }

    .btn-filter:hover {
        background: var(--kalro-dark-green);
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
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
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

    .table thead.table-success th {
        background: var(--kalro-green) !important;
        color: white;
        border: none;
        padding: 15px 12px;
        font-weight: 600;
        font-size: 14px;
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
    .status {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        display: inline-block;
    }

    .status.pending {
        background: #fff3cd;
        color: #856404;
    }

    .status.under-review {
        background: #d1ecf1;
        color: #0c5460;
    }

    .status.approved {
        background: #d4edda;
        color: #155724;
    }

    .status.rejected {
        background: #f8d7da;
        color: #721c24;
    }

    /* View Button */
    .btn-view {
        background: var(--kalro-green);
        color: white;
        border: none;
        padding: 6px 15px;
        border-radius: 5px;
        font-size: 13px;
        transition: all 0.3s;
    }

    .btn-view:hover {
        background: var(--kalro-dark-green);
        color: white;
        transform: translateY(-1px);
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

    .empty-state p {
        font-size: 16px;
    }

    /* Page Title */
    .page-title {
        font-size: 28px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 25px;
    }

    /* Modal Styles */
    .modal-header {
        background: linear-gradient(135deg, var(--kalro-green) 0%, var(--kalro-dark-green) 100%);
        color: white;
        border-bottom: none;
    }

    .modal-title {
        font-weight: 600;
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

    .submission-meta strong {
        color: #495057;
        font-weight: 600;
    }

    .abstract-content {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        border-left: 4px solid var(--kalro-green);
        line-height: 1.8;
        white-space: pre-wrap;
    }

    .keywords-badge {
        display: inline-block;
        background: var(--kalro-light-green);
        color: var(--kalro-dark-green);
        padding: 5px 12px;
        border-radius: 15px;
        margin: 3px;
        font-size: 13px;
        font-weight: 500;
    }

    /* Review Section */
    .review-approved {
        border-left-color: #28a745 !important;
        background: #d4edda !important;
    }

    .review-rejected {
        border-left-color: #dc3545 !important;
        background: #f8d7da !important;
    }

    .review-revision {
        border-left-color: #ffc107 !important;
        background: #fff3cd !important;
    }

    .form-check-input:checked {
        background-color: var(--kalro-green);
        border-color: var(--kalro-green);
    }

    .btn-primary {
        background: var(--kalro-green);
        border-color: var(--kalro-green);
    }

    .btn-primary:hover {
        background: var(--kalro-dark-green);
        border-color: var(--kalro-dark-green);
    }

    /* Form Controls */
    .form-control, .form-select {
        border: 1px solid #ced4da;
        border-radius: 5px;
        padding: 8px 12px;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--kalro-green);
        box-shadow: 0 0 0 0.2rem rgba(45, 138, 62, 0.25);
    }

    .form-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 5px;
    }
</style>

<main class="main">
    <h1 class="page-title">Submitted Abstracts</h1>

    <!-- Filter Card -->
    <div class="filter-card">
        <div class="filter-header">
            <h2 class="filter-title"><i class="fas fa-filter me-2"></i>Filter Abstracts</h2>
            <div class="filter-stats">
                Showing {{ $totalSubmissions }} abstracts
            </div>
        </div>
        
        <form method="GET" action="{{route('admin.abstracts.index')}}">
            <div class="filter-row">
                <!-- Sub-Theme -->
                <div class="form-group">
                    <label for="sub_theme" class="form-label">
                        <i class="fas fa-tag me-1"></i> Sub-Theme
                    </label>
                    <select name="sub_theme" id="sub_theme" class="form-select">
                        <option value="">All Sub-Themes</option>
                        @foreach ($sub_themes as $theme)
                            <option value="{{ $theme->id }}" {{ request('sub_theme') == $theme->id ? 'selected' : '' }}>
                                {{ $theme->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Status -->
                <div class="form-group">
                    <label for="status" class="form-label">
                        <i class="fas fa-circle me-1"></i> Status
                    </label>
                    <select name="status" id="status" class="form-select">
                        <option value="">All Statuses</option>
                        @foreach ($statuses as $key => $label)
                            <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Date Range -->
                <div class="form-group">
                    <label for="date_from" class="form-label">
                        <i class="fas fa-calendar-alt me-1"></i> Date Range
                    </label>
                    <div class="date-range-group">
                        <input type="text" name="date_from" id="date_from" 
                            class="form-control date-picker" 
                            placeholder="From Date" 
                            value="{{ request('date_from') }}">
                        <span class="date-range-separator">to</span>
                        <input type="text" name="date_to" id="date_to" 
                            class="form-control date-picker" 
                            placeholder="To Date" 
                            value="{{ request('date_to') }}">
                    </div>
                </div>
            </div>
            
            <div class="filter-actions">
                <button type="submit" class="btn btn-filter">
                    <i class="fas fa-search me-1"></i> Apply Filters
                </button>
                <a href="{{ route('admin.abstracts.index') }}" class="btn btn-reset">
                    <i class="fas fa-times me-1"></i> Clear All
                </a>
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div class="table-card">
        @if($abstracts->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-success">
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Institution</th>
                            <th>Theme</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($abstracts as $i => $r)
                            @php
                                $cls = strtolower(str_replace('_', '-', $r->status));
                                $last_reviewed = $r->updated_at ? $r->updated_at->format('d M Y') : 'Not reviewed';
                            @endphp
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td><strong>{{ $r->submission_code }}</strong></td>
                                <td>{{ Str::limit($r->paper_title, 50) }}</td>
                                <td>{{ $r->author_name }}</td>
                                <td>{{ $r->organisation }}</td>
                                <td>{{ $r->subTheme->full_name ?? 'N/A' }}</td>
                                <td><span class="status {{ $cls }}">{{ $r->status }}</span></td>
                                <td>{{ $r->created_at->format('d M Y') }}</td>
                                <td>
                                    <button class="btn btn-view btn-sm view-abstract"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#abstractModal"
                                            data-id="{{ $r->id }}"
                                            data-code="{{ $r->submission_code }}"
                                            data-title="{{ $r->paper_title }}"
                                            data-author="{{ $r->author_name }}"
                                            data-email="{{ $r->author_email }}"
                                            data-phone="{{ $r->author_phone }}"
                                            data-org="{{ $r->organisation }}"
                                            data-dept="{{ $r->department }}"
                                            data-position="{{ $r->position }}"
                                            data-theme="{{ $r->subTheme->full_name ?? '' }}"
                                            data-status="{{ $r->status }}"
                                            data-created="{{ $r->created_at->format('d M Y H:i') }}"
                                            data-reviewed-by="N/A"
                                            data-reviewed-at="{{ $last_reviewed }}"
                                            data-abstract="{{ $r->abstract_text }}"
                                            data-keywords="{{ $r->keywords }}"
                                            data-presentation="{{ $r->presentation_preference }}"
                                            data-attendance="{{ $r->attendance_mode }}"
                                            data-notes="{{ $r->special_requirements }}"
                                            data-review-comment="{{ $r->latestReview?->comment ?? '' }}"
                                            data-review-decision="{{ $r->latestReview?->decision ?? '' }}">
                                        <i class="fas fa-eye me-1"></i> View
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h3>No abstracts found</h3>
                <p>Try adjusting your filters or clear them to see all abstracts.</p>
            </div>
        @endif
    </div>
</main>

<!-- Abstract View Modal -->
<div class="modal fade" id="abstractModal" tabindex="-1" aria-labelledby="abstractModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="abstractModalLabel">
                    <i class="fas fa-file-alt me-2"></i>Abstract Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Submission Meta -->
                <div class="submission-meta">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-hashtag me-2"></i>Submission Code:</strong> 
                               <span id="modalCode" class="text-primary fw-bold"></span>
                            </p>
                            <p><strong><i class="fas fa-user me-2"></i>Author:</strong> 
                               <span id="modalAuthor"></span>
                            </p>
                            <p><strong><i class="fas fa-envelope me-2"></i>Email:</strong> 
                               <span id="modalEmail"></span>
                            </p>
                            <p><strong><i class="fas fa-phone me-2"></i>Phone:</strong> 
                               <span id="modalPhone"></span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-building me-2"></i>Organization:</strong> 
                               <span id="modalOrg"></span>
                            </p>
                            <p><strong><i class="fas fa-tag me-2"></i>Sub-Theme:</strong> 
                               <span id="modalTheme" class="badge bg-secondary"></span>
                            </p>
                            <p><strong><i class="fas fa-circle me-2"></i>Current Status:</strong> 
                               <span id="modalStatus"></span>
                            </p>
                            <p><strong><i class="fas fa-calendar me-2"></i>Submitted:</strong> 
                               <span id="modalCreated"></span>
                            </p>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-user-check me-2"></i>Last Reviewed By:</strong> 
                               <span id="modalReviewedBy"></span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-calendar-check me-2"></i>Last Review Date:</strong> 
                               <span id="modalReviewedAt"></span>
                            </p>
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
                
                <!-- Abstract Content & Keywords -->
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
                        
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-chalkboard me-2"></i>Presentation Details
                        </h6>
                        <div class="card">
                            <div class="card-body">
                                <p><strong>Preference:</strong> <span id="modalPresentation"></span></p>
                                <p class="mb-0"><strong>Attendance Mode:</strong> <span id="modalAttendance"></span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Existing Reviewer Feedback -->
                <div id="existingReviewWrapper" class="mb-4 d-none">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-comment-dots me-1"></i> Reviewer Feedback
                    </label>
                    <div id="existingReview" class="p-3 rounded border-start border-4" 
                         style="white-space: pre-wrap; background:#f8f9fa;"></div>
                </div>

                <!-- Review Comment -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-edit me-1"></i> Reviewer Comment
                    </label>
                    <textarea class="form-control" id="reviewComment" rows="4"
                              placeholder="Write feedback before approving or rejecting..." required></textarea>
                </div>

                <input type="hidden" id="reviewDecision">
                <input type="hidden" id="reviewAbstractId">

                <!-- Review Decision -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-check-circle me-1"></i> Review Decision
                    </label>

                    <div class="form-check">
                        <input class="form-check-input decision-checkbox" type="checkbox" 
                               id="approveCheckbox" value="APPROVED">
                        <label class="form-check-label text-success fw-semibold" for="approveCheckbox">
                            <i class="fas fa-check me-1"></i> Approve
                        </label>
                    </div>

                    <div class="form-check mt-2">
                        <input class="form-check-input decision-checkbox" type="checkbox" 
                               id="rejectCheckbox" value="REJECTED">
                        <label class="form-check-label text-danger fw-semibold" for="rejectCheckbox">
                            <i class="fas fa-times me-1"></i> Reject
                        </label>
                    </div>

                    <small id="reviewLockedMsg" class="text-muted d-none mt-2 d-block">
                        <i class="fas fa-lock me-1"></i>
                        This abstract has already been reviewed.
                    </small>
                </div>

                <button type="button" class="btn btn-primary w-100" id="sendFeedbackBtn" 
                        data-url="{{ route('abstracts.review') }}">
                    <i class="fas fa-paper-plane me-1"></i> Send Feedback
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    let decision = null;

    // Initialize date pickers
    if (window.flatpickr) {
        flatpickr('.date-picker', {
            dateFormat: 'Y-m-d',
            allowInput: true,
            maxDate: 'today'
        });
    }

    // View abstract modal
    document.querySelectorAll('.view-abstract').forEach(btn => {
        btn.addEventListener('click', () => {
            populateModal(btn);
            resetReviewForm(btn.dataset.id);
        });
    });

    function populateModal(btn) {
        const data = btn.dataset;

        setText('modalCode', data.code);
        setText('modalTitle', data.title);
        setText('modalAuthor', data.author);
        setText('modalEmail', data.email);
        setText('modalPhone', data.phone);
        setText('modalOrg', data.org);
        setText('modalTheme', data.theme);
        setText('modalCreated', data.created);
        setText('modalReviewedBy', data.reviewedBy || 'N/A');
        setText('modalReviewedAt', data.reviewedAt || 'N/A');
        setText('modalAbstract', data.abstract);

        renderStatus(data.status);
        renderKeywords(data.keywords);
        renderPresentation(data.presentation, data.attendance);
        renderExistingReview(data.reviewComment, data.reviewDecision);
    }

    function renderStatus(status) {
        const el = document.getElementById('modalStatus');
        if (!el || !status) return;

        const cls = status.toLowerCase().replaceAll('_', '-');
        el.textContent = status.replaceAll('_', ' ');
        el.className = `status ${cls}`;
    }

    function renderKeywords(keywords) {
        const container = document.getElementById('modalKeywords');
        if (!container) return;

        container.innerHTML = '';

        if (!keywords || !keywords.trim()) {
            container.innerHTML = '<span class="text-muted">No keywords provided</span>';
            return;
        }

        keywords.split(',').map(k => k.trim()).filter(Boolean).forEach(k => {
            const span = document.createElement('span');
            span.className = 'keywords-badge';
            span.textContent = k;
            container.appendChild(span);
        });
    }

    function renderPresentation(presentation, attendance) {
        setText('modalPresentation', presentation || 'Not specified');
        setText('modalAttendance', attendance || 'Not specified');
    }

    function resetReviewForm(abstractId) {
        decision = null;

        const idField = document.getElementById('reviewAbstractId');
        const commentField = document.getElementById('reviewComment');

        if (idField) idField.value = abstractId || '';
        if (commentField) commentField.value = '';

        document.querySelectorAll('.decision-checkbox').forEach(cb => {
            cb.checked = false;
            cb.disabled = false;
        });
    }

    function renderExistingReview(comment, reviewDecision) {
        const wrapper = document.getElementById('existingReviewWrapper');
        const box = document.getElementById('existingReview');
        const approve = document.getElementById('approveCheckbox');
        const reject = document.getElementById('rejectCheckbox');
        const commentBox = document.getElementById('reviewComment');
        const sendBtn = document.getElementById('sendFeedbackBtn');
        const lockedMsg = document.getElementById('reviewLockedMsg');

        // Reset
        if (approve) approve.disabled = false;
        if (reject) reject.disabled = false;
        if (commentBox) commentBox.disabled = false;
        if (sendBtn) sendBtn.disabled = false;
        if (lockedMsg) lockedMsg.classList.add('d-none');

        if (!wrapper || !box || !comment || !comment.trim()) {
            if (wrapper) wrapper.classList.add('d-none');
            return;
        }

        // Show existing review
        wrapper.classList.remove('d-none');
        box.textContent = comment;
        box.classList.remove('review-approved', 'review-rejected', 'review-revision');

        if (reviewDecision === 'APPROVED') {
            box.classList.add('review-approved');
            if (approve) approve.checked = true;
        } else if (reviewDecision === 'REJECTED') {
            box.classList.add('review-rejected');
            if (reject) reject.checked = true;
        }

        // Lock everything
        if (approve) approve.disabled = true;
        if (reject) reject.disabled = true;
        if (commentBox) commentBox.disabled = true;
        if (sendBtn) sendBtn.disabled = true;
        if (lockedMsg) lockedMsg.classList.remove('d-none');
    }

    // Decision checkboxes
    document.querySelectorAll('.decision-checkbox').forEach(cb => {
        cb.addEventListener('change', () => {
            document.querySelectorAll('.decision-checkbox').forEach(other => {
                if (other !== cb) other.checked = false;
            });
            decision = cb.checked ? cb.value : null;
        });
    });

    // Send feedback
    const sendBtn = document.getElementById('sendFeedbackBtn');
    if (sendBtn) {
        sendBtn.addEventListener('click', async () => {
            const comment = document.getElementById('reviewComment')?.value.trim();
            const abstractId = document.getElementById('reviewAbstractId')?.value;

            if (!comment || !decision) {
                alert('Please add a comment and choose approve or reject.');
                return;
            }

            try {
                const response = await fetch(sendBtn.dataset.url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        abstract_id: abstractId,
                        decision,
                        comment
                    })
                });

                if (response.ok) {
                    location.reload();
                } else {
                    alert('Failed to send review. Please try again.');
                }
            } catch (e) {
                console.error(e);
                alert('Failed to send review. Please try again.');
            }
        });
    }

    function setText(id, value) {
        const el = document.getElementById(id);
        if (el) el.textContent = value || '';
    }
});
</script>
@endsection