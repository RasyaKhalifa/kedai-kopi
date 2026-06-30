@extends('layouts.customer')

@section('title', 'Menu — Meja ' . $meja->nomor_meja)

@section('with-cart', true)

@section('content')
{{-- HERO BANNER --}}
<div style="background: linear-gradient(135deg, var(--kopi-espresso) 0%, var(--kopi-medium) 100%); padding: 20px 20px 16px; color: var(--kopi-cream);">
    <div style="font-size: .78rem; opacity: .7; margin-bottom: 4px;">
        <i class="bi bi-geo-alt-fill"></i> Meja {{ $meja->nomor_meja }}
    </div>
    <div style="font-family: 'Playfair Display', serif; font-size: 1.4rem; font-weight: 700;">
        Pesan sekarang ☕
    </div>
    <div style="font-size: .82rem; opacity: .75; margin-top: 2px;">
        Pilih menu favorit kamu
    </div>
</div>

{{-- KATEGORI TABS --}}
<div class="kat-tabs" id="katTabs">
    <button class="kat-tab active" onclick="filterKategori('semua', this)">Semua</button>
    @foreach($kategoris as $kat)
        <button class="kat-tab" onclick="filterKategori('kat-{{ $kat->id }}', this)">
            {{ $kat->nama_kategori }}
        </button>
    @endforeach
</div>

{{-- DAFTAR MENU --}}
<div style="padding: 16px;">

    @forelse($kategoris as $kat)
        @if($kat->menus->count() > 0)
        <div class="kategori-section mb-4" data-kat="kat-{{ $kat->id }}">
            <div class="section-title">{{ $kat->nama_kategori }}</div>

            @foreach($kat->menus as $menu)
            @php
                $inCart = isset($keranjang['menu_' . $menu->id]) ? $keranjang['menu_' . $menu->id]['qty'] : 0;
            @endphp
            <div class="menu-card" id="card-{{ $menu->id }}">
                {{-- Foto --}}
                @if($menu->foto)
                    <img src="{{ asset('storage/' . $menu->foto) }}"
                         alt="{{ $menu->nama_menu }}"
                         class="menu-card-img">
                @else
                    <div class="menu-card-img-placeholder">
                        {{ $kat->nama_kategori === 'Minuman' ? '🥤' : '🍽️' }}
                    </div>
                @endif

                {{-- Info --}}
                <div class="menu-card-body">
                    <div>
                        <div class="menu-card-name">{{ $menu->nama_menu }}</div>
                        @if($menu->deskripsi)
                            <div class="menu-card-desc">{{ Str::limit($menu->deskripsi, 60) }}</div>
                        @endif
                    </div>
                    <div class="menu-card-footer">
                        <div class="menu-price">Rp {{ number_format($menu->harga, 0, ',', '.') }}</div>

                        {{-- QTY CONTROL --}}
                        <div class="qty-control" id="qty-ctrl-{{ $menu->id }}">
                            @if($inCart > 0)
                                <button class="qty-btn" onclick="changeQty({{ $menu->id }}, -1)">−</button>
                                <span class="qty-num" id="qty-{{ $menu->id }}">{{ $inCart }}</span>
                                <button class="qty-btn add-btn" onclick="changeQty({{ $menu->id }}, 1)">+</button>
                            @else
                                <button class="qty-btn add-btn" onclick="addToCart({{ $menu->id }}, {{ $meja->id }})">
                                    <i class="bi bi-plus"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    @empty
        <div class="empty-state">
            <i class="bi bi-cup-hot"></i>
            <div>Menu belum tersedia</div>
        </div>
    @endforelse

</div>
@endsection

{{-- KERANJANG OFFCANVAS CONTENT --}}
@section('keranjang-content')
<div id="keranjang-body" style="padding: 16px; overflow-y: auto; max-height: calc(80vh - 120px);">

    @if(count($keranjang) > 0)
        @foreach($keranjang as $key => $item)
        <div class="d-flex align-items-center gap-3 mb-3 pb-3 border-bottom" id="cart-item-{{ $item['menu_id'] }}">
            <div style="font-size: 1.8rem; width: 44px; text-align:center;">
                {{ str_contains(strtolower($item['nama_menu']), 'kopi') || str_contains(strtolower($item['nama_menu']), 'es') ? '☕' : '🍽️' }}
            </div>
            <div class="flex-1" style="flex:1;">
                <div style="font-weight:600; font-size:.9rem;">{{ $item['nama_menu'] }}</div>
                <div style="font-size:.8rem; color: var(--kopi-accent);">
                    Rp {{ number_format($item['harga'], 0, ',', '.') }}
                </div>
            </div>
            <div class="qty-control">
                <button class="qty-btn" onclick="changeQty({{ $item['menu_id'] }}, -1)">−</button>
                <span class="qty-num" id="qty-{{ $item['menu_id'] }}">{{ $item['qty'] }}</span>
                <button class="qty-btn add-btn" onclick="changeQty({{ $item['menu_id'] }}, 1)">+</button>
            </div>
        </div>
        @endforeach

        <div style="margin-top:12px; padding: 12px; background: var(--kopi-cream); border-radius: 12px;">
            <div class="d-flex justify-content-between fw-bold">
                <span>Total</span>
                <span id="subtotal-display" style="color: var(--kopi-accent);">
                    Rp {{ number_format(collect($keranjang)->sum(fn($i) => $i['harga'] * $i['qty']), 0, ',', '.') }}
                </span>
            </div>
        </div>

    @else
        <div class="empty-state" style="padding: 40px 20px;">
            <i class="bi bi-basket2"></i>
            <div>Keranjang masih kosong</div>
            <small>Tambahkan menu favoritmu!</small>
        </div>
    @endif

