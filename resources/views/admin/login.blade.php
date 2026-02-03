<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login - KALRO Conference</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #2e7d32 0%, #1b5e20 100%);
            min-height: 100vh;
            font-family: 'Nunito', sans-serif;
        }
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
        }
        .login-header {
            background: linear-gradient(135deg, #2e7d32 0%, #1b5e20 100%);
            color: white;
            padding: 40px;
            text-align: center;
        }
        .login-header img {
            max-width: 80px;
            margin-bottom: 15px;
        }
        .login-header h1 {
            font-size: 24px;
            font-weight: 700;
            margin: 0;
        }
        .login-header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
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
            border-color: #2e7d32;
            box-shadow: 0 0 0 0.2rem rgba(46, 125, 50, 0.25);
        }
        .btn-login {
            background: linear-gradient(135deg, #2e7d32 0%, #1b5e20 100%);
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            color: white;
            width: 100%;
        }
        .btn-login:hover {
            background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 100%);
            color: white;
        }
        .demo-credentials {
            background: #fff3cd;
            border: 2px solid #ffc107;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .demo-credentials h6 {
            color: #856404;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .demo-credentials .credential-item {
            background: white;
            padding: 8px 12px;
            border-radius: 5px;
            margin: 5px 0;
            font-family: monospace;
        }
        .input-group-text {
            background: #f5f5f5;
            border: 2px solid #e0e0e0;
            border-right: none;
        }
        .form-control.with-icon {
            border-left: none;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <i class="fas fa-leaf fa-3x mb-3"></i>
                <h1>KALRO Admin Portal</h1>
                <p>2nd KALRO Scientific Conference and Exhibition</p>
                <small>Strengthening Agricultural Innovation Systems</small>
            </div>
            
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

                <!-- Demo Credentials Box -->
                <div class="demo-credentials">
                    <h6><i class="fas fa-info-circle"></i> Demo Login Credentials</h6>
                    <div class="credential-item">
                        <strong>Email:</strong> admin@kalro.org
                    </div>
                    <div class="credential-item">
                        <strong>Password:</strong> password123
                    </div>
                    <small class="text-muted">Click "Use Demo Credentials" button below to auto-fill</small>
                </div>

                <form method="POST" action="{{ route('admin.login.submit') }}" id="loginForm">
                    @csrf
                    
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-envelope"></i>
                                </span>
                            </div>
                            <input type="email" 
                                   class="form-control with-icon @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autofocus
                                   placeholder="Enter your email">
                        </div>
                        @error('email')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                            </div>
                            <input type="password" 
                                   class="form-control with-icon @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   required
                                   placeholder="Enter your password">
                        </div>
                        @error('password')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">
                            Remember me for 30 days
                        </label>
                    </div>

                    <button type="submit" class="btn btn-login mb-3">
                        <i class="fas fa-sign-in-alt"></i> Login to Dashboard
                    </button>

                    <button type="button" class="btn btn-outline-warning btn-block" onclick="useDemoCredentials()">
                        <i class="fas fa-user-shield"></i> Use Demo Credentials
                    </button>
                </form>

                <hr class="my-4">

                <div class="text-center">
                    <p class="text-muted mb-2">
                        <small>Having trouble logging in?</small>
                    </p>
                    <p class="mb-0">
                        <small>
                            <i class="fas fa-envelope"></i> Conference@kalro.org | 
                            <i class="fas fa-phone"></i> 0800 721741
                        </small>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function useDemoCredentials() {
            document.getElementById('email').value = 'admin@kalro.org';
            document.getElementById('password').value = 'password123';
            document.getElementById('remember').checked = true;
            
            // Optional: Auto-submit after filling
            // document.getElementById('loginForm').submit();
        }

        // Show/hide password toggle (optional enhancement)
        $(document).ready(function() {
            // Add show/hide password functionality if needed
        });
    </script>
</body>
</html>