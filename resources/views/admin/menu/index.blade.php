@extends('admin.layout')

@section('title', 'Kelola Menu')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Kelola Menu</h3>
        <a href="{{ route('admin.menu.create') }}" class="btn btn-coffee">
            <i class="bi bi-plus-lg"></i> Tambah Menu
        </a>
    </div>

    <div class="table-wrap p-4 shadow-sm" style="background: #fff; border-radius: 16px;">
        <div class="table-responsive">
            <table class="table align-middle mb-0 table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Foto</th>
                        <th>Nama Menu</th>
                        <th>Kategori</th>
                        <th class="text-end">Harga</th>
                        <th class="text-center">Stok</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($menu as $m)
                        <tr>
                            <td>
                                @if ($m->foto)
                                    {{-- Cek apakah foto ada di storage atau di folder img --}}
                                    <img src="{{ file_exists(public_path('storage/' . $m->foto)) ? asset('storage/' . $m->foto) : asset('img/' . $m->foto) }}" 
                                         alt="{{ $m->nama_menu }}" 
                                         width="50" height="50" 
                                         style="object-fit:cover; border-radius:8px; border: 1px solid #ddd;">
                                @else
                                    <span class="text-muted small">No Image</span>
                                @endif
                            </td>
                            <td>{{ $m->nama_menu }}</td>
                            <td>{{ $m->kategori->nama_kategori ?? '-' }}</td>
                            <td class="text-end">Rp {{ number_format($m->harga, 0, ',', '.') }}</td>
                            <td class="text-center">{{ $m->stok }}</td>
                            <td class="text-center">
                                <span class="badge {{ $m->status_stok === 'Tersedia' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} rounded-pill">
                                    {{ $m->status_stok }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.menu.edit', $m->id) }}" class="btn btn-sm btn-outline-secondary rounded-circle">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.menu.destroy', $m->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin hapus menu {{ $m->nama_menu }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">Belum ada menu.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection