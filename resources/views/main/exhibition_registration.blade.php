@extends('layouts.header')

@section('title')
    Exhibition Registration
@endsection

@section('content')
<div class="exhibition-wrapper">
    <!-- Hero Section -->
    <div class="exhibition-hero">
        <div class="container">
            <div class="hero-content text-center">
                <h1 class="display-4 fw-bold mb-3">KALRO Conference Exhibition</h1>
                <p class="lead">Showcase your innovations and connect with industry leaders</p>
            </div>
        </div>
    </div>

    <!-- Registration Form -->
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Progress Indicator -->
                <div class="progress-steps mb-5">
                    <div class="step active" data-step="1">
                        <div class="step-circle">
                            <div class="step-number">1</div>
                            <div class="step-icon">
                                <i class="bi bi-building"></i>
                            </div>
                        </div>
                        <div class="step-label">Organization</div>
                    </div>
                    <div class="progress-line"></div>
                    <div class="step" data-step="2">
                        <div class="step-circle">
                            <div class="step-number">2</div>
                            <div class="step-icon">
                                <i class="bi bi-shop"></i>
                            </div>
                        </div>
                        <div class="step-label">Booth Details</div>
                    </div>
                    <div class="progress-line"></div>
                    <div class="step" data-step="3">
                        <div class="step-circle">
                            <div class="step-number">3</div>
                            <div class="step-icon">
                                <i class="bi bi-credit-card"></i>
                            </div>
                        </div>
                        <div class="step-label">Payment</div>
                    </div>
                    <div class="progress-line"></div>
                    <div class="step" data-step="4">
                        <div class="step-circle">
                            <div class="step-number">4</div>
                            <div class="step-icon">
                                <i class="bi bi-person-circle"></i>
                            </div>
                        </div>
                        <div class="step-label">Contact</div>
                    </div>
                </div>

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

                <!-- Main Form Card -->
                <div class="form-card">
                    <form id="exhibitionForm" action="{{ route('exhibition.register') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Step 1: Organization Information -->
                        <div class="form-step active" data-step="1" style="display: block !important;">
                            <div class="step-header">
                                <div class="step-icon-large">
                                    <i class="bi bi-building"></i>
                                </div>
                                <h2 class="step-title">Organization Information</h2>
                                <p class="step-description">Tell us about your organization and what you'll be exhibiting</p>
                            </div>

                            <div class="step-content">
                                <div class="row g-4">
                                    <div class="col-12">
                                        <div class="input-group-modern">
                                            <label for="organizationName" class="form-label">
                                                <i class="bi bi-building-fill me-2"></i>
                                                Organization Name <span class="required">*</span>
                                            </label>
                                            <input type="text" class="form-control form-control-lg" 
                                                   id="organizationName" name="organizationName" 
                                                   placeholder="Enter your organization or company name"
                                                   value="{{ old('organizationName') }}" required>
                                            <div class="input-icon">
                                                <i class="bi bi-check-circle-fill"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="input-group-modern">
                                            <label for="aboutExhibition" class="form-label">
                                                <i class="bi bi-card-text me-2"></i>
                                                About Your Exhibition <span class="required">*</span>
                                            </label>
                                            <textarea class="form-control form-control-lg" id="aboutExhibition" 
                                                      name="aboutExhibition" rows="5" 
                                                      placeholder="Describe what you plan to exhibit - products, services, innovations, demonstrations..."
                                                      required>{{ old('aboutExhibition') }}</textarea>
                                            <small class="form-hint">
                                                <i class="bi bi-info-circle me-1"></i>
                                                Minimum 50 characters - Be descriptive and engaging!
                                            </small>
                                            <div class="char-counter">
                                                <span class="current">0</span> / 50 minimum
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="input-group-modern">
                                            <label for="benefits" class="form-label">
                                                <i class="bi bi-star-fill me-2"></i>
                                                Benefits to Attendees <span class="required">*</span>
                                            </label>
                                            <textarea class="form-control form-control-lg" id="benefits" 
                                                      name="benefits" rows="5" 
                                                      placeholder="What will attendees gain from visiting your booth? Highlight key benefits, learning opportunities, samples, demonstrations..."
                                                      required>{{ old('benefits') }}</textarea>
                                            <small class="form-hint">
                                                <i class="bi bi-info-circle me-1"></i>
                                                Help attendees understand why they should visit your booth
                                            </small>
                                            <div class="char-counter">
                                                <span class="current">0</span> / 50 minimum
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="step-footer">
                                <button type="button" class="btn btn-primary btn-lg btn-next">
                                    Continue to Booth Details
                                    <i class="bi bi-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 2: Booth Details -->
                        <div class="form-step" data-step="2">
                            <div class="step-header">
                                <div class="step-icon-large">
                                    <i class="bi bi-shop"></i>
                                </div>
                                <h2 class="step-title">Booth Configuration</h2>
                                <p class="step-description">Select the number of booths and meal preferences</p>
                            </div>

                            <div class="step-content">
                                <div class="row g-4">
                                    <!-- Booth Count Selector -->
                                    <div class="col-12">
                                        <label class="form-label section-label">
                                            <i class="bi bi-grid-3x3 me-2"></i>
                                            How many booths do you need?
                                        </label>
                                        <div class="booth-counter-card">
                                            <div class="counter-wrapper">
                                                <button type="button" class="counter-btn" id="decrementBooth">
                                                    <i class="bi bi-dash-lg"></i>
                                                </button>
                                                <div class="counter-display">
                                                    <input type="number" class="form-control" id="boothCount" 
                                                           name="boothCount" min="1" max="10" value="{{ old('boothCount', 1) }}" required readonly>
                                                    <span class="counter-label">{{ old('boothCount', 1) == 1 ? 'Booth' : 'Booths' }}</span>
                                                </div>
                                                <button type="button" class="counter-btn" id="incrementBooth">
                                                    <i class="bi bi-plus-lg"></i>
                                                </button>
                                            </div>
                                            <p class="counter-note">
                                                <i class="bi bi-info-circle me-1"></i>
                                                Each booth can accommodate up to 2 exhibitors
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Registration Type -->
                                    <div class="col-12">
                                        <label class="form-label section-label">
                                            <i class="bi bi-cup-hot me-2"></i>
                                            Choose Your Package <span class="required">*</span>
                                        </label>
                                        <div class="package-cards">
                                            <label class="package-card">
                                                <input type="radio" name="registrationType" value="with_meals" 
                                                       {{ old('registrationType', 'with_meals') == 'with_meals' ? 'checked' : '' }} required>
                                                <div class="package-content">
                                                    <div class="package-badge premium">
                                                        <i class="bi bi-star-fill"></i>
                                                        Popular
                                                    </div>
                                                    <div class="package-icon">
                                                        <i class="bi bi-cup-hot-fill"></i>
                                                    </div>
                                                    <h4 class="package-title">Premium Package</h4>
                                                    <div class="package-price">
                                                        <span class="currency">KES</span>
                                                        <span class="amount">25,000</span>
                                                        <span class="per">per booth</span>
                                                    </div>
                                                    <div class="package-features">
                                                        <div class="feature-item">
                                                            <i class="bi bi-check-circle-fill"></i>
                                                            <span>Booth space with furniture</span>
                                                        </div>
                                                        <div class="feature-item">
                                                            <i class="bi bi-check-circle-fill"></i>
                                                            <span>2 exhibitor registrations</span>
                                                        </div>
                                                        <div class="feature-item highlighted">
                                                            <i class="bi bi-cup-hot-fill"></i>
                                                            <span><strong>Full catering included</strong></span>
                                                        </div>
                                                        <div class="feature-item">
                                                            <i class="bi bi-check-circle-fill"></i>
                                                            <span>Conference materials</span>
                                                        </div>
                                                    </div>
                                                    <div class="selection-indicator">
                                                        <i class="bi bi-check-circle-fill"></i>
                                                    </div>
                                                </div>
                                            </label>

                                            <label class="package-card">
                                                <input type="radio" name="registrationType" value="without_meals"
                                                       {{ old('registrationType') == 'without_meals' ? 'checked' : '' }}>
                                                <div class="package-content">
                                                    <div class="package-badge standard">
                                                        <i class="bi bi-tag-fill"></i>
                                                        Budget
                                                    </div>
                                                    <div class="package-icon">
                                                        <i class="bi bi-shop-window"></i>
                                                    </div>
                                                    <h4 class="package-title">Standard Package</h4>
                                                    <div class="package-price">
                                                        <span class="currency">KES</span>
                                                        <span class="amount">18,000</span>
                                                        <span class="per">per booth</span>
                                                    </div>
                                                    <div class="package-features">
                                                        <div class="feature-item">
                                                            <i class="bi bi-check-circle-fill"></i>
                                                            <span>Booth space with furniture</span>
                                                        </div>
                                                        <div class="feature-item">
                                                            <i class="bi bi-check-circle-fill"></i>
                                                            <span>2 exhibitor registrations</span>
                                                        </div>
                                                        <div class="feature-item muted">
                                                            <i class="bi bi-x-circle"></i>
                                                            <span>Meals not included</span>
                                                        </div>
                                                        <div class="feature-item">
                                                            <i class="bi bi-check-circle-fill"></i>
                                                            <span>Conference materials</span>
                                                        </div>
                                                    </div>
                                                    <div class="selection-indicator">
                                                        <i class="bi bi-check-circle-fill"></i>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Cost Summary -->
                                    <div class="col-12">
                                        <div class="cost-summary-modern">
                                            <div class="summary-header">
                                                <i class="bi bi-calculator"></i>
                                                <h5>Cost Summary</h5>
                                            </div>
                                            <div class="summary-body">
                                                <div class="summary-row">
                                                    <span class="label">Number of Booths:</span>
                                                    <span class="value" id="displayBoothCount">1</span>
                                                </div>
                                                <div class="summary-row">
                                                    <span class="label">Package Selected:</span>
                                                    <span class="value" id="displayPackage">Premium (With Meals)</span>
                                                </div>
                                                <div class="summary-row">
                                                    <span class="label">Price per Booth:</span>
                                                    <span class="value" id="displayPricePerBooth">KES 25,000</span>
                                                </div>
                                                <div class="summary-divider"></div>
                                                <div class="summary-total">
                                                    <span class="label">Total Amount:</span>
                                                    <span class="amount" id="totalCost">KES 25,000</span>
                                                </div>
                                            </div>
                                            <input type="hidden" id="calculatedTotal" name="calculatedTotal" value="25000">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="step-footer">
                                <button type="button" class="btn btn-outline-secondary btn-lg btn-prev">
                                    <i class="bi bi-arrow-left me-2"></i>
                                    Back
                                </button>
                                <button type="button" class="btn btn-primary btn-lg btn-next">
                                    Continue to Payment
                                    <i class="bi bi-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 3: Payment -->
                        <div class="form-step" data-step="3">
                            <div class="step-header">
                                <div class="step-icon-large">
                                    <i class="bi bi-credit-card"></i>
                                </div>
                                <h2 class="step-title">Payment Information</h2>
                                <p class="step-description">Complete your payment to secure your booth</p>
                            </div>

                            <div class="step-content">
                                <div class="row g-4">
                                    <!-- Payment Method -->
                                    <div class="col-12">
                                        <label class="form-label section-label">
                                            <i class="bi bi-wallet2 me-2"></i>
                                            Select Payment Method <span class="required">*</span>
                                        </label>
                                        <div class="payment-method-cards">
                                            <label class="payment-method-card">
                                                <input type="radio" name="paymentMethod" value="bank" required>
                                                <div class="method-content">
                                                    <div class="method-icon">
                                                        <i class="bi bi-bank"></i>
                                                    </div>
                                                    <div class="method-info">
                                                        <h5>Bank Transfer</h5>
                                                        <p>Direct deposit to our bank account</p>
                                                    </div>
                                                    <div class="method-check">
                                                        <i class="bi bi-check-circle-fill"></i>
                                                    </div>
                                                </div>
                                            </label>

                                            <label class="payment-method-card">
                                                <input type="radio" name="paymentMethod" value="mpesa">
                                                <div class="method-content">
                                                    <div class="method-icon">
                                                        <i class="bi bi-phone"></i>
                                                    </div>
                                                    <div class="method-info">
                                                        <h5>M-Pesa</h5>
                                                        <p>Pay via mobile money</p>
                                                    </div>
                                                    <div class="method-check">
                                                        <i class="bi bi-check-circle-fill"></i>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Payment Details Cards -->
                                    <div class="col-12">
                                        <div id="bankDetails" class="payment-info-modern" style="display: none;">
                                            <div class="info-header">
                                                <i class="bi bi-bank2"></i>
                                                <h5>Bank Transfer Details</h5>
                                            </div>
                                            <div class="info-grid">
                                                <div class="info-item">
                                                    <span class="info-label">Bank Name</span>
                                                    <span class="info-value">KCB Ltd</span>
                                                </div>
                                                <div class="info-item">
                                                    <span class="info-label">Branch</span>
                                                    <span class="info-value">K I C C</span>
                                                </div>
                                                <div class="info-item">
                                                    <span class="info-label">Bank Code</span>
                                                    <span class="info-value">01104</span>
                                                </div>
                                                <div class="info-item">
                                                    <span class="info-label">Swift Code</span>
                                                    <span class="info-value">KCBLKENX</span>
                                                </div>
                                                <div class="info-item highlight">
                                                    <span class="info-label">Account Number</span>
                                                    <span class="info-value large">1116139030</span>
                                                </div>
                                                <div class="info-item highlight">
                                                    <span class="info-label">Account Name</span>
                                                    <span class="info-value large">KALRO EAAPP</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="mpesaDetails" class="payment-info-modern" style="display: none;">
                                            <div class="info-header">
                                                <i class="bi bi-phone-fill"></i>
                                                <h5>M-Pesa Payment Details</h5>
                                            </div>
                                            <div class="info-grid simple">
                                                <div class="info-item highlight">
                                                    <span class="info-label">Paybill Number</span>
                                                    <span class="info-value large">522522</span>
                                                </div>
                                                <div class="info-item highlight">
                                                    <span class="info-label">Account Number</span>
                                                    <span class="info-value large">1116139030</span>
                                                </div>
                                            </div>
                                            <div class="mpesa-steps">
                                                <h6><i class="bi bi-list-ol me-2"></i>Payment Steps:</h6>
                                                <ol>
                                                    <li>Go to M-Pesa menu on your phone</li>
                                                    <li>Select <strong>Lipa na M-Pesa</strong></li>
                                                    <li>Select <strong>Pay Bill</strong></li>
                                                    <li>Enter Business Number: <strong>522522</strong></li>
                                                    <li>Enter Account Number: <strong>1116139030</strong></li>
                                                    <li>Enter the amount shown above</li>
                                                    <li>Enter your M-Pesa PIN and confirm</li>
                                                </ol>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Transaction Details -->
                                    <div class="col-12" id="transactionSection" style="display: none;">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="input-group-modern">
                                                    <label for="receiptNumber" class="form-label">
                                                        <i class="bi bi-receipt me-2"></i>
                                                        Transaction Reference <span class="required">*</span>
                                                    </label>
                                                    <input type="text" class="form-control form-control-lg" 
                                                           id="receiptNumber" name="receiptNumber" 
                                                           placeholder="Enter your payment confirmation code"
                                                           value="{{ old('receiptNumber') }}">
                                                    <small class="form-hint">
                                                        <i class="bi bi-info-circle me-1"></i>
                                                        The reference code from your payment receipt
                                                    </small>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">
                                                    <i class="bi bi-cloud-upload me-2"></i>
                                                    Payment Proof <span class="required">*</span>
                                                </label>
                                                <div class="file-upload-modern" id="paymentProofUpload">
                                                    <input type="file" class="file-input" id="paymentProof" 
                                                           name="paymentProof" accept="image/*,.pdf">
                                                    <div class="upload-area">
                                                        <i class="bi bi-cloud-arrow-up"></i>
                                                        <span class="upload-text">Click to upload or drag & drop</span>
                                                        <small class="upload-hint">PNG, JPG, PDF (Max 5MB)</small>
                                                    </div>
                                                    <div class="file-preview-modern" style="display: none;">
                                                        <div class="file-icon">
                                                            <i class="bi bi-file-earmark-check-fill"></i>
                                                        </div>
                                                        <div class="file-info">
                                                            <span class="file-name"></span>
                                                            <span class="file-size"></span>
                                                        </div>
                                                        <button type="button" class="file-remove">
                                                            <i class="bi bi-x-lg"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="step-footer">
                                <button type="button" class="btn btn-outline-secondary btn-lg btn-prev">
                                    <i class="bi bi-arrow-left me-2"></i>
                                    Back
                                </button>
                                <button type="button" class="btn btn-primary btn-lg btn-next">
                                    Continue to Contact Info
                                    <i class="bi bi-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 4: Contact Information -->
                        <div class="form-step" data-step="4">
                            <div class="step-header">
                                <div class="step-icon-large">
                                    <i class="bi bi-person-circle"></i>
                                </div>
                                <h2 class="step-title">Contact Information</h2>
                                <p class="step-description">Who should we contact regarding this exhibition?</p>
                            </div>

                            <div class="step-content">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="input-group-modern">
                                            <label for="contactName" class="form-label">
                                                <i class="bi bi-person-fill me-2"></i>
                                                Full Name <span class="required">*</span>
                                            </label>
                                            <input type="text" class="form-control form-control-lg" 
                                                   id="contactName" name="contactName" 
                                                   placeholder="Contact person's full name"
                                                   value="{{ old('contactName') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="input-group-modern">
                                            <label for="contactRole" class="form-label">
                                                <i class="bi bi-briefcase-fill me-2"></i>
                                                Role/Position <span class="required">*</span>
                                            </label>
                                            <input type="text" class="form-control form-control-lg" 
                                                   id="contactRole" name="contactRole" 
                                                   placeholder="e.g., Director, Manager, CEO"
                                                   value="{{ old('contactRole') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="input-group-modern">
                                            <label for="contactPhone" class="form-label">
                                                <i class="bi bi-telephone-fill me-2"></i>
                                                Phone Number <span class="required">*</span>
                                            </label>
                                            <input type="tel" class="form-control form-control-lg" 
                                                   id="contactPhone" name="contactPhone" 
                                                   placeholder="+254 712 345 678"
                                                   value="{{ old('contactPhone') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="input-group-modern">
                                            <label for="contactEmail" class="form-label">
                                                <i class="bi bi-envelope-fill me-2"></i>
                                                Email Address <span class="required">*</span>
                                            </label>
                                            <input type="email" class="form-control form-control-lg" 
                                                   id="contactEmail" name="contactEmail" 
                                                   placeholder="email@example.com"
                                                   value="{{ old('contactEmail') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label section-label">
                                            <i class="bi bi-person-badge me-2"></i>
                                            Team Leader? <span class="required">*</span>
                                        </label>
                                        <div class="toggle-group">
                                            <label class="toggle-option">
                                                <input type="radio" name="isTeamLeader" value="yes" 
                                                       {{ old('isTeamLeader') == 'yes' ? 'checked' : '' }} required>
                                                <span class="toggle-content">
                                                    <i class="bi bi-check-circle"></i>
                                                    <span>Yes, I'm leading</span>
                                                </span>
                                            </label>
                                            <label class="toggle-option">
                                                <input type="radio" name="isTeamLeader" value="no" 
                                                       {{ old('isTeamLeader', 'no') == 'no' ? 'checked' : '' }}>
                                                <span class="toggle-content">
                                                    <i class="bi bi-x-circle"></i>
                                                    <span>No, someone else</span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="input-group-modern">
                                            <label for="teamSize" class="form-label">
                                                <i class="bi bi-people-fill me-2"></i>
                                                Team Size <span class="required">*</span>
                                            </label>
                                            <input type="number" class="form-control form-control-lg" 
                                                   id="teamSize" name="teamSize" min="1" max="20" 
                                                   value="{{ old('teamSize', 2) }}" required>
                                            <small class="form-hint">
                                                <i class="bi bi-info-circle me-1"></i>
                                                Note: Catering is provided for 2 persons per booth only
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Terms & Submit -->
                            <div class="terms-section">
                                <div class="terms-card">
                                    <div class="terms-checkbox">
                                        <input type="checkbox" id="terms" name="terms" required>
                                        <label for="terms">
                                            <span class="checkbox-box">
                                                <i class="bi bi-check"></i>
                                            </span>
                                            <span class="checkbox-text">
                                                I have read and agree to the 
                                                <a href="{{ route('terms') }}" target="_blank">terms and conditions</a>
                                                <span class="required">*</span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="step-footer final">
                                <button type="button" class="btn btn-outline-secondary btn-lg btn-prev">
                                    <i class="bi bi-arrow-left me-2"></i>
                                    Back
                                </button>
                                <button type="submit" class="btn btn-success btn-lg btn-submit">
                                    <i class="bi bi-check-circle me-2"></i>
                                    Complete Registration
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* ========================================
   KALRO GREEN THEME
   ======================================== */
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
    
    --success: #10b981;
    --warning: #f59e0b;
}

