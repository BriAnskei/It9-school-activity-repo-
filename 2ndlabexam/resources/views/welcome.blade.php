<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rice Shop — Management System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --cream: #FBF7F0;
            --tan: #D4A96A;
            --brown: #7A5C38;
            --brown-dark: #5C4020;
            --text-muted: #8A7560;
        }
        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--cream);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image:
                radial-gradient(ellipse at 15% 60%, rgba(212,169,106,0.15) 0%, transparent 55%),
                radial-gradient(ellipse at 85% 20%, rgba(122,92,56,0.10) 0%, transparent 50%);
        }
        .welcome-wrap {
            text-align: center;
            max-width: 520px;
            padding: 40px 20px;
        }
        .icon { font-size: 64px; margin-bottom: 20px; display: block; }
        h1 {
            font-family: 'Playfair Display', serif;
            font-size: 48px;
            font-weight: 700;
            color: var(--brown-dark);
            line-height: 1.1;
            margin-bottom: 12px;
        }
        h1 span { color: var(--tan); }
        p {
            color: var(--text-muted);
            font-size: 16px;
            font-weight: 300;
            line-height: 1.7;
            margin-bottom: 36px;
        }
        .btn-group { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
        .btn {
            padding: 14px 32px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 500;
            font-family: 'DM Sans', sans-serif;
            text-decoration: none;
            transition: all 0.18s ease;
            display: inline-block;
        }
        .btn-primary {
            background: var(--brown);
            color: white;
        }
        .btn-primary:hover { background: var(--brown-dark); transform: translateY(-2px); box-shadow: 0 6px 20px rgba(90,60,20,0.25); }
        .btn-outline {
            background: transparent;
            color: var(--brown);
            border: 2px solid var(--tan);
        }
        .btn-outline:hover { background: var(--tan); color: white; transform: translateY(-2px); }
        .divider {
            width: 60px;
            height: 3px;
            background: var(--tan);
            border-radius: 2px;
            margin: 20px auto 30px;
        }
    </style>
</head>
<body>
    <div class="welcome-wrap">
        <span class="icon">🌾</span>
        <h1>Rice <span>Shop</span></h1>
        <div class="divider"></div>
        <p>A complete management system for your rice selling business. Track products, manage orders, and process payments — all in one place.</p>

        @if (Route::has('login'))
            <div class="btn-group">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">Sign In</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-outline">Create Account</a>
                    @endif
                @endauth
            </div>
        @endif
    </div>
</body>
</html>