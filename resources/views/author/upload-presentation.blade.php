<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Presentation - KALRO Conference</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .upload-header {
            background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
            padding: 40px 0;
            color: white;
        }
        .upload-card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,.1);
        }
        .file-drop-zone {
            border: 3px dashed #d1d5db;
            border-radius: 12px;
            padding: 40px;
            text-align: center;
            transition: all .3s;
            cursor: pointer;
        }
        .file-drop-zone:hover {
            border-color: #16a34a;
            background: #f0fdf4;
        }
        .file-drop-zone.has-file {
            border-color: #16a34a;
            background: #dcfce7;
        }
    </style>
</head>
<body>

<div class="upload-header">
    <div class="container text-center">
        <i class="fas fa-trophy fa-3x mb-3"></i>
        <h2>Congratulations! Your Paper is Approved</h2>
        <p class="mb-0">Upload your presentation materials for the conference</p>
    </div>
</div>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            {{-- Paper Info --}}
            <div class="card upload-card mb-4">
                <div class="card-body">
                    <h5 class="text-success mb-3">{{ $paper->abstract->paper_title }}</h5>
                    <p class="mb-0">
                        <strong>Paper ID:</strong> FP-{{ str_pad($paper->id, 4, '0', STR_PAD_LEFT) }}
                        &nbsp;·&nbsp;
                        <strong>Author:</strong> {{ $paper->abstract->author_name }}
                    </p>
                </div>
            </div>

            {{-- Upload Form --}}
            <div class="card upload-card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-upload me-2"></i>Upload Presentation Materials
                    </h5>
                </div>
                <div class="card-body p-4">
                    
                    <form method="POST" action="{{ route('fullpaper.upload-presentation.submit', $token) }}" enctype="multipart/form-data">
                        @csrf
                        
                        {{-- PowerPoint Upload --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-file-powerpoint text-danger me-2"></i>
                                PowerPoint Presentation
                            </label>
                            <div class="file-drop-zone" id="pptZone">
                                <input type="file" 
                                       name="powerpoint_file" 
                                       id="pptFile" 
                                       accept=".ppt,.pptx" 
                                       class="d-none">
                                <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                <p class="mb-2">Click to upload PowerPoint file</p>
                                <p class="text-muted small mb-0">PPT, PPTX · Max 20MB</p>
                                <p class="text-success fw-bold mt-2 d-none" id="pptName"></p>
                            </div>
                        </div>

                        {{-- Poster Upload --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-image text-primary me-2"></i>
                                Poster
                            </label>
                            <div class="file-drop-zone" id="posterZone">
                                <input type="file" 
                                       name="poster_file" 
                                       id="posterFile" 
                                       accept=".pdf,.jpg,.jpeg,.png" 
                                       class="d-none">
                                <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                <p class="mb-2">Click to upload Poster file</p>
                                <p class="text-muted small mb-0">PDF, JPG, PNG · Max 10MB</p>
                                <p class="text-success fw-bold mt-2 d-none" id="posterName"></p>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Note:</strong> Upload at least one file (PowerPoint or Poster). You can upload both if needed.
                        </div>

                        <button type="submit" class="btn btn-success btn-lg w-100">
                            <i class="fas fa-upload me-2"></i>Upload Materials
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<script>
// File upload handlers
document.getElementById('pptZone').addEventListener('click', () => {
    document.getElementById('pptFile').click();
});

document.getElementById('posterZone').addEventListener('click', () => {
    document.getElementById('posterFile').click();
});

document.getElementById('pptFile').addEventListener('change', function() {
    if (this.files[0]) {
        document.getElementById('pptName').textContent = this.files[0].name;
        document.getElementById('pptName').classList.remove('d-none');
        document.getElementById('pptZone').classList.add('has-file');
    }
});

document.getElementById('posterFile').addEventListener('change', function() {
    if (this.files[0]) {
        document.getElementById('posterName').textContent = this.files[0].name;
        document.getElementById('posterName').classList.remove('d-none');
        document.getElementById('posterZone').classList.add('has-file');
    }
});
</script>

</body>
</html>