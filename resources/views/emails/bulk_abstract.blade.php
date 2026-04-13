{{-- resources/views/emails/bulk_abstract.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subjectLine }}</title>

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
            font-size: 24px;
            font-weight: 700;
        }

        .header p {
            margin: 10px 0 0;
            opacity: 0.9;
            font-size: 15px;
        }

        .content {
            padding: 35px 30px;
        }

        .content h2 {
            color: #1a5f3a;
            margin-top: 0;
            font-size: 20px;
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

        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }

        .details-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #e0e0e0;
            font-size: 14px;
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
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            display: inline-block;
        }

        .message-box {
            background: #f9f9f9;
            border: 1px solid #eee;
            padding: 15px;
            border-radius: 8px;
            margin-top: 10px;
            white-space: pre-line;
        }

        .footer {
            background: #f8faf8;
            padding: 25px 30px;
            text-align: center;
            color: #666;
            font-size: 13px;
            border-top: 1px solid #e0e0e0;
        }

        .footer a {
            color: #1a5f3a;
            text-decoration: none;
            font-weight: 600;
        }

        .ref-box {
            background: #1a5f3a;
            color: white;
            padding: 14px;
            border-radius: 8px;
            text-align: center;
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 1px;
            margin: 20px 0;
        }
    </style>
</head>

<body>
<div class="email-container">

    <!-- HEADER -->
    <div class="header">
        <h1>📄 Submission Updates</h1>
        <p>2nd KALRO Conference Secretariat</p>
    </div>

    <!-- CONTENT -->
    <div class="content">

        <h2>Hello {{ $abstract->author_name ?? 'Participant' }},</h2>

        <!-- REFERENCE -->
        @if($abstract)
            <div class="ref-box">
                {{ $abstract->submission_code }}
            </div>

            <div class="info-box">
                <h3>📌 Submission Details</h3>

                <table class="details-table">
                    <tr>
                        <td>Paper Title:</td>
                        <td><strong>{{ $abstract->paper_title }}</strong></td>
                    </tr>

                    <tr>
                        <td>Author:</td>
                        <td><strong>{{ $abstract->author_name }}</strong></td>
                    </tr>

                    <tr>
                        <td>Organisation:</td>
                        <td><strong>{{ $abstract->organisation }}</strong></td>
                    </tr>

                    <tr>
                        <td>Sub Theme:</td>
                        <td><strong>{{ optional($abstract->subTheme)->full_name }}</strong></td>
                    </tr>

                    <tr>
                        <td>Status:</td>
                        <td>
                            <span class="status-badge">
                                {{ $abstract->status }}
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        @endif

        <!-- CUSTOM MESSAGE SECTION -->
        <div class="info-box">
            <h3>💬 Message</h3>
            <div class="message-box">
                {{ $messageBody }}
            </div>
        </div>

        <p style="margin-top: 25px;">
            For any inquiries, please contact the conference secretariat.
        </p>

    </div>

    <!-- FOOTER -->
    <div class="footer">
        <p>
            <strong>KALRO Conference Secretariat</strong><br>
            Kenya Agricultural and Livestock Research Organization<br>
            <a href="mailto:kalroconference2026@gmail.com">kalroconference2026@gmail.com</a>
        </p>

        <p style="margin-top: 15px; font-size: 12px; color: #999;">
            © {{ date('Y') }} KALRO Conference. All rights reserved.
        </p>
    </div>

</div>
</body>
</html>