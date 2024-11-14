<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تمت الموافقة على طلبك</title>
</head>
<body>
    <h1>مرحبًا {{ $seller->first_name }} {{ $seller->last_name }}</h1>
    <p>تهانينا! تمت الموافقة على طلبك للانضمام إلى منصة لين. يمكنك الآن استخدام خدماتنا.</p>

    <p>البريد الإلكتروني الخاص بك: {{ $seller->email }}</p>

    <p>يرجى <a href="{{ url('/seller/login') }}">الضغط هنا</a> لتسجيل الدخول إلى حسابك.</p>

    <p>شكرًا لاختيارك لين.</p>
</body>
</html>
