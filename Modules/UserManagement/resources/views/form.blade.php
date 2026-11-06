@php
    $isEdit = isset($user);
    $isSelf = $isEdit && $user->id === auth()->id();
@endphp

@extends('layouts.app')
@section('title', $isEdit ? 'Ubah User' : 'Tambah User')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-person-gear"></i> {{ $isEdit ? 'Ubah User' : 'Tambah User' }}
            </div>
            <div class="card-body">
                <form action="{{ $isEdit ? route('users.update', $user) : route('users.store') }}" method="POST" novalidate>
                    @csrf
                    @if ($isEdit) @method('PUT') @endif

                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="name" value="{{ old('name', $isEdit ? $user->name : '') }}"
                               class="form-control @error('name') is-invalid @enderror">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email', $isEdit ? $user->email : '') }}"
                               class="form-control @error('email') is-invalid @enderror">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select @error('role') is-invalid @enderror">
                            @foreach (['admin' => 'Admin', 'user' => 'User'] as $val => $label)
                                <option value="{{ $val }}" @selected(old('role', $isEdit ? $user->role : 'user') === $val)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        @if ($isSelf)
                            <div class="form-text">Anda tidak dapat menurunkan role akun Anda sendiri.</div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password @if ($isEdit) <small class="text-muted">(kosongkan jika tidak diganti)</small> @endif</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>

                    <div class="d-flex gap-2">
                        <button class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
                        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
