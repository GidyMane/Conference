<?php
session_start();

/* ================= DB CONNECTION ================= */
$conn = mysqli_connect(
    "localhost",
    "nrfvqate_conf26mkurugenzi",
    "lZe=(,.ag+4KrI{weH",
    "nrfvqate_conf26"
) or die(json_encode(['error' => 'Database connection failed']));

/* ================= METRICS ================= */
$queries = [
    'totalSubmissions' => "SELECT COUNT(*) as t FROM abstract_submissions",
    'totalAuthors' => "SELECT COUNT(*) as t FROM abstract_authors",
    'oralCount' => "SELECT COUNT(*) as t FROM abstract_submissions WHERE presentation_preference='oral'",
    'posterCount' => "SELECT COUNT(*) as t FROM abstract_submissions WHERE presentation_preference='poster'",
    'approvedCount' => "SELECT COUNT(*) as t FROM abstract_submissions WHERE status='Approved'",
    'disapprovedCount' => "SELECT COUNT(*) as t FROM abstract_submissions WHERE status='Disapproved'",
    'pendingCount' => "SELECT COUNT(*) as t FROM abstract_submissions WHERE status='Submitted'",
    'reviewCount' => "SELECT COUNT(*) as t FROM abstract_submissions WHERE status='Under Review'",
    'revisionCount' => "SELECT COUNT(*) as t FROM abstract_submissions WHERE status='Revision Requested'"
];

$metrics = [];
foreach ($queries as $key => $sql) {
    $result = mysqli_query($conn, $sql);
    $metrics[$key] = mysqli_fetch_assoc($result)['t'] ?? 0;
}

// Calculate submission types
$submissionTypes = mysqli_query($conn, "SELECT submission_type, COUNT(*) as t FROM abstract_submissions GROUP BY submission_type");
$submissionTypeData = mysqli_fetch_all($submissionTypes, MYSQLI_ASSOC);

/* ================= CHART DATA ================= */
$chartData = [];
$chartQueries = [
    'subTheme' => "SELECT sub_theme, COUNT(*) as t FROM abstract_submissions WHERE sub_theme IS NOT NULL AND sub_theme != '' GROUP BY sub_theme",
    'presentation' => "SELECT presentation_preference, COUNT(*) as t FROM abstract_submissions WHERE presentation_preference IS NOT NULL AND presentation_preference != '' GROUP BY presentation_preference",
    'attendance' => "SELECT attendance_mode, COUNT(*) as t FROM abstract_submissions WHERE attendance_mode IS NOT NULL AND attendance_mode != '' GROUP BY attendance_mode",
    'authors' => "SELECT submission_id, COUNT(*) as t FROM abstract_authors GROUP BY submission_id ORDER BY t DESC LIMIT 10",
    'dates' => "SELECT DATE(created_at) as d, COUNT(*) as t FROM abstract_submissions GROUP BY DATE(created_at) ORDER BY d ASC",
    'institutions' => "SELECT organization, COUNT(*) as t FROM abstract_submissions WHERE organization IS NOT NULL AND organization != '' GROUP BY organization ORDER BY t DESC LIMIT 15",
    'submissionTypes' => "SELECT submission_type, COUNT(*) as t FROM abstract_submissions WHERE submission_type IS NOT NULL AND submission_type != '' GROUP BY submission_type",
    'status' => "SELECT status, COUNT(*) as t FROM abstract_submissions GROUP BY status"
];

foreach ($chartQueries as $key => $sql) {
    $result = mysqli_query($conn, $sql);
    $chartData[$key] = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_data_seek($result, 0);
}

// Get recent submissions for timeline
$recentSubmissions = mysqli_query($conn, 
    "SELECT id, submission_code, paper_title, status, created_at 
     FROM abstract_submissions 
     ORDER BY created_at DESC LIMIT 5"
);
$recentSubmissionsData = mysqli_fetch_all($recentSubmissions, MYSQLI_ASSOC);
?>
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
        <?php
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
        
        foreach($cards as $card): ?>
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="metric-card">
                <div class="card-body text-center">
                    <div class="metric-icon <?= $card[3] ?>">
                        <i class="fas <?= $card[2] ?> fa-2x text-white"></i>
                    </div>
                    <h6 class="text-muted mb-2 fw-semibold"><?= $card[0] ?></h6>
                    <h2 class="fw-bold mb-0" style="color: var(--kalro-<?= $card[3] ?>)">
                        <?= number_format($card[1]) ?>
                    </h2>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
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
                    <?php foreach($recentSubmissionsData as $submission): 
                        $statusClass = strtolower(str_replace(' ', '-', $submission['status']));
                    ?>
                    <div class="list-group-item <?= $statusClass ?>">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1"><?= htmlspecialchars($submission['paper_title']) ?></h6>
                                <small class="text-muted"><?= htmlspecialchars($submission['submission_code']) ?> • <?= date('M d, Y', strtotime($submission['created_at'])) ?></small>
                            </div>
                            <span class="status-badge status-<?= $statusClass ?>">
                                <?= $submission['status'] ?>
                            </span>
                        </div>
                    </div>
                    <?php endforeach; ?>
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
// Status-based colors
const statusColors = {
    'Approved': '#28a745',
    'Disapproved': '#dc3545',
    'Submitted': '#ffc107',
    'Under Review': '#17a2b8',
    'Revision Requested': '#fd7e14'
};

