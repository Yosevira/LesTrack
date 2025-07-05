<?php
$hariList = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
?>
<!-- Modal Tambah Jadwal -->
<div class="modal fade <?= session('errors') ? 'show d-block' : '' ?>" id="modalTambahJadwal" tabindex="-1"
    aria-labelledby="modalLabel" aria-hidden="<?= session('errors') ? 'false' : 'true' ?>">
    <div class="modal-dialog modal-dialog-centered">
        <form method="post" action="/ortu/jadwal/add" class="modal-content" novalidate>
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalLabel">Tambah Jadwal</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">

                <!-- HARI -->
                <div class="mb-3">
                    <label class="form-label">Hari</label>
                    <select name="hari" class="form-control <?= session('errors.hari') ? 'is-invalid' : '' ?>" required>
                        <option value="">Pilih Hari</option>
                        <?php foreach ($hariList as $h): ?>
                        <option value="<?= $h ?>" <?= old('hari') == $h ? 'selected' : '' ?>><?= $h ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if(session('errors.hari')): ?>
                    <div class="invalid-feedback">
                        <?= session('errors.hari') ?>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- MAPEL -->
                <div class="mb-3">
                    <label class="form-label">Nama Mapel</label>
                    <input type="text" name="mapel"
                        class="form-control <?= session('errors.mapel') ? 'is-invalid' : '' ?>" placeholder="Matematika"
                        value="<?= old('mapel') ?>" required>
                    <?php if(session('errors.mapel')): ?>
                    <div class="invalid-feedback">
                        <?= session('errors.mapel') ?>
                    </div>
                    <?php endif; ?>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>