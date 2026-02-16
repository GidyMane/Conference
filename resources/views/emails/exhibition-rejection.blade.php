{{-- resources/views/emails/exhibition-rejection.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exhibition Registration Update</title>
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
            background: linear-gradient(135deg, #dc3545 0%, #b02a37 100%);
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
        .warning-icon {
            text-align: center;
            margin-bottom: 25px;
        }
        .warning-icon svg {
            width: 80px;
            height: 80px;
            fill: none;
            stroke: #dc3545;
            stroke-width: 2;
        }
        .rejection-card {
            background: #f8d7da;
            border: 1px solid #f5c2c7;
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
            color: #842029;
        }
        .rejection-card h3 {
            margin-top: 0;
            color: #842029;
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
        .next-steps {
            background: #e7f3ff;
            border: 1px solid #b8daff;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
            color: #004085;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #dc3545 0%, #b02a37 100%);
            color: white;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            margin: 10px 5px;
        }
        .footer {
            background: #f8faf8;
            padding: 25px 30px;
            text-align: center;
            color: #666;
            font-size: 14px;
            border-top: 1px solid #e0e0e0;
        }
        .footer a {
            color: #dc3545;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>⚠️ Registration Update</h1>
            <p>Important information about your exhibition registration</p>
        </div>
        
        <div class="content">
            <div class="warning-icon">
                <svg viewBox="0 0 52 52">
                    <circle cx="26" cy="26" r="25" fill="none" stroke="currentColor" stroke-width="2"/>
                    <path d="M26 16 L26 30" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                    <circle cx="26" cy="38" r="2" fill="currentColor"/>
                </svg>
            </div>
            
            <h2 style="text-align: center; color: #dc3545;">Dear {{ $registration->contact_name }},</h2>
            
            <p>Thank you for your interest in exhibiting at the 2nd KALRO Conference Exhibition.</p>
            
            <p>After careful review of your registration, we regret to inform you that we are unable to approve your exhibition application at this time.</p>
            
            <div class="rejection-card">
                <h3>📋 Reason for Rejection</h3>
                <p style="font-size: 16px;"><strong>{{ $registration->admin_notes }}</strong></p>
            </div>
            
            <h3>Registration Details</h3>
            
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
                    <td>Total Amount:</td>
                    <td><strong>{{ $registration->formatted_total }}</strong></td>
                </tr>
            </table>
            
            <div class="next-steps">
                <h4 style="margin-top: 0;">📌 What happens next?</h4>
                <ul style="margin-bottom: 0;">
                    <li>Your payment will be refunded within 5-7 business days</li>
                    <li>If you paid via M-Pesa, the refund will be sent to the same number</li>
                    <li>For bank transfers, please provide your bank details for refund processing</li>
                    <li>You may reapply with corrected information or contact us for clarification</li>
                </ul>
            </div>
            
            <div style="text-align: center; margin: 30px 0;">
                <a href="mailto:exhibition@kalro.org" class="button">
                    <i class="fas fa-envelope"></i> Contact Support
                </a>
            </div>
            
            <p style="margin-top: 25px;">
                <strong>Need clarification?</strong> If you believe this decision was made in error or would like more information about the reason for rejection, please don't hesitate to contact our exhibition team.
            </p>
            
            <p>
                We appreciate your interest in the KALRO Conference and hope you'll consider participating in future events.
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
                Thank you for your understanding.
            </p>
        </div>
    </div>
</body>
</html>