@extends('layouts.header')

@section('title') Exhibition Registration @endsection

@section('content')

<style>
  :root {
    --green: #16a34a;
    --green-light: #22c55e;
    --green-soft: rgba(22,163,74,0.1);
    --green-border: rgba(22,163,74,0.35);
    --bg: #f9fafb;
    --white: #ffffff;
    --border: #e5e7eb;
    --text: #111827;
    --text-muted: #6b7280;
    --text-light: #9ca3af;
    --error-bg: #fef2f2;
    --error-border: #fecaca;
    --error-text: #dc2626;
    --success-bg: #f0fdf4;
    --success-border: #bbf7d0;
    --radius: 10px;
    --radius-sm: 7px;
    --shadow: 0 1px 4px rgba(0,0,0,0.09);
  }

  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    background: var(--bg);
    color: var(--text);
    font-size: 15px;
    line-height: 1.6;
  }

  /* ── Hero ── */
  .exhibition-hero {
    background: linear-gradient(135deg, #174d2b 0%, #16a34a 50%, #154728 100%);
    padding: 56px 20px 48px;
    margin-bottom: 0;
  }

  .exhibition-hero .hero-content h1 {
    font-size: 2.25rem;
    font-weight: 800;
    color: #fff;
    margin-bottom: 12px;
    letter-spacing: -0.02em;
    text-shadow: 0 1px 3px rgba(0,0,0,0.15);
  }

  .exhibition-hero .hero-content .lead {
    font-size: 1.1rem;
    color: rgba(255,255,255,0.88);
    font-weight: 400;
  }

  .reg-wrap {
    max-width: 680px;
    margin: 0 auto;
    padding: 32px 20px 60px;
  }

  /* Stepper */
  .stepper {
    display: flex;
    align-items: center;
    margin-bottom: 24px;
    padding: 0 4px;
  }

  .step {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 5px;
    flex: 1;
    position: relative;
  }

  .step-dot {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: 2px solid var(--border);
    background: var(--white);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    font-weight: 600;
    color: var(--text-muted);
    z-index: 1;
    transition: all 0.2s;
  }

  .step.active .step-dot {
    border-color: var(--green);
    background: var(--green);
    color: #fff;
    box-shadow: 0 0 0 4px var(--green-soft);
  }

  .step.done .step-dot {
    border-color: var(--green);
    background: var(--green-soft);
    color: var(--green);
  }

  .step-label {
    font-size: 11px;
    font-weight: 500;
    color: var(--text-light);
    letter-spacing: 0.02em;
    white-space: nowrap;
  }

  .step.active .step-label { color: var(--green); font-weight: 600; }
  .step.done .step-label   { color: var(--green); }

  .step-line {
    flex: 1;
    height: 2px;
    background: var(--border);
    margin-top: -22px;
    z-index: 0;
    transition: background 0.2s;
  }

  .step-line.done { background: var(--green-border); }

  /* Alerts */
  .alert {
    padding: 12px 14px;
    border-radius: var(--radius-sm);
    font-size: 14px;
    margin-bottom: 14px;
    display: flex;
    align-items: flex-start;
    gap: 8px;
  }

  .alert-success {
    background: var(--success-bg);
    border: 1px solid var(--success-border);
    color: var(--green);
  }

  .alert-error {
    background: var(--error-bg);
    border: 1px solid var(--error-border);
    color: var(--error-text);
  }

  .alert ul { padding-left: 13px; margin: 0; }
  .alert ul li { margin-top: 2px; }

  /* Card */
  .card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 24px;
    margin-bottom: 14px;
    box-shadow: var(--shadow);
  }

  .card-title {
    font-size: 16px;
    font-weight: 700;
    color: var(--text);
    margin-bottom: 4px;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .card-title::before {
    content: '';
    display: inline-block;
    width: 4px;
    height: 16px;
    background: var(--green);
    border-radius: 2px;
    flex-shrink: 0;
  }

  .card-desc {
    font-size: 13px;
    color: var(--text-muted);
    margin-bottom: 20px;
    padding-left: 12px;
  }

  /* Fields */
  .form-grid { display: grid; gap: 16px; }

  .form-grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
  }

  .field label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: var(--text);
    margin-bottom: 6px;
  }

  .req { color: var(--green); margin-left: 1px; }

  .field input,
  .field textarea,
  .field select {
    width: 100%;
    background: var(--white);
    border: 1.5px solid var(--border);
    border-radius: var(--radius-sm);
    color: var(--text);
    font-family: inherit;
    font-size: 14px;
    padding: 10px 12px;
    outline: none;
    transition: border-color 0.15s, box-shadow 0.15s;
    appearance: none;
    -webkit-appearance: none;
  }

  .field textarea { resize: vertical; min-height: 90px; }

  .field input:focus,
  .field textarea:focus,
  .field select:focus {
    border-color: var(--green);
    box-shadow: 0 0 0 3px var(--green-soft);
  }

  .field input::placeholder,
  .field textarea::placeholder { color: var(--text-light); font-size: 13px; }

  .field-hint { font-size: 12px; color: var(--text-muted); margin-top: 4px; }

  .char-counter {
    font-size: 11px;
    color: var(--text-light);
    text-align: right;
    margin-top: 4px;
  }

  /* Booth counter */
  .booth-row { display: flex; align-items: center; gap: 14px; }

  .booth-counter {
    display: flex;
    align-items: center;
    border: 1.5px solid var(--border);
    border-radius: var(--radius-sm);
    overflow: hidden;
    background: var(--white);
  }

  .booth-counter button {
    width: 38px;
    height: 38px;
    border: none;
    background: none;
    color: var(--text-muted);
    font-size: 18px;
    cursor: pointer;
    transition: background 0.12s, color 0.12s;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .booth-counter button:hover { background: var(--green-soft); color: var(--green); }

  .booth-counter .count {
    min-width: 56px;
    text-align: center;
    font-size: 16px;
    font-weight: 700;
    color: var(--text);
    border-left: 1.5px solid var(--border);
    border-right: 1.5px solid var(--border);
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
  }

  .booth-counter .count small { font-size: 12px; color: var(--text-muted); font-weight: 400; }
  .booth-meta { font-size: 13px; color: var(--text-muted); }

  /* Package cards */
  .packages {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
  }

  .pkg-card {
    position: relative;
    border: 1.5px solid var(--border);
    border-radius: var(--radius);
    padding: 16px;
    cursor: pointer;
    transition: border-color 0.15s, box-shadow 0.15s;
    background: var(--white);
    display: flex;
    flex-direction: column;
  }

  .pkg-card:hover { border-color: var(--green-border); }

  .pkg-card.selected {
    border-color: var(--green);
    box-shadow: 0 0 0 3px var(--green-soft);
    background: var(--success-bg);
  }

  .pkg-card input[type="radio"] { position: absolute; opacity: 0; width: 0; height: 0; }

  .pkg-check {
    position: absolute;
    top: 12px;
    right: 12px;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 1.5px solid var(--border);
    background: var(--white);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.15s;
  }

  .pkg-check::after {
    content: '✓';
    font-size: 11px;
    font-weight: 700;
    color: transparent;
  }

  .pkg-card.selected .pkg-check {
    border-color: var(--green);
    background: var(--green);
  }

  .pkg-card.selected .pkg-check::after { color: #fff; }

  .pkg-name {
    font-size: 14px;
    font-weight: 700;
    color: var(--text);
    margin-bottom: 12px;
    padding-right: 24px;
  }

  .pkg-features {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 6px;
    flex: 1;
    margin-bottom: 12px;
  }

  .pkg-features li {
    font-size: 13px;
    color: var(--text-muted);
    display: flex;
    align-items: flex-start;
    gap: 7px;
    line-height: 1.4;
  }

  .pkg-features li::before {
    content: '✓';
    color: var(--green);
    font-size: 11px;
    font-weight: 700;
    margin-top: 2px;
    flex-shrink: 0;
  }

  .pkg-features li.no::before {
    content: '✕';
    color: var(--text-light);
  }

  .pkg-price {
    font-size: 14px;
    font-weight: 700;
    color: var(--green);
    border-top: 1px solid var(--border);
    padding-top: 10px;
  }

  .pkg-price small { font-size: 12px; font-weight: 400; color: var(--text-muted); }

  /* Cost summary */
  .cost-summary {
    background: var(--success-bg);
    border: 1px solid var(--success-border);
    border-radius: var(--radius-sm);
    padding: 14px 16px;
    margin-top: 14px;
  }

  .cost-row {
    display: flex;
    justify-content: space-between;
    font-size: 13px;
    color: var(--text-muted);
    padding: 3px 0;
  }

  .cost-row.total {
    border-top: 1px solid var(--success-border);
    margin-top: 8px;
    padding-top: 10px;
    font-size: 15px;
    font-weight: 700;
    color: var(--text);
  }

  .cost-row.total span:last-child { color: var(--green); }

  /* Payment tabs */
  .pay-tabs { display: flex; gap: 10px; margin-bottom: 16px; }

  .pay-tab {
    flex: 1;
    padding: 12px 14px;
    border: 1.5px solid var(--border);
    border-radius: var(--radius-sm);
    background: var(--white);
    cursor: pointer;
    text-align: center;
    transition: all 0.15s;
  }

  .pay-tab:hover { border-color: var(--green-border); }
  .pay-tab.active { border-color: var(--green); background: var(--success-bg); }
  .pay-tab .pay-label { display: block; font-size: 14px; font-weight: 600; color: var(--text); }
  .pay-tab .pay-sub   { display: block; font-size: 12px; color: var(--text-muted); margin-top: 2px; }
  .pay-tab input { display: none; }

  /* Payment details */
  .pay-details {
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: var(--radius-sm);
    padding: 14px 16px;
    margin-bottom: 16px;
  }

  .pay-details-title {
    font-size: 11px;
    font-weight: 700;
    color: var(--text-muted);
    letter-spacing: 0.06em;
    text-transform: uppercase;
    margin-bottom: 10px;
  }

  .pay-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 13px;
    color: var(--text-muted);
    padding: 6px 0;
    border-bottom: 1px solid var(--border);
  }

  .pay-row:last-child { border-bottom: none; }
  .pay-row strong { color: var(--text); font-weight: 600; font-size: 14px; }

  .mpesa-steps { display: flex; flex-direction: column; gap: 6px; margin-top: 10px; }

  .mpesa-step {
    display: flex;
    align-items: flex-start;
    gap: 9px;
    font-size: 13px;
    color: var(--text-muted);
  }

  .mpesa-step .num {
    min-width: 18px;
    height: 18px;
    border-radius: 50%;
    background: var(--green-soft);
    border: 1px solid var(--green-border);
    color: var(--green);
    font-size: 10px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    margin-top: 2px;
  }

  /* Upload */
  .upload-zone {
    border: 1.5px dashed var(--border);
    border-radius: var(--radius-sm);
    padding: 24px 16px;
    text-align: center;
    cursor: pointer;
    transition: border-color 0.15s, background 0.15s;
    background: var(--white);
  }

  .upload-zone:hover { border-color: var(--green); background: var(--success-bg); }
  .upload-icon { font-size: 24px; margin-bottom: 6px; opacity: 0.6; }
  .upload-text { font-size: 13px; color: var(--text-muted); }
  .upload-text strong { color: var(--green); font-weight: 600; }
  .upload-hint { font-size: 12px; color: var(--text-light); margin-top: 3px; }

  /* Radios */
  .radio-group { display: flex; gap: 10px; }
  .radio-opt { flex: 1; position: relative; cursor: pointer; }
  .radio-opt input { position: absolute; opacity: 0; }

  .radio-label {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 10px 12px;
    border: 1.5px solid var(--border);
    border-radius: var(--radius-sm);
    font-size: 13px;
    color: var(--text-muted);
    background: var(--white);
    transition: all 0.13s;
    cursor: pointer;
    gap: 5px;
  }

  .radio-opt input:checked + .radio-label {
    border-color: var(--green);
    background: var(--success-bg);
    color: var(--green);
    font-weight: 600;
  }

  /* Checkbox */
  .checkbox-field { display: flex; align-items: flex-start; gap: 9px; cursor: pointer; }

  .checkbox-field input[type="checkbox"] {
    width: 16px;
    height: 16px;
    min-width: 16px;
    margin-top: 2px;
    accent-color: var(--green);
    cursor: pointer;
  }

  .checkbox-field span { font-size: 13px; color: var(--text-muted); line-height: 1.5; }
  .checkbox-field span a { color: var(--green); text-decoration: none; }
  .checkbox-field span a:hover { text-decoration: underline; }

  /* Buttons */
  .form-nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 18px;
    gap: 10px;
  }

  .btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 11px 22px;
    border-radius: var(--radius-sm);
    font-family: inherit;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.15s;
    border: none;
    white-space: nowrap;
  }

  .btn-primary { background: var(--green); color: #fff; box-shadow: 0 1px 4px rgba(22,163,74,0.3); }
  .btn-primary:hover { background: #15803d; transform: translateY(-1px); }

  .btn-ghost {
    background: var(--white);
    border: 1.5px solid var(--border);
    color: var(--text-muted);
  }

  .btn-ghost:hover { border-color: var(--green-border); color: var(--green); }

  .btn-success { background: var(--green); color: #fff; box-shadow: 0 1px 4px rgba(22,163,74,0.3); }
  .btn-success:hover { background: #15803d; transform: translateY(-1px); }

  /* Steps */
  .form-step { display: none; }
  .form-step.active { display: block; }

  @media (max-width: 520px) {
    .form-grid-2 { grid-template-columns: 1fr; }
    .packages     { grid-template-columns: 1fr; }
    .pay-tabs     { flex-direction: column; }
    .exhibition-hero .hero-content h1 { font-size: 1.6rem; }
  }
</style>

{{-- Hero Section --}}
<div class="exhibition-hero">
  <div class="container">
    <div class="hero-content text-center">
      <h1 class="display-4 fw-bold mb-3">KALRO Conference Exhibition</h1>
      <p class="lead">Showcase your innovations and connect with industry leaders</p>
    </div>
  </div>
</div>

<div class="reg-wrap">

  {{-- Stepper --}}
  <div class="stepper">
    <div class="step active" id="sd1">
      <div class="step-dot">1</div>
      <span class="step-label">Organization</span>
    </div>
    <div class="step-line" id="sl1"></div>
    <div class="step" id="sd2">
      <div class="step-dot">2</div>
      <span class="step-label">Booth</span>
    </div>
    <div class="step-line" id="sl2"></div>
    <div class="step" id="sd3">
      <div class="step-dot">3</div>
      <span class="step-label">Payment</span>
    </div>
    <div class="step-line" id="sl3"></div>
    <div class="step" id="sd4">
      <div class="step-dot">4</div>
      <span class="step-label">Contact</span>
    </div>
  </div>

  {{-- Alerts --}}
  @if(session('success'))
    <div class="alert alert-success">✓ {{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert alert-error">⚠ {{ session('error') }}</div>
  @endif
  @if($errors->any())
    <div class="alert alert-error">
      <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
  @endif

  <form method="POST" action="{{ route('exhibition.register') }}" enctype="multipart/form-data" id="regForm">
    @csrf

    {{-- STEP 1: Organization --}}
    <div class="form-step active" id="form-step-1">
      <div class="card">
        <div class="card-title">Organization Information</div>
        <div class="card-desc">Tell us about your organization and what you'll be exhibiting</div>
        <div class="form-grid">
          <div class="field">
            <label>Organization Name <span class="req">*</span></label>
            <input type="text" name="organizationName" value="{{ old('organizationName') }}" placeholder="Your organization name" required>
          </div>
          <div class="field">
            <label>About Your Exhibition <span class="req">*</span></label>
            <textarea name="aboutExhibition" id="aboutExhibition" placeholder="Describe what you'll be showcasing..." required>{{ old('aboutExhibition') }}</textarea>
            <div class="char-counter" id="aboutCounter">0 characters</div>
          </div>
          <div class="field">
            <label>Benefits to Attendees <span class="req">*</span></label>
            <textarea name="benefits" id="benefits" placeholder="Why should attendees visit your booth?" required>{{ old('benefits') }}</textarea>
            <div class="char-counter" id="benefitsCounter">0 characters</div>
          </div>
        </div>
      </div>
      <div class="form-nav">
        <div></div>
        <button type="button" class="btn btn-primary" onclick="goToStep(2)">
          Continue
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </button>
      </div>
    </div>

    {{-- STEP 2: Booth --}}
    <div class="form-step" id="form-step-2">
      <div class="card">
        <div class="card-title">Booth Configuration</div>
        <div class="card-desc">Select the number of booths and your preferred package</div>
        <div class="form-grid">

          <div class="field">
            <label>How many booths do you need?</label>
            <div class="booth-row">
              <div class="booth-counter">
                <button type="button" onclick="changeBooth(-1)">−</button>
                <div class="count">
                  <span id="boothDisplay">1</span>
                  <small id="boothLabel">Booth</small>
                </div>
                <button type="button" onclick="changeBooth(1)">+</button>
              </div>
              <span class="booth-meta">Each booth accommodates up to 2 exhibitors</span>
            </div>
            <input type="hidden" name="boothCount" id="boothCount" value="{{ old('boothCount', 1) }}">
          </div>

          <div class="field">
            <label>Choose Your Package <span class="req">*</span></label>
            <div class="packages">

              <label class="pkg-card selected" id="pkg-premium" onclick="selectPackage('premium')">
                <input type="radio" name="package" value="premium" {{ old('package','premium')=='premium' ? 'checked' : '' }}>
                <div class="pkg-check"></div>
                <div class="pkg-name">Premium Package</div>
                <ul class="pkg-features">
                  <li>Booth space with furniture</li>
                  <li>2 exhibitor registrations</li>
                  <li>Full catering included</li>
                  <li>Conference materials</li>
                </ul>
                <div class="pkg-price">KES 25,000 <small>/ booth</small></div>
              </label>

              <label class="pkg-card" id="pkg-standard" onclick="selectPackage('standard')">
                <input type="radio" name="package" value="standard" {{ old('package')=='standard' ? 'checked' : '' }}>
                <div class="pkg-check"></div>
                <div class="pkg-name">Standard Package</div>
                <ul class="pkg-features">
                  <li>Booth space with furniture</li>
                  <li>2 exhibitor registrations</li>
                  <li class="no">Meals not included</li>
                  <li>Conference materials</li>
                </ul>
                <div class="pkg-price">KES 18,000 <small>/ booth</small></div>
              </label>

            </div>
          </div>

          <div class="cost-summary">
            <div class="cost-row"><span>Number of Booths</span><span id="summaryBooths">1</span></div>
            <div class="cost-row"><span>Package Selected</span><span id="summaryPackage">Premium (With Meals)</span></div>
            <div class="cost-row"><span>Price per Booth</span><span id="summaryPrice">KES 25,000</span></div>
            <div class="cost-row total"><span>Total Amount</span><span id="summaryTotal">KES 25,000</span></div>
          </div>

        </div>
      </div>
      <div class="form-nav">
        <button type="button" class="btn btn-ghost" onclick="goToStep(1)">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg> Back
        </button>
        <button type="button" class="btn btn-primary" onclick="goToStep(3)">
          Continue <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </button>
      </div>
    </div>

    {{-- STEP 3: Payment --}}
    <div class="form-step" id="form-step-3">
      <div class="card">
        <div class="card-title">Payment Information</div>
        <div class="card-desc">Complete your payment to secure your booth</div>
        <div class="form-grid">

          <div class="field">
            <label>Select Payment Method <span class="req">*</span></label>
            <div class="pay-tabs">
              <label class="pay-tab active" id="tab-bank" onclick="selectPayment('bank')">
                <input type="radio" name="paymentMethod" value="bank" checked>
                <span class="pay-label">🏦 Bank Transfer</span>
                <span class="pay-sub">Direct deposit</span>
              </label>
              <label class="pay-tab" id="tab-mpesa" onclick="selectPayment('mpesa')">
                <input type="radio" name="paymentMethod" value="mpesa">
                <span class="pay-label">📱 M-Pesa</span>
                <span class="pay-sub">Mobile money</span>
              </label>
            </div>
          </div>

          <div id="bank-details" class="pay-details">
            <div class="pay-details-title">Bank Transfer Details</div>
            <div class="pay-row"><span>Bank Name</span><strong>KCB Ltd</strong></div>
            <div class="pay-row"><span>Branch</span><strong>K I C C</strong></div>
            <div class="pay-row"><span>Bank Code</span><strong>01104</strong></div>
            <div class="pay-row"><span>Swift Code</span><strong>KCBLKENX</strong></div>
            <div class="pay-row"><span>Account Number</span><strong>1116139030</strong></div>
            <div class="pay-row"><span>Account Name</span><strong>KALRO EAAPP</strong></div>
          </div>

          <div id="mpesa-details" class="pay-details" style="display:none;">
            <div class="pay-details-title">M-Pesa Payment Details</div>
            <div class="pay-row"><span>Paybill Number</span><strong>522522</strong></div>
            <div class="pay-row"><span>Account Number</span><strong>1116139030</strong></div>
            <div class="mpesa-steps">
              @foreach(['Go to M-Pesa menu on your phone','Select Lipa na M-Pesa','Select Pay Bill','Enter Business Number: 522522','Enter Account Number: 1116139030','Enter the amount shown above','Enter your M-Pesa PIN and confirm'] as $i => $s)
                <div class="mpesa-step">
                  <span class="num">{{ $i+1 }}</span>
                  <span>{{ $s }}</span>
                </div>
              @endforeach
            </div>
          </div>

          <div class="field">
            <label>Transaction Reference <span class="req">*</span></label>
            <input type="text" name="transactionReference" value="{{ old('transactionReference') }}" placeholder="Reference code from your payment receipt" required>
          </div>

          <div class="field">
            <label>Payment Proof <span class="req">*</span></label>
            <div class="upload-zone" onclick="document.getElementById('paymentProof').click()">
              <div class="upload-icon">📎</div>
              <div class="upload-text"><strong>Click to upload</strong> or drag & drop</div>
              <div class="upload-hint">PNG, JPG, PDF · Max 5MB</div>
            </div>
            <input type="file" name="paymentProof" id="paymentProof" accept=".png,.jpg,.jpeg,.pdf" style="display:none;" required>
          </div>

        </div>
      </div>
      <div class="form-nav">
        <button type="button" class="btn btn-ghost" onclick="goToStep(2)">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg> Back
        </button>
        <button type="button" class="btn btn-primary" onclick="goToStep(4)">
          Continue <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </button>
      </div>
    </div>

    {{-- STEP 4: Contact --}}
    <div class="form-step" id="form-step-4">
      <div class="card">
        <div class="card-title">Contact Information</div>
        <div class="card-desc">Who should we contact regarding this exhibition?</div>
        <div class="form-grid">

          <div class="form-grid-2">
            <div class="field">
              <label>Full Name <span class="req">*</span></label>
              <input type="text" name="fullName" value="{{ old('fullName') }}" placeholder="Your full name" required>
            </div>
            <div class="field">
              <label>Role / Position <span class="req">*</span></label>
              <input type="text" name="role" value="{{ old('role') }}" placeholder="e.g. Marketing Manager" required>
            </div>
          </div>

          <div class="form-grid-2">
            <div class="field">
              <label>Phone Number <span class="req">*</span></label>
              <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="+254 700 000 000" required>
            </div>
            <div class="field">
              <label>Email Address <span class="req">*</span></label>
              <input type="email" name="email" value="{{ old('email') }}" placeholder="email@organization.com" required>
            </div>
          </div>

          <div class="form-grid-2">
            <div class="field">
              <label>Team Leader? <span class="req">*</span></label>
              <div class="radio-group">
                <label class="radio-opt">
                  <input type="radio" name="isTeamLeader" value="yes" {{ old('isTeamLeader')=='yes' ? 'checked' : '' }}>
                  <span class="radio-label">✓ Yes, I'm leading</span>
                </label>
                <label class="radio-opt">
                  <input type="radio" name="isTeamLeader" value="no" {{ old('isTeamLeader','no')=='no' ? 'checked' : '' }}>
                  <span class="radio-label">No, someone else</span>
                </label>
              </div>
            </div>
            <div class="field">
              <label>Team Size <span class="req">*</span></label>
              <input type="number" name="teamSize" value="{{ old('teamSize', 2) }}" min="1" required>
              <div class="field-hint">Catering provided for 2 persons per booth only</div>
            </div>
          </div>

          <label class="checkbox-field">
            <input type="checkbox" name="terms" required {{ old('terms') ? 'checked' : '' }}>
            <span>I have read and agree to the <a href="#">terms and conditions</a> <span class="req">*</span></span>
          </label>

        </div>
      </div>
      <div class="form-nav">
        <button type="button" class="btn btn-ghost" onclick="goToStep(3)">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg> Back
        </button>
        <button type="submit" class="btn btn-success">
          Complete Registration
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg>
        </button>
      </div>
    </div>

  </form>
</div>

<script>
  function goToStep(n) {
    document.querySelectorAll('.form-step').forEach(s => s.classList.remove('active'));
    document.getElementById('form-step-' + n).classList.add('active');
    [1,2,3,4].forEach(i => {
      const dot  = document.getElementById('sd' + i);
      const line = document.getElementById('sl' + i);
      dot.classList.remove('active','done');
      if (line) line.classList.remove('done');
      if (i < n)  { dot.classList.add('done'); if (line) line.classList.add('done'); }
      if (i === n) dot.classList.add('active');
    });
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  function changeBooth(delta) {
    const inp = document.getElementById('boothCount');
    const val = Math.max(1, Math.min(10, parseInt(inp.value) + delta));
    inp.value = val;
    document.getElementById('boothDisplay').textContent = val;
    document.getElementById('boothLabel').textContent = val === 1 ? 'Booth' : 'Booths';
    updateSummary();
  }

  let selectedPkg = 'premium';
  function selectPackage(pkg) {
    selectedPkg = pkg;
    document.getElementById('pkg-premium').classList.toggle('selected', pkg === 'premium');
    document.getElementById('pkg-standard').classList.toggle('selected', pkg === 'standard');
    updateSummary();
  }

  function updateSummary() {
    const booths = parseInt(document.getElementById('boothCount').value);
    const price  = selectedPkg === 'premium' ? 25000 : 18000;
    document.getElementById('summaryBooths').textContent  = booths;
    document.getElementById('summaryPackage').textContent = selectedPkg === 'premium' ? 'Premium (With Meals)' : 'Standard (No Meals)';
    document.getElementById('summaryPrice').textContent   = 'KES ' + price.toLocaleString();
    document.getElementById('summaryTotal').textContent   = 'KES ' + (booths * price).toLocaleString();
  }

  function selectPayment(method) {
    document.getElementById('tab-bank').classList.toggle('active', method === 'bank');
    document.getElementById('tab-mpesa').classList.toggle('active', method === 'mpesa');
    document.getElementById('bank-details').style.display  = method === 'bank'  ? 'block' : 'none';
    document.getElementById('mpesa-details').style.display = method === 'mpesa' ? 'block' : 'none';
  }

  function initCounter(id, cid) {
    const el = document.getElementById(id);
    const ct = document.getElementById(cid);
    if (!el || !ct) return;
    const update = () => { const n = el.value.length; ct.textContent = n + ' character' + (n !== 1 ? 's' : ''); };
    el.addEventListener('input', update);
    update();
  }

  initCounter('aboutExhibition', 'aboutCounter');
  initCounter('benefits', 'benefitsCounter');

  document.getElementById('paymentProof').addEventListener('change', function () {
    const zone = this.closest('.field').querySelector('.upload-text');
    if (this.files[0]) zone.innerHTML = '<strong>' + this.files[0].name + '</strong>';
  });

  updateSummary();
</script>

@endsection