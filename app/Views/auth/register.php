<?= view('layout/header_auth') ?>

<div class="container mt-4">
    <h4 class="mb-4 text-center">Registrasi LesTrack</h4>
    <form method="post" action="/auth/register" novalidate>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Email</label>
                <input type="email" name="email"
                    class="form-control <?= (session('errors.email')) ? 'is-invalid' : '' ?>"
                    value="<?= old('email') ?>" required>
                <?php if(session('errors.email')): ?>
                <div class="invalid-feedback">
                    <?= session('errors.email') ?>
                </div>
                <?php endif; ?>
            </div>
            <div class="col-md-6 mb-3">
                <label>Password</label>
                <input type="password" name="password"
                    class="form-control <?= (session('errors.password')) ? 'is-invalid' : '' ?>"
                    value="<?= old('password') ?>" required>
                <?php if(session('errors.password')): ?>
                <div class="invalid-feedback">
                    <?= session('errors.password') ?>
                </div>
                <?php endif; ?>
            </div>
            <div class="col-md-6 mb-3">
                <label>Nama Orang Tua</label>
                <input type="text" name="nama_ortu"
                    class="form-control <?= (session('errors.nama_ortu')) ? 'is-invalid' : '' ?>"
                    value="<?= old('nama_ortu') ?>" required>
                <?php if(session('errors.nama_ortu')): ?>
                <div class="invalid-feedback">
                    <?= session('errors.nama_ortu') ?>
                </div>
                <?php endif; ?>
            </div>
            <div class="col-md-6 mb-3">
                <label>Nama Anak</label>
                <input type="text" name="nama_anak"
                    class="form-control <?= (session('errors.nama_anak')) ? 'is-invalid' : '' ?>"
                    value="<?= old('nama_anak') ?>" required>
                <?php if(session('errors.nama_anak')): ?>
                <div class="invalid-feedback">
                    <?= session('errors.nama_anak') ?>
                </div>
                <?php endif; ?>
            </div>
            <div class="col-md-6 mb-3">
                <label>No Telepon</label>
                <input type="text" name="no_telp"
                    class="form-control <?= (session('errors.no_telp')) ? 'is-invalid' : '' ?>"
                    value="<?= old('no_telp') ?>" required>
                <?php if(session('errors.no_telp')): ?>
                <div class="invalid-feedback">
                    <?= session('errors.no_telp') ?>
                </div>
                <?php endif; ?>
            </div>
            <div class="col-md-6 mb-3">
                <label>Kelas</label>
                <input type="text" name="kelas"
                    class="form-control <?= (session('errors.kelas')) ? 'is-invalid' : '' ?>"
                    value="<?= old('kelas') ?>" required>
                <?php if(session('errors.kelas')): ?>
                <div class="invalid-feedback">
                    <?= session('errors.kelas') ?>
                </div>
                <?php endif; ?>
            </div>
            <div class="col-12 mb-3"> <label>Alamat</label>
                <textarea name="alamat" class="form-control <?= session('errors.alamat') ? 'is-invalid' : '' ?>"
                    rows="2" required><?= old('alamat') ?></textarea>
                <?php if(session('errors.alamat')): ?>
                <div class="invalid-feedback">
                    <?= session('errors.alamat') ?>
                </div>
                <?php endif ?>
            </div>

        </div>

        <button type="submit" class="btn btn-primary w-10">Register</button>
        <p class="mt-3">
            Sudah punya akun? <a href="/login">Login di sini</a>
        </p>
    </form>
</div>

<?= view('layout/footer') ?>