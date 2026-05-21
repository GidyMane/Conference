<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>KALRO Conference - Submission Closed</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<style>

body{
    background:#f5f7fa;
    font-family:Arial,sans-serif;
}

.hero{
    background:linear-gradient(
        135deg,
        #158532,
        #0d5c23
    );

    color:white;
    padding:40px 0;
    margin-bottom:40px;
}

.theme-title{
    font-size:1.6rem;
    font-weight:700;
}

.notice-container{
    max-width:900px;
    margin:auto;
}

.deadline-banner{

    background:linear-gradient(
        135deg,
        #b91c1c,
        #dc2626
    );

    color:white;

    padding:40px;

    border-radius:15px;

    text-align:center;

    box-shadow:
    0 8px 30px rgba(0,0,0,.15);

    margin-bottom:30px;
}

.deadline-banner h1{
    font-size:2rem;
    font-weight:700;
}

.deadline-date{

    display:inline-block;

    padding:10px 20px;

    border-radius:30px;

    background:#fef3c7;

    color:#991b1b;

    font-weight:bold;

    margin:20px 0;
}

.notice-card{

    background:white;

    border-radius:12px;

    padding:30px;

    box-shadow:
    0 5px 20px rgba(0,0,0,.08);

    margin-bottom:30px;
}

.notice-title{
    color:#dc2626;
    font-weight:700;
}

.submission-card{

    background:white;

    border-radius:12px;

    padding:25px;

    box-shadow:
    0 4px 15px rgba(0,0,0,.08);

}

.locked-upload{

    border:2px dashed #ccc;

    border-radius:10px;

    padding:50px;

    text-align:center;

    background:#fafafa;

    opacity:.6;

}

.locked-upload i{
    color:#dc2626;
}

.disabled-button{
    width:100%;
    margin-top:20px;
}

.footer-note{

    text-align:center;

    margin-top:30px;

    color:#6c757d;

}

</style>
</head>

<body>


<div class="container-fluid bg-white shadow-sm py-3">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-md-3 col-6">

                <img
                src="{{asset('assets/images/kalro-logo.gif')}}"
                class="img-fluid"
                style="max-height:60px;"
                >

            </div>

            <div class="col-md-9 col-6 text-end">

                <h5 class="text-success m-0">
                    2nd KALRO Scientific Conference
                </h5>

            </div>

        </div>
    </div>
</div>



<section class="hero">

<div class="container text-center">

<h2 class="theme-title">

Conference Theme:

"Innovations for Sustainable Agri-food Systems,
Climate Change Resilience and Improved Livelihoods"

</h2>

</div>

</section>


<div class="container notice-container">


<div class="deadline-banner">

<i class="fas fa-calendar-times fa-4x mb-4"></i>

<h1>
Paper Submission Closed
</h1>

<div class="deadline-date">

Final Submission Deadline:
22nd May 2026

</div>

<p class="mt-3">

The deadline for submission of accepted full papers
has now officially passed.

</p>

<p>

Thank you to all authors who successfully submitted
their papers.

</p>

</div>



<div class="notice-card">

<h4 class="notice-title">

<i class="fas fa-exclamation-circle me-2"></i>

Notice to Authors

</h4>

<hr>

<p>

Dear Authors,

</p>

<p>

The submission window for accepted full papers has
officially closed.

The final submission deadline was:

<strong>22nd May 2026</strong>

</p>

<p>

The online system is no longer accepting new paper uploads.

Submitted papers will proceed to the next stages of:

</p>

<ul>

<li>Peer review</li>

<li>Editorial processing</li>

<li>Conference scheduling</li>

<li>Final programme preparation</li>

</ul>

<div class="alert alert-warning mt-4">

<i class="fas fa-info-circle me-2"></i>

For exceptional circumstances or enquiries,
please contact the conference secretariat.

</div>

</div>



<div class="submission-card">

<h4>

<i class="fas fa-file-alt me-2"></i>

Submission Information

</h4>

<hr>


<p>

<strong>Submission Code:</strong>

{{ $abstract->submission_code }}

</p>


<p>

<strong>Author:</strong>

{{ $abstract->author_name }}

</p>


<p>

<strong>Paper Title:</strong>

{{ $abstract->paper_title }}

</p>



<div class="locked-upload">

<i class="fas fa-lock fa-4x mb-3"></i>

<h4>

Uploads Disabled

</h4>

<p>

The paper submission deadline has passed.

</p>

<small>

New uploads are no longer accepted.

</small>

</div>


<button
class="btn btn-secondary disabled-button"
disabled
>

<i class="fas fa-ban me-2"></i>

Submission Closed

</button>

</div>


<div class="footer-note">

© {{ date('Y') }}

KALRO Scientific Conference

</div>

</div>


</body>
</html>