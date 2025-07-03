<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>LesTrack</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
    body {
        background-color: #f8f9fa;
    }

    .navbar-custom {
        background-color: #0d6efd;
    }

    .navbar-brand {
        font-weight: 600;
        color: #fff;
    }

    .nav-link {
        color: #fff !important;
    }

    .nav-link:hover {
        text-decoration: underline;
    }

    .btn-primary,
    .btn-success,
    .btn-warning,
    .btn-danger {
        border-radius: 0.3rem;
    }

    .table-hover tbody tr:hover {
        background-color: #eef6ff;
    }
    </style>
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-custom shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">LesTrack</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon bg-light"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php if(session('isLoggedIn')): ?>
                    <?php if(session('role') === 'ortu'): ?>
                    <li class="nav-item"><a class="nav-link" href="/ortu/dashboard">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="/ortu/jadwal">Jadwal</a></li>
                    <li class="nav-item"><a class="nav-link" href="/ortu/tugas">Tugas</a></li>
                    <li class="nav-item"><a class="nav-link" href="/ortu/profil">Profil</a></li>
                    <?php elseif(session('role') === 'guru'): ?>
                    <li class="nav-item"><a class="nav-link" href="/guru/dashboard">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="/guru/absensi">Absensi</a></li>
                    <?php endif ?>
                    <?php endif ?>
                </ul>

                <ul class="navbar-nav">
                    <?php if(session('isLoggedIn')): ?>
                    <li class="nav-item">
                        <a class="nav-link text-warning" href="/logout">Logout</a>
                    </li>
                    <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="/login">Login</a></li>
                    <?php endif ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- CONTENT -->
    <div class="container mt-4">