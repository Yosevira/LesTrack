<?= view('layout/header') ?>

<h3>Daftar Tugas <?= esc($siswa['nama_anak']) ?></h3>

<?php if (session()->getFlashdata('success')): ?>
<div class="alert alert-success"><?= session('success') ?></div>
<?php endif ?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Mapel</th>
            <th>Deadline</th>
            <th>Keterangan</th>
            <th>Status</th>
            <th>Hasil</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tugas as $t): ?>
        <tr>
            <form method="post" action="/guru/tugas/update" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $t['id'] ?>">

                <td><?= esc($t['mapel']) ?></td>
                <td><?= esc($t['deadline']) ?></td>
                <td><?= esc($t['keterangan']) ?></td>

                <td>
                    <select name="status" class="form-select form-select-sm">
                        <option value="belum" <?= $t['status'] == 'belum' ? 'selected' : '' ?>>Belum</option>
                        <option value="selesai" <?= $t['status'] == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                    </select>
                </td>

                <td>
                    <?php if (!empty($t['file'])): ?>
                    <a href="/uploads/<?= esc($t['file']) ?>" target="_blank">
                        <img src="/uploads/<?= esc($t['file']) ?>" alt="Bukti Tugas" width="80" class="img-thumbnail">
                    </a>
                    <?php else: ?>
                    <input type="file" name="file" class="form-control form-control-sm">
                    <?php endif ?>
                </td>

                <td>
                    <button type="submit" class="btn btn-primary btn-sm">✔ Simpan</button>
                </td>
            </form>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?= view('layout/footer') ?>