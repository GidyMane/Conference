@extends('reviewer.layout')

@section('title', 'Fully Reviewed Papers')
@section('page-title', 'Fully Reviewed Papers')

@section('styles')
<style>
    :root {
        --blue: #1e5a96;
        --dark-blue: #143d66;
        --green: #16a34a;
        --amber: #d97706;
        --red: #dc2626;
    }

    /* ── Header ── */
    .page-hero {
        background: linear-gradient(135deg, var(--dark-blue) 0%, #1e5a96 60%, #2563eb 100%);
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

    /* ── Stats ── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 28px;
    }
    @media(max-width:900px){ .stats-grid { grid-template-columns: repeat(2,1fr); } }

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
    .stat-tile.t-total  { border-top-color: var(--blue); }
    .stat-tile.t-pending{ border-top-color: var(--amber); }
    .stat-tile.t-approve{ border-top-color: var(--green); }
    .stat-tile.t-reject { border-top-color: var(--red); }

    .stat-icon {
        width: 52px; height: 52px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }
    .t-total  .stat-icon { background: #dbeafe; color: var(--blue); }
    .t-pending .stat-icon { background: #fef3c7; color: var(--amber); }
    .t-approve .stat-icon { background: #d1fae5; color: var(--green); }
    .t-reject .stat-icon  { background: #fee2e2; color: var(--red); }

    .stat-info h3 { font-size: 32px; font-weight: 700; margin: 0; color: #1e293b; }
    .stat-info p  { font-size: 12px; color: #64748b; text-transform: uppercase;
                    letter-spacing: .06em; margin: 2px 0 0; }

    /* ── Filters ── */
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
        border-color: var(--blue);
        box-shadow: 0 0 0 3px rgba(30,90,150,.12);
    }

    /* ── Table Card ── */
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
        background: #f8fafc;
        color: #475569;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .07em;
        font-weight: 700;
        padding: 14px 16px;
        border-bottom: 2px solid #e2e8f0;
    }
    .table tbody tr { transition: background .15s; }
    .table tbody tr:hover { background: #f8faff; }
    .table tbody td { padding: 14px 16px; vertical-align: middle; font-size: 14px; border-bottom: 1px solid #f1f5f9; }

    /* ── Paper ID ── */
    .paper-id {
        font-family: monospace;
        font-size: 13px;
        font-weight: 700;
        color: var(--blue);
        background: #eff6ff;
        padding: 3px 8px;
        border-radius: 5px;
        white-space: nowrap;
    }

    /* ── Review Progress Dots ── */
    .review-dots { display: flex; gap: 6px; align-items: center; }
    .rdot {
        width: 28px; height: 28px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 11px; font-weight: 700;
        cursor: default;
        position: relative;
    }
    .rdot.done  { background: #d1fae5; color: #065f46; border: 2px solid #86efac; }
    .rdot.pend  { background: #f1f5f9; color: #94a3b8; border: 2px solid #e2e8f0; }
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

    /* ── Status Badge ── */
    .sbadge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .04em;
    }
    .sbadge-awaiting { background: #fef3c7; color: #92400e; }
    .sbadge-approved  { background: #d1fae5; color: #065f46; }
    .sbadge-rejected  { background: #fee2e2; color: #991b1b; }

    /* ── Action Button ── */
    .btn-review-paper {
        background: linear-gradient(135deg, var(--blue) 0%, #2563eb 100%);
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
    .btn-review-paper:hover { color: white; opacity: .88; transform: translateY(-1px); }

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

    /* ── Score Pill ── */
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

    /* ── Sub-theme tag ── */
    .subtheme-tag {
        font-size: 11px;
        background: #eff6ff;
        color: #1e40af;
        border-radius: 5px;
        padding: 2px 8px;
        font-weight: 600;
    }

    /* ── Empty state ── */
    .empty-state {
        text-align: center;
        padding: 70px 20px;
        color: #94a3b8;
    }
    .empty-state i { font-size: 64px; margin-bottom: 18px; display: block; opacity: .35; }
    .empty-state h4 { color: #475569; font-size: 20px; margin-bottom: 8px; }
</style>
@endsection

@section('content')

{{-- Page Hero --}}
<div class="page-hero">
    <h2><i class="fas fa-clipboard-list me-2"></i>Fully Reviewed Papers</h2>
    <p>Papers that have completed all three reviews (Expert + Peer Reviewer 1 + Peer Reviewer 2) and are ready for your final decision.</p>
</div>

{{-- Stats --}}
<div class="stats-grid">
    <div class="stat-tile t-total">
        <div class="stat-icon"><i class="fas fa-layer-group"></i></div>
        <div class="stat-info"><h3>8</h3><p>Total Ready</p></div>
    </div>
    <div class="stat-tile t-pending">
        <div class="stat-icon"><i class="fas fa-hourglass-half"></i></div>
        <div class="stat-info"><h3>5</h3><p>Awaiting Decision</p></div>
    </div>
    <div class="stat-tile t-approve">
        <div class="stat-icon"><i class="fas fa-check-double"></i></div>
        <div class="stat-info"><h3>2</h3><p>Approved</p></div>
    </div>
    <div class="stat-tile t-reject">
        <div class="stat-icon"><i class="fas fa-times-circle"></i></div>
        <div class="stat-info"><h3>1</h3><p>Rejected</p></div>
    </div>
</div>

{{-- Filter Bar --}}
<div class="filter-bar">
    <div class="flex-grow-1" style="min-width:220px">
        <div class="input-group">
            <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
            <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Search paper title or author…">
        </div>
    </div>
    <select id="statusFilter" class="form-select" style="width:180px">
        <option value="">All Statuses</option>
        <option value="awaiting">Awaiting Decision</option>
        <option value="approved">Approved</option>
        <option value="rejected">Rejected</option>
    </select>
    <select id="subthemeFilter" class="form-select" style="width:200px">
        <option value="">All Sub-Themes</option>
        <option>Water &amp; Agriculture</option>
        <option>Soil Health</option>
        <option>Crop Improvement</option>
        <option>Climate Adaptation</option>
    </select>
</div>

{{-- Papers Table --}}
<div class="table-card">
    <div class="table-card-header">
        <h5><i class="fas fa-table me-2 text-primary"></i>Papers Ready for Final Decision</h5>
        <span class="badge bg-primary">8 papers</span>
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
                    <th>Last Review</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

                {{-- ── Row 1 ── --}}
                <tr data-status="awaiting" data-subtheme="Water &amp; Agriculture">
                    <td><span class="paper-id">FP-0001</span></td>
                    <td>
                        <div class="fw-semibold text-dark" style="max-width:280px;line-height:1.4">
                            Sustainable Water Management Techniques for Crop Production
                        </div>
                        <small class="text-muted">Dr. Mary Wanjiru</small>
                    </td>
                    <td><span class="subtheme-tag">Water &amp; Agriculture</span></td>
                    <td class="text-center">
                        <div class="review-dots justify-content-center">
                            <div class="rdot done"><i class="fas fa-check"></i>
                                <span class="rtip">Expert Reviewer · Prof. Otieno · 82/100</span></div>
                            <div class="rdot done"><i class="fas fa-check"></i>
                                <span class="rtip">Peer Reviewer 1 · Dr. Mwangi · 75/100</span></div>
                            <div class="rdot done"><i class="fas fa-check"></i>
                                <span class="rtip">Peer Reviewer 2 · Dr. Njeri · 77/100</span></div>
                        </div>
                    </td>
                    <td class="text-center"><span class="score-pill">78/100</span></td>
                    <td><span class="sbadge sbadge-awaiting">Awaiting Decision</span></td>
                    <td class="text-muted" style="font-size:13px">Feb 22, 2026</td>
                    <td>
                        <a href="{{ url('/reviewer/fullpapers/1/all-reviews') }}" class="btn-review-paper">
                            <i class="fas fa-eye"></i> View Reviews
                        </a>
                    </td>
                </tr>

                {{-- ── Row 2 ── --}}
                <tr data-status="awaiting" data-subtheme="Soil Health">
                    <td><span class="paper-id">FP-0002</span></td>
                    <td>
                        <div class="fw-semibold text-dark" style="max-width:280px;line-height:1.4">
                            Biochar Applications in Degraded Soil Restoration
                        </div>
                        <small class="text-muted">Prof. James Kamau</small>
                    </td>
                    <td><span class="subtheme-tag">Soil Health</span></td>
                    <td class="text-center">
                        <div class="review-dots justify-content-center">
                            <div class="rdot done"><i class="fas fa-check"></i>
                                <span class="rtip">Expert Reviewer · Dr. Achieng · 88/100</span></div>
                            <div class="rdot done"><i class="fas fa-check"></i>
                                <span class="rtip">Peer Reviewer 1 · Dr. Koech · 80/100</span></div>
                            <div class="rdot done"><i class="fas fa-check"></i>
                                <span class="rtip">Peer Reviewer 2 · Ms. Odhiambo · 84/100</span></div>
                        </div>
                    </td>
                    <td class="text-center"><span class="score-pill">84/100</span></td>
                    <td><span class="sbadge sbadge-awaiting">Awaiting Decision</span></td>
                    <td class="text-muted" style="font-size:13px">Feb 20, 2026</td>
                    <td>
                        <a href="{{ url('/reviewer/fullpapers/2/all-reviews') }}" class="btn-review-paper">
                            <i class="fas fa-eye"></i> View Reviews
                        </a>
                    </td>
                </tr>

                {{-- ── Row 3 ── --}}
                <tr data-status="approved" data-subtheme="Crop Improvement">
                    <td><span class="paper-id">FP-0003</span></td>
                    <td>
                        <div class="fw-semibold text-dark" style="max-width:280px;line-height:1.4">
                            Genomic Selection in Maize Breeding for Drought Tolerance
                        </div>
                        <small class="text-muted">Dr. Alice Muthoni</small>
                    </td>
                    <td><span class="subtheme-tag">Crop Improvement</span></td>
                    <td class="text-center">
                        <div class="review-dots justify-content-center">
                            <div class="rdot done"><i class="fas fa-check"></i>
                                <span class="rtip">Expert Reviewer · Prof. Oloo · 91/100</span></div>
                            <div class="rdot done"><i class="fas fa-check"></i>
                                <span class="rtip">Peer Reviewer 1 · Dr. Mutua · 87/100</span></div>
                            <div class="rdot done"><i class="fas fa-check"></i>
                                <span class="rtip">Peer Reviewer 2 · Dr. Wamae · 89/100</span></div>
                        </div>
                    </td>
                    <td class="text-center"><span class="score-pill">89/100</span></td>
                    <td><span class="sbadge sbadge-approved">Approved</span></td>
                    <td class="text-muted" style="font-size:13px">Feb 18, 2026</td>
                    <td>
                        <a href="{{ url('/reviewer/fullpapers/3/all-reviews') }}" class="btn-view-decision">
                            <i class="fas fa-check-circle"></i> View Decision
                        </a>
                    </td>
                </tr>

                {{-- ── Row 4 ── --}}
                <tr data-status="rejected" data-subtheme="Climate Adaptation">
                    <td><span class="paper-id">FP-0004</span></td>
                    <td>
                        <div class="fw-semibold text-dark" style="max-width:280px;line-height:1.4">
                            Climate-Smart Agriculture Practices in Semi-Arid Kenya
                        </div>
                        <small class="text-muted">Mr. Brian Oduya</small>
                    </td>
                    <td><span class="subtheme-tag">Climate Adaptation</span></td>
                    <td class="text-center">
                        <div class="review-dots justify-content-center">
                            <div class="rdot done"><i class="fas fa-check"></i>
                                <span class="rtip">Expert Reviewer · Prof. Njega · 51/100</span></div>
                            <div class="rdot done"><i class="fas fa-check"></i>
                                <span class="rtip">Peer Reviewer 1 · Dr. Tanui · 48/100</span></div>
                            <div class="rdot done"><i class="fas fa-check"></i>
                                <span class="rtip">Peer Reviewer 2 · Dr. Wekesa · 54/100</span></div>
                        </div>
                    </td>
                    <td class="text-center"><span class="score-pill low">51/100</span></td>
                    <td><span class="sbadge sbadge-rejected">Rejected</span></td>
                    <td class="text-muted" style="font-size:13px">Feb 17, 2026</td>
                    <td>
                        <a href="{{ url('/reviewer/fullpapers/4/all-reviews') }}" class="btn-view-decision" style="color:#dc2626;border-color:#dc2626">
                            <i class="fas fa-times-circle"></i> View Decision
                        </a>
                    </td>
                </tr>

                {{-- ── Row 5 ── --}}
                <tr data-status="awaiting" data-subtheme="Soil Health">
                    <td><span class="paper-id">FP-0005</span></td>
                    <td>
                        <div class="fw-semibold text-dark" style="max-width:280px;line-height:1.4">
                            Nitrogen Fixation Efficiency of Legume Cover Crops in Western Kenya
                        </div>
                        <small class="text-muted">Dr. Rachel Simiyu</small>
                    </td>
                    <td><span class="subtheme-tag">Soil Health</span></td>
                    <td class="text-center">
                        <div class="review-dots justify-content-center">
                            <div class="rdot done"><i class="fas fa-check"></i>
                                <span class="rtip">Expert Reviewer · Dr. Kirui · 73/100</span></div>
                            <div class="rdot done"><i class="fas fa-check"></i>
                                <span class="rtip">Peer Reviewer 1 · Ms. Chebet · 70/100</span></div>
                            <div class="rdot done"><i class="fas fa-check"></i>
                                <span class="rtip">Peer Reviewer 2 · Dr. Nderitu · 68/100</span></div>
                        </div>
                    </td>
                    <td class="text-center"><span class="score-pill mid">70/100</span></td>
                    <td><span class="sbadge sbadge-awaiting">Awaiting Decision</span></td>
                    <td class="text-muted" style="font-size:13px">Feb 24, 2026</td>
                    <td>
                        <a href="{{ url('/reviewer/fullpapers/5/all-reviews') }}" class="btn-review-paper">
                            <i class="fas fa-eye"></i> View Reviews
                        </a>
                    </td>
                </tr>

                {{-- ── Row 6 ── --}}
                <tr data-status="awaiting" data-subtheme="Water &amp; Agriculture">
                    <td><span class="paper-id">FP-0006</span></td>
                    <td>
                        <div class="fw-semibold text-dark" style="max-width:280px;line-height:1.4">
                            Rainwater Harvesting Innovations for Smallholder Farmers
                        </div>
                        <small class="text-muted">Eng. Samuel Ndegwa</small>
                    </td>
                    <td><span class="subtheme-tag">Water &amp; Agriculture</span></td>
                    <td class="text-center">
                        <div class="review-dots justify-content-center">
                            <div class="rdot done"><i class="fas fa-check"></i>
                                <span class="rtip">Expert Reviewer · Prof. Kariuki · 79/100</span></div>
                            <div class="rdot done"><i class="fas fa-check"></i>
                                <span class="rtip">Peer Reviewer 1 · Dr. Oginga · 76/100</span></div>
                            <div class="rdot done"><i class="fas fa-check"></i>
                                <span class="rtip">Peer Reviewer 2 · Dr. Maina · 81/100</span></div>
                        </div>
                    </td>
                    <td class="text-center"><span class="score-pill">79/100</span></td>
                    <td><span class="sbadge sbadge-awaiting">Awaiting Decision</span></td>
                    <td class="text-muted" style="font-size:13px">Feb 23, 2026</td>
                    <td>
                        <a href="{{ url('/reviewer/fullpapers/6/all-reviews') }}" class="btn-review-paper">
                            <i class="fas fa-eye"></i> View Reviews
                        </a>
                    </td>
                </tr>

                {{-- ── Row 7 ── --}}
                <tr data-status="awaiting" data-subtheme="Crop Improvement">
                    <td><span class="paper-id">FP-0007</span></td>
                    <td>
                        <div class="fw-semibold text-dark" style="max-width:280px;line-height:1.4">
                            Integrated Pest Management for Tomato Production in Smallholder Systems
                        </div>
                        <small class="text-muted">Dr. Grace Adhiambo</small>
                    </td>
                    <td><span class="subtheme-tag">Crop Improvement</span></td>
                    <td class="text-center">
                        <div class="review-dots justify-content-center">
                            <div class="rdot done"><i class="fas fa-check"></i>
                                <span class="rtip">Expert Reviewer · Dr. Mwenda · 85/100</span></div>
                            <div class="rdot done"><i class="fas fa-check"></i>
                                <span class="rtip">Peer Reviewer 1 · Mr. Kioni · 82/100</span></div>
                            <div class="rdot done"><i class="fas fa-check"></i>
                                <span class="rtip">Peer Reviewer 2 · Dr. Onyango · 80/100</span></div>
                        </div>
                    </td>
                    <td class="text-center"><span class="score-pill">82/100</span></td>
                    <td><span class="sbadge sbadge-awaiting">Awaiting Decision</span></td>
                    <td class="text-muted" style="font-size:13px">Feb 25, 2026</td>
                    <td>
                        <a href="{{ url('/reviewer/fullpapers/7/all-reviews') }}" class="btn-review-paper">
                            <i class="fas fa-eye"></i> View Reviews
                        </a>
                    </td>
                </tr>

                {{-- ── Row 8 ── --}}
                <tr data-status="approved" data-subtheme="Climate Adaptation">
                    <td><span class="paper-id">FP-0008</span></td>
                    <td>
                        <div class="fw-semibold text-dark" style="max-width:280px;line-height:1.4">
                            Digital Tools for Real-Time Crop Monitoring and Advisory Systems
                        </div>
                        <small class="text-muted">Ms. Faith Kibet</small>
                    </td>
                    <td><span class="subtheme-tag">Climate Adaptation</span></td>
                    <td class="text-center">
                        <div class="review-dots justify-content-center">
                            <div class="rdot done"><i class="fas fa-check"></i>
                                <span class="rtip">Expert Reviewer · Prof. Muiruri · 90/100</span></div>
                            <div class="rdot done"><i class="fas fa-check"></i>
                                <span class="rtip">Peer Reviewer 1 · Dr. Barasa · 88/100</span></div>
                            <div class="rdot done"><i class="fas fa-check"></i>
                                <span class="rtip">Peer Reviewer 2 · Dr. Chege · 92/100</span></div>
                        </div>
                    </td>
                    <td class="text-center"><span class="score-pill">90/100</span></td>
                    <td><span class="sbadge sbadge-approved">Approved</span></td>
                    <td class="text-muted" style="font-size:13px">Feb 16, 2026</td>
                    <td>
                        <a href="{{ url('/reviewer/fullpapers/8/all-reviews') }}" class="btn-view-decision">
                            <i class="fas fa-check-circle"></i> View Decision
                        </a>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
    <div id="emptyMsg" class="empty-state" style="display:none">
        <i class="fas fa-search"></i>
        <h4>No papers match your search</h4>
        <p>Try adjusting your filters</p>
    </div>
</div>

{{-- Info tip --}}
<div class="alert alert-info d-flex gap-3 align-items-start mt-4" style="border-radius:12px">
    <i class="fas fa-lightbulb fa-lg mt-1 flex-shrink-0"></i>
    <div>
        <strong>Tip:</strong> Hover over the review dots <span class="rdot done d-inline-flex" style="width:20px;height:20px;font-size:10px;vertical-align:middle;cursor:default"><i class="fas fa-check"></i></span>
        to quickly see the reviewer name and score without opening the full detail page.
        Click <strong>"View Reviews"</strong> to read each reviewer's full comments and submit your decision.
    </div>
</div>

@endsection

@section('scripts')
<script>
(function() {
    const searchInput   = document.getElementById('searchInput');
    const statusFilter  = document.getElementById('statusFilter');
    const subthemeFilter = document.getElementById('subthemeFilter');
    const tbody = document.querySelector('#papersTable tbody');
    const emptyMsg = document.getElementById('emptyMsg');

    function applyFilters() {
        const q   = searchInput.value.toLowerCase();
        const st  = statusFilter.value.toLowerCase();
        const sub = subthemeFilter.value.toLowerCase();
        let visible = 0;

        tbody.querySelectorAll('tr').forEach(row => {
            const text    = row.textContent.toLowerCase();
            const rowSt   = (row.dataset.status || '').toLowerCase();
            const rowSub  = (row.dataset.subtheme || '').toLowerCase();

            const matchQ   = !q   || text.includes(q);
            const matchSt  = !st  || rowSt.includes(st);
            const matchSub = !sub || rowSub.includes(sub.toLowerCase());

            const show = matchQ && matchSt && matchSub;
            row.style.display = show ? '' : 'none';
            if (show) visible++;
        });

        emptyMsg.style.display = visible === 0 ? 'block' : 'none';
    }

    searchInput.addEventListener('input', applyFilters);
    statusFilter.addEventListener('change', applyFilters);
    subthemeFilter.addEventListener('change', applyFilters);
})();
</script>
@endsection
