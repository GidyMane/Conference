<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome as Temporary Reviewer</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f5f5f5; padding: 30px;">
    <div style="max-width: 600px; margin: auto; background: #fff; padding: 25px; border-radius: 6px;">
        <h2 style="color: #1d4ed8;">Welcome, {{ $name }}!</h2>
        <p>You have been registered as a <strong>Temporary Reviewer</strong> for the conference.</p>

        <p>Your login credentials are:</p>
        <ul>
            <li><strong>Email:</strong> {{ $email }}</li>
            <li><strong>Temporary Password:</strong> {{ $password }}</li>
        </ul>

        <p>Please login at the following link and update your password:</p>
        <p><a href="{{ $loginUrl }}" style="color: #fff; background: #1d4ed8; padding: 10px 15px; border-radius: 4px; text-decoration: none;">Login Now</a></p>

        <p>This temporary password will expire in 24 hours. After logging in, you can start reviewing abstracts assigned to your sub-theme.</p>

        <p>Thank you for your contribution!</p>

        <p style="margin-top: 30px;">— Conference Committee</p>
    </div>
</body>
</html>