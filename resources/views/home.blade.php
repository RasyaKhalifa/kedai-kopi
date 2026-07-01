<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kedai Kopi ☕</title>
    
    <!-- Google Fonts Premium & Font Awesome + Bootstrap Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,800;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        :root {
            --kopi-espresso: #21120B;
            --kopi-medium: #543A20;
            --kopi-latte: #D4B28C;
            --kopi-accent: #E07B39;
            --bg-creme: #FAF6F0;
            --soft-tan: #F0E6D8;
            --glass-bg: rgba(255, 255, 255, 0.8);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-creme);
            color: var(--kopi-espresso);
            overflow-x: hidden;
        }

        h1, h2, .serif-font {
            font-family: 'Playfair Display', serif;
        }

        /* 1. PREMIUM GLASSMORPHIC NAVBAR */
        .navbar-kopi {
            background: rgba(33, 18, 11, 0.94) !important;
            backdrop-filter: blur(12px);
            border-bottom: 3px solid var(--kopi-accent);
            padding: 15px 0;
            transition: all 0.4s ease;
        }

        .navbar-brand {
            font-weight: 800;
            letter-spacing: -0.5px;
            font-size: 1.5rem;
            text-transform: uppercase;
        }

        .badge-meja {
            background: rgba(255, 255, 255, 0.08) !important;
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: var(--kopi-latte) !important;
            font-weight: 700;
            letter-spacing: 0.5px;
            padding: 10px 18px !important;
            border-radius: 14px !important;
        }

        .btn-cart-nav {
            border: 2px solid var(--kopi-latte);
            color: white;
            border-radius: 14px;
            padding: 10px 18px;
            background: transparent;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .btn-cart-nav:hover {
            background-color: var(--kopi-accent);
            border-color: var(--kopi-accent);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(224, 123, 57, 0.3);
        }

        /* 2. ELEGANT HERO BANNER BACKGROUND */
        .hero-banner {
            background: linear-gradient(135deg, #21120B 0%, #3B2314 100%);
            border-radius: 30px;
            padding: 60px 40px;
            color: white;
            margin-bottom: 50px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(33, 18, 11, 0.15);
        }

        .hero-banner::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 400px;
            height: 400px;
            background: rgba(224, 123, 57, 0.1);
            border-radius: 50%;
            filter: blur(80px);
        }

        /* 3. CATEGORY TITLES WITH FLOATING DECORATION */
        .category-container {
            position: relative;
            margin-top: 20px;
        }

        .category-title {
            position: relative;
            font-weight: 800;
            color: var(--kopi-espresso);
            letter-spacing: -0.5px;
            display: inline-block;
            margin-bottom: 35px;
            padding-left: 15px;
            border-left: 4px solid var(--kopi-accent);
        }

        /* 4. PREMIUM CARD & HOVER EFFECTS */
        .card-menu {
            border: none;
            border-radius: 28px;
            background: white;
            overflow: hidden;
            box-shadow: 0 12px 35px rgba(33, 18, 11, 0.02);
            transition: all 0.45s cubic-bezier(0.25, 1, 0.5, 1);
        }

        .card-menu:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(33, 18, 11, 0.09);
        }

        .img-wrapper {
            position: relative;
            overflow: hidden;
            height: 200px;
            background-color: var(--soft-tan);
        }

        .card-img-top {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.8s cubic-bezier(0.25, 1, 0.5, 1);
        }

        .card-menu:hover .card-img-top {
            transform: scale(1.12);
        }

        /* Status Stok Mewah */
        .badge-stok {
            position: absolute;
            top: 15px;
            right: 15px;
            backdrop-filter: blur(6px);
            font-size: 0.75rem;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 30px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .stok-aman {
            background: rgba(25, 135, 84, 0.85);
            color: white;
        }

        .stok-tipis {
            background: rgba(224, 123, 57, 0.85);
            color: white;
        }

        /* Tombol Tambah Dinamis */
        .btn-accent {
            background-color: var(--soft-tan);
            color: var(--kopi-espresso);
            width: 46px;
            height: 46px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            font-size: 1.2rem;
            border-radius: 50% !important;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .card-menu:hover .btn-accent {
            background-color: var(--kopi-accent);
            color: white;
            transform: rotate(180deg) scale(1.05);
            box-shadow: 0 6px 15px rgba(224, 123, 57, 0.35);
        }

        /* Alert Toast Modern */
        .custom-alert {
            border: none;
            border-radius: 20px;
            background: white;
            box-shadow: 0 15px 35px rgba(33, 18, 11, 0.05);
            border-left: 6px solid #198754;
        }
    </style>
</head>
<body>

<!-- Navbar Atas Premium -->
<nav class="navbar navbar-kopi sticky-top shadow-sm animate__animated animate__fadeInDown">
    <div class="container">
        <a class="navbar-brand text-white fw-bold d-flex align-items-center" href="#">
            <i class="bi bi-cup-hot text-warning me-2 animate__animated animate__pulse animate__infinite" style="display: inline-block;"></i> 
            <span style="font-family: 'Playfair Display', serif; text-transform: none; font-weight: 700; letter-spacing: 0;">Artisan Craft</span>
        </a>
        <div class="d-flex align-items-center gap-3">
            <span class="badge badge-meja fs-7">
                <i class="bi bi-tag-fill text-warning me-1"></i> Meja: {{ session('nomor_meja', 'Belum Pilih') }}
            </span>
            <a href="{{ route('cart.index') }}" class="btn btn-cart-nav position-relative d-flex align-items-center justify-content-center">
                <i class="bi bi-bag fs-5"></i>
                @if(session('cart'))
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-white animate__animated animate__bounceIn" style="font-size: 0.65rem; padding: 5px 7px;">
                        {{ count(session('cart')) }}
                    </span>
                @endif
            </a>
        </div>
    </div>
</nav>

<div class="container my-5 py-2">
    
    <!-- Hero Banner Selamat Datang -->
    <div class="hero-banner p-5 animate__animated animate__fadeIn">
        <div class="row align-items-center">
            <div class="col-md-8 text-center text-md-start">
                <span class="text-uppercase tracking-wider text-white-50 fw-semibold small d-block mb-2">Selamat Datang di Ruang Seduh</span>
                <h1 class="display-5 fw-bold mb-3 text-white">Nikmati Cita Rasa Kopi Murni Tradisional</h1>
                <p class="text-white-50 m-0 max-width-500 small">Dipanggang secara presisi oleh Barista berpengalaman untuk menemani setiap cerita berhargamu hari ini.</p>
            </div>
            <div class="col-md-4 text-center d-none d-md-block text-end">
                <i class="bi bi-brightness-high text-white-10 opacity-25" style="font-size: 7rem;"></i>
            </div>
        </div>
    </div>
    
    <!-- Notifikasi Sukses -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show custom-alert p-4 mb-5 animate__animated animate__slideInRight" role="alert">
            <div class="d-flex align-items-center text-dark">
                <div class="bg-success-subtle p-2 rounded-3 me-3 text-success">
                    <i class="bi bi-bag-check-fill fs-4"></i>
                </div>
                <div>
                    <strong class="d-block text-success fs-5">Pesanan Ditambahkan!</strong>
                    <span class="small text-muted">{{ session('success') }}</span>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="top: 24px; right: 20px;"></button>
        </div>
    @endif

    <!-- Menu Loop Section -->
    <div class="row">
        @foreach($kategoris as $kategori)
            @if($kategori->menus->count() > 0)
                
                <!-- Judul Kategori Premium -->
                <div class="col-12 category-container animate__animated animate__fadeInUp">
                    <h2 class="category-title fs-3 text-dark">{{ $kategori->nama_kategori }}</h2>
                </div>
                
                <!-- Grid Cards -->
                <div class="row row-cols-2 row-cols-md-4 g-4 mb-5 animate__animated animate__fadeInUp">
                    @foreach($kategori->menus as $menu)
                        <div class="col">
                            <div class="card h-100 card-menu">
                                <div class="img-wrapper">
                                    <img src="{{ asset('img/' . $menu->foto) }}" class="card-img-top" alt="{{ $menu->nama_menu }}" onerror="this.src='https://placehold.co/500x400?text=Premium+Coffee+Blend'">
                                    
                                    <!-- Logika Visual Status Stok agar Tidak Kaku -->
                                    @if($menu->stok >= 100)
                                        <span class="badge-stok stok-aman"><i class="bi bi-circle-fill text-white opacity-75 small me-1"></i> Ready Stock</span>
                                    @elseif($menu->stok > 0 && $menu->stok < 100)
                                        <span class="badge-stok stok-tipis">Sisa {{ $menu->stok }}</span>
                                    @else
                                        <span class="badge-stok bg-secondary text-white">Sold Out</span>
                                    @endif
                                </div>
                                <div class="card-body d-flex flex-column justify-content-between p-3 p-md-4">
                                    <div>
                                        <h5 class="card-title fw-bold m-0 text-dark fs-6 fs-md-5 text-truncate" title="{{ $menu->nama_menu }}">{{ $menu->nama_menu }}</h5>
                                        <p class="text-muted small m-0 mt-1 d-none d-sm-block" style="font-size: 0.75rem; letter-spacing: 0.3px;">Selected Specialty Roast</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top border-light">
                                        <div>
                                            <span class="text-muted d-block xx-small style="font-size: 0.65rem; text-transform: uppercase; font-weight:700;"">Harga</span>
                                            <span class="fw-bold text-success fs-6 fs-md-5">Rp {{ number_format($menu->harga, 0, ',', '.') }}</span>
                                        </div>
                                        <a href="{{ route('cart.add', $menu->id) }}" class="btn btn-accent shadow-sm">
                                            <i class="bi bi-plus-lg"></i>
                                        </a>
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