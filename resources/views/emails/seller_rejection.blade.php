<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>رفض طلب التسجيل</title>
</head>
<body>
    <h1>مرحبًا {{ $seller->first_name }} {{ $seller->last_name }}</h1>
    <p>نأسف لإبلاغك بأن طلب التسجيل الخاص بك قد تم رفضه.</p>

    <p><strong>سبب الرفض:</strong></p>
    <p>{{ $seller->request_rejection_reason }}</p>

    <div class="mt-4 text-center">
            <p>يرجى <a href="{{ url('/seller/profile/update' , $seller->id) }}" class="btn btn-custom">الضغط هنا</a> لاستكمال البيانات واعادة ارسال الطلب</p>
    </div>
    <p>شكرًا لاختيارك لين.</p>
</body>
</html>
