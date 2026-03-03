@extends('layouts.header')
@section('title', 'Full Paper Review Submitted Successfully')

@section('content')
<!-- Page Header -->
<section class="page-header bg-success text-white py-4">
    <div class="container">
        <h1 class="display-5 fw-bold">
            <i class="fas fa-check-circle me-2"></i>Review Submitted Successfully
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}" class="text-white-50">Home</a>
                </li>
                <li class="breadcrumb-item active text-white">Full Paper Review</li>
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
                        <h2 class="text-success fw-bold">Full Paper Review Submitted!</h2>
                        <p class="text-muted">
                            Thank you for completing your review for the KALRO Conference full paper submission.
                        </p>

                        <!-- Display Total Score -->
                        @if(session('total_score'))
                            <div class="alert alert-success mt-4 border-0">
                                <h5>Your Total Score</h5>
                                <div class="display-6 fw-bold text-dark">
                                    {{ session('total_score') }}/100
                                </div>
                                <small class="text-muted">Keep this score reference for your records.</small>
                            </div>
                        @endif

                        <!-- Optional Recommendation -->
                        @if(session('recommendation'))
                            <div class="alert alert-info mt-3">
                                <i class="fas fa-info-circle me-2"></i>
                                Recommendation submitted: <strong>{{ ucwords(str_replace('_', ' ', session('recommendation'))) }}</strong>
                            </div>
                        @endif

                        <div class="d-flex justify-content-center gap-3 mt-4">
                            <a href="{{ url('/') }}" class="btn btn-outline-secondary px-4">
                                <i class="fas fa-home me-2"></i>Home
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection