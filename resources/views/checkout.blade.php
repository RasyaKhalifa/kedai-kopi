<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Pesanan ☕</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        :root {
            --bg-coffee: #FDFBF7;
            --primary-coffee: #2C1810;
            --accent-success: #198754;
            --soft-bg: #FCFBF9;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-coffee);
            color: var(--primary-coffee);
        }
        .checkout-card {
            background: white;
            border-radius: 24px;
            border: none;
            box-shadow: 0 15px 35px rgba(44, 24, 16, 0.04);
        }
        .form-control {
            border-radius: 12px;
            padding: 12px;
            border: 1px solid #E2E8F0;
        }
        .form-control:focus {
            border-color: var(--primary-coffee);
            box-shadow: 0 0 0 3px rgba(44, 24, 16, 0.1);
        }
        .btn-order {
            background: var(--accent-success);
            color: white;
            border-radius: 12px;
            padding: 14px;
            font-weight: 700;
            transition: all 0.3s ease;
            border: none;
        }
        .btn-order:hover {
            background: #146c43;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(25, 135, 84, 0.2);
        }
    </style>
</head>
<body>
<div class="container my-5 animate__animated animate__fadeInUp">
    <div class="row g-4 style="max-width: 900px; margin: 0 auto;"">
        
        <div class="col-md-7">
            <div class="card p-4 p-md-5 checkout-card h-100">
                <h3 class="fw-bold mb-4">Data Pelanggan</h3>
                
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form action="{{ route('pesanan.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" name="nama_pelanggan" class="form-control" placeholder="Masukkan nama Anda..." required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Nomor Meja</label>
                        <input type="text" name="nomor_meja" class="form-control" placeholder="Contoh: M01" required>
                        <small class="text-muted">Masukkan kode meja sesuai dengan QR yang Anda scan.</small>
                    </div>

                    <button type="submit" class="btn btn-order w-100 shadow-sm">
                        <i class="bi bi-wallet2 me-2"></i> Konfirmasi & Pesan Sekarang
                    </button>
                </form>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card p-4 checkout-card h-100" style="background-color: var(--soft-bg);">
                <h4 class="fw-bold mb-3">Ringkasan Pesanan</h4>
                <hr>
                <ul class="list-group list-group-flush mb-4 bg-transparent">
                    @php $total = 0; @endphp
                    @foreach($cart as $id => $details)
                        @php $total += $details['harga'] * $details['jumlah']; @endphp
                        <li class="list-group-item d-flex justify-content-between align-items-start px-0 bg-transparent py-3">
                            <div class="me-auto">
                                <div class="fw-bold text-dark">{{ $details['nama_menu'] }}</div>
                                <small class="text-muted">x{{ $details['jumlah'] }}</small>
                            </div>
                            <span class="fw-semibold text-muted">Rp {{ number_format($details['harga'] * $details['jumlah'], 0, ',', '.') }}</span>
                        </li>
                    @endforeach
                </ul>
                <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top">
                    <h5 class="fw-bold m-0 text-success">Total Bayar</h5>
                    <h4 class="fw-800 m-0 text-success fw-bold">Rp {{ number_format($total, 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>

    </div>
</div>
</body>
</html>