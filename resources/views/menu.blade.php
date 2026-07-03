@extends('layouts.customer')

@section('title', 'Menu — Meja ' . $meja->nomor_meja)

@section('with-cart', true)

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
    /* Premium Architecture Colors */
    :root {
        --kopi-espresso: #21120B;
        --kopi-medium: #543A20;
        --kopi-latte: #D4B28C;
        --kopi-accent: #E07B39;
        --bg-creme: #FAF6F0;
        --soft-tan: #F0E6D8;
    }

    /* 1. PREMIUM DYNAMIC HERO BANNER */
    .hero-premium-banner {
        background: linear-gradient(135deg, #1f0f08 0%, #3b2214 50%, #543622 100%);
        padding: 45px 28px;
        color: #FAF6F0;
        border-radius: 0 0 32px 32px;
        box-shadow: 0 15px 35px rgba(33, 18, 11, 0.18);
        position: relative;
        overflow: hidden;
        border-bottom: 2px solid rgba(212, 178, 140, 0.15);
    }

    .hero-premium-banner::after {
        content: '☕';
        position: absolute;
        right: 5%;
        bottom: -25px;
        font-size: 9rem;
        opacity: 0.04;
        transform: rotate(-15deg);
        pointer-events: none;
        transition: all 0.5s ease;
    }
    
    .hero-premium-banner:hover::after {
        transform: rotate(-25deg) scale(1.05);
        opacity: 0.06;
    }

    /* 2. SMOOTH HORIZONTAL SCROLL FOR TABS */
    .kat-tabs-premium {
        display: flex;
        gap: 12px;
        overflow-x: auto;
        padding: 24px 16px 12px;
        scroll-behavior: smooth;
        scrollbar-width: none;
    }

    .kat-tabs-premium::-webkit-scrollbar {
        display: none;
    }

    .kat-tab-modern {
        background: white;
        color: var(--kopi-espresso);
        border: 1px solid var(--soft-tan);
        padding: 10px 24px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 0.88rem;
        white-space: nowrap;
        transition: all 0.4s cubic-bezier(0.25, 1, 0.5, 1);
        box-shadow: 0 4px 12px rgba(33, 18, 11, 0.02);
    }

    .kat-tab-modern.active {
        background: var(--kopi-accent);
        color: white;
        border-color: var(--kopi-accent);
        box-shadow: 0 8px 20px rgba(224, 123, 57, 0.35);
        transform: translateY(-2px);
    }

    /* 3. BORDER ACCENT CATEGORY TITLES */
    .section-title-modern {
        font-family: 'Playfair Display', serif;
        font-weight: 800;
        color: var(--kopi-espresso);
        font-size: 1.5rem;
        padding-left: 14px;
        border-left: 5px solid var(--kopi-accent);
        margin-bottom: 24px;
    }

    /* 4. PREMIUM COMPACT CARD DESIGN */
    .menu-card-modern {
        background: white;
        border: none;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(33, 18, 11, 0.03);
        transition: all 0.4s cubic-bezier(0.25, 1, 0.5, 1);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
    }

    .menu-card-modern:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 45px rgba(33, 18, 11, 0.08);
    }

    .img-container-modern {
        position: relative;
        height: 140px;
        overflow: hidden;
        background: var(--soft-tan);
    }

    @media(min-width: 768px) {
        .img-container-modern {
            height: 200px;
        }
    }

    .menu-img-fluid {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.7s cubic-bezier(0.25, 1, 0.5, 1);
    }

    .menu-card-modern:hover .menu-img-fluid {
        transform: scale(1.08);
    }

    /* 5. INTERACTIVE QUANTITY CONTROL */
    .qty-btn-premium {
        width: 36px;
        height: 36px;
        border-radius: 50% !important;
        background: var(--soft-tan);
        color: var(--kopi-espresso);
        border: none;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .qty-btn-premium.add-btn-premium {
        background: var(--kopi-espresso);
        color: white;
    }

    .menu-card-modern:hover .qty-btn-premium.add-btn-premium {
        background: var(--kopi-accent);
        box-shadow: 0 6px 15px rgba(224, 123, 57, 0.35);
    }

    .qty-btn-premium:active {
        transform: scale(0.85);
    }

    .qty-num {
        font-size: 0.95rem;
        min-width: 16px;
        text-align: center;
    }
</style>

{{-- HERO BANNER --}}
<div class="hero-premium-banner animate__animated animate__fadeIn">
    <div class="d-flex align-items-center gap-2 mb-2" style="font-size: 0.85rem; opacity: 0.85; font-weight: 600; color: var(--kopi-latte);">
        <i class="bi bi-geo-alt-fill text-warning"></i> 
        <span>Nine Brew Coffee — Meja {{ $meja->nomor_meja }}</span>
    </div>
    <h1 class="display-6 fw-bold mb-2" style="font-family: 'Playfair Display', serif; font-weight: 800;">Freshly Brewed, Perfectly Shared.</h1>
    <p class="m-0 small opacity-75" style="line-height: 1.5; font-weight: 300; max-width: 550px;">Dari biji kopi pilihan yang diseduh dengan presisi, hadir untuk menghangatkan setiap percakapan dan cerita berhargamu hari ini.</p>
</div>

{{-- KATEGORI TABS --}}
<div class="kat-tabs-premium animate__animated animate__fadeInUp">
    <button class="kat-tab-modern active" onclick="filterKategori('semua', this)">Semua Menu</button>
    @foreach($kategoris as $kat)
        <button class="kat-tab-modern" onclick="filterKategori('kat-{{ $kat->id }}', this)">
            {{ $kat->nama_kategori }}
        </button>
    @endforeach
</div>

{{-- DAFTAR MENU --}}
<div class="container-fluid px-3 py-3">

    @forelse($kategoris as $kat)
        @if($kat->menus->count() > 0)
        <div class="kategori-section mb-5 animate__animated animate__fadeInUp" data-kat="kat-{{ $kat->id }}">
            <h3 class="section-title-modern">{{ $kat->nama_kategori }}</h3>

            <div class="row row-cols-2 row-cols-md-4 g-3 g-md-4">
                @foreach($kat->menus as $menu)
                @php
                    $inCart = isset($keranjang['menu_' . $menu->id]) ? $keranjang['menu_' . $menu->id]['qty'] : 0;
                    
                    $slugMenu = strtolower($menu->nama_menu);
                    $fallbackImage = "https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=500&auto=format&fit=crop&q=60";
                    if(str_contains($slugMenu, 'latte') || str_contains($slugMenu, 'cappuccino') || str_contains($slugMenu, 'susu')) {
                        $fallbackImage = "https://images.unsplash.com/photo-1541167760496-1628856ab772?w=500&auto=format&fit=crop&q=60";
                    } elseif(str_contains($slugMenu, 'matcha') || str_contains($slugMenu, 'hijau')) {
                        $fallbackImage = "https://images.unsplash.com/photo-1536256263959-770b48d82b0a?w=500&auto=format&fit=crop&q=60";
                    } elseif(str_contains($slugMenu, 'ice') || str_contains($slugMenu, 'dingin') || str_contains($slugMenu, 'tea') || str_contains($slugMenu, 'americano')) {
                        $fallbackImage = "https://images.unsplash.com/photo-1517701604599-bb29b565090c?w=500&auto=format&fit=crop&q=60";
                    } elseif($kat->nama_kategori === 'Makanan' || str_contains($slugMenu, 'toast') || str_contains($slugMenu, 'snack') || str_contains($slugMenu, 'goreng') || str_contains($slugMenu, 'fries')) {
                        $fallbackImage = "https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=500&auto=format&fit=crop&q=60";
                    }
                @endphp
                
                <div class="col">
                    <div class="card menu-card-modern h-100" id="card-{{ $menu->id }}">
                        
                        {{-- Foto Container (Sudah diperbaiki menggunakan helper asset Laravel) --}}
                        <div class="img-container-modern">
                            <img src="{{ asset('image/' . $menu->foto) }}"
                                 alt="{{ $menu->nama_menu }}"
                                 class="menu-img-fluid"
                                 loading="lazy"
                                 onerror="this.onerror=null; this.src='{{ $fallbackImage }}';">
                        </div>

                     {{-- Info Body --}}
<div class="p-3 d-flex flex-column justify-content-between flex-grow-1">
    <div class="mb-2">
        <div class="fw-bold text-dark text-truncate fs-6 mb-1" title="{{ $menu->nama_menu }}">
            {{ $menu->nama_menu }}
        </div>
        
        @php
            $slug = strtolower($menu->nama_menu);
            // Logika deskripsi dinamis
            $desk = $menu->deskripsi;
            if (!$desk) {
                if (str_contains($slug, 'espresso')) $desk = "Bold & intense, the soul of coffee.";
                elseif (str_contains($slug, 'latte') || str_contains($slug, 'susu')) $desk = "Velvety smooth, creamy perfection.";
                elseif (str_contains($slug, 'americano')) $desk = "Crisp, clean, and perfectly balanced.";
                elseif (str_contains($slug, 'matcha')) $desk = "Premium earthy green tea goodness.";
                elseif (str_contains($slug, 'ice') || str_contains($slug, 'dingin')) $desk = "Chilled to keep you refreshed.";
                elseif (str_contains($slug, 'toast') || str_contains($slug, 'goreng')) $desk = "Crispy, savory, and cooked to order.";
                else $desk = "Crafted with passion for every sip.";
            }
        @endphp

        <div class="text-muted small text-truncate-2" style="font-size: 0.78rem; height: 34px; line-height: 1.3;">
            {{ Str::limit($desk, 50) }}
        </div>
    </div>
    
    {{-- Footer Card --}}
    <div class="d-flex justify-content-between align-items-center pt-2 border-top border-light mt-2">
        <div class="fw-bold text-success" style="font-size: 0.95rem;">
            Rp {{ number_format($menu->harga, 0, ',', '.') }}
        </div>
                                {{-- QTY CONTROL AJAX ENGINE --}}
                                <div class="qty-control d-flex align-items-center gap-2" id="qty-ctrl-{{ $menu->id }}">
                                    @if($inCart > 0)
                                        <button class="qty-btn-premium" onclick="changeQty({{ $menu->id }}, -1)">−</button>
                                        <span class="qty-num fw-bold px-1" id="qty-{{ $menu->id }}">{{ $inCart }}</span>
                                        <button class="qty-btn-premium add-btn-premium" onclick="changeQty({{ $menu->id }}, 1)">+</button>
                                    @else
                                        <button class="qty-btn-premium add-btn-premium" onclick="addToCart({{ $menu->id }}, {{ $meja->id }})">
                                            <i class="bi bi-plus-lg"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    @empty
        <div class="text-center py-5 text-muted animate__animated animate__fadeIn">
            <i class="bi bi-cup-hot display-3 d-block mb-3 opacity-25"></i>
            <div class="fw-bold">Menu Belum Tersedia</div>
            <small>Silakan hubungi kasir atau pelayan untuk info menu hari ini.</small>
        </div>
    @endforelse

</div>
@endsection

{{-- KERANJANG OFFCANVAS CONTENT --}}
@section('keranjang-content')
<div id="keranjang-body" style="padding: 16px; overflow-y: auto; max-height: calc(80vh - 120px);">

    @if(count($keranjang) > 0)
        @foreach($keranjang as $key => $item)
        <div class="d-flex align-items-center gap-3 mb-3 pb-3 border-bottom animate__animated animate__fadeIn" id="cart-item-{{ $item['menu_id'] }}">
            <div style="font-size: 1.8rem; width: 44px; text-align:center;">
                {{ str_contains(strtolower($item['nama']), 'kopi') || str_contains(strtolower($item['nama']), 'es') ? '☕' : '🍽️' }}
            </div>
            <div class="flex-grow-1">
                <div class="fw-bold" style="font-size:.9rem; color: var(--kopi-espresso);">{{ $item['nama'] }}</div>
                <div style="font-size:.8rem; color: var(--kopi-accent); font-weight: 600;">
                    Rp {{ number_format($item['harga'], 0, ',', '.') }}
                </div>
            </div>
            <div class="qty-control d-flex align-items-center gap-2">
                <button class="qty-btn-premium" style="width:30px; height:30px;" onclick="changeQty({{ $item['menu_id'] }}, -1)">−</button>
                <span class="qty-num fw-bold" id="qty-{{ $item['menu_id'] }}">{{ $item['qty'] }}</span>
                <button class="qty-btn-premium add-btn-premium" style="width:30px; height:30px;" onclick="changeQty({{ $item['menu_id'] }}, 1)">+</button>
            </div>
        </div>
        @endforeach

        <div class="p-3 shadow-sm border border-light mt-4 animate__animated animate__pulse" style="background: #FFF; border-radius: 16px;">
            <div class="d-flex justify-content-between align-items-center fw-bold">
                <span class="text-muted small text-uppercase">Total Transaksi</span>
                <span id="subtotal-display" class="fs-5 text-success">
                    Rp {{ number_format(collect($keranjang)->sum(fn($i) => $i['harga'] * $i['qty']), 0, ',', '.') }}
                </span>
            </div>
        </div>

    @else
        <div class="text-center py-5 text-muted animate__animated animate__fadeIn">
            <i class="bi bi-basket2 text-muted opacity-25 display-4 d-block mb-2"></i>
            <div class="fw-semibold">Keranjang Masih Kosong</div>
            <small class="text-muted-50 d-block">Pilih menu premium di atas untuk memulai pesanan.</small>
        </div>
    @endif

</div>

{{-- TOMBOL CHECKOUT INTERAKTIF --}}
<div class="p-3 border-top bg-white">
    @if(count($keranjang) > 0)
        <a href="{{ route('tracking.index', $meja->id) }}" class="btn w-100 py-3 border-0 text-white fw-bold shadow-sm d-block text-center rounded-pill animate__animated animate__pulse animate__infinite" style="background: var(--kopi-accent); font-size: 0.95rem;">
            <i class="bi bi-bag-check-fill me-2"></i>Lanjut Ke Checkout
        </a>
    @else
        <button class="btn btn-secondary w-100 py-3 border-0 rounded-pill fw-semibold opacity-50" disabled>
            <i class="bi bi-basket2 me-2"></i>Keranjang Kosong
        </button>
    @endif
</div>
@endsection

@push('scripts')
<script>
const MEJA_ID = {{ $meja->id }};
let cartCount = {{ count(session('keranjang', [])) }};

function updateBadge(count) {
    cartCount = count;
    const badgeEl = document.querySelector('.badge-count');
    if (badgeEl) badgeEl.textContent = count;
}

async function addToCart(menuId, mejaId) {
    try {
        const res = await fetch('{{ route("keranjang.tambah") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: JSON.stringify({ menu_id: menuId, meja_id: mejaId })
        });
        const data = await res.json();
        if (data.message) {
            document.getElementById('qty-ctrl-' + menuId).innerHTML = `
                <button class="qty-btn-premium" onclick="changeQty(${menuId}, -1)">−</button>
                <span class="qty-num fw-bold px-1" id="qty-${menuId}">1</span>
                <button class="qty-btn-premium add-btn-premium" onclick="changeQty(${menuId}, 1)">+</button>
            `;
            updateBadge(data.total);
            if(typeof showToast === "function") showToast('✓ ' + data.message);
            
            if(cartCount === 1) { location.reload(); }
        }
    } catch (e) {
        console.error('Error adding element:', e);
    }
}

