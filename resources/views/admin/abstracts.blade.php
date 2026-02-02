!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>KALRO Conference – Abstracts</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">

<style>
        :root {
            --kalro-primary:#004d00;
            --kalro-accent:#2e7d32;
            --kalro-approved:#28a745;
            --kalro-disapproved:#dc3545;
            --kalro-pending:#ffc107;
            --kalro-review:#17a2b8;
            --kalro-revision:#fd7e14;
        }

        body{
            background:#f4f6f9;
            font-family:Segoe UI,system-ui;
        }

        .navbar{
            background:linear-gradient(90deg,var(--kalro-primary),#003300);
            color:#fff;
            padding:1rem 2rem;
            position:fixed;
            top:0;width:100%;z-index:1030;
            height:70px;
            border-bottom: none !important;
        }

        .sidebar{
            background:var(--kalro-primary);
            position:fixed;
            top:70px !important;
            left:0;
            width:250px;height:calc(100vh - 70px);
            padding-top:2rem;
            margin-top:0 !important;
        }

        .sidebar a{
            color:#fff;
            padding:.9rem 1.5rem;
            display:flex;
            gap:.75rem;
            text-decoration:none;
        }
        .sidebar a.active,
        .sidebar a:hover{
            background:rgba(255,255,255,.15);
        }

        .main{
            margin-left:270px;
            margin-top:90px;
            padding:2rem;
        }

        .page-title{
            color:var(--kalro-primary);
            font-weight:700;
            margin-bottom:1.5rem;
        }

        .filter-card {
            background: #fff;
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 20px rgba(0,77,0,.08);
        }

        .filter-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .filter-title {
            color: var(--kalro-primary);
            font-weight: 600;
            font-size: 1.1rem;
            margin: 0;
        }

        .filter-stats {
            font-size: 0.9rem;
            color: #666;
        }

        .filter-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .form-group {
            margin-bottom: 0;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #333;
            font-size: 0.9rem;
        }

        .form-control {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 0.5rem 0.75rem;
            width: 100%;
        }

        .form-control:focus {
            border-color: var(--kalro-accent);
            box-shadow: 0 0 0 0.2rem rgba(46, 125, 50, 0.25);
        }

        .filter-actions {
            display: flex;
            gap: 0.5rem;
            justify-content: flex-end;
            padding-top: 0.5rem;
            border-top: 1px solid #eee;
        }

        .btn-filter {
            background: var(--kalro-primary);
            color: white;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
        }

        .btn-reset {
            background: #6c757d;
            color: white;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
        }

        .btn-filter:hover {
            background: #003300;
        }

        .btn-reset:hover {
            background: #545b62;
        }

        .table-card{
            background:#fff;
            border-radius:16px;
            padding:1.5rem;
            box-shadow:0 4px 20px rgba(0,77,0,.08);
        }

        .status{
            padding:.25rem .75rem;
            border-radius:20px;
            font-size:.75rem;
            font-weight:600;
            text-transform:uppercase;
        }
        .submitted{background:rgba(255,193,7,.1);color:var(--kalro-pending);}
        .under-review{background:rgba(23,162,184,.1);color:var(--kalro-review);}
        .approved{background:rgba(40,167,69,.1);color:var(--kalro-approved);}
        .disapproved{background:rgba(220,53,69,.1);color:var(--kalro-disapproved);}
        .revision-requested{background:rgba(253,126,20,.1);color:var(--kalro-revision);}

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #666;
        }

        .empty-state i {
            font-size: 3rem;
            color: #dee2e6;
            margin-bottom: 1rem;
        }

        .date-range-group {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .date-range-separator {
            color: #666;
            font-weight: bold;
            padding-top: 1.5rem;
        }

        .btn-view {
            background: var(--kalro-primary);
            color: white;
            border: none;
            padding: 0.25rem 0.75rem;
            border-radius: 4px;
            font-size: 0.85rem;
        }

        .btn-view:hover {
            background: #003300;
            color: white;
        }

        /* Modal Styles */
        .modal-header {
            background: linear-gradient(90deg, var(--kalro-primary), #003300);
            color: white;
            border-bottom: none;
        }

        .modal-title {
            font-weight: 600;
        }

        .abstract-content {
            max-height: 400px;
            overflow-y: auto;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #dee2e6;
            margin-bottom: 1.5rem;
        }

        .comment-section {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 2px solid #eee;
        }

        .comments-list {
            max-height: 300px;
            overflow-y: auto;
            margin-bottom: 1.5rem;
        }

        .comment-item {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
            border-left: 4px solid var(--kalro-accent);
        }

        .comment-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .comment-author {
            font-weight: 600;
            color: var(--kalro-primary);
        }

        .comment-date {
            font-size: 0.85rem;
            color: #666;
        }

        .comment-text {
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        .status-select {
            border: 2px solid var(--kalro-accent);
            font-weight: 500;
        }

        .reviewer-info {
            font-size: 0.9rem;
            color: #666;
            margin-top: 0.5rem;
        }

        .keywords-badge {
            background: #e9ecef;
            color: #495057;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            margin-right: 0.25rem;
            font-size: 0.85rem;
        }

        .submission-meta {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .submission-meta p {
            margin-bottom: 0.5rem;
        }

        @media (max-width: 768px) {
            .main {
                margin-left: 0;
                margin-top: 70px;
                padding: 1rem;
            }
            
            .sidebar {
                display: none;
            }
            
            .filter-row {
                grid-template-columns: 1fr;
            }
            
            .date-range-group {
                flex-direction: column;
            }
            
            .date-range-separator {
                padding-top: 0;
                padding-bottom: 1.5rem;
            }
        }
</style>
</head>

<body>

<!-- NAV -->
<nav class="navbar">
    <h5 class="mb-0">
        <i class="fas fa-file-alt me-2"></i> Abstract Submissions
    </h5>
</nav>

<!-- SIDEBAR -->
<aside class="sidebar">
    <a href="dashboard.php"><i class="fas fa-chart-line"></i> Dashboard</a>
    <a href="abstracts.php" class="active"><i class="fas fa-file-alt"></i> Abstracts</a>
</aside>

<!-- MAIN -->
<main class="main">
<h1 class="page-title">Submitted Abstracts</h1>

<!-- Filter Card -->
<div class="filter-card">
    <div class="filter-header">
        <h2 class="filter-title"><i class="fas fa-filter me-2"></i>Filter Abstracts</h2>
        <div class="filter-stats">
            Showing ### abstracts
        </div>
    </div>
    
    <form method="GET" action="">
        <div class="filter-row">
            <div class="form-group">
                <label for="sub_theme"><i class="fas fa-tag me-1"></i> Sub-Theme</label>
                <select name="sub_theme" id="sub_theme" class="form-control">
                    <option value="">All Sub-Themes</option>

                </select>
            </div>
            
            <div class="form-group">
                <label for="status"><i class="fas fa-circle me-1"></i> Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="">All Statuses</option>

                </select>
            </div>
            
            <div class="form-group">
                <label for="date_from"><i class="fas fa-calendar-alt me-1"></i> Date Range</label>
                <div class="date-range-group">
                    <input type="text" name="date_from" id="date_from" 
                           class="form-control date-picker" 
                           placeholder="From Date" 
                           value="">
                    <span class="date-range-separator">to</span>
                    <input type="text" name="date_to" id="date_to" 
                           class="form-control date-picker" 
                           placeholder="To Date" 
                           value="">
                </div>
            </div>
        </div>
        
        <div class="filter-actions">
            <button type="submit" class="btn btn-filter">
                <i class="fas fa-search me-1"></i> Apply Filters
            </button>
            <a href="abstracts.php" class="btn btn-reset">
                <i class="fas fa-times me-1"></i> Clear All
            </a>
        </div>
    </form>
</div>

    <div class="table-card table-responsive">
        {{--@if($abstracts->count() > 0)--}}
            <table class="table table-hover align-middle">
                <thead class="table-success">
                    <tr>
                        <th>#</th>
                        <th>Code</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Institution</th>
                        <th>Theme</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    {{--@foreach($abstracts as $i => $r)
                        @php
                            $cls = strtolower(str_replace(' ', '-', $r->status));
                            $last_reviewed = $r->reviewed_at ? $r->reviewed_at->format('d M Y') : 'Not reviewed';
                        @endphp--}}
                        <tr>
                            <td>123</td>
                            <td>123</td>
                            <td>123</td>
                            <td>123</td>
                            <td>123</td>
                            <td>123</td>
                            <td><span class="status">123</span></td>
                            <td>123</td>
                            <td>
                                <button class="btn btn-view btn-sm view-abstract" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#abstractModal"
                                        data-id="123"
                                        data-code="123"
                                        data-title="123"
                                        data-author="123"
                                        data-email="123"
                                        data-phone="123"
                                        data-org="123"
                                        data-dept="123"
                                        data-position="123"
                                        data-theme="123"
                                        data-status="123"
                                        data-created="123"
                                        data-reviewed-by="123"
                                        data-reviewed-at="123"
                                        data-abstract="123"
                                        data-keywords="123"
                                        data-presentation="123"
                                        data-attendance="123"
                                        data-notes="123">
                                    <i class="fas fa-eye me-1"></i> View
                                </button>
                            </td>
                        </tr>
                    {{--@endforeach--}}
                </tbody>
            </table>
        {{--@else--}}
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h3>No abstracts found</h3>
                <p>Try adjusting your filters or clear them to see all abstracts.</p>
            </div>
        {{--@endif--}}
    </div>

</main>

<!-- Abstract View Modal -->
<div class="modal fade" id="abstractModal" tabindex="-1" aria-labelledby="abstractModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="abstractModalLabel">
                    <i class="fas fa-file-alt me-2"></i>Abstract Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="submission-meta">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-hashtag me-2"></i>Submission Code:</strong> 
                               <span id="modalCode" class="text-primary fw-bold"></span>
                            </p>
                            <p><strong><i class="fas fa-user me-2"></i>Author:</strong> 
                               <span id="modalAuthor"></span>
                            </p>
                            <p><strong><i class="fas fa-envelope me-2"></i>Email:</strong> 
                               <span id="modalEmail"></span>
                            </p>
                            <p><strong><i class="fas fa-phone me-2"></i>Phone:</strong> 
                               <span id="modalPhone"></span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-building me-2"></i>Organization:</strong> 
                               <span id="modalOrg"></span>
                            </p>
                            <p><strong><i class="fas fa-tag me-2"></i>Sub-Theme:</strong> 
                               <span id="modalTheme" class="badge bg-secondary"></span>
                            </p>
                            <p><strong><i class="fas fa-circle me-2"></i>Current Status:</strong> 
                               <span id="modalStatus"></span>
                            </p>
                            <p><strong><i class="fas fa-calendar me-2"></i>Submitted:</strong> 
                               <span id="modalCreated"></span>
                            </p>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-user-check me-2"></i>Last Reviewed By:</strong> 
                               <span id="modalReviewedBy"></span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-calendar-check me-2"></i>Last Review Date:</strong> 
                               <span id="modalReviewedAt"></span>
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <h6 class="text-primary mb-3">
                        <i class="fas fa-heading me-2"></i>Paper Title
                    </h6>
                    <div class="card">
                        <div class="card-body">
                            <h5 id="modalTitle" class="card-title mb-0"></h5>
                        </div>
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-8">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-file-lines me-2"></i>Abstract Content
                        </h6>
                        <div class="abstract-content" id="modalAbstract">
                            <!-- Abstract content will be inserted here -->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-tags me-2"></i>Keywords
                        </h6>
                        <div id="modalKeywords" class="mb-3">
                            <!-- Keywords will be inserted here -->
                        </div>
                        
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-chalkboard me-2"></i>Presentation Details
                        </h6>
                        <div class="card">
                            <div class="card-body">
                                <p><strong>Preference:</strong> <span id="modalPresentation"></span></p>
                                <p><strong>Attendance Mode:</strong> <span id="modalAttendance"></span></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Comments Section -->
                <div class="comment-section" id="commentsSection">
                    <h6 class="text-primary mb-3">
                        <i class="fas fa-comments me-2"></i>Review Comments & Internal Notes
                    </h6>
                    
                    <div class="comments-list" id="commentsList">
                        <!-- Comments will be loaded here -->
                        <div class="text-center text-muted py-3" id="noComments">
                            <i class="fas fa-comment-slash fa-2x mb-2"></i>
                            <p>No comments yet</p>
                        </div>
                    </div>
                    
                    <!-- Add Comment Form -->
                    <form id="commentForm" method="POST">
                        <input type="hidden" name="submission_id" id="commentSubmissionId">
                        <input type="hidden" name="add_comment" value="1">
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="statusSelect" class="form-label">
                                    <i class="fas fa-flag me-1"></i>Update Status
                                </label>
                                <select class="form-select status-select" id="statusSelect" name="status" required>
                                    <option value="">Select new status...</option>
                                    
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="commentText" class="form-label">
                                <i class="fas fa-edit me-1"></i>Add Comment / Note
                            </label>
                            <textarea class="form-control" id="commentText" name="comment" rows="4" 
                                      placeholder="Enter your review comments or internal notes here..." required></textarea>
                            <div class="form-text reviewer-info">
                                Commenting as: <?= htmlspecialchars($_SESSION['name'] ?? 'Reviewer') ?> 
                                (<?= htmlspecialchars($_SESSION['email'] ?? '') ?>)
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i> Close
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-1"></i> Submit Comment & Update Status
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize date pickers
    flatpickr('.date-picker', {
        dateFormat: 'Y-m-d',
        allowInput: true,
        maxDate: 'today'
    });
    
    // Set max date for "from" date when "to" date is selected
    document.getElementById('date_from').addEventListener('change', function(e) {
        const toDate = document.getElementById('date_to');
        if (toDate._flatpickr && e.target.value) {
            toDate._flatpickr.set('minDate', e.target.value);
        }
    });
    
    // Set min date for "to" date when "from" date is selected
    document.getElementById('date_to').addEventListener('change', function(e) {
        const fromDate = document.getElementById('date_from');
        if (fromDate._flatpickr && e.target.value) {
            fromDate._flatpickr.set('maxDate', e.target.value);
        }
    });
    
    // Handle view abstract button clicks
    const viewButtons = document.querySelectorAll('.view-abstract');
    const abstractModal = new bootstrap.Modal(document.getElementById('abstractModal'));
    
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Get all data attributes
            const id = this.getAttribute('data-id');
            const code = this.getAttribute('data-code');
            const title = this.getAttribute('data-title');
            const author = this.getAttribute('data-author');
            const email = this.getAttribute('data-email');
            const phone = this.getAttribute('data-phone');
            const org = this.getAttribute('data-org');
            const dept = this.getAttribute('data-dept');
            const position = this.getAttribute('data-position');
            const theme = this.getAttribute('data-theme');
            const status = this.getAttribute('data-status');
            const created = this.getAttribute('data-created');
            const reviewedBy = this.getAttribute('data-reviewed-by');
            const reviewedAt = this.getAttribute('data-reviewed-at');
            const abstract = this.getAttribute('data-abstract');
            const keywords = this.getAttribute('data-keywords');
            const presentation = this.getAttribute('data-presentation');
            const attendance = this.getAttribute('data-attendance');
            const notes = this.getAttribute('data-notes');
            
            // Update modal content
            document.getElementById('modalCode').textContent = code;
            document.getElementById('modalTitle').textContent = title;
            document.getElementById('modalAuthor').textContent = author;
            document.getElementById('modalEmail').textContent = email;
            document.getElementById('modalPhone').textContent = phone;
            document.getElementById('modalOrg').textContent = org;
            document.getElementById('modalTheme').textContent = theme;
            document.getElementById('modalCreated').textContent = created;
            document.getElementById('modalReviewedBy').textContent = reviewedBy;
            document.getElementById('modalReviewedAt').textContent = reviewedAt;
            document.getElementById('modalAbstract').textContent = abstract;
            document.getElementById('commentSubmissionId').value = id;
            
            // Update status badge
            const statusElement = document.getElementById('modalStatus');
            statusElement.textContent = status;
            statusElement.className = 'status ' + status.toLowerCase().replace(' ', '-');
            
            // Set current status in dropdown
            document.getElementById('statusSelect').value = status;
            
            // Update keywords
            const keywordsContainer = document.getElementById('modalKeywords');
            keywordsContainer.innerHTML = '';
            if (keywords) {
                const keywordList = keywords.split(',').map(k => k.trim()).filter(k => k);
                keywordList.forEach(keyword => {
                    const badge = document.createElement('span');
                    badge.className = 'keywords-badge';
                    badge.textContent = keyword;
                    keywordsContainer.appendChild(badge);
                });
            }
            
            // Update presentation details
            document.getElementById('modalPresentation').textContent = presentation || 'Not specified';
            document.getElementById('modalAttendance').textContent = attendance || 'Not specified';
            
            // Display existing notes/comments
            displayComments(notes);
        });
    });
    
    // Function to display existing comments/notes
    function displayComments(notes) {
        const commentsList = document.getElementById('commentsList');
        const noComments = document.getElementById('noComments');
        
        if (notes && notes.trim()) {
            // Parse the notes (format: [timestamp] reviewer (email): comment)
            const commentEntries = notes.split('\n\n').filter(entry => entry.trim());
            
            let commentsHTML = '';
            commentEntries.forEach(entry => {
                // Split into header and comment
                const lines = entry.split('\n');
                if (lines.length >= 2) {
                    const header = lines[0];
                    const commentText = lines.slice(1).join('\n');
                    
                    // Parse header for timestamp and reviewer
                    const headerMatch = header.match(/^\[(.*?)\] (.*?) \((.*?)\):/);
                    if (headerMatch) {
                        const [, timestamp, reviewer, email] = headerMatch;
                        commentsHTML += `
                            <div class="comment-item">
                                <div class="comment-header">
                                    <span class="comment-author">${reviewer}</span>
                                    <span class="comment-date">${formatDate(timestamp)}</span>
                                </div>
                                <div class="comment-text">${escapeHtml(commentText)}</div>
                                <div class="reviewer-info">${email}</div>
                            </div>
                        `;
                    } else {
                        // Fallback for older format
                        commentsHTML += `
                            <div class="comment-item">
                                <div class="comment-text">${escapeHtml(entry)}</div>
                            </div>
                        `;
                    }
                }
            });
            
            commentsList.innerHTML = commentsHTML;
            noComments.style.display = 'none';
        } else {
            noComments.style.display = 'block';
        }
    }
    
    // Helper function to format date
    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'short',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }
    
    // Helper function to escape HTML
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // Auto-resize textarea
    document.getElementById('commentText').addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
});
</script>
</body>
</html>