<?php
// Use admin templates (header, sidebar, footer) to render this dashboard page
include  './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';
?>
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="fw-bold mb-0"><span class="text-muted fw-light">Manajemen Konten /</span> Agenda</h4>
            <a href="<?php echo BASE_URL; ?>/admin/agenda/create" class="btn btn-primary">
                <i class="bx bx-plus"></i> Tambah Agenda
            </a>
        </div>

        <div class="card">
            <h5 class="card-header">Daftar Agenda</h5>
            <?php if (!empty($_SESSION['success_message']) || !empty($_SESSION['error_message'])): ?>
                <div class="card-body">
                    <?php if (!empty($_SESSION['success_message'])): ?>
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <?php echo htmlspecialchars($_SESSION['success_message']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php unset($_SESSION['success_message']); ?>
                    <?php endif; ?>

                    <?php if (!empty($_SESSION['error_message'])): ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <?php echo htmlspecialchars($_SESSION['error_message']); ?>
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
                            <th style="width: 60px;">No</th>
                            <th>Nama Agenda</th>
                            <th>Tanggal</th>
                            <th>Lokasi</th>
                            <th>Gambar</th>
                            <th style="width: 140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <!-- contoh data statis, nanti ganti dengan loop dari DB -->
                        <?php if (!empty($agenda_list) && is_array($agenda_list)): ?>
                            <?php $no = 1;
                            foreach ($agenda_list as $a): ?>
                                <tr>
                                    <td><strong><?php echo $no++; ?></strong></td>
                                    <td><?php echo htmlspecialchars($a['nama_agenda'] ?? ''); ?></td>
                                    <td>
                                        <?php
                                        $start = $a['tanggal_mulai'] ?? '';
                                        $end = $a['tanggal_selesai'] ?? '';
                                        $s1 = $start;
                                        $s2 = $end;
                                        if (!empty($start)) {
                                            $d1 = date_create($start);
                                            if ($d1) $s1 = date_format($d1, 'Y-m-d H:i');
                                        }
                                        if (!empty($end)) {
                                            $d2 = date_create($end);
                                            if ($d2) $s2 = date_format($d2, 'Y-m-d H:i');
                                        }
                                        if (!empty($s1) && !empty($s2)) echo htmlspecialchars($s1 . ' s/d ' . $s2);
                                        else echo htmlspecialchars($s1 ?: $s2 ?: '-');
                                        ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($a['lokasi'] ?? '-'); ?></td>
                                    <td>
                                        <?php if (!empty($a['gambar_agenda'])): ?>
                                            <img src="<?php echo BASE_URL; ?>/public/uploads/agenda/<?php echo htmlspecialchars($a['gambar_agenda']); ?>" alt="gambar agenda" style="height:80px; border-radius:4px;" />
                                        <?php else: ?>
                                            <span class="text-muted small">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo BASE_URL; ?>/admin/agenda/edit/<?php echo (int)($a['id_agenda'] ?? 0); ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                        <a href="<?php echo BASE_URL; ?>/admin/agenda/delete/<?php echo (int)($a['id_agenda'] ?? 0); ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus agenda ini?');">
                                            <i class="bx bx-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <img width="20%" src="<?php echo BASE_URL; ?>/public/assets/images/empty/empty_data.jpg" alt="empty" class="mb-3">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada agenda.</td>
                            </tr>
                        <?php endif; ?>
                        <!-- end contoh -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="content-footer footer bg-footer-theme">
        <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
            <div class="mb-2 mb-md-0">
                ©
                <script>
                    document.write(new Date().getFullYear());
                </script>
                , Lab NCS
            </div>
        </div>
    </footer>
    <!-- /FOOTER -->

    <div class="content-backdrop fade"></div>
</div>
<?php
// Footer (includes scripts)
include './app/views/templates/admin/footer_admin.php';
?>
<script>
    // Auto-dismiss bootstrap alerts after 4 seconds
    document.addEventListener('DOMContentLoaded', function() {
        var alerts = document.querySelectorAll('.alert');
        if (alerts.length) {
            setTimeout(function() {
                alerts.forEach(function(el) {
                    try {
                        var bsAlert = bootstrap.Alert.getOrCreateInstance(el);
                        bsAlert.close();
                    } catch (e) {
                        // fallback: remove element
                        el.parentNode && el.parentNode.removeChild(el);
                    }
                });
            }, 3000);
        }
    });
</script>