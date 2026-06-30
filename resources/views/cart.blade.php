@extends('layouts.app')

@section('title', 'Keranjang - Kedai Kopi')
@section('header', 'Keranjang')
@section('back', route('menu.show', $meja->id ?? 1))

@section('content')

@if(empty($keranjang))
    <div style="text-align:center;padding:60px 0;">
        <div style="font-size:3rem;margin-bottom:10px;">🛒</div>
        <p class="muted">Keranjangmu masih kosong.</p>
        <a href="{{ route('menu.show', $meja->id ?? 1) }}" class="btn" style="margin-top:16px;">Lihat Menu</a>
    </div>
@else
    <div style="display:flex;flex-direction:column;gap:12px;">
        @foreach($keranjang as $itemId => $item)
            <div class="card" style="display:flex;gap:12px;align-items:center;">
                <img src="{{ $item['gambar'] ? asset('storage/'.$item['gambar']) : 'https://via.placeholder.com/70' }}"
                     style="width:64px;height:64px;border-radius:10px;object-fit:cover;">

                <div style="flex:1;">
                    <h4>{{ $item['nama'] }}</h4>
                    <span class="muted">Rp{{ number_format($item['harga'], 0, ',', '.') }}</span>
                </div>

                {{-- Ubah jumlah --}}
                <form action="{{ route('cart.update') }}" method="POST" style="display:flex;align-items:center;gap:8px;">
                    @csrf
                    <input type="hidden" name="menu_id" value="{{ $itemId }}">
                    <button type="submit" name="aksi" value="kurang"
                            class="btn-outline" style="width:30px;height:30px;border-radius:8px;border-color:rgba(255,255,255,0.2);color:#fff;">-</button>
                    <span style="min-width:18px;text-align:center;">{{ $item['qty'] }}</span>
                    <button type="submit" name="aksi" value="tambah"
                            class="btn-outline" style="width:30px;height:30px;border-radius:8px;border-color:rgba(255,255,255,0.2);color:#fff;">+</button>
                </form>
            </div>
        @endforeach
    </div>

    <div class="card" style="margin-top:18px;">
        <label class="muted" style="display:block;margin-bottom:6px;">Catatan untuk dapur (opsional)</label>
        <form action="{{ route('cart.catatan') }}" method="POST">
            @csrf
            <textarea name="catatan" rows="2" placeholder="Contoh: gula sedikit, pedas sedang..."
                style="width:100%;padding:10px;border-radius:10px;border:1px solid rgba(255,255,255,0.15);
                       background:rgba(0,0,0,0.25);color:var(--text-light);margin-bottom:10px;">{{ session('catatan') }}</textarea>
            <button type="submit" class="btn btn-outline" style="width:100%;">Simpan Catatan</button>
        </form>
    </div>

    <div class="card" style="margin-top:18px;">
        <div style="display:flex;justify-content:space-between;margin-bottom:6px;">
            <span class="muted">Subtotal</span>
            <span>Rp{{ number_format($total, 0, ',', '.') }}</span>
        </div>
        <div style="display:flex;justify-content:space-between;font-weight:bold;font-size:1.1rem;">
            <span>Total</span>
            <span style="color:var(--accent-light);">Rp{{ number_format($total, 0, ',', '.') }}</span>
        </div>
    </div>
@endif
@endsection

@section('bottom')
    @if(!empty($keranjang))
        <div class="bottom-cart-bar">
            <span class="muted">Total: Rp{{ number_format($total, 0, ',', '.') }}</span>
            <a href="{{ route('checkout.show') }}" class="btn btn-block">Checkout</a>
        </div>
    @endif
@endsection