/* ========================================
   LAYOUT
   ======================================== */
.exhibition-wrapper {
    min-height: 100vh;
    background: linear-gradient(135deg, #f0f9f4 0%, #e6f4ec 100%);
}

.exhibition-hero {
    background: var(--kalro-gradient);
    padding: 3.5rem 0 5rem;
    color: white;
    margin-bottom: -3rem;
    clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%);
    box-shadow: 0 4px 20px rgba(26, 95, 58, 0.2);
}

.exhibition-hero h1 {
    font-weight: 700;
    letter-spacing: -1px;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
}

.exhibition-hero .lead {
    color: rgba(255, 255, 255, 0.95);
    font-size: 1.15rem;
}

/* ========================================
   PROGRESS STEPS - ENHANCED
   ======================================== */
.progress-steps {
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    padding: 0 20px;
    max-width: 900px;
    margin: 0 auto;
}

.step {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.75rem;
    position: relative;
    z-index: 2;
    flex: 0 0 auto;
}

.step-circle {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    background: white;
    border: 4px solid var(--border-color);
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    transition: all 0.4s ease;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
}

.step-number {
    position: absolute;
    font-weight: 700;
    font-size: 0.85rem;
    color: var(--text-muted);
    top: -8px;
    right: -8px;
    width: 24px;
    height: 24px;
    background: white;
    border: 2px solid var(--border-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.4s ease;
}

.step-icon {
    opacity: 0;
    transform: scale(0);
    transition: all 0.4s ease;
}

.step-icon i {
    font-size: 2rem;
    color: var(--kalro-primary);
}

.step.active .step-circle,
.step.completed .step-circle {
    background: var(--kalro-gradient);
    border-color: var(--kalro-primary);
    transform: scale(1.1);
    box-shadow: 0 8px 20px rgba(26, 95, 58, 0.3);
}

.step.active .step-number,
.step.completed .step-number {
    background: var(--kalro-gradient);
    border-color: var(--kalro-primary);
    color: white;
}

.step.active .step-icon,
.step.completed .step-icon {
    opacity: 1;
    transform: scale(1);
}

.step.active .step-icon i,
.step.completed .step-icon i {
    color: white;
}

.step.completed .step-icon i {
    animation: checkBounce 0.5s ease;
}

@keyframes checkBounce {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.2); }
}

