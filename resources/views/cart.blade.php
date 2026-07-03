<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja 🛒</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        :root {
            --bg-coffee: #FDFBF7;
            --primary-coffee: #2C1810;
            --accent-warm: #E07B39;
            --soft-tan: #EDE8E0;
            --text-muted: #7A6E67;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-coffee);
            color: var(--primary-coffee);
            min-height: 100vh;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 28px;
            border: 1px solid rgba(44, 24, 16, 0.05);
            box-shadow: 0 25px 50px -12px rgba(44, 24, 16, 0.08);
            overflow: hidden;
        }

        /* Nav & Action Buttons */
        .btn-back-nav {
            background: var(--soft-tan);
            color: var(--primary-coffee);
            border-radius: 12px;
            width: 45px;
            height: 45px;
            display: grid;
            place-items: center;
            transition: all 0.3s ease;
        }
        .btn-back-nav:hover { background: var(--primary-coffee); color: white; transform: translateX(-5px); }

        .btn-outline-custom {
            border: 2px solid var(--primary-coffee);
            color: var(--primary-coffee);
            font-weight: 600;
            border-radius: 12px;
            padding: 8px 16px;
            transition: all 0.3s;
        }
        .btn-outline-custom:hover { background: var(--primary-coffee); color: white; }

        /* Table Optimization */
        .table thead th {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            background: #F8F7F4;
            padding: 16px;
            border: none;
        }
        
        .menu-img-wrapper {
            width: 70px;
            height: 70px;
            border-radius: 16px;
            overflow: hidden;
        }

        .quantity-wrapper .form-control {
            width: 70px !important;
            border-radius: 10px;
            border: 1px solid var(--soft-tan);
            font-weight: 600;
        }

        /* Responsive Table */
        @media (max-width: 576px) {
            .table thead { display: none; }
            .table tr { display: block; padding: 15px 0; border-bottom: 1px solid var(--soft-tan); }
            .table td { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border: none; }
            .table td:before { content: attr(data-label); font-weight: 700; font-size: 0.8rem; color: var(--text-muted); }
        }

        /* Footer */
        .checkout-bar {
            background: var(--primary-coffee);
            border-radius: 24px;
            padding: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }

        .btn-checkout-next {
            background: var(--accent-warm);
            color: white;
            border-radius: 16px;
            padding: 14px 32px;
            font-weight: 700;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-checkout-next:hover { filter: brightness(1.1); transform: translateY(-2px); }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="glass-card p-4 p-md-5 animate__animated animate__fadeIn">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center">
                <a href="{{ route('menu.index') }}" class="btn-back-nav me-3 text-decoration-none">
                    <i class="bi bi-arrow-left"></i>
                </a> 
                <h2 class="fw-800 m-0">Keranjang Anda</h2>
            </div>
            <a href="{{ route('menu.index') }}" class="btn btn-outline-custom">
                <i class="bi bi-plus-circle me-1"></i> <span class="d-none d-sm-inline">Tambah Pesanan</span>
            </a>
        </div>
        
        @if(session('cart') && count(session('cart')) > 0)
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Menu</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach($cart as $id => $details)
                            @php $total += $details['harga'] * $details['jumlah'] @endphp
                            <tr data-id="{{ $id }}">
                                <td data-label="Menu">
                                    <div class="d-flex align-items-center">
                                        <div class="menu-img-wrapper me-3">
                                            <img src="{{ asset('img/' . $details['foto']) }}" class="w-100 h-100" style="object-fit: cover" onerror="this.src='https://placehold.co/70x70?text=Kopi'">
                                        </div>
                                        <span class="fw-bold">{{ $details['nama_menu'] }}</span>
                                    </div>
                                </td>
                                <td data-label="Harga">Rp {{ number_format($details['harga'], 0, ',', '.') }}</td>
                                <td data-label="Jumlah">
                                    <input type="number" value="{{ $details['jumlah'] }}" class="form-control quantity update-cart" min="1">
                                </td>
                                <td data-label="Subtotal" class="fw-bold">Rp {{ number_format($details['harga'] * $details['jumlah'], 0, ',', '.') }}</td>
                                <td data-label="Aksi">
                                    <button class="btn btn-light text-danger rounded-circle remove-from-cart" title="Hapus Item">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="checkout-bar mt-4 flex-column flex-sm-row gap-3">
                <div>
                    <small class="text-white-50">Total Pembayaran</small>
                    <h3 class="m-0 fw-bold">Rp {{ number_format($total, 0, ',', '.') }}</h3>
                </div>
                <a href="{{ route('checkout') }}" class="btn btn-checkout-next">
                    Lanjut Checkout <i class="bi bi-chevron-right ms-2"></i>
                </a>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-cart-x fs-1 text-muted"></i>
                <h4 class="mt-3">Keranjangmu Kosong</h4>
                <a href="{{ route('menu.index') }}" class="btn btn-primary mt-3">Lihat Menu</a>
            </div>
        @endif
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(".update-cart").change(function (e) {
        var ele = $(this);
        $.ajax({
            url: '{{ route("cart.update") }}',
            method: "patch",
            data: { _token: '{{ csrf_token() }}', id: ele.parents("tr").attr("data-id"), jumlah: ele.val() },
            success: function () { window.location.reload(); }
        });
    });

    $(".remove-from-cart").click(function (e) {
        var ele = $(this);
        if(confirm("Apakah kamu yakin ingin menghapus menu ini?")) {
            $.ajax({
                url: '{{ route("cart.remove") }}',
                method: "DELETE",
                data: { _token: '{{ csrf_token() }}', id: ele.parents("tr").attr("data-id") },
                success: function () { window.location.reload(); }
            });
        }
    });
</script>
</body>
</html>