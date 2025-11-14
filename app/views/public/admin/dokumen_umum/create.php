<?php
// Use admin templates (header, sidebar, footer) to render this dashboard page
include  './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';
?>

<!-- CONTENT -->
<div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold mb-4">Tambah Dokumen</h4>
              <div class="card">
                <h5 class="card-header">Form Tambah Dokumen</h5>
                <div class="card-body">
                  <form action="dokumen-simpan.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                      <label for="nama_dokumen" class="form-label">Nama Dokumen</label>
                      <input type="text" class="form-control" id="nama_dokumen" name="nama_dokumen" required="">
                    </div>
                    <div class="mb-3">
                      <label for="deskripsi_dokumen" class="form-label">Deskripsi Dokumen</label>
                      <textarea class="form-control" id="deskripsi_dokumen" name="deskripsi_dokumen" required=""></textarea>
                    </div>
                    <div class="mb-3">
                      <label for="file_dokumen" class="form-label">File Dokumen</label>
                      <input type="file" class="form-control" id="file_dokumen" name="file_dokumen" required="">
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                  </form>
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
                  , dibuat dengan ❤️ oleh
                  <a href="#" class="footer-link fw-bolder">Lab NCS</a>
                </div>
              </div>
            </footer>
            <!-- /FOOTER -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- /CONTENT -->
           <?php
// Footer (includes scripts)
include './app/views/templates/admin/footer_admin.php';
?>