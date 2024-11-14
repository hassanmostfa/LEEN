<!DOCTYPE html>
<html>
<head>
    <title>تسجيل مستخدم جديد</title>
</head>
<body>
    <h1>تسجيل مستخدم جديد</h1>
    <p>تم تسجيل مستخدم جديد بالمعلومات التالية:</p>
    <ul>
        <li><strong>الاسم:</strong> {{ $customer->first_name }} {{ $customer->last_name }}</li>
        <li><strong>البريد الإلكتروني:</strong> {{ $customer->email }}</li>
        <li><strong>الهاتف:</strong> {{ $customer->phone }}</strong></li>
        <li><strong>العنوان: </strong>{{ $customer->location }}</strong></li>
    </ul>
</body>
</html>
