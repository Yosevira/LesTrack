<!-- Modal Tambah Tugas -->
<div class="modal fade <?= session('errors') ? 'show d-block' : '' ?>" id="modalTambahTugas" tabindex="-1"
    aria-labelledby="modalTambahLabel" aria-hidden="<?= session('errors') ? 'false' : 'true' ?>">
    <div class="modal-dialog modal-dialog-centered">
        <form method="post" action="/ortu/tugas/add" class="modal-content" novalidate>
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalTambahLabel">Tambah Tugas</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">

                <!-- Mapel -->
                <div class="mb-3">
                    <label class="form-label">Mapel</label>
                    <input type="text" name="mapel"
                        class="form-control <?= session('errors.mapel') ? 'is-invalid' : '' ?>"
                        value="<?= old('mapel') ?>" required>
                    <?php if(session('errors.mapel')): ?>
                    <div class="invalid-feedback">
                        <?= session('errors.mapel') ?>
                    </div>
                    <?php endif ?>
                </div>

                <!-- Deadline -->
                <div class="mb-3">
                    <label class="form-label">Deadline</label>
                    <input type="date" name="deadline"
                        class="form-control <?= session('errors.deadline') ? 'is-invalid' : '' ?>"
                        value="<?= old('deadline') ?>" required>
                    <?php if(session('errors.deadline')): ?>
                    <div class="invalid-feedback">
                        <?= session('errors.deadline') ?>
                    </div>
                    <?php endif ?>
                </div>

                <!-- Keterangan -->
                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <input type="text" name="keterangan"
                        class="form-control <?= session('errors.keterangan') ? 'is-invalid' : '' ?>"
                        value="<?= old('keterangan') ?>" required>
                    <?php if(session('errors.keterangan')): ?>
                    <div class="invalid-feedback">
                        <?= session('errors.keterangan') ?>
                    </div>
                    <?php endif ?>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>