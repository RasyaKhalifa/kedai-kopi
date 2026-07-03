<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Nine Brew Coffee</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <style>
        :root {
            --primary-coffee: #2C1810;
            --accent-warm: #E07B39;
            --bg-coffee: #FDFBF7;
            --soft-tan: #EDE8E0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-coffee);
            color: var(--primary-coffee);
            min-height: 100vh;
        }

        .navbar-brand-custom {
            background: var(--primary-coffee);
            padding: 1.5rem 0;
            border-bottom-left-radius: 30px;
            border-bottom-right-radius: 30px;
            margin-bottom: 2rem;
        }

        .glass-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(44, 24, 16, 0.05);
            border: 1px solid rgba(44, 24, 16, 0.08);
        }

        .form-control {
            border-radius: 14px;
            padding: 14px;
            border: 2px solid var(--soft-tan);
        }

        .btn-order {
            background: var(--accent-warm);
            color: white;
            border-radius: 16px;
            padding: 15px;
            font-weight: 700;
            border: none;
            transition: 0.3s;
        }

        .btn-order:hover {
            filter: brightness(1.1);
            transform: translateY(-2px);
        }

        .summary-box { background: #F8F7F4; border-radius: 20px; }
        .list-group-item { background: transparent !important; border: none !important; }
    </style>
</head>
<body>

<nav class="navbar-brand-custom text-white">
    <div class="container d-flex justify-content-between align-items-center">
        <h4 class="fw-bold m-0"><i class="bi bi-cup-hot-fill me-2"></i>Nine Brew Coffee</h4>
        <a href="{{ route('cart.index') }}" class="text-white text-decoration-none"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
    </div>
</nav>

<div class="container pb-5 animate__animated animate__fadeIn">
    <div class="row g-4 justify-content-center">
        
        <div class="col-md-7">
            <div class="card p-4 p-md-5 glass-card border-0 h-100">
                <h3 class="fw-800 mb-4">Data Pelanggan</h3>
                
                @if(session('error'))
                    <div class="alert alert-danger rounded-4">{{ session('error') }}</div>
                @endif

                <form action="{{ route('pesanan.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="fw-bold small text-uppercase text-muted">Nama Lengkap</label>
                        <input type="text" name="nama_pelanggan" class="form-control" placeholder="Masukkan nama Anda..." required>
                    </div>

                    <div class="mb-4">
                        <label class="fw-bold small text-uppercase text-muted">Nomor Meja</label>
                        <input type="text" name="nomor_meja" class="form-control" placeholder="Contoh: M01" required>
                    </div>

                    <button type="submit" class="btn btn-order w-100">
                        <i class="bi bi-bag-check-fill me-2"></i> Konfirmasi & Pesan
                    </button>
                </form>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card p-4 glass-card border-0 summary-box h-100">
                <h4 class="fw-bold mb-3">Ringkasan Pesanan</h4>
                <hr class="opacity-10">
                <ul class="list-group list-group-flush mb-4">
                    @php $total = 0; @endphp
                    @if(session('cart'))
                        @foreach(session('cart') as $details)
                            @php $total += $details['harga'] * $details['jumlah']; @endphp
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                                <div>
                                    <div class="fw-bold">{{ $details['nama_menu'] }}</div>
                                    <small class="text-muted">x{{ $details['jumlah'] }}</small>
                                </div>
                                <span class="fw-semibold">Rp {{ number_format($details['harga'] * $details['jumlah'], 0, ',', '.') }}</span>
                            </li>
                        @endforeach
                    @endif
                </ul>
                <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top border-dark border-opacity-10">
                    <h5 class="fw-bold m-0">Total Bayar</h5>
                    <h4 class="fw-800 m-0" style="color: var(--accent-warm);">Rp {{ number_format($total, 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>

    </div>
</div>

</body>
</html>