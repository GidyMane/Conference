@extends('layouts.header')

@section('title')
    Home
@endsection

@section('content')
        <!-- Your page content from earlier goes here -->
        <!-- Hero Section with Carousel -->
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
                    <div class="carousel-item active">
                        <img src="assets/images/banner1.jpg" class="d-block w-100" alt="KALRO Conference Banner">
                        <div class="carousel-caption">
                            <h2 class="display-5 fw-bold">2nd KALRO Scientific Conference and Exhibition</h2>
                            <p class="lead">Innovating for Resilience, Scaling for Impact</p>
                            <a href="/submit-abstract" class="btn btn-success btn-lg mt-3">
                                Submit Abstract Now <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="assets/images/banner2.jpg" class="d-block w-100" alt="Conference Venue">
                        <div class="carousel-caption">
                            <h2 class="display-5 fw-bold">Call for Papers</h2>
                            <p class="lead">Submit your research by 2nd February, 2026</p>
                            <a href="/submit-abstract" class="btn btn-warning btn-lg mt-3">
                                Submit Abstract <i class="fas fa-paper-plane ms-2"></i>
                            </a>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="assets/images/banner1.jpg" class="d-block w-100" alt="Networking Opportunities">
                        <div class="carousel-caption">
                            <h2 class="display-5 fw-bold">Networking & Collaboration</h2>
                            <p class="lead">Connect with leading agricultural researchers</p>
                            <a href="pages/conference_procedure.php" class="btn btn-primary btn-lg mt-3">
                                View Conference Procedure<i class="fas fa-calendar-alt ms-2"></i>
                            </a>
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

        <!-- Rest of your page content... -->
        <!-- Keep all the sections you had before... -->
        <!-- Conference Theme Section -->
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

        <!-- Quick Stats -->
        <section class="quick-stats py-5 bg-light">
            <div class="container">
                <div class="row text-center">
                    <div class="col-md-3 col-6 mb-4">
                        <div class="stat-card">
                            <i class="fas fa-calendar-alt fa-3x text-success mb-3"></i>
                            <h3 class="stat-number">3</h3>
                            <p class="stat-label">Conference Days</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-4">
                        <div class="stat-card">
                            <i class="fas fa-users fa-3x text-success mb-3"></i>
                            <h3 class="stat-number">500+</h3>
                            <p class="stat-label">Expected Participants</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-4">
                        <div class="stat-card">
                            <i class="fas fa-microphone fa-3x text-success mb-3"></i>
                            <h3 class="stat-number">50+</h3>
                            <p class="stat-label">Speakers</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-4">
                        <div class="stat-card">
                            <i class="fas fa-file-alt fa-3x text-success mb-3"></i>
                            <h3 class="stat-number">100+</h3>
                            <p class="stat-label">Papers</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <section class="main-content py-5">
            <div class="container">
                <!-- Welcome Section -->
                <div class="row mb-5">
                    <div class="col-lg-8">
                        <div class="welcome-section">
                            <h1 class="display-4 mb-4 text-success">
                                <i class="fas fa-seedling me-3"></i>Welcome to KALRO 2nd KALRO Scientific Conference and Exhibition 2026
                            </h1>
                            <p class="lead mb-4">
                                Join us for the premier gathering of agricultural researchers, scientists, 
                                and policymakers in Kenya. The 2nd KALRO Scientific Conference and Exhibition provides a platform 
                                for knowledge exchange, networking, and collaboration to advance agricultural 
                                innovation and food security.
                            </p>
                            <div class="d-flex gap-3">
                                <a href="/about" class="btn btn-outline-success btn-lg">
                                    Learn More <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                                <a href="/submit-abstract" class="btn btn-success btn-lg">
                                    Submit Abstract Now <i class="fas fa-user-plus ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card important-dates-card shadow border-0">
                            <div class="card-header bg-success text-white">
                                <h4 class="mb-0"><i class="fas fa-calendar-check me-2"></i>Important Dates</h4>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled important-dates">
                                    <li class="mb-3">
                                        <strong>Abstract Submission:</strong><br>
                                        <span class="text-success">Deadline: Feb 13, 2026</span>
                                    </li>
                                    <li class="mb-3">
                                        <strong>Notification of Acceptance of Abstract:</strong><br>
                                        <span class="text-success"> Instant for every approval</span>
                                    </li>
                                    <li class="mb-3">
                                        <strong>Submission of Full Paper:</strong><br>
                                        <span class="text-success"> 27th Feb, 2026</span>
                                    </li>
                                
                                    <li class="mb-3">
                                        <strong>Notification of Acceptance of Final Paper:</strong><br>
                                        <span class="text-success"> Before 27th March, 2026</span>
                                    </li>
                                    <li class="mb-3">
                                        <strong>Final Submission of Accepted Papers:</strong><br>
                                        <span class="text-success"> 10th April, 2026</span>
                                    </li>

                                    <li class="mb-3">
                                        <strong>Registration:</strong><br>
                                        <span class="text-success">13th February to 17th April 2026</span>
                                    </li>
                                    <li>
                                        <strong>Conference Dates:</strong><br>
                                        <span class="text-success">18th to 22nd May 2026</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                </div>

        <!--CTA OUTSIDE CONTAINER) -->
        <section class="cta-section text-center py-5">
            <h2 class="display-5 text-white mb-4">Ready to Join Us?</h2>

            <p class="lead text-white mb-5 mx-auto" style="max-width:900px;">
                Network with experts, share your research, and contribute to agricultural innovation.
            </p>

            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="/submit-abstract" class="btn btn-warning btn-lg">Submit Abstract</a>
                <a href="/contact" class="btn btn-outline-light btn-lg">Contact Us</a>
            </div>
        </section>
@endsection
