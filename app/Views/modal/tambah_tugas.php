<!-- Modal Tambah Tugas -->
<div class="modal fade" id="modalTambahTugas" tabindex="-1" aria-labelledby="modalLabelTugas" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="post" action="/ortu/tugas/add" class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalLabelTugas">Tambah Tugas</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama Mapel</label>
                    <input type="text" name="mapel" class="form-control" placeholder="Contoh: Matematika" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Deadline</label>
                    <input type="date" name="deadline" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <input type="text" name="keterangan" class="form-control" placeholder="Contoh: Bab 2" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>