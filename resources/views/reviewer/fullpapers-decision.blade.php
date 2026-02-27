@extends('reviewer.layout')

@section('title', 'Make Final Decision')
@section('page-title', 'Make Final Decision on Full Paper')

@section('content')
<style>
    .review-summary-card {
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        border-left: 5px solid #3b82f6;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 24px;
    }
    .review-card {
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 24px;
        box-shadow: 0 4px 12px rgba(0,0,0,.1);
    }
    .review-header {
        background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
        color: white;
        padding: 16px 20px;
    }
    .review-body {
        padding: 24px;
        background: white;
    }
    .score-display {
        font-size: 48px;
        font-weight: 700;
        color: #16a34a;
    }
    .section-score-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px dashed #e5e7eb;
    }
    .section-score-row:last-child { border-bottom: none; }
    
    .recommendation-badge {
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 13px;
    }
    .rec-accept { background: #d1fae5; color: #065f46; }
    .rec-needs_major_revisions { background: #fed7aa; color: #9a3412; }
    .rec-needs_minor_revisions { background: #fef3c7; color: #92400e; }
    .rec-reject { background: #fee2e2; color: #991b1b; }
    
    .compliance-checklist {
        background: #f0fdf4;
        border-left: 4px solid #16a34a;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 24px;
    }
    .checklist-item {
        padding: 8px 0;
        border-bottom: 1px solid #dcfce7;
    }
    .checklist-item:last-child { border-bottom: none; }
    .checklist-icon {
        width: 20px;
        height: 20px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin-right: 10px;
        font-size: 12px;
    }
    .check-pass { background: #d1fae5; color: #065f46; }
    .check-fail { background: #fee2e2; color: #991b1b; }
    .check-warning { background: #fef3c7; color: #92400e; }
</style>

<div class="container-fluid py-4">
    
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('/reviewer/fullpapers-review') }}">Full Papers</a>
            </li>
            <li class="breadcrumb-item active">Make Decision</li>
        </ol>
    </nav>

    {{-- Paper Info --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="text-success mb-3">Sustainable Water Management Techniques for Crop Production</h5>
            <div class="row">
                <div class="col-md-4">
                    <p class="mb-2"><strong>Paper ID:</strong> FP-0003</p>
                    <p class="mb-0"><strong>Author:</strong> Dr. Mary Wanjiru</p>
                </div>
                <div class="col-md-4">
                    <p class="mb-2"><strong>Email:</strong> m.wanjiru@example.com</p>
                    <p class="mb-0"><strong>Sub-Theme:</strong> Water & Agriculture</p>
                </div>
                <div class="col-md-4 text-end">
                    <button class="btn btn-outline-success" onclick="alert('Download would start')">
                        <i class="fas fa-download me-1"></i>Download Paper
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Compliance Checklist --}}
    <div class="compliance-checklist">
        <h6 class="text-success mb-3">
            <i class="fas fa-clipboard-check me-2"></i>Submission Guidelines Compliance Review
        </h6>
        <p class="small text-muted mb-3">Verify that the paper meets all mandatory requirements before making your decision.</p>
        
        <div class="row">
            <div class="col-md-6">
                <h6 class="small fw-bold mb-2">Cover & Author Information:</h6>
                <div class="checklist-item">
                    <span class="checklist-icon check-pass"><i class="fas fa-check"></i></span>
                    <span class="small">Title and author name(s) included</span>
                </div>
                <div class="checklist-item">
                    <span class="checklist-icon check-pass"><i class="fas fa-check"></i></span>
                    <span class="small">Institutional affiliation(s) provided</span>
                </div>
                <div class="checklist-item">
                    <span class="checklist-icon check-pass"><i class="fas fa-check"></i></span>
                    <span class="small">Complete mailing address(es) included</span>
                </div>
                <div class="checklist-item">
                    <span class="checklist-icon check-pass"><i class="fas fa-check"></i></span>
                    <span class="small">E-mail addresses provided</span>
                </div>
                <div class="checklist-item">
                    <span class="checklist-icon check-pass"><i class="fas fa-check"></i></span>
                    <span class="small">Corresponding author indicated</span>
                </div>

                <h6 class="small fw-bold mt-3 mb-2">Formatting Requirements:</h6>
                <div class="checklist-item">
                    <span class="checklist-icon check-pass"><i class="fas fa-check"></i></span>
                    <span class="small">Paper ≤ 3000 words</span>
                </div>
                <div class="checklist-item">
                    <span class="checklist-icon check-pass"><i class="fas fa-check"></i></span>
                    <span class="small">British English used</span>
                </div>
                <div class="checklist-item">
                    <span class="checklist-icon check-pass"><i class="fas fa-check"></i></span>
                    <span class="small">A4, double-spaced, Times New Roman 12</span>
                </div>
                <div class="checklist-item">
                    <span class="checklist-icon check-pass"><i class="fas fa-check"></i></span>
                    <span class="small">Pages numbered consecutively</span>
                </div>
            </div>

            <div class="col-md-6">
                <h6 class="small fw-bold mb-2">Required Sections:</h6>
                <div class="checklist-item">
                    <span class="checklist-icon check-pass"><i class="fas fa-check"></i></span>
                    <span class="small">1. Abstract</span>
                </div>
                <div class="checklist-item">
                    <span class="checklist-icon check-pass"><i class="fas fa-check"></i></span>
                    <span class="small">2. Introduction</span>
                </div>
                <div class="checklist-item">
                    <span class="checklist-icon check-pass"><i class="fas fa-check"></i></span>
                    <span class="small">3. Materials and Methods</span>
                </div>
                <div class="checklist-item">
                    <span class="checklist-icon check-pass"><i class="fas fa-check"></i></span>
                    <span class="small">4. Results</span>
                </div>
                <div class="checklist-item">
                    <span class="checklist-icon check-pass"><i class="fas fa-check"></i></span>
                    <span class="small">5. Discussion</span>
                </div>
                <div class="checklist-item">
                    <span class="checklist-icon check-pass"><i class="fas fa-check"></i></span>
                    <span class="small">6. Conclusion</span>
                </div>
                <div class="checklist-item">
                    <span class="checklist-icon check-pass"><i class="fas fa-check"></i></span>
                    <span class="small">7. Recommendations</span>
                </div>
                <div class="checklist-item">
                    <span class="checklist-icon check-pass"><i class="fas fa-check"></i></span>
                    <span class="small">8. Acknowledgement</span>
                </div>
                <div class="checklist-item">
                    <span class="checklist-icon check-pass"><i class="fas fa-check"></i></span>
                    <span class="small">9. References</span>
                </div>

                <h6 class="small fw-bold mt-3 mb-2">Technical Requirements:</h6>
                <div class="checklist-item">
                    <span class="checklist-icon check-pass"><i class="fas fa-check"></i></span>
                    <span class="small">Scientific names italicized properly</span>
                </div>
                <div class="checklist-item">
                    <span class="checklist-icon check-pass"><i class="fas fa-check"></i></span>
                    <span class="small">Figures/tables properly labeled</span>
                </div>
                <div class="checklist-item">
                    <span class="checklist-icon check-pass"><i class="fas fa-check"></i></span>
                    <span class="small">References formatted correctly</span>
                </div>
            </div>
        </div>

        <div class="alert alert-info mt-3 mb-0">
            <small>
                <i class="fas fa-info-circle me-1"></i>
                <strong>Note:</strong> This checklist is based on the reviewers' assessment. 
                You can override any concerns in your decision comments if justified.
            </small>
        </div>
    </div>

    {{-- Review Summary --}}
    <div class="review-summary-card">
        <h5 class="mb-4"><i class="fas fa-chart-pie me-2"></i>Review Summary</h5>
        <div class="row">
            <div class="col-md-3 text-center">
                <p class="text-muted mb-1 small">AVERAGE SCORE</p>
                <div class="score-display">78</div>
                <p class="text-muted small">out of 100</p>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-6 mb-3">
                        <p class="mb-1 small text-muted">ACCEPT</p>
                        <h4 class="text-success mb-0">2/3 reviewers</h4>
                    </div>
                    <div class="col-6 mb-3">
                        <p class="mb-1 small text-muted">REJECT</p>
                        <h4 class="text-danger mb-0">0/3 reviewers</h4>
                    </div>
                    <div class="col-6">
                        <p class="mb-1 small text-muted">MAJOR REVISIONS</p>
                        <h4 class="text-warning mb-0">0/3 reviewers</h4>
                    </div>
                    <div class="col-6">
                        <p class="mb-1 small text-muted">MINOR REVISIONS</p>
                        <h4 class="text-warning mb-0">1/3 reviewers</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Individual Reviews --}}
    <h5 class="mb-3">
        <i class="fas fa-clipboard-check me-2"></i>Individual Reviews
    </h5>

    {{-- Reviewer 1 --}}
    <div class="review-card">
        <div class="review-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1">
                        <i class="fas fa-user-circle me-2"></i>
                        Prof. Michael Otieno
                    </h6>
                    <small>
                        Prequalified Reviewer · Submitted Feb 20, 2026
                    </small>
                </div>
                <div class="text-end">
                    <div class="score-display" style="font-size: 32px; color: white;">
                        82/100
                    </div>
                </div>
            </div>
        </div>
        <div class="review-body">
            
            {{-- Section Scores --}}
            <h6 class="mb-3">Section Scores</h6>
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="section-score-row">
                        <span>Title</span>
                        <strong>5/5</strong>
                    </div>
                    <div class="section-score-row">
                        <span>Abstract</span>
                        <strong>4/5</strong>
                    </div>
                    <div class="section-score-row">
                        <span>Introduction</span>
                        <strong>8/10</strong>
                    </div>
                    <div class="section-score-row">
                        <span>Methods</span>
                        <strong>20/25</strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="section-score-row">
                        <span>Results</span>
                        <strong>21/25</strong>
                    </div>
                    <div class="section-score-row">
                        <span>Discussion</span>
                        <strong>13/15</strong>
                    </div>
                    <div class="section-score-row">
                        <span>Conclusions</span>
                        <strong>8/10</strong>
                    </div>
                    <div class="section-score-row">
                        <span>References</span>
                        <strong>3/5</strong>
                    </div>
                </div>
            </div>

            {{-- Recommendation --}}
            <div class="mb-3">
                <h6>Recommendation</h6>
                <span class="recommendation-badge rec-accept">Accept</span>
                <span class="ms-3">
                    <i class="fas fa-presentation me-1"></i>
                    Oral Presentation
                </span>
            </div>

            {{-- Overall Comments --}}
            <div>
                <h6>Overall Comments</h6>
                <div class="bg-light p-3 rounded">
                    This is a well-researched paper that addresses critical water management issues in agricultural settings. The methodology is sound and the results are clearly presented. Minor improvements needed in the references section.
                </div>
            </div>

            {{-- Section-by-Section Comments (Expandable) --}}
            <div class="mt-3">
                <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#reviewer1Details">
                    <i class="fas fa-eye me-1"></i>View Detailed Section Comments
                </button>
                <div class="collapse mt-2" id="reviewer1Details">
                    <div class="card card-body bg-light">
                        <p class="mb-2"><strong>Title:</strong> Appropriate and reflects content well.</p>
                        <p class="mb-2"><strong>Abstract:</strong> Concise and covers all required elements.</p>
                        <p class="mb-2"><strong>Introduction:</strong> Good background but could strengthen literature review.</p>
                        <p class="mb-2"><strong>Methods:</strong> Clear methodology with adequate sample size.</p>
                        <p class="mb-2"><strong>Results:</strong> Well-presented with good visualizations.</p>
                        <p class="mb-2"><strong>Discussion:</strong> Solid interpretation of findings.</p>
                        <p class="mb-2"><strong>Conclusions:</strong> Align well with objectives.</p>
                        <p class="mb-0"><strong>References:</strong> Some citations need formatting corrections.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Reviewer 2 --}}
    <div class="review-card">
        <div class="review-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1">
                        <i class="fas fa-user-circle me-2"></i>
                        Dr. Peter Mwangi
                    </h6>
                    <small>
                        Peer Author · Submitted Feb 21, 2026
                    </small>
                </div>
                <div class="text-end">
                    <div class="score-display" style="font-size: 32px; color: white;">
                        75/100
                    </div>
                </div>
            </div>
        </div>
        <div class="review-body">
            
            {{-- Section Scores --}}
            <h6 class="mb-3">Section Scores</h6>
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="section-score-row">
                        <span>Title</span>
                        <strong>4/5</strong>
                    </div>
                    <div class="section-score-row">
                        <span>Abstract</span>
                        <strong>4/5</strong>
                    </div>
                    <div class="section-score-row">
                        <span>Introduction</span>
                        <strong>7/10</strong>
                    </div>
                    <div class="section-score-row">
                        <span>Methods</span>
                        <strong>18/25</strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="section-score-row">
                        <span>Results</span>
                        <strong>19/25</strong>
                    </div>
                    <div class="section-score-row">
                        <span>Discussion</span>
                        <strong>12/15</strong>
                    </div>
                    <div class="section-score-row">
                        <span>Conclusions</span>
                        <strong>7/10</strong>
                    </div>
                    <div class="section-score-row">
                        <span>References</span>
                        <strong>4/5</strong>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <h6>Recommendation</h6>
                <span class="recommendation-badge rec-needs_minor_revisions">Needs Minor Revisions</span>
                <span class="ms-3">
                    <i class="fas fa-presentation me-1"></i>
                    Conference PowerPoint Presentation
                </span>
            </div>

            <div>
                <h6>Overall Comments</h6>
                <div class="bg-light p-3 rounded">
                    Good paper with practical applications. The methodology section could be strengthened with more detail on sample sizes. Results are well presented with clear visualizations.
                </div>
            </div>

            <div class="mt-3">
                <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#reviewer2Details">
                    <i class="fas fa-eye me-1"></i>View Detailed Section Comments
                </button>
                <div class="collapse mt-2" id="reviewer2Details">
                    <div class="card card-body bg-light">
                        <p class="mb-2"><strong>Title:</strong> Good but could be more specific.</p>
                        <p class="mb-2"><strong>Methods:</strong> Need more details on sample sizes and data collection procedures.</p>
                        <p class="mb-2"><strong>Results:</strong> Visualizations are excellent.</p>
                        <p class="mb-0"><strong>Acknowledgement:</strong> Properly formatted.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Reviewer 3 --}}
    <div class="review-card">
        <div class="review-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1">
                        <i class="fas fa-user-circle me-2"></i>
                        Dr. Sarah Njeri
                    </h6>
                    <small>
                        Peer Author · Submitted Feb 22, 2026
                    </small>
                </div>
                <div class="text-end">
                    <div class="score-display" style="font-size: 32px; color: white;">
                        77/100
                    </div>
                </div>
            </div>
        </div>
        <div class="review-body">
            
            {{-- Section Scores --}}
            <h6 class="mb-3">Section Scores</h6>
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="section-score-row">
                        <span>Title</span>
                        <strong>5/5</strong>
                    </div>
                    <div class="section-score-row">
                        <span>Abstract</span>
                        <strong>4/5</strong>
                    </div>
                    <div class="section-score-row">
                        <span>Introduction</span>
                        <strong>8/10</strong>
                    </div>
                    <div class="section-score-row">
                        <span>Methods</span>
                        <strong>19/25</strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="section-score-row">
                        <span>Results</span>
                        <strong>20/25</strong>
                    </div>
                    <div class="section-score-row">
                        <span>Discussion</span>
                        <strong>11/15</strong>
                    </div>
                    <div class="section-score-row">
                        <span>Conclusions</span>
                        <strong>6/10</strong>
                    </div>
                    <div class="section-score-row">
                        <span>References</span>
                        <strong>4/5</strong>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <h6>Recommendation</h6>
                <span class="recommendation-badge rec-accept">Accept</span>
                <span class="ms-3">
                    <i class="fas fa-presentation me-1"></i>
                    Oral Presentation
                </span>
            </div>

            <div>
                <h6>Overall Comments</h6>
                <div class="bg-light p-3 rounded">
                    Solid contribution to water management literature. The paper demonstrates practical applications with good data analysis. Conclusion section could be strengthened.
                </div>
            </div>

            <div class="mt-3">
                <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#reviewer3Details">
                    <i class="fas fa-eye me-1"></i>View Detailed Section Comments
                </button>
                <div class="collapse mt-2" id="reviewer3Details">
                    <div class="card card-body bg-light">
                        <p class="mb-2"><strong>Materials and Methods:</strong> Well-documented procedures.</p>
                        <p class="mb-2"><strong>Discussion:</strong> Good contextualization of results.</p>
                        <p class="mb-2"><strong>Conclusion:</strong> Could be more comprehensive.</p>
                        <p class="mb-0"><strong>Recommendations:</strong> Practical and actionable.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Decision Form --}}
    <div class="card border-warning shadow-sm">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0">
                <i class="fas fa-gavel me-2"></i>Make Your Final Decision
            </h5>
        </div>
        <div class="card-body">
            <form onsubmit="event.preventDefault(); alert('Decision submitted! Author has been notified via email.');">
                
                <div class="mb-4">
                    <label class="form-label fw-bold">Decision <span class="text-danger">*</span></label>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check p-3 border rounded mb-2">
                                <input class="form-check-input" type="radio" name="decision" id="approve" value="approved" required>
                                <label class="form-check-label fw-bold text-success" for="approve">
                                    <i class="fas fa-check-circle me-2"></i>APPROVE
                                    <br><small class="text-muted fw-normal">Paper is accepted for the conference</small>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check p-3 border rounded">
                                <input class="form-check-input" type="radio" name="decision" id="reject" value="rejected" required>
                                <label class="form-check-label fw-bold text-danger" for="reject">
                                    <i class="fas fa-times-circle me-2"></i>REJECT
                                    <br><small class="text-muted fw-normal">Paper will not be presented</small>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">
                        Comments to Author <span class="text-danger">*</span>
                    </label>
                    <textarea name="comments" 
                              class="form-control" 
                              rows="5" 
                              placeholder="Provide constructive feedback based on reviewers' comments and compliance checklist..."
                              required></textarea>
                    <small class="text-muted">Minimum 20 characters. Include guidance on any required sections that need attention.</small>
                </div>

                <div class="alert alert-info">
                    <h6 class="alert-heading">
                        <i class="fas fa-info-circle me-2"></i>What Happens Next?
                    </h6>
                    <ul class="mb-0 small">
                        <li><strong>If APPROVED:</strong> Author receives email with link to upload presentation materials (PowerPoint/Poster)</li>
                        <li><strong>If REJECTED:</strong> Author receives email with your comments, reviewers' feedback, and compliance notes</li>
                        <li>Decision is <strong>final</strong> and cannot be changed</li>
                    </ul>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-warning btn-lg">
                        <i class="fas fa-paper-plane me-2"></i>
                        Submit Decision & Notify Author
                    </button>
                    <a href="{{ url('/reviewer/fullpapers-review') }}" class="btn btn-secondary btn-lg">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection