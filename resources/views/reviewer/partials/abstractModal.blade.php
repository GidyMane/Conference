<!-- Abstract View Modal -->
<div class="modal fade" id="abstractModal" tabindex="-1" aria-labelledby="abstractModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="abstractModalLabel">
                    <i class="fas fa-file-alt me-2"></i> Abstract Details
                </h5>
                <button type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">

                <!-- Submission Meta -->
                <div class="submission-meta mb-4">
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
                            <p><strong><i class="fas fa-building me-2"></i>Organisation:</strong>
                                <span id="modalOrg"></span>
                            </p>
                            <p><strong><i class="fas fa-tag me-2"></i>Sub-Theme:</strong>
                                <span id="modalTheme" class="badge bg-secondary"></span>
                            </p>
                            <p><strong><i class="fas fa-circle me-2"></i>Status:</strong>
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
                                <span id="modalReviewedBy">—</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-calendar-check me-2"></i>Last Review Date:</strong>
                                <span id="modalReviewedAt">—</span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Paper Title -->
                <div class="mb-4">
                    <h6 class="text-success mb-3">
                        <i class="fas fa-heading me-2"></i> Paper Title
                    </h6>
                    <div class="card">
                        <div class="card-body">
                            <h5 id="modalTitle" class="card-title mb-0"></h5>
                        </div>
                    </div>
                </div>

                <!-- Abstract + Keywords -->
                <div class="row mb-4">
                    <div class="col-md-8">
                        <h6 class="text-success mb-3">
                            <i class="fas fa-file-lines me-2"></i> Abstract Content
                        </h6>
                        <div id="modalAbstract"
                             class="border rounded p-3"
                             style="white-space: pre-wrap; background:#f8f9fa;"></div>
                    </div>

                    <div class="col-md-4">
                        <h6 class="text-success mb-3">
                            <i class="fas fa-tags me-2"></i> Keywords
                        </h6>
                        <div id="modalKeywords" class="mb-3"></div>

                        <h6 class="text-success mb-3">
                            <i class="fas fa-chalkboard me-2"></i> Presentation Details
                        </h6>
                        <div class="card">
                            <div class="card-body">
                                <p><strong>Preference:</strong> <span id="modalPresentation"></span></p>
                                <p class="mb-0"><strong>Attendance Mode:</strong> <span id="modalAttendance"></span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Existing Review -->
                <div id="existingReviewWrapper" class="mb-4 d-none">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-comment-dots me-1"></i> Reviewer Feedback
                    </label>
                    <div id="existingReview"
                         class="p-3 rounded border-start border-4 border-success"
                         style="white-space: pre-wrap; background:#f8f9fa;"></div>
                </div>

                <!-- Review Comment -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-edit me-1"></i> Reviewer Comment
                    </label>
                    <textarea id="reviewComment"
                              class="form-control"
                              rows="4"
                              placeholder="Write feedback before approving or rejecting…"></textarea>
                </div>

                <input type="hidden" id="reviewDecision">
                <input type="hidden" id="reviewAbstractId">

                <!-- Decision -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-check-circle me-1"></i> Review Decision
                    </label>

                <div class="form-check">
                    <input class="form-check-input decision-checkbox"
                        type="checkbox"
                        id="approveCheckbox"
                        value="APPROVED">
                    <label class="form-check-label text-success fw-semibold" for="approveCheckbox">
                        <i class="fas fa-check me-1"></i> Approve
                    </label>
                </div>

                <div class="form-check mt-2">
                    <input class="form-check-input decision-checkbox"
                        type="checkbox"
                        id="rejectCheckbox"
                        value="REJECTED">
                    <label class="form-check-label text-danger fw-semibold" for="rejectCheckbox">
                        <i class="fas fa-times me-1"></i> Reject
                    </label>
                </div>


                    <small id="reviewLockedMsg" class="text-muted d-none mt-2">
                        <i class="fas fa-lock me-1"></i> This abstract has already been reviewed.
                    </small>
                </div>

                <!-- Submit -->
                <button type="button"
                        class="btn btn-success w-100"
                        id="sendFeedbackBtn"
                        data-url="{{ route('reviewer.review') }}">
                    <i class="fas fa-paper-plane me-1"></i> Send Feedback
                </button>

            </div>
        </div>
    </div>
