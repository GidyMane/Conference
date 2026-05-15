@extends('layouts.header')

@section('title')
    Home
@endsection

@section('content')

<style>
/* ===== GLOBAL ===== */
:root {
    --green-dark:  #1a5c2e;
    --green-main:  #2e7d46;
    --green-light: #e8f5e9;
    --gold:        #f5a623;
    --gold-dark:   #d4891a;
    --text-dark:   #1a2b1f;
    --white:       #ffffff;
}

/* ===== HERO CAROUSEL ===== */
.hero-section .carousel-item img {
    height: 560px;
    object-fit: cover;
}

.hero-section .carousel-caption {
    bottom: 60px;
    left: 50%;
    transform: translateX(-50%);
    width: 90%;
    max-width: 860px;
    text-align: center;
    z-index: 10;
}

.hero-section .carousel-caption .badge {
    font-size: 0.85rem;
    letter-spacing: 0.04em;
    padding: 0.5rem 1.2rem;
    border-radius: 50px;
    display: inline-block;
    margin-bottom: 1rem;
}

.hero-section .carousel-caption h2 {
    font-size: clamp(1.8rem, 4vw, 2.8rem);
    font-weight: 800;
    color: #ffffff;
    text-shadow: 0 2px 12px rgba(0,0,0,0.85);
    line-height: 1.2;
    margin-bottom: 1rem;
}

.hero-caption-lead {
    display: inline-block;
    color: #ffffff !important;
    font-size: clamp(1rem, 2vw, 1.2rem);
    font-weight: 600;
    line-height: 1.6;
    background: rgba(0, 0, 0, 0.45);
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
    border-radius: 8px;
    padding: 10px 20px;
    margin-bottom: 1.4rem;
    text-shadow: 0 1px 4px rgba(0,0,0,0.6);
    border-left: 3px solid var(--gold);
}

.hero-caption-lead strong { color: var(--gold); }

.carousel-control-prev-icon,
.carousel-control-next-icon {
    background-color: rgba(0,0,0,0.4);
    border-radius: 50%;
    padding: 18px;
    background-size: 55%;
}

/* ===== ANNOUNCEMENT BANNER ===== */
.announcement-banner {
    background: linear-gradient(90deg, var(--gold) 0%, #ffca28 100%);
    padding: 0.75rem 0;
}
.announcement-banner h5 {
    font-size: 1rem;
    color: #1a2b1f;
    margin: 0;
}

/* ===== CONFERENCE THEME ===== */
.conference-theme {
    background: var(--green-light);
    border-top: 4px solid var(--green-main);
}
.conference-theme h2 { color: var(--green-dark); }
.conference-theme h4 {
    color: var(--text-dark);
    font-size: 1.2rem;
    max-width: 800px;
    margin: 0 auto 1.2rem;
}
.conference-theme p.lead {
    color: #3a4a3e;
    font-size: 1.05rem;
}

/* ===== QUICK STATS ===== */
.quick-stats {
    background: #ffffff;
    border-top: 1px solid #dee2e6;
}
.stat-card {
    padding: 2rem 1rem;
    border-radius: 12px;
    background: var(--green-light);
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}
.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(46,125,70,0.15);
}
.stat-card h3 {
    font-size: 2.4rem;
    font-weight: 800;
    color: var(--green-dark);
    margin-bottom: 0.25rem;
}
.stat-card p {
    color: #4a5e50;
    font-weight: 500;
    margin: 0;
}

/* ===== PARTICIPATE STRIP ===== */
.participate-strip {
    background: var(--green-dark);
    padding: 1.1rem 0;
}
.participate-strip .participate-item {
    display: flex;
    align-items: center;
    gap: 12px;
    color: #fff;
    text-decoration: none;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    transition: background 0.2s;
}
.participate-strip .participate-item:hover {
    background: rgba(255,255,255,0.12);
}
.participate-strip .participate-item i {
    font-size: 1.4rem;
    color: var(--gold);
}
.participate-strip .participate-item span {
    font-size: 0.9rem;
    font-weight: 600;
    line-height: 1.3;
}

