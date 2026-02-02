@extends('admin.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="page-header">
    <h1>Dashboard Overview</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </nav>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <h3>{{ $stats['total_abstracts'] ?? 0 }}</h3>
            <p>Total Abstracts</p>
            <i class="fas fa-file-alt stat-card-icon"></i>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <h3>{{ $stats['pending_abstracts'] ?? 0 }}</h3>
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
            <h3>{{ $stats['approved_abstracts'] ?? 0 }}</h3>
            <p>Approved</p>
            <i class="fas fa-check-circle stat-card-icon"></i>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
            <h3>{{ $stats['rejected_abstracts'] ?? 0 }}</h3>
            <p>Rejected</p>
            <i class="fas fa-times-circle stat-card-icon"></i>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #30cfd0 0%, #330867 100%);">
            <h3>{{ $stats['full_papers'] ?? 0 }}</h3>
            <p>Full Papers</p>
            <i class="fas fa-file-pdf stat-card-icon"></i>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);">
            <h3>{{ $stats['registrations'] ?? 0 }}</h3>
            <p>Registrations</p>
            <i class="fas fa-users stat-card-icon"></i>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);">
            <h3>{{ $stats['exhibitions'] ?? 0 }}</h3>
            <p>Exhibitions</p>
            <i class="fas fa-store stat-card-icon"></i>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row mb-4">
    <div class="col-md-8 mb-3">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Submissions by Sub-theme</h5>
            </div>
            <div class="card-body">
                <canvas id="subthemeChart" height="80"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-pie-chart me-2"></i>Abstract Status</h5>
            </div>
            <div class="card-body">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div class="row">
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i>Recent Abstracts</h5>
                <a href="{{ route('admin.abstracts.index') }}" class="btn btn-sm btn-kalro-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Submission ID</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentAbstracts ?? [] as $abstract)
                            <tr>
                                <td><strong>{{ $abstract->submission_id }}</strong></td>
                                <td>{{ Str::limit($abstract->title, 40) }}</td>
                                <td>
                                    <span class="badge badge-{{ strtolower(str_replace('_', '-', $abstract->status)) }}">
                                        {{ ucfirst(str_replace('_', ' ', $abstract->status)) }}
                                    </span>
                                </td>
                                <td>{{ $abstract->created_at->format('M d, Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">No recent abstracts</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-users me-2"></i>Active Reviewers</h5>
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-kalro-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Sub-theme</th>
                                <th>Assigned</th>
                                <th>Completed</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($activeReviewers ?? [] as $reviewer)
                            <tr>
                                <td>{{ $reviewer->name }}</td>
                                <td>{{ $reviewer->subtheme->name ?? 'N/A' }}</td>
                                <td><span class="badge bg-info">{{ $reviewer->assigned_count }}</span></td>
                                <td><span class="badge bg-success">{{ $reviewer->completed_count }}</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">No active reviewers</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Timeline of Activities -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-history me-2"></i>Recent Activity Timeline</h5>
            </div>
            <div class="card-body">
                <div class="activity-timeline">
                    @forelse($recentActivities ?? [] as $activity)
                    <div class="activity-item d-flex mb-3 pb-3 border-bottom">
                        <div class="activity-icon me-3">
                            <i class="fas fa-{{ $activity->icon }} text-{{ $activity->color }}"></i>
                        </div>
                        <div class="activity-content flex-grow-1">
                            <p class="mb-1"><strong>{{ $activity->title }}</strong></p>
                            <p class="text-muted small mb-0">{{ $activity->description }}</p>
                            <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-muted">No recent activities</p>
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
    // Subtheme Chart
    const subthemeCtx = document.getElementById('subthemeChart');
    if (subthemeCtx) {
        new Chart(subthemeCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartData['subthemes'] ?? ['Theme 1', 'Theme 2', 'Theme 3', 'Theme 4', 'Theme 5']) !!},
                datasets: [{
                    label: 'Submissions',
                    data: {!! json_encode($chartData['submissions'] ?? [12, 19, 8, 15, 10]) !!},
                    backgroundColor: 'rgba(45, 138, 62, 0.8)',
                    borderColor: 'rgba(45, 138, 62, 1)',
                    borderWidth: 1
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
                            stepSize: 1
                        }
                    }
                }
            }
        });
    }

    // Status Pie Chart
    const statusCtx = document.getElementById('statusChart');
    if (statusCtx) {
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Under Review', 'Approved', 'Rejected'],
                datasets: [{
                    data: [
                        {{ $stats['pending_abstracts'] ?? 0 }},
                        {{ $stats['under_review'] ?? 0 }},
                        {{ $stats['approved_abstracts'] ?? 0 }},
                        {{ $stats['rejected_abstracts'] ?? 0 }}
                    ],
                    backgroundColor: [
                        '#ffc107',
                        '#17a2b8',
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
                        position: 'bottom'
                    }
                }
            }
        });
    }
</script>
@endsection