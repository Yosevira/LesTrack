<h3>Tugas Siswa: <?= esc($siswa['nama']) ?></h3>

<?php if (session()->getFlashdata('success')): ?>
<div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif ?>

<table class="table">
    <thead>
        <tr>
            <th>Mapel</th>
            <th>Deadline</th>
            <th>Keterangan</th>
            <th>Status</th>
            <th>Bukti</th>
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
                    <select name="status" class="form-select">
                        <option <?= $t['status']=='belum'?'selected':'' ?>>belum</option>
                        <option <?= $t['status']=='selesai'?'selected':'' ?>>selesai</option>
                    </select>
                </td>
                <td>
                    <?php if ($t['file_bukti']): ?>
                    <a href="/uploads/<?= $t['file_bukti'] ?>" target="_blank">📎</a>
                    <?php else: ?>
                    <input type="file" name="file_bukti" class="form-control form-control-sm">
                    <?php endif ?>
                </td>
                <td><button type="submit" class="btn btn-primary btn-sm">✔ Simpan</button></td>
            </form>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>