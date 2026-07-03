@extends('admin.layout')

@section('title', 'Tambah Meja')

@section('content')
    <h3 class="fw-bold mb-4">Tambah Meja</h3>

    <div class="table-wrap" style="max-width: 500px;">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.meja.store') }}" method="POST" class="py-2">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold">Nomor Meja</label>
                <input type="text" name="nomor_meja" class="form-control" value="{{ old('nomor_meja') }}" placeholder="Contoh: M01" required>
            </div>

            <button type="submit" class="btn btn-coffee">Simpan</button>
            <a href="{{ route('admin.meja.index') }}" class="btn btn-outline-secondary">Batal</a>
        </form>
    </div>
@endsection
