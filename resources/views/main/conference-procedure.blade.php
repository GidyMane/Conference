@extends('layouts.header')

@section('title')
    Conference Procedure
@endsection

@section('content')

    <!-- Page Header -->
    <section class="page-header bg-success text-white py-5">
        <div class="container text-center">
            <h1 class="display-5 fw-bold mb-2">
                <i class="fas fa-clipboard-list me-2"></i>Conference Procedure
            </h1>
            <p class="lead mb-3">Paper Submission & Participation Guidelines</p>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item">
                        <a href="/" class="text-white text-decoration-none opacity-75">Home</a>
                    </li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Conference Procedure</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Main Content -->
    <section class="conference-procedure py-5">
        <div class="container">

            <!-- Intro -->
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto text-center">
                    <div class="p-4 rounded shadow-sm bg-light">
                        <i class="fas fa-file-contract fa-3x text-success mb-3"></i>
                        <h2 class="h4 fw-bold mb-2">Conference Paper Submission & Participation Procedure</h2>
                        <p class="mb-0">Follow these clear guidelines to successfully submit your paper and participate in the conference.</p>
                    </div>
                </div>
            </div>

            <!-- Paper Submission Process -->
            <div class="row mb-4">
                <div class="col text-center">
                    <h2 class="fw-bold mb-2">Paper Submission Process</h2>
                    <p class="text-muted">Three simple steps to submit your research paper</p>
                </div>
            </div>

            <!-- Steps -->
            <div class="row g-4 mb-5">
                <!-- Step 1 -->
                <div class="col-lg-4">
                    <div class="h-100 p-4 rounded shadow-sm border-top border-4 border-success">
                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center mb-3" style="width:50px;height:50px;">
                            <span class="fw-bold">1</span>
                        </div>
                        <h3 class="h5 fw-bold text-success">Abstract Acceptance</h3>
                        <p>Authors must first receive an abstract acceptance email.</p>
                        <div class="alert alert-info py-2 mb-0 small">
                            <i class="fas fa-info-circle me-1"></i>
                            Check both Inbox and Spam folder
                        </div>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="col-lg-4">
                    <div class="h-100 p-4 rounded shadow-sm border-top border-4 border-success">
                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center mb-3" style="width:50px;height:50px;">
                            <span class="fw-bold">2</span>
                        </div>
                        <h3 class="h5 fw-bold text-success">Full Paper Upload</h3>
                        <p>Upload the full paper following prescribed guidelines.</p>
                        <div class="alert alert-warning py-2 mb-0 small">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            Late submissions will not be accepted
                        </div>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="col-lg-4">
                    <div class="h-100 p-4 rounded shadow-sm border-top border-4 border-success">
                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center mb-3" style="width:50px;height:50px;">
                            <span class="fw-bold">3</span>
                        </div>
                        <h3 class="h5 fw-bold text-success">Review & Acceptance</h3>
                        <p>Papers undergo pre-screening and peer review.</p>
                        <div class="alert alert-success py-2 mb-0 small">
                            <i class="fas fa-check-circle me-1"></i>
                            Successful authors receive confirmation
                        </div>
                    </div>
                </div>
            </div>

            <!-- Paper Requirements -->
            <div class="row mb-4">
                <div class="col text-center">
                    <h2 class="fw-bold mb-2">Paper Requirements</h2>
                    <p class="text-muted">Formatting and submission guidelines</p>
                </div>
            </div>

            <div class="row g-4 mb-5">
                <!-- Format Specs -->
                <div class="col-lg-6">
                    <div class="h-100 p-4 rounded shadow-sm bg-light">
                        <h3 class="h5 fw-bold text-success mb-3">
                            <i class="fas fa-file-alt me-2"></i>Format Specifications
                        </h3>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="p-3 border rounded h-100">
                                    <i class="fas fa-font text-success mb-1"></i>
                                    <strong class="d-block">Word Limit</strong>
                                    <small>Maximum 3,000 words</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 border rounded h-100">
                                    <i class="fas fa-language text-success mb-1"></i>
                                    <strong class="d-block">Language</strong>
                                    <small>British English</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 border rounded h-100">
                                    <i class="fas fa-file-word text-success mb-1"></i>
                                    <strong class="d-block">File Format</strong>
                                    <small>MS Word (2003–2016)</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 border rounded h-100">
                                    <i class="fas fa-ruler-combined text-success mb-1"></i>
                                    <strong class="d-block">Layout</strong>
                                    <small>A4, double-spaced</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Paper Structure -->
                <div class="col-lg-6">
                    <div class="h-100 p-4 rounded shadow-sm bg-light">
                        <h3 class="h5 fw-bold text-success mb-3">
                            <i class="fas fa-list-ol me-2"></i>Paper Structure
                        </h3>

                        <ol class="list-group list-group-numbered mb-3">
                            <li class="list-group-item">Abstract</li>
                            <li class="list-group-item">Introduction</li>
                            <li class="list-group-item">Methods</li>
                            <li class="list-group-item">Results</li>
                            <li class="list-group-item">Discussion</li>
                            <li class="list-group-item">Conclusion</li>
                            <li class="list-group-item">Recommendations</li>
                            <li class="list-group-item">Acknowledgment</li>
                            <li class="list-group-item">References</li>
                        </ol>

                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Font: Times New Roman, size 12
                        </small>
                    </div>
                </div>
            </div>

            <!-- Publication & Posters -->
            <div class="row g-4 mb-5">
                <div class="col-lg-6">
                    <div class="h-100 p-4 rounded shadow-sm bg-light">
                        <i class="fas fa-book fa-2x text-success mb-2"></i>
                        <h3 class="h5 fw-bold text-success">Publication</h3>
                        <p>Accepted papers will appear in the <strong>Conference Proceedings</strong>.</p>
                        <p class="mb-0">Selected papers will be published in <strong>EAAFJ (AJOL)</strong>.</p>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="h-100 p-4 rounded shadow-sm bg-light">
                        <i class="fas fa-image fa-2x text-success mb-2"></i>
                        <h3 class="h5 fw-bold text-success">Poster Presentations</h3>
                        <p>Optional poster session available for authors.</p>
                        <p class="mb-1"><strong>Size:</strong> A0 format</p>
                        <p class="mb-0"><strong>Quality:</strong> Clear, visual, and well-structured</p>
                    </div>
                </div>
            </div>

            <!-- Financial Info -->
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto">
                    <div class="p-4 rounded shadow-sm border border-warning">
                        <h3 class="h5 fw-bold text-success mb-2">
                            <i class="fas fa-money-bill-wave me-2 text-warning"></i>Financial Information
                        </h3>
                        <p class="mb-2">Delegates cover their own registration and participation costs including:</p>
                        <span class="badge bg-secondary me-1">Registration</span>
                        <span class="badge bg-secondary me-1">Accommodation</span>
                        <span class="badge bg-secondary me-1">Travel</span>
                        <span class="badge bg-secondary">Personal Costs</span>
                    </div>
                </div>
            </div>

            <!-- CTA -->
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="text-center p-5 rounded bg-success text-white">
                        <i class="fas fa-smile fa-3x mb-3"></i>
                        <h2 class="fw-bold mb-2">We Look Forward to Your Valuable Contributions!</h2>
                        <p class="lead mb-4">Join us in making the KALRO SEPD Conference a success.</p>

                        <div class="d-flex justify-content-center flex-wrap gap-3">
                            <a href="pages/submit_abstract.php" class="btn btn-light btn-lg">
                                <i class="fas fa-paper-plane me-1"></i>Submit Abstract
                            </a>
                        
                            <a href="/contact" class="btn btn-warning btn-lg">
                                <i class="fas fa-question-circle me-1"></i>Ask Questions
                            </a>
                        </div>

                        <p class="mt-3 small opacity-75">
                            <i class="fas fa-clock me-1"></i>Submission deadline approaching soon!
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection