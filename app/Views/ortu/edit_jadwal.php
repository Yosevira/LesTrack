<?= view('layout/header') ?>
<h3>Edit Jadwal Hari <?= esc($hari) ?></h3>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Mapel</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($jadwal as $j): ?>
        <tr>
            <form method="post" action="/ortu/jadwal/update">
                <td>
                    <input type="hidden" name="id" value="<?= $j['id'] ?>">
                    <input type="text" name="mapel" value="<?= esc($j['mapel']) ?>" class="form-control">
                </td>
                <td>
                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                    <a href="/ortu/jadwal/delete/<?= $j['id'] ?>" class="btn btn-sm btn-danger">🗑</a>
                </td>
            </form>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>

<a href="/ortu/jadwal" class="btn btn-secondary">← Kembali ke Jadwal</a>
<?= view('layout/footer') ?>