@extends('layouts.header')

@section('title', 'Partial Day Registration – KALRO Conference')

@section('content')
<style>
:root {
    --green:      #2d8a3e;
    --dark-green: #1a5f3a;
    --light-green:#e8f5e9;
    --amber:      #d97706;
    --border:     #e2e8f0;
    --text:       #1e293b;
    --muted:      #64748b;
    --radius:     14px;
}

/* ── Hero ── */
.pr-hero {
    background: linear-gradient(135deg, var(--dark-green) 0%, #2d8a3e 60%, #16a34a 100%);
    color: white;
    padding: 64px 0 52px;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.pr-hero::after {
    content: '\f274';
    font-family: 'Font Awesome 6 Free'; font-weight: 900;
    position: absolute; right: 60px; top: 50%; transform: translateY(-50%);
    font-size: 160px; opacity: .05;
}
.pr-hero h1 { font-size: clamp(1.8rem, 4vw, 2.8rem); font-weight: 800; margin-bottom: 10px; }
.pr-hero p  { font-size: 1.1rem; opacity: .85; margin: 0; }

/* ── Rate Banner ── */
.rate-banner {
    background: #fffbeb;
    border: 1px solid #fde68a;
    border-radius: var(--radius);
    padding: 24px 28px;
    margin-bottom: 28px;
}
.rate-banner h5 { color: var(--amber); font-weight: 700; margin-bottom: 16px; }
.rate-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 14px;
}
.rate-tile {
    background: white;
    border-radius: 10px;
    border: 2px solid var(--border);
    padding: 18px 20px;
    text-align: center;
    transition: border-color .2s, transform .15s;
}
.rate-tile.highlight { border-color: var(--green); }
.rate-tile .days { font-size: 2rem; font-weight: 800; color: var(--green); line-height: 1; }
.rate-tile .label { font-size: .8rem; color: var(--muted); text-transform: uppercase; letter-spacing: .06em; margin: 4px 0 10px; }
.rate-tile .rate  { font-size: 1rem; font-weight: 700; color: var(--text); }
.rate-tile .total { font-size: .85rem; color: var(--muted); margin-top: 4px; }

/* ── Card ── */
.form-card {
    background: white;
    border-radius: 18px;
    box-shadow: 0 4px 28px rgba(0,0,0,.08);
    padding: 42px 48px;
    margin-bottom: 40px;
}
@media(max-width:640px){ .form-card { padding: 28px 20px; } }

/* ── Section ── */
.form-section-title {
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--dark-green);
    border-bottom: 2px solid var(--light-green);
    padding-bottom: 8px;
    margin-bottom: 22px;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* ── Days Picker ── */
.days-picker {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
    margin-bottom: 6px;
}
@media(max-width:500px){ .days-picker { grid-template-columns: repeat(2,1fr); } }

.day-option { display: none; }
.day-label {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    border: 2px solid var(--border);
    border-radius: 12px;
    padding: 18px 12px;
    cursor: pointer;
    transition: all .2s;
    background: white;
    position: relative;
    user-select: none;
}
.day-label:hover { border-color: var(--green); background: #f0fdf4; }
.day-option:checked + .day-label {
    border-color: var(--green);
    background: var(--light-green);
    color: var(--dark-green);
}
.day-label .day-num { font-size: 2rem; font-weight: 800; line-height: 1; color: var(--green); }
.day-label .day-txt { font-size: .8rem; color: var(--muted); margin-top: 4px; }
.day-label .day-rate{ font-size: .75rem; font-weight: 700; color: var(--amber); margin-top: 6px;
                      background: #fffbeb; border-radius: 6px; padding: 2px 8px; }
.day-option:checked + .day-label .day-rate { background: #d1fae5; color: #065f46; }

/* ── Fee Display ── */
.fee-display {
    background: linear-gradient(135deg, var(--dark-green) 0%, #2d8a3e 100%);
    color: white;
    border-radius: 12px;
    padding: 20px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 24px;
}
.fee-display .fee-label { font-size: .85rem; opacity: .8; margin-bottom: 2px; }
.fee-display .fee-amount { font-size: 2rem; font-weight: 800; letter-spacing: -.02em; }
.fee-display .fee-breakdown { font-size: .8rem; opacity: .75; margin-top: 4px; }
#feeDisplay { display: none; }

/* ── Upload ── */
.upload-area {
    border: 2px dashed var(--border);
    border-radius: 10px;
    padding: 28px;
    text-align: center;
    cursor: pointer;
    transition: border-color .2s, background .2s;
}
.upload-area:hover { border-color: var(--green); background: #f8fff9; }
.upload-area i { font-size: 2rem; color: var(--muted); margin-bottom: 8px; display: block; }
.file-preview { display: none; align-items: center; gap: 10px; padding: 12px 16px;
                background: var(--light-green); border-radius: 8px; }
.file-preview i { color: var(--green); font-size: 1.2rem; }
.file-preview .fname { font-size: .9rem; font-weight: 600; flex: 1; }
.file-preview .btn-remove { background: none; border: none; cursor: pointer; color: #ef4444; font-size: 1rem; }

/* ── Payment methods ── */
.payment-methods { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
@media(max-width:480px){ .payment-methods { grid-template-columns: 1fr; } }
.pay-card { display: block; border: 2px solid var(--border); border-radius: 10px; padding: 14px 18px;
            cursor: pointer; transition: all .2s; }
.pay-card:hover { border-color: var(--green); }
.pay-card input { display: none; }
.pay-card.selected { border-color: var(--green); background: #f0fdf4; }
.pay-card-inner { display: flex; align-items: center; gap: 12px; }
.pay-card-inner i { font-size: 1.5rem; color: var(--green); }
.pay-card-inner .ptitle { font-weight: 700; font-size: .9rem; color: var(--text); }
.pay-card-inner .psub   { font-size: .78rem; color: var(--muted); }

/* ── Payment details card ── */
.payment-details {
    background: #f8fafc;
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 20px;
    margin-top: 14px;
}
.payment-details h6 { font-weight: 700; margin-bottom: 12px; }
.detail-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f1f5f9; font-size: .9rem; }
.detail-row:last-child { border-bottom: none; }
.detail-row .dk { color: var(--muted); }
.detail-row .dv { font-weight: 700; color: var(--text); }
.detail-row.highlight .dv { color: var(--dark-green); font-size: 1rem; }

/* ── Submit btn ── */
.btn-submit {
    background: linear-gradient(135deg, var(--dark-green) 0%, #2d8a3e 100%);
    color: white; border: none; border-radius: 10px;
    padding: 16px 40px; font-size: 1.05rem; font-weight: 700;
    cursor: pointer; width: 100%;
    transition: opacity .2s, transform .15s;
}
.btn-submit:hover { opacity: .9; transform: translateY(-2px); }
.btn-submit:disabled { opacity: .5; cursor: not-allowed; transform: none; }

/* ── Back link ── */
.back-link { display: inline-flex; align-items: center; gap: 6px; color: var(--muted);
             text-decoration: none; font-size: .9rem; margin-bottom: 24px;
             transition: color .2s; }
.back-link:hover { color: var(--dark-green); }
</style>

{{-- Hero --}}
<div class="pr-hero">
    <div class="container">
        <h1><i class="bi bi-calendar2-week me-2"></i>Partial Day Registration</h1>
        <p>Attending for fewer than 5 days? Register here and pay only for the days you attend.</p>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <a href="{{ route('conference.register.form') }}" class="back-link">
                <i class="bi bi-arrow-left"></i> Back to full registration
            </a>

            {{-- Alerts --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Rate Banner --}}
            <div class="rate-banner">
                <h5><i class="bi bi-tags-fill me-2"></i>Partial Attendance Rates</h5>
                <div class="rate-grid">
                    <div class="rate-tile">
                        <div class="days">1</div>
                        <div class="label">Day</div>
                        <div class="rate">KES 4,500 / day</div>
                        <div class="total">Total: <strong>KES 4,500</strong></div>
                    </div>
                    <div class="rate-tile">
                        <div class="days">2</div>
                        <div class="label">Days</div>
                        <div class="rate">KES 4,500 / day</div>
                        <div class="total">Total: <strong>KES 9,000</strong></div>
                    </div>
                    <div class="rate-tile">
                        <div class="days">3</div>
                        <div class="label">Days</div>
                        <div class="rate">KES 4,000 / day</div>
                        <div class="total">Total: <strong>KES 12,000</strong></div>
                    </div>
                    <div class="rate-tile">
                        <div class="days">4</div>
                        <div class="label">Days</div>
                        <div class="rate">KES 4,000 / day</div>
                        <div class="total">Total: <strong>KES 16,000</strong></div>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('conference.register.partial') }}" enctype="multipart/form-data" id="partialForm">
                @csrf

                {{-- ── PERSONAL DETAILS ── --}}
                <div class="form-card">
                    <div class="form-section-title">
                        <i class="bi bi-person-circle text-success"></i> Personal Details
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" name="firstName"
                                   value="{{ old('firstName') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" name="lastName"
                                   value="{{ old('lastName') }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control form-control-lg" name="email"
                                   value="{{ old('email') }}" placeholder="your@email.com" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Phone Code <span class="text-danger">*</span></label>
                            <select class="form-select form-select-lg" name="phonePrefix" required>
                                <option value="">Select</option>
                                @include('includes.prefixes')
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control form-control-lg" name="phoneNumber"
                                   value="{{ old('phoneNumber') }}" placeholder="712 345 678" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Institution / Organisation <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" name="institution"
                                   value="{{ old('institution') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Country <span class="text-danger">*</span></label>
                            <select class="form-select form-select-lg" name="country" required>
                                <option value="">Select Country</option>
                                @include('includes.countrylist')
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nationality <span class="text-danger">*</span></label>
                            <select class="form-select form-select-lg" name="nationality" id="nationality" required>
                                <option value="">Select</option>
                                <option value="east_african" {{ old('nationality') == 'east_african' ? 'selected' : '' }}>Local &amp; EAC</option>
                                <option value="non_east_african" {{ old('nationality') == 'non_east_african' ? 'selected' : '' }}>International</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Category <span class="text-danger">*</span></label>
                            <select class="form-select form-select-lg" name="category" id="category" required>
                                <option value="">Select Category</option>
                                <option value="professional" {{ old('category') == 'professional' ? 'selected' : '' }}>Scientists / Professionals</option>
                                <option value="student"      {{ old('category') == 'student'      ? 'selected' : '' }}>Student (Valid Student ID Required)</option>
                            </select>
                        </div>

                        {{-- Student ID upload (hidden unless student) --}}
                        <div class="col-12" id="studentIdSection" style="display:none;">
                            <label class="form-label fw-bold">Student ID <span class="text-danger">*</span></label>
                            <div class="upload-area" id="studentIdArea">
                                <input type="file" id="studentIdFile" name="studentId" accept="image/*,.pdf" style="display:none">
                                <i class="bi bi-cloud-upload"></i>
                                <p class="mb-0"><strong>Click to upload</strong> your student ID</p>
                                <small class="text-muted">PNG, JPG, PDF (Max 5 MB)</small>
                            </div>
                            <div class="file-preview mt-2" id="studentIdPreview">
                                <i class="bi bi-file-earmark-check-fill"></i>
                                <span class="fname" id="studentIdName"></span>
                                <button type="button" class="btn-remove" id="removeStudentId"><i class="bi bi-x-lg"></i></button>
                            </div>
                        </div>

                        {{-- Paper Reference (optional) --}}
                        <div class="col-12">
                            <label class="form-label">Paper Reference / Submission Code <span class="text-muted fw-normal">(optional)</span></label>
                            <input type="text" class="form-control form-control-lg" name="paperRefCode"
                                   value="{{ old('paperRefCode') }}"
                                   placeholder="e.g. KALRO-2026-0042">
                            <small class="text-muted"><i class="bi bi-info-circle me-1"></i>Only fill if you have submitted a full paper for presentation.</small>
                        </div>
                    </div>
                </div>

                {{-- ── DAYS SELECTION + FEE ── --}}
                <div class="form-card">
                    <div class="form-section-title">
                        <i class="bi bi-calendar-range text-success"></i> Select Number of Days
                    </div>

                    <p class="text-muted mb-4">Choose how many days you will attend. The fee is calculated automatically.</p>

                    <div class="days-picker mb-3">
                        @php $oldDays = old('days_count'); @endphp
                        @foreach([1,2,3,4] as $d)
                        @php
                            $rate  = $d <= 2 ? 4500 : 4000;
                            $total = $rate * $d;
                        @endphp
                        <div>
                            <input type="radio" name="days_count" id="day{{ $d }}" value="{{ $d }}"
                                   class="day-option" {{ $oldDays == $d ? 'checked' : '' }}
                                   onchange="updateFee()">
                            <label for="day{{ $d }}" class="day-label">
                                <span class="day-num">{{ $d }}</span>
                                <span class="day-txt">{{ $d == 1 ? 'Day' : 'Days' }}</span>
                                <span class="day-rate">KES {{ number_format($rate) }}/day</span>
                            </label>
                        </div>
                        @endforeach
                    </div>

                    {{-- Fee display --}}
                    <div id="feeDisplay" class="fee-display">
                        <div>
                            <div class="fee-label">Your Registration Fee</div>
                            <div class="fee-amount" id="feeAmount">—</div>
                            <div class="fee-breakdown" id="feeBreakdown"></div>
                        </div>
                        <i class="bi bi-calculator" style="font-size:2.5rem;opacity:.3"></i>
                    </div>

                    {{-- Hidden inputs sent to server --}}
                    <input type="hidden" name="fee" id="feeInput" value="{{ old('fee') }}">
                    <input type="hidden" name="feeCurrency" value="KES">

                    <div class="alert alert-info d-flex gap-2 align-items-start" style="border-radius:10px;">
                        <i class="bi bi-info-circle-fill mt-1 flex-shrink-0"></i>
                        <div>
                            <strong>Physical attendance only.</strong> Partial-day registration is for in-person attendance at the venue.
                            For virtual participation, please use the <a href="{{ route('conference.register.form') }}">full registration form</a>.
                        </div>
                    </div>
                </div>

                {{-- ── PAYMENT ── --}}
                <div class="form-card">
                    <div class="form-section-title">
                        <i class="bi bi-credit-card text-success"></i> Payment
                    </div>

                    <p class="text-muted mb-4">
                        Please make payment using one of the methods below, then upload your proof of payment.
                    </p>

                    {{-- Method selector --}}
                    <div class="payment-methods mb-4">
                        <label class="pay-card selected" id="bankCard">
                            <input type="radio" name="paymentMethod" value="bank" checked onchange="switchPayment('bank')">
                            <div class="pay-card-inner">
                                <i class="bi bi-bank"></i>
                                <div>
                                    <div class="ptitle">Bank Transfer</div>
                                    <div class="psub">Direct bank deposit</div>
                                </div>
                            </div>
                        </label>
                        <label class="pay-card" id="mpesaCard">
                            <input type="radio" name="paymentMethod" value="mpesa" onchange="switchPayment('mpesa')">
                            <div class="pay-card-inner">
                                <i class="bi bi-phone"></i>
                                <div>
                                    <div class="ptitle">M-Pesa</div>
                                    <div class="psub">Mobile money</div>
                                </div>
                            </div>
                        </label>
                    </div>

                    {{-- Bank details --}}
                    <div id="bankDetails" class="payment-details">
                        <h6><i class="bi bi-bank2 me-2 text-success"></i>Bank Transfer Details</h6>
                        <div class="detail-row"><span class="dk">Account Name</span><span class="dv">KALRO EAAPP</span></div>
                        <div class="detail-row highlight"><span class="dk">Account Number</span><span class="dv">1116139030</span></div>
                        <div class="detail-row"><span class="dk">Bank</span><span class="dv">KCB Ltd</span></div>
                        <div class="detail-row"><span class="dk">Branch</span><span class="dv">K.I.C.C</span></div>
                        <div class="detail-row"><span class="dk">Bank Code</span><span class="dv">01104</span></div>
                        <div class="detail-row"><span class="dk">Swift Code</span><span class="dv">KCBLKENX</span></div>
                    </div>

                    {{-- M-Pesa details --}}
                    <div id="mpesaDetails" class="payment-details" style="display:none;">
                        <h6><i class="bi bi-phone-fill me-2 text-success"></i>M-Pesa Payment Details</h6>
                        <div class="detail-row highlight"><span class="dk">Paybill Number</span><span class="dv">522522</span></div>
                        <div class="detail-row highlight"><span class="dk">Account Number</span><span class="dv">1116139030</span></div>
                        <div class="detail-row"><span class="dk">Amount</span><span class="dv" id="mpesaAmount">See fee above</span></div>
                        <div style="margin-top:14px;">
                            <p class="mb-2 fw-bold small">Steps:</p>
                            <ol class="mb-0 small">
                                <li>Go to M-Pesa menu → Lipa na M-Pesa → Pay Bill</li>
                                <li>Business Number: <strong>522522</strong></li>
                                <li>Account Number: <strong>1116139030</strong></li>
                                <li>Enter the exact amount shown above</li>
                                <li>Enter your PIN and confirm</li>
                            </ol>
                        </div>
                    </div>

                    {{-- Transaction ID --}}
                    <div class="mt-4">
                        <label class="form-label fw-bold">Transaction / Reference ID <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg" name="transactionId"
                               value="{{ old('transactionId') }}"
                               placeholder="Confirmation code you received after payment" required>
                        <small class="text-muted">Enter the M-Pesa confirmation code or bank reference number.</small>
                    </div>

                    {{-- Payment Proof --}}
                    <div class="mt-4">
                        <label class="form-label fw-bold">Payment Proof <span class="text-danger">*</span></label>
                        <p class="text-muted small mb-2">Upload a screenshot or receipt of your payment.</p>
                        <div class="upload-area" id="proofArea">
                            <input type="file" id="proofFile" name="paymentProof" accept="image/*,.pdf" style="display:none" required>
                            <i class="bi bi-receipt"></i>
                            <p class="mb-0"><strong>Click to upload</strong> or drag and drop</p>
                            <small class="text-muted">PNG, JPG, PDF (Max 5 MB)</small>
                        </div>
                        <div class="file-preview mt-2" id="proofPreview">
                            <i class="bi bi-file-earmark-check-fill"></i>
                            <span class="fname" id="proofName"></span>
                            <button type="button" class="btn-remove" id="removeProof"><i class="bi bi-x-lg"></i></button>
                        </div>
                    </div>

                    {{-- Terms --}}
                    <div class="mt-4 d-flex gap-3 align-items-start">
                        <input type="checkbox" class="form-check-input mt-1" id="terms" required style="flex-shrink:0;width:20px;height:20px;">
                        <label for="terms" class="form-check-label">
                            I agree to the <a href="{{ route('terms', ['from' => route('conference.register.partial.form')]) }}" target="_blank">terms and conditions</a>
                            and confirm the details above are correct. <span class="text-danger">*</span>
                        </label>
                    </div>

                    {{-- Submit --}}
                    <div class="mt-5">
                        <button type="submit" class="btn-submit" id="submitBtn">
                            <i class="bi bi-check-circle me-2"></i> Submit Partial Registration
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>

<script>
// ── Fee rates ──
const RATES = { 1: 4500, 2: 4500, 3: 4000, 4: 4000 };

function updateFee() {
    const checked = document.querySelector('input[name="days_count"]:checked');
    const display = document.getElementById('feeDisplay');
    const amtEl   = document.getElementById('feeAmount');
    const brkEl   = document.getElementById('feeBreakdown');
    const input   = document.getElementById('feeInput');
    const mpesa   = document.getElementById('mpesaAmount');

    if (!checked) { display.style.display = 'none'; return; }

    const days  = parseInt(checked.value);
    const rate  = RATES[days];
    const total = rate * days;

    amtEl.textContent = `KES ${total.toLocaleString()}`;
    brkEl.textContent = `${days} day${days>1?'s':''} × KES ${rate.toLocaleString()} / day`;
    input.value = total;
    if (mpesa) mpesa.textContent = `KES ${total.toLocaleString()}`;
    display.style.display = 'flex';
}

// Run on load (for old() repopulation)
document.addEventListener('DOMContentLoaded', function() {
    updateFee();

    // ── Student ID toggle ──
    document.getElementById('category')?.addEventListener('change', function() {
        const sec  = document.getElementById('studentIdSection');
        const file = document.getElementById('studentIdFile');
        if (this.value === 'student') {
            sec.style.display = 'block';
            file.required = true;
        } else {
            sec.style.display = 'none';
            file.required = false;
        }
    });
    // Restore on old() repopulation
    if (document.getElementById('category')?.value === 'student') {
        document.getElementById('studentIdSection').style.display = 'block';
        document.getElementById('studentIdFile').required = true;
    }

    // ── File uploads ──
    setupUpload('studentIdArea', 'studentIdFile', 'studentIdPreview', 'studentIdName', 'removeStudentId');
    setupUpload('proofArea',     'proofFile',     'proofPreview',     'proofName',     'removeProof');

    function setupUpload(areaId, inputId, previewId, nameId, removeBtnId) {
        const area    = document.getElementById(areaId);
        const input   = document.getElementById(inputId);
        const preview = document.getElementById(previewId);
        const nameEl  = document.getElementById(nameId);
        const removeB = document.getElementById(removeBtnId);
        if (!area || !input) return;

        area.addEventListener('click', () => input.click());
        area.addEventListener('dragover', e => { e.preventDefault(); area.style.borderColor='#2d8a3e'; });
        area.addEventListener('dragleave', () => { area.style.borderColor=''; });
        area.addEventListener('drop', e => {
            e.preventDefault(); area.style.borderColor='';
            if (e.dataTransfer.files[0]) showFile(e.dataTransfer.files[0]);
        });
        input.addEventListener('change', function() { if (this.files[0]) showFile(this.files[0]); });

        function showFile(file) {
            nameEl.textContent = file.name;
            area.style.display    = 'none';
            preview.style.display = 'flex';
        }

        removeB?.addEventListener('click', e => {
            e.stopPropagation();
            input.value = '';
            area.style.display    = 'block';
            preview.style.display = 'none';
        });
    }
});

// ── Payment method toggle ──
function switchPayment(method) {
    document.getElementById('bankDetails').style.display  = method === 'bank'  ? 'block' : 'none';
    document.getElementById('mpesaDetails').style.display = method === 'mpesa' ? 'block' : 'none';
    document.getElementById('bankCard').classList.toggle('selected',  method === 'bank');
    document.getElementById('mpesaCard').classList.toggle('selected', method === 'mpesa');
}
</script>
@endsection
