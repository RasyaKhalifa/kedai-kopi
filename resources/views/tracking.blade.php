<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pesanan #{{ $pesanan->id }} ☕</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
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
            background: rgba(255, 255, 255, 0.9);
            border-radius: 24px;
            border: none;
            box-shadow: 0 20px 40px rgba(44, 24, 16, 0.04);
        }
        .floating-icon {
            animation: float 3s ease-in-out infinite;
            display: inline-block;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .step-container {
            position: relative;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 40px 0;
        }
        .step-line {
            position: absolute;
            top: 20px;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--soft-tan);
            z-index: 1;
        }
        .step-line-fill {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            background: var(--accent-warm);
            transition: width 0.5s ease;
            z-index: 1;
        }
        .step-item {
            position: relative;
            z-index: 2;
            text-align: center;
            width: 60px;
        }
        .step-icon {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #fff;
            border: 3px solid var(--soft-tan);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 8px;
            font-size: 1.1rem;
            color: var(--text-muted);
            transition: all 0.4s ease;
        }
        .step-item.active .step-icon {
            border-color: var(--accent-warm);
            background: var(--accent-warm);
            color: #fff;
            box-shadow: 0 0 15px rgba(224, 123, 57, 0.4);
        }
        .step-item.completed .step-icon {
            border-color: #28a745;
            background: #28a745;
            color: #fff;
        }
        .step-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-muted);
        }
        .item-card {
            background-color: rgba(44, 24, 16, 0.02);
            border-radius: 16px;
            padding: 16px;
        }
        .btn-coffee {
            background: var(--primary-coffee);
            color: #fff;
            border-radius: 14px;
            padding: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
        }
        .btn-coffee:hover {
            background: #46281d;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
<div class="container my-5 py-4 animate__animated animate__fadeInUp" style="max-width: 550px;">
    <div class="card p-4 p-md-5 glass-card text-center">
        
        <div class="mb-4">
            <span class="floating-icon">
                <i class="bi bi-cup-hot-fill text-success" style="font-size: 4.5rem; color: var(--accent-warm) !important;"></i>
            </span>
        </div>

        <h3 class="fw-bold mb-1">Terima Kasih, {{ $pesanan->pelanggan->nama }}!</h3>
        <p class="text-muted small px-3">Pesanan Anda berhasil dikirim ke sistem dapur.</p>
        
        <div class="step-container">
            @php
                $progress = '0%';
                if($pesanan->status_pesanan == 'Pending') $progress = '15%';
                if($pesanan->status_pesanan == 'Memasak') $progress = '50%';
                if($pesanan->status_pesanan == 'Selesai') $progress = '100%';
            @endphp
            <div class="step-line">
                <div class="step-line-fill" style="width: {{ $progress }}"></div>
            </div>

            <div class="step-item {{ $pesanan->status_pesanan == 'Pending' ? 'active' : 'completed' }}">
                <div class="step-icon"><i class="bi bi-hourglass-split"></i></div>
                <div class="step-label">Antrean</div>
            </div>

            <div class="step-item {{ $pesanan->status_pesanan == 'Memasak' ? 'active' : ($pesanan->status_pesanan == 'Selesai' ? 'completed' : '') }}">
                <div class="step-icon"><i class="bi bi-fire"></i></div>
                <div class="step-label">Dibuat</div>
            </div>

            <div class="step-item {{ $pesanan->status_pesanan == 'Selesai' ? 'active' : '' }}">
                <div class="step-icon"><i class="bi bi-check2-all"></i></div>
                <div class="step-label">Siap</div>
            </div>
        </div>

        <div class="text-start mb-4 p-3 bg-white shadow-sm rounded-4" style="border-left: 4px solid var(--accent-warm) !important;">
            <div class="row g-2">
                <div class="col-6">
                    <span class="text-muted d-block small"><i class="bi bi-geo-alt-fill me-1"></i> Tempat Duduk</span>
                    <strong class="fs-5">Meja {{ $pesanan->meja->nomor_meja }}</strong>
                </div>
                <div class="col-6 text-end">
                    <span class="text-muted d-block small"><i class="bi bi-clock-history me-1"></i> Jam Pesan</span>
                    <strong>{{ \Carbon\Carbon::parse($pesanan->tanggal_pesanan)->format('H:i') }} WIB</strong>
                </div>
            </div>
        </div>

        <div class="item-card text-start mb-4">
            <h6 class="fw-bold mb-3 small text-uppercase text-muted"><i class="bi bi-card-checklist me-1"></i> Rincian Menu:</h6>
            <div class="list-group list-group-flush">
                @foreach($pesanan->detailPesanan as $detail)
                    <div class="d-flex justify-content-between align-items-center py-2 bg-transparent border-bottom border-light">
                        <div class="small">
                            <span class="fw-semibold text-dark">{{ $detail->menu->nama_menu }}</span>
                            <span class="text-muted ms-2">x{{ $detail->jumlah }}</span>
                        </div>
                        <span class="fw-bold text-dark small">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>
            <div class="d-flex justify-content-between align-items-center mt-3 pt-2">
                <span class="fw-bold text-muted small">Total Pembayaran</span>
                <span class="fs-4 fw-bold text-success">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
            </div>
        </div>

        <a href="{{ route('menu.index') }}" class="btn btn-coffee w-100 shadow-sm">
            <i class="bi bi-house-door-fill me-2"></i> Kembali ke Beranda Menu
        </a>
    </div>
</div>
</body>
</html>