</div>

{{-- TOMBOL CHECKOUT --}}
<div style="padding: 12px 16px; border-top: 1px solid #eee; background: #fff;">
    @if(count($keranjang) > 0)
        <a href="{{ route('checkout.index', $meja->id) }}" class="btn-kopi text-decoration-none d-block text-center">
            <i class="bi bi-bag-check-fill me-2"></i>Lanjut ke Checkout
        </a>
    @else
        <button class="btn-kopi" disabled>
            <i class="bi bi-basket2 me-2"></i>Keranjang Kosong
        </button>
    @endif
</div>
@endsection

@push('scripts')
<script>
const MEJA_ID = {{ $meja->id }};
let cartCount = {{ $totalKeranjang }};

// Update badge count
function updateBadge(count) {
    cartCount = count;
    const badge = document.getElementById('cart-count');
    const badgeEl = document.querySelector('.badge-count');
    if (badgeEl) badgeEl.textContent = count;
}

// Tambah item baru ke keranjang
async function addToCart(menuId, mejaId) {
    try {
        const res = await fetch('{{ route("keranjang.tambah") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF
            },
            body: JSON.stringify({ menu_id: menuId, meja_id: mejaId })
        });
        const data = await res.json();
        if (data.success) {
            // Ganti tombol + menjadi qty control
            document.getElementById('qty-ctrl-' + menuId).innerHTML = `
                <button class="qty-btn" onclick="changeQty(${menuId}, -1)">−</button>
                <span class="qty-num" id="qty-${menuId}">1</span>
                <button class="qty-btn add-btn" onclick="changeQty(${menuId}, 1)">+</button>
            `;
            updateBadge(data.total);
            showToast('✓ ' + data.message);
        }
    } catch (e) {
        showToast('Gagal menambah item');
    }
}

// Update qty (naik/turun)
async function changeQty(menuId, delta) {
    const qtyEl = document.getElementById('qty-' + menuId);
    if (!qtyEl) return;

    const currentQty = parseInt(qtyEl.textContent) || 0;
    const newQty     = Math.max(0, currentQty + delta);

    // Optimistic UI
    if (newQty === 0) {
        qtyEl.textContent = 0;
    } else {
        qtyEl.textContent = newQty;
    }

    try {
        const res = await fetch('{{ route("keranjang.update") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
            body: JSON.stringify({ menu_id: menuId, qty: newQty })
        });
        const data = await res.json();
        if (data.success) {
            updateBadge(data.total);

            if (newQty === 0) {
                // Ganti kembali jadi tombol +
                document.getElementById('qty-ctrl-' + menuId).innerHTML = `
                    <button class="qty-btn add-btn" onclick="addToCart(${menuId}, ${MEJA_ID})">
                        <i class="bi bi-plus"></i>
                    </button>
                `;
                // Hapus dari cart offcanvas
                const cartItem = document.getElementById('cart-item-' + menuId);
                if (cartItem) cartItem.remove();

                // Update subtotal
                updateSubtotal(data.subtotal);
            } else {
                updateSubtotal(data.subtotal);
                // Update qty di offcanvas juga
                const cartQty = document.querySelectorAll('#qty-' + menuId);
                cartQty.forEach(el => el.textContent = newQty);
            }
        }
    } catch (e) {
        // Revert on error
        qtyEl.textContent = currentQty;
    }
}

function updateSubtotal(subtotal) {
    const el = document.getElementById('subtotal-display');
    if (el && subtotal !== undefined) {
        el.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(subtotal);
    }
}

// Filter kategori
function filterKategori(kat, btn) {
    // Update tab active
    document.querySelectorAll('.kat-tab').forEach(t => t.classList.remove('active'));
    btn.classList.add('active');

    // Show/hide sections
    if (kat === 'semua') {
        document.querySelectorAll('.kategori-section').forEach(s => s.style.display = '');
    } else {
        document.querySelectorAll('.kategori-section').forEach(s => {
            s.style.display = s.dataset.kat === kat ? '' : 'none';
        });
    }
}
</script>
@endpush
