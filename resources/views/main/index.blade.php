@extends('layouts.header')

@section('title')
    Home
@endsection

@section('content')

<style>
/* =====================================================
   KALRO 2nd Scientific Conference — Homepage Styles
   ===================================================== */

/* Google Fonts */
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=DM+Sans:wght@400;500;600;700&display=swap');

:root {
    --green-dark:    #0f3d1f;
    --green-main:    #1e6b35;
    --green-mid:     #2e8b47;
    --green-light:   #e6f4ea;
    --green-pale:    #f2faf4;
    --gold:          #e8a020;
    --gold-light:    #fdf3e0;
    --text-dark:     #0f1f14;
    --text-body:     #2d3d32;
    --text-muted:    #5a7060;
    --white:         #ffffff;
    --border-light:  #d0e8d8;
    --shadow-green:  rgba(30,107,53,0.12);
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body {
    font-family: 'DM Sans', sans-serif;
    color: var(--text-body);
    background: var(--white);
}

h1, h2, h3, h4, h5, .display-font {
    font-family: 'Playfair Display', Georgia, serif;
}


/* =====================================================
   HERO CAROUSEL
   ===================================================== */
.hero-section { position: relative; }

.hero-section .carousel-item img {
    height: 600px;
    object-fit: cover;
    object-position: center;
    filter: brightness(0.55);
}

/* Diagonal green overlay accent */
.hero-section .carousel-item::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(
        160deg,
        rgba(15,61,31,0.55) 0%,
        rgba(15,61,31,0.15) 50%,
        transparent 100%
    );
    pointer-events: none;
}

.hero-section .carousel-caption {
    bottom: 70px;
    left: 50%;
    transform: translateX(-50%);
    width: 92%;
    max-width: 900px;
    text-align: center;
    z-index: 10;
}

.hero-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(232,160,32,0.18);
    border: 1px solid rgba(232,160,32,0.55);
    backdrop-filter: blur(6px);
    color: #f5c761;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.78rem;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    padding: 0.45rem 1.2rem;
    border-radius: 100px;
    margin-bottom: 1.1rem;
}

.hero-eyebrow .dot {
    width: 7px; height: 7px;
    border-radius: 50%;
    background: var(--gold);
    animation: pulse-dot 2s ease-in-out infinite;
}

@keyframes pulse-dot {
    0%, 100% { opacity: 1; transform: scale(1); }
    50%       { opacity: 0.5; transform: scale(0.7); }
}

.hero-section .carousel-caption h2 {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: clamp(2rem, 4.5vw, 3.2rem);
    font-weight: 800;
    color: #ffffff;
    line-height: 1.18;
    margin-bottom: 1rem;
    text-shadow: 0 3px 16px rgba(0,0,0,0.5);
    letter-spacing: -0.01em;
}

.hero-meta {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: rgba(0,0,0,0.42);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,0.12);
    border-left: 3px solid var(--gold);
    border-radius: 8px;
    padding: 0.7rem 1.4rem;
    color: #fff;
    font-family: 'DM Sans', sans-serif;
    font-size: clamp(0.9rem, 1.8vw, 1.05rem);
    font-weight: 500;
    margin-bottom: 1.6rem;
}

