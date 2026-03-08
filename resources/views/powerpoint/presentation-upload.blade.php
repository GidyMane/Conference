<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KALRO Conference - Upload Presentation Materials</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .hero {
            background: linear-gradient(135deg, #158532 0%, #0d5c23 100%);
            color: white;
            padding: 3rem 0;
            margin-bottom: 2rem;
            box-shadow: 0 4px 12px rgba(0,0,0,.15);
        }
        .theme-title {
            font-size: 1.5rem;
            font-weight: 600;
            line-height: 1.6;
        }
        .logo-header {
            background: white;
            padding: 1rem 0;
            box-shadow: 0 2px 4px rgba(0,0,0,.08);
            margin-bottom: 0;
        }
        .kalro-logo {
            max-height: 60px;
        }
        .upload-container {
            max-width: 900px;
            margin: 2rem auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .upload-header {
            background-color: #158532;
            color: white;
            padding: 1.5rem;
            text-align: center;
        }
        .submission-info {
            background-color: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            margin: 1.5rem;
        }
        .submission-info p {
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }
        .upload-section {
            padding: 1.5rem;
            border-bottom: 1px solid #e9ecef;
        }
        .upload-section:last-child {
            border-bottom: none;
        }
        .upload-area {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 1rem;
        }
        .upload-area.active {
            border-color: #158532;
            background-color: #e8f5e9;
        }
        .upload-area:hover {
            border-color: #158532;
            background-color: #f0f9f1;
        }
        .file-info {
            margin-top: 1rem;
            padding: 1rem;
            background: #e8f5e9;
            border-radius: 8px;
            font-size: 0.9rem;
            display: none;
        }
        .file-info.show {
            display: block;
        }
        .submit-btn {
            width: calc(100% - 3rem);
            margin: 1.5rem;
            padding: 0.75rem;
            font-weight: 600;
            background: #158532;
            border: none;
        }
        .submit-btn:hover {
            background: #0d5c23;
        }
        .submit-btn:disabled {
            background: #6c757d;
            cursor: not-allowed;
        }
        .guidelines-card {
            background-color: #e6f9e6;
            border-left: 4px solid #158532;
        }
        .file-type-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            margin-right: 8px;
        }
        .badge-required { background: #fee2e2; color: #991b1b; }
        .badge-optional { background: #e0e7ff; color: #3730a3; }
        .section-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 1rem;
        }
        .icon-ppt { background: #fef3c7; color: #92400e; }
        .icon-poster { background: #dbeafe; color: #1e40af; }
        .icon-docs { background: #e0e7ff; color: #5b21b6; }
    </style>
</head>
<body>

<!-- Logo Header -->
<div class="logo-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-2">
                <img src="{{ asset('assets/images/kalro-logo.gif') }}" alt="KALRO Logo" class="kalro-logo">
            </div>
            <div class="col-md-10">
                <h4 class="mb-0 text-success">2nd KALRO Scientific Conference and Exhibition</h4>
                <p class="mb-0 text-muted small">Presentation Materials Upload Portal</p>
            </div>
        </div>
    </div>
</div>

<!-- Hero -->
<section class="hero">
    <div class="container text-center">
        <h1 class="theme-title">
            <b>Conference Theme:</b> "Innovations for Sustainable Agri-food Systems, Climate Change Resilience and Improved Livelihoods"
        </h1>
    </div>
</section>

<div class="container">

    <!-- Congratulations Message -->
    <div class="alert alert-success shadow-sm mb-4">
        <h5 class="alert-heading">
            <i class="fas fa-trophy me-2"></i>Congratulations! Your Paper Has Been Approved
        </h5>
        <p class="mb-0">
            Your full paper has been reviewed and accepted for presentation at the conference. 
            Please upload your presentation materials below.
        </p>
    </div>

    <!-- Guidelines -->
    <div class="card shadow-sm mb-4 guidelines-card">
        <div class="card-body">
            <h5 class="card-title text-success">
                <i class="fas fa-info-circle me-2"></i>Presentation Materials Upload Guidelines
            </h5>
            <div class="card-text">
                <p><strong>Accepted File Formats:</strong></p>
                <ul>
                    <li><strong>PowerPoint Presentation:</strong> .ppt, .pptx (Maximum 20MB)</li>
                    <li><strong>Poster:</strong> .pdf, .jpg, .jpeg, .png (Maximum 10MB)</li>
                    <li><strong>Supporting Documents:</strong> .pdf, .doc, .docx, .zip (Maximum 15MB each)</li>
                </ul>
                
                <p class="mt-3"><strong>Requirements:</strong></p>
                <ul>
                    <li>Upload at least <strong>ONE</strong> presentation file (PowerPoint OR Poster)</li>
                    <li>Supporting documents are optional but recommended</li>
                    <li>Ensure all materials include your paper title and author details</li>
                    <li>Presentations should be clear, concise, and professionally formatted</li>
                    <li>File names should be descriptive (e.g., "Paper_Title_Presentation.pptx")</li>
                </ul>

                <div class="alert alert-warning mt-3 mb-0">
                    <i class="fas fa-clock me-2"></i>
                    <strong>Deadline:</strong> Please upload your materials at least 7 days before the conference date.
                </div>
            </div>
        </div>
    </div>

    <!-- Upload Container -->
    <div class="upload-container">
        <div class="upload-header">
            <h2><i class="fas fa-file-upload me-2"></i>Upload Presentation Materials</h2>
        </div>

        <div class="submission-info">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Paper ID:</strong> FP-{{ str_pad($fullPaper->id, 4, '0', STR_PAD_LEFT) }} </p>
                    <p><strong>Submission Code:</strong> {{ $fullPaper->abstract->submission_code ?? 'N/A' }}</p>
                    <p><strong>Author:</strong> {{ $fullPaper->abstract->author_name ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Title:</strong> {{ $fullPaper->abstract->paper_title ?? 'N/A' }}</p>
                    <p><strong>Decision:</strong> <span class="badge bg-success">{{ $fullPaper->status }}</span></p>
                    <p><strong>Presentation Type:</strong> <span class="badge bg-primary">{{ $fullPaper->abstract->presentation_preferencepresentation_type ?? 'Oral Presentation' }}</span></p>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success mx-3 shadow-sm">
                <h6 class="alert-heading">
                    <i class="fas fa-check-circle me-2"></i>Upload Successful!
                </h6>
                <p class="mb-0">{{ session('success') }}</p>
                @if(session('uploaded_files'))
                <hr>
                <p class="mb-1 small"><strong>Files uploaded:</strong></p>
                <ul class="mb-0 small">
                    @foreach(session('uploaded_files') as $file)
                        <li>{{ $file }}</li>
                    @endforeach
                </ul>
                @endif
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger mx-3">
                <h6 class="alert-heading">
                    <i class="fas fa-exclamation-triangle me-2"></i>Upload Failed
                </h6>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST"
            action="{{ route('fullpaper.presentation.submit', $fullPaper->id) }}"
            enctype="multipart/form-data">
            @csrf

            <!-- PowerPoint Upload Section -->
            <div class="upload-section">
                <div class="d-flex align-items-start">
                    <div class="section-icon icon-ppt me-3">
                        <i class="fas fa-file-powerpoint"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="text-success mb-2">
                            PowerPoint Presentation
                            <span class="file-type-badge badge-required">At least one required</span>
                        </h6>
                        <p class="text-muted small mb-3">
                            Upload your presentation slides for oral presentation or conference display.
                        </p>
                        
                        <input type="file" 
                               id="powerpoint_file" 
                               name="powerpoint_file" 
                               class="d-none" 
                               accept=".ppt,.pptx">
                        
                        <div id="pptUploadArea" class="upload-area">
                            <i class="fas fa-cloud-upload-alt fa-3x mb-3 text-muted"></i>
                            <h6>Click to Upload PowerPoint</h6>
                            <p class="text-muted mb-0">or drag and drop here</p>
                            <small class="text-muted d-block mt-2">PPT, PPTX • Max 20MB</small>
                        </div>

                        <div id="pptFileInfo" class="file-info">
                            <i class="fas fa-file-powerpoint text-danger fa-2x mb-2"></i>
                            <p class="mb-1"><strong id="pptFileName"></strong></p>
                            <p class="mb-0 small text-muted">Size: <span id="pptFileSize"></span></p>
                            <button type="button" class="btn btn-sm btn-outline-danger mt-2" onclick="removePPT()">
                                <i class="fas fa-times me-1"></i>Remove File
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Poster Upload Section -->
            <div class="upload-section">
                <div class="d-flex align-items-start">
                    <div class="section-icon icon-poster me-3">
                        <i class="fas fa-image"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="text-primary mb-2">
                            Poster
                            <span class="file-type-badge badge-required">At least one required</span>
                        </h6>
                        <p class="text-muted small mb-3">
                            Upload your research poster for poster presentation sessions.
                        </p>
                        
                        <input type="file" 
                               id="poster_file" 
                               name="poster_file" 
                               class="d-none" 
                               accept=".pdf,.jpg,.jpeg,.png">
                        
                        <div id="posterUploadArea" class="upload-area">
                            <i class="fas fa-cloud-upload-alt fa-3x mb-3 text-muted"></i>
                            <h6>Click to Upload Poster</h6>
                            <p class="text-muted mb-0">or drag and drop here</p>
                            <small class="text-muted d-block mt-2">PDF, JPG, PNG • Max 10MB</small>
                        </div>

                        <div id="posterFileInfo" class="file-info">
                            <i class="fas fa-image text-primary fa-2x mb-2"></i>
                            <p class="mb-1"><strong id="posterFileName"></strong></p>
                            <p class="mb-0 small text-muted">Size: <span id="posterFileSize"></span></p>
                            <button type="button" class="btn btn-sm btn-outline-danger mt-2" onclick="removePoster()">
                                <i class="fas fa-times me-1"></i>Remove File
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Supporting Documents Section -->
            <div class="upload-section">
                <div class="d-flex align-items-start">
                    <div class="section-icon icon-docs me-3">
                        <i class="fas fa-paperclip"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="text-secondary mb-2">
                            Supporting Documents
                            <span class="file-type-badge badge-optional">Optional</span>
                        </h6>
                        <p class="text-muted small mb-3">
                            Upload supplementary materials (datasets, additional figures, appendices, etc.)
                        </p>
                        
                        <input type="file" 
                               id="supporting_docs" 
                               name="supporting_docs[]" 
                               class="d-none" 
                               accept=".pdf,.doc,.docx,.zip"
                               multiple>
                        
                        <div id="docsUploadArea" class="upload-area">
                            <i class="fas fa-cloud-upload-alt fa-3x mb-3 text-muted"></i>
                            <h6>Click to Upload Supporting Documents</h6>
                            <p class="text-muted mb-0">or drag and drop here</p>
                            <small class="text-muted d-block mt-2">PDF, DOC, DOCX, ZIP • Max 15MB each • Multiple files allowed</small>
                        </div>

                        <div id="docsFileInfo" class="file-info">
                            <i class="fas fa-paperclip text-secondary fa-2x mb-2"></i>
                            <p class="mb-1"><strong>Files Selected:</strong></p>
                            <div id="docsFileList"></div>
                            <button type="button" class="btn btn-sm btn-outline-danger mt-2" onclick="removeDocs()">
                                <i class="fas fa-times me-1"></i>Remove All Files
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upload Notice -->
            <div class="mx-3 mb-3">
                <div class="alert alert-info">
                    <h6 class="alert-heading">
                        <i class="fas fa-exclamation-circle me-2"></i>Before Submitting
                    </h6>
                    <ul class="mb-0 small">
                        <li>Ensure you have uploaded <strong>at least ONE</strong> file (PowerPoint OR Poster)</li>
                        <li>Check that all file sizes are within the allowed limits</li>
                        <li>Verify that your files are complete and not corrupted</li>
                        <li>You can update your materials later if needed before the deadline</li>
                    </ul>
                </div>
            </div>

            <button type="submit" id="submitBtn" class="btn btn-success submit-btn" disabled>
                <i class="fas fa-paper-plane me-2"></i>Submit Presentation Materials
            </button>
        </form>
    </div>

</div>

<!-- Footer -->
<div class="container my-5">
    <div class="alert alert-info">
        <h6><i class="fas fa-question-circle me-2"></i>Need Help?</h6>
        <p class="mb-0">
            If you encounter any issues uploading your materials, please contact us at 
            <strong>kalroconference2026@gmail.com</strong> or call <strong>0800 721741</strong>
        </p>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(function () {
    // PowerPoint Upload
    const pptUploadArea = $('#pptUploadArea');
    const pptFileInput = $('#powerpoint_file');
    const pptFileInfo = $('#pptFileInfo');

    // Poster Upload
    const posterUploadArea = $('#posterUploadArea');
    const posterFileInput = $('#poster_file');
    const posterFileInfo = $('#posterFileInfo');

    // Supporting Docs
    const docsUploadArea = $('#docsUploadArea');
    const docsFileInput = $('#supporting_docs');
    const docsFileInfo = $('#docsFileInfo');

    const submitBtn = $('#submitBtn');

    // PowerPoint handlers
    pptUploadArea.on('click', () => pptFileInput.click());
    
    pptUploadArea.on('dragover', e => {
        e.preventDefault();
        pptUploadArea.addClass('active');
    });
    
    pptUploadArea.on('dragleave drop', () => {
        pptUploadArea.removeClass('active');
    });

    pptFileInput.on('change', function() {
        const file = this.files[0];
        if (!file) return;

        $('#pptFileName').text(file.name);
        $('#pptFileSize').text((file.size / 1048576).toFixed(2) + ' MB');
        pptFileInfo.addClass('show');
        pptUploadArea.hide();
        checkSubmitButton();
    });

    // Poster handlers
    posterUploadArea.on('click', () => posterFileInput.click());
    
    posterUploadArea.on('dragover', e => {
        e.preventDefault();
        posterUploadArea.addClass('active');
    });
    
    posterUploadArea.on('dragleave drop', () => {
        posterUploadArea.removeClass('active');
    });

    posterFileInput.on('change', function() {
        const file = this.files[0];
        if (!file) return;

        $('#posterFileName').text(file.name);
        $('#posterFileSize').text((file.size / 1048576).toFixed(2) + ' MB');
        posterFileInfo.addClass('show');
        posterUploadArea.hide();
        checkSubmitButton();
    });

    // Supporting Docs handlers
    docsUploadArea.on('click', () => docsFileInput.click());
    
    docsUploadArea.on('dragover', e => {
        e.preventDefault();
        docsUploadArea.addClass('active');
    });
    
    docsUploadArea.on('dragleave drop', () => {
        docsUploadArea.removeClass('active');
    });

    docsFileInput.on('change', function() {
        const files = this.files;
        if (!files.length) return;

        let fileListHTML = '<ul class="mb-0">';
        for (let i = 0; i < files.length; i++) {
            const size = (files[i].size / 1048576).toFixed(2);
            fileListHTML += `<li>${files[i].name} (${size} MB)</li>`;
        }
        fileListHTML += '</ul>';

        $('#docsFileList').html(fileListHTML);
        docsFileInfo.addClass('show');
        docsUploadArea.hide();
        checkSubmitButton();
    });

    // Check if submit button should be enabled
    function checkSubmitButton() {
        const hasPPT = pptFileInput[0].files.length > 0;
        const hasPoster = posterFileInput[0].files.length > 0;
        
        if (hasPPT || hasPoster) {
            submitBtn.prop('disabled', false);
        } else {
            submitBtn.prop('disabled', true);
        }
    }

    // Remove functions
    window.removePPT = function() {
        pptFileInput.val('');
        pptFileInfo.removeClass('show');
        pptUploadArea.show();
        checkSubmitButton();
    };

    window.removePoster = function() {
        posterFileInput.val('');
        posterFileInfo.removeClass('show');
        posterUploadArea.show();
        checkSubmitButton();
    };

    window.removeDocs = function() {
        docsFileInput.val('');
        docsFileInfo.removeClass('show');
        docsUploadArea.show();
    };

    // Drag and drop for all areas
    $('.upload-area').on('drop', function(e) {
        e.preventDefault();
        const files = e.originalEvent.dataTransfer.files;
        const targetId = $(this).attr('id');
        
        if (targetId === 'pptUploadArea' && files.length > 0) {
            pptFileInput[0].files = files;
            pptFileInput.trigger('change');
        } else if (targetId === 'posterUploadArea' && files.length > 0) {
            posterFileInput[0].files = files;
            posterFileInput.trigger('change');
        } else if (targetId === 'docsUploadArea' && files.length > 0) {
            docsFileInput[0].files = files;
            docsFileInput.trigger('change');
        }
    });
});

// Handle form submission (for demo)
function handleSubmit(event) {
    event.preventDefault();
    
    const pptFile = document.getElementById('powerpoint_file').files[0];
    const posterFile = document.getElementById('poster_file').files[0];
    const docsFiles = document.getElementById('supporting_docs').files;
    
    let message = 'Files uploaded successfully!\n\n';
    
    if (pptFile) {
        message += `PowerPoint: ${pptFile.name} (${(pptFile.size / 1048576).toFixed(2)} MB)\n`;
    }
    if (posterFile) {
        message += `Poster: ${posterFile.name} (${(posterFile.size / 1048576).toFixed(2)} MB)\n`;
    }
    if (docsFiles.length > 0) {
        message += `Supporting Docs: ${docsFiles.length} file(s)\n`;
    }
    
    alert(message + '\nYou will be redirected to the success page...');
    
    // In production, the form would submit normally
    // window.location.href = '/fullpaper/presentation/success';
    
    return false;
}
</script>

</body>
</html>
