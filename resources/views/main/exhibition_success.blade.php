@extends('layouts.header')

@section('title')
    Registration Successful
@endsection

@section('content')
<div class="success-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <!-- Success Card -->
                <div class="success-card">
                    <!-- Success Animation -->
                    <div class="success-animation">
                        <div class="checkmark-circle">
                            <div class="checkmark-background"></div>
                            <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                                <circle class="checkmark-circle-svg" cx="26" cy="26" r="25" fill="none"/>
                                <path class="checkmark-check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Success Content -->
                    <div class="success-content">
                        <h1 class="success-title">Registration Successful!</h1>
                        <p class="success-message">
                            Thank you for registering for the 2nd KALRO Conference Exhibition. 
                            Your submission has been received successfully.
                        </p>
                    </div>

                    <!-- What's Next Section -->
                    <div class="next-steps">
                        <h5 class="next-steps-title">
                            <i class="bi bi-clock-history me-2"></i>
                            What Happens Next?
                        </h5>
                        <div class="steps-list">
                            <div class="step-item">
                                <div class="step-number">1</div>
                                <div class="step-content">
                                    <h6>Confirmation Email</h6>
                                    <p>You'll receive a confirmation email with your registration details within 24 hours.</p>
                                </div>
                            </div>
                            <div class="step-item">
                                <div class="step-number">2</div>
                                <div class="step-content">
                                    <h6>Payment Verification</h6>
                                    <p>Our team will verify your payment and approve your booth allocation.</p>
                                </div>
                            </div>
                            <div class="step-item">
                                <div class="step-number">3</div>
                                <div class="step-content">
                                    <h6>Booth Details</h6>
                                    <p>You'll receive detailed information about your booth location and setup instructions.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Info -->
                    <div class="contact-box">
                        <div class="contact-icon">
                            <i class="bi bi-headset"></i>
                        </div>
                        <div class="contact-content">
                            <h6>Need Assistance?</h6>
                            <p>If you have any questions, please contact our conference team.</p>
                            <div class="contact-methods">
                                <a href="mailto:conference@kalro.org" class="contact-link">
                                    <i class="bi bi-envelope"></i>
                                    kalroconference2026@gmail.com
                                </a>
                                <a href="tel:+254800 721741" class="contact-link">
                                    <i class="bi bi-telephone"></i>
                                    0800 721741
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <a href="{{route('index')}}" class="btn btn-primary btn-lg">
                            <i class="bi bi-house-door me-2"></i>
                            Back to Homepage
                        </a>
                        <a href="{{ route('exhibition.register.form') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="bi bi-plus-circle me-2"></i>
                            Register Another Booth
                        </a>
                    </div>

                    <!-- Reference Number (Optional) -->
                    @if(session('reference_number'))
                    <div class="reference-box">
                        <span class="reference-label">Your Reference Number:</span>
                        <span class="reference-number">{{ session('reference_number') }}</span>
                    </div>
                    @endif
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
}

/* ========================================
   LAYOUT
   ======================================== */
.success-wrapper {
    min-height: 100vh;
    background: linear-gradient(135deg, #f0f9f4 0%, #e6f4ec 100%);
    display: flex;
    align-items: center;
    padding: 4rem 0;
}

/* ========================================
   SUCCESS CARD
   ======================================== */
.success-card {
    background: white;
    border-radius: 25px;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
    padding: 4rem 3rem;
    text-align: center;
    animation: slideUp 0.6s ease;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ========================================
   SUCCESS ANIMATION
   ======================================== */
.success-animation {
    margin-bottom: 2.5rem;
    display: flex;
    justify-content: center;
}

.checkmark-circle {
    width: 120px;
    height: 120px;
    position: relative;
    display: inline-block;
    animation: scaleIn 0.5s ease-in-out 0.3s both;
}

@keyframes scaleIn {
    from {
        transform: scale(0);
        opacity: 0;
    }
    to {
        transform: scale(1);
        opacity: 1;
    }
}

.checkmark-background {
    width: 120px;
    height: 120px;
    background: var(--kalro-gradient);
    border-radius: 50%;
    position: absolute;
    box-shadow: 0 8px 25px rgba(26, 95, 58, 0.3);
}

.checkmark {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    display: block;
    stroke-width: 3;
    stroke: #fff;
    stroke-miterlimit: 10;
    box-shadow: inset 0px 0px 0px var(--kalro-primary);
    position: relative;
    z-index: 1;
}

.checkmark-circle-svg {
    stroke-dasharray: 166;
    stroke-dashoffset: 166;
    stroke-width: 3;
    stroke-miterlimit: 10;
    stroke: var(--kalro-primary);
    fill: none;
    animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
}

.checkmark-check {
    transform-origin: 50% 50%;
    stroke-dasharray: 48;
    stroke-dashoffset: 48;
    animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 1.2s forwards;
}

@keyframes stroke {
    100% {
        stroke-dashoffset: 0;
    }
}

/* ========================================
   SUCCESS CONTENT
   ======================================== */
.success-content {
    margin-bottom: 3rem;
}

.success-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--kalro-primary);
    margin-bottom: 1rem;
    animation: fadeIn 0.6s ease 0.8s both;
}