.hero-meta strong { color: #f5c761; font-weight: 700; }
.hero-meta .pipe  { opacity: 0.4; }

.hero-btn-group {
    display: flex;
    justify-content: center;
    gap: 12px;
    flex-wrap: wrap;
}

/* Carousel controls */
.carousel-control-prev-icon,
.carousel-control-next-icon {
    background-color: rgba(15,61,31,0.65);
    border-radius: 50%;
    padding: 20px;
    background-size: 50%;
    border: 1px solid rgba(255,255,255,0.2);
}

.carousel-indicators [data-bs-target] {
    width: 8px; height: 8px;
    border-radius: 50%;
    background: rgba(255,255,255,0.5);
    border: none;
    transition: background 0.3s, transform 0.3s;
}
.carousel-indicators .active {
    background: var(--gold);
    transform: scale(1.3);
}


/* =====================================================
   ANNOUNCEMENT TICKER
   ===================================================== */
.announcement-ticker {
    background: var(--green-dark);
    padding: 0;
    overflow: hidden;
    border-bottom: 2px solid var(--gold);
}

.ticker-inner {
    display: flex;
    align-items: stretch;
    min-height: 46px;
}

.ticker-label {
    background: var(--gold);
    color: var(--green-dark);
    font-family: 'DM Sans', sans-serif;
    font-size: 0.72rem;
    font-weight: 800;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    padding: 0 1.4rem;
    display: flex;
    align-items: center;
    white-space: nowrap;
    flex-shrink: 0;
    gap: 7px;
}

.ticker-label i { font-size: 0.85rem; }

.ticker-scroll-wrap {
    flex: 1;
    overflow: hidden;
    display: flex;
    align-items: center;
    padding: 0 1rem;
}

.ticker-scroll {
    display: flex;
    gap: 0;
    animation: ticker-move 30s linear infinite;
    white-space: nowrap;
}

.ticker-scroll:hover { animation-play-state: paused; }

@keyframes ticker-move {
    0%   { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}

.ticker-item {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: rgba(255,255,255,0.9);
    font-family: 'DM Sans', sans-serif;
    font-size: 0.88rem;
    font-weight: 500;
    padding: 0 2.5rem;
    text-decoration: none;
    transition: color 0.2s;
}
.ticker-item:hover { color: #f5c761; }
.ticker-item strong { color: #f5c761; }
.ticker-sep {
    display: inline-block;
    width: 5px; height: 5px;
    border-radius: 50%;
    background: var(--gold);
    opacity: 0.5;
    flex-shrink: 0;
}

.ticker-cta-group {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 0 1rem;
    flex-shrink: 0;
    border-left: 1px solid rgba(255,255,255,0.1);
}


/* =====================================================
   CONFERENCE THEME
   ===================================================== */
.conference-theme {
    background: var(--green-pale);
    border-top: 1px solid var(--border-light);
    border-bottom: 1px solid var(--border-light);
    padding: 4rem 0;
    position: relative;
    overflow: hidden;
}

/* Decorative background leaf shape */
.conference-theme::before {
    content: '';
    position: absolute;
    top: -60px; right: -80px;
    width: 380px; height: 380px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(30,107,53,0.07) 0%, transparent 70%);
    pointer-events: none;
}

.theme-tag {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: var(--green-light);
    border: 1px solid var(--border-light);
    color: var(--green-main);
    font-family: 'DM Sans', sans-serif;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    padding: 0.4rem 1rem;
    border-radius: 100px;
    margin-bottom: 1rem;
}

.conference-theme h2 {
    font-size: clamp(1.6rem, 3vw, 2.4rem);
    color: var(--green-dark);
    line-height: 1.25;
    margin-bottom: 1rem;
}

.conference-theme .theme-quote {
    font-family: 'DM Sans', sans-serif;
    font-size: 1rem;
    color: var(--text-muted);
    max-width: 820px;
    margin: 0 auto;
    line-height: 1.75;
    border-left: 3px solid var(--green-mid);
    padding-left: 1.2rem;
    text-align: left;
}


/* =====================================================
   QUICK STATS
   ===================================================== */
.quick-stats {
    background: var(--white);
    padding: 3.5rem 0;
    border-bottom: 1px solid var(--border-light);
}

.stat-card {
    background: var(--green-pale);
    border: 1px solid var(--border-light);
    border-radius: 16px;
    padding: 2rem 1.25rem;
    text-align: center;
    position: relative;
    overflow: hidden;
    transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--green-main), var(--green-mid));
    border-radius: 16px 16px 0 0;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 32px var(--shadow-green);
    border-color: var(--green-mid);
}

.stat-icon {
    width: 52px; height: 52px;
    border-radius: 14px;
    background: var(--green-light);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.4rem;
    color: var(--green-main);
}

.stat-card h3 {
    font-family: 'Playfair Display', serif;
    font-size: 2.6rem;
    font-weight: 800;
    color: var(--green-dark);
    line-height: 1;
    margin-bottom: 0.3rem;
}

.stat-card p {
    font-family: 'DM Sans', sans-serif;
    font-size: 0.88rem;
    font-weight: 600;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin: 0;
}


/* =====================================================
   PARTICIPATE STRIP
   ===================================================== */
.participate-strip {
    background: var(--green-dark);
    padding: 0;
}

.participate-strip .strip-inner {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    min-height: 72px;
}

@media (max-width: 767px) {
    .participate-strip .strip-inner { grid-template-columns: repeat(2, 1fr); }
}

.participate-item {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 11px;
    color: rgba(255,255,255,0.88);
    text-decoration: none;
    padding: 1rem 0.75rem;
    border-right: 1px solid rgba(255,255,255,0.07);
    transition: background 0.2s, color 0.2s;
    font-family: 'DM Sans', sans-serif;
}

.participate-item:last-child { border-right: none; }

.participate-item:hover {
    background: rgba(255,255,255,0.08);
    color: #ffffff;
}

.participate-item i {
    font-size: 1.3rem;
    color: var(--gold);
}

.participate-item .pi-text strong {
    display: block;
    font-size: 0.9rem;
    font-weight: 700;
    line-height: 1.2;
}

.participate-item .pi-text span {
    font-size: 0.72rem;
    opacity: 0.65;
}


/* =====================================================
   SIDE EVENT SECTION
   ===================================================== */
.side-event-section {
    background: #f8fdf9;
    border-top: 1px solid var(--border-light);
    border-bottom: 1px solid var(--border-light);
    padding: 4.5rem 0;
}

.section-pill {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: var(--green-light);
    border: 1px solid var(--border-light);
    color: var(--green-main);
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    padding: 0.4rem 1rem;
    border-radius: 100px;
    margin-bottom: 0.85rem;
}

.side-event-card {
    background: var(--white);
    border: 1px solid var(--border-light);
    border-radius: 20px;
    padding: 2rem;
    height: 100%;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
    position: relative;
    overflow: hidden;
}

.side-event-card::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--green-main), var(--green-mid));
    border-radius: 0 0 20px 20px;
    opacity: 0;
    transition: opacity 0.25s;
}

.side-event-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 40px var(--shadow-green);
}

.side-event-card:hover::after { opacity: 1; }

.card-icon-circle {
    width: 50px; height: 50px;
    border-radius: 14px;
    background: var(--green-light);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.25rem;
    color: var(--green-main);
    margin-bottom: 1.1rem;
}

.side-event-card h5 {
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 0.65rem;
}

.side-event-card p {
    font-size: 0.9rem;
    color: var(--text-muted);
    line-height: 1.7;
}

.alert-cta-bar {
    background: var(--green-light);
    border: 1px solid var(--border-light);
    border-radius: 16px;
    padding: 1.4rem 1.8rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1.5rem;
    flex-wrap: wrap;
    margin-top: 2rem;
}

