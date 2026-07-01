<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kedai Kopi ☕</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --kopi-espresso: #2C1810;
            --kopi-medium: #6F4E37;
            --kopi-latte: #C9A87C;
            --kopi-accent: #E07B39;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f5f0;
            color: var(--kopi-espresso);
        }
        .navbar-kopi {
            background-color: var(--kopi-espresso);
            color: white;
        }
        .btn-accent {
            background-color: var(--kopi-accent);
            color: white;
        }
        .btn-accent:hover {
            background-color: var(--kopi-medium);
            color: white;
        }
        .card-menu {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            transition: 0.3s;
        }
        .card-menu:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>

<nav class="navbar navbar-kopi sticky-top shadow-sm">
    <div class="container py-2">
        <a class="navbar-brand text-white fw-bold" href="#">☕ Kedai Kopi</a>
        <div class="d-flex align-items-center">
            <span class="badge bg-light text-dark me-3">Meja: {{ session('nomor_meja', 'Belum Pilih') }}</span>
            <a href="{{ route('cart.index') }}" class="btn btn-outline-light position-relative">
                <i class="bi bi-bag-heart-fill"></i>
                @if(session('cart'))
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ count(session('cart')) }}
                    </span>
                @endif
            </a>
        </div>
    </div>
</nav>

<div class="container my-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        @foreach($kategoris as $kategori)
            @if($kategori->menus->count() > 0)
                <h3 class="fw-bold mb-4 mt-2" style="color: var(--kopi-medium)">— {{ $kategori->nama_kategori }}</h3>
                <div class="row row-cols-2 row-cols-md-4 g-4 mb-5">
                    @foreach($kategori->menus as $menu)
                        <div class="col">
                            <div class="card h-100 card-menu">
                                <img src="{{ asset('img/' . $menu->foto) }}" class="card-img-top rounded-top-4" alt="{{ $menu->nama_menu }}" style="height: 160px; object-fit: cover;">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <div>
                                        <h5 class="card-title fw-bold m-0">{{ $menu->nama_menu }}</h5>
                                        <p class="text-muted small">Stok: {{ $menu->stok }}</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <span class="fw-bold text-success">Rp {{ number_format($menu->harga, 0, ',', '.') }}</span>
                                        <a href="{{ route('cart.add', $menu->id) }}" class="btn btn-accent btn-sm rounded-circle"><i class="bi bi-plus-lg"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @endforeach
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>