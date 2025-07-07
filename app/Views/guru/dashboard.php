<?= view('layout/header') ?>

<h3>Dashboard Guru</h3>
<p>Daftar siswa :</p>

<form action="<?= base_url('guru/dashboard') ?>" method="get" class="mb-3">
    <div class="input-group">
        <input type="text" name="search" class="form-control" 
               placeholder="Cari berdasarkan Nama Anak, Orang Tua, atau Kelas..." 
               value="<?= esc($search ?? '') ?>">
        <button class="btn btn-primary" type="submit">Cari</button>
    </div>
</form>
<table class="table table-bordered table-striped">
    <thead class="table-light">
        <tr>
            <th>Nama Anak</th>
            <th>Nama Orang Tua</th>
            <th>Kelas</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($siswa)): ?>
            <?php foreach ($siswa as $row): ?>
            <tr>
                <td><?= esc($row['nama_anak']) ?></td>
                <td><?= esc($row['nama_ortu']) ?></td>
                <td><?= esc($row['kelas']) ?></td>
                <td>
                    <a href="/guru/siswa/<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary">Jadwal</a>
                    <a href="/guru/tugas/<?= $row['id'] ?>" class="btn btn-sm btn-outline-secondary">Tugas</a>
                </td>
            </tr>
            <?php endforeach ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="text-center">Tidak ada data siswa yang ditemukan.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?= view('layout/footer') ?>