<?php
include './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';
?>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="fw-bold mb-0">
                <span class="text-muted fw-light">Manajemen Layanan /</span> Jasa dan Layanan
            </h4>
            <a href="<?= BASE_URL ?>/admin/jasa-layanan/create" class="btn btn-primary">
                <i class="bx bx-plus"></i> Tambah Layanan
            </a>
        </div>

        <div class="card">
            <h5 class="card-header">Daftar Jasa dan Layanan</h5>

            <?php if (!empty($_SESSION['success_message']) || !empty($_SESSION['error_message'])): ?>
                <div class="card-body">
                    <?php if (!empty($_SESSION['success_message'])): ?>
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <?= htmlspecialchars($_SESSION['success_message']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php unset($_SESSION['success_message']); ?>
                    <?php endif; ?>

                    <?php if (!empty($_SESSION['error_message'])): ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <?= htmlspecialchars($_SESSION['error_message']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php unset($_SESSION['error_message']); ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width:60px;">ID</th>
                            <th>Nama Layanan</th>
                            <th>Deskripsi</th>
                            <th>Icon</th>
                            <th style="width:140px;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="table-border-bottom-0">
                        <?php if (empty($layanan) || !is_array($layanan)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <img width="20%"
                                        src="<?= BASE_URL ?>/public/assets/images/empty/empty_data.jpg"
                                        alt="empty"
                                        class="mb-3">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    Belum ada layanan.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($layanan as $l): ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($l['id_layanan']) ?></strong></td>
                                    <td><?= htmlspecialchars($l['nama_layanan']) ?></td>
                                    <td><?= htmlspecialchars($l['deskripsi_layanan']) ?></td>
                                    <td><?= htmlspecialchars($l['icon_layanan']) ?></td>
                                    <td>
                                        <a href="<?= BASE_URL ?>/admin/jasa-layanan/edit/<?= (int)$l['id_layanan'] ?>"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="bx bx-edit"></i>
                                        </a>

                                        <a href="<?= BASE_URL ?>/admin/jasa-layanan/delete/<?= (int)$l['id_layanan'] ?>"
                                            class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Yakin ingin menghapus layanan ini?');">
                                            <i class="bx bx-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <footer class="content-footer footer bg-footer-theme">
        <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
            <div class="mb-2 mb-md-0">
                © <script>
                    document.write(new Date().getFullYear());
                </script>, Lab NCS
            </div>
        </div>
    </footer>

    <div class="content-backdrop fade"></div>
</div>

<?php
include './app/views/templates/admin/footer_admin.php';
?>

<script>
    // Auto-dismiss bootstrap alerts after 3 detik (sama seperti di agenda)
    document.addEventListener('DOMContentLoaded', function() {
        var alerts = document.querySelectorAll('.alert');
        if (alerts.length) {
            setTimeout(function() {
                alerts.forEach(function(el) {
                    try {
                        var bsAlert = bootstrap.Alert.getOrCreateInstance(el);
                        bsAlert.close();
                    } catch (e) {
                        if (el.parentNode) {
                            el.parentNode.removeChild(el);
                        }
                    }
                });
            }, 3000);
        }
    });
</script>