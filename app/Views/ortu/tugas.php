<?= view('layout/header') ?>
<?php if (session('errors')): ?>
<script>
var modal = new bootstrap.Modal(document.getElementById('modalTambahTugas'));
modal.show();
</script>
<?php endif ?>

<!-- Header & Tombol Tambah -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Daftar Tugas Anak</h4>
    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahTugas">
        ➕ Tambah Tugas
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
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tugas as $t): ?>
                    <tr>
                        <td><?= esc($t['mapel']) ?></td>
                        <td><?= date('d-m-Y', strtotime($t['deadline'])) ?></td>
                        <td>
                            <a href="/ortu/tugas/detail/<?= $t['id'] ?>?from=tugas"
                                class="btn btn-sm btn-outline-info">Detail</a>
                            <?php if ($t['status'] !== 'selesai'): ?>
                            <a href="/ortu/tugas/delete/<?= $t['id'] ?>" class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('Anda yakin menghapus tugas ini?')">Hapus</a>
                            <?php endif ?>
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