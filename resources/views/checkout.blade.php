@extends('layouts.customer')

@section('title', 'Checkout')

@section('content')

{{-- HEADER --}}
<div style="background: linear-gradient(135deg, var(--kopi-espresso) 0%, var(--kopi-medium) 100%); padding: 20px 20px 16px; color: var(--kopi-cream);">
    <a href="{{ route('menu.index', $meja->id) }}"
       style="color: var(--kopi-latte); font-size: .85rem; text-decoration: none;">
        <i class="bi bi-arrow-left"></i> Kembali ke Menu
    </a>
    <div style="font-family: 'Playfair Display', serif; font-size: 1.4rem; font-weight: 700; margin-top: 8px;">
        Konfirmasi Pesanan
    </div>
    <div style="font-size: .82rem; opacity: .75;">Meja {{ $meja->nomor_meja }}</div>
</div>

<div style="padding: 20px;">

    {{-- RINGKASAN PESANAN --}}
    <div class="section-title">Pesanan Kamu</div>

    <div style="background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 2px 8px rgba(44,24,16,.08); margin-bottom: 20px;">
        @foreach($keranjang as $item)
        <div class="d-flex align-items-center gap-3 px-4 py-3 border-bottom">
            <div style="font-size: 1.4rem; width: 36px; text-align:center;">
                {{ str_contains(strtolower($item['nama_menu']), 'kopi') || str_contains(strtolower($item['nama_menu']), 'es') ? '☕' : '🍽️' }}
            </div>
            <div style="flex:1;">
                <div style="font-weight: 600; font-size: .9rem;">{{ $item['nama_menu'] }}</div>
                @if($item['catatan'])
                    <div style="font-size: .75rem; color: #999; font-style: italic;">{{ $item['catatan'] }}</div>
                @endif
            </div>
            <div style="text-align: right;">
                <div style="font-size: .8rem; color: #888;">× {{ $item['qty'] }}</div>
                <div style="font-weight: 700; color: var(--kopi-accent); font-size: .9rem;">
                    Rp {{ number_format($item['harga'] * $item['qty'], 0, ',', '.') }}
                </div>
            </div>
        </div>
        @endforeach

        {{-- TOTAL --}}
        <div class="d-flex justify-content-between align-items-center px-4 py-3" style="background: var(--kopi-cream);">
            <span style="font-weight: 700; font-size: 1rem;">Total Pembayaran</span>
            <span style="font-weight: 700; font-size: 1.1rem; color: var(--kopi-accent);">
                Rp {{ number_format($subtotal, 0, ',', '.') }}
            </span>
        </div>
    </div>

    {{-- FORM DATA PELANGGAN --}}
    <div class="section-title">Data Pemesan</div>

    <form action="{{ route('checkout.simpan') }}" method="POST" id="formCheckout">
        @csrf
        <input type="hidden" name="meja_id" value="{{ $meja->id }}">

        <div style="background: #fff; border-radius: 16px; padding: 20px; box-shadow: 0 2px 8px rgba(44,24,16,.08); margin-bottom: 20px;">

            {{-- Nama --}}
            <div class="mb-3">
                <label style="font-weight: 600; font-size: .85rem; color: var(--kopi-espresso); margin-bottom: 6px; display: block;">
                    Nama Kamu <span style="color: var(--kopi-accent);">*</span>
                </label>
                <input type="text"
                       name="nama_pelanggan"
                       class="form-control @error('nama_pelanggan') is-invalid @enderror"
                       placeholder="Contoh: Budi"
                       value="{{ old('nama_pelanggan') }}"
                       required
                       style="border-radius: 10px; border: 2px solid var(--kopi-cream); padding: 12px 14px; font-size: .9rem;">
                @error('nama_pelanggan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Catatan --}}
            <div class="mb-1">
                <label style="font-weight: 600; font-size: .85rem; color: var(--kopi-espresso); margin-bottom: 6px; display: block;">
                    Catatan Tambahan <span style="font-weight: 400; color: #999;">(opsional)</span>
                </label>
                <textarea name="catatan_umum"
                          class="form-control"
                          rows="3"
                          placeholder="Contoh: gula sedikit, tanpa es, dll."
                          style="border-radius: 10px; border: 2px solid var(--kopi-cream); padding: 12px 14px; font-size: .9rem; resize: none;">{{ old('catatan_umum') }}</textarea>
            </div>
        </div>

        {{-- INFO PEMBAYARAN --}}
        <div style="background: #FFF3CD; border-radius: 12px; padding: 14px 16px; margin-bottom: 24px; border-left: 4px solid #ffc107;">
            <div style="font-weight: 600; font-size: .85rem; color: #856404; margin-bottom: 4px;">
                <i class="bi bi-info-circle-fill me-1"></i> Info Pembayaran
            </div>
            <div style="font-size: .8rem; color: #6c5a00; line-height: 1.5;">
                Pembayaran dilakukan di kasir setelah pesanan selesai. Tunjukkan kode pesanan kamu kepada kasir.
            </div>
        </div>

        {{-- TOMBOL --}}
        <button type="submit" class="btn-kopi" id="btnOrder">
            <i class="bi bi-bag-check-fill me-2"></i>Kirim Pesanan
        </button>
    </form>

</div>
@endsection

@push('scripts')
<script>
document.getElementById('formCheckout').addEventListener('submit', function() {
    const btn = document.getElementById('btnOrder');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mengirim...';
});
</script>
@endpush
