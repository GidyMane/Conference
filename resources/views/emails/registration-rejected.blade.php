<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; background:#f4f6f8; padding:20px; }
        .card { max-width:600px; margin:0 auto; background:#fff; border-radius:10px; overflow:hidden; }
        .header { background:#dc3545; color:white; padding:20px; text-align:center; }
        .content { padding:25px; }
        .reason { background:#fff3f3; padding:15px; border-left:4px solid #dc3545; margin:20px 0; }
        .footer { text-align:center; font-size:12px; padding:15px; color:#777; }
    </style>
</head>
<body>

<div class="card">
    <div class="header">
        <h2>Registration Not Approved</h2>
    </div>

    <div class="content">
        <p>Dear {{ $registration->first_name }},</p>

        <p>
            We regret to inform you that your conference registration
            could not be approved at this time.
        </p>

        <div class="reason">
            <strong>Reason:</strong><br>
            {{ $registration->rejection_reason }}
        </div>

        <p>
            If you believe this was made in error or need clarification,
            please contact us at kalroconference2026@gmail.com.
        </p>

        <p>
            Kind regards,<br>
            <strong>KALRO Conference Committee</strong>
        </p>
    </div>

    <div class="footer">
        © {{ date('Y') }} KALRO Scientific Conference
    </div>
</div>

</body>
</html>
