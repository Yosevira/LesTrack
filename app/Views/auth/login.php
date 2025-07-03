<?= view('layout/header_auth') ?>

<div class="auth-card">
    <h4 class="mb-4 text-center">Login LesTrack</h4>

    <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form method="post" action="/auth/login">
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
        <p class="mt-3 text-center">
            Belum punya akun? <a href="/register">Daftar di sini</a>
        </p>
    </form>
</div>

<?= view('layout/footer') ?>