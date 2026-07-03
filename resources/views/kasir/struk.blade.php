<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk — Pesanan #{{ $pesanan->id }}</title>
    <style>
        /* Menggunakan font yang senada dengan website utama */
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px;
            width: 280px;
            margin: 0 auto;
            padding: 20px 10px;
            color: #2C1810; /* Warna utama Nine Brew */
        }
        
        .center { text-align: center; }
        
        .brand-name {
            font-weight: 800;
            font-size: 18px;
            margin-bottom: 5px;
            letter-spacing: -0.5px;
        }

        hr { 
            border: none; 
            border-top: 1px dashed #2C1810; 
            margin: 10px 0;
        }
        
        table { width: 100%; border-collapse: collapse; }
        td { padding: 3px 0; }
        .right { text-align: right; }
        
        .footer-note {
            font-size: 11px;
            font-style: italic;
            margin-top: 15px;
        }

        @media print {
            .no-print { display: none; }
        }

        .btn-print {
            background: #2C1810;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="center">
        <div class="brand-name">NINE BREW COFFEE</div>
        <p style="margin:0; font-size: 11px;">Jl. Premium Coffee No. 1, Katapang</p>
    </div>
    <hr>
    <p style="font-size: 12px; margin: 5px 0;">
        Pesanan #{{ $pesanan->id }}<br>
        Meja: {{ $pesanan->meja->nomor_meja ?? '-' }}<br>
        Pelanggan: {{ $pesanan->pelanggan->nama ?? '-' }}<br>
        {{ \Carbon\Carbon::parse($pesanan->tanggal_pesanan)->format('d M Y, H:i') }}
    </p>
    <hr>
    <table>
        @foreach ($pesanan->detailPesanan as $d)
            <tr>
                <td colspan="2" style="font-weight: 600;">{{ $d->menu->nama_menu ?? '-' }}</td>
            </tr>
            <tr>
                <td>{{ $d->jumlah }} x {{ number_format($d->harga, 0, ',', '.') }}</td>
                <td class="right">{{ number_format($d->subtotal, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </table>
    <hr>
    <table>
        <tr>
            <td><strong>Total</strong></td>
            <td class="right"><strong>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</strong></td>
        </tr>
        <tr>
            <td>Bayar ({{ $pesanan->metode_pembayaran ?? '-' }})</td>
            <td class="right">Rp {{ number_format($jumlahBayar, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Kembali</td>
            <td class="right">Rp {{ number_format($kembalian, 0, ',', '.') }}</td>
        </tr>
    </table>
    <hr>
    <div class="center footer-note">
        <p>Status: {{ $pesanan->status_pembayaran }}</p>
        Terima kasih telah berkunjung!<br>
        Selamat menikmati kopi Anda ☕
    </div>

    <div class="no-print center" style="margin-top:20px;">
        <button class="btn-print" onclick="window.print()">🖨️ Cetak Struk</button>
        <br><br>
        <a href="{{ route('kasir.index') }}" style="color: #2C1810;">Kembali ke Dashboard</a>
    </div>
</body>
</html>