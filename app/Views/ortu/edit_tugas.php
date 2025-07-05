<?= view('layout/header') ?>

<div class="container">
    <h4 class="mb-4">Edit Tugas</h4>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="post" action="/ortu/tugas/update/<?= $tugas['id'] ?>">
                <div class="mb-3">
                    <label class="form-label">Mapel</label>
                    <input type="text" name="mapel" class="form-control" value="<?= esc($tugas['mapel']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deadline</label>
                    <input type="date" name="deadline" class="form-control" value="<?= esc($tugas['deadline']) ?>"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <input type="text" name="keterangan" class="form-control" value="<?= esc($tugas['keterangan']) ?>">
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-outline-primary">Update</button>
                    <a href="/ortu/tugas" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?= view('layout/footer') ?>