// Chart color palette with multiple colors
const chartColors = [
    '#004d00', '#008000', '#2e7d32', '#43a047', '#66bb6a',
    '#81c784', '#a5d6a7', '#9ccc65', '#aed581', '#c5e1a5',
    '#dcedc8', '#388e3c', '#1b5e20', '#33691e', '#558b2f'
];

// Enhanced gradient colors for bar charts
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
        html: '<div class="text-start"><p class="mb-2">📊 <strong>Conference Intelligence Platform</strong></p>' +
              '<p class="small mb-0">Currently tracking ' + <?= $metrics['totalSubmissions'] ?> + ' submissions with ' + <?= $metrics['totalAuthors'] ?> + ' authors.</p></div>',
        icon: 'success',
        confirmButtonColor: '#004d00',
        confirmButtonText: 'View Dashboard',
        background: '#f8f9fa',
        timer: 3000,
        timerProgressBar: true
    });
});

// Logout confirmation with SweetAlert
function confirmLogout() {
    Swal.fire({
        title: 'Ready to leave?',
        html: '<div class="text-center"><i class="fas fa-sign-out-alt fa-3x mb-3" style="color:#004d00"></i>' +
              '<p>Are you sure you want to log out?</p></div>',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#004d00',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-sign-out-alt me-2"></i>Logout',
        cancelButtonText: 'Cancel',
        background: '#f8f9fa',
        reverseButtons: true,
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-secondary'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'logout.php';
        }
    });
}

