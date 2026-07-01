<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kedai Kopi')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --kopi-espresso: #2C1810;
            --kopi-medium: #6F4E37;
            --kopi-cream: #F5F5DC;
        }
        body { background-color: #f8f9fa; color: #333; }
        .btn-kopi { background: var(--kopi-medium); color: #fff; border-radius: 10px; padding: 12px; width: 100%; border: none; font-weight: 600; text-decoration: none; display: block; text-align: center; }
        .btn-kopi:hover { background: var(--kopi-espresso); color: #fff; }
    </style>
    @stack('styles')
</head>
<body>
    <div class="container-fluid p-0 mx-auto" style="max-width: 480px; background: #fff; min-height: 100vh; box-shadow: 0 0 20px rgba(0,0,0,0.05);">
        @yield('content')
    </div>
    @stack('scripts')
</body>
</html>