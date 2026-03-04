@extends('reviewer.layout')

@section('title', 'Make Final Decision')
@section('page-title', 'Make Final Decision on Full Paper')

@section('content')
<style>
    .review-summary-card {
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        border-left: 5px solid #3b82f6;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 24px;
    }
    .review-card {
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 24px;
        box-shadow: 0 4px 12px rgba(0,0,0,.1);
    }
    .review-header {
        background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
        color: white;
        padding: 16px 20px;
    }
    .review-body {
        padding: 24px;
        background: white;
    }
    .score-display {
        font-size: 48px;
        font-weight: 700;
        color: #16a34a;
    }
    .section-score-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px dashed #e5e7eb;
    }
    .section-score-row:last-child { border-bottom: none; }
    
    .recommendation-badge {
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 13px;
    }
    .rec-accept { background: #d1fae5; color: #065f46; }
    .rec-needs_major_revisions { background: #fed7aa; color: #9a3412; }
    .rec-needs_minor_revisions { background: #fef3c7; color: #92400e; }
    .rec-reject { background: #fee2e2; color: #991b1b; }
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
                <div class="col-md-4">
                    <p class="mb-2"><strong>Paper ID:</strong> {{ $paper->abstract->submission_code }}</p>
                    <p class="mb-0"><strong>Author:</strong> {{ $paper->abstract->author_name }}</p>
                </div>
                <div class="col-md-4">
                    <p class="mb-2"><strong>Email:</strong> {{ $paper->abstract->author_email }}</p>
                    <p class="mb-0"><strong>Sub-Theme:</strong> {{ $paper->abstract->subtheme->full_name ?? 'N/A' }}</p>
                </div>
                <div class="col-md-4 text-end">
                    <button class="btn btn-outline-success" onclick="alert('Download would start')">
                        <i class="fas fa-download me-1"></i>Download Paper
                    </button>
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
                            {{ $assignment->isPrequalified() ? 'Prequalified Reviewer' : 'Peer Reviewer' }} · 
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
                            <span class="ms-3"><i class="fas fa-presentation me-1"></i> {{ $review->presentation_type }}</span>
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
        // Count submitted reviews
        $submittedCount = $reviews->filter(fn($a) => $a->fullPaperReview?->submitted_at)->count();
        $allReviewed = $submittedCount === $reviews->count();
    @endphp

    {{-- Decision Form --}}
    <div class="card border-warning shadow-sm">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0">
                <i class="fas fa-gavel me-2"></i>Make Your Final Decision
            </h5>
        </div>
        <div class="card-body">
            @if(!$allReviewed)
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Final decision cannot be made until all reviewers have submitted their reviews.
                    ({{ $submittedCount }}/{{ $reviews->count() }} submitted)
                </div>
            @endif

            <form method="POST" action="{{ route('reviewer.fullpapers.final-decision', $paper->id) }}">
                @csrf
                {{-- Disable form fields if not all reviews submitted --}}
                <fieldset @if(!$allReviewed) disabled @endif>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Decision <span class="text-danger">*</span></label>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check p-3 border rounded mb-2">
                                    <input class="form-check-input" type="radio" name="decision" id="approve" value="approved" required>
                                    <label class="form-check-label fw-bold text-success" for="approve">
                                        <i class="fas fa-check-circle me-2"></i>APPROVE
                                        <br><small class="text-muted fw-normal">Paper is accepted for the conference</small>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check p-3 border rounded">
                                    <input class="form-check-input" type="radio" name="decision" id="reject" value="rejected" required>
                                    <label class="form-check-label fw-bold text-danger" for="reject">
                                        <i class="fas fa-times-circle me-2"></i>REJECT
                                        <br><small class="text-muted fw-normal">Paper will not be presented</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Comments to Author <span class="text-danger">*</span></label>
                        <textarea name="comments" class="form-control" rows="5"
                                placeholder="Provide constructive feedback to the author..."
                                required></textarea>
                        <small class="text-muted">Minimum 20 characters. This will be sent directly to the author.</small>
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
@endsection