<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>LesTrack</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">LesTrack</a>
            <div class="collapse navbar-collapse">
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

    <div class="container mt-4">