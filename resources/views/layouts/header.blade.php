<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KALRO Conference | @yield('title')</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="Join Kenya's premier agricultural research conference for knowledge exchange and networking.">
    <meta name="keywords" content="2nd KALRO Scientific Conference and Exhibition, Agriculture, Research, Kenya">
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
        /* =========================
           NAVIGATION STYLING
        ========================== */

        .navbar .nav-link {
            position: relative;
            padding: 10px 15px;
            font-weight: 500;
        }

        /* Small underline effect */
        .navbar .nav-link::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: 0;
            width: 0%;
            height: 3px;
            background-color: #ffc107;
            transition: 0.3s ease;
        }

        /* Hover underline */
        .navbar .nav-link:hover::after {
            width: 100%;
        }

        /* Active underline */
        .navbar .nav-link.active::after {
            width: 100%;
        }


        .dropdown-menu {
            border-radius: 8px;
            border: none;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .dropdown-item {
            transition: 0.2s ease;
            font-weight: 500;
        }


        .dropdown-item:hover,
        .dropdown-item:focus {
            background-color: #e9f7ef !important;  /* light green */
            color: #198754 !important;             /* green text */
        }

   
        .dropdown-item.active,
        .dropdown-item:active {
            background-color: #d1e7dd !important;  /* soft green */
            color: #146c43 !important;
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
                        <i class="fas fa-bullhorn me-2"></i> 
                        Call for Papers Now Open! Submit your research abstracts before <b>13th February.</b>
                    </marquee>
                </div>
                <div class="col-lg-4 col-md-5 col-12 text-end">
                    <span class="d-none d-md-inline">
                        <i class="fas fa-calendar-alt me-1"></i> 
                        18th to 22nd May 2026 
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
                    <h1 class="h4 mb-1">2nd KALRO Scientific Conference and Exhibition</h1>
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
    <nav class="navbar navbar-expand-lg navbar-dark"
         style="background: linear-gradient(135deg, #198754 0%, #146c43 100%); box-shadow: 0 .5rem 1rem rgba(0,0,0,.15);">
        <div class="container">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav me-auto">

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="/">
                            <i class="fas fa-home me-1"></i> Home
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('about') ? 'active' : '' }}" href="/about">
                            <i class="fas fa-info-circle me-1"></i> About Conference
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle 
                           {{ Request::is('conference*') || Request::is('exhibition*') ? 'active' : '' }}"
                           href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-bullseye me-1"></i> Conference
                        </a>

                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item {{ Request::is('conference-theme') ? 'active' : '' }}"
                                   href="/conference-theme">
                                   Conference Theme
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ Request::is('conference-procedure') ? 'active' : '' }}"
                                   href="/conference-procedure">
                                   Conference Procedure
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ Request::is('conference/register') ? 'active' : '' }}"
                                   href="/conference/register">
                                   Register as Participant
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ Request::is('exhibition/register') ? 'active' : '' }}"
                                   href="/exhibition/register">
                                   Become an Exhibitor
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('submit-abstract') ? 'active' : '' }}" href="/submit-abstract">
                            <i class="fas fa-paper-plane me-1"></i> Submit Abstract
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('contact') ? 'active' : '' }}" href="/contact">
                            <i class="fas fa-envelope me-1"></i> Contact Us
                        </a>
                    </li>

                </ul>

                <div class="d-flex">
                    <a href="/conference/register" class="btn btn-warning btn-sm">
                        <i class="fas fa-user-plus me-1"></i> Register Now
                    </a>
                </div>

            </div>
        </div>
    </nav>

    <main class="main-content">
        @yield('content')
    </main>

    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
