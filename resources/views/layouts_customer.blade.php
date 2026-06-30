<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Kedai Kopi') ☕</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --kopi-espresso:  #2C1810;
            --kopi-dark:      #3D2314;
            --kopi-medium:    #6F4E37;
            --kopi-latte:     #C9A87C;
            --kopi-cream:     #F5EDD6;
            --kopi-milk:      #FDF6EC;
            --kopi-accent:    #E07B39;
            --kopi-green:     #4A7C59;
            --kopi-red:       #C0392B;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--kopi-milk);
            color: var(--kopi-espresso);
            min-height: 100vh;
        }

        /* ── TOP BAR ── */
        .topbar {
            background: var(--kopi-espresso);
            color: var(--kopi-cream);
            padding: 12px 20px;
            position: sticky;
            top: 0;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 12px rgba(44,24,16,.4);
        }

        .topbar-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            font-weight: 700;
            letter-spacing: .03em;
        }

        .topbar-brand span { color: var(--kopi-latte); }

        .topbar-meja {
            font-size: .78rem;
            background: var(--kopi-medium);
            padding: 4px 10px;
            border-radius: 20px;
            color: var(--kopi-cream);
        }

        /* ── CART BUTTON ── */
        .btn-cart {
            background: var(--kopi-accent);
            color: #fff;
            border: none;
            border-radius: 24px;
            padding: 8px 18px;
            font-weight: 600;
            font-size: .85rem;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: background .2s;
            position: relative;
        }
        .btn-cart:hover { background: #c96a28; color: #fff; }
        .btn-cart .badge-count {
            background: #fff;
            color: var(--kopi-accent);
            border-radius: 50%;
            width: 20px; height: 20px;
            display: flex; align-items: center; justify-content: center;
            font-size: .7rem; font-weight: 700;
        }

        /* ── CONTENT WRAP ── */
        .content-wrap {
            max-width: 540px;
            margin: 0 auto;
            padding: 0 0 120px;
        }

        /* ── SECTION TITLE ── */
        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--kopi-espresso);
            margin-bottom: 12px;
            padding-bottom: 6px;
            border-bottom: 2px solid var(--kopi-latte);
        }

        /* ── MENU CARD ── */
        .menu-card {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(44,24,16,.08);
            display: flex;
            align-items: stretch;
            margin-bottom: 12px;
            transition: box-shadow .2s;
        }
        .menu-card:hover { box-shadow: 0 4px 16px rgba(44,24,16,.15); }

        .menu-card-img {
            width: 100px;
            min-height: 100px;
            object-fit: cover;
            flex-shrink: 0;
        }
        .menu-card-img-placeholder {
            width: 100px;
            min-height: 100px;
            background: var(--kopi-cream);
            display: flex; align-items: center; justify-content: center;
            font-size: 2rem; flex-shrink: 0;
        }

        .menu-card-body {
            padding: 12px 14px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .menu-card-name {
            font-weight: 600;
            font-size: .95rem;
            margin-bottom: 3px;
        }

        .menu-card-desc {
            font-size: .78rem;
            color: #888;
            margin-bottom: 8px;
            line-height: 1.4;
        }

        .menu-card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .menu-price {
            font-weight: 700;
            color: var(--kopi-accent);
            font-size: .95rem;
        }

        /* ── QTY CONTROL ── */
        .qty-control {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .qty-btn {
            width: 28px; height: 28px;
            border-radius: 50%;
            border: 2px solid var(--kopi-medium);
            background: transparent;
            color: var(--kopi-medium);
            font-size: 1rem;
            line-height: 1;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            transition: all .15s;
            font-weight: 700;
        }
        .qty-btn:hover, .qty-btn.active {
            background: var(--kopi-medium);
            color: #fff;
        }
        .qty-btn.add-btn {
            background: var(--kopi-medium);
            color: #fff;
        }
        .qty-btn.add-btn:hover { background: var(--kopi-espresso); }

        .qty-num {
            font-weight: 700;
            font-size: .9rem;
            min-width: 18px;
            text-align: center;
        }

        /* ── BADGE STATUS ── */
        .badge-pending  { background: #FFF3CD; color: #856404; }
        .badge-memasak  { background: #FFF0E0; color: #c96a28; }
        .badge-selesai  { background: #D1FAE5; color: #065F46; }
        .badge-dibayar  { background: #DBEAFE; color: #1E40AF; }
        .badge-batal    { background: #FEE2E2; color: #991B1B; }

        /* ── BOTTOM SHEET CART ── */
        .offcanvas-cart .offcanvas-header {
            background: var(--kopi-espresso);
            color: var(--kopi-cream);
        }
        .offcanvas-cart .offcanvas-header .btn-close {
            filter: invert(1);
        }

        /* ── BTN PRIMARY ── */
        .btn-kopi {
            background: var(--kopi-espresso);
            color: var(--kopi-cream);
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 600;
            font-size: .95rem;
            width: 100%;
            transition: background .2s;
        }
        .btn-kopi:hover { background: var(--kopi-dark); color: var(--kopi-cream); }
        .btn-kopi:disabled { background: #aaa; }

        .btn-kopi-outline {
            background: transparent;
            color: var(--kopi-espresso);
            border: 2px solid var(--kopi-espresso);
            border-radius: 12px;
            padding: 10px 24px;
            font-weight: 600;
            font-size: .95rem;
            width: 100%;
            transition: all .2s;
        }
        .btn-kopi-outline:hover { background: var(--kopi-espresso); color: #fff; }

        /* ── TRACKING TIMELINE ── */
        .timeline { position: relative; padding-left: 32px; }
        .timeline::before {
            content: '';
            position: absolute;
            left: 12px; top: 0; bottom: 0;
            width: 2px;
            background: var(--kopi-cream);
        }
        .timeline-item { position: relative; margin-bottom: 24px; }
        .timeline-dot {
            position: absolute;
            left: -26px; top: 2px;
            width: 20px; height: 20px;
            border-radius: 50%;
            background: var(--kopi-cream);
            border: 3px solid var(--kopi-latte);
            display: flex; align-items: center; justify-content: center;
        }
        .timeline-dot.active {
            background: var(--kopi-accent);
            border-color: var(--kopi-accent);
        }
        .timeline-dot.done {
            background: var(--kopi-green);
            border-color: var(--kopi-green);
        }
        .timeline-dot i { font-size: .65rem; color: #fff; }

        .timeline-label {
            font-weight: 600;
            font-size: .9rem;
        }
        .timeline-sub {
            font-size: .78rem;
            color: #888;
        }

        /* ── KATEGORI TABS ── */
        .kat-tabs {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            padding: 12px 16px;
            scrollbar-width: none;
            background: #fff;
            border-bottom: 1px solid var(--kopi-cream);
            position: sticky;
            top: 56px;
            z-index: 100;
        }
        .kat-tabs::-webkit-scrollbar { display: none; }
        .kat-tab {
            background: var(--kopi-cream);
            border: none;
            border-radius: 20px;
            padding: 6px 16px;
            font-size: .82rem;
            font-weight: 500;
            color: var(--kopi-medium);
            white-space: nowrap;
            cursor: pointer;
            transition: all .2s;
        }
        .kat-tab.active, .kat-tab:hover {
            background: var(--kopi-espresso);
            color: var(--kopi-cream);
        }

        /* ── EMPTY STATE ── */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #bbb;
        }
        .empty-state i { font-size: 3rem; margin-bottom: 12px; display: block; }

        /* ── TOAST ── */
        .toast-container { z-index: 2000; }

        @media (min-width: 541px) {
            .content-wrap { border-left: 1px solid #eee; border-right: 1px solid #eee; }
        }
    </style>

    @stack('styles')
</head>
<body>

{{-- TOP BAR --}}
<div class="topbar">
    <div class="topbar-brand">☕ Kedai <span>Kopi</span></div>

    <div class="d-flex align-items-center gap-2">
        @if(session('nomor_meja'))
            <div class="topbar-meja">
                <i class="bi bi-geo-alt-fill"></i> Meja {{ session('nomor_meja') }}
            </div>
        @endif

        @if(isset($totalKeranjang) && $totalKeranjang > 0)
            <button class="btn-cart" data-bs-toggle="offcanvas" data-bs-target="#offcanvasKeranjang">
                <i class="bi bi-basket2-fill"></i>
                <span class="badge-count">{{ $totalKeranjang }}</span>
            </button>
        @elseif(isset($meja))
            <button class="btn-cart" data-bs-toggle="offcanvas" data-bs-target="#offcanvasKeranjang">
                <i class="bi bi-basket2-fill"></i>
                <span class="badge-count" id="cart-count">0</span>
            </button>
        @endif
    </div>
</div>

{{-- FLASH MESSAGE --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
        <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- MAIN CONTENT --}}
<div class="content-wrap">
    @yield('content')
</div>

{{-- OFFCANVAS KERANJANG --}}
@hasSection('with-cart')
<div class="offcanvas offcanvas-bottom offcanvas-cart" tabindex="-1" id="offcanvasKeranjang" style="height: 80vh; border-radius: 20px 20px 0 0;">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title fw-bold">
            <i class="bi bi-basket2 me-2"></i>Keranjang Saya
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-0">
        @yield('keranjang-content')
    </div>
</div>
@endif

{{-- TOAST NOTIFICATION --}}
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="toastNotif" class="toast align-items-center border-0" role="alert" style="background: var(--kopi-espresso); color: var(--kopi-cream);">
        <div class="d-flex">
            <div class="toast-body fw-500" id="toastMsg">–</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>

{{-- Bootstrap 5 JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const CSRF = document.querySelector('meta[name="csrf-token"]')?.content;

    function showToast(msg) {
        document.getElementById('toastMsg').textContent = msg;
        new bootstrap.Toast(document.getElementById('toastNotif'), { delay: 2500 }).show();
    }
</script>

@stack('scripts')
</body>
</html>
