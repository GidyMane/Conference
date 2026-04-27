@extends('layouts.header')

@section('title')
    Home
@endsection

@section('content')

<!-- ================= HERO CAROUSEL ================= -->
<section class="hero-section">
    <div id="mainCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">

        <!-- Indicators -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="2"></button>
        </div>

        <!-- Slides -->
        <div class="carousel-inner">

            <!-- Slide 1 — Registration Now Open -->
            <div class="carousel-item active">
                <img src="assets/images/banner1.jpg" class="d-block w-100" alt="KALRO Conference Banner">
                <div class="carousel-caption">
                    <span class="badge bg-warning text-dark fs-6 mb-3 px-3 py-2">
                        <i class="fas fa-star me-1"></i> Registration Now Open
                    </span>
                    <h2 class="display-5 fw-bold">2nd KALRO Scientific Conference and Exhibition</h2>
                    <p class="lead">15th – 19th June 2026 &nbsp;|&nbsp; Innovating for Resilience, Scaling for Impact</p>

                    <div class="d-flex justify-content-center gap-3 flex-wrap mt-3">
                        <a href="/conference/register" class="btn btn-warning btn-lg fw-bold">
                            <i class="fas fa-user-check me-2"></i>Register as Participant
                        </a>
                        <a href="/exhibition/register" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-store me-2"></i>Register as Exhibitor
                        </a>
                    </div>
                </div>
            </div>

            <!-- Slide 2 — Participants -->
            <div class="carousel-item">
                <img src="assets/images/banner2.jpg" class="d-block w-100" alt="Conference Venue">
                <div class="carousel-caption">
                    <span class="badge bg-success fs-6 mb-3 px-3 py-2">
                        <i class="fas fa-check-circle me-1"></i> Spots Still Available
                    </span>
                    <h2 class="display-5 fw-bold">Secure Your Place at the Conference</h2>
                    <p class="lead">
                        Learn from experts, network with peers, and participate in impactful discussions.<br>
                        <strong>Early bird registration ends 22nd May 2026.</strong>
                    </p>

                    <a href="/conference/register" class="btn btn-warning btn-lg fw-bold mt-3">
                        <i class="fas fa-users me-2"></i>Register Now
                    </a>
                </div>
            </div>

            <!-- Slide 3 — Exhibitors -->
            <div class="carousel-item">
                <img src="assets/images/banner1.jpg" class="d-block w-100" alt="Networking Opportunities">
                <div class="carousel-caption">
                    <span class="badge bg-warning text-dark fs-6 mb-3 px-3 py-2">
                        <i class="fas fa-store me-1"></i> Exhibitor Spaces Available
                    </span>
                    <h2 class="display-5 fw-bold">Showcase Your Innovation</h2>
                    <p class="lead">
                        Present your products and services to researchers, policymakers, and industry leaders.
                    </p>

                    <div class="d-flex justify-content-center gap-3 flex-wrap mt-3">
                        <a href="/exhibition/register" class="btn btn-warning btn-lg fw-bold">
                            <i class="fas fa-store me-2"></i>Register as Exhibitor
                        </a>
                        <a href="/conference-procedure" class="btn btn-outline-light btn-lg">
                            Conference Details
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>

    </div>
</section>


<!-- ================= REGISTRATION OPEN BANNER ================= -->
<section class="py-3 bg-warning">
    <div class="container text-center">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fas fa-bell me-2"></i>
            Registration is Now Open! &nbsp;—&nbsp;
            Early bird pricing ends <strong>22nd May 2026</strong>.
            &nbsp;
            <a href="/conference/register" class="btn btn-dark btn-sm ms-2">Register Now</a>
            <a href="/exhibition/register" class="btn btn-outline-dark btn-sm ms-2">Exhibitor Registration</a>
        </h5>
    </div>
</section>


