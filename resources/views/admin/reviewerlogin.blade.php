<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reviewer Login - KALRO Conference</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            font-family: 'Nunito', sans-serif;
            background: 
                linear-gradient(rgba(13, 71, 161, 0.85), rgba(13, 71, 161, 0.85)),
                url('{{ asset("assets/images/banner1.jpg") }}') no-repeat center center / cover;
        }

        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 15px 45px rgba(0,0,0,0.25);
            overflow: hidden;
            max-width: 950px;
            width: 100%;
        }

        .login-header {
            background: linear-gradient(135deg, #1976d2, #0d47a1);
            color: #fff;
            padding: 35px;
            text-align: center;
        }

        .login-header img {
            max-width: 90px;
            margin-bottom: 15px;
        }

        .login-header h1 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .login-body {
            padding: 40px;
        }

        .form-control {
            border-radius: 8px;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
        }

        .form-control:focus {
            border-color: #1976d2;
            box-shadow: 0 0 0 0.2rem rgba(25, 118, 210, 0.25);
        }

        .input-group-text {
            background: #f5f5f5;
            border: 2px solid #e0e0e0;
            border-right: none;
        }

        .form-control.with-icon {
            border-left: none;
        }

        .btn-login {
            background: linear-gradient(135deg, #1976d2, #0d47a1);
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            color: white;
            width: 100%;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #0d47a1, #1976d2);
        }

        .toggle-password {
            cursor: pointer;
        }

        .info-box {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            border-radius: 6px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
<div class="login-container">
    <div class="login-card">

        <!-- HEADER -->
        <div class="login-header">
            <img src="{{ asset('assets/images/kalro-logo.gif') }}" alt="KALRO Logo">
            <h1>KALRO Reviewer Portal</h1>
            <p class="mb-1">2nd KALRO Scientific Conference & Exhibition</p>
            <small>Abstract Review System</small>
        </div>

        <!-- BODY -->
        <div class="login-body">

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            @endif

            <form method="POST" action="{{ route('reviewer.login.submit') }}">
                @csrf

                <!-- EMAIL -->
                <div class="form-group">
                    <label>Email Address</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        </div>
                        <input type="email"
                               name="email"
                               value="{{ old('email') }}"
                               class="form-control with-icon @error('email') is-invalid @enderror"
                               required
                               placeholder="Enter your email">
                    </div>
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- PASSWORD WITH SHOW/HIDE -->
                <div class="form-group">
                    <label>Password</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        </div>
                        <input type="password"
                               id="password"
                               name="password"
                               class="form-control with-icon @error('password') is-invalid @enderror"
                               required
                               placeholder="Enter your password">
                        <div class="input-group-append">
                            <span class="input-group-text toggle-password" onclick="togglePassword()">
                                <i class="fas fa-eye" id="eyeIcon"></i>
                            </span>
                        </div>
                    </div>
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Remember me for 30 days</label>
                </div>

                <button type="submit" class="btn btn-login mb-3">
                    <i class="fas fa-sign-in-alt"></i> Login to Review Portal
                </button>
            </form>

            <div class="info-box">
                <strong><i class="fas fa-exclamation-triangle"></i> First Time Login?</strong>
                <p class="mb-0 mt-2">
                    <small>You will be required to change your password after your first login.</small>
                </p>
            </div>

            <hr>

            <div class="text-center text-muted">
                <small>
                    <i class="fas fa-envelope"></i> Conference@kalro.org |
                    <i class="fas fa-phone"></i> 0800 721741
                </small>
            </div>

        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function togglePassword() {
        const password = document.getElementById('password');
        const icon = document.getElementById('eyeIcon');

        if (password.type === 'password') {
            password.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            password.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
</body>
</html>
