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
            --soft-tan: #F4EFE6;
            --text-muted: #7A6E67;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-coffee);
            color: var(--primary-coffee);
            min-height: 100vh;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 20px 40px rgba(44, 24, 16, 0.03);
            transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .btn-back-nav {
            border: 2px solid var(--soft-tan);
            background: white;
            color: var(--primary-coffee);
            border-radius: 14px;
            transition: all 0.3s ease;
        }

        .btn-back-nav:hover {
            background: var(--primary-coffee);
            color: white;
            border-color: var(--primary-coffee);
            transform: translateX(-3px);
        }

        /* Desain Menu Item */
        .menu-img-wrapper {
            position: relative;
            overflow: hidden;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(44, 24, 16, 0.08);
        }

        .menu-thumb {
            transition: transform 0.5s ease;
        }

        tr:hover .menu-thumb {
            transform: scale(1.1);
        }

        /* Custom Input Quantity */
        .quantity-wrapper .form-control {
            border-radius: 12px;
            padding: 8px 12px;
            text-align: center;
            font-weight: 700;
            border: 2px solid var(--soft-tan);
            background-color: white;
            color: var(--primary-coffee);
            transition: all 0.3s ease;
        }

        .quantity-wrapper .form-control:focus {
            border-color: var(--accent-warm);
            box-shadow: 0 0 0 4px rgba(224, 123, 57, 0.15);
        }

        /* Tabel Styling */
        .table thead th {
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 1px;
            color: var(--text-muted);
            border-bottom: 2px solid var(--soft-tan);
            padding: 16px;
        }

        .table tbody td {
            padding: 20px 16px;
            border-bottom: 1px solid rgba(44, 24, 16, 0.04);
        }

        /* Action Buttons */
        .btn-delete-item {
            background-color: #FFF5F5;
            color: #DC3545;
            border: none;
            border-radius: 12px;
            padding: 10px 14px;
            transition: all 0.2s ease;
        }

        .btn-delete-item:hover {
            background-color: #DC3545;
            color: white;
            transform: scale(1.08) rotate(5deg);
        }

        /* Checkout Bar */
        .checkout-bar {
            background: #2C1810;
            border-radius: 20px;
            padding: 24px;
            color: white;
            box-shadow: 0 10px 30px rgba(44, 24, 16, 0.15);
        }

        .btn-checkout-next {
            background: var(--accent-warm);
            color: white;
            border-radius: 14px;
            font-weight: 700;
            padding: 14px 28px;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-checkout-next:hover {
            background: #c96628;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(224, 123, 57, 0.3);
        }

        /* Animasi Empty Cart Floating */
        .empty-cart-icon {
            animation: floatUpDown 3s ease-in-out infinite;
            display: inline-block;
        }

        @keyframes floatUpDown {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-12px); }
        }
    </style>
</head>
<body>

<div class="container my-5 py-2 animate__animated animate__fadeIn">
    <div class="card shadow-sm border-0 p-4 p-md-5 glass-card">
        
        <div class="d-flex align-items-center mb-4 pb-2">
            <a href="{{ route('menu.index') }}" class="btn btn-back-nav me-3 px-3 py-2">
                <i class="bi bi-arrow-left fs-5"></i>
            </a> 
            <h2 class="m-0 fw-800 fw-bold tracking-tight">Keranjang Anda</h2>
        </div>
        
        @if(session('cart') && count(session('cart')) > 0)
            <div class="table-responsive animate__animated animate__fadeInUp animate__faster">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Menu</th>
                            <th>Harga</th>
                            <th style="width: 120px;">Jumlah</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach($cart as $id => $details)
                            @php $total += $details['harga'] * $details['jumlah'] @endphp
                            <tr data-id="{{ $id }}">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="menu-img-wrapper me-3">
                                            <img src="{{ asset('img/' . $details['foto']) }}" width="65" height="65" class="menu-thumb" style="object-fit: cover" onerror="this.src='https://placehold.co/65x65?text=Kopi'">
                                        </div>
                                        <div>
                                            <span class="fw-bold d-block fs-5 text-dark">{{ $details['nama_menu'] }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="fw-medium text-secondary">Rp {{ number_format($details['harga'], 0, ',', '.') }}</td>
                                <td>
                                    <div class="quantity-wrapper">
                                        <input type="number" value="{{ $details['jumlah'] }}" class="form-control quantity update-cart" min="1" style="width: 85px;">
                                    </div>
                                </td>
                                <td class="fw-bold text-dark fs-6">Rp {{ number_format($details['harga'] * $details['jumlah'], 0, ',', '.') }}</td>
                                <td>
                                    <button class="btn btn-delete-item remove-from-cart"><i class="bi bi-trash3-fill"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="checkout-bar d-flex flex-column flex-sm-row justify-content-between align-items-center mt-5 gap-3 animate__animated animate__fadeInUp">
                <div class="text-center text-sm-start">
                    <span class="text-white-50 small d-block uppercase tracking-wider mb-1">Total Pembayaran</span>
                    <h3 class="m-0 fw-bold text-white">Rp {{ number_format($total, 0, ',', '.') }}</h3>
                </div>
                <a href="{{ route('checkout') }}" class="btn btn-checkout-next btn-lg px-5 shadow-sm text-center w-100 w-sm-auto">
                    Lanjut Checkout <i class="bi bi-chevron-right ms-2 small"></i>
                </a>
            </div>
        @else
            <div class="text-center py-5 my-4 animate__animated animate__zoomIn">
                <span class="empty-cart-icon mb-4">
                    <i class="bi bi-cart-x text-muted" style="font-size: 5rem; color: var(--soft-tan) !important;"></i>
                </span>
                <h4 class="fw-bold mt-2">Keranjangmu Kosong Melompong</h4>
                <p class="text-muted small px-3">Aroma seduhan kopi terbaik kami sedang menunggumu di katalog.</p>
                <a href="{{ route('menu.index') }}" class="btn btn-checkout-next px-4 mt-3">
                    <i class="bi bi-cup-hot-fill me-2"></i> Lihat Menu Kopi
                </a>
            </div>
        @endif
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    // Script AJAX untuk update jumlah item
    $(".update-cart").change(function (e) {
        e.preventDefault();
        var ele = $(this);
        $.ajax({
            url: '{{ route("cart.update") }}',
            method: "patch",
            data: {
                _token: '{{ csrf_token() }}', 
                id: ele.parents("tr").attr("data-id"), 
                jumlah: ele.parents("tr").find(".quantity").val()
            },
            success: function (response) {
               window.location.reload();
            }
        });
    });

    // Script AJAX untuk hapus item
    $(".remove-from-cart").click(function (e) {
        e.preventDefault();
        var ele = $(this);
        if(confirm("Apakah kamu yakin ingin menghapus item ini?")) {
            $.ajax({
                url: '{{ route("cart.remove") }}',
                method: "DELETE",
                data: {
                    _token: '{{ csrf_token() }}', 
                    id: ele.parents("tr").attr("data-id")
                },
                success: function (response) {
                    window.location.reload();
                }
            });
        }
    });
</script>
</body>
</html>