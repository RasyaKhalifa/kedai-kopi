<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kedai Kopi')</title>
    <style>
        :root{
            --bg-dark:#3b2418;
            --bg-darker:#2a1810;
            --bg-card: rgba(255,255,255,0.06);
            --accent:#e08a3e;
            --accent-light:#f0b87a;
            --text-light:#f5ede4;
            --text-muted:#c9b8a8;
        }
        *{box-sizing:border-box;margin:0;padding:0;}
        body{
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(180deg,var(--bg-dark),var(--bg-darker));
            color: var(--text-light);
            min-height:100vh;
            padding-bottom: 90px;
        }
        .container{max-width:720px;margin:0 auto;padding:20px;}
        header.topbar{
            display:flex;align-items:center;justify-content:space-between;
            padding:16px 20px;position:sticky;top:0;
            background:rgba(42,24,16,0.92);backdrop-filter:blur(6px);
            z-index:50;border-bottom:1px solid rgba(255,255,255,0.08);
        }
        header.topbar h1{font-size:1.2rem;}
        header.topbar h1 span{color:var(--accent-light);}
        .back-link{color:var(--text-light);text-decoration:none;font-size:1.3rem;}
        .cart-fab{
            position:relative;color:var(--text-light);text-decoration:none;font-size:1.4rem;
        }
        .cart-fab .badge{
            position:absolute;top:-8px;right:-10px;background:var(--accent);
            color:#241008;font-size:0.7rem;font-weight:bold;border-radius:50%;
            min-width:18px;height:18px;display:flex;align-items:center;justify-content:center;
            padding:0 4px;
        }
        .card{
            background:var(--bg-card);border:1px solid rgba(255,255,255,0.08);
            border-radius:16px;padding:16px;
        }
        .btn{
            display:inline-block;background:var(--accent);color:#241008;
            font-weight:700;border:none;border-radius:12px;padding:12px 20px;
            text-align:center;text-decoration:none;cursor:pointer;font-size:1rem;
            transition:transform .15s ease, opacity .15s ease;
        }
        .btn:hover{transform:translateY(-1px);opacity:.92;}
        .btn-block{display:block;width:100%;}
        .btn-outline{
            background:transparent;border:1px solid var(--accent);color:var(--accent-light);
        }
        .muted{color:var(--text-muted);}
        .flash{
            background:rgba(224,138,62,0.15);border:1px solid var(--accent);
            color:var(--accent-light);padding:10px 14px;border-radius:10px;margin-bottom:14px;font-size:0.9rem;
        }
        .flash.error{
            background:rgba(220,60,60,0.15);border-color:#dc3c3c;color:#ff9b9b;
        }
        .bottom-cart-bar{
            position:fixed;bottom:0;left:0;right:0;
            background:rgba(20,12,8,0.97);border-top:1px solid rgba(255,255,255,0.1);
            padding:14px 20px;display:flex;align-items:center;justify-content:space-between;
            z-index:60;
        }
        .bottom-cart-bar a{flex:1;margin-left:14px;}
    </style>
    @stack('styles')
</head>
<body>

    <header class="topbar">
        <div style="display:flex;align-items:center;gap:10px;">
            @hasSection('back')
                <a href="@yield('back')" class="back-link">&larr;</a>
            @endif
            <h1>@yield('header', 'Kedai Kopi')</h1>
        </div>

        @if(session('meja_id'))
            <a href="{{ route('cart.show') }}" class="cart-fab">
                🛒
                @if(session('keranjang') && count(session('keranjang')) > 0)
                    <span class="badge">{{ count(session('keranjang')) }}</span>
                @endif
            </a>
        @endif
    </header>

    <div class="container">
        @if(session('success'))
            <div class="flash">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="flash error">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="flash error">{{ $errors->first() }}</div>
        @endif

        @yield('content')
    </div>

    @yield('bottom')

    @stack('scripts')
</body>
</html>
