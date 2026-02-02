@extends('layouts.header')

@section('title')
    About Conference
@endsection

@section('content')

<!-- Page Header -->
<section class="page-header bg-success text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="display-4 fw-bold mb-3">
                    <i class="fas fa-info-circle me-3"></i>About the Conference
                </h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center mb-0">
                        <li class="breadcrumb-item"><a href="/" class="text-white-50">Home</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">About Conference</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Conference Overview -->
<section class="conference-overview py-5">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-lg-8">
                <h2 class="section-title mb-4">
                    <span class="section-title-text">2nd KALRO Scientific Conference and Exhibition </span>
                </h2>
                <p class="lead mb-4">
                    Theme : Innovating towards Resilient Agri-food Systems for Climate Action, Food Security and Sustainable Livelihoods
                </p>
                <p class="mb-4">
                    Since its inception in 2018, the conference has served as a critical platform for 
                    knowledge exchange, showcasing cutting-edge research, fostering collaborations, 
                    and shaping the future of agriculture in Kenya and the wider East African region.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="pages/submit_abstract.php" class="btn btn-outline-success btn-lg">
                        <i class="fas fa-paper-plane me-2"></i>Submit Abstract
                    </a>
                </div>
            </div>
            <div class="col-lg-4 mt-4 mt-lg-0">
                <div class="card shadow border-0 h-100">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-trophy fa-4x text-success mb-4"></i>
                        <h4 class="card-title mb-3">Recognized Excellence</h4>
                        <p class="card-text">
                            At the National Farmers Awards & Celebration 2025 (hosted by the Ministry of Agriculture), KALRO was part of the sector recognition that honours excellence across the agricultural value chain — showcasing its contribution to farming innovation and impact.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Conference Objectives -->
<!-- Conference Objectives -->
<section class="conference-objectives py-5" style="background-color: #F0F0F0;">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="section-title mb-4">
                    <span class="section-title-text" style="color: #333333; border-bottom: 3px solid #DE5F07; padding-bottom: 10px; display: inline-block;">Conference Objectives</span>
                </h2>
                <p class="lead" style="color: #666;">Proposed as a fully virtual conference, the objectives of the 2nd KALRO Scientific Conference 2026 are:</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="objective-card text-center p-4 h-100" style="background-color: #FFFFFF; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: transform 0.3s;">
                    <div class="objective-icon mb-4">
                        <i class="fas fa-share-alt fa-3x" style="color: #DE5F07;"></i>
                    </div>
                    <h4 class="mb-3" style="color: #333333;">Share Research Findings</h4>
                    <p style="color: #666;">To share research and scientific findings, innovations, and policy recommendations from KALRO and partners.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="objective-card text-center p-4 h-100" style="background-color: #FFFFFF; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: transform 0.3s;">
                    <div class="objective-icon mb-4">
                        <i class="fas fa-comments fa-3x" style="color: #DE5F07;"></i>
                    </div>
                    <h4 class="mb-3" style="color: #333333;">Cross-Disciplinary Dialogue</h4>
                    <p style="color: #666;">To foster cross-disciplinary dialogue on strengthening agri-food systems against climate shocks.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="objective-card text-center p-4 h-100" style="background-color: #FFFFFF; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: transform 0.3s;">
                    <div class="objective-icon mb-4">
                        <i class="fas fa-user-graduate fa-3x" style="color: #DE5F07;"></i>
                    </div>
                    <h4 class="mb-3" style="color: #333333;">Capacity Building</h4>
                    <p style="color: #666;">To build capacity of young and upcoming scientists on scientific writing and presentation skills.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="objective-card text-center p-4 h-100" style="background-color: #FFFFFF; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: transform 0.3s;">
                    <div class="objective-icon mb-4">
                        <i class="fas fa-handshake fa-3x" style="color: #DE5F07;"></i>
                    </div>
                    <h4 class="mb-3" style="color: #333333;">Sector Collaboration</h4>
                    <p style="color: #666;">To stimulate collaboration across the public, private, and research sectors.</p>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <div class="objective-card text-center p-4" style="background-color: #FFFFFF; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); border-left: 5px solid #4CAF50;">
                    <div class="d-flex align-items-center justify-content-center mb-3">
                        <div class="objective-icon me-4">
                            <i class="fas fa-laptop fa-3x" style="color: #DE5F07;"></i>
                        </div>
                        <div class="text-start">
                            <h4 style="color: #333333;">Virtual Innovation Showcase</h4>
                            <p class="mb-0" style="color: #666;">To showcase virtually, successful innovations and technologies for uptake and scale-up.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Target Audience -->
