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
                    <form id="registrationForm" action="{{ route('conference.register') }}" method="POST" enctype="multipart/form-data">
                        @csrf

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
                                                <div class="icon-wrapper">
                                                    <i class="bi bi-building"></i>
                                                </div>
                                                <div class="text-content">
                                                    <h5>Physical Attendance</h5>
                                                    <p>Join us in person at the venue</p>
                                                </div>
                                                <div class="check-indicator">
                                                    <i class="bi bi-check-circle-fill"></i>
                                                </div>
                                            </div>
                                        </label>

                                        <label class="attendance-card">
                                            <input type="radio" name="platform" value="virtual">
                                            <div class="card-content">
                                                <div class="icon-wrapper">
                                                    <i class="bi bi-laptop"></i>
                                                </div>
                                                <div class="text-content">
                                                    <h5>Virtual Attendance</h5>
                                                    <p>Participate online via video conference</p>
                                                </div>
                                                <div class="check-indicator">
                                                    <i class="bi bi-check-circle-fill"></i>
                                                </div>
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
                                        <option value="kalro_staff" {{ old('category') == 'kalro_staff' ? 'selected' : '' }}>KALRO Staff Member</option>
                                    </select>
                                </div>

                                <!-- Student ID Upload (Conditional) -->
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
                                                <button type="button" class="btn-remove">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
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
                                                <small>Fee is calculated based on your nationality, attendance type, and category</small>
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
                                                <div class="icon-wrapper">
                                                    <i class="bi bi-bank"></i>
                                                </div>
                                                <div class="text-content">
                                                    <h5>Bank Transfer</h5>
                                                    <p>Direct bank deposit</p>
                                                </div>
                                                <div class="check-indicator">
                                                    <i class="bi bi-check-circle-fill"></i>
                                                </div>
                                            </div>
                                        </label>

                                        <label class="payment-card">
                                            <input type="radio" name="paymentMethod" value="mpesa">
                                            <div class="card-content">
                                                <div class="icon-wrapper">
                                                    <i class="bi bi-phone"></i>
                                                </div>
                                                <div class="text-content">
                                                    <h5>M-Pesa</h5>
                                                    <p>Mobile money payment</p>
                                                </div>
                                                <div class="check-indicator">
                                                    <i class="bi bi-check-circle-fill"></i>
                                                </div>
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
                                                <span class="label">Bank Name:</span>
                                                <span class="value">KCB Ltd</span>
                                            </div>
                                            <div class="detail-item">
                                                <span class="label">Branch:</span>
                                                <span class="value">K I C C</span>
                                            </div>
                                            <div class="detail-item">
                                                <span class="label">Bank Code:</span>
                                                <span class="value">01104</span>
                                            </div>
                                            <div class="detail-item">
                                                <span class="label">Swift Code:</span>
                                                <span class="value">KCBLKENX</span>
                                            </div>
                                            <div class="detail-item highlight">
                                                <span class="label">Account Number:</span>
                                                <span class="value">1116139030</span>
                                            </div>
                                            <div class="detail-item">
                                                <span class="label">Account Name:</span>
                                                <span class="value">KALRO EAAPP</span>
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
                                                <button type="button" class="btn-remove">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
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
                                        I agree to the <a href="{{ route('terms') }}" target="_blank">terms and conditions</a> <span class="text-danger">*</span>
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
            </div>
        </div>
    </div>
</div>

<style>
/* ========================================
   KALRO GREEN THEME - COLOR VARIABLES
   ======================================== */
:root {
    --kalro-primary: #1a5f3a;     /* Same as navbar green */
    --kalro-secondary: #14532d;   /* Slightly deeper variation */
    --kalro-light: #e6f4ec;       /* Soft green background tint */
    --kalro-dark: #0d3d25;        /* Navbar hover green */
    --kalro-accent: #1f7a4c;      /* Slightly brighter but same tone */
    --kalro-gradient: linear-gradient(135deg, #1a5f3a 0%, #0d3d25 100%);
    
    --text-dark: #111827;
    --text-muted: #6b7280;
    --border-color: #e5e7eb;
    --bg-light: #f9fafb;
}


/* ========================================
   GLOBAL STYLES
   ======================================== */
.registration-wrapper {
    min-height: 100vh;
    background: linear-gradient(135deg, #f0f9f0 0%, #e8f5e9 100%);
}

/* ========================================
   HERO SECTION
   ======================================== */
.registration-hero {
    background: var(--kalro-gradient);
    padding: 4rem 0 5rem;
    color: white;
    margin-bottom: -3rem;
    clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%);
    box-shadow: 0 4px 20px rgba(45, 122, 62, 0.2);
}

.registration-hero h1 {
    font-weight: 700;
    letter-spacing: -1px;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
}

.registration-hero .lead {
    color: rgba(255, 255, 255, 0.95);
    font-size: 1.15rem;
}

/* ========================================
   PROGRESS STEPS
   ======================================== */
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
    top: 25px;
    left: 20%;
    right: 20%;
    height: 3px;
    background: #dee2e6;
    z-index: 0;
}

.step {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    position: relative;
    z-index: 1;
}

.step-number {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: white;
    border: 3px solid #dee2e6;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.1rem;
    color: #6c757d;
    transition: all 0.3s ease;
}

.step.active .step-number {
    background: var(--kalro-gradient);
    border-color: var(--kalro-primary);
    color: white;
    transform: scale(1.15);
    box-shadow: 0 4px 15px rgba(45, 122, 62, 0.4);
}

.step.completed .step-number {
    background: var(--kalro-secondary);
    border-color: var(--kalro-secondary);
    color: white;
}

.step-label {
    font-size: 0.9rem;
    font-weight: 600;
    color: #6c757d;
    text-align: center;
}

.step.active .step-label {
    color: var(--kalro-primary);
}

/* ========================================
   FORM CARD
   ======================================== */
.form-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    padding: 3.5rem;
    margin-top: 2rem;
}

/* ========================================
   FORM SECTIONS
   ======================================== */
.form-section {
    display: none;
    animation: fadeInUp 0.4s ease;
}

.form-section.active {
    display: block;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.section-header {
    margin-bottom: 3rem;
    padding-bottom: 1.5rem;
    border-bottom: 3px solid var(--kalro-light);
}

.section-title {
    color: var(--text-dark);
    font-size: 1.85rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
}

.section-title i {
    color: var(--kalro-primary);
    font-size: 2rem;
}

.section-subtitle {
    color: var(--text-muted);
    margin: 0;
    font-size: 1.05rem;
}

/* ========================================
   FORM INPUTS - IMPROVED VISIBILITY
   ======================================== */
.form-label {
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
    font-size: 0.95rem;
}

.form-control,
.form-select {
    border: 2px solid var(--border-color);
    border-radius: 10px;
    padding: 0.85rem 1rem;
    font-size: 1rem;
    transition: all 0.3s ease;
    background-color: white;
    color: var(--text-dark);
}

.form-control-lg,
.form-select-lg {
    padding: 1rem 1.25rem;
    font-size: 1.05rem;
    min-height: 56px;
    line-height: 1.5;
}

.form-control:focus,
.form-select:focus {
    border-color: var(--kalro-primary);
    box-shadow: 0 0 0 4px rgba(45, 122, 62, 0.1);
    outline: none;
}

.form-control::placeholder {
    color: #adb5bd;
}

.form-select option {
    padding: 10px;
    font-size: 1rem;
}

/* Ensure select dropdown text is visible */
.form-select {
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%232d3748' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 1rem center;
    background-size: 12px;
    padding-right: 3rem;
}

/* ========================================
   ATTENDANCE OPTIONS - REFINED
   ======================================== */
.attendance-options {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
}

.attendance-card {
    position: relative;
    cursor: pointer;
    display: block;
}

.attendance-card input[type="radio"] {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.attendance-card .card-content {
    display: flex;
    align-items: center;
    gap: 1.25rem;
    padding: 1.75rem;
    background: white;
    border: 3px solid var(--border-color);
    border-radius: 15px;
    transition: all 0.3s ease;
    position: relative;
}

.attendance-card:hover .card-content {
    border-color: var(--kalro-accent);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(45, 122, 62, 0.15);
}

.attendance-card input:checked ~ .card-content {
    background: var(--kalro-gradient);
    border-color: var(--kalro-primary);
    box-shadow: 0 8px 25px rgba(45, 122, 62, 0.25);
    transform: translateY(-3px);
}

.icon-wrapper {
    flex-shrink: 0;
    width: 60px;
    height: 60px;
    border-radius: 12px;
    background: var(--kalro-light);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.icon-wrapper i {
    font-size: 2rem;
    color: var(--kalro-primary);
    transition: all 0.3s ease;
}

.attendance-card input:checked ~ .card-content .icon-wrapper {
    background: rgba(255, 255, 255, 0.2);
}

.attendance-card input:checked ~ .card-content .icon-wrapper i {
    color: white;
}

.text-content {
    flex: 1;
}

.text-content h5 {
    margin: 0 0 0.25rem 0;
    font-size: 1.15rem;
    font-weight: 700;
    color: var(--text-dark);
    transition: all 0.3s ease;
}

.text-content p {
    margin: 0;
    font-size: 0.9rem;
    color: var(--text-muted);
    transition: all 0.3s ease;
}

.attendance-card input:checked ~ .card-content .text-content h5,
.attendance-card input:checked ~ .card-content .text-content p {
    color: white;
}

.check-indicator {
    flex-shrink: 0;
    opacity: 0;
    transition: all 0.3s ease;
}

.check-indicator i {
    font-size: 1.75rem;
    color: white;
}

.attendance-card input:checked ~ .card-content .check-indicator {
    opacity: 1;
}

/* ========================================
   PAYMENT METHODS - REFINED
   ======================================== */
.payment-methods {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.payment-card {
    position: relative;
    cursor: pointer;
    display: block;
}

.payment-card input[type="radio"] {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.payment-card .card-content {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    background: white;
    border: 3px solid var(--border-color);
    border-radius: 15px;
    transition: all 0.3s ease;
}

.payment-card:hover .card-content {
    border-color: var(--kalro-accent);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(45, 122, 62, 0.15);
}

.payment-card input:checked ~ .card-content {
    background: var(--kalro-gradient);
    border-color: var(--kalro-primary);
    box-shadow: 0 8px 25px rgba(45, 122, 62, 0.25);
}

.payment-card .icon-wrapper {
    width: 50px;
    height: 50px;
    background: var(--kalro-light);
}

.payment-card .icon-wrapper i {
    font-size: 1.75rem;
}

.payment-card input:checked ~ .card-content .text-content h5,
.payment-card input:checked ~ .card-content .text-content p {
    color: white;
}

/* ========================================
   FEE CALCULATOR
   ======================================== */
.fee-calculator {
    background: var(--kalro-light);
    border: 2px solid var(--kalro-accent);
    border-radius: 15px;
    padding: 1.75rem;
}

.fee-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.25rem;
    font-weight: 700;
    font-size: 1.1rem;
    color: var(--kalro-dark);
}

.fee-header i {
    font-size: 1.75rem;
    color: var(--kalro-primary);
}

.fee-note {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--text-muted);
    padding: 0.75rem;
    background: white;
    border-radius: 8px;
}

.fee-note i {
    color: var(--kalro-primary);
    flex-shrink: 0;
}

/* ========================================
   PAYMENT DETAILS CARD
   ======================================== */
.payment-details-card {
    background: white;
    border: 2px solid var(--border-color);
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
}

.details-header {
    background: var(--kalro-gradient);
    color: white;
    padding: 1.25rem 1.75rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.details-header i {
    font-size: 1.75rem;
}

.details-header h5 {
    margin: 0;
    font-size: 1.2rem;
    font-weight: 700;
}

.details-body {
    padding: 1.75rem;
}

.detail-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 0;
    border-bottom: 1px solid #f0f0f0;
}

.detail-item:last-child {
    border-bottom: none;
}

.detail-item.highlight {
    background: var(--kalro-light);
    margin: 0 -1.75rem;
    padding: 1rem 1.75rem;
    border-bottom: none;
}

.detail-item .label {
    color: var(--text-muted);
    font-weight: 600;
    font-size: 0.95rem;
}

.detail-item .value {
    color: var(--text-dark);
    font-weight: 700;
    font-size: 1.05rem;
}

.detail-item.highlight .value {
    color: var(--kalro-dark);
    font-size: 1.25rem;
}

.payment-steps {
    margin-top: 1.5rem;
    padding: 1.25rem;
    background: var(--bg-light);
    border-radius: 10px;
}

.payment-steps ol {
    margin-left: 1.25rem;
    padding-left: 0;
}

.payment-steps li {
    padding: 0.35rem 0;
    color: var(--text-dark);
}

/* ========================================
   FILE UPLOAD
   ======================================== */
.upload-section {
    margin-top: 0.5rem;
}

.upload-area {
    border: 3px dashed var(--border-color);
    border-radius: 15px;
    padding: 2rem;
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
    background: var(--bg-light);
}

.upload-area:hover {
    border-color: var(--kalro-accent);
    background: var(--kalro-light);
}

.file-input {
    display: none;
}

.upload-placeholder i {
    font-size: 3.5rem;
    color: var(--kalro-primary);
    margin-bottom: 1rem;
}

.upload-placeholder p {
    font-size: 1.05rem;
    color: var(--text-dark);
}

.upload-placeholder strong {
    color: var(--kalro-primary);
}

.file-preview {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.25rem;
    background: white;
    border-radius: 10px;
    border: 2px solid var(--kalro-secondary);
}

.file-preview i {
    font-size: 2rem;
    color: var(--kalro-secondary);
    flex-shrink: 0;
}

.file-preview .file-name {
    flex: 1;
    font-weight: 600;
    color: var(--text-dark);
    word-break: break-all;
}

.btn-remove {
    background: #dc3545;
    color: white;
    border: none;
    border-radius: 8px;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.btn-remove:hover {
    background: #c82333;
    transform: scale(1.1);
}

/* ========================================
   TERMS SECTION
   ======================================== */
.terms-section {
    margin-top: 2.5rem;
    padding-top: 2rem;
    border-top: 2px solid #f0f0f0;
}

.custom-checkbox {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
}

.custom-checkbox input[type="checkbox"] {
    width: 22px;
    height: 22px;
    margin-top: 2px;
    cursor: pointer;
    flex-shrink: 0;
    accent-color: var(--kalro-primary);
}

.custom-checkbox label {
    font-size: 1rem;
    color: var(--text-dark);
    cursor: pointer;
    margin: 0;
}

.custom-checkbox a {
    color: var(--kalro-primary);
    text-decoration: none;
    font-weight: 600;
}

.custom-checkbox a:hover {
    text-decoration: underline;
}

/* ========================================
   SECTION FOOTER / BUTTONS
   ======================================== */
.section-footer {
    display: flex;
    justify-content: space-between;
    gap: 1.25rem;
    margin-top: 3rem;
    padding-top: 2rem;
    border-top: 2px solid #f0f0f0;
}

.section-footer .btn {
    min-width: 180px;
    padding: 1rem 2.5rem;
    font-weight: 700;
    font-size: 1.05rem;
    border-radius: 12px;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.btn-primary {
    background: var(--kalro-gradient);
    border: none;
    color: white;
}

.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(45, 122, 62, 0.35);
}

.btn-success {
    background: var(--kalro-gradient);
    border: none;
}

.btn-success:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(45, 122, 62, 0.4);
}

.btn-outline-secondary {
    border: 2px solid var(--border-color);
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
    border-radius: 12px;
    border: none;
    padding: 1.25rem 1.75rem;
    margin-bottom: 1.5rem;
    font-size: 1rem;
}

.alert i {
    font-size: 1.25rem;
}

.alert-success {
    background: var(--kalro-light);
    color: var(--kalro-dark);
    border-left: 4px solid var(--kalro-primary);
}

/* ========================================
   RESPONSIVE DESIGN
   ======================================== */
@media (max-width: 768px) {
    .form-card {
        padding: 2rem 1.5rem;
    }
    
    .attendance-options,
    .payment-methods {
        grid-template-columns: 1fr;
    }
    
    .section-footer {
        flex-direction: column;
    }
    
    .section-footer .btn {
        width: 100%;
        min-width: unset;
    }
    
    .progress-steps {
        padding: 0 10px;
    }
    
    .step-label {
        font-size: 0.75rem;
    }
    
    .step-number {
        width: 45px;
        height: 45px;
        font-size: 1rem;
    }
    
    .section-title {
        font-size: 1.5rem;
    }
    
    .section-title i {
        font-size: 1.5rem;
    }
    
    .attendance-card .card-content {
        flex-direction: column;
        text-align: center;
    }
    
    .check-indicator {
        position: absolute;
        top: 1rem;
        right: 1rem;
    }
}

@media (max-width: 576px) {
    .registration-hero {
        padding: 3rem 0 4rem;
    }
    
    .registration-hero h1 {
        font-size: 2rem;
    }
    
    .form-card {
        padding: 1.5rem 1rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    const nationalitySelect = document.getElementById('nationality');
    const platformRadios = document.querySelectorAll('input[name="platform"]');
    const categorySelect = document.getElementById('category');
    const feeSelect = document.getElementById('fee');
    const feeCurrencyInput = document.getElementById('feeCurrency');
    const studentIdUpload = document.getElementById('studentIdUpload');
    const studentIdInput = document.getElementById('studentId');
    
    // Payment Elements
    const bankRadio = document.getElementById('bank');
    const mpesaRadio = document.getElementById('mpesa');
    const bankDetails = document.getElementById('bankDetails');
    const mpesaDetails = document.getElementById('mpesaDetails');
    
    // Multi-step Elements
    const formSections = document.querySelectorAll('.form-section');
    const progressSteps = document.querySelectorAll('.progress-steps .step');
    const nextBtns = document.querySelectorAll('.next-step');
    const prevBtns = document.querySelectorAll('.prev-step');
    let currentStep = 1;
    
    // ========================================
    // FILE UPLOAD HANDLER
    // ========================================
    function setupFileUpload(uploadAreaId, inputId) {
        const uploadArea = document.getElementById(uploadAreaId);
        const input = document.getElementById(inputId);
        
        if (!uploadArea || !input) return;
        
        const placeholder = uploadArea.querySelector('.upload-placeholder');
        const preview = uploadArea.querySelector('.file-preview');
        const fileNameSpan = preview?.querySelector('.file-name');
        const removeBtn = preview?.querySelector('.btn-remove');
        
        // Click to upload
        uploadArea.addEventListener('click', (e) => {
            if (!e.target.closest('.btn-remove')) {
                input.click();
            }
        });
        
        // Drag and drop
        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.style.borderColor = '#2d7a3e';
        });
        
        uploadArea.addEventListener('dragleave', () => {
            uploadArea.style.borderColor = '';
        });
        
        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.style.borderColor = '';
            if (e.dataTransfer.files.length) {
                input.files = e.dataTransfer.files;
                handleFileSelect(input.files[0]);
            }
        });
        
        // File input change
        input.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                handleFileSelect(this.files[0]);
            }
        });
        
        function handleFileSelect(file) {
            if (fileNameSpan && placeholder && preview) {
                fileNameSpan.textContent = file.name;
                placeholder.style.display = 'none';
                preview.style.display = 'flex';
            }
        }
        
        // Remove file
        removeBtn?.addEventListener('click', (e) => {
            e.stopPropagation();
            input.value = '';
            if (placeholder && preview) {
                preview.style.display = 'none';
                placeholder.style.display = 'block';
            }
        });
    }
    
    setupFileUpload('studentIdUploadArea', 'studentId');
    setupFileUpload('paymentProofUploadArea', 'paymentProof');
    
    // ========================================
    // PAYMENT METHOD TOGGLE
    // ========================================
    bankRadio?.addEventListener('change', function() {
        if (this.checked) {
            bankDetails.style.display = 'block';
            mpesaDetails.style.display = 'none';
        }
    });
    
    mpesaRadio?.addEventListener('change', function() {
        if (this.checked) {
            bankDetails.style.display = 'none';
            mpesaDetails.style.display = 'block';
        }
    });
    
    // ========================================
    // STUDENT ID UPLOAD TOGGLE
    // ========================================
    categorySelect?.addEventListener('change', function() {
        if (this.value === 'student') {
            studentIdUpload.style.display = 'block';
            studentIdInput.required = true;
        } else {
            studentIdUpload.style.display = 'none';
            studentIdInput.required = false;
            studentIdInput.value = '';
        }
        calculateFee();
    });
    
    // ========================================
    // FEE CALCULATION
    // ========================================
    function calculateFee() {
        const nationality = nationalitySelect?.value;
        const platform = document.querySelector('input[name="platform"]:checked')?.value;
        const category = categorySelect?.value;
        
        if (!feeSelect) return;
        
        feeSelect.innerHTML = '<option value="">Please complete the fields above</option>';
        
        if (nationality && platform && category) {
            let feeOptions = [];
            let currency = '';
            
            if (nationality === 'east_african') {
                currency = 'KES';
                if (platform === 'physical') {
                    feeOptions = [
                        { value: '6500', text: `Students: ${currency} 6,500`, category: 'student' },
                        { value: '8500', text: `KALRO Staff: ${currency} 8,500`, category: 'kalro_staff' },
                        { value: '8500', text: `Professionals: ${currency} 8,500`, category: 'professional' }
                    ];
                } else {
                    feeOptions = [
                        { value: '1000', text: `Students: ${currency} 1,000`, category: 'student' },
                        { value: '1000', text: `KALRO Staff: ${currency} 1,000`, category: 'kalro_staff' },
                        { value: '4000', text: `Professionals: ${currency} 4,000`, category: 'professional' }
                    ];
                }
            } else {
                currency = 'USD';
                if (platform === 'physical') {
                    feeOptions = [
                        { value: '65', text: `Students: ${currency} 65`, category: 'student' },
                        { value: '100', text: `Professionals: ${currency} 100`, category: 'professional' }
                    ];
                } else {
                    feeOptions = [
                        { value: '10', text: `Students: ${currency} 10`, category: 'student' },
                        { value: '50', text: `Professionals: ${currency} 50`, category: 'professional' }
                    ];
                }
            }
            
            const filteredOptions = feeOptions.filter(option => option.category === category);
            
            filteredOptions.forEach(option => {
                const optElement = document.createElement('option');
                optElement.value = option.value;
                optElement.textContent = option.text;
                feeSelect.appendChild(optElement);
            });
            
            if (feeCurrencyInput) {
                feeCurrencyInput.value = currency;
            }
            
            if (filteredOptions.length === 0) {
                feeSelect.innerHTML = '<option value="">No fee available for this category</option>';
            }
        }
    }
    
    nationalitySelect?.addEventListener('change', calculateFee);
    platformRadios?.forEach(radio => radio.addEventListener('change', calculateFee));
    
    // ========================================
    // MULTI-STEP NAVIGATION
    // ========================================
    function showStep(step) {
        formSections.forEach((section, index) => {
            section.classList.remove('active');
            progressSteps[index]?.classList.remove('active', 'completed');
        });
        
        const targetSection = document.querySelector(`[data-section="${step}"]`);
        targetSection?.classList.add('active');
        
        progressSteps.forEach((stepEl, index) => {
            if (index + 1 < step) {
                stepEl.classList.add('completed');
            } else if (index + 1 === step) {
                stepEl.classList.add('active');
            }
        });
        
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
    
    nextBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const currentSection = this.closest('.form-section');
            const inputs = currentSection.querySelectorAll('input[required]:not([type="radio"]), select[required], textarea[required]');
            const radioGroups = {};
            
            let valid = true;
            
            // Check regular inputs and selects
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    valid = false;
                    input.classList.add('is-invalid');
                    if (!input.nextElementSibling?.classList.contains('invalid-feedback')) {
                        const feedback = document.createElement('div');
                        feedback.className = 'invalid-feedback';
                        feedback.textContent = 'This field is required';
                        input.parentNode.appendChild(feedback);
                    }
                } else {
                    input.classList.remove('is-invalid');
                }
            });
            
            // Check radio groups
            currentSection.querySelectorAll('input[type="radio"][required]').forEach(radio => {
                if (!radioGroups[radio.name]) {
                    radioGroups[radio.name] = false;
                }
                if (radio.checked) {
                    radioGroups[radio.name] = true;
                }
            });
            
            Object.values(radioGroups).forEach(isChecked => {
                if (!isChecked) valid = false;
            });
            
            if (valid && currentStep < 3) {
                currentStep++;
                showStep(currentStep);
            } else if (!valid) {
                alert('Please fill in all required fields before proceeding.');
            }
        });
    });
    
    prevBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
            }
        });
    });
    
    // Remove invalid class on input
    document.querySelectorAll('.form-control, .form-select').forEach(input => {
        input.addEventListener('input', function() {
            this.classList.remove('is-invalid');
            const feedback = this.parentNode.querySelector('.invalid-feedback');
            if (feedback) feedback.remove();
        });
    });
    
    // Initialize
    showStep(1);
});
</script>
@endsection