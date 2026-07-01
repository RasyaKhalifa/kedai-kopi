<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pesanan #{{ $pesanan->id }} 🕦</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --kopi-espresso: #2C1810;
            --kopi-medium: #6F4E37;
            --kopi-latte: #C9A87C;
            --kopi-accent: #E07B39;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f5f0;
            color: var(--kopi-espresso);
        }
        .card-tracking {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }
        .badge-status {
            font-size: 1.1rem;
            padding: 10px 20px;
            border-radius: 50px;
        }
        .bg-pending { background-color: #ffc107; color: #000; }
        .bg-memasak { background-color: #17a2b8; color: #fff; }
        .bg-selesai { background-color: #28a745; color: #fff; }
        .bg-dibatalkan { background-color: #dc3545; color: #fff; }
    </style>
</head>
<body>

<div class="container my-5" style="max-width: 600px;">
    <div class="card p-4 card-tracking text-center bg-white">
        
        <div class="mb-3 text-success">
            <i class="bi bi-check-circle-fill" style="font-size: 4rem; color: var(--kopi-accent);"></i>
        </div>

        <h3 class="fw-bold">Terima Kasih, {{ $pesanan->pelanggan->nama }}!</h3>
        <p class="text-muted">Pesanan Anda berhasil dikirim ke sistem dapur.</p>
        <hr class="my-4" style="border-top: 2px dashed #ddd;">
        
        <div class="my-4">
            <h5 class="fw-bold text-muted mb-2">Status Pesanan:</h5>
            @if($pesanan->status_pesanan == 'Pending')
                <span class="badge bg-pending badge-status shadow-sm"><i class="bi bi-hourglass-split me-1"></i> Menunggu Konfirmasi</span>
            @elseif($pesanan->status_pesanan == 'Memasak')
                <span class="badge bg-memasak badge-status shadow-sm"><i class="bi bi-fire me-1"></i> Sedang Dimasak Barista</span>
            @elseif($pesanan->status_pesanan == 'Selesai')
                <span class="badge bg-selesai badge-status shadow-sm"><i class="bi bi-cup-hot-fill me-1"></i> Siap Diambil / Diantar</span>
            @else
                <span class="badge bg-dibatalkan badge-status shadow-sm"><i class="bi bi-x-circle me-1"></i> Pesanan Dibatalkan</span>
            @endif
        </div>

        <div class="card p-3 text-start mb-4 border-0" style="background-color: #fcfbf9; border-left: 5px solid var(--kopi-medium) !important;">
            <p class="mb-2"><strong><i class="bi bi-geo-alt-fill me-1"></i> No. Meja:</strong> <span class="badge bg-dark">{{ $pesanan->meja->nomor_meja }}</span></p>
            <p class="mb-2"><strong><i class="bi bi-clock me-1"></i> Waktu Pesan:</strong> {{ \Carbon\Carbon::parse($pesanan->tanggal_pesanan)->format('H:i') }} WIB</p>
            <p class="mb-0"><strong><i class="bi bi-wallet2 me-1"></i> Total Bayar:</strong> <span class="text-success fw-bold">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span></p>
        </div>

        <div class="text-start mb-4">
            <h6 class="fw-bold text-muted mb-3">Detail Item:</h6>
            <ul class="list-group list-group-flush small">
                @foreach($pesanan->detailPesanan as $detail)
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent">
                        <div>
                            {{ $detail->menu->nama_menu }}
                            <span class="text-muted">x{{ $detail->jumlah }}</span>
                        </div>
                        <span class="fw-bold">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <a href="{{ route('menu.index') }}" class="btn w-100 py-2 fw-bold text-white shadow-sm" style="background-color: var(--kopi-espresso);">
            <i class="bi bi-house-door me-1"></i> Kembali ke Beranda Menu
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>