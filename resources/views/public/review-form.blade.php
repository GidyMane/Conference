<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Full Paper Review - KALRO Conference</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --kalro-green: #16a34a;
            --kalro-dark: #15803d;
        }
        body { background: #f8f9fa; }
        .review-header {
            background: linear-gradient(135deg, var(--kalro-green) 0%, var(--kalro-dark) 100%);
            padding: 30px 0;
            color: white;
            box-shadow: 0 4px 12px rgba(0,0,0,.15);
        }
        .section-card {
            margin-bottom: 24px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,.08);
            border: 1px solid #e5e7eb;
        }
        .section-header {
            background: linear-gradient(to right, #f0fdf4, #dcfce7);
            padding: 16px 20px;
            border-bottom: 3px solid var(--kalro-green);
        }
        .section-header h5 {
            margin: 0;
            color: var(--kalro-dark);
            font-weight: 700;
            font-size: 18px;
        }
        .section-header .max-score {
            float: right;
            background: var(--kalro-green);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }
        .section-body {
            padding: 24px;
            background: white;
        }
        .criteria-row {
            padding: 12px 0;
            border-bottom: 1px dashed #e5e7eb;
        }
        .criteria-row:last-child { border-bottom: none; }
        .score-input {
            max-width: 100px;
            font-weight: 700;
            text-align: center;
            font-size: 16px;
        }
        .total-display {
            background: var(--kalro-green);
            color: white;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            position: sticky;
            top: 20px;
        }
        .total-display h3 {
            font-size: 48px;
            margin: 0;
            font-weight: 700;
        }
        .checklist-card {
            background: #fffbeb;
            border-left: 4px solid #f59e0b;
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 24px;
        }
        .checklist-item {
            padding: 4px 0;
        }
        .checklist-item i {
            color: #f59e0b;
            width: 20px;
        }
    </style>
</head>
<body>

<div class="review-header">
    <div class="container">
        <h2><i class="fas fa-file-alt me-2"></i>Full Paper Review Form</h2>
        <p class="mb-0">2nd KALRO Scientific Conference and Exhibition</p>
    </div>
</div>

<div class="container my-5">
    <div class="row">
        <div class="col-lg-8">
            
            {{-- Paper Details --}}
            <div class="card section-card">
                <div class="section-header">
                    <h5><i class="fas fa-info-circle me-2"></i>Paper Details</h5>
                </div>
                <div class="section-body">

                    <h6 class="text-success mb-3">{{ $assignment->fullPaper->abstract->title }}</h6>

                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Submission ID:</strong> {{ $assignment->fullPaper->abstract->submission_code }}</p>
                            <p class="mb-2"><strong>Paper ID:</strong> {{ $assignment->fullPaper->full_paper_code }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Sub-Theme:</strong> {{ $assignment->fullPaper->abstract->subtheme->full_name ?? '-' }}</p>
                            <p class="mb-0"><strong>Your Role:</strong> 
                                {{ $assignment->prequalifiedReviewer ? 'Prequalified Reviewer' : 'Peer Reviewer' }}
                            </p>
                        </div>
                    </div>

                  
                </div>
            </div>

            {{-- Submission Requirements Checklist --}}
            <div class="checklist-card">
                <h6 class="fw-bold mb-2">
                    <i class="fas fa-clipboard-list me-2"></i>Verify Submission Requirements
                </h6>
                <p class="small mb-2">Please confirm the paper includes all mandatory components:</p>
                <div class="row small">
                    
                    <div class="col-md-6">
                        <div class="checklist-item">
                            <i class="fas fa-check-circle"></i> All 9 sections present
                        </div>
                        <div class="checklist-item">
                            <i class="fas fa-check-circle"></i> ≤ 3000 words
                        </div>
                        <div class="checklist-item">
                            <i class="fas fa-check-circle"></i> British English
                        </div>
                        <div class="checklist-item">
                            <i class="fas fa-check-circle"></i> Times New Roman 12, double-spaced
                        </div>
                        <div class="checklist-item">
                            <i class="fas fa-check-circle"></i> References properly formatted
                        </div>
                    </div>
                </div>
            </div>

            {{-- Review Form --}}
            <form method="POST" action="{{ route('review.submit', $assignment) }}">
                @csrf
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li><i class="fas fa-exclamation-circle me-1"></i>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- ═════════════════════════════════════════════════════════
                    SECTION 1: TITLE (5 points)
                ═════════════════════════════════════════════════════════ --}}
                <div class="card section-card">
                    <div class="section-header">
                        <h5>
                            <i class="fas fa-heading me-2"></i>Section 1: Title
                            <span class="max-score">Max: 5 points</span>
                        </h5>
                    </div>
                    <div class="section-body">
                        <div class="criteria-row">
                            <label class="fw-bold">Title is appropriate for conference themes (Max: 2) <span class="text-danger">*</span></label>
                            <input type="number" name="title_appropriate" class="form-control score-input mt-2" min="0" max="2"  required>
                        </div>
                        <div class="criteria-row">
                            <label class="fw-bold">Reflects manuscript contents (Max: 3) <span class="text-danger">*</span></label>
                            <input type="number" name="title_reflects_content" class="form-control score-input mt-2" min="0" max="3"  required>
                        </div>
                        <div class="mt-3">
                            <label class="form-label fw-bold">Reviewer Comments: <span class="text-danger">*</span></label>
                            <textarea name="title_comments" class="form-control" rows="2" placeholder="Provide feedback on title..." required></textarea>
                        </div>
                    </div>
                </div>

                {{-- ═════════════════════════════════════════════════════════
                    SECTION 2: ABSTRACT (5 points)
                ═════════════════════════════════════════════════════════ --}}
                <div class="card section-card">
                    <div class="section-header">
                        <h5>
                            <i class="fas fa-align-left me-2"></i>Section 2: Abstract
                            <span class="max-score">Max: 5 points</span>
                        </h5>
                    </div>
                    <div class="section-body">
                        <div class="criteria-row">
                            <label class="fw-bold">Abstract is not more than 300 words (Max: 2) <span class="text-danger">*</span></label>
                            <input type="number" name="abstract_word_count" class="form-control score-input mt-2" min="0" max="2"  required>
                        </div>
                        <div class="criteria-row">
                            <label class="fw-bold">Includes scope, methodology, findings, conclusions (Max: 3) <span class="text-danger">*</span></label>
                            <input type="number" name="abstract_completeness" class="form-control score-input mt-2" min="0" max="3"  required>
                        </div>
                        <div class="mt-3">
                            <label class="form-label fw-bold">Reviewer Comments: <span class="text-danger">*</span></label>
                            <textarea name="abstract_comments" class="form-control" rows="2" placeholder="Provide feedback on abstract..." required></textarea>
                        </div>
                    </div>
                </div>

                {{-- ═════════════════════════════════════════════════════════
                    SECTION 3: INTRODUCTION (10 points)
                ═════════════════════════════════════════════════════════ --}}
                <div class="card section-card">
                    <div class="section-header">
                        <h5>
                            <i class="fas fa-book-open me-2"></i>Section 3: Introduction
                            <span class="max-score">Max: 10 points</span>
                        </h5>
                    </div>
                    <div class="section-body">
                        <div class="criteria-row">
                            <label class="fw-bold">Explains background, gaps, recent literature (Max: 3) <span class="text-danger">*</span></label>
                            <input type="number" name="intro_background" class="form-control score-input mt-2" min="0" max="3"  required>
                        </div>
                        <div class="criteria-row">
                            <label class="fw-bold">Demonstrates originality, novelty, importance (Max: 5) <span class="text-danger">*</span></label>
                            <input type="number" name="intro_originality" class="form-control score-input mt-2" min="0" max="5"  required>
                        </div>
                        <div class="criteria-row">
                            <label class="fw-bold">States the research objectives (Max: 2) <span class="text-danger">*</span></label>
                            <input type="number" name="intro_objectives" class="form-control score-input mt-2" min="0" max="2"  required>
                        </div>
                        <div class="mt-3">
                            <label class="form-label fw-bold">Reviewer Comments: <span class="text-danger">*</span></label>
                            <textarea name="intro_comments" class="form-control" rows="2" placeholder="Provide feedback on introduction..." required></textarea>
                        </div>
                    </div>
                </div>

                {{-- ═════════════════════════════════════════════════════════
                    SECTION 4: MATERIALS AND METHODS (25 points)
                ═════════════════════════════════════════════════════════ --}}
                <div class="card section-card">
                    <div class="section-header">
                        <h5>
                            <i class="fas fa-flask me-2"></i>Section 4: Materials and Methods / Methodology
                            <span class="max-score">Max: 25 points</span>
                        </h5>
                    </div>
                    <div class="section-body">
                        <div class="criteria-row">
                            <label class="fw-bold">Detail for replication, good sample size (Max: 10) <span class="text-danger">*</span></label>
                            <input type="number" name="methods_replication" class="form-control score-input mt-2" min="0" max="10"  required>
                        </div>
                        <div class="criteria-row">
                            <label class="fw-bold">Design tests hypothesis rigorously (Max: 5) <span class="text-danger">*</span></label>
                            <input type="number" name="methods_design" class="form-control score-input mt-2" min="0" max="5"  required>
                        </div>
                        <div class="criteria-row">
                            <label class="fw-bold">Appropriate statistical techniques (Max: 5) <span class="text-danger">*</span></label>
                            <input type="number" name="methods_statistics" class="form-control score-input mt-2" min="0" max="5"  required>
                        </div>
                        <div class="criteria-row">
                            <label class="fw-bold">Follows ethical standards (Max: 5) <span class="text-danger">*</span></label>
                            <input type="number" name="methods_ethics" class="form-control score-input mt-2" min="0" max="5"  required>
                        </div>
                        <div class="mt-3">
                            <label class="form-label fw-bold">Reviewer Comments: <span class="text-danger">*</span></label>
                            <textarea name="methods_comments" class="form-control" rows="2" placeholder="Provide feedback on methodology..." required></textarea>
                        </div>
                    </div>
                </div>

                {{-- ═════════════════════════════════════════════════════════
                    SECTION 5: RESULTS (25 points)
                ═════════════════════════════════════════════════════════ --}}
                <div class="card section-card">
                    <div class="section-header">
                        <h5>
                            <i class="fas fa-chart-bar me-2"></i>Section 5: Results
                            <span class="max-score">Max: 25 points</span>
                        </h5>
                    </div>
                    <div class="section-body">
                        <div class="criteria-row">
                            <label class="fw-bold">Demonstrates new insights (Max: 5) <span class="text-danger">*</span></label>
                            <input type="number" name="results_insights" class="form-control score-input mt-2" min="0" max="5"  required>
                        </div>
                        <div class="criteria-row">
                            <label class="fw-bold">Good narrative/reporting (Max: 5) <span class="text-danger">*</span></label>
                            <input type="number" name="results_narrative" class="form-control score-input mt-2" min="0" max="5"  required>
                        </div>
                        <div class="criteria-row">
                            <label class="fw-bold">Clear data, stats explained (Max: 8) <span class="text-danger">*</span></label>
                            <input type="number" name="results_data_clarity" class="form-control score-input mt-2" min="0" max="8"  required>
                        </div>
                        <div class="criteria-row">
                            <label class="fw-bold">Data presented clearly, readable visuals (Max: 5) <span class="text-danger">*</span></label>
                            <input type="number" name="results_visuals" class="form-control score-input mt-2" min="0" max="5"  required>
                        </div>
                        <div class="criteria-row">
                            <label class="fw-bold">Proper referencing (Max: 2) <span class="text-danger">*</span></label>
                            <input type="number" name="results_referencing" class="form-control score-input mt-2" min="0" max="2"  required>
                        </div>
                        <div class="mt-3">
                            <label class="form-label fw-bold">Reviewer Comments: <span class="text-danger">*</span></label>
                            <textarea name="results_comments" class="form-control" rows="2" placeholder="Provide feedback on results..." required></textarea>
                        </div>
                    </div>
                </div>

                {{-- ═════════════════════════════════════════════════════════
                    SECTION 6: DISCUSSION (15 points)
                ═════════════════════════════════════════════════════════ --}}
                <div class="card section-card">
                    <div class="section-header">
                        <h5>
                            <i class="fas fa-comments me-2"></i>Section 6: Discussion
                            <span class="max-score">Max: 15 points</span>
                        </h5>
                    </div>
                    <div class="section-body">
                        <div class="criteria-row">
                            <label class="fw-bold">Puts results into context (Max: 2) <span class="text-danger">*</span></label>
                            <input type="number" name="discussion_context" class="form-control score-input mt-2" min="0" max="2"  required>
                        </div>
                        <div class="criteria-row">
                            <label class="fw-bold">Meets objectives, interprets well (Max: 2) <span class="text-danger">*</span></label>
                            <input type="number" name="discussion_objectives" class="form-control score-input mt-2" min="0" max="2"  required>
                        </div>
                        <div class="criteria-row">
                            <label class="fw-bold">Discusses significance and extends knowledge (Max: 5) <span class="text-danger">*</span></label>
                            <input type="number" name="discussion_significance" class="form-control score-input mt-2" min="0" max="5"  required>
                        </div>
                        <div class="criteria-row">
                            <label class="fw-bold">Aligns with conference theme (Max: 2) <span class="text-danger">*</span></label>
                            <input type="number" name="discussion_theme" class="form-control score-input mt-2" min="0" max="2"  required>
                        </div>
                        <div class="criteria-row">
                            <label class="fw-bold">Recent references (Max: 4) <span class="text-danger">*</span></label>
                            <input type="number" name="discussion_references" class="form-control score-input mt-2" min="0" max="4"  required>
                        </div>
                        <div class="mt-3">
                            <label class="form-label fw-bold">Reviewer Comments: <span class="text-danger">*</span></label>
                            <textarea name="discussion_comments" class="form-control" rows="2" placeholder="Provide feedback on discussion..." required></textarea>
                        </div>
                    </div>
                </div>

                {{-- ═════════════════════════════════════════════════════════
                    SECTION 7: CONCLUSIONS AND RECOMMENDATIONS (10 points)
                ═════════════════════════════════════════════════════════ --}}
                <div class="card section-card">
                    <div class="section-header">
                        <h5>
                            <i class="fas fa-check-circle me-2"></i>Section 7: Conclusions and Recommendations
                            <span class="max-score">Max: 10 points</span>
                        </h5>
                    </div>
                    <div class="section-body">
                        <div class="criteria-row">
                            <label class="fw-bold">Reflects objectives (Max: 2) <span class="text-danger">*</span></label>
                            <input type="number" name="conclusion_objectives" class="form-control score-input mt-2" min="0" max="2"  required>
                        </div>
                        <div class="criteria-row">
                            <label class="fw-bold">Consistent with arguments (Max: 5) <span class="text-danger">*</span></label>
                            <input type="number" name="conclusion_consistency" class="form-control score-input mt-2" min="0" max="5"  required>
                        </div>
                        <div class="criteria-row">
                            <label class="fw-bold">States contribution to science/theme (Max: 3) <span class="text-danger">*</span></label>
                            <input type="number" name="conclusion_contribution" class="form-control score-input mt-2" min="0" max="3"  required>
                        </div>
                        <div class="mt-3">
                            <label class="form-label fw-bold">Reviewer Comments: <span class="text-danger">*</span></label>
                            <textarea name="conclusion_comments" class="form-control" rows="2" placeholder="Provide feedback on conclusions and recommendations..." required></textarea>
                        </div>
                    </div>
                </div>

                {{-- ═════════════════════════════════════════════════════════
                    SECTION 8: ACKNOWLEDGEMENT AND REFERENCES (5 points)
                ═════════════════════════════════════════════════════════ --}}
                <div class="card section-card">
                    <div class="section-header">
                        <h5>
                            <i class="fas fa-book me-2"></i>Section 8: Acknowledgement and References
                            <span class="max-score">Max: 5 points</span>
                        </h5>
                    </div>
                    <div class="section-body">
                        <div class="criteria-row">
                            <label class="fw-bold">Acknowledgement section present and appropriate (Max: 1) <span class="text-danger">*</span></label>
                            <input type="number" name="acknowledgement_present" class="form-control score-input mt-2" min="0" max="1"  required>
                        </div>
                        <div class="criteria-row">
                            <label class="fw-bold">References accurate, relevant, retrievable (Max: 1) <span class="text-danger">*</span></label>
                            <input type="number" name="references_accuracy" class="form-control score-input mt-2" min="0" max="1"  required>
                        </div>
                        <div class="criteria-row">
                            <label class="fw-bold">Balanced, fair, avoids self-citation (Max: 1) <span class="text-danger">*</span></label>
                            <input type="number" name="references_balance" class="form-control score-input mt-2" min="0" max="1"  required>
                        </div>
                        <div class="criteria-row">
                            <label class="fw-bold">Cited and listed correctly (Max: 1) <span class="text-danger">*</span></label>
                            <input type="number" name="references_citation" class="form-control score-input mt-2" min="0" max="1"  required>
                        </div>
                        <div class="criteria-row">
                            <label class="fw-bold">All references match between text and list (Max: 1) <span class="text-danger">*</span></label>
                            <input type="number" name="references_matching" class="form-control score-input mt-2" min="0" max="1"  required>
                        </div>
                        <div class="mt-3">
                            <label class="form-label fw-bold">Reviewer Comments: <span class="text-danger">*</span></label>
                            <textarea name="references_comments" class="form-control" rows="2" placeholder="Provide feedback on acknowledgement and references..." required></textarea>
                        </div>
                    </div>
                </div>

                {{-- ═════════════════════════════════════════════════════════
                    OVERALL ASSESSMENT
                ═════════════════════════════════════════════════════════ --}}
                <div class="card section-card border-warning">
                    <div class="section-header" style="background: linear-gradient(to right, #fef3c7, #fde68a);">
                        <h5 style="color: #92400e;">
                            <i class="fas fa-gavel me-2"></i>Overall Assessment
                        </h5>
                    </div>
                    <div class="section-body">
                        <div class="mb-4">
                            <label class="form-label fw-bold">Overall Comments <span class="text-danger">*</span></label>
                            <textarea name="overall_comments" 
                                      class="form-control" 
                                      rows="5" 
                                      required 
                                      minlength="50"
                                      placeholder="Provide comprehensive feedback covering all 9 required sections: Abstract, Introduction, Materials and Methods, Results, Discussion, Conclusion, Recommendations, Acknowledgement, and References. Also comment on the presence of all author information (names, affiliations, addresses, emails, corresponding author)."></textarea>
                            <small class="text-muted">Minimum 50 characters required. Ensure you address section completeness.</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Recommendation <span class="text-danger">*</span></label>
                            <select name="recommendation" class="form-select" required>
                                <option value="">-- Select Your Recommendation --</option>
                                <option value="accept">✓ Accept</option>
                                <option value="needs_minor_revisions">⚠ Needs Minor Revisions</option>
                                <option value="needs_major_revisions">⚠ Needs Major Revisions</option>
                                <option value="reject">✗ Reject</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Presentation Format <span class="text-danger">*</span></label>
                            <select name="paper_suitability" class="form-select" required>
                                <option value="">-- Select Presentation Format --</option>
                                <option value="powerpoint">📊 PowerPoint Presentation</option>
                                <option value="poster">📋 Poster Presentation</option>
                            </select>
                            <small class="text-muted">Select the most appropriate format for presenting this paper at the conference.</small>
                        </div>

                        <div class="alert alert-info">
                            <strong><i class="fas fa-info-circle me-2"></i>Before submitting:</strong>
                            <ul class="mb-0 small">
                                <li>Verify all 8 sections have been scored</li>
                                <li>Confirm all comment fields are completed</li>
                                <li>Check that author information is complete</li>
                                <li>Ensure your comments address any missing sections or requirements</li>
                            </ul>
                        </div>

                        <button type="submit" class="btn btn-success btn-lg w-100">
                            <i class="fas fa-paper-plane me-2"></i>Submit Review
                        </button>
                    </div>
                </div>

            </form>

        </div>

        {{-- RIGHT SIDEBAR: Total Score --}}
        <div class="col-lg-4">
            <div class="total-display">
                <p class="mb-2">TOTAL SCORE</p>
                <h3 id="totalScore">0</h3>
                <p class="mb-0">out of 100</p>
                <hr style="border-color: rgba(255,255,255,.3); margin: 20px 0;">
                <div class="small text-start">
                    <p class="mb-1"><strong>Section Breakdown:</strong></p>
                    <p class="mb-1">Title: 5 pts</p>
                    <p class="mb-1">Abstract: 5 pts</p>
                    <p class="mb-1">Introduction: 10 pts</p>
                    <p class="mb-1">Methods: 25 pts</p>
                    <p class="mb-1">Results: 25 pts</p>
                    <p class="mb-1">Discussion: 15 pts</p>
                    <p class="mb-1">Conclusions: 10 pts</p>
                    <p class="mb-0">Acknowledgement & Refs: 5 pts</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-calculate total score
document.addEventListener('DOMContentLoaded', () => {
    const scoreInputs = document.querySelectorAll('.score-input');
    const totalDisplay = document.getElementById('totalScore');
    
    scoreInputs.forEach(input => {
        input.addEventListener('input', calculateTotal);
    });
    
    function calculateTotal() {
        let total = 0;
        scoreInputs.forEach(input => {
            total += parseInt(input.value) || 0;
        });
        totalDisplay.textContent = total;
    }
    
    // Initialize calculation
    calculateTotal();
});
</script>

</body>
</html>