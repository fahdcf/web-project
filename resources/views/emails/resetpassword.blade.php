<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New User Registration - Assign Pro</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f7;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }
        .header {
            background-color: #0a58ca;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
            color: #333;
        }
        .content p {
            font-size: 16px;
            line-height: 1.6;
        }
        .actions {
            margin-top: 30px;
            text-align: center;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            margin: 10px;
            border-radius: 5px;
            color: #fff;
            text-decoration: none;
            font-weight: bold;
        }
        .approve {
            background-color: #28a745;
            color: white;
        }
        .reject {
            background-color: #dc3545;
        }
        .footer {
            background-color: #f4f4f7;
            padding: 15px;
            text-align: center;
            font-size: 12px;
            color: #aaa;
        }
    </style>
</head>
<body>

    
    
    <div class="email-container">
        
        <div class="header">
            <h1>Assign Pro - Rest your password</h1>
        </div>
        <div class="content">
            <p><strong>A new user has registered on Assign Pro!</strong></p>
            <p><strong>Verification code</strong> {{ $code }}</p>
            <p>You can now approve or reject their request to join the platform.</p>

            
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Assign Pro. All rights reserved.
        </div>
    </div>
</body>
</html>
