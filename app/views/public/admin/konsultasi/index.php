<?php
include './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';

// Set variable for DataTable
$table_name = 'konsultasi';
?>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Layanan /</span> Konsultasi
        </h4>

        <div class="card">
            <div class="table-responsive text-nowrap p-3">
                <table class="table table-striped align-middle" id="table-konsultasi">
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
                                <?php 
                                $status = strtolower($row['status_jawaban']);
                                if ($status == 'menunggu' || $status == 'pending'): 
                                ?>
                                    <span class="badge bg-label-warning">Menunggu</span>
                                <?php elseif ($status == 'diterima' || $status == 'dijawab'): ?>
                                    <span class="badge bg-label-success">Diterima</span>
                                <?php elseif ($status == 'ditolak'): ?>
                                    <span class="badge bg-label-danger">Ditolak</span>
                                <?php else: ?>
                                    <span class="badge bg-label-secondary"><?= htmlspecialchars($row['status_jawaban']) ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php 
                                $status = strtolower($row['status_jawaban']);
                                if ($status == 'menunggu' || $status == 'pending'): 
                                ?>
                                    <!-- Show Approve and Reject buttons for pending consultations -->
                                    <button type="button" 
                                            class="btn btn-sm btn-success btn-approve"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalApprove"
                                            data-id="<?= $row['id_konsultasi'] ?>"
                                            data-penanya="<?= htmlspecialchars($row['nama_penanya']) ?>"
                                            data-pertanyaan="<?= htmlspecialchars($row['pertanyaan']) ?>"
                                            data-jawaban="">
                                        <i class="bx bx-check me-1"></i> Terima
                                    </button>

                                    <button type="button" 
                                            class="btn btn-sm btn-danger btn-reject"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalReject"
                                            data-id="<?= $row['id_konsultasi'] ?>"
                                            data-penanya="<?= htmlspecialchars($row['nama_penanya']) ?>"
                                            data-pertanyaan="<?= htmlspecialchars($row['pertanyaan']) ?>">
                                        <i class="bx bx-x me-1"></i> Tolak
                                    </button>
                                <?php elseif ($status == 'diterima' || $status == 'dijawab'): ?>
                                    <!-- View answer button -->
                                    <button type="button" 
                                            class="btn btn-sm btn-info btn-view-answer"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalViewAnswer"
                                            data-penanya="<?= htmlspecialchars($row['nama_penanya']) ?>"
                                            data-pertanyaan="<?= htmlspecialchars($row['pertanyaan']) ?>"
                                            data-jawaban="<?= htmlspecialchars($row['jawaban'] ?? '') ?>">
                                        <i class="bx bx-show me-1"></i> Lihat Jawaban
                                    </button>
                                <?php elseif ($status == 'ditolak'): ?>
                                    <!-- View rejection reason button -->
                                    <button type="button" 
                                            class="btn btn-sm btn-secondary btn-view-reason"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalViewReason"
                                            data-penanya="<?= htmlspecialchars($row['nama_penanya']) ?>"
                                            data-pertanyaan="<?= htmlspecialchars($row['pertanyaan']) ?>"
                                            data-alasan="<?= htmlspecialchars($row['alasan_tolak'] ?? '') ?>">
                                        <i class="bx bx-show me-1"></i> Lihat Alasan
                                    </button>
                                <?php endif; ?>

                                <a href="<?= BASE_URL ?>/admin/konsultasi/delete/<?= $row['id_konsultasi'] ?>" 
                                   class="btn btn-sm btn-outline-danger btn-delete">
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

<!-- Modal: Approve Consultation -->
<div class="modal fade" id="modalApprove" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Terima dan Jawab Pertanyaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="<?= BASE_URL ?>/admin/konsultasi/approve" method="POST">
                <div class="modal-body">
                    
                    <input type="hidden" name="id_konsultasi" id="approve_id_konsultasi">

                    <div class="mb-3">
                        <label class="form-label">Penanya</label>
                        <input type="text" class="form-control" id="approve_nama_penanya" readonly style="background-color: #e9ecef;">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pertanyaan</label>
                        <textarea class="form-control" id="approve_pertanyaan" rows="3" readonly style="background-color: #e9ecef;"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-success">Jawaban Anda</label>
                        <textarea class="form-control" name="jawaban" id="approve_jawaban" rows="5" placeholder="Tulis jawaban solusi di sini..." required></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Terima & Kirim Jawaban</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Reject Consultation -->
<div class="modal fade" id="modalReject" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tolak Pertanyaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="<?= BASE_URL ?>/admin/konsultasi/reject" method="POST">
                <div class="modal-body">
                    
                    <input type="hidden" name="id_konsultasi" id="reject_id_konsultasi">

                    <div class="mb-3">
                        <label class="form-label">Penanya</label>
                        <input type="text" class="form-control" id="reject_nama_penanya" readonly style="background-color: #e9ecef;">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pertanyaan</label>
                        <textarea class="form-control" id="reject_pertanyaan" rows="3" readonly style="background-color: #e9ecef;"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-danger">Alasan Penolakan</label>
                        <textarea class="form-control" name="alasan_tolak" id="reject_alasan" rows="5" placeholder="Tulis alasan mengapa konsultasi ditolak..." required></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak & Kirim Notifikasi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: View Answer (Read Only) -->
<div class="modal fade" id="modalViewAnswer" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Lihat Jawaban</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Penanya</label>
                    <input type="text" class="form-control" id="view_nama_penanya" readonly style="background-color: #e9ecef;">
                </div>

                <div class="mb-3">
                    <label class="form-label">Pertanyaan</label>
                    <textarea class="form-control" id="view_pertanyaan" rows="3" readonly style="background-color: #e9ecef;"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold text-success">Jawaban</label>
                    <textarea class="form-control" id="view_jawaban" rows="5" readonly style="background-color: #e9ecef;"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: View Rejection Reason (Read Only) -->
<div class="modal fade" id="modalViewReason" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Lihat Alasan Penolakan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Penanya</label>
                    <input type="text" class="form-control" id="reason_nama_penanya" readonly style="background-color: #e9ecef;">
                </div>

                <div class="mb-3">
                    <label class="form-label">Pertanyaan</label>
                    <textarea class="form-control" id="reason_pertanyaan" rows="3" readonly style="background-color: #e9ecef;"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold text-danger">Alasan Penolakan</label>
                    <textarea class="form-control" id="reason_alasan" rows="5" readonly style="background-color: #e9ecef;"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<?php 
include './app/views/components/toaster.php';
include './app/views/templates/admin/footer_admin.php'; 
include './app/views/components/page_scripts.php';
?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // Approve button click handler
        const approveButtons = document.querySelectorAll('.btn-approve');
        approveButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const penanya = this.getAttribute('data-penanya');
                const pertanyaan = this.getAttribute('data-pertanyaan');

                document.getElementById('approve_id_konsultasi').value = id;
                document.getElementById('approve_nama_penanya').value = penanya;
                document.getElementById('approve_pertanyaan').value = pertanyaan;
                document.getElementById('approve_jawaban').value = '';
            });
        });

        // Reject button click handler
        const rejectButtons = document.querySelectorAll('.btn-reject');
        rejectButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const penanya = this.getAttribute('data-penanya');
                const pertanyaan = this.getAttribute('data-pertanyaan');

                document.getElementById('reject_id_konsultasi').value = id;
                document.getElementById('reject_nama_penanya').value = penanya;
                document.getElementById('reject_pertanyaan').value = pertanyaan;
                document.getElementById('reject_alasan').value = '';
            });
        });

        // View answer button click handler
        const viewAnswerButtons = document.querySelectorAll('.btn-view-answer');
        viewAnswerButtons.forEach(button => {
            button.addEventListener('click', function() {
                const penanya = this.getAttribute('data-penanya');
                const pertanyaan = this.getAttribute('data-pertanyaan');
                const jawaban = this.getAttribute('data-jawaban');

                document.getElementById('view_nama_penanya').value = penanya;
                document.getElementById('view_pertanyaan').value = pertanyaan;
                document.getElementById('view_jawaban').value = jawaban;
            });
        });

        // View reason button click handler
        const viewReasonButtons = document.querySelectorAll('.btn-view-reason');
        viewReasonButtons.forEach(button => {
            button.addEventListener('click', function() {
                const penanya = this.getAttribute('data-penanya');
                const pertanyaan = this.getAttribute('data-pertanyaan');
                const alasan = this.getAttribute('data-alasan');

                document.getElementById('reason_nama_penanya').value = penanya;
                document.getElementById('reason_pertanyaan').value = pertanyaan;
                document.getElementById('reason_alasan').value = alasan;
            });
        });
    });
</script>