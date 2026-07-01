<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout Pesanan 📋</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container my-5">
    <div class="row">
        <div class="col-md-7">
            <div class="card p-4 border-0 shadow-sm">
                <h4 class="mb-4 fw-bold">Data Pelanggan</h4>
                <form action="{{ route('pesanan.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama_pelanggan" class="form-control" placeholder="Masukkan nama Anda..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor Meja</label>
                        <input type="text" name="nomor_meja" class="form-control" value="{{ session('nomor_meja') }}" placeholder="Contoh: M01" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100 py-2 mt-3 fw-bold">Konfirmasi & Pesan Sekarang</button>
                </form>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card p-4 border-0 shadow-sm bg-white">
                <h4 class="mb-4 fw-bold">Ringkasan Pesanan</h4>
                <ul class="list-group list-group-flush">
                    @php $total = 0; @endphp
                    @foreach($cart as $id => $details)
                        @php $total += $details['harga'] * $details['jumlah'] @endphp
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div>
                                <h6 class="my-0 fw-bold">{{ $details['nama_menu'] }}</h6>
                                <small class="text-muted">x{{ $details['jumlah'] }}</small>
                            </div>
                            <span class="text-muted">Rp {{ number_format($details['harga'] * $details['jumlah'], 0, ',', '.') }}</span>
                        </li>
                    @endforeach
                    <li class="list-group-item d-flex justify-content-between px-0 fw-bold fs-5 mt-2 text-success">
                        <span>Total Bayar</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
</body>
</html>