<?= view('layout/header') ?>
<h3>Jadwal Harian Anak</h3>

<?php if(session('error')): ?>
<div class="alert alert-danger"><?= session('error') ?></div>
<?php endif ?>

<!-- Form input mapel -->
<form method="post" action="/ortu/jadwal/add" class="row g-3 align-items-end">
    <div class="col-md-3">
        <label>Hari</label>
        <select name="hari" class="form-select" required>
            <option value="">--Pilih Hari--</option>
            <?php foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $h): ?>
            <option value="<?= $h ?>"><?= $h ?></option>
            <?php endforeach ?>
        </select>
    </div>
    <div class="col-md-6">
        <label>Nama Mapel</label>
        <input type="text" name="mapel" class="form-control" required>
    </div>
    <div class="col-md-3">
        <button type="submit" class="btn btn-success w-100">Tambah Jadwal</button>
    </div>
</form>

<hr>

<!-- Tampilkan jadwal per hari -->
<div class="row">
    <?php
$hariList = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
foreach ($hariList as $hari):
?>
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header bg-dark text-white"><?= $hari ?></div>
            <div class="card-body">
                <ul class="list-group">
                    <?php
          foreach ($jadwal as $j) {
            if ($j['hari'] === $hari) {
             $mapelKey = strtolower($j['mapel']);
                $adaTugas = isset($tugasMapel[$mapelKey]);

        ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?= esc($j['mapel']) ?>
                        <div>
                            <?php if ($adaTugas): ?>
                            <a href="/ortu/tugas" class="badge bg-warning text-dark text-decoration-none">Tugas</a>
                            <?php endif ?>
                            <a href="/ortu/jadwal/delete/<?= $j['id'] ?>" class="btn btn-sm btn-danger">🗑</a>
                        </div>
                    </li>
                    <?php }} ?>
                </ul>
                <a href="/ortu/jadwal/edit/<?= $hari ?>" class="btn btn-sm btn-outline-primary mt-2">✏ Edit Hari</a>
            </div>
        </div>
    </div>
    <?php endforeach ?>
</div>

<?= view('layout/footer') ?>