@extends('layouts.app')
@section('title', 'Data Buku')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <h4 class="mb-0"><i class="bi bi-journal-bookmark"></i> Data Buku</h4>
    @if (auth()->user()->isAdmin())
        <a href="{{ route('buku.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Buku</a>
    @endif
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('buku.index') }}" class="row g-2">
            <div class="col-md-9">
                <input type="text" name="q" value="{{ $keyword }}" class="form-control"
                       placeholder="Cari judul, penulis, atau penerbit...">
            </div>
            <div class="col-md-3 d-grid d-md-flex gap-2">
                <button class="btn btn-primary flex-fill"><i class="bi bi-search"></i> Cari</button>
                @if ($keyword !== '')
                    <a href="{{ route('buku.index') }}" class="btn btn-outline-secondary">Reset</a>
                @endif
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width:60px">No</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Penerbit</th>
                    <th>Tahun</th>
                    <th>Stok</th>
                    @if (auth()->user()->isAdmin())
                        <th class="text-end" style="width:150px">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($buku as $item)
                    <tr>
                        <td>{{ $buku->firstItem() + $loop->index }}</td>
                        <td class="fw-semibold">{{ $item->judul }}</td>
                        <td>{{ $item->penulis }}</td>
                        <td>{{ $item->penerbit }}</td>
                        <td>{{ $item->tahun_terbit }}</td>
                        <td>
                            <span class="badge {{ $item->stok > 0 ? 'bg-success' : 'bg-danger' }}">{{ $item->stok }}</span>
                        </td>
                        @if (auth()->user()->isAdmin())
                            <td class="text-end">
                                <a href="{{ route('buku.edit', $item) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('buku.destroy', $item) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus buku &quot;{{ $item->judul }}&quot;?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Data buku tidak ditemukan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($buku->hasPages())
        <div class="card-footer bg-white">{{ $buku->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
