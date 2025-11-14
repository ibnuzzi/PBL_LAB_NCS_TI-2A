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

                <form action="<?= BASE_URL ?>/admin/jasa-layanan/update/<?= $layanan['id_layanan'] ?>" method="POST">

                    <div class="mb-3">
                        <label class="form-label">Nama Layanan</label>
                        <input type="text" name="nama_layanan"
                               value="<?= htmlspecialchars($layanan['nama_layanan']) ?>"
                               class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi Layanan</label>
                        <textarea name="deskripsi_layanan" class="form-control" rows="4"><?= htmlspecialchars($layanan['deskripsi_layanan']) ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Icon</label>
                        <input type="text" name="icon_layanan"
                               value="<?= htmlspecialchars($layanan['icon_layanan']) ?>"
                               class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-save"></i> Update
                    </button>

                    <a href="<?= BASE_URL ?>/admin/jasa-layanan" class="btn btn-secondary ms-1">
                        Batal
                    </a>

                </form>

            </div>
        </div>

    </div>

    <?php include './app/views/templates/admin/footer_admin.php'; ?>
</div>
