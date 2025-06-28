<?= view('layout/header') ?>

<h3>Detail Siswa: <?= esc($siswa['nama_anak']) ?></h3>

<h4>Jadwal Harian</h4>
<ul class="list-group mb-4">
    <?php foreach ($jadwal as $j): ?>
    <li class="list-group-item">
        <?= esc($j['hari']) ?> - <?= esc($j['mapel']) ?>
    </li>
    <?php endforeach ?>
</ul>

<h4>Daftar Tugas</h4>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Mapel</th>
            <th>Deadline</th>
            <th>Keterangan</th>
            <th>Status</th>
            <th>Bukti</th>
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
                <a href="/uploads/<?= esc($t['file']) ?>" target="_blank">📎 Lihat File</a>
                <?php else: ?>
                <span class="text-muted">Belum ada</span>
                <?php endif ?>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>

<a href="/guru/dashboard" class="btn btn-secondary mt-3">← Kembali</a>

<?= view('layout/footer') ?>