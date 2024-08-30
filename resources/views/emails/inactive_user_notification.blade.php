<!DOCTYPE html>
<html>
<head>
    <title>Account Inactive Warning</title>
</head>
<body>
    <h1>Dear {{ $user->name }},</h1>
    <p>Your account has been inactive for more than 3 months. It will be permanently deleted in 30 days if no action is taken.</p>
    <p>If this was a mistake, please log in to reactivate your account.</p>
    <p>Thank you!</p>
</body>
</html>