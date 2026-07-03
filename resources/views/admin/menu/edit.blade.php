@extends('admin.layout')

@section('title', 'Edit Menu')

@section('content')
    <h3 class="fw-bold mb-4">Edit Menu</h3>

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

        <form action="{{ route('admin.menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data" class="py-2">
            @csrf
            @method('PUT')

            @if(!empty($menu->foto))
                <div class="mb-4">
                    <label class="form-label fw-semibold text-muted">Foto Saat Ini</label>
                    <div class="menu-img-wrapper" style="width: 120px; height: 120px; border-radius: 16px; overflow: hidden; border: 2px solid #EDE8E0; background: #f8f8f8;">
                        <img src="{{ asset('img/' . $menu->foto) }}" class="w-100 h-100" style="object-fit: cover;" alt="{{ $menu->nama_menu }}">
                    </div>
                </div>
            @endif

            <div class="mb-3">
                <label class="form-label fw-semibold">Kategori</label>
                <select name="kategori_id" class="form-select" required>
                    @foreach ($kategori as $k)
                        <option value="{{ $k->id }}" {{ old('kategori_id', $menu->kategori_id) == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Menu</label>
                <input type="text" name="nama_menu" class="form-control" value="{{ old('nama_menu', $menu->nama_menu) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Harga</label>
                <input type="number" name="harga" class="form-control" value="{{ old('harga', $menu->harga) }}" min="0" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Stok</label>
                <input type="number" name="stok" class="form-control" value="{{ old('stok', $menu->stok) }}" min="0" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Ganti Foto (opsional)</label>
                <input type="file" name="foto" class="form-control" accept="image/*">
            </div>

            <button type="submit" class="btn btn-coffee">Simpan Perubahan</button>
            <a href="{{ route('admin.menu.index') }}" class="btn btn-outline-secondary">Batal</a>
        </form>
    </div>
@endsection