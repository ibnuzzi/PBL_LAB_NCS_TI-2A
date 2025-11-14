<?php
// Use admin templates (header, sidebar, footer) to render this dashboard page
include  './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';
?>

<!-- CONTENT -->
 <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0"><span class="text-muted fw-light">Manajemen Arsip /</span> Tambah Pengabdian</h4>
              </div>

              <form action="#" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                  <label for="judul_kegiatan" class="form-label">Judul Kegiatan</label>
                  <input type="text" class="form-control" id="judul_kegiatan" name="judul_kegiatan" required="">
                </div>

                <div class="mb-3">
                  <label for="tim_pengabdi" class="form-label">Tim Pengabdi</label>
                  <input type="text" class="form-control" id="tim_pengabdi" name="tim_pengabdi" required="">
                </div>

                <div class="mb-3">
                  <label for="tahun_kegiatan" class="form-label">Tahun Kegiatan</label>
                  <input type="number" class="form-control" id="tahun_kegiatan" name="tahun_kegiatan" required="">
                </div>

                <div class="mb-3">
                  <label for="deskripsi_kegiatan" class="form-label">Deskripsi Kegiatan</label>
                  <textarea class="form-control" id="deskripsi_kegiatan" name="deskripsi_kegiatan" rows="3" required=""></textarea>
                </div>

                <div class="mb-3">
                  <label for="file_dokumen_pdf" class="form-label">File Dokumen PDF</label>
                  <input type="file" class="form-control" id="file_dokumen_pdf" name="file_dokumen_pdf" accept=".pdf" required="">
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
              </form>
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
      </div>

      <div class="layout-overlay layout-menu-toggle"></div>
    </div>


            <div class="content-backdrop fade"></div>
          </div>
          <!-- /CONTENT -->
           <?php
// Footer (includes scripts)
include './app/views/templates/admin/footer_admin.php';
?>