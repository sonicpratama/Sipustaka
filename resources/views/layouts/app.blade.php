<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SiPustaka')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f4f6fb; }
.navbar-brand { font-weight: 700; letter-spacing: .5px; color: #0d6efd !important; }
.navbar { box-shadow: 0 2px 12px rgba(0, 0, 0, .12); }
.card { border: 0; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,.06); }
.navbar .nav-link.active { font-weight: 600; color: #0d6efd !important; text-decoration: underline; text-underline-offset: 6px; }
    </style>
    @stack('styles')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white">
    <div class="container">
        <a class="navbar-brand" href="{{ route('dashboard') }}"><i class="bi bi-book-half me-1"></i> SiPustaka</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav me-auto">
                @auth
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('buku.*') ? 'active' : '' }}" href="{{ route('buku.index') }}">Buku</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('peminjaman.*') ? 'active' : '' }}" href="{{ route('peminjaman.index') }}">Peminjaman</a>
                </li>
                @if (auth()->user()->isAdmin())
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">Kelola User</a>
                </li>
                @endif
                @endauth
            </ul>
            @auth
    <span class="navbar-text text-dark me-3">
        {{ auth()->user()->name }}
        <span class="badge bg-primary text-white text-uppercase">{{ auth()->user()->role }}</span>
    </span>
    <form action="{{ route('logout') }}" method="POST" class="d-inline">
        @csrf
        <button class="btn btn-outline-danger btn-sm"><i class="bi bi-box-arrow-right"></i> Logout</button>
    </form>
@endauth
        </div>
    </div>
</nav>

<main class="container py-4">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-1"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
