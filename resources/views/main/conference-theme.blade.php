@extends('layouts.header')

@section('title')
    Conference Theme
@endsection

@section('content')

    <!-- Page Header -->
    <section class="page-header bg-success text-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="display-4 fw-bold mb-3">
                        <i class="fas fa-bullseye me-3"></i>Conference Themes
                    </h1>
                    <p class="lead mb-4">The 2nd KALRO Scientific Conference and Innovation Expo 2026</p>
                    <nav aria-label="breadcrumb" class="d-flex justify-content-center">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="/" class="text-white-50">Home</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">Conference Themes</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Theme Section -->
    <section class="main-theme py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card border-success shadow-lg">
                        <div class="card-header bg-success text-white py-4">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-star fa-3x"></i>
                                </div>
                                <div class="flex-grow-1 ms-4">
                                    <h2 class="card-title h1 mb-2">Main Conference Theme</h2>
                                    <p class="card-subtitle h4 mb-0">2nd KALRO Scientific Conference and Innovation Expo 2026</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-5">
                            <blockquote class="blockquote mb-4">
                                <p class="display-6 fw-bold text-success mb-3">
                                    "Innovations for Sustainable Agri-food Systems, Climate Change Resilience and Improved Livelihoods"
                                </p>
                            </blockquote>
                            
                            <div class="theme-narrative p-4 bg-success bg-opacity-10 rounded border-start border-success border-5">
                                <p class="mb-3">
                                    The 2nd KALRO Scientific Conference and Innovation Expo 2026 is organized under the theme 
                                    <strong>"Innovations for Sustainable Agri-food Systems, Climate Change Resilience and Improved Livelihoods"</strong>, 
                                    which is guided by the Bottom-Up Economic Transformation Agenda (BETA) and framed within the global Green Economy and emerging Blue Economy.
                                </p>
                                <p class="mb-3">
                                    The forum lays emphasis on scientific innovations as a driver of productivity, sustainability, and commercialization. 
                                    The Conference sub themes invite evidence based contributions that demonstrate how agricultural research can improve 
                                    farmer incomes, enhance resilience to climate change, and expand opportunities across value chains.
                                </p>
                                <p class="mb-0">
                                    Papers are expected to bridge research and practice, offering insights that inform policy, empower communities, 
                                    and advance Kenya's transformation agenda.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sub-Themes Grid -->
    <section class="sub-themes py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <h2 class="h1 text-success mb-3">
                        <i class="fas fa-layer-group me-2"></i>Conference Sub-Themes
                    </h2>
                    <p class="lead text-muted">17 comprehensive sub-themes guiding the conference discussions and paper submissions</p>
                    <div class="d-flex justify-content-center mb-4">
                        <span class="badge bg-success fs-6 p-3 me-2">
                            <i class="fas fa-paper-plane me-1"></i> 17 Sub-Themes
                        </span>
                        <span class="badge bg-info fs-6 p-3">
                            <i class="fas fa-microphone me-1"></i> Multidisciplinary Topics
                        </span>
                    </div>
                </div>
            </div>

            <div class="row g-4" id="subThemesGrid">
                <!-- Sub-theme 1 -->
                <div class="col-lg-4 col-md-6">
                    <div class="theme-card card h-100 border-0 shadow-sm hover-shadow transition-all">
                        <div class="card-header bg-success bg-opacity-10 border-0 py-4">
                            <div class="theme-number d-flex align-items-center justify-content-center rounded-circle bg-success text-white mb-3 mx-auto" style="width: 50px; height: 50px;">
                                <span class="h4 mb-0">1</span>
                            </div>
                            <h3 class="h5 card-title text-center mb-0">Crop Varieties, Increased Productivity and Production Management</h3>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                Improved varieties and integrated crop management practices drive food security and resilience, 
                                enhancing productivity across diverse agro ecologies.
                            </p>
                            <div class="theme-expected mt-4 p-3 bg-light rounded">
                                <h6 class="fw-bold text-success mb-2">
                                    <i class="fas fa-file-alt me-1"></i> Expected Papers:
                                </h6>
                                <ul class="mb-0 ps-3 small">
                                    <li>Breeding results and safeguarding breeders' rights</li>
                                    <li>Agronomic interventions</li>
                                    <li>Productivity assessments</li>
                                    <li>Crop management innovations</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sub-theme 2 -->
                <div class="col-lg-4 col-md-6">
                    <div class="theme-card card h-100 border-0 shadow-sm hover-shadow transition-all">
                        <div class="card-header bg-success bg-opacity-10 border-0 py-4">
                            <div class="theme-number d-flex align-items-center justify-content-center rounded-circle bg-success text-white mb-3 mx-auto" style="width: 50px; height: 50px;">
                                <span class="h4 mb-0">2</span>
                            </div>
                            <h3 class="h5 card-title text-center mb-0">Sustainable Seed Systems, Quality Assurance and Scalability</h3>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                Seed systems underpin adoption and resilience, ensuring farmers access reliable, affordable, 
                                and high quality seed at scale.
                            </p>
                            <div class="theme-expected mt-4 p-3 bg-light rounded">
                                <h6 class="fw-bold text-success mb-2">
                                    <i class="fas fa-file-alt me-1"></i> Expected Papers:
                                </h6>
                                <ul class="mb-0 ps-3 small">
                                    <li>Seed production and distribution successes and challenges</li>
                                    <li>Seed certification interventions</li>
                                    <li>Scalability case studies and models</li>
                                    <li>Seed system analyses</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sub-theme 3 -->
                <div class="col-lg-4 col-md-6">
                    <div class="theme-card card h-100 border-0 shadow-sm hover-shadow transition-all">
                        <div class="card-header bg-success bg-opacity-10 border-0 py-4">
                            <div class="theme-number d-flex align-items-center justify-content-center rounded-circle bg-success text-white mb-3 mx-auto" style="width: 50px; height: 50px;">
                                <span class="h4 mb-0">3</span>
                            </div>
                            <h3 class="h5 card-title text-center mb-0">Plant Health, Emerging Crop Pests and Diseases, Biosecurity and Phytosanitary Systems</h3>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                Diagnostics, surveillance, and phytosanitary measures safeguard crops against endemic and 
                                emerging threats while enabling market access.
                            </p>
                            <div class="theme-expected mt-4 p-3 bg-light rounded">
                                <h6 class="fw-bold text-success mb-2">
                                    <i class="fas fa-file-alt me-1"></i> Expected Papers:
                                </h6>
                                <ul class="mb-0 ps-3 small">
                                    <li>Pest diagnostics, monitoring, surveillance and early warning</li>
                                    <li>Integrated pest and disease management strategies</li>
                                    <li>Responsible use of pesticides</li>
                                    <li>Biosecurity protocols, and phytosanitary interventions</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sub-theme 4 -->
                <div class="col-lg-4 col-md-6">
                    <div class="theme-card card h-100 border-0 shadow-sm hover-shadow transition-all">
                        <div class="card-header bg-success bg-opacity-10 border-0 py-4">
                            <div class="theme-number d-flex align-items-center justify-content-center rounded-circle bg-success text-white mb-3 mx-auto" style="width: 50px; height: 50px;">
                                <span class="h4 mb-0">4</span>
                            </div>
                            <h3 class="h5 card-title text-center mb-0">Plant Nutrition, Soil Health and Conservation Agriculture</h3>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                Nutrient management, fertility enhancement, and conservation practices sustain long term 
                                productivity and enable replenishment of land resources.
                            </p>
                            <div class="theme-expected mt-4 p-3 bg-light rounded">
                                <h6 class="fw-bold text-success mb-2">
                                    <i class="fas fa-file-alt me-1"></i> Expected Papers:
                                </h6>
                                <ul class="mb-0 ps-3 small">
                                    <li>Soil amendment interventions</li>
                                    <li>Nutrient management strategies</li>
                                    <li>Conservation agriculture case studies</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sub-theme 5 -->
                <div class="col-lg-4 col-md-6">
                    <div class="theme-card card h-100 border-0 shadow-sm hover-shadow transition-all">
                        <div class="card-header bg-success bg-opacity-10 border-0 py-4">
                            <div class="theme-number d-flex align-items-center justify-content-center rounded-circle bg-success text-white mb-3 mx-auto" style="width: 50px; height: 50px;">
                                <span class="h4 mb-0">5</span>
                            </div>
                            <h3 class="h5 card-title text-center mb-0">Water Harvesting, Conservation and Irrigation Systems</h3>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                Efficient water harvesting and irrigation technologies expand production and strengthen 
                                resilience under climate-induced stresses.
                            </p>
                            <div class="theme-expected mt-4 p-3 bg-light rounded">
                                <h6 class="fw-bold text-success mb-2">
                                    <i class="fas fa-file-alt me-1"></i> Expected Papers:
                                </h6>
                                <ul class="mb-0 ps-3 small">
                                    <li>Irrigation technologies</li>
                                    <li>Water harvesting models</li>
                                    <li>Water management and conservation practices</li>
                                    <li>Drainage interventions</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sub-theme 6 -->
                <div class="col-lg-4 col-md-6">
                    <div class="theme-card card h-100 border-0 shadow-sm hover-shadow transition-all">
                        <div class="card-header bg-success bg-opacity-10 border-0 py-4">
                            <div class="theme-number d-flex align-items-center justify-content-center rounded-circle bg-success text-white mb-3 mx-auto" style="width: 50px; height: 50px;">
                                <span class="h4 mb-0">6</span>
                            </div>
                            <h3 class="h5 card-title text-center mb-0">Ecological Organic Farming Systems, Renewable Energy Integration and Circular Economy</h3>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                Organic systems, renewable energy, and circular approaches regenerate ecosystems 
                                while reducing environmental footprints.
                            </p>
                            <div class="theme-expected mt-4 p-3 bg-light rounded">
                                <h6 class="fw-bold text-success mb-2">
                                    <i class="fas fa-file-alt me-1"></i> Expected Papers:
                                </h6>
                                <ul class="mb-0 ps-3 small">
                                    <li>Organic farming techniques and results</li>
                                    <li>Application of natural energy resources</li>
                                    <li>Recycling, composting and circular economy models</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sub-theme 7 -->
                <div class="col-lg-4 col-md-6">
                    <div class="theme-card card h-100 border-0 shadow-sm hover-shadow transition-all">
                        <div class="card-header bg-success bg-opacity-10 border-0 py-4">
                            <div class="theme-number d-flex align-items-center justify-content-center rounded-circle bg-success text-white mb-3 mx-auto" style="width: 50px; height: 50px;">
                                <span class="h4 mb-0">7</span>
                            </div>
                            <h3 class="h5 card-title text-center mb-0">Climate Change, Land Degradation and Reclamation</h3>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                Adaptation strategies and reclamation practices restore degraded lands and strengthen 
                                resilience against climate impacts.
                            </p>
                            <div class="theme-expected mt-4 p-3 bg-light rounded">
                                <h6 class="fw-bold text-success mb-2">
                                    <i class="fas fa-file-alt me-1"></i> Expected Papers:
                                </h6>
                                <ul class="mb-0 ps-3 small">
                                    <li>Climate adaptation and mitigation strategies</li>
                                    <li>Land restoration interventions</li>
                                    <li>Resilience frameworks</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sub-theme 8 -->
                <div class="col-lg-4 col-md-6">
                    <div class="theme-card card h-100 border-0 shadow-sm hover-shadow transition-all">
                        <div class="card-header bg-success bg-opacity-10 border-0 py-4">
                            <div class="theme-number d-flex align-items-center justify-content-center rounded-circle bg-success text-white mb-3 mx-auto" style="width: 50px; height: 50px;">
                                <span class="h4 mb-0">8</span>
                            </div>
                            <h3 class="h5 card-title text-center mb-0">Agrodiversity and Genetic Resources</h3>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                Conserving and harnessing genetic diversity fuels innovation and resilience for 
                                future farming systems.
                            </p>
                            <div class="theme-expected mt-4 p-3 bg-light rounded">
                                <h6 class="fw-bold text-success mb-2">
                                    <i class="fas fa-file-alt me-1"></i> Expected Papers:
                                </h6>
                                <ul class="mb-0 ps-3 small">
                                    <li>Germplasm characterization</li>
                                    <li>Genetic conservation and retrieval systems</li>
                                    <li>Agrodiversity utilization</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sub-theme 9 -->
                <div class="col-lg-4 col-md-6">
                    <div class="theme-card card h-100 border-0 shadow-sm hover-shadow transition-all">
                        <div class="card-header bg-success bg-opacity-10 border-0 py-4">
                            <div class="theme-number d-flex align-items-center justify-content-center rounded-circle bg-success text-white mb-3 mx-auto" style="width: 50px; height: 50px;">
                                <span class="h4 mb-0">9</span>
                            </div>
                            <h3 class="h5 card-title text-center mb-0">Animal Feed Resources, Nutrition and Husbandry Practices</h3>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                Feed resource development, nutrition strategies, and husbandry innovations and rangeland 
                                management improve livestock productivity and welfare.
                            </p>
                            <div class="theme-expected mt-4 p-3 bg-light rounded">
                                <h6 class="fw-bold text-success mb-2">
                                    <i class="fas fa-file-alt me-1"></i> Expected Papers:
                                </h6>
                                <ul class="mb-0 ps-3 small">
                                    <li>Feed resources, forage agronomy, forage breeding</li>
                                    <li>Nutrition products</li>
                                    <li>Husbandry innovations, pastoralism, range ecology</li>
                                    <li>Rangeland restoration strategies and grazing management</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sub-theme 10 -->
                <div class="col-lg-4 col-md-6">
                    <div class="theme-card card h-100 border-0 shadow-sm hover-shadow transition-all">
                        <div class="card-header bg-success bg-opacity-10 border-0 py-4">
                            <div class="theme-number d-flex align-items-center justify-content-center rounded-circle bg-success text-white mb-3 mx-auto" style="width: 50px; height: 50px;">
                                <span class="h4 mb-0">10</span>
                            </div>
                            <h3 class="h5 card-title text-center mb-0">Livestock Breeds, Breeding Practices and Emerging Livestock Species</h3>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                Breeding programs and emerging species offer pathways to resilient and productive stocks.
                            </p>
                            <div class="theme-expected mt-4 p-3 bg-light rounded">
                                <h6 class="fw-bold text-success mb-2">
                                    <i class="fas fa-file-alt me-1"></i> Expected Papers:
                                </h6>
                                <ul class="mb-0 ps-3 small">
                                    <li>Breeding program results</li>
                                    <li>Genetic evaluations</li>
                                    <li>Genotype-environment interactions</li>
                                    <li>Breeding strategies, and emerging livestock</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sub-theme 11 -->
                <div class="col-lg-4 col-md-6">
                    <div class="theme-card card h-100 border-0 shadow-sm hover-shadow transition-all">
                        <div class="card-header bg-success bg-opacity-10 border-0 py-4">
                            <div class="theme-number d-flex align-items-center justify-content-center rounded-circle bg-success text-white mb-3 mx-auto" style="width: 50px; height: 50px;">
                                <span class="h4 mb-0">11</span>
                            </div>
                            <h3 class="h5 card-title text-center mb-0">Animal Health, Sanitary Systems and Emerging Livestock Pests and Diseases</h3>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                Vaccine research, epidemiology, diagnostics, surveillance, sanitary measures enhance 
                                livestock productivity, food safety, One Health and market access.
                            </p>
                            <div class="theme-expected mt-4 p-3 bg-light rounded">
                                <h6 class="fw-bold text-success mb-2">
                                    <i class="fas fa-file-alt me-1"></i> Expected Papers:
                                </h6>
                                <ul class="mb-0 ps-3 small">
                                    <li>Vaccine breakthroughs</li>
                                    <li>Disease epidemiology, disease surveillance</li>
                                    <li>Antimicrobial resistance, sanitary protocols and traceability</li>
                                    <li>Emerging and remerging zoonoses, vector-borne diseases and pest management</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sub-theme 12 -->
                <div class="col-lg-4 col-md-6">
                    <div class="theme-card card h-100 border-0 shadow-sm hover-shadow transition-all">
                        <div class="card-header bg-success bg-opacity-10 border-0 py-4">
                            <div class="theme-number d-flex align-items-center justify-content-center rounded-circle bg-success text-white mb-3 mx-auto" style="width: 50px; height: 50px;">
                                <span class="h4 mb-0">12</span>
                            </div>
                            <h3 class="h5 card-title text-center mb-0">Apiculture, Beneficial Insects and Ecosystem Services</h3>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                Pollinators and beneficial insects sustain biodiversity, ecosystem services, and rural incomes.
                            </p>
                            <div class="theme-expected mt-4 p-3 bg-light rounded">
                                <h6 class="fw-bold text-success mb-2">
                                    <i class="fas fa-file-alt me-1"></i> Expected Papers:
                                </h6>
                                <ul class="mb-0 ps-3 small">
                                    <li>Apiculture innovations, bee breeds and breeding</li>
                                    <li>Hive technology, bee absconding, emerging bee health challenges</li>
                                    <li>Pollination studies, insect based ecosystem services</li>
                                    <li>Insects for food and feed</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sub-theme 13 -->
                <div class="col-lg-4 col-md-6">
                    <div class="theme-card card h-100 border-0 shadow-sm hover-shadow transition-all">
                        <div class="card-header bg-success bg-opacity-10 border-0 py-4">
                            <div class="theme-number d-flex align-items-center justify-content-center rounded-circle bg-success text-white mb-3 mx-auto" style="width: 50px; height: 50px;">
                                <span class="h4 mb-0">13</span>
                            </div>
                            <h3 class="h5 card-title text-center mb-0">Biotechnological Solutions to Crop, Livestock and Natural Resource Management Challenges</h3>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                Biotechnological innovations provide scalable solutions to persistent challenges in 
                                farming and resource management.
                            </p>
                            <div class="theme-expected mt-4 p-3 bg-light rounded">
                                <h6 class="fw-bold text-success mb-2">
                                    <i class="fas fa-file-alt me-1"></i> Expected Papers:
                                </h6>
                                <ul class="mb-0 ps-3 small">
                                    <li>Genetic engineering, gene editing</li>
                                    <li>Biotech products, and techniques</li>
                                    <li>Molecular diagnostics</li>
                                    <li>Biotech applications</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sub-theme 14 -->
                <div class="col-lg-4 col-md-6">
                    <div class="theme-card card h-100 border-0 shadow-sm hover-shadow transition-all">
                        <div class="card-header bg-success bg-opacity-10 border-0 py-4">
                            <div class="theme-number d-flex align-items-center justify-content-center rounded-circle bg-success text-white mb-3 mx-auto" style="width: 50px; height: 50px;">
                                <span class="h4 mb-0">14</span>
                            </div>
                            <h3 class="h5 card-title text-center mb-0">Food Safety, Value Addition and Cottage Industries</h3>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                Food safety systems and value addition technologies strengthen markets, competitiveness, and livelihoods.
                            </p>
                            <div class="theme-expected mt-4 p-3 bg-light rounded">
                                <h6 class="fw-bold text-success mb-2">
                                    <i class="fas fa-file-alt me-1"></i> Expected Papers:
                                </h6>
                                <ul class="mb-0 ps-3 small">
                                    <li>Food safety challenges and interventions</li>
                                    <li>Value addition technologies</li>
                                    <li>Cottage industry case studies and models</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sub-theme 15 -->
                <div class="col-lg-4 col-md-6">
                    <div class="theme-card card h-100 border-0 shadow-sm hover-shadow transition-all">
                        <div class="card-header bg-success bg-opacity-10 border-0 py-4">
                            <div class="theme-number d-flex align-items-center justify-content-center rounded-circle bg-success text-white mb-3 mx-auto" style="width: 50px; height: 50px;">
                                <span class="h4 mb-0">15</span>
                            </div>
                            <h3 class="h5 card-title text-center mb-0">Mechanization in Agricultural Systems</h3>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                Mechanization drives efficiency and competitiveness across agricultural systems, 
                                reducing drudgery, improving precision, and strengthening productivity.
                            </p>
                            <div class="theme-expected mt-4 p-3 bg-light rounded">
                                <h6 class="fw-bold text-success mb-2">
                                    <i class="fas fa-file-alt me-1"></i> Expected Papers:
                                </h6>
                                <ul class="mb-0 ps-3 small">
                                    <li>Machine design, fabrication and testing</li>
                                    <li>Equipment innovations, adoption studies</li>
                                    <li>Mechanization of production, processing, and value addition processes</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sub-theme 16 -->
                <div class="col-lg-4 col-md-6">
                    <div class="theme-card card h-100 border-0 shadow-sm hover-shadow transition-all">
                        <div class="card-header bg-success bg-opacity-10 border-0 py-4">
                            <div class="theme-number d-flex align-items-center justify-content-center rounded-circle bg-success text-white mb-3 mx-auto" style="width: 50px; height: 50px;">
                                <span class="h4 mb-0">16</span>
                            </div>
                            <h3 class="h5 card-title text-center mb-0">Technology Transfer Approaches, Knowledge Co Creation and Scaling Pathways, ICT Enabled Precision Systems</h3>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                Extension approaches, co creation, and ICT precision tools accelerate adoption and 
                                scaling of innovations.
                            </p>
                            <div class="theme-expected mt-4 p-3 bg-light rounded">
                                <h6 class="fw-bold text-success mb-2">
                                    <i class="fas fa-file-alt me-1"></i> Expected Papers:
                                </h6>
                                <ul class="mb-0 ps-3 small">
                                    <li>Extension models</li>
                                    <li>ICT applications, utilization of databases</li>
                                    <li>ICT-based predictions and advisories</li>
                                    <li>Scaling case studies</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sub-theme 17 -->
                <div class="col-lg-4 col-md-6">
                    <div class="theme-card card h-100 border-0 shadow-sm hover-shadow transition-all">
                        <div class="card-header bg-success bg-opacity-10 border-0 py-4">
                            <div class="theme-number d-flex align-items-center justify-content-center rounded-circle bg-success text-white mb-3 mx-auto" style="width: 50px; height: 50px;">
                                <span class="h4 mb-0">17</span>
                            </div>
                            <h3 class="h5 card-title text-center mb-0">Agribusiness Models, Agri Financing, Agri Policy Frameworks and Entrepreneurship</h3>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                Business models, financing mechanisms, entrepreneurship strategies and policy 
                                guidelines drive commercialization and resilient livelihoods.
                            </p>
                            <div class="theme-expected mt-4 p-3 bg-light rounded">
                                <h6 class="fw-bold text-success mb-2">
                                    <i class="fas fa-file-alt me-1"></i> Expected Papers:
                                </h6>
                                <ul class="mb-0 ps-3 small">
                                    <li>Business models, financing mechanisms</li>
                                    <li>Policy analyses, agri-insurance</li>
                                    <li>Entrepreneurship case studies</li>
                                    <li>Gender and agri-demographics, and impact assessments</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Call to Action -->
            <div class="row mt-5">
                <div class="col-12">
                    <div class="alert alert-success border-0 shadow-sm">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 me-3">
                                <i class="fas fa-lightbulb fa-3x"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h4 class="alert-heading">Ready to Submit Your Abstract?</h4>
                                <p class="mb-3">Select the most relevant sub-theme for your research when submitting your abstract.</p>
                                <div class="d-flex flex-wrap gap-3">
                                    <a href="pages/submit_abstract.php" class="btn btn-success btn-lg">
                                        <i class="fas fa-paper-plane me-2"></i>Submit Abstract
                                    </a>
                                    <a href="/about" class="btn btn-outline-info btn-lg">
                                        <i class="fas fa-info-circle me-2"></i>Conference Info
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Theme Statistics -->
    <section class="theme-stats py-5 bg-light">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 col-6 mb-4">
                    <div class="stat-card p-4 bg-white rounded shadow-sm">
                        <div class="stat-icon mb-3">
                            <i class="fas fa-seedling fa-3x text-success"></i>
                        </div>
                        <h3 class="stat-number h1 fw-bold text-success mb-2">6</h3>
                        <p class="stat-label text-muted mb-0">Crop-related Themes</p>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <div class="stat-card p-4 bg-white rounded shadow-sm">
                        <div class="stat-icon mb-3">
                            <i class="fas fa-cow fa-3x text-success"></i>
                        </div>
                        <h3 class="stat-number h1 fw-bold text-success mb-2">4</h3>
                        <p class="stat-label text-muted mb-0">Livestock-related Themes</p>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <div class="stat-card p-4 bg-white rounded shadow-sm">
                        <div class="stat-icon mb-3">
                            <i class="fas fa-cogs fa-3x text-success"></i>
                        </div>
                        <h3 class="stat-number h1 fw-bold text-success mb-2">7</h3>
                        <p class="stat-label text-muted mb-0">Technology & Systems Themes</p>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <div class="stat-card p-4 bg-white rounded shadow-sm">
                        <div class="stat-icon mb-3">
                            <i class="fas fa-chart-line fa-3x text-success"></i>
                        </div>
                        <h3 class="stat-number h1 fw-bold text-success mb-2">17</h3>
                        <p class="stat-label text-muted mb-0">Total Sub-themes</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add hover effects to theme cards
        const themeCards = document.querySelectorAll('.theme-card');
        
        themeCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
                this.style.boxShadow = '0 10px 25px rgba(25,135,84,0.15)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 2px 8px rgba(0,0,0,0.1)';
            });
        });
        
        // Add click to expand functionality for mobile
        themeCards.forEach(card => {
            const expectedSection = card.querySelector('.theme-expected');
            const toggleBtn = document.createElement('button');
            toggleBtn.className = 'btn btn-sm btn-outline-success mt-3 d-md-none';
            toggleBtn.innerHTML = '<i class="fas fa-chevron-down me-1"></i> Show Expected Papers';
            toggleBtn.type = 'button';
            
            expectedSection.style.display = 'block'; // Always show on desktop
            
            card.querySelector('.card-body').appendChild(toggleBtn);
            
            toggleBtn.addEventListener('click', function() {
                if (expectedSection.style.display === 'none') {
                    expectedSection.style.display = 'block';
                    this.innerHTML = '<i class="fas fa-chevron-up me-1"></i> Hide Expected Papers';
                } else {
                    expectedSection.style.display = 'none';
                    this.innerHTML = '<i class="fas fa-chevron-down me-1"></i> Show Expected Papers';
                }
            });
        });
        
        // Filter functionality for themes (optional enhancement)
        const filterContainer = document.createElement('div');
        filterContainer.className = 'mb-4';
        filterContainer.innerHTML = `
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-filter me-2"></i>Filter Themes
                    </h5>
                    <div class="row g-2">
                        <div class="col-md-3">
                            <select class="form-select" id="themeCategory">
                                <option value="all">All Categories</option>
                                <option value="crop">Crop-related</option>
                                <option value="livestock">Livestock-related</option>
                                <option value="tech">Technology & Systems</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="themeSearch" placeholder="Search themes by keyword...">
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-success w-100" id="resetFilters">
                                <i class="fas fa-redo me-1"></i> Reset Filters
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        document.querySelector('#subThemesGrid').parentNode.insertBefore(filterContainer, document.querySelector('#subThemesGrid'));
        
        // Theme categories mapping
        const themeCategories = {
            1: 'crop', 2: 'crop', 3: 'crop', 4: 'crop', 5: 'crop', 6: 'tech',
            7: 'tech', 8: 'crop', 9: 'livestock', 10: 'livestock', 11: 'livestock',
            12: 'tech', 13: 'tech', 14: 'tech', 15: 'tech', 16: 'tech', 17: 'tech'
        };
        
        // Filter implementation
        const themeSearch = document.getElementById('themeSearch');
        const themeCategory = document.getElementById('themeCategory');
        const resetFilters = document.getElementById('resetFilters');
        
        function filterThemes() {
            const searchTerm = themeSearch.value.toLowerCase();
            const category = themeCategory.value;
            
            themeCards.forEach((card, index) => {
                const themeNumber = index + 1;
                const title = card.querySelector('.card-title').textContent.toLowerCase();
                const description = card.querySelector('.card-text').textContent.toLowerCase();
                const themeCat = themeCategories[themeNumber];
                
                const matchesSearch = searchTerm === '' || 
                    title.includes(searchTerm) || 
                    description.includes(searchTerm);
                
                const matchesCategory = category === 'all' || themeCat === category;
                
                if (matchesSearch && matchesCategory) {
                    card.parentElement.style.display = 'block';
                } else {
                    card.parentElement.style.display = 'none';
                }
            });
        }
        
        themeSearch.addEventListener('input', filterThemes);
        themeCategory.addEventListener('change', filterThemes);
        
        resetFilters.addEventListener('click', function() {
            themeSearch.value = '';
            themeCategory.value = 'all';
            filterThemes();
        });
    });
    </script>

    <style>
    /* Custom Styles for Themes Page */
    .hover-shadow {
        transition: all 0.3s ease;
    }

    .theme-card {
        border-top: 4px solid transparent;
        transition: all 0.3s ease;
    }

    .theme-card:hover {
        border-top-color: var(--kalro-green);
    }

    .theme-number {
        transition: all 0.3s ease;
    }

    .theme-card:hover .theme-number {
        transform: scale(1.1);
        box-shadow: 0 0 15px rgba(25,135,84,0.3);
    }

    .stat-card {
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(25,135,84,0.15);
    }

    .stat-icon {
        color: var(--kalro-green);
    }

    .theme-expected {
        border-left: 3px solid var(--kalro-green);
    }

    /* Animation for cards */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .theme-card {
        animation: fadeInUp 0.5s ease forwards;
        opacity: 0;
    }

    /* Stagger the animation */
    .theme-card:nth-child(1) { animation-delay: 0.1s; }
    .theme-card:nth-child(2) { animation-delay: 0.2s; }
    .theme-card:nth-child(3) { animation-delay: 0.3s; }
    .theme-card:nth-child(4) { animation-delay: 0.4s; }
    .theme-card:nth-child(5) { animation-delay: 0.5s; }
    .theme-card:nth-child(6) { animation-delay: 0.6s; }
    .theme-card:nth-child(7) { animation-delay: 0.7s; }
    .theme-card:nth-child(8) { animation-delay: 0.8s; }
    .theme-card:nth-child(9) { animation-delay: 0.9s; }
    .theme-card:nth-child(10) { animation-delay: 1.0s; }
    .theme-card:nth-child(11) { animation-delay: 1.1s; }
    .theme-card:nth-child(12) { animation-delay: 1.2s; }
    .theme-card:nth-child(13) { animation-delay: 1.3s; }
    .theme-card:nth-child(14) { animation-delay: 1.4s; }
    .theme-card:nth-child(15) { animation-delay: 1.5s; }
    .theme-card:nth-child(16) { animation-delay: 1.6s; }
    .theme-card:nth-child(17) { animation-delay: 1.7s; }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .theme-expected {
            display: none;
        }
        
        .theme-card .card-title {
            font-size: 1rem;
        }
        
        .stat-card {
            padding: 1.5rem;
        }
        
        .stat-number {
            font-size: 2.5rem;
        }
    }

    /* Print styles */
    @media print {
        .theme-card {
            break-inside: avoid;
            box-shadow: none;
            border: 1px solid #ddd;
        }
        
        .btn, .alert, .theme-stats {
            display: none !important;
        }
    }
    </style>
    
@endsection