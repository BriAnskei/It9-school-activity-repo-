<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NailSalon - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8bbd0 0%, #f48fb1 50%, #c2185b 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .auth-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(194,24,91,0.2);
            padding: 40px;
            width: 100%;
            max-width: 400px;
        }
        .auth-logo { color: #c2185b; font-size: 2rem; margin-bottom: 4px; }
        .btn-primary { background: #c2185b; border-color: #c2185b; }
        .btn-primary:hover { background: #880e4f; border-color: #880e4f; }
        .form-control:focus { border-color: #c2185b; box-shadow: 0 0 0 0.2rem rgba(194,24,91,0.15); }
    </style>
</head>
<body>
    @yield('content')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
