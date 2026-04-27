<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance Account Created</title>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .header {
            background: linear-gradient(135deg, #0d47a1 0%, #08306b 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 26px;
            font-weight: 700;
        }

        .header p {
            margin: 10px 0 0;
            opacity: 0.9;
            font-size: 15px;
        }

        .content {
            padding: 40px 30px;
        }

        .content h2 {
            color: #0d47a1;
            margin-top: 0;
            font-size: 22px;
        }

        .info-box {
            background: #f5f8ff;
            border-left: 4px solid #0d47a1;
            padding: 20px;
            margin: 25px 0;
            border-radius: 0 8px 8px 0;
        }

        .info-box h3 {
            margin-top: 0;
            color: #0d47a1;
            font-size: 18px;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .details-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #e0e0e0;
        }

        .details-table td:first-child {
            font-weight: 600;
            color: #555;
            width: 35%;
        }

        .details-table td:last-child {
            color: #0d47a1;
            font-weight: 600;
        }

        .password-box {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin-top: 15px;
            border-radius: 0 8px 8px 0;
            font-size: 14px;
        }

        .button {
            display: inline-block;
            background: linear-gradient(135deg, #0d47a1 0%, #08306b 100%);
            color: white;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            margin: 20px 0;
        }

        .footer {
            background: #f5f8ff;
            padding: 25px 30px;
            text-align: center;
            color: #666;
            font-size: 13px;
            border-top: 1px solid #e0e0e0;
        }

        .footer a {
            color: #0d47a1;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>

<body>
<div class="email-container">

    <!-- HEADER -->
    <div class="header">
        <h1>💼 Finance Portal Access</h1>
        <p>KALRO Conference Management System</p>
    </div>

    <!-- CONTENT -->
    <div class="content">

        <h2>Welcome to the Finance Team</h2>

        <p>Hello <strong>{{ $user->full_name }}</strong>,</p>

        <p>
            Your Finance Portal account has been successfully created. You can now log in
            and begin managing registrations and payments.
        </p>

        <div class="info-box">
            <h3>🔐 Login Credentials</h3>

            <table class="details-table">
                <tr>
                    <td>Email:</td>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <td>Role:</td>
                    <td>Finance User</td>
                </tr>
            </table>

            <div class="password-box">
                <strong>Temporary Password:</strong> {{ $password }} <br>
                Please change your password immediately after logging in.
            </div>
        </div>

        <p>
            Click the button below to access the Finance Portal:
        </p>

        <a href="{{ url('/login') }}" class="button">
            Login to Finance Portal
        </a>

        <p style="margin-top: 20px;">
            For security reasons, do not share your login credentials with anyone.
        </p>

    </div>

    <!-- FOOTER -->
    <div class="footer">
        <p>
            <strong>KALRO Finance System</strong><br>
            Kenya Agricultural and Livestock Research Organization<br>
            <a href="mailto:finance@kalro.org">kalroconference2026@gmail.com</a>
        </p>

        <p style="margin-top: 10px;">
            © {{ date('Y') }} KALRO. All rights reserved.
        </p>
    </div>

</div>
</body>
</html>
