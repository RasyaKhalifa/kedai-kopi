<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nine Brew Coffee — Premium Coffee Experience ☕</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;0,800;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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

        h1, h2, h3, .serif-font {
            font-family: 'Playfair Display', serif;
        }

        /* 1. GLASSMORPHIC STICKY NAVBAR */
        .navbar-kopi {
            background: rgba(33, 18, 11, 0.94) !important;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 3px solid var(--kopi-accent);
            padding: 12px 0;
            transition: all 0.4s ease;
        }

        .badge-meja {
            background: rgba(255, 255, 255, 0.08) !important;
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: var(--kopi-latte) !important;
            font-weight: 700;
            padding: 8px 14px !important;
            border-radius: 12px !important;
        }

        .btn-cart-nav {
            border: 2px solid var(--kopi-latte);
            color: white;
            border-radius: 12px;
            padding: 8px 14px;
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

        /* 2. DYNAMIC HERO BANNER */
        .hero-banner {
            background: linear-gradient(135deg, #1f0f08 0%, #3b2214 50%, #543622 100%);
            border-radius: 24px;
            padding: 50px 35px;
            color: white;
            margin-bottom: 40px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(33, 18, 11, 0.18);
            border: 1px solid rgba(212, 178, 140, 0.15);
        }

        /* Floating background pattern icon */
        .floating-bg-icon {
            position: absolute;
            right: 5%;
            bottom: -20px;
            font-size: 11rem;
            color: rgba(255, 255, 255, 0.035);
            transform: rotate(-15deg);
            pointer-events: none;
            transition: all 0.5s ease;
        }
        
        .hero-banner:hover .floating-bg-icon {
            transform: rotate(-25deg) scale(1.05);
            color: rgba(224, 123, 57, 0.05);
        }

        /* 3. BORDER LEFT ACCENT CATEGORIES */
        .category-container {
            position: relative;
            margin-top: 10px;
        }

        .category-title {
            font-weight: 800;
            color: var(--kopi-espresso);
            display: inline-block;
            margin-bottom: 25px;
            padding-left: 15px;
            border-left: 5px solid var(--kopi-accent);
        }

        /* 4. PREMIUM CARD ARCHITECTURE WITH SMOOTH TRANSITION */
        .card-menu {
            border: none;
            border-radius: 20px;
            background: white;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(33, 18, 11, 0.03);
            transition: all 0.4s cubic-bezier(0.25, 1, 0.5, 1);
        }

        .card-menu:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 45px rgba(33, 18, 11, 0.08);
        }

        .img-wrapper {
            position: relative;
            overflow: hidden;
            height: 160px; /* Default mobile height */
            background-color: var(--soft-tan);
        }

        @media (min-width: 768px) {
            .img-wrapper {
                height: 210px; /* Tablet & Desktop height */
            }
        }

        .card-img-top {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.7s cubic-bezier(0.25, 1, 0.5, 1);
        }

        .card-menu:hover .card-img-top {
            transform: scale(1.08);
        }

        /* Status Stock Overlay */
        .badge-stok {
            position: absolute;
            top: 12px;
            right: 12px;
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            font-size: 0.7rem;
            font-weight: 700;
            padding: 5px 12px;
            border-radius: 30px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
            z-index: 2;
        }

        .stok-aman { background: rgba(25, 135, 84, 0.85); color: white; }
        .stok-tipis { background: rgba(224, 123, 57, 0.85); color: white; }

        /* Plus Action Button */
        .btn-accent {
            background-color: var(--soft-tan);
            color: var(--kopi-espresso);
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            font-size: 1rem;
            border-radius: 50% !important;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        @media (min-width: 768px) {
            .btn-accent {
                width: 46px;
                height: 46px;
                font-size: 1.1rem;
            }
        }

        .card-menu:hover .btn-accent {
            background-color: var(--kopi-accent);
            color: white;
            transform: rotate(90deg) scale(1.05);
            box-shadow: 0 6px 15px rgba(224, 123, 57, 0.35);
        }

        /* Toast Alert Smooth Box */
        .custom-alert {
            border: none;
            border-radius: 16px;
            background: white;
            box-shadow: 0 15px 35px rgba(33, 18, 11, 0.05);
            border-left: 6px solid #198754;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-kopi sticky-top shadow-sm animate__animated animate__fadeInDown">
    <div class="container px-3">
        <a class="navbar-brand text-white fw-bold d-flex align-items-center" href="#">
            <i class="bi bi-cup-hot text-warning me-2 animate__animated animate__pulse animate__infinite" style="display: inline-block;"></i> 
            <span style="font-family: 'Playfair Display', serif; text-transform: none; font-weight: 700; letter-spacing: 0;">Nine Brew Coffee</span>
        </a>
        <div class="d-flex align-items-center gap-2 gap-sm-3">
            <span class="badge badge-meja fs-7 small">
                <i class="bi bi-tag-fill text-warning me-1"></i> Meja: {{ session('nomor_meja', 'Belum Pilih') }}
            </span>
            <a href="{{ route('cart.index') }}" class="btn btn-cart-nav position-relative d-flex align-items-center justify-content-center">
                <i class="bi bi-bag fs-5"></i>
                @if(session('cart'))
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-white animate__animated animate__bounceIn" style="font-size: 0.65rem; padding: 4px 6px;">
                        {{ count(session('cart')) }}
                    </span>
                @endif
            </a>
        </div>
    </div>
</nav>

<div class="container my-4 my-md-5 px-3">
    
    <div class="hero-banner p-4 p-md-5 animate__animated animate__fadeIn">
        <div class="row align-items-center">
            <div class="col-md-9 text-center text-md-start">
                <span class="text-uppercase tracking-wider text-white-50 fw-bold small d-block mb-2" style="letter-spacing: 1.5px; color: var(--kopi-latte) !important;">Selamat Datang di Nine Brew Coffee</span>
                <h1 class="display-4 fw-extrabold mb-3 text-white leading-tight" style="font-weight: 800;">Freshly Brewed, <br class="d-none d-md-block">Perfectly Shared.</h1>
                <p class="text-white-50 m-0 small col-lg-9 p-0" style="font-size: 0.95rem; line-height: 1.6; font-weight: 300; color: #f0e6d8 !important;">Dari biji kopi pilihan yang diseduh dengan presisi, hadir untuk menghangatkan setiap percakapan dan cerita berhargamu hari ini.</p>
            </div>
        </div>
        <i class="bi bi-cup-straw floating-bg-icon d-none d-md-block"></i>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show custom-alert p-3 p-md-4 mb-5 animate__animated animate__slideInRight" role="alert">
            <div class="d-flex align-items-center text-dark">
                <div class="bg-success-subtle p-2 rounded-3 me-3 text-success d-flex align-items-center justify-content-center">
                    <i class="bi bi-bag-check-fill fs-4"></i>
                </div>
                <div>
                    <strong class="d-block text-success fs-6">Pesanan Ditambahkan!</strong>
                    <span class="small text-muted" style="font-size: 0.85rem;">{{ session('success') }}</span>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="top: 50%; transform: translateY(-50%); right: 15px;"></button>
        </div>
    @endif

    <div class="row">
        @foreach($kategoris as $kategori)
            @if($kategori->menus->count() > 0)
                
                <div class="col-12 category-container animate__animated animate__fadeInUp">
                    <h2 class="category-title fs-3 text-dark">{{ $kategori->nama_kategori }}</h2>
                </div>
                
                <div class="row row-cols-2 row-cols-md-4 g-3 g-md-4 mb-5 animate__animated animate__fadeInUp">
                    @foreach($kategori->menus as $menu)
                        <div class="col">
                            <div class="card h-100 card-menu">
                                <div class="img-wrapper">
                                    @php
                                        $slugMenu = urlencode(strtolower($menu->nama_menu));
                                        $fallbackImage = "https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=500&auto=format&fit=crop&q=60"; // Default espresso image
                                        if(str_contains($slugMenu, 'latte') || str_contains($slugMenu, 'cappuccino')) {
                                            $fallbackImage = "https://images.unsplash.com/photo-1541167760496-1628856ab772?w=500&auto=format&fit=crop&q=60";
                                        } elseif(str_contains($slugMenu, 'matcha')) {
                                            $fallbackImage = "https://images.unsplash.com/photo-1536256263959-770b48d82b0a?w=500&auto=format&fit=crop&q=60";
                                        } elseif(str_contains($slugMenu, 'ice') || str_contains($slugMenu, 'dingin')) {
                                            $fallbackImage = "https://images.unsplash.com/photo-1517701604599-bb29b565090c?w=500&auto=format&fit=crop&q=60";
                                        }
                                    @endphp

                                    <img src="{{ $menu->foto ? asset('img/' . $menu->foto) : $fallbackImage }}" 
                                         class="card-img-top" 
                                         alt="{{ $menu->nama_menu }}"
                                         loading="lazy">
                                    
                                    @if($menu->stok >= 100)
                                        <span class="badge-stok stok-aman"><i class="bi bi-circle-fill text-white opacity-75 me-1" style="font-size:0.5rem; vertical-align:middle;"></i> Ready</span>
                                    @elseif($menu->stok > 0 && $menu->stok < 100)
                                        <span class="badge-stok stok-tipis">Sisa {{ $menu->stok }}</span>
                                    @else
                                        <span class="badge-stok bg-secondary text-white">Sold Out</span>
                                    @endif
                                </div>
                                
                                <div class="card-body d-flex flex-column justify-content-between p-3">
                                    <div>
                                        <h5 class="card-title fw-bold m-0 text-dark fs-6 fs-md-5 text-truncate" title="{{ $menu->nama_menu }}">{{ $menu->nama_menu }}</h5>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top border-light">
                                        <div>
                                            <span class="text-muted d-block" style="font-size: 0.65rem; text-transform: uppercase; font-weight:700; letter-spacing:0.5px;">Harga</span>
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