/* ===== SIDE EVENT SECTION ===== */
.side-event-section {
    background: #fffdf5;
    border-top: 4px solid var(--gold);
    border-bottom: 1px solid #f0e0b0;
}
.side-event-card {
    border-radius: 16px;
    border: 1px solid rgba(245,166,35,0.3);
    background: #ffffff;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}
.side-event-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(245,166,35,0.18);
}

/* ===== MID CTA ===== */
.mid-cta {
    background: #f8fdf9;
    border-top: 1px solid #c8e6c9;
    border-bottom: 1px solid #c8e6c9;
}

/* ===== MAIN CONTENT ===== */
.welcome-section h1 {
    font-size: clamp(1.8rem, 3.5vw, 2.6rem);
    font-weight: 800;
    line-height: 1.2;
}
.welcome-section p.lead {
    color: #3a4a3e;
    font-size: 1.1rem;
}

.dates-card .card-header { background: var(--green-dark) !important; }
.dates-card ul li {
    border-bottom: 1px solid #e8f0ea;
    padding-bottom: 0.75rem;
    margin-bottom: 0.75rem;
}
.dates-card ul li:last-child { border-bottom: none; }

/* ===== FINAL CTA ===== */
.cta-section {
    background: linear-gradient(135deg, var(--green-dark) 0%, var(--green-main) 60%, #3a9a5c 100%);
    position: relative;
    overflow: hidden;
}
.cta-section::before {
    content: '';
    position: absolute;
    top: -80px; right: -80px;
    width: 300px; height: 300px;
    border-radius: 50%;
    background: rgba(255,255,255,0.05);
}
.cta-section::after {
    content: '';
    position: absolute;
    bottom: -60px; left: -60px;
    width: 220px; height: 220px;
    border-radius: 50%;
    background: rgba(255,255,255,0.04);
}
.cta-section .card {
    border-radius: 16px;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}
.cta-section .card:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 40px rgba(0,0,0,0.2) !important;
}
.cta-section .card .card-body p {
    color: #4a5e50;
    font-size: 0.97rem;
}

