<?= view('layout/header') ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Profil Orang Tua</h4>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success" role="alert">
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th scope="row">Email</th>
                                <td><?= esc($user['email']) ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Nama Orang Tua</th>
                                <td><?= esc($user['nama_ortu']) ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Nama Anak</th>
                                <td><?= esc($user['nama_anak']) ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Kelas Anak</th>
                                <td><?= esc($user['kelas'] ?? '-') ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Alamat</th>
                                <td><?= esc($user['alamat']) ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Nomor Telepon</th>
                                <td><?= esc($user['no_telp']) ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="mt-3">
                        <a href="<?= base_url('ortu/dashboard') ?>" class="btn btn-primary">Kembali ke Dashboard</a>
                        <a href="<?= base_url('ortu/profil/edit') ?>" class="btn btn-primary">Edit Profil</a> </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= view('layout/footer') ?>