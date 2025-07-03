<?= view('layout/header') ?>

<!-- Header & Tombol Tambah -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Daftar Tugas Anak</h4>
    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahTugas">
        Tambah Tugas
    </button>
</div>

<!-- Tabel Tugas -->
<div class="card border">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm table-bordered align-middle mb-0">
                <thead class="table-light">
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
                        <td><?= date('d-m-Y', strtotime($t['deadline'])) ?></td>
                        <td><?= esc($t['keterangan']) ?></td>
                        <td>
                            <span class="badge <?= $t['status'] == 'selesai' ? 'bg-success' : 'bg-secondary' ?>">
                                <?= ucfirst($t['status']) ?>
                            </span>
                        </td>
                        <td>
                            <?php if (!empty($t['file'])): ?>
                            <a href="/uploads/<?= esc($t['file']) ?>" target="_blank">
                                <img src="/uploads/<?= esc($t['file']) ?>" alt="Bukti Tugas" width="80"
                                    class="img-thumbnail">
                            </a>

                            <?php else: ?>
                            <span class="text-muted">-</span>
                            <?php endif ?>
                        </td>
                        <td>
                            <a href="/ortu/tugas/edit/<?= $t['id'] ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
                            <a href="/ortu/tugas/delete/<?= $t['id'] ?>" class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('Yakin ingin menghapus tugas ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= view('modal/tambah_tugas') ?>
<?= view('layout/footer') ?>