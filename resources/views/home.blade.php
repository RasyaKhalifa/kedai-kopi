<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kedai Kopi ☕</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --kopi-espresso: #2C1810;
            --kopi-medium:   #6F4E37;
            --kopi-latte:    #C9A87C;
            --kopi-cream:    #F5EDD6;
            --kopi-milk:     #FDF6EC;
            --kopi-accent:   #E07B39;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--kopi-espresso);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        /* BG PATTERN */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: radial-gradient(circle at 20% 20%, rgba(111,78,55,.4) 0%, transparent 50%),
                              radial-gradient(circle at 80% 80%, rgba(201,168,124,.15) 0%, transparent 50%);
            pointer-events: none;
        }

        .hero-wrap {
            max-width: 420px;
            width: 100%;
            padding: 40px 24px;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .logo-icon {
            font-size: 4rem;
            margin-bottom: 8px;
            display: block;
            animation: steam 2s ease-in-out infinite;
        }

        @keyframes steam {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-6px); }
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            font-weight: 800;
            color: #fff;
            line-height: 1.1;
            margin-bottom: 6px;
        }

        .hero-title span { color: var(--kopi-latte); }

        .hero-sub {
            font-size: .9rem;
            color: rgba(255,255,255,.55);
            margin-bottom: 48px;
            font-weight: 300;
        }

        /* SCAN CARD */
        .scan-card {
            background: rgba(255,255,255,.06);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,.12);
            border-radius: 24px;
            padding: 32px 28px;
            color: #fff;
            margin-bottom: 24px;
        }

        .scan-card-icon {
            font-size: 3rem;
            margin-bottom: 12px;
            color: var(--kopi-latte);
        }

        .scan-card-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .scan-card-desc {
            font-size: .82rem;
            color: rgba(255,255,255,.55);
            line-height: 1.5;
        }

        /* TRACK FORM */
        .track-wrap {
            background: rgba(255,255,255,.06);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,.12);
            border-radius: 16px;
            padding: 20px;
        }

        .track-label {
            font-size: .82rem;
            color: rgba(255,255,255,.6);
            margin-bottom: 10px;
            font-weight: 500;
        }

        .track-input-wrap {
            display: flex;
            gap: 8px;
        }

        .track-input {
            flex: 1;
            background: rgba(255,255,255,.1);
            border: 1px solid rgba(255,255,255,.2);
            border-radius: 10px;
            padding: 10px 14px;
            color: #fff;
            font-size: .88rem;
            outline: none;
            transition: border .2s;
        }
        .track-input::placeholder { color: rgba(255,255,255,.3); }
        .track-input:focus { border-color: var(--kopi-latte); }

        .btn-track {
            background: var(--kopi-accent);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 10px 18px;
            font-weight: 600;
            font-size: .88rem;
            cursor: pointer;
            transition: background .2s;
        }
        .btn-track:hover { background: #c96a28; }

        .footer-note {
            font-size: .75rem;
            color: rgba(255,255,255,.3);
            margin-top: 32px;
        }
    </style>
</head>
<body>

<div class="hero-wrap">
    {{-- LOGO --}}
    <span class="logo-icon">☕</span>
    <h1 class="hero-title">Kedai <span>Kopi</span></h1>
    <p class="hero-sub">Pesan dengan mudah, nikmati dengan tenang</p>

    {{-- SCAN QR CARD --}}
    <div class="scan-card">
        <div class="scan-card-icon">
            <i class="bi bi-qr-code-scan"></i>
        </div>
        <div class="scan-card-title">Scan QR di Mejamu</div>
        <div class="scan-card-desc">
            Arahkan kamera ke QR Code yang ada di meja untuk mulai memesan tanpa antri.
        </div>
    </div>

    {{-- TRACKING PESANAN --}}
    <div class="track-wrap">
        <div class="track-label"><i class="bi bi-search me-1"></i> Cek status pesananmu</div>
        <form action="#" method="GET" id="trackForm">
            <div class="track-input-wrap">
                <input type="text"
                       class="track-input"
                       id="kodeInput"
                       placeholder="Masukkan kode pesanan…"
                       maxlength="20"
                       style="text-transform: uppercase;">
                <button type="submit" class="btn-track">
                    <i class="bi bi-arrow-right-circle-fill"></i>
                </button>
            </div>
        </form>
    </div>

    <div class="footer-note">© {{ date('Y') }} Kedai Kopi · Dibuat dengan ❤️</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById('trackForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const kode = document.getElementById('kodeInput').value.trim().toUpperCase();
    if (kode.length < 3) return;
    window.location.href = '/tracking/' + kode;
});

document.getElementById('kodeInput').addEventListener('input', function() {
    this.value = this.value.toUpperCase();
});
</script>
</body>
</html>
