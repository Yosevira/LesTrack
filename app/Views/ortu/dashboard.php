<?= view('layout/header') ?>

<div class="p-5 text-center bg-light rounded-3"
    style="background-image: url('https://images.unsplash.com/photo-1543269865-cbf427effbad'); background-size: cover; color: white;">
    <div class="bg-dark bg-opacity-50 p-4 rounded">
        <h1>Selamat Datang, <?= session('nama') ?></h1>
        <p class="lead">Selamat memantau kegiatan anak Anda di LesTrack!</p>
    </div>
</div>

<?= view('layout/footer') ?>