.step-label {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--text-muted);
    text-align: center;
    transition: all 0.3s ease;
}

.step.active .step-label {
    color: var(--kalro-primary);
    font-weight: 700;
}

.progress-line {
    height: 4px;
    flex: 1;
    background: var(--border-color);
    margin: 0 1rem;
    position: relative;
    border-radius: 2px;
    overflow: hidden;
}

.progress-line::after {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 0;
    background: var(--kalro-gradient);
    transition: width 0.6s ease;
}

.step.completed + .progress-line::after {
    width: 100%;
}

/* ========================================
   FORM CARD
   ======================================== */
.form-card {
    background: white;
    border-radius: 25px;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
    padding: 0;
    margin-top: 2rem;
    overflow: hidden;
}

/* ========================================
   FORM STEPS
   ======================================== */
.form-step {
    display: none !important;
    animation: fadeSlideIn 0.5s ease;
    padding: 3rem;
}

.form-step.active {
    display: block !important;
}

@keyframes fadeSlideIn {
    from {
        opacity: 0;
        transform: translateX(30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.step-header {
    text-align: center;
    margin-bottom: 3rem;
    padding-bottom: 2rem;
    border-bottom: 3px solid var(--kalro-light);
}

.step-icon-large {
    width: 90px;
    height: 90px;
    border-radius: 20px;
    background: var(--kalro-gradient);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
    box-shadow: 0 10px 30px rgba(26, 95, 58, 0.25);
}

.step-icon-large i {
    font-size: 2.5rem;
    color: white;
}

.step-title {
    font-size: 2rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 0.75rem;
}

.step-description {
    font-size: 1.1rem;
    color: var(--text-muted);
    margin: 0;
}

.step-content {
    margin-bottom: 3rem;
}

/* ========================================
   MODERN INPUT GROUPS
   ======================================== */
.input-group-modern {
    position: relative;
    margin-bottom: 0.5rem;
}

.form-label {
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.75rem;
    font-size: 1rem;
    display: flex;
    align-items: center;
}

.form-label i {
    color: var(--kalro-primary);
}

.section-label {
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 1.25rem;
    color: var(--kalro-dark);
}

.required {
    color: #dc2626;
    margin-left: 0.25rem;
}

.form-control {
    border: 2px solid var(--border-color);
    border-radius: 12px;
    padding: 1rem 1.25rem;
    font-size: 1.05rem;
    transition: all 0.3s ease;
    background: white;
}

.form-control-lg {
    padding: 1.15rem 1.5rem;
    font-size: 1.1rem;
    min-height: 58px;
}

.form-control:focus {
    border-color: var(--kalro-primary);
    box-shadow: 0 0 0 4px rgba(26, 95, 58, 0.1);
    outline: none;
}

.input-group-modern .input-icon {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--success);
    opacity: 0;
    transition: opacity 0.3s ease;
    font-size: 1.25rem;
}

.form-control:valid ~ .input-icon {
    opacity: 1;
}

textarea.form-control {
    resize: vertical;
    min-height: 140px;
}

.form-hint {
    display: block;
    margin-top: 0.5rem;
    color: var(--text-muted);
    font-size: 0.9rem;
}

.char-counter {
    position: absolute;
    right: 1rem;
    bottom: -1.75rem;
    font-size: 0.85rem;
    color: var(--text-muted);
    font-weight: 600;
}

.char-counter .current {
    color: var(--kalro-primary);
}

/* ========================================
   BOOTH COUNTER
   ======================================== */
.booth-counter-card {
    background: var(--kalro-light);
    border: 2px solid var(--kalro-accent);
    border-radius: 20px;
    padding: 2.5rem;
    text-align: center;
}

.counter-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 2rem;
    margin-bottom: 1.5rem;
}

.counter-btn {
    width: 60px;
    height: 60px;
    border-radius: 15px;
    background: white;
    border: 3px solid var(--kalro-primary);
    color: var(--kalro-primary);
    font-size: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
}

.counter-btn:hover {
    background: var(--kalro-gradient);
    color: white;
    transform: scale(1.1);
    box-shadow: 0 6px 15px rgba(26, 95, 58, 0.3);
}

.counter-btn:active {
    transform: scale(0.95);
}

.counter-display {
    text-align: center;
}

.counter-display .form-control {
    width: 120px;
    text-align: center;
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--kalro-primary);
    border: none;
    background: transparent;
    padding: 0;
    pointer-events: none;
}

