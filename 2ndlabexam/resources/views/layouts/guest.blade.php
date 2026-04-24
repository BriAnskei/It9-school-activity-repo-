<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Rice Shop') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --cream:       #FBF7F0;
            --cream-dark:  #F0E9DC;
            --tan:         #D4A96A;
            --tan-light:   #E8C99A;
            --brown:       #7A5C38;
            --brown-dark:  #5C4020;
            --text:        #3A2E22;
            --text-muted:  #8A7560;
            --white:       #FFFFFF;
            --danger:      #C0392B;
            --danger-light:#FADBD8;
            --success:     #1E8449;
            --success-light:#D5F5E3;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--cream);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            background-image:
                radial-gradient(ellipse at 20% 50%, rgba(212,169,106,0.12) 0%, transparent 60%),
                radial-gradient(ellipse at 80% 20%, rgba(122,92,56,0.08) 0%, transparent 50%);
        }

        .auth-wrapper {
            width: 100%;
            max-width: 440px;
        }

        .auth-brand {
            text-align: center;
            margin-bottom: 28px;
        }

        .auth-brand .brand-icon {
            font-size: 40px;
            display: block;
            margin-bottom: 10px;
        }

        .auth-brand h1 {
            font-family: 'Playfair Display', serif;
            font-size: 26px;
            font-weight: 600;
            color: var(--brown-dark);
        }

        .auth-brand p {
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 4px;
        }

        .auth-card {
            background: var(--white);
            border-radius: 16px;
            box-shadow: 0 8px 40px rgba(90,60,20,0.12);
            border: 1px solid var(--cream-dark);
            padding: 36px;
        }

        .auth-card h2 {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            font-weight: 500;
            color: var(--brown-dark);
            margin-bottom: 6px;
        }

        .auth-card .subtitle {
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 24px;
            line-height: 1.6;
        }

        .form-group { margin-bottom: 18px; }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: var(--brown);
            margin-bottom: 7px;
        }

        .form-control {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid var(--cream-dark);
            border-radius: 9px;
            font-size: 14px;
            font-family: 'DM Sans', sans-serif;
            color: var(--text);
            background: var(--white);
            transition: border-color 0.18s;
            outline: none;
        }

        .form-control:focus {
            border-color: var(--tan);
            box-shadow: 0 0 0 3px rgba(212,169,106,0.15);
        }

        .btn-primary {
            display: block;
            width: 100%;
            padding: 13px;
            background: var(--brown);
            color: white;
            border: none;
            border-radius: 9px;
            font-size: 15px;
            font-weight: 500;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            transition: all 0.18s ease;
            text-align: center;
            text-decoration: none;
            margin-top: 8px;
        }

        .btn-primary:hover {
            background: var(--brown-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(90,60,20,0.25);
        }

        .btn-secondary {
            display: block;
            width: 100%;
            padding: 13px;
            background: var(--cream-dark);
            color: var(--brown);
            border: none;
            border-radius: 9px;
            font-size: 15px;
            font-weight: 500;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            transition: all 0.18s ease;
            text-align: center;
            text-decoration: none;
            margin-top: 10px;
        }

        .btn-secondary:hover { background: #e0d5c5; }

        .auth-footer {
            text-align: center;
            margin-top: 22px;
            font-size: 13px;
            color: var(--text-muted);
        }

        .auth-footer a {
            color: var(--brown);
            font-weight: 500;
            text-decoration: none;
        }

        .auth-footer a:hover { text-decoration: underline; }

        .alert {
            padding: 11px 14px;
            border-radius: 9px;
            font-size: 13px;
            margin-bottom: 18px;
        }

        .alert-danger  { background: var(--danger-light);  color: var(--danger);  border: 1px solid #f1948a; }
        .alert-success { background: var(--success-light); color: var(--success); border: 1px solid #a9dfbe; }

        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 20px 0;
            color: var(--text-muted);
            font-size: 12px;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--cream-dark);
        }
    </style>
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-brand">
            <span class="brand-icon">🌾</span>
            <h1>Rice Shop</h1>
            <p>Management System</p>
        </div>
        <div class="auth-card">
            {{ $slot }}
        </div>
    </div>
</body>
</html>