.alert-cta-bar h5 {
    font-size: 1rem;
    font-weight: 700;
    color: var(--green-dark);
    margin-bottom: 0.2rem;
}

.alert-cta-bar p {
    font-size: 0.88rem;
    color: var(--text-muted);
    margin: 0;
}


/* =====================================================
   MID CTA STRIP
   ===================================================== */
.mid-cta-strip {
    background: var(--white);
    border-top: 1px solid var(--border-light);
    border-bottom: 1px solid var(--border-light);
    padding: 2.5rem 0;
}


/* =====================================================
   MAIN CONTENT (Welcome + Dates)
   ===================================================== */
.main-content { padding: 5rem 0; }

.welcome-badge {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: var(--gold-light);
    border: 1px solid rgba(232,160,32,0.3);
    color: #8a5e10;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    padding: 0.4rem 1rem;
    border-radius: 100px;
    margin-bottom: 1rem;
}

.welcome-section h1 {
    font-size: clamp(1.9rem, 3.5vw, 2.75rem);
    font-weight: 800;
    color: var(--text-dark);
    line-height: 1.2;
    margin-bottom: 1.1rem;
    letter-spacing: -0.02em;
}

.welcome-section h1 .accent { color: var(--green-main); }

.welcome-section p.lead {
    font-size: 1.05rem;
    color: var(--text-muted);
    line-height: 1.75;
    margin-bottom: 1.8rem;
}

/* Dates card */
.dates-card {
    border: 1px solid var(--border-light);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 24px var(--shadow-green);
}

.dates-card .card-header {
    background: var(--green-dark);
    padding: 1.1rem 1.5rem;
    display: flex;
    align-items: center;
    gap: 10px;
}

.dates-card .card-header h4 {
    font-family: 'DM Sans', sans-serif;
    font-size: 1rem;
    font-weight: 700;
    color: #fff;
    margin: 0;
}

.dates-card .card-body { padding: 1.5rem; }

.date-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--border-light);
}

.date-item:last-child { border-bottom: none; }

.date-dot {
    width: 10px; height: 10px;
    border-radius: 50%;
    background: var(--green-mid);
    margin-top: 5px;
    flex-shrink: 0;
}

