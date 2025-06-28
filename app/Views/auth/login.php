<?= view('layout/header') ?>

<h3>Login LesTrack</h3>
<?php if(session()->getFlashdata('error')): ?>
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
    <button type="submit" class="btn btn-primary">Login</button>
    <p class="mt-3">
        Belum punya akun? <a href="/register">Daftar di sini</a>
    </p>

</form>

<?= view('layout/footer') ?>