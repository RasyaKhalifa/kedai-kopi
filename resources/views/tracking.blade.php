@extends('layouts.customer')

@section('title', 'Tracking — ' . $pesanan->kode_pesanan)

@section('content')

{{-- HEADER --}}
<div style="background: linear-gradient(135deg, var(--kopi-espresso) 0%, var(--kopi-medium) 100%); padding: 24px 20px 20px; color: var(--kopi-cream); text-align: center;">
    <div style="font-family: 'Playfair Display', serif; font-size: 1.4rem; font-weight: 700; margin-bottom: 4px;">
        Status Pesanan
    </div>
    <div style="font-size: .8rem; opacity: .7; margin-bottom: 12px;">Meja {{ $pesanan->meja->nomor_meja }}</div>

    {{-- KODE PESANAN --}}
    <div style="background: rgba(255,255,255,.12); border-radius: 12px; padding: 10px 20px; display: inline-block;">
        <div style="font-size: .72rem; opacity: .7; margin-bottom: 2px; letter-spacing: .08em;">KODE PESANAN</div>
        <div style="font-size: 1.1rem; font-weight: 700; letter-spacing: .15em; font-family: monospace;">
            {{ $pesanan->kode_pesanan }}
        </div>
    </div>
</div>

<div style="padding: 20px;">

    {{-- STATUS BADGE --}}
    @php
        $statusMap = [
            'pending'  => ['label' => 'Menunggu Konfirmasi', 'icon' => 'hourglass-split',    'class' => 'badge-pending'],
            'memasak'  => ['label' => 'Sedang Dimasak',      'icon' => 'fire',                'class' => 'badge-memasak'],
            'selesai'  => ['label' => 'Siap Disajikan',      'icon' => 'check-circle-fill',   'class' => 'badge-selesai'],
            'dibayar'  => ['label' => 'Lunas',               'icon' => 'receipt-cutoff',      'class' => 'badge-dibayar'],
            'batal'    => ['label' => 'Dibatalkan',          'icon' => 'x-circle-fill',       'class' => 'badge-batal'],
        ];
        $s = $statusMap[$pesanan->status] ?? $statusMap['pending'];
    @endphp

    <div style="text-align: center; margin-bottom: 28px;">
        <div class="d-inline-flex align-items-center gap-2 px-4 py-2 rounded-pill {{ $s['class'] }}"
             style="font-size: 1rem; font-weight: 700; border-radius: 30px !important; padding: 10px 24px !important;">
            <i class="bi bi-{{ $s['icon'] }}"></i>
            {{ $s['label'] }}
        </div>
    </div>

    {{-- TIMELINE STATUS --}}
    <div class="section-title">Perjalanan Pesanan</div>
    <div class="timeline mb-4">

        {{-- PENDING --}}
        <div class="timeline-item">
            <div class="timeline-dot {{ in_array($pesanan->status, ['pending','memasak','selesai','dibayar']) ? 'done' : '' }}">
                <i class="bi bi-check"></i>
            </div>
            <div class="timeline-label">Pesanan Diterima</div>
            <div class="timeline-sub">Pesananmu sudah masuk ke dapur</div>
        </div>

        {{-- MEMASAK --}}
        <div class="timeline-item">
            <div class="timeline-dot
                {{ $pesanan->status === 'memasak' ? 'active' : '' }}
                {{ in_array($pesanan->status, ['selesai','dibayar']) ? 'done' : '' }}">
                <i class="bi bi-{{ $pesanan->status === 'memasak' ? 'fire' : 'check' }}"></i>
            </div>
            <div class="timeline-label" style="{{ $pesanan->status === 'pending' ? 'color:#bbb;' : '' }}">
                Sedang Dimasak
            </div>
            <div class="timeline-sub" style="{{ $pesanan->status === 'pending' ? 'color:#ddd;' : '' }}">
                Dapur sedang menyiapkan pesananmu
            </div>
        </div>

        {{-- SELESAI --}}
        <div class="timeline-item">
            <div class="timeline-dot
                {{ $pesanan->status === 'selesai' ? 'active' : '' }}
                {{ $pesanan->status === 'dibayar' ? 'done' : '' }}">
                <i class="bi bi-{{ in_array($pesanan->status, ['selesai','dibayar']) ? 'check' : 'cup-hot' }}"></i>
            </div>
            <div class="timeline-label" style="{{ in_array($pesanan->status, ['pending','memasak']) ? 'color:#bbb;' : '' }}">
                Siap Disajikan
            </div>
            <div class="timeline-sub" style="{{ in_array($pesanan->status, ['pending','memasak']) ? 'color:#ddd;' : '' }}">
                Pesanan siap di meja kamu
            </div>
        </div>

        {{-- DIBAYAR --}}
        <div class="timeline-item">
            <div class="timeline-dot {{ $pesanan->status === 'dibayar' ? 'done' : '' }}">
                <i class="bi bi-check"></i>
            </div>
            <div class="timeline-label" style="{{ $pesanan->status !== 'dibayar' ? 'color:#bbb;' : '' }}">
                Pembayaran Selesai
            </div>
            <div class="timeline-sub" style="{{ $pesanan->status !== 'dibayar' ? 'color:#ddd;' : '' }}">
                Bayar di kasir ya!
            </div>
        </div>
    </div>

    {{-- DETAIL PESANAN --}}
    <div class="section-title">Detail Pesanan</div>

    <div style="background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 2px 8px rgba(44,24,16,.08); margin-bottom: 20px;">
        @foreach($pesanan->detailPesanans as $detail)
        <div class="d-flex align-items-center gap-3 px-4 py-3 border-bottom">
            <div style="font-size: 1.3rem; width: 32px; text-align: center;">
                {{ str_contains(strtolower($detail->menu->nama_menu ?? ''), 'kopi') || str_contains(strtolower($detail->menu->nama_menu ?? ''), 'es') ? '☕' : '🍽️' }}
            </div>
            <div style="flex: 1;">
                <div style="font-weight: 600; font-size: .9rem;">{{ $detail->menu->nama_menu ?? 'Menu dihapus' }}</div>
                @if($detail->catatan)
                    <div style="font-size: .75rem; color: #999; font-style: italic;">{{ $detail->catatan }}</div>
                @endif
            </div>
            <div style="text-align: right;">
                <div style="font-size: .78rem; color: #999;">× {{ $detail->qty }}</div>
                <div style="font-weight: 700; font-size: .88rem; color: var(--kopi-accent);">
                    Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                </div>
            </div>
        </div>
        @endforeach

        <div class="d-flex justify-content-between align-items-center px-4 py-3" style="background: var(--kopi-cream);">
            <span style="font-weight: 700;">Total</span>
            <span style="font-weight: 700; color: var(--kopi-accent); font-size: 1rem;">
                Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
            </span>
        </div>
    </div>

    {{-- INFO PELANGGAN --}}
    <div style="background: #fff; border-radius: 16px; padding: 16px 20px; box-shadow: 0 2px 8px rgba(44,24,16,.08); margin-bottom: 24px;">
        <div class="d-flex justify-content-between mb-2">
            <span style="font-size: .83rem; color: #888;">Nama</span>
            <span style="font-size: .83rem; font-weight: 600;">{{ $pesanan->nama_pelanggan }}</span>
        </div>
        <div class="d-flex justify-content-between mb-2">
            <span style="font-size: .83rem; color: #888;">Meja</span>
            <span style="font-size: .83rem; font-weight: 600;">{{ $pesanan->meja->nomor_meja }}</span>
        </div>
        @if($pesanan->catatan_umum)
        <div class="d-flex justify-content-between">
            <span style="font-size: .83rem; color: #888;">Catatan</span>
            <span style="font-size: .83rem; font-weight: 600; text-align: right; max-width: 60%;">{{ $pesanan->catatan_umum }}</span>
        </div>
        @endif
    </div>

    {{-- AUTO REFRESH INFO --}}
    @if(!in_array($pesanan->status, ['selesai', 'dibayar', 'batal']))
    <div style="background: #EFF6FF; border-radius: 12px; padding: 12px 16px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
        <div class="spinner-border spinner-border-sm" style="color: var(--kopi-medium); flex-shrink:0;"></div>
        <div style="font-size: .8rem; color: #1E40AF;">
            Halaman akan diperbarui otomatis setiap 15 detik
        </div>
    </div>
    @endif

    {{-- TOMBOL PESAN LAGI --}}
    @if(in_array($pesanan->status, ['selesai', 'dibayar']))
    <a href="{{ route('menu.index', $pesanan->meja->id) }}" class="btn-kopi text-decoration-none d-block text-center">
        <i class="bi bi-arrow-repeat me-2"></i>Pesan Lagi
    </a>
    @endif

</div>
@endsection

@push('scripts')
<script>
    @if(!in_array($pesanan->status, ['selesai', 'dibayar', 'batal']))
    // Auto refresh setiap 15 detik
    setTimeout(() => { location.reload(); }, 15000);
    @endif
</script>
@endpush
