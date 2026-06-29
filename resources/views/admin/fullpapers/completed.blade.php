@extends('admin.layout')

@section('title', 'Fully Reviewed Papers')
@section('page-title', 'Fully Reviewed Papers')

@section('styles')
<style>
    :root {
        --green: #2d8a3e;
        --dark-green: #1f6129;
        --light-green: #e8f5e9;
        --amber: #d97706;
        --red: #dc2626;
    }

    .page-hero {
        background: linear-gradient(135deg, var(--dark-green) 0%, #2d8a3e 60%, #16a34a 100%);
        border-radius: 16px;
        padding: 32px 36px;
        color: white;
        margin-bottom: 32px;
        position: relative;
        overflow: hidden;
    }
    .page-hero::after {
        content: '\f15b';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        right: 40px; top: 50%;
        transform: translateY(-50%);
        font-size: 120px;
        opacity: .06;
    }
    .page-hero h2 { font-weight: 700; font-size: 26px; margin-bottom: 6px; }
    .page-hero p  { opacity: .85; margin: 0; font-size: 14px; }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 16px;
    }
    .stats-grid-materials {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 28px;
    }
    @media(max-width:900px){
        .stats-grid { grid-template-columns: repeat(2,1fr); }
        .stats-grid-materials { grid-template-columns: repeat(2,1fr); }
    }

    .stat-tile {
        background: white;
        border-radius: 12px;
        padding: 22px 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,.07);
        border-top: 4px solid;
        display: flex;
        align-items: center;
        gap: 16px;
        transition: transform .2s, box-shadow .2s;
    }
    .stat-tile:hover { transform: translateY(-3px); box-shadow: 0 6px 18px rgba(0,0,0,.1); }
    .stat-tile.t-total   { border-top-color: var(--green); }
    .stat-tile.t-pending { border-top-color: var(--amber); }
    .stat-tile.t-approve { border-top-color: #16a34a; }
    .stat-tile.t-reject  { border-top-color: var(--red); }

    .stat-icon {
        width: 52px; height: 52px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }
    .t-total   .stat-icon { background: var(--light-green); color: var(--green); }
    .t-pending .stat-icon { background: #fef3c7; color: var(--amber); }
    .t-approve .stat-icon { background: #d1fae5; color: #16a34a; }
    .t-reject  .stat-icon { background: #fee2e2; color: var(--red); }
    .t-has-mat .stat-icon { background: #dbeafe; color: #1e40af; }
    .t-no-mat  .stat-icon { background: #fce7f3; color: #9d174d; }
    .t-revised .stat-icon { background: #ede9fe; color: #5b21b6; }
    .t-ppt     .stat-icon { background: #ecfdf5; color: #065f46; }
    .stat-tile.t-has-mat { border-top-color: #3b82f6; cursor:pointer; }
    .stat-tile.t-no-mat  { border-top-color: #ec4899; cursor:pointer; }
    .stat-tile.t-revised { border-top-color: #7c3aed; }
    .stat-tile.t-ppt     { border-top-color: #059669; }
    .stat-tile.t-has-mat.active-filter { background: #eff6ff; }
    .stat-tile.t-no-mat.active-filter  { background: #fdf2f8; }

    .stat-info h3 { font-size: 32px; font-weight: 700; margin: 0; color: #1e293b; }
    .stat-info p  { font-size: 12px; color: #64748b; text-transform: uppercase;
                    letter-spacing: .06em; margin: 2px 0 0; }

    .filter-bar {
        background: white;
        border-radius: 12px;
        padding: 18px 22px;
        box-shadow: 0 2px 8px rgba(0,0,0,.06);
        margin-bottom: 22px;
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        align-items: center;
    }
    .filter-bar .form-control,
    .filter-bar .form-select {
        font-size: 13px;
        border-color: #e2e8f0;
    }
    .filter-bar .form-control:focus,
    .filter-bar .form-select:focus {
        border-color: var(--green);
        box-shadow: 0 0 0 3px rgba(45,138,62,.12);
    }

    .table-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,.07);
        overflow: hidden;
    }
    .table-card-header {
        padding: 18px 24px;
        border-bottom: 2px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .table-card-header h5 { font-weight: 700; color: #1e293b; margin: 0; font-size: 16px; }

    .table thead th {
        background: var(--green);
        color: white;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .07em;
        font-weight: 700;
        padding: 14px 16px;
        border-bottom: none;
    }
    .table tbody tr { transition: background .15s; }
    .table tbody tr:hover { background: #f0fdf4; }
    .table tbody td {
        padding: 14px 16px;
        vertical-align: middle;
        font-size: 14px;
        border-bottom: 1px solid #f1f5f9;
    }

    .paper-id {
        font-family: monospace;
        font-size: 13px;
        font-weight: 700;
        color: var(--green);
        background: var(--light-green);
        padding: 3px 8px;
        border-radius: 5px;
        white-space: nowrap;
    }

    .review-dots { display: flex; gap: 6px; align-items: center; }
    .rdot {
        width: 28px; height: 28px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 11px; font-weight: 700;
        cursor: default;
        position: relative;
    }
    .rdot.done { background: #d1fae5; color: #065f46; border: 2px solid #86efac; }
    .rdot.pend { background: #f1f5f9; color: #94a3b8; border: 2px solid #e2e8f0; }
    .rdot .rtip {
        display: none;
        position: absolute;
        bottom: calc(100% + 6px);
        left: 50%; transform: translateX(-50%);
        background: #1e293b;
        color: white;
        font-size: 11px;
        white-space: nowrap;
        padding: 4px 8px;
        border-radius: 5px;
        font-family: sans-serif;
        z-index: 9;
    }
    .rdot:hover .rtip { display: block; }

    .sbadge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .04em;
    }
    .sbadge-awaiting     { background: #fef3c7; color: #92400e; }
    .sbadge-approved     { background: #d1fae5; color: #065f46; }
    .sbadge-rejected     { background: #fee2e2; color: #991b1b; }
    .sbadge-under-review { background: var(--green); color: white; }

    .btn-view-reviews {
        background: linear-gradient(135deg, var(--green) 0%, #16a34a 100%);
        color: white;
        border: none;
        padding: 7px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: opacity .2s, transform .15s;
    }
    .btn-view-reviews:hover { color: white; opacity: .88; transform: translateY(-1px); }

    .btn-view-decision {
        background: white;
        color: var(--green);
        border: 2px solid var(--green);
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all .2s;
    }
    .btn-view-decision:hover { background: var(--green); color: white; }

    .btn-view-material {
        background: white;
        color: #1e5a96;
        border: 2px solid #1e5a96;
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all .2s;
        margin-top: 6px;
    }
    .btn-view-material:hover { background: #1e5a96; color: white; }

    .score-pill {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: #f0fdf4;
        color: #166534;
        border: 1px solid #86efac;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 700;
    }
    .score-pill.mid { background: #fefce8; color: #713f12; border-color: #fde68a; }
    .score-pill.low { background: #fff1f2; color: #9f1239; border-color: #fca5a5; }

    .subtheme-tag {
        font-size: 11px;
        background: var(--light-green);
        color: var(--dark-green);
        border-radius: 5px;
        padding: 2px 8px;
        font-weight: 600;
    }

    .mat-badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 10px; border-radius: 20px;
        font-size: 11px; font-weight: 700;
    }
    .mat-yes  { background: #dbeafe; color: #1e40af; border: 1px solid #93c5fd; }
    .mat-no   { background: #fce7f3; color: #9d174d; border: 1px solid #f9a8d4; }
    .mat-part { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
    .mat-detail { font-size: 11px; color: #64748b; margin-top: 3px; }
    .mat-detail i { margin-right: 3px; }

    .empty-state {
        text-align: center;
        padding: 70px 20px;
        color: #94a3b8;
    }
    .empty-state i { font-size: 64px; margin-bottom: 18px; display: block; opacity: .35; }
    .empty-state h4 { color: #475569; font-size: 20px; margin-bottom: 8px; }

    .pagination-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 24px;
        border-top: 2px solid #f1f5f9;
        background: #fafbfc;
        flex-wrap: wrap;
        gap: 12px;
    }
    .pagination-info { font-size: 13px; color: #64748b; }
    .pagination-info strong { color: #1e293b; }
    .pagination { margin: 0; display: flex; flex-wrap: wrap; gap: 4px; }
    .pagination .page-item .page-link {
        color: var(--green);
        border: 1px solid #e2e8f0;
        border-radius: 8px !important;
        padding: 6px 13px;
        font-size: 13px;
        font-weight: 600;
        line-height: 1.5;
        background-color: white;
        margin: 0 2px;
        transition: all 0.2s ease;
    }
    .pagination .page-item .page-link:hover {
        background-color: var(--light-green);
        border-color: var(--green);
        color: var(--dark-green);
        box-shadow: 0 2px 6px rgba(45, 138, 62, 0.18);
        text-decoration: none;
    }
    .pagination .page-item.active .page-link {
        background-color: var(--green);
        border-color: var(--green);
        color: white;
        box-shadow: 0 2px 8px rgba(45, 138, 62, 0.35);
    }
    .pagination .page-item.active .page-link:hover {
        background-color: var(--dark-green);
        border-color: var(--dark-green);
        color: white;
    }
    .pagination .page-item.disabled .page-link {
        color: #cbd5e1;
        background-color: #f8fafc;
        border-color: #e2e8f0;
        cursor: not-allowed;
        pointer-events: none;
    }
    .pagination .page-item:first-child .page-link,
    .pagination .page-item:last-child .page-link {
        padding: 6px 15px;
        font-weight: 700;
    }

    .download-panel {
        background: white;
        border-radius: 12px;
        padding: 18px 22px;
        box-shadow: 0 2px 8px rgba(0,0,0,.06);
        margin-bottom: 22px;
        border-left: 4px solid #2d8a3e;
    }
    .download-panel-title {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: #1e293b;
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .download-panel-body {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        align-items: flex-end;
    }
    .download-panel .form-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: #64748b;
        margin-bottom: 5px;
    }
    .download-panel .form-select,
    .download-panel .form-check-label { font-size: 13px; }
    .download-panel .types-group { display: flex; flex-wrap: wrap; gap: 10px; }
    .download-panel .form-check { margin: 0; }
    .btn-download-zip {
        background: linear-gradient(135deg, #1e5a96 0%, #2563eb 100%);
        color: white;
        border: none;
        padding: 9px 20px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        cursor: pointer;
        transition: opacity .2s, transform .15s;
        white-space: nowrap;
        text-decoration: none;
    }
    .btn-download-zip:hover { opacity: .88; transform: translateY(-1px); color: white; }
    .btn-download-zip:disabled { opacity: .55; cursor: not-allowed; transform: none; }
    .download-count-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #eff6ff;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
        border-radius: 20px;
        padding: 4px 12px;
        font-size: 12px;
        font-weight: 700;
    }

    /* ── Excel materials report panel (new) ── */
    .report-panel {
        background: white;
        border-radius: 12px;
        padding: 18px 22px;
        box-shadow: 0 2px 8px rgba(0,0,0,.06);
        margin-bottom: 22px;
        border-left: 4px solid #16a34a;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }
    .report-panel-text h6 {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: #1e293b;
        margin: 0 0 4px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .report-panel-text p { font-size: 13px; color: #64748b; margin: 0; }
    .btn-download-excel {
        background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
        color: white;
        border: none;
        padding: 10px 22px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        transition: opacity .2s, transform .15s;
        white-space: nowrap;
        text-decoration: none;
        flex-shrink: 0;
    }
    .btn-download-excel:hover { opacity: .88; transform: translateY(-1px); color: white; }
</style>
@endsection

@section('content')

<div class="page-hero">
    <h2><i class="fas fa-clipboard-list me-2"></i>Fully Reviewed Papers</h2>
    <p>Papers that have completed all reviews and are ready for a final decision.</p>
</div>

<div class="stats-grid">
    <div class="stat-tile t-total">
        <div class="stat-icon"><i class="fas fa-layer-group"></i></div>
        <div class="stat-info"><h3>{{ $stats['total'] }}</h3><p>Total Decided</p></div>
    </div>
    <div class="stat-tile t-pending">
        <div class="stat-icon"><i class="fas fa-hourglass-half"></i></div>
        <div class="stat-info"><h3>{{ $stats['awaiting'] }}</h3><p>Awaiting Decision</p></div>
    </div>
    <div class="stat-tile t-approve">
        <div class="stat-icon"><i class="fas fa-check-double"></i></div>
        <div class="stat-info"><h3>{{ $stats['approved'] }}</h3><p>Approved</p></div>
    </div>
    <div class="stat-tile t-reject">
        <div class="stat-icon"><i class="fas fa-times-circle"></i></div>
        <div class="stat-info"><h3>{{ $stats['rejected'] }}</h3><p>Rejected</p></div>
    </div>
</div>

<p class="text-muted mb-2" style="font-size:.75rem;text-transform:uppercase;letter-spacing:.08em;font-weight:700;">
    <i class="fas fa-file-upload me-1 text-success"></i> Materials Submission — Approved Papers
</p>
<div class="stats-grid-materials">
    <div class="stat-tile t-has-mat {{ $materialsFilter === 'submitted' ? 'active-filter' : '' }}"
         onclick="document.getElementById('materialsFilterInput').value='submitted'; document.getElementById('filterForm').submit();"
         title="Click to filter — papers that have submitted materials">
        <div class="stat-icon"><i class="fas fa-upload"></i></div>
        <div class="stat-info">
            <h3>{{ $stats['with_materials'] }}</h3>
            <p>Submitted Materials</p>
        </div>
    </div>
    <div class="stat-tile t-no-mat {{ $materialsFilter === 'missing' ? 'active-filter' : '' }}"
         onclick="document.getElementById('materialsFilterInput').value='missing'; document.getElementById('filterForm').submit();"
         title="Click to filter — papers that have NOT submitted materials">
        <div class="stat-icon"><i class="fas fa-exclamation-circle"></i></div>
        <div class="stat-info">
            <h3>{{ $stats['without_materials'] }}</h3>
            <p>No Materials Yet</p>
        </div>
    </div>
    <div class="stat-tile t-revised">
        <div class="stat-icon"><i class="fas fa-file-alt"></i></div>
        <div class="stat-info">
            <h3>{{ $stats['with_revised'] }}</h3>
            <p>Revised Full Papers</p>
        </div>
    </div>
    <div class="stat-tile t-ppt">
        <div class="stat-icon"><i class="fas fa-file-powerpoint"></i></div>
        <div class="stat-info">
            <h3>{{ $stats['with_presentation'] }}</h3>
            <p>Presentations (PPT/Poster)</p>
        </div>
    </div>
</div>

{{-- ════════════════ NEW: Excel Materials Report ════════════════ --}}
<div class="report-panel">
    <div class="report-panel-text">
        <h6><i class="fas fa-file-excel text-success"></i> Materials Submission Report (Excel)</h6>
        <p>
            Download a spreadsheet listing every approved paper — who submitted materials and who hasn't —
            with full author, contact, and institution details on two separate sheets.
            @if($search || $subthemeFilter)
                Respects your current search / sub-theme filter.
            @endif
        </p>
    </div>
    <a href="{{ route('admin.fullpapers.materials-report', request()->only('search', 'subtheme')) }}"
       class="btn-download-excel">
        <i class="fas fa-file-excel"></i>
        Download Excel Report
    </a>
</div>

<div class="download-panel">
    <div class="download-panel-title">
        <i class="fas fa-download text-success"></i>
        Bulk Download Presentation Materials
    </div>

    <form method="GET"
          action="{{ route('admin.fullpapers.download-materials') }}"
          id="downloadForm"
          class="download-panel-body">

        <div>
            <div class="form-label">Filter by Sub-Theme</div>
            <select name="subtheme" class="form-select" style="width:220px" id="dlSubtheme">
                <option value="">All Sub-Themes</option>
                @foreach($subthemes as $subtheme)
                    <option value="{{ $subtheme->id }}">{{ $subtheme->full_name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <div class="form-label">Include File Types</div>
            <div class="types-group">
                <div class="form-check">
                    <input class="form-check-input dl-type" type="checkbox"
                           name="types[]" value="revised" id="dlRevised" checked>
                    <label class="form-check-label" for="dlRevised">
                        <i class="fas fa-file-alt text-success me-1"></i> Revised Paper
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input dl-type" type="checkbox"
                           name="types[]" value="powerpoint" id="dlPPT" checked>
                    <label class="form-check-label" for="dlPPT">
                        <i class="fas fa-file-powerpoint text-warning me-1"></i> PowerPoint
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input dl-type" type="checkbox"
                           name="types[]" value="poster" id="dlPoster" checked>
                    <label class="form-check-label" for="dlPoster">
                        <i class="fas fa-image text-primary me-1"></i> Poster
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input dl-type" type="checkbox"
                           name="types[]" value="supporting" id="dlSupporting" checked>
                    <label class="form-check-label" for="dlSupporting">
                        <i class="fas fa-paperclip text-secondary me-1"></i> Supporting Docs
                    </label>
                </div>
            </div>
        </div>

        <div class="align-self-end">
            <span class="download-count-badge" id="dlCountBadge">
                <i class="fas fa-boxes"></i>
                <span id="dlCount">{{ $stats['with_materials'] }}</span> packages available
            </span>
        </div>

        <div class="align-self-end ms-auto">
            <button type="submit" class="btn-download-zip" id="dlBtn">
                <i class="fas fa-file-zipper"></i>
                Download ZIP
            </button>
        </div>
    </form>
</div>

<form method="GET" action="{{ route('admin.fullpapers.completed') }}" class="filter-bar" id="filterForm">
    <div class="flex-grow-1" style="min-width:220px">
        <div class="input-group">
            <span class="input-group-text bg-light border-end-0">
                <i class="fas fa-search text-muted"></i>
            </span>
            <input type="text" name="search" id="searchInput" class="form-control border-start-0"
                   placeholder="Search title, author, or code…"
                   value="{{ $search }}">
        </div>
    </div>
    <select name="status" id="statusFilter" class="form-select" style="width:180px" onchange="this.form.submit()">
        <option value="">All Statuses</option>
        <option value="approved" {{ $statusFilter === 'approved' ? 'selected' : '' }}>Approved</option>
        <option value="rejected" {{ $statusFilter === 'rejected' ? 'selected' : '' }}>Rejected</option>
    </select>
    <select name="subtheme" id="subthemeFilter" class="form-select" style="width:200px" onchange="this.form.submit()">
        <option value="">All Sub-Themes</option>
        @foreach($subthemes as $subtheme)
            <option value="{{ $subtheme->id }}" {{ $subthemeFilter == $subtheme->id ? 'selected' : '' }}>
                {{ $subtheme->full_name }}
            </option>
        @endforeach
    </select>
    <select id="materialsSelect" class="form-select" style="width:180px"
            onchange="document.getElementById('materialsFilterInput').value=this.value; this.form.submit()">
        <option value="">All Materials</option>
        <option value="submitted" {{ $materialsFilter === 'submitted' ? 'selected' : '' }}>✅ Materials Submitted</option>
        <option value="missing"   {{ $materialsFilter === 'missing'   ? 'selected' : '' }}>⚠️ No Materials Yet</option>
    </select>
    <input type="hidden" name="materials" id="materialsFilterInput" value="{{ $materialsFilter }}">
    <button type="submit" class="btn btn-success btn-sm px-3">
        <i class="fas fa-search me-1"></i> Search
    </button>
    @if($search || $statusFilter || $subthemeFilter || $materialsFilter)
    <a href="{{ route('admin.fullpapers.completed') }}" class="btn btn-outline-secondary btn-sm px-3">
        <i class="fas fa-times me-1"></i> Clear
    </a>
    @endif
</form>

<div class="table-card">
    <div class="table-card-header">
        <h5><i class="fas fa-table me-2 text-success"></i>
            @if($search || $statusFilter || $subthemeFilter)
                Search Results
            @else
                Papers Ready for Final Decision
            @endif
        </h5>
        <div class="d-flex align-items-center gap-2">
            @if($search || $statusFilter || $subthemeFilter)
                <span class="badge bg-secondary">{{ $papers->total() }} found</span>
            @else
                <span class="badge bg-success">{{ $stats['total'] }} papers</span>
            @endif
        </div>
    </div>

    <div class="table-responsive">
        <table class="table mb-0" id="papersTable">
            <thead>
                <tr>
                    <th>Paper ID</th>
                    <th>Title &amp; Author</th>
                    <th>Sub-Theme</th>
                    <th class="text-center">Reviews</th>
                    <th class="text-center">Avg. Score</th>
                    <th>Status</th>
                    <th>Materials</th>
                    <th>Last Update</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($papers as $paper)
                <tr
                    data-status="{{ strtolower($paper->status) }}"
                    data-subtheme="{{ strtolower($paper->abstract->subtheme->full_name ?? '') }}"
                >
                    <td>
                        <span class="paper-id">{{ $paper->abstract->submission_code }}</span>
                    </td>
                    <td>
                        <div class="fw-semibold text-dark" style="max-width:280px;line-height:1.4">
                            {{ $paper->abstract->title }}
                        </div>
                        <small class="text-muted">{{ $paper->abstract->author_name }}</small>
                    </td>
                    <td>
                        <span class="subtheme-tag">
                            {{ $paper->abstract->subtheme->full_name ?? 'N/A' }}
                        </span>
                    </td>
                    <td class="text-center">
                        <div class="review-dots justify-content-center">
                            @foreach($paper->reviews as $review)
                                <div class="rdot done">
                                    <i class="fas fa-check"></i>
                                    <span class="rtip">
                                        {{ $review->role }} · {{ $review->reviewer_name }} · {{ $review->score }}/100
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </td>
                    <td class="text-center">
                        @php
                            $avgScore   = $paper->average_score ?? 0;
                            $scoreClass = $avgScore >= 80 ? '' : ($avgScore >= 65 ? 'mid' : 'low');
                        @endphp
                        <span class="score-pill {{ $scoreClass }}">{{ $avgScore }}/100</span>
                    </td>
                    <td>
                        @php
                            $statusClass = match(strtoupper($paper->status)) {
                                'APPROVED'                      => 'sbadge-approved',
                                'REJECTED', 'NOT_APPROVED'      => 'sbadge-rejected',
                                'UNDER_REVIEW'                  => 'sbadge-under-review',
                                default                         => 'sbadge-awaiting',
                            };
                        @endphp
                        <span class="sbadge {{ $statusClass }}">{{ ucfirst($paper->status) }}</span>
                    </td>
                    <td>
                        @php
                            $pu = $paper->presentationUpload;
                            $hasRevised  = $pu && $pu->revised_fullpaper;
                            $hasPPT      = $pu && ($pu->powerpoint_file || $pu->poster_file);
                            $hasAny      = $hasRevised || $hasPPT;
                        @endphp

                        @if(!$pu || !$hasAny)
                            @if(in_array(strtoupper($paper->status), ['APPROVED']))
                                <span class="mat-badge mat-no">
                                    <i class="fas fa-exclamation-circle"></i> None
                                </span>
                            @else
                                <span class="text-muted" style="font-size:12px;">N/A</span>
                            @endif
                        @elseif($hasRevised && $hasPPT)
                            <span class="mat-badge mat-yes">
                                <i class="fas fa-check-circle"></i> Complete
                            </span>
                            <div class="mat-detail">
                                <i class="fas fa-file-alt"></i> Paper
                                &nbsp;·&nbsp;
                                <i class="fas fa-file-powerpoint"></i>
                                {{ $pu->powerpoint_file ? 'PPT' : 'Poster' }}
                            </div>
                        @else
                            <span class="mat-badge mat-part">
                                <i class="fas fa-exclamation-triangle"></i> Partial
                            </span>
                            <div class="mat-detail">
                                <i class="fas fa-file-alt {{ $hasRevised ? 'text-success' : 'text-danger' }}"></i>
                                {{ $hasRevised ? 'Paper ✓' : 'Paper ✗' }}
                                &nbsp;·&nbsp;
                                <i class="fas fa-file-powerpoint {{ $hasPPT ? 'text-success' : 'text-danger' }}"></i>
                                {{ $hasPPT ? 'PPT ✓' : 'PPT ✗' }}
                            </div>
                        @endif
                    </td>

                    <td class="text-muted" style="font-size:13px">
                        {{ $paper->updated_at->format('M d, Y') }}
                    </td>
                    <td>
                        @if(strtolower($paper->status) === 'awaiting')
                            <a href="{{ route('admin.fullpapers.all-reviews', $paper->id) }}"
                               class="btn-view-reviews">
                                <i class="fas fa-eye"></i> View Reviews
                            </a>
                        @else
                            <div class="d-flex flex-column" style="gap:6px">
                                <a href="{{ route('admin.fullpapers.all-reviews', $paper->id) }}"
                                   class="btn-view-decision">
                                    <i class="fas fa-check-circle"></i> View Decision
                                </a>
                                <a href="{{ route('admin.fullpapers.materials', $paper->id) }}"
                                   class="btn-view-material">
                                    <i class="fas fa-file-alt"></i> View Materials
                                </a>
                            </div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-5 text-muted">
                        No fully reviewed papers found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($papers->hasPages())
        <div class="pagination-wrapper">
            <div class="pagination-info">
                Showing <strong>{{ $papers->firstItem() }}</strong>
                to <strong>{{ $papers->lastItem() }}</strong>
                of <strong>{{ $papers->total() }}</strong> papers
            </div>
            {{ $papers->links() }}
        </div>
    @elseif($papers->count() > 0)
        <div class="pagination-wrapper">
            <div class="pagination-info">
                Showing all <strong>{{ $papers->count() }}</strong>
                of <strong>{{ $papers->total() }}</strong> papers
            </div>
        </div>
    @endif

</div>

<div class="alert alert-success d-flex gap-3 align-items-start mt-4"
     style="border-radius:12px; border-left: 4px solid #2d8a3e;">
    <i class="fas fa-lightbulb fa-lg mt-1 flex-shrink-0 text-success"></i>
    <div>
        <strong>Tip:</strong> Hover over the review dots
        <span class="rdot done d-inline-flex"
              style="width:20px;height:20px;font-size:10px;vertical-align:middle;cursor:default">
            <i class="fas fa-check"></i>
        </span>
        to quickly see reviewer name and score. Once a decision has been made, use
        <strong>"View Materials"</strong> to access the author's uploaded presentation files.
    </div>
</div>

@endsection

@section('scripts')
<script>
(function () {
    const searchInput = document.getElementById('searchInput');
    const filterForm  = document.getElementById('filterForm');
    let debounceTimer;

    if (searchInput && filterForm) {
        searchInput.addEventListener('input', function () {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(function () {
                filterForm.submit();
            }, 500);
        });
    }
})();
</script>

<script>
(function () {
    const dlSubtheme = document.getElementById('dlSubtheme');
    const dlCount    = document.getElementById('dlCount');
    const dlBtn      = document.getElementById('dlBtn');
    const dlTypes    = document.querySelectorAll('.dl-type');

    document.getElementById('downloadForm').addEventListener('submit', function (e) {
        const anyChecked = [...dlTypes].some(cb => cb.checked);
        if (!anyChecked) {
            e.preventDefault();
            alert('Please select at least one file type to download.');
        }
    });

    if (dlSubtheme) {
        dlSubtheme.addEventListener('change', function () {
            const subthemeId = this.value;

            dlCount.textContent = '…';
            dlBtn.disabled = true;

            fetch(`{{ route('admin.fullpapers.download-materials.count') }}?subtheme=${subthemeId}`)
                .then(r => r.json())
                .then(data => {
                    dlCount.textContent = data.count ?? '?';
                    dlBtn.disabled = (data.count === 0);
                })
                .catch(() => {
                    dlCount.textContent = '?';
                    dlBtn.disabled = false;
                });
        });
    }
})();
</script>
@endsection
