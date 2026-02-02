<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KALRO Conference - Executive Dashboard</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        :root {
            --kalro-primary: #004d00;
            --kalro-secondary: #008000;
            --kalro-accent: #2e7d32;
            --kalro-light: #f8f9fa;
            --kalro-card-bg: #ffffff;
            --kalro-approved: #28a745;
            --kalro-disapproved: #dc3545;
            --kalro-pending: #ffc107;
            --kalro-review: #17a2b8;
            --kalro-revision: #fd7e14;
        }
        
        body {
            background: linear-gradient(135deg, #f4f6f9 0%, #e9ecef 100%);
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
        }
        
        .navbar {
            background: linear-gradient(90deg, var(--kalro-primary) 0%, #003300 100%);
            color: white;
            padding: 1rem 2rem;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1030;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .sidebar {
            background: var(--kalro-primary);
            position: fixed;
            top: 70px;
            left: 0;
            width: 250px;
            height: calc(100vh - 70px);
            padding-top: 2rem;
            transition: all 0.3s ease;
            overflow-y: auto;
        }
        
        .sidebar a {
            color: rgba(255, 255, 255, 0.9);
            padding: 0.875rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            transition: all 0.2s ease;
            border-left: 4px solid transparent;
        }
        
        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-left-color: var(--kalro-accent);
        }
        
        .sidebar a.active {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border-left-color: white;
        }
        
        .main {
            margin-left: 270px;
            margin-top: 90px;
            padding: 2rem;
            transition: all 0.3s ease;
        }
        
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .main {
                margin-left: 0;
            }
            .sidebar.active {
                transform: translateX(0);
            }
        }
        
        .metric-card {
            background: var(--kalro-card-bg);
            border: none;
            border-left: 5px solid var(--kalro-primary);
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 77, 0, 0.08);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
        }
        
        .metric-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0, 77, 0, 0.15);
        }
        
        .metric-card .card-body {
            padding: 1.5rem;
        }
        
        .metric-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }
        
        .metric-icon.total { background: linear-gradient(135deg, var(--kalro-primary), var(--kalro-accent)); }
        .metric-icon.approved { background: linear-gradient(135deg, var(--kalro-approved), #4caf50); }
        .metric-icon.disapproved { background: linear-gradient(135deg, var(--kalro-disapproved), #f44336); }
        .metric-icon.pending { background: linear-gradient(135deg, var(--kalro-pending), #ff9800); }
        .metric-icon.review { background: linear-gradient(135deg, var(--kalro-review), #00bcd4); }
        .metric-icon.revision { background: linear-gradient(135deg, var(--kalro-revision), #ff5722); }
        
        .chart-container {
            background: var(--kalro-card-bg);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 20px rgba(0, 77, 0, 0.08);
            height: 100%;
            transition: all 0.3s ease;
        }
        
        .chart-container:hover {
            box-shadow: 0 8px 30px rgba(0, 77, 0, 0.12);
        }
        
        .chart-title {
            color: var(--kalro-primary);
            font-weight: 600;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid rgba(0, 77, 0, 0.1);
        }
        
        .btn-logout {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: white;
            transition: all 0.2s ease;
        }
        
        .btn-logout:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-1px);
        }
        
        .welcome-text {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
        }
        
        .page-title {
            color: var(--kalro-primary);
            font-weight: 700;
            margin-bottom: 2rem;
            position: relative;
            padding-bottom: 0.75rem;
        }
        
        .page-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 4px;
            background: var(--kalro-accent);
            border-radius: 2px;
        }
        
        .recent-submissions {
            background: var(--kalro-card-bg);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 20px rgba(0, 77, 0, 0.08);
        }
        
        .recent-submissions .list-group-item {
            border: none;
            border-left: 4px solid transparent;
            padding: 1rem;
            margin-bottom: 0.5rem;
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        
        .recent-submissions .list-group-item:hover {
            background: rgba(0, 77, 0, 0.05);
            transform: translateX(5px);
        }
        
        .recent-submissions .list-group-item.approved { border-left-color: var(--kalro-approved); }
        .recent-submissions .list-group-item.disapproved { border-left-color: var(--kalro-disapproved); }
        .recent-submissions .list-group-item.submitted { border-left-color: var(--kalro-pending); }
        .recent-submissions .list-group-item.under-review { border-left-color: var(--kalro-review); }
        .recent-submissions .list-group-item.revision-requested { border-left-color: var(--kalro-revision); }
        
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .status-approved { background: rgba(40, 167, 69, 0.1); color: var(--kalro-approved); }
        .status-disapproved { background: rgba(220, 53, 69, 0.1); color: var(--kalro-disapproved); }
        .status-pending { background: rgba(255, 193, 7, 0.1); color: var(--kalro-pending); }
        .status-review { background: rgba(23, 162, 184, 0.1); color: var(--kalro-review); }
        .status-revision { background: rgba(253, 126, 20, 0.1); color: var(--kalro-revision); }
    </style>
</head>
<body>

<!-- NAVIGATION -->
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <h5 class="mb-0 fw-semibold">
            <i class="fas fa-chart-line me-2"></i>
            1st KALRO Conference & Exhibition – Executive Dashboard
        </h5>
        <div class="d-flex align-items-center">
            <span class="welcome-text me-3">
                <i class="fas fa-user-circle me-2"></i>
                Welcome, <?= htmlspecialchars($_SESSION['name'] ?? 'Administrator') ?>
            </span>
            <button class="btn btn-logout" onclick="confirmLogout()">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </button>
        </div>
    </div>
</nav>

<!-- SIDEBAR -->
<aside class="sidebar">
    <a href="#" class="active">
        <i class="fas fa-chart-line"></i>
        <span>Dashboard Overview</span>
    </a>
    <a href="#">
        <i class="fas fa-file-alt"></i>
        <span>Abstracts (<?= number_format($metrics['totalSubmissions']) ?>)</span>
    </a>
    <a href="#">
        <i class="fas fa-users"></i>
        <span>Authors (<?= number_format($metrics['totalAuthors']) ?>)</span>
    </a>
    <a href="#">
        <i class="fas fa-building"></i>
        <span>Institutions</span>
    </a>
    <a href="#">
        <i class="fas fa-tasks"></i>
        <span>Review Queue (<?= number_format($metrics['pendingCount'] + $metrics['reviewCount'] + $metrics['revisionCount']) ?>)</span>
    </a>
    <a href="#">
        <i class="fas fa-cog"></i>
        <span>Settings</span>
    </a>
</aside>

<!-- MAIN CONTENT -->
<main class="main">
    <h1 class="page-title">Conference Intelligence Overview</h1>
    
    <!-- METRICS SECTION -->
    <div class="row g-4 mb-5">
        @php
            $cards = [
                ["Total Submissions", $metrics['totalSubmissions'], "fa-file-alt", "total"],
                ["Total Authors", $metrics['totalAuthors'], "fa-users", "total"],
                ["Approved Abstracts", $metrics['approvedCount'], "fa-check-circle", "approved"],
                ["Disapproved Abstracts", $metrics['disapprovedCount'], "fa-times-circle", "disapproved"],
                ["Pending Review", $metrics['pendingCount'], "fa-clock", "pending"],
                ["Under Review", $metrics['reviewCount'], "fa-search", "review"],
                ["Revision Requested", $metrics['revisionCount'], "fa-redo", "revision"],
                ["Oral Presentations", $metrics['oralCount'], "fa-microphone", "total"],
                ["Poster Presentations", $metrics['posterCount'], "fa-image", "total"]
            ];
        @endphp

        @foreach($cards as $card)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="metric-card">
                    <div class="card-body text-center">
                        <div class="metric-icon {{ $card[3] }}">
                            <i class="fas {{ $card[2] }} fa-2x text-white"></i>
                        </div>
                        <h6 class="text-muted mb-2 fw-semibold">{{ $card[0] }}</h6>
                        <h2 class="fw-bold mb-0" style="color: var(--kalro-{{ $card[3] }})">
                            {{ number_format($card[1]) }}
                        </h2>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    
    <!-- CHARTS ROW 1 -->
    <div class="row g-4 mb-4">
        <div class="col-xl-6 col-lg-6">
            <div class="chart-container">
                <h5 class="chart-title">Submission Status Distribution</h5>
                <canvas id="statusChart" height="300"></canvas>
            </div>
        </div>
        
        <div class="col-xl-3 col-lg-3">
            <div class="chart-container">
                <h5 class="chart-title">Presentation Type</h5>
                <canvas id="presentationChart" height="300"></canvas>
            </div>
        </div>
        
        <div class="col-xl-3 col-lg-3">
            <div class="chart-container">
                <h5 class="chart-title">Attendance Mode</h5>
                <canvas id="attendanceChart" height="300"></canvas>
            </div>
        </div>
    </div>
    
    <!-- CHARTS ROW 2 -->
    <div class="row g-4 mb-4">
        <div class="col-xl-6 col-lg-6">
            <div class="chart-container">
                <h5 class="chart-title">Submissions by Sub-Theme</h5>
                <canvas id="subThemeChart" height="300"></canvas>
            </div>
        </div>
        
        <div class="col-xl-6 col-lg-6">
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="chart-container">
                        <h5 class="chart-title">Submissions Timeline</h5>
                        <canvas id="timelineChart" height="200"></canvas>
                    </div>
                </div>
                <div class="col-12">
                    <div class="chart-container">
                        <h5 class="chart-title">Submission Types</h5>
                        <canvas id="submissionTypeChart" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- RECENT SUBMISSIONS & TOP INSTITUTIONS -->
    <div class="row g-4">
        <div class="col-xl-6 col-lg-6">
            <div class="recent-submissions">
                <h5 class="chart-title">Recent Submissions</h5>
                <div class="list-group">
                    @foreach($recentSubmissionsData as $submission)
                        @php
                            $statusClass = strtolower(str_replace(' ', '-', $submission['status']));
                        @endphp
                        <div class="list-group-item {{ $statusClass }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">{{ $submission['paper_title'] }}</h6>
                                    <small class="text-muted">
                                        {{ $submission['submission_code'] }} • {{ \Carbon\Carbon::parse($submission['created_at'])->format('M d, Y') }}
                                    </small>
                                </div>
                                <span class="status-badge status-{{ $statusClass }}">
                                    {{ $submission['status'] }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-lg-6">
            <div class="chart-container">
                <h5 class="chart-title">Top Institutions</h5>
                <canvas id="institutionsChart" height="300"></canvas>
            </div>
        </div>
    </div>
 
    <!-- BOTTOM CHART -->
    <div class="row g-4 mt-4">
        <div class="col-12">
            <div class="chart-container">
                <h5 class="chart-title">Top Submissions by Author Count</h5>
                <canvas id="authorsChart" height="300"></canvas>
            </div>
        </div>
    </div>
</main>

<script>
const metrics = @json($metrics);
const chartData = @json($chartData);

// Status-based colors
const statusColors = {
    'Approved': '#28a745',
    'Disapproved': '#dc3545',
    'Submitted': '#ffc107',
    'Under Review': '#17a2b8',
    'Revision Requested': '#fd7e14'
};

const chartColors = [
    '#004d00', '#008000', '#2e7d32', '#43a047', '#66bb6a',
    '#81c784', '#a5d6a7', '#9ccc65', '#aed581', '#c5e1a5',
    '#dcedc8', '#388e3c', '#1b5e20', '#33691e', '#558b2f'
];

function getGradientColors(ctx, baseColor) {
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, baseColor);
    gradient.addColorStop(1, baseColor.replace(')', ', 0.7)').replace('rgb', 'rgba'));
    return gradient;
}

// Welcome notification
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        title: '<span style="color:#004d00">Welcome to KALRO Dashboard</span>',
        html: `<div class="text-start">
            <p class="mb-2">📊 <strong>Conference Intelligence Platform</strong></p>
            <p class="small mb-0">Currently tracking ${metrics.totalSubmissions} submissions with ${metrics.totalAuthors} authors.</p>
        </div>`,
        icon: 'success',
        confirmButtonColor: '#004d00',
        confirmButtonText: 'View Dashboard',
        background: '#f8f9fa',
        timer: 3000,
        timerProgressBar: true
    });
});

// Example: Status chart
const statusLabels = chartData.status.map(item => item.status);
const statusValues = chartData.status.map(item => item.t);
const statusBackgrounds = chartData.status.map(item => statusColors[item.status] || '#cccccc');

new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
        labels: statusLabels,
        datasets: [{
            data: statusValues,
            backgroundColor: statusBackgrounds,
            borderWidth: 2,
            borderColor: '#ffffff'
        }]
    },
    options: {
        responsive: true,
        cutout: '60%',
        plugins: {
            legend: { position: 'right', labels: { padding: 15, usePointStyle: true, font: { size: 12 } } },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        const value = context.raw;
                        const percentage = ((value / metrics.totalSubmissions) * 100).toFixed(1);
                        return `${context.label}: ${value} (${percentage}%)`;
                    }
                }
            }
        }
    }
});
</script>


</body>
</html>