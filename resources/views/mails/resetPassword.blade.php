<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Reset Password - ExpenseTracker</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f4f4f5;
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 600px;
      background-color: #ffffff;
      margin: 30px auto;
      border-radius: 8px;
      padding: 30px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }
    .header {
      text-align: center;
      padding-bottom: 20px;
    }
    .header h1 {
      color: #4f46e5;
      font-size: 24px;
      margin: 0;
    }
    .content {
      color: #333333;
      font-size: 16px;
      line-height: 1.6;
    }
    .btn {
      display: inline-block;
      margin: 25px 0;
      padding: 12px 24px;
      background-color: #4f46e5;
      color: #ffffff;
      text-decoration: none;
      border-radius: 6px;
      font-weight: bold;
    }
    .footer {
      text-align: center;
      font-size: 13px;
      color: #888888;
      margin-top: 30px;
    }
    .link-fallback {
      font-size: 14px;
      margin-top: 20px;
      word-break: break-all;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <h1>Reset Your Password</h1>
    </div>
    <div class="content">
      <p>Hi dear User</p>
      <p>We received a request to reset your password for your <strong>ExpenseTracker</strong> account.</p>
      <p>If you made this request, click the button below to set a new password:</p>
      <p style="text-align: center;">
        <a href="{{route('welcome')}}" class="btn">Reset Password</a>
      </p>
      <p>This link will expire in <strong>5 minutes</strong>.</p>
      <p>If you didn’t request a password reset, no worries — you can safely ignore this email.</p>
      
    </div>
    <div class="footer">
      &copy; 2025 ExpenseTracker. All rights reserved.<br/>
      Track Smart. Spend Better.
    </div>
  </div>
</body>
</html>