/* Buttons */
.btn-success { background-color: var(--green-main); border-color: var(--green-main); }
.btn-success:hover { background-color: var(--green-dark); border-color: var(--green-dark); }
.btn-warning { background-color: var(--gold); border-color: var(--gold); color: #1a2b1f; }
.btn-warning:hover { background-color: var(--gold-dark); border-color: var(--gold-dark); }
</style>


{{-- ================= HERO CAROUSEL ================= --}}
<section class="hero-section">
    <div id="mainCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">

        <div class="carousel-indicators">
            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="2"></button>
            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="3"></button>
        </div>

        <div class="carousel-inner">

            {{-- Slide 1 — Registration Now Open --}}
            <div class="carousel-item active">
                <img src="assets/images/banner1.jpg" class="d-block w-100" alt="KALRO Conference Banner">
                <div class="carousel-caption">
                    <span class="badge bg-warning text-dark mb-3">
                        <i class="fas fa-star me-1"></i> Registration Now Open
                    </span>
                    <h2>2nd KALRO Scientific Conference and Innovation Expo</h2>
                    <p class="hero-caption-lead">
                        15th – 19th June 2026 &nbsp;|&nbsp; Innovating for Resilience, Scaling for Impact
                    </p>
                    <div class="d-flex justify-content-center gap-3 flex-wrap mt-2">
                        <a href="/conference/register" class="btn btn-warning btn-lg fw-bold">
                            <i class="fas fa-user-check me-2"></i>Register as Participant
                        </a>
                        <a href="/exhibition/register" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-store me-2"></i>Register as Exhibitor
                        </a>
                    </div>
                </div>
            </div>

            {{-- Slide 2 — Participants --}}
            <div class="carousel-item">
                <img src="assets/images/banner2.jpg" class="d-block w-100" alt="Conference Venue">
                <div class="carousel-caption">
                    <span class="badge bg-success mb-3">
                        <i class="fas fa-check-circle me-1"></i> Spots Still Available
                    </span>
                    <h2>Secure Your Place at the Conference</h2>
                    <p class="hero-caption-lead">
                        Learn from experts, network with peers, and participate in impactful discussions.<br>
                        <strong>Early bird registration ends 22nd May 2026.</strong>
                    </p>
                    <a href="/conference/register" class="btn btn-warning btn-lg fw-bold mt-1">
                        <i class="fas fa-users me-2"></i>Register Now
                    </a>
                </div>
            </div>

            {{-- Slide 3 — Exhibitors --}}
            <div class="carousel-item">
                <img src="assets/images/banner1.jpg" class="d-block w-100" alt="Networking Opportunities">
                <div class="carousel-caption">
                    <span class="badge bg-warning text-dark mb-3">
                        <i class="fas fa-store me-1"></i> Exhibitor Spaces Available
                    </span>
                    <h2>Showcase Your Innovation</h2>
                    <p class="hero-caption-lead">
                        Present your products and services to researchers, policymakers, and industry leaders.
                    </p>
                    <div class="d-flex justify-content-center gap-3 flex-wrap mt-1">
                        <a href="/exhibition/register" class="btn btn-warning btn-lg fw-bold">
                            <i class="fas fa-store me-2"></i>Register as Exhibitor
                        </a>
                        <a href="/conference-procedure" class="btn btn-outline-light btn-lg">
                            Conference Details
                        </a>
                    </div>
                </div>
            </div>

            {{-- Slide 4 — Host a Side Event --}}
            <div class="carousel-item">
                <img src="assets/images/banner2.jpg" class="d-block w-100" alt="Side Events">
                <div class="carousel-caption">
                    <span class="badge text-dark mb-3" style="background:var(--gold);">
                        <i class="fas fa-calendar-plus me-1"></i> Side Events Open
                    </span>
                    <h2>Host a Side Event</h2>
                    <p class="hero-caption-lead">
                        Organise a workshop, symposium, or special session alongside the main conference.
                        <strong>Submit your proposal now.</strong>
                    </p>
                    <a href="https://forms.gle/UsduBgszNWhjQpJS9" target="_blank" rel="noopener noreferrer"
                       class="btn btn-warning btn-lg fw-bold mt-1">
                        <i class="fas fa-external-link-alt me-2"></i>Submit Side Event Proposal
                    </a>
                </div>
            </div>

        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>

    </div>
</section>


{{-- ================= ANNOUNCEMENT BANNER ================= --}}
<section class="announcement-banner">
    <div class="container text-center">
        <h5 class="fw-bold">
            <i class="fas fa-bell me-2"></i>
            Registration is Now Open! &mdash;
            Early bird pricing ends <strong>22nd May 2026</strong>.
            &nbsp;
            <a href="/conference/register" class="btn btn-dark btn-sm ms-2">Register Now</a>
            <a href="/exhibition/register" class="btn btn-outline-dark btn-sm ms-2">Exhibitor Registration</a>
            <a href="https://forms.gle/UsduBgszNWhjQpJS9" target="_blank" rel="noopener noreferrer"
               class="btn btn-dark btn-sm ms-2">
                <i class="fas fa-calendar-plus me-1"></i>Host a Side Event
            </a>
        </h5>
    </div>
</section>


{{-- ================= CONFERENCE THEME ================= --}}
<section class="conference-theme py-5">
    <div class="container text-center">
        <h2 class="display-5 fw-bold mb-3">
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


{{-- ================= QUICK STATS ================= --}}
<section class="quick-stats py-5">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <i class="fas fa-calendar-alt fa-3x text-success mb-3"></i>
                    <h3>5</h3>
                    <p>Conference Days</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <i class="fas fa-users fa-3x text-success mb-3"></i>
                    <h3>500+</h3>
                    <p>Expected Participants</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <i class="fas fa-microphone fa-3x text-success mb-3"></i>
                    <h3>50+</h3>
                    <p>Speakers</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <i class="fas fa-file-alt fa-3x text-success mb-3"></i>
                    <h3>100+</h3>
                    <p>Papers</p>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- ================= PARTICIPATE STRIP ================= --}}
<section class="participate-strip">
    <div class="container">
        <div class="row justify-content-center g-2 text-center">
            <div class="col-lg-3 col-md-6">
                <a href="/conference/register" class="participate-item justify-content-center">
                    <i class="fas fa-user-check"></i>
                    <span>Register as<br>Participant</span>
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <a href="/exhibition/register" class="participate-item justify-content-center">
                    <i class="fas fa-store"></i>
                    <span>Become an<br>Exhibitor</span>
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <a href="/submit-abstract" class="participate-item justify-content-center">
                    <i class="fas fa-file-alt"></i>
                    <span>Submit<br>Research Paper</span>
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <a href="https://forms.gle/UsduBgszNWhjQpJS9" target="_blank" rel="noopener noreferrer"
                   class="participate-item justify-content-center">
                    <i class="fas fa-calendar-plus"></i>
                    <span>Host a<br>Side Event</span>
                </a>
            </div>
        </div>
    </div>
</section>


{{-- ================= HOST A SIDE EVENT — FEATURED CARD ================= --}}
<section class="side-event-section py-5">
    <div class="container">

        <div class="text-center mb-4">
            <h2 class="fw-bold" style="color: var(--text-dark);">
                <i class="fas fa-calendar-plus me-2" style="color: var(--gold);"></i>Host a Side Event
            </h2>
            <p class="text-muted mx-auto" style="max-width: 680px;">
                Propose a focused workshop, symposium, or special session alongside the main conference
                programme. Spaces are limited and allocated on a first-come, first-served basis.
            </p>
        </div>

        <div class="row g-4 justify-content-center">

            {{-- What is a Side Event --}}
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 side-event-card shadow-sm border-0 p-1">
                    <div class="card-body p-4">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mb-3"
                             style="width:52px;height:52px;background:#fff8e1;">
                            <i class="fas fa-lightbulb fa-lg" style="color:#b87800;"></i>
                        </div>
                        <h5 class="fw-bold mb-2">What is a Side Event?</h5>
                        <p class="text-muted mb-0">
                            A side event is an independently organised session — a workshop, panel discussion,
                            product launch, or networking event — held at the conference venue during the
                            15th–19th June 2026 programme.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Who Can Apply --}}
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 side-event-card shadow-sm border-0 p-1">
                    <div class="card-body p-4">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mb-3"
                             style="width:52px;height:52px;background:#fff8e1;">
                            <i class="fas fa-users fa-lg" style="color:#b87800;"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Who Can Apply?</h5>
                        <p class="text-muted mb-0">
                            Research institutions, NGOs, government agencies, private sector companies,
                            and development partners are all welcome to propose a side event aligned
                            with the conference theme.
                        </p>
                    </div>
                </div>
            </div>

            {{-- How to Apply --}}
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 side-event-card shadow-sm border-0 p-1">
                    <div class="card-body p-4">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mb-3"
                             style="width:52px;height:52px;background:#fff8e1;">
                            <i class="fas fa-paper-plane fa-lg" style="color:#b87800;"></i>
                        </div>
                        <h5 class="fw-bold mb-2">How to Apply</h5>
                        <p class="text-muted mb-3">
                            Complete the online proposal form. You will need your organisation details,
                            proposed event title, preferred date/time slot, expected audience size,
                            and any supporting documents.
                        </p>
                        <a href="https://forms.gle/UsduBgszNWhjQpJS9"
                           target="_blank" rel="noopener noreferrer"
                           class="btn btn-warning fw-bold w-100">
                            <i class="fas fa-external-link-alt me-2"></i>Submit Your Proposal
                        </a>
                    </div>
                </div>
            </div>

        </div>

        {{-- Full-width CTA banner --}}
        <div class="mt-4 p-4 rounded-3 d-flex flex-wrap align-items-center justify-content-between gap-3"
             style="background: linear-gradient(90deg, #fff8e1 0%, #fffde7 100%); border: 1px solid rgba(245,166,35,0.4);">
            <div>
                <h5 class="fw-bold mb-1" style="color: var(--text-dark);">
                    <i class="fas fa-clock me-2" style="color:var(--gold);"></i>
                    Slots are filling up fast
                </h5>
                <p class="mb-0 text-muted" style="font-size:0.95rem;">
                    Side event spaces are limited. Submit your proposal early to secure your preferred date and time.
                    For questions, email
                    <a href="mailto:kalroconference2026@gmail.com" class="fw-semibold"
                       style="color:var(--gold-dark);">kalroexpo2026@gmail.com</a>
                </p>
            </div>
            <a href="https://forms.gle/UsduBgszNWhjQpJS9"
               target="_blank" rel="noopener noreferrer"
               class="btn btn-warning btn-lg fw-bold flex-shrink-0">
                <i class="fas fa-external-link-alt me-2"></i>Host a Side Event
            </a>
        </div>

    </div>
