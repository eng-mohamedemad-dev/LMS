<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>كود التحقق</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background-color: #f4f7f9;
      font-family: 'Arial', 'Tahoma', sans-serif;
    }
    .container {
      width: 100%;
      padding: 40px 0;
      display: flex;
      justify-content: center;
    }
    .email-wrapper {
      width: 650px;
      background-color: #ffffff;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }
    .header {
      background: linear-gradient(135deg, #0d6efd, #4dabf7);
      color: #ffffff;
      padding: 30px 0;
      text-align: center;
      font-size: 28px;
      font-weight: 600;
      letter-spacing: 1px;
    }
    .content {
      padding: 50px 40px;
      text-align: center;
      color: #2c3e50;
    }
    .content h2 {
      color: #1a73e8;
      font-size: 26px;
      margin: 0 0 25px;
      font-weight: 500;
    }
    .code {
      font-size: 54px;
      font-weight: 700;
      color: #e74c3c;
      margin: 0 0 35px;
      letter-spacing: 2px;
    }
    .content p {
      font-size: 16px;
      margin: 0 0 15px;
      line-height: 1.6;
    }
    .content .expiry {
      font-weight: 600;
      color: #2c3e50;
    }
    .footer {
      background-color: #f8f9fa;
      padding: 20px 40px;
      text-align: center;
      font-size: 12px;
      color: #7f8c8d;
      border-top: 1px solid #eee;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="email-wrapper">
      <div class="header">
        منصة التعليم الذكي
      </div>
      <div class="content">
        <h2>رمز التحقق الخاص بك هو</h2>
        <div class="code">{{ $code }}</div>
        <p>
          <span class="expiry">تنتهي صلاحية هذا الكود بعد 10 دقائق</span>
        </p>
        <p style="font-size: 14px; color: #7f8c8d; margin-top: 30px;">
          إذا لم تطلب هذا الكود، يمكنك تجاهل هذه الرسالة.
        </p>
      </div>
      <div class="footer">
        © {{ date('Y') }} جميع الحقوق محفوظة لمنصة التعليم الذكي.
      </div>
    </div>
  </div>
</body>
</html>
