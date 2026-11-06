@extends('layouts.guest')
@section('title', 'Register')

@section('content')
<h4 class="mb-4 text-center">Daftar Akun</h4>
<form action="{{ route('register.store') }}" method="POST" novalidate>
    @csrf
    <div class="mb-3">
        <label class="form-label">Nama Lengkap</label>
        <input type="text" name="name" value="{{ old('name') }}"
               class="form-control @error('name') is-invalid @enderror">
        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" value="{{ old('email') }}"
               class="form-control @error('email') is-invalid @enderror">
        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password"
               class="form-control @error('password') is-invalid @enderror">
        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="form-control">
    </div>
    <button class="btn btn-primary w-100">Daftar</button>
</form>
<p class="text-center mt-3 mb-0">Sudah punya akun? <a href="{{ route('login') }}">Login</a></p>
@endsection