// Initialize Charts
document.addEventListener('DOMContentLoaded', function() {
    // Status Distribution Chart
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: [<?= implode(',', array_map(function($item) {
                return "'" . addslashes($item['status']) . "'";
            }, $chartData['status'])) ?>],
            datasets: [{
                data: [<?= implode(',', array_column($chartData['status'], 't')) ?>],
                backgroundColor: [<?= implode(',', array_map(function($item) {
                    return "'" . statusColors[$item['status']] . "'";
                }, $chartData['status'])) ?>],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            cutout: '60%',
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        padding: 15,
                        usePointStyle: true,
                        font: { size: 12 }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const total = <?= $metrics['totalSubmissions'] ?>;
                            const value = context.raw;
                            const percentage = ((value / total) * 100).toFixed(1);
                            return `${context.label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });

    // Sub-theme Chart
    new Chart(document.getElementById('subThemeChart'), {
        type: 'bar',
        data: {
            labels: [<?= count($chartData['subTheme']) > 0 ? implode(',', array_map(function($item) {
                return "'" . addslashes($item['sub_theme']) . "'";
            }, $chartData['subTheme'])) : "'No Data'" ?>],
            datasets: [{
                label: 'Submissions',
                data: [<?= count($chartData['subTheme']) > 0 ? implode(',', array_column($chartData['subTheme'], 't')) : '0' ?>],
                backgroundColor: chartColors.slice(0, <?= count($chartData['subTheme']) ?>),
                borderColor: chartColors.slice(0, <?= count($chartData['subTheme']) ?>),
                borderWidth: 1,
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleFont: { size: 14 },
                    bodyFont: { size: 13 }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.05)' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });

    // Presentation Type Chart
    new Chart(document.getElementById('presentationChart'), {
        type: 'pie',
        data: {
            labels: [<?= count($chartData['presentation']) > 0 ? implode(',', array_map(function($item) {
                return "'" . addslashes($item['presentation_preference']) . "'";
            }, $chartData['presentation'])) : "'No Data'" ?>],
            datasets: [{
                data: [<?= count($chartData['presentation']) > 0 ? implode(',', array_column($chartData['presentation'], 't')) : '0' ?>],
                backgroundColor: chartColors.slice(0, <?= count($chartData['presentation']) ?>),
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        font: { size: 12 }
                    }
                }
            }
        }
    });

    // Attendance Mode Chart
    new Chart(document.getElementById('attendanceChart'), {
        type: 'doughnut',
        data: {
            labels: [<?= count($chartData['attendance']) > 0 ? implode(',', array_map(function($item) {
                return "'" . addslashes($item['attendance_mode']) . "'";
            }, $chartData['attendance'])) : "'No Data'" ?>],
            datasets: [{
                data: [<?= count($chartData['attendance']) > 0 ? implode(',', array_column($chartData['attendance'], 't')) : '0' ?>],
                backgroundColor: chartColors.slice(0, <?= count($chartData['attendance']) ?>),
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            cutout: '65%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        usePointStyle: true,
                        font: { size: 12 }
                    }
                }
            }
        }
    });

    // Timeline Chart
    const timelineCtx = document.getElementById('timelineChart').getContext('2d');
    new Chart(timelineCtx, {
        type: 'line',
        data: {
            labels: [<?= count($chartData['dates']) > 0 ? implode(',', array_map(function($item) {
                return "'" . date('M d', strtotime($item['d'])) . "'";
            }, $chartData['dates'])) : "'No Data'" ?>],
            datasets: [{
                label: 'Daily Submissions',
                data: [<?= count($chartData['dates']) > 0 ? implode(',', array_column($chartData['dates'], 't')) : '0' ?>],
                borderColor: '#004d00',
                backgroundColor: getGradientColors(timelineCtx, 'rgb(0, 77, 0)'),
                tension: 0.3,
                fill: true,
                borderWidth: 3
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.05)' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });

    // Submission Type Chart
    new Chart(document.getElementById('submissionTypeChart'), {
        type: 'bar',
        data: {
            labels: [<?= count($chartData['submissionTypes']) > 0 ? implode(',', array_map(function($item) {
                return "'" . addslashes($item['submission_type']) . "'";
            }, $chartData['submissionTypes'])) : "'No Data'" ?>],
            datasets: [{
                label: 'Submissions',
                data: [<?= count($chartData['submissionTypes']) > 0 ? implode(',', array_column($chartData['submissionTypes'], 't')) : '0' ?>],
                backgroundColor: chartColors.slice(0, <?= count($chartData['submissionTypes']) ?>),
                borderColor: chartColors.slice(0, <?= count($chartData['submissionTypes']) ?>),
                borderWidth: 1,
                borderRadius: 8,
            }]
        },
        options: {
            responsive: true,
            indexAxis: 'y',
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.05)' }
                },
                y: {
                    grid: { display: false }
                }
            }
        }
    });

    // Institutions Chart
    new Chart(document.getElementById('institutionsChart'), {
        type: 'horizontalBar',
        data: {
            labels: [<?= count($chartData['institutions']) > 0 ? implode(',', array_map(function($item) {
                return "'" . addslashes(substr($item['organization'], 0, 30)) . "'";
            }, $chartData['institutions'])) : "'No Data'" ?>],
            datasets: [{
                label: 'Submissions',
                data: [<?= count($chartData['institutions']) > 0 ? implode(',', array_column($chartData['institutions'], 't')) : '0' ?>],
                backgroundColor: chartColors.slice(0, <?= count($chartData['institutions']) ?>),
                borderColor: chartColors.slice(0, <?= count($chartData['institutions']) ?>),
                borderWidth: 1,
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            indexAxis: 'y',
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.05)' }
                },
                y: {
                    grid: { display: false }
                }
            }
        }
    });

    // Authors Chart
    new Chart(document.getElementById('authorsChart'), {
        type: 'bar',
        data: {
            labels: [<?= count($chartData['authors']) > 0 ? implode(',', array_map(function($item) {
                return "'Submission #" . $item['submission_id'] . "'";
            }, $chartData['authors'])) : "'No Data'" ?>],
            datasets: [{
                label: 'Number of Authors',
                data: [<?= count($chartData['authors']) > 0 ? implode(',', array_column($chartData['authors'], 't')) : '0' ?>],
                backgroundColor: chartColors.slice(0, <?= count($chartData['authors']) ?>),
                borderColor: chartColors.slice(0, <?= count($chartData['authors']) ?>),
                borderWidth: 1,
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.05)' },
                    ticks: {
                        stepSize: 1
                    }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
});
</script>

</body>
</html>