@extends('admin.layout')
@section('content')
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
        
        <form method="GET" action="/abstracts">
            <div class="filter-row">
                <!-- Sub-Theme -->
                <div class="form-group">
                    <label for="sub_theme"><i class="fas fa-tag me-1"></i> Sub-Theme</label>
                    <select name="sub_theme" id="sub_theme" class="form-control">
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
                    <label for="status"><i class="fas fa-circle me-1"></i> Status</label>
                    <select name="status" id="status" class="form-control">
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
                    <label for="date_from"><i class="fas fa-calendar-alt me-1"></i> Date Range</label>
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
                <a href="/abstracts" class="btn btn-reset">
                    <i class="fas fa-times me-1"></i> Clear All
                </a>
            </div>
        </form>
    </div>


    <div class="table-card table-responsive">
        @if($abstracts->count() > 0)
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
                            <td>{{ $r->submission_code }}</td>
                            <td>{{ $r->paper_title }}</td>
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
                                        data-review-decision="{{ $r->latestReview?->decision ?? '' }}"

                                        >
                                    <i class="fas fa-eye me-1"></i> View
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
                
                <div class="row mb-4">
                    <div class="col-md-8">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-file-lines me-2"></i>Abstract Content
                        </h6>
                        <div class="abstract-content" id="modalAbstract">
                            <!-- Abstract content will be inserted here -->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-tags me-2"></i>Keywords
                        </h6>
                        <div id="modalKeywords" class="mb-3">
                            <!-- Keywords will be inserted here -->
                        </div>
                        
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-chalkboard me-2"></i>Presentation Details
                        </h6>
                        <div class="card">
                            <div class="card-body">
                                <p><strong>Preference:</strong> <span id="modalPresentation"></span></p>
                                <p><strong>Attendance Mode:</strong> <span id="modalAttendance"></span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Existing Reviewer Feedback (Read-only) -->
                    <div id="existingReviewWrapper" class="mb-4 d-none">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-comment-dots me-1"></i> Reviewer Feedback
                        </label>

                        <div id="existingReview"
                            class="p-3 rounded border-start border-4"
                            style="white-space: pre-wrap; background:#f8f9fa;">
                        </div>
                    </div>

                
                <!-- Comments Section -->
                {{-- Review Comment --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-edit me-1"></i> Reviewer Comment
                        </label>
                        <textarea class="form-control" id="reviewComment" rows="4"
                                placeholder="Write feedback before approving or rejecting..."
                                required></textarea>
                    </div>

                    <input type="hidden" id="reviewDecision">
                    <input type="hidden" id="reviewAbstractId">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-check-circle me-1"></i> Review Decision
                        </label>

                        <div class="form-check">
                            <input class="form-check-input decision-checkbox"
                                type="checkbox"
                                id="approveCheckbox"
                                value="APPROVED">
                            <label class="form-check-label text-success fw-semibold"
                                for="approveCheckbox">
                                <i class="fas fa-check me-1"></i> Approve
                            </label>
                        </div>

                        <div class="form-check mt-1">
                            <input class="form-check-input decision-checkbox"
                                type="checkbox"
                                id="rejectCheckbox"
                                value="REJECTED">
                            <label class="form-check-label text-danger fw-semibold"
                                for="rejectCheckbox">
                                <i class="fas fa-times me-1"></i> Reject
                            </label>
                        </div>

                        <small id="reviewLockedMsg" class="text-muted d-none">
                            <i class="fas fa-lock me-1"></i>
                            This abstract has already been reviewed.
                        </small>
</div>


                    <button type="button" class="btn btn-primary w-100" id="sendFeedbackBtn" data-url="{{ route('abstracts.review') }}">
                        <i class="fas fa-paper-plane me-1"></i> Send Feedback
                    </button>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        /* -------------------------------------------------
        * GLOBAL STATE
        * ------------------------------------------------- */
        let decision = null;

        /* -------------------------------------------------
        * DATE PICKERS
        * ------------------------------------------------- */
        if (window.flatpickr) {
            flatpickr('.date-picker', {
                dateFormat: 'Y-m-d',
                allowInput: true,
                maxDate: 'today'
            });
        }

        /* -------------------------------------------------
        * VIEW ABSTRACT MODAL
        * ------------------------------------------------- */
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

            // ✅ ADD THIS
            renderExistingReview(
                data.reviewComment,
                data.reviewDecision
            );
        }


        /* -------------------------------------------------
        * STATUS
        * ------------------------------------------------- */
        function renderStatus(status) {
            const el = document.getElementById('modalStatus');
            if (!el || !status) return;

            const cls = status.toLowerCase().replaceAll('_', '-');
            el.textContent = status.replaceAll('_', ' ');
            el.className = `status ${cls}`;
        }

        /* -------------------------------------------------
        * KEYWORDS
        * ------------------------------------------------- */
        function renderKeywords(keywords) {
            const container = document.getElementById('modalKeywords');
            if (!container) return;

            container.innerHTML = '';

            if (!keywords || !keywords.trim()) {
                container.innerHTML =
                    '<span class="text-muted">No keywords provided</span>';
                return;
            }

            keywords
                .split(',')
                .map(k => k.trim())
                .filter(Boolean)
                .forEach(k => {
                    const span = document.createElement('span');
                    span.className = 'keywords-badge';
                    span.textContent = k;
                    container.appendChild(span);
                });
        }

        /* -------------------------------------------------
        * PRESENTATION / ATTENDANCE
        * ------------------------------------------------- */
        function renderPresentation(presentation, attendance) {
            setText(
                'modalPresentation',
                presentation || 'Not specified'
            );
            setText(
                'modalAttendance',
                attendance || 'Not specified'
            );
        }

        /* -------------------------------------------------
        * REVIEW FORM
        * ------------------------------------------------- */
        function resetReviewForm(abstractId) {
            decision = null;

            const idField = document.getElementById('reviewAbstractId');
            const commentField = document.getElementById('reviewComment');

            if (idField) idField.value = abstractId || '';
            if (commentField) commentField.value = '';

            document
                .querySelectorAll('.decision-checkbox')
                .forEach(cb => {
                    cb.checked = false;
                    cb.disabled = false;
                });
        }

        document.querySelectorAll('.decision-checkbox').forEach(cb => {
            cb.addEventListener('change', () => {
                document.querySelectorAll('.decision-checkbox').forEach(other => {
                    if (other !== cb) other.checked = false;
                });

                decision = cb.checked ? cb.value : null;
            });
        });

        /* -------------------------------------------------
        * SEND FEEDBACK
        * ------------------------------------------------- */
        const sendBtn = document.getElementById('sendFeedbackBtn');
        if (sendBtn) {
            sendBtn.addEventListener('click', async () => {
                const comment = document
                    .getElementById('reviewComment')
                    ?.value.trim();

                const abstractId =
                    document.getElementById('reviewAbstractId')?.value;

                if (!comment || !decision) {
                    alert('Please add a comment and choose approve or reject.');
                    return;
                }

                try {
                    await fetch(sendBtn.dataset.url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document
                                .querySelector('meta[name="csrf-token"]')
                                .content,
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            abstract_id: abstractId,
                            decision,
                            comment
                        })
                    });

                    location.reload();
                } catch (e) {
                    alert('Failed to send review. Please try again.');
                }
            });
        }

        /* -------------------------------------------------
        * HELPERS
        * ------------------------------------------------- */
        function setText(id, value) {
            const el = document.getElementById(id);
            if (el) el.textContent = value || '';
        }
    });

    function renderExistingReview(comment, decision) {
        const wrapper = document.getElementById('existingReviewWrapper');
        const box = document.getElementById('existingReview');

        const approve = document.getElementById('approveCheckbox');
        const reject  = document.getElementById('rejectCheckbox');
        const commentBox = document.getElementById('reviewComment');
        const sendBtn = document.getElementById('sendFeedbackBtn');
        const lockedMsg = document.getElementById('reviewLockedMsg');

        // RESET
        if (approve) approve.disabled = false;
        if (reject) reject.disabled = false;
        if (commentBox) commentBox.disabled = false;
        if (sendBtn) sendBtn.disabled = false;
        if (lockedMsg) lockedMsg.classList.add('d-none');

        if (!wrapper || !box || !comment || !comment.trim()) {
            if (wrapper) wrapper.classList.add('d-none');
            return;
        }

        // SHOW EXISTING REVIEW
        wrapper.classList.remove('d-none');
        box.textContent = comment;

        box.classList.remove('review-approved','review-rejected','review-revision');

        if (decision === 'APPROVED') {
            box.classList.add('review-approved');
            approve.checked = true;
        } else if (decision === 'REJECTED') {
            box.classList.add('review-rejected');
            reject.checked = true;
        }

        // 🔒 LOCK EVERYTHING
        approve.disabled = true;
        reject.disabled = true;
        commentBox.disabled = true;
        sendBtn.disabled = true;

        // 👇 SHOW LOCK MESSAGE
        if (lockedMsg) lockedMsg.classList.remove('d-none');
    }
</script>
@endsection