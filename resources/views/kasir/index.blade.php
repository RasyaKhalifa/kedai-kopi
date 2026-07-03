@extends('admin.layout')

@section('title', 'Dashboard Kasir')

@section('content')
<div class="container-fluid py-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Daftar Pesanan Masuk</h3>
        <a href="{{ route('kasir.laporan') }}" class="btn btn-outline-dark btn-sm rounded-pill px-3">
            <i class="bi bi-bar-chart-fill me-1"></i> Lihat Laporan Penjualan
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
        </div>
    @endif

    <div class="row g-4">
        {{-- 1. KOLOM PENDING --}}
        <div class="col-md-4">
            <div class="mb-3">
                <span class="badge bg-light text-dark border px-3 py-2 fs-6 fw-bold rounded-pill w-100 text-start">
                    <i class="bi bi-hourglass-split text-warning me-2"></i>Pending ({{ $pesananPending->count() }})
                </span>
            </div>

            @forelse ($pesananPending as $p)
                <div class="card border-0 shadow-sm mb-3" style="border-radius: 16px; background: #fff;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <strong class="fs-5">#{{ $p->id }} — Meja {{ $p->meja->nomor_meja ?? '-' }}</strong>
                            <span class="badge bg-light text-muted">{{ \Carbon\Carbon::parse($p->tanggal_pesanan)->format('H:i') }}</span>
                        </div>
                        <p class="text-muted small mb-3"><i class="bi bi-person me-1"></i>{{ $p->pelanggan->nama ?? '-' }}</p>
                        
                        <div class="p-3 bg-light rounded-3 mb-3">
                            <ul class="list-unstyled m-0 small">
                                @foreach ($p->detailPesanan as $d)
                                    <li class="d-flex justify-content-between mb-1">
                                        <span>{{ $d->menu->nama_menu ?? '-' }}</span>
                                        <span class="fw-bold">x{{ $d->jumlah }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center pt-2">
                            <div>
                                <small class="text-muted d-block">Total</small>
                                <span class="fw-bold text-success fs-5">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</span>
                            </div>
                            <div style="width: 50%;">
                                <form action="{{ route('kasir.status.update', $p->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status_pesanan" value="Memasak">
                                    <button type="submit" class="btn btn-warning text-white btn-sm w-100 rounded-pill py-2 fw-semibold">Masak</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-4 text-center text-muted bg-white rounded-4 shadow-sm border">
                    <i class="bi bi-inbox fs-2 d-block mb-2 opacity-50"></i>Tidak ada pesanan pending.
                </div>
            @endforelse
        </div>

        {{-- 2. KOLOM MEMASAK --}}
        <div class="col-md-4">
            <div class="mb-3">
                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2 fs-6 fw-bold rounded-pill w-100 text-start">
                    <i class="bi bi-egg-fried me-2"></i>Memasak ({{ $pesananMemasak->count() }})
                </span>
            </div>

            @forelse ($pesananMemasak as $p)
                <div class="card border-0 shadow-sm mb-3" style="border-radius: 16px; background: #fff;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <strong class="fs-5">#{{ $p->id }} — Meja {{ $p->meja->nomor_meja ?? '-' }}</strong>
                            <span class="badge bg-light text-muted">{{ \Carbon\Carbon::parse($p->tanggal_pesanan)->format('H:i') }}</span>
                        </div>
                        <p class="text-muted small mb-3"><i class="bi bi-person me-1"></i>{{ $p->pelanggan->nama ?? '-' }}</p>
                        
                        <div class="p-3 bg-light rounded-3 mb-3">
                            <ul class="list-unstyled m-0 small">
                                @foreach ($p->detailPesanan as $d)
                                    <li class="d-flex justify-content-between mb-1">
                                        <span>{{ $d->menu->nama_menu ?? '-' }}</span>
                                        <span class="fw-bold">x{{ $d->jumlah }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center pt-2">
                            <div>
                                <small class="text-muted d-block">Total</small>
                                <span class="fw-bold text-success fs-5">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</span>
                            </div>
                            <div style="width: 50%;">
                                <form action="{{ route('kasir.status.update', $p->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status_pesanan" value="Selesai">
                                    <button type="submit" class="btn btn-primary btn-sm w-100 rounded-pill py-2 fw-semibold">Selesai</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-4 text-center text-muted bg-white rounded-4 shadow-sm border">
                    <i class="bi bi-fire fs-2 d-block mb-2 opacity-50"></i>Tidak ada pesanan dimasak.
                </div>
            @endforelse
        </div>

        {{-- 3. KOLOM SIAP BAYAR --}}
        <div class="col-md-4">
            <div class="mb-3">
                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 fs-6 fw-bold rounded-pill w-100 text-start">
                    <i class="bi bi-check-circle-fill me-2"></i>Siap Dibayar ({{ $pesananSiapBayar->count() }})
                </span>
            </div>

            @forelse ($pesananSiapBayar as $p)
                <div class="card mb-3 border border-success border-opacity-20 shadow-sm" style="border-radius: 16px; background: #fff;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <strong class="fs-5 text-success">#{{ $p->id }} — Meja {{ $p->meja->nomor_meja ?? '-' }}</strong>
                            <span class="badge bg-light text-muted">{{ \Carbon\Carbon::parse($p->tanggal_pesanan)->format('H:i') }}</span>
                        </div>
                        <p class="text-muted small mb-3"><i class="bi bi-person me-1"></i>{{ $p->pelanggan->nama ?? '-' }}</p>
                        
                        <div class="p-3 bg-light rounded-3 mb-3">
                            <ul class="list-unstyled m-0 small">
                                @foreach ($p->detailPesanan as $d)
                                    <li class="d-flex justify-content-between mb-1">
                                        <span>{{ $d->menu->nama_menu ?? '-' }}</span>
                                        <span class="fw-bold">x{{ $d->jumlah }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center pt-2">
                            <div>
                                <small class="text-muted d-block">Total</small>
                                <span class="fw-bold text-success fs-5">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</span>
                            </div>
                            <div style="width: 50%;">
                                <a href="{{ route('kasir.bayar.form', $p->id) }}" class="btn btn-success btn-sm w-100 rounded-pill py-2 fw-semibold">
                                    <i class="bi bi-cash-coin me-1"></i> Bayar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-4 text-center text-muted bg-white rounded-4 shadow-sm border">
                    <i class="bi bi-wallet2 fs-2 d-block mb-2 opacity-50"></i>Belum ada pesanan siap dibayar.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection 