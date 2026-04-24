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
            --brown-light: #A67C52;
            --text:        #3A2E22;
            --text-muted:  #8A7560;
            --white:       #FFFFFF;
            --danger:      #C0392B;
            --danger-light:#FADBD8;
            --success:     #1E8449;
            --success-light:#D5F5E3;
            --warning:     #D68910;
            --warning-light:#FDEBD0;
            --sidebar-w:   240px;
            --topbar-h:    64px;
            --radius:      12px;
            --shadow:      0 2px 12px rgba(90,60,20,0.10);
            --shadow-md:   0 4px 24px rgba(90,60,20,0.13);
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--cream);
            color: var(--text);
            min-height: 100vh;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            position: fixed;
            top: 0; left: 0;
            width: var(--sidebar-w);
            height: 100vh;
            background: var(--brown-dark);
            display: flex;
            flex-direction: column;
            z-index: 100;
            box-shadow: 4px 0 20px rgba(0,0,0,0.15);
        }

        .sidebar-brand {
            padding: 28px 24px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .sidebar-brand .brand-icon {
            font-size: 28px;
            margin-bottom: 6px;
        }

        .sidebar-brand h2 {
            font-family: 'Playfair Display', serif;
            color: var(--tan-light);
            font-size: 18px;
            font-weight: 600;
            line-height: 1.2;
        }

        .sidebar-brand p {
            color: rgba(255,255,255,0.35);
            font-size: 11px;
            font-weight: 300;
            letter-spacing: 0.05em;
            margin-top: 2px;
        }

        .sidebar-nav {
            flex: 1;
            padding: 16px 12px;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .nav-label {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.12em;
            color: rgba(255,255,255,0.25);
            padding: 12px 12px 6px;
            text-transform: uppercase;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            border-radius: 9px;
            color: rgba(255,255,255,0.60);
            text-decoration: none;
            font-size: 14px;
            font-weight: 400;
            transition: all 0.18s ease;
        }

        .nav-item:hover {
            background: rgba(255,255,255,0.07);
            color: var(--tan-light);
        }

        .nav-item.active {
            background: var(--tan);
            color: var(--white);
            font-weight: 500;
            box-shadow: 0 2px 8px rgba(0,0,0,0.18);
        }

        .nav-item svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
            opacity: 0.8;
        }

        .nav-item.active svg { opacity: 1; }

        .sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid rgba(255,255,255,0.08);
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            border-radius: 9px;
            color: rgba(255,255,255,0.45);
            font-size: 14px;
            font-weight: 400;
            width: 100%;
            background: none;
            border: none;
            cursor: pointer;
            transition: all 0.18s ease;
            font-family: 'DM Sans', sans-serif;
        }

        .logout-btn:hover {
            background: rgba(192,57,43,0.18);
            color: #e8a09a;
        }

        .logout-btn svg { width: 18px; height: 18px; opacity: 0.8; }

        /* ── TOPBAR ── */
        .topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-w);
            right: 0;
            height: var(--topbar-h);
            background: var(--white);
            border-bottom: 1px solid var(--cream-dark);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            z-index: 90;
            box-shadow: 0 1px 8px rgba(90,60,20,0.06);
        }

        .topbar-title {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            font-weight: 500;
            color: var(--brown-dark);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-chip {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--cream);
            border: 1px solid var(--cream-dark);
            border-radius: 50px;
            padding: 6px 14px 6px 6px;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--tan);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 600;
        }

        .user-name {
            font-size: 13px;
            font-weight: 500;
            color: var(--brown);
        }

        /* ── MAIN CONTENT ── */
        .main-content {
            margin-left: var(--sidebar-w);
            margin-top: var(--topbar-h);
            padding: 36px 40px;
            min-height: calc(100vh - var(--topbar-h));
        }

        /* ── REUSABLE COMPONENTS ── */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
        }

        .page-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 26px;
            font-weight: 500;
            color: var(--brown-dark);
        }

        .page-header p {
            color: var(--text-muted);
            font-size: 14px;
            margin-top: 3px;
        }

        .card {
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            border: 1px solid var(--cream-dark);
        }

        .card-body { padding: 28px; }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 10px 20px;
            border-radius: 9px;
            font-size: 14px;
            font-weight: 500;
            font-family: 'DM Sans', sans-serif;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.18s ease;
            line-height: 1;
        }

        .btn-primary {
            background: var(--brown);
            color: white;
        }
        .btn-primary:hover { background: var(--brown-dark); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(90,60,20,0.25); }

        .btn-secondary {
            background: var(--cream-dark);
            color: var(--brown);
        }
        .btn-secondary:hover { background: #e0d5c5; }

        .btn-danger {
            background: var(--danger);
            color: white;
        }
        .btn-danger:hover { background: #a93226; }

        .btn-outline {
            background: transparent;
            color: var(--brown);
            border: 1.5px solid var(--cream-dark);
        }
        .btn-outline:hover { border-color: var(--tan); background: var(--cream); }

        .btn-sm { padding: 6px 13px; font-size: 12px; border-radius: 7px; }

        /* Forms */
        .form-group { margin-bottom: 20px; }

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

        textarea.form-control { resize: vertical; min-height: 100px; }

        /* Alerts */
        .alert {
            padding: 12px 16px;
            border-radius: 9px;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .alert-success { background: var(--success-light); color: var(--success); border: 1px solid #a9dfbe; }
        .alert-danger  { background: var(--danger-light);  color: var(--danger);  border: 1px solid #f1948a; }
        .alert-warning { background: var(--warning-light); color: var(--warning); border: 1px solid #f0b27a; }

        /* Tables */
        .table-wrap {
            overflow-x: auto;
            border-radius: var(--radius);
            border: 1px solid var(--cream-dark);
            box-shadow: var(--shadow);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: var(--white);
        }

        thead th {
            background: var(--cream-dark);
            color: var(--brown);
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            padding: 14px 18px;
            text-align: left;
            border-bottom: 1px solid #ddd0bc;
        }

        tbody td {
            padding: 14px 18px;
            font-size: 14px;
            border-bottom: 1px solid var(--cream-dark);
            color: var(--text);
            vertical-align: middle;
        }

        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover { background: #fdf9f4; }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 4px 11px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 500;
        }

        .badge-success  { background: var(--success-light); color: var(--success); }
        .badge-danger   { background: var(--danger-light);  color: var(--danger); }
        .badge-warning  { background: var(--warning-light); color: var(--warning); }
        .badge-neutral  { background: var(--cream-dark);    color: var(--text-muted); }

        /* Detail rows */
        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
        }

        .detail-item {
            padding: 16px 20px;
            border-bottom: 1px solid var(--cream-dark);
        }

        .detail-item:nth-child(odd) { border-right: 1px solid var(--cream-dark); }

        .detail-item .detail-label {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 5px;
        }

        .detail-item .detail-value {
            font-size: 15px;
            font-weight: 500;
            color: var(--text);
        }

        .detail-full {
            grid-column: 1 / -1;
            border-right: none !important;
        }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon">🌾</div>
            <h2>Rice Shop</h2>
            <p>Management System</p>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-label">Main Menu</div>

            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>

            <a href="{{ route('rices.index') }}" class="nav-item {{ request()->routeIs('rices.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                Rice Products
            </a>

            <a href="{{ route('orders.index') }}" class="nav-item {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Orders
            </a>

            <a href="{{ route('payments.index') }}" class="nav-item {{ request()->routeIs('payments.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                Payments
            </a>
        </nav>

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- TOPBAR -->
    <header class="topbar">
        <div class="topbar-title">{{ $pageTitle ?? config('app.name', 'Rice Shop') }}</div>
        <div class="topbar-right">
            <div class="user-chip">
                <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <span class="user-name">{{ Auth::user()->name }}</span>
            </div>
        </div>
    </header>

    <!-- MAIN -->
    <main class="main-content">
        {{ $slot }}
    </main>

</body>
</html>