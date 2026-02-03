@extends('reviewer.layout')

@section('title', 'Change Password')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card">
                <div class="card-header text-center">Change Your Password</div>
                <div class="card-body">

                    @if(session('warning'))
                        <div class="alert alert-warning">
                            {{ session('warning') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('reviewer.password.update') }}">
                        @csrf

                        <div class="mb-3 position-relative">
                            <label class="form-label">New Password</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                            <span class="position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer"
                                  onclick="togglePassword('password', this)">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>

                        <div class="mb-3 position-relative">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                            <span class="position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer"
                                  onclick="togglePassword('password_confirmation', this)">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>

                        <button class="btn btn-primary w-100">
                            Update Password
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Hide navbar and sidebar on this page */
    body > header, body > aside {
        display: none !important;
    }
    .cursor-pointer { cursor: pointer; }
</style>
@endsection

@section('scripts')
<script>
    function togglePassword(fieldId, iconElement) {
        const input = document.getElementById(fieldId);
        if (input.type === "password") {
            input.type = "text";
            iconElement.innerHTML = '<i class="fas fa-eye-slash"></i>';
        } else {
            input.type = "password";
            iconElement.innerHTML = '<i class="fas fa-eye"></i>';
        }
    }
</script>
@endsection
