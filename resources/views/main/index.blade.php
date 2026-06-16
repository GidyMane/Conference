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

/* ===== HERO CAROUSEL — fully responsive, no fixed heights ===== */
/*
 * Strategy: use aspect-ratio on the carousel-item so the height is
 * always proportional to the viewport width on every screen size.
 * The image fills that box with object-fit:cover.
 * overflow:hidden + line-height:0 on every wrapper kills the black bar.
 *
 * Aspect ratios used:
 *   ≥ 992px  (desktop)  → 16/6  (~wide cinematic)
 *   768–991px (tablet)  → 16/7
 *   < 768px  (mobile)   → 4/3   (taller so content is readable)
 */

.hero-section {
    overflow: hidden;
    line-height: 0;
    font-size: 0;
}

.hero-section .carousel,
.hero-section .carousel-inner {
    overflow: hidden;
    background: transparent;
    line-height: 0;
    font-size: 0;
}

/* The carousel-item becomes the aspect-ratio container */
.hero-section .carousel-item {
    position: relative;
    overflow: hidden;
    aspect-ratio: 16 / 6;   /* desktop default */
    line-height: 0;
    font-size: 0;
}

/* Image fills the aspect-ratio box perfectly — zero leftover space */
.hero-section .carousel-item img {
    display: block;
    position: absolute;
    inset: 0;               /* top/right/bottom/left: 0 */
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
}

/* Indicators always sit inside the box */
.hero-section .carousel-indicators {
    bottom: 10px;
    margin-bottom: 0;
    z-index: 10;
}

/* Caption is absolutely positioned inside the same box */
.hero-section .carousel-caption {
    position: absolute;
    bottom: 8%;            /* % of box height → scales with screen */
    left: 50%;
    transform: translateX(-50%);
    width: 90%;
    max-width: 860px;
    text-align: center;
    z-index: 10;
    line-height: 1.4;
    font-size: 1rem;
}

.hero-section .carousel-caption .badge {
    font-size: 0.85rem;
    letter-spacing: 0.04em;
    padding: 0.5rem 1.2rem;
    border-radius: 50px;
    display: inline-block;
    margin-bottom: 0.75rem;
}

.hero-section .carousel-caption h2 {
    font-size: clamp(1.1rem, 3.2vw, 2.8rem);
    font-weight: 800;
    color: #ffffff;
    text-shadow: 0 2px 12px rgba(0,0,0,0.85);
    line-height: 1.2;
    margin-bottom: 0.75rem;
}

.hero-caption-lead {
    display: inline-block;
    color: #ffffff !important;
    font-size: clamp(0.82rem, 1.6vw, 1.2rem);
    font-weight: 600;
    line-height: 1.5;
    background: rgba(0,0,0,0.45);
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
    border-radius: 8px;
    padding: clamp(6px, 1vw, 10px) clamp(10px, 2vw, 20px);
    margin-bottom: 1rem;
    text-shadow: 0 1px 4px rgba(0,0,0,0.6);
    border-left: 3px solid var(--green-light);
}

.hero-caption-lead strong { color: var(--green-light); }

.carousel-control-prev-icon,
.carousel-control-next-icon {
    background-color: rgba(0,0,0,0.4);
    border-radius: 50%;
    padding: 18px;
    background-size: 55%;
}

/* ===== TABLET ===== */
@media (max-width: 991.98px) {
    .hero-section .carousel-item {
        aspect-ratio: 16 / 7;
    }

    .hero-section .carousel-caption .btn {
        font-size: 0.88rem;
        padding: 0.5rem 1rem;
    }
}

/* ===== MOBILE ===== */
@media (max-width: 767.98px) {
    .hero-section .carousel-item {
        aspect-ratio: 4 / 3;   /* taller on phones so text + buttons fit */
    }

    .hero-section .carousel-caption {
        bottom: 6%;
        width: 94%;
    }

    .hero-section .carousel-caption .badge {
        font-size: 0.75rem;
        padding: 0.3rem 0.8rem;
        margin-bottom: 0.4rem;
    }

    .hero-section .carousel-caption .d-flex {
        gap: 0.4rem !important;
    }

    .hero-section .carousel-caption .btn {
        font-size: 0.78rem;
        padding: 0.4rem 0.75rem;
    }

    .hero-section .carousel-indicators {
        bottom: 6px;
    }
}

