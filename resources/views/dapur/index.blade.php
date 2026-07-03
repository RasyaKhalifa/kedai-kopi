@extends('admin.layout')

@section('title', 'Antrian Dapur')

@section('content')
<style>
    :root {
        --bg-coffee: #FDFBF7;
        --primary-coffee: #2C1810;
        --accent-warm: #E07B39;
        --soft-tan: #F4EFE6;
        --text-muted: #7A6E67;
    }
    .card-pesanan {
        border: none;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 8px 20px rgba(44, 24, 16, 0.05);
        margin-bottom: 14px;
    }
    .col-title {
        font-weight: 700;
        padding: 8px 14px;
        border-radius: 10px;
        display: inline-block;
    }
    .badge-pending { background: #F4EFE6; color: #7A6E67; }
    .badge-memasak { background: #FDECD8; color: var(--accent-warm); }
    .badge-selesai { background: #DCEEDD; color: #2E7D32; }
    .btn-coffee { background: var(--accent-warm); border: none; color: #fff; font-weight: 600; }
    .btn-coffee:hover { background: #c96a2e; color: #fff; }
    .btn-selesai { background: #2E7D32; border: none; color: #fff; font-weight: 600; }
    .btn-selesai:hover { background: #256428; color: #fff; }
</style>

<div class="container-fluid p-0">
    <h3 class="mb-4 fw-bold">Antrian Dapur</h3>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        {{-- PENDING --}}
        <div class="col-md-4">
            <span class="col-title badge-pending mb-3"><i class="bi bi-hourglass-split"></i> Menunggu Dimasak ({{ $pesananPending->count() }})</span>

            @forelse ($pesananPending as $p)
                <div class="card card-pesanan">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <strong>#{{ $p->id }} — Meja {{ $p->meja->nomor_meja ?? '-' }}</strong>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($p->tanggal_pesanan)->format('H:i') }}</small>
                        </div>
                        <ul class="small my-2 ps-3">
                            @foreach ($p->detailPesanan as $d)
                                <li>{{ $d->menu->nama_menu ?? '-' }} x{{ $d->jumlah }}</li>
                            @endforeach
                        </ul>
                        
                        {{-- FORM MULAI MASAK --}}
                        <form action="{{ route('dapur.mulai', $p->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-coffee btn-sm w-100">
                                <i class="bi bi-fire"></i> Mulai Masak
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-muted mt-2">Tidak ada pesanan menunggu.</p>
            @endforelse
        </div>

        {{-- MEMASAK --}}
        <div class="col-md-4">
            <span class="col-title badge-memasak mb-3"><i class="bi bi-egg-fried"></i> Sedang Dimasak ({{ $pesananMemasak->count() }})</span>

            @forelse ($pesananMemasak as $p)
                <div class="card card-pesanan">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <strong>#{{ $p->id }} — Meja {{ $p->meja->nomor_meja ?? '-' }}</strong>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($p->tanggal_pesanan)->format('H:i') }}</small>
                        </div>
                        <ul class="small my-2 ps-3">
                            @foreach ($p->detailPesanan as $d)
                                <li>{{ $d->menu->nama_menu ?? '-' }} x{{ $d->jumlah }}</li>
                            @endforeach
                        </ul>
                        
                        {{-- FORM TANDAI SELESAI --}}
                        <form action="{{ route('dapur.selesai', $p->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-selesai btn-sm w-100">
                                <i class="bi bi-check2-circle"></i> Tandai Selesai
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-muted mt-2">Tidak ada pesanan yang sedang dimasak.</p>
            @endforelse
        </div>

        {{-- SELESAI (riwayat) --}}
        <div class="col-md-4">
            <span class="col-title badge-selesai mb-3"><i class="bi bi-check-circle-fill"></i> Selesai Terbaru</span>

            @forelse ($pesananSelesai as $p)
                <div class="card card-pesanan">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <strong>#{{ $p->id }} — Meja {{ $p->meja->nomor_meja ?? '-' }}</strong>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($p->updated_at)->format('H:i') }}</small>
                        </div>
                        <ul class="small my-2 ps-3">
                            @foreach ($p->detailPesanan as $d)
                                <li>{{ $d->menu->nama_menu ?? '-' }} x{{ $d->jumlah }}</li>
                            @endforeach
                        </ul>
                        <span class="badge bg-success">Siap diantar / dibayar</span>
                    </div>
                </div>
            @empty
                <p class="text-muted mt-2">Belum ada pesanan selesai.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection