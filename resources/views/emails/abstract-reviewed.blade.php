<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Abstract Review Outcome</title>
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
        color: #ffffff;
    }

    .header.approved {
        background-color: #28a745;
        color: #ffffff;
    }

    .header.rejected {
        background-color: #dc3545;
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

    .decision {
        font-size: 16px;
        font-weight: bold;
        margin-top: 10px;
    }

    .approved {
        color: #28a745;
        font-weight: bold;
    }

    .rejected {
        color: #dc3545;
        font-weight: bold;
    }

    .feedback {
        white-space: pre-line;
        background-color: #f1f3f5;
        padding: 12px;
        border-left: 4px solid;
        border-radius: 4px;
        margin-top: 10px;
    }

    .feedback.approved {
        border-left-color: #28a745;
    }

    .feedback.rejected {
        border-left-color: #dc3545;
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
<div class="header {{ $abstract->status === 'REJECTED' ? 'rejected' : 'approved' }}">
    <h2>2nd KALRO Scientific Conference and Exhibition</h2>
    <h3>Abstract Review Outcome</h3>
</div>

{{-- CONTENT --}}
<div class="content">
    <p>Dear {{ $abstract->author_name }},</p>

    <p>
        Thank you for submitting your abstract to the
        <strong>2nd KALRO Scientific Conference and Exhibition</strong>.
        Your submission has now been reviewed by the conference scientific committee.
    </p>

    <div class="details">
        <h4>Abstract Details</h4>

        <p>
            <strong>Submission Code:</strong>
            {{ $abstract->submission_code }}
        </p>

        <p>
            <strong>Paper Title:</strong>
            {{ $abstract->paper_title }}
        </p>

        <p class="decision">
            <strong>Decision:</strong>
            <span class="{{ $abstract->status === 'REJECTED' ? 'rejected' : 'approved' }}">
                {{ $abstract->status }}
            </span>
        </p>
    </div>

    <h4>Reviewer Feedback</h4>
    <div class="feedback {{ $abstract->status === 'REJECTED' ? 'rejected' : 'approved' }}">
        {{ $comment }}
    </div>

    @if($abstract->status === 'APPROVED' && $uploadUrl)
        <p style="margin-top: 20px;">
            <strong>Next Step:</strong><br>
            Please submit your full paper using the link below:
        </p>

        <p>
            <a href="{{ $uploadUrl }}"
            style="display:inline-block;padding:12px 20px;
            background:#158532;color:#fff;border-radius:6px;">
                Submit Full Paper
            </a>
        </p>

        <p style="font-size:12px;color:#666;">
            This link will expire in 14 days.
        </p>
    @endif


    {{-- CONDITIONAL MESSAGE --}}
    @if($abstract->status === 'APPROVED')
        <p style="margin-top: 20px;">
            Congratulations! Your abstract has been <strong>approved</strong>.
            You will receive further communication regarding presentation guidelines,
            scheduling, and registration details.
        </p>
    @else
        <p style="margin-top: 20px;">
            We regret to inform you that your abstract was not accepted for this conference.
            We sincerely appreciate your interest and effort, and we encourage you to
            consider participating in future KALRO scientific events.
        </p>
    @endif

    <p>
        If you have any questions, please contact us at
        <a href="mailto:kalroconference2026@gmail.com">kalroconference2026@gmail.com</a>
        and include your submission code in all correspondence.
    </p>

    <p>
        Thank you for your contribution to the
        2nd KALRO Scientific Conference and Exhibition.
    </p>

    <p>
        Best regards,<br>
        <strong>KALRO Scientific Conference Committee</strong><br>
        Email: kalroconference2026@gmail.com
    </p>
</div>

{{-- FOOTER --}}
<div class="footer">
    <p>This is an automated message. Please do not reply to this email.</p>
    <p>© {{ date('Y') }} 2nd KALRO Scientific Conference and Exhibition. All rights reserved.</p>
</div>
```

</div>

</body>
</html>
