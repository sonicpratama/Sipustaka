@php
    $isEdit = isset($buku);
    $fields = [
        'judul'        => ['Judul Buku', 'text'],
        'penulis'      => ['Penulis', 'text'],
        'penerbit'     => ['Penerbit', 'text'],
        'tahun_terbit' => ['Tahun Terbit', 'number'],
        'stok'         => ['Stok', 'number'],
    ];
@endphp

@extends('layouts.app')
@section('title', $isEdit ? 'Ubah Buku' : 'Tambah Buku')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-journal-plus"></i> {{ $isEdit ? 'Ubah Buku' : 'Tambah Buku' }}
            </div>
            <div class="card-body">
                <form action="{{ $isEdit ? route('buku.update', $buku) : route('buku.store') }}" method="POST" novalidate>
                    @csrf
                    @if ($isEdit) @method('PUT') @endif

                    @foreach ($fields as $name => [$label, $type])
                        <div class="mb-3">
                            <label class="form-label">{{ $label }}</label>
                            <input type="{{ $type }}" name="{{ $name }}"
                                   value="{{ old($name, $isEdit ? $buku->$name : '') }}"
                                   class="form-control @error($name) is-invalid @enderror">
                            @error($name) <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    @endforeach

                    <div class="d-flex gap-2">
                        <button class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
                        <a href="{{ route('buku.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
