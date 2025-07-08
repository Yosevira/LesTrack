<?= view('layout/header') ?>

<h4 class="mb-4">📅 Jadwal Harian <?= esc($siswa['nama_anak']) ?></h4>

<?php if(session('error')): ?>
<div class="alert alert-danger"><?= session('error') ?></div>
<?php endif ?>

<!-- Tampilkan Jadwal -->
<div class="row">
    <?php $hariList = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu']; ?>
    <?php foreach ($hariList as $hari): ?>
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <span><?= $hari ?></span>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <?php foreach ($jadwal as $j): ?>
                    <?php if ($j['hari'] === $hari): ?>
                    <?php $mapelKey = strtolower($j['mapel']); ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?= esc($j['mapel']) ?>
                        <div>
                            <?php if (isset($tugasMapel[$mapelKey])): ?>
                            <a href="<?= site_url('guru/tugas/' . $siswa['id']) ?>" class=" badge bg-warning text-dark
                                text-decoration-none">Tugas</a>

                            <?php endif ?>
                        </div>
                    </li>
                    <?php endif ?>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>
    </div>
    <?php endforeach ?>
</div>

<?= view('layout/footer') ?>