.counter-label {
    display: block;
    margin-top: 0.5rem;
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--kalro-dark);
}

.counter-note {
    margin: 0;
    color: var(--text-muted);
    font-size: 0.95rem;
}

/* ========================================
   PACKAGE CARDS - PREMIUM DESIGN
   ======================================== */
.package-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
}

.package-card {
    cursor: pointer;
    position: relative;
    display: block;
}

.package-card input[type="radio"] {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.package-content {
    background: white;
    border: 3px solid var(--border-color);
    border-radius: 20px;
    padding: 2rem;
    text-align: center;
    transition: all 0.4s ease;
    position: relative;
    height: 100%;
}

.package-card:hover .package-content {
    border-color: var(--kalro-accent);
    transform: translateY(-8px);
    box-shadow: 0 15px 40px rgba(26, 95, 58, 0.15);
}

.package-card input:checked ~ .package-content {
    background: var(--kalro-gradient);
    border-color: var(--kalro-primary);
    transform: translateY(-10px);
    box-shadow: 0 20px 50px rgba(26, 95, 58, 0.3);
}

.package-badge {
    position: absolute;
    top: -12px;
    right: 20px;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 0.35rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.package-badge.premium {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
}

.package-badge.standard {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
}

.package-icon {
    width: 80px;
    height: 80px;
    border-radius: 20px;
    background: var(--kalro-light);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
    transition: all 0.4s ease;
}

.package-icon i {
    font-size: 2.5rem;
    color: var(--kalro-primary);
    transition: all 0.4s ease;
}

.package-card input:checked ~ .package-content .package-icon {
    background: rgba(255, 255, 255, 0.2);
}

.package-card input:checked ~ .package-content .package-icon i {
    color: white;
}

.package-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 1rem;
    transition: all 0.4s ease;
}

.package-card input:checked ~ .package-content .package-title {
    color: white;
}

.package-price {
    margin-bottom: 1.75rem;
}

.package-price .currency {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-muted);
    transition: all 0.4s ease;
}

