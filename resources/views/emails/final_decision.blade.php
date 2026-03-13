<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Final Paper Decision</title>
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

        .header.approved {
            background-color: #28a745;
            color: #ffffff;
        }

        .header.rejected {
            background-color: #dc3545;
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

        .approved {
            color: #28a745;
            font-weight: bold;
        }

        .rejected {
            color: #dc3545;
            font-weight: bold;
        }

        .feedback {
            white-space: pre-line;
            background-color: #f1f3f5;
            padding: 12px;
            border-left: 4px solid;
            border-radius: 4px;
            margin-top: 10px;
        }

        .feedback.approved {
            border-left-color: #28a745;
        }

        .feedback.rejected {
            border-left-color: #dc3545;
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
    </style>
</head>
<body>

<div class="container">

    {{-- HEADER --}}
    <div class="header {{ $paper->final_decision === 'rejected' ? 'rejected' : 'approved' }}">
        <h2>2nd KALRO Scientific Conference and Exhibition</h2>
        <h3>Final Paper Decision</h3>
    </div>

    {{-- CONTENT --}}
    <div class="content">
        <p>Dear {{ $paper->abstract->author_name }},</p>

        <p>Your paper titled "<strong>{{ $paper->abstract->title }}</strong>" has received a final decision.</p>

        <div class="details">
            <p class="decision">
                <strong>Decision:</strong>
                <span class="{{ $paper->final_decision === 'rejected' ? 'rejected' : 'approved' }}">
                    {{ strtoupper(str_replace('_',' ',$paper->final_decision)) }}
                </span>
            </p>

            <div class="feedback {{ $paper->final_decision === 'rejected' ? 'rejected' : 'approved' }}">
                <strong>Comments from the Leader:</strong><br>
                {{ $paper->leader_comments }}
            </div>
        </div>

        <p>Attached is a PDF containing all reviewer scores and comments.</p>

        @if($paper->final_decision === 'approved')

            <p>
            Upload your presentation materials here:
            </p>

            <div style="text-align:center; margin-top:20px;">

                <a href="{{ url('/presentation/upload/'.$paper->id) }}" class="btn">
                Upload Presentation
                </a>
            </div>
            

        @endif

        <p>Best regards,<br>
           <strong>Conference Committee</strong><br>
           Email: kalroconference2026@gmail.com
        </p>
    </div>

    {{-- FOOTER --}}
    <div class="footer">
        <p>This is an automated message. Please do not reply to this email.</p>
        <p>© {{ date('Y') }} 2nd KALRO Scientific Conference and Exhibition. All rights reserved.</p>
    </div>

</div>

</body>
</html>