@extends('reviewer.layout')

@section('title', 'Dashboard')
@section('page-title', 'Reviewer Dashboard')

@section('content')
<div class="page-header">
    <h1>Welcome back, {{ Auth::user()->full_name ?? 'Reviewer' }}!</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </nav>
</div>

<!-- Reviewer Info Card -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card shadow-lg border-0"
             style="background: linear-gradient(135deg, var(--reviewer-blue) 0%, var(--reviewer-dark-blue) 100%);">
            <div class="card-body text-white">
                <h4 class="mb-3">
                    <i class="fas fa-user-tie me-2"></i>Reviewer Information
                </h4>

                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-1">
                            <strong>Email:</strong>
                            <span class="opacity-90">{{ Auth::user()->email ?? 'N/A' }}</span>
                        </p>
                    </div>

                    <div class="col-md-6">
                        <p class="mb-1">
                            <strong>Assigned Sub-theme:</strong>
                            <span class="badge bg-light text-primary fw-semibold">
                                @if(Auth::user()->reviewer && Auth::user()->reviewer->subThemes->isNotEmpty())
                                    @foreach(Auth::user()->reviewer->subThemes as $subtheme)
                                        {{ $subtheme->form_field_value }}@if(!$loop->last), @endif
                                    @endforeach
                                @else
                                    Not Assigned
                                @endif
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-3">
    <div class="col-md-4 mb-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <h3>{{ $stats['total_assigned'] ?? 0 }}</h3>
            <p>Total Assigned</p>
            <i class="fas fa-file-alt stat-card-icon"></i>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
            <h3>{{ $stats['pending_review'] ?? 0 }}</h3>
            <p>Pending Review</p>
            <i class="fas fa-clock stat-card-icon"></i>
        </div>
    </div>

   

    <div class="col-md-4 mb-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
            <h3>{{ $stats['completed'] ?? 0 }}</h3>
            <p>Completed</p>
            <i class="fas fa-check-circle stat-card-icon"></i>
        </div>
    </div>
</div>

<!-- Performance Metrics -->
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card border-start border-success border-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Approved</h6>
                    <h3 class="mb-0 text-success">{{ $stats['approved'] ?? 0 }}</h3>
                </div>
                <i class="fas fa-thumbs-up fa-2x text-success"></i>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card border-start border-danger border-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Rejected</h6>
                    <h3 class="mb-0 text-danger">{{ $stats['rejected'] ?? 0 }}</h3>
                </div>
                <i class="fas fa-thumbs-down fa-2x text-danger"></i>
            </div>
        </div>
    </div>


    <div class="col-md-4 mb-3">
        <div class="card border-start border-info border-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Completion Rate</h6>
                    <h3 class="mb-0">{{ $stats['completion_rate'] ?? 0 }}%</h3>
                </div>
                <i class="fas fa-chart-pie fa-2x text-info"></i>
            </div>
        </div>
    </div>
</div>



<!-- Recently Assigned Abstracts (FULL WIDTH) -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-file-alt me-2"></i>Recently Assigned Abstracts
                </h5>
                <a href="{{ route('reviewer.abstracts.index') }}"
                   class="btn btn-sm btn-reviewer-primary">
                    View All
                </a>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Submission ID</th>
                                <th>Title</th>
                                <th>Status</th>
                               
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentAbstracts ?? [] as $abstract)
                                <tr>
                                    <td><strong class="text-primary">{{ $abstract->submission_code }}</strong></td>
                                    <td>{{ Str::limit($abstract->paper_title, 40) }}</td>
                                    <td>
                                        <span class="badge badge-{{ strtolower(str_replace('_', '-', $abstract->status)) }}">
                                            {{ ucfirst(str_replace('_', ' ', $abstract->status)) }}
                                        </span>
                                    </td>
                                    
                                    <td>
                                        <button class="btn btn-info btn-sm view-abstract"
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
                                            data-status="{{ $abstract->status }}"
                                            data-created="{{ $abstract->created_at->format('d M Y H:i') }}"
                                            data-reviewed-by="{{ auth()->user()->full_name }}"
                                            data-reviewed-at="{{ optional($abstract->latestReview)->created_at?->format('d M Y') }}"
                                            data-abstract="{{ $abstract->abstract_text }}"
                                            data-keywords="{{ $abstract->keywords }}"
                                            data-presentation="{{ $abstract->presentation_preference }}"
                                            data-attendance="{{ $abstract->attendance_mode }}"
                                            data-review-comment="{{ $abstract->latestReview?->comment ?? '' }}"
                                            data-review-decision="{{ $abstract->latestReview?->decision ?? '' }}"
                                        >
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3">
                                        No abstracts assigned yet
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


   

</div>
@endsection
@include('reviewer.partials.abstractModal')
