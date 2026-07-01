<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang Belanja 🛒</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container my-5">
    <div class="card shadow-sm border-0 p-4">
        <h2 class="mb-4 fw-bold"><a href="{{ route('menu.index') }}" class="btn btn-outline-secondary me-2"><i class="bi bi-arrow-left"></i></a> Keranjang Anda</h2>
        
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
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('img/' . $details['foto']) }}" width="50" height="50" class="rounded me-3" style="object-fit: cover">
                                        <span class="fw-bold">{{ $details['nama_menu'] }}</span>
                                    </div>
                                </td>
                                <td>Rp {{ number_format($details['harga'], 0, ',', '.') }}</td>
                                <td>
                                    <input type="number" value="{{ $details['jumlah'] }}" class="form-control quantity update-cart" min="1" style="width: 80px;">
                                </td>
                                <td>Rp {{ number_format($details['harga'] * $details['jumlah'], 0, ',', '.') }}</td>
                                <td>
                                    <button class="btn btn-danger btn-sm remove-from-cart"><i class="bi bi-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-4">
                <h4>Total: <span class="fw-bold text-success">Rp {{ number_format($total, 0, ',', '.') }}</span></h4>
                <a href="{{ route('checkout') }}" class="btn btn-warning btn-lg px-4 fw-bold text-white shadow-sm">Lanjut Checkout</a>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-cart-x text-muted" style="font-size: 4rem;"></i>
                <p class="mt-3 text-muted">Keranjang Anda masih kosong.</p>
                <a href="{{ route('menu.index') }}" class="btn btn-primary">Lihat Menu</a>
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