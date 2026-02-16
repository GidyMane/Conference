{{-- resources/views/emails/exhibition-approval.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exhibition Registration Approved</title>
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
            font-size: 28px;
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
        .success-icon {
            text-align: center;
            margin-bottom: 25px;
        }
        .success-icon svg {
            width: 80px;
            height: 80px;
            fill: none;
            stroke: #1a5f3a;
            stroke-width: 2;
        }
        .booth-card {
            background: linear-gradient(135deg, #1a5f3a 0%, #0d3d25 100%);
            color: white;
            padding: 30px;
            border-radius: 12px;
            margin: 25px 0;
            text-align: center;
        }
        .booth-card h3 {
            margin: 0 0 10px;
            font-size: 20px;
            opacity: 0.9;
        }
        .booth-number {
            font-size: 48px;
            font-weight: 700;
            letter-spacing: 2px;
            margin: 15px 0;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
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
        .important-info {
            background: #fff3cd;
            border: 1px solid #ffeeba;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
            color: #856404;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #1a5f3a 0%, #0d3d25 100%);
            color: white;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            margin: 10px 5px;
        }
        .button-outline {
            background: white;
            color: #1a5f3a;
            border: 2px solid #1a5f3a;
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
            <h1>✅ Registration Approved!</h1>
            <p>Your exhibition booth is confirmed</p>
        </div>
        
        <div class="content">
            <div class="success-icon">
                <svg viewBox="0 0 52 52">
                    <circle cx="26" cy="26" r="25" fill="none" stroke="currentColor" stroke-width="2"/>
                    <path d="M14.1 27.2l7.1 7.2 16.7-16.8" fill="none" stroke="currentColor" stroke-width="3"/>
                </svg>
            </div>
            
            <h2 style="text-align: center; color: #1a5f3a;">Congratulations!</h2>
            
            <p>Dear <strong>{{ $registration->contact_name }}</strong>,</p>
            
            <p>We are pleased to inform you that your exhibition registration has been <strong style="color: #1a5f3a;">APPROVED</strong>.</p>
            
            @if($registration->booth_number)
            <div class="booth-card">
                <h3>Your Allocated Booth Number</h3>
                <div class="booth-number">{{ $registration->booth_number }}</div>
                <p style="margin: 0; opacity: 0.9;">Please note this number for setup and reference</p>
            </div>
            @endif
            
            <div class="info-box">
                <h3>📋 Registration Details</h3>
                
                <table class="details-table">
                    <tr>
                        <td>Reference Number:</td>
                        <td><strong>{{ $registration->reference_number }}</strong></td>
                    </tr>
                    <tr>
                        <td>Organization:</td>
                        <td><strong>{{ $registration->organization_name }}</strong></td>
                    </tr>
                    <tr>
                        <td>Number of Booths:</td>
                        <td><strong>{{ $registration->booth_count }}</strong></td>
                    </tr>
                    <tr>
                        <td>Package:</td>
                        <td><strong>{{ $registration->registration_type_label }}</strong></td>
                    </tr>
                    <tr>
                        <td>Team Size:</td>
                        <td><strong>{{ $registration->team_size }} persons</strong></td>
                    </tr>
                </table>
            </div>
            
            <div class="important-info">
                <h4 style="margin-top: 0; display: flex; align-items: center;">
                    <span style="font-size: 24px; margin-right: 10px;">📌</span> 
                    Important Information
                </h4>
                <ul style="margin-bottom: 0;">
                    <li><strong>Setup Time:</strong> You can begin setting up your booth from 7:00 AM on the conference day</li>
                    <li><strong>Booth Size:</strong> Standard booth size is 3m x 3m (includes table, 2 chairs, and power outlet)</li>
                    <li><strong>Exhibitor Badges:</strong> You'll receive {{ $registration->booth_count * 2 }} exhibitor badges (2 per booth)</li>
                    <li><strong>Catering:</strong> {{ $registration->registration_type === 'with_meals' ? 'Meals are included for all team members' : 'Meals are not included in your package' }}</li>
                </ul>
            </div>
            
            <h3>📋 Pre-Event Checklist</h3>
            
            <ul class="step-list">
                <li>Confirm your team members' names for badges (reply to this email)</li>
                <li>Review the exhibition guidelines (attached below)</li>
                <li>Prepare your promotional materials and giveaways</li>
                <li>Arrive early on the conference day for setup</li>
            </ul>
            
            <div style="text-align: center; margin: 35px 0 20px;">
                <a href="#" class="button">Download Guidelines</a>
                <a href="#" class="button button-outline">View Your Dashboard</a>
            </div>
            
            <p style="margin-top: 25px;">
                <strong>Questions?</strong> Our exhibition team is here to help. Please don't hesitate to reach out.
            </p>
        </div>
        
        <div class="footer">
            <p>
                <strong>KALRO Conference Exhibition Team</strong><br>
                Kenya Agricultural and Livestock Research Organization<br>
                <a href="mailto:exhibition@kalro.org">exhibition@kalro.org</a> | 
                <a href="tel:+254800721741">0800 721741</a>
            </p>
            <p style="margin-top: 15px; font-size: 12px; color: #999;">
                We look forward to welcoming you to the exhibition!
            </p>
        </div>
    </div>
</body>
</html>