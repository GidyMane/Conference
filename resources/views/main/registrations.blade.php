@extends('layouts.header')

@section('title')
    Conference Registration
@endsection

@section('content')
<div class="registration-wrapper">
    <!-- Hero Section -->
    <div class="registration-hero">
        <div class="container">
            <div class="hero-content text-center">
                <h1 class="display-4 fw-bold mb-3">KALRO Conference Registration</h1>
                <p class="lead">Join us for an exceptional agricultural research experience</p>
            </div>
        </div>
    </div>

    <!-- Registration Form -->
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <!-- Alert Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- ============================================================
                     STEP 0: REGISTRATION MODE SELECTOR
                ============================================================ -->
                <div id="modeSelector" class="mode-selector-card">
                    <div class="mode-selector-header text-center mb-5">
                        <div class="mode-selector-badge">Get Started</div>
                        <h3 class="fw-bold mb-2">How would you like to register?</h3>
                        <p class="text-muted mb-0">Choose an option below to begin your registration</p>
                    </div>
                    <div class="mode-options">

                        <!-- SELF CARD -->
                        <label class="mode-card" id="modeSelfCard">
                            <input type="radio" name="registrationMode" value="self" id="modeSelf">
                            <div class="mode-card-content">
                                <div class="mode-card-illustration self-illustration">
                                    <svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="40" cy="28" r="14" fill="currentColor" opacity=".15"/>
                                        <circle cx="40" cy="27" r="9" fill="currentColor" opacity=".4"/>
                                        <circle cx="40" cy="27" r="6" fill="currentColor"/>
                                        <path d="M16 64c0-13.255 10.745-24 24-24s24 10.745 24 24" stroke="currentColor" stroke-width="4" stroke-linecap="round" fill="none" opacity=".4"/>
                                        <path d="M22 64c0-9.941 8.059-18 18-18s18 8.059 18 18" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" fill="none"/>
                                    </svg>
                                </div>
                                <div class="mode-card-text">
                                    <h5>Register Myself</h5>
                                    <p>I am attending and will complete my own registration</p>
                                    <ul class="mode-features">
                                        <li>Personal details &amp; preferences</li>
                                        <li>Physical or virtual attendance</li>
                                        <li>Single payment</li>
                                    </ul>
                                </div>
                                <div class="mode-card-selector">
                                    <div class="mode-radio-dot"></div>
                                </div>
                            </div>
                        </label>

                        <!-- GROUP CARD -->
                        <label class="mode-card" id="modeGroupCard">
                            <input type="radio" name="registrationMode" value="group" id="modeGroup">
                            <div class="mode-card-content">
                                <div class="mode-card-illustration group-illustration">
                                    <svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="22" cy="30" r="8" fill="currentColor" opacity=".3"/>
                                        <path d="M6 64c0-8.837 7.163-16 16-16" stroke="currentColor" stroke-width="3" stroke-linecap="round" fill="none" opacity=".35"/>
                                        <circle cx="58" cy="30" r="8" fill="currentColor" opacity=".3"/>
                                        <path d="M74 64c0-8.837-7.163-16-16-16" stroke="currentColor" stroke-width="3" stroke-linecap="round" fill="none" opacity=".35"/>
                                        <circle cx="40" cy="26" r="10" fill="currentColor" opacity=".45"/>
                                        <circle cx="40" cy="26" r="7" fill="currentColor"/>
                                        <path d="M18 64c0-12.15 9.85-22 22-22s22 9.85 22 22" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" fill="none"/>
                                    </svg>
                                </div>
                                <div class="mode-card-text">
                                    <h5>Register a Group</h5>
                                    <p>I am registering multiple people with one central payment</p>
                                    <ul class="mode-features">
                                        <li>Add 2&ndash;50 participants</li>
                                        <li>Mix of categories &amp; attendance types</li>
                                        <li>Auto-calculated total fee</li>
                                    </ul>
                                </div>
                                <div class="mode-card-selector">
                                    <div class="mode-radio-dot"></div>
                                </div>
                            </div>
                        </label>

                    </div>
                    <div class="text-center mt-5">
                        <button type="button" id="modeConfirmBtn" class="btn btn-primary btn-lg mode-confirm-btn" disabled>
                            Continue &rarr;
                        </button>
                        <p class="text-muted mt-3 small mb-0">You can go back and change this at any time</p>
                    </div>
                </div>

                <!-- ============================================================
                     SELF REGISTRATION FORM
                ============================================================ -->
                <div id="selfRegistrationForm" style="display:none;">
                    <!-- Progress Indicator -->
                    <div class="progress-steps mb-5">
                        <div class="step active" data-step="1">
                            <div class="step-number">1</div>
                            <div class="step-label">Personal Details</div>
                        </div>
                        <div class="step" data-step="2">
                            <div class="step-number">2</div>
                            <div class="step-label">Registration</div>
                        </div>
                        <div class="step" data-step="3">
                            <div class="step-number">3</div>
                            <div class="step-label">Payment</div>
                        </div>
                    </div>

                    <div class="form-card">
                        <form id="registrationForm" action="{{ route('conference.register') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="registrationMode" value="self">

                            <!-- Step 1: Personal Details -->
                            <div class="form-section active" data-section="1">
                                <div class="section-header">
                                    <h3 class="section-title">
                                        <i class="bi bi-person-circle me-2"></i>Personal Information
                                    </h3>
                                    <p class="section-subtitle">Please provide your personal details</p>
                                </div>

                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label for="firstName" class="form-label">First Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-lg" id="firstName" name="firstName"
                                               value="{{ old('firstName') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="lastName" class="form-label">Last Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-lg" id="lastName" name="lastName"
                                               value="{{ old('lastName') }}" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control form-control-lg" id="email" name="email"
                                               placeholder="your.email@example.com" value="{{ old('email') }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="phonePrefix" class="form-label">Phone Code <span class="text-danger">*</span></label>
                                        <select class="form-select form-select-lg" id="phonePrefix" name="phonePrefix" required>
                                            <option value="">Select Code</option>
                                            @include('includes.prefixes')
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="phoneNumber" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                        <input type="tel" class="form-control form-control-lg" id="phoneNumber" name="phoneNumber"
                                               placeholder="e.g., 712345678" value="{{ old('phoneNumber') }}" required>
                                        <small class="text-muted">Format: 7XX XXX XXX</small>
                                    </div>
                                    <div class="col-12">
                                        <label for="institution" class="form-label">Institution/Organization <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-lg" id="institution" name="institution"
                                               placeholder="Your institution or company name" value="{{ old('institution') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="country" class="form-label">Country <span class="text-danger">*</span></label>
                                        <select class="form-select form-select-lg" id="country" name="country" required>
                                            <option value="">Select Your Country</option>
                                            @include('includes.countrylist')
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="nationality" class="form-label">Nationality <span class="text-danger">*</span></label>
                                        <select class="form-select form-select-lg" id="nationality" name="nationality" required>
                                            <option value="">Select Nationality</option>
                                            <option value="east_african" {{ old('nationality') == 'east_african' ? 'selected' : '' }}>East African</option>
                                            <option value="non_east_african" {{ old('nationality') == 'non_east_african' ? 'selected' : '' }}>Non-East African</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="section-footer">
                                    <button type="button" class="btn btn-outline-secondary btn-lg" id="backToModeFromStep1">
                                        <i class="bi bi-arrow-left me-2"></i> Back
                                    </button>
                                    <button type="button" class="btn btn-primary btn-lg next-step">
                                        Continue to Registration Details <i class="bi bi-arrow-right ms-2"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Step 2: Registration Details -->
                            <div class="form-section" data-section="2">
                                <div class="section-header">
                                    <h3 class="section-title">
                                        <i class="bi bi-calendar-check me-2"></i>Registration Details
                                    </h3>
                                    <p class="section-subtitle">Choose your attendance options and category</p>
                                </div>

                                <div class="row g-4">
                                    <!-- Attendance Platform -->
                                    <div class="col-12">
                                        <label class="form-label fw-bold mb-3">How would you like to attend? <span class="text-danger">*</span></label>
                                        <div class="attendance-options">
                                            <label class="attendance-card">
                                                <input type="radio" name="platform" value="physical" checked>
                                                <div class="card-content">
                                                    <div class="icon-wrapper"><i class="bi bi-building"></i></div>
                                                    <div class="text-content">
                                                        <h5>Physical Attendance</h5>
                                                        <p>Join us in person at the venue</p>
                                                    </div>
                                                    <div class="check-indicator"><i class="bi bi-check-circle-fill"></i></div>
                                                </div>
                                            </label>
                                            <label class="attendance-card">
                                                <input type="radio" name="platform" value="virtual">
                                                <div class="card-content">
                                                    <div class="icon-wrapper"><i class="bi bi-laptop"></i></div>
                                                    <div class="text-content">
                                                        <h5>Virtual Attendance</h5>
                                                        <p>Participate online via video conference</p>
                                                    </div>
                                                    <div class="check-indicator"><i class="bi bi-check-circle-fill"></i></div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Registration Category -->
                                    <div class="col-12">
                                        <label for="category" class="form-label fw-bold">Registration Category <span class="text-danger">*</span></label>
                                        <select class="form-select form-select-lg" id="category" name="category" required>
                                            <option value="">Select Your Category</option>
                                            <option value="student" {{ old('category') == 'student' ? 'selected' : '' }}>Student (Valid Student ID Required)</option>
                                            <option value="professional" {{ old('category') == 'professional' ? 'selected' : '' }}>Professional/Researcher</option>
                                            <option value="kalro_staff" {{ old('category') == 'kalro_staff' ? 'selected' : '' }}>Organizing Team</option>
                                        </select>
                                    </div>

                                    <!-- Student ID Upload -->
                                    <div class="col-12" id="studentIdUpload" style="display: none;">
                                        <div class="upload-section">
                                            <label class="form-label fw-bold">Student ID Proof <span class="text-danger">*</span></label>
                                            <p class="text-muted small mb-3">Please upload a clear copy of your valid student ID card</p>
                                            <div class="upload-area" id="studentIdUploadArea">
                                                <input type="file" class="file-input" id="studentId" name="studentId" accept="image/*,.pdf">
                                                <div class="upload-placeholder">
                                                    <i class="bi bi-cloud-upload"></i>
                                                    <p class="mb-0"><strong>Click to upload</strong> or drag and drop</p>
                                                    <small class="text-muted">PNG, JPG, PDF (Max 5MB)</small>
                                                </div>
                                                <div class="file-preview" style="display: none;">
                                                    <i class="bi bi-file-earmark-check-fill"></i>
                                                    <span class="file-name"></span>
                                                    <button type="button" class="btn-remove"><i class="bi bi-x-lg"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Paper Submission Reference -->
                                    <div class="col-12">
                                        <div class="paper-ref-section">
                                            <div class="paper-ref-header">
                                                <i class="bi bi-file-earmark-text"></i>
                                                <div>
                                                    <h6 class="mb-0 fw-bold">Full Paper Submission</h6>
                                                    <small class="text-muted">Only fill this if you have submitted a full paper for presentation</small>
                                                </div>
                                            </div>
                                            <div class="paper-ref-body">
                                                <label class="form-label fw-semibold">Paper Reference Number / Submission Code <span class="text-muted fw-normal">(optional)</span></label>
                                                <input type="text" class="form-control form-control-lg" id="paperRefCode" name="paperRefCode"
                                                       placeholder="e.g., KALRO-2026-0042 or your submission code"
                                                       value="{{ old('paperRefCode') }}">
                                                <small class="text-muted mt-1 d-block">
                                                    <i class="bi bi-info-circle me-1"></i>
                                                    This is the reference code you received upon submitting your full paper through the conference paper submission system.
                                                </small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Early Bird Banner -->
                                    <div class="col-12" id="earlyBirdBannerWrap">
                                        <div id="earlyBirdBanner"></div>
                                    </div>

                                    <!-- Registration Fee Display -->
                                    <div class="col-12">
                                        <div class="fee-calculator">
                                            <div class="fee-header">
                                                <i class="bi bi-calculator"></i>
                                                <span>Registration Fee Calculator</span>
                                            </div>
                                            <div class="fee-body">
                                                <label for="fee" class="form-label fw-bold">Your Registration Fee <span class="text-danger">*</span></label>
                                                <select class="form-select form-select-lg" id="fee" name="fee" required>
                                                    <option value="">Please complete the fields above</option>
                                                </select>
                                                <input type="hidden" id="feeCurrency" name="feeCurrency">
                                                <p class="fee-note mt-2 mb-0">
                                                    <i class="bi bi-info-circle"></i>
                                                    <small>Fee is calculated based on your nationality, attendance type, and category. Early bird rates apply until <strong>10 April 2026</strong>.</small>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="section-footer">
                                    <button type="button" class="btn btn-outline-secondary btn-lg prev-step">
                                        <i class="bi bi-arrow-left me-2"></i> Back
                                    </button>
                                    <button type="button" class="btn btn-primary btn-lg next-step">
                                        Continue to Payment <i class="bi bi-arrow-right ms-2"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Step 3: Payment -->
                            <div class="form-section" data-section="3">
                                <div class="section-header">
                                    <h3 class="section-title">
                                        <i class="bi bi-credit-card me-2"></i>Payment Information
                                    </h3>
                                    <p class="section-subtitle">Complete your payment to finalize registration</p>
                                </div>

                                <div class="row g-4">
                                    <!-- Payment Method Selection -->
                                    <div class="col-12">
                                        <label class="form-label fw-bold mb-3">Select Payment Method <span class="text-danger">*</span></label>
                                        <div class="payment-methods">
                                            <label class="payment-card">
                                                <input type="radio" name="paymentMethod" value="bank" checked>
                                                <div class="card-content">
                                                    <div class="icon-wrapper"><i class="bi bi-bank"></i></div>
                                                    <div class="text-content">
                                                        <h5>Bank Transfer</h5>
                                                        <p>Direct bank deposit</p>
                                                    </div>
                                                    <div class="check-indicator"><i class="bi bi-check-circle-fill"></i></div>
                                                </div>
                                            </label>
                                            <label class="payment-card">
                                                <input type="radio" name="paymentMethod" value="mpesa">
                                                <div class="card-content">
                                                    <div class="icon-wrapper"><i class="bi bi-phone"></i></div>
                                                    <div class="text-content">
                                                        <h5>M-Pesa</h5>
                                                        <p>Mobile money payment</p>
                                                    </div>
                                                    <div class="check-indicator"><i class="bi bi-check-circle-fill"></i></div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Payment Details Cards -->
                                    <div class="col-12">
                                        <div id="bankDetails" class="payment-details-card">
                                            <div class="details-header">
                                                <i class="bi bi-bank2"></i>
                                                <h5>Bank Transfer Details</h5>
                                            </div>
                                            <div class="details-body">
                                                <div class="detail-item">
                                                    <span class="label">Account Name:</span>
                                                    <span class="value">KALRO EAAPP</span>
                                                </div>
                                                <div class="detail-item highlight">
                                                    <span class="label">Account Number:</span>
                                                    <span class="value">1116139030</span>
                                                </div>
                                                <div class="detail-item">
                                                    <span class="label">Bank Name:</span>
                                                    <span class="value">KCB Ltd</span>
                                                </div>
                                                <div class="detail-item">
                                                    <span class="label">Bank Branch:</span>
                                                    <span class="value">K.I.C.C</span>
                                                </div>
                                                <div class="detail-item">
                                                    <span class="label">Bank Code:</span>
                                                    <span class="value">01104</span>
                                                </div>
                                                <div class="detail-item">
                                                    <span class="label">Swift Code:</span>
                                                    <span class="value">KCBLKENX</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="mpesaDetails" class="payment-details-card" style="display: none;">
                                            <div class="details-header">
                                                <i class="bi bi-phone-fill"></i>
                                                <h5>M-Pesa Payment Details</h5>
                                            </div>
                                            <div class="details-body">
                                                <div class="detail-item highlight">
                                                    <span class="label">Paybill Number:</span>
                                                    <span class="value">522522</span>
                                                </div>
                                                <div class="detail-item highlight">
                                                    <span class="label">Account Number:</span>
                                                    <span class="value">1116139030</span>
                                                </div>
                                                <div class="payment-steps">
                                                    <p class="mb-2"><strong>Payment Steps:</strong></p>
                                                    <ol class="mb-0">
                                                        <li>Go to M-Pesa menu</li>
                                                        <li>Select Lipa na M-Pesa</li>
                                                        <li>Select Pay Bill</li>
                                                        <li>Enter Business Number: <strong>522522</strong></li>
                                                        <li>Enter Account Number: <strong>1116139030</strong></li>
                                                        <li>Enter the amount</li>
                                                        <li>Enter your M-Pesa PIN</li>
                                                    </ol>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Transaction Details -->
                                    <div class="col-12">
                                        <label for="transactionId" class="form-label fw-bold">Transaction/Reference ID <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-lg" id="transactionId" name="transactionId"
                                               placeholder="Enter your transaction reference number" value="{{ old('transactionId') }}" required>
                                        <small class="text-muted">This is the confirmation code you received after payment</small>
                                    </div>

                                    <!-- Payment Proof Upload -->
                                    <div class="col-12">
                                        <div class="upload-section">
                                            <label class="form-label fw-bold">Payment Proof <span class="text-danger">*</span></label>
                                            <p class="text-muted small mb-3">Upload a screenshot or receipt of your payment</p>
                                            <div class="upload-area" id="paymentProofUploadArea">
                                                <input type="file" class="file-input" id="paymentProof" name="paymentProof" accept="image/*,.pdf" required>
                                                <div class="upload-placeholder">
                                                    <i class="bi bi-receipt"></i>
                                                    <p class="mb-0"><strong>Click to upload</strong> or drag and drop</p>
                                                    <small class="text-muted">PNG, JPG, PDF (Max 5MB)</small>
                                                </div>
                                                <div class="file-preview" style="display: none;">
                                                    <i class="bi bi-file-earmark-check-fill"></i>
                                                    <span class="file-name"></span>
                                                    <button type="button" class="btn-remove"><i class="bi bi-x-lg"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Terms & Submit -->
                                <div class="terms-section">
                                    <div class="custom-checkbox">
                                        <input type="checkbox" id="terms" name="terms" required>
                                        <label for="terms">
                                            I agree to the
                                            <a href="{{ route('terms', ['from' => route('conference.register.form')]) }}" target="_blank">terms and conditions</a>
                                            <span class="text-danger">*</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="section-footer">
                                    <button type="button" class="btn btn-outline-secondary btn-lg prev-step">
                                        <i class="bi bi-arrow-left me-2"></i> Back
                                    </button>
                                    <button type="submit" class="btn btn-success btn-lg submit-btn">
                                        <i class="bi bi-check-circle me-2"></i> Complete Registration
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!-- end #selfRegistrationForm -->


                <!-- ============================================================
                     GROUP REGISTRATION FORM
                ============================================================ -->
                <div id="groupRegistrationForm" style="display:none;">

                    <!-- Progress Indicator -->
                    <div class="progress-steps mb-5">
                        <div class="step active" data-step="g1">
                            <div class="step-number">1</div>
                            <div class="step-label">Coordinator</div>
                        </div>
                        <div class="step" data-step="g2">
                            <div class="step-number">2</div>
                            <div class="step-label">Members</div>
                        </div>
                        <div class="step" data-step="g3">
                            <div class="step-number">3</div>
                            <div class="step-label">Summary & Pay</div>
                        </div>
                    </div>

                    <form id="groupForm" action="#" method="POST" enctype="multipart/form-data">
                        {{-- TODO: change action to {{ route('conference.register.group') }} once route is defined --}}
                        @csrf
                        <input type="hidden" name="registrationMode" value="group">

                        <!-- GROUP STEP 1: Coordinator Details -->
                        <div class="form-card group-section active" data-gsection="1">
                            <div class="section-header">
                                <h3 class="section-title">
                                    <i class="bi bi-person-badge me-2"></i>Coordinator / Paying Contact
                                </h3>
                                <p class="section-subtitle">Details of the person making the central payment for the group</p>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label">First Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg" name="coordinatorFirstName" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg" name="coordinatorLastName" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control form-control-lg" name="coordinatorEmail"
                                           placeholder="coordinator@example.com" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Phone Code <span class="text-danger">*</span></label>
                                    <select class="form-select form-select-lg" name="coordinatorPhonePrefix" required>
                                        <option value="">Select Code</option>
                                        @include('includes.prefixes')
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control form-control-lg" name="coordinatorPhoneNumber"
                                           placeholder="e.g., 712345678" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Institution/Organization <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg" name="coordinatorInstitution"
                                           placeholder="Institution or company name" required>
                                </div>

                                <!-- How many people -->
                                <div class="col-12">
                                    <div class="group-count-selector">
                                        <label class="form-label fw-bold">How many people are you registering? <span class="text-danger">*</span></label>
                                        <p class="text-muted small mb-3">Include yourself if you are also attending. Minimum 2, maximum 50.</p>
                                        <div class="group-count-control">
                                            <button type="button" class="count-btn" id="groupCountMinus">&#8722;</button>
                                            <div class="count-display">
                                                <span id="groupCountDisplay">2</span>
                                                <small>people</small>
                                            </div>
                                            <button type="button" class="count-btn" id="groupCountPlus">&#43;</button>
                                        </div>
                                        <input type="hidden" name="groupCount" id="groupCount" value="2">
                                    </div>
                                </div>
                            </div>

                            <div class="section-footer">
                                <button type="button" class="btn btn-outline-secondary btn-lg" id="backToModeFromGroup">
                                    <i class="bi bi-arrow-left me-2"></i> Back
                                </button>
                                <button type="button" class="btn btn-primary btn-lg" id="groupStep1Next">
                                    Set Up Members <i class="bi bi-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- GROUP STEP 2: Member Details -->
                        <div class="form-card group-section" data-gsection="2" style="display:none;">
                            <div class="section-header">
                                <h3 class="section-title">
                                    <i class="bi bi-people me-2"></i>Group Members
                                </h3>
                                <p class="section-subtitle">Enter details for each person in the group. Fields marked with * are required.</p>
                            </div>

                            <!-- Early Bird Banner for Group -->
                            <div id="groupEarlyBirdBanner" class="mb-4"></div>

                            <div id="groupMembersContainer">
                                <!-- Dynamically generated member cards go here -->
                            </div>

                            <!-- Group Fee Summary -->
                            <div class="group-fee-summary mt-4" id="groupFeeSummary">
                                <div class="fee-summary-header">
                                    <i class="bi bi-receipt-cutoff"></i>
                                    <span>Group Registration Fee Summary</span>
                                </div>
                                <div class="fee-summary-body" id="groupFeeSummaryBody">
                                    <p class="text-muted text-center py-3">
                                        <i class="bi bi-info-circle me-2"></i>
                                        Fill in member details above to see the fee breakdown and total.
                                    </p>
                                </div>
                                <div class="fee-summary-total" id="groupFeeTotal" style="display:none;">
                                    <div class="total-row" id="totalKES" style="display:none;">
                                        <span class="total-label">Total (KES)</span>
                                        <span class="total-amount" id="totalAmountKES">KES 0</span>
                                    </div>
                                    <div class="total-row" id="totalUSD" style="display:none;">
                                        <span class="total-label">Total (USD)</span>
                                        <span class="total-amount" id="totalAmountUSD">USD 0</span>
                                    </div>
                                    <p class="total-note">
                                        <i class="bi bi-info-circle"></i>
                                        Please make one combined payment for the total amount shown above.
                                    </p>
                                </div>
                            </div>

                            <div class="section-footer mt-4">
                                <button type="button" class="btn btn-outline-secondary btn-lg" id="groupStep2Back">
                                    <i class="bi bi-arrow-left me-2"></i> Back
                                </button>
                                <button type="button" class="btn btn-primary btn-lg" id="groupStep2Next">
                                    Review & Pay <i class="bi bi-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- GROUP STEP 3: Summary & Payment -->
                        <div class="form-card group-section" data-gsection="3" style="display:none;">
                            <div class="section-header">
                                <h3 class="section-title">
                                    <i class="bi bi-credit-card me-2"></i>Summary & Payment
                                </h3>
                                <p class="section-subtitle">Review your group registration and complete the payment</p>
                            </div>

                            <!-- Registration Summary Table -->
                            <div class="group-summary-table-wrap mb-4">
                                <h6 class="fw-bold mb-3"><i class="bi bi-table me-2 text-success"></i>Registration Summary</h6>
                                <div class="table-responsive">
                                    <table class="table group-summary-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Category</th>
                                                <th>Attendance</th>
                                                <th>Presenter</th>
                                                <th>Paper Ref</th>
                                                <th>Fee</th>
                                            </tr>
                                        </thead>
                                        <tbody id="groupSummaryTableBody">
                                        </tbody>
                                        <tfoot id="groupSummaryTableFoot">
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <div class="row g-4">
                                <!-- Payment Method -->
                                <div class="col-12">
                                    <label class="form-label fw-bold mb-3">Select Payment Method <span class="text-danger">*</span></label>
                                    <div class="payment-methods">
                                        <label class="payment-card">
                                            <input type="radio" name="groupPaymentMethod" value="bank" checked>
                                            <div class="card-content">
                                                <div class="icon-wrapper"><i class="bi bi-bank"></i></div>
                                                <div class="text-content"><h5>Bank Transfer</h5><p>Direct bank deposit</p></div>
                                                <div class="check-indicator"><i class="bi bi-check-circle-fill"></i></div>
                                            </div>
                                        </label>
                                        <label class="payment-card">
                                            <input type="radio" name="groupPaymentMethod" value="mpesa">
                                            <div class="card-content">
                                                <div class="icon-wrapper"><i class="bi bi-phone"></i></div>
                                                <div class="text-content"><h5>M-Pesa</h5><p>Mobile money payment</p></div>
                                                <div class="check-indicator"><i class="bi bi-check-circle-fill"></i></div>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <!-- Bank Details -->
                                <div class="col-12">
                                    <div id="groupBankDetails" class="payment-details-card">
                                        <div class="details-header">
                                            <i class="bi bi-bank2"></i>
                                            <h5>Bank Transfer Details</h5>
                                        </div>
                                        <div class="details-body">
                                            <div class="detail-item">
                                                <span class="label">Account Name:</span>
                                                <span class="value">KALRO EAAPP</span>
                                            </div>
                                            <div class="detail-item highlight">
                                                <span class="label">Account Number:</span>
                                                <span class="value">1116139030</span>
                                            </div>
                                            <div class="detail-item">
                                                <span class="label">Bank Name:</span>
                                                <span class="value">KCB Ltd</span>
                                            </div>
                                            <div class="detail-item">
                                                <span class="label">Bank Branch:</span>
                                                <span class="value">K.I.C.C</span>
                                            </div>
                                            <div class="detail-item">
                                                <span class="label">Bank Code:</span>
                                                <span class="value">01104</span>
                                            </div>
                                            <div class="detail-item">
                                                <span class="label">Swift Code:</span>
                                                <span class="value">KCBLKENX</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="groupMpesaDetails" class="payment-details-card" style="display:none;">
                                        <div class="details-header">
                                            <i class="bi bi-phone-fill"></i>
                                            <h5>M-Pesa Payment Details</h5>
                                        </div>
                                        <div class="details-body">
                                            <div class="detail-item highlight">
                                                <span class="label">Paybill Number:</span>
                                                <span class="value">522522</span>
                                            </div>
                                            <div class="detail-item highlight">
                                                <span class="label">Account Number:</span>
                                                <span class="value">1116139030</span>
                                            </div>
                                            <div class="payment-steps">
                                                <p class="mb-2"><strong>Payment Steps:</strong></p>
                                                <ol class="mb-0">
                                                    <li>Go to M-Pesa menu</li>
                                                    <li>Select Lipa na M-Pesa</li>
                                                    <li>Select Pay Bill</li>
                                                    <li>Enter Business Number: <strong>522522</strong></li>
                                                    <li>Enter Account Number: <strong>1116139030</strong></li>
                                                    <li>Enter the <strong>total combined amount</strong> for all group members</li>
                                                    <li>Enter your M-Pesa PIN</li>
                                                </ol>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Transaction ID -->
                                <div class="col-12">
                                    <label class="form-label fw-bold">Transaction/Reference ID <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg" name="groupTransactionId"
                                           placeholder="Enter your transaction reference number" required>
                                    <small class="text-muted">Provide the single transaction reference covering the entire group payment</small>
                                </div>

                                <!-- Payment Proof Upload -->
                                <div class="col-12">
                                    <div class="upload-section">
                                        <label class="form-label fw-bold">Payment Proof <span class="text-danger">*</span></label>
                                        <p class="text-muted small mb-3">Upload a screenshot or receipt showing the full group payment amount</p>
                                        <div class="upload-area" id="groupPaymentProofUploadArea">
                                            <input type="file" class="file-input" id="groupPaymentProof" name="groupPaymentProof" accept="image/*,.pdf" required>
                                            <div class="upload-placeholder">
                                                <i class="bi bi-receipt"></i>
                                                <p class="mb-0"><strong>Click to upload</strong> or drag and drop</p>
                                                <small class="text-muted">PNG, JPG, PDF (Max 5MB)</small>
                                            </div>
                                            <div class="file-preview" style="display: none;">
                                                <i class="bi bi-file-earmark-check-fill"></i>
                                                <span class="file-name"></span>
                                                <button type="button" class="btn-remove"><i class="bi bi-x-lg"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Terms & Submit -->
                            <div class="terms-section">
                                <div class="custom-checkbox">
                                    <input type="checkbox" id="groupTerms" name="groupTerms" required>
                                    <label for="groupTerms">
                                        I agree to the
                                        <a href="{{ route('terms', ['from' => route('conference.register.form')]) }}" target="_blank">terms and conditions</a>
                                        on behalf of all group members
                                        <span class="text-danger">*</span>
                                    </label>
                                </div>
                            </div>

                            <div class="section-footer">
                                <button type="button" class="btn btn-outline-secondary btn-lg" id="groupStep3Back">
                                    <i class="bi bi-arrow-left me-2"></i> Back
                                </button>
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="bi bi-check-circle me-2"></i> Submit Group Registration
                                </button>
                            </div>
                        </div>
                    </form>
                </div><!-- end #groupRegistrationForm -->

            </div>
        </div>
    </div>
