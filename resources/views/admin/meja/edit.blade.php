@extends('admin.layout')

@section('title', 'Edit Meja')

@section('content')
    <h3 class="fw-bold mb-4">Edit Meja</h3>

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

        <form action="{{ route('admin.meja.update', $meja->id) }}" method="POST" class="py-2">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-semibold">Nomor Meja</label>
                <input type="text" name="nomor_meja" class="form-control" value="{{ old('nomor_meja', $meja->nomor_meja) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Status Meja</label>
                <select name="status_meja" class="form-select" required>
                    <option value="Tersedia" {{ $meja->status_meja === 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="Terisi" {{ $meja->status_meja === 'Terisi' ? 'selected' : '' }}>Terisi</option>
                </select>
            </div>

            <button type="submit" class="btn btn-coffee">Simpan Perubahan</button>
            <a href="{{ route('admin.meja.index') }}" class="btn btn-outline-secondary">Batal</a>
        </form>
    </div>
@endsection
