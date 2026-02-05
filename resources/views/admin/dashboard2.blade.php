@extends('admin.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

<div class="page-header mb-4">
    <h1>Dashboard Overview</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </nav>
</div>

<!-- ================= STAT CARDS ================= -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="stat-card bg-primary">
            <h3>{{ $metrics['totalSubmissions'] ?? 0 }}</h3>
            <p>Total Abstracts</p>
            <i class="fas fa-file-alt stat-card-icon"></i>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="stat-card bg-warning">
            <h3>{{ $metrics['pendingCount'] ?? 0 }}</h3>
            <p>Pending Review</p>
            <i class="fas fa-clock stat-card-icon"></i>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="stat-card bg-info">
            <h3>{{ $metrics['reviewCount'] ?? 0 }}</h3>
            <p>Under Review</p>
            <i class="fas fa-search stat-card-icon"></i>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="stat-card bg-success">
            <h3>{{ $metrics['approvedCount'] ?? 0 }}</h3>
            <p>Approved</p>
            <i class="fas fa-check-circle stat-card-icon"></i>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="stat-card bg-danger">
            <h3>{{ $metrics['disapprovedCount'] ?? 0 }}</h3>
            <p>Rejected</p>
            <i class="fas fa-times-circle stat-card-icon"></i>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="stat-card bg-secondary">
            <h3>{{ $metrics['fullPaperCount'] ?? 0 }}</h3>
            <p>Full Papers</p>
            <i class="fas fa-file-pdf stat-card-icon"></i>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="stat-card bg-dark">
            <h3>{{ $stats['registrations'] ?? 0 }}</h3>
            <p>Registrations</p>
            <i class="fas fa-users stat-card-icon"></i>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="stat-card" style="background:#6f42c1;">
            <h3>{{ $stats['exhibitions'] ?? 0 }}</h3>
            <p>Exhibitions</p>
            <i class="fas fa-store stat-card-icon"></i>
        </div>
    </div>
</div>

<!-- ================= SUBMISSION BY THEME ================= -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar me-2"></i>
                    Submissions by Sub-theme
                </h5>
            </div>
            <div class="card-body">
                <div style="height: 420px;">
                    <canvas id="subthemeChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ================= STATUS CHART ================= -->
<div class="row mb-4">
    <div class="col-md-6 offset-md-3">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-pie-chart me-2"></i>
                    Abstract Status Distribution
                </h5>
            </div>
            <div class="card-body">
                <canvas id="statusChart" height="260"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- ================= RECENT ABSTRACTS ================= -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-file-alt me-2"></i>
                    Recent Abstract Submissions
                </h5>
                <a href="{{ route('admin.abstracts.index') }}" class="btn btn-sm btn-kalro-primary">
                    View All
                </a>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="thead-light">
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
                                    <td><strong>{{ $abstract->submission_code }}</strong></td>
                                    <td>{{ Str::limit($abstract->paper_title, 80) }}</td>
                                    <td>
                                        <span class="badge badge-{{ strtolower(str_replace('_','-',$abstract->status)) }}">
                                            {{ ucfirst(str_replace('_',' ',$abstract->status)) }}
                                        </span>
                                    </td>
                                    <td>{{ $abstract->created_at->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        No recent abstracts found
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

<!-- ================= ACTIVE REVIEWERS ================= -->
<!-- <div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-users me-2"></i>
                    Active Reviewers
                </h5>
                <a href="/users" class="btn btn-sm btn-kalro-primary">
                    View All
                </a>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="thead-light">
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
                                    <td colspan="4" class="text-center text-muted py-4">
                                        No active reviewers
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div> -->

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
const subthemeCtx = document.getElementById('subthemeChart');

if (subthemeCtx) {
    const fullNames = {!! json_encode($chartData['full_names'] ?? []) !!};

    new Chart(subthemeCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartData['subthemes'] ?? []) !!},
            datasets: [{
                data: {!! json_encode($chartData['submissions'] ?? []) !!},
                backgroundColor: 'rgba(46, 125, 50, 0.85)',
                borderRadius: 8,
                barThickness: 26
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        title: ctx => fullNames[ctx[0].dataIndex] ?? ctx[0].label,
                        label: ctx => `Submissions: ${ctx.raw}`
                    }
                }
            },
            scales: {
                x: { beginAtZero: true },
                y: { ticks: { autoSkip: false } }
            }
        }
    });
}

const statusCtx = document.getElementById('statusChart');
if (statusCtx) {
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Under Review', 'Approved', 'Rejected'],
            datasets: [{
                data: [
                    {{ $metrics['pendingCount'] ?? 0 }},
                    {{ $metrics['reviewCount'] ?? 0 }},
                    {{ $metrics['approvedCount'] ?? 0 }},
                    {{ $metrics['disapprovedCount'] ?? 0 }}
                ],
                backgroundColor: ['#ffc107', '#17a2b8', '#28a745', '#dc3545']
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });
}
</script>
@endsection
