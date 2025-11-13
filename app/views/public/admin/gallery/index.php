<?php
include './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';
?>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold m-0"><span class="text-muted fw-light">Manajemen Konten /</span> Data Galeri</h4>
            <a href="<?php echo BASE_URL; ?>/admin/gallery/create" class="btn btn-primary"><i class="bx bx-plus"></i> Upload Foto</a>
        </div>

        <div class="card">
            <h5 class="card-header">Daftar Foto</h5>
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
                            <th style="width:60px;">No</th>
                            <th>Judul</th>
                            <th>Gambar</th>
                            <th>Uploaded</th>
                            <th style="width:140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php if (!empty($gallery_list) && is_array($gallery_list)): $no = 1;
                            foreach ($gallery_list as $g): ?>
                                <tr>
                                    <td><strong><?php echo $no++; ?></strong></td>
                                    <td><?php echo htmlspecialchars($g['judul_foto'] ?? ''); ?></td>
                                    <td>
                                        <?php if (!empty($g['nama_file_foto'])): ?>
                                            <img src="<?php echo BASE_URL; ?>/public/uploads/gallery/<?php echo htmlspecialchars($g['nama_file_foto']); ?>" alt="" style="height:80px; border-radius:4px;" />
                                        <?php else: ?>
                                            <span class="text-muted small">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php
                                        $created = $g['created_at'] ?? '';
                                        $createdFormatted = '';
                                        if (!empty($created)) {
                                            $dtc = date_create($created);
                                            if ($dtc) $createdFormatted = date_format($dtc, 'Y-m-d H:i');
                                        }
                                        echo htmlspecialchars($createdFormatted ?: '');
                                        ?>
                                    </td>
                                    <td>
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-outline-info me-1 btn-view-berita"
                                            data-judul="<?php echo htmlspecialchars($g['judul_foto'] ?? ''); ?>"
                                            data-deskripsi="<?php echo htmlspecialchars($g['deskripsi_foto'] ?? ''); ?>"
                                            data-gambar="<?php echo !empty($g['nama_file_foto']) ? BASE_URL . '/public/uploads/gallery/' . htmlspecialchars($g['nama_file_foto']) : ''; ?>"
                                            data-tanggal="<?php echo htmlspecialchars($createdFormatted ?: ''); ?>">
                                            <i class="bx bx-show-alt"></i>
                                        </button>
                                        <a href="<?php echo BASE_URL; ?>/admin/gallery/edit/<?php echo (int)($g['id_foto'] ?? 0); ?>" class="btn btn-sm btn-outline-primary"><i class="bx bx-edit"></i></a>
                                        <a href="<?php echo BASE_URL; ?>/admin/gallery/delete/<?php echo (int)($g['id_foto'] ?? 0); ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus foto ini?');"><i class="bx bx-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach;
                        else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <img width="20%" src="<?php echo BASE_URL; ?>/public/assets/images/empty/empty_data.jpg" alt="empty" class="mb-3">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada foto.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <footer class="content-footer footer bg-footer-theme">
        <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
            <div class="mb-2 mb-md-0">© <script>
                    document.write(new Date().getFullYear());
                </script>, Lab NCS</div>
        </div>
    </footer>
</div>

<div class="modal fade" id="modalDetailBerita" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailJudul">Judul Foto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5 mb-3">
                        <img id="modalDetailGambar" src="" alt="Gambar Foto" class="img-fluid rounded-3 w-100" />
                    </div>
                    <div class="col-md-7">
                        <p class="mb-1 text-muted">
                            <i class="bx bx-calendar"></i>
                            <span id="modalDetailTanggal">-</span>
                        </p>
                        <hr class="my-2" />
                        <p id="modalDetailDeskripsi" class="mb-0">
                            Deskripsi foto akan tampil di sini.
                        </p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<?php include './app/views/templates/admin/footer_admin.php'; ?>
<script>
    $(document).ready(function() {
        $('.btn-view-berita').on('click', function() {
            var judul = $(this).data('judul');
            var deskripsi = $(this).data('deskripsi');
            var gambar = $(this).data('gambar');
            var tanggal = $(this).data('tanggal');

            $('#modalDetailJudul').text(judul);
            $('#modalDetailDeskripsi').text(deskripsi);
            $('#modalDetailGambar').attr('src', gambar);
            $('#modalDetailTanggal').text(tanggal);

            var modal = new bootstrap.Modal(document.getElementById('modalDetailBerita'));
            modal.show();
        });
    });
</script>
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