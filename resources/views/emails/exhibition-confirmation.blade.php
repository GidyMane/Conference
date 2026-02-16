{{-- resources/views/emails/exhibition-confirmation.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exhibition Registration Confirmation</title>
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
        .content h2 {
            color: #1a5f3a;
            margin-top: 0;
            font-size: 22px;
        }
        .info-box {
            background: #f8faf8;
            border-left: 4px solid #1a5f3a;
            padding: 20px;
            margin: 25px 0;
            border-radius: 0 8px 8px 0;
        }
        .info-box h3 {
            margin-top: 0;
            color: #1a5f3a;
            font-size: 18px;
        }
        .info-box p {
            margin: 8px 0;
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
            background: #ffc107;
            color: #000;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            display: inline-block;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #1a5f3a 0%, #0d3d25 100%);
            color: white;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            margin: 20px 0;
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
            color: #1a5f3a;
            text-decoration: none;
            font-weight: 600;
        }
        .reference-number {
            background: #1a5f3a;
            color: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 2px;
            margin: 25px 0;
        }
        .step-list {
            list-style: none;
            padding: 0;
        }
        .step-list li {
            padding: 10px 0 10px 30px;
            position: relative;
        }
        .step-list li:before {
            content: "✓";
            color: #1a5f3a;
            font-weight: bold;
            position: absolute;
            left: 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>🎪 Exhibition Registration Received</h1>
            <p>2nd KALRO Conference Exhibition</p>
        </div>
        
        <div class="content">
            <h2>Thank You for Registering!</h2>
            
            <p>Dear <strong>{{ $registration->contact_name }}</strong>,</p>
            
            <p>We have successfully received your exhibition registration for the 2nd KALRO Conference. Your application is now being reviewed by our team.</p>
            
            <div class="reference-number">
                {{ $registration->reference_number }}
            </div>
            
            <p>Please keep this reference number for all future correspondence.</p>
            
            <div class="info-box">
                <h3>📋 Registration Summary</h3>
                
                <table class="details-table">
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
                    <tr>
                        <td>Payment Method:</td>
                        <td><strong>{{ $registration->payment_method_label }}</strong></td>
                    </tr>
                    <tr>
                        <td>Status:</td>
                        <td>
                            <span class="status-badge">Pending Verification</span>
                        </td>
                    </tr>
                </table>
            </div>
            
            <h3>📌 What Happens Next?</h3>
            
            <ul class="step-list">
                <li><strong>Step 1:</strong> Our team will verify your payment details (1-2 business days)</li>
                <li><strong>Step 2:</strong> Upon verification, your registration will be approved</li>
                <li><strong>Step 3:</strong> You'll receive an approval email with your booth allocation</li>
                <li><strong>Step 4:</strong> We'll send detailed exhibition guidelines closer to the date</li>
            </ul>
            
            <div style="text-align: center;">
                <a href="{{ route('exhibition.register.form') }}" class="button">
                    View Registration Status
                </a>
            </div>
            
            <p style="margin-top: 25px;">
                <strong>Need to make changes?</strong> Please contact our exhibition team directly.
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
                © {{ date('Y') }} KALRO. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>