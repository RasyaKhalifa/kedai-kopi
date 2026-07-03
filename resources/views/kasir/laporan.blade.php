<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan ☕</title>
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
        }
        .navbar-coffee { background: var(--primary-coffee); }
        .navbar-coffee .navbar-brand, .navbar-coffee a { color: #fff !important; }
        .stat-card {
            border: none;
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 8px 20px rgba(44, 24, 16, 0.05);
            padding: 20px;
        }
        .stat-value { font-size: 1.6rem; font-weight: 800; }
        .btn-coffee { background: var(--accent-warm); border: none; color: #fff; font-weight: 600; }
        .btn-coffee:hover { background: #c96a2e; color: #fff; }
        .table-wrap { background: #fff; border-radius: 16px; padding: 10px 16px; }
    </style>
</head>
<body>

<nav class="navbar navbar-coffee px-3">
    <span class="navbar-brand fw-bold">☕ Kedai Kopi — Laporan Penjualan</span>
    <a href="{{ route('kasir.index') }}"><i class="bi bi-arrow-left"></i> Kembali ke Kasir</a>
</nav>

<div class="container py-4">

    <form method="GET" class="row g-2 align-items-end mb-4">
        <div class="col-auto">
            <label class="form-label small fw-semibold">Dari Tanggal</label>
            <input type="date" name="dari" class="form-control" value="{{ $dari }}">
        </div>
        <div class="col-auto">
            <label class="form-label small fw-semibold">Sampai Tanggal</label>
            <input type="date" name="sampai" class="form-control" value="{{ $sampai }}">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-coffee">Terapkan</button>
        </div>
    </form>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="stat-card">
                <div class="text-muted small">Total Penjualan</div>
                <div class="stat-value">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="text-muted small">Jumlah Transaksi</div>
                <div class="stat-value">{{ $jumlahTransaksi }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="text-muted small">Menu Terlaris</div>
                <div class="stat-value" style="font-size:1.1rem;">
                    {{ $menuTerlaris->first()['nama'] ?? '-' }}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5 mb-4">
            <h6 class="fw-bold mb-2">Menu Terlaris</h6>
            <div class="table-wrap">
                <table class="table mb-0">
                    <thead>
                        <tr><th>Menu</th><th class="text-center">Qty Terjual</th><th class="text-end">Total</th></tr>
                    </thead>
                    <tbody>
                        @forelse ($menuTerlaris as $m)
                            <tr>
                                <td>{{ $m['nama'] }}</td>
                                <td class="text-center">{{ $m['qty'] }}</td>
                                <td class="text-end">Rp {{ number_format($m['total'], 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center text-muted">Belum ada data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-7 mb-4">
            <h6 class="fw-bold mb-2">Riwayat Transaksi Lunas</h6>
            <div class="table-wrap">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Meja</th>
                            <th>Pelanggan</th>
                            <th>Metode</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pesananLunas as $p)
                            <tr>
                                <td>{{ $p->id }}</td>
                                <td>{{ $p->meja->nomor_meja ?? '-' }}</td>
                                <td>{{ $p->pelanggan->nama ?? '-' }}</td>
                                <td>{{ $p->metode_pembayaran ?? '-' }}</td>
                                <td class="text-end">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted">Belum ada transaksi pada rentang ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>
