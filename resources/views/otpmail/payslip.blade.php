{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
</head>
<body>
    
    <div class="container-fluid">
        <div class="row bg-primary text-center mb-2">
            <div class="col p-2"><h3>Payment Verification Complete</h3></div>
        </div>
        <div class="row">
            <div class="col text-start p-3">
                <p>Your Account is fully verified and ready to perform your functions easily.</p>
                <a href="https://youtube.com/">Learn More to Sign in</a>
            </div>
        </div>
    </div>

</body>
</html> --}}

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Plan Approved</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 0;
            }

            .container {
                background-color: #ffffff;
                margin: 50px auto;
                padding: 20px;
                max-width: 600px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            .header {
                background-color: #02475e;
                color: #ffffff;
                padding: 10px 20px;
                border-radius: 8px 8px 0 0;
            }

            .header h1 {
                margin: 0;
                font-size: 24px;
            }

            .content {
                padding: 20px;
                line-height: 1.6;
            }

            .content p {
                margin: 0 0 20px;
            }

            .content a {
                display: inline-block;
                padding: 10px 20px;
                background-color: #007bff;
                color: #ffffff;
                text-decoration: none;
                border-radius: 5px;
            }

            .footer {
                margin-top: 20px;
                font-size: 12px;
                color: #777777;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <div class="header">
                <h1>Plan Approved: Ready to Create Job Posts</h1>
            </div>
            <div class="content">
                <p>Dear {{$companyName}},</p>
                <p>We are pleased to inform you that your plan has been approved. You can now start creating job posts on
                    our platform.</p>
                <p>Your plan is valid until <strong>[{{$expireDate}}]</strong>.</p>
                <p>To create a new job post, simply log in to your account and navigate to the job creation page.</p>
                <p>If you have any questions or need assistance, feel free to contact our support team.</p>
                <p>Best regards,</p>
                <p>Next-Gen Job Matching Team</p>
            </div>
            <div class="footer">
                <p>&copy; 2024 Next-Gen Job Matching. All rights reserved.</p>
            </div>
        </div>
    </body>

</html>
