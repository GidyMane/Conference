@extends('reviewer.layout')

@section('title', 'Make Final Decision')
@section('page-title', 'Make Final Decision on Full Paper')

@section('content')
<style>
    /* --- existing styles --- */
    .review-summary-card { background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border-left: 5px solid #3b82f6; border-radius: 12px; padding: 24px; margin-bottom: 24px; }
    .review-card { border-radius: 12px; overflow: hidden; margin-bottom: 24px; box-shadow: 0 4px 12px rgba(0,0,0,.1); }
    .review-header { background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); color: white; padding: 16px 20px; }
    .review-body { padding: 24px; background: white; }
    .score-display { font-size: 48px; font-weight: 700; color: #16a34a; }
    .section-score-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px dashed #e5e7eb; }
    .section-score-row:last-child { border-bottom: none; }
    .recommendation-badge { padding: 8px 16px; border-radius: 20px; font-weight: 700; text-transform: uppercase; font-size: 13px; }
    .rec-accept { background: #d1fae5; color: #065f46; }
    .rec-needs_major_revisions { background: #fed7aa; color: #9a3412; }
    .rec-needs_minor_revisions { background: #fef3c7; color: #92400e; }
    .rec-reject { background: #fee2e2; color: #991b1b; }
    .rec-not_approved { background: #fee2e2; color: #991b1b; }
    .rec-accept_with_minor_revisions { background: #fef3c7; color: #92400e; }
    .rec-accept_with_major_revisions { background: #fed7aa; color: #9a3412; }
</style>

<div class="container-fluid py-4">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('/reviewer/fullpapers-review') }}">Full Papers</a>
            </li>
            <li class="breadcrumb-item active">Make Decision</li>
        </ol>
    </nav>

    {{-- Paper Info --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="text-success mb-3">{{ $paper->abstract->title }}</h5>
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-2"><strong>Paper ID:</strong> {{ $paper->abstract->submission_code }}</p>
                    <p class="mb-0"><strong>Sub-Theme:</strong> {{ $paper->abstract->subtheme->full_name ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6">
                    <p class="mb-2"><strong>Total Reviews:</strong> {{ $reviews->count() }}</p>
                    <p class="mb-0"><strong>Submitted Reviews:</strong> {{ $reviews->filter(fn($a) => $a->fullPaperReview?->submitted_at)->count() }}/{{ $reviews->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Review Summary --}}
    <div class="review-summary-card">
        <h5 class="mb-4"><i class="fas fa-chart-pie me-2"></i>Review Summary</h5>
        <div class="row">
            <div class="col-md-3 text-center">
                <p class="text-muted mb-1 small">AVERAGE SCORE</p>
                <div class="score-display">{{ $paper->average_score ?? '-' }}</div>
                <p class="text-muted small">out of 100</p>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-6 mb-3">
                        <p class="mb-1 small text-muted">ACCEPT</p>
                        <h4 class="text-success mb-0">{{ $paper->count_accept ?? 0 }}/{{ $reviews->count() }} reviewers</h4>
                    </div>
                    <div class="col-6 mb-3">
                        <p class="mb-1 small text-muted">REJECT</p>
                        <h4 class="text-danger mb-0">{{ $paper->count_reject ?? 0 }}/{{ $reviews->count() }} reviewers</h4>
                    </div>
                    <div class="col-6">
                        <p class="mb-1 small text-muted">MAJOR REVISIONS</p>
                        <h4 class="text-warning mb-0">{{ $paper->count_major ?? 0 }}/{{ $reviews->count() }} reviewers</h4>
                    </div>
                    <div class="col-6">
                        <p class="mb-1 small text-muted">MINOR REVISIONS</p>
                        <h4 class="text-warning mb-0">{{ $paper->count_minor ?? 0 }}/{{ $reviews->count() }} reviewers</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Individual Reviews --}}
    <h5 class="mb-3"><i class="fas fa-clipboard-check me-2"></i>Individual Reviews</h5>

    @foreach($reviews as $assignment)
        @php
            $review = $assignment->fullPaperReview ?? null;
            $reviewerName = $assignment->prequalifiedReviewer->name ?? $assignment->peerReviewer->full_name ?? 'Unknown';
        @endphp

        <div class="review-card">
            <div class="review-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1"><i class="fas fa-user-circle me-2"></i> {{ $reviewerName }}</h6>
                        <small>
                            @if($review && $review->submitted_at)
                                Submitted {{ $review->submitted_at->format('M d, Y') }}
                            @else
                                Not submitted
                            @endif
                        </small>
                    </div>
                    <div class="text-end">
                        <div class="score-display" style="font-size: 32px; color: white;">
                            {{ $review?->total_score ?? '-' }}/100
                        </div>
                    </div>
                </div>
            </div>

            <div class="review-body">
                <h6 class="mb-3">Section Scores</h6>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="section-score-row"><span>Title</span> <strong>{{ $review?->score_title ?? '-' }}/5</strong></div>
                        <div class="section-score-row"><span>Abstract</span> <strong>{{ $review?->score_abstract ?? '-' }}/5</strong></div>
                        <div class="section-score-row"><span>Introduction</span> <strong>{{ $review?->score_introduction ?? '-' }}/10</strong></div>
                        <div class="section-score-row"><span>Methods</span> <strong>{{ $review?->score_methods ?? '-' }}/25</strong></div>
                    </div>
                    <div class="col-md-6">
                        <div class="section-score-row"><span>Results</span> <strong>{{ $review?->score_results ?? '-' }}/25</strong></div>
                        <div class="section-score-row"><span>Discussion</span> <strong>{{ $review?->score_discussion ?? '-' }}/15</strong></div>
                        <div class="section-score-row"><span>Conclusion</span> <strong>{{ $review?->score_conclusion ?? '-' }}/10</strong></div>
                        <div class="section-score-row"><span>References</span> <strong>{{ $review?->score_references ?? '-' }}/5</strong></div>
                    </div>
                </div>

                <div class="mb-3">
                    <h6>Recommendation</h6>
                    @if($review && $review->recommendation)
                        <span class="recommendation-badge rec-{{ $review->recommendation }}">
                            {{ ucwords(str_replace('_', ' ', $review->recommendation)) }}
                        </span>
                        @if($review->presentation_type)
                            <span class="ms-3"><i class="fas fa-presentation me-1"></i> {{ ucwords(str_replace('_', ' ', $review->presentation_type)) }}</span>
                        @endif
                    @else
                        <span class="text-muted">Review not submitted yet.</span>
                    @endif
                </div>

                <div>
                    <h6>Overall Comments</h6>
                    <div class="bg-light p-3 rounded">
                        {{ $review?->overall_comments ?? 'No comments provided.' }}
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @php
        $submittedCount = $reviews->filter(fn($a) => $a->fullPaperReview?->submitted_at)->count();
        $allReviewed = $submittedCount === $reviews->count();
        $decisionMade = !is_null($paper->final_decision);
        $disableForm = !$allReviewed || $decisionMade;
    @endphp

    {{-- Decision Form --}}
    <div class="card border-warning shadow-sm">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0">
                <i class="fas fa-gavel me-2"></i>Make Your Final Decision
            </h5>
        </div>
        <div class="card-body">
            @if($disableForm && !$decisionMade)
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Final decision cannot be made until all reviewers have submitted their reviews.
                    ({{ $submittedCount }}/{{ $reviews->count() }} submitted)
                </div>
            @elseif($decisionMade)
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>
                    Final decision has already been made: <strong>{{ strtoupper(str_replace('_', ' ', $paper->final_decision)) }}</strong>
                </div>
            @endif

            <form method="POST" action="{{ route('reviewer.fullpapers.final-decision', $paper->id) }}">
                @csrf
                <fieldset @if($disableForm) disabled @endif>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Final Decision <span class="text-danger">*</span></label>
                        <select name="decision" class="form-select form-select-lg" required>
                            <option value="">-- Select Decision --</option>
                             
                            <option value="approved_with_minor_revisions">⚠ Accept with Minor Revisions</option>
                            <option value="approved_with_major_revisions">⚠ Accept with Major Revisions</option>
                            <option value="not_approved">✗ Not Approved</option>
                        </select>
                        <small class="text-muted">
                            This decision is final and will determine if the paper is accepted for the conference.
                        </small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Recommended Presentation Format <span class="text-danger">*</span></label>
                        <select name="presentation_type" class="form-select" required>
                            <option value="">-- Select Format --</option>
                            <option value="powerpoint">📊 PowerPoint Presentation</option>
                            <option value="poster">📋 Poster Presentation</option>
                        </select>
                        <small class="text-muted">
                            Select the most appropriate format for presenting this paper at the conference.
                        </small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Comments to Author <span class="text-danger">*</span></label>
                        <textarea name="comments" 
                                  class="form-control" 
                                  rows="5"
                                  minlength="20"
                                  placeholder="Provide constructive feedback based on reviewers' comments and your assessment..."
                                  required></textarea>
                        <small class="text-muted">
                            Minimum 20 characters. This will be sent directly to the author along with your decision.
                        </small>
                    </div>

                    <div class="alert alert-info">
                        <h6 class="alert-heading">
                            <i class="fas fa-info-circle me-2"></i>What Happens Next?
                        </h6>
                        <ul class="mb-0 small">
                            <li><strong>If ACCEPTED:</strong> Author receives email with link to upload presentation materials (PowerPoint/Poster)</li>
                            <li><strong>If ACCEPTED WITH REVISIONS:</strong> Author receives email with revision requirements and resubmission instructions</li>
                            <li><strong>If NOT APPROVED:</strong> Author receives email with your comments and reviewers' feedback</li>
                            <li>Decision is <strong>final</strong> and cannot be changed after submission</li>
                        </ul>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning btn-lg">
                            <i class="fas fa-paper-plane me-2"></i>
                            Submit Decision & Notify Author
                        </button>
                        <a href="{{ url('/reviewer/fullpapers-review') }}" class="btn btn-secondary btn-lg">Cancel</a>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>

</div>
@endsection