</div>


<script>
function downloadAbstract(id) {
    window.open('/reviewer/abstracts/' + id + '/download', '_blank');
}

function exportData() {
    const params = new URLSearchParams(window.location.search);
    window.location.href = '/reviewer/abstracts/export?' + params.toString();
}

document.addEventListener('DOMContentLoaded', () => {

    const commentField = document.getElementById('reviewComment');
    const approveCheckbox = document.getElementById('approveCheckbox');
    const rejectCheckbox = document.getElementById('rejectCheckbox');
    const sendBtn = document.getElementById('sendFeedbackBtn');
    const lockMsg = document.getElementById('reviewLockedMsg');

    // Ensure only one checkbox is checked at a time
    document.querySelectorAll('.decision-checkbox').forEach(cb => {
        cb.addEventListener('change', () => {
            if (cb.checked) {
                document.querySelectorAll('.decision-checkbox').forEach(other => {
                    if (other !== cb) other.checked = false;
                });
            }
        });
    });

    // Open modal and populate fields
    document.querySelectorAll('.view-abstract').forEach(btn => {
        btn.addEventListener('click', () => {
            const d = btn.dataset;

            // Helper to set text
            const setText = (id, value) => {
                const el = document.getElementById(id);
                if (el) el.textContent = value || '—';
            };

            setText('modalCode', d.code);
            setText('modalTitle', d.title);
            setText('modalAuthor', d.author);
            setText('modalEmail', d.email);
            setText('modalPhone', d.phone);
            setText('modalOrg', d.org);
            setText('modalTheme', d.theme);
            setText('modalStatus', d.status);
            setText('modalCreated', d.created);
            setText('modalReviewedBy', d.reviewedBy || '—');
            setText('modalReviewedAt', d.reviewedAt || '—');
            setText('modalAbstract', d.abstract);
            setText('modalKeywords', d.keywords);
            setText('modalPresentation', d.presentation);
            setText('modalAttendance', d.attendance);
            setText('existingReview', d.reviewComment || '');

            document.getElementById('reviewAbstractId').value = d.id;

            // Lock fields if already reviewed
            if (d.reviewComment || d.reviewDecision) {
                commentField.value = d.reviewComment || '';
                commentField.disabled = true;

                approveCheckbox.checked = d.reviewDecision === 'APPROVED';
                rejectCheckbox.checked = d.reviewDecision === 'REJECTED';

                approveCheckbox.disabled = true;
                rejectCheckbox.disabled = true;
                sendBtn.style.display = 'none';
                lockMsg.classList.remove('d-none');
            } else {
                commentField.disabled = false;
                commentField.value = '';
                approveCheckbox.checked = false;
                rejectCheckbox.checked = false;
                approveCheckbox.disabled = false;
                rejectCheckbox.disabled = false;
                sendBtn.style.display = 'inline-block';
                lockMsg.classList.add('d-none');
            }

            // Show existing review wrapper if present
            document.getElementById('existingReviewWrapper').classList.toggle('d-none', !d.reviewComment);
        });
    });

    // Submit review
    sendBtn.addEventListener('click', function() {
        const abstractId = document.getElementById('reviewAbstractId').value;
        const comment = commentField.value;
        const decision = approveCheckbox.checked
            ? 'APPROVED'
            : rejectCheckbox.checked
            ? 'REJECTED'
            : '';

        if (!decision) {
            alert('Please select a review decision.');
            return;
        }

        fetch(this.dataset.url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                abstract_id: abstractId,
                comment: comment,
                decision: decision
            })
        })
        .then(async res => {
            const text = await res.text(); // get raw text
            let data;
            try {
                data = JSON.parse(text); // try to parse JSON
            } catch {
                // if not JSON, treat it as server error
                throw new Error(text || 'Unknown server error');
            }

            if (data.status === 'success') {
                alert(data.message);
                location.reload();
            } else {
                alert(data.message || 'Something went wrong.');
            }
        })
        .catch(err => {
            console.error(err);
            alert('An error occurred while submitting your review: ' + err.message);
        });
    });


});
</script>