</div>

<style>
/* ============================================================
   KALRO GREEN THEME - COLOR VARIABLES
============================================================ */
:root {
    --kalro-primary: #1a5f3a;
    --kalro-secondary: #14532d;
    --kalro-light: #e6f4ec;
    --kalro-dark: #0d3d25;
    --kalro-accent: #1f7a4c;
    --kalro-gradient: linear-gradient(135deg, #1a5f3a 0%, #0d3d25 100%);
    --text-dark: #111827;
    --text-muted: #6b7280;
    --border-color: #e5e7eb;
    --bg-light: #f9fafb;
}

/* ============================================================
   GLOBAL
============================================================ */
.registration-wrapper {
    min-height: 100vh;
    background: linear-gradient(135deg, #f0f9f0 0%, #e8f5e9 100%);
}

/* ============================================================
   HERO
============================================================ */
.registration-hero {
    background: var(--kalro-gradient);
    padding: 4rem 0 5rem;
    color: white;
    margin-bottom: -3rem;
    clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%);
    box-shadow: 0 4px 20px rgba(45, 122, 62, 0.2);
}
.registration-hero h1 { font-weight: 700; letter-spacing: -1px; text-shadow: 2px 2px 4px rgba(0,0,0,.1); }
.registration-hero .lead { color: rgba(255,255,255,.95); font-size: 1.15rem; }

/* ============================================================
   MODE SELECTOR (Step 0)
============================================================ */
.mode-selector-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0,0,0,.08);
    padding: 3.5rem;
    margin-top: 2rem;
}
.mode-selector-badge {
    display: inline-block;
    background: var(--kalro-light);
    color: var(--kalro-primary);
    font-size: .75rem;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
    padding: .3rem .9rem;
    border-radius: 100px;
    margin-bottom: 1rem;
}
.mode-options {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}
.mode-card { display: block; cursor: pointer; }
.mode-card input[type="radio"] { position: absolute; opacity: 0; pointer-events: none; }
.mode-card-content {
    display: flex;
    flex-direction: row;
    align-items: flex-start;
    gap: 1.5rem;
    padding: 2rem;
    border: 2.5px solid var(--border-color);
    border-radius: 16px;
    transition: all 0.3s ease;
    position: relative;
    background: white;
    height: 100%;
}
.mode-card:hover .mode-card-content {
    border-color: var(--kalro-accent);
    box-shadow: 0 6px 24px rgba(26,95,58,.12);
    transform: translateY(-2px);
}
.mode-card input:checked ~ .mode-card-content {
    border-color: var(--kalro-primary);
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    box-shadow: 0 8px 32px rgba(26,95,58,.18);
    transform: translateY(-3px);
}
/* SVG illustration container */
.mode-card-illustration {
    flex-shrink: 0;
    width: 72px; height: 72px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    transition: all 0.3s ease;
}
.self-illustration  { background: #e6f4ec; color: var(--kalro-primary); }
.group-illustration { background: #e6f4ec; color: var(--kalro-primary); }
.mode-card-illustration svg { width: 48px; height: 48px; }
.mode-card input:checked ~ .mode-card-content .mode-card-illustration {
    background: var(--kalro-primary);
    color: white;
}
/* Text block */
.mode-card-text { flex: 1; }
.mode-card-text h5 { font-weight: 700; font-size: 1.1rem; color: var(--text-dark); margin: 0 0 .4rem 0; transition: color .3s; }
.mode-card-text p  { font-size: .875rem; color: var(--text-muted); margin: 0 0 .85rem 0; line-height: 1.5; transition: color .3s; }
.mode-card input:checked ~ .mode-card-content .mode-card-text h5 { color: var(--kalro-dark); }
.mode-features {
    list-style: none; padding: 0; margin: 0;
    display: flex; flex-direction: column; gap: .35rem;
}
.mode-features li {
    font-size: .78rem; color: var(--text-muted);
    padding-left: 1.1rem; position: relative;
    transition: color .3s;
}
.mode-features li::before {
    content: "✓";
    position: absolute; left: 0;
    color: var(--kalro-primary); font-weight: 700; font-size: .75rem;
}
.mode-card input:checked ~ .mode-card-content .mode-features li { color: #374151; }
.mode-card input:checked ~ .mode-card-content .mode-features li::before { color: var(--kalro-primary); }
/* Radio dot selector */
.mode-card-selector {
    flex-shrink: 0;
    width: 22px; height: 22px;
    border-radius: 50%;
    border: 2.5px solid var(--border-color);
    display: flex; align-items: center; justify-content: center;
    transition: all .3s ease;
    margin-top: .15rem;
    background: white;
}
.mode-radio-dot {
    width: 10px; height: 10px;
    border-radius: 50%;
    background: transparent;
    transition: all .3s ease;
}
.mode-card input:checked ~ .mode-card-content .mode-card-selector {
    border-color: var(--kalro-primary);
    background: var(--kalro-primary);
}
.mode-card input:checked ~ .mode-card-content .mode-radio-dot { background: white; }
/* Confirm button */
.mode-confirm-btn {
    min-width: 200px;
    padding: 1rem 2.5rem;
    font-size: 1.05rem;
    font-weight: 700;
    border-radius: 12px;
    letter-spacing: .3px;
}
.mode-confirm-btn:disabled { opacity: .45; cursor: not-allowed; transform: none !important; box-shadow: none !important; }

/* ============================================================
   PROGRESS STEPS
============================================================ */
.progress-steps {
    display: flex;
    justify-content: space-between;
    position: relative;
    max-width: 600px;
    margin: 0 auto;
    padding: 0 20px;
}
.progress-steps::before {
    content: '';
    position: absolute;
    top: 25px; left: 20%; right: 20%;
    height: 3px;
    background: #dee2e6;
    z-index: 0;
}
.step { display: flex; flex-direction: column; align-items: center; gap: .5rem; position: relative; z-index: 1; }
.step-number {
    width: 50px; height: 50px;
    border-radius: 50%;
    background: white;
    border: 3px solid #dee2e6;
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 1.1rem; color: #6c757d;
    transition: all 0.3s ease;
}
.step.active .step-number {
    background: var(--kalro-gradient);
    border-color: var(--kalro-primary);
    color: white;
    transform: scale(1.15);
    box-shadow: 0 4px 15px rgba(45,122,62,.4);
}
.step.completed .step-number { background: var(--kalro-secondary); border-color: var(--kalro-secondary); color: white; }
.step-label { font-size: .9rem; font-weight: 600; color: #6c757d; text-align: center; }
.step.active .step-label { color: var(--kalro-primary); }

/* ============================================================
   FORM CARD
============================================================ */
.form-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0,0,0,.08);
    padding: 3.5rem;
    margin-top: 2rem;
}

/* ============================================================
   FORM SECTIONS
============================================================ */
.form-section { display: none; animation: fadeInUp .4s ease; }
.form-section.active { display: block; }
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to   { opacity: 1; transform: translateY(0); }
}
.section-header { margin-bottom: 3rem; padding-bottom: 1.5rem; border-bottom: 3px solid var(--kalro-light); }
.section-title { color: var(--text-dark); font-size: 1.85rem; font-weight: 700; margin-bottom: .5rem; display: flex; align-items: center; }
.section-title i { color: var(--kalro-primary); font-size: 2rem; }
.section-subtitle { color: var(--text-muted); margin: 0; font-size: 1.05rem; }

/* ============================================================
   INPUTS
============================================================ */
.form-label { font-weight: 600; color: var(--text-dark); margin-bottom: .5rem; font-size: .95rem; }
.form-control, .form-select {
    border: 2px solid var(--border-color); border-radius: 10px;
    padding: .85rem 1rem; font-size: 1rem; transition: all .3s ease;
    background-color: white; color: var(--text-dark);
}
.form-control-lg, .form-select-lg { padding: 1rem 1.25rem; font-size: 1.05rem; min-height: 56px; line-height: 1.5; }
.form-control:focus, .form-select:focus { border-color: var(--kalro-primary); box-shadow: 0 0 0 4px rgba(45,122,62,.1); outline: none; }
.form-control::placeholder { color: #adb5bd; }
.form-select { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%232d3748' d='M6 9L1 4h10z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 1rem center; background-size: 12px; padding-right: 3rem; }

/* ============================================================
   PAPER REF SECTION
============================================================ */
.paper-ref-section {
    background: #f8faff;
    border: 2px solid #c7d7f5;
    border-radius: 14px;
    overflow: hidden;
}
.paper-ref-header {
    display: flex; align-items: center; gap: 1rem;
    padding: 1.1rem 1.5rem;
    background: linear-gradient(135deg, #eef3fd, #dbe8fb);
    border-bottom: 1px solid #c7d7f5;
}
.paper-ref-header i { font-size: 1.75rem; color: #3b6fd4; }
.paper-ref-header h6 { color: #1e3a8a; }
.paper-ref-body { padding: 1.5rem; }

/* ============================================================
   ATTENDANCE OPTIONS
============================================================ */
.attendance-options { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px,1fr)); gap: 1.5rem; }
.attendance-card { position: relative; cursor: pointer; display: block; }
.attendance-card input[type="radio"] { position: absolute; opacity: 0; pointer-events: none; }
.attendance-card .card-content { display: flex; align-items: center; gap: 1.25rem; padding: 1.75rem; background: white; border: 3px solid var(--border-color); border-radius: 15px; transition: all .3s ease; position: relative; }
.attendance-card:hover .card-content { border-color: var(--kalro-accent); transform: translateY(-2px); box-shadow: 0 8px 20px rgba(45,122,62,.15); }
.attendance-card input:checked ~ .card-content { background: var(--kalro-gradient); border-color: var(--kalro-primary); box-shadow: 0 8px 25px rgba(45,122,62,.25); transform: translateY(-3px); }
.icon-wrapper { flex-shrink: 0; width: 60px; height: 60px; border-radius: 12px; background: var(--kalro-light); display: flex; align-items: center; justify-content: center; transition: all .3s ease; }
.icon-wrapper i { font-size: 2rem; color: var(--kalro-primary); transition: all .3s ease; }
.attendance-card input:checked ~ .card-content .icon-wrapper { background: rgba(255,255,255,.2); }
.attendance-card input:checked ~ .card-content .icon-wrapper i { color: white; }
.text-content { flex: 1; }
.text-content h5 { margin: 0 0 .25rem 0; font-size: 1.15rem; font-weight: 700; color: var(--text-dark); transition: all .3s ease; }
.text-content p  { margin: 0; font-size: .9rem; color: var(--text-muted); transition: all .3s ease; }
.attendance-card input:checked ~ .card-content .text-content h5,
.attendance-card input:checked ~ .card-content .text-content p  { color: white; }
.check-indicator { flex-shrink: 0; opacity: 0; transition: all .3s ease; }
.check-indicator i { font-size: 1.75rem; color: white; }
.attendance-card input:checked ~ .card-content .check-indicator { opacity: 1; }

/* ============================================================
   PAYMENT METHODS
============================================================ */
.payment-methods { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px,1fr)); gap: 1.5rem; }
.payment-card { position: relative; cursor: pointer; display: block; }
.payment-card input[type="radio"] { position: absolute; opacity: 0; pointer-events: none; }
.payment-card .card-content { display: flex; align-items: center; gap: 1rem; padding: 1.5rem; background: white; border: 3px solid var(--border-color); border-radius: 15px; transition: all .3s ease; }
.payment-card:hover .card-content { border-color: var(--kalro-accent); transform: translateY(-2px); box-shadow: 0 8px 20px rgba(45,122,62,.15); }
.payment-card input:checked ~ .card-content { background: var(--kalro-gradient); border-color: var(--kalro-primary); box-shadow: 0 8px 25px rgba(45,122,62,.25); }
.payment-card .icon-wrapper { width: 50px; height: 50px; background: var(--kalro-light); }
.payment-card .icon-wrapper i { font-size: 1.75rem; }
.payment-card input:checked ~ .card-content .text-content h5,
.payment-card input:checked ~ .card-content .text-content p  { color: white; }

/* ============================================================
   GROUP COUNT SELECTOR
============================================================ */
.group-count-selector { background: var(--kalro-light); border-radius: 14px; padding: 1.75rem; }
.group-count-control { display: flex; align-items: center; gap: 1.5rem; margin-top: .5rem; }
.count-btn {
    width: 52px; height: 52px;
    border-radius: 50%;
    border: 2px solid var(--kalro-primary);
    background: white; color: var(--kalro-primary);
    font-size: 1.6rem; font-weight: 700; line-height: 1;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: all .25s ease;
    user-select: none;
}
.count-btn:hover { background: var(--kalro-primary); color: white; transform: scale(1.08); }
.count-display { text-align: center; min-width: 90px; }
.count-display span { display: block; font-size: 2.75rem; font-weight: 800; color: var(--kalro-dark); line-height: 1; }
.count-display small { font-size: .85rem; color: var(--text-muted); font-weight: 600; }

/* ============================================================
   GROUP MEMBER CARD
============================================================ */
.member-card {
    background: white;
    border: 2px solid var(--border-color);
    border-radius: 16px;
    margin-bottom: 1.5rem;
    overflow: hidden;
    transition: box-shadow .2s;
}
.member-card:hover { box-shadow: 0 6px 20px rgba(0,0,0,.08); }
.member-card-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 1rem 1.5rem;
    background: linear-gradient(135deg, #f0f9f0, #e8f5e9);
    border-bottom: 2px solid var(--border-color);
    cursor: pointer;
}
.member-card-header-left { display: flex; align-items: center; gap: .75rem; }
.member-number {
    width: 36px; height: 36px;
    border-radius: 50%; background: var(--kalro-gradient); color: white;
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: .9rem;
}
.member-card-header h6 { margin: 0; font-weight: 700; color: var(--text-dark); font-size: 1rem; }
.member-card-header small { color: var(--text-muted); }
.member-toggle-icon { color: var(--kalro-primary); transition: transform .3s; font-size: 1.2rem; }
.member-card.collapsed .member-toggle-icon { transform: rotate(-90deg); }
.member-card-body { padding: 1.5rem; }
.member-card.collapsed .member-card-body { display: none; }

/* Fee badge inside member header */
.member-fee-badge {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .25rem .75rem; border-radius: 100px;
    font-size: .78rem; font-weight: 700;
    background: var(--kalro-light); color: var(--kalro-dark);
    margin-left: .5rem;
}

/* ============================================================
   GROUP FEE SUMMARY
============================================================ */
.group-fee-summary {
    background: white;
    border: 2px solid var(--kalro-accent);
    border-radius: 16px;
    overflow: hidden;
}
.fee-summary-header {
    display: flex; align-items: center; gap: .75rem;
    padding: 1.1rem 1.5rem;
    background: var(--kalro-gradient); color: white;
    font-weight: 700; font-size: 1.05rem;
}
.fee-summary-header i { font-size: 1.5rem; }
.fee-summary-body { padding: 1rem 1.5rem; }
.fee-summary-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: .6rem 0; border-bottom: 1px solid #f0f0f0; font-size: .9rem;
}
.fee-summary-row:last-child { border-bottom: none; }
.fee-summary-row .name { color: var(--text-dark); font-weight: 600; }
.fee-summary-row .amt  { color: var(--kalro-dark); font-weight: 700; }
.fee-summary-total { border-top: 2px solid var(--border-color); padding: 1.25rem 1.5rem; }
.total-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: .5rem; }
.total-label { font-weight: 700; font-size: 1rem; color: var(--text-dark); }
.total-amount { font-size: 1.6rem; font-weight: 800; color: var(--kalro-dark); }
.total-note { font-size: .8rem; color: var(--text-muted); margin: .75rem 0 0 0; display: flex; align-items: flex-start; gap: .4rem; }
.total-note i { flex-shrink: 0; color: var(--kalro-primary); margin-top: 2px; }

