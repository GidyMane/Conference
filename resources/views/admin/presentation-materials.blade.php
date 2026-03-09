@extends('layouts.admin-layout')

@section('title', 'View Presentation Materials')

@section('content')
<style>
    .materials-header {
        background: linear-gradient(135deg, #1a5f3a 0%, #0d3d25 100%);
        color: white;
        padding: 24px;
        border-radius: 12px;
        margin-bottom: 24px;
        box-shadow: 0 4px 12px rgba(26, 95, 58, 0.2);
    }
    
    .paper-info-card {
        background: #f0fdf4;
        border-left: 4px solid #10b981;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 24px;
    }
    
    .file-card {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 20px;
        transition: all 0.3s;
        background: white;
    }
    
    .file-card:hover {
        border-color: #10b981;
        box-shadow: 0 4px 16px rgba(16, 185, 129, 0.15);
        transform: translateY(-2px);
    }
    
    .file-icon-container {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 36px;
        margin-bottom: 16px;
    }
    
    .icon-powerpoint {
        background: #fff3cd;
        color: #d97706;
    }
    
    .icon-poster {
        background: #dbeafe;
        color: #1e40af;
    }
    
    .icon-docs {
        background: #e0e7ff;
        color: #5b21b6;
    }
    
    .file-meta {
        color: #6b7280;
        font-size: 0.875rem;
        margin-top: 8px;
    }
    
    .btn-download {
        background: #10b981;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s;
    }
    
    .btn-download:hover {
        background: #059669;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }
    
    .btn-preview {
        background: #1a5f3a;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 500;
        margin-right: 8px;
    }
    
    .btn-preview:hover {
        background: #0d3d25;
        color: white;
    }
    
    .upload-date-badge {
        background: #dcfce7;
        color: #065f46;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }
    
    .no-materials {
        text-align: center;
        padding: 60px 20px;
        color: #6b7280;
    }
    
    .no-materials i {
        font-size: 64px;
        color: #d1d5db;
        margin-bottom: 20px;
    }
    
    .status-badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    
    .status-uploaded {
        background: #d1fae5;
        color: #065f46;
    }
    
    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }
</style>

<div class="page-header">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.fullpapers.index') }}">Full Papers</a></li>
            <li class="breadcrumb-item active">Presentation Materials</li>
        </ol>
    </nav>
</div>

<div class="materials-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2 class="mb-2"><i class="fas fa-file-powerpoint me-2"></i>Presentation Materials</h2>
            <p class="mb-0 opacity-75">View and download author-submitted presentation files</p>
        </div>
        <div>
            <a href="{{ route('admin.fullpapers.index') }}" class="btn btn-light">
                <i class="fas fa-arrow-left me-2"></i>Back to Papers
            </a>
        </div>
    </div>
</div>

{{-- Paper Information --}}
<div class="paper-info-card">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h5 class="text-success mb-3">
                <i class="fas fa-file-alt me-2"></i>
                {{ $fullPaper->abstract->paper_title ?? 'Genetic Improvement of Drought-Resistant Crop Varieties' }}
            </h5>
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-2"><strong>Paper ID:</strong> FP-{{ str_pad($fullPaper->id ?? '0005', 4, '0', STR_PAD_LEFT) }}</p>
                    <p class="mb-2"><strong>Author:</strong> {{ $fullPaper->abstract->author_name ?? 'Dr. Sarah Njeri' }}</p>
                    <p class="mb-0"><strong>Email:</strong> {{ $fullPaper->abstract->author_email ?? 's.njeri@example.com' }}</p>
                </div>
                <div class="col-md-6">
                    <p class="mb-2"><strong>Sub-Theme:</strong> {{ $fullPaper->abstract->subTheme->full_name ?? 'Crop Science' }}</p>
                    <p class="mb-2"><strong>Decision:</strong> <span class="badge bg-success">APPROVED</span></p>
                    <p class="mb-0"><strong>Presentation Type:</strong> <span class="badge bg-primary">Oral Presentation</span></p>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-end">
            @if($uploadDate ?? false)
            <div class="upload-date-badge">
                <i class="fas fa-calendar-check me-1"></i>
                Uploaded: {{ $uploadDate->format('M d, Y') }}
            </div>
            @else
            <div class="upload-date-badge">
                <i class="fas fa-calendar-check me-1"></i>
                Uploaded: Feb 28, 2026
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Materials Section --}}
@if(($powerpoint ?? true) || ($poster ?? true) || ($supportingDocs ?? true))

