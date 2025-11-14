<?php
include './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';
?>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- TITLE + BUTTON -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="fw-bold mb-0">
                <span class="text-muted fw-light">Manajemen Layanan /</span> Sarana dan Prasarana
            </h4>
            <a href="<?= BASE_URL ?>/admin/sarana/create" class="btn btn-primary">
                <i class="bx bx-plus"></i> Tambah Sarana
            </a>
        </div>

        <div class="card">
            <h5 class="card-header">Daftar Sarana dan Prasarana</h5>

            <!-- NOTIFIKASI -->
            <?php if (!empty($_SESSION['success_message']) || !empty($_SESSION['error_message'])): ?>
                <div class="card-body pb-0">
                    <?php if (!empty($_SESSION['success_message'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= htmlspecialchars($_SESSION['success_message']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php unset($_SESSION['success_message']); ?>
                    <?php endif; ?>

                    <?php if (!empty($_SESSION['error_message'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= htmlspecialchars($_SESSION['error_message']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php unset($_SESSION['error_message']); ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- TABLE -->
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 60px;">ID</th>
                            <th>Nama Sarana</th>
                            <th>Jumlah</th>
                            <th>Kondisi</th>
                            <th>Foto</th>
                            <th style="width: 140px;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="table-border-bottom-0">
                        <?php if (!empty($list) && is_array($list)): ?>
                            <?php foreach ($list as $item): ?>
                                <tr>
                                    <td><strong><?= $item['id_sarana'] ?></strong></td>

                                    <td><?= htmlspecialchars($item['nama_sarana']) ?></td>

                                    <td><?= htmlspecialchars($item['jumlah']) ?></td>

                                    <td>
                                        <?php 
                                            $k = strtolower($item['kondisi']); 
                                            $badge = "bg-label-secondary";
                                            if ($k == "baik") $badge = "bg-label-success";
                                            elseif ($k == "perlu perawatan") $badge = "bg-label-warning";
                                            elseif ($k == "rusak") $badge = "bg-label-danger";
                                        ?>
                                        <span class="badge <?= $badge ?>">
                                            <?= htmlspecialchars($item['kondisi']) ?>
                                        </span>
                                    </td>

                                    <td>
                                        <?php if (!empty($item['foto_sarana'])): ?>
                                            <img src="<?= BASE_URL ?>/public/uploads/sarana/<?= htmlspecialchars($item['foto_sarana']) ?>"
                                                 style="height:90px; border-radius:6px;" />
                                        <?php else: ?>
                                            <span class="text-muted small">-</span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <a href="<?= BASE_URL ?>/admin/sarana/edit/<?= $item['id_sarana'] ?>"
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bx bx-edit"></i>
                                        </a>

                                        <a href="<?= BASE_URL ?>/admin/sarana/delete/<?= $item['id_sarana'] ?>"
                                           class="btn btn-sm btn-outline-danger"
                                           onclick="return confirm('Hapus data sarana ini?');">
                                            <i class="bx bx-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        <?php else: ?>
                            <!-- EMPTY DATA -->
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <img width="22%" src="<?= BASE_URL ?>/public/assets/images/empty/empty_data.jpg"
                                         alt="empty" class="mb-3">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6" class="text-center text-muted pb-4">
                                    Belum ada data sarana.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>

                </table>
            </div>
        </div>

    </div>

    <?php include './app/views/templates/admin/footer_admin.php'; ?>
</div>

<script>
    // Auto close alert
    document.addEventListener("DOMContentLoaded", () => {
        setTimeout(() => {
            document.querySelectorAll(".alert").forEach(a => {
                a.classList.remove("show");
            });
        }, 3000);
    });
</script>
