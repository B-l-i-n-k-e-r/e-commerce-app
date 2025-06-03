<!DOCTYPE html>
<html>
<head>
    <title>Password Reset Link</title>
</head>
<body>
    <p>Hello {{ $user->name }},</p>
    <p>An administrator has approved your request to reset your password. Please click the link below to set a new password:</p>
    <p><a href="{{ $resetLink }}">Reset Password</a></p>
    <p>This link will expire in 60 minutes.</p>
    <p>If you did not request a password reset, no further action is required.</p>
    <p>Thank you!</p>
</body>
</html>