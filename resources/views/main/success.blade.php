@extends('layouts.header')

@section('title', 'Abstract Submitted Successfully')

@section('content')

<!-- Page Header -->
<section class="page-header bg-success text-white py-4">
    <div class="container">
        <h1 class="display-5 fw-bold">
            <i class="fas fa-check-circle me-2"></i>Submission Successful
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}" class="text-white-50">Home</a>
                </li>
                <li class="breadcrumb-item active text-white">
                    Abstract Submitted
                </li>
            </ol>
        </nav>
    </div>
</section>

<!-- Success Content -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="card shadow-sm border-0">
                    <div class="card-body p-5 text-center">

                        <i class="fas fa-paper-plane fa-4x text-success mb-3"></i>

                        <h2 class="text-success fw-bold">
                            Abstract Submitted Successfully!
                        </h2>

                        <p class="text-muted">
                            Thank you for submitting your abstract to the KALRO Conference.
                        </p>

                        <div class="alert alert-success mt-4 border-0">
                            <h5>Your Submission Reference Number</h5>
                            <div class="display-6 fw-bold">
                                {{ request('ref') }}
                            </div>
                            <small class="text-muted">
                                Please keep this reference number for future communication.
                            </small>
                        </div>

                        @if(session('email_sent'))
                            <div class="alert alert-success mt-4">
                                <i class="fas fa-envelope me-2"></i>
                                Confirmation email sent to
                                <strong>{{ session('corresponding_email') }}</strong>
                            </div>
                        @elseif(session('email_error'))
                            <div class="alert alert-warning mt-4">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Submission successful, but confirmation email could not be sent.
                            </div>
                        @endif

                        <div class="d-flex justify-content-center gap-3 mt-4">
                            <a href="{{ url('/') }}" class="btn btn-outline-secondary px-4">
                                <i class="fas fa-home me-2"></i>Home
                            </a>
                            <a href="{{ route('submit.abstract') }}" class="btn btn-success px-4">
                                <i class="fas fa-plus me-2"></i>Submit Another Abstract
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection