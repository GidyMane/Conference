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
        }
        .section-card {
            margin-bottom: 24px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,.08);
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
        }
        .section-header .max-score {
            float: right;
            background: var(--kalro-green);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 13px;
        }
        .section-body {
            padding: 24px;
            background: white;
        }
        .score-input {
            max-width: 100px;
            font-weight: 700;
            text-align: center;
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
        }
    </style>
</head>
<body>

<div class="review-header">
    <div class="container">
        <h2><i class="fas fa-file-alt me-2"></i>Full Paper Review</h2>
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
                    <h6 class="text-success mb-3">Sustainable Water Management Techniques for Crop Production</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Submission ID:</strong> SUB45-003</p>
                            <p class="mb-0"><strong>Author:</strong> Dr. Mary Wanjiru</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Sub-Theme:</strong> Water & Agriculture</p>
                            <p class="mb-0"><strong>Your Role:</strong> Prequalified Reviewer</p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button class="btn btn-success" onclick="alert('Download would start')">
                            <i class="fas fa-download me-1"></i>Download Full Paper PDF
                        </button>
                    </div>
                </div>
            </div>

            {{-- Review Form --}}
            <form onsubmit="event.preventDefault(); document.getElementById('successMessage').classList.remove('d-none'); window.scrollTo(0,0);">

                {{-- Success Message (hidden initially) --}}
                <div id="successMessage" class="alert alert-success d-none">
                    <h5><i class="fas fa-check-circle me-2"></i>Review Submitted Successfully!</h5>
                    <p class="mb-0">Thank you for your review. Your total score: <strong id="finalScore">0</strong>/100</p>
                </div>

                {{-- SECTION 1: TITLE (5 points) --}}
                <div class="card section-card">
                    <div class="section-header">
                        <h5>
                            <i class="fas fa-heading me-2"></i>Section 1: Title
                            <span class="max-score">Max: 5</span>
                        </h5>
                    </div>
                    <div class="section-body">
                        <div class="mb-3">
                            <label>Title is appropriate for conference themes (Max: 2)</label>
                            <input type="number" class="form-control score-input" min="0" max="2" value="0" required>
                        </div>
                        <div class="mb-3">
                            <label>Reflects manuscript contents (Max: 3)</label>
                            <input type="number" class="form-control score-input" min="0" max="3" value="0" required>
                        </div>
                        <div>
                            <label>Comments:</label>
                            <textarea class="form-control" rows="2" placeholder="Optional comments..."></textarea>
                        </div>
                    </div>
                </div>

                {{-- SECTION 2: ABSTRACT (5 points) --}}
                <div class="card section-card">
                    <div class="section-header">
                        <h5>
                            <i class="fas fa-align-left me-2"></i>Section 2: Abstract
                            <span class="max-score">Max: 5</span>
                        </h5>
                    </div>
                    <div class="section-body">
                        <div class="mb-3">
                            <label>Not more than 300 words (Max: 2)</label>
                            <input type="number" class="form-control score-input" min="0" max="2" value="0" required>
                        </div>
                        <div class="mb-3">
                            <label>Includes scope, methodology, findings, conclusions (Max: 3)</label>
                            <input type="number" class="form-control score-input" min="0" max="3" value="0" required>
                        </div>
                        <div>
                            <label>Comments:</label>
                            <textarea class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                </div>

                {{-- SECTION 3: INTRODUCTION (10 points) --}}
                <div class="card section-card">
                    <div class="section-header">
                        <h5>
                            <i class="fas fa-book-open me-2"></i>Section 3: Introduction
                            <span class="max-score">Max: 10</span>
                        </h5>
                    </div>
                    <div class="section-body">
                        <div class="mb-3">
                            <label>Background, gaps, recent literature (Max: 3)</label>
                            <input type="number" class="form-control score-input" min="0" max="3" value="0" required>
                        </div>
                        <div class="mb-3">
                            <label>Originality, novelty, importance (Max: 5)</label>
                            <input type="number" class="form-control score-input" min="0" max="5" value="0" required>
                        </div>
                        <div class="mb-3">
                            <label>States research objectives (Max: 2)</label>
                            <input type="number" class="form-control score-input" min="0" max="2" value="0" required>
                        </div>
                        <div>
                            <label>Comments:</label>
                            <textarea class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                </div>

                {{-- For demo purposes, showing 3 sections. In production, all 8 sections would be here --}}

                {{-- RECOMMENDATION & SUBMIT --}}
                <div class="card section-card">
                    <div class="section-header">
                        <h5><i class="fas fa-gavel me-2"></i>Overall Assessment</h5>
                    </div>
                    <div class="section-body">
                        <div class="mb-3">
                            <label class="fw-bold">Overall Comments <span class="text-danger">*</span></label>
                            <textarea class="form-control" rows="4" required 
                                      placeholder="Provide comprehensive feedback..."></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold">Recommendation <span class="text-danger">*</span></label>
                            <select class="form-select" required>
                                <option value="">-- Select --</option>
                                <option>Accept</option>
                                <option>Needs Minor Revisions</option>
                                <option>Needs Major Revisions</option>
                                <option>Reject</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold">Paper Suitability <span class="text-danger">*</span></label>
                            <select class="form-select" required>
                                <option value="">-- Select --</option>
                                <option>Oral Presentation</option>
                                <option>Poster Presentation</option>
                                <option>PowerPoint Presentation</option>
                            </select>
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
            </div>
        </div>
    </div>
</div>

<script>
// Auto-calculate total score
document.addEventListener('DOMContentLoaded', () => {
    const scoreInputs = document.querySelectorAll('.score-input');
    const totalDisplay = document.getElementById('totalScore');
    const finalScore = document.getElementById('finalScore');
    
    scoreInputs.forEach(input => {
        input.addEventListener('input', calculateTotal);
    });
    
    function calculateTotal() {
        let total = 0;
        scoreInputs.forEach(input => {
            total += parseInt(input.value) || 0;
        });
        totalDisplay.textContent = total;
        finalScore.textContent = total;
    }
});
</script>

</body>
</html>