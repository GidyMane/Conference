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
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #28a745; color: white; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2>2nd KALRO Scientific Conference and Exhibition</h2>
        <h3>New Abstract Submission</h3>
    </div>

    <div class="content">
        <p>Dear Secretariat Team,</p>

        <p>
            A new abstract has been successfully submitted to the
            <strong>2nd KALRO Scientific Conference and Exhibition system</strong>.
        </p>

        <div class="details">
            <h4>Submission Details:</h4>

            <table>
                <tr><th>Field</th><th>Details</th></tr>
                <tr><td>Submission Code</td><td class="highlight">{{ $abstract->submission_code }}</td></tr>
                <tr><td>Paper Title</td><td>{{ $abstract->paper_title }}</td></tr>
                <tr><td>Corresponding Author</td><td>{{ $abstract->author_name }}</td></tr>
                <tr><td>Email</td><td>{{ $abstract->author_email }}</td></tr>
                <tr><td>Organisation</td><td>{{ $abstract->organisation ?? 'N/A' }}</td></tr>
                <tr><td>Department</td><td>{{ $abstract->department ?? 'N/A' }}</td></tr>
                <tr><td>Position</td><td>{{ $abstract->position ?? 'N/A' }}</td></tr>
                <tr><td>Submission Type</td><td>Abstract Submission</td></tr>
                <tr><td>Sub-theme</td><td>{{ $abstract->subTheme->full_name ?? 'N/A' }}</td></tr>
                <tr><td>Number of Authors</td><td>{{ $authorCount }}</td></tr>
                <tr><td>Submission Date</td><td>{{ $submissionDate }}</td></tr>
                <tr><td>Presentation Preference</td><td>{{ $abstract->presentation_preference ?? 'N/A' }}</td></tr>
                <tr><td>Attendance Mode</td><td>{{ $abstract->attendance_mode ?? 'N/A' }}</td></tr>
            </table>
        </div>

        <h4>What Happens Next:</h4>
        <ol>
            <li>The abstract will undergo peer review by the scientific committee.</li>
            <li>The author will receive notification of acceptance or rejection within 2–3 weeks.</li>
            <li>If accepted, instructions regarding presentation format and schedule will be sent.</li>
            <li>All correspondence will be sent to the author's email.</li>
        </ol>

        <p>A confirmation email has also been sent to the author.</p>

        <p>
            Best regards,<br>
            <strong>KALRO 2nd Scientific Conference and Exhibition Committee</strong><br>
            Email: kalroconference2026@gmail.com<br>
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