</section>


{{-- ================= MID CTA ================= --}}
<section class="mid-cta py-4">
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
            <a href="https://forms.gle/UsduBgszNWhjQpJS9" target="_blank" rel="noopener noreferrer"
               class="btn btn-outline-warning btn-lg fw-bold">
                <i class="fas fa-calendar-plus me-2"></i>Host a Side Event
            </a>
        </div>
    </div>
</section>


{{-- ================= MAIN CONTENT ================= --}}
<section class="main-content py-5">
    <div class="container">
        <div class="row mb-5 align-items-start g-4">

            {{-- Welcome --}}
            <div class="col-lg-8">
                <div class="welcome-section">
                    <h1 class="text-success mb-4">
                        <i class="fas fa-seedling me-3"></i>
                        Welcome to KALRO 2nd Scientific Conference and Innovation Expo 2026
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
                        <a href="https://forms.gle/UsduBgszNWhjQpJS9" target="_blank" rel="noopener noreferrer"
                           class="btn btn-outline-warning btn-lg">
                            <i class="fas fa-calendar-plus me-2"></i>Host a Side Event
                        </a>
                        <a href="/about" class="btn btn-outline-success btn-lg">
                            Learn More
                        </a>
                    </div>
                </div>
            </div>

            {{-- Important Dates --}}
            <div class="col-lg-4">
                <div class="card shadow border-0 dates-card">
                    <div class="card-header text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-calendar-check me-2"></i>Important Dates
                        </h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-3">

                            <li class="mb-3 p-2 rounded" style="background:#fff8e1; border-left:4px solid #ffc107;">
                                <strong><i class="fas fa-star text-warning me-1"></i> Registration Open:</strong><br>
                                <span class="text-success fw-bold">Now Open!</span>
                                <br><small class="text-danger fw-semibold">Early bird ends 22nd May 2026</small>
                            </li>

                            <li class="mb-3 p-2 rounded" style="background:#fff8e1; border-left:4px solid #ffc107;">
                                <strong><i class="fas fa-calendar-plus text-warning me-1"></i> Side Event Proposals:</strong><br>
                                <span class="fw-bold" style="color:var(--gold-dark);">Now Accepting</span>
                                <br>
                                <a href="https://forms.gle/UsduBgszNWhjQpJS9" target="_blank" rel="noopener noreferrer"
                                   class="small fw-semibold" style="color:var(--gold-dark);">
                                    Submit proposal &rarr;
                                </a>
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

                            <li class="mb-3">
                                <strong>Abstract Submission:</strong><br>
                                <span class="text-danger fw-semibold">Closed</span>
                            </li>

                            <li>
                                <strong>Full Paper Submission:</strong><br>
                                <span class="text-muted">17th April 2026</span>
                            </li>

                        </ul>

                        <a href="/conference/register" class="btn btn-success w-100 fw-bold mb-2">
                            <i class="fas fa-user-check me-2"></i>Register Now
                        </a>
                        <a href="https://forms.gle/UsduBgszNWhjQpJS9" target="_blank" rel="noopener noreferrer"
                           class="btn btn-warning w-100 fw-bold">
                            <i class="fas fa-calendar-plus me-2"></i>Host a Side Event
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


