<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KALRO SEPD Conference - Full Paper Upload</title>

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
    </style>
</head>
<body>

<!-- Top Bar -->
    <div class="col-lg-1 col-md-4 col-6">
        <div class="logo">
            <a href="/">
                <img src="{{asset('assets/images/kalro-logo.gif')}}" alt="KALRO Logo" class="img-fluid kalro-logo">
            </a>
        </div>
    </div>

    

<!-- Hero -->

<section class="hero">
    <div class="container text-center">
        <h1 class="theme-title"> <b>Conference Theme :</b> "Innovations for Sustainable Agri-food Systems, Climate Change Resilience and Improved Livelihoods" </h1>
    </div>
</section>

<div class="container">

    <!-- Guidelines -->
    <div class="container my-4">
        <div class="card shadow-sm w-100" style="background-color: #e6f9e6;">
            <div class="card-body">
            <h5 class="card-title text-success">
                <i class="fas fa-info-circle me-2"></i>Full Paper Upload Guidelines
            </h5>
            <p class="card-text">
                <strong>Title and Author Details:</strong><br>
                Include the paper title, author name(s), institutional affiliation(s), complete mailing addresses, and email(s). Clearly indicate the corresponding author.<br><br>

                <strong>Sections:</strong><br>
                Your paper should include the following sections: Abstract, Introduction, Materials and Methods, Results, Discussion, Conclusion, Recommendations, Acknowledgment, and References.<br><br>

                <strong>Maximum Length:</strong><br>
                <span style="color: red; font-weight: bold;">The full paper should not exceed 3000 words.</span><br><br>

                <strong>Language:</strong><br>
                All submissions must be written in British English.<br><br>

                <strong>Formatting:</strong><br>
                Use A4 paper, double-spacing, Times New Roman font, size 12.<br><br>

                <strong>File Format:</strong><br>
                Submit your document in MS Word format (compatible with Windows 2003, 2007–2016).
            </p>
            </div>
        </div>
    </div>

    <!-- Upload Box -->
    <div class="upload-container">
        <div class="upload-header">
            <h2><i class="fas fa-file-upload me-2"></i> Full Paper Upload</h2>
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
            </div>

            <div id="fileInfo" class="file-info"></div>

            <div id="progressContainer" class="progress-container">
                <div class="progress">
                    <div id="uploadProgress"
                         class="progress-bar progress-bar-striped progress-bar-animated"
                         style="width:0%"></div>
                </div>
                <div id="progressText" class="text-center mt-2">0%</div>
            </div>

            <button id="submitBtn" class="btn btn-success submit-btn">
                <i class="fas fa-paper-plane me-2"></i> Submit Paper
            </button>
        </form>
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
            <strong>File:</strong> ${file.name}<br>
            <strong>Size:</strong> ${(file.size / 1048576).toFixed(2)} MB
        `);

        submitBtn.show();
    });
});
</script>

</body>
</html>