<!-- ================= CONFERENCE THEME ================= -->
<section class="conference-theme py-5 bg-light">
    <div class="container text-center">
        <h2 class="display-5 fw-bold text-success mb-4">
            <i class="fas fa-leaf me-2"></i>Conference Theme
        </h2>

        <h4 class="fw-semibold mb-4">
            Innovating towards Resilient Agri-food Systems for Climate Action,
            Food Security and Sustainable Livelihoods
        </h4>

        <p class="lead mx-auto" style="max-width: 900px;">
            The conference brings together researchers, policymakers, practitioners,
            and industry players to explore innovative and climate-smart approaches
            that strengthen agri-food systems, enhance resilience to climate change,
            improve food and nutrition security, and support sustainable livelihoods.
        </p>
    </div>
</section>


<!-- ================= QUICK STATS ================= -->
<section class="quick-stats py-5 bg-light">
    <div class="container">
        <div class="row text-center">

            <div class="col-md-3 col-6 mb-4">
                <div class="stat-card">
                    <i class="fas fa-calendar-alt fa-3x text-success mb-3"></i>
                    <h3>5</h3>
                    <p>Conference Days</p>
                </div>
            </div>

            <div class="col-md-3 col-6 mb-4">
                <div class="stat-card">
                    <i class="fas fa-users fa-3x text-success mb-3"></i>
                    <h3>500+</h3>
                    <p>Expected Participants</p>
                </div>
            </div>

            <div class="col-md-3 col-6 mb-4">
                <div class="stat-card">
                    <i class="fas fa-microphone fa-3x text-success mb-3"></i>
                    <h3>50+</h3>
                    <p>Speakers</p>
                </div>
            </div>

            <div class="col-md-3 col-6 mb-4">
                <div class="stat-card">
                    <i class="fas fa-file-alt fa-3x text-success mb-3"></i>
                    <h3>100+</h3>
                    <p>Papers</p>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- ================= MID PAGE CTA ================= -->
<section class="py-4 bg-white border-top border-bottom">
    <div class="container text-center">

        <h4 class="fw-bold text-success mb-1">
            <i class="fas fa-door-open me-2"></i>Registration is Now Open
        </h4>
        <p class="text-muted mb-3">Join us at the 2nd KALRO Scientific Conference &amp; Exhibition, 15–19 June 2026</p>

        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="/conference/register" class="btn btn-success btn-lg fw-bold">
                <i class="fas fa-user-check me-2"></i>Register as Participant
            </a>
            <a href="/exhibition/register" class="btn btn-warning btn-lg fw-bold">
                <i class="fas fa-store me-2"></i>Become an Exhibitor
            </a>
        </div>

    </div>
</section>


