<?= view('layout/header') ?>

<style>
    .tugas-item { border-left: 5px solid; }
    .tugas-merah { border-color: #dc3545; }
    .tugas-kuning { border-color: #ffc107; }
    .tugas-hijau { border-color: #28a745; }
    .status-hadir { color: #28a745; }
    .status-izin { color: #ffc107; }
    .status-alfa { color: #dc3545; }
</style>

<h3>Dashboard Orang Tua</h3>
<p>Pantau perkembangan dan aktivitas anak Anda</p>

<div class="row mt-4">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">🔔 Pemberitahuan Tugas</h5>
            <?php if (count($tugas) > 0): ?>
                <span class="badge bg-danger"><?= count($tugas) ?> Tugas Baru</span>
            <?php endif; ?>
        </div>
        
        <?php if (empty($tugas)): ?>
            <div class="alert alert-success">Tidak ada tugas yang perlu dikerjakan. Hebat! 🎉</div>
        <?php else: ?>
            <?php foreach ($tugas as $item): 
                
                $deadline_time = strtotime($item['deadline']);
                $selisih_hari = ($deadline_time - time()) / (60 * 60 * 24);
                
                $warna = 'hijau'; 
                if ($selisih_hari < 3) $warna = 'merah';
                elseif ($selisih_hari < 7) $warna = 'kuning';
            ?>
            <div class="card tugas-item tugas-<?= $warna ?> shadow-sm mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-1"><?= esc($item['judul'] ?? 'Judul Tugas') ?></h6>
                            <small class="text-muted">Mata Pelajaran: <?= esc($item['mapel']) ?></small><br>
                            <small class="text-danger fw-bold">
                                🗓️ Deadline: <?= date('d F Y', $deadline_time) ?>
                            </small>
                        </div>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" 
                                data-bs-target="#tugasModal" 
                                data-judul="<?= esc($item['judul'] ?? '') ?>" 
                                data-mapel="<?= esc($item['mapel']) ?>" 
                                data-deadline="<?= date('d F Y', $deadline_time) ?>" 
                                data-deskripsi="<?= esc($item['keterangan'] ?? 'Tidak ada deskripsi.') ?>">
                            Lihat Tugas
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm mb-4">
            <div class="card-body text-center">
                <h6 class="card-title">✅ Status Kehadiran Hari Ini</h6>
                <?php if ($kehadiran_hari_ini): ?>
                    <div class="display-4 text-success my-2"><i class="fas fa-check-circle"></i></div>
                    <h4 class="status-hadir text-uppercase fw-bold"><?= esc($kehadiran_hari_ini['status']) ?></h4>
                    <p class="text-muted mb-0">Masuk: 07:30 WIB</p>
                <?php else: ?>
                    <div class="display-4 text-muted my-2"><i class="fas fa-question-circle"></i></div>
                    <h4 class="text-muted">BELUM ADA DATA</h4>
                <?php endif; ?>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="card-title">🗓️ Kehadiran Minggu Ini</h6>
                <ul class="list-group list-group-flush">
                    <?php
                    $hari_indonesia = [1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu', 4 => 'Kamis', 5 => 'Jumat'];
                    $status_class = ['hadir' => 'status-hadir', 'izin' => 'status-izin', 'alfa' => 'status-alfa', 'sakit' => 'text-primary'];

                    foreach ($hari_indonesia as $nomor_hari => $nama_hari) {
                        echo '<li class="list-group-item d-flex justify-content-between align-items-center">';
                        echo $nama_hari;
                        if (isset($kehadiran_minggu_ini[$nomor_hari])) {
                            $status = strtolower($kehadiran_minggu_ini[$nomor_hari]);
                            echo '<span class="fw-bold ' . ($status_class[$status] ?? '') . '">' . ucfirst($status) . '</span>';
                        } else {
                            if ($nomor_hari <= date('N')) echo '<span class="text-muted">-</span>';
                        }
                        echo '</li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="tugasModal" tabindex="-1" aria-labelledby="tugasModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tugasModalLabel">Detail Tugas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h6 id="modalJudul" class="mb-1"></h6>
        <p class="mb-1"><small class="text-muted" id="modalMapel"></small></p>
        <p class="mb-3"><small class="text-danger fw-bold" id="modalDeadline"></small></p>
        <p id="modalDeskripsi"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var tugasModal = document.getElementById('tugasModal');
    tugasModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var judul = button.getAttribute('data-judul');
        var mapel = button.getAttribute('data-mapel');
        var deadline = button.getAttribute('data-deadline');
        var deskripsi = button.getAttribute('data-deskripsi');
        
        tugasModal.querySelector('#modalJudul').textContent = judul;
        tugasModal.querySelector('#modalMapel').textContent = 'Mata Pelajaran: ' + mapel;
        tugasModal.querySelector('#modalDeadline').textContent = 'Deadline: ' + deadline;
        tugasModal.querySelector('#modalDeskripsi').textContent = deskripsi;
    });
});
</script>

<?= view('layout/footer') ?>