<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Conference Ticket</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f4f6;
            margin: 0;
            padding: 0;
        }

        .wrapper {
            width: 100%;
            padding: 30px 0;
        }

        .ticket {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }

        .ticket-header {
            background: linear-gradient(135deg, #1e7e34, #28a745);
            color: white;
            padding: 25px;
            text-align: center;
        }

        .ticket-header h1 {
            margin: 0;
            font-size: 22px;
        }

        .ticket-header p {
            margin: 5px 0 0;
            font-size: 14px;
            opacity: 0.9;
        }

        .ticket-body {
            padding: 25px;
        }

        .ticket-number {
            text-align: center;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }

        .ticket-number span {
            display: block;
            font-size: 13px;
            color: #666;
            margin-bottom: 5px;
        }

        .ticket-number strong {
            font-size: 26px;
            color: #28a745;
            letter-spacing: 2px;
        }

        .details {
            margin-top: 20px;
        }

        .details p {
            margin: 8px 0;
            font-size: 14px;
        }

        .divider {
            margin: 25px 0;
            border-top: 2px dashed #ccc;
        }

        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }

        .highlight {
            color: #28a745;
            font-weight: bold;
        }

        .emoji {
            font-size: 18px;
        }
    </style>
</head>
<body>

<div class="wrapper">
    <div class="ticket">

        <!-- HEADER -->
        <div class="ticket-header">
            <h1>🎟 2nd KALRO Scientific Conference & Exhibition</h1>
            <p>Registration Approved</p>
        </div>

        <!-- BODY -->
        <div class="ticket-body">

            <p>Dear <strong>{{ $registration->first_name }}</strong>,</p>

            <p>
                🎉 Your payment has been successfully verified.
                Your official conference ticket is confirmed!
            </p>

            <!-- Ticket Number Section -->
            <div class="ticket-number">
                <span>Your Official Ticket Number</span>
                <strong>{{ $registration->ticket_number }}</strong>
            </div>

            <div class="details">
                <p><strong>Attendee:</strong> {{ $registration->first_name }} {{ $registration->last_name }}</p>
                <p><strong>Email:</strong> {{ $registration->email }}</p>
                <p><strong>Category:</strong> {{ $registration->category ?? 'Conference Registration' }}</p>
                <p><strong>Status:</strong> <span class="highlight">Confirmed</span></p>
                <p><strong>Approval Date:</strong> {{ now()->format('F j, Y') }}</p>
            </div>

            <div class="divider"></div>

            <p>
                📌 <strong>Important:</strong><br>
                Please present this ticket number at the conference entrance.
                Keep this email for verification.
            </p>

            <p>
                We look forward to welcoming you to the conference.
                See you soon!
            </p>

            <p>
                Best regards,<br>
                <strong>KALRO Conference Committee</strong><br>
                kalroconference2026@gmail.com
            </p>

        </div>

        <!-- FOOTER -->
        <div class="footer">
            This is an automated email. Please do not reply.<br>
            © {{ date('Y') }} 2nd KALRO Scientific Conference & Exhibition
        </div>

    </div>
</div>

</body>
</html>
