<?= view('layout/header') ?>

<h3>Daftar Tugas Anak</h3>

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
            <td><?= esc($t['mapel']) ?></td>
            <td><?= esc($t['deadline']) ?></td>
            <td><?= esc($t['keterangan']) ?></td>
            <td>
                <span class="badge <?= $t['status'] == 'selesai' ? 'bg-success' : 'bg-secondary' ?>">
                    <?= ucfirst($t['status']) ?>
                </span>
            </td>
            <td>
                <?php if ($t['file']): ?>
                <a href="/uploads/<?= $t['file'] ?>" target="_blank">📎 Bukti</a>
                <?php else: ?>
                <span class="text-muted">Belum ada</span>
                <?php endif ?>
            </td>
            <td>
                <a href="/ortu/tugas/edit/<?= $t['id'] ?>" class="btn btn-sm btn-warning">✏ Edit</a>
                <a href="/ortu/tugas/delete/<?= $t['id'] ?>" class="btn btn-sm btn-danger"
                    onclick="return confirm('Yakin hapus?')">🗑 Hapus</a>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>

<hr>
<h5>Tambah Tugas Baru</h5>
<form method="post" action="/ortu/tugas/add">
    <div class="row mb-3">
        <div class="col-md-4">
            <input type="text" name="mapel" class="form-control" placeholder="Nama Mapel" required>
        </div>
        <div class="col-md-3">
            <input type="date" name="deadline" class="form-control" required>
        </div>
        <div class="col-md-5">
            <input type="text" name="keterangan" class="form-control" placeholder="Keterangan Tugas">
        </div>
    </div>
    <button type="submit" class="btn btn-success">Tambah Tugas</button>
</form>

<td>
    <?php if (!empty($t['file'])): ?>
    <a href="/uploads/<?= esc($t['file']) ?>" target="_blank">📎 Bukti</a>
    <?php else: ?>
    <span class="text-muted">Belum ada</span>
    <?php endif ?>
</td>


<?= view('layout/footer') ?>