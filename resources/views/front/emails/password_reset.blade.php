<!DOCTYPE html>
<html>
<head>
    <title>Reset Your Password</title>
</head>
<body>
    <h2>Reset Your Password</h2>
    <p>You are receiving this email because we received a password reset request for your account.</p>
    <p>Please click the button below to reset your password:</p>

    <a href="{{ route('password.reset', ['token' => $token, 'email' => $email]) }}" 
       style="background-color: #0d6efd; color: white; padding: 14px 25px; text-align: center; text-decoration: none; display: inline-block; border-radius: 5px;">
        Reset Password
    </a>

    <p>This password reset link will expire in {{ config('auth.passwords.users.expire', 60) }} minutes.</p>
    <p>If you did not request a password reset, no further action is required.</p>
</body>
</html>
