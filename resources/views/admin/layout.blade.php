<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Kedai Kopi ☕</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --bg-coffee: #FDFBF7;
            --primary-coffee: #2C1810;
            --accent-warm: #E07B39;
            --soft-tan: #F4EFE6;
            --text-muted: #7A6E67;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-coffee);
            color: var(--primary-coffee);
        }
        .sidebar {
            width: 230px;
            min-height: 100vh;
            background: var(--primary-coffee);
            position: fixed;
            top: 0; left: 0; bottom: 0;
            padding: 20px 14px;
        }
        .sidebar a {
            color: #e8ded4;
            text-decoration: none;
            display: block;
            padding: 10px 14px;
            border-radius: 10px;
            margin-bottom: 4px;
            font-weight: 600;
            font-size: .95rem;
        }
        .sidebar a.active, .sidebar a:hover {
            background: var(--accent-warm);
            color: #fff;
        }
        .main-content {
            margin-left: 230px;
            padding: 28px;
        }
        .card-stat {
            border: none;
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 8px 20px rgba(44, 24, 16, 0.05);
        }
        .btn-coffee { background: var(--accent-warm); border: none; color: #fff; font-weight: 600; }
        .btn-coffee:hover { background: #c96a2e; color: #fff; }
        .table-wrap { background: #fff; border-radius: 16px; padding: 10px 16px; }
    </style>
</head>
<body>

<div class="sidebar">
    <h5 class="text-white fw-bold mb-4">☕ Kedai Kopi</h5>
    <p class="text-white-50 small mb-4">Halo, {{ session('admin_nama', 'Admin') }}</p>

    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>
    <a href="{{ route('admin.menu.index') }}" class="{{ request()->routeIs('admin.menu.*') ? 'active' : '' }}">
        <i class="bi bi-cup-hot"></i> Kelola Menu
    </a>
    <a href="{{ route('admin.meja.index') }}" class="{{ request()->routeIs('admin.meja.*') ? 'active' : '' }}">
        <i class="bi bi-grid-3x3-gap"></i> Kelola Meja
    </a>
    <a href="{{ route('kasir.index') }}"><i class="bi bi-cash-coin"></i> Kasir</a>
    <a href="{{ route('dapur.index') }}"><i class="bi bi-egg-fried"></i> Dapur</a>

    <hr class="border-secondary">
    <a href="{{ route('admin.logout') }}"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>

<div class="main-content">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @yield('content')
</div>

</body>
</html>
