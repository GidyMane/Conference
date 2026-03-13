@extends('admin.layout')

@section('title', 'Paper Reviews')
@section('page-title', 'Paper Reviews')

@section('styles')
<style>
    .page-hero {
        background: linear-gradient(135deg, #1f6129 0%, #2d8a3e 60%, #16a34a 100%);
        border-radius: 16px;
        padding: 32px 36px;
        color: white;
        margin-bottom: 32px;
        position: relative;
        overflow: hidden;
    }
    .page-hero::after {
        content: '\f46d';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        right: 40px; top: 50%;
        transform: translateY(-50%);
        font-size: 120px;
        opacity: .06;
    }
    .page-hero h2 { font-weight: 700; font-size: 24px; margin-bottom: 6px; }
    .page-hero p  { opacity: .85; margin: 0; font-size: 14px; }

    .review-summary-card {
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        border-left: 5px solid #2d8a3e;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 24px;
    }

    .review-card {
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 24px;
        box-shadow: 0 4px 12px rgba(0,0,0,.08);
        border: 1px solid #e5e7eb;
    }

    .review-header {
        background: linear-gradient(135deg, #2d8a3e 0%, #1f6129 100%);
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
        color: #2d8a3e;
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
    .rec-accept                        { background: #d1fae5; color: #065f46; }
    .rec-needs_major_revisions         { background: #fed7aa; color: #9a3412; }
    .rec-needs_minor_revisions         { background: #fef3c7; color: #92400e; }
    .rec-reject                        { background: #fee2e2; color: #991b1b; }
    .rec-not_approved                  { background: #fee2e2; color: #991b1b; }
    .rec-accept_with_minor_revisions   { background: #fef3c7; color: #92400e; }
    .rec-accept_with_major_revisions   { background: #fed7aa; color: #9a3412; }

    .paper-info-card {
        background: #f0fdf4;
        border-left: 4px solid #2d8a3e;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 24px;
    }

    .decision-banner {
        border-radius: 12px;
        padding: 20px 24px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .decision-banner.approved  { background: #d1fae5; border: 2px solid #86efac; }
    .decision-banner.rejected  { background: #fee2e2; border: 2px solid #fca5a5; }
    .decision-banner i { font-size: 32px; }
    .decision-banner.approved i { color: #16a34a; }
    .decision-banner.rejected i { color: #dc2626; }
    .decision-banner h5 { margin: 0 0 4px; font-weight: 700; font-size: 16px; }
    .decision-banner p  { margin: 0; font-size: 14px; color: #374151; }

    .stat-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 700;
    }
    .pill-accept  { background: #d1fae5; color: #065f46; }
    .pill-reject  { background: #fee2e2; color: #991b1b; }
    .pill-major   { background: #fed7aa; color: #9a3412; }
    .pill-minor   { background: #fef3c7; color: #92400e; }
</style>
@endsection

@section('content')

{{-- Hero --}}
<div class="page-hero">
    <h2><i class="fas fa-clipboard-check me-2"></i>Paper Reviews</h2>
    <p>Read-only view of all reviewer submissions and the final decision for this paper.</p>
</div>

{{-- Breadcrumb --}}
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('admin.fullpapers.completed') }}" class="text-success">Fully Reviewed Papers</a>
        </li>
        <li class="breadcrumb-item active">Paper Reviews</li>
    </ol>
</nav>

{{-- Final Decision Banner --}}
@if($paper->final_decision)
<div class="decision-banner {{ in_array(strtolower($paper->status), ['approved']) ? 'approved' : 'rejected' }}">
    <i class="fas {{ in_array(strtolower($paper->status), ['approved']) ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
    <div>
        <h5>Final Decision: {{ strtoupper(str_replace('_', ' ', $paper->final_decision)) }}</h5>
        <p>
            Presentation Format: <strong>{{ ucfirst($paper->presentation_type ?? 'N/A') }}</strong>
            &nbsp;·&nbsp;
            Decision made: <strong>{{ $paper->decision_made_at ? \Carbon\Carbon::parse($paper->decision_made_at)->format('M d, Y') : 'N/A' }}</strong>
        </p>
        @if($paper->leader_comments)
        <p class="mt-2"><strong>Comments to Author:</strong> {{ $paper->leader_comments }}</p>
        @endif
    </div>
</div>
@endif

{{-- Paper Info --}}
<div class="paper-info-card">
    <h5 class="text-success mb-3">
        <i class="fas fa-file-alt me-2"></i>{{ $paper->abstract->title ?? 'N/A' }}
    </h5>
    <div class="row">
        <div class="col-md-6">
            <p class="mb-2"><strong>Paper ID:</strong> {{ $paper->abstract->submission_code ?? 'N/A' }}</p>
            <p class="mb-0"><strong>Author:</strong> {{ $paper->abstract->author_name ?? 'N/A' }}</p>
        </div>
        <div class="col-md-6">
            <p class="mb-2"><strong>Sub-Theme:</strong> {{ $paper->abstract->subtheme->full_name ?? 'N/A' }}</p>
            <p class="mb-0">
                <strong>Total Reviews:</strong> {{ $reviews->count() }}
                &nbsp;·&nbsp;
                <strong>Submitted:</strong> {{ $reviews->filter(fn($a) => $a->fullPaperReview?->submitted_at)->count() }}/{{ $reviews->count() }}
            </p>
        </div>
    </div>
</div>

{{-- Review Summary --}}
<div class="review-summary-card">
    <h5 class="mb-4 text-success"><i class="fas fa-chart-pie me-2"></i>Review Summary</h5>
    <div class="row">
        <div class="col-md-3 text-center">
            <p class="text-muted mb-1 small">AVERAGE SCORE</p>
            <div class="score-display">{{ $paper->average_score ?? '-' }}</div>
            <p class="text-muted small">out of 100</p>
        </div>
        <div class="col-md-9">
            <div class="row g-3 align-items-center">
                <div class="col-6">
                    <span class="stat-pill pill-accept">
                        <i class="fas fa-check"></i>
                        Accept: {{ $paper->count_accept ?? 0 }}/{{ $reviews->count() }}
                    </span>
                </div>
                <div class="col-6">
                    <span class="stat-pill pill-reject">
                        <i class="fas fa-times"></i>
                        Reject: {{ $paper->count_reject ?? 0 }}/{{ $reviews->count() }}
                    </span>
                </div>
                <div class="col-6">
                    <span class="stat-pill pill-major">
                        <i class="fas fa-exclamation"></i>
                        Major Revisions: {{ $paper->count_major ?? 0 }}/{{ $reviews->count() }}
                    </span>
                </div>
                <div class="col-6">
                    <span class="stat-pill pill-minor">
                        <i class="fas fa-info"></i>
                        Minor Revisions: {{ $paper->count_minor ?? 0 }}/{{ $reviews->count() }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Individual Reviews --}}
<h5 class="mb-3"><i class="fas fa-clipboard-check me-2 text-success"></i>Individual Reviews</h5>

@foreach($reviews as $assignment)
    @php
        $review       = $assignment->fullPaperReview ?? null;
        $reviewerName = $assignment->prequalifiedReviewer->name
                     ?? $assignment->peerReviewer->full_name
                     ?? 'Unknown';
    @endphp

    <div class="review-card">
        <div class="review-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1"><i class="fas fa-user-circle me-2"></i>{{ $reviewerName }}</h6>
                    <small>
                        @if($review && $review->submitted_at)
                            Submitted {{ $review->submitted_at->format('M d, Y') }}
                        @else
                            Not yet submitted
                        @endif
                    </small>
                </div>
                <div class="text-end">
                    <div style="font-size:32px; font-weight:700; color:white;">
                        {{ $review?->total_score ?? '-' }}/100
                    </div>
                </div>
            </div>
        </div>

        <div class="review-body">

            @if(!$review)
                <div class="alert alert-warning mb-0">
                    <i class="fas fa-hourglass-half me-2"></i>This reviewer has not yet submitted their review.
                </div>
            @else
                <h6 class="mb-3">Section Scores</h6>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="section-score-row"><span>Title</span>        <strong>{{ $review->score_title ?? '-' }}/5</strong></div>
                        <div class="section-score-row"><span>Abstract</span>     <strong>{{ $review->score_abstract ?? '-' }}/5</strong></div>
                        <div class="section-score-row"><span>Introduction</span> <strong>{{ $review->score_introduction ?? '-' }}/10</strong></div>
                        <div class="section-score-row"><span>Methods</span>      <strong>{{ $review->score_methods ?? '-' }}/25</strong></div>
                    </div>
                    <div class="col-md-6">
                        <div class="section-score-row"><span>Results</span>    <strong>{{ $review->score_results ?? '-' }}/25</strong></div>
                        <div class="section-score-row"><span>Discussion</span> <strong>{{ $review->score_discussion ?? '-' }}/15</strong></div>
                        <div class="section-score-row"><span>Conclusion</span> <strong>{{ $review->score_conclusion ?? '-' }}/10</strong></div>
                        <div class="section-score-row"><span>References</span> <strong>{{ $review->score_references ?? '-' }}/5</strong></div>
                    </div>
                </div>

                <div class="mb-3">
                    <h6>Recommendation</h6>
                    <span class="recommendation-badge rec-{{ $review->recommendation }}">
                        {{ ucwords(str_replace('_', ' ', $review->recommendation)) }}
                    </span>
                    @if($review->presentation_type)
                        <span class="ms-3 text-muted small">
                            <i class="fas fa-desktop me-1"></i>
                            Suggested Format: {{ ucwords(str_replace('_', ' ', $review->presentation_type)) }}
                        </span>
                    @endif
                </div>

                <div>
                    <h6>Overall Comments</h6>
                    <div class="bg-light p-3 rounded" style="line-height:1.7">
                        {{ $review->overall_comments ?? 'No comments provided.' }}
                    </div>
                </div>
            @endif

        </div>
    </div>
@endforeach

{{-- Back Button --}}
<div class="mt-2 mb-5">
    <a href="{{ route('admin.fullpapers.completed') }}" class="btn btn-success">
        <i class="fas fa-arrow-left me-2"></i>Back to Fully Reviewed Papers
    </a>
    @if(in_array(strtolower($paper->status), ['approved']))
    <a href="{{ route('admin.fullpapers.materials', $paper->id) }}" class="btn btn-outline-primary ms-2">
        <i class="fas fa-file-alt me-2"></i>View Presentation Materials
    </a>
    @endif
</div>

@endsection