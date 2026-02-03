@extends('reviewer.layout')

@section('title', 'Dashboard')
@section('page-title', 'Reviewer Dashboard')

@section('content')
<div class="page-header">
    <h1>Welcome back, {{ Auth::user()->name ?? 'Reviewer' }}!</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </nav>
</div>

<!-- Reviewer Info Card -->
<div class="row mb-4">
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
                                {{ Auth::user()->subtheme->name ?? 'Not Assigned' }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <h3>{{ $stats['total_assigned'] ?? 0 }}</h3>
            <p>Total Assigned</p>
            <i class="fas fa-file-alt stat-card-icon"></i>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
            <h3>{{ $stats['pending_review'] ?? 0 }}</h3>
            <p>Pending Review</p>
            <i class="fas fa-clock stat-card-icon"></i>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <h3>{{ $stats['under_review'] ?? 0 }}</h3>
            <p>Under Review</p>
            <i class="fas fa-search stat-card-icon"></i>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
            <h3>{{ $stats['completed'] ?? 0 }}</h3>
            <p>Completed</p>
            <i class="fas fa-check-circle stat-card-icon"></i>
        </div>
    </div>
</div>

<!-- Performance Metrics -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
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

    <div class="col-md-3 mb-3">
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

    <div class="col-md-3 mb-3">
        <div class="card border-start border-warning border-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Avg. Review Time</h6>
                    <h3 class="mb-0">{{ $stats['avg_review_time'] ?? 'N/A' }}</h3>
                    <small class="text-muted">hours</small>
                </div>
                <i class="fas fa-stopwatch fa-2x text-warning"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
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

<!-- Charts -->
<div class="row mb-4">
    <div class="col-md-8 mb-3">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Review Activity Over Time</h5>
            </div>
            <div class="card-body">
                <canvas id="activityChart" height="80"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-pie-chart me-2"></i>Review Status</h5>
            </div>
            <div class="card-body">
                <canvas id="statusChart"></canvas>
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
                                <th>Deadline</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentAbstracts ?? [] as $abstract)
                                <tr>
                                    <td><strong class="text-primary">{{ $abstract->submission_id }}</strong></td>
                                    <td>{{ Str::limit($abstract->title, 40) }}</td>
                                    <td>
                                        <span class="badge badge-{{ strtolower(str_replace('_', '-', $abstract->review_status ?? 'pending')) }}">
                                            {{ ucfirst(str_replace('_', ' ', $abstract->review_status ?? 'Pending')) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($abstract->review_deadline)
                                            {{ \Carbon\Carbon::parse($abstract->review_deadline)->format('M d') }}
                                        @else
                                            <small class="text-muted">No deadline</small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('reviewer.abstracts.show', $abstract->id) }}" class="btn btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('reviewer.abstracts.review', $abstract->id) }}" class="btn btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
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

<!-- Quick Actions + Recent Activity (SHARED ROW) -->
<div class="row mb-4">

    <!-- Quick Actions -->
    <div class="col-md-4 mb-3">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
            </div>
            <div class="card-body d-grid gap-2">
                <a href="{{ route('reviewer.abstracts.index', ['status' => 'pending']) }}" class="btn btn-warning">
                    Pending Reviews
                </a>
                <a href="{{ route('reviewer.abstracts.index', ['status' => 'under_review']) }}" class="btn btn-info">
                    Continue Reviews
                </a>
                <a href="{{ route('reviewer.profile') }}" class="btn btn-outline-secondary">
                    My Profile
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="col-md-8 mb-3">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-history me-2"></i>Recent Activity</h5>
            </div>
            <div class="card-body">
                @forelse($recentActivities ?? [] as $activity)
                    <div class="d-flex mb-3 pb-3 border-bottom">
                        <div class="me-3">
                            <i class="fas fa-{{ $activity->icon ?? 'circle' }}
                               text-{{ $activity->color ?? 'primary' }}"></i>
                        </div>
                        <div>
                            <strong>{{ $activity->title }}</strong>
                            <p class="text-muted small mb-0">{{ $activity->description }}</p>
                            <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-muted mb-0">No recent activities</p>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection
