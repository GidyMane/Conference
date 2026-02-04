@extends('reviewer.layout')

@section('title', 'Full Paper Submissions')

@section('content')
<style>
    :root {
        --primary-blue: #1e5a8e;
        --success-green: #28a745;
    }

    .page-header {
        margin-bottom: 30px;
    }

    .page-title {
        font-size: 28px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 10px;
    }

    /* Stats Cards */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
        border-left: 4px solid;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .stat-card.primary {
        border-left-color: var(--primary-blue);
    }

    .stat-card.success {
        border-left-color: var(--success-green);
    }

    .stat-card.warning {
        border-left-color: #ffc107;
    }

    .stat-card-content h6 {
        font-size: 14px;
        color: #6c757d;
        margin-bottom: 5px;
        text-transform: uppercase;
        font-weight: 500;
    }

    .stat-card-content h3 {
        font-size: 32px;
        font-weight: 700;
        margin: 0;
        color: #2c3e50;
    }

    .stat-card-icon {
        font-size: 40px;
        opacity: 0.3;
    }

    .stat-card.primary .stat-card-icon {
        color: var(--primary-blue);
    }

    .stat-card.success .stat-card-icon {
        color: var(--success-green);
    }

    .stat-card.warning .stat-card-icon {
        color: #ffc107;
    }

    /* Table Card */
    .table-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .table thead th {
        background: var(--primary-blue);
        color: white;
        border: none;
        padding: 15px 12px;
        font-weight: 600;
        font-size: 14px;
        text-transform: uppercase;
    }

    .table tbody td {
        padding: 12px;
        vertical-align: middle;
        font-size: 14px;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
    }

    /* Status Badges */
    .status-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        display: inline-block;
    }

    .status-badge.pending {
        background: #fff3cd;
        color: #856404;
    }

    .status-badge.approved {
        background: #d4edda;
        color: #155724;
    }

    /* Document Badge */
    .doc-badge {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 5px;
        font-size: 11px;
        font-weight: 600;
        margin: 2px;
    }

    .doc-badge.paper {
        background: #e7f3ff;
        color: #004085;
    }

    .doc-badge.presentation {
        background: #d4edda;
        color: #155724;
    }

    .doc-badge.supplementary {
        background: #fff3cd;
        color: #856404;
    }

    /* Action Buttons */
    .btn-view {
        background: var(--primary-blue);
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 5px;
        font-size: 13px;
        transition: all 0.3s;
    }

    .btn-view:hover {
        background: #0d3d5c;
        color: white;
    }

    .btn-download {
        background: var(--success-green);
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 5px;
        font-size: 13px;
        transition: all 0.3s;
    }

    .btn-download:hover {
        background: #218838;
        color: white;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 64px;
        margin-bottom: 20px;
        opacity: 0.3;
    }

    .empty-state h3 {
        font-size: 24px;
        margin-bottom: 10px;
        color: #495057;
    }

    /* Modal */
    .modal-header {
        background: linear-gradient(135deg, var(--primary-blue) 0%, #0d3d5c 100%);
        color: white;
    }

    .paper-details {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .paper-details p {
        margin-bottom: 10px;
        line-height: 1.6;
    }

    .documents-section {
        margin-top: 20px;
    }

    .document-item {
        background: white;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .document-item:hover {
        border-color: var(--primary-blue);
        background: #f8f9fa;
    }

    .document-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .document-icon {
        font-size: 32px;
        color: var(--primary-blue);
    }

    .document-meta h6 {
        margin: 0;
        font-weight: 600;
        color: #2c3e50;
    }

    .document-meta p {
        margin: 0;
        font-size: 13px;
        color: #6c757d;
    }
</style>

<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-file-pdf me-2"></i>Full Paper Submissions
    </h1>
    <p class="text-muted">Full papers submitted for abstracts you reviewed and approved</p>
</div>

<!-- Statistics Cards -->
<div class="stats-row">
    <div class="stat-card primary">
        <div class="stat-card-content">
            <h6>Total Submissions</h6>
            <h3>{{ $stats['total'] ?? 0 }}</h3>
        </div>
        <div class="stat-card-icon">
            <i class="fas fa-file-pdf"></i>
        </div>
    </div>

    <div class="stat-card warning">
        <div class="stat-card-content">
            <h6>Pending Submission</h6>
            <h3>{{ $stats['pending'] ?? 0 }}</h3>
        </div>
        <div class="stat-card-icon">
            <i class="fas fa-clock"></i>
        </div>
    </div>

    <div class="stat-card success">
        <div class="stat-card-content">
            <h6>Approved</h6>
            <h3>{{ $stats['approved'] ?? 0 }}</h3>
        </div>
        <div class="stat-card-icon">
            <i class="fas fa-check-circle"></i>
        </div>
    </div>
</div>

<!-- Full Papers Table -->
<div class="table-card">
    @if($fullPapers->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Paper ID</th>
                        <th>Abstract ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Documents</th>
                        <th>Status</th>
                        <th>Submitted</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($fullPapers as $paper)
                    <tr>
                        <td><strong class="text-primary">FP-{{ str_pad($paper->id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                        <td>{{ $paper->abstract->submission_code }}</td>
                        <td>{{ Str::limit($paper->abstract->paper_title, 40) }}</td>
                        <td>{{ $paper->abstract->author_name }}</td>
                        <td>
                            @if($paper->paper_file_path)
                                <span class="doc-badge paper" title="Full Paper">
                                    <i class="fas fa-file-pdf"></i> Paper
                                </span>
                            @endif
                            @if($paper->presentation_file_path)
                                <span class="doc-badge presentation" title="Presentation">
                                    <i class="fas fa-file-powerpoint"></i> PPT
                                </span>
                            @endif
                            @if($paper->supplementary_files_path)
                                <span class="doc-badge supplementary" title="Supplementary Files">
                                    <i class="fas fa-paperclip"></i> Supp.
                                </span>
                            @endif
                        </td>
                        <td>
                            <span class="status-badge {{ strtolower($paper->status) }}">
                                {{ ucfirst($paper->status) }}
                            </span>
                        </td>
                        <td>{{ $paper->created_at->format('M d, Y') }}</td>
                        <td>
                            <button class="btn btn-view btn-sm view-paper"
                                    data-bs-toggle="modal"
                                    data-bs-target="#paperModal"
                                    data-id="{{ $paper->id }}"
                                    data-abstract-code="{{ $paper->abstract->submission_code }}"
                                    data-title="{{ $paper->abstract->paper_title }}"
                                    data-author="{{ $paper->abstract->author_name }}"
                                    data-email="{{ $paper->abstract->author_email }}"
                                    data-theme="{{ $paper->abstract->subTheme->form_field_value ?? 'N/A' }}"
                                    data-status="{{ $paper->status }}"
                                    data-submitted="{{ $paper->created_at->format('M d, Y H:i') }}"
                                    data-has-paper="{{ $paper->file_path ? '1' : '0' }}"
                                    data-has-presentation="{{ $paper->presentation_file_path ? '1' : '0' }}"
                                    data-has-supplementary="{{ $paper->supplementary_files_path ? '1' : '0' }}"
                                    data-paper-url="{{ $paper->paper_url }}"
                                    data-presentation-url="{{ $paper->presentation_url }}">
                                    
                                <i class="fas fa-eye me-1"></i> View
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


    @else
        <div class="empty-state">
            <i class="fas fa-file-pdf"></i>
            <h3>No Full Paper Submissions</h3>
            <p>There are no full paper submissions for abstracts you reviewed yet.</p>
        </div>
    @endif
</div>

<!-- Full Paper Details Modal -->
<div class="modal fade" id="paperModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-file-pdf me-2"></i>Full Paper Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Paper Details -->
                <div class="paper-details">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-hashtag me-2"></i>Abstract Code:</strong> 
                               <span id="modalAbstractCode" class="text-primary fw-bold"></span></p>
                            <p><strong><i class="fas fa-user me-2"></i>Author:</strong> 
                               <span id="modalAuthor"></span></p>
                            <p><strong><i class="fas fa-envelope me-2"></i>Email:</strong> 
                               <span id="modalEmail"></span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-tag me-2"></i>Sub-Theme:</strong> 
                               <span id="modalTheme" class="badge bg-secondary"></span></p>
                            <p><strong><i class="fas fa-circle me-2"></i>Status:</strong> 
                               <span id="modalStatus"></span></p>
                            <p><strong><i class="fas fa-calendar me-2"></i>Submitted:</strong> 
                               <span id="modalSubmitted"></span></p>
                        </div>
                    </div>
                    <p><strong><i class="fas fa-heading me-2"></i>Title:</strong></p>
                    <h5 id="modalTitle" class="text-primary"></h5>
                </div>

                <!-- Documents Section -->
                <div class="documents-section">
                    <h6 class="mb-3">
                        <i class="fas fa-folder-open me-2"></i>Submitted Documents
                    </h6>

                    <!-- Full Paper -->
                    <div id="paperDoc" class="document-item" style="display: none;">
                        <div class="document-info">
                            <div class="document-icon">
                                <i class="fas fa-file-pdf"></i>
                            </div>
                            <div class="document-meta">
                                <h6>Full Paper Document</h6>
                                <p>Main research paper (PDF/DOC/DOCX)</p>
                            </div>
                        </div>
                        <a id="paperDownload" href="#" class="btn btn-download btn-sm" target="_blank">
                            <i class="fas fa-download me-1"></i> Download
                        </a>
                    </div>

                    <!-- Presentation -->
                    <div id="presentationDoc" class="document-item" style="display: none;">
                        <div class="document-info">
                            <div class="document-icon">
                                <i class="fas fa-file-powerpoint text-danger"></i>
                            </div>
                            <div class="document-meta">
                                <h6>Presentation Slides</h6>
                                <p>PowerPoint presentation (PPT/PPTX)</p>
                            </div>
                        </div>
                        <a id="presentationDownload" href="#" class="btn btn-download btn-sm" target="_blank">
                            <i class="fas fa-download me-1"></i> Download
                        </a>
                    </div>

                    <!-- Supplementary -->
                    <div id="supplementaryDoc" class="document-item" style="display: none;">
                        <div class="document-info">
                            <div class="document-icon">
                                <i class="fas fa-paperclip text-warning"></i>
                            </div>
                            <div class="document-meta">
                                <h6>Supplementary Files</h6>
                                <p>Additional supporting documents</p>
                            </div>
                        </div>
                        <button class="btn btn-view btn-sm" onclick="alert('Supplementary files viewer coming soon')">
                            <i class="fas fa-eye me-1"></i> View Files
                        </button>
                    </div>

                    <div id="noDocuments" class="text-center text-muted py-3" style="display: none;">
                        <i class="fas fa-inbox fa-2x mb-2"></i>
                        <p>No documents uploaded yet</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.view-paper').forEach(btn => {
        btn.addEventListener('click', () => {
            const data = btn.dataset;
            
            // Set basic info
            document.getElementById('modalAbstractCode').textContent = data.abstractCode;
            document.getElementById('modalTitle').textContent = data.title;
            document.getElementById('modalAuthor').textContent = data.author;
            document.getElementById('modalEmail').textContent = data.email;
            document.getElementById('modalTheme').textContent = data.theme;
            document.getElementById('modalSubmitted').textContent = data.submitted;
            
            // Set status
            const statusEl = document.getElementById('modalStatus');
            const statusClass = data.status.toLowerCase().replace('_', '-');
            statusEl.className = `status-badge ${statusClass}`;
            statusEl.textContent = data.status.charAt(0).toUpperCase() + data.status.slice(1);
            
            // Show/hide documents
            const paperDoc = document.getElementById('paperDoc');
            const presentationDoc = document.getElementById('presentationDoc');
            const supplementaryDoc = document.getElementById('supplementaryDoc');
            const noDocuments = document.getElementById('noDocuments');
            
            let hasAnyDoc = false;
            
            if (data.hasPaper === '1') {
                paperDoc.style.display = 'flex';
                document.getElementById('paperDownload').href = data.paperUrl;
                hasAnyDoc = true;
            } else {
                paperDoc.style.display = 'none';
            }
            
            if (data.hasPresentation === '1') {
                presentationDoc.style.display = 'flex';
                document.getElementById('presentationDownload').href = data.presentationUrl;
                hasAnyDoc = true;
            } else {
                presentationDoc.style.display = 'none';
            }
            
            if (data.hasSupplementary === '1') {
                supplementaryDoc.style.display = 'flex';
                hasAnyDoc = true;
            } else {
                supplementaryDoc.style.display = 'none';
            }
            
            noDocuments.style.display = hasAnyDoc ? 'none' : 'block';
        });
    });
});
</script>
@endsection