<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Contact Message</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f4f4;font-family:Arial,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" style="padding:40px 0;">
                <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:8px;overflow:hidden;box-shadow:0 4px 15px rgba(0,0,0,0.1);">

                    <!-- Header -->
                    <tr>
                        <td style="background:#198754;padding:20px;text-align:center;color:#ffffff;">
                            <h2 style="margin:0;">KALRO Scientific Conference</h2>
                            <p style="margin:5px 0 0;font-size:14px;">New Contact Message</p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:30px;">
                            <p><strong>Full Name:</strong> {{ $data['name'] }}</p>
                            <p><strong>Email:</strong> {{ $data['email'] }}</p>
                            <p><strong>Subject:</strong> {{ $data['subject'] }}</p>

                            <hr style="margin:20px 0;border:none;border-top:1px solid #ddd;">

                            <p style="margin-bottom:10px;"><strong>Message:</strong></p>
                            <p style="line-height:1.6;color:#555;">
                                {{ $data['message'] }}
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#f8f9fa;padding:15px;text-align:center;font-size:13px;color:#777;">
                            © {{ date('Y') }} KALRO • Nairobi, Kenya
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
