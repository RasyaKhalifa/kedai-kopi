<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meja Penuh — Kedai Kopi ☕</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #FDFBF7; 
            color: #2C1810; 
        }
        .card-error { 
            background: #fff; 
            border-radius: 24px; 
            box-shadow: 0 10px 40px rgba(44, 24, 16, 0.06); 
            max-width: 480px;
            width: 100%;
        }
    </style>
</head>
<body class="d-flex align-items-center min-vh-100 p-3">
    <div class="card-error p-5 mx-auto text-center">
        <div class="text-danger mb-3">
            <i class="bi bi-exclamation-triangle" style="font-size: 4.5rem;"></i>
        </div>
        <h2 class="fw-bold text-dark mb-2">Meja {{ $nomorMeja }} Sedang Terisi</h2>
        <p class="text-muted">
            Maaf, meja ini sedang digunakan oleh pelanggan lain atau sistem mencatat pesanan sebelumnya belum selesai. 
        </p>
        <div class="p-3 bg-light rounded-3 small text-secondary mb-4">
            Silakan pilih meja kosong lainnya atau silakan lakukan pemesanan manual langsung melalui meja Kasir.
        </div>
        <hr class="border-secondary-subtle my-4">
        <p class="text-muted small m-0">☕ Kedai Kopi App</p>
    </div>
</body>
</html>