@extends('admin.layout')

@section('title', 'Tambah Menu')

@section('content')
    <h3 class="fw-bold mb-4">Tambah Menu</h3>

    <div class="table-wrap" style="max-width: 600px;">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data" class="py-2">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold">Kategori</label>
                <select name="kategori_id" class="form-select" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($kategori as $k)
                        <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Menu</label>
                <input type="text" name="nama_menu" class="form-control" value="{{ old('nama_menu') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Harga</label>
                <input type="number" name="harga" class="form-control" value="{{ old('harga') }}" min="0" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Stok</label>
                <input type="number" name="stok" class="form-control" value="{{ old('stok', 0) }}" min="0" required>
                <small class="text-muted">Status stok (Tersedia/Habis) otomatis mengikuti angka ini.</small>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Foto</label>
                <input type="file" name="foto" class="form-control" accept="image/*">
            </div>

            <button type="submit" class="btn btn-coffee">Simpan</button>
            <a href="{{ route('admin.menu.index') }}" class="btn btn-outline-secondary">Batal</a>
        </form>
    </div>
@endsection
