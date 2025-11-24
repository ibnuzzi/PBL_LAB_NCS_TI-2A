<?php
include './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';
?>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold mb-4">
            <span class="text-muted fw-light">Jasa & Layanan /</span> Edit Layanan
        </h4>

        <div class="card">
            <h5 class="card-header">Form Edit Layanan</h5>

            <div class="card-body">

                <form action="<?= BASE_URL ?>/admin/konsultasi/update/<?= $konsultasi['id_konsultasi'] ?>" method="POST">

                    <div class="mb-3">
                        <label class="form-label">Nama Penanya</label>
                        <input type="text" name="nama_penanya"
                               value="<?= htmlspecialchars($konsultasi['nama_penanya']) ?>"
                               class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email Penanya</label>
                        <input type="email" name="email_penanya"
                               value="<?= htmlspecialchars($konsultasi['email_penanya']) ?>"
                               class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pertanyaan</label>
                        <textarea name="pertanyaan" class="form-control" rows="4" readonly><?= htmlspecialchars($konsultasi['pertanyaan']) ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jawaban</label>
                        <textarea name="jawaban" class="form-control" rows="6" placeholder="Tulis jawaban di sini..." required><?= htmlspecialchars($konsultasi['jawaban']) ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status Jawaban</label>
                        <select name="status_jawaban" class="form-select" required>
                            <option value="pending" <?= $konsultasi['status_jawaban'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="dijawab" <?= $konsultasi['status_jawaban'] === 'dijawab' ? 'selected' : '' ?>>Dijawab</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-save"></i> Simpan Jawaban
                    </button>

                    <a href="<?= BASE_URL ?>/admin/konsultasi" class="btn btn-secondary ms-1">
                        Batal
                    </a>

                </form>

            </div>
        </div>

    </div>

    <?php include './app/views/templates/admin/footer_admin.php'; ?>
</div>
