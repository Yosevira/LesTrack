<?= view('layout/header') ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Edit Profil</h4>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('ortu/profil/update') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" value="<?= esc($user['email']) ?>" disabled>
                            <div class="form-text">Email tidak bisa diubah.</div>
                        </div>
                        <div class="mb-3">
                            <label for="nama_ortu" class="form-label">Nama Orang Tua</label>
                            <input type="text" class="form-control" id="nama_ortu" name="nama_ortu" value="<?= old('nama_ortu', $user['nama_ortu']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama_anak" class="form-label">Nama Anak</label>
                            <input type="text" class="form-control" id="nama_anak" name="nama_anak" value="<?= old('nama_anak', $user['nama_anak']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="kelas" class="form-label">Kelas Anak</label>
                            <input type="text" class="form-control" id="kelas" name="kelas" value="<?= old('kelas', $user['kelas']) ?>">
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3"><?= old('alamat', $user['alamat']) ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="no_telp" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control" id="no_telp" name="no_telp" value="<?= old('no_telp', $user['no_telp']) ?>">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password Baru (kosongkan jika tidak ingin mengubah)</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="mb-3">
                            <label for="retype_password" class="form-label">Ulangi Password Baru</label>
                            <input type="password" class="form-control" id="retype_password" name="retype_password">
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="<?= base_url('ortu/profil') ?>" class="btn btn-primary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= view('layout/footer') ?>