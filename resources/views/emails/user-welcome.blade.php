<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>KALRO Account Created</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            padding: 20px;
            text-align: center;
            background-color: #158532;
            color: #ffffff;
        }

        .content {
            background-color: #f8f9fa;
            padding: 20px;
        }

        .details {
            background-color: #ffffff;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }

        .credentials {
            background-color: #f1f3f5;
            padding: 12px;
            border-left: 4px solid #158532;
            border-radius: 4px;
            margin-top: 10px;
        }

        .login-btn {
            display: inline-block;
            padding: 12px 20px;
            background-color: #158532;
            color: #ffffff;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 15px;
        }

        .footer {
            text-align: center;
            padding: 20px;
            color: #666666;
            font-size: 12px;
        }

        a {
            color: #006400;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="container">

    {{-- HEADER --}}
    <div class="header">
        <h2>KALRO System</h2>
        <h3>Account Created Successfully</h3>
    </div>

    {{-- CONTENT --}}
    <div class="content">
        <p>Hello {{ $user->full_name }},</p>

        <p>
            Your account has been successfully created on the
            <strong>KALRO system</strong>.
            Please find your login details below.
        </p>

        <div class="details">
            <h4>Login Details</h4>

            <div class="credentials">
                <p>
                    <strong>Email:</strong><br>
                    {{ $user->email }}
                </p>

                <p>
                    <strong>Temporary Password:</strong><br>
                    <strong>{{ $password }}</strong>
                </p>
            </div>

            <p style="margin-top: 10px; font-size: 13px; color: #555;">
                This is a <strong>one-time password</strong>.
                You will be required to change it immediately after your first login.
            </p>
        </div>

        <p>
            Click the button below to log in:
        </p>

        <p>
            <a href="{{ route('reviewer.login') }}" class="login-btn" style="color: #ffffff;">
                Login to KALRO System
            </a>
        </p>

        <p style="font-size: 12px; color: #666;">
            If the button does not work, copy and paste the link below into your browser:<br>
            <a href="{{ route('reviewer.login') }}">
                {{ route('reviewer.login') }}
            </a>
        </p>

        <p>
            Regards,<br>
            <strong>KALRO Admin</strong>
        </p>
    </div>

    {{-- FOOTER --}}
    <div class="footer">
        <p>This is an automated message. Please do not reply to this email.</p>
        <p>© {{ date('Y') }} KALRO. All rights reserved.</p>
    </div>

</div>

</body>
</html>
