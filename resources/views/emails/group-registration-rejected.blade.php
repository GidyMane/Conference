<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Group Registration Rejected</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f4f4; margin:0; padding:0; color:#333; }
        .email-container { max-width:600px; margin:20px auto; background:white; border-radius:12px; overflow:hidden; box-shadow:0 4px 10px rgba(0,0,0,0.1);}
        .header { background:#d9534f; color:white; padding:30px; text-align:center; }
        .header h1 { margin:0; font-size:26px; font-weight:700; }
        .content { padding:40px 30px; }
        .content h2 { color:#d9534f; font-size:22px; margin-top:0; }
        .info-box { background:#f8f8f8; border-left:4px solid #d9534f; padding:20px; margin:25px 0; border-radius:0 8px 8px 0; }
        .footer { background:#f8f8f8; padding:25px 30px; text-align:center; color:#666; font-size:14px; border-top:1px solid #e0e0e0; }
    </style>
</head>
<body>

<div class="email-container">

    <div class="header">
        <h1>❌ Group Registration Rejected</h1>
    </div>

    <div class="content">
        <h2>Dear {{ $group->first_name }} {{ $group->last_name }},</h2>

        <p>
            Your group registration for the 2nd KALRO Scientific Conference & Exhibition
            has been <strong>rejected</strong>.
        </p>

        <div class="info-box">
            <h3>📋 Details</h3>
            <p><strong>Group Name / Coordinator:</strong> {{ $group->first_name }} {{ $group->last_name }}</p>
            <p><strong>Email:</strong> {{ $group->email }}</p>
            <p><strong>Reason:</strong> {{ $group->rejection_reason }}</p>
            <p><strong>Date:</strong> {{ now()->format('F j, Y') }}</p>
        </div>

        <p>
            Please contact the conference organizers if you need further clarification.
        </p>
    </div>

    <div class="footer">
        <strong>KALRO Conference Committee</strong><br>
        kalroexpo2026@gmail.com<br><br>
        © {{ date('Y') }} 2nd KALRO Scientific Conference & Exhibition
    </div>

</div>

</body>
</html>