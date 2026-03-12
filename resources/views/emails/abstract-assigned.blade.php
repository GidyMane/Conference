<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Abstract Assignment</title>
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
            background-color: #0d6efd;
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

        .btn {
            display: inline-block;
            padding: 10px 15px;
            background-color: #198754;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }

        .footer {
            text-align: center;
            padding: 20px;
            color: #666666;
            font-size: 12px;
        }

        a {
            color: #006400;
        }
    </style>
</head>
<body>

<div class="container">

    {{-- HEADER --}}
    <div class="header">
        <h2>2nd KALRO Scientific Conference and Exhibition</h2>
        <h3>New Abstract Assignment</h3>
    </div>

    {{-- CONTENT --}}
    <div class="content">
        <p>Hello {{ $reviewer->full_name }},</p>

        <p>
            A new abstract has been assigned to you for review.
        </p>

        <div class="details">
            <p><strong>Title:</strong> {{ $abstract->paper_title }}</p>
            <p><strong>Submission ID:</strong> {{ $abstract->submission_code }}</p>
        </div>

        <p>
            Please log in to your reviewer dashboard to submit your review.
        </p>

        <a href="{{ route('reviewer.dashboard') }}" class="btn">
            Review Abstract
        </a>

        <p style="margin-top: 20px;">
            Kind regards,<br>
            <strong>KALRO Conference Secretariat</strong>
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