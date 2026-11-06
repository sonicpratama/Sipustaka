@extends('layouts.guest')
@section('title', 'Login')

@section('content')
<h4 class="mb-4 text-center">Masuk</h4>
<form action="{{ route('login.store') }}" method="POST" novalidate>
    @csrf
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" value="{{ old('email') }}"
               class="form-control @error('email') is-invalid @enderror" placeholder="nama@email.com">
        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password"
               class="form-control @error('password') is-invalid @enderror">
        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="remember" id="remember">
        <label class="form-check-label" for="remember">Ingat saya</label>
    </div>
    <button class="btn btn-primary w-100">Login</button>
</form>
<p class="text-center mt-3 mb-0">Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p>
@endsection