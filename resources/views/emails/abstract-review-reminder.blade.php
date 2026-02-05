<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Abstract Review Reminder</title>
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
            background-color: #007bff;
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
        <h2>2nd KALRO Scientific Conference and Exhibition</h2>
        <h3>Abstract Review Reminder</h3>
    </div>

    {{-- CONTENT --}}
    <div class="content">
        <p>Dear {{ $reviewer->full_name }},</p>

        <p>
            This is a gentle reminder that you have an abstract pending review.
        </p>

        <div class="details">
            <h4>Abstract Details</h4>
            <p><strong>Submission Code:</strong> {{ $abstract->submission_code }}</p>
            <p><strong>Title:</strong> {{ $abstract->paper_title }}</p>
            <p><strong>Sub-theme:</strong> {{ $abstract->subTheme->full_name ?? '-' }}</p>
        </div>

        <p>
            Please log in to the reviewer dashboard to complete your review.
        </p>

        <p>
            Thank you for your contribution to the review process.
        </p>

        <p>
            Best regards,<br>
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