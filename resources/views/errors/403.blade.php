@extends('layouts.app')
@section('title', '403 - Akses Ditolak')

@section('content')
<div class="card">
    <div class="card-body text-center py-5">
        <div class="display-1 text-danger"><i class="bi bi-shield-lock"></i></div>
        <h1 class="fw-bold mt-2">403</h1>
        <h5>Akses Ditolak</h5>
        <p class="text-muted">{{ $exception->getMessage() ?: 'Anda tidak memiliki hak akses ke halaman ini.' }}</p>
        <a href="{{ route('dashboard') }}" class="btn btn-primary"><i class="bi bi-house"></i> Kembali ke Dashboard</a>
    </div>
</div>
@endsection
