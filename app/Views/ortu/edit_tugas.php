<?= view('layout/header') ?>

<h3>Edit Tugas</h3>

<form method="post" action="/ortu/tugas/update/<?= $tugas['id'] ?>">
    <div class="mb-3">
        <label>Mapel</label>
        <input type="text" name="mapel" class="form-control" value="<?= esc($tugas['mapel']) ?>" required>
    </div>
    <div class="mb-3">
        <label>Deadline</label>
        <input type="date" name="deadline" class="form-control" value="<?= esc($tugas['deadline']) ?>" required>
    </div>
    <div class="mb-3">
        <label>Keterangan</label>
        <input type="text" name="keterangan" class="form-control" value="<?= esc($tugas['keterangan']) ?>">
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="/ortu/tugas" class="btn btn-secondary">Batal</a>
</form>

<?= view('layout/footer') ?>