@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
    <h3 class="fw-bold mb-4">Dashboard Statistik</h3>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card card-stat p-3">
                <div class="text-muted small">Pesanan Hari Ini</div>
                <div class="fs-4 fw-bold">{{ $pesananHariIni }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-stat p-3">
                <div class="text-muted small">Penjualan Hari Ini</div>
                <div class="fs-4 fw-bold">Rp {{ number_format($penjualanHariIni, 0, ',', '.') }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-stat p-3">
                <div class="text-muted small">Menu Aktif</div>
                <div class="fs-4 fw-bold">{{ $totalMenu }} <span class="fs-6 text-danger">({{ $menuHabis }} habis)</span></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-stat p-3">
                <div class="text-muted small">Meja Terisi</div>
                <div class="fs-4 fw-bold">{{ $mejaTerisi }} / {{ $totalMeja }}</div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card card-stat p-3 text-center">
                <div class="text-muted small">Pending</div>
                <div class="fs-3 fw-bold">{{ $pesananPending }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-stat p-3 text-center">
                <div class="text-muted small">Memasak</div>
                <div class="fs-3 fw-bold">{{ $pesananMemasak }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-stat p-3 text-center">
                <div class="text-muted small">Selesai (belum dibayar)</div>
                <div class="fs-3 fw-bold">{{ $pesananSelesai }}</div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-7">
            <h6 class="fw-bold mb-2">Penjualan 7 Hari Terakhir</h6>
            <div class="table-wrap">
                <table class="table mb-0">
                    <thead><tr><th>Tanggal</th><th class="text-end">Total Penjualan</th></tr></thead>
                    <tbody>
                        @foreach ($penjualan7Hari as $p)
                            <tr>
                                <td>{{ $p['tanggal'] }}</td>
                                <td class="text-end">Rp {{ number_format($p['total'], 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-5">
            <h6 class="fw-bold mb-2">Top 5 Menu Terlaris</h6>
            <div class="table-wrap">
                <table class="table mb-0">
                    <thead><tr><th>Menu</th><th class="text-center">Qty Terjual</th></tr></thead>
                    <tbody>
                        @forelse ($menuTerlaris as $m)
                            <tr>
                                <td>{{ $m['nama'] }}</td>
                                <td class="text-center">{{ $m['qty'] }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="2" class="text-center text-muted">Belum ada data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
