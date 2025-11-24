<?php
include './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';
?>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Layanan /</span> Konsultasi
        </h4>

        <div class="card">
            <h5 class="card-header">Daftar Pertanyaan Masuk</h5>

            <div class="card-body">
                <?php if (!empty($_SESSION['success_message'])): ?>
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <?= $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                <?php if (!empty($_SESSION['error_message'])): ?>
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <?= $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width:50px;">No</th>
                            <th>Tanggal</th>
                            <th>Penanya</th>
                            <th>Pertanyaan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($konsultasi)): ?>
                            <tr><td colspan="6" class="text-center">Belum ada data.</td></tr>
                        <?php else: $no=1; foreach ($konsultasi as $row): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <?= date('d M Y', strtotime($row['tanggal_tanya'])) ?><br>
                                <small class="text-muted"><?= date('H:i', strtotime($row['tanggal_tanya'])) ?></small>
                            </td>
                            <td>
                                <strong><?= htmlspecialchars($row['nama_penanya']) ?></strong><br>
                                <small><?= htmlspecialchars($row['email_penanya']) ?></small>
                            </td>
                            <td title="<?= htmlspecialchars($row['pertanyaan']) ?>">
                                <?= htmlspecialchars(substr($row['pertanyaan'], 0, 40)) ?>...
                            </td>
                            <td>
                                <?php if ($row['status_jawaban'] == 'pending'): ?>
                                    <span class="badge bg-label-warning">Menunggu</span>
                                <?php else: ?>
                                    <span class="badge bg-label-success">Dijawab</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <button type="button" 
                                        class="btn btn-sm btn-primary btn-jawab"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalJawab"
                                        data-id="<?= $row['id_konsultasi'] ?>"
                                        data-penanya="<?= htmlspecialchars($row['nama_penanya']) ?>"
                                        data-pertanyaan="<?= htmlspecialchars($row['pertanyaan']) ?>"
                                        data-jawaban="<?= htmlspecialchars($row['jawaban'] ?? '') ?>">
                                    <i class="bx bx-message-rounded-dots me-1"></i> Jawab
                                </button>

                                <a href="<?= BASE_URL ?>/admin/konsultasi/delete/<?= $row['id_konsultasi'] ?>" 
                                   class="btn btn-sm btn-outline-danger"
                                   onclick="return confirm('Hapus data ini?');">
                                    <i class="bx bx-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalJawab" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Jawab Pertanyaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="<?= BASE_URL ?>/admin/konsultasi/update" method="POST">
                <div class="modal-body">
                    
                    <input type="hidden" name="id_konsultasi" id="modal_id_konsultasi">

                    <div class="mb-3">
                        <label class="form-label">Penanya</label>
                        <input type="text" class="form-control" id="modal_nama_penanya" readonly style="background-color: #e9ecef;">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pertanyaan</label>
                        <textarea class="form-control" id="modal_pertanyaan" rows="3" readonly style="background-color: #e9ecef;"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-primary">Jawaban Anda</label>
                        <textarea class="form-control" name="jawaban" id="modal_jawaban" rows="5" placeholder="Tulis jawaban solusi di sini..." required></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Kirim Jawaban</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include './app/views/templates/admin/footer_admin.php'; ?>

<script>
    // Menunggu dokumen siap
    document.addEventListener('DOMContentLoaded', function() {
        
        // Ambil semua tombol dengan class 'btn-jawab'
        const jawabButtons = document.querySelectorAll('.btn-jawab');

        // Loop setiap tombol untuk menambahkan event click
        jawabButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Ambil data dari atribut data-* tombol yang diklik
                const id = this.getAttribute('data-id');
                const penanya = this.getAttribute('data-penanya');
                const pertanyaan = this.getAttribute('data-pertanyaan');
                const jawaban = this.getAttribute('data-jawaban');

                // Isi nilai ke dalam input form di dalam modal
                document.getElementById('modal_id_konsultasi').value = id;
                document.getElementById('modal_nama_penanya').value = penanya;
                document.getElementById('modal_pertanyaan').value = pertanyaan;
                document.getElementById('modal_jawaban').value = jawaban;
            });
        });
    });
</script>