/* ===== VERY SMALL PHONES (≤ 479px) ===== */
@media (max-width: 479.98px) {
    .hero-section .carousel-item {
        aspect-ratio: 3 / 2.8;  /* nearly square — maximise readable area */
    }

    .hero-section .carousel-caption {
        bottom: 4%;
    }
}

/* ===== ANNOUNCEMENT BANNER ===== */
.announcement-banner {
    background: linear-gradient(90deg, var(--green-main) 0%, #3a9a5c 100%);
    padding: 0.75rem 0;
}
.announcement-banner h5 {
    font-size: 1rem;
    color: #ffffff;
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
    color: var(--green-light);
}
.participate-strip .participate-item span {
    font-size: 0.9rem;
    font-weight: 600;
    line-height: 1.3;
}

/* ===== SIDE EVENT SECTION ===== */
.side-event-section {
    background: #f4faf5;
    border-top: 4px solid var(--green-main);
    border-bottom: 1px solid #c8e6c9;
}
.side-event-day-badge {
    background: var(--green-dark);
    color: #fff;
    font-size: .85rem;
    font-weight: 700;
    padding: .45em .9em;
    border-radius: 50px;
    letter-spacing: .3px;
}
.side-event-day-block {
    background: #fff;
    border-radius: 14px;
    border: 1px solid #d4edda;
    padding: 1.25rem 1.5rem;
    box-shadow: 0 2px 8px rgba(46,125,70,.06);
}
.side-event-item {
    padding: .65rem .85rem;
    border-radius: 8px;
    border-left: 3px solid var(--green-main);
    background: #f8fdf9;
    transition: background .18s;
}
.side-event-item:hover { background: #edf7f0; }
.side-event-item--tsetse {
    border-left-color: #e6a817;
    background: #fffbf0;
}
.side-event-item--tsetse:hover { background: #fff6dc; }
.side-event-time {
    min-width: 90px;
    font-size: .8rem;
    font-weight: 700;
    color: var(--green-dark);
    white-space: nowrap;
    padding-top: 2px;
}
.side-event-host {
    font-size: .8rem;
    color: #6c757d;
    margin-top: 2px;
}
.side-event-mode {
    font-size: .72rem;
    font-weight: 600;
    color: var(--green-dark);
    background: var(--green-light);
    border-radius: 50px;
    padding: .2em .75em;
    white-space: nowrap;
    align-self: flex-start;
    margin-top: 2px;
}

/* ===== CONFERENCE DOWNLOADS ===== */
.downloads-section {
    background: #f4faf5;
    border-top: 4px solid var(--green-main);
    border-bottom: 1px solid #c8e6c9;
}
.download-card {
    background: #fff;
    border-radius: 14px;
    border: 1px solid #d4edda;
    box-shadow: 0 2px 10px rgba(46,125,70,.07);
    display: flex;
    gap: 1.1rem;
    padding: 1.4rem 1.5rem;
    transition: box-shadow .2s, transform .2s;
}
.download-card:hover {
    box-shadow: 0 8px 24px rgba(46,125,70,.13);
    transform: translateY(-2px);
}
.download-card-icon {
    width: 52px;
    height: 52px;
    min-width: 52px;
    border-radius: 50%;
    background: var(--green-main);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
}
.download-card-body { flex: 1; }

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

/* ===== BUTTONS ===== */
.btn-success { background-color: var(--green-main); border-color: var(--green-main); }
.btn-success:hover { background-color: var(--green-dark); border-color: var(--green-dark); }
.btn-warning { background-color: var(--gold); border-color: var(--gold); color: #1a2b1f; }
.btn-warning:hover { background-color: var(--gold-dark); border-color: var(--gold-dark); }

/* ===== PARTNERS SECTION ===== */
.partners-section {
    background: #ffffff;
    border-top: 4px solid var(--green-main);
}
.partners-section h2 {
    color: var(--green-dark);
}
.partner-logo-wrap {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1.5rem 2rem;
    border-radius: 12px;
    border: 1px solid #e0ede3;
    background: #ffffff;
    height: 160px;
    text-decoration: none;
    cursor: pointer;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}
.partner-logo-wrap:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(46,125,70,0.12);
}
.partner-logo-wrap img {
    width: 100%;
    height: 110px;
    object-fit: contain;
    object-position: center;
    filter: grayscale(0%);
    transition: filter 0.25s ease, transform 0.25s ease;
}
.partner-logo-wrap:hover img {
    transform: scale(1.05);
}
.partner-logo-fao img {
    width: 300%;
    height: 300px;
    margin: 0 auto;
}
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
                    <span class="badge bg-success text-white mb-3">
                        <i class="fas fa-star me-1"></i> Registration Now Open
                    </span>
                    <h2>2nd KALRO Scientific Conference and Innovation Expo</h2>
                    <p class="hero-caption-lead">
                        15th – 19th June 2026 &nbsp;|&nbsp; Innovating for Resilience, Scaling for Impact
                    </p>
                    <div class="d-flex justify-content-center gap-3 flex-wrap mt-2">
                        <a href="/conference/register" class="btn btn-success btn-lg fw-bold">
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
                        <strong>Early bird registration ends 31st May 2026.</strong>
                    </p>
                    <a href="/conference/register" class="btn btn-success btn-lg fw-bold mt-1">
                        <i class="fas fa-users me-2"></i>Register Now
                    </a>
                </div>
            </div>

            {{-- Slide 3 — Exhibitors --}}
            <div class="carousel-item">
                <img src="assets/images/banner1.jpg" class="d-block w-100" alt="Networking Opportunities">
                <div class="carousel-caption">
                    <span class="badge bg-success text-white mb-3">
                        <i class="fas fa-store me-1"></i> Exhibitor Spaces Available
                    </span>
                    <h2>Showcase Your Innovation</h2>
                    <p class="hero-caption-lead">
                        Present your products and services to researchers, policymakers, and industry leaders.
                    </p>
                    <div class="d-flex justify-content-center gap-3 flex-wrap mt-1">
                        <a href="/exhibition/register" class="btn btn-success btn-lg fw-bold">
                            <i class="fas fa-store me-2"></i>Register as Exhibitor
                        </a>
                        <a href="/conference-procedure" class="btn btn-outline-light btn-lg">
                            Conference Details
                        </a>
                    </div>
                </div>
            </div>

            {{-- Slide 4 — Side Events --}}
            <div class="carousel-item">
                <img src="assets/images/banner2.jpg" class="d-block w-100" alt="Side Events">
                <div class="carousel-caption">
                    <span class="badge bg-success text-white mb-3">
                        <i class="fas fa-bolt me-1"></i> Side Events — Wed 17 &amp; Thu 18 June
                    </span>
                    <h2>10 Focused Sessions Running Alongside the Conference</h2>
                    <p class="hero-caption-lead">
                        Climate analytics, AI in agriculture, Tsetse launch, livestock, food safety, and more.
                        <strong>Open to all registered delegates.</strong>
                    </p>
                    <div class="d-flex justify-content-center gap-3 flex-wrap mt-1">
                        <a href="/conference-program#side-events" class="btn btn-success btn-lg fw-bold">
                            <i class="fas fa-calendar-alt me-2"></i>View Side Events
                        </a>
                        <a href="/program/Program_Side_event.pdf" download class="btn btn-outline-light btn-lg">
                            <i class="fas fa-download me-2"></i>Download Programme
                        </a>
                    </div>
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
            Early bird pricing ends <strong>31st May 2026</strong>.
            &nbsp;
            <a href="/conference/register" class="btn btn-light btn-sm ms-2 text-success fw-bold">
                Register Now
            </a>
            <a href="/exhibition/register" class="btn btn-outline-light btn-sm ms-2">
                Exhibitor Registration
            </a>
            <a href="https://forms.gle/UsduBgszNWhjQpJS9" target="_blank" rel="noopener noreferrer"
               class="btn btn-outline-light btn-sm ms-2">
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
        <p class="lead mx-auto" style="max-width:900px;">
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
                <a href="/conference-program#side-events" class="participate-item justify-content-center">
                    <i class="fas fa-bolt"></i>
                    <span>Side Events<br>Programme</span>
                </a>
            </div>
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
            <a href="/exhibition/register" class="btn btn-outline-success btn-lg fw-bold">
                <i class="fas fa-store me-2"></i>Become an Exhibitor
            </a>
            <a href="https://forms.gle/UsduBgszNWhjQpJS9" target="_blank" rel="noopener noreferrer"
               class="btn btn-outline-success btn-lg fw-bold">
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
                    <div class="d-flex gap-3 flex-wrap mb-4">
                        <a href="/conference/register" class="btn btn-success btn-lg">
                            <i class="fas fa-user-check me-2"></i>Register as Participant
                        </a>
                        <a href="/exhibition/register" class="btn btn-outline-success btn-lg">
                            <i class="fas fa-store me-2"></i>Register as Exhibitor
                        </a>
                        <a href="https://forms.gle/UsduBgszNWhjQpJS9" target="_blank" rel="noopener noreferrer"
                           class="btn btn-outline-success btn-lg">
                            <i class="fas fa-calendar-plus me-2"></i>Host a Side Event
                        </a>
                        <a href="/about" class="btn btn-outline-secondary btn-lg">
                            Learn More
                        </a>
                    </div>

                    {{-- Info cards --}}
                    <div class="row g-3 mt-1">
                        <div class="col-md-6">
                            <div class="p-3 rounded-3 h-100"
                                 style="background:var(--green-light); border-left:4px solid var(--green-main);">
                                <h6 class="fw-bold text-success mb-2">
                                    <i class="fas fa-map-marker-alt me-2"></i>Venue
                                </h6>
                                <p class="mb-0 text-dark" style="font-size:0.95rem;">
                                    Kenya Agricultural &amp; Livestock Research Organization (KALRO)<br>
                                    Headquarters, Loresho, Nairobi, Kenya
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded-3 h-100"
                                 style="background:var(--green-light); border-left:4px solid var(--green-main);">
                                <h6 class="fw-bold text-success mb-2">
                                    <i class="fas fa-envelope me-2"></i>Contact Us
                                </h6>
                                <p class="mb-0" style="font-size:0.95rem;">
                                    For enquiries, email us at:<br>
                                    <a href="mailto:kalroexpo2026@gmail.com" class="fw-semibold text-success">
                                        kalroexpo2026@gmail.com
                                    </a>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded-3 h-100"
                                 style="background:var(--green-light); border-left:4px solid var(--green-main);">
                                <h6 class="fw-bold text-success mb-2">
                                    <i class="fas fa-globe me-2"></i>Who Should Attend?
                                </h6>
                                <p class="mb-0 text-dark" style="font-size:0.95rem;">
                                    Researchers, scientists, policymakers, development partners, NGOs,
                                    private sector players, and students in agriculture and related fields.
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded-3 h-100"
                                 style="background:var(--green-light); border-left:4px solid var(--green-main);">
                                <h6 class="fw-bold text-success mb-2">
                                    <i class="fas fa-certificate me-2"></i>Conference Proceedings
                                </h6>
                                <p class="mb-0 text-dark" style="font-size:0.95rem;">
                                    Accepted papers will be published in the official KALRO conference
                                    proceedings and considered for peer-reviewed journal publication.
                                </p>
                            </div>
                        </div>
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

                            <li class="mb-3 p-2 rounded"
                                style="background:var(--green-light); border-left:4px solid var(--green-main);">
                                <strong>
                                    <i class="fas fa-star text-success me-1"></i> Registration Open:
                                </strong><br>
                                <span class="text-success fw-bold">Now Open!</span>
                                <br><small class="text-danger fw-semibold">Early bird ends 31st May 2026</small>
                            </li>

                            <li class="mb-3 p-2 rounded"
                                style="background:var(--green-light); border-left:4px solid var(--green-main);">
                                <strong>
                                    <i class="fas fa-calendar-plus text-success me-1"></i> Side Event Proposals:
                                </strong><br>
                                <span class="fw-bold text-success">Now Accepting</span>
                                <br>
                                <a href="https://forms.gle/UsduBgszNWhjQpJS9" target="_blank"
                                   rel="noopener noreferrer" class="small fw-semibold text-success">
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
                           class="btn btn-outline-success w-100 fw-bold">
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
                        <p>Learn from experts, network with peers, and join high-impact discussions. Early bird rates until 31st May.</p>
                        <a href="/conference/register" class="btn btn-success btn-lg w-100 fw-bold">
                            <i class="fas fa-user-check me-2"></i>Register Now
                        </a>
                    </div>
                </div>
            </div>

            {{-- Exhibitor --}}
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 shadow-lg border-0 border-top border-4 border-success">
                    <div class="card-body p-4">
                        <i class="fas fa-store fa-3x text-success mb-3 d-block"></i>
                        <h4 class="fw-bold">Exhibitor</h4>
                        <p>Showcase your products and connect with researchers, policymakers, and industry professionals.</p>
                        <a href="/exhibition/register" class="btn btn-success btn-lg w-100 fw-bold">
                            <i class="fas fa-store me-2"></i>Become an Exhibitor
                        </a>
                    </div>
                </div>
            </div>

            {{-- Submit Paper --}}
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 shadow-lg border-0 border-top border-4 border-success">
                    <div class="card-body p-4">
                        <i class="fas fa-file-alt fa-3x text-success mb-3 d-block"></i>
                        <h4 class="fw-bold">Submit Research</h4>
                        <p>Full paper submission deadline: <strong>17th April 2026</strong>. Abstract submission is now closed.</p>
                        <a href="/submit-abstract" class="btn btn-outline-success btn-lg w-100">
                            Paper Submission
                        </a>
                    </div>
                </div>
            </div>

            {{-- Side Event --}}
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 shadow-lg border-0 border-top border-4 border-success">
                    <div class="card-body p-4">
                        <i class="fas fa-calendar-plus fa-3x text-success mb-3 d-block"></i>
                        <h4 class="fw-bold">Host a Side Event</h4>
                        <p>Organise a workshop, symposium, or special session. Submit your proposal and secure a slot.</p>
                        <a href="https://forms.gle/UsduBgszNWhjQpJS9"
                           target="_blank" rel="noopener noreferrer"
                           class="btn btn-success btn-lg w-100 fw-bold">
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


{{-- ================= CONFERENCE DOWNLOADS ================= --}}
<section class="downloads-section py-5">
    <div class="container">

        <div class="text-center mb-4">
            <h2 class="fw-bold mb-1" style="color:var(--green-dark);">
                <i class="fas fa-download me-2 text-success"></i>Conference Downloads
            </h2>
            <p class="text-muted mb-0">Key documents for the KALRO 2nd Scientific Conference &amp; Innovation Expo 2026</p>
        </div>

        <div class="row g-4 justify-content-center">

            {{-- Conference Program --}}
            <div class="col-lg-4 col-md-6">
                <div class="download-card h-100">
                    <div class="download-card-icon" style="background:#1e3a5f;">
                        <i class="fas fa-calendar-alt fa-2x"></i>
                    </div>
                    <div class="download-card-body">
                        <h5 class="fw-bold mb-1">Conference Program</h5>
                        <p class="text-muted mb-3" style="font-size:.88rem;">
                            Full 5-day schedule — keynotes, parallel sessions, and all programme details.
                        </p>
                        <div class="d-flex gap-2">
                            <a href="/program/KALRO_Conference_Program_2026.pdf"
                               download="KALRO_Conference_Program_2026.pdf"
                               class="btn btn-success fw-bold flex-grow-1">
                                <i class="fas fa-download me-2"></i>Download &nbsp;<span class="opacity-75" style="font-size:.8rem;">PDF</span>
                            </a>
                            <a href="/conference-program"
                               class="btn btn-outline-success fw-bold"
                               title="View online">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Book of Abstracts --}}
            <div class="col-lg-4 col-md-6">
                <div class="download-card h-100">
                    <div class="download-card-icon">
                        <i class="fas fa-book-open fa-2x"></i>
                    </div>
                    <div class="download-card-body">
                        <h5 class="fw-bold mb-1">Book of Abstracts</h5>
                        <p class="text-muted mb-3" style="font-size:.88rem;">
                            All submitted research papers, findings, and presentations from the 2026 conference.
                        </p>
                        <a href="/program/Book%20of%20Abstract%202026%20conference%20last%20updt%2013-6.pdf"
                           download
                           class="btn btn-success fw-bold w-100">
                            <i class="fas fa-download me-2"></i>Download &nbsp;<span class="opacity-75" style="font-size:.8rem;">PDF · Updated 13 Jun</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Side Events Programme --}}
            <div class="col-lg-4 col-md-6">
                <div class="download-card h-100">
                    <div class="download-card-icon" style="background:#5b21b6;">
                        <i class="fas fa-bolt fa-2x"></i>
                    </div>
                    <div class="download-card-body">
                        <h5 class="fw-bold mb-1">Side Events Programme</h5>
                        <p class="text-muted mb-3" style="font-size:.88rem;">
                            10 focused sessions on Wed 17 &amp; Thu 18 June — schedules, hosts, and session details.
                        </p>
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="/program/Program_Side_event.pdf"
                               download
                               class="btn btn-success fw-bold flex-grow-1">
                                <i class="fas fa-download me-2"></i>Programme <span class="opacity-75" style="font-size:.8rem;">PDF</span>
                            </a>
                            <a href="/program/Side%20Event%20booklet%20compilation%20.pdf"
                               download="Side_Event_Booklet_Compilation.pdf"
                               class="btn btn-success fw-bold flex-grow-1">
                                <i class="fas fa-download me-2"></i>Booklet <span class="opacity-75" style="font-size:.8rem;">PDF</span>
                            </a>
                            <a href="/conference-program#side-events"
                               class="btn btn-outline-success fw-bold"
                               title="View in Full Programme">
                                <i class="fas fa-calendar-alt"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


