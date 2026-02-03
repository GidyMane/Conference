@extends('admin.layout')

@section('title', 'Manage Full Papers')
@section('page-title', 'Manage Full Papers')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1>Manage Full Papers</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Full Papers</li>
                </ol>
            </nav>
        </div>
        <div>
            <button class="btn btn-outline-success" onclick="exportData()">
                <i class="fas fa-file-excel me-2"></i>Export
            </button>
        </div>
    </div>
</div>

<!-- Statistics -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card border-start border-primary border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Submissions</h6>
                        <h3 class="mb-0">{{ $stats['total'] ?? 0 }}</h3>
                    </div>
                    <i class="fas fa-file-pdf fa-2x text-primary"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card border-start border-warning border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Pending Review</h6>
                        <h3 class="mb-0">{{ $stats['pending'] ?? 0 }}</h3>
                    </div>
                    <i class="fas fa-clock fa-2x text-warning"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card border-start border-success border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Accepted</h6>
                        <h3 class="mb-0">{{ $stats['accepted'] ?? 0 }}</h3>
                    </div>
                    <i class="fas fa-check-circle fa-2x text-success"></i>
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
                        <h3 class="mb-0">{{ $stats['rejected'] ?? 0 }}</h3>
                    </div>
                    <i class="fas fa-times-circle fa-2x text-danger"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filters</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('fullpapers.index') }}">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="PENDING">Pending</option>
                        <option value="APPROVED">Accepted</option>
                        <option value="REJECTED">Rejected</option>
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label">Sub-theme</label>
                    <select name="subtheme" class="form-select">
                        <option value="">All Sub-themes</option>
                        @foreach($subthemes ?? [] as $subtheme)
                        <option value="{{ $subtheme->id }}">{{ $subtheme->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label">Date Range</label>
                    <select name="date_range" class="form-select">
                        <option value="">All Time</option>
                        <option value="today">Today</option>
                        <option value="week">This Week</option>
                        <option value="month">This Month</option>
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-kalro-primary w-100">
                        <i class="fas fa-search me-2"></i>Apply Filters
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Full Papers Table -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>All Full Paper Submissions</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover data-table">
                <thead>
                    <tr>
                        <th>Paper ID</th>
                        <th>Abstract ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Sub-theme</th>
                        <th>Documents</th>
                        <th>Status</th>
                        <th>Submitted</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($fullPapers ?? [] as $paper)
                    <tr>
                        <td><strong class="text-primary">{{ $paper->id }}</strong></td>
                        <td>
                            <a href="#" class="text-decoration-none">
                                {{ $paper->abstract->submission_code }}
                            </a>
                        </td>
                        <td>{{ $paper->abstract->paper_title }}</td>
                        <td>{{ $paper->abstract->author_name }}</td>
                        <td>
                            <span class="badge bg-secondary">
                                {{ $paper->abstract?->subTheme?->name ?? 'N/A' }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                @if($paper->full_paper_document)
                                <a href="{{ $paper->full_paper_document }}" class="btn btn-outline-primary" title="Full Paper" target="_blank">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                                @endif
                                @if($paper->presentation_document)
                                <a href="{{ $paper->presentation_document }}" class="btn btn-outline-success" title="Presentation" target="_blank">
                                    <i class="fas fa-file-powerpoint"></i>
                                </a>
                                @endif
                                @if($paper->supplementary_documents)
                                <button class="btn btn-outline-info" onclick="viewSupplementary({{ $paper->id }})" title="Supplementary">
                                    <i class="fas fa-paperclip"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-{{ strtolower(str_replace('_', '-', $paper->status)) }}">
                                {{ ucfirst(str_replace('_', ' ', $paper->status)) }}
                            </span>
                        </td>
                        <td>{{ $paper->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="#" class="btn btn-info" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button class="btn btn-success" onclick="acceptPaper({{ $paper->id }})" title="Accept">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button class="btn btn-danger" onclick="rejectPaper({{ $paper->id }})" title="Reject">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">No full paper submissions found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Supplementary Documents Modal -->
<div class="modal fade" id="supplementaryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Supplementary Documents</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="supplementaryContent">
                    <!-- Will be populated dynamically -->
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
    function viewSupplementary(paperId) {
        // Fetch and display supplementary documents
        fetch(`/admin/fullpapers/${paperId}/supplementary`)
            .then(response => response.json())
            .then(data => {
                const content = document.getElementById('supplementaryContent');
                content.innerHTML = '';
                
                if (data.documents && data.documents.length > 0) {
                    data.documents.forEach(doc => {
                        content.innerHTML += `
                            <div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded">
                                <div>
                                    <i class="fas fa-file me-2"></i>
                                    <strong>${doc.name}</strong>
                                </div>
                                <a href="${doc.url}" class="btn btn-sm btn-primary" target="_blank">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            </div>
                        `;
                    });
                } else {
                    content.innerHTML = '<p class="text-muted">No supplementary documents</p>';
                }
                
                new bootstrap.Modal(document.getElementById('supplementaryModal')).show();
            });
    }
    
    function acceptPaper(paperId) {
        if (confirm('Are you sure you want to accept this full paper?')) {
            fetch(`/admin/fullpapers/${paperId}/accept`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }
    }
    
    function rejectPaper(paperId) {
        const reason = prompt('Please provide a reason for rejection:');
        if (reason) {
            fetch(`/admin/fullpapers/${paperId}/reject`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ reason: reason })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }
    }
    
    function exportData() {
        const params = new URLSearchParams(window.location.search);
        window.location.href = '/' + params.toString();
    }
</script>

@endsection
