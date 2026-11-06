@extends('layouts.app')
@section('title', 'Kelola User')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <h4 class="mb-0"><i class="bi bi-people"></i> Kelola User</h4>
    <a href="{{ route('users.create') }}" class="btn btn-primary"><i class="bi bi-person-plus"></i> Tambah User</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width:60px">No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th class="text-end" style="width:150px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $u)
                    <tr>
                        <td>{{ $users->firstItem() + $loop->index }}</td>
                        <td class="fw-semibold">
                            {{ $u->name }}
                            @if ($u->id === auth()->id()) <span class="badge bg-info text-dark">Anda</span> @endif
                        </td>
                        <td>{{ $u->email }}</td>
                        <td>
                            <span class="badge {{ $u->role === 'admin' ? 'bg-danger' : 'bg-secondary' }} text-uppercase">{{ $u->role }}</span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('users.edit', $u) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                            @if ($u->id !== auth()->id())
                                <form action="{{ route('users.destroy', $u) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus user &quot;{{ $u->name }}&quot;?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            @else
                                <button class="btn btn-sm btn-danger" disabled title="Tidak dapat menghapus akun sendiri"><i class="bi bi-trash"></i></button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if ($users->hasPages())
        <div class="card-footer bg-white">{{ $users->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
