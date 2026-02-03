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
        <div class="card bg-gradient" style="background: linear-gradient(135deg, var(--reviewer-blue) 0%, var(--reviewer-dark-blue) 100%); color: white;">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="mb-2"><i class="fas fa-user-tie me-2"></i>Reviewer Information</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Email:</strong> {{ Auth::user()->email ?? 'N/A' }}</p>
                                <p class="mb-1"><strong>Institution:</strong> {{ Auth::user()->institution ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Assigned Sub-theme:</strong> 
                                    <span class="badge bg-light text-dark">
                                        {{ Auth::user()->subtheme->name ?? 'Not Assigned' }}
                                    </span>
                                </p>
                                <p class="mb-1"><strong>Member Since:</strong> {{ Auth::user()->created_at ? Auth::user()->created_at->format('M Y') : 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="user-avatar" style="width: 80px; height: 80px; font-size: 32px; margin: 0 auto;">
                            {{ strtoupper(substr(Auth::user()->name ?? 'R', 0, 1)) }}
                        </div>
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
        <div class="card border-start border-primary border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Approved</h6>
                        <h3 class="mb-0 text-success">{{ $stats['approved'] ?? 0 }}</h3>
                    </div>
                    <i class="fas fa-thumbs-up fa-2x text-success"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card border-start border-danger border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Rejected</h6>
                        <h3 class="mb-0 text-danger">{{ $stats['rejected'] ?? 0 }}</h3>
                    </div>
                    <i class="fas fa-thumbs-down fa-2x text-danger"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card border-start border-warning border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Avg. Review Time</h6>
                        <h3 class="mb-0">{{ $stats['avg_review_time'] ?? 'N/A' }}</h3>
                        <small class="text-muted">hours</small>
                    </div>
                    <i class="fas fa-stopwatch fa-2x text-warning"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card border-start border-info border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Completion Rate</h6>
                        <h3 class="mb-0">{{ $stats['completion_rate'] ?? 0 }}%</h3>
                    </div>
                    <i class="fas fa-chart-pie fa-2x text-info"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Urgent Actions Alert -->
@if(isset($urgentDeadlines) && count($urgentDeadlines) > 0)
<div class="row mb-4">
    <div class="col-12">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h5 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Urgent: Deadlines Approaching!</h5>
            <p>You have {{ count($urgentDeadlines) }} abstract(s) with review deadlines in the next 3 days:</p>
            <ul class="mb-0">
                @foreach($urgentDeadlines as $deadline)
                <li>
                    <strong>{{ $deadline->submission_id }}</strong> - {{ Str::limit($deadline->title, 50) }}
                    <span class="badge bg-white text-dark ms-2">Due: {{ $deadline->review_deadline->format('M d, Y') }}</span>
                    <a href="{{ route('reviewer.abstracts.show', $deadline->id) }}" class="btn btn-sm btn-outline-light ms-2">Review Now</a>
                </li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
</div>
@endif

<!-- Charts Row -->
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
                <div class="mt-3 text-center">
                    <small class="text-muted">Total Reviews: {{ $stats['total_assigned'] ?? 0 }}</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Abstracts and Quick Actions -->
<div class="row">
    <div class="col-md-8 mb-3">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i>Recently Assigned Abstracts</h5>
                <a href="{{ route('reviewer.abstracts.index') }}" class="btn btn-sm btn-reviewer-primary">View All</a>
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
                                        @php
                                            $deadline = \Carbon\Carbon::parse($abstract->review_deadline);
                                            $daysLeft = now()->diffInDays($deadline, false);
                                        @endphp
                                        <small class="{{ $daysLeft <= 3 && $daysLeft >= 0 ? 'text-danger fw-bold' : '' }}">
                                            {{ $deadline->format('M d') }}
                                            @if($daysLeft >= 0)
                                                ({{ $daysLeft }}d)
                                            @else
                                                <span class="text-danger">(Overdue)</span>
                                            @endif
                                        </small>
                                    @else
                                        <small class="text-muted">No deadline</small>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('reviewer.abstracts.show', $abstract->id) }}" class="btn btn-info btn-sm" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('reviewer.abstracts.review', $abstract->id) }}" class="btn btn-primary btn-sm" title="Review">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">No abstracts assigned yet</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('reviewer.abstracts.index', ['status' => 'pending']) }}" class="btn btn-warning">
                        <i class="fas fa-clock me-2"></i>
                        Pending Reviews
                        <span class="badge bg-white text-dark ms-2">{{ $stats['pending_review'] ?? 0 }}</span>
                    </a>
                    
                    <a href="{{ route('reviewer.abstracts.index', ['status' => 'under_review']) }}" class="btn btn-info">
                        <i class="fas fa-search me-2"></i>
                        Continue Reviews
                        <span class="badge bg-white text-dark ms-2">{{ $stats['under_review'] ?? 0 }}</span>
                    </a>
                    
                    <a href="{{ route('reviewer.completed') }}" class="btn btn-success">
                        <i class="fas fa-check-circle me-2"></i>
                        Completed Reviews
                        <span class="badge bg-white text-success ms-2">{{ $stats['completed'] ?? 0 }}</span>
                    </a>
                    
                    <hr>
                    
                    <a href="{{ route('reviewer.help') }}" class="btn btn-outline-primary">
                        <i class="fas fa-book me-2"></i>
                        Review Guidelines
                    </a>
                    
                    <a href="{{ route('reviewer.profile') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-user me-2"></i>
                        My Profile
                    </a>
                </div>
            </div>
        </div>

        <!-- Performance Summary Card -->
        <div class="card mt-3">
            <div class="card-header bg-light">
                <h6 class="mb-0"><i class="fas fa-star me-2"></i>Your Performance</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <small class="text-muted">Completion Rate</small>
                        <small class="fw-bold">{{ $stats['completion_rate'] ?? 0 }}%</small>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $stats['completion_rate'] ?? 0 }}%"></div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <small class="text-muted">On-Time Reviews</small>
                        <small class="fw-bold">{{ $stats['on_time_rate'] ?? 0 }}%</small>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $stats['on_time_rate'] ?? 0 }}%"></div>
                    </div>
                </div>
                
                <hr>
                
                <div class="text-center">
                    <small class="text-muted d-block mb-1">Your Rank This Month</small>
                    <h3 class="mb-0 text-primary">#{{ $stats['rank'] ?? 'N/A' }}</h3>
                    <small class="text-muted">out of {{ $stats['total_reviewers'] ?? 0 }} reviewers</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity Timeline -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-history me-2"></i>Recent Activity</h5>
            </div>
            <div class="card-body">
                <div class="activity-timeline">
                    @forelse($recentActivities ?? [] as $activity)
                    <div class="activity-item d-flex mb-3 pb-3 border-bottom">
                        <div class="activity-icon me-3">
                            <i class="fas fa-{{ $activity->icon ?? 'circle' }} text-{{ $activity->color ?? 'primary' }}"></i>
                        </div>
                        <div class="activity-content flex-grow-1">
                            <p class="mb-1"><strong>{{ $activity->title }}</strong></p>
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
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // Activity Line Chart
    const activityCtx = document.getElementById('activityChart');
    if (activityCtx) {
        new Chart(activityCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartData['months'] ?? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']) !!},
                datasets: [{
                    label: 'Reviews Completed',
                    data: {!! json_encode($chartData['reviews'] ?? [5, 8, 12, 10, 15, 18]) !!},
                    borderColor: 'rgb(30, 90, 150)',
                    backgroundColor: 'rgba(30, 90, 150, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 5
                        }
                    }
                }
            }
        });
    }

    // Status Doughnut Chart
    const statusCtx = document.getElementById('statusChart');
    if (statusCtx) {
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Under Review', 'Completed', 'Approved', 'Rejected'],
                datasets: [{
                    data: [
                        {{ $stats['pending_review'] ?? 0 }},
                        {{ $stats['under_review'] ?? 0 }},
                        {{ $stats['completed'] ?? 0 }},
                        {{ $stats['approved'] ?? 0 }},
                        {{ $stats['rejected'] ?? 0 }}
                    ],
                    backgroundColor: [
                        '#ffc107',
                        '#17a2b8',
                        '#6c757d',
                        '#28a745',
                        '#dc3545'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            font: {
                                size: 11
                            }
                        }
                    }
                }
            }
        });
    }
</script>
@endsection