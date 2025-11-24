<?php 
include './app/views/templates/admin/header_admin.php'; 
include './app/views/templates/admin/sidebar_admin.php';
?>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="fw-bold mb-0">
                <span class="text-muted fw-light">Manajemen Layanan /</span> Edit Sarana & Prasarana
            </h4>
            <a href="<?= BASE_URL ?>/admin/sarana" class="btn btn-secondary">
                <i class="bx bx-arrow-back"></i> Kembali
            </a>
        </div>

        <!-- Notifikasi -->
        <?php if (!empty($_SESSION['error_message'])): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <?= htmlspecialchars($_SESSION['error_message']); unset($_SESSION['error_message']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card">
            <h5 class="card-header">Form Edit Sarana</h5>

            <div class="card-body">

                <form action="<?= BASE_URL ?>/admin/sarana/update/<?= $sarana['id_sarana'] ?>" 
                      method="POST" enctype="multipart/form-data">

                    <div class="row g-3">

                        <!-- Nama Sarana -->
                        <div class="col-md-6">
                            <label class="form-label">Nama Sarana</label>
                            <input type="text" 
                                   name="nama_sarana" 
                                   class="form-control"
                                   value="<?= htmlspecialchars($sarana['nama_sarana']) ?>"
                                   required>
                        </div>

                        <!-- Jumlah -->
                        <div class="col-md-6">
                            <label class="form-label">Jumlah</label>
                            <input type="number" 
                                   name="jumlah" 
                                   class="form-control"
                                   value="<?= htmlspecialchars($sarana['jumlah']) ?>"
                                   required>
                        </div>

                        <!-- Kondisi -->
                        <div class="col-md-6">
                            <label class="form-label">Kondisi</label>
                            <select name="kondisi" class="form-select" required>
                                <option value="Baik" 
                                    <?= $sarana['kondisi'] === 'Baik' ? 'selected' : '' ?>>
                                    Baik
                                </option>
                                <option value="Perlu Perawatan"
                                    <?= $sarana['kondisi'] === 'Perlu Perawatan' ? 'selected' : '' ?>>
                                    Perlu Perawatan
                                </option>
                                <option value="Rusak"
                                    <?= $sarana['kondisi'] === 'Rusak' ? 'selected' : '' ?>>
                                    Rusak
                                </option>
                            </select>
                            <label class="form-label">Foto Sarana (Opsional)</label>
                            <input type="file" name="foto_sarana" class="form-control">
                        </div>

                        <!-- Foto -->
                        <div class="col-md-6">
                            <?php if (!empty($sarana['foto_sarana'])): ?>
                                <div class="mt-2">
                                    <p class="small text-muted">Foto Saat Ini:</p>
                                    <img src="<?= BASE_URL ?>/public/uploads/sarana/<?= htmlspecialchars($sarana['foto_sarana']) ?>"
                                         style="height:100px; border-radius:6px;">
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Deskripsi -->
                        <div class="col-12">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-control" rows="4" name="deskripsi_sarana"><?= htmlspecialchars($sarana['deskripsi_sarana']) ?></textarea>
                        </div>
                    </div>
                    <div class="mt-4 d-flex gap-2">
                        <button class="btn btn-primary">
                            <i class="bx bx-save"></i> Update
                        </button>
                        <a href="<?= BASE_URL ?>/admin/sarana" class="btn btn-outline-secondary">Batal</a>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

<?php include './app/views/templates/admin/footer_admin.php'; ?>
