@extends('reviewer.layout')

@section('title', 'Paper Reviews Detail')
@section('page-title', 'Paper Reviews Detail')

@section('styles')
<style>
    :root {
        --blue: #1e5a96;
        --dark-blue: #143d66;
        --green: #16a34a;
        --amber: #d97706;
        --red: #dc2626;
        --expert-color: #7c3aed;
        --peer1-color: #0891b2;
        --peer2-color: #0d9488;
    }

    /* ── Sticky jump nav ── */
    .jump-nav {
        position: sticky;
        top: 64px;
        z-index: 200;
        background: white;
        border-radius: 12px;
        padding: 14px 22px;
        box-shadow: 0 4px 16px rgba(0,0,0,.10);
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 28px;
        border-left: 4px solid var(--blue);
    }
    .jump-nav span { font-size: 13px; font-weight: 700; color: #475569; margin-right: 4px; }
    .jump-btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 7px 16px;
        border-radius: 30px;
        font-size: 13px; font-weight: 600;
        text-decoration: none;
        border: 2px solid;
        transition: all .2s;
    }
    .jump-btn.expert  { border-color: var(--expert-color); color: var(--expert-color); }
    .jump-btn.expert:hover  { background: var(--expert-color); color: white; }
    .jump-btn.peer1   { border-color: var(--peer1-color);  color: var(--peer1-color); }
    .jump-btn.peer1:hover   { background: var(--peer1-color);  color: white; }
    .jump-btn.peer2   { border-color: var(--peer2-color);  color: var(--peer2-color); }
    .jump-btn.peer2:hover   { background: var(--peer2-color);  color: white; }
    .jump-btn.decision{ border-color: var(--amber); color: var(--amber); }
    .jump-btn.decision:hover{ background: var(--amber); color: white; }
    .jump-nav .ms-auto { margin-left: auto; }

    /* ── Paper Info Banner ── */
    .paper-banner {
        background: linear-gradient(135deg, var(--dark-blue) 0%, var(--blue) 100%);
        border-radius: 14px;
        padding: 28px 32px;
        color: white;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
    }
    .paper-banner::after {
        content: '\f15b';
        font-family: 'Font Awesome 6 Free'; font-weight: 900;
        position: absolute; right: 30px; top: 50%; transform: translateY(-50%);
        font-size: 110px; opacity: .07;
    }
    .paper-banner h3 { font-weight: 700; margin-bottom: 14px; font-size: 20px; line-height: 1.4; }
    .paper-meta-grid { display: flex; flex-wrap: wrap; gap: 20px; }
    .paper-meta-item { display: flex; align-items: center; gap: 8px; font-size: 14px; }
    .paper-meta-item i { opacity: .75; width: 16px; }
    .paper-meta-item strong { opacity: .85; }

    .download-btn {
        display: inline-flex; align-items: center; gap: 7px;
        background: rgba(255,255,255,.15);
        border: 1.5px solid rgba(255,255,255,.4);
        color: white; padding: 8px 18px; border-radius: 8px;
        font-size: 13px; font-weight: 600; text-decoration: none;
        transition: background .2s;
        backdrop-filter: blur(4px);
    }
    .download-btn:hover { background: rgba(255,255,255,.25); color: white; }

    /* ── Summary Card ── */
    .summary-card {
        background: white;
        border-radius: 14px;
        box-shadow: 0 2px 12px rgba(0,0,0,.07);
        padding: 26px 28px;
        margin-bottom: 28px;
    }
    .summary-card h5 { font-weight: 700; margin-bottom: 20px; color: #1e293b; }
    .summary-score-big {
        font-size: 60px; font-weight: 800; line-height: 1;
        background: linear-gradient(135deg, #16a34a, #059669);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    }
    .summary-score-big.mid {
        background: linear-gradient(135deg, #d97706, #b45309);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    }
    .summary-score-big.low {
        background: linear-gradient(135deg, #dc2626, #991b1b);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    }
    .rec-stat { text-align: center; padding: 12px 0; }
    .rec-stat .num { font-size: 28px; font-weight: 800; line-height: 1; }
    .rec-stat .lbl { font-size: 11px; text-transform: uppercase; color: #64748b; letter-spacing: .06em; margin-top: 3px; }

    /* reviewer dot in summary */
    .rev-chip {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 6px 14px;
        border-radius: 30px;
        font-size: 13px; font-weight: 600;
        margin: 4px;
        text-decoration: none;
    }
    .rev-chip.expert { background: #f5f3ff; color: var(--expert-color); border: 1.5px solid #c4b5fd; }
    .rev-chip.peer1  { background: #e0f2fe; color: var(--peer1-color);  border: 1.5px solid #7dd3fc; }
    .rev-chip.peer2  { background: #ccfbf1; color: var(--peer2-color);  border: 1.5px solid #5eead4; }

    /* ── Review Section Card ── */
    .review-section {
        background: white;
        border-radius: 14px;
        box-shadow: 0 2px 12px rgba(0,0,0,.07);
        overflow: hidden;
        margin-bottom: 28px;
        scroll-margin-top: 120px;
    }
    .review-section-header {
        padding: 20px 26px;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }
    .review-section-header.expert { background: linear-gradient(135deg, #7c3aed, #6d28d9); }
    .review-section-header.peer1  { background: linear-gradient(135deg, #0891b2, #0e7490); }
    .review-section-header.peer2  { background: linear-gradient(135deg, #0d9488, #0f766e); }

    .reviewer-role-badge {
        background: rgba(255,255,255,.2);
        border: 1px solid rgba(255,255,255,.35);
        color: white;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .06em;
    }
    .reviewer-score-large {
        font-size: 36px;
        font-weight: 800;
        color: white;
        line-height: 1;
    }
    .reviewer-score-large small { font-size: 18px; opacity: .7; }

    .review-body { padding: 26px 28px; }

    /* ── Section Scores Table ── */
    .scores-table { width: 100%; border-collapse: collapse; }
    .scores-table tr:last-child td { border-bottom: none; }
    .scores-table td { padding: 9px 0; border-bottom: 1px dashed #f1f5f9; font-size: 14px; }
    .scores-table td:first-child { color: #475569; }
    .scores-table td:last-child { text-align: right; font-weight: 700; color: #1e293b; }
    .score-bar-wrap { width: 120px; height: 6px; background: #e2e8f0; border-radius: 3px; display: inline-block; vertical-align: middle; margin: 0 10px; }
    .score-bar-fill { height: 100%; border-radius: 3px; background: linear-gradient(90deg,#3b82f6,#06b6d4); }

    /* ── Recommendation Badge ── */
    .rec-badge {
        display: inline-block;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .05em;
    }
    .rec-accept { background: #d1fae5; color: #065f46; }
    .rec-minor  { background: #fef3c7; color: #92400e; }
    .rec-major  { background: #fed7aa; color: #9a3412; }
    .rec-reject { background: #fee2e2; color: #991b1b; }

    /* ── Comments Box ── */
    .comment-box {
        background: #f8fafc;
        border-left: 4px solid;
        border-radius: 0 8px 8px 0;
        padding: 16px 20px;
        font-size: 14px;
        line-height: 1.7;
        color: #334155;
    }
    .comment-box.expert-border { border-left-color: var(--expert-color); }
    .comment-box.peer1-border  { border-left-color: var(--peer1-color); }
    .comment-box.peer2-border  { border-left-color: var(--peer2-color); }

    /* ── Section label ── */
    .section-label {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .08em;
        font-weight: 700;
        color: #94a3b8;
        margin-bottom: 8px;
    }

    /* ── Decision Card ── */
    .decision-card {
        background: white;
        border-radius: 14px;
        box-shadow: 0 2px 12px rgba(0,0,0,.07);
        overflow: hidden;
        scroll-margin-top: 120px;
    }
    .decision-header {
        background: linear-gradient(135deg, #d97706, #b45309);
        color: white;
        padding: 20px 26px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .decision-header h5 { margin: 0; font-weight: 700; font-size: 17px; }
    .decision-body { padding: 28px; }

    .decision-option {
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 18px 20px;
        cursor: pointer;
        transition: all .2s;
    }
    .decision-option:hover { border-color: #94a3b8; background: #f8fafc; }
    .decision-option.approve:has(input:checked)  { border-color: var(--green); background: #f0fdf4; }
    .decision-option.reject:has(input:checked)   { border-color: var(--red);   background: #fff1f2; }
    .decision-option input[type=radio] { width: 18px; height: 18px; }
    .decision-option label { cursor: pointer; }

    .submit-btn {
        background: linear-gradient(135deg, #d97706, #b45309);
        color: white; border: none;
        padding: 13px 32px;
        border-radius: 10px;
        font-size: 15px; font-weight: 700;
        display: inline-flex; align-items: center; gap: 8px;
        transition: opacity .2s, transform .15s;
    }
    .submit-btn:hover { opacity: .88; transform: translateY(-1px); color: white; }

    /* ── Already decided banner ── */
    .decided-banner {
        padding: 20px 24px;
        border-radius: 12px;
        display: flex; align-items: center; gap: 16px;
        margin-bottom: 0;
    }
    .decided-banner.approved { background: #d1fae5; color: #065f46; }
    .decided-banner.rejected { background: #fee2e2; color: #991b1b; }
    .decided-banner i { font-size: 32px; }

</style>
@endsection

@section('content')

{{-- Breadcrumb --}}
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ url('/reviewer/fullpapers-completed') }}">Fully Reviewed Papers</a>
        </li>
        <li class="breadcrumb-item active">FP-0001 · All Reviews</li>
    </ol>
</nav>

{{-- ══ STICKY JUMP NAV ══ --}}
<div class="jump-nav">
    <span><i class="fas fa-bolt me-1"></i>Jump to:</span>
    <a href="#expert-review"  class="jump-btn expert"><i class="fas fa-star"></i> Expert Reviewer</a>
    <a href="#peer1-review"   class="jump-btn peer1"><i class="fas fa-user-check"></i> Peer Reviewer 1</a>
    <a href="#peer2-review"   class="jump-btn peer2"><i class="fas fa-user-check"></i> Peer Reviewer 2</a>
    <a href="#decision-panel" class="jump-btn decision ms-auto"><i class="fas fa-gavel"></i> Make Decision</a>
</div>

{{-- ══ PAPER BANNER ══ --}}
<div class="paper-banner mb-4">
    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
        <div style="max-width:680px">
            <div class="mb-2">
                <span style="background:rgba(255,255,255,.15);border-radius:5px;padding:3px 10px;font-size:12px;font-weight:700;letter-spacing:.06em">FP-0001</span>
            </div>
            <h3>Sustainable Water Management Techniques for Crop Production</h3>
            <div class="paper-meta-grid">
                <div class="paper-meta-item"><i class="fas fa-user"></i><span><strong>Author:</strong> Dr. Mary Wanjiru</span></div>
                <div class="paper-meta-item"><i class="fas fa-envelope"></i><span><strong>Email:</strong> m.wanjiru@example.com</span></div>
                <div class="paper-meta-item"><i class="fas fa-tag"></i><span><strong>Sub-Theme:</strong> Water &amp; Agriculture</span></div>
                <div class="paper-meta-item"><i class="fas fa-calendar"></i><span><strong>Submitted:</strong> Jan 14, 2026</span></div>
            </div>
        </div>
        <div class="d-flex flex-column gap-2">
            <a href="#" onclick="alert('Paper download would start')" class="download-btn">
                <i class="fas fa-file-pdf"></i> Download Full Paper
            </a>
            <a href="#" onclick="alert('Presentation download would start')" class="download-btn">
                <i class="fas fa-file-powerpoint"></i> Download Slides
            </a>
        </div>
    </div>
</div>

{{-- ══ REVIEW SUMMARY ══ --}}
<div class="summary-card">
    <h5><i class="fas fa-chart-pie me-2 text-primary"></i>Review Summary</h5>
    <div class="row align-items-center">
        <div class="col-md-3 text-center mb-3 mb-md-0">
            <div class="summary-score-big">78</div>
            <div style="font-size:15px;color:#64748b;margin-top:4px">Avg. Score <span style="font-size:12px">/ 100</span></div>
            <div class="progress mt-2" style="height:8px;border-radius:4px">
                <div class="progress-bar bg-success" style="width:78%"></div>
            </div>
        </div>
        <div class="col-md-5 mb-3 mb-md-0">
            <div class="row text-center">
                <div class="col-3"><div class="rec-stat"><div class="num text-success">2</div><div class="lbl">Accept</div></div></div>
                <div class="col-3"><div class="rec-stat"><div class="num text-warning">1</div><div class="lbl">Minor Rev.</div></div></div>
                <div class="col-3"><div class="rec-stat"><div class="num text-orange" style="color:#ea580c">0</div><div class="lbl">Major Rev.</div></div></div>
                <div class="col-3"><div class="rec-stat"><div class="num text-danger">0</div><div class="lbl">Reject</div></div></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="section-label">Reviewers</div>
            <div>
                <a href="#expert-review" class="rev-chip expert"><i class="fas fa-star"></i> Prof. M. Otieno · 82</a>
                <a href="#peer1-review"  class="rev-chip peer1"><i class="fas fa-user-check"></i> Dr. P. Mwangi · 75</a>
                <a href="#peer2-review"  class="rev-chip peer2"><i class="fas fa-user-check"></i> Dr. S. Njeri · 77</a>
            </div>
        </div>
    </div>
</div>

{{-- ══ EXPERT REVIEWER ══ --}}
<div class="review-section" id="expert-review">
    <div class="review-section-header expert">
        <div>
            <div class="d-flex align-items-center gap-10 flex-wrap gap-2">
                <span class="reviewer-role-badge">Expert Reviewer</span>
            </div>
            <div class="mt-2">
                <h5 class="mb-0 fw-bold">Prof. Michael Otieno</h5>
                <small style="opacity:.8">Senior Research Scientist, KALRO Headquaters &nbsp;·&nbsp; Submitted Feb 20, 2026</small>
            </div>
        </div>
        <div class="text-end">
            <div class="reviewer-score-large">82<small>/100</small></div>
            <div style="font-size:12px;opacity:.75;margin-top:4px">Overall Score</div>
        </div>
    </div>

    <div class="review-body">
        <div class="row">
            {{-- Section Scores --}}
            <div class="col-md-6 mb-4 mb-md-0">
                <div class="section-label">Section Scores</div>
                <table class="scores-table">
                    <tr>
                        <td>Title</td>
                        <td><div class="score-bar-wrap"><div class="score-bar-fill" style="width:100%"></div></div></td>
                        <td>5 / 5</td>
                    </tr>
                    <tr>
                        <td>Abstract</td>
                        <td><div class="score-bar-wrap"><div class="score-bar-fill" style="width:80%"></div></div></td>
                        <td>4 / 5</td>
                    </tr>
                    <tr>
                        <td>Introduction</td>
                        <td><div class="score-bar-wrap"><div class="score-bar-fill" style="width:80%"></div></div></td>
                        <td>8 / 10</td>
                    </tr>
                    <tr>
                        <td>Methodology</td>
                        <td><div class="score-bar-wrap"><div class="score-bar-fill" style="width:80%"></div></div></td>
                        <td>20 / 25</td>
                    </tr>
                    <tr>
                        <td>Results</td>
                        <td><div class="score-bar-wrap"><div class="score-bar-fill" style="width:84%"></div></div></td>
                        <td>21 / 25</td>
                    </tr>
                    <tr>
                        <td>Discussion</td>
                        <td><div class="score-bar-wrap"><div class="score-bar-fill" style="width:87%"></div></div></td>
                        <td>13 / 15</td>
                    </tr>
                    <tr>
                        <td>Conclusions</td>
                        <td><div class="score-bar-wrap"><div class="score-bar-fill" style="width:80%"></div></div></td>
                        <td>8 / 10</td>
                    </tr>
                    <tr>
                        <td>References</td>
                        <td><div class="score-bar-wrap"><div class="score-bar-fill" style="width:60%"></div></div></td>
                        <td>3 / 5</td>
                    </tr>
                </table>
            </div>
            {{-- Recommendation & Comments --}}
            <div class="col-md-6">
                <div class="mb-4">
                    <div class="section-label">Recommendation</div>
                    <span class="rec-badge rec-accept">Accept</span>
                    <span class="ms-3 text-muted" style="font-size:13px"><i class="fas fa-microphone me-1"></i>Oral Presentation</span>
                </div>
                <div class="mb-4">
                    <div class="section-label">Strengths</div>
                    <div class="comment-box expert-border">
                        The paper demonstrates a robust experimental design with clearly defined control and treatment plots. Data collection protocols are well-documented and replicable. The comparative analysis between traditional and modern irrigation techniques adds significant value.
                    </div>
                </div>
                <div>
                    <div class="section-label">Overall Comments &amp; Suggestions</div>
                    <div class="comment-box expert-border">
                        This is a well-researched paper that addresses critical water management issues in agricultural settings. The methodology is sound and the results are clearly presented. The authors should strengthen the references section by including more recent literature (post-2022). The conclusions could also be more specific in quantifying the water savings achieved.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ══ PEER REVIEWER 1 ══ --}}
<div class="review-section" id="peer1-review">
    <div class="review-section-header peer1">
        <div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <span class="reviewer-role-badge">Peer Reviewer 1</span>
            </div>
            <div class="mt-2">
                <h5 class="mb-0 fw-bold">Dr. Peter Mwangi</h5>
                <small style="opacity:.8">Researcher, University of Nairobi &nbsp;·&nbsp; Submitted Feb 21, 2026</small>
            </div>
        </div>
        <div class="text-end">
            <div class="reviewer-score-large">75<small>/100</small></div>
            <div style="font-size:12px;opacity:.75;margin-top:4px">Overall Score</div>
        </div>
    </div>

    <div class="review-body">
        <div class="row">
            <div class="col-md-6 mb-4 mb-md-0">
                <div class="section-label">Section Scores</div>
                <table class="scores-table">
                    <tr>
                        <td>Title</td>
                        <td><div class="score-bar-wrap"><div class="score-bar-fill" style="width:80%"></div></div></td>
                        <td>4 / 5</td>
                    </tr>
                    <tr>
                        <td>Abstract</td>
                        <td><div class="score-bar-wrap"><div class="score-bar-fill" style="width:80%"></div></div></td>
                        <td>4 / 5</td>
                    </tr>
                    <tr>
                        <td>Introduction</td>
                        <td><div class="score-bar-wrap"><div class="score-bar-fill" style="width:70%"></div></div></td>
                        <td>7 / 10</td>
                    </tr>
                    <tr>
                        <td>Methodology</td>
                        <td><div class="score-bar-wrap"><div class="score-bar-fill" style="width:72%"></div></div></td>
                        <td>18 / 25</td>
                    </tr>
                    <tr>
                        <td>Results</td>
                        <td><div class="score-bar-wrap"><div class="score-bar-fill" style="width:76%"></div></div></td>
                        <td>19 / 25</td>
                    </tr>
                    <tr>
                        <td>Discussion</td>
                        <td><div class="score-bar-wrap"><div class="score-bar-fill" style="width:80%"></div></div></td>
                        <td>12 / 15</td>
                    </tr>
                    <tr>
                        <td>Conclusions</td>
                        <td><div class="score-bar-wrap"><div class="score-bar-fill" style="width:70%"></div></div></td>
                        <td>7 / 10</td>
                    </tr>
                    <tr>
                        <td>References</td>
                        <td><div class="score-bar-wrap"><div class="score-bar-fill" style="width:80%"></div></div></td>
                        <td>4 / 5</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <div class="mb-4">
                    <div class="section-label">Recommendation</div>
                    <span class="rec-badge rec-minor">Needs Minor Revisions</span>
                    <span class="ms-3 text-muted" style="font-size:13px"><i class="fas fa-desktop me-1"></i>Poster Presentation</span>
                </div>
                <div class="mb-4">
                    <div class="section-label">Weaknesses / Areas to Improve</div>
                    <div class="comment-box peer1-border">
                        The methodology section lacks specificity on sample sizes — it is unclear whether the study was adequately powered to detect the observed effects. The statistical analysis would benefit from including confidence intervals alongside p-values.
                    </div>
                </div>
                <div>
                    <div class="section-label">Overall Comments &amp; Suggestions</div>
                    <div class="comment-box peer1-border">
                        Good paper with practical applications in smallholder farming systems. The methodology section could be strengthened with more detail on sample sizes and statistical power. Results are well presented with clear visualizations. The authors should address how their findings compare with similar studies in East Africa.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ══ PEER REVIEWER 2 ══ --}}
<div class="review-section" id="peer2-review">
    <div class="review-section-header peer2">
        <div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <span class="reviewer-role-badge">Peer Reviewer 2</span>
            </div>
            <div class="mt-2">
                <h5 class="mb-0 fw-bold">Dr. Sarah Njeri</h5>
                <small style="opacity:.8">Associate Professor, Egerton University &nbsp;·&nbsp; Submitted Feb 22, 2026</small>
            </div>
        </div>
        <div class="text-end">
            <div class="reviewer-score-large">77<small>/100</small></div>
            <div style="font-size:12px;opacity:.75;margin-top:4px">Overall Score</div>
        </div>
    </div>

    <div class="review-body">
        <div class="row">
            <div class="col-md-6 mb-4 mb-md-0">
                <div class="section-label">Section Scores</div>
                <table class="scores-table">
                    <tr>
                        <td>Title</td>
                        <td><div class="score-bar-wrap"><div class="score-bar-fill" style="width:100%"></div></div></td>
                        <td>5 / 5</td>
                    </tr>
                    <tr>
                        <td>Abstract</td>
                        <td><div class="score-bar-wrap"><div class="score-bar-fill" style="width:80%"></div></div></td>
                        <td>4 / 5</td>
                    </tr>
                    <tr>
                        <td>Introduction</td>
                        <td><div class="score-bar-wrap"><div class="score-bar-fill" style="width:80%"></div></div></td>
                        <td>8 / 10</td>
                    </tr>
                    <tr>
                        <td>Methodology</td>
                        <td><div class="score-bar-wrap"><div class="score-bar-fill" style="width:76%"></div></div></td>
                        <td>19 / 25</td>
                    </tr>
                    <tr>
                        <td>Results</td>
                        <td><div class="score-bar-wrap"><div class="score-bar-fill" style="width:80%"></div></div></td>
                        <td>20 / 25</td>
                    </tr>
                    <tr>
                        <td>Discussion</td>
                        <td><div class="score-bar-wrap"><div class="score-bar-fill" style="width:73%"></div></div></td>
                        <td>11 / 15</td>
                    </tr>
                    <tr>
                        <td>Conclusions</td>
                        <td><div class="score-bar-wrap"><div class="score-bar-fill" style="width:60%"></div></div></td>
                        <td>6 / 10</td>
                    </tr>
                    <tr>
                        <td>References</td>
                        <td><div class="score-bar-wrap"><div class="score-bar-fill" style="width:80%"></div></div></td>
                        <td>4 / 5</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <div class="mb-4">
                    <div class="section-label">Recommendation</div>
                    <span class="rec-badge rec-accept">Accept</span>
                    <span class="ms-3 text-muted" style="font-size:13px"><i class="fas fa-microphone me-1"></i>Oral Presentation</span>
                </div>
                <div class="mb-4">
                    <div class="section-label">Specific Comments on Methods</div>
                    <div class="comment-box peer2-border">
                        The choice of experimental plots is appropriate. However, the description of data collection intervals (daily vs. weekly measurements) is inconsistent between sections 2.3 and 3.1 — this should be reconciled before publication.
                    </div>
                </div>
                <div>
                    <div class="section-label">Overall Comments &amp; Suggestions</div>
                    <div class="comment-box peer2-border">
                        Solid contribution to water management literature with clear practical applications for ASAL regions. The paper demonstrates good data analysis practices and the figures are informative. The conclusion section needs strengthening — it currently does not adequately reflect all results presented. The authors are also advised to include a limitations section.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ══ DECISION PANEL ══ --}}
<div class="decision-card" id="decision-panel">
    <div class="decision-header">
        <i class="fas fa-gavel fa-lg"></i>
        <div>
            <h5>Sub-Theme Leader's Final Decision</h5>
            <small style="opacity:.8">Your decision will be communicated to the author via email</small>
        </div>
    </div>
    <div class="decision-body">

        {{-- DEMO: show form (change to decided-banner once decision submitted) --}}
        <form onsubmit="event.preventDefault(); submitDecision()">

            {{-- Decision Options --}}
            <div class="mb-4">
                <label class="form-label fw-bold mb-3">Your Decision <span class="text-danger">*</span></label>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="decision-option approve" onclick="document.getElementById('opt_approve').click()">
                            <div class="d-flex align-items-center gap-3">
                                <input class="form-check-input" type="radio" name="decision" id="opt_approve" value="approved" required>
                                <label class="form-check-label" for="opt_approve">
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <i class="fas fa-check-circle text-success fa-lg"></i>
                                        <strong class="text-success fs-5">APPROVE</strong>
                                    </div>
                                    <small class="text-muted">Paper is accepted for the conference. Author will be notified and prompted to upload final materials.</small>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="decision-option reject" onclick="document.getElementById('opt_reject').click()">
                            <div class="d-flex align-items-center gap-3">
                                <input class="form-check-input" type="radio" name="decision" id="opt_reject" value="rejected" required>
                                <label class="form-check-label" for="opt_reject">
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <i class="fas fa-times-circle text-danger fa-lg"></i>
                                        <strong class="text-danger fs-5">REJECT</strong>
                                    </div>
                                    <small class="text-muted">Paper is not accepted. Author will receive your comments and reviewers' feedback.</small>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Leader's Comment --}}
            <div class="mb-4">
                <label class="form-label fw-bold" for="leaderComment">
                    Your Comments to the Author <span class="text-danger">*</span>
                </label>
                <textarea id="leaderComment" name="comments" class="form-control" rows="5"
                    placeholder="Summarise the overall assessment based on all three reviewers. Highlight key strengths, areas for improvement, and the rationale for your decision…"
                    required minlength="30"></textarea>
                <div class="d-flex justify-content-between mt-1">
                    <small class="text-muted">Minimum 30 characters. This message will be sent directly to the author.</small>
                    <small id="charCount" class="text-muted">0 chars</small>
                </div>
            </div>

            {{-- What happens next --}}
            <div class="alert alert-info border-0 rounded-3 mb-4" style="background:#eff6ff">
                <div class="d-flex gap-3">
                    <i class="fas fa-info-circle text-primary mt-1"></i>
                    <div>
                        <strong>What happens next?</strong>
                        <ul class="mb-0 mt-1 small">
                            <li><strong>If APPROVED:</strong> Author gets an email with a secure link to upload final presentation materials (PDF / PPTX).</li>
                            <li><strong>If REJECTED:</strong> Author receives your comments and a summary of all three reviewers' feedback.</li>
                            <li>This decision is <strong>final</strong> and cannot be undone. Please review carefully.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-3 flex-wrap align-items-center">
                <button type="submit" class="submit-btn">
                    <i class="fas fa-paper-plane"></i> Submit Decision &amp; Notify Author
                </button>
                <a href="{{ url('/reviewer/fullpapers-completed') }}" class="btn btn-outline-secondary btn-lg">
                    <i class="fas fa-arrow-left me-1"></i> Back to List
                </a>
            </div>
        </form>

    </div>
</div>

@endsection

@section('scripts')
<script>
// Character counter
const ta = document.getElementById('leaderComment');
const cc = document.getElementById('charCount');
if (ta && cc) {
    ta.addEventListener('input', () => {
        cc.textContent = ta.value.length + ' chars';
        cc.style.color = ta.value.length >= 30 ? '#16a34a' : '#94a3b8';
    });
}

// Highlight active decision card on select
document.querySelectorAll('.decision-option').forEach(opt => {
    const radio = opt.querySelector('input[type=radio]');
    if (radio) {
        radio.addEventListener('change', () => {
            document.querySelectorAll('.decision-option').forEach(o => {
                o.style.borderColor = '#e2e8f0';
                o.style.background  = '';
            });
            if (radio.value === 'approved') {
                opt.style.borderColor = '#16a34a';
                opt.style.background  = '#f0fdf4';
            } else {
                opt.style.borderColor = '#dc2626';
                opt.style.background  = '#fff1f2';
            }
        });
    }
});

// Demo submit
function submitDecision() {
    const decision = document.querySelector('input[name=decision]:checked');
    const comment  = document.getElementById('leaderComment').value.trim();
    if (!decision) { alert('Please select a decision.'); return; }
    if (comment.length < 30) { alert('Please provide at least 30 characters of comments.'); return; }

    const verb = decision.value === 'approved' ? 'APPROVED ✅' : 'REJECTED ❌';
    alert(`Decision Submitted!\n\nPaper FP-0001 has been ${verb}.\nDr. Mary Wanjiru has been notified by email.`);
}

// Smooth scroll for jump links
document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
        const target = document.querySelector(a.getAttribute('href'));
        if (target) {
            e.preventDefault();
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});

// Highlight active section on scroll
const sections = ['expert-review','peer1-review','peer2-review','decision-panel'];
const jumpBtns = {
    'expert-review': document.querySelector('.jump-btn.expert'),
    'peer1-review':  document.querySelector('.jump-btn.peer1'),
    'peer2-review':  document.querySelector('.jump-btn.peer2'),
    'decision-panel':document.querySelector('.jump-btn.decision'),
};

window.addEventListener('scroll', () => {
    let current = null;
    sections.forEach(id => {
        const el = document.getElementById(id);
        if (el && el.getBoundingClientRect().top < 160) current = id;
    });
    Object.keys(jumpBtns).forEach(id => {
        const btn = jumpBtns[id];
        if (!btn) return;
        btn.style.opacity = id === current ? '1' : '.65';
        btn.style.fontWeight = id === current ? '800' : '600';
    });
});
</script>
@endsection
