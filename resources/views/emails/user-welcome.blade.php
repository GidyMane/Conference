<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome as Temporary Reviewer</title>
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

        .header h2 {
            margin: 0 0 6px 0;
        }

        .header h3 {
            margin: 0;
            font-weight: normal;
            opacity: 0.9;
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

        .credentials p {
            margin: 0 0 10px 0;
        }

        .credentials p:last-child {
            margin-bottom: 0;
        }

        .login-btn {
            display: inline-block;
            padding: 12px 20px;
            background-color: #158532;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 15px;
            font-weight: bold;
        }

        .notice {
            background-color: #fff8e1;
            border-left: 4px solid #f59e0b;
            padding: 10px 14px;
            border-radius: 4px;
            margin-top: 15px;
            font-size: 13px;
            color: #555;
        }

        .footer {
            text-align: center;
            padding: 20px;
            color: #666666;
            font-size: 12px;
        }

        a {
            color: #158532;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="container">

    {{-- HEADER --}}
    <div class="header">
        <h2>KALRO Scientific Conference</h2>
        <h3>Temporary Reviewer Account</h3>
    </div>

    {{-- CONTENT --}}
    <div class="content">
        <p>Hello <strong>{{ $name }}</strong>,</p>

        <p>
            You have been registered as a <strong>Temporary Reviewer</strong> for the
            <strong>2nd KALRO Scientific Conference and Exhibition</strong>.
            Please find your login credentials below.
        </p>

        <div class="details">
            <h4>Your Login Credentials</h4>

            <div class="credentials">
                <p>
                    <strong>Email:</strong><br>
                    {{ $email }}
                </p>
                <p>
                    <strong>Temporary Password:</strong><br>
                    <strong>{{ $password }}</strong>
                </p>
            </div>

            <div class="notice">
                ⏱ This temporary password will <strong>expire in 24 hours</strong>.
                Please log in and update your password as soon as possible.
            </div>
        </div>

        <p>
            Once logged in, you will be able to start reviewing abstracts assigned to your sub-theme.
        </p>

        <p>
            Click the button below to log in:
        </p>

        <p>
            <a href="{{ $loginUrl }}" class="login-btn">Login Now</a>
        </p>

        <p style="font-size: 12px; color: #666; margin-top: 10px;">
            If the button does not work, copy and paste the link below into your browser:<br>
            <a href="{{ $loginUrl }}">{{ $loginUrl }}</a>
        </p>

        <p style="margin-top: 20px;">
            Thank you for your contribution to the conference!
        </p>

        <p>
            Regards,<br>
            <strong>KALRO Conference Committee</strong>
        </p>
    </div>

    {{-- FOOTER --}}
    <div class="footer">
        <p>This is an automated message. Please do not reply to this email.</p>
        <p>© {{ date('Y') }} 2nd KALRO Scientific Conference and Exhibition. All rights reserved.</p>
    </div>

</div>

</body>
</html>