<section class="target-audience bg-light py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="section-title mb-4">
                    <span class="section-title-text">Who Should Attend</span>
                </h2>
                <p class="lead">Join a diverse community of agricultural innovators</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="audience-card card border-0 shadow h-100">
                    <div class="card-body p-4">
                        <div class="audience-icon mb-3">
                            <i class="fas fa-flask fa-2x text-success"></i>
                        </div>
                        <h4 class="card-title mb-3">Researchers & Scientists</h4>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Agricultural Researchers</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Plant Breeders</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Biotechnologists</li>
                            <li><i class="fas fa-check text-success me-2"></i>Soil Scientists</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="audience-card card border-0 shadow h-100">
                    <div class="card-body p-4">
                        <div class="audience-icon mb-3">
                            <i class="fas fa-user-tie fa-2x text-success"></i>
                        </div>
                        <h4 class="card-title mb-3">Policymakers & Academia</h4>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Government Officials</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>University Professors</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Policy Analysts</li>
                            <li><i class="fas fa-check text-success me-2"></i>Extension Officers</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="audience-card card border-0 shadow h-100">
                    <div class="card-body p-4">
                        <div class="audience-icon mb-3">
                            <i class="fas fa-industry fa-2x text-success"></i>
                        </div>
                        <h4 class="card-title mb-3">Industry & Private Sector</h4>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Seed Company Executives</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Agribusiness Managers</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Farm Owners</li>
                            <li><i class="fas fa-check text-success me-2"></i>Agricultural Consultants</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Conference Format -->
<section class="conference-format py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="section-title mb-4">
                    <span class="section-title-text">Conference Format</span>
                </h2>
                <p class="lead">A dynamic blend of sessions designed for maximum engagement</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="format-card text-center p-4">
                    <div class="format-icon mb-3">
                        <div class="icon-circle bg-success">
                            <i class="fas fa-chalkboard-teacher fa-2x text-white"></i>
                        </div>
                    </div>
                    <h4 class="mb-3">Keynote Addresses</h4>
                    <p class="mb-0">Inspiring talks from global leaders in agricultural research and policy.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="format-card text-center p-4">
                    <div class="format-icon mb-3">
                        <div class="icon-circle bg-success">
                            <i class="fas fa-microphone fa-2x text-white"></i>
                        </div>
                    </div>
                    <h4 class="mb-3">Parallel Sessions</h4>
                    <p class="mb-0">Thematic sessions for in-depth discussion of specific research areas.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="format-card text-center p-4">
                    <div class="format-icon mb-3">
                        <div class="icon-circle bg-success">
                            <i class="fas fa-hands-helping fa-2x text-white"></i>
                        </div>
                    </div>
                    <h4 class="mb-3">Workshops</h4>
                    <p class="mb-0">Hands-on training sessions on latest research methodologies and tools.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="format-card text-center p-4">
                    <div class="format-icon mb-3">
                        <div class="icon-circle bg-success">
                            <i class="fas fa-project-diagram fa-2x text-white"></i>
                        </div>
                    </div>
                    <h4 class="mb-3">Poster Sessions</h4>
                    <p class="mb-0">Visual presentation of research findings with interactive discussions.</p>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12 text-center">
                <div class="alert alert-success" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Hybrid Format:</strong> Conference available both in-person and virtually for global participation
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Conference Venue -->
<section class="conference-venue py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h2 class="section-title mb-4">
                    <span class="section-title-text">Conference Venue</span>
                </h2>
                <h4 class="mb-3">KALRO Headquarters, Nairobi</h4>
                <p class="mb-4">
                    Located in the heart of Kenya's capital, our state-of-the-art conference facilities 
                    provide the perfect setting for learning, networking, and collaboration.
                </p>
                <div class="venue-features">
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-wifi text-success me-2"></i>High-speed WiFi</li>
                                <li class="mb-2"><i class="fas fa-utensils text-success me-2"></i>Catering Services</li>
                                <li class="mb-2"><i class="fas fa-car text-success me-2"></i>Ample Parking</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-wheelchair text-success me-2"></i>Accessibility Features</li>
                                <li class="mb-2"><i class="fas fa-first-aid text-success me-2"></i>Medical Support</li>
                                <li><i class="fas fa-shield-alt text-success me-2"></i>Security Services</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="pages/venue.php" class="btn btn-success">
                        <i class="fas fa-map-marked-alt me-2"></i>View Venue Details
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="venue-map shadow rounded overflow-hidden">
                    <img src="assets/images/kalrohq.jpg" alt="Conference Venue" class="img-fluid w-100">
                     
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="cta-about py-5" style="background: linear-gradient(135deg, #198754 0%, #146c43 100%);">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="display-5 text-white mb-4">Join Us in Advancing Agricultural Innovation</h2>
                <p class="lead text-white mb-5">
                    Be part of Kenya's most influential agricultural research conference. 
                    Network with experts, share your research, and contribute to shaping the future of agriculture.
                </p>
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <a href="pages/submit_abstract.php" class="btn btn-light btn-lg px-5">
                        <i class="fas fa-user-plus me-2"></i>Submit Abstract Now
                    </a>
                    <a href="/contact" class="btn btn-outline-light btn-lg px-5">
                        <i class="fas fa-question-circle me-2"></i>Contact Us
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection