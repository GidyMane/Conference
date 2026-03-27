@extends('layouts.header')

@section('title')
    Exhibition Registration
@endsection

@section('content')
<div class="exhibition-wrapper">
    <div class="exhibition-hero">
        <div class="container">
            <div class="hero-content text-center">
                <h1 class="display-4 fw-bold mb-3">KALRO Conference Exhibition</h1>
                <p class="lead">Showcase your innovations and connect with industry leaders</p>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <!-- Progress Steps -->
                <div class="progress-steps mb-5">
                    <div class="step active" data-step="1">
                        <div class="step-circle">
                            <div class="step-number">1</div>
                            <div class="step-icon"><svg viewBox="0 0 24 24" fill="none"><rect x="3" y="7" width="18" height="14" rx="1.5" stroke="currentColor" stroke-width="1.8" fill="none"/><path d="M3 7l9-4 9 4" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" fill="none"/><rect x="9" y="13" width="3" height="4" rx=".5" fill="currentColor" opacity=".5"/><rect x="12" y="13" width="3" height="4" rx=".5" fill="currentColor" opacity=".5"/><rect x="7" y="10" width="2.5" height="2" rx=".4" fill="currentColor" opacity=".6"/><rect x="14.5" y="10" width="2.5" height="2" rx=".4" fill="currentColor" opacity=".6"/></svg></div>
                        </div>
                        <div class="step-label">Organization</div>
                    </div>
                    <div class="progress-line"></div>
                    <div class="step" data-step="2">
                        <div class="step-circle">
                            <div class="step-number">2</div>
                            <div class="step-icon"><svg viewBox="0 0 24 24" fill="none"><path d="M3 9h18l-1.5 9a1.5 1.5 0 01-1.5 1.3H5.9A1.5 1.5 0 014.4 18L3 9z" stroke="currentColor" stroke-width="1.8" fill="none" stroke-linejoin="round"/><path d="M3 9L5 4h14l2 5" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" fill="none"/><path d="M9 9v1a3 3 0 006 0V9" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" fill="none"/><rect x="10" y="14" width="4" height="4" rx=".6" fill="currentColor" opacity=".5"/></svg></div>
                        </div>
                        <div class="step-label">Booth Details</div>
                    </div>
                    <div class="progress-line"></div>
                    <div class="step" data-step="3">
                        <div class="step-circle">
                            <div class="step-number">3</div>
                            <div class="step-icon"><svg viewBox="0 0 24 24" fill="none"><rect x="2" y="5" width="20" height="14" rx="2" stroke="currentColor" stroke-width="1.8" fill="none"/><path d="M2 10h20" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><rect x="5" y="14" width="5" height="2" rx=".5" fill="currentColor" opacity=".6"/><rect x="12" y="14" width="3" height="2" rx=".5" fill="currentColor" opacity=".4"/><rect x="16" y="14" width="3" height="2" rx=".5" fill="currentColor" opacity=".4"/></svg></div>
                        </div>
                        <div class="step-label">Payment</div>
                    </div>
                    <div class="progress-line"></div>
                    <div class="step" data-step="4">
                        <div class="step-circle">
                            <div class="step-number">4</div>
                            <div class="step-icon"><svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="1.8" fill="none"/><circle cx="12" cy="7" r="2" fill="currentColor" opacity=".4"/><path d="M4 20c0-4.418 3.582-8 8-8s8 3.582 8 8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" fill="none"/></svg></div>
                        </div>
                        <div class="step-label">Contact</div>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show"><i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show"><i class="bi bi-exclamation-triangle me-2"></i><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
                @endif

                <div class="form-card">
                    <form id="exhibitionForm" action="{{ route('exhibition.register') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- =====================================================
                             STEP 1: Organization Information
                        ====================================================== -->
                        <div class="form-step active" data-step="1">
                            <div class="step-header">
                                <div class="step-icon-large"><svg viewBox="0 0 24 24" fill="none"><rect x="3" y="7" width="18" height="14" rx="1.5" stroke="currentColor" stroke-width="1.8" fill="none"/><path d="M3 7l9-4 9 4" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" fill="none"/><rect x="9" y="13" width="3" height="4" rx=".5" fill="currentColor" opacity=".5"/><rect x="12" y="13" width="3" height="4" rx=".5" fill="currentColor" opacity=".5"/><rect x="7" y="10" width="2.5" height="2" rx=".4" fill="currentColor" opacity=".6"/><rect x="14.5" y="10" width="2.5" height="2" rx=".4" fill="currentColor" opacity=".6"/></svg></div>
                                <h2 class="step-title">Organization Information</h2>
                                <p class="step-description">Tell us about your organization and what you'll be exhibiting</p>
                            </div>
                            <div class="step-content">
                                <div class="row g-4">
                                    <div class="col-12">
                                        <div class="input-group-modern">
                                            <label for="organizationName" class="form-label"><i class="bi bi-building-fill me-2"></i>Organization Name <span class="required">*</span></label>
                                            <input type="text" class="form-control form-control-lg" id="organizationName" name="organizationName" placeholder="Enter your organization or company name" value="{{ old('organizationName') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="input-group-modern">
                                            <label for="aboutExhibition" class="form-label"><i class="bi bi-card-text me-2"></i>About Your Exhibition <span class="required">*</span></label>
                                            <textarea class="form-control form-control-lg" id="aboutExhibition" name="aboutExhibition" rows="5" placeholder="Describe what you plan to exhibit — products, services, innovations, demonstrations..." required>{{ old('aboutExhibition') }}</textarea>
                                            <small class="form-hint"><i class="bi bi-info-circle me-1"></i>Minimum 50 characters</small>
                                            <div class="char-counter"><span class="current" id="aboutCount">0</span> / 50 minimum</div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="input-group-modern">
                                            <label for="targetAudience" class="form-label"><i class="bi bi-people-fill me-2"></i>Who is/are your target audience? <span class="required">*</span></label>
                                            <textarea class="form-control form-control-lg" id="targetAudience" name="targetAudience" rows="4" placeholder="e.g., Farmers, researchers, agribusiness investors, policy makers, students..." required>{{ old('targetAudience') }}</textarea>
                                            <small class="form-hint"><i class="bi bi-info-circle me-1"></i>Describe the specific groups or sectors you are targeting at this exhibition</small>
                                            <div class="char-counter"><span class="current" id="audienceCount">0</span> / 5 minimum</div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="input-group-modern">
                                            <label for="benefits" class="form-label"><i class="bi bi-star-fill me-2"></i>Benefits to Attendees <span class="required">*</span></label>
                                            <textarea class="form-control form-control-lg" id="benefits" name="benefits" rows="5" placeholder="What will attendees gain from visiting your booth?" required>{{ old('benefits') }}</textarea>
                                            <small class="form-hint"><i class="bi bi-info-circle me-1"></i>Help attendees understand why they should visit your booth</small>
                                            <div class="char-counter"><span class="current" id="benefitsCount">0</span> / 50 minimum</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="step-footer single">
                                <button type="button" class="btn btn-primary btn-lg btn-next">
                                    Continue to Booth Details <i class="bi bi-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- =====================================================
                             STEP 2: Booth Details
                        ====================================================== -->
                        <div class="form-step" data-step="2">
                            <div class="step-header">
                                <div class="step-icon-large"><svg viewBox="0 0 24 24" fill="none"><path d="M3 9h18l-1.5 9a1.5 1.5 0 01-1.5 1.3H5.9A1.5 1.5 0 014.4 18L3 9z" stroke="currentColor" stroke-width="1.8" fill="none" stroke-linejoin="round"/><path d="M3 9L5 4h14l2 5" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" fill="none"/><path d="M9 9v1a3 3 0 006 0V9" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" fill="none"/><rect x="10" y="14" width="4" height="4" rx=".6" fill="currentColor" opacity=".5"/></svg></div>
                                <h2 class="step-title">Customize Your Exhibition Space</h2>
                                <p class="step-description">Choose your space type and quantity. All rates cover both exhibition days.</p>
                            </div>
                            <div class="step-content">
                                <div class="row g-4">
                                    <div class="col-12">
                                        <label class="form-label section-label"><i class="bi bi-grid-3x3 me-2"></i>Select Your Space Type <span class="required">*</span></label>
                                        <div class="package-cards">

                                            <!-- Standard Booth -->
                                            <label class="package-card">
                                                <input type="radio" name="registrationType" value="booth" id="typeBooth" {{ old('registrationType', 'booth') == 'booth' ? 'checked' : '' }} required>
                                                <div class="package-content">
                                                    <div class="package-badge">Most Popular</div>
                                                    <div class="package-icon">
                                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" width="34" height="34">
                                                            <rect x="2" y="7" width="20" height="15" rx="1.5" stroke="currentColor" stroke-width="1.8" fill="none"/>
                                                            <path d="M2 7l10-4 10 4" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" fill="none"/>
                                                            <rect x="9" y="13" width="6" height="5" rx="0.5" stroke="currentColor" stroke-width="1.5" fill="none"/>
                                                            <rect x="4" y="10" width="3" height="2.5" rx="0.4" fill="currentColor" opacity="0.6"/>
                                                            <rect x="17" y="10" width="3" height="2.5" rx="0.4" fill="currentColor" opacity="0.6"/>
                                                        </svg>
                                                    </div>
                                                    <h4 class="package-title">Standard Booth</h4>
                                                    <p class="package-subtitle">3m &times; 3m fully equipped space</p>
                                                    <div class="package-features">
                                                        <div class="feature-item included"><i class="bi bi-check-circle-fill"></i><span>Booth space for <strong>both days</strong></span></div>
                                                        <div class="feature-item included"><i class="bi bi-check-circle-fill"></i><span>2 chairs &amp; 1 table provided</span></div>
                                                        <div class="feature-item included highlight-feature"><i class="bi bi-check-circle-fill"></i><span><strong>Full meals for 2 persons</strong> (both days)</span></div>
                                                        <div class="feature-item included highlight-feature"><i class="bi bi-check-circle-fill"></i><span>2 &times; 500ml water per person daily</span></div>
                                                    </div>
                                                    <div class="package-price">
                                                        <span class="currency">KES</span>
                                                        <span class="amount">10,000</span>
                                                        <span class="per">per booth &bull; 2 days</span>
                                                    </div>
                                                    <div class="selection-indicator"><i class="bi bi-check-circle-fill"></i></div>
                                                </div>
                                            </label>

                                            <!-- Own Tent -->
                                            <label class="package-card">
                                                <input type="radio" name="registrationType" value="own_tent" id="typeOwnTent" {{ old('registrationType') == 'own_tent' ? 'checked' : '' }}>
                                                <div class="package-content">
                                                    <div class="package-icon">
                                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" width="34" height="34">
                                                            <path d="M3 10.5L12 3l9 7.5V21a1 1 0 01-1 1H5a1 1 0 01-1-1V10.5z" stroke="currentColor" stroke-width="1.8" fill="none" stroke-linejoin="round"/>
                                                            <path d="M9 22V13h6v9" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" fill="none"/>
                                                        </svg>
                                                    </div>
                                                    <h4 class="package-title">Own Tent</h4>
                                                    <p class="package-subtitle">Bring your own tent &amp; furniture</p>
                                                    <div class="package-features">
                                                        <div class="feature-item included"><i class="bi bi-check-circle-fill"></i><span>Exhibition grounds for <strong>both days</strong></span></div>
                                                        <div class="feature-item included highlight-feature"><i class="bi bi-check-circle-fill"></i><span><strong>Full meals for 2 persons</strong> (both days)</span></div>
                                                        <div class="feature-item included highlight-feature"><i class="bi bi-check-circle-fill"></i><span>2 &times; 500ml water per person daily</span></div>
                                                        <div class="feature-item excluded"><i class="bi bi-x-circle-fill"></i><span>No tent or furniture provided</span></div>
                                                    </div>
                                                    <div class="package-price">
                                                        <span class="currency">KES</span>
                                                        <span class="amount">5,000</span>
                                                        <span class="per">per tent &bull; 2 days</span>
                                                    </div>
                                                    <div class="selection-indicator"><i class="bi bi-check-circle-fill"></i></div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Quantity Counter -->
                                    <div class="col-12">
                                        <label class="form-label section-label"><i class="bi bi-layers me-2"></i>How many <span id="spaceTypeLabel">booths</span> do you need?</label>
                                        <div class="booth-counter-card">
                                            <div class="counter-wrapper">
                                                <button type="button" class="counter-btn" id="decrementBooth">
                                                    <span class="symbol">&#8722;</span>
                                                </button>
                                                <div class="counter-display">
                                                    <input type="number" class="form-control" id="boothCount" name="boothCount" min="1" max="10" value="{{ old('boothCount', 1) }}" required readonly>
                                                    <span class="counter-label" id="counterLabel">Booth Selected</span>
                                                </div>
                                                <button type="button" class="counter-btn" id="incrementBooth">
                                                    <span class="symbol">&#43;</span>
                                                </button>
                                            </div>
                                            <p class="counter-note mt-2" id="counterNote">
                                                <i class="bi bi-info-circle me-1"></i>
                                                Each booth is <strong>3m &times; 3m</strong> and accommodates up to <strong>2 exhibitors</strong>
                                            </p>
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
                                                    <span class="label">Space Type:</span>
                                                    <span class="value" id="displayPackage">Standard Booth</span>
                                                </div>
                                                <div class="summary-row">
                                                    <span class="label">Quantity:</span>
                                                    <span class="value" id="displayBoothCount">1</span>
                                                </div>
                                                <div class="summary-row">
                                                    <span class="label">Price per Unit:</span>
                                                    <span class="value" id="displayPricePerBooth">KES 10,000</span>
                                                </div>
                                                <div class="summary-row">
                                                    <span class="label">Duration:</span>
                                                    <span class="value">2 Exhibition Days</span>
                                                </div>
                                                <div class="summary-divider"></div>
                                                <div class="summary-total">
                                                    <span class="label">Total Amount:</span>
                                                    <span class="amount" id="totalCost">KES 10,000</span>
                                                </div>
                                            </div>
                                            <input type="hidden" id="calculatedTotal" name="calculatedTotal" value="10000">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="step-footer">
                                <button type="button" class="btn btn-outline-secondary btn-lg btn-prev"><i class="bi bi-arrow-left me-2"></i>Back</button>
                                <button type="button" class="btn btn-primary btn-lg btn-next">Continue to Payment <i class="bi bi-arrow-right ms-2"></i></button>
                            </div>
                        </div>

                        <!-- =====================================================
                             STEP 3: Payment
                        ====================================================== -->
                        <div class="form-step" data-step="3">
                            <div class="step-header">
                                <div class="step-icon-large"><svg viewBox="0 0 24 24" fill="none"><rect x="2" y="5" width="20" height="14" rx="2" stroke="currentColor" stroke-width="1.8" fill="none"/><path d="M2 10h20" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><rect x="5" y="14" width="5" height="2" rx=".5" fill="currentColor" opacity=".6"/><rect x="12" y="14" width="3" height="2" rx=".5" fill="currentColor" opacity=".4"/><rect x="16" y="14" width="3" height="2" rx=".5" fill="currentColor" opacity=".4"/></svg></div>
                                <h2 class="step-title">Payment Information</h2>
                                <p class="step-description">Complete your payment to secure your exhibition space</p>
                            </div>
                            <div class="step-content">
                                <div class="row g-4">

                                    <!-- Amount Reminder -->
                                    <div class="col-12">
                                        <div class="payment-reminder">
                                            <i class="bi bi-receipt-cutoff"></i>
                                            <div class="reminder-main">
                                                <span class="reminder-label">Amount to Pay</span>
                                                <span class="reminder-amount" id="paymentReminderAmount">KES 10,000</span>
                                            </div>
                                            <span class="reminder-detail" id="paymentReminderDetail">1 &times; Standard Booth</span>
                                        </div>
                                    </div>

                                    <!-- Payment Method -->
                                    <div class="col-12">
                                        <label class="form-label section-label"><i class="bi bi-wallet2 me-2"></i>Select Payment Method <span class="required">*</span></label>
                                        <div class="payment-method-cards">
                                            <label class="payment-method-card">
                                                <input type="radio" name="paymentMethod" value="bank" required>
                                                <div class="method-content">
                                                    <div class="method-icon">
                                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" width="28" height="28">
                                                            <path d="M3 9.5L12 3l9 6.5" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" fill="none"/>
                                                            <rect x="2" y="9" width="20" height="2" rx="0.5" fill="currentColor" opacity="0.5"/>
                                                            <rect x="2" y="19" width="20" height="2" rx="0.5" fill="currentColor" opacity="0.5"/>
                                                            <rect x="4" y="11" width="3" height="8" rx="0.4" fill="none" stroke="currentColor" stroke-width="1.6"/>
                                                            <rect x="10.5" y="11" width="3" height="8" rx="0.4" fill="none" stroke="currentColor" stroke-width="1.6"/>
                                                            <rect x="17" y="11" width="3" height="8" rx="0.4" fill="none" stroke="currentColor" stroke-width="1.6"/>
                                                        </svg>
                                                    </div>
                                                    <div class="method-info"><h5>Bank Transfer</h5><p>Direct deposit to our bank account</p></div>
                                                    <div class="method-check"><i class="bi bi-check-circle-fill"></i></div>
                                                </div>
                                            </label>
                                            <label class="payment-method-card">
                                                <input type="radio" name="paymentMethod" value="mpesa">
                                                <div class="method-content">
                                                    <div class="method-icon">
                                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" width="28" height="28">
                                                            <rect x="6" y="2" width="12" height="20" rx="2.5" stroke="currentColor" stroke-width="1.8" fill="none"/>
                                                            <circle cx="12" cy="18" r="1.2" fill="currentColor" opacity="0.7"/>
                                                            <rect x="9" y="5" width="6" height="1.2" rx="0.6" fill="currentColor" opacity="0.5"/>
                                                            <rect x="8" y="8" width="8" height="6" rx="0.8" fill="currentColor" opacity="0.15" stroke="currentColor" stroke-width="1.2"/>
                                                            <path d="M10 10.5l1.5 1.5 2.5-2.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg>
                                                    </div>
                                                    <div class="method-info"><h5>M-Pesa</h5><p>Pay via mobile money</p></div>
                                                    <div class="method-check"><i class="bi bi-check-circle-fill"></i></div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Bank Details -->
                                    <div class="col-12">
                                        <div id="bankDetails" class="payment-info-modern" style="display:none;">
                                            <div class="info-header"><i class="bi bi-bank2"></i><h5>Bank Transfer Details</h5></div>
                                            <div class="info-grid">
                                                <div class="info-item highlight"><span class="info-label">Account Name</span><span class="info-value large">KALRO EAAPP</span></div>
                                                <div class="info-item highlight"><span class="info-label">Account Number</span><span class="info-value large">1116139030</span></div>
                                                <div class="info-item"><span class="info-label">Bank Name</span><span class="info-value">KCB Ltd</span></div>
                                                <div class="info-item"><span class="info-label">Bank Branch</span><span class="info-value">K.I.C.C</span></div>
                                                <div class="info-item"><span class="info-label">Bank Code</span><span class="info-value">01104</span></div>
                                                <div class="info-item"><span class="info-label">Swift Code</span><span class="info-value">KCBLKENX</span></div>
                                            </div>
                                        </div>

                                        <!-- M-Pesa Details -->
                                        <div id="mpesaDetails" class="payment-info-modern" style="display:none;">
                                            <div class="info-header"><i class="bi bi-phone-fill"></i><h5>M-Pesa Payment Details</h5></div>
                                            <div class="info-grid simple">
                                                <div class="info-item highlight"><span class="info-label">Paybill Number</span><span class="info-value large">522522</span></div>
                                                <div class="info-item highlight"><span class="info-label">Account Number</span><span class="info-value large">1116139030</span></div>
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
                                    <div class="col-12" id="transactionSection" style="display:none;">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="input-group-modern">
                                                    <label for="receiptNumber" class="form-label"><i class="bi bi-receipt me-2"></i>Transaction Reference <span class="required">*</span></label>
                                                    <input type="text" class="form-control form-control-lg" id="receiptNumber" name="receiptNumber" placeholder="Enter your payment confirmation code" value="{{ old('receiptNumber') }}">
                                                    <small class="form-hint"><i class="bi bi-info-circle me-1"></i>The reference code from your payment receipt</small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label"><i class="bi bi-cloud-upload me-2"></i>Payment Proof <span class="required">*</span></label>
                                                <div class="file-upload-modern" id="paymentProofUpload">
                                                    <input type="file" class="file-input" id="paymentProof" name="paymentProof" accept="image/*,.pdf">
                                                    <div class="upload-area">
                                                        <i class="bi bi-cloud-arrow-up"></i>
                                                        <span class="upload-text">Click to upload or drag &amp; drop</span>
                                                        <small class="upload-hint">PNG, JPG, PDF (Max 5MB)</small>
                                                    </div>
                                                    <div class="file-preview-modern" style="display:none;">
                                                        <div class="file-icon"><i class="bi bi-file-earmark-check-fill"></i></div>
                                                        <div class="file-info">
                                                            <span class="file-name"></span>
                                                            <span class="file-size"></span>
                                                        </div>
                                                        <button type="button" class="file-remove"><i class="bi bi-x-lg"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="step-footer">
                                <button type="button" class="btn btn-outline-secondary btn-lg btn-prev"><i class="bi bi-arrow-left me-2"></i>Back</button>
                                <button type="button" class="btn btn-primary btn-lg btn-next">Continue to Contact Info <i class="bi bi-arrow-right ms-2"></i></button>
                            </div>
                        </div>

                        <!-- =====================================================
                             STEP 4: Contact Information
                        ====================================================== -->
                        <div class="form-step" data-step="4">
                            <div class="step-header">
                                <div class="step-icon-large"><svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="1.8" fill="none"/><circle cx="12" cy="7" r="2" fill="currentColor" opacity=".4"/><path d="M4 20c0-4.418 3.582-8 8-8s8 3.582 8 8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" fill="none"/></svg></div>
                                <h2 class="step-title">Contact Information</h2>
                                <p class="step-description">Who should we contact regarding this exhibition?</p>
                            </div>
                            <div class="step-content">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="input-group-modern">
                                            <label for="contactName" class="form-label"><i class="bi bi-person-fill me-2"></i>Full Name <span class="required">*</span></label>
                                            <input type="text" class="form-control form-control-lg" id="contactName" name="contactName" placeholder="Contact person's full name" value="{{ old('contactName') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group-modern">
                                            <label for="contactRole" class="form-label"><i class="bi bi-briefcase-fill me-2"></i>Role / Position <span class="required">*</span></label>
                                            <input type="text" class="form-control form-control-lg" id="contactRole" name="contactRole" placeholder="e.g., Director, Manager, CEO" value="{{ old('contactRole') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group-modern">
                                            <label for="contactPhone" class="form-label"><i class="bi bi-telephone-fill me-2"></i>Phone Number <span class="required">*</span></label>
                                            <input type="tel" class="form-control form-control-lg" id="contactPhone" name="contactPhone" placeholder="+254 712 345 678" value="{{ old('contactPhone') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group-modern">
                                            <label for="contactEmail" class="form-label"><i class="bi bi-envelope-fill me-2"></i>Email Address <span class="required">*</span></label>
                                            <input type="email" class="form-control form-control-lg" id="contactEmail" name="contactEmail" placeholder="email@example.com" value="{{ old('contactEmail') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label section-label"><i class="bi bi-person-badge me-2"></i>Team Leader? <span class="required">*</span></label>
                                        <div class="toggle-group">
                                            <label class="toggle-option">
                                                <input type="radio" name="isTeamLeader" value="yes" {{ old('isTeamLeader') == 'yes' ? 'checked' : '' }} required>
                                                <span class="toggle-content"><i class="bi bi-check-circle"></i><span>Yes, I'm leading</span></span>
                                            </label>
                                            <label class="toggle-option">
                                                <input type="radio" name="isTeamLeader" value="no" {{ old('isTeamLeader', 'no') == 'no' ? 'checked' : '' }}>
                                                <span class="toggle-content"><i class="bi bi-x-circle"></i><span>No, someone else</span></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group-modern">
                                            <label for="teamSize" class="form-label"><i class="bi bi-people-fill me-2"></i>Team Size <span class="required">*</span></label>
                                            <input type="number" class="form-control form-control-lg" id="teamSize" name="teamSize" min="1" max="20" value="{{ old('teamSize', 2) }}" required>
                                            <small class="form-hint"><i class="bi bi-info-circle me-1"></i>Note: Meals are provided for 2 persons per space only</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="terms-section">
                                <div class="terms-card">
                                    <div class="terms-checkbox">
                                        <input type="checkbox" id="terms" name="terms" required>
                                        <label for="terms">
                                            <span class="checkbox-box"><i class="bi bi-check"></i></span>
                                            <span class="checkbox-text">
                                                I have read and agree to the
                                                <a href="{{ route('terms', ['from' => route('exhibition.register.form')]) }}" target="_blank">terms and conditions</a>
                                                <span class="required">*</span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="step-footer">
                                <button type="button" class="btn btn-outline-secondary btn-lg btn-prev"><i class="bi bi-arrow-left me-2"></i>Back</button>
                                <button type="submit" class="btn btn-success btn-lg btn-submit"><i class="bi bi-check-circle me-2"></i>Complete Registration</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
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
}

