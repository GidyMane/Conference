<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Login | KALRO Conference</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            min-height: 100vh;
            background:
                linear-gradient(rgba(73, 117, 76, 0.85), rgba(217, 230, 218, 0.85)),
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
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 15px 45px rgba(0,0,0,0.25);
            max-width: 420px;
            width: 100%;
            overflow: hidden;
        }

        .login-header {
            background: linear-gradient(135deg, #2e7d32, #1b5e20);
            color: #fff;
            text-align: center;
            padding: 30px 20px;
        }

        .login-header img {
            max-width: 90px;
            margin-bottom: 15px;
        }

        .login-header h1 {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .login-header p {
            font-size: 13px;
            opacity: 0.9;
            margin: 0;
        }

        .login-body {
            padding: 30px;
        }

        .form-control {
            border-radius: 8px;
            border: 2px solid #e0e0e0;
            padding: 12px;
        }

        .form-control:focus {
            border-color: #2e7d32;
            box-shadow: 0 0 0 0.2rem rgba(46,125,50,.25);
        }

        .input-group-text {
            background: #f5f5f5;
            border: 2px solid #e0e0e0;
        }

        .btn-login {
            background: linear-gradient(135deg, #2e7d32, #1b5e20);
            color: #fff;
            font-weight: 600;
            border-radius: 8px;
            padding: 12px;
            border: none;
            width: 100%;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #1b5e20, #2e7d32);
        }

        .show-password {
            cursor: pointer;
        }

        .footer-text {
            font-size: 12px;
            color: #666;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>

<div class="login-container">
    <div class="login-card">

        <!-- Header -->
        <div class="login-header">
            <img src="{{ asset('assets/images/kalro-logo.gif') }}" alt="KALRO Logo">
            <h1>KALRO Admin Portal</h1>
            <p>2nd KALRO Scientific Conference & Exhibition</p>
        </div>

        <!-- Body -->
        <div class="login-body">

            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf

                <!-- Email -->
                <div class="form-group">
                    <label>Email Address</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-envelope"></i>
                            </span>
                        </div>
                        <input type="email"
                               name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}"
                               placeholder="admin@kalro.org"
                               required>
                    </div>
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label>Password</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                        </div>

                        <input type="password"
                               id="password"
                               name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Enter password"
                               required>

                        <div class="input-group-append">
                            <span class="input-group-text show-password" onclick="togglePassword()">
                                <i class="fas fa-eye" id="eyeIcon"></i>
                            </span>
                        </div>
                    </div>
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Remember -->
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn btn-login">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>
            </form>

            <div class="footer-text">
                <p>
                    <i class="fas fa-envelope"></i> conference@kalro.org |
                    <i class="fas fa-phone"></i> 0800 721741
                </p>
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