.success-message {
    font-size: 1.15rem;
    color: var(--text-muted);
    line-height: 1.7;
    max-width: 500px;
    margin: 0 auto;
    animation: fadeIn 0.6s ease 1s both;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ========================================
   NEXT STEPS
   ======================================== */
.next-steps {
    background: var(--kalro-light);
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2.5rem;
    text-align: left;
    animation: fadeIn 0.6s ease 1.2s both;
}

.next-steps-title {
    color: var(--kalro-dark);
    font-weight: 700;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.steps-list {
    display: grid;
    gap: 1.5rem;
}

.step-item {
    display: flex;
    gap: 1.25rem;
    align-items: flex-start;
}

.step-number {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: var(--kalro-gradient);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.2rem;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(26, 95, 58, 0.25);
}

.step-content {
    flex: 1;
}

.step-content h6 {
    color: var(--kalro-dark);
    font-weight: 700;
    margin-bottom: 0.5rem;
    font-size: 1.05rem;
}

.step-content p {
    color: var(--text-muted);
    margin: 0;
    font-size: 0.95rem;
    line-height: 1.6;
}

/* ========================================
   CONTACT BOX
   ======================================== */
.contact-box {
    background: white;
    border: 2px solid var(--kalro-accent);
    border-radius: 15px;
    padding: 1.75rem;
    margin-bottom: 2.5rem;
    display: flex;
    gap: 1.5rem;
    align-items: flex-start;
    text-align: left;
    animation: fadeIn 0.6s ease 1.4s both;
}

.contact-icon {
    width: 60px;
    height: 60px;
    border-radius: 15px;
    background: var(--kalro-gradient);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.contact-icon i {
    font-size: 1.75rem;
    color: white;
}

.contact-content {
    flex: 1;
}

.contact-content h6 {
    color: var(--kalro-dark);
    font-weight: 700;
    margin-bottom: 0.5rem;
    font-size: 1.1rem;
}

.contact-content p {
    color: var(--text-muted);
    margin-bottom: 1rem;
    font-size: 0.95rem;
}

.contact-methods {
    display: flex;
    flex-wrap: wrap;
    gap: 1.25rem;
}

.contact-link {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--kalro-primary);
    text-decoration: none;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.contact-link:hover {
    color: var(--kalro-dark);
    transform: translateX(3px);
}

.contact-link i {
    font-size: 1.1rem;
}

/* ========================================
   ACTION BUTTONS
   ======================================== */
.action-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
    margin-bottom: 2rem;
    animation: fadeIn 0.6s ease 1.6s both;
}

.action-buttons .btn {
    min-width: 200px;
    padding: 1rem 2rem;
    font-weight: 700;
    border-radius: 12px;
    transition: all 0.3s ease;
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

.btn-outline-secondary {
    border: 2px solid var(--border-color);
    color: var(--text-dark);
    background: white;
}

.btn-outline-secondary:hover {
    background: var(--kalro-light);
    border-color: var(--kalro-accent);
    color: var(--kalro-dark);
}

/* ========================================
   REFERENCE BOX
   ======================================== */
.reference-box {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    padding: 1.25rem;
    background: var(--kalro-light);
    border-radius: 12px;
    border: 2px dashed var(--kalro-accent);
    animation: fadeIn 0.6s ease 1.8s both;
}

.reference-label {
    font-size: 0.9rem;
    color: var(--text-muted);
    font-weight: 600;
}

.reference-number {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--kalro-primary);
    letter-spacing: 1px;
}

/* ========================================
   RESPONSIVE
   ======================================== */
@media (max-width: 768px) {
    .success-card {
        padding: 3rem 2rem;
    }
    
    .success-title {
        font-size: 2rem;
    }
    
    .success-message {
        font-size: 1rem;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .action-buttons .btn {
        width: 100%;
    }
    
    .contact-box {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    
    .contact-methods {
        justify-content: center;
        flex-direction: column;
        width: 100%;
    }
    
    .contact-link {
        justify-content: center;
    }
}

@media (max-width: 576px) {
    .success-card {
        padding: 2.5rem 1.5rem;
    }
    
    .checkmark-circle,
    .checkmark-background,
    .checkmark {
        width: 100px;
        height: 100px;
    }
    
    .success-title {
        font-size: 1.75rem;
    }
}
</style>
@endsection