async function changeQty(menuId, delta) {
    const qtyEl = document.getElementById('qty-' + menuId);
    if (!qtyEl) return;

    const currentQty = parseInt(qtyEl.textContent) || 0;
    const newQty     = Math.max(0, currentQty + delta);

    qtyEl.textContent = newQty;

    try {
        const res = await fetch('{{ route("keranjang.tambah") }}', {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json', 
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '' 
            },
            body: JSON.stringify({ menu_id: menuId, meja_id: MEJA_ID })
        });
        const data = await res.json();
        if (data.total !== undefined) {
            updateBadge(data.total);

            if (newQty === 0) {
                document.getElementById('qty-ctrl-' + menuId).innerHTML = `
                    <button class="qty-btn-premium add-btn-premium" onclick="addToCart(${menuId}, ${MEJA_ID})">
                        <i class="bi bi-plus-lg"></i>
                    </button>
                `;
                const cartItem = document.getElementById('cart-item-' + menuId);
                if (cartItem) cartItem.remove();
                
                if(data.total === 0) { location.reload(); }
            } else {
                const cartQty = document.querySelectorAll('#qty-' + menuId);
                cartQty.forEach(el => el.textContent = newQty);
            }
            
            if (data.subtotal) { updateSubtotal(data.subtotal); }
        }
    } catch (e) {
        qtyEl.textContent = currentQty;
    }
}

function updateSubtotal(subtotal) {
    const el = document.getElementById('subtotal-display');
    if (el && subtotal !== undefined) {
        el.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(subtotal);
    }
}

function filterKategori(kat, btn) {
    document.querySelectorAll('.kat-tab-modern').forEach(t => t.classList.remove('active'));
    btn.classList.add('active');

    if (kat === 'semua') {
        document.querySelectorAll('.kategori-section').forEach(s => {
            s.style.display = '';
            s.classList.add('animate__animated', 'animate__fadeInUp');
        });
    } else {
        document.querySelectorAll('.kategori-section').forEach(s => {
            if (s.dataset.kat === kat) {
                s.style.display = '';
                s.classList.add('animate__animated', 'animate__fadeInUp');
            } else {
                s.style.display = 'none';
            }
        });
    }
}
</script>
@endpush