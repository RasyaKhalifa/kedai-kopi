<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran — Pesanan #{{ $pesanan->id }} ☕</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --bg-coffee: #FDFBF7;
            --primary-coffee: #2C1810;
            --accent-warm: #E07B39;
            --soft-tan: #F4EFE6;
            --text-muted: #7A6E67;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-coffee);
            color: var(--primary-coffee);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .glass-card {
            background: #fff;
            border-radius: 24px;
            border: none;
            box-shadow: 0 20px 40px rgba(44, 24, 16, 0.06);
        }
        .btn-coffee {
            background: var(--accent-warm);
            border: none;
            color: #fff;
            font-weight: 700;
        }
        .btn-coffee:hover { background: #c96a2e; color: #fff; }
        table th, table td { vertical-align: middle; }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card glass-card p-4">
                <h4 class="fw-bold mb-1">💳 Pembayaran</h4>
                <p class="text-muted">Pesanan #{{ $pesanan->id }} — Meja {{ $pesanan->meja->nomor_meja ?? '-' }} — {{ $pesanan->pelanggan->nama ?? '-' }}</p>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <table class="table">
                    <thead>
                        <tr>
                            <th>Menu</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Harga</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pesanan->detailPesanan as $d)
                            <tr>
                                <td>{{ $d->menu->nama_menu ?? '-' }}</td>
                                <td class="text-center">{{ $d->jumlah }}</td>
                                <td class="text-end">Rp {{ number_format($d->harga, 0, ',', '.') }}</td>
                                <td class="text-end">Rp {{ number_format($d->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-end">Total</th>
                            <th class="text-end">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                </table>

                <form action="{{ route('kasir.bayar.proses', $pesanan->id) }}" method="POST" class="mt-2">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Metode Pembayaran</label>
                        <select name="metode_pembayaran" class="form-select" required>
                            <option value="Tunai">Tunai</option>
                            <option value="QRIS">QRIS</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jumlah Bayar</label>
                        <input type="number" name="jumlah_bayar" class="form-control"
                               min="{{ $pesanan->total_harga }}" value="{{ $pesanan->total_harga }}" required>
                        <small class="text-muted">Minimal Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</small>
                    </div>

                    <button type="submit" class="btn btn-coffee w-100 py-2">
                        <i class="bi bi-receipt"></i> Bayar & Cetak Struk
                    </button>
                    <a href="{{ route('kasir.index') }}" class="btn btn-outline-secondary w-100 mt-2">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
