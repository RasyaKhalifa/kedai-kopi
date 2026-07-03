@extends('admin.layout')

@section('title', 'QR Code Meja ' . $meja->nomor_meja)

@section('content')
    <h3 class="fw-bold mb-4 no-print">QR Code — Meja {{ $meja->nomor_meja }}</h3>

    <div class="table-wrap text-center border p-4 shadow-sm" style="max-width: 400px; background: #fff; border-radius: 16px; margin-bottom: 20px;">
        <div class="print-only mb-3 text-center">
            <h2 class="fw-bold m-0">☕ KEDAI KOPI</h2>
            <small class="text-muted">Silakan Scan untuk Memesan</small>
            <hr class="my-2" style="border-top: 2px dashed #2C1810;">
        </div>

        <h1 class="fw-bold my-2 text-dark display-5">MEJA {{ $meja->nomor_meja }}</h1>

        <div class="my-4 p-3 bg-white d-inline-block border rounded-3">
            <img src="{{ $qrImageUrl }}" alt="QR Meja {{ $meja->nomor_meja }}" class="img-fluid" id="qr-image" style="width: 220px; height: 220px;">
        </div>

        <p class="text-muted small mb-4">
            Scan untuk membuka menu langsung dengan meja terisi otomatis:<br>
            <a href="{{ $urlMenu }}" target="_blank" class="text-decoration-none fw-bold text-dark">{{ $urlMenu }}</a>
        </p>

        <div class="no-print d-flex gap-2 justify-content-center">
            <button onclick="window.print()" class="btn btn-coffee px-4">
                <i class="bi bi-printer me-1"></i> Cetak QR
            </button>
            <a href="{{ route('admin.meja.index') }}" class="btn btn-outline-secondary px-4">Kembali</a>
        </div>
    </div>

    <style>
        .print-only { display: none; }
        
        @media print {
            .sidebar, .alert, .no-print, h3.fw-bold { display: none !important; }
            .main-content { margin-left: 0 !important; padding: 0 !important; }
            .print-only { display: block !important; }
            .table-wrap { 
                border: none !important; 
                box-shadow: none !important; 
                max-width: 100% !important;
                margin: 0 auto;
                padding-top: 30px !important;
            }
            body { background: #fff !important; }
        }
    </style>
@endsection