.package-price .amount {
    font-size: 3rem;
    font-weight: 700;
    color: var(--kalro-primary);
    display: block;
    line-height: 1;
    margin: 0.25rem 0;
    transition: all 0.4s ease;
}

.package-price .per {
    font-size: 0.9rem;
    color: var(--text-muted);
    transition: all 0.4s ease;
}

.package-card input:checked ~ .package-content .package-price .currency,
.package-card input:checked ~ .package-content .package-price .amount,
.package-card input:checked ~ .package-content .package-price .per {
    color: white;
}

.package-features {
    text-align: left;
    margin-bottom: 1rem;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 0;
    border-bottom: 1px solid #f0f0f0;
    transition: all 0.4s ease;
}

.feature-item:last-child {
    border-bottom: none;
}

.feature-item i {
    font-size: 1.25rem;
    color: var(--kalro-primary);
    flex-shrink: 0;
    transition: all 0.4s ease;
}

.feature-item span {
    color: var(--text-dark);
    font-size: 0.95rem;
    transition: all 0.4s ease;
}

.feature-item.highlighted {
    background: var(--kalro-light);
    margin: 0 -2rem;
    padding: 0.75rem 2rem;
    border-bottom: none;
}

.feature-item.muted i {
    color: #dc2626;
}

.feature-item.muted span {
    color: var(--text-muted);
}

.package-card input:checked ~ .package-content .feature-item {
    border-bottom-color: rgba(255, 255, 255, 0.2);
}

.package-card input:checked ~ .package-content .feature-item i,
.package-card input:checked ~ .package-content .feature-item span {
    color: white;
}

.package-card input:checked ~ .package-content .feature-item.highlighted {
    background: rgba(255, 255, 255, 0.15);
}

.selection-indicator {
    position: absolute;
    top: 1.5rem;
    left: 1.5rem;
    font-size: 2rem;
    color: var(--success);
    opacity: 0;
    transform: scale(0);
    transition: all 0.4s ease;
}

.package-card input:checked ~ .package-content .selection-indicator {
    opacity: 1;
    transform: scale(1);
    color: white;
}

/* ========================================
   COST SUMMARY - MODERN
   ======================================== */
.cost-summary-modern {
    background: white;
    border: 3px solid var(--kalro-primary);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(26, 95, 58, 0.15);
}

.summary-header {
    background: var(--kalro-gradient);
    color: white;
    padding: 1.5rem 2rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.summary-header i {
    font-size: 1.75rem;
}

.summary-header h5 {
    margin: 0;
    font-size: 1.3rem;
    font-weight: 700;
}

.summary-body {
    padding: 2rem;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 0;
    border-bottom: 1px solid #f0f0f0;
}

.summary-row .label {
    color: var(--text-muted);
    font-weight: 600;
    font-size: 1rem;
}

.summary-row .value {
    color: var(--text-dark);
    font-weight: 700;
    font-size: 1.1rem;
}

.summary-divider {
    height: 2px;
    background: var(--kalro-light);
    margin: 1.5rem 0;
}

.summary-total {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    background: var(--kalro-light);
    border-radius: 12px;
    margin-top: 1rem;
}

.summary-total .label {
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--kalro-dark);
}

.summary-total .amount {
    font-size: 2.25rem;
    font-weight: 700;
    color: var(--kalro-primary);
}

/* ========================================
   PAYMENT METHOD CARDS
   ======================================== */
.payment-method-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.payment-method-card {
    cursor: pointer;
    display: block;
    position: relative;
}

.payment-method-card input[type="radio"] {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.method-content {
    display: flex;
    align-items: center;
    gap: 1.25rem;
    padding: 1.75rem;
    background: white;
    border: 3px solid var(--border-color);
    border-radius: 18px;
    transition: all 0.4s ease;
}

.payment-method-card:hover .method-content {
    border-color: var(--kalro-accent);
    transform: translateY(-4px);
    box-shadow: 0 10px 25px rgba(26, 95, 58, 0.15);
}

.payment-method-card input:checked ~ .method-content {
    background: var(--kalro-gradient);
    border-color: var(--kalro-primary);
    box-shadow: 0 12px 30px rgba(26, 95, 58, 0.25);
}

.method-icon {
    width: 60px;
    height: 60px;
    border-radius: 15px;
    background: var(--kalro-light);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: all 0.4s ease;
}

.method-icon i {
    font-size: 2rem;
    color: var(--kalro-primary);
    transition: all 0.4s ease;
}

.payment-method-card input:checked ~ .method-content .method-icon {
    background: rgba(255, 255, 255, 0.2);
}

.payment-method-card input:checked ~ .method-content .method-icon i {
    color: white;
}

.method-info {
    flex: 1;
}

.method-info h5 {
    margin: 0 0 0.25rem 0;
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--text-dark);
    transition: all 0.4s ease;
}

.method-info p {
    margin: 0;
    font-size: 0.9rem;
    color: var(--text-muted);
    transition: all 0.4s ease;
}

.payment-method-card input:checked ~ .method-content .method-info h5,
.payment-method-card input:checked ~ .method-content .method-info p {
    color: white;
}

.method-check {
    flex-shrink: 0;
    opacity: 0;
    transform: scale(0);
    transition: all 0.4s ease;
}

.method-check i {
    font-size: 2rem;
    color: white;
}

.payment-method-card input:checked ~ .method-content .method-check {
    opacity: 1;
    transform: scale(1);
}

/* ========================================
   PAYMENT INFO - MODERN
   ======================================== */
.payment-info-modern {
    background: white;
    border: 2px solid var(--border-color);
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
    animation: slideDown 0.4s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.info-header {
    background: var(--kalro-gradient);
    color: white;
    padding: 1.5rem 2rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.info-header i {
    font-size: 1.75rem;
}

.info-header h5 {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 700;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 0;
    padding: 2rem;
}

.info-grid.simple {
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    padding: 1.25rem;
    border-bottom: 1px solid #f0f0f0;
    border-right: 1px solid #f0f0f0;
}

.info-item:nth-child(2n) {
    border-right: none;
}

.info-item.highlight {
    background: var(--kalro-light);
    border-radius: 12px;
    margin: 0.5rem;
    border: 2px solid var(--kalro-accent);
}

.info-label {
    font-size: 0.9rem;
    color: var(--text-muted);
    font-weight: 600;
}

.info-value {
    font-size: 1.1rem;
    color: var(--text-dark);
    font-weight: 700;
}

.info-value.large {
    font-size: 1.5rem;
    color: var(--kalro-primary);
}

.mpesa-steps {
    padding: 1.5rem 2rem;
    background: var(--bg-light);
    border-top: 2px solid var(--border-color);
}

.mpesa-steps h6 {
    color: var(--kalro-dark);
    font-weight: 700;
    margin-bottom: 1rem;
}

.mpesa-steps ol {
    margin: 0;
    padding-left: 1.5rem;
}

.mpesa-steps li {
    padding: 0.5rem 0;
    color: var(--text-dark);
}

/* ========================================
   FILE UPLOAD - MODERN
   ======================================== */
.file-upload-modern {
    position: relative;
}

.file-input {
    display: none;
}

.upload-area {
    border: 3px dashed var(--border-color);
    border-radius: 15px;
    padding: 2rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background: var(--bg-light);
}

.upload-area:hover {
    border-color: var(--kalro-accent);
    background: var(--kalro-light);
}

.upload-area i {
    font-size: 3rem;
    color: var(--kalro-primary);
    display: block;
    margin-bottom: 1rem;
}

.upload-text {
    display: block;
    font-weight: 600;
    color: var(--kalro-primary);
    margin-bottom: 0.5rem;
}

.upload-hint {
    display: block;
    color: var(--text-muted);
    font-size: 0.85rem;
}

.file-preview-modern {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.25rem;
    background: white;
    border: 2px solid var(--kalro-primary);
    border-radius: 12px;
}

.file-icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    background: var(--kalro-light);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.file-icon i {
    font-size: 2rem;
    color: var(--kalro-primary);
}

.file-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.file-name {
    font-weight: 600;
    color: var(--text-dark);
    word-break: break-all;
}

.file-size {
    font-size: 0.85rem;
    color: var(--text-muted);
}

.file-remove {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: #dc2626;
    color: white;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.file-remove:hover {
    background: #b91c1c;
    transform: scale(1.1);
}

/* ========================================
   TOGGLE GROUP
   ======================================== */
.toggle-group {
    display: flex;
    gap: 1rem;
}

.toggle-option {
    flex: 1;
    cursor: pointer;
}

.toggle-option input[type="radio"] {
    display: none;
}

.toggle-content {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    padding: 1.15rem 1.5rem;
    background: white;
    border: 3px solid var(--border-color);
    border-radius: 12px;
    font-weight: 600;
    color: var(--text-dark);
    transition: all 0.3s ease;
}

.toggle-content i {
    font-size: 1.5rem;
    color: var(--text-muted);
    transition: all 0.3s ease;
}

.toggle-option:hover .toggle-content {
    border-color: var(--kalro-accent);
    background: var(--kalro-light);
}

.toggle-option input:checked ~ .toggle-content {
    background: var(--kalro-gradient);
    border-color: var(--kalro-primary);
    color: white;
    box-shadow: 0 6px 15px rgba(26, 95, 58, 0.25);
}

.toggle-option input:checked ~ .toggle-content i {
    color: white;
}

/* ========================================
   TERMS SECTION
   ======================================== */
.terms-section {
    margin-top: 2.5rem;
    padding-top: 2rem;
    border-top: 2px solid var(--border-color);
}

.terms-card {
    background: var(--kalro-light);
    border: 2px solid var(--kalro-accent);
    border-radius: 15px;
    padding: 1.75rem;
}

.terms-checkbox {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.terms-checkbox input[type="checkbox"] {
    display: none;
}

.checkbox-box {
    width: 28px;
    height: 28px;
    border: 3px solid var(--border-color);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: white;
    flex-shrink: 0;
    transition: all 0.3s ease;
    cursor: pointer;
}

.checkbox-box i {
    font-size: 1.25rem;
    color: white;
    opacity: 0;
    transform: scale(0);
    transition: all 0.3s ease;
}

.terms-checkbox input:checked ~ label .checkbox-box {
    background: var(--kalro-gradient);
    border-color: var(--kalro-primary);
}

.terms-checkbox input:checked ~ label .checkbox-box i {
    opacity: 1;
    transform: scale(1);
}

.checkbox-text {
    flex: 1;
    font-size: 1.05rem;
    color: var(--text-dark);
    line-height: 1.6;
    cursor: pointer;
}

.checkbox-text a {
    color: var(--kalro-primary);
    text-decoration: none;
    font-weight: 700;
}

.checkbox-text a:hover {
    text-decoration: underline;
}

/* ========================================
   STEP FOOTER
   ======================================== */
.step-footer {
    display: flex;
    justify-content: space-between;
    gap: 1.25rem;
    margin-top: 3rem;
    padding-top: 2.5rem;
    border-top: 2px solid var(--border-color);
}

.step-footer.final {
    justify-content: space-between;
}

.step-footer .btn {
    min-width: 180px;
    padding: 1.15rem 2.5rem;
    font-weight: 700;
    font-size: 1.1rem;
    border-radius: 12px;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.btn-primary {
    background: var(--kalro-gradient);
    border: none;
    color: white;
}

.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(26, 95, 58, 0.35);
}

.btn-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border: none;
    color: white;
}

.btn-success:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(16, 185, 129, 0.4);
}

.btn-outline-secondary {
    border: 3px solid var(--border-color);
    color: var(--text-dark);
    background: white;
}

.btn-outline-secondary:hover {
    background: var(--bg-light);
    border-color: var(--text-muted);
    color: var(--text-dark);
}

/* ========================================
   ALERTS
   ======================================== */
.alert {
    border-radius: 15px;
    border: none;
    padding: 1.25rem 1.75rem;
    margin-bottom: 1.5rem;
    animation: slideDown 0.4s ease;
}

.alert i {
    font-size: 1.25rem;
}

.alert-success {
    background: var(--kalro-light);
    color: var(--kalro-dark);
    border-left: 5px solid var(--kalro-primary);
}

/* ========================================
   RESPONSIVE
   ======================================== */
@media (max-width: 992px) {
    .form-card {
        padding: 0;
    }
    
    .form-step {
        padding: 2.5rem 2rem;
    }
    
    .package-cards {
        grid-template-columns: 1fr;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
    }
    
    .info-item {
        border-right: none;
    }
}

@media (max-width: 768px) {
    .progress-steps {
        gap: 0.5rem;
    }
    
    .step-circle {
        width: 60px;
        height: 60px;
    }
    
    .step-icon i {
        font-size: 1.5rem;
    }
    
    .step-label {
        font-size: 0.8rem;
    }
    
    .progress-line {
        margin: 0 0.5rem;
    }
    
    .form-step {
        padding: 2rem 1.5rem;
    }
    
    .step-footer {
        flex-direction: column;
    }
    
    .step-footer .btn {
        width: 100%;
        min-width: unset;
    }
    
    .payment-method-cards {
        grid-template-columns: 1fr;
    }
    
    .toggle-group {
        flex-direction: column;
    }
}

@media (max-width: 576px) {
    .exhibition-hero {
        padding: 3rem 0 4rem;
    }
    
    .exhibition-hero h1 {
        font-size: 2rem;
    }
    
    .step-icon-large {
        width: 70px;
        height: 70px;
    }
    
    .step-icon-large i {
        font-size: 2rem;
    }
    
    .step-title {
        font-size: 1.5rem;
    }
    
    .counter-btn {
        width: 50px;
        height: 50px;
    }
    
    .package-price .amount {
        font-size: 2.5rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ========================================
    // ELEMENTS
    // ========================================
    const form = document.getElementById('exhibitionForm');
    const formSteps = document.querySelectorAll('.form-step');
    const progressSteps = document.querySelectorAll('.progress-steps .step');
    const nextBtns = document.querySelectorAll('.btn-next');
    const prevBtns = document.querySelectorAll('.btn-prev');
    let currentStep = 1;
    const totalSteps = formSteps.length;
    
    // Booth counter
    const boothCountInput = document.getElementById('boothCount');
    const incrementBtn = document.getElementById('incrementBooth');
    const decrementBtn = document.getElementById('decrementBooth');
    
    // Registration type
    const registrationTypeRadios = document.querySelectorAll('input[name="registrationType"]');
    
    // Payment
    const paymentMethodRadios = document.querySelectorAll('input[name="paymentMethod"]');
    const bankDetails = document.getElementById('bankDetails');
    const mpesaDetails = document.getElementById('mpesaDetails');
    const transactionSection = document.getElementById('transactionSection');
    const receiptInput = document.getElementById('receiptNumber');
    const proofInput = document.getElementById('paymentProof');
    
    // Textareas
    const aboutExhibition = document.getElementById('aboutExhibition');
    const benefits = document.getElementById('benefits');
    
    // ========================================
    // STEP NAVIGATION
    // ========================================
    function showStep(step) {
        // Hide all steps
        formSteps.forEach(s => {
            s.classList.remove('active');
            s.style.display = 'none';
        });
        
        // Show current step
        const currentFormStep = document.querySelector(`.form-step[data-step="${step}"]`);
        if (currentFormStep) {
            currentFormStep.classList.add('active');
            currentFormStep.style.display = 'block';
        }
        
        // Update progress
        progressSteps.forEach((s, index) => {
            s.classList.remove('active', 'completed');
            if (index + 1 < step) {
                s.classList.add('completed');
            } else if (index + 1 === step) {
                s.classList.add('active');
            }
        });
        
        // Scroll to top
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
    
    function validateStep(step) {
        const currentFormStep = document.querySelector(`.form-step[data-step="${step}"]`);
        const inputs = currentFormStep.querySelectorAll('input[required]:not([type="radio"]), select[required], textarea[required]');
        const radioGroups = {};
        
        let valid = true;
        
        // Check text inputs, selects, and textareas
        inputs.forEach(input => {
            if (!input.value.trim()) {
                valid = false;
                input.classList.add('is-invalid');
                
                // Add error message if not exists
                if (!input.nextElementSibling?.classList.contains('invalid-feedback')) {
                    const feedback = document.createElement('div');
                    feedback.className = 'invalid-feedback d-block';
                    feedback.textContent = 'This field is required';
                    input.parentNode.appendChild(feedback);
                }
            } else {
                input.classList.remove('is-invalid');
                const feedback = input.parentNode.querySelector('.invalid-feedback');
                if (feedback) feedback.remove();
            }
        });
        
        // Check radio groups
        currentFormStep.querySelectorAll('input[type="radio"][required]').forEach(radio => {
            if (!radioGroups[radio.name]) {
                radioGroups[radio.name] = currentFormStep.querySelector(`input[name="${radio.name}"]:checked`);
            }
        });
        
        Object.values(radioGroups).forEach(isChecked => {
            if (!isChecked) valid = false;
        });
        
        // Special validation for textareas with minimum length
        if (step === 1) {
            if (aboutExhibition.value.trim().length < 50) {
                valid = false;
                aboutExhibition.classList.add('is-invalid');
            }
            if (benefits.value.trim().length < 50) {
                valid = false;
                benefits.classList.add('is-invalid');
            }
        }
        
        if (!valid) {
            alert('Please fill in all required fields before continuing.');
        }
        
        return valid;
    }
    
    nextBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            if (validateStep(currentStep)) {
                if (currentStep < totalSteps) {
                    currentStep++;
                    showStep(currentStep);
                }
            }
        });
    });
    
    prevBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
            }
        });
    });
    
    // Remove validation errors on input
    document.querySelectorAll('.form-control, .form-select').forEach(input => {
        input.addEventListener('input', function() {
            this.classList.remove('is-invalid');
            const feedback = this.parentNode.querySelector('.invalid-feedback');
            if (feedback) feedback.remove();
        });
    });
    
    // ========================================
    // CHARACTER COUNTER
    // ========================================
    function updateCharCounter(textarea) {
        const counter = textarea.parentElement.querySelector('.char-counter .current');
        if (counter) {
            counter.textContent = textarea.value.length;
        }
    }
    
    aboutExhibition?.addEventListener('input', function() {
        updateCharCounter(this);
    });
    
    benefits?.addEventListener('input', function() {
        updateCharCounter(this);
    });
    
    // ========================================
    // BOOTH COUNTER
    // ========================================
    incrementBtn?.addEventListener('click', () => {
        const current = parseInt(boothCountInput.value) || 1;
        if (current < 10) {
            boothCountInput.value = current + 1;
            updateBoothLabel();
            updateCostSummary();
        }
    });
    
    decrementBtn?.addEventListener('click', () => {
        const current = parseInt(boothCountInput.value) || 1;
        if (current > 1) {
            boothCountInput.value = current - 1;
            updateBoothLabel();
            updateCostSummary();
        }
    });
    
    function updateBoothLabel() {
        const count = parseInt(boothCountInput.value) || 1;
        const label = boothCountInput.parentElement.querySelector('.counter-label');
        if (label) {
            label.textContent = count === 1 ? 'Booth' : 'Booths';
        }
    }
    
    // ========================================
    // COST CALCULATION
    // ========================================
    function updateCostSummary() {
        const boothCount = parseInt(boothCountInput?.value) || 1;
        const selectedType = document.querySelector('input[name="registrationType"]:checked');
        const pricePerBooth = selectedType?.value === 'with_meals' ? 25000 : 18000;
        const total = boothCount * pricePerBooth;
        
        const packageName = selectedType?.value === 'with_meals' ? 'Premium (With Meals)' : 'Standard (Without Meals)';
        
        document.getElementById('displayBoothCount').textContent = boothCount;
        document.getElementById('displayPackage').textContent = packageName;
        document.getElementById('displayPricePerBooth').textContent = `KES ${pricePerBooth.toLocaleString()}`;
        document.getElementById('totalCost').textContent = `KES ${total.toLocaleString()}`;
        document.getElementById('calculatedTotal').value = total;
    }
    
    boothCountInput?.addEventListener('input', updateCostSummary);
    registrationTypeRadios?.forEach(radio => {
        radio.addEventListener('change', updateCostSummary);
    });
    
    // ========================================
    // PAYMENT METHOD TOGGLE
    // ========================================
    paymentMethodRadios?.forEach(radio => {
        radio.addEventListener('change', function() {
            const method = this.value;
            
            if (method === 'bank') {
                bankDetails.style.display = 'block';
                mpesaDetails.style.display = 'none';
            } else if (method === 'mpesa') {
                bankDetails.style.display = 'none';
                mpesaDetails.style.display = 'block';
            }
            
            transactionSection.style.display = 'block';
            receiptInput.required = true;
            proofInput.required = true;
        });
    });
    
    // ========================================
    // FILE UPLOAD
    // ========================================
    function setupFileUpload(uploadId, inputId) {
        const uploadArea = document.getElementById(uploadId);
        const input = document.getElementById(inputId);
        
        if (!uploadArea || !input) return;
        
        const uploadPlaceholder = uploadArea.querySelector('.upload-area');
        const preview = uploadArea.querySelector('.file-preview-modern');
        const fileNameSpan = preview?.querySelector('.file-name');
        const fileSizeSpan = preview?.querySelector('.file-size');
        const removeBtn = preview?.querySelector('.file-remove');
        
        uploadArea.addEventListener('click', (e) => {
            if (!e.target.closest('.file-remove')) {
                input.click();
            }
        });
        
        // Drag and drop
        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadPlaceholder?.classList.add('dragging');
        });
        
        uploadArea.addEventListener('dragleave', () => {
            uploadPlaceholder?.classList.remove('dragging');
        });
        
        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadPlaceholder?.classList.remove('dragging');
            if (e.dataTransfer.files.length) {
                input.files = e.dataTransfer.files;
                handleFileSelect(input.files[0]);
            }
        });
        
        input.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                handleFileSelect(this.files[0]);
            }
        });
        
        function handleFileSelect(file) {
            if (fileNameSpan && fileSizeSpan && uploadPlaceholder && preview) {
                fileNameSpan.textContent = file.name;
                fileSizeSpan.textContent = formatFileSize(file.size);
                uploadPlaceholder.style.display = 'none';
                preview.style.display = 'flex';
            }
        }
        
        function formatFileSize(bytes) {
            if (bytes < 1024) return bytes + ' B';
            if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
            return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
        }
        
        removeBtn?.addEventListener('click', (e) => {
            e.stopPropagation();
            input.value = '';
            if (uploadPlaceholder && preview) {
                preview.style.display = 'none';
                uploadPlaceholder.style.display = 'block';
            }
        });
    }
    
    setupFileUpload('paymentProofUpload', 'paymentProof');
    
    // ========================================
    // INITIALIZE
    // ========================================
    // Force show first step immediately
    document.querySelector('.form-step[data-step="1"]')?.classList.add('active');
    
    showStep(1);
    updateCostSummary();
    updateCharCounter(aboutExhibition);
    updateCharCounter(benefits);
});
</script>
@endsection