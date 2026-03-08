<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Upload Successful - KALRO Conference</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .success-container {
            max-width: 700px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(21,133,50,.2);
            overflow: hidden;
        }
        .success-header {
            background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
            color: white;
            padding: 50px 40px;
            text-align: center;
        }
        .success-icon {
            width: 100px;
            height: 100px;
            background: rgba(255,255,255,.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            animation: scaleIn 0.5s ease-out;
        }
        @keyframes scaleIn {
            from { transform: scale(0); }
            to { transform: scale(1); }
        }
        .checkmark {
            font-size: 60px;
            animation: checkmarkPop 0.3s 0.3s ease-out forwards;
            opacity: 0;
        }
        @keyframes checkmarkPop {
            from { opacity: 0; transform: scale(0); }
            to { opacity: 1; transform: scale(1); }
        }
        .success-body {
            padding: 40px;
        }
        .uploaded-files {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
        }
        .file-item {
            display: flex;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .file-item:last-child {
            border-bottom: none;
        }
        .file-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 20px;
        }
        .icon-ppt { background: #fef3c7; color: #92400e; }
        .icon-poster { background: #dbeafe; color: #1e40af; }
        .icon-docs { background: #e0e7ff; color: #5b21b6; }
        .next-steps {
            background: #eff6ff;
            border-left: 4px solid #3b82f6;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .btn-primary-custom {
            background: #16a34a;
            border: none;
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 8px;
        }
        .btn-primary-custom:hover {
            background: #15803d;
        }
    </style>
</head>
<body>

<div class="success-container">
    <div class="success-header">
        <div class="success-icon">
            <i class="fas fa-check checkmark"></i>
        </div>
        <h2 class="mb-2">Upload Successful!</h2>
        <p class="mb-0">Your presentation materials have been received</p>
    </div>
    
    <div class="success-body">
        <div class="text-center mb-4">
            <h5 class="text-success mb-3">Thank You, {{ $fullPaper->abstract->author_name ?? 'Dr. Sarah Njeri' }}!</h5>
            <p class="text-muted">
                Your materials for <strong>"{{ $fullPaper->abstract->paper_title ?? 'Genetic Improvement of Drought-Resistant Crop Varieties' }}"</strong> 
                have been successfully uploaded.
            </p>
        </div>

        <!-- Uploaded Files Summary -->
        <div class="uploaded-files">
            <h6 class="mb-3"><i class="fas fa-check-circle text-success me-2"></i>Files Uploaded</h6>
            
            @if(session('uploaded_powerpoint'))
            <div class="file-item">
                <div class="file-icon icon-ppt">
                    <i class="fas fa-file-powerpoint"></i>
                </div>
                <div class="flex-grow-1">
                    <p class="mb-0 fw-bold">PowerPoint Presentation</p>
                    <small class="text-muted">{{ session('uploaded_powerpoint') }}</small>
                </div>
                <i class="fas fa-check-circle text-success"></i>
            </div>
            @endif

            @if(session('uploaded_poster'))
            <div class="file-item">
                <div class="file-icon icon-poster">
                    <i class="fas fa-image"></i>
                </div>
                <div class="flex-grow-1">
                    <p class="mb-0 fw-bold">Poster</p>
                    <small class="text-muted">{{ session('uploaded_poster') }}</small>
                </div>
                <i class="fas fa-check-circle text-success"></i>
            </div>
            @endif

            @if(session('uploaded_docs_count'))
            <div class="file-item">
                <div class="file-icon icon-docs">
                    <i class="fas fa-paperclip"></i>
                </div>
                <div class="flex-grow-1">
                    <p class="mb-0 fw-bold">Supporting Documents</p>
                    <small class="text-muted">{{ session('uploaded_docs_count') }} file(s) uploaded</small>
                </div>
                <i class="fas fa-check-circle text-success"></i>
            </div>
            @endif

            {{-- DEMO DATA FALLBACK --}}
            @if(!session('uploaded_powerpoint') && !session('uploaded_poster'))
            <div class="file-item">
                <div class="file-icon icon-ppt">
                    <i class="fas fa-file-powerpoint"></i>
                </div>
                <div class="flex-grow-1">
                    <p class="mb-0 fw-bold">PowerPoint Presentation</p>
                    <small class="text-muted">Presentation_Drought_Resistant_Crops.pptx (3.2 MB)</small>
                </div>
                <i class="fas fa-check-circle text-success"></i>
            </div>
            <div class="file-item">
                <div class="file-icon icon-docs">
                    <i class="fas fa-paperclip"></i>
                </div>
                <div class="flex-grow-1">
                    <p class="mb-0 fw-bold">Supporting Documents</p>
                    <small class="text-muted">2 file(s) uploaded</small>
                </div>
                <i class="fas fa-check-circle text-success"></i>
            </div>
            @endif
        </div>

        <!-- Next Steps -->
        <div class="next-steps">
            <h6 class="text-primary mb-3">
                <i class="fas fa-info-circle me-2"></i>What Happens Next?
            </h6>
            <ol class="mb-0">
                <li class="mb-2">Your materials will be reviewed by our technical team within <strong>48 hours</strong></li>
                <li class="mb-2">You will receive a confirmation email with your presentation schedule</li>
                <li class="mb-2">You can update your materials anytime before the conference deadline</li>
                <li class="mb-0">Conference logistics and program details will be sent 5 days before the event</li>
            </ol>
        </div>

        <!-- Submission Details -->
        <div class="row text-center my-4">
            <div class="col-md-6 mb-3">
                <div class="p-3 bg-light rounded">
                    <i class="fas fa-calendar-check text-success fa-2x mb-2"></i>
                    <p class="mb-0 small text-muted">Uploaded On</p>
                    <p class="mb-0 fw-bold">{{ now()->format('M d, Y H:i') }}</p>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="p-3 bg-light rounded">
                    <i class="fas fa-hashtag text-primary fa-2x mb-2"></i>
                    <p class="mb-0 small text-muted">Paper ID</p>
                    <p class="mb-0 fw-bold">FP-{{ str_pad($fullPaper->id ?? '0005', 4, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex gap-2 flex-wrap justify-content-center">
            <a href="{{ route('fullpaper.presentation.upload', $fullPaper->id ?? 5) }}" class="btn btn-outline-success">
                <i class="fas fa-edit me-2"></i>Update Materials
            </a>
            <a href="{{ url('/') }}" class="btn btn-primary-custom">
                <i class="fas fa-home me-2"></i>Back to Home
            </a>
            <button onclick="window.print()" class="btn btn-outline-secondary">
                <i class="fas fa-print me-2"></i>Print Confirmation
            </button>
        </div>

        <!-- Help Section -->
        <div class="text-center mt-4 pt-4 border-top">
            <p class="text-muted small mb-2">
                <i class="fas fa-envelope me-2"></i>
                Questions? Contact us at <strong>kalroconference2026@gmail.com</strong>
            </p>
            <p class="text-muted small mb-0">
                <i class="fas fa-phone me-2"></i>
                Or call <strong>0800 721741</strong>
            </p>
        </div>
    </div>
</div>

<script>
// Auto-redirect after 30 seconds (optional)
// setTimeout(() => {
//     window.location.href = "{{ url('/') }}";
// }, 30000);
</script>

</body>
</html>
