<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>KALRO Conference - Upload Presentation Materials</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<style>
body{
background-color:#f8f9fa;
font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;
}

.hero{
background:linear-gradient(135deg,#158532 0%,#0d5c23 100%);
color:white;
padding:3rem 0;
margin-bottom:2rem;
box-shadow:0 4px 12px rgba(0,0,0,.15);
}

.theme-title{
font-size:1.5rem;
font-weight:600;
line-height:1.6;
}

.logo-header{
background:white;
padding:1rem 0;
box-shadow:0 2px 4px rgba(0,0,0,.08);
margin-bottom:0;
}

.kalro-logo{
max-height:60px;
}

.upload-container{
max-width:900px;
margin:2rem auto;
background:white;
border-radius:10px;
box-shadow:0 4px 20px rgba(0,0,0,.1);
overflow:hidden;
}

.upload-header{
background-color:#158532;
color:white;
padding:1.5rem;
text-align:center;
}

.submission-info{
background-color:#f8f9fa;
padding:1.5rem;
border-radius:8px;
margin:1.5rem;
}

.upload-section{
padding:1.5rem;
border-bottom:1px solid #e9ecef;
}

.upload-area{
border:2px dashed #dee2e6;
border-radius:8px;
padding:2rem;
text-align:center;
cursor:pointer;
transition:all .3s;
margin-top:1rem;
}

.upload-area:hover{
border-color:#158532;
background-color:#f0f9f1;
}

.upload-area.active{
border-color:#158532;
background-color:#e8f5e9;
}

.file-info{
margin-top:1rem;
padding:1rem;
background:#e8f5e9;
border-radius:8px;
font-size:.9rem;
display:none;
}

.file-info.show{
display:block;
}

.submit-btn{
width:calc(100% - 3rem);
margin:1.5rem;
padding:.75rem;
font-weight:600;
background:#158532;
border:none;
}

.section-icon{
width:50px;
height:50px;
border-radius:50%;
display:flex;
align-items:center;
justify-content:center;
font-size:24px;
margin-bottom:1rem;
}

.icon-ppt{background:#fef3c7;color:#92400e;}
.icon-poster{background:#dbeafe;color:#1e40af;}
.icon-docs{background:#e0e7ff;color:#5b21b6;}

.file-type-badge{
display:inline-block;
padding:4px 10px;
border-radius:12px;
font-size:11px;
font-weight:700;
text-transform:uppercase;
margin-left:8px;
}

.badge-required{background:#fee2e2;color:#991b1b;}
.badge-optional{background:#e0e7ff;color:#3730a3;}

.guidelines-card{
background-color:#e6f9e6;
border-left:4px solid #158532;
}
</style>
</head>

<body>

<div class="logo-header">
<div class="container">
<div class="row align-items-center">
<div class="col-md-2">
<img src="{{ asset('assets/images/kalro-logo.gif') }}" class="kalro-logo">
</div>

<div class="col-md-10">
<h4 class="mb-0 text-success">2nd KALRO Scientific Conference and Exhibition</h4>
<p class="mb-0 text-muted small">Presentation Materials Upload Portal</p>
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

<div class="alert alert-success shadow-sm mb-4">
<h5 class="alert-heading">
<i class="fas fa-trophy me-2"></i>Congratulations! Your Paper Has Been Approved
</h5>
<p class="mb-0">
Your full paper has been reviewed and accepted for presentation at the conference.
Please upload your presentation materials below.
</p>
</div>

<div class="card shadow-sm mb-4 guidelines-card">
<div class="card-body">
<h5 class="text-success">
<i class="fas fa-info-circle me-2"></i>Upload Guidelines
</h5>

<ul>
<li><b>PowerPoint:</b> ppt, pptx (Max 20MB)</li>
<li><b>Poster:</b> pdf, jpg, png (Max 10MB)</li>
<li><b>Supporting docs:</b> pdf, doc, zip (Max 15MB)</li>
</ul>
</div>
</div>

<div class="upload-container">

<div class="upload-header">
<h2><i class="fas fa-file-upload me-2"></i>Upload Presentation Materials</h2>
</div>

<div class="submission-info">

<div class="row">

<div class="col-md-6">
<p><b>Paper ID:</b> FP-{{ str_pad($fullPaper->id,4,'0',STR_PAD_LEFT) }}</p>
<p><b>Submission Code:</b> {{ $fullPaper->abstract->submission_code }}</p>
<p><b>Author:</b> {{ $fullPaper->abstract->author_name }}</p>
</div>

<div class="col-md-6">
<p><b>Title:</b> {{ $fullPaper->abstract->paper_title }}</p>
<p><b>Status:</b> <span class="badge bg-success">{{ $fullPaper->status }}</span></p>
<p><b>Presentation Type:</b>
<span class="badge bg-primary">
{{ ucfirst($fullPaper->presentation_type) }}
</span>
</p>
</div>

</div>
</div>

<form method="POST"
action="{{ route('fullpaper.presentation.submit',$fullPaper->id) }}"
enctype="multipart/form-data">
@csrf

{{-- POWERPOINT SECTION --}}
@if(strtolower($fullPaper->presentation_type) == 'powerpoint')

<div class="upload-section">

<div class="d-flex">

<div class="section-icon icon-ppt me-3">
<i class="fas fa-file-powerpoint"></i>
</div>

<div class="flex-grow-1">

<h6 class="text-success">
PowerPoint Presentation
<span class="file-type-badge badge-required">Required</span>
</h6>

<input type="file"
id="powerpoint_file"
name="powerpoint_file"
class="d-none"
accept=".ppt,.pptx">

<div id="pptUploadArea" class="upload-area">
<i class="fas fa-cloud-upload-alt fa-3x mb-3 text-muted"></i>
<h6>Click to Upload PowerPoint</h6>
<p class="text-muted mb-0">or drag and drop</p>
</div>

<div id="pptFileInfo" class="file-info">
<p><b id="pptFileName"></b></p>
<p class="small text-muted">Size: <span id="pptFileSize"></span></p>
<button type="button" class="btn btn-sm btn-outline-danger" onclick="removePPT()">Remove</button>
</div>

</div>
</div>
</div>

@endif


{{-- POSTER SECTION --}}
@if(strtolower($fullPaper->presentation_type) == 'poster')

<div class="upload-section">

<div class="d-flex">

<div class="section-icon icon-poster me-3">
<i class="fas fa-image"></i>
</div>

<div class="flex-grow-1">

<h6 class="text-primary">
Poster Upload
<span class="file-type-badge badge-required">Required</span>
</h6>

<input type="file"
id="poster_file"
name="poster_file"
class="d-none"
accept=".pdf,.jpg,.png">

<div id="posterUploadArea" class="upload-area">
<i class="fas fa-cloud-upload-alt fa-3x mb-3 text-muted"></i>
<h6>Click to Upload Poster</h6>
<p class="text-muted mb-0">or drag and drop</p>
</div>

<div id="posterFileInfo" class="file-info">
<p><b id="posterFileName"></b></p>
<p class="small text-muted">Size: <span id="posterFileSize"></span></p>
<button type="button" class="btn btn-sm btn-outline-danger" onclick="removePoster()">Remove</button>
</div>

</div>
</div>
</div>

@endif


{{-- SUPPORTING DOCUMENTS --}}
<div class="upload-section">

<div class="d-flex">

<div class="section-icon icon-docs me-3">
<i class="fas fa-paperclip"></i>
</div>

<div class="flex-grow-1">

<h6 class="text-secondary">
Supporting Documents
<span class="file-type-badge badge-optional">Optional</span>
</h6>

<input type="file"
id="supporting_docs"
name="supporting_docs[]"
multiple
class="d-none"
accept=".pdf,.doc,.docx,.zip">

<div id="docsUploadArea" class="upload-area">
<i class="fas fa-cloud-upload-alt fa-3x mb-3 text-muted"></i>
<h6>Upload Supporting Documents</h6>
</div>

<div id="docsFileInfo" class="file-info">
<div id="docsFileList"></div>
</div>

</div>
</div>
</div>

<button type="submit" id="submitBtn" class="btn btn-success submit-btn" disabled>
<i class="fas fa-paper-plane me-2"></i>Submit Materials
</button>

</form>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

$(function(){

const submitBtn=$("#submitBtn");

const pptInput=$("#powerpoint_file");
const posterInput=$("#poster_file");

function checkSubmit(){

let hasFile=false;

if(pptInput.length && pptInput[0].files.length>0){
hasFile=true;
}

if(posterInput.length && posterInput[0].files.length>0){
hasFile=true;
}

submitBtn.prop("disabled",!hasFile);

}

$("#pptUploadArea").on("click",()=>pptInput.click());

pptInput.on("change",function(){

const file=this.files[0];

if(!file)return;

$("#pptFileName").text(file.name);
$("#pptFileSize").text((file.size/1048576).toFixed(2)+" MB");

$("#pptFileInfo").addClass("show");
$("#pptUploadArea").hide();

checkSubmit();

});

$("#posterUploadArea").on("click",()=>posterInput.click());

posterInput.on("change",function(){

const file=this.files[0];

if(!file)return;

$("#posterFileName").text(file.name);
$("#posterFileSize").text((file.size/1048576).toFixed(2)+" MB");

$("#posterFileInfo").addClass("show");
$("#posterUploadArea").hide();

checkSubmit();

});

window.removePPT=function(){

pptInput.val("");
$("#pptFileInfo").removeClass("show");
$("#pptUploadArea").show();

checkSubmit();

}

window.removePoster=function(){

posterInput.val("");
$("#posterFileInfo").removeClass("show");
$("#posterUploadArea").show();

checkSubmit();

}

});

</script>

</body>
</html>