{{-- ================= FINAL CTA SECTION ================= --}}
<section class="cta-section text-center py-5">
    <div class="container position-relative" style="z-index:2;">

        <h2 class="display-5 text-white fw-bold mb-3">
            Choose How You Want to Participate
        </h2>
        <p class="lead text-white mb-5 mx-auto opacity-90" style="max-width:820px;">
            Whether your goal is to gain new knowledge, showcase innovative solutions, present research,
            or lead your own session — the KALRO Scientific Conference has a place for you.
        </p>

        <div class="row justify-content-center g-4">

            {{-- Participant --}}
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 shadow-lg border-0 border-top border-4 border-success">
                    <div class="card-body p-4">
                        <span class="badge bg-success mb-2">Most Popular</span>
                        <i class="fas fa-users fa-3x text-success mb-3 d-block"></i>
                        <h4 class="fw-bold">Conference Participant</h4>
                        <p>Learn from experts, network with peers, and join high-impact discussions. Early bird rates until 22nd May.</p>
                        <a href="/conference/register" class="btn btn-success btn-lg w-100 fw-bold">
                            <i class="fas fa-user-check me-2"></i>Register Now
                        </a>
                    </div>
                </div>
            </div>

            {{-- Exhibitor --}}
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 shadow-lg border-0">
                    <div class="card-body p-4">
                        <i class="fas fa-store fa-3x text-warning mb-3 d-block"></i>
                        <h4 class="fw-bold">Exhibitor</h4>
                        <p>Showcase your products and connect with researchers, policymakers, and industry professionals.</p>
                        <a href="/exhibition/register" class="btn btn-warning btn-lg w-100 fw-bold">
                            <i class="fas fa-store me-2"></i>Become an Exhibitor
                        </a>
                    </div>
                </div>
            </div>

            {{-- Submit Paper --}}
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 shadow-lg border-0">
                    <div class="card-body p-4">
                        <i class="fas fa-file-alt fa-3x text-secondary mb-3 d-block"></i>
                        <h4 class="fw-bold">Submit Research</h4>
                        <p>Full paper submission deadline: <strong>17th April 2026</strong>. Abstract submission is now closed.</p>
                        <a href="/submit-abstract" class="btn btn-outline-secondary btn-lg w-100">
                            Paper Submission
                        </a>
                    </div>
                </div>
            </div>

            {{-- Side Event --}}
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 shadow-lg border-0" style="border-top: 4px solid var(--gold) !important;">
                    <div class="card-body p-4">
                        <i class="fas fa-calendar-plus fa-3x mb-3 d-block" style="color:var(--gold);"></i>
                        <h4 class="fw-bold">Host a Side Event</h4>
                        <p>Organise a workshop, symposium, or special session. Submit your proposal and secure a slot.</p>
                        <a href="https://forms.gle/UsduBgszNWhjQpJS9"
                           target="_blank" rel="noopener noreferrer"
                           class="btn btn-warning btn-lg w-100 fw-bold">
                            <i class="fas fa-external-link-alt me-2"></i>Submit Proposal
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <div class="mt-5">
            <a href="/contact" class="btn btn-outline-light btn-lg px-5">
                <i class="fas fa-envelope me-2"></i>Contact Us
            </a>
        </div>

    </div>
</section>

@endsection