<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - SiPustaka</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
    min-height: 100vh;
    display: flex;
    align-items: center;
    background:
    linear-gradient(rgba(0,0,0,.45), rgba(0,0,0,.45)),
    url('{{ asset('images/bg-login.jpg') }}') center / cover no-repeat fixed;
}
        .auth-card {
    border: 0;
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.50);
    box-shadow: 0 10px 30px rgba(0, 0, 0, .2);
}
    </style>
</head>
<body>
<div class="container"> 
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="text-center text-white mb-4">
                <h1 class="fw-bold"><i class="bi bi-book-half"></i> SiPustaka</h1>
                <p class="mb-0">Sistem Informasi Perpustakaan Kampus</p>
            </div>
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="card auth-card">
                <div class="card-body p-4">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>