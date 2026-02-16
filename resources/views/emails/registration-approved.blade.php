{{-- resources/views/emails/conference-ticket.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conference Ticket</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #1a5f3a 0%, #0d3d25 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 26px;
            font-weight: 700;
        }
        .header p {
            margin: 10px 0 0;
            opacity: 0.9;
            font-size: 16px;
        }
        .content {
            padding: 40px 30px;
        }
        .content h2 {
            color: #1a5f3a;
            margin-top: 0;
            font-size: 22px;
        }
        .ticket-number {
            background: #1a5f3a;
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            font-size: 26px;
            font-weight: 700;
            letter-spacing: 3px;
            margin: 25px 0;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .details-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #e0e0e0;
        }
        .details-table td:first-child {
            font-weight: 600;
            color: #555;
            width: 40%;
        }
        .details-table td:last-child {
            color: #1a5f3a;
            font-weight: 500;
        }
        .status-badge {
            background: #28a745;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            display: inline-block;
        }
        .info-box {
            background: #f8faf8;
            border-left: 4px solid #1a5f3a;
            padding: 20px;
            margin: 25px 0;
            border-radius: 0 8px 8px 0;
        }
        .footer {
            background: #f8faf8;
            padding: 25px 30px;
            text-align: center;
            color: #666;
            font-size: 14px;
            border-top: 1px solid #e0e0e0;
        }
    </style>
</head>
<body>

<div class="email-container">

    <div class="header">
        <h1>🎟 Conference Ticket Confirmed</h1>
        <p>2nd KALRO Scientific Conference & Exhibition</p>
    </div>

    <div class="content">

        <h2>Registration Approved 🎉</h2>

        <p>Dear <strong>{{ $registration->first_name }}</strong>,</p>

        <p>
            Your payment has been successfully verified and your conference
            registration is now officially confirmed.
        </p>

        <!-- Ticket Number -->
        <div class="ticket-number">
            {{ $registration->ticket_number }}
        </div>

        <p style="text-align:center; margin-top:-15px;">
            Please present this ticket number at the entrance.
        </p>

        <!-- Details -->
        <div class="info-box">
            <h3>📋 Ticket Details</h3>

            <table class="details-table">
                <tr>
                    <td>Attendee:</td>
                    <td>{{ $registration->first_name }} {{ $registration->last_name }}</td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td>{{ $registration->email }}</td>
                </tr>
                <tr>
                    <td>Category:</td>
                    <td>{{ $registration->category ?? 'Conference Registration' }}</td>
                </tr>
                <tr>
                    <td>Status:</td>
                    <td><span class="status-badge">Confirmed</span></td>
                </tr>
                <tr>
                    <td>Approval Date:</td>
                    <td>{{ now()->format('F j, Y') }}</td>
                </tr>
            </table>
        </div>

        <p>
            📌 <strong>Important:</strong> Keep this email safe.
            Your ticket number will be required for badge collection.
        </p>

        <p>
            We look forward to welcoming you to the conference.
        </p>

    </div>

    <div class="footer">
        <strong>KALRO Conference Committee</strong><br>
        kalroconference2026@gmail.com<br><br>
        © {{ date('Y') }} 2nd KALRO Scientific Conference & Exhibition
    </div>

</div>

</body>
</html>