@extends('layouts.header')

@section('title')
    Side Event Registration — 2nd KALRO Conference & Innovation Exhibition
@endsection

@section('content')
<div class="se-wrapper">

    {{-- ── HERO ── --}}
    <div class="se-hero">
        <div class="se-hero-bg"></div>
        <div class="container position-relative">
            <div class="se-hero-badge">2nd KALRO Conference & Innovation Exhibition</div>
            <h1 class="se-hero-title">Host a Side Event</h1>
            <p class="se-hero-sub">Complete the form below and we'll send you an invoice to confirm your booking.</p>
            <div class="se-hero-venue">
                <i class="bi bi-geo-alt-fill"></i> KALRO Headquarters — Nairobi, Kenya
            </div>
        </div>
    </div>

    <div class="container se-body">
        <div class="row justify-content-center">
            <div class="col-lg-9 col-xl-8">

                {{-- Alerts --}}
                @if(session('success'))
                    <div class="alert se-alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert se-alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert se-alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <ul class="mb-0 mt-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form id="sideEventForm" action="{{ route('side-event.register') }}" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf

                    {{-- ══════════════════════════════════════════
                         SECTION 1 — ORGANISER / HOST DETAILS
                    ══════════════════════════════════════════ --}}
                    <div class="se-card">
                        <div class="se-card-header">
                            <div class="se-card-icon"><i class="bi bi-person-badge"></i></div>
                            <div>
                                <h2 class="se-card-title">Organiser Details</h2>
                                <p class="se-card-sub">Who is hosting this side event?</p>
                            </div>
                        </div>

                        <div class="se-card-body">
                            <div class="se-field-grid">

                                <div class="se-field">
                                    <label class="se-label" for="host_organization">
                                        Organisation / Institution <span class="se-req">*</span>
                                    </label>
                                    <input type="text" class="se-input @error('host_organization') is-invalid @enderror"
                                           id="host_organization" name="host_organization"
                                           placeholder="Your organisation's full name"
                                           value="{{ old('host_organization') }}" required>
                                    @error('host_organization')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="se-field se-field--half">
                                    <label class="se-label" for="contact_name">
                                        Contact Person Name <span class="se-req">*</span>
                                    </label>
                                    <input type="text" class="se-input @error('contact_name') is-invalid @enderror"
                                           id="contact_name" name="contact_name"
                                           placeholder="Full name"
                                           value="{{ old('contact_name') }}" required>
                                    @error('contact_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="se-field se-field--half">
                                    <label class="se-label" for="contact_email">
                                        Email Address <span class="se-req">*</span>
                                    </label>
                                    <input type="email" class="se-input @error('contact_email') is-invalid @enderror"
                                           id="contact_email" name="contact_email"
                                           placeholder="contact@example.com"
                                           value="{{ old('contact_email') }}" required>
                                    @error('contact_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="se-field se-field--third">
                                    <label class="se-label" for="contact_phone_prefix">
                                        Code <span class="se-req">*</span>
                                    </label>
                                    <select class="se-input @error('contact_phone_prefix') is-invalid @enderror"
                                            id="contact_phone_prefix" name="contact_phone_prefix" required>
                                        <option value="">—</option>
                                        @include('includes.prefixes')
                                    </select>
                                    @error('contact_phone_prefix')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="se-field se-field--two-thirds">
                                    <label class="se-label" for="contact_phone">
                                        Phone Number <span class="se-req">*</span>
                                    </label>
                                    <input type="tel" class="se-input @error('contact_phone') is-invalid @enderror"
                                           id="contact_phone" name="contact_phone"
                                           placeholder="e.g., 712 345 678"
                                           value="{{ old('contact_phone') }}" required>
                                    @error('contact_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                {{-- Alternative contact --}}
                                <div class="se-field se-field--full">
                                    <div class="se-alt-toggle" id="altContactToggle">
                                        <i class="bi bi-plus-circle"></i> Add an alternative contact person
                                    </div>
                                </div>

                                <div id="altContactFields" class="se-alt-block se-field--full" style="display:none;">
                                    <div class="se-alt-label">
                                        <i class="bi bi-person-plus"></i> Alternative Contact
                                    </div>
                                    <div class="se-field-grid">
                                        <div class="se-field se-field--half">
                                            <label class="se-label" for="alt_contact_name">Name</label>
                                            <input type="text" class="se-input" id="alt_contact_name"
                                                   name="alt_contact_name" placeholder="Full name"
                                                   value="{{ old('alt_contact_name') }}">
                                        </div>
                                        <div class="se-field se-field--half">
                                            <label class="se-label" for="alt_contact_email">Email Address</label>
                                            <input type="email" class="se-input" id="alt_contact_email"
                                                   name="alt_contact_email" placeholder="alt@example.com"
                                                   value="{{ old('alt_contact_email') }}">
                                        </div>
                                        <div class="se-field se-field--third">
                                            <label class="se-label" for="alt_phone_prefix">Code</label>
                                            <select class="se-input" id="alt_phone_prefix" name="alt_phone_prefix">
                                                <option value="">—</option>
                                                @include('includes.prefixes')
                                            </select>
                                        </div>
                                        <div class="se-field se-field--two-thirds">
                                            <label class="se-label" for="alt_contact_phone">Phone Number</label>
                                            <input type="tel" class="se-input" id="alt_contact_phone"
                                                   name="alt_contact_phone" placeholder="e.g., 712 345 678"
                                                   value="{{ old('alt_contact_phone') }}">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- ══════════════════════════════════════════
                         SECTION 2 — SIDE EVENT BASICS
                    ══════════════════════════════════════════ --}}
                    <div class="se-card">
                        <div class="se-card-header">
                            <div class="se-card-icon"><i class="bi bi-calendar-event"></i></div>
                            <div>
                                <h2 class="se-card-title">Event Basics</h2>
                                <p class="se-card-sub">Title, date, time, and format of your side event</p>
                            </div>
                        </div>

                        <div class="se-card-body">
                            <div class="se-field-grid">

                                <div class="se-field">
                                    <label class="se-label" for="event_title">
                                        Title of Side Event <span class="se-req">*</span>
                                    </label>
                                    <input type="text" class="se-input @error('event_title') is-invalid @enderror"
                                           id="event_title" name="event_title"
                                           placeholder="Give your side event a clear, descriptive title"
                                           value="{{ old('event_title') }}" required>
                                    @error('event_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="se-field se-field--half">
                                    <label class="se-label" for="proposed_date">
                                        Proposed Date <span class="se-req">*</span>
                                    </label>
                                    <input type="date" class="se-input @error('proposed_date') is-invalid @enderror"
                                           id="proposed_date" name="proposed_date"
                                           value="{{ old('proposed_date') }}" required>
                                    @error('proposed_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="se-field se-field--half">
                                    <label class="se-label" for="proposed_time">
                                        Proposed Time <span class="se-req">*</span>
                                    </label>
                                    <input type="time" class="se-input @error('proposed_time') is-invalid @enderror"
                                           id="proposed_time" name="proposed_time"
                                           value="{{ old('proposed_time') }}" required>
                                    @error('proposed_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="se-field se-field--half">
                                    <label class="se-label" for="duration_hours">
                                        Duration (hours) <span class="se-req">*</span>
                                    </label>
                                    <select class="se-input @error('duration_hours') is-invalid @enderror"
                                            id="duration_hours" name="duration_hours" required>
                                        <option value="">Select duration</option>
                                        @foreach(['0.5' => '30 minutes', '1' => '1 hour', '1.5' => '1.5 hours', '2' => '2 hours', '2.5' => '2.5 hours', '3' => '3 hours', '4' => '4 hours', '5' => '5 hours', '6+' => '6 hours or more'] as $val => $label)
                                            <option value="{{ $val }}" {{ old('duration_hours') == $val ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('duration_hours')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="se-field se-field--half">
                                    <label class="se-label">
                                        Proposed Format <span class="se-req">*</span>
                                    </label>
                                    <div class="se-radio-group">
                                        @foreach(['in_person' => 'In-Person', 'virtual' => 'Virtual', 'hybrid' => 'Hybrid'] as $val => $label)
                                            <label class="se-radio-card">
                                                <input type="radio" name="format" value="{{ $val }}"
                                                       {{ old('format') == $val ? 'checked' : '' }}>
                                                <span>{{ $label }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                    @error('format')<div class="se-error">{{ $message }}</div>@enderror
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- ══════════════════════════════════════════
                         SECTION 3 — CONTENT & AGENDA
                    ══════════════════════════════════════════ --}}
                    <div class="se-card">
                        <div class="se-card-header">
                            <div class="se-card-icon"><i class="bi bi-journal-text"></i></div>
                            <div>
                                <h2 class="se-card-title">Content & Agenda</h2>
                                <p class="se-card-sub">Help us understand what your side event will cover</p>
                            </div>
                        </div>

                        <div class="se-card-body">
                            <div class="se-field-grid">

                                <div class="se-field">
                                    <label class="se-label" for="theme_alignment">
                                        Theme Alignment <span class="se-req">*</span>
                                    </label>
                                    <p class="se-hint">How does your side event align with the 2nd KALRO Conference & Expo theme?</p>
                                    <textarea class="se-input se-textarea @error('theme_alignment') is-invalid @enderror"
                                              id="theme_alignment" name="theme_alignment"
                                              rows="4" placeholder="Describe how your side event aligns with the conference theme…"
                                              required>{{ old('theme_alignment') }}</textarea>
                                    @error('theme_alignment')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="se-field">
                                    <label class="se-label" for="objectives">
                                        Objectives <span class="se-req">*</span>
                                    </label>
                                    <p class="se-hint">What are the objectives of holding this side event, and who is the target audience?</p>
                                    <textarea class="se-input se-textarea @error('objectives') is-invalid @enderror"
                                              id="objectives" name="objectives"
                                              rows="4" placeholder="State your objectives and describe the target audience…"
                                              required>{{ old('objectives') }}</textarea>
                                    @error('objectives')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="se-field">
                                    <label class="se-label" for="key_topics">
                                        Key Topics <span class="se-req">*</span>
                                    </label>
                                    <p class="se-hint">What key topics will be discussed in the side event?</p>
                                    <textarea class="se-input se-textarea @error('key_topics') is-invalid @enderror"
                                              id="key_topics" name="key_topics"
                                              rows="4" placeholder="List the main topics or discussion areas…"
                                              required>{{ old('key_topics') }}</textarea>
                                    @error('key_topics')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="se-field">
                                    <label class="se-label" for="proposed_agenda">
                                        Proposed Agenda <span class="se-req">*</span>
                                    </label>
                                    <p class="se-hint">Provide a running order or brief schedule for your side event.</p>
                                    <textarea class="se-input se-textarea @error('proposed_agenda') is-invalid @enderror"
                                              id="proposed_agenda" name="proposed_agenda"
                                              rows="6" placeholder="e.g. 09:00 – Welcome remarks | 09:15 – Keynote | 10:00 – Panel discussion…"
                                              required>{{ old('proposed_agenda') }}</textarea>
                                    @error('proposed_agenda')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="se-field">
                                    <label class="se-label" for="key_participants">
                                        Key Participants <span class="se-req">*</span>
                                    </label>
                                    <textarea class="se-input se-textarea @error('key_participants') is-invalid @enderror"
                                              id="key_participants" name="key_participants"
                                              rows="4" placeholder="Who are the key speakers, panellists, or participants?"
                                              required>{{ old('key_participants') }}</textarea>
                                    @error('key_participants')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="se-field">
                                    <label class="se-label" for="expected_outcomes">
                                        Expected Outcomes <span class="se-req">*</span>
                                    </label>
                                    <textarea class="se-input se-textarea @error('expected_outcomes') is-invalid @enderror"
                                              id="expected_outcomes" name="expected_outcomes"
                                              rows="4" placeholder="What do you hope to achieve or produce from this side event?"
                                              required>{{ old('expected_outcomes') }}</textarea>
                                    @error('expected_outcomes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- ══════════════════════════════════════════
                         SECTION 4 — LOGISTICS
                    ══════════════════════════════════════════ --}}
                    <div class="se-card">
                        <div class="se-card-header">
                            <div class="se-card-icon"><i class="bi bi-tools"></i></div>
                            <div>
                                <h2 class="se-card-title">Logistics & Execution</h2>
                                <p class="se-card-sub">Venue setup, media, publicity, and documentation needs</p>
                            </div>
                        </div>

                        <div class="se-card-body">
                            <div class="se-field-grid">

                                <div class="se-field">
                                    <label class="se-label" for="venue_setup">
                                        Venue Setup Requirements <span class="se-req">*</span>
                                    </label>
                                    <p class="se-hint">Describe what you need for the venue setup (furniture, AV, layout, etc.)</p>
                                    <textarea class="se-input se-textarea @error('venue_setup') is-invalid @enderror"
                                              id="venue_setup" name="venue_setup"
                                              rows="4" placeholder="e.g., Theatre-style seating for 50, projector, microphone, breakout tables…"
                                              required>{{ old('venue_setup') }}</textarea>
                                    @error('venue_setup')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                {{-- Media services checkboxes --}}
                                <div class="se-field">
                                    <label class="se-label">Media Services Required</label>
                                    <div class="se-check-group">
                                        <label class="se-checkbox">
                                            <input type="checkbox" name="needs_videography" value="1"
                                                   {{ old('needs_videography') ? 'checked' : '' }}>
                                            <span class="se-checkbox-box"></span>
                                            <span>Videography</span>
                                        </label>
                                        <label class="se-checkbox">
                                            <input type="checkbox" name="needs_livestream" value="1"
                                                   {{ old('needs_livestream') ? 'checked' : '' }}>
                                            <span class="se-checkbox-box"></span>
                                            <span>Live Streaming</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="se-field">
                                    <label class="se-label" for="publicity_plan">
                                        Publicity Plan <span class="se-req">*</span>
                                    </label>
                                    <p class="se-hint">What steps have you taken or plan to take to promote this side event?</p>
                                    <textarea class="se-input se-textarea @error('publicity_plan') is-invalid @enderror"
                                              id="publicity_plan" name="publicity_plan"
                                              rows="4" placeholder="Social media, email campaigns, partner networks…"
                                              required>{{ old('publicity_plan') }}</textarea>
                                    @error('publicity_plan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="se-field">
                                    <label class="se-label" for="documentation_output">
                                        Documentation / Output <span class="se-req">*</span>
                                    </label>
                                    <p class="se-hint">What will be the final output or deliverable from this side event?</p>
                                    <textarea class="se-input se-textarea @error('documentation_output') is-invalid @enderror"
                                              id="documentation_output" name="documentation_output"
                                              rows="4" placeholder="e.g., Summary report, press release, recorded video, policy brief…"
                                              required>{{ old('documentation_output') }}</textarea>
                                    @error('documentation_output')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- ══════════════════════════════════════════
                         SECTION 5 — UPLOADS
                    ══════════════════════════════════════════ --}}
                    <div class="se-card">
                        <div class="se-card-header">
                            <div class="se-card-icon"><i class="bi bi-cloud-arrow-up"></i></div>
                            <div>
                                <h2 class="se-card-title">Uploads</h2>
                                <p class="se-card-sub">Attach your organisation's logo and presenter photos</p>
                            </div>
                        </div>

                        <div class="se-card-body">
                            <div class="se-field-grid">

                                {{-- Logo --}}
                                <div class="se-field se-field--half">
                                    <label class="se-label">
                                        Organisation Logo <span class="se-req">*</span>
                                    </label>
                                    <div class="se-upload-zone" id="logoZone">
                                        <input type="file" class="se-upload-input" id="logo" name="logo"
                                               accept="image/*,.svg,.pdf" required>
                                        <div class="se-upload-placeholder">
                                            <i class="bi bi-image"></i>
                                            <p><strong>Click to upload logo</strong></p>
                                            <small>PNG, JPG, SVG (max 5MB)</small>
                                        </div>
                                        <div class="se-upload-preview" style="display:none;">
                                            <i class="bi bi-file-earmark-check-fill"></i>
                                            <span class="se-fname"></span>
                                            <button type="button" class="se-remove-btn">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @error('logo')<div class="se-error mt-1">{{ $message }}</div>@enderror
                                </div>

                                {{-- Presenter photos --}}
                                <div class="se-field se-field--half">
                                    <label class="se-label">Photos of Presenters</label>
                                    <div class="se-upload-zone" id="photosZone">
                                        <input type="file" class="se-upload-input" id="presenter_photos"
                                               name="presenter_photos[]" accept="image/*" multiple>
                                        <div class="se-upload-placeholder">
                                            <i class="bi bi-people"></i>
                                            <p><strong>Click to upload photos</strong></p>
                                            <small>PNG, JPG — multiple allowed (max 5MB each)</small>
                                        </div>
                                        <div class="se-upload-preview" style="display:none;">
                                            <i class="bi bi-file-earmark-check-fill"></i>
                                            <span class="se-fname"></span>
                                            <button type="button" class="se-remove-btn">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @error('presenter_photos')<div class="se-error mt-1">{{ $message }}</div>@enderror
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- ══════════════════════════════════════════
                         INVOICE REQUEST NOTICE
                    ══════════════════════════════════════════ --}}
                    <div class="se-invoice-notice">
                        <div class="se-invoice-icon"><i class="bi bi-file-earmark-text"></i></div>
                        <div class="se-invoice-text">
                            <strong>How it works</strong>
                            <p>After submitting, our team will review your application and send an invoice to your email address. You can then proceed with payment to confirm your side event booking.</p>
                        </div>
                    </div>

                    {{-- ══════════════════════════════════════════
                         SUBMIT
                    ══════════════════════════════════════════ --}}
                    <div class="se-submit-row">
                        <button type="submit" class="se-submit-btn" id="submitBtn">
                            <span class="se-submit-inner">
                                <i class="bi bi-send-fill"></i>
                                Request for Invoice
                            </span>
                            <span class="se-submit-arrow"><i class="bi bi-arrow-right"></i></span>
                        </button>
                        <p class="se-submit-note">
                            <i class="bi bi-lock-fill"></i>
                            Your information is handled securely and used only for this booking.
                        </p>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════════
     STYLES
══════════════════════════════════════════════════════════════ --}}
<style>
/* ── Root tokens (match KALRO green palette) ── */
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
    --k-radius:     14px;
    --k-shadow:     0 4px 24px rgba(0,0,0,.07);
    --k-shadow-lg:  0 10px 40px rgba(0,0,0,.10);
}

