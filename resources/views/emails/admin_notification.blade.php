<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>انضمام بائع جديد</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 20px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
        .header {
            background-color: #007bff;
            color: white;
            padding: 15px;
            border-radius: 10px 10px 0 0;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <h1>انضمام بائع جديد</h1>
        </div>

        <div class="mt-4">
            <p>أهلاً.. مقدم خدمة جديد يريد الانضمام إلى لين. هذه هي التفاصيل الخاصة بمقدم الخدمة:</p>
            <ul class="list-group">
                <li class="list-group-item"><strong>الاسم الأول:</strong> {{ $seller->first_name }}</li>
                <li class="list-group-item"><strong>الاسم الأخير:</strong> {{ $seller->last_name }}</li>
                <li class="list-group-item"><strong>البريد الإلكتروني:</strong> {{ $seller->email }}</li>
                <li class="list-group-item"><strong>الهاتف:</strong> {{ $seller->phone }}</li>
                <li class="list-group-item"><strong>العنوان:</strong> {{ $seller->location }}</li>
            </ul>
        </div>

        <div class="mt-4 text-center">
            <p>يرجى <a href="{{ url('/admin/sellers/requests/'.$seller->id) }}" class="btn btn-custom">الضغط هنا</a> لمراجعة مقدم الخدمة والموافقة أو الرفض.</p>
        </div>
    </div>

</body>
</html>

