<?= view('layout/header') ?>

<style>
.absensi-cell {
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.2s;
}

.absensi-cell:hover {
    background-color: #f0f0f0;
}

.status-hadir {
    color: #198754;
    /* success */
}

.status-sakit {
    color: #ffc107;
    /* warning */
}

.status-alpa {
    color: #dc3545;
    /* danger */
}

.status-izin {
    color: #0d6efd;
    /* primary */
}

.status-kosong {
    color: #adb5bd;
    /* secondary */
}
</style>

<div class="container-fluid">
    <h3 class="mb-3">Daftar Hadir Les</h3>
    <div class="card p-3 mb-4 text-center shadow-sm">
        <h4 class="mb-3">Ringkasan Hari Ini</h4>
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card text-white p-3" style="background-color: #e6f7d5;">
                    <h3 class="text-success"><?= esc($hadir_hari_ini) ?></h3>
                    <p class="text-success mb-0">Hadir</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card text-dark p-3" style="background-color: #fff9c4;">
                    <h3 class="text-warning"><?= esc($sakit_hari_ini) ?></h3>
                    <p class="text-warning mb-0">Sakit</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card text-white p-3" style="background-color: #ffcdd2;">
                    <h3 class="text-danger"><?= esc($alpa_hari_ini) ?></h3>
                    <p class="text-danger mb-0">Alpa</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card text-white bg-primary p-3">
                    <h3><?= esc($total_murid) ?></h3>
                    <p class="mb-0">Total Murid</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card p-3 shadow-sm">

        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
            <?php
                // Logika untuk bulan sebelumnya
                $prev_month = $month - 1;
                $prev_year = $year;
                if ($prev_month == 0) {
                    $prev_month = 12;
                    $prev_year = $year - 1;
                }

                // Logika untuk bulan selanjutnya
                $next_month = $month + 1;
                $next_year = $year;
                if ($next_month == 13) {
                    $next_month = 1;
                    $next_year = $year + 1;
                }
            ?>
            <a href="<?= site_url('guru/absensi/' . $prev_year . '/' . $prev_month) ?>"
                class="btn btn-outline-primary">&leftarrow; Bulan Sebelumnya</a>
            <div class="mx-auto">
                <h4 class="mb-0"><?= esc($nama_bulan) ?> <?= esc($year) ?></h4>
            </div>
            <a href="<?= site_url('guru/absensi/' . $next_year . '/' . $next_month) ?>"
                class="btn btn-outline-primary">Bulan Selanjutnya &rightarrow;</a>
            <span class="badge bg-light text-dark ms-md-3 fs-6">Total Pertemuan: <?= esc($total_pertemuan) ?></span>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th class="text-start" style="width: 200px; vertical-align: middle;">NAMA MURID</th>
                        <?php for ($i = 1; $i <= $days_in_month; $i++): ?>
                        <th><?= $i ?></th>
                        <?php endfor; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($siswa)): ?>
                    <tr>
                        <td colspan="<?= $days_in_month + 1 ?>" class="text-center">Belum ada data siswa.</td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($siswa as $s): ?>
                    <tr>
                        <td class="text-start"><?= esc($s['nama_anak']) ?></td>
                        <?php for ($i = 1; $i <= $days_in_month; $i++): ?>
                        <?php
                                    // Tentukan status, tampilan, dan class untuk setiap sel
                                    $status = $absensi[$s['id']][$i] ?? 'kosong';
                                    $tanggal_lengkap = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);
                                    $display_char = '•';
                                    $css_class = 'status-kosong';
                                    
                                    switch ($status) {
                                        case 'hadir':
                                            $display_char = '✓';
                                            $css_class = 'status-hadir';
                                            break;
                                        case 'sakit':
                                            $display_char = 'S';
                                            $css_class = 'status-sakit';
                                            break;
                                        case 'izin':
                                            $display_char = 'I';
                                            $css_class = 'status-izin';
                                            break;
                                        case 'alfa':
                                            $display_char = 'A';
                                            $css_class = 'status-alpa';
                                            break;
                                    }
                                ?>
                        <td class="absensi-cell <?= $css_class ?>" data-bs-toggle="modal" data-bs-target="#absensiModal"
                            data-userid="<?= $s['id'] ?>" data-nama="<?= esc($s['nama_anak']) ?>"
                            data-tanggal="<?= $tanggal_lengkap ?>"
                            data-tanggal-display="<?= $i . ' ' . $nama_bulan . ' ' . $year ?>">
                            <?= $display_char ?>
                        </td>
                        <?php endfor; ?>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="absensiModal" tabindex="-1" aria-labelledby="absensiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="absensiModalLabel">Input Absensi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-1"><strong>Tanggal:</strong> <span id="modalTanggalDisplay"></span></p>
                <p class="mb-3"><strong>Murid:</strong> <span id="modalNamaMurid"></span></p>

                <form id="formAbsensi" action="<?= site_url('guru/simpanAbsensiPopup') ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="user_id" id="modalUserId">
                    <input type="hidden" name="tanggal" id="modalTanggalValue">

                    <div class="d-grid gap-2">
                        <button type="submit" name="status" value="hadir" class="btn btn-success">✓ Hadir</button>
                        <button type="submit" name="status" value="sakit" class="btn btn-warning">Sakit</button>
                        <button type="submit" name="status" value="alfa" class="btn btn-danger">X Alpa</button>
                        <button type="submit" name="status" value="kosong" class="btn btn-secondary">Kosongkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?= view('layout/footer') ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const absensiModal = document.getElementById('absensiModal');
    if (absensiModal) {
        absensiModal.addEventListener('show.bs.modal', function(event) {
            // Tombol/sel yang memicu modal
            const cell = event.relatedTarget;

            // Ekstrak informasi dari atribut data-*
            const userId = cell.getAttribute('data-userid');
            const namaMurid = cell.getAttribute('data-nama');
            const tanggalValue = cell.getAttribute('data-tanggal');
            const tanggalDisplay = cell.getAttribute('data-tanggal-display');

            // Perbarui konten modal
            const modalNamaMuridEl = absensiModal.querySelector('#modalNamaMurid');
            const modalTanggalDisplayEl = absensiModal.querySelector('#modalTanggalDisplay');
            const modalUserIdInput = absensiModal.querySelector('#modalUserId');
            const modalTanggalValueInput = absensiModal.querySelector('#modalTanggalValue');

            modalNamaMuridEl.textContent = namaMurid;
            modalTanggalDisplayEl.textContent = tanggalDisplay;
            modalUserIdInput.value = userId;
            modalTanggalValueInput.value = tanggalValue;
        });
    }
});
</script>