<?= view('layout/header') ?>

<h3>Dashboard Guru</h3>
<p>Daftar siswa :</p>

<table class="table table-bordered table-striped">
    <thead class="table-light">
        <tr>
            <th>Nama Anak</th>
            <th>Nama Orang Tua</th>
            <th>Kelas</th> <!-- Tambahan -->
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($siswa as $row): ?>
        <tr>
            <td><?= esc($row['nama_anak']) ?></td>
            <td><?= esc($row['nama_ortu']) ?></td>
            <td><?= esc($row['kelas']) ?></td> <!-- Tambahan -->
            <td>
                <a href="/guru/siswa/<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary">Jadwal</a>
                <a href="/guru/tugas/<?= $row['id'] ?>" class="btn btn-sm btn-outline-secondary">Tugas</a>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?= view('layout/footer') ?>