/* ============================================================
   GROUP SUMMARY TABLE
============================================================ */
.group-summary-table-wrap { background: #f9fafb; border-radius: 12px; padding: 1.5rem; border: 1px solid var(--border-color); }
.group-summary-table { margin: 0; font-size: .9rem; }
.group-summary-table thead th { background: var(--kalro-light); color: var(--kalro-dark); font-weight: 700; border: none; padding: .75rem 1rem; }
.group-summary-table tbody td { padding: .75rem 1rem; vertical-align: middle; }
.group-summary-table tfoot td { padding: .75rem 1rem; font-weight: 700; background: var(--kalro-light); border-top: 2px solid var(--kalro-primary); }
.badge-presenter { background: #dbeafe; color: #1d4ed8; padding: .25rem .65rem; border-radius: 100px; font-size: .75rem; font-weight: 700; }
.badge-attendee  { background: #f3f4f6; color: #6b7280; padding: .25rem .65rem; border-radius: 100px; font-size: .75rem; font-weight: 700; }

/* ============================================================
   EARLY BIRD BANNER
============================================================ */
#earlyBirdBanner, #groupEarlyBirdBanner { border-radius: 12px; overflow: hidden; font-size: .9rem; }
#earlyBirdBanner.is-early, #groupEarlyBirdBanner.is-early { background: linear-gradient(135deg,#f0fdf4,#dcfce7); border: 2px solid #86efac; }
#earlyBirdBanner.is-standard, #groupEarlyBirdBanner.is-standard { background: linear-gradient(135deg,#fffbeb,#fef3c7); border: 2px solid #fcd34d; }
.eb-inner { padding: 1.1rem 1.4rem; display: flex; align-items: flex-start; gap: .9rem; }
.eb-emoji { font-size: 1.75rem; flex-shrink: 0; }
.eb-title { font-weight: 700; font-size: .95rem; margin-bottom: .25rem; }
#earlyBirdBanner.is-early .eb-title,#groupEarlyBirdBanner.is-early .eb-title { color: #14532d; }
#earlyBirdBanner.is-standard .eb-title,#groupEarlyBirdBanner.is-standard .eb-title { color: #78350f; }
.eb-desc { font-size: .825rem; color: #374151; margin-bottom: .75rem; line-height: 1.5; }
.eb-badge { display: inline-flex; align-items: center; gap: .35rem; font-size: .76rem; font-weight: 600; padding: .25rem .75rem; border-radius: 100px; margin-bottom: .85rem; }
#earlyBirdBanner.is-early .eb-badge,#groupEarlyBirdBanner.is-early .eb-badge { background: #bbf7d0; color: #14532d; }
#earlyBirdBanner.is-standard .eb-badge,#groupEarlyBirdBanner.is-standard .eb-badge { background: #fde68a; color: #78350f; }
.eb-countdown { display: flex; gap: .4rem; margin-bottom: .9rem; flex-wrap: wrap; }
.eb-cd-unit { background: white; border-radius: 7px; padding: .35rem .6rem; min-width: 50px; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,.08); }
.eb-cd-num { display: block; font-size: 1.05rem; font-weight: 700; color: #15803d; line-height: 1.2; font-family: 'Courier New', monospace; }
.eb-cd-lbl { display: block; font-size: .6rem; text-transform: uppercase; letter-spacing: .06em; color: #9ca3af; }
.eb-prices { display: grid; grid-template-columns: 1fr 1fr; gap: .4rem; }
.eb-price-row { background: white; border-radius: 8px; padding: .5rem .75rem; display: flex; justify-content: space-between; align-items: center; gap: .5rem; font-size: .78rem; box-shadow: 0 1px 2px rgba(0,0,0,.05); }
.eb-price-label { color: #6b7280; font-weight: 500; }
.eb-price-amount { font-weight: 700; }
#earlyBirdBanner.is-early .eb-price-amount,#groupEarlyBirdBanner.is-early .eb-price-amount { color: #15803d; }
#earlyBirdBanner.is-standard .eb-price-amount,#groupEarlyBirdBanner.is-standard .eb-price-amount { color: #d97706; }
.eb-footer { background: rgba(0,0,0,.04); padding: .55rem 1.4rem; font-size: .74rem; color: #6b7280; }

/* ============================================================
   FEE CALCULATOR
============================================================ */
.fee-calculator { background: var(--kalro-light); border: 2px solid var(--kalro-accent); border-radius: 15px; padding: 1.75rem; }
.fee-header { display: flex; align-items: center; gap: .75rem; margin-bottom: 1.25rem; font-weight: 700; font-size: 1.1rem; color: var(--kalro-dark); }
.fee-header i { font-size: 1.75rem; color: var(--kalro-primary); }
.fee-note { display: flex; align-items: center; gap: .5rem; color: var(--text-muted); padding: .75rem; background: white; border-radius: 8px; }
.fee-note i { color: var(--kalro-primary); flex-shrink: 0; }

/* ============================================================
   PAYMENT DETAILS CARD
============================================================ */
.payment-details-card { background: white; border: 2px solid var(--border-color); border-radius: 15px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,.05); }
.details-header { background: var(--kalro-gradient); color: white; padding: 1.25rem 1.75rem; display: flex; align-items: center; gap: .75rem; }
.details-header i { font-size: 1.75rem; }
.details-header h5 { margin: 0; font-size: 1.2rem; font-weight: 700; }
.details-body { padding: 1.75rem; }
.detail-item { display: flex; justify-content: space-between; align-items: center; padding: 1rem 0; border-bottom: 1px solid #f0f0f0; }
.detail-item:last-child { border-bottom: none; }
.detail-item.highlight { background: var(--kalro-light); margin: 0 -1.75rem; padding: 1rem 1.75rem; border-bottom: none; }
.detail-item .label { color: var(--text-muted); font-weight: 600; font-size: .95rem; }
.detail-item .value { color: var(--text-dark); font-weight: 700; font-size: 1.05rem; }
.detail-item.highlight .value { color: var(--kalro-dark); font-size: 1.25rem; }
.payment-steps { margin-top: 1.5rem; padding: 1.25rem; background: var(--bg-light); border-radius: 10px; }
.payment-steps ol { margin-left: 1.25rem; padding-left: 0; }
.payment-steps li { padding: .35rem 0; color: var(--text-dark); }

/* ============================================================
   FILE UPLOAD
============================================================ */
.upload-area { border: 3px dashed var(--border-color); border-radius: 15px; padding: 2rem; text-align: center; transition: all .3s ease; cursor: pointer; background: var(--bg-light); }
.upload-area:hover { border-color: var(--kalro-accent); background: var(--kalro-light); }
.file-input { display: none; }
.upload-placeholder i { font-size: 3.5rem; color: var(--kalro-primary); margin-bottom: 1rem; }
.upload-placeholder p { font-size: 1.05rem; color: var(--text-dark); }
.upload-placeholder strong { color: var(--kalro-primary); }
.file-preview { display: flex; align-items: center; gap: 1rem; padding: 1.25rem; background: white; border-radius: 10px; border: 2px solid var(--kalro-secondary); }
.file-preview i { font-size: 2rem; color: var(--kalro-secondary); flex-shrink: 0; }
.file-preview .file-name { flex: 1; font-weight: 600; color: var(--text-dark); word-break: break-all; }
.btn-remove { background: #dc3545; color: white; border: none; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all .3s ease; flex-shrink: 0; }
.btn-remove:hover { background: #c82333; transform: scale(1.1); }

/* ============================================================
   TERMS
============================================================ */
.terms-section { margin-top: 2.5rem; padding-top: 2rem; border-top: 2px solid #f0f0f0; }
.custom-checkbox { display: flex; align-items: flex-start; gap: .75rem; }
.custom-checkbox input[type="checkbox"] { width: 22px; height: 22px; margin-top: 2px; cursor: pointer; flex-shrink: 0; accent-color: var(--kalro-primary); }
.custom-checkbox label { font-size: 1rem; color: var(--text-dark); cursor: pointer; margin: 0; }
.custom-checkbox a { color: var(--kalro-primary); text-decoration: none; font-weight: 600; }
.custom-checkbox a:hover { text-decoration: underline; }

/* ============================================================
   SECTION FOOTER / BUTTONS
============================================================ */
.section-footer { display: flex; justify-content: space-between; gap: 1.25rem; margin-top: 3rem; padding-top: 2rem; border-top: 2px solid #f0f0f0; }
.section-footer .btn { min-width: 180px; padding: 1rem 2.5rem; font-weight: 700; font-size: 1.05rem; border-radius: 12px; transition: all .3s ease; text-transform: uppercase; letter-spacing: .5px; }
.btn-primary { background: var(--kalro-gradient); border: none; color: white; }
.btn-primary:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(45,122,62,.35); }
.btn-primary:disabled { opacity: .5; transform: none; box-shadow: none; cursor: not-allowed; }
.btn-success { background: var(--kalro-gradient); border: none; }
.btn-success:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(45,122,62,.4); }
.btn-outline-secondary { border: 2px solid var(--border-color); color: var(--text-dark); background: white; }
.btn-outline-secondary:hover { background: var(--bg-light); border-color: var(--text-muted); color: var(--text-dark); }

/* ============================================================
   ALERTS
============================================================ */
.alert { border-radius: 12px; border: none; padding: 1.25rem 1.75rem; margin-bottom: 1.5rem; font-size: 1rem; }
.alert i { font-size: 1.25rem; }
.alert-success { background: var(--kalro-light); color: var(--kalro-dark); border-left: 4px solid var(--kalro-primary); }

/* ============================================================
   RESPONSIVE
============================================================ */
@media (max-width: 768px) {
    .form-card { padding: 2rem 1.5rem; }
    .mode-options { grid-template-columns: 1fr; }
    .attendance-options, .payment-methods { grid-template-columns: 1fr; }
    .section-footer { flex-direction: column; }
    .section-footer .btn { width: 100%; min-width: unset; }
    .progress-steps { padding: 0 10px; }
    .step-label { font-size: .75rem; }
    .step-number { width: 45px; height: 45px; font-size: 1rem; }
    .section-title { font-size: 1.5rem; }
    .section-title i { font-size: 1.5rem; }
    .eb-prices { grid-template-columns: 1fr; }
    .group-count-control { justify-content: center; }
}
@media (max-width: 576px) {
    .registration-hero { padding: 3rem 0 4rem; }
    .registration-hero h1 { font-size: 2rem; }
    .form-card { padding: 1.5rem 1rem; }
    .mode-selector-card { padding: 1.75rem 1.25rem; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // ================================================================
    // HELPERS
    // ================================================================
    const EARLY_BIRD_DEADLINE = new Date('2026-04-10T23:59:59');
    const isEarlyBird = () => new Date() <= EARLY_BIRD_DEADLINE;
    const pad = n => String(n).padStart(2, '0');

    const FEE_TABLE = {
        virtual: {
            professional: { east_african: { early: 2000, standard: 3000, currency: 'KES' }, non_east_african: { early: 50,    standard: 60,   currency: 'USD' } },
            student:       { east_african: { early: 1000, standard: 1500, currency: 'KES' }, non_east_african: { early: 25,    standard: 30,   currency: 'USD' } },
        },
        physical: {
            kalro_staff:   { east_african: { early: 15000, standard: 18000, currency: 'KES' }, non_east_african: { early: 150, standard: 200, currency: 'USD' } },
        },
    };

    function getFee(platform, category, nationality) {
        try {
            const row = FEE_TABLE[platform][category][nationality];
            if (!row) return null;
            return { amount: isEarlyBird() ? row.early : row.standard, currency: row.currency };
        } catch(e) { return null; }
    }

    function formatFee(fee) {
        if (!fee) return '—';
        return fee.currency + ' ' + fee.amount.toLocaleString();
    }

    // ================================================================
    // EARLY BIRD BANNER (shared renderer)
    // ================================================================
    function renderEarlyBirdBanner(containerId) {
        const banner = document.getElementById(containerId);
        if (!banner) return;
        const early = isEarlyBird();
        const deadline = EARLY_BIRD_DEADLINE;
        function getTimeParts() {
            const diff = deadline - new Date();
            if (diff <= 0) return [0,0,0,0];
            return [
                Math.floor(diff / 86400000),
                Math.floor((diff % 86400000) / 3600000),
                Math.floor((diff % 3600000) / 60000),
                Math.floor((diff % 60000) / 1000)
            ];
        }
        const [d,h,m,s] = getTimeParts();
        const priceRows = `
            <div class="eb-price-row"><span class="eb-price-label">🌍 Virtual – Professional (EAC)</span><span class="eb-price-amount">${early ? 'KES 2,000' : 'KES 3,000'}</span></div>
            <div class="eb-price-row"><span class="eb-price-label">🌐 Virtual – Professional (Intl)</span><span class="eb-price-amount">${early ? 'USD 50' : 'USD 60'}</span></div>
            <div class="eb-price-row"><span class="eb-price-label">🎓 Virtual – Student (EAC)</span><span class="eb-price-amount">${early ? 'KES 1,000' : 'KES 1,500'}</span></div>
            <div class="eb-price-row"><span class="eb-price-label">🎓 Virtual – Student (Intl)</span><span class="eb-price-amount">${early ? 'USD 25' : 'USD 30'}</span></div>
            <div class="eb-price-row"><span class="eb-price-label">🏢 Physical – Org. Team (EAC)</span><span class="eb-price-amount">${early ? 'KES 15,000' : 'KES 18,000'}</span></div>
            <div class="eb-price-row"><span class="eb-price-label">🏢 Physical – Org. Team (Intl)</span><span class="eb-price-amount">${early ? 'USD 150' : 'USD 200'}</span></div>`;

        if (early) {
            banner.className = 'is-early';
            banner.innerHTML = `
                <div class="eb-inner">
                    <div class="eb-emoji">🎉</div>
                    <div>
                        <div class="eb-title">Early Bird Pricing is Active!</div>
                        <div class="eb-desc">Register before <strong>10 April 2026</strong> to get discounted rates.</div>
                        <div class="eb-badge"><i class="bi bi-clock"></i> Deadline: 10 April 2026</div>
                        <div class="eb-countdown">
                            <div class="eb-cd-unit"><span class="eb-cd-num eb-d">${pad(d)}</span><span class="eb-cd-lbl">Days</span></div>
                            <div class="eb-cd-unit"><span class="eb-cd-num eb-h">${pad(h)}</span><span class="eb-cd-lbl">Hrs</span></div>
                            <div class="eb-cd-unit"><span class="eb-cd-num eb-m">${pad(m)}</span><span class="eb-cd-lbl">Min</span></div>
                            <div class="eb-cd-unit"><span class="eb-cd-num eb-s">${pad(s)}</span><span class="eb-cd-lbl">Sec</span></div>
                        </div>
                        <div class="eb-prices">${priceRows}</div>
                    </div>
                </div>
                <div class="eb-footer">Standard rates apply after 10 April 2026. Your exact fee is auto-calculated below.</div>`;

            const ticker = setInterval(() => {
                const r = EARLY_BIRD_DEADLINE - new Date();
                if (r <= 0) { clearInterval(ticker); renderEarlyBirdBanner(containerId); return; }
                banner.querySelectorAll('.eb-d').forEach(el => el.textContent = pad(Math.floor(r/86400000)));
                banner.querySelectorAll('.eb-h').forEach(el => el.textContent = pad(Math.floor((r%86400000)/3600000)));
                banner.querySelectorAll('.eb-m').forEach(el => el.textContent = pad(Math.floor((r%3600000)/60000)));
                banner.querySelectorAll('.eb-s').forEach(el => el.textContent = pad(Math.floor((r%60000)/1000)));
            }, 1000);
        } else {
            banner.className = 'is-standard';
            banner.innerHTML = `
                <div class="eb-inner">
                    <div class="eb-emoji">⚠️</div>
                    <div>
                        <div class="eb-title">Standard Rates Now Apply</div>
                        <div class="eb-desc">The early bird deadline of <strong>10 April 2026</strong> has passed.</div>
                        <div class="eb-badge"><i class="bi bi-calendar-x"></i> Early bird closed 10 April 2026</div>
                        <div class="eb-prices">${priceRows}</div>
                    </div>
                </div>
                <div class="eb-footer">Your exact fee is auto-calculated below once you select your category.</div>`;
        }
    }

    // ================================================================
    // FILE UPLOAD HANDLER
    // ================================================================
    function setupFileUpload(uploadAreaId, inputId) {
        const uploadArea = document.getElementById(uploadAreaId);
        const input = document.getElementById(inputId);
        if (!uploadArea || !input) return;
        const placeholder = uploadArea.querySelector('.upload-placeholder');
        const preview = uploadArea.querySelector('.file-preview');
        const fileNameSpan = preview?.querySelector('.file-name');
        const removeBtn = preview?.querySelector('.btn-remove');

        uploadArea.addEventListener('click', e => { if (!e.target.closest('.btn-remove')) input.click(); });
        uploadArea.addEventListener('dragover', e => { e.preventDefault(); uploadArea.style.borderColor='#1a5f3a'; });
        uploadArea.addEventListener('dragleave', () => { uploadArea.style.borderColor=''; });
        uploadArea.addEventListener('drop', e => {
            e.preventDefault(); uploadArea.style.borderColor='';
            if (e.dataTransfer.files.length) { input.files = e.dataTransfer.files; handleFile(input.files[0]); }
        });
        input.addEventListener('change', function() { if (this.files?.[0]) handleFile(this.files[0]); });

        function handleFile(file) {
            if (fileNameSpan && placeholder && preview) {
                fileNameSpan.textContent = file.name;
                placeholder.style.display = 'none';
                preview.style.display = 'flex';
            }
        }
        removeBtn?.addEventListener('click', e => {
            e.stopPropagation(); input.value = '';
            if (placeholder && preview) { preview.style.display='none'; placeholder.style.display='block'; }
        });
    }

    // ================================================================
    // MODE SELECTOR
    // ================================================================
    const modeSelector = document.getElementById('modeSelector');
    const selfForm     = document.getElementById('selfRegistrationForm');
    const groupForm    = document.getElementById('groupRegistrationForm');
    const modeConfirm  = document.getElementById('modeConfirmBtn');

    document.querySelectorAll('input[name="registrationMode"]').forEach(r => {
        r.addEventListener('change', () => { modeConfirm.disabled = false; });
    });

    modeConfirm.addEventListener('click', () => {
        const mode = document.querySelector('input[name="registrationMode"]:checked')?.value;
        modeSelector.style.display = 'none';
        if (mode === 'self') {
            selfForm.style.display = 'block';
            initSelfForm();
        } else {
            groupForm.style.display = 'block';
            initGroupForm();
        }
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    function backToMode() {
        selfForm.style.display  = 'none';
        groupForm.style.display = 'none';
        modeSelector.style.display = 'block';
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    document.getElementById('backToModeFromStep1')?.addEventListener('click', backToMode);
    document.getElementById('backToModeFromGroup')?.addEventListener('click', backToMode);

    // ================================================================
    // SELF FORM
    // ================================================================
    function initSelfForm() {
        renderEarlyBirdBanner('earlyBirdBanner');
        setupFileUpload('studentIdUploadArea', 'studentId');
        setupFileUpload('paymentProofUploadArea', 'paymentProof');

        const formSections  = selfForm.querySelectorAll('.form-section');
        const progressSteps = selfForm.querySelectorAll('.progress-steps .step');
        const nextBtns      = selfForm.querySelectorAll('.next-step');
        const prevBtns      = selfForm.querySelectorAll('.prev-step');
        let currentStep = 1;

        const nationalitySelect = document.getElementById('nationality');
        const categorySelect    = document.getElementById('category');
        const feeSelect         = document.getElementById('fee');
        const feeCurrencyInput  = document.getElementById('feeCurrency');
        const studentIdUpload   = document.getElementById('studentIdUpload');
        const studentIdInput    = document.getElementById('studentId');
        const bankDetails       = document.getElementById('bankDetails');
        const mpesaDetails      = document.getElementById('mpesaDetails');

        function showStep(step) {
            formSections.forEach((s,i) => {
                s.classList.remove('active');
                progressSteps[i]?.classList.remove('active','completed');
            });
            selfForm.querySelector(`[data-section="${step}"]`)?.classList.add('active');
            progressSteps.forEach((el,i) => {
                if (i+1 < step) el.classList.add('completed');
                else if (i+1 === step) el.classList.add('active');
            });
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function calculateFee() {
            const nationality = nationalitySelect?.value;
            const platform    = selfForm.querySelector('input[name="platform"]:checked')?.value;
            const category    = categorySelect?.value;
            if (!feeSelect) return;
            feeSelect.innerHTML = '<option value="">Please complete the fields above</option>';
            if (!nationality || !platform || !category) return;

            const fee = getFee(platform, category, nationality);
            if (!fee) {
                if (platform === 'virtual' && category === 'kalro_staff') feeSelect.innerHTML = '<option value="">Virtual attendance not available for Organizing Team</option>';
                else if (platform === 'physical' && category !== 'kalro_staff') feeSelect.innerHTML = '<option value="">Physical attendance is for Organizing Team only</option>';
                return;
            }
            if (feeCurrencyInput) feeCurrencyInput.value = fee.currency;
            const eb = isEarlyBird();
            const opt = document.createElement('option');
            opt.value = fee.amount;
            opt.textContent = `${fee.currency} ${fee.amount.toLocaleString()}${eb ? ' (Early Bird – by 10 Apr)' : ' (Standard Rate)'}`;
            opt.selected = true;
            feeSelect.appendChild(opt);
        }

        nationalitySelect?.addEventListener('change', calculateFee);
        selfForm.querySelectorAll('input[name="platform"]').forEach(r => r.addEventListener('change', calculateFee));
        categorySelect?.addEventListener('change', function() {
            studentIdUpload.style.display = this.value === 'student' ? 'block' : 'none';
            if (studentIdInput) studentIdInput.required = (this.value === 'student');
            if (this.value !== 'student') { if(studentIdInput) studentIdInput.value = ''; }
            calculateFee();
        });

        document.querySelectorAll('input[name="paymentMethod"]').forEach(r => {
            r.addEventListener('change', function() {
                bankDetails.style.display  = this.value === 'bank'  ? 'block' : 'none';
                mpesaDetails.style.display = this.value === 'mpesa' ? 'block' : 'none';
            });
        });

        nextBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const section = this.closest('.form-section');
                const inputs  = section.querySelectorAll('input[required]:not([type="radio"]), select[required]');
                let valid = true;
                inputs.forEach(inp => {
                    if (!inp.value.trim()) { valid = false; inp.classList.add('is-invalid'); }
                    else inp.classList.remove('is-invalid');
                });
                if (valid && currentStep < 3) { currentStep++; showStep(currentStep); }
                else if (!valid) alert('Please fill in all required fields before proceeding.');
            });
        });

        prevBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                if (currentStep > 1) { currentStep--; showStep(currentStep); }
            });
        });

        showStep(1);
    }

    // ================================================================
    // GROUP FORM
    // ================================================================
    function initGroupForm() {
        renderEarlyBirdBanner('groupEarlyBirdBanner');
        setupFileUpload('groupPaymentProofUploadArea', 'groupPaymentProof');

        let groupCount = 2;
        const groupCountDisplay = document.getElementById('groupCountDisplay');
        const groupCountInput   = document.getElementById('groupCount');

        document.getElementById('groupCountMinus')?.addEventListener('click', () => {
            if (groupCount > 2) { groupCount--; groupCountDisplay.textContent = groupCount; groupCountInput.value = groupCount; }
        });
        document.getElementById('groupCountPlus')?.addEventListener('click', () => {
            if (groupCount < 50) { groupCount++; groupCountDisplay.textContent = groupCount; groupCountInput.value = groupCount; }
        });

        // Group step navigation
        const gSections = groupForm.querySelectorAll('.group-section');
        const gSteps    = groupForm.querySelectorAll('.progress-steps .step');

        function showGSection(n) {
            gSections.forEach((s,i) => {
                s.style.display = (i+1 === n) ? 'block' : 'none';
                gSteps[i]?.classList.remove('active','completed');
            });
            gSteps.forEach((el,i) => {
                if (i+1 < n) el.classList.add('completed');
                else if (i+1 === n) el.classList.add('active');
            });
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        document.getElementById('groupStep1Next')?.addEventListener('click', () => {
            buildMemberCards(groupCount);
            showGSection(2);
        });
        document.getElementById('groupStep2Back')?.addEventListener('click', () => showGSection(1));
        document.getElementById('groupStep2Next')?.addEventListener('click', () => {
            buildSummaryTable();
            showGSection(3);
        });
        document.getElementById('groupStep3Back')?.addEventListener('click', () => showGSection(2));

        // Payment method toggle for group
        document.querySelectorAll('input[name="groupPaymentMethod"]').forEach(r => {
            r.addEventListener('change', function() {
                document.getElementById('groupBankDetails').style.display  = this.value === 'bank'  ? 'block' : 'none';
                document.getElementById('groupMpesaDetails').style.display = this.value === 'mpesa' ? 'block' : 'none';
            });
        });

        showGSection(1);
    }

    // ================================================================
    // BUILD MEMBER CARDS
    // ================================================================
    function buildMemberCards(count) {
        const container = document.getElementById('groupMembersContainer');
        container.innerHTML = '';

        for (let i = 1; i <= count; i++) {
            const card = document.createElement('div');
            card.className = 'member-card';
            card.id = `memberCard${i}`;
            card.innerHTML = `
                <div class="member-card-header" onclick="toggleMemberCard(${i})">
                    <div class="member-card-header-left">
                        <div class="member-number">${i}</div>
                        <div>
                            <h6>Member ${i} <span class="member-fee-badge" id="memberFeeBadge${i}">Fee: —</span></h6>
                            <small id="memberCardSubtitle${i}" class="text-muted">Fill in details below</small>
                        </div>
                    </div>
                    <i class="bi bi-chevron-down member-toggle-icon"></i>
                </div>
                <div class="member-card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="members[${i}][firstName]"
                                   oninput="updateMemberSubtitle(${i})" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="members[${i}][lastName]"
                                   oninput="updateMemberSubtitle(${i})" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="members[${i}][email]"
                                   placeholder="member@example.com" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Institution <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="members[${i}][institution]" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nationality <span class="text-danger">*</span></label>
                            <select class="form-select" name="members[${i}][nationality]"
                                    onchange="recalcMemberFee(${i})" required>
                                <option value="">Select</option>
                                <option value="east_african">East African</option>
                                <option value="non_east_african">Non-East African</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Attendance <span class="text-danger">*</span></label>
                            <select class="form-select" name="members[${i}][platform]"
                                    onchange="recalcMemberFee(${i})" required>
                                <option value="">Select</option>
                                <option value="virtual">Virtual</option>
                                <option value="physical">Physical</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Category <span class="text-danger">*</span></label>
                            <select class="form-select" name="members[${i}][category]"
                                    onchange="recalcMemberFee(${i}); toggleMemberStudentId(${i})" required>
                                <option value="">Select</option>
                                <option value="student">Student</option>
                                <option value="professional">Professional/Researcher</option>
                                <option value="kalro_staff">Organizing Team</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Is this person a presenter?</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="members[${i}][presenter]" value="yes" id="presYes${i}">
                                    <label class="form-check-label" for="presYes${i}">Yes – Presenter</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="members[${i}][presenter]" value="no" id="presNo${i}" checked>
                                    <label class="form-check-label" for="presNo${i}">No – Attendee only</label>
                                </div>
                            </div>
                        </div>
                        <!-- Paper Ref (shown when presenter = yes) -->
                        <div class="col-12 member-paper-ref" id="memberPaperRef${i}" style="display:none;">
                            <div class="paper-ref-section">
                                <div class="paper-ref-header">
                                    <i class="bi bi-file-earmark-text"></i>
                                    <div>
                                        <h6 class="mb-0 fw-bold">Full Paper Reference</h6>
                                        <small class="text-muted">If this presenter has submitted a full paper</small>
                                    </div>
                                </div>
                                <div class="paper-ref-body">
                                    <input type="text" class="form-control" name="members[${i}][paperRefCode]"
                                           placeholder="e.g., KALRO-2026-0042 or submission code">
                                    <small class="text-muted d-block mt-1">
                                        <i class="bi bi-info-circle me-1"></i>The reference code from the paper submission system (optional).
                                    </small>
                                </div>
                            </div>
                        </div>
                        <!-- Student ID (shown when category = student) -->
                        <div class="col-12 member-student-id" id="memberStudentId${i}" style="display:none;">
                            <label class="form-label fw-bold">Student ID Proof <span class="text-danger">*</span></label>
                            <div class="upload-area member-student-upload-area" id="memberStudentUploadArea${i}">
                                <input type="file" class="file-input" id="memberStudentIdFile${i}" name="members[${i}][studentId]" accept="image/*,.pdf">
                                <div class="upload-placeholder">
                                    <i class="bi bi-cloud-upload" style="font-size:2rem;margin-bottom:.5rem;"></i>
                                    <p class="mb-0"><strong>Click to upload</strong> student ID</p>
                                    <small class="text-muted">PNG, JPG, PDF (Max 5MB)</small>
                                </div>
                                <div class="file-preview" style="display:none;">
                                    <i class="bi bi-file-earmark-check-fill"></i>
                                    <span class="file-name"></span>
                                    <button type="button" class="btn-remove"><i class="bi bi-x-lg"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
            container.appendChild(card);

            // Wire up presenter toggle
            card.querySelectorAll(`input[name="members[${i}][presenter]"]`).forEach(r => {
                r.addEventListener('change', function() {
                    document.getElementById(`memberPaperRef${i}`).style.display = this.value === 'yes' ? 'block' : 'none';
                });
            });

            // Wire up student upload
            setupMemberFileUpload(`memberStudentUploadArea${i}`, `memberStudentIdFile${i}`);
        }

        recalcGroupTotal();
    }

    function setupMemberFileUpload(areaId, inputId) {
        const area = document.getElementById(areaId);
        const inp  = document.getElementById(inputId);
        if (!area || !inp) return;
        const placeholder = area.querySelector('.upload-placeholder');
        const preview     = area.querySelector('.file-preview');
        const fileNameSpan = preview?.querySelector('.file-name');
        const removeBtn   = preview?.querySelector('.btn-remove');

        area.addEventListener('click', e => { if (!e.target.closest('.btn-remove')) inp.click(); });
        inp.addEventListener('change', function() {
            if (this.files?.[0] && fileNameSpan && placeholder && preview) {
                fileNameSpan.textContent = this.files[0].name;
                placeholder.style.display = 'none';
                preview.style.display = 'flex';
            }
        });
        removeBtn?.addEventListener('click', e => {
            e.stopPropagation(); inp.value = '';
            if (placeholder && preview) { preview.style.display='none'; placeholder.style.display='block'; }
        });
    }

    // ================================================================
    // MEMBER FEE CALCULATION
    // ================================================================
    window.toggleMemberCard = function(i) {
        document.getElementById(`memberCard${i}`)?.classList.toggle('collapsed');
    };

    window.updateMemberSubtitle = function(i) {
        const fn = document.querySelector(`[name="members[${i}][firstName]"]`)?.value || '';
        const ln = document.querySelector(`[name="members[${i}][lastName]"]`)?.value || '';
        const sub = document.getElementById(`memberCardSubtitle${i}`);
        if (sub) sub.textContent = (fn || ln) ? `${fn} ${ln}`.trim() : 'Fill in details below';
    };

    window.toggleMemberStudentId = function(i) {
        const cat = document.querySelector(`[name="members[${i}][category]"]`)?.value;
        const el  = document.getElementById(`memberStudentId${i}`);
        const fileInp = document.getElementById(`memberStudentIdFile${i}`);
        if (el) el.style.display = cat === 'student' ? 'block' : 'none';
        if (fileInp) fileInp.required = (cat === 'student');
    };

    window.recalcMemberFee = function(i) {
        const platform    = document.querySelector(`[name="members[${i}][platform]"]`)?.value;
        const category    = document.querySelector(`[name="members[${i}][category]"]`)?.value;
        const nationality = document.querySelector(`[name="members[${i}][nationality]"]`)?.value;
        const badge       = document.getElementById(`memberFeeBadge${i}`);

        if (platform && category && nationality) {
            const fee = getFee(platform, category, nationality);
            if (badge) badge.textContent = fee ? `Fee: ${formatFee(fee)}` : 'Fee: Not applicable';
        } else {
            if (badge) badge.textContent = 'Fee: —';
        }
        recalcGroupTotal();
    };

    function recalcGroupTotal() {
        const count   = parseInt(document.getElementById('groupCount')?.value) || 0;
        const bodyEl  = document.getElementById('groupFeeSummaryBody');
        const totalEl = document.getElementById('groupFeeTotal');
        if (!bodyEl) return;

        let totalKES = 0, totalUSD = 0;
        let rows = '';
        let allComplete = true;

        for (let i = 1; i <= count; i++) {
            const fn = document.querySelector(`[name="members[${i}][firstName]"]`)?.value || `Member ${i}`;
            const ln = document.querySelector(`[name="members[${i}][lastName]"]`)?.value || '';
            const platform    = document.querySelector(`[name="members[${i}][platform]"]`)?.value;
            const category    = document.querySelector(`[name="members[${i}][category]"]`)?.value;
            const nationality = document.querySelector(`[name="members[${i}][nationality]"]`)?.value;

            if (!platform || !category || !nationality) { allComplete = false; continue; }
            const fee = getFee(platform, category, nationality);
            if (!fee) continue;

            if (fee.currency === 'KES') totalKES += fee.amount;
            else totalUSD += fee.amount;

            rows += `<div class="fee-summary-row">
                <span class="name">${fn} ${ln}</span>
                <span class="amt">${formatFee(fee)}</span>
            </div>`;
        }

        bodyEl.innerHTML = rows || '<p class="text-muted text-center py-3"><i class="bi bi-info-circle me-2"></i>Fill in member details to see the fee breakdown.</p>';

        const totalKESSec = document.getElementById('totalKES');
        const totalUSDSec = document.getElementById('totalUSD');
        if (totalKES > 0 || totalUSD > 0) {
            totalEl.style.display = 'block';
            if (totalKESSec) totalKESSec.style.display = totalKES > 0 ? 'flex' : 'none';
            if (totalUSDSec) totalUSDSec.style.display = totalUSD > 0 ? 'flex' : 'none';
            document.getElementById('totalAmountKES').textContent = `KES ${totalKES.toLocaleString()}`;
            document.getElementById('totalAmountUSD').textContent = `USD ${totalUSD.toLocaleString()}`;
        } else {
            totalEl.style.display = 'none';
        }
    }

    // ================================================================
    // BUILD SUMMARY TABLE FOR GROUP STEP 3
    // ================================================================
    function buildSummaryTable() {
        const count = parseInt(document.getElementById('groupCount')?.value) || 0;
        const tbody = document.getElementById('groupSummaryTableBody');
        const tfoot = document.getElementById('groupSummaryTableFoot');
        if (!tbody) return;

        let totalKES = 0, totalUSD = 0;
        let rows = '';

        for (let i = 1; i <= count; i++) {
            const fn = document.querySelector(`[name="members[${i}][firstName]"]`)?.value || '—';
            const ln = document.querySelector(`[name="members[${i}][lastName]"]`)?.value || '';
            const platform    = document.querySelector(`[name="members[${i}][platform]"]`)?.value || '—';
            const category    = document.querySelector(`[name="members[${i}][category]"]`)?.value || '—';
            const nationality = document.querySelector(`[name="members[${i}][nationality]"]`)?.value;
            const presenter   = document.querySelector(`input[name="members[${i}][presenter]"]:checked`)?.value || 'no';
            const paperRef    = document.querySelector(`[name="members[${i}][paperRefCode]"]`)?.value || '—';
            const fee         = (platform && category && nationality) ? getFee(platform, category, nationality) : null;

            if (fee) {
                if (fee.currency === 'KES') totalKES += fee.amount;
                else totalUSD += fee.amount;
            }

            const catLabel = { student: 'Student', professional: 'Professional', kalro_staff: 'Org. Team' }[category] || category;
            const platLabel = { virtual: 'Virtual', physical: 'Physical' }[platform] || platform;
            const presenterBadge = presenter === 'yes'
                ? `<span class="badge-presenter"><i class="bi bi-mic-fill me-1"></i>Presenter</span>`
                : `<span class="badge-attendee">Attendee</span>`;

            rows += `<tr>
                <td>${i}</td>
                <td>${fn} ${ln}</td>
                <td>${catLabel}</td>
                <td>${platLabel}</td>
                <td>${presenterBadge}</td>
                <td style="font-size:.78rem;color:#6b7280;">${presenter === 'yes' ? paperRef : '—'}</td>
                <td style="font-weight:700;color:#0d3d25;">${formatFee(fee)}</td>
            </tr>`;
        }

        tbody.innerHTML = rows;

        let footContent = '<tr>';
        footContent += '<td colspan="6" style="text-align:right;">Total</td>';
        let totalStr = '';
        if (totalKES > 0) totalStr += `KES ${totalKES.toLocaleString()}`;
        if (totalKES > 0 && totalUSD > 0) totalStr += ' + ';
        if (totalUSD > 0) totalStr += `USD ${totalUSD.toLocaleString()}`;
        footContent += `<td>${totalStr || '—'}</td></tr>`;
        tfoot.innerHTML = footContent;
    }

});
</script>
@endsection