/* ── Wrapper ── */
.se-wrapper {
    min-height: 100vh;
    background: linear-gradient(160deg, #f0faf3 0%, #e9f5ec 60%, #e4f0e8 100%);
}

/* ── Hero ── */
.se-hero {
    position: relative;
    background: var(--k-grad);
    padding: 4.5rem 0 5.5rem;
    overflow: hidden;
    clip-path: polygon(0 0, 100% 0, 100% 84%, 0 100%);
    color: #fff;
}
.se-hero-bg {
    position: absolute; inset: 0;
    background-image:
        radial-gradient(circle at 15% 40%, rgba(255,255,255,.06) 0%, transparent 50%),
        radial-gradient(circle at 80% 70%, rgba(255,255,255,.04) 0%, transparent 40%);
    pointer-events: none;
}
.se-hero-badge {
    display: inline-block;
    background: rgba(255,255,255,.18);
    border: 1px solid rgba(255,255,255,.3);
    color: #fff;
    font-size: .75rem;
    font-weight: 700;
    letter-spacing: .1em;
    text-transform: uppercase;
    padding: .35rem 1rem;
    border-radius: 100px;
    margin-bottom: 1.25rem;
    backdrop-filter: blur(6px);
}
.se-hero-title {
    font-size: clamp(2rem, 5vw, 3rem);
    font-weight: 800;
    letter-spacing: -.5px;
    margin: 0 0 .75rem;
    text-shadow: 0 2px 8px rgba(0,0,0,.15);
}
.se-hero-sub {
    font-size: 1.1rem;
    color: rgba(255,255,255,.9);
    margin: 0 0 1.5rem;
    max-width: 520px;
}
.se-hero-venue {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    background: rgba(255,255,255,.15);
    border: 1px solid rgba(255,255,255,.25);
    padding: .4rem 1rem;
    border-radius: 100px;
    font-size: .875rem;
    font-weight: 600;
    backdrop-filter: blur(4px);
}

/* ── Body area ── */
.se-body { padding-top: 1.5rem; padding-bottom: 5rem; }

/* ── Alerts ── */
.se-alert-success {
    background: var(--k-green-lt);
    color: var(--k-green-dark);
    border-left: 4px solid var(--k-green);
    border-radius: 12px;
    border-top: none; border-right: none; border-bottom: none;
    font-size: .95rem;
}
.se-alert-danger {
    background: #fef2f2;
    color: #991b1b;
    border-left: 4px solid #dc2626;
    border-radius: 12px;
    border-top: none; border-right: none; border-bottom: none;
    font-size: .95rem;
}

/* ── Card ── */
.se-card {
    background: #fff;
    border-radius: 20px;
    box-shadow: var(--k-shadow-lg);
    margin-bottom: 2rem;
    overflow: hidden;
    border: 1px solid rgba(26,95,58,.08);
    transition: box-shadow .3s;
}
.se-card:hover { box-shadow: 0 14px 50px rgba(0,0,0,.12); }

.se-card-header {
    display: flex;
    align-items: flex-start;
    gap: 1.25rem;
    padding: 2rem 2.5rem 1.5rem;
    border-bottom: 2px solid var(--k-green-lt);
    background: linear-gradient(135deg, #f7fbf8 0%, var(--k-green-xl) 100%);
}
.se-card-icon {
    flex-shrink: 0;
    width: 56px; height: 56px;
    border-radius: 14px;
    background: var(--k-grad);
    color: #fff;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.6rem;
    box-shadow: 0 4px 14px rgba(26,95,58,.35);
}
.se-card-title {
    font-size: 1.4rem;
    font-weight: 800;
    color: var(--k-text);
    margin: 0 0 .2rem;
    letter-spacing: -.3px;
}
.se-card-sub {
    font-size: .9rem;
    color: var(--k-muted);
    margin: 0;
}
.se-card-body { padding: 2rem 2.5rem 2.5rem; }

/* ── Field grid ── */
.se-field-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem 2rem;
}
.se-field        { grid-column: span 2; }
.se-field--half  { grid-column: span 1; }
.se-field--third { grid-column: span 1; max-width: 140px; }
.se-field--two-thirds { grid-column: span 1; }
.se-field--full  { grid-column: span 2; }

/* ── Label ── */
.se-label {
    display: block;
    font-size: .875rem;
    font-weight: 700;
    color: var(--k-text);
    margin-bottom: .45rem;
    letter-spacing: .01em;
}
.se-req { color: #dc2626; }
.se-hint {
    font-size: .8rem;
    color: var(--k-muted);
    margin: -.2rem 0 .6rem;
    line-height: 1.5;
}

/* ── Inputs ── */
.se-input {
    display: block;
    width: 100%;
    padding: .85rem 1.1rem;
    font-size: .975rem;
    color: var(--k-text);
    background: #fff;
    border: 2px solid var(--k-border);
    border-radius: 10px;
    transition: border-color .25s, box-shadow .25s;
    outline: none;
    appearance: none;
}
.se-input:focus {
    border-color: var(--k-green);
    box-shadow: 0 0 0 4px rgba(26,95,58,.1);
}
.se-input.is-invalid { border-color: #dc2626; }
.se-input.is-invalid:focus { box-shadow: 0 0 0 4px rgba(220,38,38,.1); }
select.se-input {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath fill='%23374151' d='M6 8L0 0h12z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 1rem center;
    background-size: 10px;
    padding-right: 2.5rem;
    cursor: pointer;
}
.se-textarea { resize: vertical; min-height: 100px; line-height: 1.6; }
.invalid-feedback { font-size: .8rem; color: #dc2626; margin-top: .3rem; }
.se-error { font-size: .8rem; color: #dc2626; }

/* ── Radio group (format selector) ── */
.se-radio-group {
    display: flex; gap: .75rem; flex-wrap: wrap;
}
.se-radio-card {
    flex: 1; min-width: 90px;
    display: block; cursor: pointer;
}
.se-radio-card input { position: absolute; opacity: 0; pointer-events: none; }
.se-radio-card span {
    display: flex; align-items: center; justify-content: center;
    padding: .7rem .5rem;
    border: 2.5px solid var(--k-border);
    border-radius: 10px;
    font-size: .875rem;
    font-weight: 600;
    color: var(--k-muted);
    transition: all .2s ease;
    text-align: center;
    background: #fff;
}
.se-radio-card:hover span { border-color: var(--k-green-acc); color: var(--k-green); }
.se-radio-card input:checked ~ span {
    border-color: var(--k-green);
    background: var(--k-green-lt);
    color: var(--k-green-dark);
    box-shadow: 0 2px 10px rgba(26,95,58,.15);
}

/* ── Checkboxes ── */
.se-check-group { display: flex; gap: 2rem; flex-wrap: wrap; margin-top: .35rem; }
.se-checkbox {
    display: flex; align-items: center; gap: .65rem;
    cursor: pointer; font-size: .95rem; color: var(--k-text); font-weight: 500;
}
.se-checkbox input { display: none; }
.se-checkbox-box {
    flex-shrink: 0;
    width: 22px; height: 22px;
    border-radius: 6px;
    border: 2px solid var(--k-border);
    background: #fff;
    display: flex; align-items: center; justify-content: center;
    transition: all .2s ease;
}
.se-checkbox input:checked ~ .se-checkbox-box {
    background: var(--k-green);
    border-color: var(--k-green);
}
.se-checkbox input:checked ~ .se-checkbox-box::after {
    content: '';
    width: 5px; height: 9px;
    border: 2px solid #fff;
    border-top: none; border-left: none;
    transform: rotate(45deg) translate(-1px, -1px);
    display: block;
}

/* ── Alternative contact toggle ── */
.se-alt-toggle {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    color: var(--k-green);
    font-size: .9rem;
    font-weight: 600;
    cursor: pointer;
    padding: .6rem 1rem;
    border: 2px dashed rgba(26,95,58,.35);
    border-radius: 10px;
    background: var(--k-green-xl);
    transition: all .2s ease;
}
.se-alt-toggle:hover {
    background: var(--k-green-lt);
    border-color: var(--k-green);
}
.se-alt-block {
    background: var(--k-green-xl);
    border: 2px solid var(--k-green-lt);
    border-radius: 14px;
    padding: 1.5rem;
}
.se-alt-label {
    display: flex; align-items: center; gap: .5rem;
    font-size: .875rem; font-weight: 700;
    color: var(--k-green-dark);
    margin-bottom: 1.25rem;
}
.se-alt-label i { font-size: 1.1rem; }

/* ── File upload zones ── */
.se-upload-zone {
    border: 3px dashed var(--k-border);
    border-radius: 14px;
    padding: 2rem 1.5rem;
    text-align: center;
    cursor: pointer;
    background: var(--k-bg);
    transition: all .25s ease;
    min-height: 130px;
    display: flex; align-items: center; justify-content: center;
}
.se-upload-zone:hover {
    border-color: var(--k-green-acc);
    background: var(--k-green-xl);
}
.se-upload-input { display: none; }
.se-upload-placeholder i {
    font-size: 2.5rem;
    color: var(--k-green);
    display: block;
    margin-bottom: .6rem;
}
.se-upload-placeholder p {
    font-size: .9rem;
    color: var(--k-text);
    margin: 0 0 .2rem;
}
.se-upload-placeholder strong { color: var(--k-green); }
.se-upload-placeholder small { color: var(--k-muted); font-size: .78rem; }
.se-upload-preview {
    display: flex; align-items: center; gap: .75rem;
    width: 100%;
    padding: .85rem 1rem;
    background: #fff;
    border-radius: 10px;
    border: 2px solid var(--k-green-mid);
}
.se-upload-preview i { font-size: 1.6rem; color: var(--k-green-mid); flex-shrink: 0; }
.se-fname {
    flex: 1;
    font-weight: 600;
    font-size: .85rem;
    color: var(--k-text);
    word-break: break-all;
    text-align: left;
}
.se-remove-btn {
    flex-shrink: 0;
    width: 32px; height: 32px;
    background: #dc2626; color: #fff;
    border: none; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; font-size: .85rem;
    transition: background .2s;
}
.se-remove-btn:hover { background: #b91c1c; }

/* ── Invoice notice ── */
.se-invoice-notice {
    display: flex;
    align-items: flex-start;
    gap: 1.25rem;
    background: linear-gradient(135deg, #fffbeb, #fef3c7);
    border: 2px solid #fcd34d;
    border-radius: 16px;
    padding: 1.75rem 2rem;
    margin-bottom: 2rem;
}
.se-invoice-icon {
    flex-shrink: 0;
    width: 50px; height: 50px;
    background: #f59e0b;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.6rem; color: #fff;
}
.se-invoice-text strong {
    display: block;
    font-size: 1rem;
    font-weight: 800;
    color: #78350f;
    margin-bottom: .35rem;
}
.se-invoice-text p {
    font-size: .9rem;
    color: #92400e;
    margin: 0;
    line-height: 1.6;
}

/* ── Submit row ── */
.se-submit-row {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
    padding-bottom: 2rem;
}
.se-submit-btn {
    display: inline-flex;
    align-items: center;
    gap: 1.25rem;
    padding: 1.1rem 3rem 1.1rem 2.25rem;
    background: var(--k-grad);
    color: #fff;
    border: none;
    border-radius: 14px;
    font-size: 1.1rem;
    font-weight: 800;
    letter-spacing: .3px;
    cursor: pointer;
    transition: all .3s ease;
    box-shadow: 0 6px 20px rgba(26,95,58,.35);
    text-transform: uppercase;
}
.se-submit-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 30px rgba(26,95,58,.45);
}
.se-submit-btn:active { transform: translateY(-1px); }
.se-submit-inner { display: flex; align-items: center; gap: .75rem; }
.se-submit-arrow {
    width: 40px; height: 40px;
    border-radius: 10px;
    background: rgba(255,255,255,.2);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem;
    transition: background .2s;
}
.se-submit-btn:hover .se-submit-arrow { background: rgba(255,255,255,.3); }
.se-submit-note {
    font-size: .8rem;
    color: var(--k-muted);
    display: flex;
    align-items: center;
    gap: .4rem;
    margin: 0;
}
.se-submit-note i { color: var(--k-green-acc); }

/* ── Responsive ── */
@media (max-width: 768px) {
    .se-card-body  { padding: 1.5rem; }
    .se-card-header { padding: 1.5rem; }
    .se-field-grid { grid-template-columns: 1fr; gap: 1.25rem; }
    .se-field--half,
    .se-field--third,
    .se-field--two-thirds { grid-column: span 1; max-width: 100%; width: 100%; }
    .se-radio-group { flex-direction: column; }
    .se-radio-card { flex: none; width: 100%; }
    .se-submit-btn { width: 100%; justify-content: center; font-size: 1rem; }
    .se-check-group { flex-direction: column; gap: .75rem; }
}
@media (max-width: 576px) {
    .se-hero { padding: 3rem 0 4.5rem; }
    .se-hero-title { font-size: 1.9rem; }
    .se-body { padding-top: .5rem; }
    .se-invoice-notice { flex-direction: column; }
}
</style>

{{-- ══════════════════════════════════════════════════════════════
     SCRIPTS
══════════════════════════════════════════════════════════════ --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── Alternative contact toggle ──────────────────────────────
    const altToggle = document.getElementById('altContactToggle');
    const altFields = document.getElementById('altContactFields');
    if (altToggle && altFields) {
        altToggle.addEventListener('click', function () {
            const isHidden = altFields.style.display === 'none';
            altFields.style.display = isHidden ? 'block' : 'none';
            this.innerHTML = isHidden
                ? '<i class="bi bi-dash-circle"></i> Remove alternative contact'
                : '<i class="bi bi-plus-circle"></i> Add an alternative contact person';
        });
    }

    // ── File upload helper ───────────────────────────────────────
    function setupUpload(zoneId, inputId) {
        const zone     = document.getElementById(zoneId);
        const input    = document.getElementById(inputId);
        if (!zone || !input) return;
        const placeholder = zone.querySelector('.se-upload-placeholder');
        const preview     = zone.querySelector('.se-upload-preview');
        const fname       = preview && preview.querySelector('.se-fname');
        const removeBtn   = preview && preview.querySelector('.se-remove-btn');

        zone.addEventListener('click', function (e) {
            if (!e.target.closest('.se-remove-btn')) input.click();
        });
        zone.addEventListener('dragover', function (e) {
            e.preventDefault();
            zone.style.borderColor = '#1a5f3a';
            zone.style.background  = '#e6f4ec';
        });
        zone.addEventListener('dragleave', function () {
            zone.style.borderColor = '';
            zone.style.background  = '';
        });
        zone.addEventListener('drop', function (e) {
            e.preventDefault();
            zone.style.borderColor = '';
            zone.style.background  = '';
            if (e.dataTransfer.files.length) {
                // assign files to input
                try {
                    const dt = new DataTransfer();
                    Array.from(e.dataTransfer.files).forEach(f => dt.items.add(f));
                    input.files = dt.files;
                } catch (_) {}
                showPreview(e.dataTransfer.files);
            }
        });
        input.addEventListener('change', function () {
            if (this.files && this.files.length) showPreview(this.files);
        });

        function showPreview(files) {
            if (!files || !files.length) return;
            const label = files.length === 1
                ? files[0].name
                : files.length + ' files selected';
            if (fname) fname.textContent = label;
            if (placeholder) placeholder.style.display = 'none';
            if (preview)     preview.style.display = 'flex';
        }

        if (removeBtn) {
            removeBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                input.value = '';
                if (placeholder) placeholder.style.display = '';
                if (preview)     preview.style.display = 'none';
            });
        }
    }

    setupUpload('logoZone',   'logo');
    setupUpload('photosZone', 'presenter_photos');

    // ── Client-side submit guard ─────────────────────────────────
    const form = document.getElementById('sideEventForm');
    const submitBtn = document.getElementById('submitBtn');
    if (form && submitBtn) {
        form.addEventListener('submit', function (e) {
            // Check all required fields
            const required = form.querySelectorAll('[required]');
            let hasError = false;
            required.forEach(function (el) {
                if (!el.value.trim()) {
                    el.classList.add('is-invalid');
                    hasError = true;
                } else {
                    el.classList.remove('is-invalid');
                }
            });

            // Check at least one format radio is selected
            const formatChosen = form.querySelector('input[name="format"]:checked');
            if (!formatChosen) {
                form.querySelector('.se-radio-group').style.outline = '2px solid #dc2626';
                form.querySelector('.se-radio-group').style.borderRadius = '10px';
                hasError = true;
            }

            if (hasError) {
                e.preventDefault();
                // Scroll to first error
                const first = form.querySelector('.is-invalid, [required]:invalid');
                if (first) first.scrollIntoView({ behavior: 'smooth', block: 'center' });
                return;
            }

            // Loading state
            submitBtn.disabled = true;
            submitBtn.querySelector('.se-submit-inner').innerHTML =
                '<span class="spinner-border spinner-border-sm me-2" role="status"></span> Submitting…';
        });

        // Remove invalid highlight on input
        form.querySelectorAll('.se-input').forEach(function (el) {
            el.addEventListener('input', function () {
                this.classList.remove('is-invalid');
            });
        });

        // Clear format outline on selection
        form.querySelectorAll('input[name="format"]').forEach(function (r) {
            r.addEventListener('change', function () {
                const rg = form.querySelector('.se-radio-group');
                if (rg) { rg.style.outline = ''; rg.style.borderRadius = ''; }
            });
        });
    }

});
</script>
@endsection