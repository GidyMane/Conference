<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KALRO SEPD Conference — Full Paper Submission</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --green-deep: #0a4d1f;
            --green-mid: #158532;
            --green-bright: #1db954;
            --green-pale: #e8f5eb;
            --green-glass: rgba(21,133,50,0.08);
            --amber: #f59e0b;
            --amber-pale: #fffbeb;
            --red: #ef4444;
            --text-primary: #0f1a13;
            --text-secondary: #4a6356;
            --text-muted: #8aa898;
            --border: #d4e6d9;
            --bg: #f4f9f5;
            --white: #ffffff;
            --shadow-sm: 0 1px 3px rgba(10,77,31,0.08);
            --shadow-md: 0 4px 16px rgba(10,77,31,0.10);
            --shadow-lg: 0 12px 40px rgba(10,77,31,0.14);
            --radius: 14px;
            --radius-sm: 8px;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            font-weight: 400;
            background: var(--bg);
            color: var(--text-primary);
            line-height: 1.6;
            min-height: 100vh;
        }

        /* ── TOPBAR ── */
        .topbar {
            background: var(--white);
            border-bottom: 1px solid var(--border);
            padding: 0.75rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: var(--shadow-sm);
        }
        .topbar-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
        }
        .topbar-logo-mark {
            width: 40px;
            height: 40px;
            background: var(--green-mid);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem;
            font-weight: 700;
        }
        .topbar-name {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--green-deep);
        }
        .topbar-sub {
            font-size: 0.75rem;
            color: var(--text-muted);
        }
        .topbar-badge {
            background: var(--green-pale);
            color: var(--green-mid);
            border: 1px solid var(--border);
            padding: 0.3rem 0.85rem;
            border-radius: 100px;
            font-size: 0.78rem;
            font-weight: 500;
        }

        /* ── HERO ── */
        .hero {
            background: linear-gradient(135deg, var(--green-deep) 0%, #0d5c23 55%, #1a7a38 100%);
            color: white;
            padding: 3.5rem 2rem 4rem;
            position: relative;
            overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .hero-inner {
            max-width: 900px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
            text-align: center;
        }
        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            color: rgba(255,255,255,0.9);
            padding: 0.35rem 1rem;
            border-radius: 100px;
            font-size: 0.8rem;
            font-weight: 500;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            margin-bottom: 1.25rem;
        }
        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.6rem, 3.5vw, 2.4rem);
            font-weight: 700;
            line-height: 1.25;
            margin-bottom: 1rem;
            color: white;
        }
        .hero-title em {
            font-style: normal;
            color: #7dd89a;
        }
        .hero-desc {
            font-size: 1rem;
            color: rgba(255,255,255,0.75);
            max-width: 580px;
            margin: 0 auto 2rem;
        }

        /* Hero step indicators */
        .hero-steps {
            display: flex;
            justify-content: center;
            gap: 0;
            flex-wrap: wrap;
        }
        .hero-step {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
        }
        .hero-step-num {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.3);
            color: white;
            font-size: 0.75rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .hero-step-num.active {
            background: var(--green-bright);
            border-color: var(--green-bright);
        }
        .hero-step-num.done {
            background: rgba(255,255,255,0.2);
        }
        .hero-step span {
            font-size: 0.82rem;
            color: rgba(255,255,255,0.7);
        }
        .hero-step.active span { color: white; font-weight: 500; }
        .hero-step-divider {
            width: 30px;
            height: 1px;
            background: rgba(255,255,255,0.2);
            align-self: center;
        }

        /* ── LAYOUT ── */
        .page-body {
            max-width: 1060px;
            margin: 0 auto;
            padding: 2.5rem 1.5rem 4rem;
        }
        .two-col {
            display: grid;
            grid-template-columns: 1fr 360px;
            gap: 1.75rem;
            align-items: start;
        }

        /* ── CARDS ── */
        .card {
            background: var(--white);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }
        .card-head {
            padding: 1.1rem 1.5rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 0.65rem;
        }
        .card-head-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            flex-shrink: 0;
        }
        .card-head-icon.green { background: var(--green-pale); color: var(--green-mid); }
        .card-head-icon.amber { background: var(--amber-pale); color: var(--amber); }
        .card-head h3 {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text-primary);
        }
        .card-body { padding: 1.5rem; }

        /* ── SUBMISSION INFO ── */
        .submission-card .card-body {
            display: flex;
            flex-direction: column;
            gap: 0;
        }
        .submission-row {
            display: flex;
            gap: 1rem;
            padding: 0.8rem 0;
            border-bottom: 1px solid var(--border);
            align-items: flex-start;
        }
        .submission-row:last-child { border-bottom: none; }
        .submission-label {
            font-size: 0.72rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--text-muted);
            min-width: 90px;
            flex-shrink: 0;
            padding-top: 0.1rem;
        }
        .submission-value {
            font-size: 0.9rem;
            color: var(--text-primary);
            font-weight: 500;
        }
        .submission-value.code {
            font-family: 'DM Mono', monospace;
            background: var(--green-pale);
            color: var(--green-mid);
            padding: 0.15rem 0.6rem;
            border-radius: 5px;
            font-size: 0.85rem;
        }

        /* ── UPLOAD ZONE ── */
        .upload-zone {
            border: 2px dashed var(--border);
            border-radius: var(--radius);
            padding: 2.5rem 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease;
            background: var(--white);
            margin-bottom: 1.25rem;
            position: relative;
            overflow: hidden;
        }
        .upload-zone::before {
            content: '';
            position: absolute;
            inset: 0;
            background: var(--green-glass);
            opacity: 0;
            transition: opacity 0.2s;
        }
        .upload-zone:hover, .upload-zone.drag-over {
            border-color: var(--green-mid);
            transform: translateY(-1px);
            box-shadow: 0 0 0 4px rgba(21,133,50,0.06);
        }
        .upload-zone:hover::before, .upload-zone.drag-over::before { opacity: 1; }
        .upload-zone.has-file {
            border-style: solid;
            border-color: var(--green-mid);
            background: var(--green-pale);
        }
        .upload-icon-wrap {
            width: 68px;
            height: 68px;
            background: var(--green-pale);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem;
            font-size: 1.6rem;
            color: var(--green-mid);
            transition: all 0.2s;
        }
        .upload-zone:hover .upload-icon-wrap { background: var(--green-mid); color: white; transform: scale(1.05); }
        .upload-zone.has-file .upload-icon-wrap { background: var(--green-mid); color: white; }
        .upload-zone h4 {
            font-size: 1.05rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.35rem;
        }
        .upload-zone p {
            font-size: 0.85rem;
            color: var(--text-secondary);
            margin-bottom: 0.75rem;
        }
        .upload-zone .format-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            background: var(--green-pale);
            border: 1px solid var(--border);
            color: var(--green-mid);
            padding: 0.3rem 0.75rem;
            border-radius: 100px;
            font-size: 0.77rem;
            font-weight: 500;
        }

        /* File selected state */
        .file-selected-display {
            display: none;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 1rem;
            margin-bottom: 1.25rem;
            align-items: center;
            gap: 1rem;
        }
        .file-selected-display.visible { display: flex; }
        .file-icon-box {
            width: 44px;
            height: 44px;
            background: #2b579a;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.1rem;
            flex-shrink: 0;
        }
        .file-meta { flex: 1; min-width: 0; }
        .file-meta-name {
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--text-primary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .file-meta-size { font-size: 0.78rem; color: var(--text-muted); }
        .file-remove-btn {
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 0.3rem;
            border-radius: 5px;
            transition: all 0.15s;
            font-size: 1rem;
        }
        .file-remove-btn:hover { color: var(--red); background: #fef2f2; }

        /* ── SUBMIT BTN ── */
        .submit-btn {
            width: 100%;
            padding: 0.9rem 1.5rem;
            background: var(--green-mid);
            color: white;
            border: none;
            border-radius: var(--radius-sm);
            font-size: 1rem;
            font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            opacity: 0.4;
            pointer-events: none;
        }
        .submit-btn.active {
            opacity: 1;
            pointer-events: auto;
        }
        .submit-btn.active:hover {
            background: var(--green-deep);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(21,133,50,0.3);
        }
        .submit-btn.active:active { transform: translateY(0); }

        /* Progress */
        .progress-wrap { display: none; margin-top: 1rem; }
        .progress-wrap.visible { display: block; }
        .progress-bar-bg {
            height: 6px;
            background: var(--border);
            border-radius: 100px;
            overflow: hidden;
        }
        .progress-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--green-mid), var(--green-bright));
            border-radius: 100px;
            transition: width 0.3s;
            width: 0%;
        }
        .progress-label {
            display: flex;
            justify-content: space-between;
            font-size: 0.78rem;
            color: var(--text-muted);
            margin-top: 0.4rem;
        }

        /* ── GUIDELINES ── */
        .guidelines-tabs {
            display: flex;
            gap: 0.4rem;
            padding: 1rem 1.5rem 0;
            border-bottom: 1px solid var(--border);
            overflow-x: auto;
        }
        .g-tab {
            padding: 0.5rem 1rem;
            border-radius: 8px 8px 0 0;
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--text-muted);
            cursor: pointer;
            border: none;
            background: transparent;
            white-space: nowrap;
            border-bottom: 2px solid transparent;
            margin-bottom: -1px;
            transition: all 0.15s;
            font-family: 'DM Sans', sans-serif;
        }
        .g-tab:hover { color: var(--text-primary); }
        .g-tab.active { color: var(--green-mid); font-weight: 600; border-bottom-color: var(--green-mid); }
        .g-panel { display: none; padding: 1.5rem; }
        .g-panel.active { display: block; }

        .g-item {
            display: flex;
            gap: 0.75rem;
            padding: 0.6rem 0;
            border-bottom: 1px solid #f0f5f1;
            font-size: 0.875rem;
            color: var(--text-secondary);
            line-height: 1.5;
        }
        .g-item:last-child { border-bottom: none; }
        .g-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--green-mid);
            flex-shrink: 0;
            margin-top: 0.52rem;
        }
        .g-item strong { color: var(--text-primary); }

        .ref-example {
            background: #f8fcf8;
            border: 1px solid var(--border);
            border-left: 3px solid var(--green-mid);
            border-radius: 0 6px 6px 0;
            padding: 0.75rem 1rem;
            font-family: 'DM Mono', monospace;
            font-size: 0.78rem;
            color: var(--text-secondary);
            line-height: 1.6;
            margin: 0.5rem 0 1rem;
        }
        .ref-type {
            font-size: 0.72rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--green-mid);
            margin-top: 1rem;
            margin-bottom: 0.25rem;
        }

        /* ── SECTIONS LIST ── */
        .sections-list {
            display: flex;
            flex-direction: column;
            gap: 0;
        }
        .section-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.6rem 0;
            border-bottom: 1px solid #f0f5f1;
            font-size: 0.875rem;
            color: var(--text-secondary);
        }
        .section-item:last-child { border-bottom: none; }
        .section-num {
            width: 24px;
            height: 24px;
            border-radius: 6px;
            background: var(--green-pale);
            color: var(--green-mid);
            font-size: 0.72rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        /* ── CHECKLIST SIDEBAR ── */
        .checklist-item {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--border);
            cursor: pointer;
        }
        .checklist-item:last-child { border-bottom: none; }
        .check-box {
            width: 20px;
            height: 20px;
            border: 2px solid var(--border);
            border-radius: 5px;
            flex-shrink: 0;
            margin-top: 0.05rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.15s;
            color: transparent;
            font-size: 0.65rem;
        }
        .checklist-item.checked .check-box {
            background: var(--green-mid);
            border-color: var(--green-mid);
            color: white;
        }
        .check-label {
            font-size: 0.835rem;
            color: var(--text-secondary);
            line-height: 1.45;
            transition: color 0.15s;
        }
        .checklist-item.checked .check-label {
            color: var(--text-muted);
            text-decoration: line-through;
        }
        .checklist-progress {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }
        .checklist-progress-label {
            font-size: 0.78rem;
            color: var(--text-muted);
        }
        .checklist-progress-count {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--green-mid);
        }

        /* Notice box */
        .notice-box {
            display: flex;
            gap: 0.75rem;
            background: var(--amber-pale);
            border: 1px solid #fde68a;
            border-radius: var(--radius-sm);
            padding: 0.85rem 1rem;
            margin-bottom: 1.5rem;
            font-size: 0.83rem;
            color: #92400e;
        }
        .notice-box i { color: var(--amber); flex-shrink: 0; margin-top: 0.1rem; }

        /* Format spec bar */
        .format-bar {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }
        .format-pill {
            background: var(--green-pale);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 0.65rem 0.85rem;
            text-align: center;
        }
        .format-pill-label {
            font-size: 0.68rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--text-muted);
            font-weight: 600;
            margin-bottom: 0.2rem;
        }
        .format-pill-value {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--green-deep);
        }

        /* Word limit pill */
        .limit-highlight {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: var(--red);
            padding: 0.35rem 0.75rem;
            border-radius: 100px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        /* ── ALERTS ── */
        .alert-success {
            background: var(--green-pale);
            border: 1px solid #86efac;
            color: var(--green-deep);
            padding: 0.85rem 1rem;
            border-radius: var(--radius-sm);
            font-size: 0.88rem;
            margin-bottom: 1.25rem;
            display: flex;
            gap: 0.6rem;
        }
        .alert-danger {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
            padding: 0.85rem 1rem;
            border-radius: var(--radius-sm);
            font-size: 0.88rem;
            margin-bottom: 1.25rem;
            display: flex;
            gap: 0.6rem;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            .two-col { grid-template-columns: 1fr; }
            .hero { padding: 2.5rem 1.25rem 3rem; }
            .hero-steps { gap: 0; }
            .hero-step-divider { display: none; }
            .page-body { padding: 1.5rem 1rem 3rem; }
            .topbar { padding: 0.65rem 1rem; }
            .topbar-badge { display: none; }
            .format-bar { grid-template-columns: repeat(3, 1fr); }
        }

        /* Stagger fade-in */
        .fade-in { animation: fadeInUp 0.45s ease both; }
        .fade-in:nth-child(2) { animation-delay: 0.08s; }
        .fade-in:nth-child(3) { animation-delay: 0.16s; }
        .fade-in:nth-child(4) { animation-delay: 0.24s; }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(14px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<!-- TOPBAR -->
<header class="topbar">
    <a href="/" class="topbar-logo">
        <div class="topbar-logo-mark">K</div>
        <div>
            <div class="topbar-name">KALRO</div>
            <div class="topbar-sub">2nd Scientific Conference</div>
        </div>
    </a>
    <span class="topbar-badge"><i class="fas fa-lock" style="font-size:0.7rem; margin-right:0.3rem;"></i>Secure Submission Portal</span>
</header>

<!-- HERO -->
<section class="hero">
    <div class="hero-inner">
        <span class="hero-eyebrow"><i class="fas fa-leaf"></i> Full Paper Submission</span>
        <h1 class="hero-title">
            Innovations for <em>Sustainable Agri-food Systems</em>,<br>
            Climate Change Resilience & Improved Livelihoods
        </h1>
        <p class="hero-desc">Upload your complete research manuscript for peer review. Ensure your paper meets all formatting requirements before submitting.</p>

        <div class="hero-steps">
            <div class="hero-step">
                <div class="hero-step-num done"><i class="fas fa-check" style="font-size:0.6rem;"></i></div>
                <span>Abstract Approved</span>
            </div>
            <div class="hero-step-divider"></div>
            <div class="hero-step active">
                <div class="hero-step-num active">2</div>
                <span>Submit Full Paper</span>
            </div>
            <div class="hero-step-divider"></div>
            <div class="hero-step">
                <div class="hero-step-num">3</div>
                <span>Peer Review</span>
            </div>
            <div class="hero-step-divider"></div>
            <div class="hero-step">
                <div class="hero-step-num">4</div>
                <span>Presentation</span>
            </div>
        </div>
    </div>
</section>

<!-- PAGE BODY -->
<div class="page-body">
    <div class="two-col">

        <!-- LEFT COLUMN -->
        <div>

            <!-- Submission Info Card -->
            <div class="card submission-card fade-in" style="margin-bottom: 1.5rem;">
                <div class="card-head">
                    <div class="card-head-icon green"><i class="fas fa-file-alt"></i></div>
                    <h3>Your Submission</h3>
                </div>
                <div class="card-body" style="padding: 0 1.5rem;">
                    <div class="submission-row">
                        <span class="submission-label">Code</span>
                        <span class="submission-value code">KALRO-2025-0047</span>
                    </div>
                    <div class="submission-row">
                        <span class="submission-label">Author</span>
                        <span class="submission-value">Dr. Jane M. Wanjiku</span>
                    </div>
                    <div class="submission-row">
                        <span class="submission-label">Title</span>
                        <span class="submission-value" style="font-size:0.85rem; line-height:1.4;">Effect of Drought-Tolerant Maize Varieties on Smallholder Yield in Semi-Arid Kenya</span>
                    </div>
                </div>
            </div>

            <!-- Upload Card -->
            <div class="card fade-in" style="margin-bottom: 1.5rem;">
                <div class="card-head">
                    <div class="card-head-icon green"><i class="fas fa-cloud-upload-alt"></i></div>
                    <h3>Upload Full Paper</h3>
                </div>
                <div class="card-body">

                    <!-- Alerts -->
                    <div class="alert-success" id="alertSuccess" style="display:none;">
                        <i class="fas fa-check-circle"></i>
                        <span>Your paper has been submitted successfully. You will receive a confirmation email shortly.</span>
                    </div>
                    <div class="alert-danger" id="alertError" style="display:none;">
                        <i class="fas fa-exclamation-circle"></i>
                        <span id="alertErrorMsg">Please select a valid .doc or .docx file.</span>
                    </div>

                    <form id="uploadForm" method="POST" enctype="multipart/form-data" action="#">
                        <input type="hidden" name="_token" value="">
                        <input type="file" id="full_paper" name="full_paper" class="d-none" accept=".doc,.docx" style="display:none;">

                        <!-- Drop zone -->
                        <div id="uploadZone" class="upload-zone" tabindex="0" role="button" aria-label="Click or drag to upload your paper">
                            <div class="upload-icon-wrap" id="uploadIconWrap">
                                <i class="fas fa-file-word" id="uploadIcon"></i>
                            </div>
                            <h4 id="uploadTitle">Drag & drop your manuscript here</h4>
                            <p id="uploadSubtitle">or click to browse your files</p>
                            <span class="format-badge"><i class="fas fa-check-circle"></i> .doc &nbsp;·&nbsp; .docx only</span>
                        </div>

                        <!-- File selected display -->
                        <div class="file-selected-display" id="fileSelectedDisplay">
                            <div class="file-icon-box"><i class="fas fa-file-word"></i></div>
                            <div class="file-meta">
                                <div class="file-meta-name" id="fileName">document.docx</div>
                                <div class="file-meta-size" id="fileSize">—</div>
                            </div>
                            <button type="button" class="file-remove-btn" id="removeFileBtn" title="Remove file">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        <!-- Progress -->
                        <div class="progress-wrap" id="progressWrap">
                            <div class="progress-bar-bg">
                                <div class="progress-bar-fill" id="progressFill"></div>
                            </div>
                            <div class="progress-label">
                                <span>Uploading…</span>
                                <span id="progressPct">0%</span>
                            </div>
                        </div>

                        <!-- Submit button -->
                        <button type="submit" class="submit-btn" id="submitBtn">
                            <i class="fas fa-paper-plane"></i>
                            Submit Full Paper
                        </button>
                    </form>
                </div>
            </div>

            <!-- Guidelines Card (tabbed) -->
            <div class="card fade-in">
                <div class="card-head">
                    <div class="card-head-icon green"><i class="fas fa-book-open"></i></div>
                    <h3>Submission Guidelines</h3>
                </div>

                <div class="guidelines-tabs" role="tablist">
                    <button class="g-tab active" data-panel="format" role="tab">Formatting</button>
                    <button class="g-tab" data-panel="structure" role="tab">Structure</button>
                    <button class="g-tab" data-panel="scientific" role="tab">Scientific Names</button>
                    <button class="g-tab" data-panel="refs" role="tab">References</button>
                    <button class="g-tab" data-panel="figures" role="tab">Figures & Tables</button>
                </div>

                <!-- Formatting -->
                <div class="g-panel active" id="panel-format">
                    <div class="limit-highlight">
                        <i class="fas fa-exclamation-circle"></i> Maximum 3,000 words
                    </div>
                    <div class="format-bar">
                        <div class="format-pill">
                            <div class="format-pill-label">Language</div>
                            <div class="format-pill-value">British EN</div>
                        </div>
                        <div class="format-pill">
                            <div class="format-pill-label">Font</div>
                            <div class="format-pill-value">TNR 12pt</div>
                        </div>
                        <div class="format-pill">
                            <div class="format-pill-label">Spacing</div>
                            <div class="format-pill-value">Double</div>
                        </div>
                        <div class="format-pill">
                            <div class="format-pill-label">Paper</div>
                            <div class="format-pill-value">A4</div>
                        </div>
                        <div class="format-pill">
                            <div class="format-pill-label">Pages</div>
                            <div class="format-pill-value">Numbered</div>
                        </div>
                        <div class="format-pill">
                            <div class="format-pill-label">Format</div>
                            <div class="format-pill-value">.doc / .docx</div>
                        </div>
                    </div>
                    <div class="g-item">
                        <div class="g-dot"></div>
                        <span>Numbers <strong>1–10</strong> written in words within text; 11 onwards in numerals</span>
                    </div>
                    <div class="g-item">
                        <div class="g-dot"></div>
                        <span>Numbers starting a sentence are <strong>always</strong> written in words</span>
                    </div>
                    <div class="g-item">
                        <div class="g-dot"></div>
                        <span>Equations must use <strong>Microsoft Equation Editor 3.1</strong> or lower</span>
                    </div>
                    <div class="g-item">
                        <div class="g-dot"></div>
                        <span>Use <strong>S.I. units</strong> for all measurements throughout the paper</span>
                    </div>
                </div>

                <!-- Structure -->
                <div class="g-panel" id="panel-structure">
                    <div class="notice-box">
                        <i class="fas fa-info-circle"></i>
                        <span>The cover page must list all author names, affiliations, telephone, and email. <strong>Underline</strong> the presenting author's name.</span>
                    </div>
                    <p style="font-size:0.83rem; color:var(--text-muted); margin-bottom:1rem;">Required sections in order:</p>
                    <div class="sections-list">
                        <div class="section-item"><div class="section-num">1</div>Abstract</div>
                        <div class="section-item"><div class="section-num">2</div>Introduction</div>
                        <div class="section-item"><div class="section-num">3</div>Materials and Methods</div>
                        <div class="section-item"><div class="section-num">4</div>Results</div>
                        <div class="section-item"><div class="section-num">5</div>Discussion</div>
                        <div class="section-item"><div class="section-num">6</div>Conclusion</div>
                        <div class="section-item"><div class="section-num">7</div>Recommendations</div>
                        <div class="section-item"><div class="section-num">8</div>Acknowledgment</div>
                        <div class="section-item"><div class="section-num">9</div>References</div>
                    </div>
                </div>

                <!-- Scientific -->
                <div class="g-panel" id="panel-scientific">
                    <div class="g-item">
                        <div class="g-dot"></div>
                        <span>Provide the scientific name with authority on <strong>first use</strong> of each organism</span>
                    </div>
                    <div class="g-item">
                        <div class="g-dot"></div>
                        <span>Species and genera must be <em>italicized</em> throughout the text</span>
                    </div>
                    <div class="g-item">
                        <div class="g-dot"></div>
                        <span>Other taxa: capitalize the first letter, but do <strong>not</strong> italicize</span>
                    </div>
                    <div class="g-item">
                        <div class="g-dot"></div>
                        <span>Generic names may be abbreviated after first mention (except at sentence start)</span>
                    </div>
                    <div class="g-item">
                        <div class="g-dot"></div>
                        <span>Pesticides: use standard convention with correct chemical name on first mention</span>
                    </div>
                </div>

                <!-- References -->
                <div class="g-panel" id="panel-refs">
                    <div class="g-item">
                        <div class="g-dot"></div>
                        <span>Cite by <strong>author and year</strong>; multiple publications same year: add a, b, c after year</span>
                    </div>
                    <div class="g-item">
                        <div class="g-dot"></div>
                        <span>More than two authors: <strong>first author et al.</strong></span>
                    </div>
                    <div class="g-item">
                        <div class="g-dot"></div>
                        <span>Journal names in <em>italics</em>, spelled in full; include volume and page numbers</span>
                    </div>
                    <div class="g-item">
                        <div class="g-dot"></div>
                        <span>Books: title, publisher, city, total pages</span>
                    </div>
                    <div class="g-item">
                        <div class="g-dot"></div>
                        <span>Online sources: include URL, access date, and/or DOI</span>
                    </div>

                    <div class="ref-type">Journal Paper</div>
                    <div class="ref-example">Ndungu, M.M., J.K. Lagat and J.K. Langat (2019). Determinants and causes of postharvest milk losses among milk producers in Nyandarua North subcounty, Kenya. <em>East African Agricultural and Forestry Journal</em> 83: 269–280.</div>

                    <div class="ref-type">Book Chapter</div>
                    <div class="ref-example">Namikoye, E.S., et al. (2020). Enhancing monitoring efficiency and management of vectors of maize lethal necrosis disease in Kenya. In: Niassy, S., et al. (eds) <em>Sustainable Management of Invasive Pests in Africa</em>. Vol 14: pp 125–137. Springer, Cham.</div>

                    <div class="ref-type">Book</div>
                    <div class="ref-example">Singh G. (2025). <em>Principles of Animal Husbandry and Dairy Science</em>. Sura India Publication. ISBN No: 978-81-989418-0-0.</div>
                </div>

                <!-- Figures -->
                <div class="g-panel" id="panel-figures">
                    <div class="g-item">
                        <div class="g-dot"></div>
                        <span>All figures and tables must fit on <strong>one page</strong> and be clearly labelled</span>
                    </div>
                    <div class="g-item">
                        <div class="g-dot"></div>
                        <span>Figure captions are placed <strong>below</strong> the figure</span>
                    </div>
                    <div class="g-item">
                        <div class="g-dot"></div>
                        <span>Table headings are placed <strong>above</strong> the table</span>
                    </div>
                    <div class="g-item">
                        <div class="g-dot"></div>
                        <span>Use Microsoft Word's built-in table function for all tables</span>
                    </div>
                    <div class="g-item">
                        <div class="g-dot"></div>
                        <span>Place figures and tables where they are <strong>first referred to</strong> in the text</span>
                    </div>
                    <div class="g-item" style="background:#fef9ec; border-radius:6px; padding:0.6rem 0.75rem; border: 1px solid #fde68a;">
                        <i class="fas fa-exclamation-triangle" style="color:var(--amber); flex-shrink:0; margin-top:0.1rem;"></i>
                        <span style="color:#92400e;">No alterations to illustrations can be made after submission</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- RIGHT COLUMN (sticky sidebar) -->
        <div style="position: sticky; top: 80px; display: flex; flex-direction: column; gap: 1.5rem;">

            <!-- Checklist -->
            <div class="card fade-in">
                <div class="card-head">
                    <div class="card-head-icon amber"><i class="fas fa-clipboard-check"></i></div>
                    <h3>Pre-Submission Checklist</h3>
                </div>
                <div class="card-body">
                    <div class="checklist-progress">
                        <span class="checklist-progress-label">Completed</span>
                        <span class="checklist-progress-count" id="checkCount">0 / 7</span>
                    </div>
                    <div class="progress-bar-bg" style="margin-bottom:1.25rem;">
                        <div class="progress-bar-fill" id="checkProgressFill" style="background: linear-gradient(90deg, var(--amber), #f59e0b);"></div>
                    </div>

                    <div id="checklistItems">
                        <div class="checklist-item" data-check="1">
                            <div class="check-box"><i class="fas fa-check"></i></div>
                            <span class="check-label">Paper does not exceed 3,000 words</span>
                        </div>
                        <div class="checklist-item" data-check="2">
                            <div class="check-box"><i class="fas fa-check"></i></div>
                            <span class="check-label">British English, Times New Roman 12, double-spaced</span>
                        </div>
                        <div class="checklist-item" data-check="3">
                            <div class="check-box"><i class="fas fa-check"></i></div>
                            <span class="check-label">Cover page includes all author details and contacts</span>
                        </div>
                        <div class="checklist-item" data-check="4">
                            <div class="check-box"><i class="fas fa-check"></i></div>
                            <span class="check-label">All required sections included (Abstract → References)</span>
                        </div>
                        <div class="checklist-item" data-check="5">
                            <div class="check-box"><i class="fas fa-check"></i></div>
                            <span class="check-label">Scientific names properly italicized</span>
                        </div>
                        <div class="checklist-item" data-check="6">
                            <div class="check-box"><i class="fas fa-check"></i></div>
                            <span class="check-label">Figures and tables properly placed and labeled</span>
                        </div>
                        <div class="checklist-item" data-check="7">
                            <div class="check-box"><i class="fas fa-check"></i></div>
                            <span class="check-label">References formatted correctly per examples</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Need help? -->
            <div class="card fade-in" style="border-color: var(--green-pale);">
                <div class="card-body" style="text-align: center;">
                    <div style="width:42px; height:42px; background: var(--green-pale); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 0.85rem; color:var(--green-mid); font-size:1rem;">
                        <i class="fas fa-headset"></i>
                    </div>
                    <div style="font-weight:600; font-size:0.9rem; margin-bottom:0.35rem; color:var(--text-primary);">Need Assistance?</div>
                    <p style="font-size:0.8rem; color:var(--text-muted); margin-bottom:1rem;">Contact the conference secretariat for technical help with your submission.</p>
                    <a href="mailto:conference@kalro.org" style="display:inline-flex; align-items:center; gap:0.4rem; background:var(--green-pale); color:var(--green-mid); border:1px solid var(--border); border-radius:100px; padding:0.4rem 1rem; font-size:0.8rem; font-weight:500; text-decoration:none;">
                        <i class="fas fa-envelope"></i> conference@kalro.org
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // ── TABS ──
    document.querySelectorAll('.g-tab').forEach(tab => {
        tab.addEventListener('click', () => {
            document.querySelectorAll('.g-tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.g-panel').forEach(p => p.classList.remove('active'));
            tab.classList.add('active');
            document.getElementById('panel-' + tab.dataset.panel).classList.add('active');
        });
    });

    // ── CHECKLIST ──
    let checkedCount = 0;
    document.querySelectorAll('.checklist-item').forEach(item => {
        item.addEventListener('click', () => {
            item.classList.toggle('checked');
            checkedCount = document.querySelectorAll('.checklist-item.checked').length;
            document.getElementById('checkCount').textContent = checkedCount + ' / 7';
            document.getElementById('checkProgressFill').style.width = (checkedCount / 7 * 100) + '%';
        });
    });

    // ── UPLOAD ──
    const zone = document.getElementById('uploadZone');
    const input = document.getElementById('full_paper');
    const fileDisplay = document.getElementById('fileSelectedDisplay');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const submitBtn = document.getElementById('submitBtn');
    const removeBtn = document.getElementById('removeFileBtn');

    zone.addEventListener('click', () => input.click());
    zone.addEventListener('keydown', e => { if (e.key === 'Enter' || e.key === ' ') input.click(); });

    zone.addEventListener('dragover', e => { e.preventDefault(); zone.classList.add('drag-over'); });
    zone.addEventListener('dragleave', () => zone.classList.remove('drag-over'));
    zone.addEventListener('drop', e => {
        e.preventDefault();
        zone.classList.remove('drag-over');
        if (e.dataTransfer.files.length) {
            const dt = new DataTransfer();
            dt.items.add(e.dataTransfer.files[0]);
            input.files = dt.files;
            handleFile(e.dataTransfer.files[0]);
        }
    });

    input.addEventListener('change', () => {
        if (input.files[0]) handleFile(input.files[0]);
    });

    function handleFile(file) {
        const ext = file.name.split('.').pop().toLowerCase();
        if (!['doc', 'docx'].includes(ext)) {
            document.getElementById('alertError').style.display = 'flex';
            document.getElementById('alertErrorMsg').textContent = 'Invalid file type. Please upload a .doc or .docx file.';
            return;
        }
        document.getElementById('alertError').style.display = 'none';
        zone.style.display = 'none';
        fileName.textContent = file.name;
        fileSize.textContent = (file.size / 1048576).toFixed(2) + ' MB';
        fileDisplay.classList.add('visible');
        submitBtn.classList.add('active');
    }

    removeBtn.addEventListener('click', () => {
        input.value = '';
        zone.style.display = '';
        fileDisplay.classList.remove('visible');
        submitBtn.classList.remove('active');
    });

    // ── FORM SUBMIT (simulated for demo) ──
    document.getElementById('uploadForm').addEventListener('submit', function(e) {
        e.preventDefault();
        if (!submitBtn.classList.contains('active')) return;

        const progressWrap = document.getElementById('progressWrap');
        const progressFill = document.getElementById('progressFill');
        const progressPct = document.getElementById('progressPct');

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Uploading…';
        progressWrap.classList.add('visible');

        let pct = 0;
        const interval = setInterval(() => {
            pct += Math.random() * 18;
            if (pct >= 100) {
                pct = 100;
                clearInterval(interval);
                setTimeout(() => {
                    progressWrap.classList.remove('visible');
                    fileDisplay.classList.remove('visible');
                    zone.style.display = '';
                    submitBtn.classList.remove('active');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Submit Full Paper';
                    document.getElementById('alertSuccess').style.display = 'flex';
                    input.value = '';
                }, 400);
            }
            progressFill.style.width = pct + '%';
            progressPct.textContent = Math.round(pct) + '%';
        }, 120);
    });
</script>
</body>
</html>