<div class="row">
    
    {{-- PowerPoint Presentation --}}
    @if($powerpoint ?? true)
    <div class="col-md-6 mb-4">
        <div class="file-card">
            <div class="text-center">
                <div class="file-icon-container icon-powerpoint mx-auto">
                    <i class="fas fa-file-powerpoint"></i>
                </div>
                <h5 class="mb-2">PowerPoint Presentation</h5>
                <p class="text-muted mb-1">{{ $powerpoint->original_name ?? 'Drought_Resistant_Crops_Presentation.pptx' }}</p>
                <div class="file-meta">
                    <i class="fas fa-hdd me-1"></i>{{ $powerpoint->size ?? '3.2 MB' }}
                    <span class="mx-2">•</span>
                    <span class="status-badge status-uploaded">
                        <i class="fas fa-check-circle me-1"></i>Uploaded
                    </span>
                </div>
            </div>
            <hr class="my-3">
            <div class="d-flex justify-content-center gap-2">
                <button class="btn btn-preview" onclick="previewFile('powerpoint')">
                    <i class="fas fa-eye me-2"></i>Preview
                </button>
                <a href="{{ $powerpoint->download_url ?? '#' }}" 
                   class="btn btn-download"
                   onclick="trackDownload('powerpoint', event)">
                    <i class="fas fa-download me-2"></i>Download
                </a>
            </div>
        </div>
    </div>
    @endif

    {{-- Poster --}}
    @if($poster ?? true)
    <div class="col-md-6 mb-4">
        <div class="file-card">
            <div class="text-center">
                <div class="file-icon-container icon-poster mx-auto">
                    <i class="fas fa-image"></i>
                </div>
                <h5 class="mb-2">Research Poster</h5>
                <p class="text-muted mb-1">{{ $poster->original_name ?? 'Research_Poster_Drought_Crops.pdf' }}</p>
                <div class="file-meta">
                    <i class="fas fa-hdd me-1"></i>{{ $poster->size ?? '2.1 MB' }}
                    <span class="mx-2">•</span>
                    <span class="status-badge status-uploaded">
                        <i class="fas fa-check-circle me-1"></i>Uploaded
                    </span>
                </div>
            </div>
            <hr class="my-3">
            <div class="d-flex justify-content-center gap-2">
                <button class="btn btn-preview" onclick="previewFile('poster')">
                    <i class="fas fa-eye me-2"></i>Preview
                </button>
                <a href="{{ $poster->download_url ?? '#' }}" 
                   class="btn btn-download"
                   onclick="trackDownload('poster', event)">
                    <i class="fas fa-download me-2"></i>Download
                </a>
            </div>
        </div>
    </div>
    @endif

</div>

{{-- Supporting Documents --}}
@if($supportingDocs ?? true)
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-paperclip me-2"></i>Supporting Documents
        </h5>
    </div>
    <div class="card-body">
        <div class="row">
            {{-- Demo supporting docs --}}
            @php
                $demoDocs = $supportingDocs ?? [
                    (object)[
                        'id' => 1,
                        'original_name' => 'Supplementary_Data_Analysis.pdf',
                        'size' => '1.8 MB',
                        'type' => 'PDF Document'
                    ],
                    (object)[
                        'id' => 2,
                        'original_name' => 'Research_Methodology_Details.docx',
                        'size' => '856 KB',
                        'type' => 'Word Document'
                    ],
                    (object)[
                        'id' => 3,
                        'original_name' => 'Dataset_Raw_Figures.zip',
                        'size' => '5.2 MB',
                        'type' => 'ZIP Archive'
                    ]
                ];
            @endphp

            @foreach($demoDocs as $doc)
            <div class="col-md-6 mb-3">
                <div class="d-flex align-items-center p-3 border rounded" style="background: #fafafa;">
                    <div class="file-icon-container icon-docs me-3" style="width: 50px; height: 50px; font-size: 24px;">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-1">{{ $doc->original_name }}</h6>
                        <small class="text-muted">
                            {{ $doc->type ?? 'Document' }} • {{ $doc->size }}
                        </small>
                    </div>
                    <div>
                        <a href="{{ $doc->download_url ?? '#' }}" 
                           class="btn btn-sm btn-download"
                           onclick="trackDownload('supporting_{{ $doc->id }}', event)">
                            <i class="fas fa-download"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- Download All Button --}}
<div class="text-center mt-4">
    <button class="btn btn-lg" style="background: #1a5f3a; color: white;" onclick="downloadAll()">
        <i class="fas fa-download me-2"></i>Download All Materials (ZIP)
    </button>
</div>

@else

{{-- No Materials Uploaded --}}
<div class="card">
    <div class="card-body">
        <div class="no-materials">
            <i class="fas fa-inbox"></i>
            <h4>No Presentation Materials Uploaded</h4>
            <p class="text-muted">The author has not yet uploaded any presentation materials for this paper.</p>
            <p class="small text-muted">Materials are typically uploaded after paper approval.</p>
        </div>
    </div>
</div>

@endif

{{-- Activity Log --}}
<div class="card mt-4">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-history me-2"></i>Activity Log
        </h5>
    </div>
    <div class="card-body">
        <div class="list-group list-group-flush">
            <div class="list-group-item">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-upload text-success me-2"></i>
                        <strong>PowerPoint uploaded</strong>
                        <p class="mb-0 small text-muted ms-4">Drought_Resistant_Crops_Presentation.pptx</p>
                    </div>
                    <small class="text-muted">Feb 28, 2026 - 2:34 PM</small>
                </div>
            </div>
            <div class="list-group-item">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-upload text-success me-2"></i>
                        <strong>Poster uploaded</strong>
                        <p class="mb-0 small text-muted ms-4">Research_Poster_Drought_Crops.pdf</p>
                    </div>
                    <small class="text-muted">Feb 28, 2026 - 2:35 PM</small>
                </div>
            </div>
            <div class="list-group-item">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-upload text-success me-2"></i>
                        <strong>3 supporting documents uploaded</strong>
                    </div>
                    <small class="text-muted">Feb 28, 2026 - 2:37 PM</small>
                </div>
            </div>
            <div class="list-group-item">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-check-circle text-info me-2"></i>
                        <strong>Paper approved for presentation</strong>
                    </div>
                    <small class="text-muted">Feb 25, 2026 - 10:15 AM</small>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewFile(type) {
    alert(`Preview for ${type} will open in a new window/modal`);
    // In production: window.open(previewUrl, '_blank');
}

function trackDownload(fileType, event) {
    console.log(`Downloading: ${fileType}`);
    // In production: log download activity
    // If using demo, prevent default
    if (event.target.href === '#' || event.target.href.endsWith('#')) {
        event.preventDefault();
        alert(`Download would start for: ${fileType}`);
    }
}

function downloadAll() {
    alert('All materials will be downloaded as a ZIP file');
    // In production: trigger ZIP download
}
</script>

@endsection
