<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KALRO Conference | @yield('title')</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="Join Kenya's premier agricultural research conference for knowledge exchange and networking.">
    <meta name="keywords" content="2nd KALRO Scientific Conference and Innovation Expo, Agriculture, Research, Kenya">
    <meta name="author" content="KALRO">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/css/style.css">

    <style>
        /* ================================
           NAVBAR CLEAN PROFESSIONAL STYLE
        ================================= */

        .navbar {
            background: linear-gradient(135deg, #198754 0%, #146c43 100%);
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15);
        }

        /* Make ALL nav links white */
        .navbar .nav-link,
        .navbar .navbar-brand,
        .navbar .dropdown-toggle {
            color: #ffffff !important;
            position: relative;
            font-weight: 500;
            padding: 8px 9px;
            font-size: .82rem;
            white-space: nowrap;
        }

        /* Remove bootstrap hover background */
        .navbar .nav-link:hover,
        .navbar .nav-link:focus {
            color: #ffffff !important;
            background: transparent !important;
        }

        /* Underline effect */
        .navbar .nav-link::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: 0;
            width: 0%;
            height: 3px;
            background-color: #ffc107;
            transition: width 0.3s ease;
        }

        /* Hover underline */
        .navbar .nav-link:hover::after {
            width: 100%;
        }

        /* Active underline */
        .navbar .nav-link.active::after {
            width: 100%;
        }

        /* Compact CTA buttons */
        .navbar .btn {
            font-size: .76rem;
            padding: 5px 9px;
            white-space: nowrap;
        }

        /* Keep navbar on one line */
        .navbar-collapse {
            flex-wrap: nowrap !important;
        }
        .navbar-nav {
            flex-wrap: nowrap !important;
        }

        /* ================================
           DROPDOWN CLEAN FIX
        ================================= */

        .dropdown-menu {
            border-radius: 8px;
            border: none;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        /* Clean dropdown items */
        .dropdown-item {
            font-weight: 500;
            color: #212529;
            background: transparent;
        }

        .dropdown-item:hover {
            background-color: #e9f7ef !important;
            color: #198754 !important;
        }

        /* Remove blue active background */
        .dropdown-item.active {
            background: transparent !important;
            color: #198754 !important;
            font-weight: 600;
        }

        /* Dropdown auto open on hover (desktop only) */
        @media (min-width: 992px) {
            .navbar .dropdown:hover .dropdown-menu {
                display: block;
                margin-top: 0;
            }
        }
    </style>

    <link rel="icon" type="image/x-icon" href="/assets/images/favicon.ico">
</head>

<body>

    <!-- Top Announcement Bar -->
    <div class="announcement-bar bg-dark text-white py-2">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 col-md-7 col-12">
                    <marquee behavior="scroll" direction="left" scrollamount="3">
                        <i class="fas fa-bell me-2"></i>
                        Registration is Now Open! &nbsp;|&nbsp;
                        <i class="fas fa-users me-1"></i> Participant Registration &amp; Exhibitor Registration now available.
                        &nbsp;|&nbsp; Early bird pricing ends <b>31st May 2026.</b>
                        &nbsp;|&nbsp; Conference: <b>15th – 19th June 2026, Nairobi, Kenya.</b>
                    </marquee>
                </div>
                <div class="col-lg-4 col-md-5 col-12 text-end">
                    <span class="d-none d-md-inline">
                        <i class="fas fa-calendar-alt me-1"></i> 
                        15th to 19th June 2026
                        <i class="fas fa-map-marker-alt ms-2 me-1"></i> 
                        Nairobi, Kenya
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Header -->
    <header class="header-area">
        <div class="container">
            <div class="row align-items-center py-3">

                <div class="col-lg-1 col-md-4 col-6">
                    <a href="/">
                        <img src="/assets/images/kalro-logo.gif" alt="KALRO Logo" class="img-fluid">
                    </a>
                </div>

                <div class="col-lg-7 col-md-4 d-none d-md-block">
                    <h1 class="h4 mb-1">2nd KALRO Scientific Conference and Innovation Expo</h1>
                    <p class="mb-0 text-muted">Strengthening Agricultural Innovation Systems</p>
                </div>

                <div class="col-lg-4 col-md-4 col-6 text-end">
                    <div>
                        <i class="fas fa-phone-alt me-2"></i>
                        <a href="tel:+254800721741" class="text-decoration-none">0800 721741</a>
                    </div>
                    <div>
                        <i class="fas fa-envelope me-2"></i>
                        <a href="mailto:kalroconference2026@gmail.com" class="text-decoration-none">
                            kalroconference2026@gmail.com
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </header>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid px-3">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav me-auto flex-nowrap">

                    <!-- Home -->
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="/">
                            <i class="fas fa-home me-1"></i> Home
                        </a>
                    </li>

                    <!-- About -->
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('about') ? 'active' : '' }}" href="/about">
                            <i class="fas fa-info-circle me-1"></i> About Conference
                        </a>
                    </li>

                    <!-- Program — top-level for visibility -->
                    <!-- <li class="nav-item">
                        <a class="nav-link fw-bold {{ Request::is('conference-program') ? 'active' : '' }}"
                           href="/conference-program"
                           style="{{ Request::is('conference-program') ? '' : 'color:#ffc107!important;' }}">
                            <i class="fas fa-calendar-alt me-1"></i> Program
                        </a>
                    </li> -->

                    <!-- Conference Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle 
                           {{ Request::is('conference*') || Request::is('exhibition*') || Request::is('conference-program') ? 'active' : '' }}"
                           href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-bullseye me-1"></i> Conference
                        </a>

                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item {{ Request::is('conference-theme') ? 'active' : '' }}"
                                   href="/conference-theme">
                                   <i class="fas fa-book-open me-1"></i> Conference Theme
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ Request::is('conference-procedure') ? 'active' : '' }}"
                                   href="/conference-procedure">
                                   <i class="fas fa-tasks me-1"></i> Conference Procedure
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ Request::is('conference-program') ? 'active' : '' }}"
                                   href="/conference-program">
                                   <i class="fas fa-calendar-alt me-1"></i> Conference Program
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item {{ Request::is('conference/register') ? 'active' : '' }}"
                                   href="/conference/register">
                                   <i class="fas fa-user-plus me-1"></i> Register as Participant
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ Request::is('exhibition/floor-plan') ? 'active' : '' }}"
                                   href="/exhibition/floor-plan">
                                   <i class="fas fa-map me-1"></i> Exhibition Floor Plan
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ Request::is('exhibition/register') ? 'active' : '' }}"
                                   href="/exhibition/register">
                                   <i class="fas fa-handshake me-1"></i> Become an Exhibitor
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Papers Dropdown (replaces standalone Submit Abstract) -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle
                           {{ Request::is('submit-abstract') || Request::is('submit-paper') ? 'active' : '' }}"
                           href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-file-alt me-1"></i> Papers
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item {{ Request::is('submit-abstract') ? 'active' : '' }}"
                                   href="/submit-abstract">
                                   <i class="fas fa-paper-plane me-1"></i> Submit Full Paper
                                </a>
                            </li>
                            
                            <li>
                                <a class="dropdown-item {{ Request::is('conference-procedure') ? 'active' : '' }}"
                                   href="/conference-procedure">
                                   <i class="fas fa-list-alt me-1"></i> Submission Guidelines
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Contact -->
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('contact') ? 'active' : '' }}" href="/contact">
                            <i class="fas fa-envelope me-1"></i> Contact Us
                        </a>
                    </li>

                </ul>

                <!-- Nav CTA Buttons -->
                <div class="d-flex gap-1 flex-nowrap align-items-center">
                    <a href="/conference/register" class="btn btn-warning btn-sm fw-bold">
                        <i class="fas fa-user-check me-1"></i> Register Now
                    </a>
                    <a href="/conference-program" class="btn btn-success btn-sm fw-bold">
                        <i class="fas fa-calendar-alt me-1"></i> Program
                    </a>
                    <a href="https://forms.gle/UsduBgszNWhjQpJS9" target="_blank" rel="noopener noreferrer"
       class="btn btn-sm fw-bold" style="background:var(--gold,#f5a623); color:#1a2b1f; border:none;">
        <i class="fas fa-calendar-plus me-1"></i> Side Event
    </a>
                    <a href="/exhibition/floor-plan" class="btn btn-outline-light btn-sm px-2" title="Exhibition Floor Plan">
                        <i class="fas fa-map me-1"></i> Floor Plan
                    </a>
                    <a href="/exhibition/register" class="btn btn-outline-light btn-sm px-2" title="Become an Exhibitor">
                        <i class="fas fa-store me-1"></i> Exhibitor
                    </a>
                </div>

            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    @include('layouts.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>