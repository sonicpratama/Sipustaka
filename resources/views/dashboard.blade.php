@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="card">
    <div class="card-body p-4">
        <h4>Selamat datang, {{ auth()->user()->name }} 👋</h4>
        <p class="text-muted mb-0">
            Anda login sebagai <strong>{{ auth()->user()->role }}</strong>.
        </p>
    </div>
</div>
@endsection