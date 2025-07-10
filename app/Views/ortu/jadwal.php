<?= view('layout/header') ?>
<h3>Jadwal Harian Anak</h3>

<!-- Tombol Tambah -->
<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahJadwal">
    ➕ Tambah Jadwal
</button>
<?= view('modal/tambah_jadwal') ?>

<!-- Tampilkan Jadwal -->
<div class="row">
    <?php $hariList = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu']; ?>
    <?php foreach ($hariList as $hari): ?>
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <span><?= $hari ?></span>
                <a href="/ortu/jadwal/edit/<?= $hari ?>" class="btn btn-sm btn-light">Edit</a>
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
                            <a href="/ortu/tugas" class="badge bg-warning text-dark text-decoration-none">Tugas</a>
                            <?php endif ?>
                            <a href="/ortu/jadwal/delete/<?= $j['id'] ?>" class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('Anda yakin menghapus mapel ini?')">Hapus</a>
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

<?= view('modal/edit_jadwal', ['jadwal' => $jadwal, 'hari' => $hari]) ?>

<?= view('layout/footer') ?>