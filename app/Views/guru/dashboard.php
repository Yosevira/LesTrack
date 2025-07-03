<?= view('layout/header') ?>

<h3>Dashboard Guru</h3>
<p>Daftar siswa (akun orang tua):</p>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nama Anak</th>
            <th>Nama Orang Tua</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($siswa as $row): ?>
        <tr>
            <td><?= esc($row['nama_anak']) ?></td>
            <td><?= esc($row['nama_ortu']) ?></td>
            <td>
                <a href="/guru/siswa/<?= $row['id'] ?>" class="btn btn-primary btn-sm mb-1">📅 Lihat Jadwal</a>
                <a href="/guru/tugas/<?= $row['id'] ?>" class="btn btn-warning btn-sm">📋 Lihat Tugas</a>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?= view('layout/footer') ?>