.date-dot.gold   { background: var(--gold); }
.date-dot.red    { background: #dc3545; }
.date-dot.muted  { background: #ced4da; }

.date-item .label {
    font-size: 0.78rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--text-muted);
    margin-bottom: 0.15rem;
}

.date-item .value {
    font-size: 0.93rem;
    font-weight: 600;
    color: var(--text-dark);
}

.date-item .value.open   { color: var(--green-main); }
.date-item .value.closed { color: #dc3545; }
.date-item .value.gold   { color: #b8730a; }


/* =====================================================
   FINAL CTA
   ===================================================== */
.cta-section {
    background: var(--green-dark);
    padding: 5rem 0;
    position: relative;
    overflow: hidden;
}

/* Decorative circles */
.cta-section::before {
    content: '';
    position: absolute;
    top: -100px; right: -100px;
    width: 400px; height: 400px;
    border-radius: 50%;
    border: 60px solid rgba(255,255,255,0.04);
    pointer-events: none;
}

.cta-section::after {
    content: '';
    position: absolute;
    bottom: -80px; left: -80px;
    width: 300px; height: 300px;
    border-radius: 50%;
    border: 50px solid rgba(255,255,255,0.03);
    pointer-events: none;
}

.cta-section h2 {
    font-size: clamp(1.8rem, 3.5vw, 2.8rem);
    color: #ffffff;
    font-weight: 800;
    letter-spacing: -0.02em;
    line-height: 1.2;
}

.cta-section .sub {
    color: rgba(255,255,255,0.65);
    font-size: 1.05rem;
    max-width: 780px;
    line-height: 1.7;
}

.cta-card {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 20px;
    padding: 2rem 1.5rem;
    height: 100%;
    transition: background 0.25s ease, transform 0.25s ease, border-color 0.25s ease;
    position: relative;
}

.cta-card:hover {
    background: rgba(255,255,255,0.1);
    border-color: rgba(255,255,255,0.22);
    transform: translateY(-5px);
}

.cta-card .card-icon {
    width: 56px; height: 56px;
    border-radius: 16px;
    background: rgba(255,255,255,0.1);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.5rem;
    color: #f5c761;
    margin-bottom: 1.1rem;
}

.cta-card h4 {
    font-family: 'DM Sans', sans-serif;
    font-size: 1.05rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: 0.6rem;
}

.cta-card p {
    font-size: 0.88rem;
    color: rgba(255,255,255,0.6);
    line-height: 1.65;
    margin-bottom: 1.25rem;
}

.badge-popular {
    position: absolute;
    top: -10px; right: 18px;
    background: var(--gold);
    color: var(--green-dark);
    font-size: 0.68rem;
    font-weight: 800;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    padding: 0.25rem 0.8rem;
    border-radius: 100px;
}


/* =====================================================
   PARTNERS MARQUEE
   ===================================================== */
.partners-marquee-section {
    background: #ffffff;
    border-top: 3px solid var(--green-main);
    padding: 2rem 0 2.4rem;
    overflow: hidden;
}

.partners-marquee-section .pm-label {
    text-align: center;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: var(--text-muted);
    margin-bottom: 1.6rem;
    position: relative;
}

.pm-label::before,
.pm-label::after {
    content: '';
    display: inline-block;
    width: 40px; height: 1px;
    background: var(--border-light);
    vertical-align: middle;
    margin: 0 0.75rem;
}

.marquee-outer {
    width: 100%;
    overflow: hidden;
    -webkit-mask-image: linear-gradient(to right, transparent 0%, #000 7%, #000 93%, transparent 100%);
    mask-image: linear-gradient(to right, transparent 0%, #000 7%, #000 93%, transparent 100%);
}

.marquee-outer:hover .marquee-track { animation-play-state: paused; }

.marquee-track {
    display: flex;
    align-items: center;
    width: max-content;
    animation: marquee-scroll 34s linear infinite;
}

@keyframes marquee-scroll {
    0%   { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}

.marquee-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 0 2.8rem;
    flex-shrink: 0;
    text-decoration: none;
    opacity: 0.78;
    transition: opacity 0.2s, transform 0.22s;
}

.marquee-item:hover { opacity: 1; transform: translateY(-3px); }

.marquee-item img {
    height: 60px;
    max-width: 155px;
    width: auto;
    object-fit: contain;
    display: block;
}

.partner-label {
    display: none;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.72rem;
    font-weight: 700;
    color: var(--green-dark);
    text-align: center;
    max-width: 140px;
    line-height: 1.35;
    background: var(--green-light);
    border: 1px solid var(--border-light);
    border-radius: 8px;
    padding: 6px 14px;
}

.marquee-item.img-error img            { display: none; }
.marquee-item.img-error .partner-label { display: block; }

.marquee-sep {
    flex-shrink: 0;
    width: 5px; height: 5px;
    border-radius: 50%;
    background: var(--border-light);
    margin: 0 0.25rem;
}


/* =====================================================
   GLOBAL BUTTONS
   ===================================================== */
.btn-kalro-primary {
    background: var(--green-main);
    border: 1.5px solid var(--green-main);
    color: #fff;
    font-family: 'DM Sans', sans-serif;
    font-weight: 700;
    border-radius: 10px;
    padding: 0.65rem 1.4rem;
    transition: background 0.2s, border-color 0.2s, transform 0.15s, box-shadow 0.2s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-size: 0.92rem;
}
.btn-kalro-primary:hover {
    background: var(--green-dark);
    border-color: var(--green-dark);
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 6px 18px var(--shadow-green);
}

.btn-kalro-primary.lg { padding: 0.8rem 1.75rem; font-size: 1rem; border-radius: 12px; }

.btn-kalro-outline {
    background: transparent;
    border: 1.5px solid rgba(255,255,255,0.45);
    color: #fff;
    font-family: 'DM Sans', sans-serif;
    font-weight: 600;
    border-radius: 10px;
    padding: 0.65rem 1.4rem;
    transition: background 0.2s, border-color 0.2s, transform 0.15s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-size: 0.92rem;
}
.btn-kalro-outline:hover {
    background: rgba(255,255,255,0.1);
    border-color: rgba(255,255,255,0.7);
    color: #fff;
    transform: translateY(-1px);
}
.btn-kalro-outline.lg { padding: 0.8rem 1.75rem; font-size: 1rem; border-radius: 12px; }

.btn-kalro-gold {
    background: var(--gold);
    border: 1.5px solid var(--gold);
    color: var(--green-dark);
    font-family: 'DM Sans', sans-serif;
    font-weight: 800;
    border-radius: 10px;
    padding: 0.65rem 1.4rem;
    transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-size: 0.92rem;
}
.btn-kalro-gold:hover {
    background: #c8881a;
    border-color: #c8881a;
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(232,160,32,0.35);
}
.btn-kalro-gold.lg { padding: 0.8rem 1.75rem; font-size: 1rem; border-radius: 12px; }

.btn-kalro-green-outline {
    background: transparent;
    border: 1.5px solid var(--green-main);
    color: var(--green-main);
    font-family: 'DM Sans', sans-serif;
    font-weight: 700;
    border-radius: 10px;
    padding: 0.65rem 1.4rem;
    transition: background 0.2s, color 0.2s, transform 0.15s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-size: 0.92rem;
}
.btn-kalro-green-outline:hover {
    background: var(--green-main);
    color: #fff;
    transform: translateY(-1px);
}
.btn-kalro-green-outline.lg { padding: 0.8rem 1.75rem; font-size: 1rem; border-radius: 12px; }

/* =====================================================
   RESPONSIVE
   ===================================================== */
@media (max-width: 991px) {
    .hero-section .carousel-item img { height: 480px; }
}
@media (max-width: 767px) {
    .hero-section .carousel-item img { height: 380px; }
    .hero-section .carousel-caption  { bottom: 30px; }
    .marquee-item { padding: 0 1.8rem; }
    .marquee-item img { height: 44px; max-width: 110px; }
}
</style>


{{-- ===============================================================
     HERO CAROUSEL
     =============================================================== --}}
<section class="hero-section">
    <div id="mainCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5500">

        <div class="carousel-indicators">
            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
        </div>

        <div class="carousel-inner">

            {{-- Slide 1 — Registration Now Open --}}
            <div class="carousel-item active">
                <img src="assets/images/banner1.jpg" class="d-block w-100" alt="KALRO Conference 2026">
                <div class="carousel-caption">
                    <div class="hero-eyebrow">
                        <span class="dot"></span>
                        Registration Now Open
                    </div>
                    <h2>2nd KALRO Scientific Conference<br>and Innovation Expo</h2>
                    <div class="hero-meta">
                        <i class="fas fa-calendar-alt" style="color:var(--gold);"></i>
                        <strong>15th – 19th June 2026</strong>
                        <span class="pipe">|</span>
                        Innovating for Resilience, Scaling for Impact
                    </div>
                    <div class="hero-btn-group">
                        <a href="/conference/register" class="btn-kalro-gold lg">
                            <i class="fas fa-user-check"></i> Register as Participant
                        </a>
                        <a href="/exhibition/register" class="btn-kalro-outline lg">
                            <i class="fas fa-store"></i> Become an Exhibitor
                        </a>
                    </div>
                </div>
            </div>

            {{-- Slide 2 — Secure Your Place --}}
            <div class="carousel-item">
                <img src="assets/images/banner2.jpg" class="d-block w-100" alt="Conference Participants">
                <div class="carousel-caption">
                    <div class="hero-eyebrow">
                        <span class="dot"></span>
                        Spots Still Available
                    </div>
                    <h2>Secure Your Place<br>at the Conference</h2>
                    <div class="hero-meta">
                        <i class="fas fa-clock" style="color:var(--gold);"></i>
                        <strong>Early bird ends 22nd May 2026</strong>
                        <span class="pipe">|</span>
                        Learn · Network · Collaborate
                    </div>
                    <div class="hero-btn-group">
                        <a href="/conference/register" class="btn-kalro-gold lg">
                            <i class="fas fa-users"></i> Register Now
                        </a>
                    </div>
                </div>
            </div>

            {{-- Slide 3 — Showcase Your Innovation --}}
            <div class="carousel-item">
                <img src="assets/images/banner1.jpg" class="d-block w-100" alt="Expo Exhibition">
                <div class="carousel-caption">
                    <div class="hero-eyebrow">
                        <span class="dot"></span>
                        Exhibitor Spaces Available
                    </div>
                    <h2>Showcase Your Innovation<br>to Decision Makers</h2>
                    <div class="hero-meta">
                        <i class="fas fa-store" style="color:var(--gold);"></i>
                        Present to researchers, policymakers &amp; industry leaders
                    </div>
                    <div class="hero-btn-group">
                        <a href="/exhibition/register" class="btn-kalro-gold lg">
                            <i class="fas fa-store"></i> Register as Exhibitor
                        </a>
                        <a href="/conference-procedure" class="btn-kalro-outline lg">
                            Conference Details
                        </a>
                    </div>
                </div>
            </div>

            {{-- Slide 4 — Host a Side Event --}}
            <div class="carousel-item">
                <img src="assets/images/banner2.jpg" class="d-block w-100" alt="Side Events">
                <div class="carousel-caption">
                    <div class="hero-eyebrow">
                        <span class="dot"></span>
                        Side Events Open
                    </div>
                    <h2>Host a Workshop,<br>Symposium or Session</h2>
                    <div class="hero-meta">
                        <i class="fas fa-calendar-plus" style="color:var(--gold);"></i>
                        <strong>Submit your proposal now</strong>
                        <span class="pipe">|</span>
                        Limited slots available
                    </div>
                    <div class="hero-btn-group">
                        <a href="https://forms.gle/UsduBgszNWhjQpJS9" target="_blank" rel="noopener noreferrer"
                           class="btn-kalro-gold lg">
                            <i class="fas fa-external-link-alt"></i> Submit Side Event Proposal
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>

    </div>
</section>


{{-- ===============================================================
     ANNOUNCEMENT TICKER
     =============================================================== --}}
<div class="announcement-ticker">
    <div class="ticker-inner">
        <div class="ticker-label">
            <i class="fas fa-bell"></i> Live Updates
        </div>
        <div class="ticker-scroll-wrap">
            <div class="ticker-scroll" id="tickerScroll">
                <a href="/conference/register" class="ticker-item">
                    <i class="fas fa-star" style="color:var(--gold); font-size:0.7rem;"></i>
                    Registration is now open! <strong>Early bird ends 22nd May 2026</strong>
                </a>
                <span class="ticker-sep"></span>
                <a href="https://forms.gle/UsduBgszNWhjQpJS9" target="_blank" class="ticker-item">
                    <i class="fas fa-calendar-plus" style="color:var(--gold); font-size:0.7rem;"></i>
                    Side event proposals now being accepted — <strong>submit yours today</strong>
                </a>
                <span class="ticker-sep"></span>
                <span class="ticker-item">
                    <i class="fas fa-map-marker-alt" style="color:var(--gold); font-size:0.7rem;"></i>
                    Conference dates: <strong>15th – 19th June 2026</strong>
                </span>
                <span class="ticker-sep"></span>
                <a href="/submit-abstract" class="ticker-item">
                    <i class="fas fa-file-alt" style="color:var(--gold); font-size:0.7rem;"></i>
                    Final paper submission deadline: <strong>22nd May 2026</strong>
                </a>
                <span class="ticker-sep"></span>
            </div>
        </div>
        <div class="ticker-cta-group d-none d-md-flex">
            <a href="/conference/register" class="btn-kalro-gold" style="font-size:0.78rem; padding:0.4rem 1rem; border-radius:8px;">
                Register Now
            </a>
        </div>
    </div>
</div>


{{-- ===============================================================
     CONFERENCE THEME
     =============================================================== --}}
<section class="conference-theme">
    <div class="container text-center">
        <div class="theme-tag">
            <i class="fas fa-leaf"></i> Conference Theme
        </div>
        <h2 class="mb-4">
            Innovating towards Resilient Agri-food Systems for<br class="d-none d-md-block">
            Climate Action, Food Security and Sustainable Livelihoods
        </h2>
        <p class="theme-quote mx-auto">
            The conference brings together researchers, policymakers, practitioners, and industry players to explore
            innovative and climate-smart approaches that strengthen agri-food systems, enhance resilience to climate
            change, improve food and nutrition security, and support sustainable livelihoods across Kenya and the region.
        </p>
    </div>
</section>


{{-- ===============================================================
     QUICK STATS
     =============================================================== --}}
<section class="quick-stats">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-calendar-alt"></i></div>
                    <h3>5</h3>
                    <p>Conference Days</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-users"></i></div>
                    <h3>500+</h3>
                    <p>Expected Participants</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-microphone"></i></div>
                    <h3>50+</h3>
                    <p>Expert Speakers</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-file-alt"></i></div>
                    <h3>100+</h3>
                    <p>Research Papers</p>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- ===============================================================
     PARTICIPATE STRIP
     =============================================================== --}}
<div class="participate-strip">
    <div class="container-fluid px-0">
        <div class="strip-inner">
            <a href="/conference/register" class="participate-item">
                <i class="fas fa-user-check"></i>
                <div class="pi-text">
                    <strong>Register as Participant</strong>
                    <span>Early bird until 22 May</span>
                </div>
            </a>
            <a href="/exhibition/register" class="participate-item">
                <i class="fas fa-store"></i>
                <div class="pi-text">
                    <strong>Become an Exhibitor</strong>
                    <span>Showcase your innovation</span>
                </div>
            </a>
            <a href="/submit-abstract" class="participate-item">
                <i class="fas fa-file-alt"></i>
                <div class="pi-text">
                    <strong>Submit Research Paper</strong>
                    <span>Deadline 22nd May 2026</span>
                </div>
            </a>
            <a href="https://forms.gle/UsduBgszNWhjQpJS9" target="_blank" rel="noopener noreferrer"
               class="participate-item">
                <i class="fas fa-calendar-plus"></i>
                <div class="pi-text">
                    <strong>Host a Side Event</strong>
                    <span>Limited slots remaining</span>
                </div>
            </a>
        </div>
    </div>
</div>


{{-- ===============================================================
     HOST A SIDE EVENT
     =============================================================== --}}
<section class="side-event-section">
    <div class="container">

        <div class="text-center mb-5">
            <div class="section-pill">
                <i class="fas fa-calendar-plus"></i> Side Events
            </div>
            <h2 class="mb-3" style="color:var(--green-dark); font-size:clamp(1.6rem,3vw,2.4rem);">
                Host a Side Event
            </h2>
            <p class="mx-auto" style="max-width:660px; color:var(--text-muted); font-size:1rem; line-height:1.7;">
                Propose a focused workshop, symposium, or special session alongside the main conference programme.
                Spaces are limited and allocated on a first-come, first-served basis.
            </p>
        </div>

        <div class="row g-4 justify-content-center">

            <div class="col-lg-4 col-md-6">
                <div class="side-event-card">
                    <div class="card-icon-circle">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <h5>What is a Side Event?</h5>
                    <p>
                        An independently organised session — a workshop, panel discussion, product launch,
                        or networking event — held at the conference venue during 15th–19th June 2026.
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="side-event-card">
                    <div class="card-icon-circle">
                        <i class="fas fa-users"></i>
                    </div>
                    <h5>Who Can Apply?</h5>
                    <p>
                        Research institutions, NGOs, government agencies, private sector companies, and
                        development partners are all welcome to propose a side event aligned with the
                        conference theme.
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="side-event-card">
                    <div class="card-icon-circle">
                        <i class="fas fa-paper-plane"></i>
                    </div>
                    <h5>How to Apply</h5>
                    <p>
                        Complete the online proposal form. You will need your organisation details,
                        proposed event title, preferred date and time slot, and expected audience size.
                    </p>
                    <a href="https://forms.gle/UsduBgszNWhjQpJS9" target="_blank" rel="noopener noreferrer"
                       class="btn-kalro-primary" style="width:100%; justify-content:center; margin-top:auto;">
                        <i class="fas fa-external-link-alt"></i> Submit Your Proposal
                    </a>
                </div>
            </div>

        </div>

        <div class="alert-cta-bar">
            <div>
                <h5><i class="fas fa-clock me-2" style="color:var(--green-main);"></i>Slots are filling up fast</h5>
                <p>
                    Submit early to secure your preferred date and time. For questions email
                    <a href="mailto:kalroexpo2026@gmail.com" class="fw-semibold"
                       style="color:var(--green-main);">kalroexpo2026@gmail.com</a>
                </p>
            </div>
            <a href="https://forms.gle/UsduBgszNWhjQpJS9" target="_blank" rel="noopener noreferrer"
               class="btn-kalro-primary lg" style="flex-shrink:0;">
                <i class="fas fa-external-link-alt"></i> Host a Side Event
            </a>
        </div>

    </div>
</section>


{{-- ===============================================================
     MID CTA STRIP
     =============================================================== --}}
<div class="mid-cta-strip">
    <div class="container text-center">
        <p class="mb-3" style="font-size:1.05rem; font-weight:600; color:var(--green-dark);">
            <i class="fas fa-door-open me-2" style="color:var(--green-main);"></i>
            Registration is Now Open — Join us at the 2nd KALRO Scientific Conference &amp; Exhibition, 15–19 June 2026
        </p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="/conference/register"  class="btn-kalro-primary lg">
                <i class="fas fa-user-check"></i> Register as Participant
            </a>
            <a href="/exhibition/register"  class="btn-kalro-green-outline lg">
                <i class="fas fa-store"></i> Become an Exhibitor
            </a>
            <a href="https://forms.gle/UsduBgszNWhjQpJS9" target="_blank" rel="noopener noreferrer"
               class="btn-kalro-green-outline lg">
                <i class="fas fa-calendar-plus"></i> Host a Side Event
            </a>
        </div>
    </div>
</div>


{{-- ===============================================================
     MAIN CONTENT — Welcome + Important Dates
     =============================================================== --}}
<section class="main-content">
    <div class="container">
        <div class="row g-5 align-items-start">

            {{-- Welcome --}}
            <div class="col-lg-8">
                <div class="welcome-section">
                    <div class="welcome-badge">
                        <i class="fas fa-seedling"></i> Welcome
                    </div>
                    <h1>
                        KALRO 2nd Scientific Conference<br>
                        <span class="accent">&amp; Innovation Expo 2026</span>
                    </h1>
                    <p class="lead">
                        Join us for the premier gathering of agricultural researchers, scientists, and policymakers
                        in Kenya. The conference provides a platform for knowledge exchange, networking, and
                        collaboration to advance agricultural innovation and food security across the region.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="/conference/register"  class="btn-kalro-primary lg">
                            <i class="fas fa-user-check"></i> Register as Participant
                        </a>
                        <a href="/exhibition/register"  class="btn-kalro-green-outline lg">
                            <i class="fas fa-store"></i> Register as Exhibitor
                        </a>
                        <a href="https://forms.gle/UsduBgszNWhjQpJS9" target="_blank" rel="noopener noreferrer"
                           class="btn-kalro-green-outline lg">
                            <i class="fas fa-calendar-plus"></i> Host a Side Event
                        </a>
                        <a href="/about" class="btn-kalro-green-outline lg">
                            Learn More
                        </a>
                    </div>
                </div>
            </div>

            {{-- Important Dates --}}
            <div class="col-lg-4">
                <div class="dates-card">
                    <div class="card-header">
                        <i class="fas fa-calendar-check" style="color:var(--gold);"></i>
                        <h4>Important Dates</h4>
                    </div>
                    <div class="card-body">

                        <div class="date-item">
                            <div class="date-dot gold"></div>
                            <div>
                                <div class="label">Registration</div>
                                <div class="value open">Now Open!</div>
                                <div style="font-size:0.78rem; color:#c0392b; font-weight:600; margin-top:2px;">
                                    Early bird ends 22nd May 2026
                                </div>
                            </div>
                        </div>

                        <div class="date-item">
                            <div class="date-dot"></div>
                            <div>
                                <div class="label">Side Event Proposals</div>
                                <div class="value open">Now Accepting</div>
                                <a href="https://forms.gle/UsduBgszNWhjQpJS9" target="_blank"
                                   rel="noopener noreferrer"
                                   style="font-size:0.78rem; font-weight:700; color:var(--green-main);">
                                    Submit proposal →
                                </a>
                            </div>
                        </div>

                        <div class="date-item">
                            <div class="date-dot"></div>
                            <div>
                                <div class="label">Conference Dates</div>
                                <div class="value">15th – 19th June 2026</div>
                            </div>
                        </div>

                        <div class="date-item">
                            <div class="date-dot"></div>
                            <div>
                                <div class="label">Notification of Acceptance</div>
                                <div class="value">4th May 2026</div>
                            </div>
                        </div>

                        <div class="date-item">
                            <div class="date-dot"></div>
                            <div>
                                <div class="label">Final Submission of Accepted Papers</div>
                                <div class="value">22nd May 2026</div>
                            </div>
                        </div>

                        <div class="date-item">
                            <div class="date-dot red"></div>
                            <div>
                                <div class="label">Abstract Submission</div>
                                <div class="value closed">Closed</div>
                            </div>
                        </div>

                        <div class="date-item">
                            <div class="date-dot muted"></div>
                            <div>
                                <div class="label">Full Paper Submission</div>
                                <div class="value" style="color:var(--text-muted);">17th April 2026</div>
                            </div>
                        </div>

                        <div class="mt-3 d-flex flex-column gap-2">
                            <a href="/conference/register" class="btn-kalro-primary" style="justify-content:center;">
                                <i class="fas fa-user-check"></i> Register Now
                            </a>
                            <a href="https://forms.gle/UsduBgszNWhjQpJS9" target="_blank" rel="noopener noreferrer"
                               class="btn-kalro-green-outline" style="justify-content:center;">
                                <i class="fas fa-calendar-plus"></i> Host a Side Event
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


{{-- ===============================================================
     FINAL CTA — Choose How You Want to Participate
     =============================================================== --}}
<section class="cta-section">
    <div class="container position-relative" style="z-index:2;">

        <div class="text-center mb-5">
            <h2 class="mb-3">Choose How You Want to Participate</h2>
            <p class="sub mx-auto">
                Whether your goal is to gain new knowledge, showcase innovative solutions, present research,
                or lead your own session — the KALRO Scientific Conference has a place for you.
            </p>
        </div>

        <div class="row g-4 justify-content-center">

            <div class="col-lg-3 col-md-6">
                <div class="cta-card">
                    <span class="badge-popular">Most Popular</span>
                    <div class="card-icon"><i class="fas fa-users"></i></div>
                    <h4>Conference Participant</h4>
                    <p>Learn from experts, network with peers, and join high-impact discussions. Early bird rates until 22nd May.</p>
                    <a href="/conference/register" class="btn-kalro-gold" style="width:100%; justify-content:center;">
                        <i class="fas fa-user-check"></i> Register Now
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="cta-card">
                    <div class="card-icon"><i class="fas fa-store"></i></div>
                    <h4>Exhibitor</h4>
                    <p>Showcase your products and connect with researchers, policymakers, and industry professionals.</p>
                    <a href="/exhibition/register" class="btn-kalro-outline" style="width:100%; justify-content:center;">
                        <i class="fas fa-store"></i> Become an Exhibitor
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="cta-card">
                    <div class="card-icon"><i class="fas fa-file-alt"></i></div>
                    <h4>Submit Research</h4>
                    <p>Full paper submission deadline: <strong style="color:#f5c761;">17th April 2026</strong>. Abstract submission is now closed.</p>
                    <a href="/submit-abstract" class="btn-kalro-outline" style="width:100%; justify-content:center;">
                        Paper Submission
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="cta-card">
                    <div class="card-icon"><i class="fas fa-calendar-plus"></i></div>
                    <h4>Host a Side Event</h4>
                    <p>Organise a workshop, symposium, or special session. Submit your proposal and secure a slot.</p>
                    <a href="https://forms.gle/UsduBgszNWhjQpJS9" target="_blank" rel="noopener noreferrer"
                       class="btn-kalro-gold" style="width:100%; justify-content:center;">
                        <i class="fas fa-external-link-alt"></i> Submit Proposal
                    </a>
                </div>
            </div>

        </div>

        <div class="text-center mt-5">
            <a href="/contact" class="btn-kalro-outline lg" style="border-color:rgba(255,255,255,0.4);">
                <i class="fas fa-envelope"></i> Contact Us
            </a>
        </div>

    </div>
</section>


{{-- ===============================================================
     PARTNERS MARQUEE — bottom of page, after Contact Us
     =============================================================== --}}
<section class="partners-marquee-section" aria-label="Partners and supporters">
    <div class="pm-label">Our Partners &amp; Supporters</div>

    <div class="marquee-outer">
        <div class="marquee-track" id="marqueeTrack">

            {{-- Ministry of Agriculture and Livestock Development --}}
            <a href="https://kilimo.go.ke/" target="_blank" rel="noopener noreferrer"
               class="marquee-item" title="Ministry of Agriculture and Livestock Development">
                <img src="https://kilimo.go.ke/wp-content/uploads/2023/05/MoALD-Logo.png"
                     alt="Ministry of Agriculture and Livestock Development"
                     onerror="this.closest('.marquee-item').classList.add('img-error')">
                <span class="partner-label">Ministry of Agriculture &amp; Livestock Dev.</span>
            </a>
            <span class="marquee-sep"></span>

            {{-- Food Systems Resilience Program --}}
            <a href="https://fsrp.go.ke/" target="_blank" rel="noopener noreferrer"
               class="marquee-item" title="Food Systems Resilience Program">
                <img src="https://fsrp.go.ke/sites/default/files/2024-11/FSRP%20Logo.png"
                     alt="Food Systems Resilience Program"
                     onerror="this.closest('.marquee-item').classList.add('img-error')">
                <span class="partner-label">Food Systems Resilience Program</span>
            </a>
            <span class="marquee-sep"></span>

            {{-- FAO Kenya --}}
            <a href="https://www.fao.org/kenya/en/" target="_blank" rel="noopener noreferrer"
               class="marquee-item" title="FAO Kenya">
                <img src="https://www.fao.org/images/corporatelibraries/fao-logo/fao-logo-en.svg"
                     alt="FAO – Food and Agriculture Organization"
                     onerror="this.closest('.marquee-item').classList.add('img-error')">
                <span class="partner-label">FAO Kenya</span>
            </a>
            <span class="marquee-sep"></span>

            {{-- Agriculture and Food Authority --}}
            <a href="https://www.afa.go.ke/" target="_blank" rel="noopener noreferrer"
               class="marquee-item" title="Agriculture and Food Authority">
                <img src="https://www.afa.go.ke/images/logo.png"
                     alt="Agriculture and Food Authority"
                     onerror="this.closest('.marquee-item').classList.add('img-error')">
                <span class="partner-label">Agriculture &amp; Food Authority</span>
            </a>
            <span class="marquee-sep"></span>

            {{--
                ── Add more partner logos here as needed ──
                Template:
                <a href="https://partner.org/" target="_blank" rel="noopener noreferrer"
                   class="marquee-item" title="Partner Name">
                    <img src="https://partner.org/path/to/logo.png"
                         alt="Partner Name"
                         onerror="this.closest('.marquee-item').classList.add('img-error')">
                    <span class="partner-label">Partner Name</span>
                </a>
                <span class="marquee-sep"></span>
            --}}

        </div>
    </div>
</section>


<script>
/* ── Ticker: duplicate for seamless loop ── */
(function () {
    var ts = document.getElementById('tickerScroll');
    if (!ts) return;
    var kids = Array.from(ts.children);
    kids.forEach(function (k) { ts.appendChild(k.cloneNode(true)); });
})();

/* ── Marquee: duplicate for seamless loop + re-bind onerror on clones ── */
(function () {
    var track = document.getElementById('marqueeTrack');
    if (!track) return;

    var children = Array.from(track.children);
    children.forEach(function (child) {
        track.appendChild(child.cloneNode(true));
    });

    track.querySelectorAll('img').forEach(function (img) {
        function check () {
            if (!img.complete || img.naturalWidth === 0) {
                var item = img.closest('.marquee-item');
                if (item) item.classList.add('img-error');
            }
        }
        img.addEventListener('error', check);
        img.addEventListener('load',  check);
        if (img.complete) check();
    });
})();
</script>

@endsection