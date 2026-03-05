<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abstract Review Outcome</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f0f4f0;
            font-family: 'Georgia', serif;
            line-height: 1.7;
            color: #2d2d2d;
        }

        .wrapper {
            max-width: 640px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 6px 30px rgba(0,0,0,0.10);
        }

        /* ── HEADER ── */
        .header {
            padding: 36px 32px 28px;
            text-align: center;
            position: relative;
        }
        .header.approved {
            background: linear-gradient(135deg, #1a7a3c 0%, #158532 60%, #0f6626 100%);
        }
        .header.rejected {
            background: linear-gradient(135deg, #6b7c6e 0%, #556358 60%, #445249 100%);
        }
        .header .logo-line {
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.7);
            margin-bottom: 12px;
            font-family: Arial, sans-serif;
        }
        .header h1 {
            font-size: 22px;
            font-weight: bold;
            color: #ffffff;
            margin-bottom: 6px;
            line-height: 1.3;
        }
        .header h2 {
            font-size: 13px;
            font-weight: normal;
            color: rgba(255,255,255,0.8);
            letter-spacing: 0.3px;
            font-family: Arial, sans-serif;
            font-style: italic;
        }
        .header .status-badge {
            display: inline-block;
            margin-top: 18px;
            padding: 7px 22px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: bold;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-family: Arial, sans-serif;
        }
        .header .status-badge.approved {
            background: rgba(255,255,255,0.2);
            color: #ffffff;
            border: 2px solid rgba(255,255,255,0.5);
        }
        .header .status-badge.rejected {
            background: rgba(255,255,255,0.15);
            color: rgba(255,255,255,0.92);
            border: 2px solid rgba(255,255,255,0.35);
        }

        /* ── BODY ── */
        .body {
            padding: 36px 36px 28px;
            background: #ffffff;
        }

        .greeting {
            font-size: 17px;
            margin-bottom: 18px;
            color: #1a1a1a;
        }

        .body p {
            font-size: 15px;
            color: #3d3d3d;
            margin-bottom: 16px;
        }

        /* ── PAPER DETAILS CARD ── */
        .details-card {
            background: #f7faf7;
            border: 1px solid #d4e8d4;
            border-radius: 8px;
            padding: 18px 20px;
            margin: 22px 0;
        }
        .details-card .card-title {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #158532;
            font-weight: bold;
            margin-bottom: 14px;
            font-family: Arial, sans-serif;
        }
        .details-card table {
            width: 100%;
            border-collapse: collapse;
        }
        .details-card table td {
            padding: 6px 0;
            font-size: 14px;
            vertical-align: top;
            border-bottom: 1px solid #eaf3ea;
        }
        .details-card table tr:last-child td {
            border-bottom: none;
        }
        .details-card table td:first-child {
            color: #777;
            width: 145px;
            font-family: Arial, sans-serif;
            font-size: 13px;
        }
        .details-card table td:last-child {
            color: #1a1a1a;
            font-weight: 600;
            font-family: Arial, sans-serif;
        }

        /* ── DIVIDER ── */
        .divider {
            border: none;
            border-top: 1px solid #e8eee8;
            margin: 26px 0;
        }

        /* ── FEEDBACK TOGGLE ── */
        .feedback-section {
            margin: 24px 0;
        }
        .feedback-section .feedback-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: bold;
            font-family: Arial, sans-serif;
            margin-bottom: 8px;
        }
        .feedback-section .feedback-label.approved { color: #158532; }
        .feedback-section .feedback-label.rejected  { color: #5a6e5e; }

        details.feedback-toggle {
            border-radius: 8px;
            overflow: hidden;
        }
        details.feedback-toggle summary {
            cursor: pointer;
            padding: 13px 18px;
            font-size: 14px;
            font-weight: bold;
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            gap: 10px;
            list-style: none;
            user-select: none;
        }
        details.feedback-toggle summary::-webkit-details-marker { display: none; }
        details.feedback-toggle.approved summary {
            background-color: #eaf6ed;
            color: #155724;
            border: 1px solid #c3e6cb;
            border-radius: 8px;
        }
        details.feedback-toggle[open].approved summary {
            border-radius: 8px 8px 0 0;
        }
        details.feedback-toggle.rejected summary {
            background-color: #f0f4f1;
            color: #3d5242;
            border: 1px solid #c2d4c5;
            border-radius: 8px;
        }
        details.feedback-toggle[open].rejected summary {
            border-radius: 8px 8px 0 0;
        }
        details.feedback-toggle summary .chevron {
            margin-left: auto;
            font-style: normal;
            font-size: 11px;
            transition: transform 0.2s ease;
        }
        details.feedback-toggle[open] summary .chevron {
            transform: rotate(180deg);
        }
        .feedback-body {
            padding: 16px 18px;
            font-size: 14px;
            line-height: 1.8;
            white-space: pre-line;
            font-family: Arial, sans-serif;
            border-radius: 0 0 8px 8px;
        }
        .feedback-body.approved {
            background: #f6fdf7;
            border: 1px solid #c3e6cb;
            border-top: none;
            color: #1d3d24;
        }
        .feedback-body.rejected {
            background: #f7faf7;
            border: 1px solid #c2d4c5;
            border-top: none;
            color: #2d3d30;
        }

        /* ── CTA BUTTON ── */
        .cta-wrap {
            margin: 26px 0 10px;
        }
        .cta-button {
            display: inline-block;
            padding: 13px 28px;
            background: #158532;
            color: #ffffff !important;
            border-radius: 7px;
            text-decoration: none;
            font-size: 15px;
            font-weight: bold;
            font-family: Arial, sans-serif;
            letter-spacing: 0.3px;
        }

        /* ── ENCOURAGEMENT BOX (rejection only) ── */
        .encouragement-box {
            background: #fdfbf0;
            border-left: 4px solid #d4a017;
            border-radius: 0 6px 6px 0;
            padding: 16px 18px;
            margin: 22px 0;
            font-size: 14px;
            color: #4a3c00;
            font-family: Arial, sans-serif;
            line-height: 1.7;
        }
        .encouragement-box strong {
            display: block;
            margin-bottom: 6px;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #7a5c00;
        }

        /* ── SIGN OFF ── */
        .signoff {
            margin-top: 28px;
            font-size: 15px;
            color: #2d2d2d;
        }
        .signoff .name {
            display: block;
            margin-top: 8px;
            font-size: 15px;
            font-weight: bold;
            color: #158532;
            font-family: Arial, sans-serif;
        }
        .signoff a {
            color: #158532;
            text-decoration: none;
            font-size: 14px;
            font-family: Arial, sans-serif;
        }

        /* ── FOOTER ── */
        .footer {
            background: #f0f4f0;
            padding: 20px 32px;
            text-align: center;
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #888888;
            border-top: 1px solid #dde8dd;
        }
        .footer p { margin-bottom: 4px; }
    </style>
</head>
<body>

<div class="wrapper">

    {{-- ══════════════════════════════════════
         HEADER
    ══════════════════════════════════════ --}}
    <div class="header {{ $abstract->status === 'REJECTED' ? 'rejected' : 'approved' }}">
        <div class="logo-line">2nd KALRO Scientific Conference and Exhibition</div>
        <h1>Abstract Review Outcome</h1>
        <h2>"Innovations for Sustainable Agri-food Systems, Climate Change Resilience and Improved Livelihoods"</h2>
        <div class="status-badge {{ $abstract->status === 'REJECTED' ? 'rejected' : 'approved' }}">
            @if($abstract->status === 'REJECTED')
                Not Accepted
            @else
                ✓ &nbsp;Approved
            @endif
        </div>
    </div>

    {{-- ══════════════════════════════════════
         BODY
    ══════════════════════════════════════ --}}
    <div class="body">

        <p class="greeting">Dear {{ $abstract->author_name }},</p>

        @if($abstract->status === 'APPROVED')

            {{-- ─────────────────────────────────
                 APPROVED
            ───────────────────────────────── --}}

            <p>
                Thank you for submitting your abstract to the
                <strong>2nd KALRO Scientific Conference and Exhibition</strong>.
                We are delighted to share the outcome of your review with you.
            </p>

            <div class="details-card">
                <div class="card-title">Submission Details</div>
                <table>
                    <tr>
                        <td>Submission Code</td>
                        <td>{{ $abstract->submission_code }}</td>
                    </tr>
                    <tr>
                        <td>Paper Title</td>
                        <td>{{ $abstract->paper_title }}</td>
                    </tr>
                    <tr>
                        <td>Decision</td>
                        <td style="color: #158532;">✓ Approved</td>
                    </tr>
                </table>
            </div>

            <p>
                🎉 <strong>Congratulations!</strong> Your abstract has been approved by the conference
                scientific committee. We look forward to featuring your work at the conference.
                You will receive further communication regarding presentation guidelines,
                scheduling, and registration details in due course.
            </p>

            <div class="feedback-section">
                <div class="feedback-label approved">Reviewer Feedback</div>
                <details class="feedback-toggle approved">
                    <summary>
                        <span>📋 View comments from the reviewer</span>
                        <span class="chevron">▼</span>
                    </summary>
                    <div class="feedback-body approved">{{ $comment }}</div>
                </details>
            </div>

            @if($uploadUrl)
                <hr class="divider">
                <div class="cta-wrap">
                    <p>
                        <strong>Next Step — Submit Your Full Paper</strong><br>
                        Please use the button below to upload your full paper. Ensure your manuscript
                        follows the conference formatting guidelines before submission.
                    </p>
                    <a href="{{ $uploadUrl }}" class="cta-button">📄 &nbsp;Submit Full Paper</a>
                </div>
            @endif

        @else

            {{-- ─────────────────────────────────
                 REJECTED
            ───────────────────────────────── --}}

            <p>
                Thank you for submitting your abstract to the
                <strong>2nd KALRO Scientific Conference and Exhibition</strong>.
                We truly appreciate the time, thought, and dedication you have put into your work,
                and we are genuinely grateful that you chose to share it with us.
            </p>

            <div class="details-card">
                <div class="card-title">Submission Details</div>
                <table>
                    <tr>
                        <td>Submission Code</td>
                        <td>{{ $abstract->submission_code }}</td>
                    </tr>
                    <tr>
                        <td>Paper Title</td>
                        <td>{{ $abstract->paper_title }}</td>
                    </tr>
                    <tr>
                        <td>Decision</td>
                        <td style="color: #5a6e5e;">Not Accepted</td>
                    </tr>
                </table>
            </div>

            <p>
                After thorough and careful consideration by the conference scientific committee,
                we are sorry to let you know that your abstract has not been selected for this
                year's conference programme. We understand this may be disappointing, and we
                want you to know that this decision reflects the highly competitive nature of
                the selection process it is not a reflection of your dedication or the
                significance of your research.
            </p>

            <p>
                To support your growth and help you strengthen your work for future submissions,
                the reviewers have shared some specific observations. We hope you find their
                feedback constructive and encouraging:
            </p>

            <div class="feedback-section">
                <div class="feedback-label rejected">Reviewer Comments</div>
                <details class="feedback-toggle rejected">
                    <summary>
                        <span>💬 Read feedback from the reviewer</span>
                        <span class="chevron">▼</span>
                    </summary>
                    <div class="feedback-body rejected">{{ $comment }}</div>
                </details>
            </div>

            <div class="encouragement-box">
                <strong>💡 A note of encouragement</strong>
                Many researchers whose work has gone on to make a lasting impact have faced setbacks
                along the way. Please do not be discouraged every piece of feedback is an
                opportunity to refine and strengthen your research. We warmly invite you to
                use these comments, keep building on your work, and consider submitting to
                future KALRO scientific events. We would genuinely love to see you back.
            </div>

        @endif

        <hr class="divider">

        <p>
            If you have any questions or need further clarification, please reach out to us at
            <a href="mailto:kalroconference2026@gmail.com">kalroconference2026@gmail.com</a>.
            Please include your submission code in all correspondence so we can assist you promptly.
        </p>

        <p>
            Thank you once again for your valuable contribution to agricultural science
            and to the 2nd KALRO Scientific Conference and Exhibition.
        </p>

        <div class="signoff">
            Warm regards,
            <span class="name">KALRO Scientific Conference Committee</span>
            <a href="mailto:kalroconference2026@gmail.com">kalroconference2026@gmail.com</a>
        </div>

    </div>

    {{-- ══════════════════════════════════════
         FOOTER
    ══════════════════════════════════════ --}}
    <div class="footer">
        <p>This is an automated message please do not reply directly to this email.</p>
        <p>© {{ date('Y') }} 2nd KALRO Scientific Conference and Exhibition. All rights reserved.</p>
    </div>

</div>

</body>
</html>