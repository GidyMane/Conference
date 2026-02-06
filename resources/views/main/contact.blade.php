@extends('layouts.header')
@section('title')
    Contact Us
@endsection

@section('content')

<!-- Page Header -->
<section class="page-header bg-success text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="display-4 fw-bold mb-3">
                    <i class="fas fa-envelope me-3"></i>Contact Us
                </h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center mb-0">
                        <li class="breadcrumb-item"><a href="/" class="text-white-50">Home</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Contact Us</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section py-5" style="background-color: #F0F0F0;">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="section-title mb-3">
                    <span class="section-title-text" style="color:#333;border-bottom:3px solid #DE5F07;padding-bottom:10px;display:inline-block;">
                        Get in Touch
                    </span>
                </h2>
                <p class="lead" style="color:#666;">We’d love to hear from you regarding the 2nd KALRO Scientific Conference</p>
            </div>
        </div>

        <div class="row g-4">
            <!-- Contact Form -->
            <div class="col-lg-7">
                <div class="card shadow border-0">
                    <div class="card-body p-4">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('contact.send') }}">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email Address</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Subject</label>
                                    <input type="text" name="subject" class="form-control" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Message</label>
                                    <textarea name="message" rows="5" class="form-control" required></textarea>
                                </div>
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-success px-4">
                                        <i class="fas fa-paper-plane me-2"></i>Send Message
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-5">
                <div class="card shadow border-0 h-100">
                    <div class="card-body p-4">
                        <h4 class="mb-4">Conference Secretariat</h4>
                        <p><i class="fas fa-map-marker-alt text-success me-2"></i>KALRO Headquarters, Nairobi, Kenya</p>
                        <p><i class="fas fa-envelope text-success me-2"></i>kalroconference2026@gmail.com</p>
                        <p><i class="fas fa-phone text-success me-2"></i>+254 20 722 6000</p>

                        <hr>

                        <h5 class="mb-3">Why Contact Us?</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Abstract submission support</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Registration enquiries</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Sponsorship & partnerships</li>
                            <li><i class="fas fa-check text-success me-2"></i>General conference information</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection