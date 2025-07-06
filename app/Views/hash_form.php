<?= view('layout/header') ?>

<div class="container mt-5">
    <h3>🔐 Password Hash Generator</h3>

    <?php if (session('error')): ?>
    <div class="alert alert-danger"><?= session('error') ?></div>
    <?php endif ?>

    <form method="post" action="/hash/generate">
        <div class="mb-3">
            <label for="password" class="form-label">Masukkan Password:</label>
            <input type="text" name="password" id="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Generate Hash</button>
    </form>

    <?php if (isset($hash)): ?>
    <div class="mt-4">
        <h5>🔑 Password Asli:</h5>
        <code><?= esc($original) ?></code>

        <h5 class="mt-3">🧬 Hash BCRYPT:</h5>
        <code><?= esc($hash) ?></code>
    </div>
    <?php endif ?>
</div>

<?= view('layout/footer') ?>