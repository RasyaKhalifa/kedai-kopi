@extends('admin.layout')

@section('title', 'Kelola Meja')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold mb-0">Kelola Meja & QR Code</h3>
    <a href="{{ route('admin.meja.create') }}" class="btn btn-coffee">
        <i class="bi bi-plus-circle me-2"></i>Tambah Meja
    </a>
</div>

<div class="table-wrap p-4 shadow-sm" style="background: #fff; border-radius: 16px;">
    <div class="table-responsive">
        <table class="table table-hover align-middle m-0">
            <thead class="table-light">
                <tr>
                    <th width="80">No</th>
                    <th>Nomor Meja</th>
                    <th>Status</th>
                    <th width="250" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($meja as $key => $item)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td><strong class="fs-5">Meja {{ $item->nomor_meja }}</strong></td>
                        <td>
                            @if($item->status_meja === 'Tersedia')
                                <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">Tersedia</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2">Terisi / Penuh</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="{{ route('admin.meja.qrcode', $item->id) }}" class="btn btn-sm btn-outline-dark">
                                    <i class="bi bi-qr-code-scan me-1"></i> QR Code
                                </a>
                                <a href="{{ route('admin.meja.edit', $item->id) }}" class="btn btn-sm btn-light text-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.meja.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus meja ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light text-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">Belum ada data meja.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection