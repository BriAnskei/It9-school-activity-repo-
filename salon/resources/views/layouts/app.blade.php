<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NailSalon - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; }
        .sidebar {
            min-height: 100vh;
            background: #c2185b;
            width: 220px;
        }
        .sidebar a { color: rgba(255,255,255,0.85); text-decoration: none; }
        .sidebar a:hover { color: #fff; background: rgba(255,255,255,0.1); border-radius: 8px; }
    </style>
</head>
<body>
    <div class="d-flex">
        <div class="sidebar p-3">
            <div class="text-white fw-bold fs-5 mb-4 mt-2"><i class="bi bi-stars me-2"></i>NailSalon</div>
            <nav class="d-flex flex-column gap-1">
                <a href="{{ route('dashboard') }}" class="px-3 py-2 d-flex align-items-center gap-2">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a href="{{ route('services.index') }}" class="px-3 py-2 d-flex align-items-center gap-2">
                    <i class="bi bi-scissors"></i> Services
                </a>
                <a href="{{ route('appointments.index') }}" class="px-3 py-2 d-flex align-items-center gap-2">
                    <i class="bi bi-calendar-check"></i> Appointments
                </a>
                <a href="{{ route('payments.index') }}" class="px-3 py-2 d-flex align-items-center gap-2">
                    <i class="bi bi-cash-stack"></i> Payments
                </a>
            </nav>
            <div class="mt-auto pt-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-light w-100">
                        <i class="bi bi-box-arrow-left me-1"></i> Logout
                    </button>
                </form>
            </div>
        </div>
        <div class="flex-grow-1 p-4">
            <h5 class="fw-bold mb-4">@yield('title')</h5>
            @yield('content')
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
