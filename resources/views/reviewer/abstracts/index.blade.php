@extends('reviewer.layout')

@section('title', 'My Abstracts')
@section('page-title', 'My Assigned Abstracts')

@section('content')

<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1>My Assigned Abstracts</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('reviewer.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">My Abstracts</li>
                </ol>
            </nav>

            @if(Auth::user()->subtheme)
                <div class="reviewer-badge">
                    <i class="fas fa-tag"></i>
                    Your Sub-theme:
                    <strong>{{ Auth::user()->subtheme->name }}</strong>
                </div>
            @endif
        </div>

        <div>
            <button class="btn btn-outline-success" onclick="exportData()">
                <i class="fas fa-file-excel me-2"></i>Export My Reviews
            </button>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filters</h5>
    </div>

    <div class="card-body">
        <form method="GET" action="{{ route('reviewer.abstracts.index') }}">
            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option>
                        <option value="reviewed" {{ request('status')=='reviewed' ? 'selected' : '' }}>Reviewed</option>
                        <option value="approved" {{ request('status')=='approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status')=='rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Sort By</label>
                    <select name="sort" class="form-select">
                        <option value="newest" {{ request('sort')=='newest' ? 'selected' : '' }}>Newest First</option>
                        <option value="oldest" {{ request('sort')=='oldest' ? 'selected' : '' }}>Oldest First</option>
                    </select>
                </div>

                <div class="col-12">
                    <button class="btn btn-reviewer-primary">
                        <i class="fas fa-search me-2"></i>Apply Filters
                    </button>
                    <a href="{{ route('reviewer.abstracts.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-redo me-2"></i>Reset
                    </a>
                </div>

            </div>
        </form>
    </div>
</div>

<!-- Stats -->
<div class="row mb-4">
@foreach([
    'pending' => 'warning',
    'reviewed' => 'primary',
    'approved' => 'success',
    'rejected' => 'danger',
] as $status => $color)
    <div class="col-md-3 mb-3">
        <div class="card border-start border-4 border-{{ $color }}">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted text-capitalize">{{ $status }}</h6>
                    <h3>{{ $statusCounts[$status] ?? 0 }}</h3>
                </div>
                <i class="fas fa-{{ match($status) {
                    'pending' => 'clock',
                    'reviewed' => 'check-circle',
                    'approved' => 'thumbs-up',
                    'rejected' => 'times-circle'
                } }} fa-2x text-{{ $color }}"></i>
            </div>
        </div>
    </div>
@endforeach
</div>

<!-- Abstracts Table -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>My Assigned Abstracts</h5>
    </div>

    <div class="card-body">
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
                @forelse($abstracts as $abstract)
                    <tr>
                        <td><strong>{{ $abstract->submission_code }}</strong></td>
                        <td>{{ $abstract->paper_title }}</td>
                        <td>{{ $abstract->author_name }}</td>

                        {{-- Status --}}
                        <td>
                            @php
                                $status = strtolower($abstract->status);

                                if ($status === 'under_review') {
                                    $status = 'pending';
                                }

                                $statusMap = [
                                    'pending' => ['Pending', 'bg-warning'],
                                    'reviewed' => ['Reviewed', 'bg-primary'],
                                    'approved' => ['Approved', 'bg-success'],
                                    'rejected' => ['Rejected', 'bg-danger'],
                                ];

                                [$label, $class] = $statusMap[$status] ?? ['Unknown', 'bg-secondary'];
                            @endphp

                            <span class="badge {{ $class }}">
                                {{ $label }}
                            </span>
                        </td>

                        {{-- Assigned Date --}}
                        <td>
                            {{ optional($abstract->assignments->first())->created_at?->format('M d, Y') ?? 'N/A' }}
                        </td>

                        {{-- Actions --}}
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-info view-abstract"
                                    data-bs-toggle="modal"
                                    data-bs-target="#abstractModal"
                                    data-id="{{ $abstract->id }}"
                                    data-code="{{ $abstract->submission_code }}"
                                    data-title="{{ $abstract->paper_title }}"
                                    data-author="{{ $abstract->author_name }}"
                                    data-email="{{ $abstract->author_email }}"
                                    data-phone="{{ $abstract->author_phone }}"
                                    data-org="{{ $abstract->organisation }}"
                                    data-theme="{{ $abstract->subTheme->full_name ?? '' }}"
                                    data-status="{{ ucfirst($label) }}"
                                    data-created="{{ $abstract->created_at->format('d M Y H:i') }}"
                                    data-abstract="{{ $abstract->abstract_text }}"
                                    data-keywords="{{ $abstract->keywords }}"
                                    data-presentation="{{ $abstract->presentation_preference }}"
                                    data-attendance="{{ $abstract->attendance_mode }}"
                                    data-review-comment="{{ $abstract->latestReview?->comment ?? '' }}"
                                    data-review-decision="{{ $abstract->latestReview?->decision ?? '' }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            No abstracts assigned yet.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
@include('reviewer.partials.abstractModal')

@section('scripts')
<script>
function downloadAbstract(id) {
    window.open('/reviewer/abstracts/' + id + '/download', '_blank');
}

function exportData() {
    const params = new URLSearchParams(window.location.search);
    window.location.href = '/reviewer/abstracts/export?' + params.toString();
}
</script>
@endsection
