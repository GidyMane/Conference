<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Abstract Submission</title>
</head>
<body>
    <p>Dear Secretariat Team,</p>

    <p>
        A new abstract has been successfully submitted to the KALRO Conference 2026 system.
    </p>

    <p><strong>Submission Details:</strong></p>
    <ul>
        <li><strong>Submission Code:</strong> {{ $abstract->submission_code }}</li>
        <li><strong>Author:</strong> {{ $abstract->author_name }}</li>
        <li><strong>Email:</strong> {{ $abstract->author_email }}</li>
        <li><strong>Organisation:</strong> {{ $abstract->organisation }}</li>
        <li><strong>Paper Title:</strong> {{ $abstract->paper_title }}</li>
        <li><strong>Sub-Theme:</strong> {{ $abstract->subTheme->name ?? 'N/A' }}</li>
    </ul>

    <p>
        A confirmation email has been sent to the author.
    </p>

    <p>
        Kind regards,<br>
        <strong>KALRO Conference System</strong>
    </p>
</body>
</html>
