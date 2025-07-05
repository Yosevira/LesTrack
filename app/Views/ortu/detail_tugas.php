<?= view('layout/header') ?>

<div class="container">
    <h4 class="mb-4">Detail Tugas</h4>

    <div class="card border shadow-sm">
        <div class="card-body">
            <table class="table table-bordered mb-3">
                <tr>
                    <th width="150">Mapel</th>
                    <td><?= esc($tugas['mapel']) ?></td>
                </tr>
                <tr>
                    <th>Deadline</th>
                    <td><?= date('d-m-Y', strtotime($tugas['deadline'])) ?></td>
                </tr>
                <tr>
                    <th>Keterangan</th>
                    <td><?= esc($tugas['keterangan']) ?></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <span class="badge <?= $tugas['status'] == 'selesai' ? 'bg-success' : 'bg-secondary' ?>">
                            <?= ucfirst($tugas['status']) ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>File Bukti</th>
                    <td>
                        <?php if (!empty($tugas['file'])): ?>
                        <a href="/uploads/<?= esc($tugas['file']) ?>" target="_blank">
                            <img src="/uploads/<?= esc($tugas['file']) ?>" width="100" class="img-thumbnail">
                        </a>
                        <?php else: ?>
                        <span class="text-muted">Belum ada</span>
                        <?php endif ?>
                    </td>
                </tr>
            </table>

            <div class="d-flex gap-2">
                <?php if ($tugas['status'] !== 'selesai'): ?>
                <a href="/ortu/tugas/edit/<?= $tugas['id'] ?>" class="btn btn-outline-warning">Edit</a>
                <a href="/ortu/tugas/delete/<?= $tugas['id'] ?>" class="btn btn-outline-danger"
                    onclick="return confirm('Yakin ingin menghapus tugas ini?')">Hapus</a>
                <?php endif ?>
                <?php
                    $from = $_GET['from'] ?? 'tugas'; // default ke halaman tugas
                    $backUrl = $from === 'dashboard' ? '/ortu/dashboard' : '/ortu/tugas';
                    ?>
                <a href="<?= $backUrl ?>" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>

<?= view('layout/footer') ?>