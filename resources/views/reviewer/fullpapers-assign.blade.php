@extends('reviewer.layout')

@section('title', 'Assign Reviewers')
@section('page-title', 'Assign Reviewers to Full Paper')

@section('content')
<style>
    .paper-info-card {
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        border-left: 5px solid #16a34a;
    }
    .reviewer-card {
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        padding: 20px;
        background: #fafafa;
        transition: all .3s;
    }
    .reviewer-card:hover {
        border-color: #1e5a96;
        background: #f0f9ff;
        transform: translateY(-2px);
    }
    .reviewer-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
    }
    .badge-prequalified { background: #fef3c7; color: #92400e; }
    .badge-peer { background: #dbeafe; color: #1e40af; }
    
    .assignment-info {
        background: #eff6ff;
        border-left: 4px solid #3b82f6;
        padding: 16px;
        border-radius: 8px;
    }
</style>

<div class="container-fluid py-4">
    
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('/reviewer/fullpapers-review') }}">Full Papers</a>
            </li>
            <li class="breadcrumb-item active">Assign Reviewers</li>
        </ol>
    </nav>

    {{-- Paper Details Card --}}
    <div class="card paper-info-card mb-4">
        <div class="card-header bg-transparent border-0">
            <h5 class="mb-0 text-success">
                <i class="fas fa-file-alt me-2"></i>Paper Information
            </h5>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-lg-8">

                    {{-- Paper Title --}}
                    <h6 class="mb-3">
                        {{ $paper->abstract->paper_title ?? 'N/A' }}
                    </h6>

                    <div class="row">
                        <div class="col-md-6">

                            {{-- Paper Code --}}
                            <p class="mb-2">
                                <strong>Paper ID:</strong>
                                <span class="text-success">
                                    {{ $paper->full_paper_code ?? 'N/A' }}
                                </span>
                            </p>
                            
                            {{-- Submission Date --}}
                            <p class="mb-0">
                                <strong>Submitted:</strong>
                                {{ $paper->uploaded_at?->format('M d, Y') ?? 'N/A' }}
                            </p>



                        </div>

                        <div class="col-md-6">

                            {{-- Sub Theme --}}
                            <p class="mb-2">
                                <strong>Sub-Theme:</strong>
                                {{ $paper->abstract->subTheme->full_name ?? 'N/A' }}
                            </p>



                        </div>
                    </div>
                </div>

                {{-- Download Button --}}
                <div class="col-lg-4 text-end">
                    @if($paper->paper_url)
                        <a href="{{ asset('full-papers/'.$paper->abstract->sub_theme_id.'/'.basename($paper->file_path)) }}"
                            class="btn btn-success"
                            target="_blank"
                            download>
                                <i class="fas fa-download me-2"></i>
                                Download Paper
                        </a>
                    @else
                        <button class="btn btn-secondary" disabled>
                            No File Available
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Assignment Instructions --}}
    <div class="assignment-info mb-4">
        <h6><i class="fas fa-info-circle me-2"></i>Assignment Requirements</h6>
        <ul class="mb-0 small">
            <li><strong>Reviewer 1:</strong> Must be a <strong>prequalified reviewer</strong> from our expert pool</li>
            <li><strong>Reviewers 2 & 3:</strong> Must be <strong>peer authors</strong> (authors who submitted full papers)</li>
            <li>All 3 reviewers must be <strong>different people</strong></li>
            <li>Each reviewer can review maximum <strong>3 papers</strong></li>
            <li>Reviewers will receive email with unique review link valid for <strong>14 days</strong></li>
        </ul>
    </div>

    {{-- Assignment Form --}}
    <form method="POST" action="{{ route('reviewer.fullpapers.assign.submit', $paper->id) }}">
        @csrf

        <div class="row">
            
            {{-- Reviewer 1: Prequalified --}}
            <div class="col-lg-4 mb-4">
                <div class="reviewer-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0">
                            <i class="fas fa-star text-warning me-2"></i>Reviewer 1
                        </h6>
                        <span class="reviewer-badge badge-prequalified">Prequalified</span>
                    </div>
                    
                    <label class="form-label small text-muted mb-2">
                        Select from expert pool <span class="text-danger">*</span>
                    </label>
                    
                    <select name="reviewer1" class="form-select" required>
                        <option value="">-- Choose Expert --</option>

                        @foreach($prequalifiedReviewers as $reviewer)
                            <option value="{{ $reviewer->id }}">
                                {{ $reviewer->title }} {{ $reviewer->name }}
                                ({{ $reviewer->email }})
                                - {{ $reviewer->assigned_count }}/3 papers
                            </option>
                        @endforeach
                    </select>
                    
                    <small class="text-muted d-block mt-2">
                        <i class="fas fa-check-circle me-1"></i>Expert from verified pool
                    </small>
                </div>
            </div>

            {{-- Reviewer 2: Peer --}}
            <div class="col-lg-4 mb-4">
                <div class="reviewer-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0">
                            <i class="fas fa-users text-primary me-2"></i>Reviewer 2
                        </h6>
                        <span class="reviewer-badge badge-peer">Peer Author</span>
                    </div>
                    
                    <label class="form-label small text-muted mb-2">
                        Select peer author <span class="text-danger">*</span>
                    </label>
                    
                    <select name="reviewer2" class="form-select" required>
                        <option value="">-- Choose Peer --</option>

                        @foreach($peerReviewers as $peer)
                            <option value="{{ $peer->id }}">
                                {{ $peer->full_name }} ({{ $peer->email }})
                            </option>
                        @endforeach
                    </select>
                    
                    <small class="text-muted d-block mt-2">
                        <i class="fas fa-check-circle me-1"></i>Author with submitted paper
                    </small>
                </div>
            </div>

            {{-- Reviewer 3: Peer --}}
            <div class="col-lg-4 mb-4">
                <div class="reviewer-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0">
                            <i class="fas fa-users text-primary me-2"></i>Reviewer 3
                        </h6>
                        <span class="reviewer-badge badge-peer">Peer Author</span>
                    </div>
                    
                    <label class="form-label small text-muted mb-2">
                        Select another peer <span class="text-danger">*</span>
                    </label>
                    
                    <select name="reviewer3" class="form-select" required>
                        <option value="">-- Choose Peer --</option>

                        @foreach($peerReviewers as $peer)
                            <option value="{{ $peer->id }}">
                                {{ $peer->full_name }} ({{ $peer->email }})
                            </option>
                        @endforeach
                    </select>
                    
                    <small class="text-muted d-block mt-2">
                        <i class="fas fa-check-circle me-1"></i>Must differ from Reviewer 2
                    </small>
                </div>
            </div>

        </div>

        {{-- Warning Notice --}}
        <div class="alert alert-warning">
            <div class="d-flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle fa-2x"></i>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="alert-heading">Before You Assign</h6>
                    <ul class="mb-0 small">
                        <li>Each reviewer will receive an <strong>email with a unique review link</strong></li>
                        <li>They have <strong>14 days</strong> to complete the review</li>
                        <li>Review uses the <strong>standardized KALRO template</strong> (8 sections, 100 points)</li>
                        <li>You cannot change assignments once a review is <strong>started or completed</strong></li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <!-- <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success btn-lg">
                <i class="fas fa-paper-plane me-2"></i>
                Assign Reviewers & Send Emails
            </button>
            <a href="{{ url('/reviewer/fullpapers-review') }}" class="btn btn-secondary btn-lg">
                <i class="fas fa-times me-2"></i>Cancel
            </a>
        </div> -->
        <div class="alert alert-warning d-flex align-items-center gap-2 mt-2">
    <i class="fas fa-ban"></i>
    <span>Reviewer assignment is currently disabled. Please check back later.</span>
</div>

    </form>

</div>

<script>
document.querySelector('form').addEventListener('submit', function(e) {
    const r1 = document.querySelector('[name="reviewer1"]').value;
    const r2 = document.querySelector('[name="reviewer2"]').value;
    const r3 = document.querySelector('[name="reviewer3"]').value;

    if (r1 === r2 || r1 === r3 || r2 === r3) {
        e.preventDefault();
        alert("All 3 reviewers must be different.");
    }
});
</script>
<script>
const reviewer2 = document.querySelector('[name="reviewer2"]');
const reviewer3 = document.querySelector('[name="reviewer3"]');

reviewer2.addEventListener('change', function() {
    const selectedId = this.value;

    // Loop through Reviewer 3 options
    for (let option of reviewer3.options) {
        if(option.value === selectedId) {
            option.disabled = true; // disable selected reviewer
        } else {
            option.disabled = false;
        }
    }

    // Reset Reviewer 3 if currently selected option was disabled
    if(reviewer3.value === selectedId){
        reviewer3.value = '';
    }
});
</script>
@endsection