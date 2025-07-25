<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email Address</title>

    <style>
        body {
            font-family: sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f7fafc;
            padding: 16px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 24px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 24px;
            font-weight: bold;
            color: #1a202c;
        }

        .content {
            margin-bottom: 20px;
        }

        .content p {
            color: #4a5568;
            margin-bottom: 16px;
        }

        .code-box {
            display: inline-block;
            padding: 16px 32px;
            background-color: #281c2b;
            border-radius: 8px;
            font-size: 30px;
            font-weight: bold;
            letter-spacing: 0.05em;
            color: #ffffff;
            text-align: center;
            border: 2px solid #640464;
            user-select: all;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #a0aec0;
            margin-top: 24px;
            padding-top: 16px;
            border-top: 1px solid #e2e8f0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Email Verification</h1>
        </div>

        <div class="content">
            <p>Hello {{ $user->firstname }},</p>
            <p>
                Thank you for registering with us! To complete your registration and verify your email address
                ({{ $user->email }}), please use the following One-Time Password (OTP):
            </p>

            <div style="text-align: center; margin: 32px 0;">
                <span class="code-box">
                    {{ $verificationCode }}
                </span>
            </div>

            <p>
                This code is valid for 2 minutes. Please enter it on the verification page to confirm your email.
            </p>
            <p>
                If you did not request this code, please ignore this email.
            </p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} BidMax. All rights reserved.</p>
            <p>If you have any questions, please contact our support team.</p>
        </div>
    </div>
</body>

</html>
