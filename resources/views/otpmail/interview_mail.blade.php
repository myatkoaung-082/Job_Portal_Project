<!DOCTYPE html>
<html>
<head>
    <title>Interview Invitation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 100%;
            padding: 20px;
        }
        .content {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #02475e;
            color: #ffffff;
            padding: 10px;
            border-radius: 8px 8px 0 0;
            text-align: center;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #888888;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="content">
            <div class="header">
                <h1>Interview Invitation</h1>
            </div>
            <p>Dear {{ $seekerName }},</p>
            <p>We are pleased to inform you that you have been shortlisted for an interview at our company.</p>
            <p><strong>Company:</strong> {{ $companyName }}</p>
            <p><strong>Industry:</strong> {{ $industryName }}</p>
            <p><strong>Position:</strong> {{ $jobPosition }}</p>
            <p><strong>Date:</strong> {{ $date }}</p>
            <p><strong>Time:</strong> {{ $time }}</p>
            <p><strong>Location:</strong> {{ $location }}</p>
            <p>We look forward to meeting you.</p>
            <p>Best regards,</p>
            <p>{{ $companyName }}</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ $companyName }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>