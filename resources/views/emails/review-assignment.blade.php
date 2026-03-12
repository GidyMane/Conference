<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paper Review Assignment</title>
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
        .paper-code {
            background: #1a5f3a;
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 2px;
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
        .btn {
            display: inline-block;
            padding: 12px 20px;
            background: #1a5f3a;
            color: white !important;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            margin: 10px 5px;
        }
        .btn-secondary {
            background: #2563eb;
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
        <h1>📄 Paper Review Assignment</h1>
        <p>2nd KALRO Scientific Conference & Exhibition</p>
    </div>

    <div class="content">

        <h2>You have been assigned as a reviewer</h2>

        <p>Hello,</p>

        <p>
            You have been assigned to review the following conference paper.
            Please download the paper and submit your review before the deadline.
        </p>

        <!-- Paper Code -->
        <div class="paper-code">
            {{ $paper->abstract->submission_code }}
        </div>

        <!-- Paper Details -->
        <div class="info-box">
            <h3>📋 Paper Details</h3>

            <table class="details-table">
                <tr>
                    <td>Paper Title:</td>
                    <td>{{ $paper->abstract->paper_title }}</td>
                </tr>
                <tr>
                    <td>Paper Code:</td>
                    <td>{{ $paper->abstract->submission_code }}</td>
                </tr>
                
                <tr>
                    <td>Submission Date:</td>
                    <td>{{ $paper->uploaded_at?->format('F j, Y') }}</td>
                </tr>
                <tr>
                    <td>Review Deadline:</td>
                    <td>{{ now()->addDays(14)->format('F j, Y') }}</td>
                </tr>
            </table>
        </div>

        <!-- Conflict of Interest Notice -->
        <div class="info-box">
            <h3>⚖️ Conflict of Interest</h3>
            <p>
                To maintain the integrity of the peer-review process, reviewers are required to
                disclose any potential <strong>conflict of interest</strong>.
            </p>

            <p>
    If you recognize the author(s) of this paper or become aware of any circumstance
    that may compromise your ability to provide an objective and impartial review,
    please notify the conference secretariat promptly by replying to this email or contacting us at
    <strong>kalroconference2026@gmail.com</strong>.
</p>

            <p>
                Kindly include the <strong>paper code</strong> in your email and briefly indicate the
                nature of the conflict so that the paper can be reassigned to another reviewer.
            </p>
        </div>

        <!-- Action Buttons -->
        <div style="text-align:center; margin-top:20px;">
            <a href="{{ $downloadLink }}" class="btn">
                📥 Download Full Paper
            </a>

            <a href="{{ $reviewLink }}" class="btn btn-secondary">
                📝 Submit Review
            </a>
        </div>

        <p style="margin-top:25px;">
            ⏳ <strong>Note:</strong> Your review link will expire in 14 days.
        </p>

        <p>
            Thank you for contributing to the peer review process.
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