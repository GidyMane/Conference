@extends('layouts.header')

@section('title', 'Side Events Programme — 2nd KALRO Scientific Conference & Innovation Expo 2026')

@section('content')
<div class="se-wrapper">

    {{-- ══ HERO ══ --}}
    <div class="se-hero">
        <div class="se-hero-bg"></div>
        <div class="container position-relative">
            <div class="se-hero-badge">2nd KALRO Scientific Conference &amp; Innovation Expo 2026</div>
            <h1 class="se-hero-title">Side Events Programme</h1>
            <p class="se-hero-sub">
                10 focused workshops, business sessions, and collaborative dialogues running alongside the main
                conference on <strong>Wednesday 17</strong> and <strong>Thursday 18 June 2026</strong>.
                Open to all registered delegates.
            </p>
            <div class="d-flex flex-wrap gap-2 align-items-center">
                <div class="se-hero-badge-pill">
                    <i class="fas fa-map-marker-alt me-1"></i> KALRO Headquarters, Nairobi
                </div>
                <div class="se-hero-badge-pill">
                    <i class="fas fa-calendar-alt me-1"></i> Wed 17 &amp; Thu 18 June 2026
                </div>
                <div class="se-hero-badge-pill">
                    <i class="fas fa-users me-1"></i> Open to All Registered Delegates
                </div>
            </div>
        </div>
    </div>

    {{-- ══ ACTION BAR ══ --}}
    <div class="se-action-bar">
        <div class="container d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <span class="fw-bold" style="color:#0d3d25;">Plan your side event attendance</span>
                <span class="text-muted ms-2" style="font-size:.88rem;">Scroll to explore all 10 sessions below</span>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ asset('program/Program_Side_event.pdf') }}"
                   download="Program_Side_event.pdf"
                   class="se-btn-outline">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    Download Programme PDF
                </a>
                <a href="https://forms.gle/UsduBgszNWhjQpJS9"
                   target="_blank" rel="noopener noreferrer"
                   class="se-btn-primary">
                    <i class="fas fa-external-link-alt me-1"></i> Register for a Side Event
                </a>
            </div>
        </div>
    </div>

    <div class="container se-body">

        {{-- ══ DAY TABS ══ --}}
        <div class="se-day-tabs">
            <button class="se-day-tab active" onclick="filterDay('wed', this)">
                <span class="se-tab-label">Wednesday</span>
                <span class="se-tab-date">17 June · 6 Sessions</span>
            </button>
            <button class="se-day-tab" onclick="filterDay('thu', this)">
                <span class="se-tab-label">Thursday</span>
                <span class="se-tab-date">18 June · 4 Sessions</span>
            </button>
        </div>

        {{-- ══════════════════════════════════════════
             WEDNESDAY 17 JUNE
        ══════════════════════════════════════════ --}}
        <div class="se-day-section" id="day-wed">
            <div class="se-day-header">
                <div class="se-day-dot"></div>
                <h2>Wednesday, 17 June 2026</h2>
            </div>

            {{-- EVENT 1 --}}
            <div class="se-event-card">
                <div class="se-event-head">
                    <div class="se-event-meta">
                        <span class="se-event-num">01</span>
                        <div>
                            <span class="se-event-time"><i class="fas fa-clock me-1"></i>09:30 – 14:30</span>
                            <span class="se-mode-badge se-mode-inperson">In Person</span>
                        </div>
                    </div>
                    <div class="se-event-title-block">
                        <h3 class="se-event-title">Better Analytics for Reduced Impact of Extreme Weather Events</h3>
                        <p class="se-event-host"><i class="fas fa-building me-1"></i>KALRO / FAO Loss &amp; Damage Project</p>
                    </div>
                </div>
                <div class="se-event-body">
                    <p class="se-event-overview">
                        Showcases analytical tools and modelling approaches developed under the KALRO–FAO Loss and Damage Project to
                        quantify the impacts of extreme weather events on Kenya's agricultural sector. Brings together researchers,
                        policymakers, meteorological experts, and development partners to explore how advanced modelling can support
                        climate-smart planning and reduce agricultural losses.
                    </p>
                    <div class="se-event-details">
                        <div class="se-detail-col">
                            <h5 class="se-detail-head">Objectives</h5>
                            <ul class="se-list">
                                <li>Present analytical tools to assess agricultural loss from extreme weather events</li>
                                <li>Share modelling results, including predicted impacts and vulnerability patterns</li>
                                <li>Facilitate dialogue on analytics for policy and planning among researchers and county governments</li>
                                <li>Identify opportunities for scaling evidence-based climate resilience strategies</li>
                            </ul>
                        </div>
                        <div class="se-detail-col">
                            <h5 class="se-detail-head">Key Topics</h5>
                            <div class="se-tags">
                                <span class="se-tag">Climate risk analytics</span>
                                <span class="se-tag">Loss &amp; damage methodologies</span>
                                <span class="se-tag">Predictive modelling</span>
                                <span class="se-tag">Analytics into policy</span>
                                <span class="se-tag">Climate data systems</span>
                            </div>
                            <h5 class="se-detail-head mt-3">Expected Outcomes</h5>
                            <p class="se-outcome-text">Improved understanding of climate analytics; evidence for policy recommendations; strengthened collaboration; clear next steps for integrating modelling tools into planning.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- EVENT 10 (Tsetse — runs Wed) --}}
            <div class="se-event-card se-event-card--launch">
                <div class="se-event-head">
                    <div class="se-event-meta">
                        <span class="se-event-num" style="background:#92400e;color:#fff;">10</span>
                        <div>
                            <span class="se-event-time"><i class="fas fa-clock me-1"></i>10:00 – 13:00</span>
                            <span class="se-mode-badge se-mode-hybrid">Hybrid</span>
                            <span class="se-launch-badge"><i class="fas fa-rocket me-1"></i>Official Launch</span>
                        </div>
                    </div>
                    <div class="se-event-title-block">
                        <h3 class="se-event-title">Tsetse Repellent Business Session &amp; Official Launch</h3>
                        <p class="se-event-host"><i class="fas fa-building me-1"></i>KALRO</p>
                    </div>
                </div>
                <div class="se-event-body">
                    <p class="se-event-overview">
                        Presents KALRO's breakthrough Tsetse Repellent Technology for both humans and animals. The session highlights
                        the product's efficacy, regulatory milestones, commercial readiness, and strong demand from wildlife authorities,
                        pastoral communities, and regional governments — providing a platform to validate market demand and engage
                        potential industrial partners for production scale-up.
                    </p>
                    <div class="se-event-details">
                        <div class="se-detail-col">
                            <h5 class="se-detail-head">Objectives</h5>
                            <ul class="se-list">
                                <li>Officially launch the Tsetse Repellent for human and animal use</li>
                                <li>Present efficacy results, regulatory approvals, and commercialisation readiness</li>
                                <li>Validate market demand with key stakeholders</li>
                                <li>Engage potential industrial partners and distributors</li>
                                <li>Agree on next steps for production scale-up and deployment</li>
                            </ul>
                        </div>
                        <div class="se-detail-col">
                            <h5 class="se-detail-head">Key Topics</h5>
                            <div class="se-tags">
                                <span class="se-tag">Efficacy validation</span>
                                <span class="se-tag">Patents &amp; regulatory approvals</span>
                                <span class="se-tag">Commercial trials</span>
                                <span class="se-tag">Demand quantification</span>
                                <span class="se-tag">Production pathways</span>
                                <span class="se-tag">Partnership opportunities</span>
                            </div>
                            <h5 class="se-detail-head mt-3">Expected Outcomes</h5>
                            <p class="se-outcome-text">Validated demand; strengthened partnerships; clarity on production strategy; commitments for pilot purchases; positioning of the repellent as a flagship KALRO commercialisation success.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- EVENT 2 --}}
            <div class="se-event-card">
                <div class="se-event-head">
                    <div class="se-event-meta">
                        <span class="se-event-num">02</span>
                        <div>
                            <span class="se-event-time"><i class="fas fa-clock me-1"></i>11:00 – 13:00</span>
                            <span class="se-mode-badge se-mode-hybrid">Hybrid</span>
                        </div>
                    </div>
                    <div class="se-event-title-block">
                        <h3 class="se-event-title">AI in Agriculture: Opportunities, Implications &amp; Risks</h3>
                        <p class="se-event-host"><i class="fas fa-building me-1"></i>Strathmore Agri-Food Innovation Center (SAFIC)</p>
                    </div>
                </div>
                <div class="se-event-body">
                    <p class="se-event-overview">
                        Explores the evolving role of Artificial Intelligence in transforming Kenya's agricultural sector, highlighting
                        AI-enabled advisory systems, trusted agricultural content, and data governance frameworks that support
                        climate-smart, farmer-centred transformation.
                    </p>
                    <div class="se-event-details">
                        <div class="se-detail-col">
                            <h5 class="se-detail-head">Objectives</h5>
                            <ul class="se-list">
                                <li>Demystify AI for agricultural applications</li>
                                <li>Showcase existing AI-enabled advisory solutions</li>
                                <li>Explore partnerships for strengthening trusted agricultural content</li>
                                <li>Discuss governance and responsible data use</li>
                                <li>Identify collaboration opportunities across institutions</li>
                            </ul>
                        </div>
                        <div class="se-detail-col">
                            <h5 class="se-detail-head">Key Topics</h5>
                            <div class="se-tags">
                                <span class="se-tag">AI-enabled advisory</span>
                                <span class="se-tag">Trusted agricultural content</span>
                                <span class="se-tag">WhatsApp / SMS / IVR channels</span>
                                <span class="se-tag">Benchmarking AI models</span>
                                <span class="se-tag">Data governance</span>
                            </div>
                            <h5 class="se-detail-head mt-3">Expected Outcomes</h5>
                            <p class="se-outcome-text">Greater awareness of AI advisory work; clearer understanding of data governance; identified collaboration opportunities; shared priorities for farmer-centred AI systems.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- EVENT 3 --}}
            <div class="se-event-card">
                <div class="se-event-head">
                    <div class="se-event-meta">
                        <span class="se-event-num">03</span>
                        <div>
                            <span class="se-event-time"><i class="fas fa-clock me-1"></i>11:00 – 13:00</span>
                            <span class="se-mode-badge se-mode-inperson">In Person</span>
                        </div>
                    </div>
                    <div class="se-event-title-block">
                        <h3 class="se-event-title">Aflasafe Distributorship Business Session</h3>
                        <p class="se-event-host"><i class="fas fa-building me-1"></i>KALRO</p>
                    </div>
                </div>
                <div class="se-event-body">
                    <p class="se-event-overview">
                        Focuses on strengthening Kenya's capacity to scale Aflasafe, a biocontrol product that reduces aflatoxin
                        contamination in maize and groundnuts. Brings together researchers, distributors, regulators, and development
                        partners to explore business models and operational strategies for expanding Aflasafe distribution.
                    </p>
                    <div class="se-event-details">
                        <div class="se-detail-col">
                            <h5 class="se-detail-head">Objectives</h5>
                            <ul class="se-list">
                                <li>Discuss the business case for Aflasafe distribution</li>
                                <li>Identify viable distributorship models</li>
                                <li>Strengthen linkages across research, private sector, and regulators</li>
                                <li>Explore market-driven adoption strategies</li>
                                <li>Share insights on demand, pricing, and last-mile delivery</li>
                            </ul>
                        </div>
                        <div class="se-detail-col">
                            <h5 class="se-detail-head">Key Topics</h5>
                            <div class="se-tags">
                                <span class="se-tag">Aflasafe technology</span>
                                <span class="se-tag">Distribution models</span>
                                <span class="se-tag">Market development</span>
                                <span class="se-tag">Regulatory considerations</span>
                                <span class="se-tag">County partnerships</span>
                                <span class="se-tag">Lessons from pilots</span>
                            </div>
                            <h5 class="se-detail-head mt-3">Expected Outcomes</h5>
                            <p class="se-outcome-text">Clear understanding of distributorship opportunities; strengthened partnerships; identified market gaps; agreed next steps for scaling Aflasafe adoption.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- EVENT 4 --}}
            <div class="se-event-card">
                <div class="se-event-head">
                    <div class="se-event-meta">
                        <span class="se-event-num">04</span>
                        <div>
                            <span class="se-event-time"><i class="fas fa-clock me-1"></i>13:00 – 16:00</span>
                            <span class="se-mode-badge se-mode-inperson">In Person</span>
                        </div>
                    </div>
                    <div class="se-event-title-block">
                        <h3 class="se-event-title">From Research to Impact: How KALRO &amp; CIMMYT Are Advancing Agricultural Innovation</h3>
                        <p class="se-event-host"><i class="fas fa-building me-1"></i>CIMMYT in Partnership with KALRO</p>
                    </div>
                </div>
                <div class="se-event-body">
                    <p class="se-event-overview">
                        Highlights the long-standing KALRO–CIMMYT partnership, showcasing collaborative research, field implementation,
                        and capacity building that strengthen seed systems and deliver climate-resilient innovations to farmers. Covers
                        breeding, digital phenotyping, mechanisation, conservation agriculture, and sustainable agrifood systems.
                    </p>
                    <div class="se-event-details">
                        <div class="se-detail-col">
                            <h5 class="se-detail-head">Objectives</h5>
                            <ul class="se-list">
                                <li>Highlight the strategic role of the KALRO–CIMMYT partnership</li>
                                <li>Showcase advances in breeding, seed systems, and climate-resilient crops</li>
                                <li>Share breakthroughs in mechanisation, digital phenotyping, and field trial excellence</li>
                                <li>Present innovations in soil health and sustainable agrifood systems</li>
                                <li>Strengthen collaboration across research, government, and private sector</li>
                            </ul>
                        </div>
                        <div class="se-detail-col">
                            <h5 class="se-detail-head">Key Topics</h5>
                            <div class="se-tags">
                                <span class="se-tag">Breeding operations</span>
                                <span class="se-tag">Wheat &amp; maize improvement</span>
                                <span class="se-tag">Dryland crops</span>
                                <span class="se-tag">Conservation agriculture</span>
                                <span class="se-tag">Soil health</span>
                                <span class="se-tag">Genetic resources</span>
                            </div>
                            <h5 class="se-detail-head mt-3">Expected Outcomes</h5>
                            <p class="se-outcome-text">Strengthened collaboration; enhanced knowledge sharing; increased awareness of scalable innovations; clearer pathways for farmer adoption; alignment with national food security priorities.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- EVENT 5 --}}
            <div class="se-event-card">
                <div class="se-event-head">
                    <div class="se-event-meta">
                        <span class="se-event-num">05</span>
                        <div>
                            <span class="se-event-time"><i class="fas fa-clock me-1"></i>14:00 – 17:00</span>
                            <span class="se-mode-badge se-mode-hybrid">Hybrid</span>
                        </div>
                    </div>
                    <div class="se-event-title-block">
                        <h3 class="se-event-title">Emerging Trends in Food Safety: Challenges, Innovations, Regulation &amp; Policy</h3>
                        <p class="se-event-host"><i class="fas fa-building me-1"></i>KALRO, Egerton University &amp; IITA</p>
                    </div>
                </div>
                <div class="se-event-body">
                    <p class="se-event-overview">
                        Brings together researchers, regulators, industry actors, and development partners to examine emerging food safety
                        challenges and innovations. Explores detection technologies, regulatory frameworks, and opportunities for
                        strengthening collaboration to build a safer, more resilient food system.
                    </p>
                    <div class="se-event-details">
                        <div class="se-detail-col">
                            <h5 class="se-detail-head">Objectives</h5>
                            <ul class="se-list">
                                <li>Highlight emerging food safety challenges affecting Kenya's food systems</li>
                                <li>Showcase innovations in food safety research, diagnostics, and mitigation</li>
                                <li>Strengthen understanding of regulatory and policy frameworks</li>
                                <li>Facilitate dialogue between researchers, regulators, and industry</li>
                                <li>Identify collaboration opportunities for improved compliance</li>
                            </ul>
                        </div>
                        <div class="se-detail-col">
                            <h5 class="se-detail-head">Key Topics</h5>
                            <div class="se-tags">
                                <span class="se-tag">Food safety risks</span>
                                <span class="se-tag">Detection &amp; diagnostics</span>
                                <span class="se-tag">Regulatory frameworks</span>
                                <span class="se-tag">Industry compliance</span>
                                <span class="se-tag">Research–policy collaboration</span>
                            </div>
                            <h5 class="se-detail-head mt-3">Expected Outcomes</h5>
                            <p class="se-outcome-text">Improved understanding of risks and innovations; alignment between research and regulation; identification of policy gaps; strengthened collaboration; clear next steps for enhancing Kenya's food safety systems.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>{{-- /day-wed --}}


        {{-- ══════════════════════════════════════════
             THURSDAY 18 JUNE
        ══════════════════════════════════════════ --}}
        <div class="se-day-section d-none" id="day-thu">
            <div class="se-day-header">
                <div class="se-day-dot"></div>
                <h2>Thursday, 18 June 2026</h2>
            </div>

            {{-- EVENT 6 --}}
            <div class="se-event-card">
                <div class="se-event-head">
                    <div class="se-event-meta">
                        <span class="se-event-num">06</span>
                        <div>
                            <span class="se-event-time"><i class="fas fa-clock me-1"></i>09:00 – 11:00</span>
                            <span class="se-mode-badge se-mode-inperson">In Person</span>
                        </div>
                    </div>
                    <div class="se-event-title-block">
                        <h3 class="se-event-title">Sustainable Livestock in Kenya: Unlocking Economic, Environmental &amp; Social Benefits</h3>
                        <p class="se-event-host"><i class="fas fa-building me-1"></i>International Livestock Research Institute (ILRI)</p>
                    </div>
                </div>
                <div class="se-event-body">
                    <p class="se-event-overview">
                        Highlights the role of livestock systems in Kenya's economy, environment, and social wellbeing. Showcases
                        ILRI's co-created solutions for sustainable rangeland management, dairy development, gender-responsive livestock
                        enterprises, and climate-smart livestock systems.
                    </p>
                    <div class="se-event-details">
                        <div class="se-detail-col">
                            <h5 class="se-detail-head">Objectives</h5>
                            <ul class="se-list">
                                <li>Share interventions that unlock livestock economic, environmental, and social benefits</li>
                                <li>Present evidence-based solutions for sustainable rangeland management and dairy development</li>
                                <li>Facilitate dialogue on scaling livestock innovations</li>
                                <li>Strengthen collaboration for climate-smart livestock systems</li>
                            </ul>
                        </div>
                        <div class="se-detail-col">
                            <h5 class="se-detail-head">Key Topics</h5>
                            <div class="se-tags">
                                <span class="se-tag">Rangeland management</span>
                                <span class="se-tag">Dairy value chain</span>
                                <span class="se-tag">Women-led livestock enterprises</span>
                                <span class="se-tag">Community co-creation</span>
                                <span class="se-tag">Climate-smart livestock</span>
                            </div>
                            <h5 class="se-detail-head mt-3">Expected Outcomes</h5>
                            <p class="se-outcome-text">Strengthened collaboration; increased awareness of sustainable livestock interventions; clearer scaling pathways; alignment with policy and community needs.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- EVENT 7 --}}
            <div class="se-event-card">
                <div class="se-event-head">
                    <div class="se-event-meta">
                        <span class="se-event-num">07</span>
                        <div>
                            <span class="se-event-time"><i class="fas fa-clock me-1"></i>10:00 – 12:30</span>
                            <span class="se-mode-badge se-mode-inperson">In Person</span>
                        </div>
                    </div>
                    <div class="se-event-title-block">
                        <h3 class="se-event-title">Accelerating Sustainable Production, Market Trade &amp; Consumption</h3>
                        <p class="se-event-host"><i class="fas fa-building me-1"></i>Alliance of Bioversity International &amp; CIAT (Co-hosted with KALRO)</p>
                    </div>
                </div>
                <div class="se-event-body">
                    <p class="se-event-overview">
                        Presents an integrated genes-to-markets model linking climate-resilient varieties, regenerative agriculture,
                        soil health, digital innovation, and market-driven consumption. Draws on 30 years of Alliance/CIAT–KALRO
                        partnership through PABRA to demonstrate how coordinated action can transform Kenya's bean value chain.
                    </p>
                    <div class="se-event-details">
                        <div class="se-detail-col">
                            <h5 class="se-detail-head">Objectives</h5>
                            <ul class="se-list">
                                <li>Present the production corridor model</li>
                                <li>Showcase 30 years of ABC/PABRA–KALRO partnership impact</li>
                                <li>Highlight regenerative agriculture practices that unlock genetic potential</li>
                                <li>Explore urban market opportunities and digital agronomy</li>
                                <li>Catalyse partnerships to close production and market gaps</li>
                            </ul>
                        </div>
                        <div class="se-detail-col">
                            <h5 class="se-detail-head">Key Topics</h5>
                            <div class="se-tags">
                                <span class="se-tag">Demand-led breeding</span>
                                <span class="se-tag">Seed systems</span>
                                <span class="se-tag">Production corridors</span>
                                <span class="se-tag">Regenerative agriculture</span>
                                <span class="se-tag">Urban markets</span>
                                <span class="se-tag">Digital agronomy</span>
                            </div>
                            <h5 class="se-detail-head mt-3">Expected Outcomes</h5>
                            <p class="se-outcome-text">Clear understanding of the corridor model; identified priority actions; strengthened partnerships across research, government, private sector, and development partners.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- EVENT 8 --}}
            <div class="se-event-card">
                <div class="se-event-head">
                    <div class="se-event-meta">
                        <span class="se-event-num">08</span>
                        <div>
                            <span class="se-event-time"><i class="fas fa-clock me-1"></i>11:00 – 13:00</span>
                            <span class="se-mode-badge se-mode-hybrid">Hybrid</span>
                        </div>
                    </div>
                    <div class="se-event-title-block">
                        <h3 class="se-event-title">Business Session: Cassava Starch Processing — Which Way Forward?</h3>
                        <p class="se-event-host"><i class="fas fa-building me-1"></i>KALRO &amp; Agriculture and Food Authority (AFA)</p>
                    </div>
                </div>
                <div class="se-event-body">
                    <p class="se-event-overview">
                        Examines the future of cassava starch processing in Kenya, focusing on market opportunities, industrial demand,
                        farmer supply systems, and the enabling environment required to unlock sector growth. Brings together researchers,
                        processors, regulators, private sector actors, and farmer organisations to explore viable business models.
                    </p>
                    <div class="se-event-details">
                        <div class="se-detail-col">
                            <h5 class="se-detail-head">Objectives</h5>
                            <ul class="se-list">
                                <li>Examine the current status of cassava starch processing in Kenya</li>
                                <li>Identify market opportunities and industrial demand drivers</li>
                                <li>Discuss supply chain challenges and farmer–processor linkages</li>
                                <li>Explore investment opportunities and viable business models</li>
                                <li>Align stakeholders on policy, standards, and regulatory requirements</li>
                            </ul>
                        </div>
                        <div class="se-detail-col">
                            <h5 class="se-detail-head">Key Topics</h5>
                            <div class="se-tags">
                                <span class="se-tag">Market trends</span>
                                <span class="se-tag">Industrial applications</span>
                                <span class="se-tag">Supply systems</span>
                                <span class="se-tag">Processing technologies</span>
                                <span class="se-tag">Quality standards</span>
                                <span class="se-tag">Policy &amp; regulation</span>
                            </div>
                            <h5 class="se-detail-head mt-3">Expected Outcomes</h5>
                            <p class="se-outcome-text">Clear understanding of market potential; identified value chain gaps; strengthened collaboration; agreed priority actions for scaling processing capacity.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- EVENT 9 --}}
            <div class="se-event-card">
                <div class="se-event-head">
                    <div class="se-event-meta">
                        <span class="se-event-num">09</span>
                        <div>
                            <span class="se-event-time"><i class="fas fa-clock me-1"></i>14:00 – 16:00</span>
                            <span class="se-mode-badge se-mode-hybrid">Hybrid</span>
                        </div>
                    </div>
                    <div class="se-event-title-block">
                        <h3 class="se-event-title">Business Session: ECF Vaccine Commercialisation</h3>
                        <p class="se-event-host"><i class="fas fa-building me-1"></i>KALRO – Veterinary Sciences Research Institute (VSRI)</p>
                    </div>
                </div>
                <div class="se-event-body">
                    <p class="se-event-overview">
                        Advances the commercialisation pathway for the East Coast Fever (ECF) vaccine, focusing on the locally produced
                        Marikebuni vaccine. Brings together regulators, private sector actors, researchers, and development partners to
                        review regulatory compliance, production readiness, market expansion, and partnership models.
                    </p>
                    <div class="se-event-details">
                        <div class="se-detail-col">
                            <h5 class="se-detail-head">Objectives</h5>
                            <ul class="se-list">
                                <li>Review progress toward regulatory approval and completion of the registration dossier</li>
                                <li>Discuss GMP requirements and pathways for certification</li>
                                <li>Explore public–private partnership models for production scale-up</li>
                                <li>Identify market opportunities for expanding national and regional uptake</li>
                                <li>Agree on priority actions and responsibilities</li>
                            </ul>
                        </div>
                        <div class="se-detail-col">
                            <h5 class="se-detail-head">Key Topics</h5>
                            <div class="se-tags">
                                <span class="se-tag">Regulatory &amp; GMP requirements</span>
                                <span class="se-tag">Production capacity</span>
                                <span class="se-tag">Market demand</span>
                                <span class="se-tag">Distribution models</span>
                                <span class="se-tag">Private sector engagement</span>
                                <span class="se-tag">Commercialisation roadmap</span>
                            </div>
                            <h5 class="se-detail-head mt-3">Expected Outcomes</h5>
                            <p class="se-outcome-text">Clear understanding of regulatory requirements; agreed next steps for dossier completion; strengthened partnerships; identified market expansion opportunities; coordinated commercialisation roadmap.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- EVENT 11 --}}
            <div class="se-event-card">
                <div class="se-event-head">
                    <div class="se-event-meta">
                        <span class="se-event-num">11</span>
                        <div>
                            <span class="se-event-time"><i class="fas fa-clock me-1"></i>TBC</span>
                            <span class="se-mode-badge se-mode-hybrid">Hybrid</span>
                        </div>
                    </div>
                    <div class="se-event-title-block">
                        <h3 class="se-event-title">Delivering Biotechnology in Kenya: Delivery, Products &amp; Future Prospects</h3>
                        <p class="se-event-host"><i class="fas fa-building me-1"></i>KALRO – Biotechnology Research Institute (BioRI) &amp; AATF</p>
                    </div>
                </div>
                <div class="se-event-body">
                    <p class="se-event-overview">
                        Brings together biotechnology researchers, policymakers, industry actors, farmers, and media to explore Kenya's
                        progress in delivering modern biotechnology solutions for agriculture. The session highlights practical
                        experiences in deploying biotechnology innovations, emerging breeding techniques, regulatory developments, and
                        the future of modern biotechnology products in strengthening climate-smart agriculture and national food security.
                    </p>
                    <div class="se-event-details">
                        <div class="se-detail-col">
                            <h5 class="se-detail-head">Objectives</h5>
                            <ul class="se-list">
                                <li>Share Kenya's experience in delivering biotechnology innovations</li>
                                <li>Highlight opportunities, challenges, and lessons in biotechnology deployment</li>
                                <li>Explore emerging breeding techniques and regional progress</li>
                                <li>Discuss future prospects of modern biotechnology products for Kenya</li>
                                <li>Identify strategic actions, partnerships, and policy recommendations</li>
                            </ul>
                        </div>
                        <div class="se-detail-col">
                            <h5 class="se-detail-head">Key Topics</h5>
                            <div class="se-tags">
                                <span class="se-tag">Biotechnology delivery pathways</span>
                                <span class="se-tag">Emerging breeding techniques</span>
                                <span class="se-tag">Modern biotech products</span>
                                <span class="se-tag">Regulatory &amp; policy considerations</span>
                                <span class="se-tag">Commercialisation pathways</span>
                            </div>
                            <h5 class="se-detail-head mt-3">Expected Outcomes</h5>
                            <p class="se-outcome-text">Increased awareness of modern biotechnology; clear lessons on delivery in Kenya; identification of strategic actions and partnerships; recommendations for policy briefs; strengthened alignment between research, regulation, and public engagement.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>{{-- /day-thu --}}


        {{-- ══ BOTTOM CTA ══ --}}
        <div class="se-cta-block">
            <div class="se-cta-inner">
                <div>
                    <h3 class="se-cta-title">Ready to attend a side event?</h3>
                    <p class="se-cta-sub">Side events are open to all registered conference delegates. Register below or download the full programme for session details and venue information.</p>
                </div>
                <div class="d-flex gap-3 flex-wrap justify-content-center">
                    <a href="https://forms.gle/UsduBgszNWhjQpJS9"
                       target="_blank" rel="noopener noreferrer"
                       class="se-cta-btn-primary">
                        <i class="fas fa-external-link-alt me-2"></i>Register for a Side Event
                    </a>
                    <a href="{{ asset('program/Program_Side_event.pdf') }}"
                       download="Program_Side_event.pdf"
                       class="se-cta-btn-outline">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        Download Programme PDF
                    </a>
                </div>
            </div>
        </div>

    </div>{{-- /container --}}