{{-- ================= PARTNERS / SPONSORS ================= --}}
<section class="partners-section py-5">
    <div class="container">

        <div class="text-center mb-4">
            <h2 class="fw-bold mb-2">
                <i class="fas fa-handshake me-2 text-success"></i>Our Partners
            </h2>
            <p class="text-muted mx-auto" style="max-width:600px;">
                We are proud to be supported by leading organisations committed to advancing
                agricultural research, food security, and sustainable development.
            </p>
        </div>

        <div class="row align-items-center justify-content-center g-4">

            {{-- Ministry of Agriculture --}}
            <div class="col-lg-3 col-md-6 col-6">
                <a href="https://kilimo.go.ke/" target="_blank" rel="noopener noreferrer" class="partner-logo-wrap d-flex">
                    <img src="assets/images/MOA.png" alt="Ministry of Agriculture">
                </a>
            </div>

            {{-- FSRP --}}
            <div class="col-lg-3 col-md-6 col-6">
                <a href="https://fsrp.go.ke" target="_blank" rel="noopener noreferrer" class="partner-logo-wrap d-flex">
                    <img src="assets/images/fsrp.jpg" alt="Food Systems Resilience Program (FSRP)">
                </a>
            </div>

            {{-- FAO --}}
            <div class="col-lg-3 col-md-6 col-6">
                <a href="https://www.fao.org/kenya/en" target="_blank" rel="noopener noreferrer" class="partner-logo-wrap partner-logo-fao d-flex">
                    <img src="assets/images/FAO.png" alt="Food and Agriculture Organization (FAO)">
                </a>
            </div>

            {{-- AFA --}}
            <div class="col-lg-3 col-md-6 col-6">
                <a href="https://www.afa.go.ke/" target="_blank" rel="noopener noreferrer" class="partner-logo-wrap d-flex">
                    <img src="assets/images/AFA.jpg" alt="Agriculture and Food Authority (AFA)">
                </a>
            </div>

        </div>

    </div>
</section>

@endsection