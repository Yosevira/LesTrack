<?= view('layout/header') ?>

<h3>Registrasi LesTrack</h3>
<?php if(session()->getFlashdata('errors')): ?>
<div class="alert alert-danger">
    <ul>
        <?php foreach(session('errors') as $error): ?>
        <li><?= $error ?></li>
        <?php endforeach ?>
    </ul>
</div>
<?php endif; ?>

<form method="post" action="/auth/register">
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Nama Orang Tua</label>
        <input type="text" name="nama_ortu" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Nama Anak</label>
        <input type="text" name="nama_anak" class="form-control">
    </div>
    <div class="mb-3">
        <label>Alamat</label>
        <textarea name="alamat" class="form-control"></textarea>
    </div>
    <div class="mb-3">
        <label>No Telepon</label>
        <input type="text" name="no_telp" class="form-control">
    </div>
    <div class="mb-3">
        <label>Role</label>
        <select name="role" class="form-control" required>
            <option value="ortu">Orang Tua</option>
            <option value="guru">Guru</option>
        </select>
    </div>
    <button type="submit" class="btn btn-success">Register</button>
</form>

<?= view('layout/footer') ?>