<!-- ================= MAIN CONTENT ================= -->
<section class="main-content py-5">
    <div class="container">

        <div class="row mb-5">

            <!-- Welcome -->
            <div class="col-lg-8">
                <div class="welcome-section">

                    <h1 class="display-4 mb-4 text-success">
                        <i class="fas fa-seedling me-3"></i>
                        Welcome to KALRO 2nd Scientific Conference and Exhibition 2026
                    </h1>

                    <p class="lead mb-4">
                        Join us for the premier gathering of agricultural researchers, scientists,
                        and policymakers in Kenya. The conference provides a platform for
                        knowledge exchange, networking, and collaboration to advance
                        agricultural innovation and food security.
                    </p>

                    <div class="d-flex gap-3 flex-wrap">

                        <a href="/conference/register" class="btn btn-success btn-lg">
                            <i class="fas fa-user-check me-2"></i>Register as Participant
                        </a>

                        <a href="/exhibition/register" class="btn btn-warning btn-lg">
                            <i class="fas fa-store me-2"></i>Register as Exhibitor
                        </a>

                        <a href="/about" class="btn btn-outline-success btn-lg">
                            Learn More
                        </a>

                    </div>

                </div>
            </div>


            <!-- Important Dates -->
            <div class="col-lg-4">
                <div class="card shadow border-0">

                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-calendar-check me-2"></i>
                            Important Dates
                        </h4>
                    </div>

                    <div class="card-body">

                        <ul class="list-unstyled">

                            <!-- Registration highlighted first -->
                            <li class="mb-3 p-2 rounded" style="background:#fff8e1; border-left: 4px solid #ffc107;">
                                <strong><i class="fas fa-star text-warning me-1"></i> Registration Open:</strong><br>
                                <span class="text-success fw-bold">Now Open!</span>
                                <br><small class="text-danger">Early bird ends 22nd May 2026</small>
                            </li>

                            <li class="mb-3">
                                <strong>Conference Dates:</strong><br>
                                <span class="text-success fw-bold">15th to 19th June 2026</span>
                            </li>

                            <li class="mb-3">
                                <strong>Notification of Acceptance:</strong><br>
                                <span class="text-success">4th May 2026</span>
                            </li>

                            <li class="mb-3">
                                <strong>Final Submission of Accepted Papers:</strong><br>
                                <span class="text-success">22nd May 2026</span>
                            </li>

                            <li class="mb-3 text-muted">
                                <strong>Abstract Submission:</strong><br>
                                <span class="text-danger">Closed</span>
                            </li>

                            <li class="mb-3 text-muted">
                                <strong>Full Paper Submission:</strong><br>
                                <span>17th April 2026</span>
                            </li>

                        </ul>

                        <a href="/conference/register" class="btn btn-success w-100 fw-bold">
                            <i class="fas fa-user-check me-2"></i>Register Now
                        </a>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- ================= FINAL CTA SECTION ================= -->
<section class="cta-section text-center py-5">
    <div class="container">

        <h2 class="display-5 text-white mb-4">
            Choose How You Want to Participate
        </h2>

        <p class="lead text-white mb-5 mx-auto" style="max-width:900px;">
            Whether your goal is to gain new knowledge, showcase innovative solutions, or present research, the KALRO Scientific Conference offers an opportunity for you to participate and make an impact.
        </p>

        <div class="row justify-content-center g-4">

            <!-- Participant — PRIMARY -->
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 shadow border-0 border-top border-4 border-success">
                    <div class="card-body p-4">
                        <span class="badge bg-success mb-2">Most Popular</span>
                        <i class="fas fa-users fa-3x text-success mb-3 d-block"></i>
                        <h4 class="fw-bold">Conference Participant</h4>
                        <p>Learn from experts, network with peers, and join high-impact discussions. Early bird rates available until 22nd May.</p>
                        <a href="/conference/register" class="btn btn-success btn-lg w-100 fw-bold">
                            <i class="fas fa-user-check me-2"></i>Register Now
                        </a>
                    </div>
                </div>
            </div>

            <!-- Exhibitor — SECONDARY -->
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 shadow border-0">
                    <div class="card-body p-4">
                        <i class="fas fa-store fa-3x text-warning mb-3"></i>
                        <h4 class="fw-bold">Exhibitor</h4>
                        <p>Showcase your products and connect with researchers, policymakers, and industry professionals.</p>
                        <a href="/exhibition/register" class="btn btn-warning btn-lg w-100 fw-bold">
                            <i class="fas fa-store me-2"></i>Become an Exhibitor
                        </a>
                    </div>
                </div>
            </div>

            <!-- Submit Paper — TERTIARY -->
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 shadow border-0">
                    <div class="card-body p-4">
                        <i class="fas fa-file-alt fa-3x text-secondary mb-3"></i>
                        <h4 class="fw-bold">Submit Research</h4>
                        <p>Full paper submission deadline: <strong>17th April 2026</strong>. Abstract submission is now closed.</p>
                        <a href="/submit-abstract" class="btn btn-outline-secondary btn-lg w-100">
                            Paper Submission
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <div class="mt-5">
            <a href="/contact" class="btn btn-outline-light btn-lg">
                Contact Us
            </a>
        </div>

    </div>
</section>

@endsection