.exhibition-wrapper { min-height: 100vh; background: linear-gradient(135deg, #f0f9f4 0%, #e6f4ec 100%); }

/* HERO */
.exhibition-hero { background: var(--kalro-gradient); padding: 2.5rem 0 4rem; color: white; margin-bottom: -2.5rem; clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%); box-shadow: 0 4px 20px rgba(26,95,58,.2); }
.exhibition-hero h1 { font-weight: 700; letter-spacing: -1px; text-shadow: 2px 2px 4px rgba(0,0,0,.1); font-size: 2.25rem; }
.exhibition-hero .lead { color: rgba(255,255,255,.95); font-size: 1rem; }

/* PROGRESS */
.progress-steps { display: flex; align-items: center; justify-content: center; padding: 0 20px; max-width: 900px; margin: 0 auto; }
.step { display: flex; flex-direction: column; align-items: center; gap: .5rem; flex: 0 0 auto; }
.step-circle { width: 60px; height: 60px; border-radius: 16px; background: white; border: 2.5px solid var(--border-color); display: flex; align-items: center; justify-content: center; position: relative; transition: all .4s ease; box-shadow: 0 3px 10px rgba(0,0,0,.07); }
.step-number { position: absolute; font-weight: 800; font-size: .65rem; color: var(--text-muted); top: -8px; right: -8px; width: 20px; height: 20px; background: white; border: 2px solid var(--border-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: all .4s ease; }
.step-icon { opacity: 0; transform: scale(0); transition: all .4s ease; display: flex; align-items: center; justify-content: center; }
.step-icon svg { width: 26px; height: 26px; color: var(--kalro-primary); }
.step.active .step-circle, .step.completed .step-circle { background: var(--kalro-gradient); border-color: var(--kalro-primary); transform: scale(1.08); box-shadow: 0 8px 20px rgba(26,95,58,.3); border-radius: 18px; }
.step.active .step-number, .step.completed .step-number { background: var(--kalro-primary); border-color: var(--kalro-primary); color: white; font-weight: 800; }
.step.active .step-icon, .step.completed .step-icon { opacity: 1; transform: scale(1); }
.step.active .step-icon svg, .step.completed .step-icon svg { color: white; }
.step-label { font-size: .8rem; font-weight: 600; color: var(--text-muted); text-align: center; transition: all .3s ease; }
.step.active .step-label { color: var(--kalro-primary); font-weight: 700; }
.progress-line { height: 3px; flex: 1; background: var(--border-color); margin: 0 .75rem; border-radius: 2px; overflow: hidden; position: relative; }
.progress-line::after { content: ''; position: absolute; left: 0; top: 0; height: 100%; width: 0; background: var(--kalro-gradient); transition: width .6s ease; }
.step.completed + .progress-line::after { width: 100%; }

/* FORM CARD */
.form-card { background: white; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,.08); padding: 0; margin-top: 1.5rem; overflow: hidden; }
.form-step { display: none; animation: fadeSlideIn .4s ease; padding: 2.5rem; }
.form-step.active { display: block; }
@keyframes fadeSlideIn { from { opacity: 0; transform: translateX(24px); } to { opacity: 1; transform: translateX(0); } }

/* STEP HEADER */
.step-header { text-align: center; margin-bottom: 2.5rem; padding-bottom: 1.75rem; border-bottom: 2px solid var(--kalro-light); }
.step-icon-large { width: 76px; height: 76px; border-radius: 20px; background: var(--kalro-gradient); display: inline-flex; align-items: center; justify-content: center; margin-bottom: 1.25rem; box-shadow: 0 8px 24px rgba(26,95,58,.25); }
.step-icon-large svg { width: 38px; height: 38px; color: white; }
.step-title { font-size: 1.65rem; font-weight: 700; color: var(--text-dark); margin-bottom: .5rem; }
.step-description { font-size: .95rem; color: var(--text-muted); margin: 0; }

/* INPUTS */
.input-group-modern { position: relative; margin-bottom: .25rem; }
.form-label { font-weight: 600; color: var(--text-dark); margin-bottom: .6rem; font-size: .9rem; display: flex; align-items: center; flex-wrap: wrap; gap: .2rem; }
.form-label i { color: var(--kalro-primary); font-size: .95rem; }
.section-label { font-size: 1rem; font-weight: 700; margin-bottom: 1rem; color: var(--kalro-dark); }
.required { color: #dc2626; margin-left: .2rem; }
.form-control { border: 2px solid var(--border-color); border-radius: 10px; padding: .75rem 1rem; font-size: .95rem; transition: all .3s ease; background: white; color: var(--text-dark); }
.form-control-lg { padding: .85rem 1.15rem; font-size: 1rem; min-height: 50px; }
.form-control:focus { border-color: var(--kalro-primary); box-shadow: 0 0 0 3px rgba(26,95,58,.08); outline: none; }
textarea.form-control { resize: vertical; min-height: 110px; }
.form-hint { display: block; margin-top: .4rem; color: var(--text-muted); font-size: .8rem; }
.char-counter { position: absolute; right: .85rem; bottom: -1.6rem; font-size: .75rem; color: var(--text-muted); font-weight: 600; }
.char-counter .current { color: var(--kalro-primary); font-weight: 700; }

/* PACKAGES */
.package-cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(270px, 1fr)); gap: 1.5rem; }
.package-card { cursor: pointer; position: relative; display: block; }
.package-card input[type="radio"] { position: absolute; opacity: 0; pointer-events: none; }
.package-content { background: white; border: 2.5px solid var(--border-color); border-radius: 18px; padding: 1.75rem; text-align: center; transition: all .4s ease; position: relative; height: 100%; display: flex; flex-direction: column; }
.package-card:hover .package-content { border-color: var(--kalro-accent); transform: translateY(-6px); box-shadow: 0 14px 32px rgba(26,95,58,.12); }
.package-card input:checked ~ .package-content { background: var(--kalro-gradient); border-color: var(--kalro-primary); transform: translateY(-8px); box-shadow: 0 18px 44px rgba(26,95,58,.28); }
.package-badge { position: absolute; top: -12px; left: 50%; transform: translateX(-50%); background: var(--kalro-accent); color: white; font-size: .7rem; font-weight: 700; padding: .25rem .85rem; border-radius: 100px; letter-spacing: .05em; text-transform: uppercase; white-space: nowrap; }
.package-icon { width: 65px; height: 65px; border-radius: 16px; background: var(--kalro-light); display: inline-flex; align-items: center; justify-content: center; margin-bottom: 1rem; margin-top: .5rem; transition: all .4s ease; }
/* SVG icons inside package cards */
.package-icon svg { color: var(--kalro-primary); transition: color .4s ease; }
.package-card input:checked ~ .package-content .package-icon { background: rgba(255,255,255,.2); }
.package-card input:checked ~ .package-content .package-icon svg { color: white; }
.package-title { font-size: 1.2rem; font-weight: 700; color: var(--text-dark); margin-bottom: .25rem; transition: all .4s ease; }
.package-subtitle { font-size: .82rem; color: var(--text-muted); margin-bottom: 1rem; transition: all .4s ease; }
.package-card input:checked ~ .package-content .package-title,
.package-card input:checked ~ .package-content .package-subtitle { color: rgba(255,255,255,.9); }
.package-features { text-align: left; margin-bottom: 1rem; flex: 1; }
.feature-item { display: flex; align-items: flex-start; gap: 7px; margin-bottom: 7px; font-size: .83rem; }
.feature-item i { font-size: 1rem; margin-top: 1px; flex-shrink: 0; }
.feature-item.included i { color: #16a34a; }
.feature-item.excluded i { color: #dc2626; }
.highlight-feature { background: rgba(22,163,74,.07); padding: 5px 8px; border-radius: 6px; }
.feature-item span { color: var(--text-dark); transition: all .4s ease; }
.package-card input:checked ~ .package-content .feature-item i,
.package-card input:checked ~ .package-content .feature-item span { color: white; }
.package-card input:checked ~ .package-content .feature-item.excluded i { color: rgba(255,255,255,.6); }
.package-price { margin-top: auto; padding-top: 1rem; border-top: 1px solid var(--border-color); }
.package-card input:checked ~ .package-content .package-price { border-top-color: rgba(255,255,255,.25); }
.package-price .currency { font-size: .9rem; font-weight: 600; color: var(--text-muted); transition: all .4s ease; }
.package-price .amount { font-size: 2.25rem; font-weight: 800; color: var(--kalro-primary); display: block; line-height: 1.1; margin: .2rem 0; transition: all .4s ease; }
.package-price .per { font-size: .78rem; color: var(--text-muted); transition: all .4s ease; }
.package-card input:checked ~ .package-content .package-price .currency,
.package-card input:checked ~ .package-content .package-price .amount,
.package-card input:checked ~ .package-content .package-price .per { color: white; }
.selection-indicator { position: absolute; top: 1.1rem; left: 1.1rem; font-size: 1.65rem; color: var(--success); opacity: 0; transform: scale(0); transition: all .4s ease; }
.package-card input:checked ~ .package-content .selection-indicator { opacity: 1; transform: scale(1); color: white; }

/* BOOTH COUNTER */
.booth-counter-card { background: var(--kalro-light); border: 2px solid var(--kalro-accent); border-radius: 16px; padding: 1.75rem; text-align: center; }
.counter-wrapper { display: flex; align-items: center; justify-content: center; gap: 1.5rem; margin-bottom: .75rem; }
.counter-btn { width: 50px; height: 50px; border-radius: 12px; background: white; border: 2px solid var(--kalro-primary); color: var(--kalro-primary); font-size: 1.5rem; font-weight: 700; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all .3s ease; user-select: none; }
.counter-btn:hover { background: var(--kalro-gradient); color: white; transform: scale(1.08); box-shadow: 0 5px 12px rgba(26,95,58,.25); }
.counter-display { text-align: center; }
.counter-display .form-control { width: 100px; text-align: center; font-size: 2rem; font-weight: 700; color: var(--kalro-primary); border: none; background: transparent; padding: 0; pointer-events: none; }
.counter-label { display: block; margin-top: .35rem; font-size: .9rem; font-weight: 600; color: var(--kalro-dark); }
.counter-note { color: var(--text-muted); font-size: .82rem; margin: 0; }

/* COST SUMMARY */
.cost-summary-modern { background: white; border: 2px solid var(--kalro-primary); border-radius: 16px; overflow: hidden; box-shadow: 0 8px 20px rgba(26,95,58,.1); }
.summary-header { background: var(--kalro-gradient); color: white; padding: 1.1rem 1.5rem; display: flex; align-items: center; gap: .6rem; }
.summary-header i { font-size: 1.5rem; }
.summary-header h5 { margin: 0; font-size: 1.05rem; font-weight: 700; }
.summary-body { padding: 1.5rem; }
.summary-row { display: flex; justify-content: space-between; align-items: center; padding: .7rem 0; border-bottom: 1px solid #f0f0f0; }
.summary-row:last-child { border-bottom: none; }
.summary-row .label { color: var(--text-muted); font-weight: 600; font-size: .88rem; }
.summary-row .value { color: var(--text-dark); font-weight: 700; font-size: .92rem; }
.summary-divider { height: 1.5px; background: var(--kalro-light); margin: .85rem 0; }
.summary-total { display: flex; justify-content: space-between; align-items: center; padding: 1.1rem; background: var(--kalro-light); border-radius: 10px; }
.summary-total .label { font-size: 1rem; font-weight: 700; color: var(--kalro-dark); }
.summary-total .amount { font-size: 1.75rem; font-weight: 800; color: var(--kalro-primary); }

/* PAYMENT REMINDER */
.payment-reminder { display: flex; align-items: center; gap: 1rem; background: var(--kalro-light); border: 2px solid var(--kalro-accent); border-radius: 14px; padding: 1.25rem 1.5rem; }
.payment-reminder > i { font-size: 2rem; color: var(--kalro-primary); flex-shrink: 0; }
.reminder-main { display: flex; flex-direction: column; flex: 1; }
.reminder-label { font-size: .8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: .06em; }
.reminder-amount { font-size: 1.65rem; font-weight: 800; color: var(--kalro-dark); line-height: 1.2; }
.reminder-detail { font-size: .85rem; color: var(--text-muted); font-weight: 600; flex-shrink: 0; }

/* PAYMENT METHODS */
.payment-method-cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); gap: 1.25rem; }
.payment-method-card { cursor: pointer; display: block; position: relative; }
.payment-method-card input[type="radio"] { position: absolute; opacity: 0; pointer-events: none; }
.method-content { display: flex; align-items: center; gap: 1rem; padding: 1.35rem; background: white; border: 2px solid var(--border-color); border-radius: 14px; transition: all .4s ease; }
.payment-method-card:hover .method-content { border-color: var(--kalro-accent); transform: translateY(-3px); box-shadow: 0 8px 20px rgba(26,95,58,.12); }
.payment-method-card input:checked ~ .method-content { background: var(--kalro-gradient); border-color: var(--kalro-primary); box-shadow: 0 10px 25px rgba(26,95,58,.2); }
.method-icon { width: 50px; height: 50px; border-radius: 12px; background: var(--kalro-light); display: flex; align-items: center; justify-content: center; flex-shrink: 0; transition: all .4s ease; }
.method-icon i,
.method-icon svg { font-size: 1.65rem; color: var(--kalro-primary); transition: all .4s ease; }
.payment-method-card input:checked ~ .method-content .method-icon { background: rgba(255,255,255,.2); }
.payment-method-card input:checked ~ .method-content .method-icon i,
.payment-method-card input:checked ~ .method-content .method-icon svg { color: white; }
.method-info { flex: 1; }
.method-info h5 { margin: 0 0 .2rem 0; font-size: 1rem; font-weight: 700; color: var(--text-dark); transition: all .4s ease; }
.method-info p { margin: 0; font-size: .8rem; color: var(--text-muted); transition: all .4s ease; }
.payment-method-card input:checked ~ .method-content .method-info h5,
.payment-method-card input:checked ~ .method-content .method-info p { color: white; }
.method-check { flex-shrink: 0; opacity: 0; transform: scale(0); transition: all .4s ease; }
.method-check i { font-size: 1.65rem; color: white; }
.payment-method-card input:checked ~ .method-content .method-check { opacity: 1; transform: scale(1); }

/* PAYMENT INFO CARDS */
.payment-info-modern { background: white; border: 2px solid var(--border-color); border-radius: 14px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,.06); animation: slideDown .4s ease; }
@keyframes slideDown { from { opacity: 0; transform: translateY(-12px); } to { opacity: 1; transform: translateY(0); } }
.info-header { background: var(--kalro-gradient); color: white; padding: 1.1rem 1.5rem; display: flex; align-items: center; gap: .6rem; }
.info-header i { font-size: 1.5rem; }
.info-header h5 { margin: 0; font-size: 1.05rem; font-weight: 700; }
.info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); padding: 1.25rem; gap: 0; }
.info-grid.simple { grid-template-columns: repeat(auto-fit, minmax(170px, 1fr)); }
.info-item { display: flex; flex-direction: column; gap: .35rem; padding: .85rem; border-bottom: 1px solid #f4f4f4; border-right: 1px solid #f4f4f4; }
.info-item:nth-child(2n) { border-right: none; }
.info-item.highlight { background: var(--kalro-light); border-radius: 8px; margin: .4rem; border: 1.5px solid var(--kalro-accent); }
.info-label { font-size: .78rem; color: var(--text-muted); font-weight: 600; }
.info-value { font-size: .9rem; color: var(--text-dark); font-weight: 700; }
.info-value.large { font-size: 1.2rem; color: var(--kalro-primary); }
.mpesa-steps { padding: 1.1rem 1.5rem; background: var(--bg-light); border-top: 2px solid var(--border-color); }
.mpesa-steps h6 { color: var(--kalro-dark); font-weight: 700; margin-bottom: .7rem; font-size: .9rem; }
.mpesa-steps ol { margin: 0; padding-left: 1.25rem; }
.mpesa-steps li { padding: .35rem 0; color: var(--text-dark); font-size: .85rem; }

/* FILE UPLOAD */
.file-upload-modern { position: relative; }
.file-input { display: none; }
.upload-area { border: 2px dashed var(--border-color); border-radius: 12px; padding: 1.5rem; text-align: center; cursor: pointer; transition: all .3s ease; background: var(--bg-light); }
.upload-area:hover { border-color: var(--kalro-accent); background: var(--kalro-light); }
.upload-area i { font-size: 2.5rem; color: var(--kalro-primary); display: block; margin-bottom: .65rem; }
.upload-text { display: block; font-weight: 600; color: var(--kalro-primary); margin-bottom: .35rem; font-size: .9rem; }
.upload-hint { display: block; color: var(--text-muted); font-size: .75rem; }
.file-preview-modern { display: flex; align-items: center; gap: .85rem; padding: 1rem; background: white; border: 2px solid var(--kalro-primary); border-radius: 10px; }
.file-icon { width: 42px; height: 42px; border-radius: 8px; background: var(--kalro-light); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.file-icon i { font-size: 1.65rem; color: var(--kalro-primary); }
.file-info { flex: 1; display: flex; flex-direction: column; gap: .2rem; }
.file-name { font-weight: 600; color: var(--text-dark); word-break: break-all; font-size: .85rem; }
.file-size { font-size: .75rem; color: var(--text-muted); }
.file-remove { width: 34px; height: 34px; border-radius: 8px; background: #dc2626; color: white; border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all .3s ease; flex-shrink: 0; }
.file-remove:hover { background: #b91c1c; transform: scale(1.08); }

/* TOGGLE */
.toggle-group { display: flex; gap: .75rem; }
.toggle-option { flex: 1; cursor: pointer; }
.toggle-option input[type="radio"] { display: none; }
.toggle-content { display: flex; align-items: center; justify-content: center; gap: .6rem; padding: .85rem 1rem; background: white; border: 2px solid var(--border-color); border-radius: 10px; font-weight: 600; color: var(--text-dark); transition: all .3s ease; font-size: .88rem; }
.toggle-content i { font-size: 1.2rem; color: var(--text-muted); transition: all .3s ease; }
.toggle-option:hover .toggle-content { border-color: var(--kalro-accent); background: var(--kalro-light); }
.toggle-option input:checked ~ .toggle-content { background: var(--kalro-gradient); border-color: var(--kalro-primary); color: white; box-shadow: 0 5px 12px rgba(26,95,58,.2); }
.toggle-option input:checked ~ .toggle-content i { color: white; }

/* TERMS */
.terms-section { margin-top: 2rem; padding-top: 1.5rem; border-top: 2px solid var(--border-color); }
.terms-card { background: var(--kalro-light); border: 2px solid var(--kalro-accent); border-radius: 12px; padding: 1.25rem; }
.terms-checkbox { display: flex; align-items: flex-start; gap: .85rem; }
.terms-checkbox input[type="checkbox"] { display: none; }
.checkbox-box { width: 24px; height: 24px; border: 2px solid var(--border-color); border-radius: 6px; display: flex; align-items: center; justify-content: center; background: white; flex-shrink: 0; transition: all .3s ease; cursor: pointer; }
.checkbox-box i { font-size: 1.1rem; color: white; opacity: 0; transform: scale(0); transition: all .3s ease; }
.terms-checkbox input:checked ~ label .checkbox-box { background: var(--kalro-gradient); border-color: var(--kalro-primary); }
.terms-checkbox input:checked ~ label .checkbox-box i { opacity: 1; transform: scale(1); }
.checkbox-text { flex: 1; font-size: .9rem; color: var(--text-dark); line-height: 1.5; cursor: pointer; }
.checkbox-text a { color: var(--kalro-primary); text-decoration: none; font-weight: 700; }
.checkbox-text a:hover { text-decoration: underline; }

/* FOOTER */
.step-footer { display: flex; justify-content: space-between; gap: 1rem; margin-top: 2.5rem; padding-top: 2rem; border-top: 2px solid var(--border-color); }
.step-footer.single { justify-content: flex-end; }
.step-footer .btn { min-width: 160px; padding: .85rem 2rem; font-weight: 700; font-size: .95rem; border-radius: 10px; transition: all .3s ease; text-transform: uppercase; letter-spacing: .4px; box-shadow: 0 3px 10px rgba(0,0,0,.08); }
.btn-primary { background: var(--kalro-gradient); border: none; color: white; }
.btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(26,95,58,.3); }
.btn-success { background: linear-gradient(135deg, #10b981 0%, #059669 100%); border: none; color: white; }
.btn-success:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(16,185,129,.35); }
.btn-outline-secondary { border: 2px solid var(--border-color); color: var(--text-dark); background: white; }
.btn-outline-secondary:hover { background: var(--bg-light); border-color: var(--text-muted); }

/* ALERTS */
.alert { border-radius: 12px; border: none; padding: 1rem 1.35rem; margin-bottom: 1.25rem; }
.alert-success { background: var(--kalro-light); color: var(--kalro-dark); border-left: 4px solid var(--kalro-primary); }

/* RESPONSIVE */
@media (max-width: 992px) {
    .form-step { padding: 2rem 1.5rem; }
    .package-cards { grid-template-columns: 1fr; }
    .info-item { border-right: none; }
}
@media (max-width: 768px) {
    .step-circle { width: 48px; height: 48px; }
    .step-icon svg { width: 22px; height: 22px; }
    .step-label { font-size: .7rem; }
    .progress-line { margin: 0 .4rem; }
    .form-step { padding: 1.5rem 1.1rem; }
    .step-footer, .step-footer.single, .toggle-group { flex-direction: column; }
    .step-footer .btn { width: 100%; min-width: unset; }
    .payment-method-cards { grid-template-columns: 1fr; }
    .payment-reminder { flex-direction: column; align-items: flex-start; text-align: left; }
}
@media (max-width: 576px) {
    .exhibition-hero { padding: 2.5rem 0 3.5rem; }
    .exhibition-hero h1 { font-size: 1.75rem; }
    .step-title { font-size: 1.3rem; }
    .package-price .amount { font-size: 1.9rem; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const formSteps     = document.querySelectorAll('.form-step');
    const progressSteps = document.querySelectorAll('.progress-steps .step');
    const nextBtns      = document.querySelectorAll('.btn-next');
    const prevBtns      = document.querySelectorAll('.btn-prev');
    let currentStep = 1;
    const totalSteps = formSteps.length;

    // -------------------------------------------------------
    // Step navigation
    // -------------------------------------------------------
    function showStep(step) {
        formSteps.forEach(s => { s.classList.remove('active'); });
        const cur = document.querySelector(`.form-step[data-step="${step}"]`);
        if (cur) cur.classList.add('active');

        progressSteps.forEach((s, i) => {
            s.classList.remove('active', 'completed');
            if (i + 1 < step)        s.classList.add('completed');
            else if (i + 1 === step) s.classList.add('active');
        });
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function validateStep(step) {
        const cur = document.querySelector(`.form-step[data-step="${step}"]`);
        let valid = true;

        cur.querySelectorAll('input[required]:not([type="radio"]):not([type="checkbox"]), select[required], textarea[required]').forEach(inp => {
            inp.classList.remove('is-invalid');
            if (!inp.value.trim()) { valid = false; inp.classList.add('is-invalid'); }
        });

        // Radio group validation
        const radioGroups = {};
        cur.querySelectorAll('input[type="radio"][required]').forEach(r => {
            if (!radioGroups[r.name]) {
                radioGroups[r.name] = !!cur.querySelector(`input[name="${r.name}"]:checked`);
            }
        });
        Object.values(radioGroups).forEach(checked => { if (!checked) valid = false; });

        // Minimum character counts
        if (step === 1) {
            const about    = document.getElementById('aboutExhibition');
            const audience = document.getElementById('targetAudience');
            const benefits = document.getElementById('benefits');
            if (about.value.trim().length < 50)   { valid = false; about.classList.add('is-invalid'); }
            if (audience.value.trim().length < 5) { valid = false; audience.classList.add('is-invalid'); }
            if (benefits.value.trim().length < 50) { valid = false; benefits.classList.add('is-invalid'); }
        }

        if (!valid) alert('Please fill in all required fields before continuing.');
        return valid;
    }

    nextBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            if (validateStep(currentStep) && currentStep < totalSteps) {
                currentStep++;
                showStep(currentStep);
            }
        });
    });
    prevBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            if (currentStep > 1) { currentStep--; showStep(currentStep); }
        });
    });

    // Remove is-invalid on input
    document.querySelectorAll('.form-control').forEach(inp => {
        inp.addEventListener('input', function () { this.classList.remove('is-invalid'); });
    });

    // -------------------------------------------------------
    // Character counters
    // -------------------------------------------------------
    function wireCounter(textareaId, counterId) {
        const el  = document.getElementById(textareaId);
        const cnt = document.getElementById(counterId);
        if (!el || !cnt) return;
        const update = () => { cnt.textContent = el.value.length; };
        el.addEventListener('input', update);
        update();
    }
    wireCounter('aboutExhibition', 'aboutCount');
    wireCounter('targetAudience',  'audienceCount');
    wireCounter('benefits',        'benefitsCount');

    // -------------------------------------------------------
    // Booth counter & cost summary
    // -------------------------------------------------------
    const boothCountInput = document.getElementById('boothCount');
    const incrementBtn    = document.getElementById('incrementBooth');
    const decrementBtn    = document.getElementById('decrementBooth');

    const PRICES = { booth: 10000, own_tent: 5000 };
    const LABELS  = { booth: 'Standard Booth', own_tent: 'Own Tent' };
    const UNITS   = { booth: 'booth', own_tent: 'tent' };

    function updateBoothLabel() {
        const count = parseInt(boothCountInput.value) || 1;
        const type  = document.querySelector('input[name="registrationType"]:checked')?.value || 'booth';
        const unit  = UNITS[type];
        document.getElementById('counterLabel').textContent   = count === 1 ? `${unit.charAt(0).toUpperCase() + unit.slice(1)} Selected` : `${unit.charAt(0).toUpperCase() + unit.slice(1)}s Selected`;
        document.getElementById('spaceTypeLabel').textContent = unit + 's';
        const noteEl = document.getElementById('counterNote');
        if (type === 'booth') {
            noteEl.innerHTML = '<i class="bi bi-info-circle me-1"></i>Each booth is <strong>3m &times; 3m</strong> and accommodates up to <strong>2 exhibitors</strong>';
        } else {
            noteEl.innerHTML = '<i class="bi bi-info-circle me-1"></i>Bring your own tent and furniture. Grounds and meals for <strong>2 persons</strong> provided.';
        }
    }

    function updateCostSummary() {
        const count = parseInt(boothCountInput.value) || 1;
        const type  = document.querySelector('input[name="registrationType"]:checked')?.value || 'booth';
        const price = PRICES[type] || 10000;
        const total = count * price;
        const label = LABELS[type] || 'Standard Booth';
        const unit  = UNITS[type] || 'booth';

        document.getElementById('displayPackage').textContent       = label;
        document.getElementById('displayBoothCount').textContent    = count;
        document.getElementById('displayPricePerBooth').textContent = `KES ${price.toLocaleString()}`;
        document.getElementById('totalCost').textContent            = `KES ${total.toLocaleString()}`;
        document.getElementById('calculatedTotal').value            = total;

        document.getElementById('paymentReminderAmount').textContent = `KES ${total.toLocaleString()}`;
        document.getElementById('paymentReminderDetail').textContent  = `${count} \u00d7 ${label}`;

        updateBoothLabel();
    }

    incrementBtn?.addEventListener('click', () => {
        const cur = parseInt(boothCountInput.value) || 1;
        if (cur < 10) { boothCountInput.value = cur + 1; updateCostSummary(); }
    });
    decrementBtn?.addEventListener('click', () => {
        const cur = parseInt(boothCountInput.value) || 1;
        if (cur > 1) { boothCountInput.value = cur - 1; updateCostSummary(); }
    });
    document.querySelectorAll('input[name="registrationType"]').forEach(r => r.addEventListener('change', updateCostSummary));

    // -------------------------------------------------------
    // Payment method toggle
    // -------------------------------------------------------
    const bankDetails        = document.getElementById('bankDetails');
    const mpesaDetails       = document.getElementById('mpesaDetails');
    const transactionSection = document.getElementById('transactionSection');
    const receiptInput       = document.getElementById('receiptNumber');
    const proofInput         = document.getElementById('paymentProof');

    document.querySelectorAll('input[name="paymentMethod"]').forEach(radio => {
        radio.addEventListener('change', function () {
            bankDetails.style.display        = this.value === 'bank'  ? 'block' : 'none';
            mpesaDetails.style.display       = this.value === 'mpesa' ? 'block' : 'none';
            transactionSection.style.display = 'block';
            if (receiptInput) receiptInput.required = true;
            if (proofInput)   proofInput.required   = true;
        });
    });

    // -------------------------------------------------------
    // File upload
    // -------------------------------------------------------
    function setupFileUpload(wrapperId, inputId) {
        const wrapper     = document.getElementById(wrapperId);
        const input       = document.getElementById(inputId);
        if (!wrapper || !input) return;
        const placeholder = wrapper.querySelector('.upload-area');
        const preview     = wrapper.querySelector('.file-preview-modern');
        const nameSpan    = preview?.querySelector('.file-name');
        const sizeSpan    = preview?.querySelector('.file-size');
        const removeBtn   = preview?.querySelector('.file-remove');

        wrapper.addEventListener('click',    e  => { if (!e.target.closest('.file-remove')) input.click(); });
        wrapper.addEventListener('dragover',  e  => { e.preventDefault(); placeholder?.classList.add('dragging'); });
        wrapper.addEventListener('dragleave', () => placeholder?.classList.remove('dragging'));
        wrapper.addEventListener('drop', e => {
            e.preventDefault(); placeholder?.classList.remove('dragging');
            if (e.dataTransfer.files.length) { input.files = e.dataTransfer.files; handleFile(input.files[0]); }
        });
        input.addEventListener('change', function () { if (this.files?.[0]) handleFile(this.files[0]); });

        function handleFile(file) {
            if (!placeholder || !preview) return;
            if (nameSpan) nameSpan.textContent = file.name;
            if (sizeSpan) {
                const b = file.size;
                sizeSpan.textContent = b < 1024 ? b + ' B' : b < 1048576 ? (b / 1024).toFixed(1) + ' KB' : (b / 1048576).toFixed(1) + ' MB';
            }
            placeholder.style.display = 'none';
            preview.style.display     = 'flex';
        }
        removeBtn?.addEventListener('click', e => {
            e.stopPropagation(); input.value = '';
            if (placeholder) placeholder.style.display = 'block';
            if (preview)     preview.style.display     = 'none';
        });
    }
    setupFileUpload('paymentProofUpload', 'paymentProof');

    // -------------------------------------------------------
    // Init
    // -------------------------------------------------------
    showStep(1);
    updateCostSummary();
});
</script>
@endsection