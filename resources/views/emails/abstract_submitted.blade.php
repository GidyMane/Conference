<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #28a745; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background-color: #f8f9fa; }
        .details { background-color: white; padding: 15px; border-radius: 5px; margin: 15px 0; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
        .highlight { color: #28a745; font-weight: bold; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2>2nd KALRO Scientific Conference and Exhibition</h2>
        <h3>Abstract Submission Confirmation</h3>
    </div>

    <div class="content">
        <p>Dear {{ $abstract->author_name }},</p>

        <p>
            Thank you for submitting your abstract to the
            <strong>2nd KALRO Scientific Conference and Exhibition</strong>.
            We have successfully received your submission and it is now under review.
        </p>

        <div class="details">
            <h4>Submission Details:</h4>

            <p>
                <strong>Submission Code:</strong>
                <span class="highlight">{{ $abstract->submission_code }}</span>
            </p>

            <p><strong>Paper Title:</strong> {{ $abstract->paper_title }}</p>
            <p><strong>Corresponding Author:</strong> {{ $abstract->author_name }}</p>
            <p><strong>Email:</strong> {{ $abstract->author_email }}</p>

            <p><strong>Submission Type:</strong> Abstract Submission</p>

            <p>
                <strong>Sub-theme:</strong>
                {{ $abstract->subTheme->full_name }}
            </p>

            <p><strong>Number of Authors:</strong> {{ $authorCount }}</p>
            <p><strong>Submission Date:</strong> {{ $submissionDate }}</p>
        </div>

        <h4>What Happens Next:</h4>
        <ol>
            <li>Your abstract will undergo a peer review process by our scientific committee</li>
            <li>You will receive notification of acceptance or rejection within 2–3 weeks</li>
            <li>If accepted, you will receive further instructions regarding presentation format and schedule</li>
            <li>All correspondence will be sent to this email address</li>
        </ol>

        <p>
            <strong>Important:</strong>
            Please keep your submission code
            (<span class="highlight">{{ $abstract->submission_code }}</span>)
            for future reference in all communications.
        </p>

        <p>
            If you need to make any changes to your submission or have any questions,
            please contact us at
            <a href="mailto:sepdconference@gmail.com">sepdconference@gmail.com</a>
            and include your submission code.
        </p>

        <p>
            Thank you for your contribution to the
            2nd KALRO Scientific Conference and Exhibition.
        </p>

        <p>
            Best regards,<br>
            <strong>KALRO 2nd Scientific Conference and Exhibition Committee</strong><br>
            Email: sepdconference@gmail.com<br>
            Website: {{ $host }}
        </p>
    </div>

    <div class="footer">
        <p>This is an automated message. Please do not reply to this email.</p>
        <p>© {{ date('Y') }} 2nd KALRO Scientific Conference and Exhibition. All rights reserved.</p>
    </div>
</div>

</body>
</html>
