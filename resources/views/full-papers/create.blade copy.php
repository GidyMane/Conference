<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KALRO Conference - Full Paper Upload</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        .upload-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            background: white;
        }
        .upload-header {
            background-color: #158532;
            color: white;
            padding: 1.5rem;
            border-radius: 10px 10px 0 0;
            text-align: center;
        }
        .submission-info {
            background-color: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }
        .upload-area {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 1.5rem;
        }
        .upload-area.active {
            border-color: #158532;
            background-color: #e8f5e9;
        }
        .file-info {
            margin-top: 1rem;
            font-size: 0.9rem;
            color: #6c757d;
        }
        .progress-container {
            display: none;
            margin-top: 1.5rem;
        }
        .submit-btn {
            display: none;
            width: 100%;
            padding: 0.75rem;
            font-weight: 600;
        }
        .guidelines-section {
            background-color: #e6f9e6;
            border-left: 4px solid #158532;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border-radius: 8px;
        }
        .guidelines-section h6 {
            color: #158532;
            font-weight: 600;
            margin-top: 1rem;
            margin-bottom: 0.5rem;
        }
        .guidelines-section h6:first-of-type {
            margin-top: 0;
        }
        .reference-example {
            background: #f8f9fa;
            padding: 0.75rem;
            border-radius: 5px;
            font-family: 'Courier New', monospace;
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
            border-left: 3px solid #158532;
        }
        .important-note {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 1rem;
            margin: 1rem 0;
            border-radius: 5px;
        }
        .author-removal-notice {
            background: #fff1f2;
            border-left: 4px solid #e11d48;
            padding: 1rem 1.25rem;
            margin: 1rem 0;
            border-radius: 5px;
        }
        .author-removal-notice strong {
            color: #be123c;
        }
        .hero {
            background: linear-gradient(135deg, #158532 0%, #0d5c23 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }
        .theme-title {
            font-size: 1.5rem;
            font-weight: 600;
        }
        .acknowledgement-box {
            background: #fef9ec;
            border: 2px solid #f59e0b;
            border-radius: 8px;
            padding: 16px 18px;
            margin-bottom: 16px;
        }
        .acknowledgement-box .form-check-label {
            font-weight: 600;
            color: #78350f;
            font-size: 14px;
            cursor: pointer;
        }
        .acknowledgement-box .form-check-input {
            width: 18px;
            height: 18px;
            margin-top: 2px;
            cursor: pointer;
            accent-color: #d97706;
        }
    </style>
</head>
<body>


<div class="container-fluid bg-white py-2 shadow-sm">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-2 col-md-4 col-6">
                <div class="logo">
                    <a href="/">
                        <img src="{{asset('assets/images/kalro-logo.gif')}}" alt="KALRO Logo" class="img-fluid" style="max-height: 60px;">
                    </a>
                </div>
            </div>
            <div class="col-lg-10 col-md-8 col-6 text-end">
                <h5 class="mb-0 text-success d-none d-md-block">2nd KALRO Scientific Conference</h5>
            </div>
        </div>
    </div>
</div>


<section class="hero">
    <div class="container text-center">
        <h1 class="theme-title">
            <b>Conference Theme:</b> "Innovations for Sustainable Agri-food Systems, Climate Change Resilience and Improved Livelihoods"
        </h1>
    </div>
</section>

<div class="container">

 
    <div class="container my-4">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>Full Paper Submission Guidelines
                </h5>
            </div>
            <div class="card-body">
                

                <div class="important-note">
                    <strong><i class="fas fa-exclamation-triangle me-2"></i>Important:</strong> 
                    Abstracts and full papers must align with one of the conference sub-themes. 
                    Authors will participate in peer review and mentorship.
                </div>

 
                <div class="author-removal-notice">
                    <strong><i class="fas fa-user-slash me-2"></i>Author Anonymisation Required:</strong>
                    Kindly <strong>remove / delete ALL author details and affiliation</strong> from the paper before uploading it. This is required to ensure a fair, double-blind peer review process.
                </div>

                <div class="guidelines-section">
                    <h6><i class="fas fa-file-alt me-2"></i>Manuscript Requirements</h6>
                    <ul>
                        <li><strong>Maximum Length:</strong> <span style="color: red; font-weight: bold;">Not more than 3000 words</span></li>
                        <li><strong>Language:</strong> British English</li>
                        <li><strong>Paper Size:</strong> A4</li>
                        <li><strong>Spacing:</strong> Double-spaced</li>
                        <li><strong>Font:</strong> Times New Roman, size 12</li>
                        <li><strong>Page Numbers:</strong> Consecutively numbered</li>
                        <li><strong>File Format:</strong> MS Word for Windows 2003, 2007 to 2016 (.doc, .docx)</li>
                    </ul>

                    <h6><i class="fas fa-sort-numeric-down me-2"></i>Number Formatting</h6>
                    <ul>
                        <li>Numbers 1-10 should be written in words in the text</li>
                        <li>Numbers 11 to infinity should be in numeral form</li>
                        <li>Numbers at the beginning of a sentence should always be written in words</li>
                    </ul>

                    <h6><i class="fas fa-list-ol me-2"></i>Required Sections</h6>
                    <p>Your paper must include the following sections in order:</p>
                    <ol>
                        <li>Abstract</li>
                        <li>Introduction</li>
                        <li>Materials and Methods</li>
                        <li>Results</li>
                        <li>Discussion</li>
                        <li>Conclusion</li>
                        <li>Recommendations</li>
                        <li>Acknowledgment</li>
                        <li>References</li>
                    </ol>

                    <h6><i class="fas fa-microscope me-2"></i>Scientific and Common Names</h6>
                    <ul>
                        <li>Scientific names must be given for each organism with authority the first time used</li>
                        <li>Species and genera names must be <em>italicized</em></li>
                        <li>For other taxa, capitalize the first letter but do not italicize</li>
                        <li>Generic names may be abbreviated after first mention (not at sentence beginning)</li>
                        <li>Pesticide names should follow standard convention with correct chemical name on first mention</li>
                        <li>Use S.I. units for measurements</li>
                        <li>Equations should be done using Microsoft Equation Editor 3.1 or lower</li>
                    </ul>

                    <h6><i class="fas fa-image me-2"></i>Illustrations (Figures and Tables)</h6>
                    <ul>
                        <li>Must fit on one page and be clearly labelled</li>
                        <li>Figure captions must be placed <strong>below</strong> the figure</li>
                        <li>Tables must have table headings <strong>above</strong> the table</li>
                        <li>Use Microsoft Word table function for tables</li>
                        <li>Place figures and tables where they are first referred to in the text</li>
                        <li><strong>No provisions</strong> will be made for altering illustrations after submission</li>
                    </ul>

                    <h6><i class="fas fa-book me-2"></i>References</h6>
                    <p><strong>In-text citations:</strong></p>
                    <ul>
                        <li>Reference by author and year</li>
                        <li>Multiple publications per year: add letters (a, b, c) after year</li>
                        <li>More than two authors: first author followed by "et al."</li>
                    </ul>

                    <p><strong>Reference list format:</strong></p>
                    <ul>
                        <li>Journal names in <em>italics</em>, spelled out in full</li>
                        <li>Include Volume Number (and Issue Number if available)</li>
                        <li>Page numbers inclusive after colon following Volume Number</li>
                        <li>Books: title, publisher, city, total pages</li>
                        <li>Online sources: include URL, access date, and/or DOI</li>
                    </ul>

                    <p><strong>Examples:</strong></p>
                    
                    <p class="mb-1"><strong>Journal paper:</strong></p>
                    <div class="reference-example">
                        Ndungu, M.M., J.K. Lagat and J.K. Langat (2019). Determinants and causes of postharvest milk losses among milk producers in Nyandarua North subcounty, Kenya. <em>East African Agricultural and Forestry Journal</em> 83: 269-280. https://doi.org/10.1080/00128325.2019.1667648.
                    </div>

                    <p class="mb-1"><strong>Book chapter:</strong></p>
                    <div class="reference-example">
                        Namikoye, E.S., G.M. Kariuki, Z.M. Kinyua, M. Githendu and M. Kasina (2020). Enhancing monitoring efficiency and management of vectors of maize lethal necrosis disease in Kenya. In: Niassy, S., Ekesi, S., Migiro, L., Otieno, W. (eds) <em>Sustainable Management of Invasive Pests in Africa</em>. Sustainability in Plant and Crop Protection, vol 14: pp 125–137. Springer, Cham. https://doi.org/10.1007/978-3-030-41083-4_11.
                    </div>

                    <p class="mb-1"><strong>Conference proceedings:</strong></p>
                    <div class="reference-example">
                        Wambua, S., G. Mwenjeri and I. Macharia (2024). Production and marketing of improved indigenous chicken in selected counties of Kenya. In T. Karanja-Lumumba, I. Osuga, S. Mbuku, and E. Makokha (Eds.), <em>Resilient and Sustainable Food Systems Transformation Agenda: Making Climate Smart Livestock Production Future-Compliant</em>. Proceedings of the Annual Animal Production Society of Kenya (APSK) Scientific Symposium, held from 29th October to 1st November 2024, (pp. 226–233). Animal Production Society of Kenya (APSK).
                    </div>

                    <p class="mb-1"><strong>Book:</strong></p>
                    <div class="reference-example">
                        Singh G. (2025). <em>Principles of Animal Husbandry and Dairy Science</em>. Sura India Publication. ISBN No: - 978-81-989418-0-0.
                    </div>
                </div>

            </div>
        </div>
    </div>

 
    <div class="upload-container">
        <div class="upload-header">
            <h2><i class="fas fa-file-upload me-2"></i>Full Paper Upload</h2>
        </div>

        <div class="submission-info">
            <p><strong>Submission Code:</strong> {{ $abstract->submission_code }}</p>
            <p><strong>Author:</strong> {{ $abstract->author_name }}</p>
            <p><strong>Title:</strong> {{ $abstract->paper_title }}</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form id="uploadForm"
              method="POST"
              enctype="multipart/form-data"
              action="{{ route('full-papers.store', $abstract) }}">
            @csrf

            <input type="file" id="full_paper" name="full_paper"
                   class="d-none" accept=".doc,.docx" required>

            <div id="uploadArea" class="upload-area">
                <i class="fas fa-cloud-upload-alt fa-3x mb-3 text-muted"></i>
                <h5>Drag & Drop your file here</h5>
                <p class="text-muted">or click to browse</p>
                <small class="text-muted">Accepted formats: .doc, .docx</small>
            </div>

            <div id="fileInfo" class="file-info"></div>

            <div id="progressContainer" class="progress-container">
                <div class="progress">
                    <div id="uploadProgress"
                         class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                         style="width:0%"></div>
                </div>
                <div id="progressText" class="text-center mt-2">0%</div>
            </div>

            {{-- Author Removal Acknowledgement --}}
           <div id="acknowledgementBox" class="acknowledgement-box" style="display:none;">
    <div class="form-check d-flex align-items-start gap-2 mb-2">
        <input class="form-check-input flex-shrink-0"
               type="checkbox"
               name="author_removal_acknowledged"
               id="authorRemovalAck"
               value="1"
               required>
        <label class="form-check-label" for="authorRemovalAck">
            <i class="fas fa-user-slash me-1 text-warning"></i>
            I acknowledge that I have removed all author details and affiliation from the attached paper.
        </label>
    </div>
    <div class="form-check d-flex align-items-start gap-2">
        <input class="form-check-input flex-shrink-0"
               type="checkbox"
               name="peer_review_acknowledged"
               id="peerReviewAck"
               value="1"
               required>
        <label class="form-check-label" for="peerReviewAck">
            <i class="fas fa-users me-1 text-warning"></i>
            I agree to participate in the blind peer review process and to review papers submitted by other authors as required.
        </label>
    </div>
</div>

            <button id="submitBtn" class="btn btn-success submit-btn">
                <i class="fas fa-paper-plane me-2"></i>Submit Paper
            </button>
        </form>
    </div>


    <div class="container my-4">
        <div class="card shadow-sm border-warning">
            <div class="card-header bg-warning">
                <h5 class="mb-0">
                    <i class="fas fa-check-square me-2"></i>Pre-Submission Checklist
                </h5>
            </div>
            <div class="card-body">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="check1">
                    <label class="form-check-label" for="check1">
                        Paper does not exceed 3000 words
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="check2">
                    <label class="form-check-label" for="check2">
                        Written in British English, Times New Roman 12, double-spaced
                    </label>
                </div>
                
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="check4">
                    <label class="form-check-label" for="check4">
                        All required sections included (Abstract through References)
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="check5">
                    <label class="form-check-label" for="check5">
                        Scientific names properly formatted (italicized)
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="check6">
                    <label class="form-check-label" for="check6">
                        Figures and tables properly placed and labeled
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="check7">
                    <label class="form-check-label" for="check7">
                        References formatted correctly with examples provided
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="check8">
                    <label class="form-check-label" for="check8">
                        All author details and affiliation have been removed from the paper
                    </label>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(function () {
    const uploadArea = $('#uploadArea');
    const fileInput = $('#full_paper');
    const fileInfo = $('#fileInfo');
    const submitBtn = $('#submitBtn');
    const acknowledgementBox = $('#acknowledgementBox');

    uploadArea.on('click', () => fileInput.click());

    uploadArea.on('dragover', e => {
        e.preventDefault();
        uploadArea.addClass('active');
    });

    uploadArea.on('dragleave drop', () => {
        uploadArea.removeClass('active');
    });

    fileInput.on('change', () => {
        const file = fileInput[0].files[0];
        if (!file) return;

        fileInfo.html(`
            <div class="alert alert-info">
                <strong><i class="fas fa-file-word me-2"></i>File Selected:</strong> ${file.name}<br>
                <strong>Size:</strong> ${(file.size / 1048576).toFixed(2)} MB
            </div>
        `);

        acknowledgementBox.show();
        submitBtn.show();
    });
});
</script>

</body>
</html>
