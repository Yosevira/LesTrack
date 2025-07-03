<!-- Modal Edit Jadwal - <?= $hari ?> -->
<div class="modal fade" id="modalEdit<?= $hari ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="post" action="/ortu/jadwal/update" class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Edit Jadwal - <?= $hari ?></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <?php foreach ($jadwal as $j): ?>
                <?php if ($j['hari'] == $hari): ?>
                <input type="hidden" name="id[]" value="<?= $j['id'] ?>">
                <div class="input-group mb-2">
                    <input type="text" name="mapel[]" class="form-control" value="<?= esc($j['mapel']) ?>" required>
                    <a href="/ortu/jadwal/delete/<?= $j['id'] ?>" class="btn btn-outline-danger">🗑</a>
                </div>
                <?php endif ?>
                <?php endforeach ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>