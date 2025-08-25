<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Message Notification</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
            line-height: 1.6;
            color: #333333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 1px solid #eeeeee;
            padding-bottom: 20px;
        }

        .header h1 {
            color: #007bff;
            font-size: 24px;
            margin: 0 0 10px 0;
        }

        .header p {
            color: #666666;
            font-size: 14px;
            margin: 0;
        }

        .user-info {
            display: flex;
            /* Use flexbox for layout */
            align-items: center;
            /* Vertically align items */
            margin-bottom: 20px;
            padding: 20px;
            background-color: #f9f9f9;
            border-left: 4px solid #007bff;
            border-radius: 4px;
        }

        .user-image {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            /* Make the image round */
            margin-right: 20px;
            /* Space between image and text */
            object-fit: cover;
            /* Ensure image covers the area without distortion */
        }

        .user-details {
            flex-grow: 1;
            /* Allow details to take up remaining space */
        }

        .user-details h2 {
            margin: 0 0 5px 0;
            font-size: 18px;
            color: #333333;
        }

        .user-details p {
            margin: 0;
            font-size: 14px;
            color: #666666;
        }

        .user-details p strong {
            color: #000000;
        }

        .message-content {
            margin-bottom: 30px;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #eeeeee;
            border-radius: 4px;
        }

        .message-content h3 {
            margin: 0 0 15px 0;
            font-size: 20px;
            color: #333333;
        }

        .message-content p {
            margin: 0;
            white-space: pre-wrap;
            /* Preserve whitespace and line breaks */
        }

        .button {
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 16px;
            padding: 12px;
            background-color: #007bff;
            border-radius: 8px;
            color: white;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #999999;
            margin-top: 20px;
            border-top: 1px solid #eeeeee;
            padding-top: 20px;
        }

        .footer a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>New Message Received</h1>
            <p>You have a new message from a user.</p>
        </div>

        <div class="user-info">
            <img class="user-image" src="{{ $user->image ?? 'default_user_image.jpg' }}"
                alt="{{ $user->username }}'s profile picture">
            <div class="user-details">
                <h2>{{ $user->firstname }} {{ $user->lastname }}</h2>
                <p><strong>Username:</strong> {{ $user->username }}</p>
                <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
                <p><strong>Email:</strong> <a href="mailto:{{ $user->email }}"
                        style="color: #666666; text-decoration: none;">{{ $user->email }}</a></p>
            </div>
        </div>

        <div class="message-content">
            <h3>Message:</h3>
            <p>{{ $user_message }}</p>
        </div>

        <a class="button" href="{{ 'https://wa.me/' . $user->freelancer_details->phone_number }}">Message Back</a>

        <div class="footer">
            <p>This is an automated notification. Please do not reply to this email.</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
