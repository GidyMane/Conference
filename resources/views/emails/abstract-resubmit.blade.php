<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Abstract Revision Required</title>

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

.header.resubmit {
    background-color: #d97706;
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

.resubmit {
    color: #d97706;
    font-weight: bold;
}

.feedback {
    white-space: pre-line;
    background-color: #fff3cd;
    padding: 12px;
    border-left: 4px solid #ffc107;
    border-radius: 4px;
    margin-top: 10px;
}

.button {
    display: inline-block;
    padding: 12px 20px;
    background: #d97706;
    color: #ffffff;
    border-radius: 6px;
    text-decoration: none;
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

<!-- HEADER -->
<div class="header resubmit">
    <h2>2nd KALRO Scientific Conference and Exhibition</h2>
    <h3>Abstract Revision Required</h3>
</div>

<!-- CONTENT -->
<div class="content">

<p>Dear {{ $abstract->author_name }},</p>

<p>
Thank you for submitting your abstract to the
<strong>2nd KALRO Scientific Conference and Exhibition</strong>.
</p>

<p>
Your abstract has been reviewed by the conference scientific committee.
The reviewers have recommended that the abstract be
<strong>revised and resubmitted</strong> before a final decision can be made.
</p>

<div class="details">

<h4>Submission Details</h4>

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
<span class="resubmit">RESUBMISSION REQUIRED</span>
</p>

</div>

<h4>Reviewer Comments</h4>

<div class="feedback">
{{ $comment }}
</div>

<p style="margin-top:20px;">
Please revise your abstract carefully according to the reviewer comments above
and resubmit the updated version through the conference submission system.
</p>

<p>
Once resubmitted, your abstract will be reviewed again by the scientific committee.
</p>

<p>
If you have any questions, please contact us at
<a href="mailto:kalroconference2026@gmail.com">kalroconference2026@gmail.com</a>
and include your submission code in all correspondence.
</p>

<p>
Thank you for your interest in the
<strong>2nd KALRO Scientific Conference and Exhibition</strong>.
</p>

<p>
Best regards,<br>
<strong>KALRO Scientific Conference Committee</strong><br>
Email: kalroconference2026@gmail.com
</p>

</div>

<!-- FOOTER -->
<div class="footer">
<p>This is an automated message. Please do not reply to this email.</p>
<p>© {{ date('Y') }} 2nd KALRO Scientific Conference and Exhibition. All rights reserved.</p>
</div>

</div>

</body>
</html>