</div>{{-- /se-wrapper --}}


<style>
:root {
    --k-green:      #1a5f3a;
    --k-green-dark: #0d3d25;
    --k-green-mid:  #14532d;
    --k-green-acc:  #1f7a4c;
    --k-green-lt:   #e6f4ec;
    --k-green-xl:   #f0fdf4;
    --k-grad:       linear-gradient(135deg, #1a5f3a 0%, #0d3d25 100%);
    --k-border:     #d1d5db;
    --k-bg:         #f8faf9;
    --k-text:       #111827;
    --k-muted:      #6b7280;
    --k-shadow:     0 4px 24px rgba(0,0,0,.07);
    --k-shadow-lg:  0 10px 40px rgba(0,0,0,.10);
}

/* ── Wrapper ── */
.se-wrapper { min-height:100vh; background:linear-gradient(160deg,#f0faf3 0%,#e9f5ec 60%,#e4f0e8 100%); }

/* ── Hero ── */
.se-hero {
    position:relative; background:var(--k-grad);
    padding:4.5rem 0 5.5rem; overflow:hidden;
    clip-path:polygon(0 0,100% 0,100% 84%,0 100%); color:#fff;
}
.se-hero-bg {
    position:absolute; inset:0;
    background-image:radial-gradient(circle at 15% 40%,rgba(255,255,255,.06) 0%,transparent 50%),
                     radial-gradient(circle at 80% 70%,rgba(255,255,255,.04) 0%,transparent 40%);
    pointer-events:none;
}
.se-hero-badge {
    display:inline-block; background:rgba(255,255,255,.18);
    border:1px solid rgba(255,255,255,.3); color:#fff;
    font-size:.75rem; font-weight:700; letter-spacing:.1em;
    text-transform:uppercase; padding:.35rem 1rem;
    border-radius:100px; margin-bottom:1.25rem;
}
.se-hero-title { font-size:clamp(2rem,5vw,3rem); font-weight:800; letter-spacing:-.5px; margin:0 0 .75rem; }
.se-hero-sub { font-size:1.05rem; color:rgba(255,255,255,.9); margin:0 0 1.5rem; max-width:600px; }
.se-hero-badge-pill {
    display:inline-flex; align-items:center; gap:.4rem;
    background:rgba(255,255,255,.15); border:1px solid rgba(255,255,255,.25);
    padding:.4rem 1rem; border-radius:100px;
    font-size:.82rem; font-weight:600;
}

/* ── Action bar ── */
.se-action-bar {
    background:#f0fdf4; border-bottom:1px solid #86efac; padding:13px 0; position:sticky; top:0; z-index:90;
    box-shadow:0 2px 8px rgba(0,0,0,.06);
}
.se-btn-primary {
    display:inline-flex; align-items:center; gap:7px;
    background:var(--k-green); color:#fff; font-weight:700; font-size:.83rem;
    padding:9px 20px; border-radius:22px; text-decoration:none; white-space:nowrap;
    transition:background .15s;
}
.se-btn-primary:hover { background:var(--k-green-dark); color:#fff; }
.se-btn-outline {
    display:inline-flex; align-items:center; gap:7px;
    background:#fff; color:var(--k-green); border:2px solid var(--k-green);
    font-weight:700; font-size:.83rem; padding:7px 18px;
    border-radius:22px; text-decoration:none; white-space:nowrap;
    transition:all .15s;
}
.se-btn-outline:hover { background:var(--k-green-lt); }

/* ── Body ── */
.se-body { padding-top:2rem; padding-bottom:5rem; }

/* ── Day tabs ── */
.se-day-tabs { display:flex; gap:1rem; margin-bottom:2rem; }
.se-day-tab {
    flex:1; max-width:200px; padding:.9rem 1.5rem;
    background:#fff; border:2px solid var(--k-border); border-radius:14px;
    cursor:pointer; text-align:left; transition:all .2s;
    box-shadow:var(--k-shadow);
}
.se-day-tab:hover { border-color:var(--k-green-acc); }
.se-day-tab.active { background:var(--k-green); border-color:var(--k-green); color:#fff; }
.se-tab-label { display:block; font-weight:800; font-size:1rem; }
.se-tab-date { display:block; font-size:.78rem; opacity:.75; margin-top:2px; }
.se-day-tab.active .se-tab-date { opacity:.85; }

/* ── Day section ── */
.se-day-header { display:flex; align-items:center; gap:12px; margin-bottom:1.5rem; }
.se-day-dot { width:12px; height:12px; border-radius:50%; background:var(--k-green); flex-shrink:0; }
.se-day-header h2 { font-size:1.1rem; font-weight:700; color:var(--k-green-dark); margin:0; }

/* ── Event card ── */
.se-event-card {
    background:#fff; border-radius:18px;
    border:1px solid rgba(26,95,58,.1); border-left:5px solid var(--k-green);
    box-shadow:var(--k-shadow); margin-bottom:1.5rem; overflow:hidden;
    transition:box-shadow .2s, transform .2s;
}
.se-event-card:hover { box-shadow:var(--k-shadow-lg); transform:translateY(-2px); }
.se-event-card--launch { border-left-color:#b45309; }

/* ── Event head ── */
.se-event-head {
    display:flex; align-items:flex-start; gap:1rem;
    padding:1.25rem 1.5rem; background:linear-gradient(135deg,#f7fbf8 0%,var(--k-green-xl) 100%);
    border-bottom:1px solid var(--k-green-lt);
}
.se-event-card--launch .se-event-head { background:linear-gradient(135deg,#fffbf0 0%,#fef3c7 100%); border-bottom-color:#fde68a; }
.se-event-meta { display:flex; flex-direction:column; align-items:center; gap:.5rem; flex-shrink:0; }
.se-event-num {
    width:38px; height:38px; border-radius:50%;
    background:var(--k-green); color:#fff;
    display:flex; align-items:center; justify-content:center;
    font-size:.8rem; font-weight:800; flex-shrink:0;
}
.se-event-time { font-size:.78rem; font-weight:700; color:var(--k-green-dark); white-space:nowrap; }
.se-mode-badge {
    display:inline-block; font-size:.68rem; font-weight:700;
    padding:.2em .65em; border-radius:20px; white-space:nowrap;
}
.se-mode-inperson { background:#dcfce7; color:#14532d; }
.se-mode-hybrid { background:#dbeafe; color:#1e40af; }
.se-launch-badge {
    display:inline-block; background:#fef3c7; color:#92400e;
    font-size:.68rem; font-weight:700; padding:.2em .65em;
    border-radius:20px; white-space:nowrap;
}
.se-event-title-block { flex:1; }
.se-event-title { font-size:1.05rem; font-weight:800; color:var(--k-text); margin:0 0 .3rem; line-height:1.35; }
.se-event-host { font-size:.82rem; color:var(--k-muted); margin:0; }

/* ── Event body ── */
.se-event-body { padding:1.25rem 1.5rem; }
.se-event-overview { color:var(--k-text); font-size:.93rem; line-height:1.65; margin-bottom:1.25rem; }
.se-event-details { display:grid; grid-template-columns:1fr 1fr; gap:1.5rem; }
@media(max-width:640px) { .se-event-details { grid-template-columns:1fr; } }
.se-detail-head { font-size:.78rem; font-weight:800; text-transform:uppercase; letter-spacing:.08em; color:var(--k-green-mid); margin:0 0 .6rem; }
.se-list { padding-left:1.1rem; margin:0; }
.se-list li { font-size:.875rem; color:var(--k-text); margin-bottom:.35rem; line-height:1.5; }
.se-tags { display:flex; flex-wrap:wrap; gap:.4rem; }
.se-tag {
    background:var(--k-green-lt); color:var(--k-green-dark);
    font-size:.75rem; font-weight:600; padding:.25em .75em;
    border-radius:20px;
}
.se-outcome-text { font-size:.875rem; color:var(--k-muted); line-height:1.6; margin:0; }

/* ── Bottom CTA ── */
.se-cta-block { margin-top:3rem; }
.se-cta-inner {
    background:var(--k-grad); border-radius:20px;
    padding:3rem 2.5rem; text-align:center; color:#fff;
    display:flex; flex-direction:column; align-items:center; gap:2rem;
    box-shadow:0 12px 40px rgba(13,61,37,.3);
}
.se-cta-title { font-size:1.6rem; font-weight:800; margin:0 0 .5rem; }
.se-cta-sub { font-size:.95rem; color:rgba(255,255,255,.85); margin:0; max-width:560px; }
.se-cta-btn-primary {
    display:inline-flex; align-items:center; gap:8px;
    background:#f5a623; color:#1a2b1f; font-weight:800;
    font-size:.95rem; padding:13px 28px; border-radius:50px;
    text-decoration:none; transition:background .15s; white-space:nowrap;
}
.se-cta-btn-primary:hover { background:#e8961a; color:#1a2b1f; }
.se-cta-btn-outline {
    display:inline-flex; align-items:center; gap:8px;
    background:rgba(255,255,255,.12); color:#fff;
    border:2px solid rgba(255,255,255,.4);
    font-weight:700; font-size:.95rem; padding:11px 24px;
    border-radius:50px; text-decoration:none; transition:all .15s; white-space:nowrap;
}
.se-cta-btn-outline:hover { background:rgba(255,255,255,.22); }
</style>

<script>
function filterDay(day, btn) {
    document.querySelectorAll('.se-day-section').forEach(s => s.classList.add('d-none'));
    document.querySelectorAll('.se-day-tab').forEach(b => b.classList.remove('active'));
    document.getElementById('day-' + day).classList.remove('d-none');
    btn.classList.add('active');
}
</script>

@endsection
