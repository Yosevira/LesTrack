<?= view('layout/header') ?>

<h3>Absensi Harian</h3>

<?php if(session('success')): ?>
<div class="alert alert-success"><?= session('success') ?></div>
<?php endif ?>

<form method="post" action="/guru/absensi/simpan">
    <div class="mb-3">
        <label for="tanggal">Tanggal</label>
        <input type="date" name="tanggal" class="form-control" required>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Siswa</th>
                <th>Status Kehadiran</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($siswa as $s): ?>
            <tr>
                <td><?= esc($s['nama_anak']) ?></td>
                <td>
                    <select name="status[<?= $s['id'] ?>]" class="form-select" required>
                        <option value="hadir">Hadir</option>
                        <option value="sakit">Sakit</option>
                        <option value="izin">Izin</option>
                        <option value="alfa">Alfa</option>
                    </select>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <button type="submit" class="btn btn-primary">Simpan Absensi</button>
</form>

<?= view('layout/footer') ?>